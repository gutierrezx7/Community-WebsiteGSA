@component('partials.v3.frame', [
    //'type' => 'basic'
])

<form class="collection-option" method="post" action="{{$item->orderUrl()}}">
    {{csrf_field()}}
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <div class="main-image">

                @if($item->hasLabel())
                    <div class="label label-theme top-left">
                        {{$item->label()}}
                    </div>
                @endif

                <img src="{{$item->image()}}">
            </div>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="main-title">

                <h2 class="title">
                    <span>
                        {{$item->name()}}
                    </span>
                </h2>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {!! Markdown::convertToHtml($item->description()) !!}

            @if($item->cluster)
                <div class="alert alert-warning">
                    <span>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        Apenas entregue no cluster <strong>{{$item->cluster}}</strong>!
                    </span>
                </div>
            @endif

            @if($item->gameserver)
                <div class="alert alert-warning">
                    <span>
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        Apenas entregue no servidor <strong>{{$item->gameserver}}</strong>!
                    </span>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            @if($item->tokenPrice() > 0)
                <div class="text-center">
                    <h4>
                        Preço
                        @if($item->hasLabel())
                            <div class="label label-theme top-left">
                                {{$item->label()}}
                            </div>
                        @endif
                    </h4>

                    <p>
                        <strong>
                            {!! $item->displayTokenPrice() !!}
                        </strong>
                    </p>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <?php
                    $percentage = calcPercentage($item->limit(), $item->usage());
                    ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                             aria-valuemax="100" style="width: {{$percentage}}%">
                        </div>

                        <div class="detail">
                            {{$item->displayLimits()}}

                            @if($item->limit())
                                <i>({{$percentage}}%)</i>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-6 col-xs-12">
                    @if(!auth()->check())
                        <div class="alert alert-info">
                            Faça login para fazer o pedido.
                        </div>
                    @elseif($item->requiresDiscordConnected() and !auth()->user()->hasDiscordSetup())
                        <div class="alert alert-warning">
                            Você precisa <a href="{{route('user.settings', auth()->user()->id)}}">conectar o Discord</a> para fazer o pedido deste pacote.
                        </div>
                    @elseif($item->requiresCharacterSelect())
                        @if($item->hasCharacters())
                            <div class="text-center">
                                <label>Entregar para:</label>
                                <select name="character_id">
                                    @foreach($item->characters() as $character)
                                        <option @if($character->online()) selected @endif value="{{$character->id}}">
                                            {{$character->name()}}

                                            @if($character->online()) [online] @endif

                                            @if($character->hasServer())
                                                ({{$character->server->name}})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @include('partials.v3.button', [
                                'element' => 'button',
                                'type' => 'submit',
                                'title' => 'Peça agora &raquo;',
                                'class' => 'btn-theme-rock center'
                            ])
                        @else
                            <div class="alert alert-danger">
                                Você não tem um personagem para entregar este pacote da loja.
                            </div>
                        @endif
                    @else
                        @include('partials.v3.button', [
                            'element' => 'button',
                            'type' => 'submit',
                            'title' => 'Peça agora &raquo;',
                            'class' => 'btn-theme-rock center'
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endcomponent