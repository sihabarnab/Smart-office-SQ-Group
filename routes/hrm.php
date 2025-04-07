<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//HRM
use App\Http\Controllers\HrmBackOfficeController;


Route::group(['middleware' => ['auth','auth2']], function () {


Route::get('/hrm', [App\Http\Controllers\ModuleController::class, 'hrm'])->name('hrm');

//HRM Backoffice
//Company
Route::get('/hrm/company', [HrmBackOfficeController::class, 'hrmbackcompany'])->name('company');
Route::post('/hrm/company', [HrmBackOfficeController::class, 'hrmbackcompanystore'])->name('hrmbackcompanystore');
Route::get('/hrm/company/edit/{id}', [HrmBackOfficeController::class, 'hrmbackcompanyedit'])->name('hrmbackcompanyedit');
Route::post('/hrm/company-up', [HrmBackOfficeController::class, 'hrmbackcompanyupdate'])->name('hrmbackcompanyupdate');

//end Company

//Designation
Route::get('/hrm/designation', [HrmBackOfficeController::class, 'hrmbackdesignation'])->name('designation');
Route::post('/hrm/designation', [HrmBackOfficeController::class, 'hrmbackdesignationstore'])->name('hrmbackdesignationstore');
Route::get('/hrm/designation/edit/{id}', [HrmBackOfficeController::class, 'hrmbackdesignationedit'])->name('hrmbackdesignationedit');
Route::post('/hrm/designation-up', [HrmBackOfficeController::class, 'hrmbackdesignationupdate'])->name('hrmbackdesignationupdate');
//end Designation

//department
Route::get('/hrm/department', [HrmBackOfficeController::class, 'hrmbackdepartment'])->name('department');
Route::post('/hrm/department', [HrmBackOfficeController::class, 'hrmbackdepartmentstore'])->name('hrmbackdepartmentstore');
Route::get('/hrm/department/edit/{id}', [HrmBackOfficeController::class, 'hrmbackdepartmentedit'])->name('hrmbackdepartmentedit');
Route::post('/hrm/department-up', [HrmBackOfficeController::class, 'hrmbackdepartmentupdate'])->name('hrmbackdepartmentupdate');
//end department

//section
Route::get('/hrm/section', [HrmBackOfficeController::class, 'hrmbacksection'])->name('section');
Route::post('/hrm/section', [HrmBackOfficeController::class, 'hrmbacksectionstore'])->name('hrmbacksectionstore');
Route::get('/hrm/section/edit/{id}', [HrmBackOfficeController::class, 'hrmbacksectionedit'])->name('hrmbacksectionedit');
Route::post('/hrm/section-up', [HrmBackOfficeController::class, 'hrmbacksectionupdate'])->name('hrmbacksectionupdate');
//end Designation




//place of posting
Route::get('/hrm/placeposting', [HrmBackOfficeController::class, 'hrmbackplaceposting'])->name('placeposting');
Route::post('/hrm/placeposting', [HrmBackOfficeController::class, 'hrmbackplace_postingstore'])->name('hrmbackplace_postingstore');
Route::get('/hrm/placeposting/edit/{id}', [HrmBackOfficeController::class, 'hrmbackplace_postingedit'])->name('hrmbackplace_postingedit');
Route::post('/hrm/placeposting/{update}', [HrmBackOfficeController::class, 'hrmbackplace_postingupdate'])->name('hrmbackplace_postingupdate');

//end place of posting

//Bio Device
Route::get('/hrm/biodevice', [HrmBackOfficeController::class, 'hrmbackbio_device'])->name('biodevice');
Route::post('/hrm/biodevice', [HrmBackOfficeController::class, 'hrmbackbio_devicestore'])->name('hrmbackbio_devicestore');
Route::get('/hrm/biodevice/{id}', [HrmBackOfficeController::class, 'hrmbackbio_deviceedit'])->name('hrmbackbio_deviceedit');
Route::post('/hrm/biodevice/{update}', [HrmBackOfficeController::class, 'hrmbackbio_deviceupdate'])->name('hrmbackbio_deviceupdate');
//end Bio Device


//policy
Route::get('/hrm/policy', [HrmBackOfficeController::class, 'hrmbackpolicy'])->name('policy');
Route::post('/hrm/policy', [HrmBackOfficeController::class, 'hrmbackpolicystore'])->name('hrmbackpolicystore');
Route::get('/hrm/policy/{id}', [HrmBackOfficeController::class, 'hrmbackpolicyedit'])->name('hrmbackpolicyedit');
Route::post('/hrm/policy/{update}', [HrmBackOfficeController::class, 'hrmbackpolicyupdate'])->name('hrmbackpolicyupdate');
Route::get('/hrm/policy_sub', [HrmBackOfficeController::class, 'HrmPolicySub'])->name('policy_sub');
Route::get('/hrm/policy_sub/{id2}', [HrmBackOfficeController::class, 'HrmPolicySubEdit'])->name('HrmPolicySubEdit');
Route::post('/hrm/policy_sub_ok', [HrmBackOfficeController::class, 'HrmPolicySubOk'])->name('HrmPolicySubOk');



//end policy

//holiday
Route::get('/hrm/holiday', [HrmBackOfficeController::class, 'hrmbackholiday'])->name('holiday');
Route::post('/hrm/holiday', [HrmBackOfficeController::class, 'hrmbackholidaystore'])->name('hrmbackholidaystore');
Route::get('/hrm/holiday/{id}', [HrmBackOfficeController::class, 'hrmbackholidayedit'])->name('hrmbackholidayedit');
Route::post('/hrm/holiday/{update}', [HrmBackOfficeController::class, 'hrmbackholidayupdate'])->name('hrmbackholidayupdate');



//end holiday

//basic_info
Route::get('/hrm/basic_info', [HrmBackOfficeController::class, 'hrmbackbasic_info'])->name('basic_info');

Route::post('/hrm/basic_info', [HrmBackOfficeController::class, 'hrmbackbasic_infostore'])->name('hrmbackbasic_infostore');

Route::get('/hrm/basic_info/{id}', [HrmBackOfficeController::class, 'hrmbackbasic_infoedit'])->name('hrmbackbasic_infoedit');

Route::post('/hrm/basic_info/{update}', [HrmBackOfficeController::class, 'hrmbackbasic_infoupdate'])->name('hrmbackbasic_infoupdate');

Route::get('/hrm/basic_info/{company_id}', [HrmBackOfficeController::class, 'hrmbackbasic_company_id'])->name('hrmbackbasic_company_id');

//end basic_info

//Employee Reporting Boss List
Route::get('/hrm/reporting_boss/{id2}', [HrmBackOfficeController::class, 'HrmReportingBoss'])->name('reporting_boss');
Route::post('/hrm/reporting_boss', [HrmBackOfficeController::class, 'HrmReportingBossStore'])->name('HrmReportingBossStore');
Route::get('/hrm/reporting_boss/edit/{id}', [HrmBackOfficeController::class, 'HrmReportingBossEdit'])->name('HrmReportingBossEdit');
Route::post('/hrm/reporting_boss/{update}', [HrmBackOfficeController::class, 'HrmReportingBosUpdate'])->name('HrmReportingBosUpdate');


//basic_info for HR
Route::get('/hrm/basic_info_up', [HrmBackOfficeController::class, 'HrmBasicInfoUp'])->name('basic_info_up');
Route::get('/hrm/basic_info_up/{id}', [HrmBackOfficeController::class, 'HrmBasicInfoUpEdit'])->name('HrmBasicInfoUpEdit');
Route::post('/hrm/basic_info_up/{update}', [HrmBackOfficeController::class, 'HrmBasicInfoUpupdate'])->name('HrmBasicInfoUpupdate');


//bio_data
Route::get('/hrm/bio_data', [HrmBackOfficeController::class, 'hrmbackbio_data'])->name('bio_data');
Route::post('/hrm/bio_data', [HrmBackOfficeController::class, 'hrmbio_datastore'])->name('hrmbio_datastore');

Route::get('/biodata_file/{emp_id}', [HrmBackOfficeController::class, 'biodata_file'])->name('biodata_file');
Route::post('/biodata_file', [HrmBackOfficeController::class, 'biodata_file_store'])->name('biodata_file_store');

//Educational qualification
Route::get('/educational_qualification/{emp_id}', [HrmBackOfficeController::class, 'educational_qualification'])->name('educational_qualification');
Route::post('/educational_qualification', [HrmBackOfficeController::class, 'educational_qualification_store'])->name('educational_qualification_store');

//Professional Training
Route::get('/professional_training/{emp_id}', [HrmBackOfficeController::class, 'professional_training'])->name('professional_training');
Route::post('/professional_training', [HrmBackOfficeController::class, 'professional_training_store'])->name('professional_training_store');

//Experience
Route::get('/experience/{emp_id}', [HrmBackOfficeController::class, 'experience'])->name('experience');
Route::post('/experience', [HrmBackOfficeController::class, 'experience_store'])->name('experience_store');

// biodata print -web
// Route::get('/biodata/{employee_id}', [HrmBackOfficeController::class, 'biodata'])->name('biodata');

Route::get('/biodata_print/{emp_id}', [HrmBackOfficeController::class, 'biodata'])->name('biodata_print');



//employee_attendance report
Route::get('/hrm/companyEmployee/{id}', [HrmBackOfficeController::class, 'companyEmployee'])->name('companyEmployee');

// Route::post('/hrm/bio_data', [HrmBackOfficeController::class, 'hrmbackbio_datastore'])->name('hrmbackbio_datastore');

Route::get('/hrm/bio_data/{id}', [HrmBackOfficeController::class, 'hrmbio_dataedit'])->name('hrmbio_dataedit');

Route::post('/hrm/bio_data/{update}', [HrmBackOfficeController::class, 'hrmbio_dataupdate'])->name('hrmbio_dataupdate');

//end bio_data

// Employee Working Shifts Change
Route::get('/hrm/shift_change', [HrmBackOfficeController::class, 'shift_change'])->name('shift_change');
Route::post('/hrm/shift_change', [HrmBackOfficeController::class, 'shift_change_list'])->name('shift_change_list');
// Ajax
Route::get('/Add/Policy/{policy}/{employee}', [HrmBackOfficeController::class, 'AddPolicy']);
//End Employee Working Shifts Change

//salary_info
Route::get('/hrm/salary_info', [HrmBackOfficeController::class, 'hrmbacksalary_info'])->name('salary_info');
//end salary_info

//employee_clossing
Route::get('/hrm/employee_clossing', [HrmBackOfficeController::class, 'hrmbackemployee_clossing'])->name('employee_clossing');
Route::post('/hrm/employee_clossing', [HrmBackOfficeController::class, 'hrmemp_closingstore'])->name('hrmemp_closingstore');

//employee_extension
Route::get('/hrm/employee_extension', [HrmBackOfficeController::class, 'hrm_employee_extension'])->name('employee_extension');
Route::post('/hrm/employee_extension', [HrmBackOfficeController::class, 'hrmemp_extensionstore'])->name('hrmemp_extensionstore');


//end employee_clossing

//attn_payroll_status
Route::get('/hrm/attn_payroll_status', [HrmBackOfficeController::class, 'hrmbackattn_payroll_status'])->name('attn_payroll_status');
//end attn_payroll_status

//Own Password Change
Route::get('/hrm/profile', [HrmBackOfficeController::class, 'EmpProfile'])->name('profile');
Route::get('/hrm/changepass', [HrmBackOfficeController::class, 'ResetPass'])->name('changepass');
Route::post('/hrm/changepass', [HrmBackOfficeController::class, 'ResetPassstore'])->name('ResetPassstore');


//end attn_payroll_status

//leave_type
Route::get('/hrm/leave_type', [HrmBackOfficeController::class, 'hrmbackleave_type'])->name('leave_type');

Route::post('/hrm/leave_type', [HrmBackOfficeController::class, 'hrmbackleave_typestore'])->name('hrmbackleave_typestore');

Route::get('/hrm/leave_type/{id}', [HrmBackOfficeController::class, 'hrmbackleave_typeedit'])->name('hrmbackleave_typeedit');

Route::post('/hrm/leave_type/{update}', [HrmBackOfficeController::class, 'hrmbackleave_typeupdate'])->name('hrmbackleave_typeupdate');

//end leave_type

//leave_config

Route::get('/hrm/leave_config', [HrmBackOfficeController::class, 'hrmbackleave_config'])->name('leave_config');

Route::post('/hrm/leave_config', [HrmBackOfficeController::class, 'hrmbackleave_configstore'])->name('hrmbackleave_configstore');

Route::get('/hrm/leave_config/{id}', [HrmBackOfficeController::class, 'hrmbackleave_configedit'])->name('hrmbackleave_configedit');

Route::post('/hrm/leave_config/{update}', [HrmBackOfficeController::class, 'hrmbackleave_configupdate'])->name('hrmbackleave_configupdate');

//end leave_config

//leave_application
Route::get('/hrm/leave_application', [HrmBackOfficeController::class, 'hrmbackleave_application'])->name('leave_application');
Route::post('/hrm/leave_application', [HrmBackOfficeController::class, 'hrmbackleave_applicationstore'])->name('hrmbackleave_applicationstore');
Route::get('/hrm/leave_application/edit/{id}', [HrmBackOfficeController::class, 'HrmLleaveAppEdit'])->name('HrmLleaveAppEdit');
Route::post('/hrm/leave_application/{update}', [HrmBackOfficeController::class, 'HrmLeaveAppUpdate'])->name('HrmLeaveAppUpdate');


Route::get('/hrm/leave_application_op', [HrmBackOfficeController::class, 'HrmLeaveApplicationOp'])->name('leave_application_op');
Route::post('/hrm/leave_application_op', [HrmBackOfficeController::class, 'HrmLeaveApplicationOpStore'])->name('HrmLeaveApplicationOpStore');

//end leave_application

//leave_approval
Route::get('/hrm/leave_approval', [HrmBackOfficeController::class, 'hrmbackleave_approval'])->name('leave_approval');

Route::get('/hrm/leave_app_for_approval/{id}', [HrmBackOfficeController::class, 'hrmleave_app_approval'])->name('hrmleave_app_approval');

Route::post('/hrm/leave_app_for_approval/{update}', [HrmBackOfficeController::class, 'hrmleave_appupdate'])->name('hrmleave_appupdate');


Route::get('/hrm/leave_approval_others', [HrmBackOfficeController::class, 'hrmbackleave_approval_others'])->name('leave_approval_others');
Route::get('/hrm/leave_app_for_approval_other/{id}', [HrmBackOfficeController::class, 'hrmbackleave_app_for_approval_other'])->name('leave_app_for_approval_other');
Route::post('/hrm/leave_app_for_approval_other_update/{update}', [HrmBackOfficeController::class, 'leave_app_for_approval_other_update'])->name('leave_app_for_approval_other_update');
Route::get('/hrm/leave_app_for_approval_upload/{id}', [HrmBackOfficeController::class, 'leave_app_for_approval_upload'])->name('leave_app_for_approval_upload');

Route::post('/hrm/leave_file_store/{id}', [HrmBackOfficeController::class, 'leave_file_store'])->name('leave_file_store');
//end leave_approval

//movement
Route::get('/hrm/movement', [HrmBackOfficeController::class, 'hrmbackmovement'])->name('movement');
Route::post('/hrm/movement', [HrmBackOfficeController::class, 'hrmlate_applicationstore'])->name('hrmlate_applicationstore');

Route::get('/hrm/movement_application_op', [HrmBackOfficeController::class, 'HrmMoveApplicationOp'])->name('movement_application_op');
Route::post('/hrm/movement_application_op', [HrmBackOfficeController::class, 'HrmMoveApplicationOpStore'])->name('HrmMoveApplicationOpStore');

Route::get('/hrm/rpt_movement', [HrmBackOfficeController::class, 'hrmbackrptovement'])->name('rpt_movement');
Route::post('/hrm/rpt_movement_list', [HrmBackOfficeController::class, 'hrmbackrptovementList'])->name('hrmbackrptovementList');

//end movement

//movement_approval
Route::get('/hrm/movement_approval', [HrmBackOfficeController::class, 'hrmmovement_approval'])->name('movement_approval');
Route::get('/hrm/move_app_for_approval/{id}', [HrmBackOfficeController::class, 'hrmmove_app_approval'])->name('hrmmove_app_approval');
Route::post('/hrm/move_app_for_approval/{update}', [HrmBackOfficeController::class, 'hrmmove_appupdate'])->name('hrmmove_appupdate');

Route::get('/hrm/move_approval_others', [HrmBackOfficeController::class, 'HrmMoveApprovalOthers'])->name('move_approval_others');
Route::get('/hrm/move_app_for_approval_other/{id}', [HrmBackOfficeController::class, 'hrmbackmove_app_for_approval_other'])->name('move_app_for_approval_other');
Route::post('/hrm/move_app_for_approval_other_update/{update}', [HrmBackOfficeController::class, 'move_app_for_approval_other_update'])->name('move_app_for_approval_other_update');
Route::get('/hrm/move_app_for_approval_upload/{id}', [HrmBackOfficeController::class, 'move_app_for_approval_upload'])->name('move_app_for_approval_upload');
Route::post('/hrm/move_file_store/{id}', [HrmBackOfficeController::class, 'move_file_store'])->name('move_file_store');

//end movement_approval

//movement_approval manual
Route::get('/hrm/move_appro_manual', [HrmBackOfficeController::class, 'MoveApproManual'])->name('move_appro_manual');
Route::post('/hrm/move_appro_manual', [HrmBackOfficeController::class, 'MoveApproManualStore'])->name('MoveApproManualStore');

//All Policy Change posting wise
Route::get('/hrm/emp_all_policy_change', [HrmBackOfficeController::class, 'HrmAllPolicyChange'])->name('emp_all_policy_change');
Route::post('/hrm/emp_all_policy_change', [HrmBackOfficeController::class, 'HrmAllPolicyChangeStore'])->name('HrmAllPolicyChangeStore');



//data_sync
Route::get('/hrm/data_sync', [HrmBackOfficeController::class, 'hrmbackdata_sync'])->name('data_sync');

Route::post('/hrm/data_sync', [HrmBackOfficeController::class, 'hrmbackdata_syncstore'])->name('hrmbackdata_syncstore');




//end data_sync

//attendance_process
Route::get('/hrm/attendance_process', [HrmBackOfficeController::class, 'hrmbackattendance_process'])->name('attendance_process');

Route::post('/hrm/attendance_process', [HrmBackOfficeController::class, 'hrmbackattendance_processstore'])->name('hrmbackattendance_processstore');

Route::get('/hrm/attendance_process_02', [HrmBackOfficeController::class, 'HrmAttendanceProcess_02'])->name('attendance_process_02');

Route::post('/hrm/attendance_process_02', [HrmBackOfficeController::class, 'HrmAttenProcessStore_02'])->name('HrmAttenProcessStore_02');


//company & posting wise attendance_process
Route::get('/hrm/attendance_process_com_posting', [HrmBackOfficeController::class, 'HrmAttenProcessComPosting'])->name('attendance_process_com_posting');
Route::post('/hrm/attendance_process_com_posting', [HrmBackOfficeController::class, 'HrmAttenProcessComPostingStore'])->name('HrmAttenProcessComPostingStore');
Route::get('/hrm/attendance_process_com_posting_02', [HrmBackOfficeController::class, 'HrmAttenProcessComPosting_02'])->name('attendance_process_com_posting_02');
Route::post('/hrm/attendance_process_com_posting_02', [HrmBackOfficeController::class, 'HrmAttenProcessComPostingStore_02'])->name('HrmAttenProcessComPostingStore_02');




/// Company and posting wise update process
Route::get('/hrm/atten_re_process_com_posting', [HrmBackOfficeController::class, 'HrmAttenReProcessComPosting'])->name('atten_re_process_com_posting');
Route::post('/hrm/atten_re_process_com_posting', [HrmBackOfficeController::class, 'HrmAttenReProcessComPostingUpdate'])->name('HrmAttenReProcessComPostingUpdate');



//attendance_re_process
Route::get('/hrm/attendance_re_process', [HrmBackOfficeController::class, 'hrmbackattendance_re_process'])->name('attendance_re_process');

Route::post('/hrm/attendance_re_process', [HrmBackOfficeController::class, 'attendance_re_processstore'])->name('attendance_re_processstore');

Route::get('/hrm/attendance_ind_process', [HrmBackOfficeController::class, 'hrmbackattendance_ind_process'])->name('attendance_ind_process');
Route::post('/hrm/attendance_ind_process', [HrmBackOfficeController::class, 'attendance_ind_processstore'])->name('attendance_ind_processstore');



//end attendance_process

//leave_process
Route::get('/hrm/leave_process', [HrmBackOfficeController::class, 'hrmbackleave_process'])->name('leave_process');
Route::post('/hrm/leave_process', [HrmBackOfficeController::class, 'hrm_leave_process'])->name('hrm_leave_process');
//end leave_process

//movement_process
Route::get('/hrm/movement_process', [HrmBackOfficeController::class, 'hrmbackmovement_process'])->name('movement_process');
Route::post('/hrm/movement_process', [HrmBackOfficeController::class, 'hrm_movement_process'])->name('hrm_movement_process');
//end movement_process

//eatly_process
Route::get('/hrm/early_process', [HrmBackOfficeController::class, 'HrmEarlyProcess'])->name('early_process');
Route::post('/hrm/early_process', [HrmBackOfficeController::class, 'HrmEarlyProcessStore'])->name('HrmEarlyProcessStore');
//end eatly_process

//time_process
Route::get('/hrm/time_process', [HrmBackOfficeController::class, 'HrmTimeProcess'])->name('time_process');
Route::post('/hrm/time_process', [HrmBackOfficeController::class, 'HrmTimeProcessStore'])->name('HrmTimeProcessStore');
//end time_process

//summary_process
Route::get('/hrm/summary_process', [HrmBackOfficeController::class, 'hrmbacksummary_process'])->name('summary_process');

Route::post('/hrm/summary_process', [HrmBackOfficeController::class, 'hrmbacksummary_processstore'])->name('hrmbacksummary_processstore');


//end summary_process

//payroll_process
Route::get('/hrm/payroll_process', [HrmBackOfficeController::class, 'hrmbackpayroll_process'])->name('payroll_process');
//end payroll_process

//summery_attendance report
Route::get('/hrm/summary_attendance', [HrmBackOfficeController::class, 'hrmbacksummary_attendance'])->name('summary_attendance');
Route::get('/hrm/summary_attn_posting', [HrmBackOfficeController::class, 'hrmsummary_attendance_posting'])->name('summary_attn_posting');

Route::post('/hrm/summary_attendance', [HrmBackOfficeController::class, 'hrmbacksummary_attendance_report'])->name('hrmbacksummary_attendance_report');
Route::post('/hrm/summary_attn_posting', [HrmBackOfficeController::class, 'HrmSummaryPostingAttnReport'])->name('HrmSummaryPostingAttnReport');

//print summery_attendance report
Route::get('/hrm/summary_attendance_print/{summ_attn_master_id}/{sele_placeofposting}', [HrmBackOfficeController::class, 'hrmbacksummary_attendance_print'])->name('summary_attendance_print');


Route::get('/hrm/summary_leave', [HrmBackOfficeController::class, 'hrmsummary_leave'])->name('summary_leave');
Route::post('/hrm/summary_leave', [HrmBackOfficeController::class, 'hrmsummary_leave_report'])->name('hrmsummary_leave_report');

//Data Query
Route::get('/hrm/data_query', [HrmBackOfficeController::class, 'HrmDataQuery'])->name('data_query');
Route::post('/hrm/data_query_list', [HrmBackOfficeController::class, 'HrmDataQueryList'])->name('HrmDataQueryList');

//end summery_attendance

//attendance report
Route::get('/hrm/rpt_atten_ind', [HrmBackOfficeController::class, 'hrmattenind'])->name('rpt_atten_ind');
Route::post('/hrm/rpt_atten_ind_show', [HrmBackOfficeController::class, 'hrmattenindrpt'])->name('hrmattenindrpt');
Route::get('/hrm/rpt_atten_ind_print/{txt_month}/{cbo_employee_id}', [HrmBackOfficeController::class, 'HrmAttnIndReportPrint'])->name('HrmAttnIndReportPrint');


//end attendance

//employee_attendance report
Route::get('/hrm/postingEmployee/{id}', [HrmBackOfficeController::class, 'postingEmployee'])->name('postingEmployee');

Route::get('/hrm/postingEmployee1/{id}', [HrmBackOfficeController::class, 'postingEmployee1'])->name('postingEmployee1');



Route::get('/hrm/employee_attendance', [HrmBackOfficeController::class, 'hrmbackemployee_attendance'])->name('employee_attendance');
Route::post('/hrm/emp_attn_report', [HrmBackOfficeController::class, 'hrmbackemp_attn_report'])->name('hrmbackemp_attn_report');
Route::get('/hrm/hrmbackemp_attn_report_print/{txt_month}/{cbo_employee_id}', [HrmBackOfficeController::class, 'hrmbackemp_attn_report_print'])->name('hrmbackemp_attn_report_print');

//end employee_attendance

Route::get('/hrm/employee_attendance_date', [HrmBackOfficeController::class, 'HrmEmpAttenDate'])->name('employee_attendance_date');
Route::post('/hrm/emp_attn_date_report', [HrmBackOfficeController::class, 'HrmEmpAttnDateReport'])->name('HrmEmpAttnDateReport');



//employee punch report
Route::get('/hrm/daily_punch', [HrmBackOfficeController::class, 'hrmbackdaily_punch'])->name('daily_punch');
Route::get('/hrm/emp_punch_report', [HrmBackOfficeController::class, 'hrmbackdaily_punch_report'])->name('hrmbackdaily_punch_report');

//ajax
Route::get('get/hrm/placeofsubposting/{placeofposting_id}', [HrmBackOfficeController::class, 'hrmbackgetplaceofsubposting']);
Route::get('get/hrm/employee/{placeofposting_id}/{placeofposting_sub_id}/{company_id}', [HrmBackOfficeController::class, 'hrmbackgetemployee']);
//end employee punch report

//data split 
Route::get('/hrm/data_split', [HrmBackOfficeController::class, 'HrmDataSplit'])->name('data_split');
Route::post('/hrm/data_split', [HrmBackOfficeController::class, 'HrmDataSplitStore'])->name('HrmDataSplitStore');


//employee atten aaa report
Route::get('/hrm/rpt_atten_date_range', [HrmBackOfficeController::class, 'hrmAttenAaa'])->name('rpt_atten_date_range');
Route::post('/hrm/date_range_atten_report', [HrmBackOfficeController::class, 'hrmAaaReport'])->name('hrmAaaReport');

//end employee punch report


//leave_application_list
Route::get('/hrm/leave_application_list', [HrmBackOfficeController::class, 'hrmbackleave_application_list'])->name('leave_application_list');
//end leave_application_list

//Report Employee List
Route::get('/hrm/rpt_basic_info_list', [HrmBackOfficeController::class, 'RptEmpList'])->name('rpt_basic_info_list');
Route::get('/hrm/rpt_basic_info_list_all', [HrmBackOfficeController::class, 'RptEmpListAll'])->name('rpt_basic_info_list_all');

//end Report Employee List

//sub place of posting
Route::get('/hrm/sub_placeofposting', [HrmBackOfficeController::class, 'HrmSubPlaceOfPosting'])->name('sub_placeofposting');
Route::post('/hrm/sub_placeofposting_store', [HrmBackOfficeController::class, 'HrmSubPlaceOfPostingStore'])->name('sub_placeofposting_store');
Route::get('/hrm/sub_placeofposting_edit/{id}', [HrmBackOfficeController::class, 'HrmSubPlaceOfPostingEdit'])->name('sub_placeofposting_edit');
Route::post('/hrm/sub_placeofposting_update/{id}', [HrmBackOfficeController::class, 'HrmSubPlaceOfPostingUpdate'])->name('sub_placeofposting_update');
//End sub place of posting

Route::get('/hrm/emp_day_shift', [HrmBackOfficeController::class, 'HrmEmpDayShift'])->name('emp_day_shift');
Route::post('/hrm/emp_day_shift_store', [HrmBackOfficeController::class, 'HrmEmpDayShiftStore'])->name('emp_day_shift_store');
Route::get('/hrm/emp_day_shift_details/{attn_date}/{id}/{id1}/{id2}', [HrmBackOfficeController::class, 'HrmEmpDayShiftDetails'])->name('emp_day_shift_details');
Route::post('/hrm/emp_day_shift_details_store', [HrmBackOfficeController::class, 'HrmEmpDayShiftDetailsStore'])->name('emp_day_shift_details_store');
Route::get('/hrm/emp_day_shift_final/{attn_date}/{id}/{id1}/{id2}', [HrmBackOfficeController::class, 'HrmEmpDayShiftFinal'])->name('emp_day_shift_final');
Route::get('/hrm/emp_day_shift_no_change', [HrmBackOfficeController::class, 'HrmEmpDayShiftNoChange'])->name('emp_day_shift_no_change');
Route::post('/hrm/emp_day_shift_final_nochange', [HrmBackOfficeController::class, 'HrmEmpDayShiftFinalnoChange'])->name('emp_day_shift_final_nochange');
Route::get('/hrm/emp_month_shift_no_change', [HrmBackOfficeController::class, 'HrmEmpMonthShiftNoChange'])->name('emp_month_shift_no_change');
Route::post('/hrm/emp_month_shift_final_nochange', [HrmBackOfficeController::class, 'HrmEmpMonthShiftFinalnoChange'])->name('emp_month_shift_final_nochange');


Route::get('/hrm/emp_id_card/{id}', [HrmBackOfficeController::class, 'HrmEmpIdCard'])->name('emp_id_card');


Route::get('/hrm/rpt_emp_day_shift', [HrmBackOfficeController::class, 'RptEmpDayShift'])->name('rpt_emp_day_shift');

Route::post('/hrm/rpt_emp_day_shift', [HrmBackOfficeController::class, 'EmpDayShiftReport'])->name('EmpDayShiftReport');


//Daily Punch report 02
Route::get('/hrm/daily_punch_02', [HrmBackOfficeController::class, 'hrmbackdaily_punch02'])->name('daily_punch_02');
Route::get('/hrm/emp_punch_report_02', [HrmBackOfficeController::class, 'hrmbackdaily_punch_report02'])->name('hrmbackdaily_punch_report_02');

//leave_application_list
Route::get('/hrm/leave_application_list_02', [HrmBackOfficeController::class, 'hrmbackleave_application_list02'])->name('leave_application_list_02');
Route::post('/hrm/leave_application_list_02', [HrmBackOfficeController::class, 'hrmbackleave_application_details02'])->name('leave_application_details_02');
//end leave_application_list

//report Movement
Route::get('/hrm/rpt_movement_register_list', [HrmBackOfficeController::class, 'hrmbackMovement_register_list'])->name('rpt_movement_register_list');
Route::post('/hrm/rpt_movement_register_list', [HrmBackOfficeController::class, 'hrmbackMovement_register_details'])->name('rpt_movement_register_details');
//end movement

//end HRM Backoffice

// ajax call
Route::get('get/employee/{id}', [HrmBackOfficeController::class, 'GetEmployee']);
Route::get('get/employee/{m_company}/{m_posting}/{m_sub_posting}', [HrmBackOfficeController::class, 'GetEmployeeDayShift']);
Route::get('get/posting/{m_company}', [HrmBackOfficeController::class, 'GetPosting']);
Route::get('get/policy/{m_company}', [HrmBackOfficeController::class, 'GetPolicy']);
Route::get('get/sub_posting/{placeofposting_id}', [HrmBackOfficeController::class, 'GetSubPosting']);
Route::get('get/SubPosting_list/{placeofposting_id}', [HrmBackOfficeController::class, 'GetSubPostingList']);
Route::get('get/employee_bio/{id}', [HrmBackOfficeController::class, 'GetEmployeeBio']);
Route::get('get/employeews/{id}', [HrmBackOfficeController::class, 'GetEmployeeWS']);
Route::get('get/desig/{id}', [HrmBackOfficeController::class, 'GetEmployeeDesig']);

//Hrm rpt basic info list
Route::get('/get/hrm/basic_info_list', [HrmBackOfficeController::class, 'GetHrmBasicInfoList']);
Route::get('/get/hrm/basic_info_up_list', [HrmBackOfficeController::class, 'GetHrmBasicInfoUpList']);
Route::get('get/rpt_basic_info_list', [HrmBackOfficeController::class, 'GetRptBasicInfoList']); 
Route::get('get/rpt_basic_info_list_all', [HrmBackOfficeController::class, 'GetRptBasicInfoListAll']); 
Route::get('get/company_policy/{id}', [HrmBackOfficeController::class, 'GetCompanyPolicy']);

});