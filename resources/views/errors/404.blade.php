@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Página não encontrada',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])
@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin'])
                <h1>Página não encontrada</h1>

                <p>
                    Parece que esta página não existe mais ou foi movida para uma nova localização.
                </p>

                <br>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <a class="btn btn-theme" href="{{url()->previous()}}"><span>Página anterior</span></a>
                    </div>
                    <div class="col-md-6 text-center">
                        <a class="btn btn-theme btn-theme-rock" href="/"><span>Início</span></a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>

@stop