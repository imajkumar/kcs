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
   
    


    Route::get('/edit-user/{id}', [App\Http\Controllers\SuperAdminController::class, 'edit_user'])->name('edit_user');
    Route::get('/view-user/{id}', [App\Http\Controllers\SuperAdminController::class, 'view_user'])->name('view_user');

    
   
   
   

    

    

   

    Route::get('/user-list', [App\Http\Controllers\SuperAdminController::class, 'userList'])->name('userList');
    Route::get('/add-user', [App\Http\Controllers\SuperAdminController::class, 'addUser'])->name('addUser');


    Route::get('/admin-profile', [App\Http\Controllers\SuperAdminController::class, 'admin_profile'])->name('admin_profile');
   
   
   
   
   
   
   
   
    

    
    
    


    


    
    Route::post('/useractionUserIsActive', [App\Http\Controllers\SuperAdminController::class, 'useractionUserIsActive'])->name('useractionUserIsActive');

    Route::post('/saveUserEdit', [App\Http\Controllers\SuperAdminController::class, 'saveUserEdit'])->name('saveUserEdit');
    Route::post('/saveUserData', [App\Http\Controllers\SuperAdminController::class, 'saveUserData'])->name('saveUserData');
    Route::post('/uploadFile', [App\Http\Controllers\SuperAdminController::class, 'uploadFile'])->name('uploadFile');

    

    Route::post('/saveAdminProfile', [App\Http\Controllers\SuperAdminController::class, 'saveAdminProfile'])->name('saveAdminProfile');

    

    
    
    

    
    

    

    
    Route::post('/deleteUser', [App\Http\Controllers\SuperAdminController::class, 'deleteUser'])->name('deleteUser');
    Route::post('/UserResetPassword', [App\Http\Controllers\SuperAdminController::class, 'UserResetPassword'])->name('UserResetPassword');


    


    
    Route::post('/deletebyAction', [App\Http\Controllers\SuperAdminController::class, 'deletebyAction'])->name('deletebyAction');
  

    


    

    

    Route::post('/deletImage', [App\Http\Controllers\SuperAdminController::class, 'deletImage'])->name('deletImage');
  
    


    

    
   //  datatable

   

   


   



   Route::get('/getDatatableUserList', [App\Http\Controllers\SuperAdminController::class, 'getDatatableUserList'])->name('getDatatableUserList');



   
   
   


 
 });