<?php

use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\TendentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskAssignController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\UtilityPaidController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\PropertyRequestController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FeaturesToPropertyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RentPayController;
use App\Http\Controllers\UsersubscriptionController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\SocialLinksController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CityController;
use App\Models\notifications;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/noti', [NotificationsController::class, 'notification']);
// user Routes
Route::group(['middleware' => ['auth:sanctum', 'check.subs'], 'prefix' => 'user'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/update/', [UserController::class, 'update']);
    Route::post('/update/image', [UserController::class, 'updateimage']);
    Route::post('/update/password', [UserController::class, 'updatepassword']);
    Route::post('/apptoken', [UserController::class, 'storeAppToken']);
});
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'user'], function () {
    Route::get('/select', [UserController::class, 'select']);
    Route::post('/select/one', [UserController::class, 'selectspecific']);
    Route::get('/verifition/code', [UserController::class, 'sendVerificationCode']);
    Route::get('/match/{code}', [UserController::class, 'matchVerificationCode']);
});

// user/type Routes
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'user/type'], function () {
    Route::get('/list', [UserTypeController::class, 'select']);
});

//property Rourtes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], 'prefix' => 'property'], function () {
    Route::post('/insert', [PropertyController::class, 'insert']);
    Route::post('/update', [PropertyController::class, 'update']);
    Route::post('/delete', [PropertyController::class, 'delete']);
    Route::post('/update/image', [PropertyController::class, 'updateimage']);
    Route::post('/delete/image', [PropertyController::class, 'deleteimage']);
});
Route::group(["middleware" => 'auth:sanctum', 'prefix' => 'property'], function () {
    Route::post('/select', [PropertyController::class, 'select']);
    Route::post('/select/image', [PropertyController::class, 'selectimage']);
    Route::post('select/one', [PropertyController::class, 'selectspecific']);
});

// property request Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "property/request"], function () {
    Route::post('/add', [PropertyRequestController::class, 'add']);
    Route::post('/approve', [PropertyRequestController::class, 'approve']);
    Route::post('/delete', [PropertyRequestController::class, 'delete']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "property/request"], function () {
    Route::post('/tendent', [PropertyRequestController::class, 'select']);
});

// currency routes
Route::group(["middleware" => 'auth:sanctum', "prefix" => "currency"], function () {
    Route::get('/select', [CurrencyController::class, 'select']);
});

// tendent to property Routes
Route::group(['middleware' => ['auth:sanctum', 'check.subs'], "prefix" => "property/tendent"], function () {
    Route::post('/approved', [TendentController::class, 'tendent_only_approved']);
    Route::post('/delete', [TendentController::class, 'delete']);
});
Route::group(['middleware' => 'auth:sanctum', "prefix" => "property/tendent"], function () {
    Route::post('/select', [TendentController::class, 'select']);
    Route::post('/select/one', [TendentController::class, 'selectspecific']);
    Route::post('/tendentonproperty', [TendentController::class, 'tendent_on_property']);
    Route::post('/detail', [TendentController::class, 'selectone']);
    Route::post('/old', [TendentController::class, 'tendent_lived_in_property']);
    Route::get('/{id}', [TendentController::class, 'tendentSelectOne']);
});


//  socialLinks Routes
Route::group(['middleware' => "auth:sanctum", "prefix" => "social"], function () {
    Route::get('/select', [SocialLinksController::class, 'select']);
});
// features Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "features"], function () {
    Route::post('/insert', [FeatureController::class, 'insert']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "features"], function () {
    Route::get('/select', [FeatureController::class, 'select']);
});

// notifications Routes
Route::group(["middleware" => 'auth:sanctum', "prefix" => "notifications"], function () {
    Route::post('/update', [NotificationsController::class, 'update']);
    Route::get('/select', [NotificationsController::class, 'select']);
});

// property/features Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "property/features"], function () {
    Route::post('/insert', [FeaturesToPropertyController::class, 'insert']);
    Route::post('/delete', [FeaturesToPropertyController::class, 'delete']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "property/features"], function () {
    Route::post('/select', [FeaturesToPropertyController::class, 'select']);
});

// task Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "task"], function () {
    Route::post('/add', [TaskController::class, 'add']);
    Route::post('/update', [TaskController::class, 'update']);
    Route::post('/delete', [TaskController::class, 'delete']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "task"], function () {
    Route::post('/select', [TaskController::class, 'select']);
});

// task_assign Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "task/assign"], function () {
    Route::post('/add', [TaskAssignController::class, 'add']);
    Route::post('/update', [TaskAssignController::class, 'update']);
    Route::post('/delete', [TaskAssignController::class, 'delete']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "task/assign"], function () {
    Route::post('/select', [TaskAssignController::class, 'select']);
});
Route::get('task/assign/repetition', [TaskAssignController::class, 'repetition']);
// utility Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "utility"], function () {
    Route::post('/add', [UtilityController::class, 'add']);
    Route::post('/update', [UtilityController::class, 'update']);
    Route::post('/delete', [UtilityController::class, 'delete']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "utility"], function () {
    Route::get('/select/{property_id}', [UtilityController::class, 'select']);
});

// utility_paid Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "utilitypaid"], function () {
    Route::post('/add', [UtilityPaidController::class, 'add']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "utilitypaid"], function () {
    Route::post('/select', [UtilityPaidController::class, 'select']);
    Route::post('/avg', [UtilityPaidController::class, 'utilityAll']);
});

// rent Routes
Route::group(["middleware" => 'auth:sanctum', "prefix" => "rent"], function () {
    Route::post('/select', [RentController::class, 'select']);
});

// rentpay Routes
Route::group(["middleware" => ['auth:sanctum', 'check.subs'], "prefix" => "rent/pay"], function () {
    Route::post('/add', [RentPayController::class, 'add']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "rent/pay"], function () {
    Route::post('/select', [RentPayController::class, 'select']);
    Route::post('/date', [RentPayController::class, 'duedate']);
    Route::post('/upcoming', [RentPayController::class, 'upcomingrent']);
    Route::post('/sum', [RentPayController::class, 'rentAll']);
    Route::post('/graph', [RentPayController::class, 'YearlyDataMothWise']);
});
Route::get('rent/pay/notify', [RentPayController::class, 'rentNotification']);

// state Routes
Route::group(["middleware" => 'auth:sanctum', "prefix" => "states"], function () {
    Route::get('/select', [StatesController::class, 'select']);
});

// city Routes
Route::group(["middleware" => 'auth:sanctum', "prefix" => "cities"], function () {
    Route::post('/select', [CityController::class, 'select']);
});

Route::group(["middleware" => 'auth:sanctum', "prefix" => "subscription"], function () {
    Route::get('/select', [SubscriptionController::class, 'select']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "user/subscription"], function () {
    Route::post('/add', [UsersubscriptionController::class, 'add']);
    Route::get('/select', [UsersubscriptionController::class, 'select']);
});
Route::get('user/subscription/update', [UsersubscriptionController::class, 'update']);
Route::group(["middleware" => 'auth:sanctum', "prefix" => "pay/method"], function () {
    Route::get('/select', [PaymentMethodsController::class, 'manage']);
});
Route::group(["middleware" => 'auth:sanctum', "prefix" => "bank"], function () {
    Route::get('/details', [BankDetailController::class, 'select']);
});

// messages Route
Route::group(["middleware" => 'auth:sanctum', "prefix" => "messages"], function () {
    Route::get('/select/{property_id}', [MessageController::class, 'getMessages']);
    Route::get('users/select/{property_id}', [MessageController::class, 'PropertyUsers']);
});
// signup Route
Route::post('/signup', [UserController::class, 'register']);
// usertype Route
Route::get('usertype/list', [UserTypeController::class, 'select']);
// login Route
Route::post('login', [UserController::class, 'login']);
// unauthorized Route
Route::get('/unauthorized', [UserController::class, 'unauthorized'])->name('unauthorized');
Route::post('user/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('policy', function () {
    $policy = "maihommanager is the management tool that helps the landlord/real estate agent or property owners/renters to manage the home, collect the rent, remind/enforce the occupants to take  part in their house hold duties/policies, provide an effective   platform that enhances friendly home, communications amongst   households and the landlord and home affairs etc. Apart from just   turning up to collect the rent, it is very hard to manage overall    aspact of house/property for rents by the land lord. So many     Landlords who has people in their house for rents face challenges trying to make sure their property is well managed and looked  after. Arguments between the tenants, late or untimely rent  payment, lack of communication between the landlord and tenants  etc. are some of those areas challenging for the landlord.   Especially for those shared house (Renting rooms) it is even   more bizarre. Hence maihommanager is the management tool that   helps the landlord/real estate agent or property owners/renters   to manage the home, collect the rent, remind/enforce the    occupants to take part in their house hold duties/policies,    provide an effective platform that enhances friendly home,     communications amongst households and the landlord and home     affairs etc. The system is a customised solution property     manager app- designed and developed based on research and     personal experience living in number of years in shared     accommodations. Living in a shared house/accomodation is     sometimes worse given the people with a different ways of     living and doing things. App is designed to work on those     areas and help the landlord manage its property well and     efficiently. The app takes over the landlords management tasks     and allows landlord to save time, effort, money and increase      its profitability.";
    return response()->json(["status" => true, "data" => [$policy]]);
});
// forgot password
Route::group(['prefix' => 'forgot/password'], function () {
    Route::post('/code', [UserController::class, 'forgotPasswordcode']);
    Route::get('/{code}', [UserController::class, 'forgotPasswordMatch']);
    Route::post('/change', [UserController::class, 'forgotPasswordChange']);
});
