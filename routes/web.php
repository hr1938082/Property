<?php

use App\Http\Controllers\AddsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SocialLinksController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TendentController;
use App\Http\Controllers\UsersubscriptionController;
use App\Models\SocialLinks;
use App\Models\usersubscription;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/foo', function () {
    Artisan::call('storage:link');
});
Route::get('/policy', function () {
    $social = SocialLinks::all();
    $socialLinks = [
        $social[0]->name => $social[0]->link,
        $social[1]->name => $social[1]->link,
        $social[2]->name => $social[2]->link,
        $social[3]->name => $social[3]->link,
    ];
    view()->share('socialLinks', $socialLinks);
    return view('web.privacypolicy');
})->name('policy');
Route::get('/admin', function () {
    return view('auth.login');
})->middleware('guest')->name('login_view');
Route::get('/', [AddsController::class, 'webselect'])->name('index');
Route::get('/adds/{id}', [AddsController::class, 'webadsdetails'])->name('web.add');
Route::get('/contact', function () {
    return view('web.contact');
})->name('contact');
Route::get('/about', function () {
    return view('web.about');
})->name('about');
Route::post('contact/mail/send', [ContactController::class, 'contact'])->name('contact-mail-send');
Route::get('/add', function () {
    return view('web.adds');
})->name('add');
Route::get('/ads/request', [AddsController::class, 'indexrequestforad'])->name('adds.request');
Route::post('/ads/request', [AddsController::class, 'webstore'])->name('adds.request.send');
Route::get('/home', [AdminController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::group(["middleware" => "auth", "prefix" => "user"], function () {
    Route::get('profile', function () {
        return view('profile.edit');
    })->name('editprofile');
    Route::view('password/update', 'profile.password')->name('changepassword');
    Route::get('/add', [AdminController::class, 'adduserform'])->name('userform');
    Route::post('/register', [AdminController::class, 'register'])->name('useradd');
    Route::get('/manage', [UserController::class, 'selectAdmin'])->name('manageuser');
    Route::get('/edit', [UserController::class, 'updateAdmin'])->name('edituser');
    Route::post('update/name', [UserController::class, 'updateNameAdmin'])->name('updatename');
    Route::post('update/usertype', [UserController::class, 'updateUserTypeAdmin'])->name('updateusertype');
    Route::post('update/email', [UserController::class, 'updateEmailAdmin'])->name('updateemail');
    Route::post('check/password', [UserController::class, 'checkpasswordAdmin']);
    Route::post('update/password', [UserController::class, 'updatepasswordAdmin'])->name('updatepass');
    Route::post('update/mobile', [UserController::class, 'updatemobileAdmin'])->name('updatemob');
    Route::post('update/address', [UserController::class, 'updateaddressAdmin'])->name('updateadd');
    Route::post('update/profile-image', [UserController::class, 'updateImageAdmin'])->name('updateimage');
    Route::get('stat/update/{id}/{column}/{search}/{page}', [UserController::class, 'userStatUpdate'])->name('userStatUpdate');
});
Route::group(["middleware" => "auth", "prefix" => "user/type"], function () {
    Route::get('/add', [UserTypeController::class, 'insertform'])->name('show-add-user-type');
    Route::post('/add', [UserTypeController::class, 'insert'])->name('add-user-type');
    Route::get('/manage', [UserTypeController::class, 'select'])->name('manage-user-type');
    Route::post('/upadte', [UserTypeController::class, 'update'])->name('upadte-user-type');
});
Route::group(["middleware" => "auth", "prefix" => "properties"], function () {
    Route::get('/add', [PropertyController::class, 'index'])->name('add-properties');
    Route::post('/add', [PropertyController::class, 'insert'])->name('insert-properties');
    Route::get('/manage', [PropertyController::class, 'select'])->name('manage-properties');
    Route::get('/{id}', [PropertyController::class, 'selectspecific'])->name('select-properties');
    Route::get('/delete/{id}', [PropertyController::class, 'delete'])->name('delete-properties');
    Route::get('/edit/images/{id}', [PropertyController::class, 'editImages'])->name('editImages');
    Route::post('/delete/image', [PropertyController::class, 'deleteimage'])->name('deleteImage');
    Route::post('update/images', [PropertyController::class, 'updateimage'])->name('updateimage');
    Route::get('edit/info/{id}', [PropertyController::class, 'editinfo'])->name('editinfo');
    Route::post('update/info', [PropertyController::class, 'updateinfo'])->name('updateinfo');
    Route::get('edit/address/{id}', [PropertyController::class, 'editaddress'])->name('editaddress');
    Route::post('update/address', [PropertyController::class, 'updateaddress'])->name('updateaddress');
});
Route::group(["middelware" => "auth", "prefix" => "territory"], function () {
    Route::get('/country/add', [CountryController::class, 'index'])->name('Country.index');
    Route::post('/country/add', [CountryController::class, 'store'])->name('Country.store');
    Route::get('/country/manage', [CountryController::class, 'select'])->name('Country.select');
    Route::get('country/update/{id}', [CountryController::class, 'statUpdate'])->name('Country.statupdate');
    Route::get('/state/add', [StatesController::class, 'index'])->name('stateIndex');
    Route::post('/state/add', [StatesController::class, 'insert'])->name('stateInsert');
    Route::get('state/manage', [StatesController::class, 'select'])->name('stateManage');
    Route::get('state/update/{id}', [StatesController::class, 'statUpdate'])->name('stateUpdate');
    Route::get('state/select/{country_name}', [StatesController::class, 'selectWeb'])->name('stateSelectWeb');
    Route::get('city/add', [CityController::class, 'Index'])->name('cityIndex');
    Route::post('city/add', [CityController::class, 'insert'])->name('cityInsert');
    Route::get('city/manage', [CityController::class, 'select'])->name('cityManage');
    Route::get('city/delete/{id}', [CityController::class, 'delete'])->name('cityDelete');
    Route::get('city/edit/{id}', [CityController::class, 'edit'])->name('cityEdit');
    Route::get('city/select/{state_name}', [CityController::class, 'selectWeb']);
});
Route::group(["middleware" => "auth", "prefix" => "subscription"], function () {
    Route::view('/add', 'subscription.add')->name('subs-add-form');
    Route::get('/manage', [SubscriptionController::class, 'select'])->name('subs-select-view');
    Route::post('/status/change', [SubscriptionController::class, 'softdelete'])->name('subs-stat-change');
    Route::post('/add', [SubscriptionController::class, 'add'])->name('subs-add');
    Route::get('edit/{id}', [SubscriptionController::class, 'edit'])->name('subsEdit');
    Route::post('update', [SubscriptionController::class, 'update'])->name('subsUpdate');
});
Route::group(["middleware" => "auth", "prefix" => "user/subscription"], function () {
    Route::post('/insert', [UsersubscriptionController::class, 'add'])->name('user-subs-add');
    Route::get('/manage', [UsersubscriptionController::class, 'select'])->name('user-subs-view');
    Route::post('/detail', [UsersubscriptionController::class, 'detail'])->name('user-subs-detail-view');
    Route::post('/stat', [UsersubscriptionController::class, 'softdelete'])->name('user-subs-stat-view');
    Route::post('/fetch/detail', [UsersubscriptionController::class, 'fetchdetail'])->name('user-subs-fetch-detail-view');
    Route::get('/add/{id}', [UsersubscriptionController::class, 'addform'])->name('user-subs-add-view');
    Route::get('/approval', [UsersubscriptionController::class, 'manageBankApproval'])->name('user-subs-approval-view');
    Route::post('/approval/details', [UsersubscriptionController::class, 'manageBankApprovalDetail'])->name('user-subs-approval-det-view');
    Route::post('/approve', [UsersubscriptionController::class, 'approve'])->name('user-subs-approve');
    Route::post('/approval/image', [UsersubscriptionController::class, 'approvalImage'])->name('user-subs-approval-image-view');
});
Route::group(["middleware" => "auth", "prefix" => "payment/methods"], function () {
    Route::get('/manage', [PaymentMethodsController::class, 'manage'])->name('pay-met-view');
    Route::post('/detail', [PaymentMethodsController::class, 'authCheck'])->name('pay-met-auth');
    Route::get('bank/details', [BankDetailController::class, 'select'])->name('Bankdetails.select');
    Route::post('bank/update', [BankDetailController::class, 'update'])->name('Bankdetails.update');
    Route::post('/update', [PaymentMethodsController::class, 'update'])->name('pay-met-update');
    Route::post('/soft/del', [PaymentMethodsController::class, 'softdel'])->name('pay-met-soft-del');
});
Route::group(["middleware" => "auth", "prefix" => "currency"], function () {
    Route::get('/add', [CurrencyController::class, 'index'])->name('currencyIndex');
    Route::post('insert', [CurrencyController::class, 'insert'])->name('currencyInsert');
    Route::get('/manage', [CurrencyController::class, 'manage'])->name('currencyManage');
    Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('currencyEdit');
    Route::post('update', [CurrencyController::class, 'update'])->name('currencyUpdate');
    Route::get('/stat/update/{id}', [CurrencyController::class, 'statUpdate'])->name('currencystatUpdate');
});
Route::group(['middleware' => 'auth', 'prefix' => 'ads'], function () {
    Route::get('/add', [AddsController::class, 'index'])->name('adds.index');
    Route::post('/store', [AddsController::class, 'store'])->name('adds.store');
    Route::get('/manage', [AddsController::class, 'select'])->name('add.manage');
    Route::get('/{id}', [AddsController::class, 'selectspecific'])->name('adds.selectspecific');
    Route::get('/edit/images/{id}', [AddsController::class, 'editImages'])->name('adds.editimages');
    Route::post('update/images', [AddsController::class, 'updateimage'])->name('adds.updateimages');
    Route::get('edit/info/{id}', [AddsController::class, 'editinfo'])->name('adds.editinfo');
    Route::post('update/info', [AddsController::class, 'updateinfo'])->name('adds.updateinfo');
    Route::get('edit/address/{id}', [AddsController::class, 'editaddress'])->name('adds.editaddress');
    Route::post('update/address', [AddsController::class, 'updateaddress'])->name('adds.updateaddress');
    Route::get('edit/owner/{id}', [AddsController::class, 'editowner'])->name('adds.editowner');
    Route::post('update/owner', [AddsController::class, 'updateowner'])->name('adds.updateowner');
    Route::post('/delete/{id}', [AddsController::class, 'delete'])->name('add.delete');
    Route::get('/approval/{id}', [AddsController::class, 'approval'])->name('add.approval');
});
Route::group(["middleware" => "auth", "prefix" => "social"], function () {
    Route::get('/manage', [SocialLinksController::class, 'select'])->name('SocialManage');
    Route::post('/update', [SocialLinksController::class, 'update'])->name('SocialManage.update');
});
Route::get('/tenants', [TendentController::class, 'ten_to_pro'])
    ->middleware('auth')
    ->name('tenants-view');
