<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use DB;
use View;
use App\User;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Support\Facades\Input;
use App\UploadMedia;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleNotificationMailable;
// use App\Mail\ArticleNotificationMailable;
use App\SiteManagement;
use App\Helper;
use Intervention\Image\Facades\Image;
use File;

class SettingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(User $users)
    {
        $this->middleware(['auth', 'isAdmin']);
        $this->users = $users;
    }

    /**
     * @access public
     * @desc Display a list of account settings
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        return View::make('admin.settings.account-settings', compact('user_id'));
    }

    /**
     * @access public
     * @desc Update password.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function requestPassword(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            Validator::extend('old_password', function ($attribute, $value, $parameters) {
                return Hash::check($value, Auth::user()->password);
            });
            $this->validate($request, [
                'password' => 'min:6|required', 'confirm_password' => 'same:password',
                'old_password' => 'required|old_password'
            ]);
            $user_id = $request['user_id'];
            $user = User::find($user_id);
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
                // prepare email and send to user
                if (!empty(config('mail.username')) && !empty(config('mail.password'))) {
                    $email_params = array();
                    $role = User::getUserRoleType($user_id);
                    $email_params['userName'] = $user->name;
                    $email_params['newPassword'] = $request->password;
                    $email_params['change_password_login_email'] = $user->email;
                    $template_data = DB::table('email_templates')->where('email_type', 'change_password')->get()->first();
                    Mail::to($user->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
                }
                Auth::logout();
                return Redirect::to('/login');
            } else {
                Session::flash('error', trans('prs.pass_not_match'));
                return Redirect::back();
            }
        }
    }

    /**
     * @access public
     * @desc Get User Image.
     * @return \Illuminate\Http\Response
     */
    public function getImage()
    {
        $response = array();
        $user_id = Auth::user()->id;
        $requestedImage = DB::table('users')->where('id', $user_id)
            ->select('user_image')->get()->first();
        if (!empty($requestedImage)) {
            $image = UploadMedia::getImageName($requestedImage->user_image);
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
     * @desc Get uploaded image from storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request)
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['error'] = $server->getData()->message;
            return $response;
        }
        $user_id = Auth::user()->id;
        $file = Input::file('attachment_file');
        if ($request['deleted_image'] == 'deleted') {
            $message = trans('image required');
            $response['error'] = $message;
            return $response;
        } else {
            $file_original_name = $file->getClientOriginalName();
            $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
            // getting image extension
            $extension = $file->getClientOriginalExtension();
            if ($extension === "jpg" || $extension === "png") {
                $filename = $file_name_without_extension . '-' . time() . '.' . $extension;
                $path = getcwd().'/uploads/users/';
                //$path = public_path() . '/uploads/users/';
                if (!file_exists($path.$user_id)) {
                    $directory  = File::makeDirectory($path.$user_id);
                }
                // generate mini image
                $small_img = Image::make($file);
                $small_img->fit(
                    40, 40,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $small_img->save($path.$user_id. '/mini-' . $filename);
                // generate small image
                $small_img = Image::make($file);
                $small_img->fit(
                    50, 50,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $small_img->save($path.$user_id . '/small-' . $filename);
                // generate medium image
                $medium_img = Image::make($file);
                $medium_img->fit(
                    70, 70,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $medium_img->save($path.$user_id . '/medium-' . $filename);
                 // generate large image
                $img = Image::make($file);
                $img->fit(
                    110, 110,
                    function ($constraint) {
                        $constraint->upsize();
                    }
                );
                $img->save($path.$user_id.'/'.$filename);
                //$file->move('uploads/users/', $filename);
                $user = User::find($user_id);
                $user->user_image = filter_var($filename, FILTER_SANITIZE_STRING);
                $user->save();
                $response = array();
                $image = UploadMedia::getImageName($filename);
                $message = trans('prs.img_upload_success');
                $response['image_name'] = $image;
                $response['message'] = $message;
                $response['url'] = url('/uploads/users/'.$user_id.'/'. $filename);
                $response['deleted'] = $request['deleted_image'];
                $response['type'] = 'user_img_update';
                return $response;
            } else {
                $message = trans('image must jpg or png type');
                $response['error'] = $message;
                return $response;
            }
        }
    }

    /**
     * @access public
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function deleteImage()
    {
        $user_id = Auth::user()->id;
        if (!empty($user_id)) {
            $json = array();
            $user = User::find($user_id);
            $user->user_image = "";
            $user->save();
            $json['message'] = trans('prs.img_delete_success');
            $json['type'] = 'user_delete';
            return $json;
        }
    }

// account setting
    public function add_author_bio()
    {

        $user_id = Auth::user()->id;
        $user = DB::table('author_bio')->where('user_id', $user_id);

        if (!empty($user_id)) {

            $data=array(
                "user_id" => $user_id,
                "title" => isset($_POST['title'])?$_POST['title']:"",
                "bio" => isset($_POST['bio'])?$_POST['bio']:"",
                "academic" => isset($_POST['academic'])?$_POST['academic']:"",
                "institute" => isset($_POST['institute'])?$_POST['institute']:"",
                "update_datetime" => date('Y-m-d H:i:s')
            );

            if($user->count() > 0) {
                DB::table('author_bio')->where('user_id', $user_id)->update($data);
                echo "<script>parent.success_update()</script>";
            }
            else {
                $data["create_datetime"] = date('Y-m-d H:i:s');
                DB::table('author_bio')->insert($data);
                echo "<script>parent.success_add()</script>";
            }
        }
    }
}
