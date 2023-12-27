<?php
use GameserverApp\Helpers\SiteHelper;
?>

<form method="post" action="{{route('group.visual.save', $group->id)}}" enctype="multipart/form-data">
    {{csrf_field()}}

    @component('partials.v3.frame', [
        'title' => 'Faça o upload do seu logotipo',
        'footer' => '<small>Max. 500KB | Supported: png, jpg, jpeg, gif</small>'
    ])
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Logotipo</label>
                    <p>
                        Personalize a página do seu grupo com o logotipo do grupo.
                    </p>

                    @if(SiteHelper::featureEnabled('tribe_image_upload'))
                        <input class="form-control" type="file" name="logo">
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="{{$group->logo()}}" style="max-width:200px; max-height:200px; height:auto; width:100%;">
                </div>
            </div>
        </div>
        <br>

        @if(SiteHelper::featureEnabled('tribe_image_upload'))
            @include('partials.v3.button', [
                'type' => 'submit',
                'element' => 'button',
                'title' => translate('upload', 'Upload'),
                'class' => 'center'
            ])
        @else
            <div class="alert alert-warning">
                Essa funcionalidade está desativada.
            </div>
        @endif
    @endcomponent

</form>