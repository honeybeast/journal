<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Page extends Model
{

    /**
     * @access protected
     * @var array $fillable
     */
    protected $fillable = array('title', 'slug', 'sub_title', 'body');

    /**
     * @access public
     * @param string $value
     * @desc Set slug before saving in DB
     * @return string
     */
    public function setSlugAttribute($value)
    {
        $temp = str_slug($value, '-');
        if (!Page::all()->where('slug', $temp)->isEmpty()) {
            $i = 1;
            $new_slug = $temp . '-' . $i;
            while (!Page::all()->where('slug', $new_slug)->isEmpty()) {
                $i++;
                $new_slug = $temp . '-' . $i;
            }
            $temp = $new_slug;
        }
        $this->attributes['slug'] = $temp;
    }

    /**
     * @access public
     * @desc Get pages from database
     * @return collection
     */
    public static function getPages()
    {
        $pages = DB::table('pages')->paginate(5);
        return $pages;
    }

    /**
     * @access public
     * @param \Illuminate\Http\Request  $request
     * @desc Store page data in database
     * @return \Illuminate\Http\Response
     */
    public function savePage($request)
    {
        if (!empty($request)) {
            $this->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->sub_title = filter_var($request->sub_title, FILTER_SANITIZE_STRING);
            $this->body = $request->content;
            if ($request->parent_id) {
                $this->relation_type = 1;
            } else {
                $this->relation_type = 0;
            }
            $this->save();
            $page_id =  $this->id;
            if (!empty($request['seo_desc'])) {
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'seo-desc-'.$page_id, 'meta_value' => $request['seo_desc'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
            if (!empty($request['show_page'])) {
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'show-page-'.$page_id, 'meta_value' => $request['show_page'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
            return $page_id;
        }
    }

    /**
     * @access public
     * @param \Illuminate\Http\Request  $request
     * @desc Update page data in database
     * @return \Illuminate\Http\Response
     *
     */
    public function updatePage($id, $request)
    {
        if (!empty($id) && !empty($request)) {
            $pages = Page::find($id);
            $pages->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            if ($pages->title != $request->title) {
                $pages->slug = filter_var($request->title, FILTER_SANITIZE_STRING);
            }
            $pages->sub_title = filter_var($request->sub_title, FILTER_SANITIZE_STRING);
            $pages->body = $request->content;
            if ($request->parent_id == null) {
                $pages->relation_type = 0;
            } elseif ($request->parent_id) {
                $pages->relation_type = 1;
            }
            $pages->save();
            if (!empty($request['seo_desc'])) {
                DB::table('sitemanagements')->where('meta_key', '=', 'seo-desc-'.$id)->delete();
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'seo-desc-'.$id, 'meta_value' => $request['seo_desc'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
            if (!empty($request['show_page'])) {
                DB::table('sitemanagements')->where('meta_key', '=', 'show-page-'.$id)->delete();
                DB::table('sitemanagements')->insert(
                    [
                        'meta_key' => 'show-page-'.$id, 'meta_value' => $request['show_page'],
                        "created_at" => Carbon::now(), "updated_at" => Carbon::now()
                    ]
                );
            }
        }
    }

    /**
     * @access public
     * @desc Get page data
     * @param int $id
     * @return collection
     */
    public static function getPageData($slug)
    {
        if (!empty($slug) && is_string($slug)) {
            return DB::table('pages')->select('*')->where('slug', $slug)->get()->first();
        }
    }

    /**
     * @access public
     * @desc Get page slug
     * @param int $id
     * @return collection
     */
    public static function getPageslug($id)
    {
        if (!empty($id) && is_numeric($id)) {
            return DB::table('pages')->select('slug')->where('id', $id)->get()->first();
        }
    }


    /**
     * @access public
     * @desc Get parent page
     * @param int $id
     * @return array
     */
    public function getParentPages($id = '')
    {
        if (!empty($id)) {
            return DB::table('pages')->where('relation_type', '=', 0)->where('id', '!=', $id)->pluck('title', 'id')->prepend('Select parent', '');
        } else {
            return DB::table('pages')->where('relation_type', '=', 0)->pluck('title', 'id')->prepend('Select parent', '');
        }

    }

    /**
     * @access public
     * @desc Get page list
     * @param int $id
     * @return collection
     */
    public static function getPageList()
    {
        return DB::table('pages')->select('title', 'slug')->pluck('title', 'slug');
    }

    /**
     * @access public
     * @desc Get child page
     * @param int $child_id
     * @return collection
     */
    public static function getChildPages($child_id)
    {
        return DB::table('pages')->select('title', 'slug', 'id')->where('id', $child_id)->get()->first();
    }

    /**
     * @access public
     * @desc Get Parent Pages
     * @param int $page_id
     * @return array
     */
    public static function pageHasChild($page_id)
    {
        if (!empty($page_id) && is_numeric($page_id)) {
            return DB::table('pages')
                ->join('parent_child_pages', 'pages.id', '=', 'parent_child_pages.parent_id')
                ->select('pages.id', 'pages.title', 'parent_child_pages.child_id')
                ->where('parent_child_pages.parent_id', '=', $page_id)
                ->get()->all();
        }
    }
}
