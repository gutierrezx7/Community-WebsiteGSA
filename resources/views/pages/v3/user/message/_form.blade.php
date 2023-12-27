<?php
if(isset($message)) {
    // Se a variável $message estiver definida, estamos respondendo a uma mensagem existente
    $title = 'Enviar resposta para'; // Título da página
    $routeId = $message->sender->id; // ID do destinatário (remetente da mensagem original)
    $btnText = 'Enviar resposta'; // Texto do botão de envio
} else {
    // Caso contrário, estamos criando uma nova mensagem
    $title = 'Nova mensagem para'; // Título da página
    $routeId = $receiver->id; // ID do destinatário (usuário ou destinatário da nova mensagem)
    $btnText = 'Enviar mensagem'; // Texto do botão de envio
}

// Construção do título com base nas variáveis definidas acima
if(!empty( $receiver->name )) {
    $title .= ' ' . $receiver->showLink();
} elseif(isset($message)) {
    if($message->receiver->id == auth()->id()) {
        $title .= ' ' . $message->sender->showLink();
    } else {
        $title .= ' ' . $message->receiver->showLink();
    }
} else {
    $title .= ' jogador';
}
?>

@component('partials.v3.frame', ['title' => $title, 'type' => 'basic'])
    <form method="post" action="{{route('message.send', $routeId)}}">
        {{csrf_field()}}

        @if(isset( $message ) )
            <input type="hidden" name="subject" value="{{$message->subject}}">
        @else
            <div class="form-group">
                <label>Assunto</label>
                <input type="text" class="form-control" name="subject" value="{{old('subject')}}">
            </div>
        @endif

        <div class="form-group">
            <label>Mensagem</label>
            <textarea type="text" class="form-control simplemde" name="content">{{old('content')}}</textarea>
        </div>

        <br>

        @include('partials.v3.button', [
            'element' => 'button',
            'type' => 'submit',
            'title' => $btnText,
            'class' => 'center btn-theme-rock'
        ])

    </form>
@endcomponent