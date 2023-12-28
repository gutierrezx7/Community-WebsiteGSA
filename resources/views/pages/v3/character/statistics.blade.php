@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Estatísticas - ' . $character->name(),
        'description' => '',
        'class' => 'character-single',
        //'bg' => $character->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.character._header')

    <div class="row">
        <div class="col-md-12">

{{--            todo add stream block--}}


            @if(isset($stats['levels-gained']) or isset($stats['xp-gained']))
                <div class="row">

                    @isset($stats['levels-gained'])
                        <div class="col-md-6">

                            @include('pages.v3.character._graph', [
                                'title' => 'Progresso do nível',
                                'data' => $stats['levels-gained']
                            ])

                        </div>
                    @endisset

                    @isset($stats['xp-gained'])
                        <div class="col-md-6">

                            @include('pages.v3.character._graph', [
                                'title' => 'Progresso de EXP',
                                'data' => $stats['xp-gained']
                            ])

                        </div>
                    @endisset
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">

                    @include('pages.v3.character._graph', [
                        'title' => 'Horas jogadas',
                        'data' => $stats['hours-played']
                    ])

                </div>
            </div>

        </div>
    </div>
@stop