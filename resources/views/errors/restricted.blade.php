@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Entrar em ' . GameserverApp\Helpers\SiteHelper::name(),
        'description' => '',
        'class' => 'error pagebuilder'
    ],
])

@section('banner_content')
@stop

@section('page_content')

    <div class="row padding-2">
        <div class="col-md-6 center-block">
            @component('partials.v3.frame', ['class' => 'text-center no-bottom-margin', 'type' => 'big'])
                <h1>
                    <i class="fa fa-child"></i>
                    Entrar em {{GameserverApp\Helpers\SiteHelper::name()}}
                </h1>

                <p>
                    <strong>Para visualizar esta página, você precisa fazer login.</strong>
                    <br><br>
                    Você pode fazer login usando sua conta STEAM ou Epic. Isso é rápido e seguro.<br/>
                    Mesmo que você ainda não tenha jogado em um de nossos servidores.
                </p>

                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a class="btn btn-theme btn-theme-rock" href="{{route('auth.login')}}">
                            <span>Fazer Login</span>
                        </a>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
@stop