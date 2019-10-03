<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use Auth;
use App\SiteManagement;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleNotificationMailable;
use App\EmailTemplate;
use DB;
use App\Helper;
use Session;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Mail\ExceptionOccured;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';
    private $email_settings;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->email_settings = '';
        if (isset($_SERVER["SERVER_NAME"]) && $_SERVER["SERVER_NAME"] != '127.0.0.1') {
            $this->email_settings = SiteManagement::getMetaValue('email_settings');
            config(['mail.username' => $this->email_settings[0]['email']]);
        }
        $this->middleware('guest');
    }

    public function register(Request $request) {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors($validator, 'register');
        } else {
            event(new Registered($user = $this->create($request->all())));

            return redirect($this->redirectPath())->with('message', trans('prs.register_success'));
        }
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
    */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                    'terms_condition' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param  array  $data
     * @return \App\User
    */
    protected function create(array $data) {
        $role = $data['role'];
        $id = !empty($role) && $role == 'author' ? '3' : '5';
        $user = new User();
        $role_r = Role::where('id', '=', $id)->firstOrFail();
        $user->assignRole($role_r); //Assigning role to user
        $user = User::create([
                    'name' => $data['name'],
                    'sur_name' => $data['sur_name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'token' => md5(uniqid(rand(), true)),
        ]);
        if (!empty($this->email_settings)) {
            $site = SiteManagement::getMetaValue('site_title');
            $superadmin = User::getUserByRoleType('superadmin');
            $email_params['new_user_supper_admin_name'] = $superadmin[0]->name;
            $email_params['site_title'] = $site[0]['site_title'];
            $email_params['user_edit_page_link'] = url('/login?user_id='.$user->id.'&email_type=new_user');
            $email_params['new_user_name'] = $data['name']." ".$data['sur_name'];
            $email_params['new_user_role'] = $role;
            $email_params['login_email'] = $data['email'];
            $email_params['new_user_password'] = $data['password'];
            $template_data = EmailTemplate::getEmailTemplatesByID($superadmin[0]->role_id,'new_user');
            if (!empty($template_data)) {
                Mail::to($superadmin[0]->email)->send(new ArticleNotificationMailable($email_params, $template_data, $role));
            }
            $user_template_data = DB::table('email_templates')->where('email_type','new_user')->where('role_id',null)->get()->first();
            if (!empty($user_template_data)) {
                Mail::to( $data['email'])->send(new ArticleNotificationMailable($email_params, $user_template_data, $role));
            }
        }
        
        return $user;
    }

}