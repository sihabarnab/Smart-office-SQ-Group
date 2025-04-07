<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class PurchaseController extends Controller
{

    //Project Name
    public function ProjectName()
    {
        $pro_project_name = DB::table('pro_project_name')->get();
        return view('purchase.project_name', compact('pro_project_name'));
    }

    public function project_name_store(Request $request)
    {
        $project_name_check = DB::table('pro_project_name')->where('project_name', $request->txt_project_name)->first();
        if ($project_name_check === null) {
            $rules = [
                'txt_project_name' => 'required',
            ];

            $customMessages = [
                'txt_project_name.required' => 'project name is required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['project_name'] = $request->txt_project_name;
            $data['valid'] = 1;
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            DB::table('pro_project_name')->insert($data);
            return redirect()->route('project_name')->with('success', 'Project Name Inserted Successfull !');
        } else {
            $project_name_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function project_name_edit($id)
    {
        $project_name_edit = DB::table('pro_project_name')->where('project_id', $id)->first();
        return view('purchase.project_name', compact('project_name_edit'));
    }
    public function project_name_update(Request $request, $id)
    {
        $rules = [
            'txt_project_name' => 'required',
        ];

        $customMessages = [
            'txt_project_name.required' => 'project name is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $data = array();
        $data['project_name'] = $request->txt_project_name;
        DB::table('pro_project_name')->where('project_id', $id)->update($data);
        return redirect()->route('project_name')->with('success', 'Project Name Updated Successfull !');
    }


    //Indent Category
    public function IndentCategory()
    {
        $pro_indent_category = DB::table('pro_indent_category')->get();
        return view('purchase.indent_category', compact('pro_indent_category'));
    }

    public function indent_category_store(Request $request)
    {
        $category_name_check = DB::table('pro_indent_category')->where('category_name', $request->txt_category_info)->first();

        if ($category_name_check === null) {
            $rules = [
                'txt_category_info' => 'required',
            ];

            $customMessages = [
                'txt_category_info.required' => 'Indent Category is required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['category_name'] = $request->txt_category_info;
            $data['valid'] = 1;
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            DB::table('pro_indent_category')->insert($data);
            return redirect()->route('indent_category')->with('success', 'Indent Category Inserted Successfull !');
        } else {
            $category_name_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function indent_category_edit($id)
    {
        $indent_category_edit = DB::table('pro_indent_category')->where('category_id', $id)->first();
        return view('purchase.indent_category', compact('indent_category_edit'));
    }
    public function indent_category_update(Request $request, $id)
    {
        $rules = [
            'txt_category_info' => 'required',
        ];

        $customMessages = [
            'txt_category_info.required' => 'Indent Category is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['category_name'] = $request->txt_category_info;
        DB::table('pro_indent_category')->where('category_id', $id)->update($data);
        return redirect()->route('indent_category')->with('success', 'Indent Category Updated Successfull !');
    }



    //Purchase Indent
    public function PurchaseIndent()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.purchase_status', '1')
            ->get();

        $pro_indent_category = DB::table('pro_indent_category')->get();
        $pro_project_name = DB::table('pro_project_name')->get();
        $pro_section_information = DB::table('pro_section_information')->get();
        return view('purchase.indent_info', compact('pro_indent_category', 'pro_project_name', 'pro_section_information', 'user_company'));
    }
    public function purchase_indent_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_project_name' => 'required|integer|between:1,99999999',
            'cbo_indent_category' => 'required|integer|between:1,99999999',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            'cbo_section' => 'required|integer|between:1,99999999',
            'txt_product_quanity' => 'required',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',
            'cbo_project_name.required' => 'project name field is required!',
            'cbo_project_name.integer' => 'project name field is required!',
            'cbo_project_name.between' => 'project name field is required!',
            'cbo_indent_category.required' => 'indent category field is required!',
            'cbo_indent_category.integer' => 'indent category field is required!',
            'cbo_indent_category.between' => 'indent category field is required!',
            'cbo_product_group.required' => 'product group field is required!',
            'cbo_product_group.integer' => 'product group field is required!',
            'cbo_product_group.between' => 'product group field is required!',
            'cbo_product_sub_group.required' => 'product Sub group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub group field is required!',
            'cbo_product_sub_group.between' => 'product Sub group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            'cbo_section.required' => 'section field is required!',
            'cbo_section.integer' => 'section field is required!',
            'cbo_section.between' => 'section field is required!',
            'txt_product_quanity.required' => 'product quanity field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['project_id'] = $request->cbo_project_name;
        $data['indent_category'] = $request->cbo_indent_category;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['product_unit'] = $request->txt_unit_id;
        $data['description'] = $request->txt_product_description;
        $data['remarks'] = $request->txt_remarks;
        $data['section_id'] = $request->cbo_section;
        $data['qty'] = $request->txt_product_quanity;
        $data['valid'] = '1';
        $data['status'] = '1';
        $data['rr_status'] = '1';
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['req_date'] = $request->txt_req_date;
        // $indent_no = date("Y") . date("m") . str_pad(mt_rand(1, 100000), 5, '0', STR_PAD_LEFT);

        $last_indent = DB::table("pro_indent_master_$request->cbo_company_id")->orderByDesc("indent_no")->first();
        $indent_no = date("Ym") . str_pad((substr($last_indent->indent_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        //must 11 digit
        // $indent_no = date("Y") . date("m") . str_pad(mt_rand(1, 100000),5,'0',STR_PAD_LEFT); 
        $data['indent_no'] = $indent_no;

        $indent_id = DB::table("pro_indent_details_$request->cbo_company_id")->insertGetId($data);
        if ($indent_id) {
            DB::table("pro_indent_master_$request->cbo_company_id")->insert([
                'indent_no' => $indent_no,
                'company_id' => $request->cbo_company_id,
                'project_id' => $request->cbo_project_name,
                'indent_category' => $request->cbo_indent_category,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date("Y-m-d"),
                'entry_time' => date("h:i:sa"),
                'status' => '1',
                'rr_status' => '1',
                'cancel_status' => '1',
                'in_status' => '0',
                'valid' => '1',
            ]);
        }

        return redirect()->route('purchase_indent_edit', [$indent_no, $request->cbo_company_id]);
    }

    public function purchase_indent_edit($id, $id2)
    {
        $pro_indent_master = DB::table("pro_indent_master_$id2")
            ->leftJoin('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->leftJoin("pro_company", "pro_indent_master_$id2.company_id", "pro_company.company_id")
            ->select("pro_indent_master_$id2.*", 'pro_indent_category.category_name', 'pro_project_name.project_name', 'pro_company.company_name')
            ->where("pro_indent_master_$id2.indent_no", '=', $id)
            ->where("pro_indent_master_$id2.status", '=', '1')
            ->first();

        $pro_indent_detail_all = DB::table("pro_indent_details_$id2")
            ->leftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$id2.*", "pro_product_group_$id2.pg_name", "pro_product_sub_group_$id2.pg_sub_name", "pro_product_$id2.product_name", "pro_product_$id2.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$id2.indent_no", '=', $id)
            ->where("pro_indent_details_$id2.status", '=', '1')
            ->get();


        $pro_indent_category = DB::table('pro_indent_category')->get();
        $pro_project_name = DB::table('pro_project_name')->get();
        $pro_product_group = DB::table("pro_product_group_$id2")->get();
        $pro_section_information = DB::table('pro_section_information')->get();
        return view('purchase.indent_info', compact('pro_indent_master', 'pro_indent_detail_all', 'pro_indent_category', 'pro_project_name', 'pro_product_group', 'pro_section_information'));
    }

    public function purchase_indent_update($id, $id2)
    {
        $pro_indent_detail_edit = DB::table("pro_indent_details_$id2")
            ->leftJoin('pro_project_name', "pro_indent_details_$id2.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_indent_details_$id2.indent_category", 'pro_indent_category.category_id')
            ->leftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->leftJoin("pro_company", "pro_indent_details_$id2.company_id", "pro_company.company_id")
            ->select(
                "pro_indent_details_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_product_$id2.product_name",
                'pro_section_information.section_name',
                'pro_indent_category.category_name',
                'pro_project_name.project_name',
                'pro_company.company_name',
            )
            ->where("pro_indent_details_$id2.indent_details_id", '=', $id)
            ->first();

        $pro_indent_category = DB::table('pro_indent_category')->get();
        $pro_project_name = DB::table('pro_project_name')->get();
        $pro_product_group = DB::table("pro_product_group_$id2")->get();
        $pro_section_information = DB::table('pro_section_information')->get();
        return view('purchase.indent_info', compact('pro_indent_detail_edit', 'pro_indent_category', 'pro_project_name', 'pro_product_group', 'pro_section_information'));
    }
    public function purchase_indent_update2(Request $request, $id, $id2)
    {
        $rules = [
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            'cbo_section' => 'required|integer|between:1,99999999',
            'txt_product_quanity' => 'required',

        ];

        $customMessages = [
            'cbo_product_group.required' => 'product group field is required!',
            'cbo_product_group.integer' => 'product group field is required!',
            'cbo_product_group.between' => 'product group field is required!',
            'cbo_product_sub_group.required' => 'product Sub group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub group field is required!',
            'cbo_product_sub_group.between' => 'product Sub group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            'cbo_section.required' => 'section field is required!',
            'cbo_section.integer' => 'section field is required!',
            'cbo_section.between' => 'section field is required!',
            'txt_product_quanity.required' => 'product quanity field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['description'] = $request->txt_product_description;
        $data['remarks'] = $request->txt_remarks;
        $data['section_id'] = $request->cbo_section;
        $data['qty'] = $request->txt_product_quanity;
        $data['req_date'] = $request->txt_req_date;
        DB::table("pro_indent_details_$id2")->where('indent_details_id', $id)->update($data);
        return redirect()->route('purchase_indent_edit', [$request->txt_indent_no, $id2])->with('success', 'Update Successfull !');
    }

    public function purchase_indent_add_another(Request $request)
    {
        $rules = [
            'cbo_project_id' => 'required',
            'cbo_indent_category' => 'required',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            'cbo_section' => 'required|integer|between:1,99999999',
            'txt_product_quanity' => 'required',

        ];

        $customMessages = [
            'cbo_project_id.required' => 'project name field is required!',
            'cbo_indent_category.required' => 'indent category field is required!',
            'cbo_product_group.required' => 'product group field is required!',
            'cbo_product_group.integer' => 'product group field is required!',
            'cbo_product_group.between' => 'product group field is required!',
            'cbo_product_sub_group.required' => 'product Sub group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub group field is required!',
            'cbo_product_sub_group.between' => 'product Sub group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            'cbo_section.required' => 'section field is required!',
            'cbo_section.integer' => 'section field is required!',
            'cbo_section.between' => 'section field is required!',
            'txt_product_quanity.required' => 'product quanity field is required!',

        ];
        $this->validate($request, $rules, $customMessages);



        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->txt_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['indent_category'] = $request->cbo_indent_category;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['product_unit'] = $request->txt_unit_id;
        $data['description'] = $request->txt_product_description;
        $data['remarks'] = $request->txt_remarks;
        $data['section_id'] = $request->cbo_section;
        $data['qty'] = $request->txt_product_quanity;
        $data['valid'] = '1';
        $data['status'] = '1';
        $data['rr_status'] = '1';
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['indent_no'] = $request->txt_indent_no;
        $data['req_date'] = $request->txt_req_date;
        $inserted_id = DB::table("pro_indent_details_$request->txt_id")->insertGetId($data);
        return redirect()->route('purchase_indent_edit', [$request->txt_indent_no, $request->txt_id]);
    }

    public function purchase_indent_final($id, $id2)
    {
        DB::table("pro_indent_details_$id2")
            ->where('indent_no', '=', $id)
            ->update(['status' => '2']);

        DB::table("pro_indent_master_$id2")
            ->where('indent_no', '=', $id)
            ->update(['status' => '2']);

        return redirect()->route('indent_info')->with('success', 'Indent Add Successfull !');
    }

    public function purchase_indent_list_for_approval()
    {
        return view('purchase.indent_list_for_approval');
    }

    public function company_wise_indent_approval(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $pro_indent_master  = DB::table("pro_indent_master_$request->cbo_company_id")
            ->join('pro_project_name', "pro_indent_master_$request->cbo_company_id.project_id", 'pro_project_name.project_id')
            ->join('pro_indent_category', "pro_indent_master_$request->cbo_company_id.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$request->cbo_company_id.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$request->cbo_company_id.status", '=', '2')
            ->orderby('indent_no', 'DESC')
            ->get();

        return view('purchase.indent_list_for_approval', compact('pro_indent_master'));
    }

    public function purchase_indent_approval($id, $id2)
    {
        $pro_indent_detail_all = DB::table("pro_indent_details_$id2")
            ->join("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->join('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$id2.*", "pro_product_$id2.product_name", "pro_product_$id2.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$id2.indent_no", '=', $id)
            ->where("pro_indent_details_$id2.status", '=', '2')
            ->get();

        $pro_indent_master  = DB::table("pro_indent_master_$id2")
            ->join('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->join('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$id2.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$id2.indent_no", '=', $id)
            ->where("pro_indent_master_$id2.status", '=', '2')
            ->first();

        return view('purchase.indent_approval', compact('pro_indent_detail_all', 'pro_indent_master'));
    }
    public function purchase_indent_approval_ok(Request $request, $id, $id2)
    {
        $rules = [
            'txt_app_qty' => 'required',
        ];

        $customMessages = [
            'txt_app_qty.required' => 'Approved qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['approved_by'] = Auth::user()->emp_id;
        $data['approved_qty'] = $request->txt_app_qty;
        date_default_timezone_set("Asia/Dhaka");
        $data['approved_date'] = date("Y-m-d");
        $data['approved_time'] = date("h:i:sa");
        $data['status'] = '3';

        DB::table("pro_indent_details_$id2")
            ->where('indent_details_id', '=', $id)
            ->update($data);

        $status3 = DB::table("pro_indent_details_$id2")
            ->where('indent_no', '=', $request->txt_indent_no)
            ->where('status', '=', '3')
            ->pluck('indent_details_id');

        $allstatus = DB::table("pro_indent_details_$id2")
            ->where('indent_no', '=', $request->txt_indent_no)
            ->pluck('indent_details_id');

        if (count($status3) == count($allstatus)) {
            DB::table("pro_indent_master_$id2")
                ->where('indent_no', '=', $request->txt_indent_no)
                ->update(['status' => '3']);
            return redirect()->route('indent_list_for_approval');
        } else {
            return back()->with('success', 'Approved Successfull !');
        }
    }

    public function purchase_indent_list_report()
    {
        // $pro_indent_master  = DB::table('pro_indent_master')
        //     ->join('pro_project_name', 'pro_indent_master.project_id', 'pro_project_name.project_id')
        //     ->join('pro_indent_category', 'pro_indent_master.indent_category', 'pro_indent_category.category_id')
        //     ->join('pro_employee_info', 'pro_indent_master.user_id', 'pro_employee_info.employee_id')
        //     ->select('pro_indent_master.*', 'pro_project_name.project_name', 'pro_indent_category.category_name', 'pro_employee_info.employee_name')
        //     ->where('pro_indent_master.status', '=', '2')
        //     ->orWhere('pro_indent_master.status', '=', '3')
        //     ->get();

        return view('purchase.indent_list_report');
    }

    public function company_wise_indent_report(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        if ($request->txt_from_date) {

            if ($request->txt_to_date == null) {
                // return redirect()->back()->with('warning','To Date field is required!');  
                $rules = [
                    'txt_to_date' => 'required',

                ];
                $customMessages = [
                    'txt_to_date.required' => 'To Date is required!',

                ];
                $this->validate($request, $rules, $customMessages);
            }
            return redirect()->route('company_wise_indent_report2', [$company_id, $request->txt_from_date, $request->txt_to_date]);
        } else {
            return redirect()->route('company_wise_indent_report2', [$company_id, 0, 0]);
        }
    }

    public function company_wise_indent_report2($company_id, $date1, $date2)
    {

        if ($date1 != 0) {

            $pro_indent_master  = DB::table("pro_indent_master_$company_id")
                ->leftJoin('pro_project_name', "pro_indent_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_indent_category', "pro_indent_master_$company_id.indent_category", 'pro_indent_category.category_id')
                ->leftJoin('pro_employee_info', "pro_indent_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->select("pro_indent_master_$company_id.*", 'pro_project_name.project_name', 'pro_indent_category.category_name', 'pro_employee_info.employee_name')
                ->where("pro_indent_master_$company_id.company_id", $company_id)
                // ->where("pro_indent_master_$company_id.status", '=', '2')
                // ->orWhere("pro_indent_master_$company_id.status", '=', '3')
                ->whereIn("pro_indent_master_$company_id.status", ['2', '3'])
                ->whereBetween("pro_indent_master_$company_id.entry_date", [$date1, $date2])
                ->orderby("pro_indent_master_$company_id.indent_no", 'DESC')
                ->get();
        } else {

            $pro_indent_master  = DB::table("pro_indent_master_$company_id")
                ->leftJoin('pro_project_name', "pro_indent_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_indent_category', "pro_indent_master_$company_id.indent_category", 'pro_indent_category.category_id')
                ->leftJoin('pro_employee_info', "pro_indent_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->select("pro_indent_master_$company_id.*", 'pro_project_name.project_name', 'pro_indent_category.category_name', 'pro_employee_info.employee_name')
                ->where("pro_indent_master_$company_id.company_id", $company_id)
                // ->where("pro_indent_master_$company_id.status", '=', '2')
                // ->orWhere("pro_indent_master_$company_id.status", '=', '3')
                ->whereIn("pro_indent_master_$company_id.status", ['2', '3'])
                ->orderby("pro_indent_master_$company_id.indent_no", 'DESC')
                ->take('10')
                ->get();
        }
        return view('purchase.indent_list_report', compact('pro_indent_master'));
    }


    public function purchase_indent_view($id, $id2)
    {

        $pro_indent_master = DB::table("pro_indent_master_$id2")
            ->LeftJoin('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$id2.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$id2.indent_id", '=', $id)
            ->first();

        $pro_indent_detail_all = DB::table("pro_indent_details_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->LeftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$id2.*", "pro_product_group_$id2.pg_name", "pro_product_sub_group_$id2.pg_sub_name", "pro_product_$id2.product_name", "pro_product_$id2.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$id2.indent_no", '=', $pro_indent_master->indent_no)
            ->where("pro_indent_details_$id2.status", '!=', '1')
            ->get();

        return view('purchase.indent_report_view', compact('pro_indent_detail_all', 'pro_indent_master'));
    }
    public function purchase_indent_view_print($id, $id2)
    {
        $pro_indent_master = DB::table("pro_indent_master_$id2")
            ->LeftJoin('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$id2.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$id2.indent_id", '=', $id)
            ->first();

        $pro_indent_detail_all = DB::table("pro_indent_details_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->LeftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$id2.*", "pro_product_group_$id2.pg_name", "pro_product_sub_group_$id2.pg_sub_name", "pro_product_$id2.product_name", "pro_product_$id2.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$id2.indent_no", '=', $pro_indent_master->indent_no)
            ->where("pro_indent_details_$id2.status", '!=', '1')
            ->get();

        return view('purchase.indent_report_view_print', compact('pro_indent_detail_all', 'pro_indent_master'));
    }

    public function RPTIndentExcel($id, $id2)
    {

        $ci_indent_master_excel = DB::table("pro_indent_master_$id2")
            ->where("pro_indent_master_$id2.indent_id", '=', $id)
            ->first();

        $txt_indent_no = $ci_indent_master_excel->indent_no;
        $filename = "$txt_indent_no";         //File Name
        $file_ending = "xls";

        //header info for browser
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$filename.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");


        //tabbed character
        $sep = "\t";
        $new = "\n";

        // Column names 
        $fields = array('SL No.', 'Product Group', 'Product Name', 'Section', 'Indent Qty', 'Approved Qty', 'RR Qty', 'Unit', 'Remarks', 'Product Require Date');

        // Display column names as first row 
        $excelColume = implode($sep, array_values($fields)) . $new;
        echo $excelColume;

        // Display My data 
        $data =  DB::table("pro_indent_details_$id2")
            ->leftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->leftJoin('pro_units', "pro_indent_details_$id2.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_indent_details_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_product_$id2.product_name",
                'pro_section_information.section_name',
                'pro_units.unit_name',
            )
            ->where("pro_indent_details_$id2.indent_no", $txt_indent_no)
            ->get();

        foreach ($data as $key => $row) {
            $key = $key + 1;
            $value = array("$key", "$row->pg_name/$row->pg_sub_name", "$row->product_name/$row->description", "$row->section_name", "$row->qty", "$row->approved_qty", "$row->rr_qty", "$row->unit_name", "$row->remarks", "$row->req_date");
            $result = implode($sep, array_values($value)) . $new;
            echo $result;
        }
        // return back();
    }


    //closing_stock_price
    public function closing_stock_price()
    {
        $m_projects = DB::table('pro_project_name')->where('valid', 1)->get();
        return view('purchase.closing_stock_price', compact('m_projects'));
    }
    public function closing_stock_price_details(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_project_id' => 'required|integer|between:1,99999999',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',
            'cbo_project_id.required' => 'Project is required!',
            'cbo_project_id.integer' => 'Project is required!',
            'cbo_project_id.between' => 'Project is required!',
            'cbo_product_group.required' => 'Product Group is required!',
            'cbo_product_group.integer' => 'Product Group is required!',
            'cbo_product_group.between' => 'Product Group is required!',
            'cbo_product_sub_group.required' => 'Product Sub Group field is required!',
            'cbo_product_sub_group.integer' => 'Product Sub Group field is required!',
            'cbo_product_sub_group.between' => 'Product Sub Group field is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        return redirect()->route('closing_stock_price_details_edit', ['project_id' => $request->cbo_project_id, 'pg_id' => $request->cbo_product_group, "pg_sub_id" => $request->cbo_product_sub_group, 'id2' => $request->cbo_company_id]);
    }

    public function closing_stock_price_details_edit($project_id, $pg_id, $pg_sub_id, $id2)
    {
        $m_stock_closing = DB::table("pro_stock_closing_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_stock_closing_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_stock_closing_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin('pro_project_name', "pro_stock_closing_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin("pro_product_$id2", "pro_stock_closing_$id2.product_id", "pro_product_$id2.product_id")
            ->select(
                "pro_stock_closing_$id2.*",
                'pro_project_name.project_name',
                "pro_product_$id2.product_name",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
            )
            ->where("pro_stock_closing_$id2.project_id", $project_id)
            ->where("pro_stock_closing_$id2.pg_id", $pg_id)
            ->where("pro_stock_closing_$id2.pg_sub_id", $pg_sub_id)
            ->where("pro_stock_closing_$id2.price_status", 0)
            ->where("pro_stock_closing_$id2.valid", 1)
            ->get();

        $all_stock_closing = DB::table("pro_stock_closing_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_stock_closing_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_stock_closing_$id2.pg_sub_id",  "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin('pro_project_name', "pro_stock_closing_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin("pro_product_$id2", "pro_stock_closing_$id2.product_id", "pro_product_$id2.product_id")
            ->select(
                "pro_stock_closing_$id2.*",
                'pro_project_name.project_name',
                "pro_product_$id2.product_name",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
            )
            ->where("pro_stock_closing_$id2.project_id", $project_id)
            ->where("pro_stock_closing_$id2.pg_id", $pg_id)
            ->where("pro_stock_closing_$id2.pg_sub_id", $pg_sub_id)
            ->where("pro_stock_closing_$id2.price_status", 1)
            ->where("pro_stock_closing_$id2.valid", 1)
            ->get();


        if ($m_stock_closing->count() == 0 && $all_stock_closing->count() == 0) {
            return redirect()->route('closing_stock_price')->with('warning', 'Data Not found.');
        }
        return view('purchase.closing_stock_price_details', compact('m_stock_closing', 'all_stock_closing'));
    }

    public function closing_stock_price_details_update(Request $request, $id, $id2)
    {
        $all_rr_details = DB::table("pro_stock_closing_$id2")
            ->where('stock_closing_id', $id)
            ->update([
                'price_user_id' => Auth::user()->emp_id,
                'company_id' => $id2,
                'product_rate' => $request->txt_product_rate,
                'received_total' => ($request->txt_product_rate * $request->txt_qty),
                'price_status' => 1,
                'price_entry_date' => date("Y-m-d"),
                'price_entry_time' => date("h:i:sa"),
            ]);
        return back()->with('success', 'Updated Sucessfull !');
    }
    //End closing stock price



    //rr price list
    public function purchase_rr_price_list()
    {
        return view('purchase.rr_price_list');
    }

    public function company_wise_rr_price(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $pro_indent_master  = DB::table("pro_grr_master_$company_id")
            ->leftJoin('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->leftJoin('pro_supplier_information', "pro_grr_master_$company_id.supplier_id", 'pro_supplier_information.supplier_id')
            ->select(
                "pro_grr_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                'pro_supplier_information.supplier_address',
                'pro_supplier_information.supplier_name'
            )
            ->where("pro_grr_master_$company_id.status", '=', '2')
            ->where("pro_grr_master_$company_id.price_status", '=', '0')
            ->get();
        return view('purchase.rr_price_list', compact('pro_indent_master'));
    }

    public function purchase_material_price($id, $id2)
    {
        $pro_indent_master  = DB::table("pro_grr_master_$id2")
            ->leftJoin('pro_project_name', "pro_grr_master_$id2.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_grr_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->leftJoin('pro_supplier_information', "pro_grr_master_$id2.supplier_id", 'pro_supplier_information.supplier_id')
            ->select(
                "pro_grr_master_$id2.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                'pro_supplier_information.supplier_address',
                'pro_supplier_information.supplier_name'
            )
            ->where("pro_grr_master_$id2.grr_master_id", $id)
            ->first();

        $pro_grr_details  = DB::table("pro_grr_details_$id2")
            ->leftJoin("pro_product_$id2", "pro_grr_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftJoin('pro_units', "pro_grr_details_$id2.unit", 'pro_units.unit_id')
            ->select(
                "pro_grr_details_$id2.*",
                "pro_product_$id2.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_grr_details_$id2.grr_no", $pro_indent_master->grr_no)
            ->where("pro_grr_details_$id2.price_status", '0')
            ->get();

        return view('purchase.material_price', compact('pro_indent_master', 'pro_grr_details'));
    }

    public function purchase_material_price_update(Request $request, $id, $id2)
    {
        $rules = [
            'txt_rate' => 'required',
            'txt_total' => 'required',
        ];

        $customMessages = [
            'txt_rate.required' => 'Rate is required!',
            'txt_total.required' => 'Total is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['price_user_id'] = Auth::user()->emp_id;
        $data['product_rate'] = $request->txt_rate;
        $data['received_total'] = $request->txt_total;
        $data['price_status'] = '1';
        $data['price_entry_date'] = date("Y-m-d");
        $data['price_entry_time'] = date("h:i:sa");
        // dd($data);
        DB::table("pro_grr_details_$id2")->where('grr_details_id', $id)->update($data);

        $data  = DB::table("pro_grr_details_$id2")
            ->where('grr_no', $request->txt_grr_no)
            ->where('price_status', 1)
            ->get();

        $data2  = DB::table("pro_grr_details_$id2")
            ->where('grr_no', $request->txt_grr_no)
            ->get();

        if (count($data) == count($data2)) {
            $pro_indent_master  = DB::table("pro_grr_master_$id2")
                ->where('grr_no', $request->txt_grr_no)
                ->update(['price_status' => 1]);
            return redirect()->route('rr_price_list')->with('success', 'Successfull !');
        } else {
            return redirect()->back()->with('success', 'Price Add Successfull !');
        }
    }

    // Report RR Price List

    public function rpt_rr_price_list()
    {
        return view('purchase.rpt_rr_price_list');
    }

    public function company_wise_rr_price_list(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $pro_indent_master  = DB::table("pro_grr_master_$company_id")
            ->join('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
            ->join('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->join('pro_supplier_information', "pro_grr_master_$company_id.supplier_id", 'pro_supplier_information.supplier_id')
            ->select(
                "pro_grr_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                'pro_supplier_information.supplier_address',
                'pro_supplier_information.supplier_name'
            )
            // ->where('pro_grr_master.status', '=', '2')
            ->where("pro_grr_master_$company_id.price_status", '=', '1')
            ->get();

        return view('purchase.rpt_rr_price_list', compact('pro_indent_master'));
    }

    public function rpt_rr_price_list_view($id, $id2)
    {
        $pro_grr_master  = DB::table("pro_grr_master_$id2")
            ->LeftJoin('pro_project_name', "pro_grr_master_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_indent_category', "pro_grr_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->LeftJoin('pro_supplier_information', "pro_grr_master_$id2.supplier_id", 'pro_supplier_information.supplier_id')
            ->select(
                "pro_grr_master_$id2.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                'pro_supplier_information.supplier_address',
                'pro_supplier_information.supplier_name'
            )
            ->where('grr_master_id', $id)
            ->first();

        $pro_grr_details  = DB::table("pro_grr_details_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_grr_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_grr_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin("pro_product_$id2", "pro_grr_details_$id2.product_id", "pro_product_$id2.product_id")
            ->select(
                "pro_grr_details_$id2.*",
                "pro_product_$id2.product_name",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
            )
            ->where("pro_grr_details_$id2.grr_no", $pro_grr_master->grr_no)
            ->where("pro_grr_details_$id2.price_status", 1)
            ->get();

        return view('purchase.rpt_rr_price_list_view', compact('pro_grr_master', 'pro_grr_details'));
    }

    public function rpt_rr_price_list_print($id, $id2)
    {

        $pro_grr_master  = DB::table("pro_grr_master_$id2")
            ->LeftJoin('pro_project_name', "pro_grr_master_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_indent_category', "pro_grr_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->LeftJoin('pro_supplier_information', "pro_grr_master_$id2.supplier_id", 'pro_supplier_information.supplier_id')
            ->select(
                "pro_grr_master_$id2.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                'pro_supplier_information.supplier_address',
                'pro_supplier_information.supplier_name'
            )
            ->where('grr_master_id', $id)
            ->first();

        $pro_grr_details  = DB::table("pro_grr_details_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_grr_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_grr_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin("pro_product_$id2", "pro_grr_details_$id2.product_id", "pro_product_$id2.product_id")
            ->select(
                "pro_grr_details_$id2.*",
                "pro_product_$id2.product_name",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
            )
            ->where("pro_grr_details_$id2.grr_no", $pro_grr_master->grr_no)
            ->where("pro_grr_details_$id2.price_status", 1)
            ->get();

        return view('purchase.rpt_rr_price_list_print', compact('pro_grr_master', 'pro_grr_details'));
    }

    //Ene report RR Price

    //Ajax call
    public function GetIndentProductGroup($id2)
    {
        $data = DB::table("pro_product_group_$id2")->where('valid', 1)->get();
        return json_encode($data);
    }
    public function GetProduct($id, $id2)
    {
        $data = DB::table("pro_product_$id2")->where('pg_sub_id', $id)->where('valid', 1)->get();
        return json_encode($data);
    }

    public function GetPurchaseProductSubGroup($id, $id2)
    {
        $data = DB::table("pro_product_sub_group_$id2")->where('pg_id', $id)->where('valid', 1)->get();
        return json_encode($data);
    }

    public function GetPurchaseIndentProductSubGroup($id, $indent_no, $id2)
    {
        $pg_sub_id = DB::table("pro_indent_details_$id2")->where('indent_no', '=', $indent_no)->pluck('pg_sub_id');
        $data = DB::table("pro_product_sub_group_$id2")
            // ->whereNotIn('pg_sub_id',$pg_sub_id)
            ->where('pg_id', $id)
            ->get();
        return json_encode($data);
    }
    public function GetPurchaseUnit($id, $id2)
    {
        $data = DB::table("pro_product_$id2")->where('product_id', $id)
            ->leftJoin('pro_units', "pro_product_$id2.unit", 'pro_units.unit_id')
            ->select("pro_product_$id2.*", 'pro_units.unit_name', 'pro_units.unit_id')
            ->first();
        return json_encode($data);
    }



    public function GetPurchaseIndentProduct($id, $indent_no, $id2)
    {
        $purchase_product_id = DB::table("pro_indent_details_$id2")->where('indent_no', '=', $indent_no)->pluck('product_id');
        $data = DB::table("pro_product_$id2")
            ->whereNotIn('product_id', $purchase_product_id)
            ->where('pg_sub_id', $id)
            ->get();
        return json_encode($data);
    }
    public function GetPurchaseIndentListReport()
    {
        $data  = DB::table('pro_indent_master')
            ->join('pro_project_name', 'pro_indent_master.project_id', 'pro_project_name.project_id')
            ->join('pro_indent_category', 'pro_indent_master.indent_category', 'pro_indent_category.category_id')
            ->select('pro_indent_master.*', 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where('pro_indent_master.status', '=', '2')
            ->orWhere('pro_indent_master.status', '=', '3')
            ->orderby('indent_no', 'DESC')
            ->get();

        return json_encode($data);
    }

    //Get closing stock price sub group
    public function GetClosingStockProductSubGroup($id, $id2)
    {
        $data = DB::table("pro_product_sub_group_$id2")->where('pg_id', $id)->get();
        return json_encode($data);
    }


    //indent copy 
    public function indent_copy()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.purchase_status', '1')
            ->get();
        return view('purchase.indent_copy', compact('user_company'));
    }

    public function indent_copy_search(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

            'txt_from_date.required' => 'Form is required!',
            'txt_to_date.required' => 'To is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;

        if ($request->txt_from_date < '2023-01-01') {
            return back()->with('warning', 'Please select form date 2023-01-01');
        }

        $pro_indent_master  = DB::table("pro_indent_master_$company_id")
            ->leftJoin('pro_project_name', "pro_indent_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_indent_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->leftJoin('pro_employee_info', "pro_indent_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select("pro_indent_master_$company_id.*", 'pro_project_name.project_name', 'pro_indent_category.category_name', 'pro_employee_info.employee_name')
            ->where("pro_indent_master_$company_id.company_id", $company_id)
            // ->whereIn("pro_indent_master_$company_id.status", ['2','3'])
            ->whereBetween("pro_indent_master_$company_id.entry_date", [$request->txt_from_date, $request->txt_to_date])
            ->orderby("pro_indent_master_$company_id.indent_no", 'DESC')
            ->get();

        return view('purchase.indent_copy', compact('pro_indent_master'));
    }

    public function indent_copy_details($id, $id2)
    {
        $pro_indent_master = DB::table("pro_indent_master_$id2")
            ->LeftJoin('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$id2.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$id2.indent_id", '=', $id)
            ->first();

        $pro_indent_detail_all = DB::table("pro_indent_details_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->LeftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$id2.*", "pro_product_group_$id2.pg_name", "pro_product_sub_group_$id2.pg_sub_name", "pro_product_$id2.product_name", "pro_product_$id2.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$id2.indent_no", '=', $pro_indent_master->indent_no)
            // ->where("pro_indent_details_$id2.status", '!=', '1')
            ->where("pro_product_$id2.valid", '1')
            ->get();

        return view('purchase.indent_copy_details', compact('pro_indent_master', 'pro_indent_detail_all'));
    }

    public function indent_copy_master($id, $id2)
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.purchase_status', '1')
            ->get();
        $pro_indent_category = DB::table('pro_indent_category')->get();
        $pro_project_name = DB::table('pro_project_name')->get();

        $pro_indent_master = DB::table("pro_indent_master_$id2")
            ->LeftJoin('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$id2.*", 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$id2.indent_id", '=', $id)
            ->first();
        return view('purchase.indent_copy_master', compact('pro_indent_master', 'pro_indent_category', 'pro_project_name', 'user_company'));
    }

    public function indent_copy_master_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_project_name' => 'required|integer|between:1,99999999',
            'cbo_indent_category' => 'required|integer|between:1,99999999',


        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',
            'cbo_project_name.required' => 'project name is required!',
            'cbo_project_name.integer' => 'project name is required!',
            'cbo_project_name.between' => 'project name is required!',
            'cbo_indent_category.required' => 'indent category is required!',
            'cbo_indent_category.integer' => 'indent category is required!',
            'cbo_indent_category.between' => 'indent category is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $company_id = $request->cbo_company_id;
        $last_indent = DB::table("pro_indent_master_$company_id")->orderByDesc("indent_no")->first();
        $indent_no = date("Ym") . str_pad((substr($last_indent->indent_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        $old_indent_no = $request->cbo_old_indent_no;

        DB::table("pro_indent_master_$company_id")->insert([
            'indent_no' => $indent_no,
            'company_id' => $company_id,
            'project_id' => $request->cbo_project_name,
            'indent_category' => $request->cbo_indent_category,
            'user_id' => $m_user_id,
            'entry_date' => date("Y-m-d"),
            'entry_time' => date("h:i:sa"),
            'status' => '1',
            'rr_status' => '1',
            'cancel_status' => '1',
            'in_status' => '0',
            'valid' => '1',
        ]);

        return redirect()->route('indent_copy_product_details', [$indent_no, $old_indent_no, $company_id]);
    }

    public function indent_copy_product_details($indent_no, $old_indent_no, $company_id)
    {
        $pro_indent_master  = DB::table("pro_indent_master_$company_id")
            ->LeftJoin('pro_project_name', "pro_indent_master_$company_id.project_id", 'pro_project_name.project_id')
            ->LeftJoin('pro_company', "pro_indent_master_$company_id.company_id", 'pro_company.company_id')
            ->LeftJoin('pro_indent_category', "pro_indent_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->select("pro_indent_master_$company_id.*", 'pro_company.company_name', 'pro_project_name.project_name', 'pro_indent_category.category_name')
            ->where("pro_indent_master_$company_id.indent_no", '=', $indent_no)
            ->first();

        $new_indent_product = DB::table("pro_indent_details_$company_id")
            ->where("pro_indent_details_$company_id.indent_no", '=', $indent_no)
            ->pluck('product_id');

        $m_indent_detail_all = DB::table("pro_indent_details_$company_id")
            ->leftJoin("pro_product_group_$company_id", "pro_indent_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftJoin("pro_product_sub_group_$company_id", "pro_indent_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftJoin("pro_product_$company_id", "pro_indent_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_section_information', "pro_indent_details_$company_id.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$company_id.*", "pro_product_group_$company_id.pg_name",  "pro_product_sub_group_$company_id.pg_sub_name", "pro_product_$company_id.product_name", "pro_product_$company_id.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$company_id.indent_no", '=', $old_indent_no)
            ->whereNotIn("pro_indent_details_$company_id.product_id", $new_indent_product)
            ->where("pro_product_$company_id.valid", '1')
            ->get();

        $new_indent_detail_all = DB::table("pro_indent_details_$company_id")
            ->leftJoin("pro_product_group_$company_id", "pro_indent_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftJoin("pro_product_sub_group_$company_id", "pro_indent_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftJoin("pro_product_$company_id", "pro_indent_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_section_information', "pro_indent_details_$company_id.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$company_id.*", "pro_product_group_$company_id.pg_name", "pro_product_sub_group_$company_id.pg_sub_name", "pro_product_$company_id.product_name", "pro_product_$company_id.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$company_id.indent_no", '=', $indent_no)
            ->get();

        $m_section_information = DB::table('pro_section_information')->get();
        return view('purchase.indent_copy_product_details', compact('pro_indent_master', 'm_indent_detail_all', 'new_indent_detail_all', 'm_section_information', 'indent_no', 'old_indent_no', 'company_id'));
    }

    public function indent_copy_product_details_add(Request $request)
    {
        $rules = [
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'txt_qty.required' => 'Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $company_id = $request->cbo_company_id;
        $indent_no = $request->txt_indent_no;

        $m_indent_detail = DB::table("pro_indent_details_$company_id")
            ->where("pro_indent_details_$company_id.indent_details_id", $request->txt_indent_details_id)
            ->first();
        if ($m_indent_detail) {
            $data = array();
            $data['user_id'] = $m_user_id;
            $data['indent_no'] = $indent_no;
            $data['company_id'] = $company_id;
            $data['project_id'] = $m_indent_detail->project_id;
            $data['indent_category'] = $m_indent_detail->indent_category;
            $data['pg_id'] = $m_indent_detail->pg_id;
            $data['pg_sub_id'] = $m_indent_detail->pg_sub_id;
            $data['product_id'] = $m_indent_detail->product_id;
            $data['product_unit'] = $m_indent_detail->product_unit;
            $data['description'] = $request->txt_description;
            $data['remarks'] = $request->txt_remarks;
            $data['section_id'] = $request->cbo_section;
            $data['qty'] = $request->txt_qty;
            $data['valid'] = '1';
            $data['status'] = '1';
            $data['rr_status'] = '1';
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['req_date'] = $request->txt_req_date;
            DB::table("pro_indent_details_$company_id")->insert($data);
            return back()->with('success', 'Add Successfull');
        } else {
            return back()->with('warning', 'Data Not found');
        }
    }
}
