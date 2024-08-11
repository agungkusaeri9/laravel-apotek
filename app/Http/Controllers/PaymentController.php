<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentCheck;

class PaymentController extends Controller
{
    public function show($id)
    {
        $paymentcheck = PaymentCheck::where('orderdetail_id', $id)->latest();
        return view('dashboard.user.UserCheckPayment', [
            'paymentcheck' => $paymentcheck
        ]);
    }
}
