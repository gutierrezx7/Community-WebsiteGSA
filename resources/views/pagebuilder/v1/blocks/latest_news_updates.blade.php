<div class="news-activity">
    <h1>
        Últimas notícias e atualizações
    </h1>

    <ul>
        @forelse($lastNewsPosts as $news)
            <li>
                <article itemscope itemtype="http://schema.org/Article">
                    <div class="title-category">
                        @if($news->hasType())
                            {!! $news->presentType() !!}
                        @endif
                        <h1 class="title">
                            <a href="{{ route('news.show', [$news->id, $news->slug() ])}}"  itemprop="headline url">
                                {!! $news->title(40) !!}
                            </a>
                        </h1>
                    </div>
                    <span class="summary">
                        <a href="{{ route('news.show', [$news->id, $news->slug() ])}}">
                            <time itemprop="datePublished" datetime="{{$news->date('published_at')->toDateTimeString()}}">
                                <em>{{ $news->date('published_at')->format('d F Y') }}</em> -
                            </time>
                            <span class="description" itemprop="description">
                                {!! $news->summary() !!}
                            </span>
                        </a>
                    </span>
                </article>
            </li>
        @empty

        @endforelse
    </ul>
    <a href="{{route('news.index')}}" class="btn btn-theme btn-theme-rock ">
        <span>
            Todas as notícias &raquo;
        </span>
    </a>
</div>