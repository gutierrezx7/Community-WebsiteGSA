@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Eventos do calendário',
        'description' => 'Descubra o que está acontecendo e o que está por vir!',
        'class' => 'calendar'
    ],

    'breadcrumbs' => [
        [
            'title' => translate('calendar', 'Calendar')
        ]
    ]
])

@section('page_content')

<div class="row">
    <div class="col-md-12">
        <div class="calendar-js" style="height:1000px"></div>
    </div>
</div>

@stop