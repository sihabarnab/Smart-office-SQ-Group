<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Purchase
use App\Http\Controllers\PurchaseController;


Route::group(['middleware' => ['auth','auth2']], function () {



//---------Purchase--------------------
Route::get('/purchase', [App\Http\Controllers\ModuleController::class, 'purchase'])->name('purchase');

//project Name
Route::get('/purchase/project_name', [PurchaseController::class, 'ProjectName'])->name('project_name');
Route::post('/purchase/project_name_store', [PurchaseController::class, 'project_name_store'])->name('project_name_store');
Route::get('/purchase/project_name_edit/{id}', [PurchaseController::class, 'project_name_edit'])->name('project_name_edit');
Route::post('/purchase/project_name_update/{id}', [PurchaseController::class, 'project_name_update'])->name('project_name_update');

//Indent Category
Route::get('/purchase/indent_category', [PurchaseController::class, 'IndentCategory'])->name('indent_category');
Route::post('/purchase/indent_category_store', [PurchaseController::class, 'indent_category_store'])->name('indent_category_store');
Route::get('/purchase/indent_category_edit/{id}', [PurchaseController::class, 'indent_category_edit'])->name('indent_category_edit');
Route::post('/purchase/indent_category_update/{id}', [PurchaseController::class, 'indent_category_update'])->name('indent_category_update');

//indent
Route::get('/purchase/indent_info', [PurchaseController::class, 'PurchaseIndent'])->name('indent_info');
Route::post('/purchase/indent_store', [PurchaseController::class, 'purchase_indent_store'])->name('purchase_indent_store');
Route::get('/purchase/indent_edit/{id}/{id2}', [PurchaseController::class, 'purchase_indent_edit'])->name('purchase_indent_edit');
Route::get('/purchase/indent_update/{id}/{id2}', [PurchaseController::class, 'purchase_indent_update'])->name('purchase_indent_update');
Route::post('/purchase/indent_update2/{id}/{id2}', [PurchaseController::class, 'purchase_indent_update2'])->name('purchase_indent_update2');
Route::post('/purchase/indent_add_another', [PurchaseController::class, 'purchase_indent_add_another'])->name('purchase_indent_add_another');
Route::get('/purchase/indent_final/{id}/{id2}', [PurchaseController::class, 'purchase_indent_final'])->name('purchase_indent_final');
//apprroval
Route::get('/purchase/indent_list_for_approval', [PurchaseController::class, 'purchase_indent_list_for_approval'])->name('indent_list_for_approval');
Route::post('/purchase/company_wise_indent_approval', [PurchaseController::class, 'company_wise_indent_approval'])->name('company_wise_indent_approval');
Route::get('/purchase/indent_approval/{id}/{id2}', [PurchaseController::class, 'purchase_indent_approval'])->name('purchase_indent_approval');
Route::post('/purchase/indent_approval_ok/{id}/{id2}', [PurchaseController::class, 'purchase_indent_approval_ok'])->name('purchase_indent_approval_ok');
//report
Route::get('/purchase/indent_list_report', [PurchaseController::class, 'purchase_indent_list_report'])->name('indent_list_report');
Route::get('/purchase/indent_view_print/{id}/{id2}', [PurchaseController::class, 'purchase_indent_view_print'])->name('purchase_indent_view_print');

Route::post('/purchase/company_wise_indent_report', [PurchaseController::class, 'company_wise_indent_report'])->name('company_wise_indent_report');

Route::get('/purchase/company_wise_indent_report2/{company}/{date1}/{date2}', [PurchaseController::class, 'company_wise_indent_report2'])->name('company_wise_indent_report2');

Route::get('/purchase/indent_view/{id}/{id2}', [PurchaseController::class, 'purchase_indent_view'])->name('purchase_indent_view');
Route::get('/purchase/rpt_indent_excel/{id}/{id2}', [PurchaseController::class, 'RPTIndentExcel'])->name('rpt_indent_excel');


// rr closing stock price
Route::get('/purchase/closing_stock_price', [PurchaseController::class, 'closing_stock_price'])->name('closing_stock_price');
Route::post('/purchase/closing_stock_price_details', [PurchaseController::class, 'closing_stock_price_details'])->name('closing_stock_price_details');
Route::get('/purchase/closing_stock_price_details/edit/{project_id}/{pg_id}/{pg_sub_id}/{id2}', [PurchaseController::class, 'closing_stock_price_details_edit'])->name('closing_stock_price_details_edit');
Route::post('/purchase/closing_stock_price_details/update/{id}/{id2}', [PurchaseController::class, 'closing_stock_price_details_update'])->name('closing_stock_price_details_update');

//material rr price 
Route::get('/purchase/rr_price_list', [PurchaseController::class, 'purchase_rr_price_list'])->name('rr_price_list');
Route::post('/purchase/company_wise_rr_price', [PurchaseController::class, 'company_wise_rr_price'])->name('company_wise_rr_price');
Route::get('/purchase/material_price/{id}/{id2}', [PurchaseController::class, 'purchase_material_price'])->name('material_price');
Route::post('/purchase/material_price/update/{id}/{id2}', [PurchaseController::class, 'purchase_material_price_update'])->name('material_price_update');

//rpt material rr price  
Route::get('/purchase/rpt_rr_price_list', [PurchaseController::class, 'rpt_rr_price_list'])->name('rpt_rr_price_list');
Route::post('/purchase/company_wise_rr_price_list', [PurchaseController::class, 'company_wise_rr_price_list'])->name('company_wise_rr_price_list');
Route::get('/purchase/rpt_rr_price_list_view/{id}/{id2}', [PurchaseController::class, 'rpt_rr_price_list_view'])->name('rpt_rr_price_list_view');
Route::get('/purchase/rpt_rr_price_list_print/{id}/{id2}', [PurchaseController::class, 'rpt_rr_price_list_print'])->name('rpt_rr_price_list_print');


//indent copy 
Route::get('/purchase/indent_copy', [PurchaseController::class, 'indent_copy'])->name('indent_copy');
Route::post('/purchase/indent_copy_search', [PurchaseController::class, 'indent_copy_search'])->name('indent_copy_search');
Route::get('/purchase/indent_copy_details/{id}/{id2}', [PurchaseController::class, 'indent_copy_details'])->name('indent_copy_details');
Route::get('/purchase/indent_copy_master/{id}/{id2}', [PurchaseController::class, 'indent_copy_master'])->name('indent_copy_master');
Route::post('/purchase/indent_copy_master_store', [PurchaseController::class, 'indent_copy_master_store'])->name('indent_copy_master_store');
Route::get('/purchase/indent_copy_product_details/{id}/{id2}/{id3}', [PurchaseController::class, 'indent_copy_product_details'])->name('indent_copy_product_details');
Route::post('/purchase/indent_copy_product_details_add', [PurchaseController::class, 'indent_copy_product_details_add'])->name('indent_copy_product_details_add');



//------------------End Purchase------------------


// ajax call
Route::get('/get/purchase/product_group/{id2}', [PurchaseController::class, 'GetIndentProductGroup']);
Route::get('/get/purchase/product/{id}/{id2}', [PurchaseController::class, 'GetProduct']);
Route::get('/get/purchase/product_sub_group/{id}/{id2}', [PurchaseController::class, 'GetPurchaseProductSubGroup']);
Route::get('/get/purchase/unit/{id}/{id2}', [PurchaseController::class, 'GetPurchaseUnit']);

Route::get('/get/purchase/indent_product_sub_group/{id}/{indent_no}/{id2}', [PurchaseController::class, 'GetPurchaseIndentProductSubGroup']);
Route::get('/get/purchase/indent_product/{id}/{indent_no}/{id2}', [PurchaseController::class, 'GetPurchaseIndentProduct']);


//Close stock 
Route::get('/get/purchase/closing_stock_product_sub_group/{id}/{id2}', [PurchaseController::class, 'GetClosingStockProductSubGroup']);
//RPT All purchase
Route::get('/get/purchase/indent_list_report', [PurchaseController::class, 'GetPurchaseIndentListReport']);

});