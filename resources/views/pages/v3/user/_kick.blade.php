@component('partials.v3.frame', ['title' => 'Ferramentas Especiais'])
    <p>
        Se você não conseguir entrar no servidor devido ao bug "Já existe um jogador com esta conta conectada", você pode se desconectar do servidor.
    </p>
    <br>

    {!! Form::model($user, ['route'=>['user.kick', auth()->id()]]) !!}

    @include('partials.v3.button', [
        'type' => 'submit',
        'element' => 'button',
        'title' => translate('kick_me', 'Me Desconectar'),
        'class' => 'center btn-theme-gem'
    ])

    {!! Form::close() !!}
@endcomponent