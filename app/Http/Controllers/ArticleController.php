<?php

/**
 * Class ArticleController
 *
 * @category Scientific-Journal
 *
 * @package Scientific-Journal
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Edition;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use DB;
use App\User;
use View;
use App\Mail\ArticleNotificationMailable;
use Auth;
use App\Helper;
use App\SiteManagement;
use Illuminate\Support\Facades\Input;
use App\EmailTemplate;
use Storage;

/**
 * Class ArticleController
 *
 */
class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * @access public
     * @param string $role
     * @param int $id
     * @param string $status
     * @desc Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $role = "", $id = "", $status = "")
    {
        $article_status = Helper::getMenuStatus($status);
        $user_id = Auth::user()->id;
        $user_role_type = User::getUserRoleType($user_id);
        $user_role = $user_role_type->role_type;
        $page_title = Helper::DashboardArticlePageTitle($status);
        $payment_mode = SiteManagement::getMetaValue('payment_mode');
        if (empty($article_status)) {
            return Redirect::to('/' . $user_role . '/dashboard/' . $user_id . '/articles-under-review');
        } else {
            if ($user_role != $role || $user_id != $id || !(is_numeric($id)) || !(in_array($article_status, Helper::statusStaticList()))) {
                return View::make('errors.401');
            }
            $editions = Edition::getEditionsListByStatus();
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                    $articles = Article::where('status', $article_status)->where('title', 'like', '%' . $keyword . '%')
                        ->orderBy('updated_at', 'desc')->paginate(10);
            } else {
                $articles = Article::where('status', $article_status)->orderBy('updated_at', 'desc')->paginate(9);
            }
            return View::make(
                'admin.article.index',
                compact(
                    'page_title', 'editions', 'user_id',
                    'articles', 'article_status', 'user_role', 'payment_mode'
                )
            );
        }
    }

    /**
     * @access public
     * @desc Display the specified resource.
     * @param string $role
     * @param int $id
     * @param string $status
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($role = "", $id = "", $status, $slug)
    {
        $article_status = Helper::getMenuStatus($status);
        $user_id = Auth::user()->id;
        $user_role_type = User::getUserRoleType($user_id);
        $user_role = $user_role_type->role_type;
        if ($user_role != $role || $user_id != $id || !(is_numeric($id)) || !(in_array($article_status, Helper::statusStaticList()))) {
            return View::make('errors.401');
        }
        $article = DB::table('articles')->where('slug', $slug)->where('status', $article_status)->first();
        if (!empty($article)) {
            $existed_reviewers = User::getUserByRoleType('reviewer');
            $existed_categories = Category::all();
            $reviewers_categories = Category::getReviewersCategory();
            $article_reviewers = Article::getReviewerIdByArticle($article->id);
            return View::make(
                'admin.article.show',
                compact(
                    'slug', 'article_reviewers', 'user_role',
                    'user_id', 'article', 'existed_reviewers',
                    'existed_categories', 'reviewers_categories'
                )
            )->with('status', $article_status);
        }
    }

    /**
     * @access public
     * @desc Assign article to the reviewer and
     * sent email to the reviewer.
     * @param  \Illuminate\Http\Request  $request
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function assignReviewer(Request $request, $role = "")
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $reviewers = $request['reviewers'];
        $article_id = $request['reviewer_article'];
        if (!empty($reviewers)) {
            $submitted_article = Article::getArticleNotificationData($article_id);
            if (!empty($submitted_article)) {
                $article_title = $submitted_article->title;
            }
            if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                $email_params = array();
                $email_params['reviewer_assign_article_title'] = $article_title;
                foreach ($reviewers as $reviewer_id) {
                    $reviewer_data = User::getUserDataByID($reviewer_id);
                    if (!empty($reviewer_data)) {
                        $reviewer_name = $reviewer_data->name . " " . $reviewer_data->sur_name;
                        $reviewer_email = $reviewer_data->email;
                    }
                    $email_params['assign_article_reviewer_name'] = $reviewer_name;
                    $email_params['reviewer_email'] = $reviewer_email;
                    $article_link = url('/login?user_id=' . $reviewer_id . '&email_type=assign_reviewer');
                    $email_params['article_link'] = $article_link;
                    $email_params['assign_article_id'] = $article_id;
                    $role_id = User::getRoleIDByUserID($reviewer_id);
                    $template_data = EmailTemplate::getEmailTemplatesByID($role_id, 'assign_reviewer');
                    Mail::to($reviewer_email)->send(new ArticleNotificationMailable($email_params, $template_data, 'reviewer'));
                }
            }
            DB::table('reviewers')->where('article_id', $article_id)->delete();
            Article::SaveArticleReviewers('articles_under_review', $article_id, $reviewers);
            $message = trans('prs.article_assigned');
            return response()->json(['message' => $message]);
        } else {
            $assignedReviewers = DB::table('reviewers')->where('article_id', $article_id)->get();
            if ($assignedReviewers->count() == 0) {
                $message = trans('prs.reviewer_assigned_error');
                return response()->json(['message' => $message]);
            } else {
                DB::table('reviewers')->where('article_id', $article_id)->delete();
                $message = trans('prs.reviewers_delete');
                return response()->json(['message' => $message]);
            }
        }
    }

    /**
     * @access public
     * @desc Notify reviewer comments
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notifyArticleReview(Request $request)
    {
        $request_id = $request['ID'];
        if (!empty($request_id)) {
            $parts = explode("-", $request_id);
            $article_id = $parts[1];
            return DB::table('articles')
                ->where('id', $article_id)
                ->update(['notify' => 0]);
        }
    }

    /**
     * @access public
     * @desc Notify Article Review.
     * @param \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function submitEditorFeedback(Request $request, $id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate(
                $request, [
                    'comments' => 'required',
                ]
            );
            $email_params = array();
            $status = $request['status'];
            $status_title = Helper::setArticleMenuParameter($status);
            $user_id = Auth::user()->id;
            $user_role_type = User::getUserRoleType($user_id);
            $userRole = $user_role_type->role_type;
            $editor = User::getUserDataByID($user_id);
            Article::submitComments($request, $user_id, $id);
            $comment_id = DB::getPdo()->lastInsertId();
            $comments = Article::getCommentsByID($comment_id);
            Article::where('id', '=', $id)->update(['status' => $status, 'author_notify' => 1]);
            // prepare email and send to users
            $corresponding_author = Article::getArticleCorrespondingAuthor($id);
            if (!empty($corresponding_author)) {
                $corresponding_author_email = $corresponding_author[0]->email;
                $corresponding_author_name = $corresponding_author[0]->name . " " . $corresponding_author[0]->sur_name;
                $corresponding_author_data = User::getUserRoleType($corresponding_author[0]->id);
                $author_template_data = EmailTemplate::getEmailTemplatesByID($corresponding_author_data->id, $status . '_editor_feedback');
                $author_article_link = url(
                    '/login?user_id=' . $corresponding_author[0]->id . '&email_type=' . $status . '_editor_feedback&status=' . $status
                );
                $email_params['editor_review_corresponding_author_name'] = $corresponding_author_name;
                $email_params['author_editor_review_article_link'] = $author_article_link;
            }
            $superadmin = User::getUserByRoleType('superadmin');
            $email_params['editor_review_super_admin_name'] = $superadmin[0]->name;
            $articles = Article::select('title')->where('id', $id)->first();
            if (!empty($articles)) {
                $email_params['editor_review_author_article_title'] = $articles->title;
            }
            $email_params['editor_review_author_article_id'] = $id;
            $email_params['editor_review_comments'] = $comments->comment;
            $email_params['editor_name'] = $editor->name . " " . $editor->sur_name;
            if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                $role_type = array("superadmin", "corresponding_author", "author");
                $user_email = "";
                foreach ($role_type as $key => $role) {
                    if ($role == "superadmin") {
                        $article_link = url('/login?user_id=' . $superadmin[0]->id . '&email_type=' . $status . '_editor_feedback&status=' . $status);
                        $email_params['editor_review_article_link'] = $article_link;
                        $template_data = EmailTemplate::getEmailTemplatesByID($superadmin[0]->role_id, $status . '_editor_feedback');
                        if (!empty($template_data)) {
                            Mail::to($superadmin[0]->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
                        }
                    } elseif ($role == "author") {
                        $authors = Article::getArticleAuthors($id);
                        foreach ($authors as $author) {
                            if (!empty($author_template_data)) {
                                $email_params['editor_review_author_name'] = $author->name;
                                Mail::to($author->email)->send(new ArticleNotificationMailable($email_params, $author_template_data, $role));
                            }
                        }
                    } elseif ($role == "corresponding_author") {
                        if (!empty($author_template_data)) {
                            Mail::to($corresponding_author_email)->send(new ArticleNotificationMailable($email_params, $author_template_data, $role));
                        }
                    }
                }
            }
            Session::flash('message', trans('prs.feedback_submitted'));
            return Redirect::to('/' . $userRole . '/dashboard/' . $user_id . '/' . $status_title);
        }
    }

    /**
     * @access public
     * @desc Custom errors for articles.
     * @param \Illuminate\Http\Request  $request
     * @return string
     */
    public function articleCustomErrors(Request $request)
    {
        $errors = array();
        $errors['author_name_error'] = trans('prs.ph_article_author_name_error');
        $errors['author_email_error'] = trans('prs.ph_article_author_email_error');
        $errors['article_title_error'] = trans('prs.ph_article_title_error');
        $errors['article_desc_error'] = trans('prs.ph_article_desc_error');
        $errors['article_excerpt_error'] = trans('prs.ph_article_excerpt_error');
        $errors['article_doc_error'] = trans('prs.ph_article_doc_error');
        $errors['article_wordsover_error'] = trans('prs.ph_article_wordsover_error');
        $errors['article_keywords_error'] = trans('prs.ph_article_keywords_error');
        $errors['article_policy_error'] = trans('prs.ph_article_policy_error');
        return $errors;
    }

    /**
     * @access public
     * @desc Update accepted articles.
     * @param \Illuminate\Http\Request  $request
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function updateAcceptedArticle(Request $request, $role = "")
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $hidden_pdf = $request['hidden_pdf_field'];
            $pdf = $request->file('article_pdf');
            $price = $request['price'];
            $article_id = $request['article'];
            if (empty($hidden_pdf)) {
                $this->validate(
                    $request, [
                    'article_pdf' => 'required|mimes:pdf|max:2000',
                    ]
                );
            }
            if (!empty($pdf)) {
                $this->validate(
                    $request, [
                        'article_pdf' => 'required|mimes:pdf|max:2000',
                    ]
                );
                $uploaded_file = $request->file('article_pdf');
                $file_original_name = $uploaded_file->getClientOriginalName();
                $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
                $file_path = 'uploads/articles_pdf/' . $article_id . '/';
                $extension = $uploaded_file->getClientOriginalExtension();
                $file_name = $article_id . '-' . $file_name_without_extension . '-' . time() . '.' . $extension;
                Storage::disk('local')->putFileAs(
                    $file_path,
                    $uploaded_file,
                    $file_name
                );
                $article = Article::find($article_id);
                $article->price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
                $article->publish_document = filter_var($file_name, FILTER_SANITIZE_STRING);
                $article->save();
                Session::flash('message', trans('prs.article_updated'));
                return Redirect::back();
            } elseif (!empty($hidden_pdf) && !empty($price)) {
                $article = Article::find($article_id);
                $article->price = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
                $article->save();
                Session::flash('message', trans('prs.article_updated'));
                return Redirect::back();
            } else {
                Session::flash('message', trans('prs.article_updated'));
                return Redirect::back();
            }
        }
    }
}
