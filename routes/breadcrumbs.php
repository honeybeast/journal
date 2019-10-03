<?php
/**
 * Route breadcrumbs file
 *
 */
Breadcrumbs::for(
    'home', function ($trail) {
        $trail->push(trans('prs.home'), route('home'));
    }
);

Breadcrumbs::for(
    'editorArticles', function ($trail, $user_role, $user_id, $article_status) {
        $breadcrumbs_title = "";
        if (!empty($article_status)) {
            $breadcrumbs_title = $article_status;
        }
        $trail->parent('home');
        $trail->push($breadcrumbs_title, route('editorArticles', ['user_role'=> $user_role,'user_id'=>$user_id,'article_status'=>$article_status]));
    }
);

Breadcrumbs::for(
    'editorArticleDetail', function ($trail, $article, $user_role, $user_id, $status, $slug) {
        $breadcrumbs_title = "";
        if (!empty($article->title)) {
            $breadcrumbs_title = $article->title;
        }
        $trail->parent('editorArticles', $user_role, $user_id, $status);
        $trail->push($breadcrumbs_title, route('editorArticles', ['user_role'=> $user_role,'user_id'=> $user_id,'status'=>$status,'slug'=>$slug]));
    }
);

// Author--Create Article
Breadcrumbs::for(
    'checkAuthor', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.create_article'), route('checkAuthor'));
    }
);

//Author--Article Listing
Breadcrumbs::for(
    'authorArticles', function ($trail, $author_id, $status) {
        $breadcrumbs_title = "";
        if (!empty($status)) {
            $breadcrumbs_title = $status;
        }
        $trail->parent('home');
        $trail->push($breadcrumbs_title, route('authorArticles', ['author_id'=> $author_id, 'status'=>$status]));
    }
);

//Reviewer--Article Listing
Breadcrumbs::for(
    'reviewerArticles', function ($trail, $reviewer_id, $status) {
        $breadcrumbs_title = "";
        if (!empty($status)) {
            $breadcrumbs_title = $status;
        }
        $trail->parent('home');
        $trail->push($status, route('reviewerArticles', ['reviewer_id'=> $reviewer_id, 'status'=>$status]));
    }
);

//Reviewer--Article Detail
Breadcrumbs::for(
    'reviewerArticleDetail', function ($trail,$article, $reviewer_id, $status,$id) {
        $trail->parent('reviewerArticles', $reviewer_id, $status);
        $trail->push($article[0]->title, route('reviewerArticleDetail', ['reviewer_id'=> $reviewer_id, 'status'=>$status, 'id'=>$id]));
    }
);

Breadcrumbs::for(
    'categorySetting', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.category_settings'), route('categorySetting'));
    }
);

Breadcrumbs::for(
    'editionSetting', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.edition_settings'), route('editionSetting'));
    }
);

Breadcrumbs::for(
    'manageUsers', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.manage_users'), route('manageUsers'));
    }
);

Breadcrumbs::for(
    'createUser', function ($trail) {
        $trail->parent('manageUsers');
        $trail->push(trans('prs.create_users'), route('createUser'));
    }
);

Breadcrumbs::for(
    'editUser', function ($trail, $id) {
        $trail->parent('manageUsers');
        $trail->push(trans('prs.edit_user'), route('editUser', ['id'=>$id]));
    }
);

Breadcrumbs::for(
    'accountSetting', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.account_settings'), route('accountSetting'));
    }
);

Breadcrumbs::for(
    'managePages', function ($trail, $user_role) {
        $trail->parent('home');
        $trail->push(trans('prs.manage_pages'), route('managePages', ['user_role'=>$user_role]));
    }
);

Breadcrumbs::for(
    'createPage', function ($trail, $user_role, $user_id) {
        $trail->parent('managePages', $user_role);
        $trail->push(trans('prs.create_page'), route('createPage', ['user_role'=>$user_role, 'user_id'=>$user_id]));
    }
);

Breadcrumbs::for(
    'editPage', function ($trail, $user_role, $id) {
        $trail->parent('managePages', $user_role);
        $trail->push(trans('prs.edit_page'), route('editPage', ['user_role'=>$user_role, 'id'=>$id]));
    }
);

Breadcrumbs::for(
    'showPage', function ($trail, $page, $slug) {
        $page_title = "";
        if (!empty($page->title)) {
            $page_title = $page->title;
        }
        $trail->parent('home');
        $trail->push($page_title, route('showPage', ['slug'=>$slug]));
    }
);

Breadcrumbs::for(
    'manageSite', function ($trail, $userRole) {
        $trail->parent('home');
        $trail->push(trans('prs.settings'), route('manageSite', ['user_role', $userRole]));
    }
);

Breadcrumbs::for(
    'orders', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.orders'), route('orders'));
    }
);

Breadcrumbs::for(
    'downloads', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.download'), route('downloads'));
    }
);

Breadcrumbs::for(
    'paymentSettings', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.payment_settings'), route('paymentSettings'));
    }
);

Breadcrumbs::for(
    'emailSettings', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.email_settings'), route('emailSettings'));
    }
);

Breadcrumbs::for(
    'emailTemplates', function ($trail) {
        $trail->parent('home');
        $trail->push(trans('prs.email_templates'), route('emailTemplates'));
    }
);

Breadcrumbs::for(
    'editTemplate', function ($trail,$id) {
        $trail->parent('emailTemplates');
        $trail->push(trans('prs.edit_template'), route('editTemplate', ['id',$id]));
    }
);

Breadcrumbs::for(
    'editEdition', function ($trail,$id) {
        $trail->parent('editionSetting');
        $trail->push(trans('prs.edit_edition'), route('editEdition', ['id'=>$id]));
    }
);

Breadcrumbs::for(
    'editListing', function ($trail, $slug, $title) {
        $trail->parent('home');
        $trail->push($title, route('editListing', ['slug'=> $slug]));
    }
);

Breadcrumbs::for(
    'articleDetail', function ($trail, $edition_slug, $edition_title, $article) {
        $trail->parent('editListing', $edition_slug, $edition_title);
        $trail->push($article->title, route('editListing', ['edition_slug'=>$edition_slug, 'edition_title'=>$edition_title, 'article'=> $article]));
    }
);
