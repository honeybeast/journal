<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Storage;

class Article extends Model
{
    /**
     * @access protected 
     * @var array $fillable
     */
    protected $fillable = array(
        'title', 'slug', 'abstract', 'submitted_document', 'status', 'editor_comments', 'corresponding_author_id', 'category_id'
    );

    /**
     * @access protected 
     * @var array $dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @access public   
     * @desc Make relation with edition.
     * @return \Illuminate\Http\Response
     */
    public function editions()
    {
        return $this->belongsTo('Edition');
    }

    /**
     * @access public   
     * @desc Make many to many relation with authors.
     * @return \Illuminate\Http\Response
     */
    public function authors()
    {
        return $this->belongsToMany('Author');
    }

    /**
     * @access public
     * @param string $value
     * @desc Set slug before saving in DB 
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!Article::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Article::all()->where('slug', $new_slug)->isEmpty()) {
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
     * @param \Illuminate\Http\Request  $request
     * @desc Store articles in database
     * @return \Illuminate\Http\Response
     */
    public static function saveArticle($request)
    {
        if (!empty($request)) {
            $article = new Article();
            $user = User::find(Auth::id());
            $user_role = $user->getRoleNames()->toArray();
            $random_number = Helper::generateRandomCode(8);
            $unique_code = strtoupper($random_number);
            if ($user_role[0] === 'author') {
                $uploaded_file = $request->file('uploaded_new_article');
                $file_original_name = $uploaded_file->getClientOriginalName();
                $corresponding_author_id = Auth::id();
                $filePath = 'uploads/articles/users/' . $corresponding_author_id . '/';
                $file_name_without_extension = pathinfo($file_original_name, PATHINFO_FILENAME);
                $extension = $uploaded_file->getClientOriginalExtension();
                $full_doc_name = $corresponding_author_id . '-' . $file_name_without_extension . '-' . time() . '.' . $extension;
                // store file into disk
                Storage::disk('local')->putFileAs(
                    $filePath,
                    $uploaded_file,
                    $full_doc_name
                );
                // store data into database
                $article->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
                $article->slug = filter_var($request['title'], FILTER_SANITIZE_STRING);
                $article->price = null;
                $article->abstract = $request['abstract'];
                $article->excerpt = filter_var($request['excerpt'], FILTER_SANITIZE_STRING);
                $article->submitted_document = filter_var($full_doc_name, FILTER_SANITIZE_STRING);
                $article->publish_document = null;
                $article->status = 'articles_under_review';
                $article->editor_comments = null;
                $article->corresponding_author_id = filter_var($corresponding_author_id, FILTER_SANITIZE_NUMBER_INT);
                $article->notify = 0;
                $article->article_category_id = filter_var($request['category'], FILTER_SANITIZE_NUMBER_INT);
                $article->edition_id = null;
                $article->unique_code = $unique_code;
                $article->author_notify = 0;
                $article->hits = 0;
                return $article->save();
            }
        }
    }


    /**
     * @access public
     * @param int  $article_id
     * @desc get articles notifiication data
     * @return collection
     */
    public static function getArticleNotificationData($article_id)
    {
        return DB::table('articles')->select('id', 'corresponding_author_id', 'status', 'submitted_document', 'title', 'abstract')
            ->where('id', $article_id)->get()->first();
    }


    /**
     * @access public
     * @param  \Illuminate\Http\Request  $request
     * @param int $user_id
     * @param int $article_id
     * @desc Submit comments
     * @return \Illuminate\Http\Response
     */
    public static function submitComments($request, $user_id, $article_id)
    {
        if (!empty($request) && !empty($user_id) && !empty($article_id)) {
            $comment = $request->comments;
            $status = $request->status;
            return DB::table('comments')->insert(
                [
                    'comment_author' => $user_id, 'article_id' => $article_id, 'comment' => $comment, 'status' => $status,
                    'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()
                ]
            );
        }

    }

    /**
     * @access public
     * @param int $id
     * @desc Get comments
     * @return collection
     */
    public static function getCommentsByID($id)
    {
        if (!empty($id) && is_numeric($id)) {
            return DB::table('comments')->select('comment')->where('id', $id)->get()->first();
        }
    }

    /**
     * @package Scientific-Journal
     * @access public
     * @version 1.0
     * @param int $user_id
     * @param int $article_id
     * @desc Get specific comment
     * @return array
     */
    public static function getArticleCommentsByUserID($user_id, $article_id)
    {
        return DB::table('comments')->select('*')->where('comment_author', $user_id)->where('article_id', $article_id)->get()->all();
    }

    /**
     * @access public
     * @param int $article_id
     * @param int $user_id
     * @desc Get article feedback
     * @return array
     */
    public static function getArticleFeedback($article_id, $user_id)
    {
        return DB::table('comments')
            ->select()
            ->where('article_id', $article_id)
            ->where('comment_author', $user_id)
            ->get()->all();

    }

    /**
     * @access public
     * @param int $article_id
     * @param string $roleType
     * @desc Get article comments by user role
     * @return array
     */
    public static function getArticleComments($article_id, $roleType)
    {
        return DB::table('comments')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'comments.comment_author')
            ->join('users', 'users.id', '=', 'comments.comment_author')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('comments.*', 'users.name')
            ->where('comments.article_id', '=', $article_id)
            ->where('roles.role_type', '=', $roleType)
            ->orderBy('comments.created_at', 'desc')
            ->get()->all();
    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get article comments by superadmin or author
     * @return array
     */
    public static function getAdminArticleFeedbacks($article_id, $status)
    {
        $roles = ['superadmin', 'editor'];
        return DB::table('comments')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'comments.comment_author')
            ->join('users', 'users.id', '=', 'comments.comment_author')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('comments.*', 'users.name', 'roles.role_type')
            ->where('comments.article_id', '=', $article_id)
            ->where('comments.status', '=', $status)
            ->whereIn('roles.role_type', $roles)
            ->orderBy('comments.created_at', 'desc')
            ->groupBy('comments.comment_author')
            ->get()->all();
    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get article comments 
     * @return array
     */
    public static function getAdminArticleComments($article_id)
    {
        return DB::table('comments')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'comments.comment_author')
            ->join('users', 'users.id', '=', 'comments.comment_author')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('comments.*', 'users.name', 'roles.role_type')
            ->where('comments.article_id', $article_id)
            ->orderBy('comments.created_at', 'desc')
            ->get()->all();
    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get article corresponding author
     * @return array
     */
    public static function getArticleCorrespondingAuthor($article_id)
    {
        return DB::table('users')
            ->join('articles', 'articles.corresponding_author_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.sur_name', 'users.email')
            ->where('articles.id', '=', $article_id)
            ->get()->all();
    }

    /**
     * @access public
     * @param int $edition_id
     * @desc Get article edition
     * @return collection
     */
    public static function getArticleEdition($edition_id)
    {
        return DB::table('editions')->select('id', 'title')->where('id', $edition_id)->get()->first();
    }

    /**
     * @access public
     * @param string $status
     * @param int $article_id
     * @param array $reviewers
     * @desc Assign article to reviewer
     * @return \Illuminate\Http\Response
     */
    public static function SaveArticleReviewers($status, $article_id, $reviewers = array())
    {
        if (!empty($status) && !empty($article_id) && !empty($reviewers)) {
            foreach ($reviewers as $reviewer_id) {
                $reviewer_article = DB::table('reviewers')->insert(
                    [
                        'status' => $status, 'reviewer_id' => $reviewer_id, 'article_id' => $article_id,
                        'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()
                    ]
                );

            }
            return $reviewer_article;
        }

    }

    /**
     * @access public
     * @param int $reviewer_id
     * @param int $article_id
     * @param string $status
     * @desc Update reviewer status
     * @return \Illuminate\Http\Response
     */
    public static function updateReviewerStatus($reviewer_id, $article_id, $status)
    {
        if (!empty($reviewer_id) && !empty($article_id) && !empty($status)) {
            return DB::table('reviewers')
                ->where('reviewer_id', $reviewer_id)
                ->where('article_id', $article_id)
                ->update(['status' => $status]);
        }

    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get reviewer id by article
     * @return array
     */
    public static function getReviewerIdByArticle($article_id)
    {
        if (!empty($article_id) && is_numeric($article_id)) {
            return DB::table('reviewers')->select('reviewer_id')
                ->where('article_id', $article_id)
                ->get()->pluck('reviewer_id')->toArray();
        }
    }

    /**
     * @access public
     * @param int $reviewer_id
     * @param string $status
     * @desc Get reviewer articles
     * @return collection
     */
    public static function getReviewerArticles($reviewer_id, $status)
    {
        if (!empty($reviewer_id) && is_numeric($reviewer_id) && !empty($status) && is_string($status)) {
            return DB::table('articles')
                ->join('reviewers', 'articles.id', '=', 'reviewers.article_id')
                ->select(
                    'articles.id',
                    'articles.title',
                    'articles.abstract',
                    'articles.excerpt',
                    'articles.submitted_document',
                    'article_category_id',
                    'articles.unique_code',
                    'articles.created_at',
                    'articles.corresponding_author_id',
                    'reviewers.status'
                )
                ->where('reviewers.reviewer_id', '=', $reviewer_id)
                ->where('reviewers.status', '=', $status)
                ->groupBy('articles.id')
                ->paginate(10);
        }
    }

    /**
     * @access public
     * @param int $reviewer_id
     * @param string $status
     * @param string $search_key
     * @desc Get reviewer article by search key
     * @return collection
     */
    public static function getReviewerArticlesBySearchKey($reviewer_id, $status, $search_key)
    {
        if (!empty($reviewer_id) && !empty($status) && !empty($search_key)) {
            return DB::table('articles')
                ->join('reviewers', 'articles.id', '=', 'reviewers.article_id')
                ->select('articles.*', 'reviewers.status')
                ->where('reviewers.reviewer_id', '=', $reviewer_id)
                ->where('reviewers.status', '=', $status)
                ->where('articles.title', 'like', $search_key . '%')
                ->groupBy('articles.id')
                ->get();
        }
    }

    /**
     * @access public
     * @param int $reviewer_id
     * @param string $status
     * @param int $article_id
     * @desc Get Reviewer Articles Detail
     * @return array
     */
    public static function getReviewerArticlesDetail($reviewer_id, $status, $article_id)
    {
        if (!empty($reviewer_id) && !empty($status) && !empty($article_id)) {
            return DB::table('articles')
                ->join('reviewers', 'articles.id', '=', 'reviewers.article_id')
                ->select(
                    'articles.id',
                    'articles.title',
                    'articles.abstract',
                    'articles.submitted_document',
                    'article_category_id',
                    'articles.unique_code',
                    'articles.created_at',
                    'reviewers.status',
                    'articles.corresponding_author_id'
                )
                ->where('reviewers.reviewer_id', '=', $reviewer_id)
                ->where('reviewers.status', '=', $status)
                ->where('articles.id', '=', $article_id)
                ->get()->all();
        }
    }

    /**
     * @access public
     * @param string $status
     * @param int $author_id
     * @desc Get Author articles by status
     * @return array
     */
    public static function getAuthorArticlesByStatus($status, $author_id)
    {
        if (!empty($status) && !empty($author_id)) {
            return DB::table('articles')
                ->where('status', $status)->where('corresponding_author_id', $author_id)->orderBy('updated_at', 'desc')->paginate(10);
        }
    }

    /**
     * @access public
     * @param string $status
     * @param int $author_id
     * @param string $search_key
     * @desc Get author articles by search
     * @return array
     */
    public static function getAuthorArticlesBySearchKey($status, $author_id, $search_key)
    {
        if (!empty($status) && !empty($author_id) && !empty($search_key)) {
            return DB::table('articles')
                ->where('status', $status)->where('corresponding_author_id', $author_id)->where('title', 'like', '%' . $search_key . '%')
                ->paginate(10);
        }
    }

    /**
     * @access public
     * @param int $user_id
     * @desc Get author notifications
     * @return array
     */
    public static function getAuthorNotification($user_id)
    {
        if (!empty($user_id) && is_numeric($user_id)) {
            return DB::table('articles')->select('author_notify')->where('corresponding_author_id', $user_id)->get()->all();
        }
    }

    /**
     * @access public
     * @param int $edition_id
     * @desc Get article comments by edition id
     * @return array
     */
    public static function getArticleDocumentByEdition($edition_id)
    {
        if (!empty($edition_id) && is_numeric($edition_id)) {
            return DB::table('articles')
                ->join('editions', 'editions.id', '=', 'articles.edition_id')
                ->join('users', 'users.id', '=', 'articles.corresponding_author_id')
                ->select(
                    'articles.id',
                    'articles.submitted_document',
                    'articles.corresponding_author_id',
                    'articles.excerpt',
                    'users.name',
                    'articles.title'
                )
                ->where('articles.edition_id', '=', $edition_id)
                ->get()->all();
        }
    }

    /**
     * @access public
     * @desc Get publish articles 
     * @return array
     */
    public static function getPublishedArticle()
    {
        return DB::table('articles')
            ->join('editions', 'editions.id', '=', 'articles.edition_id')
            ->select('articles.*')
            ->where('articles.publish_document', '!=', null)
            ->where('articles.edition_id', '!=', null)
            ->where('editions.edition_status', 1)
            ->limit(5)->get()->all();
    }

        public static function getPublishedDownloadedArticle()
    {
        return DB::table('articles')
            ->join('editions', 'editions.id', '=', 'articles.edition_id')
            ->select('articles.*')
            ->where('articles.publish_document', '!=', null)
            ->where('articles.edition_id', '!=', null)
            ->where('editions.edition_status', 1)
            ->where('download_cnt', '>', 0)
            ->orderBy('download_cnt', 'desc')
            ->limit(5)->get()->all();
    }

    /**
     * @access public
     * @param int $article_id
     * @desc Get edition price by assign article
     * @return array
     */
    public static function getEditionPriceByAssignArticle($article_id)
    {
        return DB::table('editions')
            ->join('articles', 'articles.edition_id', '=', 'editions.id')
            ->select('editions.edition_price', 'editions.edition_status')
            ->where('articles.id', '=', $article_id)
            ->get()->all();

    }

    /**
     * @access public
     * @param int $article_id
     * @desc Articles with edition id 
     * @return array
     */
    public static function checkArticleEditionID($article_id)
    {
        if (!empty($article_id)) {
            return DB::table('articles')
                ->select('edition_id')
                ->where('id', '!=', $article_id)
                ->get();
        }
    }

    /**
     * @access public
     * @param int $article_id
     * @desc get article authors
     * @return array
     */
    public static function getArticleAuthors($article_id)
    {
        if (!empty($article_id)) {
            return DB::table('authors')
                ->join('author_article', 'author_article.author_id', '=', 'authors.id')
                ->join('articles', 'articles.id', '=', 'author_article.article_id')
                ->select('authors.name', 'authors.email')
                ->where('articles.id', '=', $article_id)
                ->get()->all();
        }
    }

    /**
     * @access public
     * @param int $author_id
     * @desc Get articles by author
     * @return collection
     */
    public static function getArticlesByAuthorID($author_id)
    {
        if (!empty($author_id)) {
            return DB::table('articles')->select('id', 'title')
                ->where('corresponding_author_id', $author_id)->get()->first();
        }
    }

    /**
     * @access public
     * @param string $keyword
     * @param array $categories
     * @param array $editions
     * @param string $sort_by
     * @param int $total_records
     * @desc Get Filter Articles
     * @return array
     */
    public static function getFilterArticles($keyword = "", $categories = array(), $editions = array(), $sort_by = "", $total_records)
    {
        $query = '';
        $query = DB::table('articles')->join('editions', 'editions.id', '=', 'articles.edition_id')->select('articles.*');
        if (!empty($keyword)) {
            $query->where('articles.title', 'like', '%' . $keyword . '%');
        }
        if (!empty($categories)) {
            $query->whereIn('articles.article_category_id', $categories);
        }
        if (!empty($editions)) {
            $query->whereIn('articles.edition_id', $editions);
        }
        $query->where('articles.status', 'accepted_articles');
        $query->where('articles.edition_id', '!=', null);
        $query->where('editions.edition_status', '=', 1);
        return $query->orderBy($sort_by, 'asc')->limit($total_records)->get()->all();
    }

    /**
     * @access public
     * @param string $file_name
     * @desc Get article name
     * @return string
     */
    public static function getArticleFullName($file_name)
    {
        if (!empty($file_name)) {
            $file_parts = explode('-', $file_name);
            $extension = explode('.', $file_name);
            unset($file_parts[0]);
            array_pop($file_parts);
            return implode('-', $file_parts) . "." . $extension[1];
        }
    }
}
