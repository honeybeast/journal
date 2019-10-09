<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = array('title', 'image', 'description');

    /**
     * @access public
     * @desc Get all categories
     * @return collection
     */
    public static function getCategories()
    {
        $categories = DB::table('categories')->paginate(5);
        return $categories;
    }

    /**
     * @access public
     * @param \Illuminate\Http\Request  $request
     * @desc Store categories in database
     * @return \Illuminate\Http\Response
     */
    public function saveCategory($request)
    {
        if (!empty($request)) {

            $cat_img = UploadMedia::mediaUpload('category_image', $request, 'uploads/categories/');
            $this->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $this->image = $cat_img;
            $this->description = filter_var($request['description'], FILTER_SANITIZE_STRING);
            $this->author_guideline = filter_var($request['author_guideline'], FILTER_SANITIZE_STRING);
            $this->issn_print = filter_var($request['issn_print'], FILTER_SANITIZE_STRING);
            $this->issn_electronic = filter_var($request['issn_electronic'], FILTER_SANITIZE_STRING);

            $this->save();

            $id = DB::getPdo()->lastInsertId();
            if ($request->logo_img) {

                $logo = UploadMedia::MultimediaUpload( 'logo_img', $_FILES['logo_img'], 'uploads/categories/');

                if ($request->logo_img) {

                    $data = array();
                    for ($i=0; $i < count($request->logo_img) ; $i++) { 

                        $data[$i] = array(
                            'jo_id'=>$id,
                            'logo_img'=>$logo[$i],
                            'abstract_title'=>$request->abstract_title[$i],
                            'abstract_url'=>$request->abstract_url[$i],
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')
                        );

                        DB::table('abstract')->insert($data[$i]);
                    };
                }

            }else{
                $data = array();
                    for ($i=0; $i < isset($request->abstract_title) ; $i++) { 

                        $data[$i] = array(
                            'jo_id'=>$id,
                            'abstract_title'=>$request->abstract_title[$i],
                            'abstract_url'=>$request->abstract_url[$i],
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')
                        );

                        DB::table('abstract')->insert($data[$i]);
                    };
            }
        }

    }

    /**
     * @access public
     * @param \Illuminate\Http\Request  $request
     * @param int $category_id
     * @desc Update category
     * @return \Illuminate\Http\Response
     */
    public function updateCategory($request, $category_id)
    {
        if (!empty($request['category_image']) && !empty($category_id) && is_numeric($category_id)) {
            $category = $this->find($category_id);
            $path = 'uploads/categories/';
            if (!empty($request['hidden_category_image'])) {
                $image_parts = explode('.', $request['hidden_category_image']);
                $image_last_parts = end($image_parts);
                $cat_img = $path . '/' . $image_parts[0] . '-' . time() . '.' . $image_last_parts;
                if (!empty($request['category_image'])) {
                    $request['category_image']->getClientOriginalName();
                    $request['category_image']->move($path, $cat_img);
                }
            } else {
                $cat_img = UploadMedia::mediaUpload('category_image', $request, 'uploads/categories/');
            }
            $category->title = filter_var($request->title, FILTER_SANITIZE_STRING);
            $category->description = filter_var($request->description, FILTER_SANITIZE_STRING);
            $category->author_guideline = filter_var($request->author_guideline, FILTER_SANITIZE_STRING);
            $category->issn_print = filter_var($request['issn_print'], FILTER_SANITIZE_STRING);
            $category->issn_electronic = filter_var($request['issn_electronic'], FILTER_SANITIZE_STRING);
            $category->image = filter_var($cat_img, FILTER_SANITIZE_STRING);
            $category->save();
        }
        else {            
            $data=array(
                'title'=>filter_var($request->title, FILTER_SANITIZE_STRING),
                'description'=>filter_var($request->description, FILTER_SANITIZE_STRING),
                'author_guideline'=>filter_var($request->author_guideline, FILTER_SANITIZE_STRING),
                'issn_print'=>filter_var($request->issn_print, FILTER_SANITIZE_STRING),
                'issn_electronic'=>filter_var($request->issn_electronic, FILTER_SANITIZE_STRING),
                'updated_at'=>date('Y-m-d H:i:s')
            );
            DB::table('categories')->where('id', $category_id)->update($data);
        };



        $abstract = DB::table('abstract')->where('jo_id', $category_id)->get();

        if ($request->abstract_id) {
            if (count($abstract)) {
                foreach ($abstract as $val) {
                    if(!in_array($val->id, $request->abstract_id)) {
                        DB::table('abstract')->where('id', $val->id)->delete();
                    }
                }
            }
        }else{
            DB::table('abstract')->where('jo_id', $category_id)->delete();
        }
        if (!empty($request->logo_img_changed)) {
            $logo = UploadMedia::MultimediaUpload( 'logo_img', $_FILES['logo_img'], 'uploads/categories/');
            $data = array();
            for ($i=0; $i < count($request->logo_img_changed) ; $i++) {
                $data[$i] = array();
                if($request->abstract_id[$i] != -1) {
                    if($request->logo_img_changed[$i] == 0) {
                        $data[$i] = array(
                            'abstract_title'=>$request->abstract_title[$i],
                            'abstract_url'=>$request->abstract_url[$i],
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                    }
                    else {
                        $data[$i] = array(
                            'logo_img'=>$logo[$i],
                            'abstract_title'=>$request->abstract_title[$i],
                            'abstract_url'=>$request->abstract_url[$i],
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                    }

                    DB::table('abstract')->where('id', $request->abstract_id[$i])->update($data[$i]);
                }
                else {
                    if($request->logo_img_changed[$i] == 0) {
                        $data[$i] = array(
                            'abstract_title'=>$request->abstract_title[$i],
                            'abstract_url'=>$request->abstract_url[$i],
                            'jo_id'=> $category_id,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                    }
                    else {
                        $data[$i] = array(
                            'logo_img'=>$logo[$i],
                            'jo_id'=> $category_id,
                            'abstract_title'=>$request->abstract_title[$i],
                            'abstract_url'=>$request->abstract_url[$i],
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')
                        );
                    }

                    DB::table('abstract')->insert($data[$i]);
                }
            };
        }
    }

    /**
     * @access public
     * @desc Get list of article categories.
     * @return array
     */
    public static function getCategoriesList()
    {
        return DB::table('categories')->pluck('title', 'id')->prepend('Select Manuscript Journal', '');
    }

    /**
     * @access public
     * @param int $id
     * @desc Get category by by
     * @return collection
     */
    public static function getCategoryByID($id)
    {
        if (!empty($id) && is_numeric($id)) {
            return DB::table('categories')->select('title', 'id')->where('id', $id)->get()->first();
        }
    }

    /**
     * @access public
     * @desc Get reviewer by category
     * @return collection
     */
    public static function getReviewersCategory()
    {
        return DB::table('categories')
            ->join('reviewers_categories', 'categories.id', '=', 'reviewers_categories.category_id')
            ->select('categories.*')
            ->groupBy('categories.id')
            ->get();
    }

    /**
     * @access public
     * @param array $categories
     * @param int $user_id
     * @desc Store category id and reviewer id in database
     * @return \Illuminate\Http\Response
     */
    public static function saveReviewerCategory($categories = array(), $user_id)
    {
        if (!empty($categories) && !empty($user_id)) {
            $reviewers = DB::table('reviewers_categories')->select('reviewer_id')
                ->where('reviewer_id', $user_id)->get()->pluck('reviewer_id')->toArray();
            if (!empty($reviewers)) {
                if ((in_array($user_id, $reviewers))) {
                    DB::table('reviewers_categories')->where('reviewer_id', $user_id)->delete();
                }
            }
            foreach ($categories as $category) {
                $result = DB::table('reviewers_categories')->insert(
                    [
                        'category_id' => $category, 'reviewer_id' => $user_id,
                        'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()
                    ]
                );
            }
            return $result;
        }
    }

    /**
     * @access public
     * @param int $reviewer_id
     * @desc Categories assigned to reviewers
     * @return array
     */
    public static function getCategoryByReviewerID($reviewer_id)
    {
        if (!empty($reviewer_id) && is_numeric($reviewer_id)) {
            return DB::table('reviewers_categories')->select('category_id')
                ->where('reviewer_id', $reviewer_id)->get()->pluck('category_id')->toArray();
        }
    }
}
