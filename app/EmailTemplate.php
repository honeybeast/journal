<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{

    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = array('subject', 'title', 'email_type', 'body');

    /**
     * @access public
     * @param \Illuminate\Http\Request  $request
     * @desc Stiore template in database.
     * @return \Illuminate\Http\Response
     */
    public function saveEmailTemplate($request)
    {
        if (!empty($request)) {
            $this->subject = filter_var($request->subject, FILTER_SANITIZE_STRING);
            $this->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->email_type = filter_var($request->template_types, FILTER_SANITIZE_STRING);
            $this->role_id = filter_var($request->user_types, FILTER_SANITIZE_NUMBER_INT);
            $this->body = $request->body;
            $this->save();
        }
    }

    /**
     * @access public
     * @param int $id
     * @param \Illuminate\Http\Request  $request
     * @desc Update template in database
     * @return \Illuminate\Http\Response
     */
    public function updateTemplate($id, $request)
    {
        if (!empty($id) && !empty($request)) {
            $template = EmailTemplate::find($id);
            $template->subject = filter_var($request->subject, FILTER_SANITIZE_STRING);;
            $template->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $template->body = $request->body;
            $template->save();
        }
    }

    /**
     * @access public
     * @desc Get email templates
     * @return collection
     */
    public static function getEmailTemplates()
    {
        $email_templates = DB::table('email_templates')->paginate(10);
        return $email_templates;
    }

    /**
     * @access public
     * @param int $role_id
     * @param string $email_type
     * @desc Get specific email template
     * @return collection
     */
    public static function getEmailTemplatesByID($role_id, $email_type)
    {
        if (!empty($role_id) && !empty($email_type)) {
            return DB::table('email_templates')->where('role_id', $role_id)->where('email_type', $email_type)->get()->first();
        }
    }

    /**
     * @access public
     * @param int $role_id
     * @param string $email_type
     * @desc Get specific email veriables by role
     * @return collection
     */
    public static function getEmailVariablesByRoleID($role_id, $email_type)
    {
        if (!empty($email_type)) {
            if ($role_id == null) {
                return DB::table('role_email_types')->select('variables')->where('role_id', null)
                    ->where('email_type', $email_type)->get()->first();
            } else {
                return DB::table('role_email_types')->select('variables')
                    ->where('role_id', $role_id)->where('email_type', $email_type)
                    ->get()->first();
            }
        }
    }

    /**
     * @access public
     * @param int $id
     * @desc Get specific email type by role
     * @return collection
     */
    public static function getEmailTemplatesRoleByID($id)
    {
        if (!empty($id) && is_numeric($id)) {
            return DB::table('email_templates')->select('role_id')->where('id', $id)->get()->first();
        }
    }

    /**
     * @access public
     * @param string $email_type
     * @desc Get specific email template role list
     * @return array
     */
    public static function getEmailTemplateRoleByType($email_type)
    {
        if (!empty($email_type)) {
            return DB::table('email_templates')->select('role_id')->where('email_type', $email_type)
                ->get()->pluck('role_id')->all();
        }
    }

    /**
     * @access public
     * @param string $email_type
     * @desc Get email template role count
     * @return count
     */
    public static function getEmailTypeRoleCount($email_type)
    {
        if ($email_type) {
            return DB::table('role_email_types')->select('role_id')->where('email_type', $email_type)->get()->count();
        }
    }

    /**
     * @access public
     * @param int $email_template_id
     * @desc Get specific email template role
     * @return collection
     */
    public static function getEmailTemplateRole($email_template_id)
    {
        if(!empty($email_template_id) && is_numeric($email_template_id)){
            return DB::table('email_templates')->select('role_id')->where('id', $email_template_id)->get()->first();
        }
    }

    /**
     * @access public
     * @desc Get change password template
     * @return collection 
     */
    public static function getChangePasswordEmailTemplate()
    {
        return DB::table('email_templates')->where('email_type', 'change_password')->get();
    }

    /**
     * @access public
     * @param int $role_id
     * @param string $type
     * @desc Get filter email template
     * @return collection
     */
    public static function getFilterTemplate($role_id = "", $type = "")
    {
        $query = '';
        $query = DB::table('email_templates')->select('*');
        if (!empty($role_id)) {
            $query->where('role_id', $role_id);
        }
        if (!empty($type)) {
            $query->where('email_type', $type);
        }
        return $query->paginate(10);
    }

}
