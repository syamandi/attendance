<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;

Route::get('/', [ClassController::class, 'index'])->name('index.form');



Route::get('/classes', function () {
    return view('classes');
});

Route::get('/get-attendance', function () {
    return view('getattendance');
});

Route::get('/attendance', [ClassController::class, 'attendanceForm'])->name('attendance.form');
Route::post('/attendance', [ClassController::class, 'storeAttendance'])->name('attendance.store');


Route::get('/students', [ClassController::class, 'students'])->name('students');
Route::post('/add-student', [ClassController::class, 'addStudent'])->name('addStudent');
Route::patch('/edit-student/{id}', [ClassController::class, 'editStudent'])->name('editStudent');
Route::patch('/delete-student/{id}', [ClassController::class, 'deleteStudent'])->name('deleteStudent');
Route::post('/bulk-assign-students', [ClassController::class, 'bulkAssign'])->name('bulkAssignStudents');



Route::get('/classes', [ClassController::class, 'classes'])->name('classes');
Route::post('/add-class', [ClassController::class, 'addClass'])->name('addClass');
Route::patch('/edit-class/{id}', [ClassController::class, 'editClass'])->name('editClass');
Route::post('/check-class-name', [ClassController::class, 'checkClassName'])->name('checkClassName');;
Route::patch('/delete-class/{id}', [ClassController::class, 'deleteClass'])->name('deleteClass');

Route::get('/student-report', [ClassController::class, 'showAttendanceReportStudent'])->name('attendance.report.student');
Route::get('/class-report', [ClassController::class, 'showAttendanceReportClass'])->name('attendance.report.class');

Route::get('/manual-attendance', [ClassController::class, 'manualattendanceForm'])->name('manualattendance.form');
Route::post('/manual-attendance', [ClassController::class, 'manualstoreAttendance'])->name('manualattendance.store');

