@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('supporter_tiers', 'Tiers de Apoiadores'),
        'description' => 'Contribua para a sua comunidade.',
        'class' => 'supporter-tier'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('supporter_tiers', 'Tiers de Apoiadores')
        ]
    ]
])

@section('page_content')

    <div class="row">

        <div class="col-md-12 text-center">
            <h1 class="main-title">{{translate('disabled_by_admin', 'Desativado pelo administrador')}}</h1>
        </div>

    </div>

@stop