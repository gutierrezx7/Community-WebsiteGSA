<div data-id="{{$server->id}}" class="@if($server->slots()) loaded @endif server-block-{{$server->id}} server-block {{$server->getCssClass()}}">

    @if($server->hasBackground())
        <div class="background" style="background-image:url('{{$server->background}}')"></div>
    @endif

    <div class="top-nav">
        <div class="vote">
            @if($server->hasVoteSites())
                <button type="button" class="btn btn-theme small" data-toggle="modal" data-target="#voteServer{{$server->id}}">
                    <span>
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        Votar
                    </span>
                </button>
            @endif
        </div>

        @if(!isset($status) and !$server->slots())

            <span class="preload">
                <div class="loader"></div>
            </span>

        @elseif($server->isScheduled())
            @if($server->isScheduledForUpdate())
                <span class="status_message">
                    @if( $server->date('update_at') > Carbon\Carbon::now() )
                        Atualização automática: {{$server->date('update_at')->diffForHumans()}}
                    @else
                        Atualização e inicialização automáticas em andamento...
                    @endif
                </span>
            @elseif($server->isScheduledForShutdown())
                <span class="status_message">
                    @if( $server->date('shutdown_at') > Carbon\Carbon::now() )
                        Desligamento: {{$server->date('shutdown_at')->diffForHumans()}}
                    @else
                        Desligamento em andamento...
                    @endif
                </span>
            @elseif($server->isScheduledForRestart())
                <span class="status_message">
                    @if( $server->date('restart_at') > Carbon\Carbon::now() )
                        Reinício: {{$server->date('restart_at')->diffForHumans()}}
                    @else
                        Reinício em andamento...
                    @endif
                </span>
            @endif
            <span class="status update"></span>
        @else
            <div class="version">
                @if(!empty($server->version))
                    v{{$server->version}}
                @endif
                @if($server->slots() !== false and $server->onlinePlayers() !== false)
                    &nbsp; &nbsp; <strong>{{$server->onlinePlayers()}}/{{$server->slots()}}</strong>
                @endif
            </div>

            @if( $server->online() )
                <span class="status online"></span>
            @elseif(!is_null($server->online()))
                <span class="status offline"></span>
            @endif
        @endif
    </div>

    <div class="server-block-content">

        <h2 class="title">{{$server->name()}}</h2>


        <a href="steam://connect/{{$server->connectAddress()}}" class="join-btn btn btn-theme">
            <span>
                Clique para entrar &raquo;
            </span>
        </a>

        <div class="info">

            @if($server->twitchSubOnly())
                <span class="label label-theme" target="_blank">
                    <a href="{{route('user.settings', 'me')}}">Apenas subscritores</a>
                </span>
            @endif

            <span>
                {{$server->connectAddress()}}
            </span>

            @if(!empty($server->cluster_name))
                <span class="cluster_name">
                    // {{$server->cluster_name}}
                </span>
            @endif

        </div>
    </div>

</div>

@push('modal_content')
    @include('partials.v3.server-vote')
@endpush