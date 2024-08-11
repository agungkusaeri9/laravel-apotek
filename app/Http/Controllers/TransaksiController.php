<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOut;
use App\Models\Transaction;
use App\Services\WhatsappService;
use Darryldecode\Cart\Validators\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        $items = Transaction::latest()->get();
        return view('dashboard.transaction.index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $kode_baru  = Transaction::getNewCode();
        $products = Product::orderBy('nama', 'ASC')->get();
        return view('dashboard.transaction.create', [
            'products' => $products,
            'kode_baru' => $kode_baru
        ]);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'sub_total' => ['required', 'numeric'],
            'tunai' => ['required', 'numeric'],
            'kembalian' => ['required', 'numeric'],
            'data' => ['required', 'array']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        DB::beginTransaction();
        try {
            $penjualan = Transaction::create([
                'invoice' => Transaction::getNewCode(),
                'user_id' => auth()->id(),
                'sub_total' => request('sub_total'),
                'tunai' => request('tunai'),
                'kembalian' => request('kembalian'),
                'diskon' => request('diskon'),
                'total_harga' => 0
            ]);

            $data_product = request('data');

            foreach ($data_product as $product) {
                $penjualan->details()->create([
                    'product_id' => $product[0]['product_id'],
                    'jumlah' => $product[0]['jumlah'],
                    'harga' => $product[0]['harga'],
                    'total_harga' => $product[0]['total_harga']
                ]);

                // create product keluar
                ProductOut::create([
                    'product_id' => $product[0]['product_id'],
                    'jumlah' => $product[0]['jumlah'],
                    'keterangan' => 'Dari Penjualan'
                ]);

                // kurangi stok
                $produk = Product::find($product[0]['product_id']);
                $produk->decrement('stok', $product[0]['jumlah']);
            }

            // update total harga
            $penjualan->update([
                'total_harga' => $penjualan->details->sum('total_harga')
            ]);

            $this->cekMinimalStok();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Transaksi berhasil dibuat!'
            ], 200);
        } catch (\Throwable $th) {
            throw $th;

            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show($invoice)
    {
        $item = Transaction::where('invoice', $invoice)->firstOrFail();
        return view('dashboard.transaction.show', [
            'title' => 'Detail Penjualan',
            'item' => $item
        ]);
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
