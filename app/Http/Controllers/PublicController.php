<?php

/**
 * @package Scientific-Journal
 * @version 1.0
 * @author Amentotech <theamentotech@gmail.com>
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use View;
use App\Edition;
use App\SiteManagement;
use DB;
use App\Article;
use App\Category;
use Illuminate\Support\Facades\Input;
use Session;
use App\Page;
use App\Helper;

class PublicController extends Controller

{
    /**
     * @access public
     * @desc Get published article file from storage.
     * @param string $publish_file
     * @return \Illuminate\Http\Response
     */
    function getPublishFile($publish_file)
    {
        if (!empty($publish_file)) {
            $file_parts = explode('-', $publish_file);
            $article_id = $file_parts[0];
            $article = DB::table('articles')->where('id', $article_id)->get();
            $cur_download_cnt = $article[0]->download_cnt;
            $real_download_cnt = $cur_download_cnt+1;
            $data = array(
                'download_cnt'=>$real_download_cnt
            );
            DB::table('articles')->where('id', $article_id)->update($data);
            return Storage::download('uploads/articles_pdf/' . $article_id . '/' . $publish_file);
        }
    }

    /**
     * @access public
     * @desc Get published article from database.
     * @param string $slug
     * @return array
     */
    public function showPublishArticle($slug)
    {
        $published_articles = Edition::getPublishedEditionArticles($slug);
        $title = $published_articles[0]->edition_title;
        return View::make('editions.index', compact('published_articles', 'slug', 'title'));
    }

    /**
     * @access public
     * @desc Display the specified resource.
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = DB::table('articles')->where('slug', $slug)->first();
        $payment_detail = SiteManagement::getMetaValue('payment_settings');
        $currency_symbol = !empty($payment_detail) && !empty($payment_detail[0]['currency']) ? $payment_detail[0]['currency'] : '';
        $article_edition = Edition::getEditionByArticleID($article->id);
        $edition_slug = $article_edition->slug ;
        $edition_title = $article_edition->title ;
        $meta_desc = !empty($article) ? $article->excerpt : '';
        return View::make(
            'editions.show',
            compact(
                'article', 'payment_detail', 'currency_symbol',
                'edition_slug', 'edition_title', 'meta_desc'
            )
        );
    }

    /**
     * @access public
     * @desc Display the search result
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function filterEdition(Request $request)
    {
        $categories = Category::getCategories()->all();
        $editions = Edition::getPublishedEdition();
        if (!empty($request['s']) || !empty($request['category']) || !empty($request['edition']) || !empty($request['sort']) || !empty($request['show'])) {
            $keyword = $request['s'];
            $requested_category = $request['category'];
            $requested_editions = $request['edition'];
            $sort_by = $request['sort'];
            if (!empty($sort_by)) {
                if ($sort_by == 'date') {
                    $sort_by = "created_at";
                } else {
                    $sort_by = $request['sort'];
                }
            } else {
                $sort_by = "created_at";
            }
            $total_records = $request['show'];
            $published_articles = Article::getFilterArticles($keyword, $requested_category, $requested_editions, $sort_by, $total_records);
            if (!empty($published_articles)) {
                return View::make('editions.all_published_articles', compact('published_articles', 'categories', 'editions', 'requested_category', 'requested_editions'))->withInput(Input::all());
            } else {
                $published_articles = array();
                Session::flash('message', trans('prs.record_not_found'));
                return View::make('editions.all_published_articles', compact('published_articles', 'categories', 'editions'))->withInput(Input::all());
            }
        } else {
            $published_articles = Article::getPublishedArticle();
            return View::make('editions.all_published_articles', compact('published_articles', 'categories', 'editions'))->withInput(Input::all());
        }
    }

    /**
     * @access public
     * @desc Display the specified resource.
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function showDetailPage($slug)
    {
        $page = Page::getPageData($slug);
        $meta = DB::table('sitemanagements')->where('meta_key', 'seo-desc-'.$page->id)->select('meta_value')->pluck('meta_value')->first();
        $meta_desc = !empty($meta) ? $meta : '';
        return View::make('admin.pages.show', compact('page', 'slug', 'meta_desc'));
    }

    public function checkServerAuthentication()
    {
        $server = Helper::ajax_journal_is_demo_site();
        if (!empty($server)) {
            $response['message'] = $server->getData()->message;
            return $response;
        }
    }

    public function detail($id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }

        $journal = DB::table('categories')->where('id',$id)->get();
        return View::make('journal_detail')->with('journal', $journal);

    }

        public function published_articles($id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }

        $journal = DB::table('categories')->where('id',$id)->get();
        return View::make('published_articles')->with('journal', $journal);

    }

    public function author_guideline($id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }

        $journal = DB::table('categories')->where('id',$id)->get();
        return View::make('author_guideline')->with('journal', $journal);

    }

    public function journal_by_category($id)
    {
        $server_verification = Helper::journal_is_demo_site();
        if (!empty($server_verification)) {
            Session::flash('error', $server_verification);
            return Redirect::back();
        }

        $journal = DB::table('categories')->join('category_list', 'category_list.id', '=', 'categories.category_list')->where('categories.category_list',$id)->get();
        return View::make('journal_by_category')->with('journal', $journal);

    }
}
