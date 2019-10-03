<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleNotificationMailable;
use App\User;
use Auth;
use View;
use DB;
use Session;
use App\Helper;
use App\SiteManagement;
use App\EmailTemplate;
use Illuminate\Support\Facades\Input;


class ReviewerController extends Controller
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
     * @desc Display a listing of the resource.
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $role, $status)
    {
        $article_status = Helper::getMenuStatus($status);
        $user_id = Auth::user()->id;
        if (!empty($role) && !empty($status)) {
            if ($user_id != $role || !(is_numeric($role)) || !(in_array($article_status, Helper::statusStaticList()))) {
                return View::make('errors.401');
            }
            $page_title = Helper::DashboardArticlePageTitle($status);
            if (!empty($_GET['keyword'])) {
                $keyword = $_GET['keyword'];
                $articles = Article::getReviewerArticlesBySearchKey($user_id, $article_status, $keyword);
            } else {
                $articles = Article::getReviewerArticles($user_id, $article_status);
            }
            return View::make(
                'reviewer.article.index',
                compact(
                    'page_title', 'articles'
                )
            )->with('status', $article_status)->with('reviewer_id', $user_id);
        }
    }

    /**
     * @access public
     * @desc Display the specified resource.
     * @param int $reviewer_id
     * @param string $status
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($reviewer_id, $status, $id)
    {
        $user_id = Auth::user()->id;
        if (!empty($status) && !empty($id)) {
            $article_status = Helper::getMenuStatus($status);
            if ($user_id != $reviewer_id || !(is_numeric($reviewer_id)) || !(in_array($article_status, Helper::statusStaticList()))) {
                return View::make('errors.401');
            }
            $article = Article::getReviewerArticlesDetail($user_id, $article_status, $id);
            $comments = Article::getArticleFeedback($id, $user_id);
            return View::make('reviewer.article.feedback', compact('comments', 'article', 'id'))->with('status', $article_status)->with('reviewer_id', $reviewer_id);
        }
    }

    /**
     * @access public
     * @desc Store reviewer comments in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function storeReviewerFeedback(Request $request, $id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate($request, [
                'comments' => 'required',
            ]);
            $user_id = Auth::user()->id;
            $status = $request->status;
            if (!empty($id) && is_numeric($id)) {
                Article::submitComments($request, $user_id, $id);
                $comment_id = DB::getPdo()->lastInsertId();
                $comments = Article::getCommentsByID($comment_id);
                Article::updateReviewerStatus($user_id, $id, $status);
                Article::where('id', '=', $id)->update(array('notify' => 1));
                $reviewer_data = User::getUserDataByID($user_id);
                $reviewer_name = $reviewer_data->name . " " . $reviewer_data->sur_name;
                $reviewer_email = $reviewer_data->email;
                $articles = Article::getArticleNotificationData($id);
                $status_title = Helper::setArticleMenuParameter($status);
                $superadmin = User::getUserByRoleType('superadmin');
                $email_params = array();
                $email_params['reviewer_feedback_article_title'] = $articles->title;
                $email_params['reviewer_feedback_article_id'] = $articles->id;
                $email_params['reviewer_feedback_name'] = $reviewer_name;
                $email_params['reviewer_feedback_email'] = $reviewer_email;
                $email_params['reviewer_feedback_comments'] = $comments->comment;
                $email_params['reviewer_feedback_admin_name'] = $superadmin[0]->name;
                if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                    $role_type = array("superadmin", "editor");
                    foreach ($role_type as $key => $role) {
                        if ($role == "superadmin") {
                            $article_link = url('/login?user_id=' . $superadmin[0]->id . '&email_type=reviewer_feedback&status=' . $status_title . '&id=' . $id);
                            $email_params['reviewer_feedback_article_link'] = $article_link;
                            $template_data = EmailTemplate::getEmailTemplatesByID($superadmin[0]->role_id, 'reviewer_feedback');
                            if (!empty($template_data)) {
                                Mail::to($superadmin[0]->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role, $reviewer_name, $reviewer_email));
                            }
                        } elseif ($role == "editor") {
                            $editors = User::getUserByRoleType('editor');
                            if (!empty($editors)) {
                                foreach ($editors as $editor) {
                                    $article_link = url('/login?user_id=' . $editor->id . '&email_type=reviewer_feedback&status=' . $status_title . '&id=' . $id);
                                    $email_params['reviewer_feedback_article_link'] = $article_link;
                                    $email_params['editor_name'] = $editor->name . " " . $editor->sur_name;
                                    $template_data = EmailTemplate::getEmailTemplatesByID($editor->role_id, 'reviewer_feedback');
                                    if (!empty($template_data)) {
                                        Mail::to($editor->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role, $reviewer_name, $reviewer_email));
                                    }
                                }
                            }
                        }
                    }
                }
                Session::flash('message', trans('prs.feedback_submitted'));
                return Redirect::to('/reviewer/user/' . $user_id . '/' . $status_title);
            }
        }
    }
}
