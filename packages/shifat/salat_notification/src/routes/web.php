<?php
use Illuminate\Support\Facades\Route;
use Shifat\Salat_notification\Controllers\SalatController;

Route::get('/salat_waqt_view', [SalatController::class, 'salat_waqt_view'])->name('salat_waqt_view');
Route::post('create_waqt', [SalatController::class, 'create_waqt']);
Route::get('salat_cron', [SalatController::class, 'salat_notification_cron']);
Route::put('/update_waqt/{id}', [SalatController::class, 'update_waqt']);
Route::delete('/delete_waqt/{id}', [SalatController::class, 'delete_waqt']);



