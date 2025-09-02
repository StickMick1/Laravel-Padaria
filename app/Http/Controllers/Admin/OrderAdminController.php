<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user','items.product')->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    // Aprovar/pagar pedido -> gera SAÍDA de estoque p/ cada item
    public function approve(Order $order)
    {
        if (!$order->isPendente()) {
            return back()->withErrors('Apenas pedidos pendentes podem ser aprovados.');
        }

        foreach ($order->items as $item) {
            $product = $item->product;

            // valida estoque
            if ($product->current_stock < $item->quantity) {
                return back()->withErrors("Estoque insuficiente para {$product->name}.");
            }

            $stockBefore = $product->current_stock;
            $product->current_stock -= $item->quantity;
            $product->save();
            $stockAfter = $product->current_stock;

            StockMovement::create([
                'product_id'   => $product->id,
                'type'         => 'saida',
                'quantity'     => $item->quantity,
                'reason'       => "Pedido {$order->code} aprovado",
                'stock_before' => $stockBefore,
                'stock_after'  => $stockAfter,
            ]);
        }

        $order->update(['status' => 'aprovado', 'paid_at' => now()]);

        return back()->with('success', "Pedido {$order->code} aprovado. Estoque atualizado.");
    }

    // Entregar ficha (retirada em loja)
    public function deliver(Order $order)
    {
        if (! $order->isAprovado()) {
            return back()->withErrors('Só é possível dar baixa em pedidos aprovados.');
        }

        $order->update(['status' => 'entregue', 'delivered_at' => now()]);
        return back()->with('success', "Pedido {$order->code} marcado como ENTREGUE.");
    }

    // Cancelar (política de estorno de estoque documentada abaixo)
    public function cancel(Order $order)
    {
        if ($order->isCancelado()) {
            return back()->withErrors('Pedido já está cancelado.');
        }

        // Política de estoque:
        // - Se ainda estava pendente: não havia saída de estoque -> apenas marca cancelado.
        // - Se já estava aprovado (saída lançada) e ainda NÃO entregue: fazemos estorno (ENTRADA) para cada item.
        // - Se já foi entregue, entendemos que a mercadoria saiu definitivamente -> não estornamos (documentado).
        if ($order->isAprovado()) {
            foreach ($order->items as $item) {
                $product = $item->product;

                $stockBefore = $product->current_stock;
                $product->current_stock += $item->quantity;
                $product->save();
                $stockAfter = $product->current_stock;

                StockMovement::create([
                    'product_id'   => $product->id,
                    'type'         => 'entrada',
                    'quantity'     => $item->quantity,
                    'reason'       => "Estorno cancelamento pedido {$order->code}",
                    'stock_before' => $stockBefore,
                    'stock_after'  => $stockAfter,
                ]);
            }
        } elseif ($order->isEntregue()) {
            // Sem estorno: pedido entregue já consumiu estoque (documentado).
        }

        $order->update(['status' => 'cancelado', 'canceled_at' => now()]);

        return back()->with('success', "Pedido {$order->code} cancelado.");
    }
}

