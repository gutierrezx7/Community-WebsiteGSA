@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Estatísticas - ' . $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-12">

            @include('pages.v3.group._graph', [
                'title' => 'Horas jogadas',
                'data' => $stats['hours-played']
            ])

        </div>
    </div>

    @isset($stats['levels-gained'])
        <div class="row">
            <div class="col-md-12">

                @include('pages.v3.group._graph', [
                    'title' => 'Progresso de nível',
                    'data' => $stats['levels-gained']
                ])

            </div>
        </div>
    @endisset

    @isset($stats['xp-gained'])
        <div class="row">
            <div class="col-md-12">

                @include('pages.v3.group._graph', [
                    'title' => 'Progresso de EXP',
                    'data' => $stats['xp-gained']
                ])

            </div>
        </div>
    @endisset
@stop