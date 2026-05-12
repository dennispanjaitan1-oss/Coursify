<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $plan = $request->query('plan', 'pro'); // default pro
        return view('payment', compact('plan'));
    }
}