@component('partials.v3.frame', [
    'title' => 'Contas Conectadas',
])

    @forelse(auth()->user()->sub_users as $subUser)
        <div class="row">
            <div class="col-md-8">
                <strong>{{$subUser->name()}}</strong>
                <span class="label label-default">
                    {{$subUser->serviceType()}}
                </span><br>
                <small style="font-size:12px;">{{$subUser->serviceId()}}</small>
            </div>
            <div class="col-md-4">
                <div style="padding-top:10px;">
                    {!! Form::model($subUser, ['route'=>['user.sub_user.disconnect', $subUser->id], 'method' => 'post']) !!}
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('disconnect', 'Desconectar'),
                        'class' => 'center small'
                    ])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <hr>
    @empty
        <p>
            Não há contas conectadas à sua conta atualmente.
        </p>
    @endforelse

    <div class="frame-footer">
        @if(
            auth()->user()->connect_users and
            count((array) auth()->user()->connect_users)
        )
            <label>Conectar Contas</label><br>
            @foreach(auth()->user()->connect_users as $connectUser)
                <a class="btn btn-default openid-connect" href="{{$connectUser->connect_url}}">
                    <div>
                        <img width="100%" height="100%" src="{{$connectUser->icon}}">
                    </div>
                </a>
            @endforeach
            <hr>
        @endif

        {!! Form::model($user, ['route'=>['user.sub_user.connect'], 'method' => 'post']) !!}
        <label>Insira o código de conexão</label><br>
        <p>
            Use isso quando não houver opção de conectar contas acima.
        </p>
        <div class="row">
            <div class="col-md-8">
                <input type="text" name="code" value="{{old('code')}}" class="form-control">
                <small>
                    <a href="https://docs.gameserverapp.com/dashboard/community/website#connect-sub-accounts-on-community-website" target="_blank">Como obter o código de conexão &raquo;</a>
                </small>
            </div>
            <div class="col-md-4">
                <div>
                    @include('partials.v3.button', [
                        'type' => 'submit',
                        'element' => 'button',
                        'title' => translate('Connect', 'Conectar'),
                        'class' => 'center small'
                    ])
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endcomponent