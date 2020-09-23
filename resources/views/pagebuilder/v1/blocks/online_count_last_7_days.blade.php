<?php
$settings = [
    'settings' => 'tiny-padding'
];

if(isset($block['title'])) {
    $settings['title'] = $block['title'];
}
?>

@component('partials.v3.frame', $settings)
    <div class="stat_canvas" data-value="{{$value}}" data-route="{{route('stat.index', 'online-count-last-7-days')}}"><span>Loading...</span></div>
@endcomponent