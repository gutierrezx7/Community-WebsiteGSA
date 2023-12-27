@component('partials.v3.frame', [
    'title' => '<i class="fa fa-thumbs-up"></i> Top 5 Votantes',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Total de Votos</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 1;
        ?>
        @forelse( $users as $user )
            <tr>
                <td>{{$count}}</td>
                <td>
                    {!! $user->showLink() !!}
                </td>
                <td>
                    {{$user->votes()}}
                </td>
            </tr>

            <?php
            $count++;
            ?>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    <br><br>
                    Nenhum voto ainda!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent