<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(["register" => false, "reset" => false]);

Route::get('/', "HomeController@index")->middleware("auth")->name("home");

/*Client*/
Route::resource("client", "ClientController")->except(["show", "destroy"]);
Route::group(['prefix' => "client", 'as' => 'client.', "middleware" => "auth"], function () {
    Route::get("destroy/{id}", "ClientController@destroy")->where(["id" => "[0-9]+"])->name("destroy");
    Route::get("monthly-services-form/{id}", "ClientController@monthlyServicesForm")
        ->where(["id" => "[0-9]+"])
        ->name("monthlyServicesForm");

    Route::post("monthly-services-add/{id}", "ClientController@monthlyServicesAdd")
        ->where(["id" => "[0-9]+"])
        ->name("monthlyServicesAdd");

    Route::get("monthly-services-delete/{id}/{services_item_id}", "ClientController@monthlyServicesDelete")
        ->where(["id" => "[0-9]+"])
        ->where(["services_item_id" => "[0-9]+"])
        ->name("monthlyServicesDelete");
});

/*Services*/
Route::group(['prefix' => "services", 'as' => 'services.', "middleware" => "auth"], function () {
    Route::get("import", "ServicesItemController@formImport")->name("formImport");
    Route::post("import", "ServicesItemController@import")->name("import");

    /*ServicesItem*/
    Route::resource("item", "ServicesItemController")->except(["show", "destroy"]);
    Route::group(['prefix' => "item", 'as' => 'item.', "middleware" => "auth"], function () {
        Route::get("destroy/{id}", "ServicesItemController@destroy")->where(["id" => "[0-9]+"])->name("destroy");
    });

    /**
     * ServiceGroup
     */
    Route::resource("group", "ServicesGroupController")->except(["show", "destroy"]);
    Route::group(['prefix' => "group", 'as' => 'group.', "middleware" => "auth"], function () {
        Route::get("destroy/{id}", "ServicesGroupController@destroy")->where(["id" => "[0-9]+"])->name("destroy");
    });

    Route::post("getServicesItem", "ServicesItemController@getServicesItem")->name("getServicesItem");
    Route::post("getServicesItemByClientId", "ServicesItemController@getServicesItemByClientId")->name("getServicesItemByClientId");
    Route::post("getServicesGroupByClientId", "ServicesGroupController@getServicesGroupByClientId")->name("getServicesGroupByClientId");
});

/*Job-log*/
Route::group(['prefix' => "job-log", 'as' => 'job_log.', "middleware" => "auth"], function () {
    Route::get("show", "JobLogController@showJobLog")->name("showJobLog")->middleware("job_log.dataTable.defaultFilter");
    Route::get("create", "JobLogController@formCreate")->name("formCreate");
    Route::post("create", "JobLogController@create")->name("create");
    Route::get("update/{id}", "JobLogController@formUpdate")->name("formUpdate");
    Route::post("update/{id}", "JobLogController@update")->name("update");
    Route::get("delete/{id}", "JobLogController@delete")->name("delete");
    Route::post("getJobByProject", "JobLogController@getJobByProject")->name("getJobByProject");

    Route::post("calcTotalAjax", "JobLogController@calcTotalAjax")->name("calcTotalAjax");
    Route::post("checkMonthlyJobByClientId", "JobLogController@checkMonthlyJobByClientId") -> name("checkMonthlyJobByClientId");
    Route::get("add-monthly-job-by-client-id/{client_id}", "JobLogController@addMonthlyJobByClientId")
        -> where(["client_id" => "[0-9]+"])
        -> name("addMonthlyJobByClientId");

    Route::group(["prefix" => "reporting", "as" => "reporting."], function () {
        Route::get("build", "JobLogReport\BuildReportController@build")->name("build");
        Route::get("export-report", "JobLogReport\BuildReportController@exportReport")->name("exportReport");

        /**
         * Звіти для бухгалтерії
         */
        Route::group(["prefix" => "accounting", "as" => "accounting."], function () {
            Route::get("/", "JobLogReport\AccountingReportsController@index")->name("index");
            Route::get("get-added-services/{client_id}/{month}", "JobLogReport\AccountingReportsController@getAddedServices")
                ->where(["client_id" => "[0-9]+"])
                ->name("getAddedServices");
            Route::post("download-report", "JobLogReport\AccountingReportsController@downloadReport")->name("downloadReport");
        });

    });
});

/*Translations*/
Route::resource("translations", "Translation\TranslationsController")->except(["show", "destroy"]);
Route::group(['prefix' => "translations", 'as' => 'translations.', "middleware" => "auth"], function () {
    Route::get("destroy/{id}", "Translation\TranslationsController@destroy")->where(["id" => "[0-9]+"])->name("destroy");
});

/*Project*/
Route::resource("project", "ProjectController")->except(["show", "destroy", "store"]);
Route::group(["prefix" => "project", "as" => "project.", "middleware" => "auth"], function () {
    Route::post("storeAjax", "ProjectController@storeAjax")->name("storeAjax");
    Route::get("close/{id}", "ProjectController@close")
        ->where(["id" => "[0-9]+"])
        ->name("close");
    Route::get("destroy/{id}", "ProjectController@destroy")
        ->where(["id" => "[0-9]+"])
        ->name("destroy");
    Route::get("details-info/{id}", "ProjectController@details_info")
        ->where(["id" => "[0-9]+"])
        ->name("details_info");
});

/**
 * Coefficient
 */
Route::resource("coefficient", "CoefficientController")->except(["show", "destroy"]);
Route::group(["prefix" => "coefficient", "as" => "coefficient.", "middleware" => "auth"], function () {
    Route::get("destroy/{id}", "CoefficientController@destroy")
        ->where(["id" => "[0-9]+"])
        ->name("destroy");
});


/**
 * Users
 */
Route::resource("users", "UsersController")->except(["show", "destroy"]);
Route::group(["prefix" => "users", "as" => "users.", "middleware" => "auth"], function () {
    Route::get("reset-password/{id}", "UsersController@resetPasswordForm")
        ->where(["id" => "[0-9]+"])
        ->name("resetPasswordForm");
    Route::post("reset-password/{id}", "UsersController@resetPassword")
        ->where(["id" => "[0-9]+"])
        ->name("resetPassword");
    Route::get("destroy/{id}", "UsersController@destroy")
        ->where(["id" => "[0-9]+"])
        ->name("destroy");
});

/**
 * Units
 */
Route::resource("units", "UnitsController")->except(["show", "destroy"]);
Route::group(["prefix" => "units", "as" => "units.", "middleware" => "auth"], function () {
    Route::get("destroy/{id}", "UnitsController@destroy")
        ->where(["id" => "[0-9]+"])
        ->name("destroy");
});
