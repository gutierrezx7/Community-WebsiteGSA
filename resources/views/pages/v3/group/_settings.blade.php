<form method="post" action="{{route('group.settings.save', $group->id)}}">
    {{csrf_field()}}

    @component('partials.v3.frame', ['title' => 'Configurações'])
        <div class="form-group">
            <label>Mensagem do Dia</label>
            <p>
                Lembre sua equipe sobre objetivos e muito mais.<br>
                A mensagem será exibida no jogo quando você ou um dos seus membros fizer login.
            </p>
            <p>
                A Mensagem do Dia é visível apenas para os membros do grupo.
            </p>
            <textarea style="height:70px;" name="motd" class="form-control" placeholder="Vamos lá!!" maxlength="290">{{old('motd', $group->motd())}}</textarea>
        </div>
        <hr>
        <div class="form-group">
            <label>Sobre o seu grupo</label>
            <p>
                Apresente o seu grupo para as pessoas que visitam a página do seu grupo e deixe a impressão certa.
            </p>
            <textarea style="height:150px;" name="about" class="form-control" placeholder="Oi! Somos um novo grupo amigável disposto a ajudar. Envie uma mensagem!">{{old('about', $group->about())}}</textarea>
        </div>

        <br>

        @include('partials.v3.button', [
            'type' => 'submit',
            'element' => 'button',
            'title' => translate('save_settings', 'Salvar configurações'),
            'class' => 'center'
        ])
    @endcomponent

</form>