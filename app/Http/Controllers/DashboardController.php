<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $karyawan = User::where('role_id', 2)->count();
        $masyarakat = User::where('role_id', 3)->count();
        $category = Category::all()->count();
        $product = Product::all()->count();
        $transaksi = Transaction::count();

        return view('dashboard.index', [
            'masyarakat' => $masyarakat,
            'transaksi' => $transaksi,
            'karyawan' => $karyawan,
            'category' => $category,
            'product' => $product
        ]);
    }
}
