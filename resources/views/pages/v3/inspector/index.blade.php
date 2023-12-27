<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('inspector', 'Inspector'),
        'description' => 'Pesquise todos os personagens e grupos na comunidade.',
        'class' => 'inspetor'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('inspector', 'Inspector')
        ]
    ]
])

@section('page_content')

    <form method="get" action="{{route('inspector.index')}}">
        <div class="row">

            <div class="col-sm-12 text-center">
            {{--                    <h3 class="title">{{translate('search', 'Search')}}:</h3>--}}
                <input type="text" class="form-control search" name="search" value="{{request('search')}}" placeholder="Pesquisar por..." autofocus>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-9">

                <h5>
                    Encontrados {{$results->total()}}
                    @if( $results->total() == 1 )
                        resultado
                    @else
                        resultados
                    @endif
                </h5>

                <?php
                $chunkSize = 2;

                if ($results->first() instanceof GameserverApp\Models\Group) {
                    $chunkSize = 2;
                }
                ?>

                @forelse( $results->chunk($chunkSize) as $chunks )
                    <div class="row">
                        @foreach($chunks as $result)
                            @if( $result instanceof GameserverApp\Models\Character)
                                <div class="col-sm-6 results">
                                    @include('partials.v3.character-card', [
                                        'character' => $result
                                    ])
                                </div>
                            @endif

                            @if( $result instanceof GameserverApp\Models\Group)
                                <div class="col-sm-6 results">
                                    @include('partials.v3.group-card', [
                                        'group' => $result
                                    ])
                                </div>
                            @endif
                        @endforeach
                    </div>
                @empty
                    <div class="col-md-6 center-block">
                        <br>
                        <div class="text-center">
                            <h2>Sem resultados...</h2>
                            <p>
                                Tente algo diferente!
                            </p>
                        </div>
                    </div>
                @endforelse

                @if( method_exists($results, 'links') )
                    <div class="paginate">
                        {{$results->appends(Request::except('page'))->links()}}
                    </div>
                @endif
            </div>

            <div class="col-sm-3">
                <h5>Filtros</h5>

                @component('partials.v3.frame', ['type' => 'basic'])
                    @include('pages.v3.inspector._filters')
                @endcomponent

                @include('partials.v3.button', [
                    'type' => 'submit',
                    'element' => 'button',
                    'title' => translate('search', 'Pesquisar'),
                    'class' => 'center'
                ])
            </div>

        </div>
    </form>

@stop