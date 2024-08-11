<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOut;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductOutController extends Controller
{
    public function index()
    {
        $items = ProductOut::with('product')->getByUser()->latest()->get();
        return view('dashboard.product-out.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $barangs = Product::orderBy('nama', 'ASC')->get();
        return view('dashboard.product-out.create', [
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
            $product_in = ProductOut::create($data);
            $product_in->product()->decrement('stok', request('jumlah'));
            $this->cekMinimalStok();
            DB::commit();
            return redirect()->route('product-out.index')
                ->with('success', 'Data Berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function edit($id)
    {
        $item = ProductOut::findOrFail($id);
        return view('dashboard.product-out.edit', [
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
            $product_in = ProductOut::findOrFail($id);
            $product_in->product()->increment('stok', $product_in->jumlah);
            $product_in->product()->decrement('stok', request('jumlah'));
            $product_in->update($data);
            $this->cekMinimalStok();
            DB::commit();
            return redirect()->route('product-out.index')
                ->with('success', 'Data Berhasil diupdate');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_in = ProductOut::findOrFail($id);
            $product_in->product()->increment('stok', $product_in->jumlah);
            $product_in->delete();
            DB::commit();
            return redirect()->route('product-out.index')
                ->with('success', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cekMinimalStok()
    {
        $products = Product::latest()->get();
        $wa = new WhatsappService();
        foreach ($products as $product) {
            if ($product->stok_minimal >= $product->stok) {
                // kirim notifikasi
                $wa->stokMenipis($product->id);
            }
        }
    }
}
