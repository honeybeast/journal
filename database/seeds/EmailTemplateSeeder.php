<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmailTemplateSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('email_templates')->insert([
                [
                    'subject' => 'New Article Created',
                    'title' => 'Create New Article - Admin',
                    'role_id' => '1',
                    'email_type' => 'new_article',
                    'body' => '<p>Hi %admin_name%,</p>
                               <p>A new article %article_name% has been submitted for the review. Please assign this article to the reviewers. You can edit this article by clicking the below link</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'New Article Created',
                    'title' => 'Create New Article - Editor',
                    'role_id' => '2',
                    'email_type' => 'new_article',
                    'body' => '<p>Hi %editor_name%,</p>
                            <p>A new article %article_name% has been submitted for the review. Please assign this article to the reviewers. You can edit this article by clicking the below link</p>
                            <p>%article_link%</p>
                            <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'New Article Created',
                    'title' => 'Create New Article - Author',
                    'role_id' => '3',
                    'email_type' => 'new_article',
                    'body' => '<p>Hi %author_name%,</p>
                                <p>Thank you for your submission. Your article "%article_name%" has been submitted. Our quality team will review your article and send you the feedback.</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article Assigned to Reviewer',
                    'title' => 'Article Assigning - Reviewer',
                    'role_id' => '4',
                    'email_type' => 'assign_reviewer',
                    'body' => ' <p>Hi %reviewer_name%,</p>
                                <p>You have received a new article "%article_name%" for the review. To give your feedback you can view this article from below link</p>
                                <p>%article_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article has been re-submitted',
                    'title' => 'Article Re-submission -Super Admin',
                    'role_id' => '1',
                    'email_type' => 'resubmit_article',
                    'body' => '<p><p>Hi %admin_name%</p>
                                <p>An article with the name "<em style="box-sizing: border-box; margin: 0px; padding: 0px; color: #636c77; font-family: Quicksand, Arial, Helvetica, sans-serif;">%article_name%</em>" has been resubmitted by the author "%author_name%". To view the changes you can click below link.</p>
                                <p>%article_link%</p>
                                <p>%signature%</p></p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article has been re-submitted',
                    'title' => 'Article Re-submission - Admin',
                    'role_id' => '2',
                    'email_type' => 'resubmit_article',
                    'body' => '<p>Hi %admin_name%</p>
                               <p>An article with the name %article_name% has been resubmitted by the author "%author_name%". To view the changes you can click below link.</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article has been re-submitted',
                    'title' => 'Article Re-submission - Author',
                    'role_id' => '3',
                    'email_type' => 'resubmit_article',
                    'body' => '<p>Hi %author_name%</p>
                               <p>Thank you for re-submission. Our quality team will review your changes and send you the feedback.</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Feedback from the Reviewer',
                    'title' => 'Reviewer Feedback - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'reviewer_feedback',
                    'body' => '<p>Hi %admin_name%,</p>
                               <p>"%reviewer_name%" has left his/her comments on the article "%article_name%"</p>
                               <p>Reviewer comments are given below</p>
                               <p>%reviewer_comments%</p>
                               <p>To view the article click the below link</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Feedback from the Reviewer',
                    'title' => 'Reviewer Feedback - Admin',
                    'role_id' => '2',
                    'email_type' => 'reviewer_feedback',
                    'body' => '<p>Hi %admin_name%,</p>
                               <p>"%reviewer_name%" has left his/her comments on the article "%article_name%"</p>
                               <p>Reviewer comments are given below</p>
                               <p>%reviewer_comments%</p>
                               <p>To view the article click the below link</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article Accepted, Feedback from the Admin',
                    'title' => 'Editor Feedback Accepted Articles - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'accepted_articles_editor_feedback',
                    'body' => '<p>Hi %admin_name%</p>
                                <p>Congratulations!</p>
                                <p>"%article_name%" has been accepted, The comments from Editor are given below </p>
                                <p>%editor_comments%</p>
                                <p>To view the article click the below link</p>
                                <p>%article_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Minor Revisions, Feedback from the Admin',
                    'title' => 'Editor Feedback Minor Revisions - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'minor_revisions_editor_feedback',
                    'body' => '<p>Hi %admin_name%</p>
                                <p>There are some recommended minor revisions in the articles.</p>
                                <p>"%editor_name%" has left his/her comments on the article "%article_name%". Editors comments are given below</p>
                                <p>%editor_comments%</p>
                                <p>To view the article click the below link</p>
                                <p>%article_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Major Revisions, Feedback from the Admin',
                    'title' => 'Major Revisions Editor Feedback - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'major_revisions_editor_feedback',
                    'body' => '<p>Hi %admin_name%</p>
                                <p>There are some recommended major revisions in the articles.</p>
                                <p>"%editor_name%" has left his/her comments on the article "%article_name%". Editors comments are given below</p>
                                <p>%editor_comments%</p>
                                <p>To view the article click the below link</p>
                                <p>%article_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Rejected Article, Feedback from the Admin',
                    'title' => 'Rejected Article Editor Feedback - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'rejected_editor_feedback',
                    'body' => '<p>Hi %admin_name%</p>
                                <p>Article has been rejected.</p>
                                <p>"%editor_name%" has left his/her comments on the article "%article_name%". Editors comments are given below</p>
                                <p>%editor_comments%</p>
                                <p>To view the article click the below link</p>
                                <p>%article_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article Accepted, Feedback from the Admin',
                    'title' => 'Accepted Article Editor Feedback - Author',
                    'role_id' => '3',
                    'email_type' => 'accepted_articles_editor_feedback',
                    'body' => '<p>Hi %author_name%</p>
                               <p>Congratulations!</p>
                                <p>"%article_name%" has been accepted, The comments from Editor are given below </p>
                                <p>%editor_comments%</p>
                                <p>To view the article click the below link</p>
                                <p>%article_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Minor Revisions, Feedback from the Admin',
                    'title' => 'Minor Revisions Editor Feedback - Author',
                    'role_id' => '3',
                    'email_type' => 'minor_revisions_editor_feedback',
                    'body' => '<p>Hi %author_name%</p>
                               <p>Your article "%article_name%" have some minor changes outlined by the editor.</p>
                               <p>" %editor_comments% "</p>
                               <p>When you&rsquo;re ready, you can upload your changes by clicking below link</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Major Revisions Feedback from the Admin',
                    'title' => 'Major Revisions Editor Feedback - Author',
                    'role_id' => '3',
                    'email_type' => 'major_revisions_editor_feedback',
                    'body' => '<p>Hi %author_name%</p>
                               <p>Your article "%article_name%" have some major changes outlined by the editor</p>
                               <p>" %editor_comments% "</p>
                               <p>When you&rsquo;re ready, you can upload your changes by clicking below link</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Article Rejected, Feedback from the Admin',
                    'title' => 'Rejected Article Editor Feedback - Author',
                    'role_id' => '3',
                    'email_type' => 'rejected_editor_feedback',
                    'body' => '<p>Hi %author_name%</p>
                               <p>Your article "%article_name%" has been rejected. But don&rsquo;t be afraid, we&rsquo;d love to see you resubmit after making the changes outlined by the reviewer below.</p>
                               <p>" %editor_comments% "</p>
                               <p>When you&rsquo;re ready, you can upload your changes by clicking below link</p>
                               <p>%article_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Edition Published',
                    'title' => 'Publish Edition - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'publish_edition',
                    'body' =>   '<p>Hi %admin_name%</p>
                                <p>A list of articles given below has been published in the edition "%edition_name%"</p>
                                <p>%article_list%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Edition Published',
                    'title' => 'Publish Edition - Author',
                    'role_id' => '3',
                    'email_type' => 'publish_edition',
                    'body' => '<p>Hi %author_name%</p>
                               <p>Congratulations!</p>
                               <p>Your article "%article_name%" has been published in the edition "%edition_name%"</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'New User Registered',
                    'title' => 'Create New User - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'new_user',
                    'body' => '<p>Hi %admin_name%</p>
                               <p>A new user has signed up on the %site_name%. To view the account detail please click on below link</p>
                               <p>%account_edit_link%</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Congratulations, Account Created',
                    'title' => 'Create New User',
                    'role_id' => null,
                    'email_type' => 'new_user',
                    'body' => '<p>Hi %username%</p>
                               <p>Congratulations! Your account with the given below detail has been created.</p>
                               <p>%user_credentials%</p>
                               <p>If you didn\'t created this account, ignore this email.</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Password Updated',
                    'title' => 'Change Password - User',
                    'role_id' => null,
                    'email_type' => 'change_password',
                    'body' => '<p>Hi %username%</p>
                                <p>Congratulations! Your account password has been reset to the new password.</p>
                                <p>Your New Password is " %password% "</p>
                                <p>If you didn\'t reset this password, then please login to account and reset it again.</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'New Order Received',
                    'title' => 'New Order Received - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'new_order',
                    'body' => '<p>Hi %admin_name%</p>
                               <p>A new order with order ID "%order_id%" has been created.</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'New Order Created',
                    'title' => 'New Order Created - Reader',
                    'role_id' => '5',
                    'email_type' => 'new_order',
                    'body' => '<p>Hi %admin_name%</p>
                               <p>A new order with order ID "%order_id%" has been created.</p>
                               <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Order Completed',
                    'title' => 'Order Completed - Super Admin',
                    'role_id' => '1',
                    'email_type' => 'success_order',
                    'body' =>   '<p>Hi %admin_name%</p>
                                <p>A payment has been received against the order ID "%order_id%".</p>
                                <p>To view order detail click on below link</p>
                                <p>%order_detail_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'subject' => 'Order Completed',
                    'title' => 'Order Completed - Reader',
                    'role_id' => '5',
                    'email_type' => 'success_order',
                    'body' =>   '<p>Hi %customer_name%</p>
                                <p>Thank you for for purchasing our products! Your payment detail is given below</p>
                                <p>%payment_detail%</p>
                                <p>To print your invoice you can click below link.</p>
                                <p>%customer_order_link%</p>
                                <p>%signature%</p>',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],


            ]);
        }
    }

}
