<?php
use GameserverApp\Helpers\PremiumHostedHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Falha na Conexão',
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin', 'title' => 'Falha ao Conectar ao Discord'])
                <p>
                    Algo deu errado ao conectar sua conta do Discord.<br>
                    Tente novamente ou entre em contato com o administrador.
                </p>

                <br>

                <img src="https://media.giphy.com/media/EizPK3InQbrNK/giphy.gif">

                <br><br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-theme btn-theme-rock" href="{{config('gameserverapp.connection.oauth_base_url')}}frontend/oauth/discord/user?client_id={{PremiumHostedHelper::clientId()}}"><span>Tente Novamente</span></a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>

@stop