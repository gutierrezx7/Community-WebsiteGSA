@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('token_transactions', 'Transações de Tokens'),
        'description' => '',
        'class' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => auth()->user()->name(),
            'route' => route('user.settings', 'me')
        ],
        [
            'title' => translate('token_transactions', 'Transações de Tokens')
        ]
    ]
])

@section('page_content')


    <div class="row">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4 text-center">
            <h1 class="main-title">{{auth()->user()->displayTokenBalance()}}</h1>
        </div>
        <div class="col-sm-4">
            @include('partials.v3.button', [
                'route' => GameserverApp\Helpers\RouteHelper::token(),
                'title' => 'Obter tokens',
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 center-block">

            @component('partials.v3.frame', ['class' => 'no-padding'])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>+/-</th>
                        <th></th>
                        <th width="50%">Descrição</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->date('created_at')->format('d-m-Y H:i')}}</td>
                            <td>
                                @if( $transaction->transactionType() == 'purchase' )
                                    <div class="label label-default">Compra de Tokens</div>
                                @elseif( $transaction->transactionType() == 'shop' )
                                    <div class="label label-info">Compra na Loja</div>
                                @elseif( $transaction->transactionType() == 'player' )
                                    <div class="label label-warning">Jogador para Jogador</div>
                                @elseif( $transaction->transactionType() == 'admin' )
                                    <div class="label label-champ">Admin</div>
                                @else
                                    <div class="label label-default">Desconhecido</div>
                                @endif
                            </td>
                            <td>
                                @if( $transaction->transactionValue() > 0 )
                                    <div class="label label-success">
                                        +{{$transaction->transactionValue()}}
                                    </div>
                                @else
                                    <div class="label label-danger">
                                        {{$transaction->transactionValue()}}
                                    </div>
                                @endif

                            </td>
                            <td>
                                @if( $transaction->transactionValue() > 0 )
                                    @if(is_null($transaction->sender) )
                                        <em>de</em>
                                        <strong>{{GameserverApp\Helpers\SiteHelper::name()}}</strong>
                                    @else
                                        <em>de</em>
                                        <strong>{!! $transaction->sender->showLink() !!}</strong>
                                    @endif
                                @elseif(isset($transaction->sender))
                                    <em>para</em>
                                    <strong>{!! $transaction->sender->showLink() !!}</strong>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{$transaction->description}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <em>Nenhuma transação encontrada</em>
                            </td>
                        </tr>

                    @endforelse

                    </tbody>
                </table>
            @endcomponent
        </div>

        <div class="paginate">
            {!! $transactions->links() !!}
        </div>

    </div>



@stop