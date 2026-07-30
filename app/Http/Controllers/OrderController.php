<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // التأكد أن الأوردر يخص المستخدم الحالي
        if ($order->user_id !== Auth::id()) abort(403);
        
        // حساب الديبوزت (15%)
        $depositAmount = $order->total * 0.15;
        
        return view('orders.show', compact('order', 'depositAmount'));
    }
}