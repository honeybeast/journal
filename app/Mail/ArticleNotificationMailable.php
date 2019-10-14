<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\SiteManagement;

class ArticleNotificationMailable extends Mailable
{
    use
        Queueable,
        SerializesModels;

    /**
     * @access public 
     * @var array $email_params
     */
    public $email_params;

    /**
     * @access public 
     * @var array $template_data
     */
    public $template_data;

    /**
     * @access public 
     * @var array $user_type
     */
    public $user_type;

    /**
     * @access public 
     * @var array $subject
     */
    public $subject;

    /**
     * @access public 
     * @var array $email
     */
    public $email;

    /**
     * @access public 
     * @var array $name
     */
    public $name;

    /**
     * @access public   
     * @desc Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_params = array(), $template_data = '', $user_type = '', $name = '', $email = '')
    {
        $email_settings = SiteManagement::getMetaValue('email_settings');
        $title = SiteManagement::getMetaValue('site_title');
        $this->email_params = $email_params;
        $this->template_data = $template_data;
        $this->user_type = $user_type;
        $this->name = $title[0]['site_title'];
        $this->email = $email_settings[0]['email'];
    }

    /**
     * @access public   
     * @desc Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_type = $this->template_data->email_type;
        $subject = $this->template_data->subject;
        $from_name = !empty($this->name) ? $this->name : 'no-reply@domain.com';
        $from_address = !empty($this->email) ? $this->email : 'no-reply@domain.com';
        if ($email_type == "new_article" && ($this->user_type == "corresponding_author" || $this->user_type == "author")) {
            $email_message = $this->prepare_author_new_article_email_message($this->email_params);
        } elseif ($email_type == "resubmit_article" && ($this->user_type == "corresponding_author" || $this->user_type == "author")) {
            $email_message = $this->prepare_author_resubmit_article_email_message($this->email_params);
        } elseif ($this->user_type == "superadmin" && $email_type == "new_article") {
            $email_message = $this->prepare_admin_new_article_email_message($this->email_params);
        } elseif ($this->user_type == "superadmin" && $email_type == "resubmit_article") {
            $email_message = $this->prepare_admin_resubmit_article_email_message($this->email_params);
        } elseif ($this->user_type == "editor" && $email_type == "resubmit_article") {
            $email_message = $this->prepare_editor_resubmit_article_email_message($this->email_params);
        } elseif ($this->user_type == "editor" && $email_type == "new_article") {
            $email_message = $this->prepare_editor_new_article_email_message($this->email_params);
        } elseif (($this->user_type == "editor" || $this->user_type == "superadmin") && $email_type == "reviewer_feedback") {
            $email_message = $this->prepare_reviewer_feedback_email_message($this->email_params);
        } elseif (($email_type == "accepted_articles_editor_feedback" || $email_type == "minor_revisions_editor_feedback" || $email_type == "major_revisions_editor_feedback" || $email_type == "rejected_editor_feedback") && ($this->user_type == "corresponding_author" || $this->user_type == "author")) {
            $email_message = $this->prepare_author_editor_review_email_message($this->email_params);
        } elseif (($email_type == "accepted_articles_editor_feedback" || $email_type == "minor_revisions_editor_feedback" || $email_type == "major_revisions_editor_feedback" || $email_type == "rejected_editor_feedback") && $this->user_type == "superadmin") {
            $email_message = $this->prepare_superadmin_editor_review_email_message($this->email_params);
        } elseif ($email_type == "new_order" && ($this->user_type == "superadmin" || $this->user_type == "reader")) {
            $email_message = $this->prepare_new_order_email_message($this->email_params);
        } elseif ($email_type == "success_order" && ($this->user_type == "superadmin" || $this->user_type == "reader")) {
            $email_message = $this->prepare_success_order_email_message($this->email_params);
        } elseif ($email_type == "new_user" && ($this->user_type == "author" || $this->user_type == "reader" || $this->user_type == "superadmin" || $this->user_type == "reviewer" || $this->user_type == "editor")) {
            $email_message = $this->prepare_new_register_user_email_message($this->email_params);
        } elseif ($email_type == "assign_reviewer" && $this->user_type == "reviewer") {
            $email_message = $this->prepare_reviewer_Assign_Article_email_message($this->email_params);
        } elseif ($email_type == "publish_edition" && $this->user_type == "author") {
            $email_message = $this->prepare_author_publish_edition_email_message($this->email_params);
        } elseif ($email_type == "publish_edition" && $this->user_type == "superadmin") {
            $email_message = $this->prepare_superadmin_publish_edition_email_message($this->email_params);
        } elseif ($email_type == "change_password") {
            $email_message = $this->prepare_change_password_email_message($this->email_params);
        }
        $message = $this->from($from_address, $from_name)->subject($subject)->view('emails.index')
                ->with([
                    'html' => $email_message,
                ]);
        return $message;
    }

    /**
     * @access public
     * @desc Create email header 
     * @return string
     */
    public function prepare_email_header()
    {
        ob_start();
        ?>
        <div style="min-width:100%;background-color:#f6f7f9;margin:0;width:100%;color:#283951;font-family:'Helvetica','Arial',sans-serif;padding: 60px 0;">
        <div style="max-width: 600px; width: 100%; margin: 0 auto; overflow: hidden; color: #919191; font:400 16px/26px 'Open Sans', Arial, Helvetica, sans-serif;">
        <header style="width: 100%; float: left; padding: 30px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
            <strong style="float: left; padding: 0 0 0 30px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                <a style="float: left; color: #55acee; text-decoration: none;" href="#"></a></strong>
            <div style="float: right; padding: 14px 30px 14px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"></div>
        </header>
        <div style="background:#ffffff; width: 100%; float: left; padding: 30px 30px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
        <div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
        <div style="width: 100%; float: left;">
        <?php
        return ob_get_clean();
    }

    /**
     * @access public
     * @desc Create email footer 
     * @param $email_type
     * @return string
     */
    public function prepare_email_footer()
    {
        $project_title = SiteManagement::getMetaValue('site_title');
        ob_start();
        ?>
        </div>
        </div>
        </div>
        <footer style="width:100%;float:left;background: #002c49;padding: 30px 15px;text-align:center;box-sizing:border-box;border-radius: 0 0 5px 5px;">
            <p style="font-size: 13px; line-height: 13px; color: #aaaaaa; margin: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                Copyright&nbsp;&copy;&nbsp;2018 | All Rights Reserved 
                <a href="<?php echo url('/') ?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; color: #348eda; margin: 0; padding: 0;">
                    <?php echo e($project_title[0]['site_title']); ?>
                </a>
            </p>
        </footer>
        </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * @access public
     * @desc Create redirect Link 
     * @param $email_type
     * @return string
     */
    public function prepare_redirect_link($redirect_link, $link_title)
    {
        ob_start();
        ?>
        <a style="color: #fff; padding: 0 50px; margin: 0 0 15px; font-size: 20px; font-weight: 600; line-height: 60px; border-radius: 8px; background: #5dc560; vertical-align: top; display: inline-block; font-family: 'Work Sans', Arial, Helvetica, sans-serif;  text-decoration: none;" href="<?php echo $redirect_link; ?>">
            <?php echo e($link_title); ?>
        </a>
        <?php
        return ob_get_clean();
    }

    /**
     * @access public
     * @desc Prepare publish edition email article list.
     * @param array $publish_edition_article_data
     * @param int $edition_id
     * @return string
     */
    public function prepare_publish_edition_article_list($publish_edition_article_data = array(), $edition_id)
    {
        ob_start();
        ?>
        <ul style="margin: 0; width: 100%; float: left; list-style: none; font-size: 14px; line-height: 20px; padding: 0 0 15px; font-family: 'Work Sans', Arial, Helvetica, sans-serif;">
         <?php foreach ($publish_edition_article_data as $article_data) { ?>
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none; background: #f7f7f7;">
                <strong style="width: 33.33%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo e($article_data['title']); ?></strong>
                <span style="width: 33.33%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><a href="<?php echo url('/article/' . $article_data['slug']) ?>">Link</a> </span>
                <span style="width: 33.33%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo e($article_data['author']['name']); ?></span>
            </li>
         <?php 
    } ?>
         </ul>
        <?php
        return ob_get_clean();
    }

    /**
     * @access public
     * @desc Prepare customer success order detail function
     * @param int $order_id
     * @param string $product_name
     * @param double $gross_amount
     * @param double $vat_amount
     * @param double $total_amount
     * @return string
     */
    public function prepare_customer_success_order_detail($order_id, $product_name, $gross_amount, $vat_amount, $total_amount)
    {
        ob_start();
        ?>
        <ul style="margin: 0; width: 100%; float: left; list-style: none; font-size: 14px; line-height: 20px; padding: 0 0 15px; font-family: 'Work Sans', Arial, Helvetica, sans-serif;">
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none; background: #f7f7f7;">
                <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Order ID</strong>
                <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo $order_id; ?></span>
            </li>
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none;">
                <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Product Name</strong>
                <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo e($product_name); ?></span>
            </li>
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none; background: #f7f7f7;">
                <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Gross Amount</strong>
                <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo $gross_amount; ?></span>
            </li>
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none;">
                <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">VAT %</strong>
                <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo $vat_amount; ?></span>
            </li>
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none; background: #f7f7f7;">
                <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Total Amount</strong>
                <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo $total_amount; ?></span>
            </li>
        </ul>
        <?php return ob_get_clean();
    }

    /**
     * @access public
     * @desc Create email signature function
     * @return string
     */
    public function prepare_email_signature()
    {
        ob_start();
        $site_title = SiteManagement::getMetaValue('site_title');
        ?>
        <div style="overflow: hidden; padding: 0 0 0 0px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
            <p style="margin: 0 0 7px; font-size: 14px; line-height: 14px; color: #919191; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Thanks</p>
            <p style="margin: 0 0 7px; font-size: 14px; line-height: 14px; color: #919191 -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Regards</p>
            <h2 style="font-size: 18px; line-height: 18px; margin: 0 0 5px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #333; font-weight: normal;font-family: 'Work Sans', Arial, Helvetica, sans-serif;"><?php echo e($site_title[0]['site_title']); ?></h2>
        </div>
        <?php return ob_get_clean();
    }

    /**
     * @access public   
     * @desc Prepare author submit article email message.
     * @param array $email_params
     * @return string
     */

    public function prepare_author_new_article_email_message($email_params = array())
    {
        extract($email_params);
        $name = $this->user_type == "corresponding_author" ? $corresponding_author_name : $author_name;
        $title = $article_title;
        $admin_name = $superadmin_name;
        $link = $this->prepare_redirect_link($article_link, 'view Article');
        $id = $article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare author resubmit article email message
     * @param array $email_params
     * @return string
     */
    public function prepare_author_resubmit_article_email_message($email_params = array())
    {
        extract($email_params);
        $name = $this->user_type == "corresponding_author" ? $corresponding_author_name : $author_name;
        $title = $article_title;
        $admin_name = $superadmin_name;
        $link = $this->prepare_redirect_link($article_link, 'view Article');
        $id = $article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }


    /**
     * @access public
     * @desc Prepare superadmin new article email message
     * @param array $email_params
     * @return string
     */
    public function prepare_admin_new_article_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $corresponding_author_name;
        $title = $article_title;
        $admin_name = $superadmin_name;
        $link = $this->prepare_redirect_link($article_link, 'view Article');
        $id = $article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);
        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare editor new article email message
     * @param array $email_params
     * @return string
     */
    public function prepare_editor_new_article_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $corresponding_author_name;
        $title = $article_title;
        $admin_name = $superadmin_name;
        $editorName = $editor_name;
        $link = $this->prepare_redirect_link($article_link, 'view Article');
        $id = $article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %editor_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%editor_name%", $editorName, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare superadmin resubmit article email message
     * @param array $email_params
     * @return string
     */
    public function prepare_admin_resubmit_article_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $corresponding_author_name;
        $title = $article_title;
        $admin_name = $superadmin_name;
        $link = $this->prepare_redirect_link($article_link, 'view Article');
        $id = $article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare editor resubmit article email message
     * @param array $email_params
     * @return string
     */
    public function prepare_editor_resubmit_article_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $corresponding_author_name;
        $title = $article_title;
        $admin_name = $editor_name;
        $link = $this->prepare_redirect_link($article_link, 'view Article');
        $id = $article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public   
     * @desc Prepare reviewer status update message
     * @param array $email_params
     * @return string
     */
    public function prepare_reviewer_feedback_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $reviewer_name = $reviewer_feedback_name;
        $this->user_type == "superadmin" ? $name = $reviewer_feedback_admin_name : $name = $editor_name;
        $title = $reviewer_feedback_article_title;
        $comments = $reviewer_feedback_comments;
        $link = $this->prepare_redirect_link($reviewer_feedback_article_link, 'view Detail');
        $id = $reviewer_feedback_article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %reviewer_name%
                                    %admin_name%
                                    %article_name%
                                    %reviewer_comments%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%reviewer_name%", $reviewer_name, $app_content);
        $app_content = str_replace("%admin_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%reviewer_comments%", $comments, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare author publish edition message.
     * @param array $email_params
     * @return string
     */
    public function prepare_author_publish_edition_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $publish_edition_corresponding_author_name;
        $admin_name = $publish_edition_article_super_admin_name;
        $title = $publish_edition_author_article_title;
        $link = $this->prepare_redirect_link($publish_edition_author_article_link, 'view Detail');
        $id = $publish_edition_author_article_id;
        $edition = $publish_edition_edition_title;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %edition_name%
                                    %article_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    %admin_name%
                                    Greetings author!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%edition_name%", $edition, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare superadmin publish edition message.
     * @param array $email_params
     * @return string
     */
    public function prepare_superadmin_publish_edition_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $article_data = $publish_edition_article_list_data;
        $edition = $publish_edition_edition_title;
        $article_list = $this->prepare_publish_edition_article_list($article_data, $edition);
        $admin_name = $publish_edition_article_super_admin_name;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %article_list%
                                    %edition_name%
                                    %signature%
                                    %admin_name%
                                    Greetings admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%article_list%", $article_list, $app_content);
        $app_content = str_replace("%edition_name%", $edition, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public   
     * @desc Prepare reviewer assign article message
     * @param array $email_params
     * @return string
     */
    public function prepare_reviewer_Assign_Article_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $assign_article_reviewer_name;
        $title = $reviewer_assign_article_title;
        $link = $this->prepare_redirect_link($article_link, 'view Detail');
        $id = $assign_article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %reviewer_name%
                                    %article_name%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%reviewer_name%", $name, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public   
     * @desc Prepare author editor comment Email Message
     * @param array $email_params
     * @return string
     */
    public function prepare_author_editor_review_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        ($this->user_type == "corresponding_author") ? $name = $editor_review_corresponding_author_name : $name = $editor_review_author_name;
        $title = $editor_review_author_article_title;
        $comments = $editor_review_comments;
        $link = $this->prepare_redirect_link($author_editor_review_article_link, 'view Detail');
        $id = $editor_review_author_article_id;
        $signature = $this->prepare_email_signature();
        $superadmin_name = $editor_review_super_admin_name;
        $editorName = $editor_name;
        $app_content = $this->template_data->body;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %editor_name%
                                    %editor_comments%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%admin_name%", $superadmin_name, $app_content);
        $app_content = str_replace("%editor_name%", $editorName, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%editor_comments%", $comments, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public   
     * @desc Prepare superadmin editor comment Email Message
     * @param array $email_params
     * @return string
     */
    public function prepare_superadmin_editor_review_email_message($email_params = array())
    {
        $name = "";
        extract($email_params);
        $name = $editor_review_corresponding_author_name;
        $superadmin_name = $editor_review_super_admin_name;
        $title = $editor_review_author_article_title;
        $comments = $editor_review_comments;
        $link = $this->prepare_redirect_link($editor_review_article_link, 'view Detail');
        $id = $editor_review_author_article_id;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;
        $editorName = $editor_name;

        $email_content_default = "  %author_name%
                                    %article_name%
                                    %admin_name%
                                    %editor_name%
                                    %editor_comments%
                                    %article_link%
                                    %signature%
                                    %article_id%
                                    Greetings Admin!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%author_name%", $name, $app_content);
        $app_content = str_replace("%editor_name%", $editorName, $app_content);
        $app_content = str_replace("%article_name%", $title, $app_content);
        $app_content = str_replace("%admin_name%", $superadmin_name, $app_content);
        $app_content = str_replace("%editor_comments%", $comments, $app_content);
        $app_content = str_replace("%article_link%", $link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%article_id%", $id, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare received new order email message
     * @param array $email_params
     * @return string
     */
    public function prepare_new_order_email_message($email_params = array())
    {
        extract($email_params);
        $customer_name = $new_order_customer_name;
        $new_order_orderId = $new_order_id;
        $admin_name = $new_order_admin_email;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;

        $email_content_default = "  %admin_name%
                                    %order_id%
                                    %signature%
                                    %username%
                                    Greetings user!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%order_id%", $new_order_orderId, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%username%", $customer_name, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare success transaction email message
     * @param array $email_params
     * @return string
     */
    public function prepare_success_order_email_message($email_params = array())
    {
        extract($email_params);
        $admin_name = $success_order_admin_name;
        $customer_name = $success_order_customer_name;
        $order_id = $success_order_invoice_id;
        $order_detail_link = $this->prepare_redirect_link($admin_success_order_link, 'view Order Detail');
        $customer_order_detail_link = $this->prepare_redirect_link($customer_success_order_link, 'view Order Detail');
        $signature = $this->prepare_email_signature();
        $product_name = $success_order_product_title;
        $gross_amount = $success_order_gross_amount;
        $vat_amount = $success_order_vat_amount;
        $total_amount = $success_order_total_amount;
        $currency = $success_order_currency;
        $payment_method = $success_order_payment_method;
        $quantity = $success_order_quantity;
        $payment_date = $success_order_payment_date;
        $app_content = $this->template_data->body;
        $customer_payment_detail = $this->prepare_customer_success_order_detail($order_id, $product_name, $gross_amount, $vat_amount, $total_amount);

        $email_content_default = "  %admin_name%
                                    %customer_name%
                                    %order_id%
                                    %order_detail_link%
                                    %customer_order_link%
                                    %signature%
                                    %product_name%
                                    %gross_amount%
                                    %vat_amount%
                                    %total_amount%
                                    %currency%
                                    %payment_method%
                                    %quantity%
                                    %payment_date%
                                    %payment_detail%
                                    Greetings user!<br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%admin_name%", $admin_name, $app_content);
        $app_content = str_replace("%customer_name%", $customer_name, $app_content);
        $app_content = str_replace("%order_id%", $order_id, $app_content);
        $app_content = str_replace("%order_detail_link%", $order_detail_link, $app_content);
        $app_content = str_replace("%customer_order_link%", $customer_order_detail_link, $app_content);
        $app_content = str_replace("%signature%", $signature, $app_content);
        $app_content = str_replace("%product_name%", $product_name, $app_content);
        $app_content = str_replace("%gross_amount%", $gross_amount, $app_content);
        $app_content = str_replace("%vat_amount%", $vat_amount, $app_content);
        $app_content = str_replace("%total_amount%", $total_amount, $app_content);
        $app_content = str_replace("%currency%", $currency, $app_content);
        $app_content = str_replace("%payment_method%", $payment_method, $app_content);
        $app_content = str_replace("%quantity%", $quantity, $app_content);
        $app_content = str_replace("%payment_date%", $payment_date, $app_content);
        $app_content = str_replace("%payment_detail%", $customer_payment_detail, $app_content);

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare new user credential function
     * @param array $email_params
     * @return string
     */
    public function prepare_new_user_credential($user_name, $password)
    {
        ob_start();
        ?>
        <ul style="margin: 0; width: 100%; float: left; list-style: none; font-size: 14px; line-height: 20px; padding: 0 0 15px; font-family: 'Work Sans', Arial, Helvetica, sans-serif;">
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none;">
            <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Email</strong>
            <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo e($user_name); ?></span>
            </li>
            <li style="width: 100%; float: left; line-height: inherit; list-style-type: none; background: #f7f7f7;">
                <strong style="width: 50%; float: left; padding: 10px; color: #333; font-weight: 400; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">Password</strong>
                <span style="width: 50%; float: left; padding: 10px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo e($password); ?></span>
            </li>
        </ul>
        <?php
        return ob_get_clean();
    }

    /**
     * @access public
     * @desc Prepare New Register user email message
     * @param array $email_params
     * @return string
     */
    public function prepare_new_register_user_email_message($email_params = array())
    {
        extract($email_params);
        $user_name = $new_user_name;
        $user_role = $new_user_role;
        $admin_name = $new_user_supper_admin_name;
        $site_title = $site_title;
        $account_edit_link = $this->prepare_redirect_link($user_edit_page_link, 'view Detail');
        $signature = $this->prepare_email_signature();
        $login_email = $login_email;
        $password = $new_user_password;
        $user_credentials = $this->prepare_new_user_credential($login_email, $password);
        $app_content = $this->template_data->body;
        $email_content_default = "  %admin_name%
                                    %site_name%
                                    %account_edit_link%
                                    %username%
                                    %user_role%
                                    %signature%
                                    %login_email%
                                    %password%
                                    %user_credentials%
                                    <br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%admin_name%", $admin_name, $app_content); //Replace Signature
        $app_content = str_replace("%site_name%", $site_title, $app_content); //Replace Signature
        $app_content = str_replace("%account_edit_link%", $account_edit_link, $app_content); //Replace Signature
        $app_content = str_replace("%username%", $user_name, $app_content); //Replace Signature
        $app_content = str_replace("%user_role%", $user_role, $app_content); //Replace Signature
        $app_content = str_replace("%signature%", $signature, $app_content); //Replace Signature
        $app_content = str_replace("%login_email%", $login_email, $app_content); //Replace Signature
        $app_content = str_replace("%password%", $password, $app_content); //Replace Signature
        $app_content = str_replace("%user_credentials%", $user_credentials, $app_content); //Replace Signature
        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

    /**
     * @access public
     * @desc Prepare update user password message
     * @param array $email_params
     * @return string
     */
    public function prepare_change_password_email_message($email_params = array())
    {
        extract($email_params);
        $user_name = $userName;
        $new_password = $newPassword;
        $user_email = $change_password_login_email;
        $signature = $this->prepare_email_signature();
        $app_content = $this->template_data->body;
        $email_content_default = "  %username%
                                    %password%
                                    %login_email%
                                    %signature%
                                    <br/>
									Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magniquae Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exommodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia desunt mollit anim id est laborum sed ut perspiciatis unde.<br/>
									';";
        //set default contents
        if (empty($app_content)) {
            $app_content = $email_content_default;
        }
        $app_content = str_replace("%username%", $user_name, $app_content); //Replace Signature
        $app_content = str_replace("%password%", $new_password, $app_content); //Replace Signature
        $app_content = str_replace("%login_email%", $user_email, $app_content); //Replace Signature
        $app_content = str_replace("%signature%", $signature, $app_content); //Replace Signature

        $body = "";
        $body .= $this->prepare_email_header();
        $body .= $app_content;
        $body .= $this->prepare_email_footer();
        return $body;
    }

}
