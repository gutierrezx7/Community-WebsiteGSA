@component('partials.v3.frame', [
    'title' => '<i class="fa fa-heart"></i> Doações Recentes',
    'class' => 'no-padding center-title no-bottom-margin',
    'content_style' => 'min-height: 300px;'
])
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Quantia</th>
        </tr>
        </thead>
        <tbody>
        @forelse( $sales as $sale )
            <tr>
                <td>
                    {!! $sale->user()->showLink() !!}
                </td>
                <td>
                    {{$sale->currency()}} {{$sale->amount()}}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">
                    <br><br>
                    Nenhuma doação ainda!
                    <br><br>
                    <br>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endcomponent