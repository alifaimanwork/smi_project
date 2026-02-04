<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Web\Admin\CompanyController;
use App\Http\Controllers\Web\Admin\NetworkMonitoringController;
use App\Http\Controllers\Web\Admin\OpcServerController;
use App\Http\Controllers\Web\Admin\PlantController;
use App\Http\Controllers\Web\Admin\SuperAdminController;
use Illuminate\Support\Facades\Route;

//TODO: dashboard middleware

Route::get('dashboard/{plant_uid}/{work_center_uid}', [DashboardController::class, 'index'])
    ->name('dashboard.index');

Route::post('dashboard/{plant_uid}/{work_center_uid}', [DashboardController::class, 'getTerminalData'])
    ->name('dashboard.get.data');
