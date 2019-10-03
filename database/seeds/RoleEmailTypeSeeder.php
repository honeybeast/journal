<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleEmailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_email_types')->insert([
            [
                'role_id' => '1',
                'email_type' => 'new_article',
                'variables' => 'a:6:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:4;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '2',
                'email_type' => 'new_article',
                'variables' => 'a:6:{i:0;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:4;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'new_article',
                'variables' => 'a:6:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:4;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'resubmit_article',
                'variables' => 'a:6:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:4;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '2',
                'email_type' => 'resubmit_article',
                'variables' => 'a:6:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:4;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'resubmit_article',
                'variables' => 'a:6:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:4;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '4',
                'email_type' => 'assign_reviewer',
                'variables' =>'a:5:{i:0;a:2:{s:3:"key";s:13:"reviewer_name";s:5:"value";s:15:"%reviewer_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:3;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:4;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'reviewer_feedback',
                'variables' => 'a:7:{i:0;a:2:{s:3:"key";s:13:"reviewer_name";s:5:"value";s:15:"%reviewer_name%";}i:1;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:2;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:3;a:2:{s:3:"key";s:17:"reviewer_comments";s:5:"value";s:19:"%reviewer_comments%";}i:4;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '2',
                'email_type' => 'reviewer_feedback',
                'variables' => 'a:7:{i:0;a:2:{s:3:"key";s:13:"reviewer_name";s:5:"value";s:15:"%reviewer_name%";}i:1;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:2;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:3;a:2:{s:3:"key";s:17:"reviewer_comments";s:5:"value";s:19:"%reviewer_comments%";}i:4;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'accepted_articles_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'minor_revisions_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'major_revisions_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'rejected_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'accepted_articles_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'minor_revisions_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'major_revisions_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'rejected_editor_feedback',
                'variables' => 'a:8:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:2;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:3;a:2:{s:3:"key";s:11:"editor_name";s:5:"value";s:13:"%editor_name%";}i:4;a:2:{s:3:"key";s:15:"editor_comments";s:5:"value";s:17:"%editor_comments%";}i:5;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:6;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:7;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'publish_edition',
                'variables' => 'a:4:{i:0;a:2:{s:3:"key";s:12:"article_list";s:5:"value";s:14:"%article_list%";}i:1;a:2:{s:3:"key";s:12:"edition_name";s:5:"value";s:14:"%edition_name%";}i:2;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:3;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '3',
                'email_type' => 'publish_edition',
                'variables' => 'a:7:{i:0;a:2:{s:3:"key";s:11:"author_name";s:5:"value";s:13:"%author_name%";}i:1;a:2:{s:3:"key";s:12:"edition_name";s:5:"value";s:14:"%edition_name%";}i:2;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:3;a:2:{s:3:"key";s:12:"article_name";s:5:"value";s:14:"%article_name%";}i:4;a:2:{s:3:"key";s:12:"article_link";s:5:"value";s:14:"%article_link%";}i:5;a:2:{s:3:"key";s:10:"article_id";s:5:"value";s:12:"%article_id%";}i:6;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'new_user',
                'variables' => 'a:9:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:9:"site_name";s:5:"value";s:11:"%site_name%";}i:2;a:2:{s:3:"key";s:17:"account_edit_link";s:5:"value";s:19:"%account_edit_link%";}i:3;a:2:{s:3:"key";s:8:"username";s:5:"value";s:10:"%username%";}i:4;a:2:{s:3:"key";s:9:"user_role";s:5:"value";s:11:"%user_role%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:11:"login_email";s:5:"value";s:13:"%login_email%";}i:7;a:2:{s:3:"key";s:8:"password";s:5:"value";s:10:"%password%";}i:8;a:2:{s:3:"key";s:16:"user_credentials";s:5:"value";s:18:"%user_credentials%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => null,
                'email_type' => 'new_user',
                'variables' => 'a:9:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:9:"site_name";s:5:"value";s:11:"%site_name%";}i:2;a:2:{s:3:"key";s:17:"account_edit_link";s:5:"value";s:19:"%account_edit_link%";}i:3;a:2:{s:3:"key";s:8:"username";s:5:"value";s:10:"%username%";}i:4;a:2:{s:3:"key";s:9:"user_role";s:5:"value";s:11:"%user_role%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:11:"login_email";s:5:"value";s:13:"%login_email%";}i:7;a:2:{s:3:"key";s:8:"password";s:5:"value";s:10:"%password%";}i:8;a:2:{s:3:"key";s:16:"user_credentials";s:5:"value";s:18:"%user_credentials%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
//            [
//                'role_id' => '5',
//                'email_type' => 'new_user',
//                'variables' => 'a:9:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:9:"site_name";s:5:"value";s:11:"%site_name%";}i:2;a:2:{s:3:"key";s:17:"account_edit_link";s:5:"value";s:19:"%account_edit_link%";}i:3;a:2:{s:3:"key";s:8:"username";s:5:"value";s:10:"%username%";}i:4;a:2:{s:3:"key";s:9:"user_role";s:5:"value";s:11:"%user_role%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:11:"login_email";s:5:"value";s:13:"%login_email%";}i:7;a:2:{s:3:"key";s:8:"password";s:5:"value";s:10:"%password%";}i:8;a:2:{s:3:"key";s:16:"user_credentials";s:5:"value";s:18:"%user_credentials%";}}',
//                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            ],
            [
                'role_id' => null,
                'email_type' => 'change_password',
                'variables' => 'a:4:{i:0;a:2:{s:3:"key";s:8:"username";s:5:"value";s:10:"%username%";}i:1;a:2:{s:3:"key";s:8:"password";s:5:"value";s:10:"%password%";}i:2;a:2:{s:3:"key";s:11:"login_email";s:5:"value";s:13:"%login_email%";}i:3;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'new_order',
                'variables' => 'a:4:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:8:"order_id";s:5:"value";s:10:"%order_id%";}i:2;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:3;a:2:{s:3:"key";s:8:"username";s:5:"value";s:10:"%username%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '5',
                'email_type' => 'new_order',
                'variables' => 'a:4:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:8:"order_id";s:5:"value";s:10:"%order_id%";}i:2;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:3;a:2:{s:3:"key";s:8:"username";s:5:"value";s:10:"%username%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '1',
                'email_type' => 'success_order',
                'variables' => 'a:15:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:13:"customer_name";s:5:"value";s:15:"%customer_name%";}i:2;a:2:{s:3:"key";s:8:"order_id";s:5:"value";s:10:"%order_id%";}i:3;a:2:{s:3:"key";s:17:"order_detail_link";s:5:"value";s:19:"%order_detail_link%";}i:4;a:2:{s:3:"key";s:19:"customer_order_link";s:5:"value";s:21:"%customer_order_link%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:12:"product_name";s:5:"value";s:14:"%product_name%";}i:7;a:2:{s:3:"key";s:12:"gross_amount";s:5:"value";s:14:"%gross_amount%";}i:8;a:2:{s:3:"key";s:10:"vat_amount";s:5:"value";s:12:"%vat_amount%";}i:9;a:2:{s:3:"key";s:12:"total_amount";s:5:"value";s:14:"%total_amount%";}i:10;a:2:{s:3:"key";s:8:"currency";s:5:"value";s:10:"%currency%";}i:11;a:2:{s:3:"key";s:14:"payment_method";s:5:"value";s:16:"%payment_method%";}i:12;a:2:{s:3:"key";s:8:"quantity";s:5:"value";s:10:"%quantity%";}i:13;a:2:{s:3:"key";s:12:"payment_date";s:5:"value";s:14:"%payment_date%";}i:14;a:2:{s:3:"key";s:14:"payment_detail";s:5:"value";s:16:"%payment_detail%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'role_id' => '5',
                'email_type' => 'success_order',
                'variables' => 'a:15:{i:0;a:2:{s:3:"key";s:10:"admin_name";s:5:"value";s:12:"%admin_name%";}i:1;a:2:{s:3:"key";s:13:"customer_name";s:5:"value";s:15:"%customer_name%";}i:2;a:2:{s:3:"key";s:8:"order_id";s:5:"value";s:10:"%order_id%";}i:3;a:2:{s:3:"key";s:17:"order_detail_link";s:5:"value";s:19:"%order_detail_link%";}i:4;a:2:{s:3:"key";s:19:"customer_order_link";s:5:"value";s:21:"%customer_order_link%";}i:5;a:2:{s:3:"key";s:9:"signature";s:5:"value";s:11:"%signature%";}i:6;a:2:{s:3:"key";s:12:"product_name";s:5:"value";s:14:"%product_name%";}i:7;a:2:{s:3:"key";s:12:"gross_amount";s:5:"value";s:14:"%gross_amount%";}i:8;a:2:{s:3:"key";s:10:"vat_amount";s:5:"value";s:12:"%vat_amount%";}i:9;a:2:{s:3:"key";s:12:"total_amount";s:5:"value";s:14:"%total_amount%";}i:10;a:2:{s:3:"key";s:8:"currency";s:5:"value";s:10:"%currency%";}i:11;a:2:{s:3:"key";s:14:"payment_method";s:5:"value";s:16:"%payment_method%";}i:12;a:2:{s:3:"key";s:8:"quantity";s:5:"value";s:10:"%quantity%";}i:13;a:2:{s:3:"key";s:12:"payment_date";s:5:"value";s:14:"%payment_date%";}i:14;a:2:{s:3:"key";s:14:"payment_detail";s:5:"value";s:16:"%payment_detail%";}}',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
