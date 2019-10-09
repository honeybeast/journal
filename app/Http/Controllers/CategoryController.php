<?php
/**
 * Class CategoryController
 *
 * @category Scientific-Journal
 *
 * @package Scientific-Journal
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com Amentotech
 * @link    http://www.amentotech.com
 */

namespace App\Http\Controllers;

use DB;
use View;
use Session;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Edition;
use Auth;
use App\Article;
use App\Helper;

/**
 * Class CategoryController
 *
 */
class CategoryController extends Controller
{

    /**
     * Defining scope of variable
     *
     * @access public
     * @var    array $categories
     */
    protected $categories;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Category $categories)
    {
        $this->middleware(['auth', 'isAdmin']);
        $this->categories = $categories;
    }

    /**
     * @access public
     * @desc Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editor_id = Auth::user()->id;
        $categories = Category::getCategories();
        $editions = Edition::getEditions();
        return View::make('admin.settings.category-setting', compact('editions', 'editor_id'))->with('categories', $categories);
    }

    /**
     * @access public
     * Store a newly created resource in storage.
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
        if (!empty($request)) {

            $file = $request->file('category_image');
            $this->categories->saveCategory($request);
            Session::flash('message', trans('prs.cat_created'));
            return Redirect::back();
        }
    }

    /**
     * @access public
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
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
            $file = $request->file('category_image');
            $this->categories->updateCategory($request, $id);
            Session::flash('message', trans('prs.cat_updated'));
            return Redirect::back(); 
        }
    }

    /**
     * @access public
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
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
            DB::table('categories')->where('id', $id)->delete();
            DB::table('reviewers_categories')->where('category_id', $id)->delete();
            Article::where('article_category_id', '=', $id)->update(array('article_category_id' => null));
            $json['type'] = 'success';
            $json['message'] = trans('prs.cat_deleted');
            return $json;
        }
    }
}
