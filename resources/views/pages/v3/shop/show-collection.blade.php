<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $package->name(),
        'description' => $package->summary(),
        'class' => 'package-collection',
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
        <div class="col-md-4">
            <div class="text-center">
                <div class="main-image">
                    <img src="{{$package->image()}}">
                </div>

                @if($package->hasLabel())
                    <div class="label label-theme top-left">
                        {{$package->label()}}
                    </div>
                    <br><br>
                @endif

                <div class="main-title">
                    <h2 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                    </h2>
                </div>

                {!! Markdown::convertToHtml($package->description()) !!}
            </div>

            <div class=" hidden-sm hidden-xs">
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">

                        @if(!auth()->check())
                            <div class="alert alert-info">
                                Por favor, <a href="{{route('auth.login')}}">faça login</a> para fazer um pedido.
                            </div>
                            <br>
                        @endif

                        @if( SiteHelper::featureEnabled('tokens'))
                            @include('partials.v3.button', [
                                'route' => GameserverApp\Helpers\RouteHelper::token(),
                                'title' => 'Obter tokens',
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="options-title">
                <h2 class="title text-center">
                    <span>
                        Opções de coleção
                    </span>
                </h2>
            </div>

            @forelse($package->children() as $child)
                @include('pages.v3.shop._collection-option', [
                    'item' => $child
                ])
            @empty
                <div class="alert alert-warning">

                    <em>Esta coleção não tem subpacotes. Volte mais tarde...</em>
                </div>
                <br>
            @endif

            <div class=" hidden-lg hidden-md">
                @if(auth()->check())
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if( SiteHelper::featureEnabled('tokens'))
                                @include('partials.v3.button', [
                                    'route' => GameserverApp\Helpers\RouteHelper::token(),
                                    'title' => 'Obter tokens',
                                ])
                            @endif
                        </div>
                    </div>
                    <br><br>
                @endif
            </div>

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

    </div>

@stop