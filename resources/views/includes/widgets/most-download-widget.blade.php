@php $articles = App\Article::getPublishedDownloadedArticle(); @endphp
@if (!empty($articles))
    <div class="sj-widget sj-widgetrelatedarticles">
        <div class="sj-widgetheading">
            <h3 style="text-align: center; line-height: 20px;">Most downloaded Manuscripts</h3>
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
