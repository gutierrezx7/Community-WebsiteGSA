@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Enviar tokens para o jogador - ' . $user->name(),
        'description' => 'Enviar tokens para outros jogadores.',
        'class' => 'user-single'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-8 center-block">

            @component('partials.v3.frame', ['title' => $title, 'type' => 'basic'])
                <form method="post" action="{{route('token.send', $user->id)}}">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="number" class="form-control" name="amount" value="{{old('amount', 1)}}">
                    </div>

                    <div class="form-group">
                        <label>Mensagem</label>
                        <input type="text" maxlength="120" class="form-control" name="message" value="{{old('message')}}">
                    </div>

                    <br>

                    @include('partials.v3.button', [
                        'element' => 'button',
                        'type' => 'submit',
                        'title' => 'Enviar tokens',
                        'class' => 'center btn-theme-rock'
                    ])

                </form>
            @endcomponent

        </div>
    </div>
@stop