@component('partials.v3.frame')
    <div class="row">

        <div class="col-md-6">
            <h4>Detalhes</h4>

            <table class="table">
                <tr>
                    <td>
                        Conteúdo
                    </td>
                    <td>
                        <strong><a href="{{$subscription->relatableUrl()}}">{{$subscription->relatableName()}}</a></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Preço
                    </td>
                    <td>
                        {{$subscription->currency()}} {{$subscription->amount()}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Estado
                    </td>
                    <td>
                        {{$subscription->status}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Processador
                    </td>
                    <td>
                        {{$subscription->gateway}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Iniciado
                    </td>
                    <td>
                        {{$subscription->created_at}}
                    </td>
                </tr>
            </table>

            @if(
                !$subscription->isPatreon() and
                !$subscription->expired()
            )
                <form method="post" action="{{route('subscription.cancel', ['uuid' => auth()->id(), 'id' => $subscription->id()])}}">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-xs btn-danger">Cancelar assinatura</button>
                </form>
            @endif
        </div>

        <div class="col-md-6">
            <h4>Configurações</h4>
            @if(
                !$subscription->isPatreon() and
                $subscription->expired()
            )
                <div class="alert alert-warning">
                    Esta assinatura foi cancelada e não pode mais ser alterada.
                </div>
            @else
                @if($subscription->requiresCharacter())

                    @if(!$subscription->hasCharacter())
                        <div class="alert alert-warning">
                            Esta assinatura atualmente não tem nenhum personagem configurado. Por favor, selecione um personagem para garantir que você receba suas recompensas.
                        </div>
                    @else
                        <div class="alert alert-info">
                            Você pode determinar qual personagem deve receber o conteúdo desta assinatura. Certas assinaturas só podem ser entregues em clusters específicos, o que também limita quais personagens você pode escolher. Você pode trocar de personagem a qualquer momento.
                        </div>
                    @endif

                    <form method="post" action="{{route('subscription.change_character', ['uuid' => auth()->id(), 'id' => $subscription->id()])}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>
                                Entregar conteúdo para:
                            </label>
                            <select name="character_id">
                                @foreach($subscription->availableCharacters() as $character)
                                    @if(
                                        $subscription->hasCharacter() and
                                        $subscription->character->id == $character->id
                                    )
                                        <option selected value="{{$character->id}}">{{$character->name()}} [current]</option>
                                    @else
                                        <option value="{{$character->id}}">{{$character->name()}}</option>
                                    @endif
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-default btn-small">Alterar</button>
                        </div>
                    </form>
                @endif
            @endif

        </div>

    </div>
@endcomponent