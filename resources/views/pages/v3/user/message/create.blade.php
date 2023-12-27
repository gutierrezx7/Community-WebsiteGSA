<?php
use GameserverApp\Helpers\SiteHelper;
use Illuminate\Support\Facades\Request;

$user = $receiver;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('send_message_to', 'Enviar a mensagem para') . ' ' . $user->name(),
        'description' => 'Enviar uma mensagem para outros jogadores.',
        'class' => 'user-single'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-8 center-block">

            @include('pages.v3.user.message._form')

        </div>
    </div>

@stop