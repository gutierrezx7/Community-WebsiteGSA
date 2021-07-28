<?php
use GameserverApp\Helpers\SiteHelper;
?>

@extends('layouts.v3.default', [
    'page' => [
        'title' => $package->name(),
        'description' => $package->summary(),
        'class' => 'package-single',
        'attributes' => ''
    ],

    'breadcrumbs' => [
        [
            'title' => translate('reward_shop', 'Reward shop'),
            'route' => route('shop.index')
        ],
        [
            'title' => $package->name()
        ],
    ]
])

@section('page_content')

    <div class="row">

        <form method="post" action="{{$package->orderUrl()}}">
            {{csrf_field()}}

            <div class="col-md-4">
                <div class="text-center">
                    <div class="main-image">
                        <img src="{{$package->image()}}">
                    </div>

                    @if($package->hasLabel())
                        <div class="label label-theme top-left">
                            {{$package->label()}}
                        </div>
                        <br>
                    @endif

                    <div class="hidden-md hidden-lg main-title">
                        <h1 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                        </h1>
                    </div>

                    <?php
                    $percentage = calcPercentage($package->limit(), $package->usage());
                    ?>

                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
                             aria-valuemax="100" style="width: {{$percentage}}%">
                        </div>

                        <div class="detail">
                            {{$package->displayLimits()}}

                            @if($package->limit())
                                <i>({{$percentage}}%)</i>
                            @endif
                        </div>
                    </div>

                    @if($package->tokenPrice() > 0)
                        <p>
                            <strong>
                                Price: {{$package->displayTokenPrice()}}
                            </strong>
                        </p>
                    @endif
                </div>

                <div class=" hidden-sm hidden-xs">
                    @if(auth()->check())
                        <br>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @include('partials.v3.button', [
                                    'element' => 'button',
                                    'type' => 'submit',
                                    'title' => 'Order now &raquo;',
                                    'class' => 'btn-theme-rock'
                                ])
                            </div>

                            <div class="col-md-12 text-center">
                                <br>
                            </div>

                            <div class="col-md-12 text-center">
                                @if( SiteHelper::featureEnabled('tokens'))
                                    @include('partials.v3.button', [
                                        'route' => route('supporter-tier.index'),
                                        'title' => 'Get tokens',
                                    ])
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8">

                <div class="hidden-sm hidden-xs main-title">
                    <h1 class="title">
                        <span>
                            {{$package->name()}}
                        </span>
                    </h1>
                </div>
                <br>

                @component('partials.v3.frame', [
                    'type' => 'big'
                ])
                    {!! Markdown::convertToHtml($package->description()) !!}

                    <hr>

                    @if($package->cluster)
                        <div class="alert alert-warning">
                            <span>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                Only deliverable on the <strong>{{$package->cluster}}</strong> cluster!
                            </span>
                        </div>
                    @endif

                    @if(auth()->check() and $package->requiresCharacterSelect())
                        @if($package->hasCharacters())
                            <div class="text-center">
                                <label>Deliver to:</label>
                                <select name="character_id">
                                    @foreach($package->characters() as $character)
                                        @if($character->status)
                                            <option selected value="{{$character->id}}">{{$character->name()}} [online]</option>
                                        @else
                                            <option value="{{$character->id}}">{{$character->name()}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                You do not have a character to deliver this shop pack to.
                            </div>
                        @endif
                    @endif
                @endcomponent


                @if(auth()->check())
                    <div class=" hidden-md hidden-lg">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @include('partials.v3.button', [
                                    'element' => 'button',
                                    'type' => 'submit',
                                    'title' => 'Order now &raquo;',
                                    'class' => 'btn-theme-rock'
                                ])
                            </div>

                            <div class="col-md-12 text-center">
                                <br>
                            </div>

                            <div class="col-md-12 text-center">
                                @if( SiteHelper::featureEnabled('tokens'))
                                    @include('partials.v3.button', [
                                        'route' => route('supporter-tier.index'),
                                        'title' => 'Get tokens',
                                    ])
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                @else
                    <div class="alert alert-info">
                        Please <a href="{{route('auth.login')}}">login</a> to place an order.
                    </div>
                @endif
                <br>

                @component('partials.v3.frame', ['type' => 'basic'])
                    <div class="row">
                        <div class="col-md-6">
                            <h6>When do I get it?</h6>
                            <p>
                                Your order is delivered automatically when you are online. This usually takes less than 1 minute. You're notified in-game about the status.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>I'm not online right now</h6>
                            <p>
                                The delivery system will wait for your to come online. You have 7 days to pick up your order.
                            </p>
                        </div>
                    </div>
                @endcomponent

            </div>

        </form>
    </div>

@stop