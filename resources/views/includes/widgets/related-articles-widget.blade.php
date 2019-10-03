@php 
    $editionID = Request::segment(4); 
    $articleID = Request::segment(5); 
    $published_articles = App\Edition::getPublishedRelatedArticles($editionID,$articleID);
@endphp 
@if (!empty($published_articles))
    <div class="sj-widget sj-widgetrelatedarticles">
        <div class="sj-widgetheading">
            <h3>{{{trans('prs.related_articles')}}}</h3>
        </div>
        <div class="sj-widgetcontent">
            <ul>
                @foreach ($published_articles as $article) 
                    @php $author = App\User::getUserDataByID($article->corresponding_author_id); @endphp
                    <li>
                        <span class="sj-username">{{{$author->name}}}</span>
                        <a href="{{{url('/published/article/detail/'.$article->edition_id.'/'.$article->id.'')}}}">
                            <div class="sj-description">{{{$article->title}}}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif