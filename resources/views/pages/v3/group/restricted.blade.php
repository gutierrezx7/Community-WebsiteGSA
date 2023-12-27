@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Log - ' . $group->name(),
        'description' => str_limit($group->about(), 200),
        'class' => 'group-single',
        'bg' => $group->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.group._header')

    <div class="row">
        <div class="col-md-6 center-block">

            @component('partials.v3.frame', ['title' => 'Restrito'])

                <div class="text-center">
                    <p>Você precisa fazer parte de <strong>{{$group->name()}}</strong> para acessar esta página.</p>
                </div>

                @if(!auth()->check())


                    <br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-theme btn-theme-rock" href="{{route('auth.login')}}">
                                <span>Entrar</span>
                            </a>
                        </div>
                    </div>
                @endif

            @endcomponent

        </div>
    </div>
@stop