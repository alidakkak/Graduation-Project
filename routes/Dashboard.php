<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\JobOpportunityController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::get('getStudentNotRegistrationComplete', [StudentController::class, 'getStudentNotRegistrationComplete']);
Route::patch('checkStudentData/{id}', [StudentController::class, 'checkStudentData']);

//////  Announcements
Route::post('announcement', [AnnouncementController::class, 'store']);
Route::post('announcement/{id}', [AnnouncementController::class, 'update']);
Route::get('announcements', [AnnouncementController::class, 'index']);
Route::get('announcement/{id}', [AnnouncementController::class, 'show']);
Route::delete('announcement/{id}', [AnnouncementController::class, 'delete']);

////// Job Opportunity
Route::post('jobOpportunity', [JobOpportunityController::class, 'store']);
Route::post('jobOpportunity/{id}', [JobOpportunityController::class, 'update']);
Route::get('jobOpportunities', [JobOpportunityController::class, 'index']);
Route::get('jobOpportunity/{id}', [JobOpportunityController::class, 'show']);
Route::delete('jobOpportunity/{id}', [JobOpportunityController::class, 'delete']);
Route::put('switchJobIsExpired/{id}', [JobOpportunityController::class, 'switchJobIsExpired']);

///// Academic Year
Route::post('academicYear', [AcademicYearController::class, 'store']);
Route::get('academicYears', [AcademicYearController::class, 'index']);
Route::get('academicYear/{id}', [AcademicYearController::class, 'show']);
Route::delete('academicYear/{id}', [AcademicYearController::class, 'delete']);

///// Work Schedule
Route::post('workSchedules', [WorkScheduleController::class, 'store']);
Route::get('workSchedules', [WorkScheduleController::class, 'getSchedulesBySemesterID']);
Route::put('workSchedules/{id}', [WorkScheduleController::class, 'update']);

///// Work Schedule
Route::post('examSchedules', [ExamScheduleController::class, 'store']);
Route::get('examSchedules', [ExamScheduleController::class, 'getSchedulesBySemesterID']);
Route::put('examSchedules/{id}', [ExamScheduleController::class, 'update']);
