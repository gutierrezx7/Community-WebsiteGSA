@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Discord conectado!',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin', 'title' => 'Seu Discord está agora conectado'])

                <p>
                    Prepare-se para um pouco de magia de bot!
                </p>

                <br>

                <img src="https://media.giphy.com/media/opmIBtljGbwZi/giphy.gif">

            @endcomponent
        </div>
    </div>

@stop