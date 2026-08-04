<?php
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\FeeController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\TimetableController;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated (any role)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/students/{student}/grades', [GradeController::class, 'studentGrades']);
    Route::get('/students/{student}/fees', [FeeController::class, 'studentFees']);
    Route::get('/announcements', [AnnouncementController::class, 'index']);
    Route::get('/timetable', [TimetableController::class, 'index']);

    // Lecturer + Admin
    Route::middleware('role:lecturer,admin')->group(function () {
        Route::post('/grades', [GradeController::class, 'upsert']);
        Route::post('/announcements', [AnnouncementController::class, 'store']);
        Route::post('/timetable', [TimetableController::class, 'store']);
        Route::post('/courses/enroll', [CourseController::class, 'enroll']);
    });

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
        Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy']);
        Route::post('/fees', [FeeController::class, 'store']);
        Route::put('/fees/{fee}/pay', [FeeController::class, 'markPaid']);

        Route::get('/admin/stats', [AdminController::class, 'stats']);
        Route::get('/admin/departments', [AdminController::class, 'departments']);
        Route::post('/admin/departments', [AdminController::class, 'storeDepartment']);
        Route::get('/admin/students', [AdminController::class, 'students']);
        Route::post('/admin/lecturers', [AdminController::class, 'storeLecturer']);
    });
});
