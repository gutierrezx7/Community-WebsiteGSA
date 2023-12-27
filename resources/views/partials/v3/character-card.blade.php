<?php
use GameserverApp\Helpers\SiteHelper;
?>

@component('partials.v3.frame', ['type' => 'basic'])
    <article class="character-card" itemscope itemtype="http://schema.org/Person">
        <div class="row">

            <div class="col-md-5 character text-center">
                <a href="{{route('character.show', $character->id)}}">
                    <img src="{{$character->image()}}" class="image">
                </a>
            </div>

            <div class="col-md-7 account">

                <h5>
                    {!! $character->showLink(['limit' => 13]) !!}
                </h5>

                <div class="summary">

                    @if($character->hasGame() and $character->game->supportLevel())
                        <div>
                            Nível: {{$character->level}}
                        </div>
                    @endif

                    <div>
                        Jogado: {{$character->hoursPlayed()}} horas
                    </div>

                    @if(GameserverApp\Helpers\SiteHelper::featureEnabled('player_status'))
                        @if( $character->online() )
                            <div>
                                Online desde: {{str_replace('minutes', 'min.', $character->date('status_since')->diffForHumans())}}
                            </div>
                        @else
                            <div>
                                Último acesso: {{$character->date('status_since')->diffForHumans()}}
                            </div>
                        @endif
                    @endif

                    <div>
                        Criado: {{$character->date('created_at')->diffForHumans()}}
                    </div>
                    <div>
                        Servidor:
                        @if($character->hasServer())
                            {{$character->server->name(13)}}
                        @endif
                    </div>

                    <br>

                    <div class="owner">
                        Proprietário:
                        @if($character->hasUser())
                            {!! $character->user->showLink(['limit' => 12]) !!}
                        @endif
                    </div>

                    @if( $character->hasGroup() )
                        <div  class="tribe">
                            {{ ucfirst(GameserverApp\Helpers\SiteHelper::groupName())}}:
                            @if( $character->hasGroup() )
                                <span itemprop="memberOf">
                                    {!! $character->groups[0]->showLink(['limit' => 13]) !!}
                                </span>
                            @endif
                        </div>
                    @else
                        <br>
                    @endif

                    <br>

                    <div class="buttons">
                        @if(
                            !$character->hasGroup() and
                            $character->hasUser() and
                            (
                                (
                                    !auth()->check()
                                ) or
                                (
                                    auth()->check() and
                                    auth()->user()->canSendMessage()
                                )
                            )
                        )
                            @include('partials.v3.button', [
                                'route' => route('message.create', $character->user->id),
                                'title' => 'Recrutar',
                                'class' => 'btn-theme-rock tiny'
                            ])
                        @endif

                        @if(
                            $character->hasUser() and
                            (
                                (
                                    !auth()->check()
                                ) or
                                (
                                    auth()->check() and
                                    auth()->user()->canSendMessage()
                                )
                            )
                        )
                            @include('partials.v3.button', [
                                'route' => route('message.create', $character->user->id),
                                'title' => 'Enviar mensagem',
                                'class' => 'tiny'
                            ])
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </article>
@endcomponent