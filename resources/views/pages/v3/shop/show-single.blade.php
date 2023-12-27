<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $package->name(),
        'description' => $package->summary(),
        'class' => 'package-single',
        'attributes' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Loja de Recompensas'),
            'route' => route('shop.index')
        ],
        [
            'title' => $package->name()
        ],
    ]
])

@section('page_content')

    <div class="row">

        <form method="post" action="{{$package->orderUrl()}}">
            {{csrf_field()}}

            <div class="col-md-4">
                <div class="text-center">
                    <div class="main-image">
                        <img src="{{$package->image()}}">
                    </div>

                    @if($package->hasLabel())
                        <div class="label label-theme top-left">
                            {{$package->label()}}
                        </div>
                        <br>
                    @endif

                    <div class="hidden-md hidden-lg main-title">
                        <h1 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                        </h1>
                    </div>

                    <?php
                    $percentage = calcPercentage($package->limit(), $package->usage());
                    ?>

                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                             aria-valuemax="100" style="width: {{$percentage}}%">
                        </div>

                        <div class="detail">
                            {{$package->displayLimits()}}

                            @if($package->limit())
                                <i>({{$percentage}}%)</i>
                            @endif
                        </div>
                    </div>

                    @if($package->tokenPrice() > 0)
                        <p>
                            <strong>

                                @if($package->discount())
                                    Preço<br>
                                    {!! $package->displayTokenPrice() !!}
                                @else
                                    Preço: {!! $package->displayTokenPrice() !!}
                                @endif

                            </strong>
                        </p>
                    @endif
                </div>

                <div class=" hidden-sm hidden-xs">
                    @if(auth()->check())
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @include('partials.v3.button', [
                                    'element' => 'button',
                                    'type' => 'submit',
                                    'title' => 'Pedir agora &raquo;',
                                    'class' => 'btn-theme-rock'
                                ])
                            </div>

                            <div class="col-md-12 text-center">
                                <br>
                            </div>

                            <div class="col-md-12 text-center">
                                @if( SiteHelper::featureEnabled('tokens'))
                                    @include('partials.v3.button', [
                                        'route' => GameserverApp\Helpers\RouteHelper::token(),
                                        'title' => 'Obter tokens',
                                    ])
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8">

                <div class="hidden-sm hidden-xs main-title">
                    <h1 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                    </h1>
                </div>
                <br>

                @component('partials.v3.frame', [
                    'type' => 'big'
                ])
                    {!! Markdown::convertToHtml($package->description()) !!}

                    @if(
                        $package->cluster or
                        $package->gameserver or
                        (
                            auth()->check() and
                            (
                                $package->requiresCharacterSelect()
                                or
                                (
                                    $package->requiresDiscordConnected() and
                                    !auth()->user()->hasDiscordSetup()
                                )
                            )
                        )
                    )
                        <hr>
                    @endif

                    @if($package->cluster)
                        <div class="alert alert-warning">
                            <span>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Entrega apenas no cluster <strong>{{$package->cluster}}</strong>!
                            </span>
                        </div>
                    @endif

                    @if($package->gameserver)
                        <div class="alert alert-warning">
                            <span>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Entrega apenas no servidor de jogo <strong>{{$package->gameserver}}</strong>!
                            </span>
                        </div>
                    @endif

                    @if(auth()->check() and $package->requiresCharacterSelect())
                        @if($package->hasCharacters())
                            <div class="text-center">
                                <label>Entregar para:</label>
                                <select name="character_id">
                                    @foreach($package->characters() as $character)
                                        <option @if($character->online()) selected @endif value="{{$character->id}}">
                                            {{$character->name()}}

                                            @if($character->online()) [online] @endif

                                            @if($character->hasServer())
                                                ({{$character->server->name}})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                Você não tem um personagem para receber este pacote da loja.
                            </div>
                        @endif
                    @endif
                @endcomponent


                @if(auth()->check())
                    <div class=" hidden-md hidden-lg">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if(
                                    $package->requiresDiscordConnected() and
                                    !auth()->user()->hasDiscordSetup()
                                )
                                    <div class="alert alert-danger">
                                        Você precisa <a href="{{route('user.settings', auth()->user()->id)}}">conectar o seu Discord</a> para pedir este pacote.
                                    </div>
                                    <br>
                                @else
                                    @include('partials.v3.button', [
                                        'element' => 'button',
                                        'type' => 'submit',
                                        'title' => 'Pedir agora &raquo;',
                                        'class' => 'btn-theme-rock'
                                    ])
                                @endif
                            </div>

                            <div class="col-md-12 text-center">
                                <br>
                            </div>

                            <div class="col-md-12 text-center">
                                @if( SiteHelper::featureEnabled('tokens'))
                                    @include('partials.v3.button', [
                                        'route' => GameserverApp\Helpers\RouteHelper::token(),
                                        'title' => 'Obter tokens',
                                    ])
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                @else
                    <div class="alert alert-info">
                        Por favor, <a href="{{route('auth.login')}}">faça login</a> para fazer um pedido.
                    </div>
                @endif
                <br>

                @component('partials.v3.frame', ['type' => 'basic'])
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Quando vou receber?</h6>
                            <p>
                                Seu pedido é entregue automaticamente quando você está online. Isso geralmente leva menos de 1 minuto. Você será notificado no jogo sobre o status.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Não estou online no momento</h6>
                            <p>
                                O sistema de entrega esperará você ficar online. Você tem 7 dias para retirar o seu pedido.
                            </p>
                        </div>
                    </div>
                @endcomponent

            </div>

        </form>
    </div>

@stop