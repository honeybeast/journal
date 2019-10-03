<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SiteManagement extends Model
{
    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = array('meta_key', 'meta_value	');

    /**
     * @access public
     * @param string $meta_key
     * @desc Get meta values from database
     * @return array
     */
    public static function getMetaValue($meta_key)
    {
        $serialize_array = "";
        if (!empty($meta_key)) {
            if ($meta_key === 'logo') {
                $logo = '';
                $uploaded_logo = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'logo')->get()->first();
                if (!empty($uploaded_logo)) {
                    $logo = 'uploads/settings/' . $uploaded_logo->meta_value;
                } else {
                    $logo = 'images/logo.png';
                }
                return $logo;
            }
            if ($meta_key === 'keywords') {
                $keywords = array();
                $cur_keywords = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'keywords')->get();
                if ($cur_keywords->count() > 0) {
                    $keywords = explode(",", $cur_keywords[0]->meta_value);
                }
                return $keywords;
            }
            if ($meta_key === 'advertisement') {
                $img = '';
                $uploaded_image = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'advertisement')->get()->first();
                if (!empty($uploaded_image)) {
                    $img = 'uploads/settings/' . $uploaded_image->meta_value;
                } else {
                    $img = 'images/widget-add.png';
                }
                return $img;
            } else {
                $serialize_array = DB::table('sitemanagements')->select('meta_value')->where('meta_key', $meta_key)->get()->first();
                if (!empty($serialize_array)) {
                    if ($meta_key === 'payment_mode') {
                        $payment_mode = !empty($serialize_array) ? unserialize($serialize_array->meta_value) : '';
                        return $payment_mode[0];
                    } else {
                        return !empty($serialize_array) ? unserialize($serialize_array->meta_value) : '';
                    }
                } else {
                    return $serialize_array;
                }
            }
        }

    }

    /**
     * @access public
     * @desc Get logo
     * @return string
     */
    public static function getLogo()
    {
        $logo = '';
        $uploaded_logo = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'logo')->get()->first();
        if (!empty($uploaded_logo)) {
            $logo = 'uploads/logo/' . $uploaded_logo->meta_value;
        } else {
            $logo = 'images/logo.png';
        }
        return $logo;
    }

    /**
     * @access public
     * @desc Get ad image
     * @return string
     */
    public static function getAdImage()
    {
        $image = '';
        $uploaded_image = DB::table('sitemanagements')->select('meta_value')->where('meta_key', 'advertisement')->get()->first();
        if (!empty($uploaded_image)) {
            $image = 'uploads/settings/' . $uploaded_image->meta_value;
        }
        return $image;
    }
}
