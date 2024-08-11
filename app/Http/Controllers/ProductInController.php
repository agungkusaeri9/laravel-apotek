<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductInController extends Controller
{
    public function index()
    {
        $items = ProductIn::with('product')->getByUser()->latest()->get();
        return view('dashboard.product-in.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $barangs = Product::orderBy('nama', 'ASC')->get();
        return view('dashboard.product-in.create', [
            'barangs' => $barangs
        ]);
    }

    public function store()
    {
        request()->validate([
            'product_id' => ['required'],
            'jumlah' => ['required', 'numeric']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['product_id', 'jumlah', 'keterangan']);
            $product_in = ProductIn::create($data);
            $product_in->product()->increment('stok', request('jumlah'));
            DB::commit();
            return redirect()->route('product-in.index')
                ->with('success', 'Data Berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function edit($id)
    {
        $item = ProductIn::findOrFail($id);
        return view('dashboard.product-in.edit', [
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'jumlah' => ['required', 'numeric']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['jumlah', 'keterangan']);
            $product_in = ProductIn::findOrFail($id);
            $product_in->product()->decrement('stok', $product_in->jumlah);
            $product_in->product()->increment('stok', request('jumlah'));
            $product_in->update($data);
            DB::commit();
            return redirect()->route('product-in.index')
                ->with('success', 'Data Berhasil diupdate');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_in = ProductIn::findOrFail($id);
            $product_in->product()->decrement('stok', $product_in->jumlah);
            $product_in->delete();
            DB::commit();
            return redirect()->route('product-in.index')
                ->with('success', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
