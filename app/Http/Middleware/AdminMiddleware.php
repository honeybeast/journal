<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class AdminMiddleware
{

    /**
     * @package Peer Review System
     * @access public
     * @version 1.0
     * @desc Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::all()->count();
        if (!($user == 1)) {
            if ($request->path() === 'notify-article-review') {
                if (!Auth::user()->hasPermissionTo('Notify Article Review')) {
                    abort('404');
                }
            }
            if ($request->is('submit-editor-feedback/*')) {
                if (!Auth::user()->hasPermissionTo('Submit Feedback')) {
                    abort('404');
                }
            }
            if ($request->is('author/user/*/*')) {
                if (!Auth::user()->hasPermissionTo('author_articles')) {
                    abort('404');
                }
            }
            if ($request->path() === 'author/user/create-article') {
                if (!Auth::user()->hasPermissionTo('Create Articles')) {
                    abort('404');
                }
            }
            if ($request->path() === 'superadmin/users/manage-users') {
                if (!Auth::user()->hasPermissionTo('Manage Users')) {
                    abort('404');
                }
            }
            if ($request->path() === 'superadmin/users/create-users') {
                if (!Auth::user()->hasPermissionTo('Create Users')) {
                    abort('404');
                }
            }
            if ($request->is('superadmin/users/edit-user/*')) {
                if (!Auth::user()->hasPermissionTo('Edit Users')) {
                    abort('404');
                }
            }
            if ($request->path() === 'dashboard/category/settings') {
                if (!Auth::user()->hasPermissionTo('View Categories')) {
                    abort('404');
                }
            }
            if ($request->path() === 'dashboard/general/settings/create-category') {
                if (!Auth::user()->hasPermissionTo('Create Category')) {
                    abort('404');
                }
            }
            if ($request->is('dashboard/general/settings/edit-category/*')) {
                if (!Auth::user()->hasPermissionTo('Edit Category')) {
                    abort('404');
                }
            }
            if ($request->path() === 'dashboard/general/settings/category-delete') {
                if (!Auth::user()->hasPermissionTo('Delete Category')) {
                    abort('404');
                }
            }
            if ($request->path() === 'dashboard/edition/settings') {
                if (!Auth::user()->hasPermissionTo('edition_listing')) {
                    abort('404');
                }
            }
            if ($request->path() === 'dashboard/general/settings/create-edition') {
                if (!Auth::user()->hasPermissionTo('Create Edition')) {
                    abort('404');
                }
            }
            if ($request->path() === 'dashboard/general/settings/delete-edition') {
                if (!Auth::user()->hasPermissionTo('Delete Edition')) {
                    abort('404');
                }
            }
            if ($request->is('dashboard/general/settings/update-edition/*')) {
                if (!Auth::user()->hasPermissionTo('Edit Edition')) {
                    abort('404');
                }
            }
            if ($request->is('reviewer/dashboard/*/*')) {
                if (!Auth::user()->hasPermissionTo('Review Articles')) {
                    abort('404');
                }
            }
            if ($request->is('reviewer-feedback/*/*/*')) {
                if (!Auth::user()->hasPermissionTo('Reviewer Feedback')) {
                    abort('404');
                }
            }
            if ($request->is('reviewer/user/submit-feedback/*')) {
                if (!Auth::user()->hasPermissionTo('submit_reviewer_feedback')) {
                    abort('404');
                }
            }
            if ($request->is('*/dashboard/pages')) {
                if (!Auth::user()->hasPermissionTo('Manage Pages')) {
                    abort('404');
                }
            }
            if ($request->is('*/dashboard/*/pages/page/create-page')) {
                if (!Auth::user()->hasPermissionTo('Create Pages')) {
                    abort('404');
                }
            }
            if ($request->is('/editor/dashboard/pages/page/*/edit-page')) {
                if (!Auth::user()->hasPermissionTo('Edit Pages')) {
                    abort('404');
                }
            }
            if ($request->path() === 'editor/dashboard/pages/page/delete-page') {
                if (!Auth::user()->hasPermissionTo('Delete Pages')) {
                    abort('404');
                }
            }
            if ($request->is('dashboard/*/site-management/settings')) {
                if (!Auth::user()->hasPermissionTo('Site Management')) {
                    abort('404');
                }
            }
            if ($request->path() === 'author/create-article') {
                if (!Auth::user()->hasPermissionTo('Create Articles')) {
                    return Redirect::to('/login');
                }
            }
            if ($request->is('paypal/ec-checkout/*')) {
                if (!Auth::user()->hasPermissionTo('article_access')) {
                    abort('404');
                }
            }
            if ($request->path === 'dashboard/superadmin/site-management/payment/settings') {
                if (!Auth::user()->hasPermissionTo('sp_payment_settings')) {
                    abort('404');
                }
            }
            if ($request->path === 'user/products/downloads') {
                if (!Auth::user()->hasPermissionTo('reader_download_products')) {
                    abort('404');
                }
            }
            if ($request->path === 'superadmin/downloads') {
                if (!Auth::user()->hasPermissionTo('sp_download_products')) {
                    abort('404');
                }
            }
            if ($request->is('get/*')) {
                if (!Auth::user()->hasPermissionTo('dashboard_article_access')) {
                    abort('404');
                }
            }
            if ($request->is('user/products/checkout/*')) {
                if (!Auth::user()->hasPermissionTo('buy_article')) {
                    abort('404');
                }
            }
            if ($request->path === '/dashboard/superadmin/emails/templates') {
                if (!Auth::user()->hasPermissionTo('email_templates')) {
                    abort('404');
                }
            }
            if ($request->is('/dashboard/superadmin/emails/edit-template/*')) {
                if (!Auth::user()->hasPermissionTo('edit_email_templates')) {
                    abort('404');
                }
            }
        }
        return $next($request);
    }

}
