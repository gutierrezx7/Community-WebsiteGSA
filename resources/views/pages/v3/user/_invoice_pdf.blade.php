<?php
use PremiumARK\Sales\Sale;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Recibo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial;
            background: #fff;
            background-image: none;
            font-size: 12px;
        }
        address {
            margin-top: 15px;
        }
        h2 {
            font-size: 28px;
            color: #cccccc;
        }
        .container {
            padding-top: 30px;
        }
        .invoice-head td {
            padding: 0 8px;
        }
        .invoice-body {
            background-color: transparent;
        }
        .logo {
            padding-bottom: 10px;
        }
        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 20px;
            text-align: left;
        }
        .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }
        .well {
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <table style="margin-left: auto; margin-right: auto" width="550">
        <tr valign="top">
            <td width="375">
            {{--                <img style="width:250px;" src="{{$logo}}">--}}
                <br>
                <br>
                <br>
                <br>
                <br>

                {!! $buyerDetails !!}
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>

            <!-- Nome / Logotipo da Organização -->
            <td align="left">
                {!! $sellerDetails !!}
            </td>
        </tr>
        <tr valign="top">
            <td>
                <p>
                    <strong>ID do Recibo:</strong> {{ $invoice->id }}<br>
                    <strong>Status:</strong> PAGO
                </p>
            </td>

            <!-- Nome / Data da Organização -->
            <td>
                <p>
                    <strong>Data:</strong> {{ $invoice->transactionDate()->toFormattedDateString() }} (UTC)<br>
                </p>
            </td>
        </tr>
        <tr valign="top">
            <td colspan="2" >

                <!-- Tabela do Recibo -->
                <table width="100%" class="table" border="0">
                    <tr>
                        <th align="left">Descrição</th>
                        <th align="right">Valor</th>
                    </tr>

                    <!-- Exibe as Cobranças do Recibo -->

                    <tr>
                        <td>
                            @if($invoice->isSubscriptionSale())
                                Assinatura:
                            @else
                                Compra:
                            @endif

                            {{$invoice->relatable()->name()}}

                            @if ($invoice->hasDiscount())
                                <br>

                                (Incluindo {{ $invoice->discount() }}% de desconto)
                            @endif
                        </td>

                        <td>{{$invoice->currency()}} {{$invoice->amount()}}</td>
                    </tr>
                    <!-- Exibe o Total Final -->
                    <tr style="border-top:2px solid #000;">
                        <td style="text-align: right;"><strong>Total</strong></td>
                        <td>
                            <strong>{{$invoice->currency()}} {{$invoice->amount()}}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <br>
                <br>
                <hr>
                <p>
                    {!! $sellerNote !!}
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>