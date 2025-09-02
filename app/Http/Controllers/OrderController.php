<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\StockMovement;

class OrderController extends Controller
{
    use AuthorizesRequests;

    // Lista pedidos do usuário
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Mostra detalhes do pedido com QR
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product');

        $qrUrl = $this->getQrUrl($order);

        return view('orders.show', compact('order', 'qrUrl'));
    }

    // Cria pedido com 1 item
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $order = new Order();
        $order->user_id     = Auth::id();
        $order->code        = Str::upper(Str::uuid());
        $order->status      = 'pendente';
        $order->total_cents = 0;
        $order->save();

        $item = new OrderItem();
        $item->order_id    = $order->id;
        $item->product_id  = $product->id;
        $item->quantity    = $request->quantity;
        $item->unit_price  = $product->unit_price;
        $item->total_cents = $product->unit_price * $request->quantity;
        $item->save();

        $order->load('items');
        $order->total_cents = $order->items->sum('total_cents');
        $order->save();

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Ficha gerada! Aguarde aprovação/pagamento.');
    }

    // Cancela pedido pendente
    public function cancel(Order $order)
    {
        $this->authorize('view', $order);
        if (!$order->isPendente()) {
            return back()->withErrors('Só é possível cancelar pedidos pendentes.');
        }

        $order->update([
            'status' => 'cancelado',
            'canceled_at' => now(),
        ]);

        // Devolve os itens ao estoque (estorno)
        /*foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);

            // Opcional: registrar movimentação de estoque
            StockMovement::create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'type'       => 'entrada', // devolução
                'reason'     => 'Estorno de pedido cancelado',
                'order_id'   => $order->id,
            ]);
    }*/

        return redirect()->route('orders.index')
                         ->with('success','Pedido cancelado.');
    }

    // Tela de ticket
    public function ticket(Order $order)
    {
        $this->authorize('view', $order);
        $qrUrl = $this->getQrUrl($order);

        return view('orders.ticket', compact('order', 'qrUrl'));
    }

    // PDF da ficha com QR
    public function ticketPdf(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('user','items.product');

        // Gera QR Code no caminho temporário
        $qrPath = public_path("qrcodes/{$order->code}.png");
        if (!file_exists($qrPath)) {
            QrCode::format('png')->size(120)->generate(route('orders.show', $order->id), $qrPath);
        }

        // Converte para base64 (para o PDF)
        $qrBase64 = base64_encode(file_get_contents($qrPath));
        $qrDataUrl = "data:image/png;base64,{$qrBase64}";

        // Passa para a view
        $pdf = Pdf::loadView('orders.ticket', [
            'order' => $order,
            'qrUrl' => $qrDataUrl, // usar no <img src="{{ $qrUrl }}">
        ]);

        return $pdf->download('ficha-'.$order->code.'.pdf');
        }

    // Método privado que gera/reutiliza QR Code PNG
    private function getQrUrl(Order $order)
    {
        $qrPath = public_path("qrcodes/{$order->code}.png");

        if (! file_exists(dirname($qrPath))) {
            mkdir(dirname($qrPath), 0777, true);
        }

        if (! file_exists($qrPath)) {
            QrCode::format('png')
                ->size(120)
                ->generate(route('orders.show', $order->id), $qrPath);
        }

        return asset("qrcodes/{$order->code}.png");
    }
}

