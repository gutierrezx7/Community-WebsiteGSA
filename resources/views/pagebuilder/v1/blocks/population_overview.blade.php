<div class="row">
    <div class="col-md-12 text-center">
        <h1>
            População
        </h1>
    </div>
</div>
<br>

<div class="row stat_block">
    @foreach($stats as $stat)

        <div class="col-md-{{$stat['col']}}">

            <?php
            $class = 'tiny-padding';

            if ($stat['col'] == 12) {
                $class .= '  no-bottom-margin';
            }
            ?>

            @component('partials.v3.frame', ['title' => $stat['name'], 'class' => $class])
                <div class="stat_canvas" data-value="" data-route="{{route('stat.index', $stat['route'])}}"><span>Carregando...</span></div>
            @endcomponent
        </div>

    @endforeach
</div>
