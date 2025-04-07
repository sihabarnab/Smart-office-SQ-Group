<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Sales
use App\Http\Controllers\SalesController;


Route::group(['middleware' => ['auth', 'auth2']], function () {

    //----------------------Sales------------------------------------
    Route::get('/sales', [App\Http\Controllers\ModuleController::class, 'sales'])->name('sales');

    //Customer Info
    Route::get('/sales/customer_info', [SalesController::class, 'customer_info'])->name('customer_info');
    Route::post('/sales/customer_info', [SalesController::class, 'customer_info_store'])->name('customer_info_store');
    Route::get('/sales/customer_info/edit/{id}/{company_id}', [SalesController::class, 'customer_info_edit'])->name('customer_info_edit');
    Route::post('/sales/customer_info/{update}', [SalesController::class, 'customer_info_update'])->name('customer_info_update');
    //Ajax
    Route::get('/get/sales/customer_list/{company_id}', [SalesController::class, 'customer_list']);
    Route::get('/get/sales/customer/{id}/{company_id}', [SalesController::class, 'GetAllCustomerTypeWise']);

    // Rate Chart  start
    Route::get('/sales/rate_chart', [SalesController::class, 'rateChart'])->name('rate_chart');
    Route::get('/get_sales_finish_product_list/{company_id}', [SalesController::class, 'GetSalesFinishProductList'])->name('GetSalesFinishProductList');
    Route::post('/sales/rate_chart', [SalesController::class, 'rateChartStore'])->name('rate_chart_store');
    Route::get('/sales/rate_chart/edit/{id}/{company_id}', [SalesController::class, 'rateChartEdit'])->name('rate_chart_edit');
    Route::post('/sales/rate_chart/{update}', [SalesController::class, 'rateChartUpdate'])->name('rate_chart_update');
    Route::get('/get/sales/chart_list/{company_id}', [SalesController::class, 'rateChartList']);

    //rpt rate chart
    Route::get('/sales/rpt_rate_chart', [SalesController::class, 'rpt_rate_chart'])->name('rpt_rate_chart');
    Route::get('/sales/rpt_rate_chart_list', [SalesController::class, 'rpt_rate_chart_list'])->name('rpt_rate_chart_list');


    // Rate Chart end

    // Rate Policy  start
    Route::get('/sales/rate_policy', [SalesController::class, 'ratePolicy'])->name('rate_policy');
    Route::post('/sales/rate_policy', [SalesController::class, 'ratePolicyStore'])->name('rate_policy_store');
    Route::get('/sales/rate_policy/edit/{id}/{company_id}', [SalesController::class, 'ratePolicyEdit'])->name('rate_policy_edit');
    Route::post('/sales/rate_policy/{update}', [SalesController::class, 'ratePolicyUpdate'])->name('rate_policy_update');
    Route::get('/get/sales/policy_list/{company_id}', [SalesController::class, 'ratePolicyList']);
    // Rate Policy end

    //financial year
    Route::get('/sales/financial_year', [SalesController::class, 'financial_year'])->name('financial_year');
    Route::post('/sales/financial_store', [SalesController::class, 'financial_store'])->name('financial_store');

    //Mushok 
    Route::get('/sales/mushok', [SalesController::class, 'mushok'])->name('mushok');
    Route::post('/sales/mushok_store', [SalesController::class, 'mushok_store'])->name('mushok_store');

    //rpt Mushok 
    Route::get('/sales/rpt_mushok_list', [SalesController::class, 'rpt_mushok_list'])->name('rpt_mushok_list');
    //ajax
    Route::get('get/sales/get_mushok_list/{company_id}', [SalesController::class, 'get_mushok_list']);

   //End Mushok


    //Create Finish produck Serial
    Route::get('/sales/finish_product_serial', [SalesController::class, 'finish_product_serial'])->name('finish_product_serial');
    Route::post('/sales/finish_product_serial_store', [SalesController::class, 'finish_product_serial_store'])->name('finish_product_serial_store');

    //Quotation
    Route::get('/sales/quotation', [SalesController::class, 'quotation'])->name('quotation');
    Route::post('/sales/quotation_store', [SalesController::class, 'quotation_store'])->name('quotation_store');
    Route::get('/sales/quotation_details/{id}/{company_id}', [SalesController::class, 'quotation_details'])->name('quotation_details');
    Route::post('/sales/quotation_details_store/{id}/{company_id}', [SalesController::class, 'quotation_details_store'])->name('quotation_details_store');
    Route::get('/sales/quotation_details_more/{id}/{company_id}', [SalesController::class, 'quotation_details_more'])->name('quotation_details_more');
    Route::post('/sales/quotation_details_final/{id}/{company_id}', [SalesController::class, 'quotation_details_final'])->name('quotation_details_final');
    //edit details
    Route::get('/sales/quotation_details_edit/{id}/{company_id}', [SalesController::class, 'quotation_details_edit'])->name('quotation_details_edit');
    Route::post('/sales/quotation_details_update/{id}/{company_id}', [SalesController::class, 'quotation_details_update'])->name('quotation_details_update');

    //RPT Quotation List
    Route::get('/sales/rpt_quotation_list', [SalesController::class, 'quotation_list'])->name('rpt_quotation_list');
    Route::get('/sales/rpt_quotation_view/{id}/{company_id}', [SalesController::class, 'rpt_quotation_view'])->name('rpt_quotation_view');
    Route::get('/sales/rpt_quotation_print/{id}/{company_id}', [SalesController::class, 'rpt_quotation_print'])->name('rpt_quotation_print');

    //Ajax Quotation
    Route::get('get/sales/quotation/GetCustomerList', [SalesController::class, 'GetCustomerList'])->name('GetCustomerList');
    Route::get('get/sales/quotation/customer_details/{id}/{company_id}', [SalesController::class, 'GetCustomerDetails']);
    Route::get('/get/sales/quotation_list/{company_id}/{form}/{to}', [SalesController::class, 'GetSalesQuotationList'])->name('GetSalesQuotationList');

    // End Quotation

    //money_receipt
    Route::get('/sales/money_receipt', [SalesController::class, 'MoneyReceipt'])->name('money_receipt');
    Route::post('/sales/money_receipt_master', [SalesController::class, 'money_receipt_master'])->name('money_receipt_master');
    Route::get('/sales/money_receipt_details/{id}/{company_id}', [SalesController::class, 'money_receipt_details'])->name('money_receipt_details');
    Route::post('/sales/money_receipt_details_store/{id}/{company_id}', [SalesController::class, 'money_receipt_details_store'])->name('money_receipt_details_store');
    Route::get('/sales/money_receipt_final/{id}/{company_id}', [SalesController::class, 'money_receipt_final'])->name('money_receipt_final');

    // money receipt customer balance 
    Route::get('/get/sales/customer_previous_balance/{id}/{company_id}', [SalesController::class, 'GetCustomerPreviousBalance']);


    //Active / Deactive
    Route::get('/sales/money_receipt_list', [SalesController::class, 'money_receipt_list'])->name('money_receipt_list');
    Route::get('/get/sales/money_receipt_list/{company_id}/{form}/{to}', [SalesController::class, 'GetMoneyReceiptList']);
    Route::get('/sales/money_receipt_active/{id}/{company_id}', [SalesController::class, 'money_receipt_active'])->name('money_receipt_active');
    Route::get('/sales/money_receipt_valid/{id}/{company_id}', [SalesController::class, 'money_receipt_valid'])->name('money_receipt_valid');

    //RPT money_receipt
    Route::get('/sales/rpt_money_receipt_list', [SalesController::class, 'rpt_money_receipt_list'])->name('rpt_money_receipt_list');
    Route::get('/get/sales/rpt_mr_list/{company_id}/{form}/{to}/{pg_id}', [SalesController::class, 'GetMRList']);
    Route::get('/sales/rpt_money_receipt_view/{id}/{company_id}', [SalesController::class, 'rpt_money_receipt_view'])->name('rpt_money_receipt_view');
    Route::get('/sales/rpt_money_receipt_print/{id}/{company_id}', [SalesController::class, 'rpt_money_receipt_print'])->name('rpt_money_receipt_print');

    //Sales Invoice
    Route::get('/sales/sales_invoice', [SalesController::class, 'sales_invoice'])->name('sales_invoice');
    Route::post('/sales/sales_invoice_master_store', [SalesController::class, 'sales_invoice_master_store'])->name('sales_invoice_master_store');
    Route::get('/sales/sales_invoice_mr/{sim_no}/{company_id}', [SalesController::class, 'sales_invoice_mr'])->name('sales_invoice_mr');
    Route::post('/sales/sales_invoice_add_mr/{sim_no}/{company_id}', [SalesController::class, 'sales_invoice_add_mr'])->name('sales_invoice_add_mr');
    Route::get('/sales/sales_invoice_details/{sim_no}/{company_id}', [SalesController::class, 'sales_invoice_details'])->name('sales_invoice_details');
    Route::post('/sales/sales_invoice_details_store/{sim_no}/{company_id}', [SalesController::class, 'sales_invoice_details_store'])->name('sales_invoice_details_store');
    //update
    Route::get('/sales/sales_invoice_details_edit/{sid_id}/{company_id}', [SalesController::class, 'sales_invoice_details_edit'])->name('sales_invoice_details_edit');
    Route::post('/sales/sales_invoice_details_update/{sid_id}/{company_id}', [SalesController::class, 'sales_invoice_details_update'])->name('sales_invoice_details_update');
    //serial
    Route::get('/sales/sales_invoice_add_serial/{sid_id}/{company_id}', [SalesController::class, 'sales_invoice_add_serial'])->name('sales_invoice_add_serial');
    Route::post('/sales/sales_invoice_serial_store/{sid_id}/{company_id}', [SalesController::class, 'sales_invoice_serial_store'])->name('sales_invoice_serial_store');
    //final
    Route::get('/sales/sales_invoice_end/{sim_id}/{company_id}', [SalesController::class, 'sales_invoice_end'])->name('sales_invoice_end');
    Route::post('/sales/sales_invoice_final/{sim_id}/{company_id}', [SalesController::class, 'sales_invoice_final'])->name('sales_invoice_final');

    //rpt sales invoice
    Route::get('/sales/rpt_sales_invoice', [SalesController::class, 'rpt_sales_invoice'])->name('rpt_sales_invoice');
    Route::get('/sales/rpt_sales_invoice_view_regular/{id}/{company_id}', [SalesController::class, 'rpt_sales_invoice_view_regular'])->name('rpt_sales_invoice_view_regular');
    Route::get('/sales/rpt_sales_invoice_view/{id}/{company_id}', [SalesController::class, 'rpt_sales_invoice_view'])->name('rpt_sales_invoice_view');
    Route::get('/sales/rpt_sales_invoice_print/{id}/{company_id}', [SalesController::class, 'rpt_sales_invoice_print'])->name('rpt_sales_invoice_print');
    Route::get('/sales/rpt_sales_invoice_print_regular/{id}/{company_id}', [SalesController::class, 'rpt_sales_invoice_print_regular'])->name('rpt_sales_invoice_print_regular');

    //Ajax sales 
    Route::get('/get/sales/invoice_cust_details/{id}/{company_id}', [SalesController::class, 'GetInvoiceCustDetails']);
    Route::get('/get/sales/musak_no/{company_id}', [SalesController::class, 'GetInvoiceMusakno']);
    Route::get('/get/sales/sales_invoice_list/{company_id}/{form}/{to}/{pg_id}', [SalesController::class, 'GetRptSalesInvoiceList']);

    Route::get('/get/sales_customer_id/{id}/{company_id}', [SalesController::class, 'GetCustomerId']);

    //End Sales Invoice

    //Delivery Challan
    Route::get('/sales/delivery_challan', [SalesController::class, 'delivery_challan'])->name('delivery_challan');
    Route::get('/sales/create_delivery_challan/{id}/{company_id}', [SalesController::class, 'create_delivery_challan'])->name('create_delivery_challan');
    Route::post('/sales/create_delivery_challan_master/{id}/{company_id}', [SalesController::class, 'create_delivery_challan_master'])->name('create_delivery_challan_master');
    Route::get('/sales/delivery_challan_details/{id}/{company_id}', [SalesController::class, 'delivery_challan_details'])->name('delivery_challan_details');
    Route::post('/sales/delivery_challan_details_store/{id}/{company_id}', [SalesController::class, 'delivery_challan_details_store'])->name('delivery_challan_details_store');
    //update
    Route::get('/sales/delivery_challan_details_edit/{id}/{company_id}', [SalesController::class, 'delivery_challan_details_edit'])->name('delivery_challan_details_edit');
    Route::post('/sales/delivery_challan_details_update/{id}/{company_id}', [SalesController::class, 'delivery_challan_details_update'])->name('delivery_challan_details_update');

    //serial
    Route::get('/sales/delivery_challan_serial/{id}/{company_id}', [SalesController::class, 'delivery_challan_serial'])->name('delivery_challan_serial');
    Route::post('/sales/delivery_challan_serial_store/{id}/{company_id}', [SalesController::class, 'delivery_challan_serial_store'])->name('delivery_challan_serial_store');
    //final
    Route::get('/sales/delivery_challan_details_final/{id}/{company_id}', [SalesController::class, 'delivery_challan_details_final'])->name('delivery_challan_details_final');

    //rpt
    Route::get('/sales/rpt_delivery_challan', [SalesController::class, 'rpt_delivery_challan'])->name('rpt_delivery_challan');
    Route::get('/sales/rpt_delivery_challan_view/{id}/{company_id}', [SalesController::class, 'rpt_delivery_challan_view'])->name('rpt_delivery_challan_view');
    Route::get('/sales/rpt_delivery_challan_print/{id}/{company_id}', [SalesController::class, 'rpt_delivery_challan_print'])->name('rpt_delivery_challan_print');

    //Ajax delivery challan 
    Route::get('/get/delivery_challan/product_details/{product_id}/{id}/{company_id}', [SalesController::class, 'GetDeliveryProductDetails']);
    Route::get('/get/sales/dch_list/{company_id}', [SalesController::class, 'GetUnDeliveryChallanList']);
    Route::get('/get/sales/dch_not_final_list/{company_id}', [SalesController::class, 'GetDeliveryChallanNotFinalList']);
    Route::get('/get/sales/delivary_challan_list/{company_id}/{form}/{to}', [SalesController::class, 'GetRptDeliverychallanList']);

    //End Delivery Challan   

    //Gate Pass 
    Route::get('/sales/gate_pass', [SalesController::class, 'gate_pass'])->name('gate_pass');
    Route::get('/sales/gate_pass_info', [SalesController::class, 'gate_pass_info'])->name('gate_pass_info');
    Route::post('/sales/gate_pass_store/{id}/{company_id}', [SalesController::class, 'gate_pass_store'])->name('gate_pass_store');

    //rpt
    Route::get('/sales/rpt_gate_pass', [SalesController::class, 'rpt_gate_pass'])->name('rpt_gate_pass');
    Route::get('/sales/rpt_gate_pass_view/{id}/{company_id}', [SalesController::class, 'rpt_gate_pass_view'])->name('rpt_gate_pass_view');
    Route::get('/sales/rpt_gate_pass_print/{id}/{company_id}', [SalesController::class, 'rpt_gate_pass_print'])->name('rpt_gate_pass_print');

    //gate pass
    Route::get('/get/sales/gate_pass_list/{company_id}/{form}/{to}', [SalesController::class, 'GetRptGatePassList']);
    //End Gate Pass 

    //Requisition 
    Route::get('/sales/requisition', [SalesController::class, 'requisition'])->name('requisition');
    Route::post('/sales/requisition_master_store', [SalesController::class, 'requisition_master_store'])->name('requisition_master_store');
    Route::get('/sales/requisition_details/{id}/{company_id}', [SalesController::class, 'requisition_details'])->name('requisition_details');
    Route::post('/sales/requisition_details_store/{id}/{company_id}', [SalesController::class, 'requisition_details_store'])->name('requisition_details_store');
    Route::get('/sales/requisition_final/{id}/{company_id}', [SalesController::class, 'requisition_final'])->name('requisition_final');
    
    //Requisition Approval List
    Route::get('/sales/requisition_approval_list', [SalesController::class, 'requisition_approval_list'])->name('requisition_approval_list');
    Route::get('/sales/requisition_approved_details/{id}/{company_id}', [SalesController::class, 'requisition_approved_details'])->name('requisition_approved_details');
    Route::post('/sales/requisition_approved_confirm/{id}/{company_id}', [SalesController::class, 'requisition_approved_confirm'])->name('requisition_approved_confirm');

    //rpt requisition 
    Route::get('/sales/rpt_requisition', [SalesController::class, 'rpt_requisition'])->name('rpt_requisition');
    Route::get('/get/sales/requisition_list/{company_id}/{form}/{to}', [SalesController::class, 'GetRptRequisitionList']);
    Route::get('/sales/rpt_requisition_view/{id}/{company_id}', [SalesController::class, 'rpt_requisition_view'])->name('rpt_requisition_view');
    Route::get('/sales/rpt_requisition_print/{id}/{company_id}', [SalesController::class, 'rpt_requisition_print'])->name('rpt_requisition_print');

    //Ajax Sales Requisition 
    Route::get('/get/sales/client_balance/{id}/{company_id}', [SalesController::class, 'GetReqClintBalance']);
    Route::get('/get/sales/requisition_not_approval_list/{company_id}', [SalesController::class, 'GetReqNotFinalList']);


    //End Requisition

    //return sales invoice   
    Route::get('/sales/return_invoice', [SalesController::class, 'return_invoice'])->name('return_invoice');
    Route::get('/sales/return_invoice_details', [SalesController::class, 'return_invoice_details'])->name('return_invoice_details');
    Route::post('/sales/return_invoice_store/{id}/{company_id}', [SalesController::class, 'return_invoice_store'])->name('return_invoice_store');
    Route::get('/sales/return_sales_invoice_details/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_details'])->name('return_sales_invoice_details');
    Route::post('/sales/return_sales_invoice_details_store/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_details_store'])->name('return_sales_invoice_details_store');
    Route::get('/sales/return_sales_invoice_final/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_final'])->name('return_sales_invoice_final');
    //Edit
    Route::get('/sales/return_sales_invoice_edit/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_edit'])->name('return_sales_invoice_edit');
    Route::post('/sales/return_sales_invoice_update/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_update'])->name('return_sales_invoice_update');

    //serial
    Route::get('/sales/return_sales_invoice_serial/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_serial'])->name('return_sales_invoice_serial');
    Route::post('/sales/return_sales_invoice_serial_store/{id}/{company_id}', [SalesController::class, 'return_sales_invoice_serial_store'])->name('return_sales_invoice_serial_store');

    //rpt return invoice
    Route::get('/sales/rpt_return_sales_invoice', [SalesController::class, 'rpt_return_sales_invoice'])->name('rpt_return_sales_invoice');
    Route::get('/sales/rpt_return_sales_invoice_view/{id}/{company_id}', [SalesController::class, 'rpt_return_sales_invoice_view'])->name('rpt_return_sales_invoice_view');
    Route::get('/sales/rpt_return_sales_invoice_print/{id}/{company_id}', [SalesController::class, 'rpt_return_sales_invoice_print'])->name('rpt_return_sales_invoice_print');

    //Ajax Sales Return Invoice  
    Route::get('/get/sales/return_invoice_list/{company_id}', [SalesController::class, 'GetSalesReturnInvoiceList']);
    Route::get('/get/sales/return_sales_invoice_details/{product_id}/{rsim_id}/{company_id}', [SalesController::class, 'GetSalesReturnInvoiceDetails']);
    Route::get('/get/sales/return_sales_invoice_details_edit/{product_id}/{rsim_id}/{company_id}', [SalesController::class, 'GetSalesReturnInvoiceDetailsEdit']);
    Route::get('/get/sales/rpt_return_invoice_list/{company_id}/{form}/{to}/{pg_id}', [SalesController::class, 'GetRptSalesReturnInvoiceList']);

    //End return sales invoice 

    // Repair Invoice  start
    Route::get('/sales/repair_invoice', [SalesController::class, 'repair_invoice'])->name('repair_invoice');
    Route::post('/sales/repair_invoice_store', [SalesController::class, 'repair_invoice_store'])->name('repair_invoice_store');
    Route::get('/sales/repair_invoice_details/{id}/{company_id}', [SalesController::class, 'repair_Invoice_details'])->name('repair_Invoice_details');
    Route::post('/sales/repair_invoice_details_store', [SalesController::class, 'repair_invoice_details_store'])->name('repair_invoice_details_store');
    Route::get('/sales/repair_invoice_final/{id}/{company_id}', [SalesController::class, 'repair_invoice_final'])->name('repair_invoice_final');
    Route::get('/sales/repair_invoice_details_edit/{id}/{company_id}', [SalesController::class, 'repair_invoice_details_edit'])->name('repair_invoice_details_edit');
    Route::post('/sales/repair_invoice_details_update', [SalesController::class, 'repair_invoice_details_update'])->name('repair_invoice_details_update');

    //rpt Repair invoice
    Route::get('/sales/rpt_repair_invoice_list', [SalesController::class, 'rpt_repair_invoice_list'])->name('rpt_repair_invoice_list');
    Route::get('/sales/rpt_repair_invoice_view/{id}/{company_id}', [SalesController::class, 'rpt_repair_invoice_view'])->name('rpt_repair_invoice_view');
    Route::get('/sales/rpt_repair_invoice_print/{id}/{company_id}', [SalesController::class, 'rpt_repair_invoice_print'])->name('rpt_repair_invoice_print');


    //Ajax Repair
    Route::get('get_customer_address_for_repair_invoice/{id}/{company_id}', [SalesController::class, 'customerAddressForRepairInvoice']);
    Route::get('get_money_receipt_for_repair_invoice/{customer_id}/{company_id}', [SalesController::class, 'MoneyReceiptForRepairInvoice']);
    Route::get('get/sales/rpt_repair_invoice_list/{company_id}/{form}/{to}/{pg_id}', [SalesController::class, 'GetSalesRepairInvoiceList']);
    Route::get('/get/sales/repair_invoice_not_final/{company_id}', [SalesController::class, 'GetSalesRepairInvoiceNotFinal']);
    Route::get('/get_sales_repeair_product/{id}/{company_id}', [SalesController::class, 'GetSalesRepairProductList']);
    // Repair Invoice end

    //remaining serial number list
    Route::get('/sales/rpt_remaining_serial_list', [SalesController::class, 'rpt_remaining_serial_list'])->name('rpt_remaining_serial_list');
    Route::get('/sales/remaing_serial_list', [SalesController::class, 'remaing_serial_list'])->name('remaing_serial_list');

    //Debit Voucher
    Route::get('/sales/debit_voucher', [SalesController::class, 'debit_voucher'])->name('debit_voucher');
    Route::get('/sales/debit_voucher_store', [SalesController::class, 'debit_voucher_store'])->name('debit_voucher_store');

    //rpt debit voucer
    Route::get('/sales/rpt_debit_voucher_list', [SalesController::class, 'rpt_debit_voucher_list'])->name('rpt_debit_voucher_list');
    Route::get('/sales/rpt_debit_voucher_view/{id}/{company_id}', [SalesController::class, 'rpt_debit_voucher_view'])->name('rpt_debit_voucher_view');
    Route::get('/sales/rpt_debit_voucher_print/{id}/{company_id}', [SalesController::class, 'rpt_debit_voucher_print'])->name('rpt_debit_voucher_print');
    //ajax
    Route::get('get/sales/money_receipt_for_debit_voucher/{company_id}', [SalesController::class, 'money_receipt_for_debit_voucher']);
    Route::get('get/sales/debit_voucher_list/{company_id}', [SalesController::class, 'debit_voucher_list']);
    Route::get('get/sales/get_debit_voucher_list/{company_id}/{form}/{to}', [SalesController::class, 'get_debit_voucher_list']);

    //Debit Voucher for Test, Transport and Other
    Route::get('/sales/debit_voucher_for_tto', [SalesController::class, 'debit_voucher_for_tto'])->name('debit_voucher_for_tto');
    Route::post('/sales/debit_voucher_for_tto_store', [SalesController::class, 'debit_voucher_for_tto_store'])->name('debit_voucher_for_tto_store');

    //rpt debit oucer
    Route::get('/sales/rpt_debit_voucher_tto_list', [SalesController::class, 'rpt_debit_voucher_tto_list'])->name('rpt_debit_voucher_tto_list');
    Route::get('/sales/rpt_debit_voucher_tto_view/{id}/{company_id}', [SalesController::class, 'rpt_debit_voucher_tto_view'])->name('rpt_debit_voucher_tto_view');
    Route::get('/sales/rpt_debit_voucher_tto_print/{id}/{company_id}', [SalesController::class, 'rpt_debit_voucher_tto_print'])->name('rpt_debit_voucher_tto_print');
    
    //Ajax
    Route::get('get/sales/sales_invoice_for_debit_voucher_tto/{company_id}', [SalesController::class, 'sales_invoice_for_debit_voucher_tto']);
    Route::get('get/sales/customer_details_for_debit_voucher_tto/{company_id}/{id}', [SalesController::class, 'customer_details_for_debit_voucher_tto']);
    Route::get('get/sales/get_debit_voucher_tto_list/{company_id}/{form}/{to}', [SalesController::class, 'get_debit_voucher_tto_list']);
    
    
    // Daily Sales Report
    Route::get('/sales/rpt_daily_sales_list', [SalesController::class, 'rpt_daily_sales_list'])->name('rpt_daily_sales_list');
    Route::get('/sales/rpt_daliy_sales_report', [SalesController::class, 'rpt_daliy_sales_report'])->name('rpt_daliy_sales_report');
    // Ajax 
    Route::get('/get/sales/daliy_report_party_list/{type_id}/{company_id}', [SalesController::class, 'get_daliy_report_party_list']);
    Route::get('/get/sales/cbo_transformer_ctpt/{id}/{company_id}', [SalesController::class, 'get_daliy_report_transformer_ctpt']);
    
    
    //Sales ledger Report
    Route::get('/sales/rpt_sales_ledger', [SalesController::class, 'rpt_sales_ledger'])->name('rpt_sales_ledger');
    Route::get('/sales/rpt_sales_ledger_list', [SalesController::class, 'rpt_sales_ledger_list'])->name('rpt_sales_ledger_list');
    
    //rpt_total_collection
    Route::get('/sales/rpt_total_collection', [SalesController::class, 'rpt_total_collection'])->name('rpt_total_collection');
    Route::get('/sales/rpt_total_collection_list', [SalesController::class, 'rpt_total_collection_list'])->name('rpt_total_collection_list');

    //Finish Product 
    Route::get('/sales/finish_product', [SalesController::class, 'finish_product'])->name('finish_product');
    Route::post('/sales/finish_product_store', [SalesController::class, 'FinishProductStore'])->name('FinishProductStore');
    Route::get('/sales/finish_product_edit/{id}/{company_id}', [SalesController::class, 'finish_product_edit'])->name('finish_product_edit');
    Route::post('/sales/finish_product_update/{id}', [SalesController::class, 'finish_product_update'])->name('finish_product_update');


    Route::get('get_all_finish_product_list/{company_id}', [SalesController::class, 'GetAllFinishProductList']);
    Route::get('get_sales_finish_product_group_list/{company_id}', [SalesController::class, 'GetSalesFinishProductGroupList']);
    Route::get('get_sales/finish_product_sub_group/{pg_id}/{company_id}', [SalesController::class, 'GetSalesFinishProductSubGroupList']);


    //Finish Product closing Stock 
    Route::get('/sales/finish_product_closing_stock', [SalesController::class, 'finish_product_closing_stock'])->name('finish_product_closing_stock');
    Route::post('/sales/finish_product_closing_stock_store', [SalesController::class, 'finish_product_closing_stock_store'])->name('finish_product_closing_stock_store');

    
    //RPT Finish product stock details
    Route::get('/sales/rpt_finish_product_stock_details', [SalesController::class, 'rpt_finish_product_stock_details'])->name('rpt_finish_product_stock_details');
    Route::post('/sales/rpt_finish_product_stock_details_list', [SalesController::class, 'rpt_finish_product_stock_details_list'])->name('rpt_finish_product_stock_details_list');
    Route::get('/sales/rpt_finish_product_stock_more_details/{company}/{product}/{form}/{to}', [SalesController::class, 'rpt_finish_product_stock_more_details'])->name('rpt_finish_product_stock_more_details');


    //---------------------------------------Only Ajax

    



    //End---------------------------------------Only Ajax

 //account ledger
    Route::get('/sales/rpt_acc_ledger', [SalesController::class, 'rpt_acc_ledger'])->name('rpt_acc_ledger');
    Route::post('/sales/rpt_acc_ledger_list', [SalesController::class, 'rpt_acc_ledger_list'])->name('rpt_acc_ledger_list');


});
