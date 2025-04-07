<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Finance
use App\Http\Controllers\FinanceController;


Route::group(['middleware' => ['auth','auth2']], function () {

Route::get('/finance', [App\Http\Controllers\ModuleController::class, 'finance'])->name('finance');

//Bank
Route::get('/finance/bank', [FinanceController::class, 'finance_bank'])->name('bank');
Route::post('/finance/bank', [FinanceController::class, 'bank_store'])->name('bank_store');
Route::get('/finance/bank/edit/{id}', [FinanceController::class, 'bank_edit'])->name('bank_edit');
Route::post('/finance/bank-up', [FinanceController::class, 'bank_update'])->name('bank_update');

//Bank Branch
Route::get('/finance/bank_branch', [FinanceController::class, 'finance_bank_branch'])->name('bank_branch');
Route::post('/finance/bank_branch', [FinanceController::class, 'bank_branch_store'])->name('bank_branch_store');
Route::get('/finance/bank_branch/edit/{id}', [FinanceController::class, 'bank_branch_edit'])->name('bank_branch_edit');
Route::post('/finance/bank_branch-up', [FinanceController::class, 'bank_branch_update'])->name('bank_branch_update');

//Bank Details
Route::get('/finance/bank_details', [FinanceController::class, 'finance_bank_details'])->name('bank_details');
Route::post('/finance/bank_details', [FinanceController::class, 'bank_details_store'])->name('bank_details_store');
Route::get('/finance/bank_details/edit/{id}', [FinanceController::class, 'bank_details_edit'])->name('bank_details_edit');
Route::post('/finance/bank_details_up', [FinanceController::class, 'bank_details_update'])->name('bank_details_update');

//Bank Account
Route::get('/finance/bank_accounts', [FinanceController::class, 'finance_bank_accounts'])->name('bank_accounts');
Route::post('/finance/bank_accounts', [FinanceController::class, 'bank_accounts_store'])->name('bank_accounts_store');
Route::get('/finance/bank_accounts/edit/{id}', [FinanceController::class, 'bank_accounts_edit'])->name('bank_accounts_edit');
Route::post('/finance/bank_accounts_up', [FinanceController::class, 'bank_accounts_update'])->name('bank_accounts_update');

//Account Type
Route::get('/finance/bank_accounts_type', [FinanceController::class, 'BankAccType'])->name('bank_accounts_type');
Route::post('/finance/bank_accounts_type', [FinanceController::class, 'BankAccTypeStore'])->name('BankAccTypeStore');
Route::get('/finance/bank_accounts_type/edit/{id}', [FinanceController::class, 'BankAccTypeEdit'])->name('BankAccTypeEdit');
Route::post('/finance/bank_accounts_type-up', [FinanceController::class, 'BankAccTypeUpdate'])->name('BankAccTypeUpdate');

//Create Cheque
Route::get('/finance/create_cheque', [FinanceController::class, 'finance_create_cheque'])->name('create_cheque');
Route::post('/finance/create_cheque', [FinanceController::class, 'finance_cheque_store'])->name('finance_cheque_store');

//Cheque Issue
Route::get('/finance/cheque_issue', [FinanceController::class, 'finance_cheque_issue'])->name('cheque_issue');
Route::post('/finance/cheque_issue', [FinanceController::class, 'finance_cheque_issue_store'])->name('finance_cheque_issue_store');
Route::get('/finance/cheque_issue/edit/{id}', [FinanceController::class, 'cheque_issue_edit'])->name('cheque_issue_edit');
Route::post('/finance/cheque_issue_up', [FinanceController::class, 'cheque_issue_update'])->name('cheque_issue_update');


//FDR Information
Route::get('/finance/fdr_info', [FinanceController::class, 'fdr_info'])->name('fdr_info');
Route::post('/finance/fdr_info_store', [FinanceController::class, 'fdr_info_store'])->name('fdr_info_store');
Route::get('/get/finance/fdr_employee_name/{id}', [FinanceController::class, 'fdr_employee_name']);

//edit FDR Information
Route::get('/finance/fdr_info_edit/{id}', [FinanceController::class, 'fdr_info_edit'])->name('fdr_info_edit');
Route::post('/finance/fdr_info_update/{id}', [FinanceController::class, 'fdr_info_update'])->name('fdr_info_update');

//closing and Renew 
Route::get('/finance/closing_renew_list', [FinanceController::class, 'closing_renew_list'])->name('closing_renew_list');
Route::get('/finance/fdr_closing/{id}', [FinanceController::class, 'fdr_closing'])->name('fdr_closing');
Route::post('/finance/fdr_closing_update/{id}', [FinanceController::class, 'fdr_closing_update'])->name('fdr_closing_update');
Route::get('/finance/fdr_renew/{id}', [FinanceController::class, 'fdr_renew'])->name('fdr_renew');
Route::post('/finance/fdr_renew_update/{id}', [FinanceController::class, 'fdr_renew_update'])->name('fdr_renew_update');

//BG/PG Information
Route::get('/finance/bg_pg_info', [FinanceController::class, 'bg_pg_info'])->name('bg_pg_info');
Route::post('/finance/bg_pg_info_store', [FinanceController::class, 'bg_pg_info_store'])->name('bg_pg_info_store');
Route::get('/finance/bg_pg_info_edit/{id}', [FinanceController::class, 'bg_pg_info_edit'])->name('bg_pg_info_edit');
Route::post('/finance/bg_pg_info_update/{id}', [FinanceController::class, 'bg_pg_info_update'])->name('bg_pg_info_update');

Route::get('/get/finance/bg_pg_reff_name/{id}', [FinanceController::class, 'bg_pg_reff_name']);



//Fund Requsition Indent
Route::get('/finance/fund_req', [FinanceController::class, 'fund_req'])->name('fund_req');
Route::post('/finance/fund_req_store', [FinanceController::class, 'FinanceFundReqStore'])->name('FinanceFundReqStore');
Route::get('/finance/fund_req_detail/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetail'])->name('fund_req_detail');
Route::post('/finance/fund_req_detail_store/{id2}', [FinanceController::class, 'FinanceFundReqDetailStore'])->name('FinanceFundReqDetailStore');
Route::get('/finance/fund_req_detail_edit/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetailEdit'])->name('FinanceFundReqDetailEdit');
Route::post('/finance/fund_req_detail_update/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetailUpdate'])->name('FinanceFundReqDetailUpdate');

//file Upload
Route::post('/finance/fund_req_file_update', [FinanceController::class, 'FundReqFileStore'])->name('FundReqFileStore');

//final Entry
Route::get('/finance/fund_req_detail_final/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetailFinal'])->name('FinanceFundReqDetailFinal');

//Query edit
Route::get('/finance/fund_req_detail_query/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetailQuery'])->name('FinanceFundReqDetailQuery');
Route::get('/finance/fund_req_detail_reedit/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetailReEdit'])->name('FinanceFundReqDetailReEdit');
Route::post('/finance/fund_req_detail_reupdate/{id}/{id2}', [FinanceController::class, 'FinanceFundReqDetailReUpdate'])->name('FinanceFundReqDetailReUpdate');
Route::post('/finance/fund_req_detail_refinal', [FinanceController::class, 'FinanceFundReqDetailReFinal'])->name('FinanceFundReqDetailReFinal');
//End Query edit

//Fund Requsition List for Check
Route::get('/finance/fund_req_check_list', [FinanceController::class, 'FundReqCheckList'])->name('fund_req_check_list');
Route::post('/finance/company_wise_fund_req_check_list', [FinanceController::class, 'CompanyFundReqCheckList'])->name('CompanyFundReqCheckList');
Route::get('/finance/fund_req_check_01/{id}/{company_id}', [FinanceController::class, 'FundReqCheck01'])->name('FundReqCheck01');


// ok, Cancel and query Final Approved
Route::post('/finance/fund_req_check_ok', [FinanceController::class, 'FundReqCheckok'])->name('FundReqCheckok');
Route::post('/finance/fund_req_check_query', [FinanceController::class, 'FundReqCheckQuery'])->name('FundReqCheckQuery');
Route::post('/finance/fund_req_check_total_cancel', [FinanceController::class, 'FundReqCheckTotalCancel'])->name('FundReqCheckTotalCancel');
//final check
Route::post('/finance/fund_req_check_final', [FinanceController::class, 'FundReqCheckFinal'])->name('FundReqCheckFinal');

//Report 
Route::get('/finance/rpt_fund_indent_list', [FinanceController::class, 'RptFundReqist'])->name('rpt_fund_indent_list');
Route::get('get/rpt_fund_indent_list/{company_id}/{form}/{to}', [FinanceController::class, 'GetRPTFundIndentList']);
Route::get('/finance/rpt_fund_indent_view/{fund_req_master_id}/{company_id}', [FinanceController::class, 'RPTFundIndentView'])->name('rpt_fund_indent_view');
Route::get('/finance/rpt_fund_indent_print/{fund_req_master_id}/{company_id}', [FinanceController::class, 'RPTFundIndentPrint'])->name('rpt_fund_indent_print');
Route::get('/finance/rpt_fund_indent_excel/{fund_req_master_id}/{company_id}', [FinanceController::class, 'RPTFundIndentExcel'])->name('rpt_fund_indent_excel');


//End Requsition Indent


//Start Bank cheque issue
Route::get('/finance/fund_indent_approved_list', [FinanceController::class, 'FundIndentReqist'])->name('fund_indent_approved_list');
Route::get('get/fund_indent_approved_list/{company_id}/{form}/{to}', [FinanceController::class, 'GetFundIndentApprovedList']);
Route::get('/finance/fund_req_bank/{id}/{id2}', [FinanceController::class, 'FinanceFundReqBank'])->name('FinanceFundReqBank');
Route::post('/finance/fund_req_bank_store/{id2}', [FinanceController::class, 'FinanceFundReqBankStore'])->name('FinanceFundReqBankStore');
//edit
Route::get('/finance/fund_req_bank_edit/{id}/{id2}', [FinanceController::class, 'FinanceFundReqBankEdit'])->name('FinanceFundReqBankEdit');
Route::post('/finance/fund_req_bank_update/{id}/{id2}', [FinanceController::class, 'FinanceFundReqBankUpdate'])->name('FinanceFundReqBankUpdate');
//file
Route::get('/finance/fund_req_chq_file/{id}/{id2}', [FinanceController::class, 'FundReqChqFile'])->name('FundReqChqFile');
Route::post('/finance/fund_req_chq_file_update/{id}', [FinanceController::class, 'FundReqChqFileStore'])->name('FundReqChqFileStore');

//Final
Route::get('/finance/fund_req_bank_final/{id}/{id2}', [FinanceController::class, 'FinanceFundReqBankFinal'])->name('FinanceFundReqBankFinal');


//End Bank cheque issue



Route::get('/finance/fund_req_file/{id}/{id2}', [FinanceController::class, 'FundReqFile'])->name('FundReqFile');


// Route::get('/get/finance/fdr_employee_name/{id}', [FinanceController::class, 'fdr_employee_name']);

//edit FDR Information

// finance report / alart list
//cheque
Route::get('/finance/rpt_cheque_issue', [FinanceController::class, 'RptChequeIssue'])->name('rpt_cheque_issue');
Route::post('/finance/rpt_cheque_issue_list', [FinanceController::class, 'RptChequeIssueList'])->name('RptChequeIssueList');


Route::get('/finance/rpt_fdr_bgpg', [FinanceController::class, 'rpt_fdr_bgpg'])->name('rpt_fdr_bgpg');
Route::post('/finance/rpt_fdr_bgpg_list', [FinanceController::class, 'rpt_fdr_bgpg_list'])->name('rpt_fdr_bgpg_list');



Route::post('/finance/bank_check_01_ok', [FinanceController::class, 'FundBankCheck01ok'])->name('FundBankCheck01ok');

//Fund Requsition List for Check Second
Route::get('/finance/fund_req_check_list_2', [FinanceController::class, 'FundReqCheckList2'])->name('fund_req_check_list_2');
Route::post('/finance/company_wise_fund_req_check_list2', [FinanceController::class, 'CompanyFundReqCheckList2'])->name('CompanyFundReqCheckList2');
Route::get('/finance/fund_req_check_02/{id}/{company_id}', [FinanceController::class, 'FundReqCheck02'])->name('FundReqCheck02');

Route::post('/finance/fund_req_check_02_ok', [FinanceController::class, 'FundReqCheck02ok'])->name('FundReqCheck02ok');
Route::post('/finance/bank_check_02_ok', [FinanceController::class, 'FundBankCheck02ok'])->name('FundBankCheck02ok');

//Fund Requsition List for Check final
Route::get('/finance/fund_req_approved_list', [FinanceController::class, 'FundReqApprovedList'])->name('fund_req_approved_list');
Route::post('/finance/company_wise_fund_req_approved_list', [FinanceController::class, 'CompanyFundReqApprovedList'])->name('CompanyFundReqApprovedList');
Route::get('/finance/fund_req_approved/{id}/{company_id}', [FinanceController::class, 'FundReqApproved'])->name('FundReqApproved');

Route::post('/finance/fund_req_approved_ok', [FinanceController::class, 'FundReqApprovedok'])->name('FundReqApprovedok');
Route::post('/finance/bank_approved_ok', [FinanceController::class, 'FundBankApprovedok'])->name('FundBankApprovedok');


//Fund Requsition List for report
Route::get('/finance/rpt_fund_req', [FinanceController::class, 'FundReqList'])->name('rpt_fund_req');





//End Fund Requsition List


// ajax call
Route::get('get/branch_add/{id}', [FinanceController::class, 'GetBranchAdd']);
Route::get('/get/account_no/{id}/{id2}', [FinanceController::class, 'GetAccNo']);
Route::get('/get/cheque_no/{id}', [FinanceController::class, 'GetChequeNo']);



//end of Finance

});