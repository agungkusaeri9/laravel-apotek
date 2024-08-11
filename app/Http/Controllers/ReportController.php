<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductOut;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function product_index()
    {
        return view('dashboard.report.product.index');
    }

    public function product_print()
    {
        $products = Product::with(['product_in', 'product_out'])->orderBy('nama', 'ASC')->get();
        $pdf = Pdf::loadView('dashboard.report.product.print', [
            'products' => $products
        ]);
        return $pdf->download('laporan-barang.pdf');
    }

    public function product_in_index()
    {
        return view('dashboard.report.product-in.index');
    }

    public function product_in_print()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $data = ProductIn::with('product');
        if ($dari && $sampai) {
            $data->whereBetween('created_at', [$dari, $sampai]);
        } elseif ($dari && !$sampai) {
            $data->whereDate('created_at', $dari);
        } else {
            $data->whereNotNull('id');
        }
        $items = $data->latest()->get();
        $pdf = Pdf::loadView('dashboard.report.product-in.print', [
            'items' => $items
        ]);
        return $pdf->download('laporan-barang-masuk.pdf');
    }

    public function product_out_index()
    {
        return view('dashboard.report.product-out.index');
    }

    public function product_out_print()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $data = ProductOut::with('product');
        if ($dari && $sampai) {
            $data->whereBetween('created_at', [$dari, $sampai]);
        } elseif ($dari && !$sampai) {
            $data->whereDate('created_at', $dari);
        } else {
            $data->whereNotNull('id');
        }
        $items = $data->latest()->get();
        $pdf = Pdf::loadView('dashboard.report.product-out.print', [
            'items' => $items
        ]);
        return $pdf->download('laporan-barang-keluar.pdf');
    }

    public function transaksi_index()
    {
        return view('dashboard.report.transaksi.index');
    }

    public function transaksi_print()
    {
        $dari = request('dari');
        $sampai = request('sampai');

        $data = Transaction::with('details');
        if ($dari && $sampai) {
            $data->whereBetween('created_at', [$dari, $sampai]);
        } elseif ($dari && !$sampai) {
            $data->whereDate('created_at', $dari);
        } else {
            $data->whereNotNull('id');
        }
        $items = $data->latest()->get();
        $pdf = Pdf::loadView('dashboard.report.transaksi.print', [
            'items' => $items
        ]);
        return $pdf->download('laporan-transaksi.pdf');
    }
}
