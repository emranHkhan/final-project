<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// commmon page routes
Route::view('/', 'pages.home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/jobs', 'pages.jobs')->name('jobs');
Route::view('/blogs', 'pages.blogs')->name('blogs');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/userLogin', 'pages.auth.login-page')->name('login');
Route::view('/userRegistration', 'pages.auth.registration-page')->name('register');
Route::view('/sendOtp', 'pages.auth.send-otp-page')->name('sendOtp');
Route::view('/verifyOtp', 'pages.auth.verify-otp-page')->name('verifyOtp');
Route::view('/resetPassword', 'pages.auth.reset-pass-page')->name('resetPassword');
Route::view('/userProfile', 'pages.dashboard.profile-page')->name('userProfile');

// page data
Route::get('/home/categories', [PageController::class, 'index']);
Route::post('/home/jobsByCategory', [PageController::class, 'getJobsByCategory']);
Route::post('/home/saveJobCandidate', [PageController::class, 'saveJobCandidate']);
Route::get('/home/getTopCompanies', [PageController::class, 'getTopCompanies']);
Route::get('/blogs/getBlogsPageInfo', [PageController::class, 'getBlogsPageInfo']);
Route::get('/contact/getContactPageInfo', [PageController::class, 'getContactPageInfo']);
Route::get('/about/getAboutPageInfo', [PageController::class, 'getAboutPageInfo']);
Route::get('/blogs/getAllBlogs', [PageController::class, 'getAllBlogs']);
// company backend routes
Route::view('/company/dashboard', 'pages.dashboard.company-dashboard');
Route::view('/company/jobs', 'pages.dashboard.company-jobs');
Route::view('/company/plugins', 'pages.dashboard.company-plugins');
Route::view('/company/blogs', 'pages.dashboard.company-blogs');


Route::post('/company/job', [CompanyController::class, 'postJob'])->middleware('auth:sanctum');
Route::post('/company/job-summary', [CompanyController::class, 'getJobSummary'])->middleware('auth:sanctum');
Route::get('/company/allJobs', [CompanyController::class, 'getJobs'])->middleware('auth:sanctum');
Route::get('/company/{id}', [CompanyController::class, 'index'])->middleware('auth:sanctum');
// candidate backend routes
Route::view('/candidate/dashboard', 'pages.dashboard.candidate-dashboard');
Route::view('/candidate/jobs', 'pages.dashboard.candidate-jobs');
Route::view('/candidate/profile', 'pages.dashboard.candidate-profile');
Route::post('/candidate/save', [CandidateController::class, 'saveCandidate'])->middleware('auth:sanctum');

Route::get('/candidate/jobs/{id}', [CandidateController::class, 'getAppliedJobsCount'])->middleware('auth:sanctum');
Route::get('/candidate/appliedJobs/{id}', [CandidateController::class, 'getAppliedJobs'])->middleware('auth:sanctum');
// admin backend routes
Route::view('/admin/dashboard', 'pages.dashboard.admin-dashboard');
Route::view('/admin/jobs', 'pages.dashboard.admin-jobs');
Route::view('/admin/profile', 'pages.dashboard.admin-profile');
Route::view('/admin/blogs', 'pages.dashboard.admin-blogs');
Route::view('/admin/pages', 'pages.dashboard.admin-pages');
Route::view('/admin/companies', 'pages.dashboard.admin-companies');

Route::get('/admin/getJobs', [AdminController::class, 'getJobs'])->middleware('auth:sanctum');
Route::post('/admin/update-job-status', [AdminController::class, 'updateJobStatus'])->middleware('auth:sanctum');
Route::post('/admin/delete-job', [AdminController::class, 'deleteJob'])->middleware('auth:sanctum');
Route::get('/admin/getCompanies', [AdminController::class, 'getCompanies'])->middleware('auth:sanctum');
Route::post('/admin/update-company-status', [AdminController::class, 'updateCompanyStatus'])->middleware('auth:sanctum');
Route::post('/admin/delete-company', [AdminController::class, 'deleteCompany'])->middleware('auth:sanctum');
Route::get('/admin/jobAndCompanyData', [AdminController::class, 'getJobAndCompanyData'])->middleware('auth:sanctum');
Route::post('/admin/saveBlogData', [AdminController::class, 'saveBlogData'])->middleware('auth:sanctum');
Route::post('/admin/savePageData', [AdminController::class, 'savePageData'])->middleware('auth:sanctum');
Route::get('/admin/getBlogs', [AdminController::class, 'getBlogs'])->middleware('auth:sanctum');
Route::get('/admin/getCandidateCount/{id}', [AdminController::class, 'getCandidateCount'])->middleware('auth:sanctum');
Route::get('/admin/getJob/{id}', [AdminController::class, 'getJob'])->middleware('auth:sanctum');
Route::get('/admin/getCandidateForJob/{id}', [AdminController::class, 'getCandidateForJob'])->middleware('auth:sanctum');

// user authentication routes
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware('auth:sanctum');
Route::get('/logout', [UserController::class, 'UserLogout'])->middleware('auth:sanctum');
Route::post('/user-update', [UserController::class, 'UpdateProfile'])->middleware('auth:sanctum');
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware('auth:sanctum');
