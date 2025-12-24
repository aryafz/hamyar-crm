<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * نمایش لیست کل سفارشات سیستم با قابلیت صفحه‌بندی
     */
    public function index()
    {
        $orders = Order::with('contact')->latest()->paginate(15);

        return Inertia::render('Orders/Index', [
            'orders' => $orders
        ]);
    }

    /**
     * ذخیره سفارش جدید به همراه مبلغ کل و بیعانه
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'type'       => 'required|string|max:255',
            'amount'     => 'required|numeric|min:0',
            'deposit'    => 'nullable|numeric|min:0',
            'status'     => 'required|string',
        ]);

        // مقداردهی پیش‌فرض برای بیعانه اگر وارد نشده باشد
        $data['deposit'] = $data['deposit'] ?? 0;

        Order::create($data);

        return back()->with('success', 'سفارش جدید با موفقیت در سیستم ثبت شد.');
    }

    /**
     * بروزرسانی وضعیت یا جزئیات مالی سفارش
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status'  => 'sometimes|string',
            'type'    => 'sometimes|string',
            'amount'  => 'sometimes|numeric|min:0',
            'deposit' => 'sometimes|numeric|min:0',
        ]);

        $order->update($data);

        return back()->with('success', 'اطلاعات سفارش با موفقیت بروزرسانی شد.');
    }

    /**
     * حذف فیزیکی سفارش از سیستم
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'سفارش مورد نظر حذف گردید.');
    }
}
