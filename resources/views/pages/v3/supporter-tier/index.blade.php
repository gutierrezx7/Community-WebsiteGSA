@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('supporter_tiers', 'Tiers de Apoiador'),
        'description' => 'Contribua para a sua comunidade.',
        'class' => 'supporter-tier'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('supporter_tiers', 'Tiers de Apoiador')
        ]
    ]
])

@section('page_content')

<div class="row">

    <div class="col-md-4">

    </div>
    <div class="col-md-4 text-center title">
        <h1 class="main-title">{{translate('supporter_tiers', 'Tiers de Apoiador')}}</h1>
    </div>
    <div class="col-md-4 coupon">
        <h4>Código de desconto:</h4>
        <form method="get">
            <div class="input-group">
                <input class="form-control" name="coupon" type="text" value="{{request('coupon', '')}}" placeholder="Digite seu código de desconto">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Aplicar</button>
                </span>
            </div>
        </form>

        <div class="hidden-desktop">
            <br>
        </div>
    </div>
</div>
<div class="row">

    @forelse( $packages as $tier )

        <div class="col-md-6 col-lg-4">
            @include('partials.v3.purchase-package', [
                'item' => $tier
            ])
        </div>

    @empty
        <div class="col-md-12">
            <div class="text-center">
                <em>Nenhum tier disponível</em>
            </div>
        </div>
    @endforelse

</div>

<div class="row">
    <div class="paginate">
        {!! $packages->appends(Request::except('page'))->links() !!}
    </div>
</div>

@stop