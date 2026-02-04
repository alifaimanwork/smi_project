<?php


use App\Http\Controllers\Terminal\ProgressStatusController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.terminal','auth.terminal.operator']], function () {

    Route::get('terminal/{plant_uid}/{work_center_uid}/progress-status', [ProgressStatusController::class, 'index'])
        ->name('terminal.progress-status.index');

    //ajax
    Route::post('terminal/{plant_uid}/{work_center_uid}/progress-status/set/stop-production', [ProgressStatusController::class, 'setStopProduction'])
        ->name('terminal.progress-status.set.stop-production');

    Route::post('terminal/{plant_uid}/{work_center_uid}/progress-status/set/resume-production', [ProgressStatusController::class, 'setResumeProduction'])
        ->name('terminal.progress-status.set.resume-production');

    Route::post('terminal/{plant_uid}/{work_center_uid}/progress-status/set/break-production', [ProgressStatusController::class, 'setBreakProduction'])
        ->name('terminal.progress-status.set.break-production');
});
