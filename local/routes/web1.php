<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth::routes();
Auth::routes([
   'register' => false, // Registration Routes...
   'reset' => false, // Password Reset Routes...
   'verify' => false, // Email Verification Routes...
   'login' => false, // Email Verification Routes...
 ]);
//Forget password

//get state  getStateByCountryID
Route::get('/getStateByCountryID', [App\Http\Controllers\HomeController::class, 'getStateByCountryID'])->name('getStateByCountryID');
Route::get('/getCityByStateID', [App\Http\Controllers\HomeController::class, 'getCityByStateID'])->name('getCityByStateID');



Route::get('/forget-password', [App\Http\Controllers\ForgotPasswordController::class, 'getEmail'])->name('getEmail');
Route::post('/postEmail', [App\Http\Controllers\ForgotPasswordController::class, 'postEmail'])->name('postEmail');



Route::get('/reset-password/{token}', [App\Http\Controllers\ForgotPasswordController::class, 'getPassword'])->name('getPassword');
Route::post('/updatePassword', [App\Http\Controllers\ForgotPasswordController::class, 'updatePassword'])->name('updatePassword');

//custom Login 

Route::post('/customLogin', [App\Http\Controllers\Auth\LoginController::class, 'customLogin'])->name('customLogin');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/roles', [App\Http\Controllers\PermissionController::class, 'Permission'])->name('Permission');

Route::group(['middleware' => 'role:superadmin'], function() {

   //  Route::get('/admin', function() { 
   //     return 'Welcome Admin';
       
   //  });
    Route::get('/add-school', [App\Http\Controllers\SuperAdminController::class, 'add_school'])->name('add_school');
    Route::get('/edit-school/{id}', [App\Http\Controllers\SuperAdminController::class, 'edit_school'])->name('edit_school');
    Route::get('/view-school/{id}', [App\Http\Controllers\SuperAdminController::class, 'view_school'])->name('view_school');
    Route::get('/view-school-requested/{id}', [App\Http\Controllers\SuperAdminController::class, 'view_school_requested'])->name('view_school_requested');

    


    Route::get('/edit-user/{id}', [App\Http\Controllers\SuperAdminController::class, 'edit_user'])->name('edit_user');
    Route::get('/view-user/{id}', [App\Http\Controllers\SuperAdminController::class, 'view_user'])->name('view_user');

    
    Route::post('/saveSchool', [App\Http\Controllers\SuperAdminController::class, 'saveSchool'])->name('saveSchool');
    Route::get('/school-list', [App\Http\Controllers\SuperAdminController::class, 'schoolList'])->name('schoolList');
    Route::get('/school-request-list', [App\Http\Controllers\SuperAdminController::class, 'SchoolRequestList'])->name('SchoolRequestList');

    

    Route::post('/uploadSchoolDoc', [App\Http\Controllers\SuperAdminController::class, 'uploadSchoolDoc'])->name('uploadSchoolDoc');
    Route::post('/uploadSchoolLogo', [App\Http\Controllers\SuperAdminController::class, 'uploadSchoolLogo'])->name('uploadSchoolLogo');
    Route::post('/uploadSchoolSlider', [App\Http\Controllers\SuperAdminController::class, 'uploadSchoolSlider'])->name('uploadSchoolSlider');
    Route::post('/uploadUserPhoto', [App\Http\Controllers\SuperAdminController::class, 'uploadUserPhoto'])->name('uploadUserPhoto');

    

    Route::post('/updateSchoolHistory', [App\Http\Controllers\SuperAdminController::class, 'updateSchoolHistory'])->name('updateSchoolHistory');
    Route::post('/updateUserInterest', [App\Http\Controllers\SuperAdminController::class, 'updateUserInterest'])->name('updateUserInterest');
    Route::post('/updateUserSport', [App\Http\Controllers\SuperAdminController::class, 'updateUserSport'])->name('updateUserSport');

    

    Route::post('/updateSchoolInstructor', [App\Http\Controllers\SuperAdminController::class, 'updateSchoolInstructor'])->name('updateSchoolInstructor');

    Route::get('/user-list', [App\Http\Controllers\SuperAdminController::class, 'userList'])->name('userList');
    Route::get('/admin-profile', [App\Http\Controllers\SuperAdminController::class, 'admin_profile'])->name('admin_profile');
    Route::get('/add-static-content', [App\Http\Controllers\SuperAdminController::class, 'addStaticContent'])->name('addStaticContent');
    Route::post('/saveStaticContent', [App\Http\Controllers\SuperAdminController::class, 'saveStaticContent'])->name('saveStaticContent');
    Route::get('/static-content-list', [App\Http\Controllers\SuperAdminController::class, 'staticContentList'])->name('staticContentList');
    Route::get('/edit-static-content/{id}', [App\Http\Controllers\SuperAdminController::class, 'editStaticContent'])->name('editStaticContent');
    Route::get('/view-school-details/{id}', [App\Http\Controllers\SuperAdminController::class, 'viewSchoolDetails'])->name('viewSchoolDetails');
    Route::get('/getSchoolCourse', [App\Http\Controllers\SuperAdminController::class, 'getSchoolCourse'])->name('getSchoolCourse');
    Route::get('/getMoreCertificate', [App\Http\Controllers\SuperAdminController::class, 'getMoreCertificate'])->name('getMoreCertificate');
    Route::get('/getEnrollSchool/{id}', [App\Http\Controllers\SuperAdminController::class, 'getEnrollSchool'])->name('getEnrollSchool');
    

    
    
    


    


    Route::get('/certificate-list', [App\Http\Controllers\SuperAdminController::class, 'schoolCertificateList'])->name('schoolCertificateList');
    Route::get('/school-performance-list', [App\Http\Controllers\SuperAdminController::class, 'schoolPerformanceList'])->name('schoolPerformanceList');

    Route::post('/createOrSentSchoolAccount', [App\Http\Controllers\SuperAdminController::class, 'createOrSentSchoolAccount'])->name('createOrSentSchoolAccount');
    Route::post('/useractionSchoolAccount', [App\Http\Controllers\SuperAdminController::class, 'useractionSchoolAccount'])->name('useractionSchoolAccount');
    Route::post('/useractionUserIsActive', [App\Http\Controllers\SuperAdminController::class, 'useractionUserIsActive'])->name('useractionUserIsActive');

    Route::post('/saveUserEdit', [App\Http\Controllers\SuperAdminController::class, 'saveUserEdit'])->name('saveUserEdit');
    Route::post('/saveAdminProfile', [App\Http\Controllers\SuperAdminController::class, 'saveAdminProfile'])->name('saveAdminProfile');

    

    
    
    

    
    

    

    Route::post('/deleteSchool', [App\Http\Controllers\SuperAdminController::class, 'deleteSchool'])->name('deleteSchool');
    Route::post('/deleteUser', [App\Http\Controllers\SuperAdminController::class, 'deleteUser'])->name('deleteUser');
    


    

    Route::post('/UserResetPassword', [App\Http\Controllers\SuperAdminController::class, 'UserResetPassword'])->name('UserResetPassword');


    


    Route::post('/deleteSportInterst', [App\Http\Controllers\SuperAdminController::class, 'deleteSportInterst'])->name('deleteSportInterst');
    Route::post('/deletebyAction', [App\Http\Controllers\SuperAdminController::class, 'deletebyAction'])->name('deletebyAction');
    Route::post('/schoolAcceptedRejectAction', [App\Http\Controllers\SuperAdminController::class, 'schoolAcceptedRejectAction'])->name('schoolAcceptedRejectAction');

    


    

    

    Route::post('/deletImage', [App\Http\Controllers\SuperAdminController::class, 'deletImage'])->name('deletImage');
    Route::post('/saveSportIntrest', [App\Http\Controllers\SuperAdminController::class, 'saveSportIntrest'])->name('saveSportIntrest');
    


    

    
   //  datatable

   Route::get('/getDatatableSchoolList', [App\Http\Controllers\SuperAdminController::class, 'getDatatableSchoolList'])->name('getDatatableSchoolList');
   Route::get('/getDatatableSchoolListData', [App\Http\Controllers\SuperAdminController::class, 'getDatatableSchoolListData'])->name('getDatatableSchoolListData');
   Route::get('/getSchoolCertificates', [App\Http\Controllers\SuperAdminController::class, 'getSchoolCertificates'])->name('getSchoolCertificates');
   Route::get('/getSchoolCertificatesBYFilter', [App\Http\Controllers\SuperAdminController::class, 'getSchoolCertificatesBYFilter'])->name('getSchoolCertificatesBYFilter');

   

   Route::get('/getSchoolCertificatesByWeek', [App\Http\Controllers\SuperAdminController::class, 'getSchoolCertificatesByWeek'])->name('getSchoolCertificatesByWeek');
   Route::get('/getCousePaymentByFilter', [App\Http\Controllers\SuperAdminController::class, 'getCousePaymentByFilter'])->name('getCousePaymentByFilter');
   Route::get('/getCousePaymentByFilterThisWeek', [App\Http\Controllers\SuperAdminController::class, 'getCousePaymentByFilterThisWeek'])->name('getCousePaymentByFilterThisWeek');

   


   


   

   Route::get('/getSchoolPerformance', [App\Http\Controllers\SuperAdminController::class, 'getSchoolPerformance'])->name('getSchoolPerformance');
   Route::get('/getSchoolPerformanceFilter', [App\Http\Controllers\SuperAdminController::class, 'getSchoolPerformanceFilter'])->name('getSchoolPerformanceFilter');
   Route::get('/getSchoolPerformanceFilterCountry', [App\Http\Controllers\SuperAdminController::class, 'getSchoolPerformanceFilterCountry'])->name('getSchoolPerformanceFilterCountry');

   

   Route::get('/getSchoolPerformanceFilterTop', [App\Http\Controllers\SuperAdminController::class, 'getSchoolPerformanceFilterTop'])->name('getSchoolPerformanceFilterTop');


   

   

   Route::get('/getSchoolRatingComments', [App\Http\Controllers\SuperAdminController::class, 'getSchoolRatingComments'])->name('getSchoolRatingComments');
   Route::get('/getSchoolRatingCommentsBySchool', [App\Http\Controllers\SuperAdminController::class, 'getSchoolRatingCommentsBySchool'])->name('getSchoolRatingCommentsBySchool');

   


   

   Route::get('/view-school-ratings/{id}', [App\Http\Controllers\SuperAdminController::class, 'getSchoolCommentRating'])->name('getSchoolCommentRating');

   


   


   

   

   Route::get('/getDatatableUserList', [App\Http\Controllers\SuperAdminController::class, 'getDatatableUserList'])->name('getDatatableUserList');

   Route::get('/basic-settings', [App\Http\Controllers\SuperAdminController::class, 'basicSettings'])->name('basicSettings');

   
   


 
 });