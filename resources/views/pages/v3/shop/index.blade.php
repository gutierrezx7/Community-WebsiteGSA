<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('reward_shop', 'Loja de Recompensas'),
        'description' => 'Your orders are delivered in real-time.',
        'class' => 'loja'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Loja de Recompensas')
        ]
    ]
])

@section('page_content')

<div class="row">

    <div class="col-md-12 text-center">

        <div class="row">
            <div class="col-sm-8 center-block">
                <h1 class="title main-title">{{translate('reward_shop', 'Loja de Recompensas')}}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 hidden-xs">
            </div>
            <div class="col-md-4 col-xs-8">
                <form method="get">
                    <input type="search" name="search" value="{{request()->get('search')}}" placeholder="Pesquisar...">
                    <input type="hidden" name="cluster" value="{{request()->get('cluster')}}">
                    <input type="hidden" name="gameserver" value="{{request()->get('gameserver')}}">
                    <input type="hidden" name="filter" value="{{request()->get('filter')}}">
                </form>
            </div>
            <div class="col-md-4 col-xs-4">

                <select onchange="if (this.value) window.location.href=this.value">
                    <option value="{{route('shop.index')}}?search={{request()->get('search')}}">Sem filtro</option>

                    @if($filters)
                        <optgroup label="Filtros">
                            @foreach($filters as $uuid => $name)
                                <option @if(urlencode(request()->get('filter')) == $uuid) selected @endif value="{{route('shop.index')}}?search={{request()->get('search')}}&filter={{$uuid}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    @endif

                    @if($clusters)
                        <optgroup label="Itens para cluster específico">
                            @foreach($clusters as $uuid => $name)
                                <option @if(request()->get('cluster') == $uuid) selected @endif value="{{route('shop.index')}}?search={{request()->get('search')}}&cluster={{$uuid}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    @endif

                    @if($gameservers)
                        <optgroup label="Itens para servidor de jogo específico">
                            @foreach($gameservers as $id => $name)
                                <option @if(request()->get('gameserver') == $id) selected @endif value="{{route('shop.index')}}?search={{request()->get('search')}}&gameserver={{$id}}">{{$name}}</option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>
        </div>

    </div>
</div>
<br>
@if(request()->has('search'))
    <div class="row">
        <div class="col-md-8 center-block text-center">
            <h3 class="title">
                Resultados para "{{request()->get('search')}}"
            </h3>
        </div>
    </div>
@endif
<div class="row">

    @forelse( $packs as $pack )

        <div class="col-md-4 col-lg-3">
        @include('partials.v3.shop-package', [
                'item' => $pack
            ])
        </div>

    @empty
        <div class="col-md-12">
            <div class="text-center">
                <em>Nenhum pacote disponível</em>
            </div>
        </div>
    @endforelse

</div>

<div class="row">
    <div class="paginate">
        {!! $packs->appends([
            'search' => request()->get('search'),
            'cluster' => request()->get('cluster'),
            'filter' => request()->get('filter')])->links() !!}
    </div>
</div>

@stop