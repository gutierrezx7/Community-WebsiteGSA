@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Acalme-se!',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin'])
                <img src="https://media2.giphy.com/media/UJS4fUKBaTc8o/giphy.gif">
                <br><br><br>
                <h1>Muitas solicitações</h1>

                <p>
                    O servidor web está recebendo um grande número de solicitações. Por favor, tente novamente mais tarde.
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