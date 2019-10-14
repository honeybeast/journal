<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use App\Article;
use App\Author;
use App\Category;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleNotificationMailable;
use DB;
use App\User;
use View;
use App\Helper;
use App\SiteManagement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\EmailTemplate;
use Storage;
use PDF;

class AuthorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * @access public
     * @param int $id
     * @param string $status
     * @desc Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id, $status)
    {
        $article_status = Helper::getMenuStatus($status);
        $user_id = Auth::user()->id;
        $author_notification = Article::getAuthorNotification($user_id);
        if (!empty($id) && !empty($article_status)) {
            if ($user_id != $id || !(is_numeric($id)) || !(in_array($article_status, Helper::statusStaticList()))) {
                return View::make('errors.401');
            }
            $page_title = Helper::DashboardArticlePageTitle($status);
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $articles = Article::getAuthorArticlesBySearchKey($article_status, $user_id, $keyword)->setPath('');
                $pagination = $articles->appends(
                    array(
                        'keyword' => Input::get('keyword')
                    )
                );
            } else {
                $articles = Article::getAuthorArticlesByStatus($article_status, $user_id);
            }
            return View::make('author.index', compact('author_notification', 'articles', 'user_id', 'page_title'))
                ->with('status', $article_status);
        }
    }

    /**
     * @access public
     * @desc Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @version 1.0
     */
    public function create()
    {
        if (Auth::user()) {
            $user_role_type = User::getUserRoleType(Auth::user()->id);
            $role = $user_role_type->role_type;
            if ($role == 'author') {
                $categories_count = Category::all();
                if ($categories_count->count() > 0) {
                    $categories = Category::getCategoriesList();
                } else {
                    $categories = "";
                }
                $payment_mode = SiteManagement::getMetaValue('payment_mode');
                $product_mode = !empty($payment_mode) ? $payment_mode : '';
                return view('article/create')->with('categories', $categories)->with('product_mode', $product_mode);
            } else {
                Auth::logout();
                return Redirect::to('/login');
            }
        }
    }

    /**
     * @access public
     * @desc Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $email_params = array();
            $user_id = Auth::user()->id;
            $categories = Category::all();
            if ($categories->count() > 0) {
                $this->validate($request, [
                    'category' => 'required',
                ]);
            }
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'abstract' => 'required',
                'excerpt' => 'required',
                'uploaded_new_article' => 'required|mimes:doc,docx|max:2000',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withInput($request->input())->with([
                    'errors' => $validator->errors()
                ]);
            }
            if ($request['file_deleted'] == "deleted") {
                Session::flash('upload_error', 'Manuscript Field is required');
                return Redirect::back()->withInput(Input::all());
            }
            // save author data
            $authors = $request['authors'];
            $author_id = array();
            if (!empty($authors)) {
                foreach ($authors as $key => $author) {
                    Author::saveAuthor($author['title'], $author['email']);
                    $author_id[] = DB::getPdo()->lastInsertId();
                }
            }
            // save article data
            Article::saveArticle($request);
            $article_id = DB::getPdo()->lastInsertId();

            // extract data for pdf
            $article_info = DB::table('articles')->where('id', $article_id)->get();
            $author_bio = DB::table('author_bio')->where('user_id', $article_info[0]->corresponding_author_id)->get();
            $author_info = DB::table('users')->where('id', $article_info[0]->corresponding_author_id)->get();
            $db_keywords = DB::table('sitemanagements')->where('meta_key', 'keywords')->get();
            $default_keywords = $db_keywords[0]->meta_value;

            $keywords = $_REQUEST['keywords'][0];
            $keywords_data = array(
                'keywords' => $keywords
            );

            DB::table('articles')->where('id',$article_id)->update($keywords_data);

            $keywords_list = explode(",", $keywords);
            $default_keywords_list = explode(",", $default_keywords);
            $result = array_diff($keywords_list,$default_keywords_list);
            $final_keywords = array_merge($default_keywords_list, $result);
            $final_keywords_data = array(
                'keywords' => $final_keywords
            );

            $virtual_keywords = implode(",",$final_keywords_data['keywords']);
            $ffinal_keywords_data = array(

                'meta_value' => $virtual_keywords
            );

            DB::table('sitemanagements')->where('meta_key','keywords')->update($ffinal_keywords_data);

            $data['article'] = $article_info;
            $data['author_bio'] = $author_bio;
            $data['author_info'] = $author_info;

            // save data in pivot data
            if (!empty($article_id)) {
                foreach ($author_id as $auth_id) {
                    DB::table('author_article')->insert(
                        ['author_id' => $auth_id, 'article_id' => $article_id, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()]
                    );
                    $author_data = Author::getAuthorByID(filter_var($auth_id, FILTER_SANITIZE_NUMBER_INT));
                    if (!empty($author_data)) {
                        $email_params['author_name'] = $author_data[0]->name;
                    }
                }
            }
            if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                // prepare email data
                $submitted_article = Article::getArticleNotificationData($article_id);
                if (!empty($submitted_article)) {
                    $email_params['article_title'] = $submitted_article->title;
                    $email_params['article_id'] = $submitted_article->id;
                    $corresponding_author_id = $submitted_article->corresponding_author_id;
                    if (!empty($corresponding_author_id)) {
                        $corresponding_author = User::getUserDataByID($corresponding_author_id);
                        if (!empty($corresponding_author)) {
                            $email_params['corresponding_author_name'] = $corresponding_author->name;
                            $email_params['author_email'] = $corresponding_author->email;
                        }
                        $author_role_id = User::getRoleIDByUserID($corresponding_author_id);
                        if (!empty($author_role_id)) {
                            $author_template_data = EmailTemplate::getEmailTemplatesByID($author_role_id, 'new_article');
                        }
                    }
                }
                //send email
                $role_type = array("superadmin", "editor", "corresponding_author", "author");
                $user_email = "";
                foreach ($role_type as $key => $role) {
                    if ($role == "superadmin") {
                        $superadmin = User::getUserByRoleType('superadmin');
                        if (!empty($superadmin)) {
                            $email_params['superadmin_name'] = $superadmin[0]->name;
                            $email_params['superadmin_email'] = $superadmin[0]->email;
                            $article_link = url('/login?user_id=' . $superadmin[0]->id . '&email_type=new_article');
                            $email_params['article_link'] = $article_link;
                            $template_data = EmailTemplate::getEmailTemplatesByID($superadmin[0]->role_id, 'new_article');
                            if (!empty($template_data)) {
                                Mail::to($superadmin[0]->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
                            }
                        }
                    } else if ($role == "editor") {
                        $editors = User::getUserByRoleType('editor');
                        if (!empty($editors)) {
                            foreach ($editors as $editor) {
                                $email_params['editor_name'] = $editor->name;
                                $email_params['editor_email'] = $editor->email;
                                $article_link = url('/login?user_id=' . $editor->id . '&email_type=new_article');
                                $email_params['article_link'] = $article_link;
                                $template_data = EmailTemplate::getEmailTemplatesByID($editor->role_id, 'new_article');
                                if (!empty($template_data)) {
                                    Mail::to($editor->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
                                }
                            }
                        }
                    } elseif ($role == "author") {
                        foreach ($author_id as $auth_id) {
                            if (!empty($author_template_data)) {
                                Mail::to($author_data[0]->email)->send(new ArticleNotificationMailable($email_params, $author_template_data, $role));
                            }
                        }
                    } elseif ($role == "corresponding_author") {
                        if (!empty($author_template_data)) {
                            $article_link = url('/login?user_id=' . $corresponding_author_id . '&email_type=new_article');
                            $email_params['article_link'] = $article_link;
                            Mail::to($corresponding_author->email)->send(new ArticleNotificationMailable($email_params, $author_template_data, $role));
                        }
                    }
                }
            }
            Session::flash('message', trans('prs.article_submitted'));
            return Redirect::to('/author/user/' . $user_id . '/articles-under-review');
        }
    }


    /**
     * @access public
     * @desc Resubmit article for review
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resubmitArticle(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate($request, [
                'resubmit_article' => 'required|mimes:doc,docx',
            ]);
            $article_id = $request['article_id'];
            $user_id = Auth::user()->id;
            // file process
            $uploaded_file = $request->file('resubmit_article');
            if (!empty($uploaded_file)) {
                $corresponding_author_id = Auth::id();
                $file_original_name = $uploaded_file->getClientOriginalName();
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_path = 'uploads/articles/users/' . $corresponding_author_id . '/';
                $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
                $full_doc_name = $corresponding_author_id . '-' . $file_name_without_extension . '-' . time() . '.' . $extension;
                Storage::disk('local')->putFileAs(
                    $file_path,
                    $uploaded_file,
                    $full_doc_name
                );
                // article update
                $article = Article::find($article_id);
                $article->submitted_document = filter_var($full_doc_name, FILTER_SANITIZE_STRING);
                $article->status = "articles_under_review";
                $article->save();
                // delete article reviewers
                $reviewers = Article::getReviewerIdByArticle($article_id);
                if (!empty($reviewers)) {
                    foreach ($reviewers as $reviewer_id) {
                        DB::table('reviewers')->where('reviewer_id', $reviewer_id)->where('article_id', $article_id)->delete();
                    }
                }
                // prepare email data
                $submitted_article = Article::getArticleNotificationData($article_id);
                if (!empty($submitted_article)) {
                    $email_params['article_title'] = $submitted_article->title;
                    $email_params['article_id'] = $submitted_article->id;
                }
                $corresponding_author = User::getUserDataByID($corresponding_author_id);
                if (!empty($corresponding_author)) {
                    $email_params['corresponding_author_name'] = $corresponding_author->name;
                    $email_params['author_email'] = $corresponding_author->email;
                    $author_role_id = User::getRoleIDByUserID($corresponding_author_id);
                    if (!empty($author_role_id)) {
                        $author_template_data = EmailTemplate::getEmailTemplatesByID($author_role_id, 'resubmit_article');
                    }
                }
                //send email
                if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                    $role_type = array("superadmin", "editor", "corresponding_author", "author");
                    $user_email = "";
                    foreach ($role_type as $key => $role) {
                        if ($role == "superadmin") {
                            $superadmin = User::getUserByRoleType('superadmin');
                            if (!empty($superadmin)) {
                                $email_params['superadmin_name'] = $superadmin[0]->name;
                                $email_params['superadmin_email'] = $superadmin[0]->email;
                                $article_link = url('/login?user_id=' . $superadmin[0]->id . '&email_type=resubmit_article&status=articles-under-review');
                                $email_params['article_link'] = $article_link;
                                $template_data = EmailTemplate::getEmailTemplatesByID($superadmin[0]->role_id, 'resubmit_article');
                                if (!empty($template_data)) {
                                    Mail::to($superadmin[0]->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
                                }
                            }
                        } elseif ($role == "editor") {
                            $editors = User::getUserByRoleType('editor');
                            foreach ($editors as $editor) {
                                if (!empty($editors)) {
                                    $email_params['editor_name'] = $editor->name;
                                    $email_params['editor_email'] = $editor->email;
                                    $article_link = url('/login?user_id=' . $editor->id . '&email_type=resubmit_article&status=articles-under-review');
                                    $email_params['article_link'] = $article_link;
                                    $template_data = EmailTemplate::getEmailTemplatesByID($editor->role_id, 'resubmit_article');
                                    if (!empty($template_data)) {
                                        Mail::to($editor->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
                                    }
                                }
                            }
                        } elseif ($role == "author") {
                            $authors = Author::getAuthorByArticle($article_id);
                            foreach ($authors as $author) {
                                $email_params['author_name'] = $author->name;
                                if (!empty($author_template_data)) {
                                    Mail::to($author->email)->send(new ArticleNotificationMailable($email_params, $author_template_data, $role));
                                }
                            }
                        } elseif ($role == "corresponding_author") {
                            if (!empty($author_template_data)) {
                                $article_link = url('/login?user_id=' . $corresponding_author_id . '&email_type=resubmit_article&status=articles_under_review');
                                $email_params['article_link'] = $article_link;
                                Mail::to($corresponding_author->email)->send(new ArticleNotificationMailable($email_params, $author_template_data, $role));
                            }
                        }
                    }
                }
                Session::flash('message', trans('prs.article_submitted'));
                return Redirect::to('/author/user/' . $user_id . '/articles_under_review');
            }
        }
    }

    /**
     * @access public
     * @desc Send comment notification to author.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authorNotified(Request $request)
    {
        $request_id = $request['ID'];
        if (!empty($request_id)) {
            $parts = explode("-", $request_id);
            $article_id = $parts[1];
            return DB::table('articles')
                ->where('id', $article_id)
                ->update(['author_notify' => 0]);
        }
    }

    public function pdfCreate($id){

            $article_id = $id;

            // extract data for pdf
            $article_info = DB::table('articles')->where('id', $article_id)->get();
            $author_bio = DB::table('author_bio')->where('user_id', $article_info[0]->corresponding_author_id)->get();
            $author_info = DB::table('users')->where('id', $article_info[0]->corresponding_author_id)->get();
            

            $data['article'] = $article_info;
            $data['author_bio'] = $author_bio;
            $data['author_info'] = $author_info;

            // pdf create, preview, download
            $pdf = PDF::loadView('pdf.manuscript', $data);
            return $pdf->stream('manuscript.pdf');
    }

        public function pdfDownload($id){

            $article_id = $id;

            // extract data for pdf
            $article_info = DB::table('articles')->where('id', $article_id)->get();
            $author_bio = DB::table('author_bio')->where('user_id', $article_info[0]->corresponding_author_id)->get();
            $author_info = DB::table('users')->where('id', $article_info[0]->corresponding_author_id)->get();
            

            $data['article'] = $article_info;
            $data['author_bio'] = $author_bio;
            $data['author_info'] = $author_info;

            // pdf create, preview, download
            $pdf = PDF::loadView('pdf.manuscript', $data);
            return $pdf->download('manuscript.pdf');
    }

    public function pdfCreateReviewer($id){

            $article_id = $id;

            // extract data for pdf
            $article_info = DB::table('articles')->where('id', $article_id)->get();
            $author_bio = DB::table('author_bio')->where('user_id', $article_info[0]->corresponding_author_id)->get();
            $author_info = DB::table('users')->where('id', $article_info[0]->corresponding_author_id)->get();
            

            $data['article'] = $article_info;
            $data['author_bio'] = $author_bio;
            $data['author_info'] = $author_info;

            // pdf create, preview, download
            $pdf = PDF::loadView('pdf.manuscript', $data);
            return $pdf->stream('manuscript.pdf');
    }

        public function pdfDownloadReviewer($id){

            $article_id = $id;

            // extract data for pdf
            $article_info = DB::table('articles')->where('id', $article_id)->get();
            $author_bio = DB::table('author_bio')->where('user_id', $article_info[0]->corresponding_author_id)->get();
            $author_info = DB::table('users')->where('id', $article_info[0]->corresponding_author_id)->get();
            
            $data['article'] = $article_info;
            // $data['author_bio'] = $author_bio;
            // $data['author_info'] = $author_info;

            // pdf create, preview, download
            $pdf = PDF::loadView('pdf.manuscript', $data);
            return $pdf->download('manuscript.pdf');
    }

        public function terms()
    {
        if (Auth::user()) {
            $user_role_type = User::getUserRoleType(Auth::user()->id);
            $role = $user_role_type->role_type;
            if ($role == 'author') {
                return View::make('article.terms');
            } else {
                Auth::logout();
                return Redirect::to('/login');
            }
        }
    }
}
