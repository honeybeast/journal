<?php
/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Author extends Model
{
    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = array('name', 'email');

    /**
     * @access public
     * @desc Make relation with article.
     * @return \Illuminate\Http\Response
     */
    public function articles()
    {
        return $this->belongsToMany('Article');
    }

    /**
     * @access public
     * @param string $author_name
     * @param string $author_email
     * @desc store author in database
     * @return \Illuminate\Http\Response
     */
    public static function saveAuthor($author_name, $author_email)
    {
        if (!empty($author_name) && !empty($author_email)) {
            return DB::table('authors')->insert(
                [
                    'name' => $author_name, 'email' => $author_email,
                    "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()
                ]
            );
        }
    }

    /**
     * @access public
     * @param int $author_id
     * @desc Get author By id
     * @return array
     */
    public static function getAuthorByID($author_id)
    {
        if (!empty($author_id) && is_numeric($author_id)) {
            return DB::table('authors')->select('name', 'email')->where('id', $author_id)->get()->all();
        }

    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get author by article
     * @return array
     */
    public static function getAuthorByArticle($article_id)
    {
        if (!empty($article_id) && is_numeric($article_id)) {
            return DB::table('authors')
                ->join('author_article', 'authors.id', '=', 'author_article.author_id')
                ->join('articles', 'articles.id', '=', 'author_article.article_id')
                ->select('authors.id', 'authors.name', 'authors.email')
                ->where('author_article.article_id', '=', $article_id)
                ->get()->all();
        }

    }
}
