<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
use View;
use Illuminate\Support\Str;

class Helper extends Model
{

    /**
     * @access public
     * @param int $limit
     * @desc Generate randomn code For edition
     * @return int
     */
    public static function generateRandomCode($limit)
    {
        if (!empty($limit) && is_numeric($limit)) {
            return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
        }
    }

    /**
     * @access public
     * @param string $status
     * @desc Display reviewer comment status
     * @return string
     */
    public static function displayReviewerCommentStatus($status)
    {
        if (!empty($status) && is_string($status)) {
            $commentStatus = "";
            if ($status == "minor_revisions") {
                $commentStatus = "Minor Revision";
            } else if ($status == "major_revisions") {
                $commentStatus = "Major Revision";
            } else if ($status == "rejected") {
                $commentStatus = "Rejected";
            } else {
                $commentStatus = "Approved";
            }

            return $commentStatus;
        }
    }

    /**
     * @access public
     * @desc regenerate image sizes
     * @return array
     */
    public static function predefined_regenerate_sizes()
    {
        $list = array(
            'img_thumb' => array(
                'key' => 'thumb',
                'size' => '200x200',
                'width' => '200',
                'height' => '200',
            ),
            'img_medium' => array(
                'key' => 'medium',
                'size' => '300x300',
                'width' => '300',
                'height' => '300',
            ),
        );

        return $list;
    }

    /**
     * @access public
     * @param string $title
     * @desc Display reviewer comment status
     * @return string
     */
    public static function displayArticleBreadcrumbsTitle($title)
    {
        if (!empty($title)) {
            $breadcrumbs_title = "";
            if ($title == "minor_revisions") {
                $breadcrumbs_title = "minor-revision";
            } elseif ($title == "major_revisions") {
                $breadcrumbs_title = "major-revision";
            } elseif ($title == "rejected") {
                $breadcrumbs_title = "rejected";
            } elseif ($title == "articles_under_review") {
                $breadcrumbs_title = "under-review";
            } else {
                $breadcrumbs_title = "approved";
            }

            return $breadcrumbs_title;
        }
    }

    /**
     * @access public
     * @param string $title
     * @desc Set article url status segment
     * @return string
     */
    public static function setArticleMenuParameter($title)
    {
        if (!empty($title)) {
            $status = "";
            if ($title == "minor_revisions") {
                $status = "minor-revisions";
            } elseif ($title == "major_revisions") {
                $status = "major-revisions";
            } elseif ($title == "rejected") {
                $status = "rejected";
            } elseif ($title == "articles_under_review") {
                $status = "articles-under-review";
            } elseif ($title == "accepted_articles") {
                $status = "accepted-articles";
            }

            return $status;
        }
    }

    /**
     * @access public
     * @param string $string
     * @desc Get acronym
     * @return $string
     */
    public static function getAcronym($string)
    {
        if (!empty($string)) {
            $acronym = "";
            $parts = preg_split("/\s+/", $string);
            foreach ($parts as $w) {
                $acronym .= ucfirst(substr($w[0], 0, 1));
            }
            return $acronym;
        }
    }

    /**
     * @access public
     * @param int $user_id
     * @param string $image
     * @param string $size
     * @desc Get user image
     * @return string
     */
    public static function getUserImage($user_id, $image, $size = "")
    {
        if (!empty($user_id)) {
            if (!empty($image)) {
                if (!empty($size)) {
                    return 'uploads/users/' . $user_id . '/' . $size . '-' . $image;
                } else {
                    return 'uploads/users/' . $user_id . '/' . $image;
                }
            } else {
                return "images/no-profile-img.jpg";
            }
        }
    }

    /**
     * @access public
     * @param string $status
     * @desc Get article page title
     * @return string
     */
    public static function DashboardArticlePageTitle($status)
    {
        if (!empty($status)) {
            $page_title = "";
            if ($status == "rejected") {
                $page_title = trans('prs.rejected_articles');
            } elseif ($status == "minor-revisions") {
                $page_title = trans('prs.minor_revisions');
            } elseif ($status == "major-revisions") {
                $page_title = trans('prs.major_revisions');
            } elseif ($status == "accepted-articles") {
                $page_title = trans('prs.accpeted_articles');
            } else {
                $page_title = trans('prs.article_under_review');
            }
            return $page_title;
        }
    }

    /**
     * @access public
     * @desc Get social media data
     * @return array
     */
    public static function getSocialData()
    {
        $social = array(
            'facebook' => array(
                'title' => 'Facebook',
                'color' => '#3b5999',
                'icon' => 'fa-facebook',
            ),
            'twitter' => array(
                'title' => 'Twitter',
                'color' => '#55acee',
                'icon' => 'fa-twitter',
            ),
            'linkedin' => array(
                'title' => 'Linkedin',
                'color' => '#0077B5',
                'icon' => 'fa-linkedin',
            ),
            'googleplus' => array(
                'title' => 'Google Plus',
                'color' => '#dd4b39',
                'icon' => 'fa-google-plus',
            )
        );
        return $social;
    }

    /**
     * @access public
     * @desc Get status static list
     * @return array
     */
    public static function statusStaticList()
    {
        $status = array('articles_under_review', 'accepted_articles', 'major_revisions', 'minor_revisions', 'rejected');
        return $status;
    }

    /**
     * @access public
     * @param array $data
     * @desc Chaneg the .env file Data.
     * @return array
     */
    public static function changeEnv($data = array())
    {
        if (count($data) > 0) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach ((array)$data as $key => $value) {

                // Loop through .env-data
                foreach ($env as $env_key => $env_value) {

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if ($entry[0] == $key) {
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @access public
     * @param string $code
     * @desc Currency list
     * @return array
     */
    public static function currencyList($code = "")
    {
        $currency_array = array(
            'USD' => array (
                'numeric_code'  => 840 ,
                'code'          => 'USD' ,
                'name'          => 'United States dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent[D]' ,
                'decimals'      => 2 ) ,
            'AUD' => array (
                'numeric_code'  => 36 ,
                'code'          => 'AUD' ,
                'name'          => 'Australian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'BRL' => array (
                'numeric_code'  => 986 ,
                'code'          => 'BRL' ,
                'name'          => 'Brazilian real' ,
                'symbol'        => 'R$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'CAD' => array (
                'numeric_code'  => 124 ,
                'code'          => 'CAD' ,
                'name'          => 'Canadian dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'CZK' => array (
                'numeric_code'  => 203 ,
                'code'          => 'CZK' ,
                'name'          => 'Czech koruna' ,
                'symbol'        => 'Kc' ,
                'fraction_name' => 'Haléř' ,
                'decimals'      => 2 ) ,
            'DKK' => array (
                'numeric_code'  => 208 ,
                'code'          => 'DKK' ,
                'name'          => 'Danish krone' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Øre' ,
                'decimals'      => 2 ) ,
            'EUR' => array (
                'numeric_code'  => 978 ,
                'code'          => 'EUR' ,
                'name'          => 'Euro' ,
                'symbol'        => '€' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'HKD' => array (
                'numeric_code'  => 344 ,
                'code'          => 'HKD' ,
                'name'          => 'Hong Kong dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'HUF' => array (
                'numeric_code'  => 348 ,
                'code'          => 'HUF' ,
                'name'          => 'Hungarian forint' ,
                'symbol'        => 'Ft' ,
                'fraction_name' => 'Fillér' ,
                'decimals'      => 2 ) ,
            'ILS' => array (
                'numeric_code'  => 376 ,
                'code'          => 'ILS' ,
                'name'          => 'Israeli new sheqel' ,
                'symbol'        => '₪' ,
                'fraction_name' => 'Agora' ,
                'decimals'      => 2 ) ,
            'INR' => array (
                'numeric_code'  => 356 ,
                'code'          => 'INR' ,
                'name'          => 'Indian rupee' ,
                'symbol'        => 'INR' ,
                'fraction_name' => 'Paisa' ,
                'decimals'      => 2 ) ,
            'JPY' => array (
                'numeric_code'  => 392 ,
                'code'          => 'JPY' ,
                'name'          => 'Japanese yen' ,
                'symbol'        => '¥' ,
                'fraction_name' => 'Sen[G]' ,
                'decimals'      => 2 ) ,
            'MYR' => array (
                'numeric_code'  => 458 ,
                'code'          => 'MYR' ,
                'name'          => 'Malaysian ringgit' ,
                'symbol'        => 'RM' ,
                'fraction_name' => 'Sen' ,
                'decimals'      => 2 ) ,
            'MXN' => array (
                'numeric_code'  => 484 ,
                'code'          => 'MXN' ,
                'name'          => 'Mexican peso' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'NOK' => array (
                'numeric_code'  => 578 ,
                'code'          => 'NOK' ,
                'name'          => 'Norwegian krone' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Øre' ,
                'decimals'      => 2 ) ,
            'NZD' => array (
                'numeric_code'  => 554 ,
                'code'          => 'NZD' ,
                'name'          => 'New Zealand dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'PHP' => array (
                'numeric_code'  => 608 ,
                'code'          => 'PHP' ,
                'name'          => 'Philippine peso' ,
                'symbol'        => 'PHP' ,
                'fraction_name' => 'Centavo' ,
                'decimals'      => 2 ) ,
            'PLN' => array (
                'numeric_code'  => 985 ,
                'code'          => 'PLN' ,
                'name'          => 'Polish złoty' ,
                'symbol'        => 'zł' ,
                'fraction_name' => 'Grosz' ,
                'decimals'      => 2 ) ,
            'GBP' => array (
                'numeric_code'  => 826 ,
                'code'          => 'GBP' ,
                'name'          => 'British pound[C]' ,
                'symbol'        => '£' ,
                'fraction_name' => 'Penny' ,
                'decimals'      => 2 ) ,
            'SGD' => array (
                'numeric_code'  => 702 ,
                'code'          => 'SGD' ,
                'name'          => 'Singapore dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'SEK' => array (
                'numeric_code'  => 752 ,
                'code'          => 'SEK' ,
                'name'          => 'Swedish krona' ,
                'symbol'        => 'kr' ,
                'fraction_name' => 'Öre' ,
                'decimals'      => 2 ) ,
            'CHF' => array (
                'numeric_code'  => 756 ,
                'code'          => 'CHF' ,
                'name'          => 'Swiss franc' ,
                'symbol'        => 'Fr' ,
                'fraction_name' => 'Rappen[I]' ,
                'decimals'      => 2 ) ,
            'TWD' => array (
                'numeric_code'  => 901 ,
                'code'          => 'TWD' ,
                'name'          => 'New Taiwan dollar' ,
                'symbol'        => '$' ,
                'fraction_name' => 'Cent' ,
                'decimals'      => 2 ) ,
            'THB' => array (
                'numeric_code'  => 764 ,
                'code'          => 'THB' ,
                'name'          => 'Thai baht' ,
                'symbol'        => '฿' ,
                'fraction_name' => 'Satang' ,
                'decimals'      => 2 ) ,
            'RUB' => array (
                'numeric_code'  => 643 ,
                'code'          => 'RUB' ,
                'name'          => 'Russian ruble' ,
                'symbol'        => 'руб.' ,
                'fraction_name' => 'Kopek' ,
                'decimals'      => 2 ) ,
        );

        if (!empty($code) && array_key_exists($code, $currency_array)) {
            return $currency_array[$code];
        } else {
            return $currency_array;
        }
    }

    /**
     * @access public
     * @desc Get payment mode list
     * @return array
     */
    public static function productModeList()
    {
        return array('free' => trans('prs.free'), 'individual-product' => trans('prs.individual_product'));
    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get product price
     * @return string
     */
    public static function getProductPrice($article_id)
    {
        if (!empty($article_id) && is_numeric($article_id)) {
            $article = Article::select('price')->where('id', $article_id)->first();
            if (!empty($article)) {
                $default_price = "";
                $default_price = Article::getEditionPriceByAssignArticle($article_id);
                return !empty($article->price) ? $article->price : $default_price[0]->edition_price;
            }
        }
    }

    /**
     * @access public
     * @param string $currency
     * @desc Get currency symbol
     * @return string
     */
    public static function getCurrencySymbol($currency)
    {
        if (!empty($currency)) {
            $serialize_array = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'payment_settings')->get()->first();
            if (!empty($serialize_array)) {
                $payment_setting = !empty($serialize_array) ? unserialize($serialize_array->meta_value) : '';
                $currency_symbol = self::currencyList($payment_setting[0]['currency']);
                return $payment_setting[0]['currency'] == $currency ? $currency_symbol['symbol'] : "";
            }
        }
    }

    /**
     * @access public
     * @desc Get sale tax value from database
     * @return int
     */
    public static function getSaleTax()
    {
        $serialize_array = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'payment_settings')->get()->first();
        if (!empty($serialize_array)) {
            $payment_setting = !empty($serialize_array) ? unserialize($serialize_array->meta_value) : '';
            return $payment_setting[0]['vat'];
        }
    }

    /**
     * @access public
     * @param int $sale_tax
     * @param int $subtotal
     * @desc Calculate sales tax
     * @return double
     */
    public static function calculateSaleTax($sale_tax, $subtotal)
    {
        if (!empty($sale_tax) && !empty($subtotal)) {
            return ($sale_tax / 100) * $subtotal;
        } else {
            return 0.00;
        }
    }

    /**
     * @access public
     * @param int $sale_tax
     * @param int $subtotal
     * @desc Calculate grandTotal of the product
     * @return int
     */
    public static function calculateGrandTotal($sale_tax, $subtotal)
    {
        if (!empty($sale_tax) && !empty($subtotal)) {
            return $sale_tax + $subtotal;
        } else {
            return $subtotal;
        }
    }

    /**
     * @access public
     * @desc Get super-admin data
     * @return string
     */
    public static function getSuperAdmin()
    {
        $super_admin = "";
        $user = Auth::user();
        if (!empty($user)) {
            $user_roles_type = User::getUserRoleType($user->id);
            if ($user_roles_type->role_type == 'superadmin') {
                $super_admin = 'superadmin';
            }
        }
        return $super_admin;
    }

    /**
     * @access public
     * @desc Display social icons
     * @return string
     */
    public static function displaySocials()
    {
        $output = "";
        $social_unserialize_array = SiteManagement::getMetaValue('socials');
        $social_list = Helper::getSocialData();
        if (!empty($social_unserialize_array)) {
            $output .= "<ul class='sj-socialicons sj-socialiconssimple'>";
            foreach ($social_unserialize_array as $key => $value) {
                if (array_key_exists($value['title'], $social_list)) {
                    $socialList = $social_list[$value['title']];
                    $output .= "<li class='sj-{$value['title']}'><a href = 'https://{$value["url"]}' target = '_blank' ><i class='fa {$socialList["icon"]}' ></i></a></li>";
                }
            }
            $output .= "</ul>";
        }
        echo $output;
    }

    /**
     * @access public
     * @param int $page_id
     * @desc Display article menu
     * @return string
     */
    public static function displayArticleMenu($page_id = "")
    {
        $output = "";
        $dashboard = '';
        $active_class = '';
        $user_roles_type = User::getUserRoleType(Auth::user()->id);
        $status = array(
            "sync" => "articles-under-review",
            "spell-check" => "accepted-articles",
            "undo" => "minor-revisions",
            "unlink" => "major-revisions",
            "cross" => "rejected"
        );
        if ($user_roles_type->role_type == 'superadmin' || $user_roles_type->role_type == 'editor') {
            $dashboard = 'dashboard';
        } else {
            $dashboard = 'user';
        }
        foreach ($status as $key => $s) {
            if (!empty($page_id)) {
                $active_class = $page_id == $s ? 'class="sj-active"' : '';
            }
             $link = url('/' . $user_roles_type->role_type . '/' . $dashboard . '/' . Auth::user()->id . '/' . $s);
            $output .= "<li $active_class>";
            $output .= "<a href='$link'>";
            $output .= "<i class='lnr lnr-$key'></i><span>" . self::DashboardArticlePageTitle($s) . "</span>";
            $output .= "</a>";
            $output .= "</li>";
        }
        echo $output;
    }

    /**
     * @access public
     * @desc Set status from url
     * @return string
     */
    public static function getMenuStatus($status)
    {
        if ($status == "articles-under-review") {
            $status = "articles_under_review";
        } elseif ($status == "accepted-articles") {
            $status = "accepted_articles";
        } elseif ($status == "minor-revisions") {
            $status = "minor_revisions";
        } elseif ($status == "minor-revisions") {
            $status = "minor_revisions";
        } elseif ($status == "major-revisions") {
            $status = "major_revisions";
        }
        return $status;
    }

    /**
     * @access public
     * @desc Get page author
     * @return string
     */
    public static function getPageAuthor()
    {
        $page_author = '';
        $user_roles_type = User::getUserRoleType(Auth::user()->id);
        if ($user_roles_type->role_type == 'superadmin') {
            $page_author = 'superadmin';
        } else {
            $page_author = 'editor';
        }

        return $page_author;
    }

    /**
     * @access public
     * @desc Diaplay email warning
     * @return string
     */
    public static function displayEmailWarning()
    {
        $output = "";
        if (empty(env('MAIL_USERNAME'))
            || empty(env('MAIL_PASSWORD'))
            && auth()->user()->getRoleNames()->first() == 'super admin'
        ) {
            $output .= '<div class="toast-holder">';
            $output .= '<div id="toast-container">';
            $output .= '<div class="alert toast-danger alart-message alert-dismissible fade show fixed_message">';
            $output .= '<div class="toast-message">';
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $output .= '<span aria-hidden="true">&times;</span></button>';
            $output .= trans('prs.ph_email_warning');
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }
        echo $output;
    }

    /**
     * @access public
     * @desc Static email type list
     * @return array
     */
    public static function emailTypeList()
    {
        $types = array(
            '0' => array(
                'title' => trans('prs.new_article'),
                'value' => 'new_article'
            ),
            '1' => array(
                'title' => trans('prs.assign_reviewer'),
                'value' => 'assign_reviewer',
            ),
            '2' => array(
                'title' => trans('prs.resubmit_article'),
                'value' => 'resubmit_article',
            ),
            '3' => array(
                'title' => trans('prs.reviewer_feedback'),
                'value' => 'reviewer_feedback',
            ),
            '4' => array(
                'title' => trans('prs.accepted_editor_feedback'),
                'value' => 'accepted_articles_editor_feedback',
            ),
            '5' => array(
                'title' => trans('prs.rejected_editor_feedback'),
                'value' => 'rejected_editor_feedback',
            ),
            '6' => array(
                'title' => trans('prs.minor_editor_feedback'),
                'value' => 'minor_revisions_editor_feedback',
            ),
            '7' => array(
                'title' => trans('prs.major_editor_feedback'),
                'value' => 'major_revisions_editor_feedback',
            ),
            '8' => array(
                'title' => trans('prs.publish_edition'),
                'value' => 'publish_edition',
            ),
            '9' => array(
                'title' => trans('prs.new_user'),
                'value' => 'new_user',
            ),
            '10' => array(
                'title' => trans('prs.change_pswd'),
                'value' => 'change_password',
            ),
            '11' => array(
                'title' => trans('prs.new_ord_rec'),
                'value' => 'new_order',
            ),
            '12' => array(
                'title' => trans('prs.successful_ord'),
                'value' => 'success_order',
            ),
        );
        return $types;
    }

    /**
     * @access public
     * @param int $user_id
     * @param string $status
     * @desc Get article email redirect link based on user type
     * @return string
     */
    public static function getArticleEmailRedirectLink($user_id, $status = "")
    {
        if (!empty($user_id && is_numeric($user_id))) {
            $role = User::getUserRoleType($user_id);
            if ($role->role_type == 'superadmin' || $role->role_type == 'editor') {
                if (!empty($status)) {
                    return redirect::to(url($role->role_type . '/dashboard/' . $user_id . '/' . $status));
                } else {
                    return redirect::to(url($role->role_type . '/dashboard/' . $user_id . '/articles-under-review'));
                }
            } elseif ($role->role_type == 'author' || $role->role_type == 'reviewer') {
                if (!empty($status)) {
                    return redirect::to(url($role->role_type . '/user/' . $user_id . '/' . $status));
                } else {
                    return redirect::to(url($role->role_type . '/user/' . $user_id . '/articles-under-review'));
                }
            } else {
                if (!empty($status)) {
                    return redirect::to(url('author/user/' . $user_id . '/' . $status));
                } else {
                    return redirect::to(url('author/user/' . $user_id . '/articles-under-review'));
                }
            }
        }
    }

    /**
     * @access public
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public static function journal_is_demo_site($message = '')
    {
        $json = array();
        $message = !empty($message) ? $message : trans('prs.restricted_text');
        if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'amentotech.com') {
            //abort('404',$message);
            return $message;
        }
    }

    /**
     * @access public
     * @param string $message
     * @return string
     */
    public static function ajax_journal_is_demo_site($message = '')
    {
        $server_error = "Sorry! you are restricted to perform this action on demo site.";
        if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] === 'amentotech.com') {
            return response()->json(['message' => $server_error]);
        }
    }

    /**
     * @access public
     * @param int $id
     * @param string $size
     * @desc Get edition image
     * @return string
     */
    public static function getEditionImage($id, $size = "")
    {
        $edition = "";
        if (!empty($id)) {
            $edition = DB::table('editions')->select('edition_cover')
                ->where('id', $id)->get()->first();
            if (!empty($edition->edition_cover)) {
                if (!empty($size)) {
                    $image =  $size . '-' . $edition->edition_cover;
                    return 'uploads/editions/' . $id . '/' . $image;
                } else {
                    return 'uploads/editions/' . $id . '/' . $edition->edition_cover;
                }
            } elseif (!empty($size)) {
                return 'uploads/editions/' . $size . '-edition_image.jpg';
            } else {
                return 'uploads/editions/edition_image.jpg';
            }
        }
    }

    /**
     * Get site title from storage
     *
     * @return void
     */
    public static function displayProjectTitle()
    {
        $title = SiteManagement::getMetaValue('site_title');
        return $title[0]['site_title'];
    }

    /**
     * Language list
     *
     * @param string $lang lang
     *
     * @access public
     *
     * @return array
     */
    public static function getTranslatedLang($lang="")
    {
        $languages = array(
            'en' => array(
                'code' => 'en',
                'title' => 'English',
            ),
            'tr' => array(
                'code' => 'tr',
                'title' => 'Turkish',
            ),
            'es' => array(
                'code' => 'es',
                'title' => 'Spanish',
            ),
            'pt' => array(
                'code' => 'pt',
                'title' => 'Portuguese',
            ),
            'fr' => array(
                'code' => 'fr',
                'title' => 'French',
            ),
        );

        if (!empty($lang) && array_key_exists($lang, $languages)) {
            return $languages[$lang];
        } else {
            return $languages;
        }
    }

    /**
     * Display socials
     *
     * @access public
     *
     * @return array
     */
    public static function getBodyLangClass()
    {
        $body_lang_class = DB::table('sitemanagements')->where('meta_key', 'body-lang-class')->select('meta_value')->pluck('meta_value')->first();
        return !empty($body_lang_class) ? $body_lang_class : '';

    }
}
