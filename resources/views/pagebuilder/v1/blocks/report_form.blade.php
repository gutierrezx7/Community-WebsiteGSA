@if(auth()->check())
    <form method="post" action="{{route('report.submit')}}">
        {{csrf_field()}}
@endif

<?php
$footer = '<button type="submit" ' . (!auth()->check() ? 'disabled' : '' ) . ' class="btn btn-theme small"><span>Enviar</span></button>';
?>

@component('partials.v3.frame', ['title' => $value, 'class' => 'no-bottom-margin', 'footer' => $footer])

    @if(!auth()->check())
        <div class="alert alert-warning">
            Por favor, <a href="{{route('auth.login')}}">faça login</a> para enviar seu relatório.<br>
            Será solicitado que você faça login na sua conta Steam para que possamos verificar que você possui a conta Steam.
        </div>
    @endif

    {!! Markdown::convertToHtml($block['description']) !!}
    <hr>

    <div class="form-group">
        <label>Selecione o tipo</label>
        <select class="form-control" name="type">
            @foreach($block['types'] as $reportType)
                <option value="{{$reportType['id']}}" @if(old('types') == $reportType['id']) selected @endif>{{$reportType['name']}}</option>
            @endforeach
        </select>
    </div>

    @isset($block['character'])
        <div class="form-group">
            <label>Relatando sobre</label>
            <select class="form-control" name="reporting_char">
                <option value=""> - Ninguém - </option>
                <option value="{{$block['character']['id']}}" selected>{{$block['character']['name']}}</option>
            </select>
        </div>
    @endif

    <div class="form-group">
        <label>O que você deseja relatar (obrigatório)</label>
        <textarea name="comment" style="height:100px;" class="form-control">{{old('comment')}}</textarea>
    </div>

@endcomponent

@if(auth()->check())
    </form>
@endif
