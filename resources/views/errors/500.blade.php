@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Ops!',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin'])
                <img src="https://media3.giphy.com/media/3oKIPwoeGErMmaI43S/giphy.gif">
                <br><br><br>
                <h1>Um erro inesperado ocorreu!</h1>

                <p>
                    Ohh boy, parece que algo deu errado.<br>
                    Um relatório foi enviado para os desenvolvedores para verificar!
                </p>

                <br>
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