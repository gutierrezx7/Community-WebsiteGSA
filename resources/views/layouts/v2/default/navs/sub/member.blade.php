<?php
use GameserverApp\Helpers\SiteHelper;
?>
<div class="dropdown">
    <span class="btn btn-default btn-small dashboard" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="true">
        {!! auth()->user()->showLink(['disable_link' => true]) !!}
        <span class="caret"></span>
    </span>
    <ul class="dropdown-menu">

        <?php
        if(auth()->user()->hasCharacters()) {
            $navChar = auth()->user()->lastCharacter();

            if($navChar) {
                ?>

                @if(SiteHelper::featureEnabled('character_page'))
                    <li>
                        <a href="{{route('character.show', $navChar->id)}}" class="charview {{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('character.show', $navChar->id) ? 'orange' : '' }}">
                                <span>
                                    {!! $navChar->showLink(['disable_link' => true]) !!}
                                </span>
                            &nbsp;
                            <div class="char_pic"
                                 style="background-image:url('/img/character/{{$navChar->image()}}')"></div>
                        </a>
                    </li>
                @endif

                @if(SiteHelper::featureEnabled('tribe_page'))

                    @if($navChar->hasGroup())
                        <?php
                        $tribes = auth()->user()->lastCharacter()->tribes
                        ?>

                        @foreach($tribes as $tribe)
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{route('group.show', $tribe->id)}}"  class="{{ GameserverApp\Helpers\RouteHelper::isCurrentroute('group.show', $tribe->id) ? 'orange' : '' }}">
                                    {!! $tribe->showLink(['disable_link' => true]) !!}

                                    @if($tribe->hasServer())
                                        &nbsp;
                                        &nbsp;
                                        <span class="label label-default">
                                            {{$tribe->server->name()}}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            @if($navChar->groupAdmin($tribe))
                                <li>
                                    <a href="{{route('group.settings', $tribe->id)}}">
                                        Configurações da Tribo
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @elseif($navChar)
                        <li>
                            <a href="/{{GameserverApp\Helpers\RouteHelper::inspector()}}?search_type=tribe">
                                Encontre uma {{ GameserverApp\Helpers\SiteHelper::groupName()}} &raquo;
                            </a>
                        </li>
                    @endif

                @endif
                @if(SiteHelper::featureEnabled('character_page') or SiteHelper::featureEnabled('tribe_page'))
                <li role="separator" class="divider"></li>
                @endif
                <?php
            }

        }
        ?>


        @if(SiteHelper::featureEnabled('supporter_tiers'))
            <li>
                <a href="{{route('supporter-tier.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('supporter-tier.index') ? 'orange' : '' }}">
                    <i class="fa fa-trophy" aria-hidden="true"></i> &nbsp;
                    Níveis de Apoio
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('shop'))
            <li>
                <a href="{{route('shop.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.index') ? 'orange' : '' }}">
                    <i class="fa fa-gift" aria-hidden="true"></i> &nbsp;
                    Loja
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('tokens'))
            <li>
                <a href="{{route('token.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('token.index') ? 'orange' : '' }}">
                    Tokens
                    <span class="label label-default right">
                        {{auth()->user()->tokenBalance()}}
                    </span>
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('supporter_tiers'))
            <li>
                <a href="{{route('subscription.index', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('subscription.index', auth()->id()) ? 'orange' : '' }}">
                    Assinaturas
                </a>
            </li>
        @endif


        @if(
            SiteHelper::featureEnabled('supporter_tiers') or
            SiteHelper::featureEnabled('shop') or
            SiteHelper::featureEnabled('tokens')
        )
            <li role="separator" class="divider"></li>
        @endif
        {{--

        <li>
            <a href="{{route('news.index')}}" class="news {{ Request::is('news*') ? 'active' : '' }}">
                News & Updates
            </a>
        </li>


        @if( config('championark.subscriptions.enabled') )
            <li>
                <a href="{{route('user.subscription')}}">
                    Subscription

                    @if(auth()->user()->isP2PSubscriptionEndingShortly())
                        <span class="label label-danger right">
                                !
                            </span>
                    @elseif(auth()->user()->hasP2PSubscription())
                        <span class="label label-success right">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                    @endif
                </a>
            </li>
        @endif
 --}}
        <li>
            <a href="/calendar">
                <span>Calendário</span>
            </a>
        </li>
        @if(GameserverApp\Helpers\RouteHelper::rules() != false)
            <li>
                <a href="{{GameserverApp\Helpers\RouteHelper::rules()}}">
                    <span>Regras</span>
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('messages'))
            <li class="hidden-sm">
                <a href="{{route('message.index', auth()->id())}}"
                   class="inbox {{ ( Request::is('message/*')) ? 'active' : '' }}">
                    Mensagens
                    <span class="label label-default right">
                       {{auth()->user()->unreadMessagesCount()}}
                    </span>
                </a>
            </li>
        @endif

        <li>
            <a href="{{route('user.settings', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.settings', auth()->id()) ? 'orange' : '' }}">
                Configurações
            </a>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <a href="{{route('auth.logout')}}">
                Sair
            </a>
        </li>
    </ul>
</div>
