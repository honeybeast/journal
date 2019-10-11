<?php

/*
  |--------------------------------------------------------------------------
  | Web routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

// Authentication routes
Auth::routes();

// Import demo route
Route::get('create-database', function () {
    $exitCode = \Artisan::call('migrate:fresh');
    $exitCode = \Artisan::call('db:seed');
    return redirect()->back();
});

// Cache clear route
Route::get('cache-clear', function () {
    $exitCode = \Artisan::call('cache:clear');
    $exitCode = \Artisan::call('route:clear');
    $exitCode = \Artisan::call('config:clear');
    return redirect()->back();
});
Route::get(
    '/',
    function () {
        if (Schema::hasTable('users')) {
            return view('home');
        } else {
            if (!empty(env('DB_DATABASE'))) {
                return Redirect::to('/install');
            } else {
                return "please configure database in .env file";
            }
        }
    }
)->name('home');
Route::get('{role}/dashboard/{id}/{status}', 'ArticleController@index')->name('editorArticles');
Route::get('{role}/dashboard/{id}/{status}/article-search', 'ArticleController@index');
Route::get('{role}/dashboard/{id}/{status}/{slug}', 'ArticleController@show')->name('editorArticleDetail');
Route::post('notify-article-review', 'ArticleController@notifyArticleReview');
Route::post('submit-editor-feedback/{id}', 'ArticleController@submitEditorFeedback');
Route::post('{role}/dashboard/assign-reviewer', 'ArticleController@assignReviewer');
Route::post('{role}/dashboard/update-accepted-article', 'ArticleController@updateAcceptedArticle');

// Author controller routes
Route::get('author/user/{id}/{status}', 'AuthorController@index')->name('authorArticles');
Route::get('author/user/{id}/{status}/article-search', 'AuthorController@index');
Route::get('author/create-article', 'AuthorController@create')->name('checkAuthor');
Route::post('author/store-article', 'AuthorController@store');
Route::post('author/resubmit-article', 'AuthorController@resubmitArticle');
Route::post('author/user/article/author-notified', 'AuthorController@authorNotified');
Route::post('author/user/article/new-article-custom-errors', 'ArticleController@articleCustomErrors');

Route::get('author/user/articlekeywords', 'SiteManagementController@keywords');

Route::get('author/create-pdf/{id}', 'AuthorController@pdfCreate');
Route::get('author/download-pdf/{id}', 'AuthorController@pdfDownload');
Route::get('author/create-pdf-reviewer/{id}', 'AuthorController@pdfCreateReviewer');
Route::get('author/download-pdf-reviewer/{id}', 'AuthorController@pdfDownloadReviewer');

// User controller routes
Route::get('superadmin/users/manage-users', 'UserController@index')->name('manageUsers');
Route::get('superadmin/users/create-users', 'UserController@addUser')->name('createUser');
Route::post('superadmin/users/store-users', 'UserController@create');
Route::get('superadmin/users/edit-user/{id}', 'UserController@edit')->name('editUser');
Route::post('superadmin/users/update-users/{id}', 'UserController@update');
Route::post('superadmin/users/delete-user', 'UserController@destroy');
Route::post('superadmin/users/assign-category', 'UserController@assignCategory');
Route::get('superadmin/products/invoice/{id}', 'UserController@OrderInvoice');
Route::get('superadmin/downloads', 'UserController@downloadOrders')->name('orders');
Route::get('superadmin/users/role-filters', 'UserController@index');
Route::get('user/products/downloads', 'UserController@downloadArticles')->name('downloads');
Route::get('user/products/checkout/{id}', 'UserController@checkout');
Route::get('user/products/thankyou', 'UserController@paymentRedirect');
Route::get('user/products/invoice/{id}', 'UserController@productInvoice');

// general Settings Category Controller Route
Route::get('dashboard/category/settings', 'CategoryController@index')->name('categorySetting');
Route::post('dashboard/general/settings/create-category', 'CategoryController@store');
Route::post('dashboard/general/settings/category-delete', 'CategoryController@destroy');
Route::post('dashboard/general/settings/edit-category/{id}', 'CategoryController@update');

// Pages controller routes
Route::get('{userRole}/dashboard/pages', 'PageController@index')->name('managePages');
Route::get('{userRole}/dashboard/{userId}/pages/page/create-page', 'PageController@create')->name('createPage');
Route::post('{userRole}/dashboard/pages/store-page', 'PageController@store');
Route::get('page/{slug}/', 'PublicController@showDetailPage')->name('showPage');
Route::get('{userRole}/dashboard/pages/page/{id}/edit-page', 'PageController@edit')->name('editPage');
Route::post('{userRole}/dashboard/pages/page/{id}/update-page', 'PageController@update');
Route::post('{userRole}/dashboard/pages/page/delete-page', 'PageController@destroy');

// Site Management Controller Route
Route::get('dashboard/{userRole}/site-management/settings', 'SiteManagementController@index')->name('manageSite');
Route::post('dashboard/{userRole}/site-management/store-settings', 'SiteManagementController@store');
Route::post('dashboard/{userRole}/site-management/store/slider-settings', 'SiteManagementController@storeSlidesData');
Route::post('dashboard/{userRole}/site-management/store/welcome-slider-settings', 'SiteManagementController@storeWelcomeSlidesData');
Route::post('dashboard/{userRole}/site-management/store/welcome-settings', 'SiteManagementController@storePages');
Route::post('dashboard/{userRole}/site-management/store/register-settings', 'SiteManagementController@storeRegSettings');
Route::post('dashboard/{userRole}/site-management/store/success-factor-settings', 'SiteManagementController@storeSuccessFactors');
Route::post('dashboard/{userRole}/site-management/store/contact-info-settings', 'SiteManagementController@storeContactInfo');
Route::post('dashboard/{userRole}/site-management/store/about-us-settings', 'SiteManagementController@storeAboutUsNote');
Route::post('dashboard/{userRole}/site-management/store/notice-board-settings', 'SiteManagementController@storeNotices');
Route::post('dashboard/{userRole}/site-management/store/language-settings', 'SiteManagementController@storeLanguageSetting');
Route::post('dashboard/{userRole}/site-management/store-logo', 'SiteManagementController@storeLogo');
Route::post('dashboard/{userRole}/site-management/delete-logo', 'SiteManagementController@destroySiteLogo');
Route::get('dashboard/{userRole}/site-management/logo/get-logo', 'SiteManagementController@getSiteLogo');
Route::post('dashboard/{userRole}/site-management/store/store-resource-pages', 'SiteManagementController@storeResourceMenuPages');
Route::post('dashboard/{userRole}/site-management/store-advertise-image', 'SiteManagementController@storeAdvertise');
Route::post('dashboard/{userRole}/site-management/delete-advertise', 'SiteManagementController@destroyAdvertise');
Route::get('dashboard/{userRole}/site-management/advertise/get-advertise-image', 'SiteManagementController@getAdvertise');
Route::post('dashboard/{userRole}/site-management/store/site-title-settings', 'SiteManagementController@storeSiteTitle');
Route::post('dashboard/{userRole}/site-management/store/add-keyword', 'SiteManagementController@storeKeyword');

Route::get('dashboard/superadmin/site-management/payment/settings', 'SiteManagementController@setPaymentSetting')->name('paymentSettings');
Route::post('dashboard/superadmin/site-management/payment/store-payment-settings', 'SiteManagementController@storePaymentSetting');
Route::post('dashboard/superadmin/site-management/payment/store-product-type', 'SiteManagementController@storeProductType');
Route::get('dashboard/superadmin/site-management/settings/email', 'SiteManagementController@createEmailSetting')->name('emailSettings');
Route::post('dashboard/superadmin/site-management/email/store-email-settings', 'SiteManagementController@storeEmailSetting');
Route::get('dashboard/superadmin/site-management/cache/clear-allcache', 'SiteManagementController@clearAllCache');
Route::post('superadmin/dashboard/pages/page/edit-page', 'SiteManagementController@getPageOption');

// Edition Controller Route
Route::get('dashboard/edition/settings', 'EditionController@index')->name('editionSetting');
Route::get('dashboard/edition/settings/search-edition', 'EditionController@index');
Route::post('dashboard/general/settings/create-edition', 'EditionController@store');
Route::get('dashboard/general/settings/edit-edition/{id}', 'EditionController@edit')->name('editEdition');
Route::post('dashboard/general/settings/delete-edition', 'EditionController@destroy');
Route::post('dashboard/general/settings/update-edition/{id}', 'EditionController@update');
Route::post('dashboard/general/settings/publish-edition', 'EditionController@publishEdition');
Route::get('article/{slug}', 'PublicController@show')->name('articleDetail');;
Route::get('edition/{slug}', 'PublicController@showPublishArticle')->name('editListing');
Route::post('publish-edition/article/edition-id/', 'EditionController@getEditionID');
Route::get('published/editions/articles', 'PublicController@filterEdition');
Route::get('published/editions/filters', 'PublicController@filterEdition');
Route::get('journal_detail/{id}', 'PublicController@detail');
Route::get('published_articles/{id}', 'PublicController@published_articles');
Route::get('author_guideline/{id}', 'PublicController@author_guideline');
Route::get('journal_by_category/{id}', 'PublicController@journal_by_category');


// Account Settings Controller Route
Route::get('dashboard/general/settings/account-settings', 'SettingController@index')->name('accountSetting');
Route::post('/dashboard/general/settings/account-settings/request-new-password', 'SettingController@requestPassword');
Route::post('/dashboard/general/settings/account-settings/upload-image', 'SettingController@uploadImage');
Route::get('/dashboard/general/settings/account-settings/get-image', 'SettingController@getImage');
Route::post('/dashboard/general/settings/account-settings/delete-image', 'SettingController@deleteImage');
Route::post('/dashboard/general/settings/account-settings/add_author_bio', 'SettingController@add_author_bio');


//  Reviewer controller routes
Route::get('reviewer/user/{userId}/{status}', 'ReviewerController@index')->name('reviewerArticles');
Route::get('reviewer/user/{reviewerId}/{status}/search-article', 'ReviewerController@index');
Route::get('reviewer-feedback/{reviewerId}/{status}/{id}', 'ReviewerController@show')->name('reviewerArticleDetail');
Route::post('reviewer/user/submit-feedback/{id}', 'ReviewerController@storeReviewerFeedback');


//  File controller routes
Route::get('get/{filename}', 'FileController@getFile')->name('getfile');
Route::get('get-publish-file/{PublishFile}', 'PublicController@getPublishFile')->name('getPublishFile');


//  Payment controller routes
Route::get('paypal/redirect-url', 'PaymentController@getIndex');
Route::get('paypal/ec-checkout', 'PaymentController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'PaymentController@getExpressCheckoutSuccess');
Route::get('paypal/adaptive-pay', 'PaymentController@getAdaptivePay');
Route::post('paypal/notify', 'PaymentController@notify');


// Email Template Controller Route
Route::get('dashboard/superadmin/emails/get-email-type', 'EmailController@getEmailType');
Route::post('dashboard/superadmin/emails/get-email-user-type', 'EmailController@getUserType');
Route::post('/dashboard/superadmin/emails/get-email-variables', 'EmailController@getEmailVariables');
Route::get('/dashboard/superadmin/emails/templates', 'EmailController@index')->name('emailTemplates');
Route::get('/dashboard/superadmin/emails/filter-templates', 'EmailController@index')->name('emailTemplates');
Route::get('/dashboard/superadmin/emails/create-templates', 'EmailController@create');
Route::post('/dashboard/superadmin/emails/store-templates', 'EmailController@store');
Route::get('/dashboard/superadmin/emails/edit-template/{id}', 'EmailController@edit')->name('editTemplate');
Route::post('/dashboard/superadmin/emails/email/{id}/update-template', 'EmailController@update');
Route::post('/superadmin/emails/email/delete-template', 'EmailController@destroy');

// Subscriber Controller Route
Route::post('/prs/store-subscriber', 'SubscriberController@store');
