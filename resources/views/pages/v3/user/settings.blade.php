@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('suas_configuracoes', 'Suas configurações'),
        'description' => 'Gerencie suas configurações',
        'class' => 'user-single'
    ],
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">

        <div class="col-md-6">
            <form method="post" action="{{route('user.settings.store', auth()->id())}}">
                {{csrf_field()}}

                @component('partials.v3.frame', ['title' => 'Notificações'])
                    <strong>
                        Seu endereço de e-mail
                    </strong>
                    <p>
                        Em qual endereço de e-mail você deseja receber notificações?
                    </p>
                    {!! Form::email('email', old('email', auth()->user()->notifications['email']), array('class' => 'form-control', 'placeholder'=>'Seu endereço de e-mail')) !!}

                    <br>
                    @if(auth()->user()->hasEmailSetup() and !auth()->user()->emailConfirmed())
                        <div class="alert alert-warning">
                            <strong>Por favor, confirme seu endereço de e-mail clicando no link no e-mail de confirmação.</strong> <a href="{{route('user.confirm_email.resend', $user->id)}}">Reenviar confirmação</a>
                        </div>
                        <br>
                    @endif
                    <div class="alert alert-info">
                        <strong>Nós odiamos spam, assim como você!</strong><br>
                        Seu endereço de e-mail é armazenado no banco de dados GameServerApp.com e só é usado para os alertas abaixo. Seu endereço de e-mail <u>não</u> será vendido para terceiros.
                    </div>

                    <hr>

                    <strong>
                        Quando um jogador lhe envia uma mensagem
                    </strong>
                    <p class="small">
                        Apenas jogadores ativos podem enviar uma mensagem para você.
                    </p>
                    <label>
                        {!! Form::checkbox('notify_message', 1, old('notify_message', auth()->user()->notifications['notify_message'])) !!}
                        Notificar por e-mail
                    </label>

                    <hr>

                    <strong>
                        Quando um alerta é acionado
                    </strong>
                    <p class="small">
                        Receba uma notificação quando um alerta da web in-game é acionado.<br>Alertas da web envolvem: ativação de tripwire ou um bebê chocando.
                    </p>
                    <label>
                        {!! Form::checkbox('notify_webalert', 1, old('notify_webalert', auth()->user()->notifications['notify_webalert'])) !!}
                        Notificar por e-mail
                    </label>


                    <hr>

                    <strong>
                        Resposta em tópico de fórum inscrito
                    </strong>
                    <p class="small">
                        Quando alguém responde a um tópico ou postagem que você está inscrito.
                    </p>
                    <label>
                        {!! Form::checkbox('notify_forum', 1, old('notify_forum', auth()->user()->notifications['notify_forum'])) !!}
                        Notificar por e-mail
                    </label>

                    <br><br>
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('salvar_configuracoes', 'Salvar configurações'),
                        'class' => 'center'
                    ])
                @endcomponent


            </form>
        </div>

        <div class="col-md-6">

            @include('pages.v3.user._connect_accounts')

            @include('pages.v3.user._kick')

        </div>

    </div>



@stop