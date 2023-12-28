{{-- $category é passado como NULL para a view de layout principal para evitar que ele seja exibido nas migalhas de pão --}}
@extends('forum::master', ['category' => null])

@section('content')

    <div class="row">
        <div class="col-md-3">
            @can('createCategories')
                @include('forum::category.partials.form-create')
            @endcan
        </div>
        <div class="col-md-6 text-center">
            <h2>Fórum</h2>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            @forelse($categories as $category)
                @include('forum::custom.category')
            @empty
                <div class="alert alert-info">
                    Nada aqui ainda!<br>
                    Siga as instruções abaixo para começar:<br>

                    <ol>
                        <li>
                            <a href="https://docs.gameserverapp.com/dashboard/admin_teams#manage-admins" target="_blank">Vincule sua conta do site da comunidade à sua conta do Painel GSA</a>
                        </li>
                        <li>
                            <a href="https://docs.gameserverapp.com/dashboard/admin_teams/#grant-forum-permissions" target="_blank">Conceda permissões de fórum às equipes de administradores</a>
                        </li>
                    </ol>

                </div>
            @endforelse
        </div>
    </div>
@stop
