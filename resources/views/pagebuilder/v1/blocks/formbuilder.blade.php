@if(auth()->check())
    <form method="post" action="{{route('form.submit', $block['id'])}}">
        {{csrf_field()}}
@endif

<?php
$footer = '<button type="submit" ' . (!auth()->check() ? 'disabled' : '' ) . ' class="btn btn-theme small"><span>Enviar</span></button>';
?>

@component('partials.v3.frame', ['title' => $block['name'], 'class' => 'formbuilder no-bottom-margin', 'footer' => $footer])

    @if(!auth()->check())
        <div class="alert alert-warning">
            Por favor, <a href="{{route('auth.login')}}">faça login</a> para enviar este formulário.<br>
            Você será solicitado a fazer login na sua conta Steam, para que possamos verificar que você é o proprietário da conta Steam.
        </div>
    @elseif(
        isset($block['form_type']) and
        $block['form_type'] == 'whitelist-application'
    )
        @if(
            (
                !auth()->user()->hasEmailSetup() or
                !auth()->user()->emailConfirmed()
            ) and
            isset($block['email_required']) and
            $block['email_required']
        )
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle" style="display:inline-block" aria-hidden="true"></i>
                <span style="display:inline-block">
                    Você deve ter um endereço de e-mail confirmado <a href="{{route('user.settings', auth()->user()->id)}}">configurado</a> para enviar este formulário. <em><a href="{{route('user.settings', auth()->user()->id)}}">Informações de privacidade</a></em>
                </span>
            </div>
        @elseif(
            auth()->user()->hasEmailSetup() and
            auth()->user()->emailConfirmed()
        )
            <div class="alert alert-success">
                As atualizações serão enviadas para o seu endereço de e-mail.
            </div>
        @endif

        @if(!auth()->user()->hasDiscordSetup())
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle" style="display:inline-block" aria-hidden="true"></i>
                Por favor, <a href="{{route('user.settings', auth()->user()->id)}}">conecte o seu Discord</a> para continuar.
            </div>
        @endif
    @endif

    @if(isset($block['description']) and !empty($block['description']))
        {!! Markdown::convertToHtml($block['description']) !!}
        <hr>
    @endif

    <div class="form">
        @include('partials.form.index', [
            'content' => json_decode($value, true)
        ])
    </div>

@endcomponent

@if(auth()->check())
    </form>
@endif