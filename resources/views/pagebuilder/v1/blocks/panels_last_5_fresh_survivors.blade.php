@component('partials.v3.frame', [
    'title' => '<i class="fa fa-hand-spock-o" aria-hidden="true"></i> Sobreviventes Novos',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Nível</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @forelse( $characters as $character )
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
                        {{str_replace('minute','min.',
                            str_replace('minutes','min.',
                                $character->date('created_at')->diffForHumans()
                            )
                        )}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        <br><br>
                        Nenhum personagem ainda!
                        <br><br>
                        <br>
                    </td>
                </tr>
            @endforelse

            {{--<tr>--}}
                {{--<td colspan="4" class="text-right">--}}
                    {{--<a href="{{route('halloffame.newbies')}}">--}}
                        {{--Ver todos os novatos &raquo;--}}
                    {{--</a>--}}
                {{--</td>--}}
            {{--</tr>--}}

        </tbody>
    </table>
@endcomponent