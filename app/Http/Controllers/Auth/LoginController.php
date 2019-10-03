<?php

namespace App\Http\Controllers\Auth;

use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Schema;
use DB;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user)
    {
        if (Schema::hasTable('users')) {
            if (!empty($_GET['user_id']) && !empty($_GET['email_type'])) {
                //(!empty($_GET['user_id'])) ? $email_user_id = $_GET['user_id'] : $email_user_id = "";
                $email_user_id = !empty($_GET['user_id']) ? $_GET['user_id'] : "";
                $role = User::getUserRoleType($email_user_id);
                (!empty($_GET['email_type'])) ? $email_redirect_type = $_GET['email_type'] : $email_redirect_type = "";
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
                    if ($role->role_type == 'superadmin') {
                        return redirect::to(url('/superadmin/products/invoice/' . $_GET['invoice_id']));
                    } else {
                        return redirect::to(url('/user/products/invoice/' . $_GET['invoice_id']));
                    }

                }
            }
            $user_id = Auth::user()->id;
            $user_role_type = User::getUserRoleType($user_id);
            $userRole = $user_role_type->role_type;
            if ($user->hasRole('editor') || $user->hasRole('super admin')) {
                return Redirect::to('/' . $userRole . '/dashboard/' . $user_id . '/articles-under-review');
            } elseif ($user->hasRole('reviewer')) {
                return Redirect::to('/reviewer/user/' . $user_id . '/articles-under-review');
            } elseif ($user->hasRole('author')) {
                return Redirect::to('author/create-article');
            } else {
                return Redirect::to('/');
            }
        }

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Schema::hasTable('users')) {
            $this->middleware('guest')->except('logout');
        }
    }

}
