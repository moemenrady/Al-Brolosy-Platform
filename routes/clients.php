<?php

use App\Http\Controllers\ClientInterestController;
use App\Http\Controllers\Api\LeadCaptureController;
use App\Http\Controllers\Api\BehaviorTrackingController;
use Illuminate\Support\Facades\Route;

// الروابط الحالية
Route::post('/api/v1/lead/register', [ClientInterestController::class, 'lead_register'])->name('lead.register');

Route::post('/api/v1/client/register-interest', [ClientInterestController::class, 'store'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class);
Route::get('/client/profile', [ClientInterestController::class, 'show'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class)->name('client.profile');

// نظام أخذ البيانات الذكي بدون ملل ومفاجأة (Frictionless Real Estate Lead Capture)
Route::post('/api/v1/lead/quiz-submit', [LeadCaptureController::class, 'quizSubmit'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class)->name('lead.quiz-submit');

Route::post('/api/v1/lead/quick-inquiry', [LeadCaptureController::class, 'quickInquiry'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class)->name('lead.quick-inquiry');

// تتبع سلوك الزوار والعملاء
Route::post('/api/v1/behavior/track', [BehaviorTrackingController::class, 'track'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class)->name('behavior.track');
