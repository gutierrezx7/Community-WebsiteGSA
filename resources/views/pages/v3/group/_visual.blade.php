<?php
use GameserverApp\Helpers\SiteHelper;
?>

<form method="post" action="{{route('group.visual.save', $group->id)}}" enctype="multipart/form-data">
    {{csrf_field()}}

    @component('partials.v3.frame', [
        'title' => 'Visual',
        'footer' => '<small>Max. 500KB | Supported: png, jpg, jpeg, gif</small>'
    ])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Imagem de fundo</label>
                    <p>
                        Defina uma imagem de fundo personalizada para o seu grupo.
                    </p>

                    @if(SiteHelper::featureEnabled('tribe_image_upload'))
                        <input class="form-control" type="file" name="background">
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="{{$group->backgroundImage()}}" style="max-width:200px; max-height:200px; height:auto; width:100%;">
                </div>
            </div>
        </div>

        <br>

        @if(SiteHelper::featureEnabled('tribe_image_upload'))
            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('upload', 'Enviar'),
                'class' => 'center'
            ])
        @else
            <div class="alert alert-warning">
                Essa funcionalidade está desativada.
            </div>
        @endif

    @endcomponent

</form>