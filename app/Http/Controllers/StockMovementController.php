<?php 

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with('product')->latest()->paginate(10);
        return view('stockmovements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stockmovements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entrada,saida',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Se for saída, valida se há estoque suficiente
        if ($request->type === 'saida' && $product->current_stock < $request->quantity) {
            return redirect()->back()
                ->withErrors(['quantity' => 'Estoque insuficiente para realizar essa saída!'])
                ->withInput();
        }

        // Estoque antes
        $stockBefore = $product->current_stock;

        // Atualiza o estoque do produto
        if ($request->type === 'entrada') {
            $product->current_stock += $request->quantity;
        } else {
            $product->current_stock -= $request->quantity;
        }
        $product->save();

        // Estoque depois
        $stockAfter = $product->current_stock;

        // Cria movimentação com saldo antes e depois
        StockMovement::create([
            'product_id'   => $product->id,
            'type'         => $request->type,
            'quantity'     => $request->quantity,
            'reason'       => $request->reason,
            'stock_before' => $stockBefore,
            'stock_after'  => $stockAfter,
        ]);

        return redirect()->route('stockmovements.index')
            ->with('success', 'Movimentação registrada e estoque atualizado!');
    }
}