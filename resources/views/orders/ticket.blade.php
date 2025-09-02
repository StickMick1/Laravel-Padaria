<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha {{ $order->code }}</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 14px; 
            margin: 0; 
            padding: 10px; 
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
        }

        .box { 
            border:1px solid #000; 
            padding:12px; 
            margin-bottom:16px; 
            box-sizing: border-box;
        }

        table { 
            width:100%; 
            border-collapse: collapse; 
        }

        th, td { 
            border:1px solid #000; 
            padding:8px; 
            text-align:left; 
            word-break: break-word;
        }

        .flex { 
            display:flex; 
            align-items:flex-start; 
            gap:16px; 
            flex-wrap: wrap; 
        }

        .qr { 
            width:150px; 
            height:150px; 
            flex-shrink: 0;
        }

        ul {
            padding-left: 20px;
            margin: 0;
        }

        /* Telas pequenas */
        @media (max-width: 768px) {
            body {
                font-size: 16px;
            }

            .flex {
                flex-direction: column;
                align-items: center;
            }

            .qr {
                width: 180px;
                height: 180px;
                margin-bottom: 12px;
            }

            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h2>Ficha #{{ $order->code }}</h2>

    <div class="box">
        <p><strong>Cliente:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
        <p><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="box">
        <h3>Itens</h3>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Qtd</th>
                    <th>Unit</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->total_cents, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="box flex">
        <div>
            {{-- QR Code --}}
            <img src="{{ $qrUrl }}" alt="QR Code" class="qr">
        </div>
        <div>
            <p><strong>Instruções:</strong></p>
            <ul>
                <li>Apresente esta ficha (impresso ou no celular) na retirada.</li>
                <li>O QR Code contém o identificador do seu pedido.</li>
                <li>Retirada em loja mediante confirmação de pagamento.</li>
            </ul>
        </div>
    </div>
</body>
</html>