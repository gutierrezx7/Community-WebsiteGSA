<?php
use GameserverApp\Models\Order;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('reward_shop_history', 'Histórico da Loja de Recompensas'),
        'description' => 'Confira o histórico da sua loja de recompensas',
        'class' => 'package-single',
        'attributes' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Loja de Recompensas'),
            'route' => route('shop.index')
        ],
        [
            'title' => translate('history', 'Histórico')
        ],
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-12 text-center title">
            <h1 class="main-title">{{translate('reward_shop_history', 'Histórico da Loja de Recompensas')}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 center-block">

            @component('partials.v3.frame', ['class' => 'no-padding'])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Pacote</th>
                        <th>Nº do Pedido</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $item)
                        <tr>
                            <td>
                                <?php
                                switch( $item->status() )
                                {
                                    case Order::STATUS_PROCESSING:
                                        print '<div class="label label-default">Processando</div>';
                                        break;

                                    case Order::STATUS_FULL_INVENTORY:
                                        print '<div class="label label-danger">Personagem / Dino no inventário</div>';
                                        break;

                                    case Order::STATUS_DELIVERED:
                                        print '<div class="label label-warning">Entregue</div>';
                                        break;

                                    case Order::STATUS_PICKEDUP:
                                        print '<div class="label label-success">Retirado</div>';
                                        break;
                                }
                                ?>
                            </td>
                            <td>{{$item->name()}}</td>
                            <td>{{$item->id}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endcomponent

            <div class="paginate">
                {!! $orders->links() !!}
            </div>
        </div>

        </div>
    </div>

@stop