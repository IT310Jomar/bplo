<?php

use Illuminate\Http\Request;
use App\Models\RegulatoryOffice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RegulatoryController;
use App\Http\Controllers\RequestListController;
use App\Http\Controllers\GeneratedHistoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    // Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('user-profile', [AuthController::class, 'me']);
    Route::get('/officer/getdata', [RegulatoryController::class, 'getOfficer']);
    Route::get('/getdepartment', [RegulatoryController::class, 'getdepartment']);

    //pendingcategroy
    Route::get('/getcategory', [RequestListController::class, 'getcategory']);

    Route::post('/addofficer', [RegulatoryController::class, 'addofficer']);
    Route::get('/getclient', [ClientController::class, 'getclient']);
    Route::get('/viewofficer/{id}', [RegulatoryController::class, 'viewofficer']);
    Route::get('/viewclient/{id}', [ClientController::class, 'viewclient']);
    Route::post('/editofficer/{id}', [RegulatoryController::class, 'editofficer']);
    Route::put('/activeofficer/{id}', [RegulatoryController::class, 'activeofficer']);
    Route::put('/disableofficer/{id}', [RegulatoryController::class, 'disableofficer']);

    Route::get('/listData', [RequestListController::class, 'listData']);
    Route::put('/requirements/{id}', [RequestListController::class, 'requirements']);

    //GET PENDING REQUEST LIST
    Route::get('/getrequestlist', [RequestListController::class, 'getpendingrequestlist']);
    //pending search
    Route::get('/requestlist/search', [RequestListController::class, 'searchrequestPending']);


    //approve search
    Route::get('/requestapprove/search', [RequestListController::class, 'searchRequestApprove']);
    
  //reject search
  Route::get('/requestreject/search', [RequestListController::class, 'searchRequestReject']);

    //GET APPROVAL REQUEST LIST
    Route::get('/getapprovalrequestlist', [RequestListController::class, 'getapprovalrequestlist']);

    //GET REJECT REQUEST LIST
    Route::get('/getrejectrequestlist', [RequestListController::class, 'getrejectrequestlist']);


    Route::put('/approvepermit/{id}', [RequestListController::class, 'approvepermit']);
    Route::put('/rejectpermit/{id}', [RequestListController::class, 'rejectpermit']);

    Route::get('/getImage', [RegulatoryController::class, 'getImage']);

    Route::get('/viewrequirments/{id}', [RequestListController::class, 'viewrequirments']);

    //buco

    Route::get('/approverequestlist', [RequestListController::class, 'approverequestlist']);

    Route::put('/approvebuco/{id}', [RequestListController::class, 'approvebuco']);

    Route::get('/approveList', [RequestListController::class, 'approveList']);

    Route::get('/rejectList', [RequestListController::class, 'rejectList']);

    Route::put('/rejectbuco/{id}', [RequestListController::class, 'rejectbuco']);


    //buco_sms
    Route::post('/send_schedule/buco/{id}', [RequestListController::class, 'sendSms']);

    //bfp_sms
    Route::post('/bfp_sms/bfp/{id}', [RequestListController::class, 'bfpsms']);

    //health_sms

    Route::post('/bfp_sms/health/{id}', [RequestListController::class, 'healthsms']);


    //bfp

    Route::put('/approvebfp/{id}', [RequestListController::class, 'approvebfp']);

    Route::get('/approvebfplist', [RequestListController::class, 'approvebfplist']);

    Route::get('/approveRequestbfp', [RequestListController::class, 'approveRequestbfp']);

    Route::get('/rejectbfp', [RequestListController::class, 'rejectbfp']);

    Route::put('/rejectlistbfp/{id}', [RequestListController::class, 'rejectlistbfp']);




    //cleanro

    Route::get('/pendinglistcleanro', [RequestListController::class, 'pendinglistcleanro']);

    Route::put('/approvecleanro/{id}', [RequestListController::class, 'approvecleanro']);

    Route::get('/approveListcleanro', [RequestListController::class, 'approveListcleanro']);

    Route::get('/rejectcleanros', [RequestListController::class, 'rejectcleanros']);

    Route::put('/rejectcleanro/{id}', [RequestListController::class, 'rejectcleanro']);

   
    //health

    Route::get('/pendinglisthealth', [RequestListController::class, 'pendinglisthealth']);

    Route::put('/approvehealth/{id}', [RequestListController::class, 'approvehealth']);

    Route::get('/approveListhealth', [RequestListController::class, 'approveListhealth']);

    Route::get('/rejecthealths', [RequestListController::class, 'rejecthealths']);

    Route::put('/rejecthealth/{id}', [RequestListController::class, 'rejecthealth']);

    //generate permit
    Route::get('/generateapproveList', [RequestListController::class, 'generateapproveList']);

    //generate history

    Route::post('/generated_history/{id}', [GeneratedHistoryController::class, 'generated_history']);

    Route::get('/get_generated_history', [GeneratedHistoryController::class, 'get_generated_history']);


    Route::post('/send-email', [EmailController::class, 'sendEmail']);

});
