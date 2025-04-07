<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Inventory
use App\Http\Controllers\InventoryController;

Route::group(['middleware' => ['auth','auth2']], function () {


//---------------Inventory------------------------------------
Route::get('/inventory', [App\Http\Controllers\ModuleController::class, 'inventory'])->name('inventory');

//Product Group
Route::get('/inventory/product_group', [App\Http\Controllers\InventoryController::class, 'inventoryproductgroup'])->name('product_group');
Route::post('/inventory/product_group', [App\Http\Controllers\InventoryController::class, 'inventorypgstore'])->name('inventorypgstore');
Route::get('/inventory/product_group/edit/{id}/{id2}', [App\Http\Controllers\InventoryController::class, 'inventorypgedit'])->name('inventorypgedit');
Route::post('/inventory/product_group/{update}', [App\Http\Controllers\InventoryController::class, 'inventorypgupdate'])->name('inventorypgupdate');
Route::get('get_all_product_group_list/{id}', [InventoryController::class, 'GetAllProductGroupList']);

//Product Sub Group
Route::get('/inventory/product_sub_group', [App\Http\Controllers\InventoryController::class, 'inventoryproductsubgroup'])->name('product_sub_group');
Route::post('/inventory/product_sub_group', [App\Http\Controllers\InventoryController::class, 'inventorypgsubstore'])->name('inventorypgsubstore');
Route::get('/inventory/product_sub_group/edit/{id}/{id2}', [App\Http\Controllers\InventoryController::class, 'inventorypgsubedit'])->name('inventorypgsubedit');
Route::post('/inventory/product_sub_group/{update}', [App\Http\Controllers\InventoryController::class, 'inventorypgsubupdate'])->name('inventorypgsubupdate');
Route::get('get_all_product_sub_group_list/{id}', [InventoryController::class, 'GetAllProductSubGroupList']);
Route::get('/get/product_group/company/{id}', [InventoryController::class, 'GetProductGroupCompanyWise']);


//Product
Route::get('/inventory/product', [App\Http\Controllers\InventoryController::class, 'inventoryproduct'])->name('product');
Route::post('/inventory/product', [App\Http\Controllers\InventoryController::class, 'inventoryproductstore'])->name('inventoryproductstore');
Route::get('/inventory/product/edit/{id}/{id2}', [App\Http\Controllers\InventoryController::class, 'inventoryproductedit'])->name('inventoryproductedit');
Route::post('/inventory/product/{update}', [App\Http\Controllers\InventoryController::class, 'inventoryproductupdate'])->name('inventoryproductupdate');
//end Inventory 
Route::get('get/product_info/{id2}', [InventoryController::class, 'GetProduct']);


//Unit
Route::get('/inventory/product_unit', [App\Http\Controllers\InventoryController::class, 'productunit'])->name('product_unit');
Route::post('/inventory/product_unit', [App\Http\Controllers\InventoryController::class, 'unitstore'])->name('unitstore');
Route::get('/inventory/product_unit/edit/{id}', [App\Http\Controllers\InventoryController::class, 'prounitedit'])->name('prounitedit');
Route::post('/inventory/product_unit/{update}', [App\Http\Controllers\InventoryController::class, 'prounitupdate'])->name('prounitupdate');

//supplier information
Route::get('/inventory/supplier_information', [App\Http\Controllers\InventoryController::class, 'supplierinfo'])->name('supplier_information');
Route::post('/inventory/supplier_info', [App\Http\Controllers\InventoryController::class, 'supplierinfostore'])->name('inventorysupplierinfostore');
Route::get('/inventory/supplier_info/edit/{id}/{company_id}', [App\Http\Controllers\InventoryController::class, 'supplierinfoedit'])->name('inventorysupplierinfoedit');
Route::post('/inventory/supplier_info/{update}', [App\Http\Controllers\InventoryController::class, 'supplierinfoupdate'])->name('inventorysupplierinfoupdate');

Route::get('get/supply_info/{company_id}', [InventoryController::class, 'GetSupplier']);


//Indent list RR
Route::get('/inventory/indent_list_for_rr', [InventoryController::class, 'InventoryIndentListRR'])->name('indent_list_for_rr');
Route::post('/inventory/company_wise_list_for_rr', [InventoryController::class, 'company_wise_list_for_rr'])->name('company_wise_list_for_rr');
Route::get('/inventory/indent_receiving_report/{id}/{id2}', [InventoryController::class, 'inventory_indent_receiving_report'])->name('inventory_indent_receiving_report');
Route::post('/inventory/indent_receiving_report_store/{id2}', [InventoryController::class, 'inventory_indent_receiving_report_store'])->name('inventory_indent_receiving_report_store');
Route::get('/inventory/receiving_report_details/{id}/{id2}', [InventoryController::class, 'inventory_receiving_report_details'])->name('inventory_receiving_report_details');
Route::post('/inventory/indent_report_receiving/{id2}', [InventoryController::class, 'inventory_indent_report_receiving'])->name('inventory_indent_report_receiving');
Route::get('/inventory/receiving_report_final/{id}/{id2}', [InventoryController::class, 'inventory_receiving_report_final'])->name('inventory_receiving_report_final');

//edit
Route::get('/inventory_receiving_report_edit/{id}/{id2}', [InventoryController::class, 'inventory_receiving_report_edit'])->name('inventory_receiving_report_edit');
Route::post('/inventory_receiving_report_update/{id}/{id2}', [InventoryController::class, 'inventory_receiving_report_update'])->name('inventory_receiving_report_update');

//RPT
Route::get('/inventory/rpt_rr_list', [InventoryController::class, 'RPTRRList'])->name('rpt_rr_list');
Route::get('/inventory/rpt_rr_list_details/{grr_master_id}/{company_id}', [InventoryController::class, 'RPTRRListView'])->name('rpt_rr_list_details');
Route::get('/inventory/rpt_rr_list_print/{grr_master_id}/{company_id}', [InventoryController::class, 'RPTRRListPrint'])->name('rpt_rr_list_print');
Route::get('/inventory/rpt_rr_excel/{grr_no}/{company_id}', [InventoryController::class, 'RPTRRExcel'])->name('rpt_rr_excel');
//End Indent list RR

//Material Requsition
Route::get('inventory/material_requsition_info', [InventoryController::class, 'material_requsition_info'])->name('material_requsition_info');
Route::post('/inventory/material_req_store', [InventoryController::class, 'inventory_material_req_store'])->name('inventory_material_req_store');
Route::get('/inventory/material_req_details/{id}/{id2}', [InventoryController::class, 'inventory_material_req_details'])->name('inventory_material_req_details');
Route::post('/inventory/material_req_details_store/{id2}', [InventoryController::class, 'inventory_material_req_details_store'])->name('inventory_material_req_details_store');
Route::get('/inventory/material_req_details_final/{id}/{id2}', [InventoryController::class, 'inventory_material_req_details_final'])->name('inventory_material_req_details_final');
//edit
Route::get('/inventory/material_req_details_edit/{id}/{id2}', [InventoryController::class, 'inventory_material_req_details_edit'])->name('inventory_material_req_details_edit');
Route::post('/inventory/material_req_details_update/{id}/{id2}', [InventoryController::class, 'inventory_material_req_details_update'])->name('inventory_material_req_details_update');

//MR Approval 
Route::get('/inventory/material_requsition_approval_list', [InventoryController::class, 'material_requsition_approval_list'])->name('material_requsition_approval_list');
Route::post('/inventory/company_wise_material_requsition_approval_list', [InventoryController::class, 'company_wise_material_requsition_approval_list'])->name('company_wise_material_requsition_approval_list');
Route::get('/inventory/material_req_approval/{id}/{company_id}', [InventoryController::class, 'inventory_material_req_approval'])->name('inventory_material_req_approval');
Route::post('/inventory/material_req_approval_ok/{id}/{company_id}', [InventoryController::class, 'inventory_material_req_approval_ok'])->name('inventory_material_req_approval_ok');

//RPT
Route::get('/inventory/rpt_requsition_list', [InventoryController::class, 'RPTRequsitionList'])->name('rpt_requsition_list');
Route::get('/inventory/rpt_requsition_details/{mrm_no}/{company_id}', [InventoryController::class, 'RPTRequsitionView'])->name('rpt_requsition_details');
Route::get('/inventory/rpt_requsition_print/{mrm_no}/{company_id}', [InventoryController::class, 'RPTRequsitionPrint'])->name('rpt_requsition_print');
Route::get('/inventory/rpt_requsition_excel/{mrm_no}/{company_id}', [InventoryController::class, 'RPTRequsitionExcel'])->name('rpt_requsition_excel');

//End Material Requsition

//Material Issue
Route::get('inventory/requsition_list_for_issue', [InventoryController::class, 'InventoryRequsitionListForIssue'])->name('requsition_list_for_issue');
Route::post('inventory/company_wise_requsition_list_for_issue', [InventoryController::class, 'company_wise_requsition_list_for_issue'])->name('company_wise_requsition_list_for_issue');
Route::get('/inventory/req_material_issue/{id}/{company_id}', [InventoryController::class, 'inventory_req_material_issue'])->name('inventory_req_material_issue');
Route::post('/inventory/req_material_issue_store/{company_id}', [InventoryController::class, 'inventory_req_material_issue_store'])->name('inventory_req_material_issue_store');
Route::get('/inventory/req_material_issue_details/{id}/{company_id}', [InventoryController::class, 'inventory_req_material_issue_details'])->name('inventory_req_material_issue_details');
Route::post('/inventory/req_material_issue_details_store/{company_id}', [InventoryController::class, 'inventory_req_material_issue_details_store'])->name('inventory_req_material_issue_details_store');
Route::get('/inventory/req_material_issue_details_final/{id}/{company_id}', [InventoryController::class, 'inventory_req_material_issue_details_final'])->name('inventory_req_material_issue_details_final');
//  edit 
Route::get('/inventory/req_material_issue_edit/{rid_id}/{company_id}', [InventoryController::class, 'inventory_req_material_issue_edit'])->name('req_material_issue_edit');
Route::post('/inventory/req_material_issue_update/{rid_id}/{company_id}', [InventoryController::class, 'inventory_req_material_issue_details_update'])->name('req_material_issue_update');

//RPT
Route::get('/inventory/rpt_issue_list', [InventoryController::class, 'RPTRequsitionIssueList'])->name('rpt_issue_list');
Route::get('/inventory/rpt_requsition_issue_details/{rim_no}/{company_id}', [InventoryController::class, 'RPTRequsitionIssueView'])->name('rpt_requsition_issue_details');
Route::get('/inventory/rpt_requsition_issue_print/{rim_no}/{company_id}', [InventoryController::class, 'RPTRequsitionIssuePrint'])->name('rpt_requsition_issue_print');
Route::get('/inventory/rpt_issue_excel/{rim_no}/{company_id}', [InventoryController::class, 'RPTIssueExcel'])->name('rpt_issue_excel');

//Material Return
Route::get('inventory/material_return_info', [InventoryController::class, 'InventoryMaterialReturn'])->name('material_return_info');
Route::post('/inventory/material_return_store', [InventoryController::class, 'inventory_material_return_store'])->name('inventory_material_return_store');
Route::get('/inventory/material_return_details/{id}/{company_id}', [InventoryController::class, 'inventory_material_return_details'])->name('inventory_material_return_details');
Route::post('/inventory/material_return_details_store/{company_id}', [InventoryController::class, 'inventory_material_return_details_store'])->name('inventory_material_return_details_store');
Route::get('/inventory/material_return_final/{id}/{company_id}', [InventoryController::class, 'inventory_material_return_final'])->name('inventory_material_return_final');

//edit
Route::get('/inventory/material_return_edit/{mreturnd_id}/{company_id}', [InventoryController::class, 'inventory_material_return_edit'])->name('inventory_material_return_edit');
Route::post('/inventory/material_return_update/{mreturnd_id}/{company_id}', [InventoryController::class, 'inventory_material_return_update'])->name('material_return_update');
//End Material Return

//Month close
Route::get('/inventory/closing_stock', [InventoryController::class, 'ClosingStock'])->name('closing_stock');
Route::post('/inventory/closing_stock', [InventoryController::class, 'ClosingStockList'])->name('ClosingStockList');
// Route::post('/inventory/closing_stock', [InventoryController::class, 'ClosingStockUpdate'])->name('ClosingStockUpdate');

//Closing Stock List for Update
Route::get('/inventory/closing_stock_list', [InventoryController::class, 'ClosingStockQtyUpdate'])->name('closing_stock_list');
Route::get('/inventory/closing_stock_list_01', [InventoryController::class, 'ClosingStockQtyUpdate_01'])->name('ClosingStockQtyUpdate_01');
Route::post('/inventory/closing_stock_list_02/update', [InventoryController::class, 'ClosingStockQtyUpdate_02'])->name('ClosingStockQtyUpdate_02');


//RPT
Route::get('/inventory/rpt_return_list', [InventoryController::class, 'RPTMaterialReturnList'])->name('rpt_return_list');
Route::get('/inventory/rpt_return_details/{return_master_no}/{company_id}', [InventoryController::class, 'RPTMaterialReturnView'])->name('rpt_return_details');
Route::get('/inventory/rpt_return_print/{return_master_no}/{company_id}', [InventoryController::class, 'RPTMaterialReturnPrint'])->name('rpt_return_print');
Route::get('/inventory/rpt_return_excel/{return_master_no}/{company_id}', [InventoryController::class, 'RPTReturnExcel'])->name('rpt_return_excel');


//RPT all stock
Route::get('/inventory/rpt_all_stock', [InventoryController::class, 'RptAllStock'])->name('rpt_all_stock');
Route::post('/inventory/rpt_all_stock_list', [InventoryController::class, 'RptAllStockList'])->name('RptAllStockList');

Route::get('/inventory/rpt_damage_stock', [InventoryController::class, 'RptDamageStock'])->name('rpt_damage_stock');
Route::post('/inventory/rpt_damage_stock_list', [InventoryController::class, 'RptDamageStockList'])->name('RptDamageStockList');


Route::get('inventory/rpt_product_stock', [InventoryController::class, 'RptProductStock'])->name('rpt_product_stock');
Route::post('/inventory/rpt_product_stock_list', [InventoryController::class, 'RptProductStockList'])->name('RptProductStockList');

//RPT product RR
Route::get('/inventory/rpt_product_rr', [InventoryController::class, 'RptProductRR'])->name('rpt_product_rr');
Route::post('/inventory/rpt_product_rr_list', [InventoryController::class, 'RptProductRRList'])->name('RptProductRRList');

//
Route::get('/inventory/rpt_product_supply_rr', [InventoryController::class, 'RptProductSupplyRR'])->name('rpt_product_supply_rr');
Route::get('/inventory/company_wise_list_for_supply_rr', [InventoryController::class, 'RptProductSupplyRRList'])->name('company_wise_list_for_supply_rr');


//RPT product Issue
Route::get('/inventory/rpt_product_issue', [InventoryController::class, 'RptProductIssue'])->name('rpt_product_issue');
Route::post('/inventory/rpt_product_issue_list', [InventoryController::class, 'RptProductIssueList'])->name('RptProductIssueList');

//Finish Product Stock Mastern
Route::get('inventory/fpsm', [InventoryController::class, 'FinishProductStockMaster'])->name('fpsm');
Route::post('/inventory/fpsm_store', [InventoryController::class, 'FinishProductStockMasterStore'])->name('FinishProductStockMasterStore');
Route::get('/inventory/fpsd/{id}/{id2}', [InventoryController::class, 'FinishProductDetails'])->name('FinishProductDetails');
Route::post('/inventory/fpsd_store/{id2}', [InventoryController::class, 'FinishProductDetailsStore'])->name('FinishProductDetailsStore');

Route::get('/inventory/fpsd_edit/{id}/{id2}', [InventoryController::class, 'FinishProductDetailsEdit'])->name('FinishProductDetailsEdit');
Route::post('/inventory/fpsd_update{id}/{id2}', [InventoryController::class, 'FinishProductDetailsUpdate'])->name('FinishProductDetailsUpdate');
Route::get('/inventory/fpsd_final/{id}/{id2}', [InventoryController::class, 'FinishProductDetailsFinal'])->name('FinishProductDetailsFinal');

//--------------------End Inventory---------------------------------------


// ajax call
Route::get('/get/supply_address/{id}/{company_id}', [InventoryController::class, 'GetSupplyAddress']);
Route::get('/get/inventory/product_sub_group/{pg_id}/{indent_no}/{grr_no}/{id2}', [InventoryController::class, 'GetInvProductSubGroup']);
Route::get('/get/inventory/product/{pg_sub_id}/{indent_no}/{grr_no}/{id2}', [InventoryController::class, 'GetInvProduct']);
Route::get('/get/inventory/product_unit/{product_id}/{id2}', [InventoryController::class, 'GetProductUnit']);
Route::get('/get/inventory/indent_qty/{product_id}/{indent_no}/{id2}', [InventoryController::class, 'GetIndentQty']);

// Material Requsition 
Route::get('/get/matrial_requsition/product_sub_group/{id}/{id2}', [InventoryController::class, 'GetRequsitionProductSubGroup']);
Route::get('/get/matrial_requsition/product/{id}/{id2}', [InventoryController::class, 'GetRequsitionProduct']);
Route::get('/get/matrial_requsition/unit/product_list/{id}/{id2}', [InventoryController::class, 'GetProductList']);
Route::get('/get/matrial_requsition_product/{id}/{mrm_no}/{id2}', [InventoryController::class, 'GetMRMProduct']);

//inventory Issue
Route::get('/get/rim_issue/product_sub_group/{pg_id}/{mrm_no}/{rim_no}/{company_id}', [InventoryController::class, 'GetIssueSubGroup']);
Route::get('/get/rim_issue/product/{pg_sub_id}/{mrm_no}/{rim_no}/{company_id}', [InventoryController::class, 'GetIssueProductGroup']);
Route::get('/get/issue/qty/details/{product_id}/{mrm_no}/{company_id}', [InventoryController::class, 'GetIssueQtyDetails']);
Route::get('/get/issue/total/stock/{product_id}/{mrm_no}/{company_id}', [InventoryController::class, 'GetIssueTotalStock']);

//inventory return
Route::get('/get/return/product_sub_group/{pg_id}/{id2}', [InventoryController::class, 'GetReturnProductSubGroup']);
Route::get('/get/return/product/{pg_sub_id}/{id2}', [InventoryController::class, 'GetReturnProduct']);
Route::get('/get/return/product_details/{product_id}/{id2}', [InventoryController::class, 'GetReturnProductDetails']);
Route::get('/get/material_return/product/{pg_sub_id}/{return_master_no}/{company_id}', [InventoryController::class, 'GetMaterialReturnProduct']);

//RPT ALL Inventory
Route::get('get/rpt_rr_list/{company_id}/{form}/{to}', [InventoryController::class, 'GetRPTRRList']);
Route::get('get/rpt_requsition_list/{company_id}/{form}/{to}', [InventoryController::class, 'GetRPTRequsitionList']);
Route::get('get/rpt_requsition_issue_list/{company_id}/{form}/{to}', [InventoryController::class, 'GetRPTRequsitionIssueList']);
Route::get('get/rpt_return_list/{company_id}/{form}/{to}', [InventoryController::class, 'GetRPTMaterialReturnList']);


Route::get('get/pg/{id}/{id2}', [InventoryController::class, 'GetPgSub']);


//RPT Finish Product Stock
Route::get('/inventory/rpt_finish_product_stock', [InventoryController::class, 'rpt_finish_product_stock'])->name('rpt_finish_product_stock');
Route::post('/inventory/rpt_finish_product_stock_view', [InventoryController::class, 'rpt_finish_product_stock_view'])->name('rpt_finish_product_stock_view');
Route::get('/inventory/rpt_fps_details/{product_id}/{company_id}/{form}/{to}', [InventoryController::class, 'rpt_fps_details'])->name('rpt_fps_details');
Route::get('/get/inventory/fpsd_sub_group/{pg_id}/{id2}', [InventoryController::class, 'GetInvFinishProductSubGroup']);
Route::get('/get/inventory/fpsd_product/{pg_sub_id}/{id2}', [InventoryController::class, 'GetInvFinishProduct']);


});
