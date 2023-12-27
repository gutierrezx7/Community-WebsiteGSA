<?php
use GameserverApp\Helpers\SiteHelper;
?>

<div class="forum-activity">
    <h1>
        Última atividade no fórum
    </h1>

    <ul>
        @forelse( $lastForumThreads as $thread )
            <li>
                <article itemid="{{ Forum::route('thread.show', $thread) }}" itemscope itemtype="http://schema.org/DiscussionForumPosting">
                    <div class="title-category">
                        <h1 class="title">
                            <a href="{{ Forum::route('thread.show', $thread->lastPost) }}">
                                <span itemprop="headline">{{$thread->title}}</span>
                            </a>
                        </h1>
                        <div class="count badge"  itemprop="interactionStatistic" itemscope itemtype="http://schema.org/InteractionCounter">
                            <link itemprop="interactionType" href="http://schema.org/CommentAction" />
                            <span itemprop="userInteractionCount">{{$thread->reply_count}}</span>
                        </div>
                    </div>

                    <div class="meta">
                        <a class="category label label-theme alternative" href="{{ Forum::route('category.show', $thread->category) }}">
                            {{$thread->category->title}}
                        </a>

                        <time datetime="{{$thread->lastPost->date('updated_at')->toDateTimeString()}}" itemprop="datePublished">
                            {{ $thread->lastPost->date('updated_at')->diffForHumans() }}
                        </time>
                        <span class="author" itemprop="author">
                            @if(SiteHelper::featureEnabled('user_page'))
                                por {!! $thread->lastPost->author->showLink() !!}
                            @else
                                por {!! $thread->lastPost->author->showName() !!}
                            @endif
                        </span>
                    </div>
                </article>
            </li>
        @empty
            <li><em>Nenhuma postagem encontrada</em></li>
        @endforelse
    </ul>
    @if($lastForumThreads)

        <a href="{{route('forum.index')}}" class="btn btn-theme btn-theme-rock">
            <span>
                Fórum &raquo;
            </span>
        </a>
    @endif
</div>