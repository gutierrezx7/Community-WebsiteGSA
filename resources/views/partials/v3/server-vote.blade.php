<!-- Modal -->
<div class="modal fade" id="voteServer{{$server->id}}" tabindex="-1" role="dialog" aria-labelledby="voteServerLabel{{$server->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Votar em {{$server->name()}}</h4>
            </div>
            <div class="modal-body">

                @if(!auth()->check())
                    <div class="alert alert-danger">
                        Faça login para reivindicar seu voto.
                    </div>
                    <br>
                @endif

                <div class="row">

                    @foreach($server->vote_sites as $site)
                        <div class="col-md-6 text-center">
                            <a href="{{$site->vote_url}}" target="_blank" class="btn btn-primary">
                                @if($site->icon)
                                    <img src="{{$site->icon}}" height="15" title="{{$site->name}}" />
                                    &nbsp;
                                @endif
                                Votar em {{$site->name}}
                            </a><br><br>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(auth()->check())
                <div class="modal-footer">
                    <span>Reivindique seu prêmio após votar</span>
                    <form style="display:inline-block" method="post" action="{{route('server.claim-vote', $server->id)}}">
                        {{csrf_field()}}
                        <button class="btn btn-success btn-xs">Reivindicar</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>