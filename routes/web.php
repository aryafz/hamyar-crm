<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\{Contact, Order};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ۱. صفحه فرود عمومی
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// ۲. مسیرهای اختصاصی CRM (نیاز به لاگین دارند)
Route::middleware(['auth', 'verified'])->group(function () {

    // داشبورد اصلی با محاسبات مالی پویا
    Route::get('/dashboard', function () {
        $totalAmount = Order::sum('amount');
        $totalPaid = Order::sum('deposit');

        return Inertia::render('Dashboard', [
            'stats' => [
                'total_contacts' => Contact::count(),
                'active_orders'  => Order::where('status', '!=', 'completed')->count(),
                'total_revenue'  => (float) $totalPaid,
                'total_pending'  => (float) ($totalAmount - $totalPaid),
            ],
            'chartData' => Order::select('amount', 'status', 'created_at')->get()
        ]);
    })->name('dashboard');

    // مدیریت مخاطبین/مشتریان
    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
        Route::post('/', [ContactController::class, 'store'])->name('contacts.store');
        Route::get('/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::patch('/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::delete('/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        // ثبت تعامل در تایم‌لاین
        Route::post('/{contact}/interactions', [ContactController::class, 'storeInteraction'])->name('contacts.interactions.store');
    });

    // مدیریت سفارشات
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::patch('/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    // مدیریت پروفایل کاربری مدیر
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
