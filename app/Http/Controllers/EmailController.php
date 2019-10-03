<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use App\EmailTemplate;
use App\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use View;
use Session;
use DB;

class EmailController extends Controller
{

    /**
     * @access private 
     * @var array $email_templates
     */
    private $email_templates;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailTemplate $templates)
    {
        $this->middleware(['auth', 'isAdmin']);
        $this->email_templates = $templates;
    }

    /**
     * @access public
     * @desc Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request['role'] || !empty($request['type']))) {
            $email_templates = EmailTemplate::getFilterTemplate($request['role'], $request['type']);
        } else {
            $email_templates = EmailTemplate::getEmailTemplates();
        }
        $template_types = Helper::emailTypeList();
        $roles = Role::select('name', 'id')->get()->pluck('name', 'id');
        $total_templates_created = EmailTemplate::all();
        $total_roles_templates = DB::table('role_email_types')->get();
        $create_template = $total_templates_created->count() == $total_roles_templates->count() ? true : false;
        return View::make('admin.email-templates.index', compact('email_templates', 'create_template', 'template_types', 'roles'));
    }

    /**
     * @access public
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templateTypes = Helper::emailTypeList();
        return View::make('admin.email-templates.create');
    }

    /**
     * @access public
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate($request, [
                'subject' => 'required',
                'body' => 'required',
                'template_types' => 'required',
            ]);
            $this->email_templates->saveEmailTemplate($request);
            Session::flash('message', trans('prs.template_created'));
            return Redirect::to('dashboard/superadmin/emails/templates');
        }
    }

    /**
     * @access public
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!empty($id)) {
            $email_template = EmailTemplate::find($id);
            $email_types = Helper::emailTypeList();
            $user_types = User::getRoleList($email_template->email_type);
            $template_variables = EmailTemplate::getEmailVariablesByRoleID($email_template->role_id, $email_template->email_type);
            $variables = unserialize($template_variables->variables);
            return View::make('admin.email-templates.edit', compact('email_template', 'id', 'email_types', 'user_types', 'variables'));
        }
    }

    /**
     * @access public
     * @desc Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request) && !empty($id)) {
            $this->validate(
                $request, [
                    'subject' => 'required',
                    'body' => 'required',
                    'title' => 'required',
                ]
            );
            $this->email_templates->updateTemplate($id, $request);
            Session::flash('message', trans('prs.template_updated'));
            return Redirect::to('/dashboard/superadmin/emails/templates');
        }
    }

    /**
     * @access public
     * @desc Remove the specified resource from storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request['id'];
        if (!empty($id)) {
            DB::table('email_templates')->where('id', '=', $id)->delete();
            $message = trans('template_deleted');
            return $message;
        }
    }

    /**
     * @access public
     * get email types.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEmailType(Request $request)
    {
        $email_type = Helper::emailTypeList();
        return response()->json(['email_type' => $email_type]);
    }

    /**
     * @access public
     * get user types related to email types.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUserType(Request $request)
    {
        if (!empty($request)) {
            $user_type = '';
            $email_type = $request['email_type'];
            $change_password_template = EmailTemplate::getChangePasswordEmailTemplate();
            if ($email_type != null) {
                if ($email_type == "change_password" && $change_password_template->count() > 0) {
                    return response()->json(['error' => 'Template already created select other type']);
                }
                $excluded_roles = EmailTemplate::getEmailTemplateRoleByType($email_type);
                if (!empty($excluded_roles)) {
                    $user_type = User::getEmailTypeRoles($email_type, $excluded_roles);
                } else {
                    $user_type = User::getRoleList($email_type);
                }
                if ($email_type == "change_password") {
                    return response()->json(['user_type' => $user_type]);
                }
                if (!empty($user_type)) {
                    return response()->json(['user_type' => $user_type]);
                } else {
                    return response()->json(['error' => 'Template already created select other type']);
                }
            } else {
                return response()->json(['user_type' => $user_type]);
            }
        }
    }

    /**
     * @access public
     * get email variables.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getEmailVariables(Request $request)
    {
        $role_id = $request['role_id'];
        $email_type = $request['email_type'];
        if (!empty($role_id) && !empty($email_type)) {
            $template_variables = EmailTemplate::getEmailVariablesByRoleID($role_id, $email_type);
            $serialize_variables = unserialize($template_variables->variables);
            return response()->json(['variables' => $serialize_variables]);
        }
    }
}
