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
                                 style="background-image:url('{{$navChar->image()}}')"></div>
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                @endif

                @if(SiteHelper::featureEnabled('tribe_page'))

                    @if($navChar->hasGroup())
                        <?php
                        $groups = auth()->user()->lastCharacter()->groups;
                        ?>

                        @foreach($groups as $group)
                            <li>
                                <a href="{{$group->showRoute()}}"  class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('group.show', $group->id) ? 'orange' : '' }}">
                                    {!! $group->showName() !!}

                                    @if($group->hasServer())
                                        &nbsp;
                                        &nbsp;
                                        <span class="label label-default">
                                            {{$group->server->name()}}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            @if($navChar->groupAdmin($group))
                                <li>
                                    <a href="{{route('group.settings', $group->id)}}">
                                        Configurações do Grupo
                                    </a>
                                </li>
                            @endif

                            <li role="separator" class="divider"></li>
                        @endforeach
                    @elseif($navChar)
                        <li>
                            <a href="/{{GameserverApp\Helpers\RouteHelper::inspector()}}?search_type=tribe">
                                Encontre um {{ GameserverApp\Helpers\SiteHelper::groupName()}} &raquo;
                            </a>
                        </li>

                    <li role="separator" class="divider"></li>
                    @endif

                @endif

                <?php
            }
        }
        ?>

        @if(SiteHelper::featureEnabled('shop'))
            <li>
                <a href="{{route('shop.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('shop.index') ? 'orange' : '' }}">
                    <i class="fa fa-gift" aria-hidden="true"></i> &nbsp;
                    Loja de Recompensas
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('supporter_tiers'))
            <li>
                <a href="{{route('supporter-tier.index')}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('supporter-tier.index') ? 'orange' : '' }}">
                    <i class="fa fa-trophy" aria-hidden="true"></i> &nbsp;
                    Tiers de Apoiador
                </a>
            </li>
        @endif


        @if(
            SiteHelper::featureEnabled('supporter_tiers') or
            SiteHelper::featureEnabled('shop')
        )
            <li role="separator" class="divider"></li>
        @endif

        @if(SiteHelper::featureEnabled('user_page'))
            <li>
                <a href="{{route('user.show', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.show', auth()->id()) ? 'orange' : '' }}">
                    Perfil da Conta
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

        @if(SiteHelper::featureEnabled('tokens'))
            <li>
                <a href="{{route('token.index', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('token.index', auth()->id()) ? 'orange' : '' }}">
                    Tokens
                    <span class="label label-default right">
                    {{auth()->user()->tokenBalance()}}
                </span>
                </a>
            </li>
        @endif


        @if(SiteHelper::featureEnabled('shop'))
            <li>
                <a href="{{route('user.deliveries', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.deliveries', auth()->id()) ? 'orange' : '' }}">
                    Entregas
                </a>
            </li>
        @endif

        @if(SiteHelper::featureEnabled('supporter_tiers'))
            <li>
                <a href="{{route('subscription.index', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('subscription.index', auth()->id()) ? 'orange' : '' }}">
                    Assinaturas
                </a>
            </li>
            <li>
                <a href="{{route('user.invoices', auth()->id())}}" class="{{ GameserverApp\Helpers\RouteHelper::isCurrentRoute('user.invoices', auth()->id()) ? 'orange' : '' }}">
                    Faturas
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