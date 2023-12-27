@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Atividade - ' . $user->name(),
        'description' => '',
        'class' => 'user-single'
    ]
])

@section('page_content')
    @include('pages.v3.user._header')

    <div class="row">
        @forelse($activity as $item)
            <div class="col-md-8 center-block">
                @include('partials.v3.user-activity')
            </div>
        @empty
            <div class="col-md-12 text-center">
                <em>Nenhuma atividade ainda.</em>
            </div>
        @endforelse
    </div>

    <div class="paginate">
        {!! $activity->links() !!}
    </div>
@stop