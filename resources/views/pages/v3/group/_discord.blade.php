@component('partials.v3.frame', ['title' => 'Conecte o seu Discord'])
    <p>
        Conecte o seu servidor Discord para receber os registros em seu servidor Discord privado.
    </p>

    @if( $group->discordSetup() )

        @if($group->discordChannelSetup())
            <div class="alert alert-success">
                <span class="indent">
                    Discord <strong>{{$group->discordServerName()}}</strong> conectado
                </span>
            </div>
        @else
            <div class="alert alert-warning">
                <span class="indent">
                    Por favor, selecione um canal para relatar.<br>
                    <strong>Assegure-se de que o bot tenha acesso ao canal!</strong>
                </span>
            </div>
        @endif

        <div class="alert alert-warning">
            Se o bot não puder enviar mensagens no canal que você selecionou, ele será desconectado.
        </div>

        <form method="post" action="{{route('group.discord.save', $group->id)}}">
            {{csrf_field()}}

            <select name="channel_id">
                <option value="-1"> - Selecione um canal do Discord - </option>
                @foreach($group->discord['available_channels'] as $id => $name)
                    @if($group->discordChannelSetup() and $id == $group->discord['channel'])
                        <option selected value="{{$id}}">{{$name}} [Current]</option>
                    @else
                        <option value="{{$id}}">{{$name}}</option>
                    @endif
                @endforeach
            </select>

            <br><br>

            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('save_channel', 'Salvar canal'),
                'class' => 'center btn-theme-rock'
            ])

        </form>

        <br>

        <form method="post" action="{{route('group.discord.disconnect', $group->id)}}">
            {{csrf_field()}}
            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('disconnect_discord', 'Desconectar Discord'),
                'class' => 'center'
            ])
        </form>

    @else
        <br>
        @if($group->isOwner(auth()->user()))
            @include('partials.v3.button', [
                'title' => translate('connect_discord', 'Conectar Discord'),
                'route' => $group->discordOAuthRedirectUrl(),
                'class' => 'center btn-theme-rock'
            ])
        @else
            <div class="alert alert-warning">
                Apenas o proprietário deste grupo pode conectar o servidor Discord.
            </div>
        @endif
    @endif
@endcomponent