@extends('layouts.v3.default', [
    'page' => [
        'title' => translate('inspector', 'Inspector'),
        'description' => 'Pesquise todos os personagens e grupos na comunidade.',
        'class' => 'inspector'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('inspector', 'Inspector')
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