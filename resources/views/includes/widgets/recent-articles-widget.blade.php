@php $articles = App\Article::getPublishedArticle(); @endphp
@if (!empty($articles))
    <div class="sj-widget sj-widgetrelatedarticles">
        <div class="sj-widgetheading">
            <h3>{{{trans('prs.recent_articles')}}}</h3>
        </div>
        <div class="sj-widgetcontent">
            <ul>
                @foreach ($articles as $article) 
                @php $author = App\User::getUserDataByID($article->corresponding_author_id); @endphp
                <li>
                    <span class="sj-username">{{{$author->name}}}</span>
                    <div class="sj-description"><a href="{{{url('article/'.$article->slug.'')}}}">{{{$article->title}}}</a></div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
