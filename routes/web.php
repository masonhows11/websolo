<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthUser\LoginController;
use App\Http\Controllers\AuthUser\RegisterController;
use App\Http\Controllers\AuthUser\EmailVerifyPromptController;
use App\Http\Controllers\AuthUser\VerifyEmailController;

use App\Http\Controllers\UserDashboard\UserDashboardController;
use App\Http\Controllers\UserDashboard\EditEmailController;

use App\Http\Controllers\AdminDashboard\AdminController;
use App\Http\Controllers\AdminDashboard\Auth\AdminAuthController;
use App\Http\Controllers\AdminDashboard\Auth\AdminValidateController;
use App\Http\Controllers\AdminDashboard\Auth\AdminProfileController;

use App\Http\Controllers\AdminDashboard\AdminCategoryController;
use App\Http\Controllers\AdminDashboard\AdminUsersController;
use App\Http\Controllers\AdminDashboard\AdminAdminsController;

use App\Http\Controllers\AdminDashboard\AdminRoleController;
use App\Http\Controllers\AdminDashboard\AdminPermController;
use App\Http\Controllers\AdminDashboard\AdminAssignRoleController;
use App\Http\Controllers\AdminDashboard\AdminAssignPermController;

use App\Http\Controllers\AdminDashboard\AdminArticleController;
use App\Http\Controllers\AdminDashboard\AdminTagController;
use App\Http\Controllers\AdminDashboard\AdminSampleController;

use App\Http\Controllers\AdminDashboard\AdminBackEndController;
use App\Http\Controllers\AdminDashboard\AdminFrontEndController;
use App\Http\Controllers\AdminDashboard\AdminCommentController;


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TrainingController;

use App\Http\Livewire\Samples;
use App\Http\Livewire\FrontSample;
use App\Http\Livewire\FrontArticle;
use App\Http\Livewire\AboutUs;
use App\Http\Livewire\ContactUs;


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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/loginForm', [LoginController::class, 'loginForm'])->name('loginForm');
Route::post('/login', [LoginController::class, 'login'])->name('login')->middleware(['throttle:3,1']);
Route::get('/registerForm', [RegisterController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/emailVerifyPrompt', [EmailVerifyPromptController::class, 'verifyEmailPrompt'])->name('emailVerifyPrompt');
Route::post('/resendVerifyEmail', [VerifyEmailController::class, 'resendEmailVerify'])->name('resendVerifyEmail');
Route::get('/emailVerify/{id}/{code}', [VerifyEmailController::class, 'verifyEmail'])->name('emailVerify');

Route::middleware(['web','auth','verifyUser'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['web','auth','verifyUser'])->group(function () {

  Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');

  Route::get('/editProfile',[UserDashboardController::class,'editProfile'])->name('editProfile');
  Route::post('/updateProfile',[UserDashboardController::class,'updateProfile'])->name('updateProfile');
  
  Route::get('/editEmailForm',[EditEmailController::class,'editEmailForm'])->name('editEmailForm');
  Route::post('/editEmail',[EditEmailController::class,'editEmail'])->name('editEmail');
  Route::get('/verifyEditEmail/{$id}{$code}',[EditEmailController::class,'verifyEditEmail'])->name('verifyEditEmail');

});
///////////////////////////////////// front routes /////////////////////////////////////

// about us contact us
Route::get('/about-us',AboutUs::class)->name('aboutUs');

Route::get('/contact-us',ContactUs::class)->name('contactUs');


// articles
Route::get('/articles',[ArticleController::class,'index'])->name('articleIndex');
Route::get('/articles/{category}',[ArticleController::class,'articleCategory'])->name('articleCategory');
Route::get('/article/{article}',FrontArticle::class)->name('article');
// samples
Route::get('/samples',Samples::class)->name('sampleIndex');
Route::get('/sample/{sample}',FrontSample::class)->name('sample');
// tags
Route::get('/tag/{tag}',[TagController::class,'index'])->name('articlesByTag');
// training
Route::get('/trainings',[TrainingController::class,'index'])->name('trainingIndex');


///////////////////////////////////// admin routes /////////////////////////////////////

// admin auth routes
Route::group(['prefix'=>'admin'],function (){

    Route::get('/loginForm',[AdminAuthController::class,'loginAdminForm'])->name('adminLoginForm');
    Route::post('/login',[AdminAuthController::class,'loginAdmin'])->name('adminLogin');

    Route::get('/validate/mobileForm',[AdminValidateController::class,'validateMobileForm'])->name('validateMobileForm');
    Route::post('/validate/mobile',[AdminValidateController::class,'validateMobile'])->name('validateMobile');

    Route::post('/resend/token',[AdminValidateController::class,'resendToken'])->name('adminResendToken');
});


Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){

    Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
    Route::get('/logOut',[AdminAuthController::class,'logOut'])->name('adminLogOut');

});

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){

    Route::get('/profile',[AdminProfileController::class,'profile'])->name('adminProfile');
    Route::post('/update/profile', [AdminProfileController::class, 'update'])->name('updateProfile');

    Route::get('/edit/mobile', [AdminProfileController::class, 'editMobile'])->name('editMobile');
    Route::post('/update/mobile', [AdminProfileController::class, 'updateMobile'])->name('updateMobile');

});

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function () {
    Route::get('/users',[AdminUsersController::class,'index'])->name('adminUsers');
    Route::get('/users/status/{user}',[AdminUsersController::class,'status'])->name('adminUserStatus');
    Route::get('/destroy',[AdminUsersController::class,'destroy'])->name('adminUserDestroy');
});

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function () {
    Route::get('/admins',[AdminAdminsController::class,'index'])->name('adminAdmins');
});

/* roles & permissions */
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function () {
    Route::get('/roles',[AdminRoleController::class,'index'])->name('adminRoles');
});

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function () {
    Route::get('/permissions',[AdminPermController::class,'index'])->name('adminPermissions');
});

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function () {
    Route::get('/assignRole',[AdminAssignRoleController::class,'index'])->name('adminAssignRole');
});

Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function () {
    Route::get('/assignPerm',[AdminAssignPermController::class,'index'])->name('adminAssignPerm');
});
// category
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){
    Route::get('/category/index',[AdminCategoryController::class,'index'])->name('categoryIndex');
    Route::get('/category/create', [AdminCategoryController::class, 'create'])->name('categoryCreate');
    Route::post('/category/store',[AdminCategoryController::class,'store'])->name('categoryStore');

    Route::get('/category/edit/{category}',[AdminCategoryController::class,'edit'])->name('categoryEdit');
    Route::post('/category/update',[AdminCategoryController::class,'update'])->name('categoryUpdate');

    Route::get('/category/delete',[AdminCategoryController::class,'destroy'])->name('categoryDelete');
    Route::get('/category/detach/{category}',[AdminCategoryController::class,'detach'])->name('categoryDetach');

    Route::get('/category/activate/{category}', [AdminCategoryController::class, 'activate'])->name('categoryActivate');
});
// tag admin
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){
    Route::get('/tag/index',[AdminTagController::class,'index'])->name('tagIndex');
    Route::get('/tag/create',[AdminTagController::class,'create'])->name('tagCreate');
    Route::post('/tag/store',[AdminTagController::class,'store'])->name('tagStore');

    Route::get('/tag/edit/{tag}',[AdminTagController::class,'edit'])->name('tagEdit');
    Route::post('/tag/update',[AdminTagController::class,'update'])->name('tagUpdate');

    Route::get('/tag/delete',[AdminTagController::class,'destroy'])->name('tagDelete');
});
// back-end admin
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){
    Route::get('/back/index',[AdminBackEndController::class,'index'])->name('backIndex');
    Route::get('/back/create',[AdminBackEndController::class,'create'])->name('backCreate');
    Route::post('/back/store',[AdminBackEndController::class,'store'])->name('backStore');

    Route::get('/back/edit/{backEnd}',[AdminBackEndController::class,'edit'])->name('backEdit');
    Route::post('/back/update',[AdminBackEndController::class,'update'])->name('backUpdate');

    Route::get('/back/delete',[AdminBackEndController::class,'destroy'])->name('backDelete');
});
// front-end admin
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){
    Route::get('/front/index',[AdminFrontEndController::class,'index'])->name('frontIndex');
    Route::get('/front/create',[AdminFrontEndController::class,'create'])->name('frontCreate');
    Route::post('/front/store',[AdminFrontEndController::class,'store'])->name('frontStore');

    Route::get('/front/edit/{frontEnd}',[AdminFrontEndController::class,'edit'])->name('frontEdit');
    Route::post('/front/update',[AdminFrontEndController::class,'update'])->name('frontUpdate');

    Route::get('/front/delete',[AdminFrontEndController::class,'destroy'])->name('frontDelete');
});
// article admin
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){
    Route::get('/article/index',[AdminArticleController::class,'index'])->name('articleIndex');
    Route::get('/article/create', [AdminArticleController::class, 'create'])->name('articleCreate');
    Route::post('/article/store',[AdminArticleController::class,'store'])->name('articleStore');

    Route::get('/article/edit/{article}',[AdminArticleController::class,'edit'])->name('articleEdit');
    Route::post('/article/update',[AdminArticleController::class,'update'])->name('articleUpdate');

    Route::get('/article/delete',[AdminArticleController::class,'destroy'])->name('articleDelete');
    Route::get('/article/activate/{article}',[AdminArticleController::class,'activate'])->name('articleActivate');
});
// sample admin
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){

    Route::get('/sample/index',[AdminSampleController::class,'index'])->name('sampleIndex');
    Route::get('/sample/create', [AdminSampleController::class, 'create'])->name('sampleCreate');
    Route::post('/sample/store',[AdminSampleController::class,'store'])->name('sampleStore');

    Route::get('/sample/edit/{sample}',[AdminSampleController::class,'edit'])->name('sampleEdit');
    Route::post('/sample/update',[AdminSampleController::class,'update'])->name('sampleUpdate');

    Route::get('/sample/delete',[AdminSampleController::class,'destroy'])->name('sampleDelete');
    Route::get('/sample/activate/{sample}',[AdminSampleController::class,'activate'])->name('sampleActivate');
});
// comment admin
Route::prefix('admin')->name('admin.')->middleware(['web','auth:admin','verify_admin','role:admin|admin'])->group(function (){

    Route::get('/comment/sample/index',[AdminCommentController::class,'samples'])->name('sampleCommentIndex');
    Route::get('/comments/sample/{sample}',[AdminCommentController::class,'sampleComments'])->name('sampleComments');
    Route::get('/comment/sample/approve',[AdminCommentController::class,'approveSampleComment'])->name('sampleApproveComment');
    Route::get('/comment/sample/delete',[AdminCommentController::class,'deleteSampleComment'])->name('sampleDeleteComment');

    Route::get('/comment/article/index',[AdminCommentController::class,'articles'])->name('articleCommentIndex');
    Route::get('/comments/article/{article}',[AdminCommentController::class,'articleComments'])->name('articleComments');
    Route::get('/comment/article/approve',[AdminCommentController::class,'approveArticleComment'])->name('articleApproveComment');
    Route::get('/comment/article/delete',[AdminCommentController::class,'deleteArticleComment'])->name('articleDeleteComment');


});
