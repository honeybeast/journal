<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;
use Session;
use DB;
use Auth;
use App\User;
use App\Helper;
use App\SiteManagement;

class PageController extends Controller
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
     * @desc Display a listing of the resource.
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function index($role = "")
    {
        $editor_id = Auth::user()->id;
        $user_role_type = User::getUserRoleType($editor_id);
        $user_role = $user_role_type->role_type;
        if ($user_role != $role) {
            return View::make('errors.no-record');
        }
        $pages = Page::getPages();
        return View::make('admin.pages.index', compact('editor_id', 'user_role', 'pages'));
    }

    /**
     * @access public
     * @desc Show the form for creating a new resource.
     * @param string $role
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($role = "", $id = "")
    {
        $parent_page = $this->pages->getParentPages();
        $user_id = Auth::user()->id;
        $user_role_type = User::getUserRoleType($user_id);
        $user_role = $user_role_type->role_type;
        if ($user_role != $role) {
            return View::make('errors.no-record');
        }
        return View::make('admin.pages.create', compact('parent_page', 'user_role', 'user_id'));
    }

    /**
     * @access public
     * @desc Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $role = "")
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate(
                $request, [
                    'title' => 'required|string',
                    'content' => 'required',
                ]
            );
            $user_id = Auth::user()->id;
            $user_role_type = User::getUserRoleType($user_id);
            $user_role = $user_role_type->role_type;
            $page_save = $this->pages->savePage($request);
            if ($request['parent_id']) {
                DB::table('parent_child_pages')->insert(
                    ['parent_id' => $request['parent_id'], 'child_id' => $page_save]
                );
            }
            Session::flash('message', trans('prs.page_created'));
            return Redirect::to('/' . $user_role . '/dashboard/pages');
        }
    }

    /**
     * @access public
     * @desc Display the specified resource.
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (!empty($slug)) {
            $page = $this->pages->getPageData($slug);
            return View::make(
                'admin.pages.show',
                compact('page', 'slug')
            );
        }
    }

    /**
     * @access public
     * @dec Show the form for editing the specified resource.
     * @param string $role
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role = "", $id)
    {
        if (!empty($id)) {
            $user_id = Auth::user()->id;
            $user_role_type = User::getUserRoleType($user_id);
            $user_role = $user_role_type->role_type;
            $page = Page::find($id);
            $parent_selected_id = '';
            $parent_page = $this->pages->getParentPages($id);
            $has_child = $this->pages->pageHasChild($id);
            $child_parent_id = DB::table('parent_child_pages')->select('parent_id')->where('child_id', $id)->get()->first();
            $desc = DB::table('sitemanagements')->where('meta_key', 'seo-desc-'.$id)->select('meta_value')->pluck('meta_value')->first();
            $show_page = DB::table('sitemanagements')->where('meta_key', 'show-page-'.$id)->select('meta_value')->pluck('meta_value')->first();
            $seo_desc = !empty($desc) ? $desc : '';
            if ($child_parent_id == null) {
                $parent_selected_id = '';
            } else {
                $parent_selected_id = $child_parent_id->parent_id;
            }
            return View::make('admin.pages.edit', compact('page', 'parent_page', 'parent_selected_id', 'user_role', 'id', 'has_child', 'seo_desc', 'show_page'));
        }
    }

    /**
     * @access public
     * @desc Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param string $role
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userRole = "", $id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }
        if (!empty($request)) {
            $this->validate($request, [
                'title' => 'required|string',
                'content' => 'required',
            ]);
            $parent_id = filter_var($request['parent_id'], FILTER_SANITIZE_NUMBER_INT);
            $child_id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $user_id = Auth::user()->id;
            $user_role_type = User::getUserRoleType($user_id);
            $user_role = $user_role_type->role_type;
            $this->pages->updatePage($id, $request);
            if ($parent_id == null) {
                DB::table('parent_child_pages')->where('child_id', '=', $child_id)->delete();
            } elseif ($parent_id) {
                DB::table('parent_child_pages')->where('child_id', '=', $child_id)->delete();
                DB::table('parent_child_pages')->insert(
                    ['parent_id' => $parent_id, 'child_id' => $child_id]
                );
            }
            Session::flash('message', trans('prs.page_updated'));
            return Redirect::to('/' . $user_role . '/dashboard/pages');
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
        $json = array();
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $json['type'] = 'error';
            $json['message'] = $server->getData()->message;
            return $json;
        }
        $id = $request['id'];
        if (!empty($id)) {
            $child_pages = Page::pageHasChild($id);
            if (!empty($child_pages)) {
                foreach ($child_pages as $page) {
                    DB::table('pages')->where('id', $page->child_id)->update(['relation_type' => 0]);
                }
            } else {
                $relation = DB::table('pages')->select('relation_type')->where('id', $id)->get()->first();
                if ($relation->relation_type == 1) {
                    DB::table('pages')->where('id', $id)->update(['relation_type' => 0]);
                }
            }
            DB::table('parent_child_pages')->where('child_id', '=', $id)->orWhere('parent_id', '=', $id)->delete();
            DB::table('pages')->where('id', '=', $id)->delete();
            DB::table('sitemanagements')->where('meta_key', '=', 'r_menu_pages')->delete();
            $json['type'] = 'success';
            $json['message'] = trans('prs.page_deleted');
            return $json;
        }
    }
}
