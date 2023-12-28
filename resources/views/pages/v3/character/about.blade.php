@extends('layouts.v3.default', [
    'page' => [
        'title' => 'Sobre - ' . $character->name(),
        'description' => '',
        'class' => 'character-single about',
        //'bg' => $character->backgroundImage()
    ]
])

@section('page_content')
    @include('pages.v3.character._header')

    <div class="row">
        <div class="col-md-4">

            @if($character->hasAboutImage())
                <div class="image">
                    <img src="{{$character->aboutImageUrl()}}">
                </div>
            @else
                @component('partials.v3.frame', [
                    'type' => 'basic',
                    'class' => 'text-center'
                ])
                    <em>{{$character->name()}} ainda não possui uma imagem.</em>
                @endcomponent
            @endif

        </div>
        <div class="col-md-8">
            <?php
                $time_start = microtime(true);
            ?>
            @component('partials.v3.frame', [
                'title' => 'Sobre ' . $character->name()
            ])
                @if($character->hasAbout())
                    {!! Markdown::convertToHtml($character->about()) !!}
                    <?php
                        $time_about = microtime(true);
                    ?>
                @else
                    <em>{{$character->name()}} ainda não possui informações sobre si.</em>
                    <?php
                        $time_name = microtime(true);
                        $time_end = microtime(true);
                        $exec_time_title = ($time_end - $time_start);
                        $exec_time_about = ($time_end - $time_about);
                        $exec_time_name = ($time_end - $time_name);
                    ?>
                    <em>Title: {{ $exec_time_title }} <br> about: {{ $exec_time_about }} <br>  name: {{ $exec_time_name }}</em>
                @endif

                @if(
                    auth()->check() and
                    auth()->id() == $character->user->id
                )
                    <br><br>
                    <div class="edit">
                        <a class="btn btn-theme small" href="{{route('character.about.edit', $character->id)}}"><span>Editar</span></a>
                    </div>
                @endif
            @endcomponent

        </div>
    </div>
@stop
