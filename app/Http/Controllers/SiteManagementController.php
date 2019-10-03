<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use App\Helper;
use App\SiteManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Storage;
use App\UploadMedia;
use Auth;
use App\User;
use App\Page;
use Validator;
use Intervention\Image\Facades\Image;
use File;

class SiteManagementController extends Controller
{
    /**
     * @access protected
     * @var array $pages
     */
    protected $pages;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Page $pages)
    {
        $this->middleware(['auth', 'isAdmin']);
        $this->pages = $pages;
    }

    /**
     * @access public
     * @desc Display a list of site settings
     * @return \Illuminate\Http\Response
     */
    public function index($userRole = "")
    {
        $social_list = Helper::getSocialData();
        $social_unSerialize_array = SiteManagement::getMetaValue('socials');
        $slide_unSerialize_array = SiteManagement::getMetaValue('slides');
        $welcome_slide_unserialize_array = SiteManagement::getMetaValue('welcome_slides');
        $successfactor = SiteManagement::getMetaValue('success_data');
        $reg_data = SiteManagement::getMetaValue('reg_data');
        $notice_board = SiteManagement::getMetaValue('notices');
        $languages = array_pluck(Helper::getTranslatedLang(), 'title', 'code');
        $selected_language = DB::table('sitemanagements')->where('meta_key', 'language')->select('meta_value')->pluck('meta_value')->first();
        $contactinfo = SiteManagement::getMetaValue('contact_info');
        $about_us_note = SiteManagement::getMetaValue('about_us');
        $page = Page::getPageList();
        $welcome_page = SiteManagement::getMetaValue('pages');
        $page_data = SiteManagement::getMetaValue('r_menu_pages');
        $stored_site_title = SiteManagement::getMetaValue('site_title');
        $site_title = !empty($stored_site_title) ? $stored_site_title[0]['site_title'] : '';
        $editor_id = Auth::user()->id;
        $user_role_type = User::getUserRoleType($editor_id);
        $user_role = $user_role_type->role_type;
        $stored_keywords = SiteManagement::getMetaValue('keywords');
        $keywords = !empty($stored_keywords) ? $stored_keywords : "";

        return View::make(
            'admin.cms.index',
            compact(
                'social_list',
                'editor_id',
                'social_unSerialize_array',
                'slide_unSerialize_array',
                'user_role',
                'page',
                'page_data',
                'notice_board',
                'successfactor',
                'contactinfo',
                'about_us_note',
                'welcome_page',
                'site_title',
                'reg_data',
                'welcome_slide_unserialize_array',
                'languages',
                'selected_language',
                'keywords'
            )
        );
    }

    /**
     * @access public
     * @desc Store a social settings in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $socials = $request['social'];
        if (!empty($socials)) {
            foreach ($socials as $key => $value) {
                if (($value['title'] == 'select social icon' || $value['url'] == null)) {
                    Session::flash('error', 'title and url Fields are required');
                    return Redirect::back();
                } elseif (!preg_match(
                    "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",
                    $value['url']
                )) {
                    Session::flash('error', 'Please enter valid url');
                    return Redirect::back();
                }
            }
            $existing_social = SiteManagement::getMetaValue('socials');
            if (!empty($existing_social)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'socials')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'socials', 'meta_value' => serialize($socials),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Socials Save Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store a home slider settings in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSlidesData(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $filePath = 'uploads/slider/images/';
        $slides = $request['slide'];
        $slide_data_array = array();
        if (!empty($slides)) {
            foreach ($slides as $slide_key => $slide_data) {
                if (!empty($slide_data['title']) && !empty($slide_data['desc'])) {
                    $filename = '';
                    if (array_key_exists('image', $slide_data)) {
                        $filename = $slide_data['image']->getClientOriginalName();
                        $slide_data['image']->move($filePath, $filename);

                    } elseif (array_key_exists('hidden_image', $slide_data)) {
                        $filename = $slide_data['hidden_image'];
                    } else {
                        Session::flash('error', 'Image Field is required');
                        return Redirect::back();
                    }
                    $slide_data_array[$slide_key]['slide_title'] = $slide_data['title'];
                    $slide_data_array[$slide_key]['slide_desc'] = $slide_data['desc'];
                    $slide_data_array[$slide_key]['slide_image'] = $filename;
                } elseif (array_key_exists('image', $slide_data) || array_key_exists('hidden_image', $slide_data)) {
                    Session::flash('error', 'title and description Fields are required');
                    return Redirect::back();
                }
            }
            $existing_slides = SiteManagement::getMetaValue('slides');
            if (!empty($existing_slides)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'slides')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'slides', 'meta_value' => serialize($slide_data_array),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Slides Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store a welcome slider settings in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWelcomeSlidesData(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $filePath = 'uploads/settings/welcome_slider/';
        $slider_image = $request['slide'];
        $welcome_slide_data_array = array();
        if (!empty($slider_image)) {
            foreach ($slider_image as $slide_key => $slide_data) {
                if (array_key_exists('welcome_image', $slide_data)) {
                    $filename = '';
                    $filename = $slide_data['welcome_image']->getClientOriginalName();
                    $slide_data['welcome_image']->move($filePath, $filename);
                    $welcome_slide_data_array[$slide_key]['welcome_slide_image'] = $filename;
                } elseif (array_key_exists('welcome_hidden_image', $slide_data)) {
                    $filename = $slide_data['welcome_hidden_image'];
                    $welcome_slide_data_array[$slide_key]['welcome_slide_image'] = $filename;
                } else {
                    Session::flash('error', 'Image Field is required');
                    return Redirect::back();
                }
            }
        }
        $existing_slides = SiteManagement::getMetaValue('welcome_slides');
        if (!empty($existing_slides)) {
            DB::table('sitemanagements')->where('meta_key', '=', 'welcome_slides')->delete();
        }
        DB::table('sitemanagements')->insert(
            [
                'meta_key' => 'welcome_slides', 'meta_value' => serialize($welcome_slide_data_array),
                "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
            ]
        );
        Session::flash('success', 'Welcome Slides Saved Successfully');
        return Redirect::back();
    }

    /**
     * @access public
     * @desc Store a welcome page data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePages(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $page_id = $request['page'];
        $existingPages = SiteManagement::getMetaValue('pages');
        if (!empty($existingPages)) {
            DB::table('sitemanagements')->where('meta_key', '=', 'pages')->delete();
        }
        if (!empty($page_id)) {
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'pages', 'meta_value' => serialize($page_id),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Welcome Page Selected Successfully');
            return Redirect::back();
        } else {
            Session::flash('success', 'Select the Welcome Page');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store resource Widget data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResourceMenuPages(Request $request)
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
        $r_pages = $request['page'];
        $pages = array();
        $existing_r_menu_p = SiteManagement::getMetaValue('r_menu_pages');
        if (!empty($existing_r_menu_p)) {
            DB::table('sitemanagements')->where('meta_key', '=', 'r_menu_pages')->delete();
        }
        if (!empty($r_pages)) {
            foreach ($r_pages as $page) {
                $pages[] = DB::table('pages')->select('title','slug')->where('slug', $page)->get()->first();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'r_menu_pages', 'meta_value' => serialize($r_pages),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            return response()->json(['message' => 'Saved Successfully', 'pages'=> $pages]);
        } else {
            return response()->json(['message' => 'Select Pages']);
        }
    }

    /**
     * @access public
     * @desc Store success factors Widget data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSuccessFactors(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $data = $request['success_data'];
        $success_data_array = array();
        if (!empty($data)) {
            $existing_success_data = SiteManagement::getMetaValue('success_data');
            if (!empty($existing_success_data)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'success_data')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'success_data', 'meta_value' => serialize($data),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Success Factors Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store registration page data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRegSettings(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $data = $request['reg_data'];
        if (!empty($data)) {
            $existing_reg_data = SiteManagement::getMetaValue('reg_data');
            if (!empty($existing_reg_data)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'reg_data')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'reg_data', 'meta_value' => serialize($data),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Register Page Settings Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store contact info in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeContactInfo(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $contact_info = $request['contact_info'];
        if (!empty($contact_info)) {
            $existing_info = SiteManagement::getMetaValue('contact_info');
            if (!empty($existing_info)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'contact_info')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'contact_info', 'meta_value' => serialize($contact_info),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Contact Information Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store notice board data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNotices(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $notices = $request['notice_board'];
        if (!empty($notices)) {
            $existing_notice_data = SiteManagement::getMetaValue('notices');
            if (!empty($existing_notice_data)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'notices')->delete();
            }

            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'notices', 'meta_value' => serialize($notices),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Notice Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store about us widget data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAboutUsNote(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $about_us = $request['about_us'];
        if (!empty($about_us)) {
            $existing_about_widget = SiteManagement::getMetaValue('about_us');
            if (!empty($existing_about_widget)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'about_us')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'about_us', 'meta_value' => serialize($about_us),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'About Us Note Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store advertisement widget data in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAdvertise(Request $request)
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['error'] = $server->getData()->message;
            return $response;
        }
        $existing_advertise = SiteManagement::getMetaValue('advertisement');
        if ($existing_advertise) {
            DB::table('sitemanagements')->where('meta_key', '=', 'advertisement')->delete();
        }
        $file = Input::file('attachment_file');
        if (!empty($file)) {
            $file_original_name = $file->getClientOriginalName();
            $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
            // getting image extension
            $extension = $file->getClientOriginalExtension();
            if ($extension === "jpg" || $extension === "png") {
                $filename = $file_name_without_extension . '-' . time() . '.' . $extension;
                $file->move('uploads/settings/', $filename);
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'advertisement', 'meta_value' => $filename,
                        "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                    ]
                );
                $response = array();
                $image = UploadMedia::getImageName($filename);
                $message = trans('prs.img_upload_success');
                $response['image_name'] = $image;
                $response['message'] = $message;
                $response['url'] = url('/uploads/settings/' . $filename);
                return $response;
            } else {
                $message = trans('image must jpg or png type');
                $response['error'] = $message;
                return $response;
            }
        } else {
            $message = trans('image required');
            $response['error'] = $message;
            return $response;
        }
    }

    /**
     * @access public
     * @desc Store logo in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeLogo(Request $request)
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['error'] = $server->getData()->message;
            return $response;
        }
        $file = Input::file('attachment_file');
        if (!empty($file)) {
            $sizes = Helper::predefined_regenerate_sizes();
            $existing_logo = SiteManagement::getMetaValue('logo');
            if ($existing_logo) {
                DB::table('sitemanagements')->where('meta_key', '=', 'logo')->delete();
            }
            $file_original_name = $file->getClientOriginalName();
            $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
            // getting image extension
            $extension = $file->getClientOriginalExtension();
            if ($extension === "jpg" || $extension === "png") {
                $filename = $file_name_without_extension . '-' . time() . '.' . $extension;
                $file->move('uploads/logo/', $filename);
                DB::table('sitemanagements')->insert(
                    ['meta_key' => 'logo', 'meta_value' => $filename, "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()]
                );
                $response = array();
                $image = UploadMedia::getImageName($filename);
                $message = trans('prs.img_upload_success');
                $response['image_name'] = $image;
                $response['message'] = $message;
                $response['url'] = url('/uploads/logo/' . $filename);
                $response['type'] = 'logo_update';
                return $response;
            } else {
                $message = trans('image must jpg or png type');
                $response['error'] = $message;
                return $response;
            }
        } else {
            $message = trans('logo required');
            $response['error'] = $message;
            return $response;
        }
    }

    /**
     * @access public
     * @desc Get logo from storage.
     * @return string
     */
    public function getSiteLogo()
    {
        $response = array();
        $requested_image = DB::table('sitemanagements')->where('meta_key', 'logo')->select('meta_value')->get()->first();
        if (!empty($requested_image)) {
            $image = UploadMedia::getImageName($requested_image->meta_value);
            $response['image'] = $image;
            return $response;
        } else {
            $message = trans('prs.no_image');
            $response['error'] = $message;
            return $response;
        }
    }

    /**
     * @access public
     * @desc Get advertisement image from storage.
     * @return string
     */
    public function getAdvertise()
    {
        $response = array();
        $requested_image = DB::table('sitemanagements')->where('meta_key', 'advertisement')->select('meta_value')->get()->first();
        if (!empty($requested_image)) {
            $image = UploadMedia::getImageName($requested_image->meta_value);
            $response['image'] = $image;
            return $response;
        } else {
            $message = trans('prs.no_image');
            $response['error'] = $message;
            return $response;
        }
    }

    /**
     * @access public
     * @desc Delete Logo from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroySiteLogo()
    {
        $json = array();
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        DB::table('sitemanagements')->where('meta_key', '=', 'logo')->delete();
        $json['message'] = trans('prs.img_delete_success');
        $json['type'] = 'logo_delete';
        return $json;
        //return $message;
    }

    /**
     * @access public
     * @desc Delete advertisement image from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroyAdvertise()
    {
        $json = array();
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        DB::table('sitemanagements')->where('meta_key', '=', 'advertisement')->delete();
        $message = "Image Deleted Successfully";
        $json['type'] = 'success';
        $json['message'] = $message;
        return $json;
    }

    /**
     * @access public
     * @desc Show the form for storing payment setting in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setPaymentSetting()
    {
        $currency = Helper::currencyList();
        $product_mode = Helper::productModeList();
        $existing_payment_settings = SiteManagement::getMetaValue('payment_settings');
        $existing_product_mode = SiteManagement::getMetaValue('payment_mode');
        return View::make(
            'admin.cms.payment_settings',
            compact('currency', 'existing_payment_settings', 'product_mode', 'existing_product_mode')
        );
    }

    /**
     * @access public
     * @desc Set payment mode.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProductType(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $payment_mode = $request['payment_mode'];
        if (!empty($payment_mode)) {
            $existing_payment_mode = SiteManagement::getMetaValue('payment_mode');
            if (!empty($existing_payment_mode)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'payment_mode')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'payment_mode', 'meta_value' => serialize($payment_mode),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );

            Session::flash('success', 'Payment Setting Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Store paypal payment settings in storage and
     * update payment settings in env file.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePaymentSetting(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $this->validate(
            $request, [
                'client_id' => 'required',
                'paypal_password' => 'required',
                'paypal_secret' => 'required',
            ]
        );
        $client_id = $request['client_id'];
        $paypal_password = $request['paypal_password'];
        $paypal_secret = $request['paypal_secret'];
        $currency = "";
        $vat = "";
        if ($request['currency']) {
            $currency = $request['currency'];
        }
        if ($request['vat']) {
            $vat = $request['vat'];
        }
        $payment_type = $request['payment_type'];
        $payment_settings = array();
        $payment_settings[0]['client_id'] = $client_id;
        $payment_settings[0]['paypal_password'] = $paypal_password;
        $payment_settings[0]['paypal_secret'] = $paypal_secret;
        $payment_settings[0]['currency'] = $currency;
        $payment_settings[0]['vat'] = $vat;
        $payment_settings[0]['payment_type'] = $payment_type;
        if (!empty($payment_settings)) {
            $existing_payment_settings = SiteManagement::getMetaValue('payment_settings');
            if (!empty($existing_payment_settings)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'payment_settings')->delete();
                Helper::changeEnv(
                    [
                        'PAYPAL_SANDBOX_API_USERNAME' => "",
                        'PAYPAL_SANDBOX_API_PASSWORD' => "",
                        'PAYPAL_SANDBOX_API_SECRET' => "",
                        'PAYPAL_LIVE_API_USERNAME' => "",
                        'PAYPAL_LIVE_API_PASSWORD' => "",
                        'PAYPAL_LIVE_API_SECRET' => "",
                        'PAYMENT_SYMBOL' => "",
                    ]
                );
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'payment_settings', 'meta_value' => serialize($payment_settings),
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            if ($payment_type == "test_mode") {
                Helper::changeEnv(
                    [
                        'PAYPAL_SANDBOX_API_USERNAME' => $client_id,
                        'PAYPAL_SANDBOX_API_PASSWORD' => $paypal_password,
                        'PAYPAL_SANDBOX_API_SECRET' => $paypal_secret,
                        'PAYMENT_SYMBOL' => $currency,
                    ]
                );
            } else {
                Helper::changeEnv(
                    [
                    'PAYPAL_LIVE_API_USERNAME' => $client_id,
                    'PAYPAL_LIVE_API_PASSWORD' => $paypal_password,
                    'PAYPAL_LIVE_API_SECRET' => $paypal_secret,
                    'PAYMENT_SYMBOL' => $currency,
                    ]
                );
            }
            \Artisan::call('optimize:clear');
            Session::flash('success', 'Payment Credential Saved Successfully');
            return Redirect::back();
        }
    }

    /**
     * @access public
     * @desc Show the form for storing email setting in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createEmailSetting()
    {
        $existing_email_settings = SiteManagement::getMetaValue('email_settings');
        return View::make('admin.cms.email_settings', compact('existing_email_settings'));
    }


    /**
     * @access public
     * @desc Store email settings in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEmailSetting(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate($request, [
                'email' => 'required',
            ]);
            $email = $request['email'];
            $email_settings = array();
            $email_settings[0]['email'] = $email;
            if (!empty($email_settings)) {
                $existing_email_settings = SiteManagement::getMetaValue('email_settings');
                if (!empty($existing_email_settings)) {
                    DB::table('sitemanagements')->where('meta_key', '=', 'email_settings')->delete();
                }
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'email_settings', 'meta_value' => serialize($email_settings),
                        "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                    ]
                );
                Session::flash('success', trans('prs.email_setting_success'));
                return Redirect::back();
            }
        }
    }

    /**
     * @access public
     * @desc Store project title in storage and
     * update in env file.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSiteTitle(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate(
                $request, [
                    'site_title' => 'required',
                ]
            );
            $site_title = $request['site_title'];
            $site_title_setting = array();
            $site_title_setting[0]['site_title'] = $site_title;
            if (!empty($site_title_setting)) {
                $existing_site_title_setting = SiteManagement::getMetaValue('site_title');
                if (!empty($existing_site_title_setting)) {
                    DB::table('sitemanagements')->where('meta_key', '=', 'site_title')->delete();
                }
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'site_title', 'meta_value' => serialize($site_title_setting),
                        "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                    ]
                );
                Session::flash('success', 'Site Title Saved Successfully');
                return Redirect::back();
            }
        }
    }

    /**
     * Remove all cache of the app.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearAllCache()
    {
        $json = array();
        \Artisan::call('optimize:clear');
        $json['type'] = 'success';
        return $json;
    }

    /**
     * Store language settings
     *
     * @param mixed $request Request->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function storeLanguageSetting(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $language = $request['language'];
        if (!empty($language)) {
            if (!empty($language) && File::exists(resource_path('lang/'.$language))) {
                if (File::exists(resource_path('lang/'.$language.'/prs.php'))
                    && File::exists(resource_path('lang/'.$language.'/auth.php'))
                    && File::exists(resource_path('lang/'.$language.'/pagination.php'))
                    && File::exists(resource_path('lang/'.$language.'/passwords.php'))
                    && File::exists(resource_path('lang/'.$language.'/validation.php'))
                ) {
                    Helper::changeEnv(
                        [
                            'APP_LANG' => $language,
                        ]
                    );
                } else {
                    Session::flash('error', 'Language not found');
                    return Redirect::back();
                }
                \Artisan::call('config:clear');
                \Artisan::call('cache:clear');
                \Artisan::call('view:clear');
            } else {
                Session::flash('error', 'Language not found');
                return Redirect::back();
            }
            $existing_lang_data = DB::table('sitemanagements')->where('meta_key', 'language')->select('meta_value');
            if (!empty($existing_lang_data)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'language')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'language', 'meta_value' => $language,
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            $body_class_data = DB::table('sitemanagements')->where('meta_key', 'body-lang-class')->select('meta_value');
            if (!empty($body_class_data)) {
                DB::table('sitemanagements')->where('meta_key', '=', 'body-lang-class')->delete();
            }
            DB::table('sitemanagements')->insert(
                [
                    'meta_key' => 'body-lang-class', 'meta_value' => 'lang-'.$language,
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
            Session::flash('success', 'Language Updated Successfully');
            return Redirect::back();
        }
    }

    /**
     * Remove all cache of the app.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPageOption(Request $request)
    {
        $json = array();
        $settings = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'show-page-'.$request['page_id'])->get()->first();

        if (!empty($settings)) {
            $json['type'] = 'success';
            $json['show_page'] = $settings->meta_value;
        } else {
            $json['type'] = 'error';
        }
        return $json;
    }

    public function storeKeyword(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate(
                $request, [
                    'keywords' => 'required',
                ]
            );
            $keywords = $request->keywords;
            $site_title_setting = array();
            $site_title_setting[0]['keywords'] = $keywords;


            $cur_keywords = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'keywords')->get();
            $data=array(
                "meta_key" => 'keywords',
                "meta_value" => join(",", $keywords),
                "updated_at" => date('Y-m-d H:i:s')
            );

            if (empty($cur_keywords[0])) {
                $data["created_at"] = date('Y-m-d H:i:s');
                DB::table('sitemanagements')->insert($data);
            }else{
                
                DB::table('sitemanagements')->where('meta_key', 'keywords')->update($data);
            }

            Session::flash('success', 'Keywords Saved Successfully');
                return Redirect::back();
        }
    }

    public function keywords(Request $request)
    {
        if (!empty($request)) {
            
            $this->validate(
                $request, [
                    'term' => 'required',
                ]
            );

            $keywords = $request->term;
            $site_title_setting = array();
            $site_title_setting[0]['keywords'] = $keywords;


            $cur_keywords = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'keywords')->get();
            $json = collect(explode(",", $cur_keywords[0]->meta_value))->filter(function ($value, $key) use ($keywords) {
                if (strpos($value, $keywords) !== false) {
                    return true;
                }
                return false;
            })->all();

            echo json_encode($json);

        }
    }

}
