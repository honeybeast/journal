<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use App\Article;
use DB;
use View;
use Session;
use App\Edition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\SiteManagement;
use Illuminate\Support\Facades\Input;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleNotificationMailable;
use App\EmailTemplate;
use App\Helper;

class EditionController extends Controller
{

    /**
     * @access protected
     * @var array $editions
     */
    protected $editions;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Edition $editions)
    {
        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
        $this->editions = $editions;
    }

    /**
     * @access public
     * @desc Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $editor_id = Auth::user()->id;
        $payment_mode = SiteManagement::getMetaValue('payment_mode');
        $payment_class = $payment_mode == 'free' ? 'sj-formmanagevtwo' : '';
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $editions = Edition::where('title', 'like', '%' . $keyword . '%')->orderBy('updated_at', 'desc')->paginate(10)->setPath('');
            $pagination = $editions->appends(
                array(
                    'keyword' => Input::get('keyword')
                )
            );
        } else {
            $editions = Edition::getEditions();
        }
        return View::make('admin.settings.edition-setting', compact('editor_id', 'payment_mode', 'payment_class'))
        ->with('editions', $editions);
    }

    /**
     * @access public
     * Store a newly created resource in storage.
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
            $this->validate($request, [
                'title' => 'required|string',
                'edition_date' => 'required|date|date_format:Y-m-d',
                'price' => 'required',
            ]);

            $this->editions->saveEdition($request);
            Session::flash('message', trans('prs.edition_created'));
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Display the specified resource.
     * @param int  $edition_id
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($edition_id = "", $id)
    {
        if (!empty($id)) {
            // Get article data from database
            $article = DB::table('articles')->where('id', $id)->first();
            $payment_detail = SiteManagement::getMetaValue('payment_settings');
            return View::make('editions/show', compact('id', 'article', 'payment_detail'));
        }
    }

    /**
     * @access public
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $edition = Edition::find($id);
            $payment_mode = SiteManagement::getMetaValue('payment_mode');
            $payment_class = $payment_mode == 'free' ? 'sj-formmanagevtwo' : '';
            // Get accepted articles not assign to any edition
            $unassigned_articles = DB::table('articles')->select('*')
                ->where('status', 'accepted_articles')
                ->Where('edition_id', null)
                ->Where('pay_verified', 1)
                ->orWhere('edition_id', $id)
                ->get()->all();
            // Get articles assign to this edition
            $assign_articles = DB::table('articles')->select('id')
                ->where('edition_id', $id)
                ->get()->pluck('id')->toArray();
            return View::make('admin.settings.edition-edit', compact(
                'payment_mode',
                'payment_class',
                'unassigned_articles',
                'assign_articles',
                'id'
            ))
                ->with('edition', $edition);
        }
    }

    /**
     * @access public
     * @desc Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request) && !empty($id)) {
            $this->validate($request, [
                'title' => 'required|string',
                'edition_date' => 'required|date|date_format:Y-m-d',
                'edition_cover' => 'mimes:jpeg,png,jpg',
            ]);
            $this->editions->updateEdition($request, $id);
            Session::flash('message', trans('prs.edition_updated'));
            return Redirect::to('/dashboard/edition/settings');
        }
    }

    /**
     * @access public
     * @desc Remove the specified resource from storage.
     * @param int $id
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $json = array();
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }

        if (!empty($request)) {
            $id = $request['id'];
            if (!empty($id)) {
                DB::table('editions')->where('id', $id)->delete();
                $articles = Edition::getEditionArticle($id);
                if (!empty($articles)) {
                    foreach ($articles as $article) {
                        DB::table('articles')
                            ->where('id', $article->id)
                            ->update(['edition_id' => null, 'publish_document' => null]);
                    }
                }
                $json['type'] = 'success';
                $json['message'] = trans('prs.edition_deleted');
                return $json;
            }
        }
    }

    /**
     * @access public
     * Update edition status to publish
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publishEdition(Request $request)
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['error'] = $server->getData()->message;
            return $response;
        }
        if (!empty($request)) {
            $jason = array();
            $id = $request['id'];
            if (!empty($id)) {
                $articles = Edition::getAssignArticles($id);
                $pdf = DB::table('articles')->select('title')->whereNull('publish_document')
                    ->where('edition_id', $id)->get()->pluck('title')->toArray();
                if (empty($pdf)) {
                    if (!empty($articles)) {
                        DB::table('editions')->where('id', $id)->update(['edition_status' => 1]);
                        $edition = DB::table('editions')->select('title', 'slug')->where('id', $id)->get()->first();
                        //send email
                        if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                            $email_params = array();
                            $email_params['publish_edition_edition_title'] = $edition->title;
                            $super_admin = User::getUserByRoleType('superadmin');
                            $article_list = array();
                            foreach ($articles as $article) {
                                $author_role_id = User::getRoleIDByUserID($article->corresponding_author_id);
                                $corresponding_author = User::getUserDataByID($article->corresponding_author_id);
                                $author_article = Article::getArticlesByAuthorID($article->corresponding_author_id);
                                $email_params['publish_edition_corresponding_author_name'] = $corresponding_author->name;
                                $email_params['publish_edition_author_article_id'] = $author_article->id;
                                $email_params['publish_edition_author_article_title'] = $author_article->title;
                                $email_params['publish_edition_author_article_link'] = url('/article/'. $article->slug);
                                $email_params['publish_edition_article_super_admin_name'] = $super_admin[0]->name;
                                $author_template_data = EmailTemplate::getEmailTemplatesByID($author_role_id, 'publish_edition');
                                if (!empty($author_template_data)) {
                                    Mail::to($corresponding_author->email)->send(new ArticleNotificationMailable($email_params, $author_template_data, 'author'));
                                }
                                $corresponding_author_array = get_object_vars($corresponding_author);
                                $article_list[$article->id]['author'] = $corresponding_author_array;
                                $article_list[$article->id]['title'] = $article->title;
                                $article_list[$article->id]['id'] = $article->id;
                                $article_list[$article->id]['slug'] = $article->slug;
                            }
                            foreach ($article_list as $article_list_data) {
                                $email_params['publish_edition_article_list_data'][] = $article_list_data;
                            }
                            $template_data = EmailTemplate::getEmailTemplatesByID($super_admin[0]->role_id, 'publish_edition');
                            if (!empty($template_data)) {
                                Mail::to($super_admin[0]->email)->send(new ArticleNotificationMailable($email_params, $template_data, 'superadmin'));
                            }
                        }
                        $jason['message'] = trans('prs.edition_success');
                        $jason['edition_id'] = $id;
                        $jason['edition_slug'] = $edition->slug;
                        $jason['edition_title'] = $edition->title;
                        return $jason;
                    } else {
                        return response()->json(['error' => 'Edition Empty']);
                    }
                } else {
                    $doc = "";
                    foreach ($pdf as $f) {
                        $doc .= '"' . $f . '" , ';
                    }
                    $jason['error'] = "please upload the following manuscript pdf " . $doc;
                    return $jason;
                }
            }
        }
    }

    /**
     * @package Peer Review System
     * @access public
     * @version 1.0
     * @desc Get All Editions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEditionID(Request $request)
    {
        $url = $request['url'];
        $urlParts = explode('/', $url);
        $urlEditionPart = count($urlParts) - 2;
        $editionID = $urlParts[$urlEditionPart];
        $articleID = end($urlParts);
        $published_articles = Edition::getPublishedRelatedArticles($editionID, $articleID);
        return response()->json(['article_data' => $published_articles]);
    }

    /**
     * @package Peer Review System
     * @access public
     * @version 1.0
     * @desc Search for Editions.
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function searchEdition(Request $request)
    {
        $editor_id = Auth::user()->id;
        $this->validate($request, [
            'edition_title' => 'required',
        ]);
        $payment_mode = SiteManagement::getMetaValue('payment_mode');
        $payment_class = $payment_mode == 'free' ? 'sj-formmanagevtwo' : '';
        $title = $request['edition_title'];
        if (!empty($title)) {
            $editions = Edition::where('title', 'like', '%' . $title . '%')->orderBy('updated_at', 'desc')->paginate(10);
            if (!($editions->count() > 0)) {
                Session::flash('error', trans('Record Not Found'));
                return Redirect::to('/dashboard/edition/settings')->withInput(Input::all());
            } else {
                return View::make('admin.settings.edition-setting', compact('editor_id', 'payment_mode', 'payment_class'))
                    ->with('editions', $editions)->withInput(Input::all());
                // return redirect()->back()->with(compact('editor_id', 'editions'))->withInput(Input::all());
            }
        }else{
            Session::flash('error', trans('Record Not Found'));
            return Redirect::to('/dashboard/edition/settings')->withInput(Input::all());
        }

    }

}
