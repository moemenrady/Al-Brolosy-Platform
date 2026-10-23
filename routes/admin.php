<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\PaymentPlanController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ConciergeStepController;
use App\Http\Controllers\Admin\SmartCardController;
use App\Http\Controllers\ClientInterestController;
use Illuminate\Support\Facades\Route;

// routes/admin

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // لوحة القيادة المركزية للمنصة
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // إدارة الوحدات العقارية
    Route::get('units', [UnitController::class, 'index'])->name('units.index');
    Route::post('units', [UnitController::class, 'store'])->name('units.store');
    Route::put('units/{unit}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');
    Route::patch('units/{unit}/toggle-status', [UnitController::class, 'toggleStatus'])->name('units.toggle-status');

    // إدارة خطط السداد
    Route::get('payment-plans', [PaymentPlanController::class, 'index'])->name('payment-plans.index');
    Route::post('payment-plans', [PaymentPlanController::class, 'store'])->name('payment-plans.store');
    Route::put('payment-plans/{paymentPlan}', [PaymentPlanController::class, 'update'])->name('payment-plans.update');
    Route::delete('payment-plans/{paymentPlan}', [PaymentPlanController::class, 'destroy'])->name('payment-plans.destroy');

    // إدارة القطاعات
    Route::get('sectors', [SectorController::class, 'index'])->name('sectors.index');
    Route::post('sectors', [SectorController::class, 'store'])->name('sectors.store');
    Route::put('sectors/{sector}', [SectorController::class, 'update'])->name('sectors.update');
    Route::delete('sectors/{sector}', [SectorController::class, 'destroy'])->name('sectors.destroy');
    Route::patch('sectors/{sector}/toggle-active', [SectorController::class, 'toggleActive'])->name('sectors.toggle-active');

    // CRM - إدارة العملاء والطلبات
    Route::get('clients', [ClientInterestController::class, 'index'])->name('clients.index');
    Route::post('clients', [CrmController::class, 'store'])->name('clients.store');
    Route::put('clients/{client}', [CrmController::class, 'update'])->name('clients.update');
    Route::delete('clients/{client}', [CrmController::class, 'destroy'])->name('clients.destroy');
    Route::patch('clients/{client}/status', [CrmController::class, 'updateStatus'])->name('clients.status');
    Route::patch('clients/{client}/assign', [CrmController::class, 'assignEmployee'])->name('clients.assign');
    Route::post('clients/{client}/history', [CrmController::class, 'addHistory'])->name('clients.history');

    Route::get('crm/leads', [CrmController::class, 'leads'])->name('leads.index');
    Route::get('crm/customers', [CrmController::class, 'customers'])->name('customers.index');
    Route::get('crm/contact-requests', [CrmController::class, 'contactRequests'])->name('consultations.index');
    Route::patch('crm/consultations/{consultation}/toggle', [CrmController::class, 'toggleConsultation'])->name('consultations.toggle');
    Route::delete('crm/consultations/{consultation}', [CrmController::class, 'destroyConsultation'])->name('consultations.destroy');

    // إدارة خطوات وأسئلة المستشار الذكي (Concierge Builder)
    Route::get('concierge-steps', [ConciergeStepController::class, 'index'])->name('concierge-steps.index');
    Route::post('concierge-steps', [ConciergeStepController::class, 'store'])->name('concierge-steps.store');
    Route::put('concierge-steps/{conciergeStep}', [ConciergeStepController::class, 'update'])->name('concierge-steps.update');
    Route::delete('concierge-steps/{conciergeStep}', [ConciergeStepController::class, 'destroy'])->name('concierge-steps.destroy');
    Route::patch('concierge-steps/{conciergeStep}/toggle-active', [ConciergeStepController::class, 'toggleActive'])->name('concierge-steps.toggle-active');
    Route::post('concierge-steps/reorder', [ConciergeStepController::class, 'reorder'])->name('concierge-steps.reorder');

    // إدارة المستخدمين والصلاحيات
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.delete');

    // تحليلات السلوك والتقارير
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/export', [AnalyticsController::class, 'exportReport'])->name('analytics.export');

    // إدارة الكروت الذكية VIP
    Route::get('smart-cards', [SmartCardController::class, 'index'])->name('smart-cards');
    Route::get('smart-cards/list', [SmartCardController::class, 'index'])->name('smart-cards.index');
    Route::put('smart-cards/{smartCard}', [SmartCardController::class, 'update'])->name('smart-cards.update');
    Route::post('smart-cards/assign', [SmartCardController::class, 'assign'])->name('smart-cards.assign');
    Route::post('smart-cards/{smartCard}/unlink', [SmartCardController::class, 'unlink'])->name('smart-cards.unlink');
    Route::post('smart-cards/generate', [SmartCardController::class, 'generateBulk'])->name('smart-cards.generate');

    // المنتجات والمجموعات والطلبات الحالية (الحفاظ على كافة الفيتشرز الموجودة)
    Route::get('products/create', [AdminController::class, 'addProduct'])->name('products.create');
    Route::post('products/store', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::put('products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('collections/create', [AdminController::class, 'addCollection'])->name('collections.create');
    Route::post('collections/store', [AdminController::class, 'storeCollection'])->name('collections.store');
    Route::delete('/collections/{id}', [AdminController::class, 'destroyCollection'])->name('collections.destroy');
    Route::get('collections/{id}', [AdminController::class, 'showCollection'])->name('collections.show');

    Route::get('/orders', [AdminController::class, 'indexOrders'])->name('orders.index');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateStatusOrder'])->name('orders.updateStatus');

    Route::get('hero', [AdminController::class, 'editHeroImage'])->name('hero.edit');
    Route::post('hero', [AdminController::class, 'updateHeroImage'])->name('hero.update');
});
