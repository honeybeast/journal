<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Helper;
use App\User;
use DB;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (!empty($_GET['user_id']) && !empty($_GET['email_type'])) {
                $email_redirect_type = !empty($_GET['email_type']) ? $_GET['email_type'] : "";
                $email_user_id = !empty($_GET['user_id']) ? $_GET['user_id'] : "";
                $role = User::getUserRoleType($email_user_id);
                $status_title = !empty($_GET['status']) ? Helper::displayArticleBreadcrumbsTitle($_GET['status']) : "";
                if ($email_redirect_type == "new_article") {
                    return Helper::getArticleEmailRedirectLink($email_user_id);
                } elseif ($email_redirect_type == "assign_reviewer") {
                    return redirect::to('/reviewer/user/' . $email_user_id . '/articles-under-review');
                } elseif ($email_redirect_type == "reviewer_feedback" && !empty($_GET['status'])) {
                    if ($role->role_type == 'superadmin' || $role->role_type == 'editor') {
                        $status = DB::table('articles')->select('status')->where('id', $_GET['id'])->get()->first();
                        $menu_status = Helper::setArticleMenuParameter($status);
                        return Helper::getArticleEmailRedirectLink($email_user_id, $menu_status);
                    } else {
                        return Helper::getArticleEmailRedirectLink($email_user_id, $_GET['status']);
                    }
                } elseif (($email_redirect_type == "accepted_articles_editor_feedback"
                    || $email_redirect_type == "minor_revisions_editor_feedback"
                    || $email_redirect_type == "major_revisions_editor_feedback"
                    || $email_redirect_type == "rejected_editor_feedback")
                    && !empty($_GET['status'])) {
                        $menu_status = Helper::setArticleMenuParameter($_GET['status']);
                        return Helper::getArticleEmailRedirectLink($email_user_id, $menu_status);
                } elseif ($email_redirect_type == "new_user") {
                    return redirect::to(url('/superadmin/users/edit-user/' . $email_user_id));
                } elseif ($email_redirect_type == "success_order" && !empty($_GET['invoice_id'])) {
                    $role = User::getUserRoleType($email_user_id);
                    if ($role->role_type == 'superadmin') {
                        return redirect::to(url('/superadmin/products/invoice/' . $_GET['invoice_id']));
                    } else {
                        return redirect::to(url('/user/products/invoice/' . $_GET['invoice_id']));
                    }
                }
            } else {
                return redirect('/');
            }

        }

        return $next($request);
    }
}
