<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

//File Management
use App\Http\Controllers\FileManagerController;


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

// Route::get('/trr', function () {

// 	return $ci1_pro_product_sub_group = DB::table('pro_product_sub_group')
//                           ->Where('pg_id', 2)
//                           ->Where('pg_sub_id', '!=',61)
//                           ->orderBy('pg_sub_name', 'asc')
//                           ->get();
//     // return view('welcome');
// });



Auth::routes();

Route::group(['middleware' => ['auth', 'auth2']], function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/get/alart_massage', function () {
        $m_employee  = Auth::user()->emp_id;
        $data = DB::table('pro_alart_massage')->select('massage')->where('report_id', $m_employee)->where('valid', 1)->get();
        return response()->json($data);
    })->name('alart_massage');

    Route::get('/remove/alart_massage/{id}', function ($id) {

        $m_employee  = Auth::user()->emp_id;
        if ($id == 0) {
            DB::table('pro_alart_massage')->where('report_id', $m_employee)->update(['valid' => 0]);
            return response()->json('allDelete');
        } else {
            DB::table('pro_alart_massage')->where('report_id', $m_employee)->where('alart_massage_id', $id)->update(['valid' => 0]);
            return response()->json('success');
        }
    });
});


//  //Clear route cache
//  Route::get('/route-clear', function() {
//     \Artisan::call('route:clear');
//     return 'Routes cleared';
// });


// // Clear view clear
// Route::get('/view-clear', function() {
//     \Artisan::call('view:clear');
//     return 'View cleared';
// });

// // Clear cache using optimize
// Route::get('/optimize', function() {
//     \Artisan::call('optimize');
//     return 'Optimize view, route, config cache cleared';
// });


// Route::get('/sub_need',function(){
// $products = DB::table('pro_product')->where('valid',1)->get();
// foreach($products as $product){
//     DB::table('pro_graw_issue_details')
//     // ->where('pg_id',$product->pg_id)
//     ->where('product_id',$product->product_id)
//     ->update(['pg_sub_id'=>$product->pg_sub_id]);
// }
// return "Done";
// });

// Route::get('/sub_level',function(){
// $m_employee_info = DB::table('pro_employee_info')->get();
// foreach($m_employee_info as $row_employee_info){
//     DB::table('pro_level_step')->insert([
//     	'level_step'=>$row_employee_info->level_step,
//     	'employee_id'=>$row_employee_info->employee_id,
//     	'report_to_id'=>$row_employee_info->report_to_id,
//     	'user_id'=>$row_employee_info->level_step,
//     	'entry_date'=>date('Y-m-d'),
//     	'entry_time'=>date('H:i:s'),
//     	'valid'=>'1',

//     	]);
// }
// return "Done";
// });


// Route::get('/sub_group',function(){

// $ci_indent_details = DB::table('pro_indent_details')->get();
// // return ($products);
// foreach($ci_indent_details as $row_indent_details){
// 	$products = DB::table('pro_product')
// 	->where('product_id',$row_indent_details->product_id)
// 	->first();

//     DB::table('pro_indent_details')
//     ->where('indent_details_id',$row_indent_details->indent_details_id)
//     ->update(['pg_sub_id'=>$products->pg_sub_id]);
// }
// return "Done";
// });



// // Route::get('/sub_need',function(){

// // $ci_indent_details = DB::table('pro_indent_details')->get();
// // // return ($products);
// // foreach($ci_indent_details as $row_indent_details){
// // 	$products = DB::table('pro_product')
// // 	->where('product_id',$row_indent_details->product_id)
// // 	->first();

// //     DB::table('pro_indent_details')
// //     ->where('indent_details_id',$row_indent_details->indent_details_id)
// //     ->update(['product_unit'=>$products->unit]);
// // }
// // return "Done";
// // });


// // Route::get('/sub_need',function(){

// // $products = DB::table('pro_attendance')->get();
// // // return ($products);
// // foreach($products as $product){
// // $x=	str_pad($product->employee_id,8,"0",STR_PAD_LEFT);
// //     DB::table('pro_attendance')
// //     ->where('attendance_id',$product->attendance_id)
// //     ->update(['employee_id'=>$x]);
// // }
// // return "Done";
// // });
//  // Route::get('/check',function(){

//  //                $m_employee_id='00000160';
//  //                // $m_desig_id=$row_attn_employee->desig_id;
//  //                // $m_department_id=$row_attn_employee->department_id;
//  //                // $m_placeofposting_id=$row_attn_employee->placeofposting_id;

//  //                $m_working_day=DB::table('pro_attendance')
//  //                ->whereBetween('attn_date',['2023-06-01','2023-06-30'])
//  //                ->where('day_status','R')
//  //                ->where('employee_id',$m_employee_id)
//  //                ->groupBy('attn_date')
//  //                ->having('attn_date','>',1)
//  //                ->count();
//  //               return $m_twd=$m_working_day;
//  //                dd($m_twd);


// // $remove_duplicateRecords =  DB::table('pro_teams')
// //               ->select('team_leader_id')
// //               ->groupBy('team_leader_id')
// //               ->having('team_leader_id', '>', 1)
// //               ->get();

//  // });

// Route::get('/atten_table_split',function(){

// $start_date = "2023-08-01";
// $end_date = "2023-08-31";

// $data = DB::table('pro_attendance')->whereBetween('attn_date', [$start_date, $end_date])->get();

// foreach($data as $row){

//  DB::table('pro_attendance_0823')->insert([
//             // 'attendance_id'=>$row->attendance_id,
//             'company_id'=>$row->company_id,
//             'employee_id'=>$row->employee_id,
//             'machine_id'=>$row->machine_id,
//             'desig_id'=>$row->desig_id,
//             'department_id'=>$row->department_id,
//             'placeofposting_id'=>$row->placeofposting_id,
//             'att_policy_id'=>$row->att_policy_id,
//             'attn_date'=>$row->attn_date,
//             'r_in_time'=>$row->r_in_time,
//             'p_in_time'=>$row->p_in_time,
//             'p_out_time'=>$row->p_out_time,
//             'in_time'=>$row->in_time,
//             'nodeid_in'=>$row->nodeid_in,
//             'out_time'=>$row->out_time,
//             'nodeid_out'=>$row->nodeid_out,
//             'day_name'=>$row->day_name,
//             'day_status'=>$row->day_status,
//             'total_working_hour'=>$row->total_working_hour,
//             'ot_minute'=>$row->ot_minute,
//             'late_min'=>$row->late_min,
//             'early_min'=>$row->early_min,
//             'status'=>$row->status,
//             'is_quesitonable'=>$row->is_quesitonable,
//             'process_status'=>$row->process_status,
//             'user_id'=>$row->user_id,
//             'entry_date'=>$row->entry_date,
//             'entry_time'=>$row->entry_time,
//             'valid'=>$row->valid,
//             'psm_id'=>$row->psm_id,
//         ]);


// }

Route::get('/late_approved_table', function () {

    $data = DB::table('pro_late_inform_details')
        ->where('valid', 1)
        ->get();

    $m_approved_level = '1';
    foreach ($data as $row) {


        $data = array();
        $data['late_inform_master_id'] = $row->late_inform_master_id;
        $data['employee_id'] = $row->employee_id;
        $data['company_id'] = $row->company_id;
        $data['desig_id'] = $row->desig_id;
        $data['late_type_id'] = $row->late_type_id;
        $data['late_date'] = $row->late_type_id;
        $data['total'] = $row->late_total;
        $data['approved_id'] = $row->approved_id;
        $data['user_id'] = $row->approved_id;
        $data['entry_date'] = $row->entry_date;
        $data['entry_time'] = $row->entry_time;
        $data['valid'] = $row->valid;
        $data['approved_level'] = $m_approved_level;

        DB::table('pro_late_approved_details')->insert($data);
    }

    return "Done";
});

Route::get('/leave_approved_table', function () {

    $data = DB::table('pro_leave_info_details')
        ->where('valid', 1)
        ->get();

    $m_approved_level = '1';
    foreach ($data as $row) {


        $data = array();
        $data['leave_info_master_id'] = $row->leave_info_master_id;
        $data['employee_id'] = $row->employee_id;
        $data['company_id'] = $row->company_id;
        $data['desig_id'] = $row->desig_id;
        $data['leave_type_id'] = $row->leave_type_id;
        $data['leave_date'] = $row->leave_date;
        $data['total'] = $row->total;
        $data['approved_id'] = $row->approved_id;
        $data['user_id'] = $row->approved_id;
        $data['entry_date'] = $row->entry_date;
        $data['entry_time'] = $row->entry_time;
        $data['valid'] = $row->valid;
        $data['approved_level'] = $m_approved_level;

        DB::table('pro_leave_approved_details')->insert($data);
    }

    return "Done";
});

//customer
Route::get('/move_customer', function () {

    $old_customer = DB::table('bpack_supplier_information')->where('cust_sppl', '!=', 'S')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_customer_information')->where('customer_id', $row->supplier_id)->first();
        if ($check == null) {
            $data = array();
            $data['customer_id'] = $row->supplier_id;
            $data['customer_name'] = $row->supplier_name;
            $data['contact_person'] = $row->supplier_contact;
            $data['customer_type'] = $row->supplier_type;
            $data['customer_address'] = $row->supplier_address;
            $data['customer_zip'] = $row->supplier_zip;
            $data['customer_city'] = $row->supplier_city;
            $data['customer_country'] = $row->supplier_country;
            $data['customer_state'] = $row->supplier_state;
            $data['customer_phone'] = $row->supplier_phone;
            $data['customer_mobile'] = $row->supplier_mobile;
            $data['customer_fax'] = $row->supplier_fax;
            $data['customer_email'] = $row->supplier_email;
            $data['customer_url'] = $row->supplier_url;
            $data['user_id'] = $row->admin_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['last_user_id'] = $row->last_user_id;
            $data['last_edit_date'] = $row->last_edit_date;
            $data['last_edit_time'] = $row->last_edit_time;
            $data['cust_sppl'] = $row->cust_sppl;
            $data['valid'] = $row->valid;

            DB::table('pro_customer_information')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done customer";
});


//Rate Policy
Route::get('/move_rate_policy', function () {

    $old_customer = DB::table('bpack_rate_policy')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_rate_policy_1')->where('rate_policy_id', $row->rate_policy_id)->first();
        if ($check == null) {
            $data = array();
            $data['rate_policy_id'] = $row->rate_policy_id;
            $data['company_id'] = '1';
            $data['rate_policy_name'] = $row->rate_policy_name;
            $data['rate_group'] = $row->rate_group;
            $data['discount_type'] = $row->discount_type;
            $data['discount'] = $row->discount;
            $data['remarks'] = $row->remarks;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;

            DB::table('pro_rate_policy_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done rate ploicy";
});

//Rate chart
Route::get('/move_rate_chart', function () {

    $old_customer = DB::table('bpack_rate_chart')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_rate_chart_1')->where('rate_chart_id', $row->rate_chart_id)->first();
        if ($check == null) {
            $data = array();
            $data['rate_chart_id'] = $row->rate_chart_id;
            $data['company_id'] = '1';
            $data['rate_group'] = $row->rate_group;
            $data['product_id'] = $row->product_id;
            $data['rate'] = $row->rate;
            $data['remarks'] = $row->remarks;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;

            DB::table('pro_rate_chart_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done rate chart";
});

//Musuk
Route::get('/move_mushok', function () {

    $old_customer = DB::table('bpack_mushok')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_mushok_1')->where('mushok_id', $row->mushok_id)->first();
        if ($check == null) {
            $data = array();
            $data['mushok_id'] = $row->mushok_id;
            $data['company_id'] = '1';
            $data['mushok_number'] = $row->mushok_number;
            $data['financial_year_id'] = $row->financial_year_id;
            $data['financial_year_name'] = $row->financial_year_name;
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['pg_id'] = $row->pg_id;
            $data['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
            $data['dcm_date'] = $row->dcm_date;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;

            DB::table('pro_mushok_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done mushok";
});


//Finish Product Serial
Route::get('/move_product_serial', function () {

    $old_customer = DB::table('bpack_finish_product_serial')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_finish_product_serial_1')->where('serial_id', $row->serial_id)->first();
        if ($check == null) {
            $data = array();
            $data['serial_id'] = $row->serial_id;
            $data['company_id'] = '1';
            $data['id'] = $row->id;
            $data['pg_id'] = $row->pg_id;
            $data['product_id'] = $row->product_id;
            $data['serial_no'] = $row->serial_no;
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['sid_id'] = $row->sid_id;
            $data['customer_id'] = $row->customer_id;
            $data['sinv_user_id'] = $row->sinv_user_id;
            $data['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
            $data['delivery_chalan_details_id'] = $row->delivery_chalan_details_id;
            $data['rsim_id'] = $row->rsim_id;
            $data['rsid_id'] = $row->rsid_id;
            $data['dcd_date'] = $row->dcd_date;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;
            $data['year'] = '';

            DB::table('pro_finish_product_serial_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done product serial";
});

//Qutiation Master
Route::get('/move_quotation_master', function () {

    $old_customer = DB::table('bpack_quotation_master')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_quotation_master_1')->where('quotation_master_id', $row->quotation_master_id)->first();
        if ($check == null) {
            $data = array();
            // $data['quotation_id ']= ;
            $data['company_id'] = '1';
            $data['quotation_master_id'] = $row->quotation_master_id;
            $data['quotation_date'] = $row->quotation_date;
            $data['customer_name'] = $row->customer_name;
            $data['customer_address'] = $row->customer_address;
            $data['customer_mobile'] = $row->customer_mobile;
            $data['subject'] = $row->subject;
            $data['offer_valid'] = $row->offer_valid;
            $data['reference'] = $row->reference;
            $data['reference_mobile'] = $row->reference_mobile;
            $data['email'] = $row->email;
            $data['sub_total'] = $row->sub_total;
            $data['discount_amount'] = $row->discount_amount;
            $data['transport_cost'] = $row->transport_cost;
            $data['test_fee'] = $row->test_fee;
            $data['other_expense'] = $row->other_expense;
            $data['quotation_total'] = $row->quotation_total;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;
            $data['attention'] = '';

            DB::table('pro_quotation_master_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Quotation Master";
});

//Qutiation Details
Route::get('/move_quotation_details', function () {

    $old_customer = DB::table('bpack_quotation_details')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_quotation_details_1')->where('quotation_details_id', $row->quotation_details_id)->first();
        if ($check == null) {
            $data = array();
            $data['quotation_details_id'] = $row->quotation_details_id;
            $data['company_id'] = '1';
            // $data['quotation_id']=$row->quotation_master_id;
            $data['quotation_master_id'] = $row->quotation_master_id;
            $data['quotation_date'] = $row->quotation_date;
            $data['product_id'] = $row->product_id;
            $data['qty'] = $row->qty;
            $data['rate'] = $row->rate;
            $data['rate_policy_id'] = $row->rate_policy_id;
            $data['total'] = $row->total;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;

            DB::table('pro_quotation_details_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Quotation Details";
});


//Update Qutiation Details
Route::get('/update_quotation_details', function () {

    $old_customer = DB::table('pro_quotation_master_1')->get();

    foreach ($old_customer as $row) {
        $data['quotation_id'] = $row->quotation_id;
        DB::table('pro_quotation_details_1')->where('quotation_master_id', $row->quotation_master_id)->update($data);
    } //foreach($old_customer as $row)

    return "Done Quotation Details update";
});


//Requisition Master 
Route::get('/move_requisition_master', function () {

    $old_customer = DB::table('bpack_sales_requisition_01')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_sales_requisition_master_1')->where('requisition_master_id', $row->requisition_id_01)->first();
        if ($check == null) {
            $data = array();
            $data['requisition_master_id'] = $row->requisition_id_01;
            $data['requisition_date'] = $row->requisition_date;
            $data['company_id'] = '1';
            $data['customer_id'] = $row->main_customer_code;
            $data['deposit_amount'] = $row->deposit_amount;
            $data['sub_deposit_amount'] = $row->sub_deposit_amount;
            $data['total_deposit_amount'] = $row->total_deposit_amount;
            $data['last_balance'] = $row->last_balance;
            $data['pono_ref'] = $row->pono_ref;
            $data['pono_ref_date'] = $row->pono_ref_date;
            $data['remarks'] = $row->remarks;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;
            $data['requisition_stock_status'] = $row->requisition_stock_status;
            $data['approved'] = $row->approved;
            $data['comments'] = $row->comments;

            DB::table('pro_sales_requisition_master_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Requisition Master";
});

//Requisition Details 
Route::get('/move_requisition_details', function () {

    $old_customer = DB::table('bpack_sales_requisition_02')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_sales_requisition_details_1')->where('requisition_details_id', $row->requisition_id_02)->first();
        if ($check == null) {
            $data = array();
            $data['requisition_details_id'] = $row->requisition_id_02;
            $data['requisition_master_id'] = $row->requisition_id_01;
            $data['requisition_date'] = $row->requisition_date;
            $data['company_id'] = '1';
            $data['customer_id'] = $row->main_customer_code;
            $data['product_id'] = $row->product_id;
            $data['qty'] = $row->qty;
            $data['rate'] = $row->rate;
            $data['rate_policy_id'] = $row->rate_policy_id;
            $data['total'] = $row->total;
            $data['comm_rate'] = $row->comm_rate;
            $data['comm_rate_total'] = $row->comm_rate_total;
            $data['transport_rate'] = $row->transport_rate;
            $data['total_transport'] = $row->total_transport;
            $data['net_total'] = $row->net_total;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;

            DB::table('pro_sales_requisition_details_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Requisition Details";
});

//Money Receipt
Route::get('/move_money_receipt', function () {

    $old_customer = DB::table('bpack_money_receipt')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_money_receipt_1')->where('mr_id', $row->mr_id)->first();
        if ($check == null) {
            $data = array();
            $data['mr_id'] = $row->mr_id;
            $data['company_id'] = '1';
            $data['collection_date'] = $row->collection_date;
            $data['mr_master_id'] = $row->mr_master_id;
            $data['pg_id'] = $row->pg_id;
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['customer_id'] = $row->customer_id;
            $data['cust_sppl'] = $row->cust_sppl;
            $data['rate_policy_id'] = $row->rate_policy_id;
            $data['sinv_total'] = $row->sinv_total;
            $data['dt_price'] = $row->dt_price;
            $data['transport_fee'] = $row->transport_fee;
            $data['test_fee'] = $row->test_fee;
            $data['other_fee'] = $row->other_fee;
            $data['mr_amount'] = $row->mr_amount;
            $data['receive_amount_inword'] = $row->receive_amount_inword;
            $data['discount_amount'] = $row->discount_amount;
            $data['cr_amount'] = $row->cr_amount;
            $data['payment_type'] = $row->payment_type;
            $data['receive_type'] = $row->receive_type;
            $data['bank_id'] = $row->bank_id;
            $data['chq_po_dd_no'] = $row->chq_po_dd_no;
            $data['chq_po_dd_date'] = $row->chq_po_dd_date;
            $data['remarks'] = $row->remarks;
            $data['sinv_user_id'] = $row->sinv_user_id;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;
            $data['sales_type'] = $row->sales_type;

            DB::table('pro_money_receipt_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Money Receipt";
});

//Money Receipt Master
Route::get('/move_money_receipt_master', function () {

    $old_customer = DB::table('bpack_money_receipt_master')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_money_receipt_master_1')->where('mr_master_id', $row->mr_master_id)->first();
        if ($check == null) {
            $data = array();
            $data['mr_master_id'] = $row->mr_master_id;
            $data['company_id'] = '1';
            $data['sales_type'] = $row->sales_type;
            $data['mr_total'] = $row->mr_total;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;

            DB::table('pro_money_receipt_master_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Money Receipt Master";
});


//Sales Invoice Master
Route::get('/move_sales_invoice_master', function () {

    $old_customer = DB::table('bpack_sim')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_sim_1')->where('sim_id', $row->sim_id)->first();
        if ($check == null) {
            $data = array();
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['company_id'] = '1';
            $data['customer_id'] = $row->customer_id;
            $data['cust_sppl'] = $row->cust_sppl;
            $data['pg_id'] = $row->pg_id;
            $data['ref_name'] = $row->ref_name;
            $data['ref_mobile'] = $row->ref_mobile;
            $data['mushok_no'] = $row->mushok_no;
            $data['ifb_no'] = $row->ifb_no;
            $data['ifb_date'] = $row->ifb_date;
            $data['contract_no'] = $row->contract_no;
            $data['contract_date'] = $row->contract_date;
            $data['allocation_no'] = $row->allocation_no;
            $data['allocation_date'] = $row->allocation_date;
            $data['pono_ref'] = $row->pono_ref;
            $data['pono_ref_date'] = $row->pono_ref_date;
            $data['status'] = $row->status;
            $data['sinv_total'] = $row->sinv_total;
            $data['money_receipt_no'] = $row->money_receipt_no;
            $data['sales_type'] = $row->sales_type;
            $data['discount_amount'] = $row->discount_amount;
            $data['tr_discount_amount'] = $row->tr_discount_amount;
            $data['transport_cost'] = $row->transport_cost;
            $data['test_fee'] = $row->test_fee;
            $data['other_expense'] = $row->other_expense;
            $data['total'] = $row->total;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['tto_status'] = $row->tto_status;
            $data['dch_status'] = '';
            $data['reinvm_status'] = '';

            DB::table('pro_sim_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Sales Invoice Master";
});


//Sales Invoice Details
Route::get('/move_sales_invoice_details', function () {

    $old_customer = DB::table('bpack_sid')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_sid_1')->where('sid_id', $row->sid_id)->first();
        if ($check == null) {
            $data = array();
            $data['sid_id'] = $row->sid_id;
            $data['company_id'] = '1';
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['customer_id'] = $row->customer_id;
            $data['cust_sppl'] = $row->cust_sppl;
            $data['vendor_id'] = $row->vendor_id;
            $data['auth_ref_no'] = $row->auth_ref_no;
            $data['pg_id'] = $row->pg_id;
            $data['product_id'] = $row->product_id;
            $data['qty'] = $row->qty;
            $data['rate'] = $row->rate;
            $data['rate_policy_id'] = $row->rate_policy_id;
            $data['discount_rate'] = $row->discount_rate;
            $data['total_discount'] = $row->total_discount;
            $data['transport_rate'] = $row->transport_rate;
            $data['total_transport'] = $row->total_transport;
            $data['total'] = $row->total;
            $data['remarks'] = $row->remarks;
            $data['status'] = $row->status;
            $data['deliver_no'] = $row->deliver_no;
            $data['deliver_date'] = $row->deliver_date;
            $data['deliver_qty'] = $row->deliver_qty;
            $data['cash_fac'] = $row->cash_fac;
            $data['cash_ho'] = $row->cash_ho;
            $data['bybank'] = $row->bybank;
            $data['through_bank'] = $row->through_bank;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['dch_qty'] = '';
            $data['dch_status'] = '';
            $data['reinvm_qty'] = '';
            $data['reinvm_status'] = '';
            $data['valid'] = $row->valid;
            $data['commission_status'] = $row->commission_status;

            DB::table('pro_sid_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Sales Invoice Details";
});

//Delivery Challan master
Route::get('/move_delivery_chalan_master', function () {

    $old_customer = DB::table('bpack_delivery_chalan_master')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_delivery_chalan_master_1')->where('delivery_chalan_master_id', $row->delivery_chalan_master_id)->first();
        if ($check == null) {
            $data = array();
            $data['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
            $data['company_id'] = '1';
            $data['dcm_date'] = $row->dcm_date;
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['customer_id'] = $row->customer_id;
            $data['delivery_address'] = $row->delivery_address;
            $data['ifb_no'] = $row->ifb_no;
            $data['ifb_date'] = $row->ifb_date;
            $data['contract_no'] = $row->contract_no;
            $data['contract_date'] = $row->contract_date;
            $data['allocation_no'] = $row->allocation_no;
            $data['allocation_date'] = $row->allocation_date;
            $data['pono_ref'] = $row->pono_ref;
            $data['pono_ref_date'] = $row->pono_ref_date;
            // $data['mushok_no']=$row->mushok_no;
            $data['truck_no'] = $row->truck_no;
            $data['driver_name'] = $row->driver_name;
            $data['status'] = $row->status;
            // $data['gp_status']=$row->gp_status;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            DB::table('pro_delivery_chalan_master_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Delivery Challan Master";
});

//Delivery Challan Details
Route::get('/move_delivery_chalan_details', function () {

    $old_customer = DB::table('bpack_delivery_chalan_details')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_delivery_chalan_details_1')->where('delivery_chalan_details_id', $row->delivery_chalan_details_id)->first();
        if ($check == null) {
            $data = array();
            $data['delivery_chalan_details_id'] = $row->delivery_chalan_details_id;
            $data['company_id'] = '1';
            $data['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
            $data['sim_id'] = $row->sim_id;
            $data['customer_id'] = $row->customer_id;
            $data['customer_id'] = $row->customer_id;
            $data['product_id'] = $row->product_id;
            $data['del_qty'] = $row->del_qty;
            $data['status'] = $row->status;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            DB::table('pro_delivery_chalan_details_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Delivery Challan Details";
});

//Gate Pass Master
Route::get('/move_gate_pass_master', function () {

    $old_customer = DB::table('bpack_gate_pass_master')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_gate_pass_master_1')->where('gate_pass_master_id', $row->gate_pass_master_id)->first();
        if ($check == null) {
            $data = array();
            // $data['gate_pass_id']= $row->gate_pass_id;
            $data['gate_pass_master_id'] = $row->gate_pass_master_id;
            $data['gate_pass_date'] = $row->gate_pass_date;
            $data['company_id'] = '1';
            $data['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
            $data['dcm_date'] = $row->dcm_date;
            $data['sim_id'] = $row->sim_id;
            $data['sim_date'] = $row->sim_date;
            $data['customer_id'] = $row->customer_id;
            $data['delivery_address'] = $row->delivery_address;
            $data['vat_no'] = $row->vat_no;
            $data['status'] = $row->status;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            DB::table('pro_gate_pass_master_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Gate Pass Master";
});

//Gate Pass Details
Route::get('/move_gate_pass_details', function () {

    $old_customer = DB::table('bpack_gate_pass_details')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_gate_pass_details_1')->where('gate_pass_details_id', $row->gate_pass_details_id)->first();
        if ($check == null) {
            $data = array();
            $data['gate_pass_details_id'] = $row->gate_pass_details_id;
            $data['gate_pass_master_id'] = $row->gate_pass_master_id;
            $data['company_id'] = '1';
            $data['delivery_chalan_details_id'] = $row->delivery_chalan_details_id;
            $data['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
            $data['sim_id'] = $row->sim_id;
            $data['customer_id'] = $row->customer_id;
            $data['product_id'] = $row->product_id;
            $data['del_qty'] = $row->del_qty;
            $data['status'] = $row->status;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            DB::table('pro_gate_pass_details_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Gate Pass Details";
});

//Return Invoice Master
Route::get('/move_return_invoice_master', function () {

    $old_customer = DB::table('bpack_rim')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_return_invoice_master_1')->where('reinvm_id', $row->reinvm_id)->first();
        if ($check == null) {
            $data = array();
            $data['reinvm_id'] = $row->reinvm_id;
            $data['reinvm_date'] = $row->reinvm_date;
            $data['company_id'] = '1';
            $data['customer_id'] = $row->customer_id;
            $data['cust_sppl'] = $row->cust_sppl;
            // $data['sim_id']= $row->sim_id;
            // $data['sim_date']=$row->sim_date;
            // $data['mushok_no']=$row->mushok_no;
            // $data['pono_ref']=$row->pono_ref;
            // $data['pono_ref_date']=$row->pono_ref_date;
            $data['pg_id'] = $row->pg_id;
            $data['product_id'] = $row->product_id;
            $data['repair_qty'] = $row->repair_qty;
            $data['repair_date'] = $row->repair_date;
            $data['serial_no'] = $row->serial_no;
            $data['sold_date'] = $row->sold_date;
            $data['recived_date'] = $row->recived_date;
            $data['mr_id'] = $row->mr_id;
            $data['reinv_total'] = $row->reinv_total;
            $data['remarks'] = $row->remarks;
            $data['user_id'] = $row->user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;
            DB::table('pro_return_invoice_master_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Return Invoice Master";
});


//Return Invoice Details
Route::get('/move_return_invoice_details', function () {

    $old_customer = DB::table('bpack_rid')->get();

    foreach ($old_customer as $row) {
        $check = DB::table('pro_return_invoice_details_1')->where('reinvd_id', $row->reinvd_id)->first();
        if ($check == null) {
            $data = array();
            $data['reinvd_id'] = $row->reinvd_id;
            $data['reinvm_id'] = $row->reinvm_id;
            $data['reinvm_date'] = $row->reinvm_date;
            $data['company_id'] = '1';
            $data['customer_id'] = $row->customer_id;
            // $data['sim_id']= $row->sim_id;
            // $data['sim_date']=$row->sim_date;
            $data['pg_id'] = $row->pg_id;
            $data['product_id'] = $row->product_id;
            $data['unit'] = $row->unit;
            // $data['sales_qty']=$row->sales_qty;
            $data['qty'] = $row->qty;
            $data['unit_price'] = $row->unit_price;
            $data['total'] = $row->total;
            // $data['vat_amount']=$row->vat_amount;
            // $data['discount']=$row->discount;
            // $data['depreciation']=$row->depreciation;
            // $data['net_payble']=$row->net_payble;
            // $data['remarks']=$row->remarks;
            $data['user_id'] = $row->user_id;
            // $data['update_user_id']=$row->update_user_id;
            $data['entry_date'] = $row->entry_date;
            $data['entry_time'] = $row->entry_time;
            $data['valid'] = $row->valid;
            $data['status'] = $row->status;
            // $data['damage_status']=$row->damage_status;
            DB::table('pro_return_invoice_details_1')->insert($data);
        } //if($check == null)
    } //foreach($old_customer as $row)

    return "Done Return Invoice Details";
});


//Update Bank for sales
Route::get('/update_bank', function () {

    $new_bank_id = '0';
    $old_bank_id = "0";

    $datas = DB::table('pro_money_receipt_1')
        ->where('bank_id', $old_bank_id)
        ->get();



    foreach ($datas as $key => $row) {
        DB::table('pro_money_receipt_1_temp')
            ->insert([
                'mr_id' => $row->mr_id,
                'company_id' => $row->company_id,
                'collection_date' => $row->collection_date,
                'mr_master_id' => $row->mr_master_id,
                'pg_id' => $row->pg_id,
                'sim_id' => $row->sim_id,
                'sim_date' => $row->sim_date,
                'customer_id' => $row->customer_id,
                'cust_sppl' => $row->cust_sppl,
                'rate_policy_id' => $row->rate_policy_id,
                'sinv_total' => $row->sinv_total,
                'dt_price' => $row->dt_price,
                'transport_fee' => $row->transport_fee,
                'test_fee' => $row->test_fee,
                'other_fee' => $row->other_fee,
                'mr_amount' => $row->mr_amount,
                'receive_amount_inword' => $row->receive_amount_inword,
                'discount_amount' => $row->discount_amount,
                'cr_amount' => $row->cr_amount,
                'payment_type' => $row->payment_type,
                'receive_type' => $row->receive_type,
                'bank_id' => $new_bank_id,
                'chq_po_dd_no' => $row->chq_po_dd_no,
                'chq_po_dd_date' => $row->chq_po_dd_date,
                'remarks' => $row->remarks,
                'sinv_user_id' => $row->sinv_user_id,
                'user_id' => $row->user_id,
                'entry_date' => $row->entry_date,
                'entry_time' => $row->entry_time,
                'valid' => $row->valid,
                'status' => $row->status,
                'sales_type' => $row->sales_type
            ]);
    }


    return "update bank success";
});

//Update attendance_0524
Route::get('/update_attendance', function () {

    $m_employee_info = DB::table('pro_employee_info')
        ->where('valid', '1')
        ->where('working_status', '1')
        ->where('ss', '1')
        ->orderBy('employee_id', 'asc')
        ->get();

    // $old_customer = DB::table('pro_quotation_master_1')->get();

    foreach ($m_employee_info as $row) {
        $data['placeofposting_sub_id'] = $row->placeofposting_sub_id;
        DB::table('pro_attendance_0524')
            ->where('employee_id', $row->employee_id)
            ->update($data);
    } //foreach($m_employee_info as $row)
    return "update attendance success";
});

Route::get('/update_deed_doc_file', function () {

    $datas = DB::table('pro_doc_file')
        ->get();



    foreach ($datas as $key => $row) {

        $master =   DB::table('pro_deed_master')
            ->where('deed_no', $row->deed_no)
            ->first();

        if ($master && $master->moujas_id) {
            DB::table('pro_doc_file')
                ->where('doc_file_id', $row->doc_file_id)
                ->update([
                    'moujas_id' => $master->moujas_id,
                ]);
        }
    }


    return "update success";
});

//Update Summery attendance
Route::get('/update_summery_attendance', function () {

    $m_employee_info = DB::table('pro_summ_attn_details')
        ->where('valid', '1')
        ->where('month', '09')
        ->where('year', '2024')
        ->get();

    // $old_customer = DB::table('pro_quotation_master_1')->get();

    foreach ($m_employee_info as $row) {
        $data['absent'] = $row->absent - 1;
        DB::table('pro_summ_attn_details')
            ->where('valid', '1')
            ->where('month', '09')
            ->where('year', '2024')
            ->where('employee_id', $row->employee_id)
            ->update($data);
    } //foreach($m_employee_info as $row)
    return "update attendance success";
});


//Update RR master
Route::get('/update_rr_master', function () {

    $form = "2024-11-01";
    $to = "2024-11-09";

    $m_rr = DB::table('pro_grr_master_1')
        ->whereBetween('grr_date', [$form, $to])
        ->get();


    foreach ($m_rr as $row) {
        $new_grr_no = "RR2410" . substr($row->grr_no, -5);
        $data['grr_no'] = $new_grr_no;
        $data['grr_date'] = '2024-10-31';

        DB::table('pro_grr_master_1')
            ->where('grr_no', $row->grr_no)
            ->update($data);
    }
    return "update rr master successfull";
});

//Update RR details
Route::get('/update_rr_details', function () {

    $form = "2024-11-01";
    $to = "2024-11-09";

    $m_rr = DB::table('pro_grr_details_1')
        ->whereBetween('grr_date', [$form, $to])
        ->get();


    foreach ($m_rr as $row) {
        $new_grr_no = "RR2410" . substr($row->grr_no, -5);
        $data['grr_no'] = $new_grr_no;
        $data['grr_date'] = '2024-10-31';

        DB::table('pro_grr_details_1')
            ->where('grr_no', $row->grr_no)
            ->update($data);
    }
    return "update rr details successfull";
});

//Update Requisition master
Route::get('/update_req_master', function () {

    $form = "2024-11-01";
    $to = "2024-11-09";

    $m_req = DB::table('pro_gmaterial_requsition_master_1')
        ->whereBetween('mrm_date', [$form, $to])
        ->get();


    foreach ($m_req as $row) {
        $new_mrm_no = "202410" . substr($row->mrm_no, -5);
        $data['mrm_no'] = $new_mrm_no;
        $data['mrm_date'] = '2024-10-31';

        DB::table('pro_gmaterial_requsition_master_1')
            ->where('mrm_no', $row->mrm_no)
            ->update($data);
    }
    return "update Requisition master successfull";
});

//Update Requisition details
Route::get('/update_req_details', function () {

    $form = "2024-11-01";
    $to = "2024-11-09";

    $m_req = DB::table('pro_gmaterial_requsition_details_1')
        ->whereBetween('mrm_date', [$form, $to])
        ->get();


    foreach ($m_req as $row) {
        $new_mrm_no = "202410" . substr($row->mrm_no, -5);
        $data['mrm_no'] = $new_mrm_no;
        $data['mrm_date'] = '2024-10-31';

        DB::table('pro_gmaterial_requsition_details_1')
            ->where('mrm_no', $row->mrm_no)
            ->update($data);
    }
    return "update Requisition details successfull";
});

//Update Issue master
Route::get('/update_issue_master', function () {

    $form = "2024-11-01";
    $to = "2024-11-09";

    $m_rim = DB::table('pro_graw_issue_master_1')
        ->whereBetween('rim_date', [$form, $to])
        ->get();


    foreach ($m_rim as $row) {
        $new_rim_no = "IM2410" . substr($row->rim_no, -5);
        $new_mrm_no = "202410" . substr($row->mrm_no, -5);
        $data['rim_no'] = $new_rim_no;
        $data['rim_date'] = '2024-10-31';
        $data['mrm_no'] = $new_mrm_no;
        $data['mrm_date'] = '2024-10-31';

        DB::table('pro_graw_issue_master_1')
            ->where('rim_no', $row->rim_no)
            ->update($data);
    }
    return "update Issue master successfull";
});

//Update issue details
Route::get('/update_issue_details', function () {

    $form = "2024-11-01";
    $to = "2024-11-09";

    $m_rid = DB::table('pro_graw_issue_details_1')
        ->whereBetween('rim_date', [$form, $to])
        ->get();


    foreach ($m_rid as $row) {
        $new_rim_no = "IM2410" . substr($row->rim_no, -5);
        $new_mrm_no = "202410" . substr($row->mrm_no, -5);
        $data['rim_no'] = $new_rim_no;
        $data['rim_date'] = '2024-10-31';
        $data['mrm_no'] = $new_mrm_no;
        $data['mrm_date'] = '2024-10-31';


        DB::table('pro_graw_issue_details_1')
            ->where('rim_no', $row->rim_no)
            ->update($data);
    }
    return "update issue details successfull";
});

//Create chalan No check
Route::get('/challan_check', function () {

    $form = "2017-11-01";

    $challan = DB::table('pro_delivery_chalan_master_1')
        ->where('dcm_date', ">", $form)
        ->select('pro_delivery_chalan_master_1.delivery_chalan_master_id')
        ->orderByDesc('delivery_chalan_master_id')
        ->get();

    $data2 = array();
    foreach ($challan as $row) {
        if (strlen($row->delivery_chalan_master_id) < 15) {
            array_push($data2, $row->delivery_chalan_master_id);
        }
    }
    return $data2;
});



//Get Last Five Minit User
Route::get('/user_activity', function () {
    $lastFiveMinit = date('Y-m-d H:i:s', time() - 300);
    $onlineUsers = DB::table('users')->where('last_activity', '>=', $lastFiveMinit)->count(); 
    return $onlineUsers;
});



//Vicar Electricals Limited

//Get Indent Master
Route::get('/get_indent_master', function () {
$indent_master_all = DB::table('bpack_indent_master')->get();
foreach($indent_master_all as $value){
    $data = array();
    $data['indent_id'] = $value->indent_id ;
    $data['company_id'] = 21;
    $data['indent_no'] = $value->indent_no ;
    $data['project_id'] = '';
    $data['indent_category'] = $value->indent_category;
    $data['qc_status'] = $value->qc_status;
    $data['rr_status'] = $value->rr_status;
    $data['cancel_status'] = $value->cancel_status;
    $data['user_id'] = $value->user_id;
    $data['entry_date'] = $value->entry_date;
    $data['entry_time'] = $value->entry_time;
    $data['status'] = $value->status;
    $data['valid'] = $value->valid;
    $data['in_status'] = '';
    DB::table('pro_indent_master_21')->insert($data);
}
return "Indent Master Add Successfully";

});


//Get Indent Details
Route::get('/get_indent_details', function () {
    $indent_details_all = DB::table('bpack_indent_details')->get();
    foreach($indent_details_all as $value){
        $data = array();
        $data['indent_details_id'] = $value->indent_details_id ;
        $data['indent_no'] = $value->indent_no;
        $data['company_id'] = 21;
        $data['project_id'] = '';
        $data['indent_category'] = $value->indent_category;
        $data['pg_sub_id'] = '';
        $data['product_id'] = $value->product_id;
        $pr_unit = DB::table('pro_product_21')->where('product_id',$value->product_id)->first();
        if($pr_unit){
            $data['pg_id'] = $pr_unit->pg_id;
            $data['product_unit'] = $pr_unit->unit;
        }else{
            $data['pg_id'] = '';
            $data['product_unit'] = ''; 
        }
        $data['description'] = $value->description;
        $data['section_id'] = $value->branch_id;
        $data['qty'] = $value->qty;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['status'] = $value->status;
        $data['approved_qty'] = $value->approved_qty;
        $data['approved_by'] = $value->approved_by;
        $data['approved_date'] = $value->approved_date;
        $data['approved_time'] = $value->approved_time;
        $data['remarks'] = $value->remarks;
        $data['estimate_unit_price'] = $value->estimate_unit_price;
        $data['one_year_average_rate'] = $value->one_year_average_rate;
        $data['last_three_average_rate'] = $value->last_three_average_rate;
        $data['valid'] = $value->valid;
        $data['qc_status'] = $value->qc_status;
        $data['rr_status'] = $value->rr_status;
        $data['cancel_status'] = $value->cancel_status;
        $data['qc_qty'] = $value->qc_qty;
        $data['rr_qty'] = $value->rr_qty;
        $data['in_status'] = '';
        $data['req_date'] = '';
        DB::table('pro_indent_details_21')->insert($data);
    }
    return "Indent Details Add Successfully";
    
    });


//Get RR Master
Route::get('/get_rr_master', function () {
    $indent_master_all = DB::table('bpack_rr_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['grr_master_id'] = $value->rr_master_id;
        $data['company_id'] = 21;
        $data['grr_no'] = $value->rr_no ;
        $data['old_grr_no'] = '';
        $data['grr_date'] = $value->rr_date;
        $data['supplier_id'] = $value->supplier_id;
        $data['referance'] = $value->referance;
        $data['gqc_no'] = $value->qc_no;
        $data['gqc_date'] = $value->qc_date;
        $data['gpom_no'] = $value->po_no;
        $data['gpom_date'] = $value->po_date;
        $data['project_id'] = '';
        $data['indent_category'] = '';
        $data['indent_no'] = $value->indent_no;
        $data['indent_date'] = $value->indent_date;
        $data['glc_no'] = $value->lc_no;
        $data['glc_date'] = $value->lc_date;
        $data['chalan_no'] = $value->chalan_no;
        $data['chalan_date'] = $value->chalan_date;
        $data['trnsport_company'] = $value->trnsport_company;
        $data['transport_no'] = $value->transport_no;
        $data['remarks'] = $value->remarks;
        $data['status'] = $value->status;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['final_date'] = $value->final_date;
        $data['final_time'] = $value->final_time;
        $data['valid'] = $value->valid;
        $data['bill_adjust'] = '';
        $data['bill_status'] = '';
        $data['price_status'] = '';
        $data['in_status'] = '';
        DB::table('pro_grr_master_21')->insert($data);
    }
    return "RR Master Add Successfully";
    
});

//Get RR Details
Route::get('/get_rr_details', function () {
    $indent_master_all = DB::table('bpack_rr_details')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['grr_details_id'] = $value->rr_details_id;
        $data['company_id'] = 21;
        $data['grr_no'] = $value->rr_no;
        $data['old_grr_no'] = '';
        $data['grr_date'] = $value->rr_date;
        $data['gqc_no'] = $value->qc_no;
        $data['gqc_date'] = $value->qc_date;
        $data['gpom_no'] = $value->po_no;
        $data['gpom_date'] = $value->po_date;
        $data['project_id'] = '';
        $data['indent_category'] = '';
        $data['indent_no'] = $value->indent_no;
        $data['indent_date'] = $value->indent_date;
        $data['indent_details_id'] = '';
        $data['glc_no'] = '';
        $data['glc_date'] = '';
        $data['chalan_no'] = $value->chalan_no;
        $data['chalan_date'] = $value->chalan_date;
        $data['pg_sub_id'] = '';
        $data['product_id'] = $value->product_id;
        $data['p_order_qty'] = $value->p_order_qty;
        $data['indent_qty'] = '';
        $data['received_qty'] = $value->received_qty;
        $pr_unit = DB::table('pro_product_21')->where('product_id',$value->product_id)->first();
        if($pr_unit){
            $data['pg_id'] = $pr_unit->pg_id;
            $data['unit'] = $pr_unit->unit;
        }else{
            $data['pg_id'] = '';
            $data['unit'] = ''; 
        }
        $data['product_rate'] = $value->product_rate;
        $data['received_total'] = $value->received_total;
        $data['remarks'] = $value->remarks;
        $data['status'] = '';
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['bill_adjust'] = '';
        $data['price_status'] = '';
        $data['in_status'] = '';
        $data['price_user_id'] = '';
        $data['price_entry_date'] = '';
        $data['price_entry_time'] = '';
        DB::table('pro_grr_details_21')->insert($data);
    }
    return "RR Details Add Successfully";
    
});



//Get Material Requsition Master
Route::get('/get_material_requsition_master', function () {
    $indent_master_all = DB::table('bpack_material_requsition_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['mrm_no'] = $value->mrm_no;
        $data['mrm_date'] = '';
        $data['company_id'] = 21;
        $data['project_id'] = '';
        $data['section_id'] = $value->branch_id ;
        $data['mrm_serial_no'] = $value->mrm_serial_no ;
        $data['mrm_serial_date'] = $value->mrm_serial_date ;
        $data['jo_no'] = '' ;
        $data['jo_date'] = '' ;
        $data['remarks'] = $value->remarks ;
        $data['status'] = $value->status;
        $data['issue_status'] = '';
        $data['cancel_status'] = '';
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_gmaterial_requsition_master_21')->insert($data);
    }
    return "Material Requsition Master Add Successfully";
    
});


//Get Material Requsition Details
Route::get('/get_material_requsition_details', function () {
    $indent_master_all = DB::table('bpack_material_requsition_details')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['mrd_id'] = $value->mrd_id;
        $data['mrm_no'] = $value->mrm_no;
        $data['mrm_date'] = $value->mrm_date;
        $data['company_id'] = 21;
        $data['project_id'] = '';
        $data['section_id'] = '' ;
        $data['jo_no'] = '' ;
        $data['jo_date'] = '' ;
        $pr_unit = DB::table('pro_product_21')->where('product_id',$value->product_id)->first();
        if($pr_unit){
            $data['pg_id'] = $pr_unit->pg_id;
        }else{
            $data['pg_id'] = '';
        }
        $data['pg_sub_id'] = '';
        $data['product_id'] = $value->product_id;
        $data['product_unit'] = $value->product_unit;
        $data['requsition_qty'] = $value->product_qty;
        $data['remarks'] = $value->remarks ;
        $data['status'] = $value->status;
        $data['approved_qty'] = $value->product_qty; //sire ke jigas korte hove
        $data['approved_by'] = ''; 
        $data['approved_date'] = ''; 
        $data['approved_time'] = ''; 
        $data['approved_remarks'] = ''; 
        $data['issue_qty'] = ''; 
        $data['issue_status'] = '';
        $data['cancel_status'] = '';
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_gmaterial_requsition_details_21')->insert($data);
    }
    return "Material Requsition Details Add Successfully";
    
});

//Get Issue Master
Route::get('/get_issue_master', function () {
    $indent_master_all = DB::table('bpack_graw_issue_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['rim_no'] = $value->rim_no;
        $data['rim_date'] = '';
        $data['company_id'] = 21;
        $data['project_id'] = '';
        $data['section_id'] = $value->branch_id ;
        $data['mrm_no'] = $value->mrm_serial_no ;
        $data['mrm_date'] = $value->mrm_serial_date ;
        $data['job_no'] = '' ;
        $data['job_date'] = '' ;
        $data['status'] = $value->status;
        $data['remrks'] = '';
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_graw_issue_master_21')->insert($data);
    }
    return "Issue Master Add Successfully";
    
});

//Get Issue Details
Route::get('/get_issue_details', function () {
    $indent_master_all = DB::table('bpack_graw_issue_details')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['rid_id'] = $value->rid_id ;
        $data['rim_no'] = $value->rim_no ;
        $data['rim_date'] = '';
        $data['company_id'] = 21;
        $data['project_id'] = '';
        $data['section_id'] = '';
        $data['mrm_no'] = $value->mrm_no;
        $data['mrm_date'] = '' ;
        $data['mrd_id'] = $value->mrd_id;
        $data['job_no'] = '' ;
        $data['job_date'] = '' ;
        $data['pg_sub_id'] = '';
        $data['product_id'] = $value->product_id;
        $data['product_qty'] = $value->product_qty;
        $pr_unit = DB::table('pro_product_21')->where('product_id',$value->product_id)->first();
        if($pr_unit){
            $data['pg_id'] = $pr_unit->pg_id;
            $data['product_unit'] = $pr_unit->unit;
        }else{
            $data['pg_id'] ='';
            $data['unit'] = ''; 
        }
        $data['remarks'] = $value->remarks;
        $data['status'] = '';
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_graw_issue_details_21')->insert($data);
    }
    return "Issue Details Add Successfully";
    
});


//Get Money Receipt 01
Route::get('/get_money_receipt_01', function () {
    $indent_master_all = DB::table('bpack_money_receipt_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['mr_master_id'] = $value->mr_master_id;
        $data['company_id'] = 21;
        $data['sales_type'] = $value->sales_type;
        $data['mr_total'] = $value->mr_total;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        DB::table('pro_money_receipt_master_21')->insert($data);
    }
    return "Money Receipt Master Add Successfully";
    
});

//Get Money Receipt 02
Route::get('/get_money_receipt_02', function () {
    $indent_master_all = DB::table('bpack_money_receipt')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['mr_id'] = $value->mr_id;
        $data['company_id'] = 21;
        $data['collection_date'] = '';
        $data['mr_master_id'] = $value->mr_master_id;
        $data['pg_id'] = $value->pg_id;
        $data['sim_id'] = $value->sim_id;
        $data['sim_date'] = $value->sim_date;
        $data['customer_id'] = $value->customer_id;
        $data['cust_sppl'] = $value->cust_sppl;
        $data['rate_policy_id'] = $value->rate_policy_id;
        $data['sinv_total'] = $value->sinv_total;
        $data['dt_price'] = $value->dt_price;
        $data['transport_fee'] = $value->transport_fee;
        $data['test_fee'] = $value->test_fee;
        $data['other_fee'] = $value->other_fee;
        $data['mr_amount'] = $value->mr_amount;
        $data['receive_amount_inword'] = $value->receive_amount_inword;
        $data['discount_amount'] = $value->discount_amount;
        $data['cr_amount'] = $value->cr_amount;
        $data['payment_type'] = $value->payment_type;
        $data['receive_type'] = $value->receive_type;
        $data['bank_id_old'] = '';
        $data['bank_id'] = $value->bank_id;
        $data['chq_po_dd_no'] = $value->chq_po_dd_no;
        $data['chq_po_dd_date'] = $value->chq_po_dd_date;
        $data['remarks'] = $value->remarks;
        $data['sinv_user_id'] = $value->sinv_user_id;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        $data['sales_type'] = $value->sales_type;
        DB::table('pro_money_receipt_21')->insert($data);
    }
    return "Money Receipt 02 Add Successfully";
    
});

//Get Debit Voucher
Route::get('/get_debit_voucher', function () {
    $indent_master_all = DB::table('bpack_debit_voucher')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['debit_voucher_id'] = $value->debit_voucher_id ;
        $data['debit_voucher_date'] = $value->debit_voucher_date;
        $data['company_id'] = 21;
        $data['mr_id'] = $value->mr_id;
        $data['mr_date'] = $value->mr_date;
        $data['customer_id'] = $value->customer_id;
        $data['accounts_name'] = $value->accounts_name;
        $data['name'] = $value->name;
        $data['details'] = $value->details;
        $data['amount'] = $value->amount;
        $data['tr_amount'] = $value->tr_amount;
        $data['cr_amount'] = $value->cr_amount;
        $data['cash_book_no'] = $value->cash_book_no;
        $data['page_no'] = $value->page_no;
        $data['folio_no'] = $value->folio_no;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_debit_voucher_21')->insert($data);
    }
    return "Debit Voucher Add Successfully";
    
});

//Get Sim Master
Route::get('/get_sim_master', function () {
    $indent_master_all = DB::table('bpack_sim')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['sim_id'] = $value->sim_id ;
        $data['company_id'] = 21;
        $data['sim_date'] = $value->sim_date;
        $data['customer_id'] = $value->customer_id;
        $data['cust_sppl'] = $value->cust_sppl;
        $data['customer_type_id'] = '';
        $data['pg_id'] = $value->pg_id;
        $data['ref_name'] = $value->ref_name;
        $data['ref_mobile'] = $value->ref_mobile;
        $data['mushok_no'] = $value->mushok_no;
        $data['ifb_no'] = $value->ifb_no;
        $data['ifb_date'] = $value->ifb_date;
        $data['contract_no'] = $value->contract_no;
        $data['contract_date'] = $value->contract_date;
        $data['allocation_no'] = $value->allocation_no;
        $data['allocation_date'] = $value->allocation_date;
        $data['pono_ref'] = $value->pono_ref;
        $data['pono_ref_date'] = $value->pono_ref_date;
        $data['status'] = $value->status;
        $data['sinv_total'] = $value->sinv_total;
        $data['money_receipt_no'] = $value->money_receipt_no;
        $data['sales_type'] = $value->sales_type;
        $data['discount_amount'] = $value->discount_amount;
        $data['tr_discount_amount'] = $value->tr_discount_amount;
        $data['transport_cost'] = $value->transport_cost;
        $data['test_fee'] = $value->test_fee;
        $data['other_expense'] = $value->other_expense;
        $data['total'] = $value->total;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['tto_status'] = $value->tto_status;
        $data['dcs_status'] = '';
        $data['reinvm_status'] = '';
        $data['rsim_qty'] = '';
        $data['rsim_status'] = '';
        DB::table('pro_sim_21')->insert($data);
    }
    return "Sim Master Add Successfully";
    
});

//Get Sim Details
Route::get('/get_sim_details', function () {
    $indent_master_all = DB::table('bpack_sid')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['sid_id'] = $value->sid_id ;
        $data['company_id'] = 21;
        $data['sim_id'] = $value->sim_id;
        $data['sim_date'] = $value->sim_date;
        $data['customer_id'] = $value->customer_id;
        $data['cust_sppl'] = $value->cust_sppl;
        $data['customer_type_id'] = '';
        $data['vendor_id'] = $value->vendor_id;
        $data['auth_ref_no'] = $value->auth_ref_no;
        $data['pg_id'] = $value->pg_id;
        $data['product_id'] = $value->product_id;
        $data['qty'] = $value->qty;
        $data['rate'] = $value->rate;
        $data['rate_policy_id'] = $value->rate_policy_id;
        $data['discount_rate'] = $value->discount_rate;
        $data['total_discount'] = $value->total_discount;
        $data['transport_rate'] = $value->transport_rate;
        $data['total_transport'] = $value->total_transport;
        $data['total'] = $value->total;
        $data['remarks'] = $value->remarks;
        $data['status'] = $value->status;
        $data['deliver_no'] = $value->deliver_no;
        $data['deliver_date'] = $value->deliver_date;
        $data['deliver_qty'] = $value->deliver_qty;
        $data['cash_fac'] = $value->cash_fac;
        $data['cash_ho'] = $value->cash_ho;
        $data['bybank'] = $value->bybank;
        $data['through_bank'] = $value->through_bank;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['commission_status'] = $value->commission_status;
        $data['dcs_qty'] = '';
        $data['dcs_status'] = '';
        $data['reinvm_qty'] = '';
        $data['reinvm_status'] = '';
        $data['rsim_qty'] = '';
        $data['rsim_status'] = '';
        DB::table('pro_sid_21')->insert($data);
    }
    return "Sim Details Add Successfully";
    
});


//Get Rate Policy
Route::get('/get_rate_policy', function () {
    $indent_master_all = DB::table('bpack_rate_policy')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['rate_policy_id'] = $value->rate_policy_id  ;
        $data['company_id'] = 21;
        $data['rate_policy_name'] = $value->rate_policy_name;
        $data['rate_group'] = $value->rate_group;
        $data['discount_type'] = $value->discount_type;
        $data['discount'] = $value->discount;
        $data['remarks'] = $value->remarks;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_rate_policy_21')->insert($data);
    }
    return "Rate Policy Add Successfully";
    
});

//Get Rate Chart
Route::get('/get_rate_chart', function () {
    $indent_master_all = DB::table('bpack_rate_chart')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['rate_chart_id'] = $value->rate_chart_id ;
        $data['company_id'] = 21;
        $data['rate_group'] = $value->rate_group;
        $data['product_id'] = $value->product_id;
        $data['rate'] = $value->rate;
        $data['remarks'] = $value->remarks;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_rate_chart_21')->insert($data);
    }
    return "Rate Chart Add Successfully";
    
});


//Get Mushok
Route::get('/get_mushok', function () {
    $indent_master_all = DB::table('bpack_mushok')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['mushok_id'] = $value->mushok_id;
        $data['mushok_number'] = $value->mushok_number;
        $data['company_id'] = 21;
        $data['financial_year_id'] = $value->financial_year_id;
        $data['financial_year_name'] = $value->financial_year_name;
        $data['sim_id'] = $value->sim_id;
        $data['sim_date'] = $value->sim_date;
        $data['pg_id'] = $value->pg_id;
        $data['delivery_chalan_master_id'] = $value->delivery_chalan_master_id;
        $data['dcm_date'] = $value->dcm_date;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_mushok_21')->insert($data);
    }
    return "Mushok Add Successfully";
    
});

//Get Finish Product Serial
Route::get('/get_finish_product_serial', function () {
    $indent_master_all = DB::table('bpack_finish_product_serial')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['serial_id'] = $value->serial_id;
        $data['company_id'] = 21;
        $data['id'] = $value->id;
        $data['pg_id'] = $value->pg_id;
        $data['product_id'] = $value->product_id;
        $data['serial_no'] = $value->serial_no;
        $data['sim_id'] = $value->sim_id;
        $data['sim_date'] = $value->sim_date;
        $data['sid_id'] = $value->sid_id;
        $data['customer_id'] = $value->customer_id;
        $data['sinv_user_id'] = $value->sinv_user_id;
        $data['delivery_chalan_master_id'] = $value->delivery_chalan_master_id;
        $data['delivery_chalan_details_id'] = $value->delivery_chalan_details_id;
        $data['rsim_id'] = $value->rsim_id;
        $data['rsid_id'] = $value->rsid_id;
        $data['dcd_date'] = $value->rsid_id;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        $data['year'] = '';
        DB::table('pro_finish_product_serial_21')->insert($data);
    }
    return "Finish Product Add Successfully";
    
});

//Get Delivery challan master
Route::get('/get_delivery_challan_master', function () {
    $indent_master_all = DB::table('bpack_delivery_chalan_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['delivery_chalan_master_id'] = $value->delivery_chalan_master_id ;
        $data['dcm_date'] = $value->dcm_date ;
        $data['company_id'] = 21;
        $data['sim_id'] = $value->sim_id;
        $data['sim_date'] = $value->sim_date;
        $data['customer_id'] = $value->customer_id;
        $data['delivery_address'] = $value->delivery_address;
        $data['ifb_no'] = $value->ifb_no;
        $data['ifb_date'] = $value->ifb_date;
        $data['contract_no'] = $value->contract_no;
        $data['contract_date'] = $value->contract_date;
        $data['allocation_no'] = $value->allocation_no;
        $data['allocation_date'] = $value->allocation_date;
        $data['pono_ref'] = $value->pono_ref;
        $data['pono_ref_date'] = $value->pono_ref_date;
        $data['mushok_no'] ='';
        $data['truck_no'] = $value->truck_no;
        $data['driver_name'] = $value->driver_name;
        $data['status'] = $value->status;
        $data['gp_status'] = '';
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_delivery_chalan_master_21')->insert($data);
    }
    return "Delivery Challan Master Add Successfully";
    
});

//Get Delivery challan Details
Route::get('/get_delivery_challan_details', function () {
    $indent_master_all = DB::table('bpack_delivery_chalan_details')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['delivery_chalan_details_id'] = $value->delivery_chalan_details_id ;
        $data['delivery_chalan_master_id'] = $value->delivery_chalan_master_id ;
        $data['company_id'] = 21;
        $data['sim_id'] = $value->sim_id;
        $data['customer_id'] = $value->customer_id;
        $data['product_id'] = $value->product_id;
        $data['del_qty'] = $value->del_qty;
        $data['status'] = $value->status;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_delivery_chalan_details_21')->insert($data);
    }
    return "Delivery Challan Details Add Successfully";
    
});

//Get GatePass Master
Route::get('/get_getpass_master', function () {
    $indent_master_all = DB::table('bpack_gate_pass_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['gate_pass_master_id'] = $value->gate_pass_master_id ;
        $data['gate_pass_date'] = $value->gate_pass_date ;
        $data['company_id'] = 21;
        $data['delivery_chalan_master_id'] = $value->delivery_chalan_master_id;
        $data['dcm_date'] = $value->dcm_date;
        $data['sim_id'] = $value->sim_id;
        $data['sim_date'] = $value->sim_date;
        $data['customer_id'] = $value->customer_id;
        $data['delivery_address'] = $value->delivery_address;
        $data['vat_no'] = $value->vat_no;
        $data['status'] = $value->status;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_gate_pass_master_21')->insert($data);
    }
    return "GatePass Master Add Successfully";
    
});

//Get GatePass Details
Route::get('/get_getpass_details', function () {
    $indent_master_all = DB::table('bpack_gate_pass_details')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['gate_pass_details_id'] = $value->gate_pass_details_id  ;
        $data['gate_pass_master_id'] = $value->gate_pass_master_id ;
        $data['company_id'] = 21;
        $data['delivery_chalan_details_id'] = $value->delivery_chalan_details_id;
        $data['delivery_chalan_master_id'] = $value->delivery_chalan_master_id;
        $data['sim_id'] = $value->sim_id;
        $data['customer_id'] = $value->customer_id;
        $data['product_id'] = $value->product_id;
        $data['del_qty'] = $value->del_qty;
        $data['status'] = $value->status;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_gate_pass_details_21')->insert($data);
    }
    return "GatePass Details Add Successfully";
    
});

//Get quotation master
Route::get('/get_quotation_master', function () {
    $indent_master_all = DB::table('bpack_quotation_master')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['company_id'] = 21;
        $data['quotation_master_id'] = $value->quotation_master_id ;
        $data['quotation_date'] = $value->quotation_date;
        $data['customer_name'] = $value->customer_name;
        $data['customer_address'] = $value->customer_address;
        $data['customer_mobile'] = $value->customer_mobile;
        $data['subject'] = $value->subject;
        $data['offer_valid'] = $value->offer_valid;
        $data['reference'] = $value->reference;
        $data['reference_mobile'] = $value->reference_mobile;
        $data['attention'] = '';
        $data['email'] = $value->email;
        $data['sub_total'] = $value->sub_total;
        $data['discount_amount'] = $value->discount_amount;
        $data['transport_cost'] = $value->transport_cost;
        $data['test_fee'] = $value->test_fee;
        $data['other_expense'] = $value->other_expense;
        $data['quotation_total'] = $value->quotation_total;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        DB::table('pro_quotation_master_21')->insert($data);
    }
    return "Quotation Master Add Successfully";
    
});

//Get quotation Details
Route::get('/get_quotation_details', function () {
    $indent_master_all = DB::table('bpack_quotation_details')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['quotation_details_id'] = $value->quotation_details_id ;
        $data['company_id'] = 21;
        $data['quotation_id'] = '';
        $data['quotation_master_id'] = $value->quotation_master_id ;
        $data['quotation_date'] = $value->quotation_date;
        $data['product_id'] = $value->product_id;
        $data['qty'] = $value->qty;
        $data['rate'] = $value->rate;
        $data['rate_policy_id'] = $value->rate_policy_id;
        $data['total'] = $value->total;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        DB::table('pro_quotation_details_21')->insert($data);
    }
    return "Quotation Details Add Successfully";
    
});

//Get sales requisition master
Route::get('/get_sales_requistion_master', function () {
    $indent_master_all = DB::table('bpack_sales_requisition_01')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['requisition_master_id'] = $value->requisition_id_01;
        $data['requisition_date'] = $value->requisition_date ;
        $data['company_id'] = 21;
        $data['customer_id'] = $value->main_customer_code ;
        $data['deposit_amount'] = $value->deposit_amount;
        $data['sub_deposit_amount'] = $value->sub_deposit_amount;
        $data['total_deposit_amount'] = $value->total_deposit_amount;
        $data['last_balance'] = $value->last_balance;
        $data['pono_ref'] = $value->pono_ref;
        $data['pono_ref_date'] = $value->pono_ref_date;
        $data['remarks'] = $value->remarks;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        $data['requisition_stock_status'] = $value->requisition_stock_status;
        $data['approved'] = $value->approved;
        $data['comments'] = $value->comments;
        $data['approved_id'] = '';
        DB::table('pro_sales_requisition_master_21')->insert($data);
    }
    return "Sales Requistion Master Add Successfully";
    
});

//Get sales requisition details
Route::get('/get_sales_requistion_details', function () {
    $indent_master_all = DB::table('bpack_sales_requisition_02')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['requisition_details_id'] = $value->requisition_id_02;
        $data['requisition_master_id'] = $value->requisition_id_01;
        $data['requisition_date'] = $value->requisition_date ;
        $data['company_id'] = 21;
        $data['customer_id'] = $value->main_customer_code ;
        $data['product_id'] = $value->product_id;
        $data['qty'] = $value->qty;
        $data['rate'] = $value->rate;
        $data['rate_policy_id'] = $value->rate_policy_id;
        $data['total'] = $value->total;
        $data['comm_rate'] = $value->comm_rate;
        $data['comm_rate_total'] = $value->comm_rate_total;
        $data['transport_rate'] = $value->transport_rate;
        $data['total_transport'] = $value->total_transport;
        $data['net_total'] = $value->net_total;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        DB::table('pro_sales_requisition_details_21')->insert($data);
    }
    return "Sales Requistion Details Add Successfully";
    
});

//Get sales return master
Route::get('/get_sales_return_master', function () {
    $indent_master_all = DB::table('bpack_rsim')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['rsim_id'] = $value->rsim_id;
        $data['company_id'] = 21;
        $data['rsim_date'] = $value->rsim_date;
        $data['sim_id'] = $value->sim_id ;
        $data['customer_id'] = $value->customer_id ;
        $data['pg_id'] = $value->pg_id;
        $data['ref_name'] = $value->ref_name;
        $data['mushok_no'] = $value->mushok_no;
        $data['ifb_no'] = $value->ifb_no;
        $data['ifb_date'] = $value->ifb_date;
        $data['contract_no'] = $value->contract_no;
        $data['contract_date'] = $value->contract_date;
        $data['allocation_no'] = $value->allocation_no;
        $data['allocation_date'] = $value->allocation_date;
        $data['pono_ref'] = $value->pono_ref;
        $data['pono_ref_date'] = $value->pono_ref_date;
        $data['status'] = $value->status;
        $data['sinv_total'] = $value->sinv_total;
        $data['sinv_date'] = $value->sinv_date;
        $data['money_receipt_no'] = $value->money_receipt_no;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_return_invoice_master_21')->insert($data);
    }
    return "Sales Return Master Add Successfully";
    
});

//Get sales return details
Route::get('/get_sales_return_details', function () {
    $indent_master_all = DB::table('bpack_rsid')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['rsid_id'] = $value->rsid_id ;
        $data['company_id'] = 21;
        $data['rsim_id'] = $value->rsim_id;
        $data['rsim_date'] = $value->rsim_date;
        $data['customer_id'] = $value->customer_id ;
        $data['cust_sppl'] = $value->cust_sppl ;
        $data['product_id'] = $value->product_id;
        $data['pg_id'] = $value->pg_id;
        $data['sales_rate'] = $value->sales_rate;
        $data['remarks'] = $value->remarks;
        $data['return_qty'] = $value->return_qty;
        $data['total_sales_price'] = $value->total_sales_price;
        $data['vat_amount'] = $value->vat_amount;
        $data['discount_amount'] = $value->discount_amount;
        $data['depreciation'] = $value->depreciation;
        $data['net_payble'] = $value->net_payble;
        $data['status'] = $value->status;
        $data['damage_status'] = $value->damage_status;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        DB::table('pro_return_invoice_details_21')->insert($data);
    }
    return "Sales Return details Add Successfully";
    
});

//Get sales repair master
Route::get('/get_sales_repair_master', function () {
    $indent_master_all = DB::table('bpack_rim')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['reinvm_id'] = $value->reinvm_id  ;
        $data['company_id'] = 21;
        $data['reinvm_date'] = $value->reinvm_date;
        $data['customer_id'] = $value->customer_id ;
        $data['cust_sppl'] = $value->cust_sppl ;
        $data['pg_id'] = $value->pg_id;
        $data['product_id'] = $value->product_id;
        $data['repair_qty'] = $value->repair_qty;
        $data['repair_date'] = $value->repair_date;
        $data['serial_no'] = $value->serial_no;
        $data['sold_date'] = $value->sold_date;
        $data['recived_date'] = $value->recived_date;
        $data['mr_id'] = $value->mr_id;
        $data['reinv_total'] = $value->reinv_total;
        $data['remarks'] = $value->remarks;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        DB::table('pro_repair_invoice_master_21')->insert($data);
    }
    return "Sales Repair master Add Successfully";
    
});

//Get sales repair details
Route::get('/get_sales_repair_details', function () {
    $indent_master_all = DB::table('bpack_rid')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['reinvd_id'] = $value->reinvd_id ;
        $data['company_id'] = 21;
        $data['reinvm_id'] = $value->reinvm_id;
        $data['reinvm_date'] = $value->reinvm_date;
        $data['customer_id'] = $value->customer_id ;
        $data['pg_id'] = $value->pg_id;
        $data['pro_des'] = $value->pro_des;
        $data['unit'] = $value->unit;
        $data['qty'] = $value->qty;
        $data['unit_price'] = $value->unit_price;
        $data['total'] = $value->total;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['valid'] = $value->valid;
        $data['status'] = $value->status;
        DB::table('pro_repair_invoice_details_21')->insert($data);
    }
    return "Sales Repair Details Add Successfully";
    
});


//Get Finish Product
Route::get('/get_finish_product', function () {
    $indent_master_all = DB::table('bpack_product_list')->where('product_category',2)->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['product_id'] = $value->product_id;
        $data['company_id'] = 21;
        $data['pg_id'] = $value->pg_id;
        //Transformer 28, ctpt 33
        if($value->pg_id == 28){
            $data['pg_sub_id'] = 338;
        }else{
            $data['pg_sub_id'] = 399;
        }
        
        $data['product_category'] = $value->product_category;
        $data['product_name'] = $value->product_name;
        $data['product_type'] = $value->product_type ;
        $data['brand_name'] = $value->brand_name;
        $data['model_size'] = $value->model_size;
        $data['product_description'] = $value->product_description;
        $data['unit'] = $value->unit;
        $data['reorder_qty'] = $value->reorder_qty;
        $data['get_discount'] = $value->get_discount;
        $data['warrenty'] = $value->warrenty;
        $data['pro_image_name'] = $value->pro_image_name;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['last_user_id'] = $value->last_user_id;
        $data['last_edit_date'] = $value->last_edit_date;
        $data['last_edit_time'] = $value->last_edit_time;
        $data['valid'] = $value->valid;
        DB::table('pro_finish_product_21')->insert($data);
    }
    return "Finish Product Add Successfully";
    
});

//Get Raw Product
Route::get('/get_raw_product', function () {
    $indent_master_all = DB::table('bpack_product_list')->where('product_category',1)->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['product_id'] = $value->product_id;
        $data['company_id'] = 21;
        $data['pg_id'] = $value->pg_id;
        $data['pg_sub_id'] = 0;
        $data['product_category'] = $value->product_category;
        $data['product_name'] = $value->product_name;
        $data['product_type'] = $value->product_type ;
        $data['brand_name'] = $value->brand_name;
        $data['model_size'] = $value->model_size;
        $data['product_description'] = $value->product_description;
        $data['unit'] = $value->unit;
        $data['reorder_qty'] = $value->reorder_qty;
        $data['get_discount'] = $value->get_discount;
        $data['warrenty'] = $value->warrenty;
        $data['pro_image_name'] = $value->pro_image_name;
        $data['user_id'] = $value->user_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['last_user_id'] = $value->last_user_id;
        $data['last_edit_date'] = $value->last_edit_date;
        $data['last_edit_time'] = $value->last_edit_time;
        $data['valid'] = $value->valid;
        DB::table('pro_product_21')->insert($data);
    }
    return "Raw Product Add Successfully";
    
});

//Get All Customer
Route::get('/get_all_customer', function () {
    $indent_master_all = DB::table('bpack_supplier_information')->whereNotIn('cust_sppl',['S'])->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['customer_id'] = $value->supplier_id;
        $data['company_id'] = 21;
        $data['customer_name'] = $value->supplier_name;
        $data['contact_person'] = $value->supplier_contact;
        $data['customer_type'] = $value->supplier_type;
        $data['customer_address'] = $value->supplier_address ;
        $data['customer_zip'] = $value->supplier_zip;
        $data['customer_city'] = $value->supplier_city;
        $data['customer_country'] = $value->supplier_country;
        $data['customer_state'] = $value->supplier_state;
        $data['customer_phone'] = $value->supplier_phone;
        $data['customer_mobile'] = $value->supplier_mobile;
        $data['customer_fax'] = $value->supplier_fax;
        $data['customer_email'] = $value->supplier_email;
        $data['customer_url'] = $value->supplier_url;
        $data['user_id'] = $value->admin_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['last_user_id'] = $value->last_user_id;
        $data['last_edit_date'] = $value->last_edit_date;
        $data['last_edit_time'] = $value->last_edit_time;
        $data['cust_sppl'] = $value->cust_sppl;
        $data['valid'] = $value->valid;
        DB::table('pro_customer_information_21')->insert($data);
    }
    return "Get All Customer Add Successfully";
    
});

//Get All Section
Route::get('/get_all_section', function () {
    $indent_master_all = DB::table('bpack_branch_information')->get();
    foreach($indent_master_all as $value){
        $data = array();
        $data['section_id'] = $value->branch_id;
        $data['company_id'] = 21;
        $data['section_name'] = $value->branch_name;
        $data['section_add'] = $value->branch_add;
        $data['section_zip'] = $value->branch_zip;
        $data['section_city'] = $value->branch_city ;
        $data['section_country'] = $value->branch_country;
        $data['section_state'] = $value->branch_state;
        $data['section_phone'] = $value->branch_phone;
        $data['section_mobile'] = $value->branch_mobile;
        $data['section_fax'] = $value->branch_fax;
        $data['section_email'] = $value->branch_email;
        $data['section_url'] = $value->branch_url;
        $data['user_id'] = $value->admin_id;
        $data['entry_date'] = $value->entry_date;
        $data['entry_time'] = $value->entry_time;
        $data['last_user_id'] = $value->last_user_id;
        $data['last_edit_date'] = $value->last_edit_date;
        $data['last_edit_time'] = $value->last_edit_time;
        $data['valid'] = $value->valid;
        $data['section_catagory'] = $value->branch_catagory;
        DB::table('pro_section_information')->insert($data);
    }
    return "Get section Add Successfully";
    
});
