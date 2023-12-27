<?php
use GameserverApp\Models\Order;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('histórico_da_loja_de_recompensas', 'Histórico da loja de recompensas'),
        'description' => 'Confira o histórico da loja de recompensas',
        'class' => 'user-single',
        'attributes' => ''
    ],
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        <div class="col-md-10 center-block">

            @component('partials.v3.frame', ['class' => 'no-padding'])
                <table class="table">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Pacote</th>
                        <th>Pedido #</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($orders as $item)
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
                    @empty
                        <tr>
                            <td colspan="3"><em>Sem entregas ainda.</em></td>
                        </tr>
                    @endforelse

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