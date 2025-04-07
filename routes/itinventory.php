<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Inventory
use App\Http\Controllers\ITBackOfficeController;


Route::group(['middleware' => ['auth','auth2']], function () {


//IT INVENTORY
Route::get('/itinventory', [App\Http\Controllers\ModuleController::class, 'itinventory'])->name('itinventory');

//IT INVENTORY Backoffice
//Supplier
Route::get('/itinventory/supplier_info', [ITBackOfficeController::class, 'itsupp'])->name('supplier_info');
Route::post('/itinventory/supplier_info', [ITBackOfficeController::class, 'supplier_info_store'])->name('supplier_info_store');
Route::get('/itinventory/supplier_info/{id}', [ITBackOfficeController::class, 'supplier_infoedit'])->name('supplier_infoedit');
Route::post('/itinventory/supplier_info/{update}', [ITBackOfficeController::class, 'itsupplier_infoupdate'])->name('itsupplier_infoupdate');

//Product Type
Route::get('/itinventory/product_type', [ITBackOfficeController::class, 'itproduct_type'])->name('product_type');
Route::post('/itinventory/product_type', [ITBackOfficeController::class, 'itproduct_type_store'])->name('itproduct_type_store');
Route::get('/itinventory/product_type/{id}', [ITBackOfficeController::class, 'itproduct_typeedit'])->name('itproduct_typeedit');
Route::post('/itinventory/product_type/{update}', [ITBackOfficeController::class, 'itproduct_typeupdate'])->name('itproduct_typeupdate');

//Brand
Route::get('/itinventory/brand', [ITBackOfficeController::class, 'itbrand'])->name('brand');
Route::post('/itinventory/brand', [ITBackOfficeController::class, 'itbrand_store'])->name('itbrand_store');
Route::get('/itinventory/brand/{id}', [ITBackOfficeController::class, 'itbrandedit'])->name('itbrandedit');
Route::post('/itinventory/brand/{update}', [ITBackOfficeController::class, 'itbrandupdate'])->name('itbrandupdate');

//Processor
Route::get('/itinventory/processor', [ITBackOfficeController::class, 'itprocessor'])->name('processor');
Route::post('/itinventory/processor', [ITBackOfficeController::class, 'itprocessor_store'])->name('itprocessor_store');
Route::get('/itinventory/processor/{id}', [ITBackOfficeController::class, 'itprocessoredit'])->name('itprocessoredit');
Route::post('/itinventory/processor/{update}', [ITBackOfficeController::class, 'itprocessorupdate'])->name('itprocessorupdate');

//Asset
Route::get('/itinventory/it_asset', [ITBackOfficeController::class, 'itasset'])->name('it_asset');
Route::post('/itinventory/it_asset', [ITBackOfficeController::class, 'itasset_store'])->name('itasset_store');
Route::get('/itinventory/it_asset/edit/{id}', [ITBackOfficeController::class, 'it_assetedit'])->name('it_assetedit');
Route::post('/itinventory/it_asset/{update}', [ITBackOfficeController::class, 'it_assetupdate'])->name('it_assetupdate');

Route::get('/itinventory/it_asset_issue', [ITBackOfficeController::class, 'ItAssetIssue'])->name('it_asset_issue');
Route::post('/itinventory/it_asset_issue', [ITBackOfficeController::class, 'ItAssetIssueStore'])->name('ItAssetIssueStore');
Route::get('/itinventory/it_asset_issue/edit/{id}', [ITBackOfficeController::class, 'ItAssetIssueEdit'])->name('ItAssetIssueEdit');
Route::post('/itinventory/it_asset_issue/{update}', [ITBackOfficeController::class, 'ItAssetIssueUpdate'])->name('ItAssetIssueUpdate');


Route::get('/itinventory/it_asset_return', [ITBackOfficeController::class, 'ItAssetReturn'])->name('it_asset_return');
Route::post('/itinventory/it_asset_return', [ITBackOfficeController::class, 'ItAssetReturnStore'])->name('ItAssetReturnStore');

//IT Asset Received
Route::get('/itinventory/it_asset_received', [ITBackOfficeController::class, 'ItAssetReceived'])->name('it_asset_received');
Route::post('/itinventory/it_asset_received', [ITBackOfficeController::class, 'ItAssetReceivedStore'])->name('ItAssetReceivedStore');
Route::get('/itinventory/it_asset_received_details/{id}', [ITBackOfficeController::class, 'ItAssetReceivedDetails'])->name('ItAssetReceivedDetails');
Route::post('/itinventory/it_asset_received_details_store/{id}', [ITBackOfficeController::class, 'ItAssetReceivedDetailsStore'])->name('ItAssetReceivedDetailsStore');
Route::get('/itinventory/it_asset_received_details_edit/{id}', [ITBackOfficeController::class, 'ItAssetReceivedDetailsEdit'])->name('ItAssetReceivedDetailsEdit');
Route::post('/itinventory/it_asset_received_details_update/{id}', [ITBackOfficeController::class, 'ItAssetReceivedDetailsUpdate'])->name('ItAssetReceivedDetailsUpdate');
Route::get('/itinventory/it_asset_received_final/{id}', [ITBackOfficeController::class, 'ItAssetReceivedFinal'])->name('ItAssetReceivedFinal');
// RPT IT Asset Received
Route::get('/itinventory/rpt_it_asset_received', [ITBackOfficeController::class, 'RptItAssetReceived'])->name('rpt_it_asset_received');
Route::get('/get/rpt_it_asset_received_list/{company_id}/{form}/{to}', [ITBackOfficeController::class, 'RptItAssetReceivedList']);
Route::get('/itinventory/rpt_it_asset_received_view/{id}', [ITBackOfficeController::class, 'RptItAssetReceivedView'])->name('rpt_it_asset_received_view');
Route::get('/itinventory/rpt_it_asset_received_print/{id}', [ITBackOfficeController::class, 'RptItAssetReceivedPrint'])->name('rpt_it_asset_received_print');


Route::get('/itinventory/ip_mac_info', [ITBackOfficeController::class, 'IpMacInfo'])->name('ip_mac_info');
Route::post('/itinventory/ip_mac_info', [ITBackOfficeController::class, 'ItIpMacStore'])->name('ItIpMacStore');
Route::get('/itinventory/ip_mac_info/edit/{id}', [ITBackOfficeController::class, 'ItIpMacEdit'])->name('ItIpMacEdit');
Route::post('/itinventory/ip_mac_info/{update}', [ITBackOfficeController::class, 'ItIpMacUpdate'])->name('ItIpMacUpdate');


Route::get('get/ip_mac_list', [ITBackOfficeController::class, 'GetIPMacList']);

Route::get('/itinventory/rpt_it_asset', [ITBackOfficeController::class, 'RptItAsset'])->name('rpt_it_asset');
Route::post('/itinventory/rpt_it_asset_list', [ITBackOfficeController::class, 'RptItAssetList'])->name('RptItAssetList');

//end of IT Inventory

// ajax call
Route::get('get/employee2/{id}', [ITBackOfficeController::class, 'GetEmployee2']);
Route::get('get/employee3/{id}/{id2}', [ITBackOfficeController::class, 'GetEmployee3']);
Route::get('get/it_asset_info', [ITBackOfficeController::class, 'GetItAsset']);
Route::get('get/issue_asset/{id}', [ITBackOfficeController::class, 'GetIssueAsset']);
Route::get('get/it_asset_issue_list', [ITBackOfficeController::class, 'GetItAssetIssueList']);
Route::get('get/it_asset_return_list', [ITBackOfficeController::class, 'GetItAssetReturnList']);
Route::get('/get/it_asset_received/{id}', [ITBackOfficeController::class, 'GetAssetReceived']);
Route::get('/get/it_asset_emp_info/{id1}', [ITBackOfficeController::class, 'GetAssetEmpInfo']);



});
