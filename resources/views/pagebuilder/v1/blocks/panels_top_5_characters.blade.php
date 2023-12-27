@component('partials.v3.frame', [
    'title' => '<i class="fa fa-trophy"></i> Top 5 Personagens',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Nível</th>
            <th>Servidor</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        ?>
        @forelse( $characters as $character )
            <tr>
                <td>{{$count}}</td>
                <td>
                    {!! $character->showLink(['limit' => 13]) !!}
                </td>
                <td>{{$character->level}}</td>
                <td>
                    @if($character->hasServer())
                        {{$character->server->name(10)}}
                    @endif
                </td>
            </tr>

            <?php
            $count++;
            ?>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    <br><br>
                    Nenhum personagem ainda!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent