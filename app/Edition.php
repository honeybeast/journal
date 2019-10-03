<?php

/**
 * @package Scientific-Journal
 * @author  Amentotech <theamentotech@gmail.com>
 * @version 1.0
 */

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helper;
use Intervention\Image\Facades\Image;
use File;

class Edition extends Model
{

    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = array('title', 'slug', 'edition_date', 'edition_price', 'edition_cover', 'edition_status');

    /**
     * @access public
     * @desc Make relation with article.
     * @return \Illuminate\Http\Response
     */
    public function articles()
    {
        return $this->hasMany('Article');
    }

    /**
     * @access public
     * @param string $value
     * @desc Set slug before saving in database 
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!Edition::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Edition::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * @access public
     * @desc Get editions
     * @return array
     */
    public static function getEditions()
    {
        $editions = DB::table('editions')->paginate(10);
        return $editions;
    }

    /**
     * @access public
     * @param int $edition_id
     * @desc Get articles by edition
     * @return array
     */
    public static function getEditionArticle($edition_id)
    {
        if (!empty($edition_id) && is_numeric($edition_id)) {
            return DB::table('articles')->select('id', 'title')
                ->where('edition_id', $edition_id)->get()->all();
        }
    }

    /**
     * @access public
     * @param \Illuminate\Http\Request  $request
     * @desc store editions in database
     * @return \Illuminate\Http\Response
     */
    public function saveEdition($request)
    {
        if (!empty($request)) {
            $this->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->slug = filter_var($request->title, FILTER_SANITIZE_STRING);
            $this->edition_date = Carbon::parse($request->edition_date)->toDateString();
            $this->edition_price = filter_var($request->price, FILTER_SANITIZE_NUMBER_INT);
            $this->save();
        }
    }

    /**
     * @access public
     * @param id $edition_id
     * @param \Illuminate\Http\Request  $request
     * @desc Update editions
     * @return \Illuminate\Http\Response
     */
    public function updateEdition($request, $edition_id)
    {
        if (!empty($request) && !empty($edition_id)) {
            $sizes = Helper::predefined_regenerate_sizes();
            $file = $request->file('edition_cover');
            $articles = $request['articles'];
            $edition = $this->find($edition_id);
            $edition->title = $request->title;
            $edition->edition_date = Carbon::parse($request->edition_date)->toDateString();
            if (!empty($request->price)) {
                $edition->edition_price = $request->price;
            }
            if (!empty($file)) {
                $extension = $file->getClientOriginalExtension();
                $file_original_name = $file->getClientOriginalName();
                $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
                if ($extension === "jpg" || $extension === "png") {
                    $filename = $file_name_without_extension . '-' . time() . '.' . $extension;
                    $path = getcwd().'/uploads/editions/';
                    //$path = public_path() . '/uploads/editions/';
                    // create directory if not exist.
                    if (!file_exists($path.$edition_id)) {
                        $directory  = File::makeDirectory($path.$edition_id);
                    } 
                    // generate small image size
                    $small_img = Image::make($file);
                    $small_img->fit(
                        62, 35,
                        function ($constraint) {
                            $constraint->upsize();
                        }
                    );
                    $small_img->save($path.$edition_id.'/small-'.time().'-'.$file_original_name); 
                    // generate medium image size
                    $medium_img = Image::make($file);
                    $medium_img->fit(
                        270, 170,
                        function ($constraint) {
                            $constraint->upsize();
                        }
                    );
                    $medium_img->save($path.$edition_id.'/medium-'.time().'-'.$file_original_name); 
                    // save original image size
                    $img = Image::make($file);
                    $img->save($path.$edition_id.'/'.time().'-'.$file_original_name);
                    $edition->edition_cover = time().'-'.$file_original_name;
                } else {
                    Session::flash('message', trans('image must jpg or png type'));
                    return Redirect::back();
                }
            }
            $edition->save();
            $selected_articles = $this->getEditionArticle($edition->id);
            foreach ($selected_articles as $article) {
                DB::table('articles')
                    ->where('id', $article->id)
                    ->update(['edition_id' => null]);
            }
            if (!empty($articles)) {
                foreach ($articles as $article) {
                    DB::table('articles')
                        ->where('id', $article)
                        ->update(['edition_id' => $edition_id]);
                }
            }
        }
    }

    /**
     * @access public
     * @desc Get list of article Editions
     * @return array
     */
    public static function getEditionsList()
    {
        return DB::table('editions')->pluck('title', 'id')->prepend('Select Article Edition', '');
    }

    /**
     * @access public
     * @desc Get Editions by status
     * @return array
     */
    public static function getEditionsListByStatus()
    {
        return DB::table('editions')->select('title', 'id')
            ->where('edition_status', '=', 0)
            ->pluck('title', 'id');
    }

    /**
     * @access public
     * @param int $id
     * @desc Get edition by id
     * @return collection
     */
    public static function getEditionByID($id)
    {
        if (!empty($id) && is_numeric($id)) {
            return DB::table('editions')->select('title', 'edition_date', 'id')->where('id', $id)->get()->first();
        }
    }

    /**
     * @access public
     * @desc Get publish editions
     * @return array
     */
    public static function getPublishedEdition()
    {
        return DB::table('editions')->select('title', 'slug', 'id')->where('edition_status', 1)->get()->all();
    }

    /**
     * @access public
     * @param string $slug
     * @desc Get published articles   
     * @return array
     */
    public static function getPublishedEditionArticles($slug)
    {
        if (!empty($slug) && is_string($slug)) {
            return DB::table('articles')
                ->join('editions', 'editions.id', '=', 'articles.edition_id')
                ->select('articles.*', 'editions.title as edition_title', 'editions.edition_cover', 'editions.edition_status')
                ->where('editions.edition_status', '=', 1)
                ->where('editions.slug', '=', $slug)
                ->get()->all();
        }
    }

    /**
     * @access public
     * @param int $id
     * @desc Get articles assign to edition
     * @return array
     */

    public static function getAssignArticles($id)
    {
        if (!empty($id) && is_numeric($id)) {
            return DB::table('articles')
                ->join('editions', 'editions.id', '=', 'articles.edition_id')
                ->select('articles.*', 'editions.edition_cover', 'editions.edition_status')
                ->where('editions.id', '=', $id)
                ->get()->all();
        }
    }

    /**
     * @access public
     * @param int $edition_id
     * @param int $excluded_article
     * @desc Get articles assign to edition from database
     * @return array
     */
    public static function getPublishedRelatedArticles($edition_id, $excluded_article)
    {
        if (!empty($edition_id) && !empty($excluded_article)) {
            return DB::table('articles')
                ->join('editions', 'editions.id', '=', 'articles.edition_id')
                ->select('articles.*', 'editions.edition_cover', 'editions.edition_status')
                ->where('editions.edition_status', '=', 1)
                ->where('editions.id', '=', $edition_id)
                ->where('articles.id', '!=', $excluded_article)
                ->get()->all();
        }
    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get article edition.
     * @return array
     */
    public static function getEditionByArticleID($article_id)
    {
        if (!empty($article_id)) {
            return DB::table('editions')
                ->join('articles', 'articles.edition_id', '=', 'editions.id')
                ->select('editions.slug', 'editions.title')
                ->where('articles.id', '=', $article_id)
                ->get()->first();
        }
    }

    /**
     * @access public
     * @param int $id
     * @desc Get publish edition by status
     * @return string
     */
    public static function getEditionStatusByID($id)
    {
        if (!empty($id)) {
            $edition = DB::table('editions')->select('edition_status')
                ->where('id', $id)->get()->first();
            return $edition->edition_status;
        }

    }

    /**
     * @access public
     * @param int $id
     * @desc Get edition image
     * @return string
     */
    public static function getEditionImageByID($id)
    {
        if (!empty($id)) {
            $edition = DB::table('editions')->select('edition_cover')
                ->where('id', $id)->get()->first();
            if (!empty($edition->edition_cover)) {
                $image_parts = explode('-', $edition->edition_cover);
                $remove_timestamp = array_shift($image_parts);
                $image_name = implode('-', $image_parts);
                return $image_name;
            } else {
            
            }
        }

    }
}
