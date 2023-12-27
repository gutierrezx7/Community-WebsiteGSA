<?php
$title = 'Quem está online?';

if ($totalOnline == 1) {
    $title .= ' <span class="label label-theme alternative">1 jogador online</span>';
} else {
    $title .= ' <span class="label label-theme alternative">' . $totalOnline . ' jogadores online</span>';
}
?>

@component('partials.v3.frame', [
    'title' => $title,
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Nível</th>
            <th>Jogando em</th>
        </tr>
        </thead>
        <tbody>

        @if($characters->count() > 0)

            @foreach($characters->slice(0, 5) as $character)
                <tr>
                    <td>
                        {!! $character->showLink([
                            'limit' => 13
                        ]) !!}
                    </td>
                    <td>
                        {{$character->level}}
                    </td>
                    <td>
                        @if($character->hasServer())
                            {{$character->server->name(10)}}
                        @endif
                    </td>
                </tr>
            @endforeach

            {{--@if(count($characters['online']) > 5)--}}
                {{--<tr>--}}
                    {{--<td colspan="4" class="text-right">--}}
                        {{--<a href="{{route('halloffame.online')}}">--}}
                            {{--Ver todos os jogadores online &raquo;--}}
                        {{--</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endif--}}

        @else
            <tr>
                <td colspan="4" class="text-center">
                    <br><br>
                    Oh querido.. Nenhum personagem online!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endif

        </tbody>
    </table>
@endcomponent
