<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/home');
    }

    //Company
    public function admincuser()
    {
        $data = DB::table('users')->Where('valid', '1')->orderBy('id', 'asc')->get(); //query builder

        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();
        return view('admin.create_user', compact('data', 'companies'));
    }

    public function admincuserstore(Request $request)
    {
        $rules = [
            // 'cbo_employee_id' => 'required|integer|between:1,99999999',
            'txt_password' => 'required|min:8|max:20',
        ];

        $customMessages = [
            // 'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'txt_password.required' => 'Password is required.',
            'txt_password.min' => 'Password must be at least 8 characters.',
            'txt_password.max' => 'Password not more 20 characters.',
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('users')->where('emp_id', $request->cbo_employee_id)->first();
        //dd($abcd);

        if ($abcd === null) {

            $ci_employee_info = DB::table('pro_employee_info')->Where('employee_id', $request->cbo_employee_id)->first();
            $txt_employee_name = $ci_employee_info->employee_name;

            $m_valid = '1';
            $m_user_status = '1';

            $data = array();
            $data['emp_id'] = $request->cbo_employee_id;
            $data['password'] = Hash::make($request->txt_password);
            $data['user_status'] = $m_user_status;
            $data['admin_id'] = $request->txt_user_id;
            $data['full_name'] = $txt_employee_name;
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');
            // dd($data);
            DB::table('users')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function admincuseredit($id)
    {

        $m_user = DB::table('users')->where('emp_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('users')->Where('valid', '1')->orderBy('emp_id', 'desc')->get();
        return view('admin.create_user', compact('data', 'm_user'));
    }

    public function admincuserupdate(Request $request, $update)
    {

        $rules = [
            'sele_employee_id' => 'required|integer|between:1,99999999',
            'txt_password' => 'required|max:20|min:8',
        ];

        $customMessages = [

            'sele_employee_id.required' => 'Select Employee.',
            'sele_employee_id.integer' => 'Select Employee.',
            'sele_employee_id.between' => 'Chose Employee.',

            'txt_password.required' => 'Password is required.',
            'txt_password.min' => 'Password must be at least 8 characters.',
            'txt_password.max' => 'Password not more 20 characters.',

        ];

        $this->validate($request, $rules, $customMessages);

        DB::table('users')->where('emp_id', $update)->update([
            'password' => Hash::make($request->txt_password),
            'valid' => $request->sele_valid,
            'updated_at' => date('Y-m-d H:i:s'),

        ]);

        return redirect(route('create_user'))->with('success', 'Data Updated Successfully!');
    }

    //User Sub menu

    public function user_menu_permission()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();
        $modules = DB::table('pro_module')->get();
        return view('admin.user_menu_permission', compact('companies', 'modules'));
    }

    public function user_menu_permission_list(Request $request)
    {
        $rules = [
            'cbo_employee_id' => 'required',
            'cbo_company_id' => 'required',
            'cbo_module_id' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_company_id.required' => 'Select Company',
            'cbo_module_id.required' => 'Select Module',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_company = DB::table('pro_company')
            ->where('company_id', $request->cbo_company_id)
            ->first();
        $m_employee = DB::table('pro_employee_info')
            ->where('employee_id', $request->cbo_employee_id)
            ->where('valid', 1)
            ->first();
        $m_modules = DB::table('pro_module')
            ->where('module_id', $request->cbo_module_id)
            ->first();
        $m_main_mnu = DB::table('pro_main_mnu')
            ->where('module_id', $request->cbo_module_id)
            ->get();
        return view('admin.user_menu_permission_list', compact('m_company', 'm_modules', 'm_employee', 'm_main_mnu'));
    }

    public function module_all_menu_permission(Request $request)
    {

        $m_submenu = DB::table('pro_sub_mnu')
            ->where('module_id', $request->txt_module_id)
            ->get();

        foreach ($m_submenu as $row) {

            if ($request->txt_valid_all == 'on') {
                $valid = '1';
            } else {
                $valid = '0';
            }

            $check = DB::table('pro_sub_mnu_for_users')
                ->where('emp_id', $request->txt_employee_id)
                ->where('module_id', $request->txt_module_id)
                ->where('main_mnu_id', $row->main_mnu_id)
                ->where('sub_mnu_id', $row->sub_mnu_id)
                ->first();

            if ($check) {
                DB::table('pro_sub_mnu_for_users')
                    ->where('emp_id', $request->txt_employee_id)
                    ->where('module_id', $request->txt_module_id)
                    ->where('main_mnu_id', $row->main_mnu_id)
                    ->where('sub_mnu_id', $row->sub_mnu_id)
                    ->update(['valid' => $valid]);
            } else {
                $data = array();
                $data['emp_id'] = $request->txt_employee_id;
                $data['module_id'] = $request->txt_module_id;
                $data['main_mnu_id'] = $row->main_mnu_id;
                $data['sub_mnu_id'] =  $row->sub_mnu_id;
                $data['valid'] = $valid;
                DB::table('pro_sub_mnu_for_users')->insert($data);
            }
            //  if ($check) { update
        }
        // foreach ($m_submenu as $value){
        return back()->with('success', "Module Wise add Successfull!");
    }

    public function main_menu_all_permission(Request $request)
    {

        $m_submenu = DB::table('pro_sub_mnu')
            ->where('module_id', $request->txt_module_id)
            ->where('main_mnu_id', $request->txt_main_menu_id)
            ->get();

        foreach ($m_submenu as $row) {

            if ($request->txt_mark_all == 'on') {
                $valid = '1';
            } else {
                $valid = '0';
            }

            $check = DB::table('pro_sub_mnu_for_users')
                ->where('emp_id', $request->txt_employee_id)
                ->where('module_id', $request->txt_module_id)
                ->where('main_mnu_id', $request->txt_main_menu_id)
                ->where('sub_mnu_id', $row->sub_mnu_id)
                ->first();

            if ($check) {
                DB::table('pro_sub_mnu_for_users')
                    ->where('emp_id', $request->txt_employee_id)
                    ->where('module_id', $request->txt_module_id)
                    ->where('main_mnu_id', $request->txt_main_menu_id)
                    ->where('sub_mnu_id', $row->sub_mnu_id)
                    ->update(['valid' => $valid]);
            } else {
                $data = array();
                $data['emp_id'] = $request->txt_employee_id;
                $data['module_id'] = $request->txt_module_id;
                $data['main_mnu_id'] = $request->txt_main_menu_id;
                $data['sub_mnu_id'] =  $row->sub_mnu_id;
                $data['valid'] = $valid;
                DB::table('pro_sub_mnu_for_users')->insert($data);
            }
            //  if ($check) { update
        }
        // foreach ($m_submenu as $value){
        return back()->with('success', " Main menu wise add Successfull!");
    }

    public function sub_menu_wise_permission(Request $request)
    {
        if ($request->txt_valid == 'on') {
            $valid = '1';
        } else {
            $valid = '0';
        }

        $check = DB::table('pro_sub_mnu_for_users')
            ->where('emp_id', $request->txt_employee_id)
            ->where('module_id', $request->txt_module_id)
            ->where('main_mnu_id', $request->txt_main_menu_id)
            ->where('sub_mnu_id', $request->txt_sub_menu_id)
            ->first();

        if ($check) {
            DB::table('pro_sub_mnu_for_users')
                ->where('emp_id', $request->txt_employee_id)
                ->where('module_id', $request->txt_module_id)
                ->where('main_mnu_id', $request->txt_main_menu_id)
                ->where('sub_mnu_id', $request->txt_sub_menu_id)
                ->update(['valid' => $valid]);
        } else {
            $data = array();
            $data['emp_id'] = $request->txt_employee_id;
            $data['module_id'] = $request->txt_module_id;
            $data['main_mnu_id'] = $request->txt_main_menu_id;
            $data['sub_mnu_id'] =   $request->txt_sub_menu_id;
            $data['valid'] = $valid;
            DB::table('pro_sub_mnu_for_users')->insert($data);
        }
        //  if ($check) { update
        return back()->with('success', "Sub mneu wise add Successfull!");
    }


    //New Module and Company
    public function UserModuleCompany()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();

        $employees = DB::table('pro_employee_info')->get();
        return view('admin.user_module_and_company', compact('employees', 'companies'));
    }

    public function user_mc_list(Request $request)
    {
        $rules = [
            'cbo_employee_id' => 'required',
            'cbo_blade' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_blade.required' => 'Select Blade',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->cbo_blade == 1) {
            return redirect()->route('user_module_edit', $request->cbo_employee_id);
        } elseif ($request->cbo_blade == 2) {
            return redirect()->route('user_company_edit', $request->cbo_employee_id);
        }
    }

    //Module
    public function user_module_edit($emp_id)
    {

        // $m_module = DB::table('pro_module_user')
        // ->where('pro_module_user.emp_id', $emp_id)
        // ->where('pro_module_user.valid', 1)
        // ->join('pro_module','pro_module_user.module_id','pro_module.module_id')
        // ->select('pro_module.*')
        // ->get();
        $m_module = DB::table('pro_module')->where('valid', 1)->get();
        return view('admin.user_module_list', compact('m_module', 'emp_id'));
    }
    public function user_module_update(Request $request, $id)
    {

        $check_module = DB::table('pro_module_user')
            ->where('emp_id', $id)
            ->where('module_id', $request->txt_module_id)
            ->first();

        if (isset($check_module)) {
            if ($request->txt_valid == "on") {
                DB::table('pro_module_user')
                    ->where('emp_id', $id)
                    ->where('module_id', $request->txt_module_id)
                    ->update(['valid' => 1]);
            } else {
                DB::table('pro_module_user')
                    ->where('emp_id', $id)
                    ->where('module_id', $request->txt_module_id)
                    ->update(['valid' => 0]);
            }
            return back()->with('success', 'Successfull Updated');
        } else {
            $data = array();
            $data['emp_id'] = $request->txt_employee_id;
            $data['module_id'] = $request->txt_module_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table('pro_module_user')->insert($data);
            return back()->with('success', 'Successfull Inserted');
        }
    }

    //comapny
    public function user_company_edit($emp_id)
    {
        $m_company = DB::table('pro_company')->where('valid', 1)->get();
        return view('admin.user_company_list', compact('m_company', 'emp_id'));
    }
    public function user_company_update(Request $request, $id)
    {
        $check_company = DB::table('pro_user_company')
            ->where('employee_id', $id)
            ->where('company_id', $request->txt_company_id)
            ->first();

        if ($request->txt_valid == "on") {
            $valid = 1;
        } else {
            $valid = 0;
        }
        if ($request->txt_posting_status == "on") {
            $posting_status = 1;
        } else {
            $posting_status = 2;
        }

        if (isset($check_company)) {
            DB::table('pro_user_company')
                ->where('employee_id', $id)
                ->where('company_id', $request->txt_company_id)
                ->update(['valid' => $valid, 'posting_status' => $posting_status]);

            return back()->with('success', 'Successfull Updated');
        } else {
            $data = array();
            $data['employee_id'] = $request->txt_employee_id;
            $data['company_id'] = $request->txt_company_id;
            $data['posting_status'] = $posting_status;
            // $data['entry_date'] = date("Y-m-d");
            // $data['entry_time'] = date("h:i:sa");
            $data['valid'] = $valid;
            DB::table('pro_user_company')->insert($data);
            return back()->with('success', 'Successfull Inserted');
        }
    }


    public function user_placeofposting_permission()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();

        $employees = DB::table('pro_employee_info')
            ->where('valid', '1')
            ->where('working_status', '1')
            ->orderBy('employee_id', 'asc')
            ->get();
        return view('admin.user_placeofposting_permission', compact('employees', 'companies'));
    }

    public function user_placeofposting_permission_list(Request $request)
    {
        $rules = [
            'cbo_employee_id' => 'required',
            'cbo_company_id' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_company_id.required' => 'Select Company',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_company = DB::table('pro_company')
            ->where('company_id', $request->cbo_company_id)
            ->where('valid', 1)
            ->first();
        $m_employee = DB::table('pro_employee_info')
            ->where('employee_id', $request->cbo_employee_id)
            ->where('valid', 1)
            ->first();
        return view('admin.user_placeofposting_permission_list', compact('m_company', 'm_employee'));
    }

    public function all_placeofposting_permission(Request $request)
    {


        $all_placeofposting = DB::table('pro_placeofposting')
            ->where('valid', 1)
            ->get();

        if ($request->txt_valid_all == 'on') {
            $valid = 1;
        } else {
            $valid = 0;
        }

        foreach ($all_placeofposting as $row) {

            $check = DB::table('pro_user_posting')
                ->where('company_id', $request->txt_company_id)
                ->where('employee_id', $request->txt_employee_id)
                ->where('placeofposting_id', $row->placeofposting_id)
                ->first();
            if ($check) {
                DB::table('pro_user_posting')
                    ->where('company_id', $request->txt_company_id)
                    ->where('employee_id', $request->txt_employee_id)
                    ->where('placeofposting_id', $row->placeofposting_id)
                    ->update([
                        'valid' =>   $valid,
                    ]);
            } else {
                DB::table('pro_user_posting')
                    ->insert([
                        'company_id' => $request->txt_company_id,
                        'employee_id' => $request->txt_employee_id,
                        'placeofposting_id' => $row->placeofposting_id,
                        'user_id' => Auth::user()->emp_id,
                        'valid' =>   $valid,
                    ]);
            } //if ($check) {
        } // foreach ($all_placeofposting as $row) {

        return back()->with('success', "add Successfull!");
    }

    public function catagory_wise_placeofposting_permission(Request $request)
    {


        $all_placeofposting = DB::table('pro_placeofposting')
            ->where('posting_catagory', $request->txt_catagory)
            ->where('valid', 1)
            ->get();

        if ($request->txt_cattagory_valid == 'on') {
            $valid = 1;
        } else {
            $valid = 0;
        }

        foreach ($all_placeofposting as $row) {

            $check = DB::table('pro_user_posting')
                ->where('company_id', $request->txt_company_id)
                ->where('employee_id', $request->txt_employee_id)
                ->where('placeofposting_id', $row->placeofposting_id)
                ->first();
            if ($check) {
                DB::table('pro_user_posting')
                    ->where('company_id', $request->txt_company_id)
                    ->where('employee_id', $request->txt_employee_id)
                    ->where('placeofposting_id', $row->placeofposting_id)
                    ->update([
                        'valid' =>   $valid,
                    ]);
            } else {
                DB::table('pro_user_posting')
                    ->insert([
                        'company_id' => $request->txt_company_id,
                        'employee_id' => $request->txt_employee_id,
                        'placeofposting_id' => $row->placeofposting_id,
                        'user_id' => Auth::user()->emp_id,
                        'valid' =>   $valid,
                    ]);
            } //if ($check) {
        } // foreach ($all_placeofposting as $row) {

        return back()->with('success', "add Successfull!");
    }

    public function only_one_placeofposting_permission(Request $request, $id)
    {
        $all_placeofposting = DB::table('pro_placeofposting')
            ->where('placeofposting_id', $id)
            ->where('valid', 1)
            ->get();

        if ($request->txt_posting_status == 'on') {
            $valid = 1;
        } else {
            $valid = 0;
        }

        $check = DB::table('pro_user_posting')
            ->where('company_id', $request->txt_company_id)
            ->where('employee_id', $request->txt_employee_id)
            ->where('placeofposting_id', $id)
            ->first();
        if ($check) {
            DB::table('pro_user_posting')
                ->where('company_id', $request->txt_company_id)
                ->where('employee_id', $request->txt_employee_id)
                ->where('placeofposting_id', $id)
                ->update([
                    'valid' =>   $valid,
                ]);
        } else {
            DB::table('pro_user_posting')
                ->insert([
                    'company_id' => $request->txt_company_id,
                    'employee_id' => $request->txt_employee_id,
                    'placeofposting_id' => $id,
                    'user_id' => Auth::user()->emp_id,
                    'valid' =>   $valid,
                ]);
        } //if ($check) {

        return back()->with('success', "add Successfull!");
    }









    //Fund Requsition permission_for_notification
    public function permission_for_notification()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.finance_status', '1')
            ->get();
        $m_fund_req_check =   DB::table('pro_fund_req_check')->where('valid', 1)->get();
        return view('admin.permission_for_notification', compact('user_company', 'm_fund_req_check'));
    }

    public function permission_for_notification_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_first_check' => 'required',
            'cbo_second_check' => 'required',
            'cbo_final_check' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_first_check.required' => 'Select First Employee Check.',
            'cbo_second_check.required' => 'Select Second Employee Check.',
            'cbo_final_check.required' => 'Select Final Employee Check.',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $data = array();
        $data['company_id'] = $request->cbo_company_id;
        $data['employee_id_01'] = $request->cbo_first_check;
        $data['employee_id_02'] = $request->cbo_second_check;
        $data['employee_id_03'] = $request->cbo_final_check;
        $data['status'] = 1;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        DB::table('pro_fund_req_check')->insert($data);
        return back()->with('success', 'Add successfully');
    }

    public function permission_for_notification_edit($id)
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.finance_status', '1')
            ->get();
        $m_fund_req_check =   DB::table('pro_fund_req_check')->where('fund_req_check_id', $id)->first();
        return view('admin.permission_for_notification_edit', compact('user_company', 'm_fund_req_check'));
    }

    public function permission_for_notification_update(Request $request, $id)
    {
        $m_user_id = Auth::user()->emp_id;
        $data = array();
        $data['company_id'] = $request->cbo_company_id;
        $data['employee_id_01'] = $request->cbo_first_check;
        $data['employee_id_02'] = $request->cbo_second_check;
        $data['employee_id_03'] = $request->cbo_final_check;
        $data['user_id'] = $m_user_id;
        DB::table('pro_fund_req_check')->where('fund_req_check_id', $id)->update($data);
        return redirect()->route('permission_for_notification')->with('success', 'Update successfully');
    }

    public function FundNotificationEmployeeInfo($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('valid', '1')
            ->where('working_status', '1')
            ->orderBy('employee_id', 'asc')
            ->get();
        return response()->json($data);
    }

    public function user_menu_create()
    {
        if (Auth::user()->emp_id == "00000130") {
            $m_modules = DB::table('pro_module')->where('valid', 1)->get();
            $m_sub_menu = DB::table('pro_sub_mnu')->where('valid', 1)->orderByDesc('sub_mnu_id')->get();
            return view('admin.user_menu_create', compact('m_modules', 'm_sub_menu'));
        } else {
            return back()->with('warning', "Data Not Found");
        }
    }
    public function user_menu_store(Request $request)
    {

        $rules = [
            'cbo_module_id' => 'required',
            'cbo_main_menu_id' => 'required',
            'txt_sub_menu_title' => 'required',
            'txt_sub_menu_link' => 'required',
            'txt_menu_serial' => 'required',
        ];

        $customMessages = [
            'cbo_module_id.required' => 'Select Module.',
            'cbo_main_menu_id.required' => 'Select Main Menu.',
            'txt_sub_menu_title.required' => 'Title is required.',
            'txt_sub_menu_link.required' => 'Link is required ',
            'txt_menu_serial.required' => 'Valid is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        if (Auth::user()->emp_id == "00000130") {
            DB::table('pro_sub_mnu')->insert([
                'module_id' => $request->cbo_module_id,
                'main_mnu_id' => $request->cbo_main_menu_id,
                'sub_mnu_title' => $request->txt_sub_menu_title,
                'sub_mnu_link' => $request->txt_sub_menu_link,
                'sub_mnu_gr' => 1,
                'menu_sl' => $request->txt_menu_serial,
                'valid' => 1,
            ]);
            return back()->with('success', "Sub mneu  Create Successfull!");
        } else {
            return back()->with('warning', "Data Not Found");
        }
    }


    public function user_menu_edit($id)
    {
        $m_sub_menu_edit = DB::table('pro_sub_mnu')->where('sub_mnu_id', $id)->first();
        $m_module = DB::table('pro_module')
            ->where('module_id', $m_sub_menu_edit->module_id)
            ->first();
        $m_main_menu = DB::table('pro_main_mnu')
            ->where('main_mnu_id', $m_sub_menu_edit->main_mnu_id)
            ->first();
        return view('admin.user_menu_edit', compact('m_module', 'm_sub_menu_edit', 'm_main_menu'));
    }

    public function user_menu_update(Request $request, $id)
    {
        DB::table('pro_sub_mnu')->where('sub_mnu_id', $id)->update([
            'sub_mnu_title' => $request->txt_sub_menu_title,
            'sub_mnu_link' => $request->txt_sub_menu_link,
            'menu_sl' => $request->txt_menu_serial,
        ]);
        return redirect()->route('user_menu_create')->with('success', "Sub mneu  Create Successfull!");
    }


    public function user_password_reset()
    {
        $companies = DB::table('pro_company')
            ->where('valid', '1')
            ->get();
        return view('admin.user_password_reset', compact('companies'));
    }
    public function user_password_update(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_employee_id' => 'required',
            'txt_new_pass' => [
                'required',
                'string',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'password_confirmation' => 'required|same:txt_new_pass'
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_employee_id.required' => 'Select Employee.',
            'txt_new_pass.required' => 'Password is Required.',
            'txt_new_pass.string' => 'Password must contain a string.',
            'txt_new_pass.regex' => 'Password at least one lowercase ,  one uppercase , one digit and chracter Ex- Pr@120#p ',
            'txt_new_pass.min' => 'Password must be at least 8 characters in length.',
            'password_confirmation.required' => 'Confirmed Password is Required.',
            'password_confirmation.same' => 'Password Confirmation should match the Password.',
        ];
        $this->validate($request, $rules, $customMessages);

        $newPassword = password_hash($request->txt_new_pass, PASSWORD_DEFAULT);

        DB::table("users")->where('emp_id', $request->cbo_employee_id)->update(['password' => $newPassword]);

        return back()->with('success', 'User Reset Password Successfully.');
    }

    public function user_subposting_permission()
    {
        $companies = DB::table('pro_company')
            ->select("pro_company.company_id", "pro_company.company_name")
            ->where('valid', '1')
            ->get();
        $m_placeofposting = DB::table('pro_placeofposting')
            ->select('pro_placeofposting.placeofposting_id', 'pro_placeofposting.placeofposting_name')
            ->Where('valid', '1')
            ->orderBy('placeofposting_id', 'asc')
            ->get();
        return view('admin.user_subposting_permission', compact('companies', 'm_placeofposting'));
    }

    public function user_subposting_permission_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'cbo_employee_id' => 'required',
            'cbo_placeofposting_id' => 'required',
            // 'cbo_placeofposting_sub_id' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_placeofposting_id.required' => 'Select Posting.',
            // 'cbo_placeofposting_sub_id.required' => 'Select Sub Posting.',

        ];
        $this->validate($request, $rules, $customMessages);
        $check_sub_posting = DB::table('pro_user_sub_posting')
            ->where('employee_id', $request->cbo_employee_id)
            ->where('company_id', $request->cbo_company_id)
            ->where('placeofposting_id', $request->cbo_placeofposting_id)
            ->where('placeofposting_sub_id', $request->cbo_placeofposting_sub_id)
            ->first();
        if ($check_sub_posting) {
            return back()->with('warning', 'Alredy Insert Data.');
        } else {
            $data = array();
            $data['employee_id'] = $request->cbo_employee_id;
            $data['company_id'] = $request->cbo_company_id;
            $data['placeofposting_id'] = $request->cbo_placeofposting_id;
            $data['placeofposting_sub_id'] = $request->cbo_placeofposting_sub_id;
            $data['valid'] = 1;
            DB::table('pro_user_sub_posting')->insert($data);
            return back()->with('success', 'User Sub Posting Permission Successfully.');
        }
    }



    //Ajax user sub-placeposting permission
    public function admingetplaceofsubposting($placeofposting_id)
    {
        $data = DB::table('pro_sub_placeofposting')
            ->select('pro_sub_placeofposting.placeofposting_sub_id', 'pro_sub_placeofposting.sub_placeofposting_name')
            ->where('placeofposting_id', $placeofposting_id)
            ->Where('valid', '1')
            ->orderBy('placeofposting_sub_id', 'asc')
            ->get();

        return response()->json($data);
    }

    public function admingetemployee($placeofposting_id, $placeofposting_sub_id, $company_id)
    {
        $data = DB::table('pro_employee_info')
            ->where('working_status', '1')
            // ->where('ss', '1')
            ->where('company_id', $company_id)
            ->get();

        return response()->json($data);
    }

    //End Sub Posting Permission



    //Indent Requsition Check user
    public function indent_req_check_user()
    {
        $companies = DB::table('pro_company')
            ->select("pro_company.company_id", "pro_company.company_name")
            ->where('valid', '1')
            ->get();
        $all_user = DB::table('pro_fund_req_check')
            ->leftJoin('pro_company', "pro_fund_req_check.company_id", 'pro_company.company_id')
            ->leftJoin('pro_employee_info', "pro_fund_req_check.employee_id", 'pro_employee_info.employee_id')
            ->select('pro_fund_req_check.*', 'pro_company.company_name', 'pro_employee_info.employee_name')
            ->get();
        return view('admin.indent_req_check_user', compact('companies', 'all_user'));
    }

    public function indent_req_check_user_permission(Request $request)
    {

        $rules = [
            'cbo_employee_id' => 'required',
        ];

        $customMessages = [
            'cbo_employee_id.required' => 'Select Employee.',

        ];
        $this->validate($request, $rules, $customMessages);
        $m_employee_id = $request->cbo_employee_id;

        $companies = DB::table('pro_company')
            ->select("pro_company.company_id", "pro_company.company_name")
            ->where('valid', '1')
            ->get();

        $employee_details = DB::table('pro_employee_info')
            ->where('working_status', '1')
            ->where('employee_id', $m_employee_id)
            ->first();

        $employee_bio = DB::table('pro_employee_biodata')
            ->where('employee_id', $m_employee_id)
            ->first();

        if ($employee_bio) {
            $mial = $employee_bio->email_office;
        } else {
            $mial = "";
        }

        return view('admin.indent_req_check_user', compact('companies', 'employee_details', 'mial'));
    }

    public function indent_req_check_user_store(Request $request)
    {
        $employee_id = $request->txt_employee_id;
        $company_id = $request->txt_company_id;
        $mail = $request->txt_mail;

        if($company_id){
            $companies = DB::table('pro_company')
            ->select("pro_company.company_id", "pro_company.company_name")
            ->where('company_id', $company_id)
            ->where('valid', '1')
            ->first();
            $company_name = $companies->company_name;
        }else{
            $company_name = ''; 
        }
      
        if ($request->txt_mail == NULL && $request->cbo_level_id == NULL)
         {
            return back()->with('warning', "$company_name Mail And Level is required!");
        } 
        elseif ($request->txt_mail && $request->cbo_level_id == NULL)
         {
            return back()->with('warning', "$company_name Level is required!");
        } 
        elseif ($request->txt_mail == NULL && $request->cbo_level_id)
         {
            return back()->with('warning', "$company_name Mail is required!");
        } 
        else {
            

            if ($request->txt_valid == "on") {
                $valid = 1;
            } else {
                $valid = 0;
            }
            //
            $check =  DB::table('pro_fund_req_check')
                ->where("company_id", $company_id)
                ->where("employee_id", $employee_id)
                ->first();
            if ($check) {
                $data = array();
                // $data['employee_id'] = $employee_id;
                // $data['company_id'] = $company_id;
                $data['mail_id'] = $mail;
                $data['status'] = $request->cbo_level_id;
                $data['user_id'] = Auth::user()->emp_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid'] = $valid;
                DB::table('pro_fund_req_check')
                    ->where("company_id", $company_id)
                    ->where("employee_id", $employee_id)
                    ->update($data);
                return back()->with('Warning', "Alredy Insert!");
            } else {
                $data = array();
                $data['employee_id'] = $employee_id;
                $data['company_id'] = $company_id;
                $data['mail_id'] = $mail;
                $data['status'] = $request->cbo_level_id;
                $data['user_id'] = Auth::user()->emp_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid'] = $valid;
                DB::table('pro_fund_req_check')->insert($data);
                return back()->with('success', "Add Successfully!");
            }
        }
    }



    // Ajax Sub Menu For User Store

    public function GetEmployee1($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('working_status', '1')
            // ->where('ss', '1')
            ->where('company_id', $id)
            ->orderBy('employee_id', 'asc')
            ->get();
        return json_encode($data);
    }

    public function GetEmployee1Details($id)
    {
        $data = DB::table('pro_employee_biodata')
            ->where('employee_id', $id)
            ->first();

        if ($data) {
            $mial = $data->email_office;
        } else {
            $mial = "";
        }

        return response()->json($mial);
    }

    public function GetCompany($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('company_id', $id)
            ->where('valid', '1')
            ->orderBy('employee_id', 'asc')
            ->get();
        return response()->json($data);
    }
    public function GetMainMenu($id)
    {
        $data = DB::table('pro_main_mnu')
            ->where('module_id', $id)
            ->get();
        return response()->json($data);
    }
}
