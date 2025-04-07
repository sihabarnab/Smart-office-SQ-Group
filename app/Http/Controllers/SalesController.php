<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{

    //Customer
    public function customer_info()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        return view('sales.customer_info', compact('customer_type', 'user_company'));
    }

    public function customer_list($company_id)
    {
        $data = DB::table("pro_customer_information_$company_id")
            ->select(
                'customer_name',
                'customer_address',
                'customer_phone',
                'customer_email',
                'contact_person',
                'customer_id',
                'company_id',
            )
            ->Where('valid', '1')
            ->orderBy('customer_id', 'DESC')
            ->get();
        return response()->json($data);
    }

    public function GetAllCustomerTypeWise($id, $company_id)
    {
        $data = DB::table("pro_customer_information_$company_id")
            ->select(
                'customer_name',
                'customer_id',
            )
            ->Where('customer_type', $id)
            ->Where('valid', '1')
            ->orderBy('customer_id', 'ASC')
            ->get();
        return response()->json($data);
    }



    public function customer_info_store(Request $request)
    {
        $rules = [
            'cbo_company' => 'required',
            'txt_customer_name' => 'required',
            'txt_customer_add' => 'required',
            'cbo_customer_type_id' => 'required',
        ];
        $customMessages = [
            'cbo_company.required' => 'Select Company.',
            'txt_customer_name.required' => 'Customer Name is required.',
            'txt_customer_add.required' => 'Customer Address is required.',
            'cbo_customer_type_id.required' => 'Select Customer Type.',
        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company;
        $customer_type = DB::table('pro_customer_type')->where("customer_type_id", $request->cbo_customer_type_id)->first();
        $abcd = DB::table("pro_customer_information_$company_id")->where('customer_name', $request->txt_customer_name)->where('customer_address', $request->txt_customer_add)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['company_id'] = $company_id;
            $data['customer_name'] = $request->txt_customer_name;
            $data['customer_address'] = $request->txt_customer_add;
            $data['customer_phone'] = $request->txt_customer_phone;
            $data['customer_email'] = $request->txt_customer_email;
            $data['contact_person'] = $request->txt_contact_person;
            $data['customer_type'] = $request->cbo_customer_type_id;
            $data['customer_zip'] = $request->txt_zip;
            $data['customer_city'] = $request->txt_city;
            $data['customer_country'] = $request->txt_country;
            $data['customer_fax'] = $request->txt_customer_fax;
            $data['customer_url'] = $request->txt_customer_url;
            $data['cust_sppl'] = $customer_type->cust_sppl;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table("pro_customer_information_$company_id")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function customer_info_edit($id, $company_id)
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $m_customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $id)->first();
        $customer_type = DB::table('pro_customer_type')->get();
        return view('sales.customer_info', compact('m_customer', 'customer_type', 'user_company'));
    }

    public function customer_info_update(Request $request, $update)
    {

        $rules = [
            'txt_customer_name' => 'required',
            'txt_customer_add' => 'required',
            'cbo_company' => 'required',
        ];
        $customMessages = [
            'txt_customer_name.required' => 'Customer Name is required.',
            'txt_customer_add.required' => 'Customer Address is required.',
            'cbo_company.required' => 'Select Company.',
        ];

        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company;
        $customer_type = DB::table('pro_customer_type')->where("customer_type_id", $request->cbo_customer_type_id)->first();
        $ci_pro_customers = DB::table("pro_customer_information_$company_id")->where('customer_id', $request->txt_customer_id)->where('customer_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_customers === null) {

            DB::table("pro_customer_information_$company_id")->where('customer_id', $update)->update([
                'company_id' => $company_id,
                'customer_name' => $request->txt_customer_name,
                'customer_address' => $request->txt_customer_add,
                'customer_phone' => $request->txt_customer_phone,
                'customer_email' => $request->txt_customer_email,
                'contact_person' => $request->txt_contact_person,
                'customer_type' => $request->cbo_customer_type_id,
                'cust_sppl' => $customer_type->cust_sppl,
                'customer_zip' => $request->txt_zip,
                'customer_city' => $request->txt_city,
                'customer_country' => $request->txt_country,
                'customer_fax' => $request->txt_customer_fax,
                'customer_url' => $request->txt_customer_url,
                'last_user_id' => Auth::user()->emp_id,
                'last_edit_date' => date("Y-m-d"),
                'last_edit_time' => date("h:i:sa"),
            ]);

            return redirect(route('customer_info'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }
    //End Customer 

    // sales Rate Chart Start
    public function rateChart()
    {
        return view('sales.rate_chart');
    }
    public function GetSalesFinishProductList($company_id)
    {
        $data = DB::table("pro_finish_product_$company_id")->where('valid', 1)->get();
        return response()->json($data);
    }

    //Store
    public function rateChartStore(Request $request)
    {


        $rules = [
            'cbo_company' => 'required',
            'cbo_rate_category' => 'required',
            'cbo_product_id' => 'required',
            'txt_unit_price' => 'required',

        ];
        $customMessages = [
            'cbo_company.required' => 'Select Company.',
            'cbo_rate_category.required' => 'Select rate category.',
            'cbo_product_id.required' => 'Select product  name.',
            'txt_unit_price.required' => 'Unit price is required.',

        ];
        $this->validate($request, $rules, $customMessages);

        $check =  DB::table("pro_rate_chart_$request->cbo_company")
            ->where('product_id', $request->cbo_product_id)
            ->first();
        if ($check) {
            return back()->with('warning', 'Data Alredy Inserted ');
        } else {

            $data = array();
            $data['company_id'] = $request->cbo_company;
            $data['rate_group'] = $request->cbo_rate_category;
            $data['product_id'] = $request->cbo_product_id;
            $data['rate'] = $request->txt_unit_price;
            $data['remarks'] = $request->txt_remarks;
            $data['user_id'] = Auth::user()->emp_id;
            $data['valid'] = 1;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');

            DB::table("pro_rate_chart_$request->cbo_company")->insert($data);
            return back()->with('success', 'Data Inserted Successfully!');
        }
    }
    //Edit
    public function rateChartEdit($id, $company_id)
    {

        $e_rate = DB::table("pro_rate_chart_$company_id")
            ->where('rate_chart_id', $id)
            ->first();
        $product = DB::table("pro_finish_product_$company_id")
            ->where('product_id', $e_rate->product_id)
            ->first();
        return view('sales.rate_chart', compact('e_rate', 'product'));
    }

    //Update
    public function rateChartUpdate(Request $request, $update)
    {
        $rules = [
            'txt_unit_price' => 'required',
        ];
        $customMessages = [
            'txt_unit_price.required' => 'Unit price is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['rate'] = $request->txt_unit_price;
        $data['remarks'] = $request->txt_remarks;
        $data['user_id'] = Auth::user()->emp_id;
        DB::table("pro_rate_chart_$request->cbo_company")->where('rate_chart_id', $update)->update($data);
        return redirect()->route('rate_chart')->with('success', 'Data Updated Successfully!');
    }

    public function rateChartList($company_id)
    {
        $data = DB::table("pro_rate_chart_$company_id")
            ->leftJoin('pro_company', "pro_rate_chart_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_finish_product_$company_id", "pro_rate_chart_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select("pro_rate_chart_$company_id.*", "pro_finish_product_$company_id.product_name", 'pro_company.company_name', "pro_finish_product_$company_id.model_size", "pro_finish_product_$company_id.product_description")
            ->get();

        return response()->json($data);
    }

    //report rate chart
    public function rpt_rate_chart()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        return view('sales.rpt_rate_chart', compact('user_company'));
    }
    public function rpt_rate_chart_list(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $company_id = $request->cbo_company_id;
        $pg_group = $request->cbo_transformer;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();


        if ($request->cbo_transformer) {
            $m_rate_chart = DB::table("pro_rate_chart_$company_id")
                ->leftJoin('pro_company', "pro_rate_chart_$company_id.company_id", 'pro_company.company_id')
                ->leftJoin("pro_finish_product_$company_id", "pro_rate_chart_$company_id.product_id", "pro_finish_product_$company_id.product_id")
                ->select("pro_rate_chart_$company_id.rate_group", "pro_rate_chart_$company_id.rate", "pro_rate_chart_$company_id.remarks", "pro_finish_product_$company_id.product_name", 'pro_company.company_name', "pro_finish_product_$company_id.product_description")
                ->where("pro_finish_product_$company_id.pg_id", $request->cbo_transformer)
                ->where("pro_finish_product_$company_id.valid", 1)
                ->where("pro_rate_chart_$company_id.valid", 1)
                ->orderByDesc('rate_chart_id')
                ->get();
        } else {
            $m_rate_chart = DB::table("pro_rate_chart_$company_id")
                ->leftJoin('pro_company', "pro_rate_chart_$company_id.company_id", 'pro_company.company_id')
                ->leftJoin("pro_finish_product_$company_id", "pro_rate_chart_$company_id.product_id", "pro_finish_product_$company_id.product_id")
                ->select("pro_rate_chart_$company_id.rate_group", "pro_rate_chart_$company_id.rate", "pro_rate_chart_$company_id.remarks", "pro_finish_product_$company_id.product_name", 'pro_company.company_name', "pro_finish_product_$company_id.product_description")
                ->where("pro_finish_product_$company_id.valid", 1)
                ->where("pro_rate_chart_$company_id.valid", 1)
                ->orderByDesc('rate_chart_id')
                ->get();
        }

        return view('sales.rpt_rate_chart_list', compact('user_company', 'm_rate_chart', 'pg_group', 'company_id'));
    }
    //end rate chart




    // sales Rate Policy Start
    public function ratePolicy()
    {
        return view('sales.rate_policy');
    }

    //Store
    public function ratePolicyStore(Request $request)
    {

        $rules = [
            'cbo_company' => 'required',
            'txt_policy_name' => 'required',
            'cbo_rate_category' => 'required',
            'cbo_discount_type' => 'required',

        ];
        $customMessages = [
            'cbo_company.required' => 'Select Company.',
            'txt_policy_name.required' => 'Policy name is required.',
            'cbo_rate_category.required' => 'Select rate category.',
            'cbo_discount_type.required' => 'Discount type is required.',

        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['company_id'] = $request->cbo_company;
        $data['rate_policy_name'] = $request->txt_policy_name;
        $data['rate_group'] = $request->cbo_rate_category;
        $data['discount_type'] = $request->cbo_discount_type; //1 (% value ). 2 (Fixed value)
        $data['discount'] = $request->txt_discount;
        $data['remarks'] = $request->txt_remarks;
        $data['user_id'] = Auth::user()->emp_id;
        $data['valid'] = 1;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date('H:i:s');

        DB::table("pro_rate_policy_$request->cbo_company")->insert($data);
        return back()->with('success', 'Data Inserted Successfully!');
    }
    //Edit
    public function ratePolicyEdit($id, $company_id)
    {
        $e_policy = DB::table("pro_rate_policy_$company_id")->where('rate_policy_id', $id)->first();
        return view('sales.rate_policy', compact('e_policy'));
    }

    //Update
    public function ratePolicyUpdate(Request $request, $update)
    {
        $rules = [
            'txt_policy_name' => 'required',
            'cbo_rate_category' => 'required',
            'cbo_discount_type' => 'required',

        ];
        $customMessages = [
            'txt_policy_name.required' => 'Policy name is required.',
            'cbo_rate_category.required' => 'Select rate category.',
            'cbo_discount_type.required' => 'Discount type is required.',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company;

        $data = array();
        $data['rate_policy_name'] = $request->txt_policy_name;
        $data['rate_group'] = $request->cbo_rate_category;
        $data['discount_type'] = $request->cbo_discount_type;
        $data['discount'] = $request->txt_discount;
        $data['remarks'] = $request->txt_remarks;
        $data['user_id'] = Auth::user()->emp_id;
        DB::table("pro_rate_policy_$company_id")->where('rate_policy_id', $update)->update($data);
        return redirect()->route('rate_policy')->with('success', 'Data Updated Successfully!');
    }

    public function ratePolicyList($company_id)
    {
        $data = DB::table("pro_rate_policy_$company_id")
            ->leftJoin('pro_company', "pro_rate_policy_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_rate_policy_$company_id.*", 'pro_company.company_name')
            ->get();
        return response()->json($data);
    }
    //end policy

    //financial_year
    public function financial_year()
    {
        $f_year =  DB::table("pro_financial_year")->get();
        return view('sales.financial_year', compact('f_year'));
    }

    public function financial_store(Request $request)
    {
        $rules = [
            'txt_financial_year' => 'required',
        ];
        $customMessages = [
            'txt_financial_year.required' => 'Select Company.',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['financial_year_name'] = $request->txt_financial_year;
        $data['valid'] = 1;
        DB::table("pro_financial_year")->insert($data);

        return back()->with('success', 'Add Successfully !');
    }

    //mushok
    public function mushok()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();

        return view('sales.mushok', compact('user_company'));
    }


    public function mushok_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_financial_year_id' => 'required',
            'txt_mushok_serial' => 'required',
            'txt_mushok_qty' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_financial_year_id.required' => 'Select Financial Year.',
            'txt_mushok_serial.required' => 'Mushok No. is Required.',
            'txt_mushok_qty.required' => 'Qty is Required.',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_financial_year = DB::table('pro_financial_year')->where('financial_year_id', $request->cbo_financial_year_id)->first();
        $financial_year_name = $m_financial_year == null ? '' : $m_financial_year->financial_year_name;
        $company_id = $request->cbo_company_id;
        $qty = $request->txt_mushok_qty;

        $data2 = array();
        $flag = 0;

        for ($i = 0; $i < $qty; $i++) {
            $mushok_number =  $request->txt_mushok_serial + $i;
            $check = DB::table("pro_mushok_$company_id")
                ->where("mushok_number", $mushok_number)
                ->where("financial_year_name", $financial_year_name)
                ->first();
            if ($check) {
                return back()->with('warning', 'Musuk No Alredy Inserted');
            } else {
                $flag = 1;
            } // if($check)

        } //for ($i = 0; $i < $qty; $i++)

        if ($flag == 1) {

            for ($i = 0; $i < $qty; $i++) {
                $mushok_number =  $request->txt_mushok_serial + $i;
                $data = array();
                $data['company_id'] = $company_id;
                $data['mushok_number'] =  $mushok_number;
                $data['financial_year_id'] = $request->cbo_financial_year_id;
                $data['financial_year_name'] = $financial_year_name;
                $data['user_id'] = Auth::user()->emp_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid'] = 1;
                DB::table("pro_mushok_$company_id")->insert($data);
                array_push($data2, $mushok_number);
            } //for ($i = 0; $i < $qty; $i++)

            $m_musuk = DB::table("pro_mushok_$company_id")
                ->leftJoin('pro_company', "pro_mushok_$company_id.company_id", 'pro_company.company_id')
                ->select("pro_mushok_$company_id.*", "pro_company.company_name")
                ->whereIn("pro_mushok_$company_id.mushok_number", $data2)
                ->where("pro_mushok_$company_id.financial_year_name", $financial_year_name)
                ->get();

            return back()->with(['success' => 'Add Successfully !', 'm_musuk' => $m_musuk]);
        } //if($flag == 1)
    }

    //RPT Mushok

    public function rpt_mushok_list()
    {
        return view('sales.rpt_mushok_list');
    }

    public function get_mushok_list($company_id)
    {
        $data = DB::table("pro_mushok_$company_id")
            ->leftJoin('pro_company', "pro_mushok_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_mushok_$company_id.*", "pro_company.company_name")
            ->where("pro_mushok_$company_id.valid", 1)
            ->orderByDesc('mushok_id')
            ->get();

        return response()->json($data);
    }
    // End Mushok  

    //finish_product_serial

    public function finish_product_serial()
    {
        return view('sales.finish_product_serial');
    }

    public function finish_product_serial_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_product_id' => 'required',
            'txt_serial' => 'required',
            'txt_qty' => 'required',
            'txt_year' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_product_id.required' => 'Select Product.',
            'txt_serial.required' => 'Serial Number required.',
            'txt_qty.required' => 'QTY required.',
            'txt_year.required' => 'Year required.',
        ];

        $this->validate($request, $rules, $customMessages);


        //
        $array_serial = (string)$request->txt_serial;
        $my_digit = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        for ($i = 0; $i < strlen($array_serial); $i++) {
            if (!in_array($array_serial[$i], $my_digit)) {
                return back()->with('warning', "Serial number only numeric!");
            }
        }
        //


        $m_product = DB::table("pro_finish_product_$request->cbo_company_id")
            ->where('product_id', $request->cbo_product_id)
            ->where('valid', 1)
            ->first();

        $data2 = array();
        $flag = 0;

        $check_length = strlen((string)$request->txt_serial);
        if ($check_length > 5) {
            return back()->with('warning', "Serial number maximum 5 digit.");
        } elseif ($request->txt_qty > 100) {
            return back()->with('warning', "Maximum serial qty 100.");
        } else {


            for ($i = 0; $i < $request->txt_qty; $i++) {
                $serial =  str_pad(($request->txt_serial + $i), 5, '0', STR_PAD_LEFT);
                $serial_no = "$request->txt_year-$m_product->model_size-$serial";
                $check =  DB::table("pro_finish_product_serial_$request->cbo_company_id")
                    ->where('serial_no', $serial_no)
                    ->first();

                if ($check) {
                    return back()->with('warning', 'Serial No Alredy Inserted');
                } else {
                    $flag = 1;
                }
            } //for ($i = 0; $i < $request->txt_qty; $i++)

            if ($flag == 1) {

                for ($i = 0; $i < $request->txt_qty; $i++) {

                    $serial =  str_pad(($request->txt_serial + $i), 5, '0', STR_PAD_LEFT);
                    $serial_no = "$request->txt_year-$m_product->model_size-$serial";
                    $data = array();
                    $data['company_id'] = $request->cbo_company_id;
                    $data['pg_id'] = $m_product->pg_id;
                    $data['product_id'] = $request->cbo_product_id;
                    $data['serial_no'] = $serial_no;
                    $data['user_id'] = Auth::user()->emp_id;
                    $data['entry_date'] = date("Y-m-d");
                    $data['entry_time'] = date("h:i:sa");
                    $data['valid'] = 1;
                    $data['status'] = 1;
                    $data['year'] = $request->txt_year;
                    DB::table("pro_finish_product_serial_$request->cbo_company_id")->insert($data);
                    array_push($data2, $serial_no);
                }
                $m_finish_product_serial = DB::table("pro_finish_product_serial_$request->cbo_company_id")
                    ->leftJoin('pro_company', "pro_finish_product_serial_$request->cbo_company_id.company_id", 'pro_company.company_id')
                    ->leftJoin("pro_finish_product_$request->cbo_company_id", "pro_finish_product_serial_$request->cbo_company_id.product_id", "pro_finish_product_$request->cbo_company_id.product_id")
                    ->select("pro_finish_product_serial_$request->cbo_company_id.*", "pro_company.company_name", "pro_finish_product_$request->cbo_company_id.*")
                    ->whereIn("pro_finish_product_serial_$request->cbo_company_id.serial_no", $data2)
                    ->get();

                return back()->with(['success' => 'Add Successfully !', 'm_finish_product_serial' => $m_finish_product_serial]);
            } // if( $flag == 1)

        }
    }


    //quotation
    public function quotation()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();

        return view('sales.quotation', compact('user_company'));
    }

    public function quotation_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'txt_date' => 'required',
            'txt_customer_name' => 'required',
            'txt_address' => 'required',
            // 'txt_mobile_number' => 'required',
            'txt_subject' => 'required',
            'txt_valid_until' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Company required.',
            'cbo_company_id.integer' => 'Company required.',
            'cbo_company_id.between' => 'Company required.',
            'txt_date.required' => 'Date required.',
            'txt_customer_name.required' => 'Customer name required.',
            'txt_address.required' => 'Address required.',
            // 'txt_mobile_number.required' => 'Mobile Number required.',
            'txt_subject.required' => 'Subject required.',
            'txt_valid_until.required' => 'Valid Until required.',
        ];

        $this->validate($request, $rules, $customMessages);

        //customer
        $customer =  DB::table("pro_customer_information_$request->cbo_company_id")
            ->where('customer_name', $request->txt_customer_name)
            ->where('customer_address', $request->txt_address)
            ->first();

        if ($customer) {
            $customer_id =  $customer->customer_id;
        } else {
            $customer_id = DB::table("pro_customer_information_$request->cbo_company_id")->insertGetId([
                'customer_name' => $request->txt_customer_name,
                'customer_address' => $request->txt_address,
                'customer_email' => $request->txt_email,
                'customer_phone' => $request->txt_mobile_number,
                'contact_person' => $request->txt_attention,
                // 'customer_type' => ,
                'user_id' => Auth::user()->emp_id,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date('h:i:sa'),
                'valid' => 1,
            ]);
        }

        $data = array();
        $data['customer_name'] = $request->txt_customer_name;
        $data['customer_address'] = $request->txt_address;
        $data['customer_mobile'] = $request->txt_mobile_number;
        $data['subject'] = $request->txt_subject;
        $data['offer_valid'] = $request->txt_valid_until;
        $data['reference'] = $request->txt_reference_name;
        $data['reference_mobile'] = $request->txt_reference_number;
        $data['email'] = $request->txt_email;
        $data['attention'] = $request->txt_attention;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['valid'] = 1;
        $data['status'] = 1;
        //
        $company = DB::table('pro_company')->where('company_id', $request->cbo_company_id)->first();
        $quotation_master = DB::table("pro_quotation_master_$request->cbo_company_id")->orderByDesc("quotation_master_id")->first();
        $quotation_master_id  = "$company->short_code/QUOTATION/" . date("Y") . date("m") . str_pad((substr($quotation_master->quotation_master_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        $data['quotation_master_id'] =  $quotation_master_id;
        //
        $data['quotation_date'] = $request->txt_date;
        $quotation_id = DB::table("pro_quotation_master_$request->cbo_company_id")->insertGetId($data);
        return redirect()->route('quotation_details', [$quotation_id, $request->cbo_company_id]);
    }

    public function quotation_details($id, $company_id)
    {
        $m_quotation_master = DB::table("pro_quotation_master_$company_id")->where('quotation_id', $id)->first();

        $all_quotation_details = DB::table("pro_quotation_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_quotation_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_quotation_details_$company_id.*",
                "pro_finish_product_$company_id.*",
            )
            ->where("pro_quotation_details_$company_id.quotation_master_id", $m_quotation_master->quotation_master_id)
            ->get();

        $product_id = DB::table("pro_quotation_details_$company_id")
            ->where('quotation_master_id', $m_quotation_master->quotation_master_id)
            ->pluck('product_id');

        $m_product = DB::table("pro_finish_product_$company_id")
            ->whereNotIn('product_id', $product_id)
            ->where('product_category', 2)
            ->where('valid', 1)
            ->get();

        $m_rate_policy = DB::table("pro_rate_policy_$company_id")->where('valid', 1)->get();
        return view('sales.quotation_details', compact('m_quotation_master', 'm_rate_policy', 'm_product', 'all_quotation_details'));
    }

    public function quotation_details_store(Request $request, $id, $company_id)
    {
        $rules = [
            'cbo_product_name' => 'required|integer|between:1,99999999',
            'cbo_rate_policy' => 'required|integer|between:1,99999999',
        ];
        $customMessages = [
            'cbo_product_name.required' => 'Product name required.',
            'cbo_product_name.integer' => 'Product name required.',
            'cbo_product_name.between' => 'Product name required.',
            'cbo_rate_policy.required' => 'Rate Policy required.',
            'cbo_rate_policy.integer' => 'Rate Policy required.',
            'cbo_rate_policy.between' => 'Rate Policy required',
        ];

        $this->validate($request, $rules, $customMessages);

        $m_quotation_master = DB::table("pro_quotation_master_$company_id")
            ->where('quotation_id', $id)
            ->first();

        $data = array();
        $data['quotation_id'] = $m_quotation_master->quotation_id;
        $data['company_id'] = $m_quotation_master->company_id;
        $data['quotation_master_id'] = $m_quotation_master->quotation_master_id;
        $data['quotation_date'] = $m_quotation_master->quotation_date;
        $data['product_id'] = $request->cbo_product_name;
        $data['qty'] = $request->txt_quantity;
        $data['rate_policy_id'] = $request->cbo_rate_policy;
        //
        $m_rate_policy = DB::table("pro_rate_policy_$company_id")
            ->where('rate_policy_id', $request->cbo_rate_policy)
            ->first();
        $m_rate_chart = DB::table("pro_rate_chart_$company_id")
            ->where('product_id', $request->cbo_product_name)
            ->where('rate_group', $m_rate_policy->rate_group)
            ->first();
        $data['rate'] = $m_rate_chart->rate;
        $data['total'] = $m_rate_chart->rate * $request->txt_quantity;
        //
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['user_id'] = Auth::user()->emp_id;
        $data['valid'] = 1;
        $data['status'] = 1;
        DB::table("pro_quotation_details_$company_id")->insert($data);
        return redirect()->route('quotation_details', [$id, $company_id])->with('success', 'Received Successfull !');
    }

    public function quotation_details_more($id, $company_id)
    {
        $m_quotation_master = DB::table("pro_quotation_master_$company_id")
            ->where('quotation_id', $id)
            ->first();

        $m_quotation_details = DB::table("pro_quotation_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_quotation_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_quotation_details_$company_id.*",
                "pro_finish_product_$company_id.*",
            )
            ->where("pro_quotation_details_$company_id.quotation_master_id", $m_quotation_master->quotation_master_id)
            ->get();

        return view('sales.quotation_details_final', compact('m_quotation_master', 'm_quotation_details'));
    }
    public function quotation_details_final(Request $request, $id, $company_id)
    {

        $m_quotation_master = DB::table("pro_quotation_master_$company_id")
            ->where('quotation_id', $id)
            ->first();

        $discount_amount = $request->txt_discount == null ? 0 : $request->txt_discount;
        $transport_cost = $request->txt_transportation_cost == null ? 0 : $request->txt_transportation_cost;
        $test_fee = $request->txt_test_fee == null ? 0 : $request->txt_test_fee;
        $other_expense = $request->txt_other == null ? 0 : $request->txt_other;

        $data = array();
        $data['discount_amount'] = $discount_amount;
        $data['transport_cost'] = $transport_cost;
        $data['test_fee'] = $test_fee;
        $data['other_expense'] = $other_expense;
        $data['sub_total'] = $request->txt_subtotal;
        $data['quotation_total'] = $request->txt_subtotal - $discount_amount + $transport_cost + $test_fee + $other_expense;
        $data['status'] = 2;

        DB::table("pro_quotation_master_$company_id")
            ->where('quotation_master_id', $m_quotation_master->quotation_master_id)
            ->update($data);

        DB::table("pro_quotation_details_$company_id")
            ->where('quotation_master_id', $m_quotation_master->quotation_master_id)
            ->update(['status' => 2]);

        return redirect()->route('rpt_quotation_view', [$id, $company_id])->with('success', 'Successfull !');
    }

    //edit
    public function quotation_details_edit($id, $company_id)
    {
        $quotation_details_edit = DB::table("pro_quotation_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_quotation_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_quotation_details_$company_id.*",
                "pro_finish_product_$company_id.*",
            )
            ->where("pro_quotation_details_$company_id.quotation_details_id", $id)
            ->first();

        $quotation_master_edit = DB::table("pro_quotation_master_$company_id")->where('quotation_master_id', $quotation_details_edit->quotation_master_id)->first();
        $m_product = DB::table("pro_finish_product_$company_id")
            ->where('product_category', 2)
            ->where('valid', 1)
            ->get();
        $m_rate_policy = DB::table("pro_rate_policy_$company_id")->where('valid', 1)->get();
        return view('sales.quotation_details', compact('quotation_details_edit', 'm_rate_policy', 'm_product', 'quotation_master_edit'));
    }
    public function quotation_details_update(Request $request, $id, $company_id)
    {
        $rules = [
            'cbo_product_name' => 'required|integer|between:1,99999999',
            'cbo_rate_policy' => 'required|integer|between:1,99999999',
        ];
        $customMessages = [
            'cbo_product_name.required' => 'Product name required.',
            'cbo_product_name.integer' => 'Product name required.',
            'cbo_product_name.between' => 'Product name between 1 to 99999999 .',
            'cbo_rate_policy.required' => 'Product name required.',
            'cbo_rate_policy.integer' => 'Product name required.',
            'cbo_rate_policy.between' => 'Product name between 1 to 99999999 .',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['product_id'] = $request->cbo_product_name;
        $data['qty'] = $request->txt_quantity;
        $data['rate_policy_id'] = $request->cbo_rate_policy;

        //
        $m_rate_policy = DB::table("pro_rate_policy_$company_id")
            ->where('rate_policy_id', $request->cbo_rate_policy)
            ->first();
        $m_rate_chart = DB::table("pro_rate_chart_$company_id")
            ->where('product_id', $request->cbo_product_name)
            ->where('rate_group', $m_rate_policy->rate_group)
            ->first();
        $data['rate'] = $m_rate_chart->rate;
        //
        $data['total'] = $m_rate_chart->rate * $request->txt_quantity;
        DB::table("pro_quotation_details_$company_id")
            ->where('quotation_details_id', $id)
            ->update($data);

        $get_quotation_id =  DB::table("pro_quotation_details_$company_id")
            ->where('quotation_details_id', $id)
            ->first();
        return redirect()->route('quotation_details', [$get_quotation_id->quotation_id, $company_id])->with('success', 'Updated Successfull !');
    }

    public function quotation_list()
    {
        return view('sales.rpt_quotation_list');
    }

    public function rpt_quotation_view($id, $company_id)
    {
        $m_quotation_master = DB::table("pro_quotation_master_$company_id")->where('quotation_id', $id)->first();
        $m_quotation_details = DB::table("pro_quotation_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_quotation_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_quotation_details_$company_id.*",
                "pro_finish_product_$company_id.*",
            )
            ->where("pro_quotation_details_$company_id.quotation_id", $id)
            ->get();
        $m_company = DB::table('pro_company')->where('company_id', $company_id)->first();
        return view('sales.rpt_quotation_view', compact('m_quotation_master', 'm_quotation_details', 'm_company'));
    }
    public function rpt_quotation_print($id, $company_id)
    {
        $m_quotation_master = DB::table("pro_quotation_master_$company_id")->where('quotation_id', $id)->first();
        $m_quotation_details = DB::table("pro_quotation_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_quotation_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_quotation_details_$company_id.*",
                "pro_finish_product_$company_id.*",
            )
            ->where("pro_quotation_details_$company_id.quotation_id", $id)
            ->get();
        $m_company = DB::table('pro_company')->where('company_id', $company_id)->first();
        return view('sales.rpt_quotation_print', compact('m_quotation_master', 'm_quotation_details', 'm_company'));
    }
    //ajax quotation
    public function GetCustomerList(Request $request)
    {
        $company_id = $request->cbo_company_id;
        $data = DB::table("pro_customer_information_$company_id")->where('customer_name', 'LIKE', '%' . $request->name . '%')->get();
        return response()->json($data);
    }

    public function GetCustomerDetails($id, $company_id)
    {
        $data = DB::table("pro_customer_information_$company_id")->where('customer_name', $id)->first();
        return response()->json($data);
    }

    public function GetSalesQuotationList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_quotation_master_$company_id")
                ->where('status', 2)
                ->orderByDesc('quotation_id')
                ->get();
        } else {
            $data =  DB::table("pro_quotation_master_$company_id")
                ->whereBetween("pro_quotation_master_$company_id.quotation_date", [$form, $to])->where('status', 2)
                ->orderByDesc('quotation_id')
                ->get();
        }
        return response()->json($data);
    }




    //-----------MoneyReceipt
    public function MoneyReceipt()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();

        return view('sales.money_recipt', compact('user_company'));
    }
    public function money_receipt_master(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_mr_type_id' => 'required|integer|between:1,100',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_mr_type_id.required' => 'Select Money Recipt.',
            'cbo_mr_type_id.integer' => 'Select Money Recipt.',
            'cbo_mr_type_id.between' => 'Select Money Recipt.',
        ];
        $this->validate($request, $rules, $customMessages);

        $master_mr = DB::table("pro_money_receipt_master_$request->cbo_company_id")->orderByDesc("mr_master_id")->first();
        $mr_master_id = "MM" . date("ym") . str_pad((substr($master_mr->mr_master_id, -5) + 1), 5, '0', STR_PAD_LEFT);

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['mr_master_id'] = $mr_master_id;
        $data['sales_type'] = $request->cbo_mr_type_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        $data['status'] = 1;
        DB::table("pro_money_receipt_master_$request->cbo_company_id")->insert($data);
        return redirect()->route('money_receipt_details', [$mr_master_id, $request->cbo_company_id]);
    }
    public function money_receipt_details($id, $company_id)
    {
        $mr_master = DB::table("pro_money_receipt_master_$company_id")->where('mr_master_id', $id)->first();
        return view('sales.money_recipt_details', compact('mr_master'));
    }
    public function money_receipt_details_store(Request $request, $id, $company_id)
    {

        $rules = [
            'txt_collection_date' => 'required',
            'cbo_active' => 'required',
            'cbo_transformer' => 'required|integer|between:1,100000000000',
            'cbo_customer_type' => 'required|integer|between:1,100000000000',
            'cbo_customer' => 'required|integer|between:1,100000000000',
            'txt_dt_price' => 'required',
            'cbo_payment_type' => 'required|integer|between:1,100000000000',
        ];
        $customMessages = [
            'cbo_active.required' => 'Active/Deactive required',
            'txt_collection_date.required' => 'Collection Date required',
            'cbo_transformer.required' => 'Select Transformer.',
            'cbo_transformer.integer' => 'Select Transformer.',
            'cbo_transformer.between' => 'Select Transformer.',
            'cbo_customer_type.required' => 'Select Customer Type.',
            'cbo_customer_type.integer' => 'Select Customer Type.',
            'cbo_customer_type.between' => 'Select Customer Type.',
            'cbo_customer.required' => 'Select Customer.',
            'cbo_customer.integer' => 'Select Customer.',
            'cbo_customer.between' => 'Select Customer.',
            'txt_dt_price.required' => 'DT Price Required.',
            'cbo_payment_type.required' => 'Select Payment Type.',
            'cbo_payment_type.integer' => 'Select Payment Type.',
            'cbo_payment_type.between' => 'Select Payment Type.',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->cbo_payment_type == 1) {
            $rules = [
                'cbo_received' => 'required',
            ];
            $customMessages = [
                'cbo_received.required' => 'Select Recived By',
            ];
            $this->validate($request, $rules, $customMessages);
        } elseif ($request->cbo_payment_type == 2) {
            //empty
        } else {

            $rules = [
                'cbo_online_deposite' => 'required',
                'txt_dd_no' => 'required',
                'txt_dd_date' => 'required',
            ];
            $customMessages = [
                'cbo_online_deposite.required' => 'Select Bank',
                'txt_dd_no.required' => 'Chq/PO/DD No required',
                'txt_dd_date.required' => 'Chq/PO/DD Date required',
            ];
            $this->validate($request, $rules, $customMessages);
        }

        $master_mr = DB::table("pro_money_receipt_master_$company_id")->where("mr_master_id", $id)->first();
        //MR No Dynamic
        $collection_date = $request->txt_collection_date;
        $invoice_date = date('ym', strtotime($collection_date));
        $invoice_search = "MR" . $invoice_date;
        $last_mr = DB::table("pro_money_receipt_$company_id")
            ->where('mr_id', 'like', "$invoice_search%")
            ->orderByDesc("mr_id")
            ->first();

        if (isset($last_mr)) {
            $mr_id = "$invoice_search" . str_pad((substr($last_mr->mr_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $mr_id =  $invoice_search . "00001";
        }

        $check_mr = DB::table("pro_money_receipt_$company_id")->where("mr_id", $mr_id)->first();
        if ($check_mr) {
            return back()->with('warning', "MR ID Alredy Taken");
        } else {

            $m_customer_type = DB::table('pro_customer_type')->where('customer_type_id', $request->cbo_customer_type)->first();
            $cust_sppl = $m_customer_type->cust_sppl;

            if ($request->cbo_payment_type == 1 || $request->cbo_payment_type == 2) {
                $active = 1;
            } else {
                $active = $request->cbo_active;
            }

            $dt_price = $request->txt_dt_price == null ? 0 : $request->txt_dt_price;
            $transport_fee = $request->txt_transport == null ? 0 : $request->txt_transport;
            $test_fee = $request->txt_test_fee == null ? 0 : $request->txt_test_fee;
            $other_fee = $request->txt_other == null ? 0 : $request->txt_other;

            $data = array();
            $data['mr_id'] = $mr_id;
            $data['company_id'] = $company_id;
            $data['collection_date'] = $request->txt_collection_date;
            $data['mr_master_id'] = $id;
            $data['customer_id'] = $request->cbo_customer;
            $data['cust_sppl'] = $cust_sppl;
            $data['pg_id'] = $request->cbo_transformer;
            $data['dt_price'] =  $dt_price;
            $data['transport_fee'] = $transport_fee;
            $data['test_fee'] = $test_fee;
            $data['other_fee'] = $other_fee;
            $data['mr_amount'] =  $dt_price +  $transport_fee + $test_fee + $other_fee;
            $data['payment_type'] = $request->cbo_payment_type;
            $data['receive_type'] = $request->cbo_received == null ? '0' : $request->cbo_received;
            $data['bank_id'] = $request->cbo_online_deposite;
            $data['chq_po_dd_no'] = $request->txt_dd_no;
            $data['chq_po_dd_date'] = $request->txt_dd_date;
            $data['remarks'] = $request->txt_remark;
            $data['user_id'] = Auth::user()->emp_id;
            $data['status'] = $active;
            $data['valid'] = 1;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['sales_type'] = $master_mr->sales_type;
            DB::table("pro_money_receipt_$company_id")->insert($data);
            return back()->with('success', "Add Successfully !");
        }
    }

    public function money_receipt_final($id, $company_id)
    {
        return redirect()->route('money_receipt');
    }

    //Activation Money Resceipt
    public function money_receipt_list()
    {
        return view('sales.money_receipt_list');
    }

    public function GetMoneyReceiptList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_money_receipt_$company_id")
                ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_money_receipt_$company_id.*", 'pro_payment_type.payment_type', "pro_customer_information_$company_id.customer_name")
                ->orderByDesc("pro_money_receipt_$company_id.mr_id")
                ->where("pro_money_receipt_$company_id.status", 2)
                ->where("pro_money_receipt_$company_id.valid", 1)
                ->where("pro_money_receipt_$company_id.payment_type", '>', 1)
                ->where("pro_money_receipt_$company_id.bank_id", '>', 0)
                ->get();
        } else {
            $data = DB::table("pro_money_receipt_$company_id")
                ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_money_receipt_$company_id.*", 'pro_payment_type.payment_type', "pro_customer_information_$company_id.customer_name")
                ->whereBetween("pro_money_receipt_$company_id.entry_date", [$form, $to])
                ->orderByDesc("pro_money_receipt_$company_id.mr_id")
                ->where("pro_money_receipt_$company_id.status", 2)
                ->where("pro_money_receipt_$company_id.valid", 1)
                ->where("pro_money_receipt_$company_id.payment_type", '>', 1)
                ->where("pro_money_receipt_$company_id.bank_id", '>', 0)
                ->get();
        }
        return response()->json($data);
    }

    public function money_receipt_active($id, $company_id)
    {
        $mr_details = DB::table("pro_money_receipt_$company_id")->where('mr_id', $id)->first();
        $mr_master = DB::table("pro_money_receipt_master_$company_id")->where('mr_master_id', $mr_details->mr_master_id)->first();
        return view('sales.money_receipt_active', compact('mr_details', 'mr_master'));
    }

    public function money_receipt_valid(Request $request, $id, $company_id)
    {
        $rules = [
            'cbo_active' => 'required',
        ];
        $customMessages = [
            'cbo_active.required' => 'Select Active Yes or NO.',
        ];
        $this->validate($request, $rules, $customMessages);

        DB::table("pro_money_receipt_$company_id")
            ->where('mr_id', $id)
            ->update([
                'status' => $request->cbo_active,
            ]);
        return redirect()->route('rpt_money_receipt_view', [$id, $company_id]);
    }


    //Report Money Resceipt
    public function rpt_money_receipt_list()
    {
        // $mr_receipt = DB::table('pro_money_receipt')->orderByDesc('mr_id')->where('status', 2)->get();
        return view('sales.rpt_money_receipt_list');
    }

    public function GetMRList($company_id, $form, $to, $pg_id)
    {
        if ($form == 0) {
            if ($pg_id == 0) {
                $data = DB::table("pro_money_receipt_$company_id")
                    ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
                    ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_money_receipt_$company_id.*", 'pro_payment_type.payment_type', "pro_customer_information_$company_id.customer_name")
                    ->orderByDesc("pro_money_receipt_$company_id.mr_id")
                    ->get();
            } else {
                $data = DB::table("pro_money_receipt_$company_id")
                    ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
                    ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_money_receipt_$company_id.*", 'pro_payment_type.payment_type', "pro_customer_information_$company_id.customer_name")
                    ->orderByDesc("pro_money_receipt_$company_id.mr_id")
                    ->where("pro_money_receipt_$company_id.pg_id", $pg_id)
                    ->get();
            }
        } else {
            if ($pg_id == 0) {
                $data = DB::table("pro_money_receipt_$company_id")
                    ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
                    ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_money_receipt_$company_id.*", 'pro_payment_type.payment_type', "pro_customer_information_$company_id.customer_name")
                    ->whereBetween("pro_money_receipt_$company_id.collection_date", [$form, $to])
                    ->orderByDesc("pro_money_receipt_$company_id.mr_id")
                    ->get();
            } else {
                $data = DB::table("pro_money_receipt_$company_id")
                    ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
                    ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_money_receipt_$company_id.*", 'pro_payment_type.payment_type', "pro_customer_information_$company_id.customer_name")
                    ->whereBetween("pro_money_receipt_$company_id.collection_date", [$form, $to])
                    ->orderByDesc("pro_money_receipt_$company_id.mr_id")
                    ->where("pro_money_receipt_$company_id.pg_id", $pg_id)
                    ->get();
            }
        }
        return response()->json($data);
    }

    public function rpt_money_receipt_view($id, $company_id)
    {
        $m_money_receipt = DB::table("pro_money_receipt_$company_id")->where('mr_id', $id)->first();
        return view('sales.rpt_money_receipt_view', compact('m_money_receipt'));
    }
    public function rpt_money_receipt_print($id, $company_id)
    {
        $m_money_receipt = DB::table("pro_money_receipt_$company_id")->where('mr_id', $id)->first();
        return view('sales.rpt_money_receipt_print', compact('m_money_receipt'));
    }

    //Money Receipt AJAX

    public function GetCustomerPreviousBalance($id, $company_id)
    {
        $customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $id)->first();

        $data = array();
        $data['address'] = $customer->customer_address;
        $data['balance'] = "0.000";
        return response()->json($data);
    }

    //Sales Invoice
    public function sales_invoice()
    {
        return view('sales.sales_invoice');
    }

    public function sales_invoice_master_store(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_transformer' => 'required|integer|between:1,100',
            'cbo_customer_type_id' => 'required|integer|between:1,100',
            'cbo_mushok_no' => 'required|integer|between:1,100000000000',
            'cbo_sales_type' => 'required|integer|between:1,100000000000',
            'txt_sales_date' => 'required',
            'cbo_customer' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'cbo_transformer.required' => 'Select Transformer.',
            'cbo_transformer.integer' => 'Select Transformer.',
            'cbo_transformer.between' => 'Select Transformer.',
            'cbo_customer_type_id.required' => 'Select Customer Type.',
            'cbo_customer_type_id.integer' => 'Select Customer Type.',
            'cbo_customer_type_id.between' => 'Select Customer Type.',
            'cbo_mushok_no.required' => 'Select Mushok No.',
            'cbo_mushok_no.integer' => 'Select Mushok No.',
            'cbo_mushok_no.between' => 'Select Mushok No.',
            'cbo_sales_type.required' => 'Select Sales Type',
            'cbo_sales_type.between' => 'Select Sales Type',
            'cbo_sales_type.required' => 'Select Sales Type',
            'txt_sales_date.required' => 'Sales Date is required.',
            'cbo_customer.required' => 'Customer is required.',
        ];
        $this->validate($request, $rules, $customMessages);


        $m_company = DB::table('pro_company')
            ->where('company_id', $request->cbo_company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";

        $sim_date = $request->txt_sales_date;
        $invoice_date = date('Ym', strtotime($sim_date));
        $invoice_search = $company_short_name . $invoice_date;
        $last_sim_invoice_no = DB::table("pro_sim_$request->cbo_company_id")
            ->where('sim_id', 'like', "$invoice_search%")
            ->orderByDesc("sim_id")
            ->first();
        if ($last_sim_invoice_no) {
            $sim_no = "$invoice_search" . str_pad((substr($last_sim_invoice_no->sim_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $sim_no =  $invoice_search . "00001";
        }

        $check_sim_no = DB::table("pro_sim_$request->cbo_company_id")->where("sim_id", $sim_no)->first();
        if ($check_sim_no) {
            return back()->with('warning', 'Invoice No alredy taken');
        } else {

            $m_mushok = DB::table("pro_mushok_$request->cbo_company_id")
                ->where('mushok_id', $request->cbo_mushok_no)
                ->where('valid', 1)
                ->first();

            $m_customer_type = DB::table('pro_customer_type')
                ->where('customer_type_id', $request->cbo_customer_type_id)
                ->where('valid', 1)
                ->first();
            $txt_cust_sppl = "$m_customer_type->cust_sppl";
            $m_customer_id = $request->cbo_customer;

            $data = array();
            $data['sim_id'] = $sim_no;
            $data['company_id'] = $request->cbo_company_id;
            $data['sim_date'] = $request->txt_sales_date;
            $data['customer_id'] = $m_customer_id;
            $data['cust_sppl'] = $txt_cust_sppl;
            $data['customer_type_id'] = $request->cbo_customer_type_id;
            $data['pg_id'] = $request->cbo_transformer;
            $data['ref_name'] = $request->txt_reff_name;
            $data['ref_mobile'] = $request->txt_reff_mobile;
            $data['mushok_no'] = $m_mushok->mushok_number;
            $data['ifb_no'] = $request->txt_ifb_no;
            $data['ifb_date'] = $request->txt_ifb_date;
            $data['contract_no'] = $request->txt_contract_no;
            $data['contract_date'] = $request->txt_contract_date;
            $data['allocation_no'] = $request->txt_allocation_no;
            $data['allocation_date'] = $request->txt_allocation_date;
            $data['pono_ref'] = $request->txt_po_no;
            $data['pono_ref_date'] = $request->txt_ref_date;
            $data['sales_type'] = $request->cbo_sales_type;
            $data['status'] = '1';
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = '1';

            DB::table("pro_sim_$request->cbo_company_id")->insert($data);

            $data1 = array();
            $data1['sim_id'] = $sim_no;
            $data1['sim_date'] = $request->txt_sales_date;
            $data1['valid'] = '2';

            DB::table("pro_mushok_$request->cbo_company_id")
                ->where('mushok_id', $request->cbo_mushok_no)
                ->update($data1);

            // 2 -credit
            // 1 -cash
            if ($request->cbo_sales_type == 2) {
                return redirect()->route('sales_invoice_details',  [$sim_no, $request->cbo_company_id]);
            } else {
                return redirect()->route('sales_invoice_mr', [$sim_no, $request->cbo_company_id]);
            }
        }
    }

    public function GetCustomerId($id, $company_id)
    {
        $data = DB::table("pro_customer_information_$company_id")
            ->where('customer_type', $id)
            ->where('valid', '1')
            ->get();
        return json_encode($data);
    }



    // Sales invoice mr add 
    public function sales_invoice_mr($sim_no, $company_id)
    {
        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $sim_no)->first();
        return view('sales.sales_invoice_mr', compact('sales_master'));
    }

    public function sales_invoice_add_mr(Request $request, $sim_no, $company_id)
    {
        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $sim_no)->first();
        $rules = [
            'cbo_mr_id' => 'required',
        ];
        $customMessages = [
            'cbo_mr_id.required' => 'Select Money Receipt.',
        ];
        $this->validate($request, $rules, $customMessages);

        DB::table("pro_money_receipt_$company_id")->where('mr_id', $request->cbo_mr_id)->update([
            'sim_id' => $sales_master->sim_id,
            'sim_date' => $sales_master->sim_date,
            'valid' => 2,
        ]);

        return back()->with('success', 'Add Successfully');
    } //end mr 

    //sales details
    public function sales_invoice_details($sim_no, $company_id)
    {
        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $sim_no)->first();
        return view('sales.sales_invoice_details', compact('sales_master'));
    }


    public function sales_invoice_details_store(Request $request, $sim_no, $company_id)
    {

        $rules = [
            'cbo_product' => 'required|integer|between:1,100000000000',
            'cbo_rate_policy' => 'required',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Transformer.',
            'cbo_product.integer' => 'Select Transformer.',
            'cbo_product.between' => 'Select Transformer.',
            'cbo_rate_policy.required' => 'Select Rate Policy.',
            'txt_qty.required' => 'QTY Required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $sim_no)->first();

        $discount_rate = $request->txt_discount == null ? 0 : $request->txt_discount;
        $transport_rate = $request->txt_tr_discount == null ? 0 : $request->txt_tr_discount;;

        $data = array();
        $data['sim_id'] = $sales_master->sim_id;
        $data['sim_date'] = $sales_master->sim_date;
        $data['company_id'] = $sales_master->company_id;
        $data['customer_id'] = $sales_master->customer_id;
        $data['cust_sppl'] = $sales_master->cust_sppl;
        $data['pg_id'] = $sales_master->pg_id;
        $data['product_id'] = $request->cbo_product;
        $data['auth_ref_no'] = $request->txt_ref_no;
        $data['rate_policy_id'] = $request->cbo_rate_policy;
        $data['qty'] = $request->txt_qty;
        $data['discount_rate'] =   $discount_rate;
        $data['transport_rate'] = $transport_rate;

        //
        $rate_policy_group = DB::table("pro_rate_policy_$company_id")->where('rate_policy_id', $request->cbo_rate_policy)->first();
        $rate_chart = DB::table("pro_rate_chart_$company_id")->where('product_id', $request->cbo_product)->where('rate_group', $rate_policy_group->rate_group)->first();
        $total_discount = $request->txt_qty * $discount_rate;
        $total_tr_discount = $request->txt_qty *  $transport_rate;
        $total = $rate_chart->rate * $request->txt_qty;

        $data['total_discount'] = $total_discount;
        $data['total_transport'] = $total_tr_discount;
        $data['rate'] = $rate_chart->rate;
        $data['total'] = $total;
        //
        $data['status'] = '1';
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = '1';

        DB::table("pro_sid_$company_id")->insert($data);
        return back()->with('success', 'Add Successfully');
    }

    //Edit sales invoicce product qty in details blade 

    public function sales_invoice_details_edit($sid_id, $company_id)
    {
        $edit_sales_details = DB::table("pro_sid_$company_id")->where('sid_id', $sid_id)->first();
        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $edit_sales_details->sim_id)->first();
        return view('sales.sales_invoice_details', compact('edit_sales_details', 'sales_master'));
    }

    public function sales_invoice_details_update(Request $request, $sid_id, $company_id)
    {

        $rules = [
            'cbo_product' => 'required|integer|between:1,100000000000',
            'cbo_rate_policy' => 'required|integer|between:1,100000000000',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'cbo_product.required' => 'Select Transformer.',
            'cbo_product.integer' => 'Select Transformer.',
            'cbo_product.between' => 'Select Transformer.',
            'cbo_rate_policy.required' => 'Select Rate Policy.',
            'txt_qty.required' => 'QTY Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $edit_sales_details = DB::table("pro_sid_$company_id")->where('sid_id', $sid_id)->first();

        $data = array();
        $data['product_id'] = $request->cbo_product;
        $data['auth_ref_no'] = $request->txt_ref_no;
        $data['rate_policy_id'] = $request->cbo_rate_policy;
        $data['qty'] = $request->txt_qty;
        $data['discount_rate'] = $request->txt_discount;
        $data['transport_rate'] = $request->txt_tr_discount;

        //
        $rate_policy_group = DB::table("pro_rate_policy_$company_id")->where('rate_policy_id', $request->cbo_rate_policy)->first();
        $rate_chart = DB::table("pro_rate_chart_$company_id")->where('product_id', $request->cbo_product)->where('rate_group', $rate_policy_group->rate_group)->first();
        $total_discount = $request->txt_qty * $request->txt_discount;
        $total_tr_discount = $request->txt_qty * $request->txt_tr_discount;
        $total = $rate_chart->rate * $request->txt_qty;

        $data['total_discount'] = $total_discount;
        $data['total_transport'] = $total_tr_discount;
        $data['rate'] = $rate_chart->rate;
        $data['total'] = $total;
        //
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:sa");

        DB::table("pro_sid_$company_id")->where('sid_id', $sid_id)->update($data);
        return redirect()->route('sales_invoice_details', [$edit_sales_details->sim_id, $company_id])->with('success', 'Update Successfully');
    }
    //End Edit

    //sales invoice serial 
    public function sales_invoice_add_serial($sid_id, $company_id)
    {
        $sales_details = DB::table("pro_sid_$company_id")
            ->where('sid_id', $sid_id)
            ->first();

        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $sales_details->sim_id)->first();
        return view('sales.sales_invoice_add_serial', compact('sales_details', 'sales_master'));
    }

    public function sales_invoice_serial_store(Request $request, $sid_id, $company_id)
    {

        $rules = [
            'cbo_serial' => 'required|integer|between:1,100000000000',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'cbo_serial.required' => 'Select Serial Number.',
            'cbo_serial.integer' => 'Select Serial Number.',
            'cbo_serial.between' => 'Select Serial Number.',
            'txt_qty.required' => 'Qty Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $sales_details = DB::table("pro_sid_$company_id")->where('sid_id', $sid_id)->first();
        $sales_master = DB::table("pro_sim_$company_id")->where('sim_id', $sales_details->sim_id)->first();

        $finish_product_serial_count = DB::table("pro_finish_product_serial_$company_id")
            ->where('sid_id', $sales_details->sid_id)
            ->where('sim_id', $sales_details->sim_id)
            ->where('product_id', $sales_details->product_id)
            ->count();

        if ($finish_product_serial_count >= $sales_details->qty) {
            return back()->with('warning', "Alredy Add Serial");
        } elseif ($request->txt_qty > $sales_details->qty) {
            return back()->with('warning', "Request Qty greatr than Sales qty ($sales_details->qty > $request->txt_qty).");
        } else {

            $flag = 0;
            for ($i = 0; $i < $request->txt_qty; $i++) {
                $serial_id =  $request->cbo_serial + $i;
                $check = DB::table("pro_finish_product_serial_$company_id")->where('serial_id', $serial_id)->where('product_id', $sales_details->product_id)->where('status', 1)->first();
                if (isset($check)) {
                    $flag =  $flag + 1;
                }
            }

            if ($flag == $request->txt_qty) {
                for ($i = 0; $i < $request->txt_qty; $i++) {
                    $serial_id =  $request->cbo_serial + $i;
                    $data = array();
                    $data['sid_id'] = $sales_details->sid_id;
                    $data['sim_id'] = $sales_master->sim_id;
                    $data['sim_date'] = $sales_master->sim_date;
                    $data['customer_id'] = $sales_master->customer_id;
                    $data['status'] = 2;
                    DB::table("pro_finish_product_serial_$company_id")
                        ->where('serial_id', $serial_id)
                        ->where('product_id', $sales_details->product_id)
                        ->update($data);
                }
            } else {
                return back()->with('warning', "Please select valid Serial Number.");
            }

            return back()->with('success', 'Add Successfully');
        }
    } //End Serial

    //sales invoice end and Final 
    public function sales_invoice_end($sim_id, $company_id)
    {

        $sales_master =  DB::table("pro_sim_$company_id")->where('sim_id', $sim_id)->first();
        $sales_details = DB::table("pro_sid_$company_id")
            ->leftJoin("pro_rate_policy_$company_id", "pro_sid_$company_id.rate_policy_id", "pro_rate_policy_$company_id.rate_policy_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_sid_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_sid_$company_id.*", "pro_finish_product_$company_id.product_name", "pro_rate_policy_$company_id.rate_policy_name", 'pro_units.unit_name')
            ->where("pro_sid_$company_id.sim_id", $sim_id)
            ->get();
        return view('sales.sales_invoice_end', compact('sales_master', 'sales_details'));
    }
    public function sales_invoice_final(Request $request, $sim_id, $company_id)
    {

        $subtotal = DB::table("pro_sid_$company_id")->where('sim_id', $sim_id)->sum('total');
        $discount_amount = DB::table("pro_sid_$company_id")->where('sim_id', $sim_id)->sum('total_discount');
        $tr_discount_amount = DB::table("pro_sid_$company_id")->where('sim_id', $sim_id)->sum('total_transport');

        $transport_cost = $request->txt_tr_cost_discount == null ? '0' : $request->txt_tr_cost_discount;
        $test_fee = $request->txt_test_fee == null ? '0' : $request->txt_test_fee;
        $other_expense = $request->txt_other == null ? '0' : $request->txt_other;

        $total = ($subtotal + $transport_cost + $test_fee + $other_expense - $discount_amount - $tr_discount_amount);

        $data = array();
        $data['sinv_total'] = $subtotal;
        $data['discount_amount'] = $discount_amount;
        $data['tr_discount_amount'] = $tr_discount_amount;
        $data['transport_cost'] = $transport_cost;
        $data['test_fee'] = $test_fee;
        $data['other_expense'] = $other_expense;
        $data['total'] = $total;
        $data['status'] = 2;

        //details sales final-> 2 status, master sales final-> 2 status
        DB::table("pro_sim_$company_id")->where('sim_id', $sim_id)->update($data);
        DB::table("pro_sid_$company_id")->where('sim_id', $sim_id)->update(['status' => 2]);

        return redirect()->route('rpt_sales_invoice_view', [$sim_id, $company_id])->with('success', 'Successfully');
    }

    //rpt sales invoce
    public function rpt_sales_invoice()
    {
        return view('sales.rpt_sales_invoice');
    }

    public function rpt_sales_invoice_view($id, $company_id)
    {
        // return $id;
        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select(
                "pro_sim_$company_id.*",
                'customer_name',
                'customer_address',
                'customer_mobile'
            )
            ->where("pro_sim_$company_id.sim_id", $id)
            ->first();

        $m_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $id)
            ->get();


        return view('sales.rpt_sales_invoice_view', compact('m_sales', 'm_details', 'company_id'));
    }

    public function rpt_sales_invoice_view_regular($id, $company_id)
    {
        // return $id;
        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select(
                "pro_sim_$company_id.*",
                'customer_name',
                'customer_address',
                'customer_mobile'
            )
            ->where("pro_sim_$company_id.sim_id", $id)
            ->first();

        $m_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $id)
            ->get();

        return view('sales.rpt_sales_invoice_view_regular', compact('m_sales', 'm_details', 'company_id'));
    }


    public function rpt_sales_invoice_print($id, $company_id)
    {
        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select(
                "pro_sim_$company_id.*",
                'customer_name',
                'customer_address',
                'customer_mobile'
            )
            ->where("pro_sim_$company_id.sim_id", $id)
            ->first();

        $m_details = DB::table("pro_sid_$company_id")->where('sim_id', $id)->get();

        return view('sales.rpt_sales_invoice_print', compact('m_sales', 'm_details', 'company_id'));
    }

    public function rpt_sales_invoice_print_regular($id, $company_id)
    {
        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select(
                "pro_sim_$company_id.*",
                'customer_name',
                'customer_address',
                'customer_mobile'
            )
            ->where("pro_sim_$company_id.sim_id", $id)
            ->first();

        $m_details = DB::table("pro_sid_$company_id")->where('sim_id', $id)->get();

        return view('sales.rpt_sales_invoice_print_regular', compact('m_sales', 'm_details', 'company_id'));
    }

    //delivery challan
    public function delivery_challan()
    {
        return view('sales.delivery_challan');
    }


    public function create_delivery_challan($id, $company_id)
    {
        $sales_master =  DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_sim_$company_id.*", "pro_customer_information_$company_id.*")
            ->where("pro_sim_$company_id.sim_id", $id)
            ->first();

        return view('sales.create_delivery_challan', compact('sales_master'));
    }

    public function create_delivery_challan_master(Request $request, $id, $company_id)
    {

        $rules = [
            'txt_dcm_date' => 'required',
            'cbo_address' => 'required',
            'cbo_truck_no' => 'required',
            'cbo_driver_name' => 'required',

        ];

        $customMessages = [
            'txt_dcm_date.required' => 'DCM Date field is required!',
            'cbo_address.required' => 'Delivery Address field is required!',
            'cbo_truck_no.required' => 'Vehicle No field is required!',
            'cbo_driver_name.required' => 'Driver Nmae field is required!',

        ];
        // $this->validate($request, $rules, $customMessages);

        $sales_master =  DB::table("pro_sim_$company_id")
            ->where("sim_id", $id)
            ->first();
        $m_company = DB::table('pro_company')
            ->where('company_id', $company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";

        $dcm_date = $request->txt_dcm_date;
        $invoice_date = date('Ym', strtotime($dcm_date));
        $invoice_search = $company_short_name . $invoice_date;
        $challan = DB::table("pro_delivery_chalan_master_$company_id")
            ->where("delivery_chalan_master_id", "LIKE", "$invoice_search%")
            ->orderByDesc("delivery_chalan_master_id")
            ->first();
        if (isset($challan)) {
            $delivery_chalan_master_id = "$invoice_search" . str_pad((substr($challan->delivery_chalan_master_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $delivery_chalan_master_id =  $invoice_search . "00001";
        }

        $check_challan = DB::table("pro_delivery_chalan_master_$company_id")->where("delivery_chalan_master_id", $delivery_chalan_master_id)->first();
        // return $check_challan;
        if ($check_challan) {
            return back()->with('warning', "Challan No alredy taken!");
        } else {

            $data = array();
            $data['delivery_chalan_master_id'] = $delivery_chalan_master_id;
            $data['company_id'] = $company_id;
            $data['dcm_date'] = $request->txt_dcm_date;
            $data['sim_id'] = $sales_master->sim_id;
            $data['sim_date'] = $sales_master->sim_date;
            $data['customer_id'] = $sales_master->customer_id;
            $data['delivery_address'] = $request->cbo_address;
            $data['ifb_no'] = $sales_master->ifb_no;
            $data['ifb_date'] = $sales_master->ifb_date;
            $data['contract_no'] = $sales_master->contract_no;
            $data['contract_date'] = $sales_master->contract_date;
            $data['allocation_no'] = $sales_master->allocation_no;
            $data['allocation_date'] = $sales_master->allocation_date;
            $data['pono_ref'] = $sales_master->pono_ref;
            $data['pono_ref_date'] = $sales_master->pono_ref_date;
            $data['mushok_no'] = $sales_master->mushok_no;
            $data['truck_no'] = $request->cbo_truck_no;
            $data['driver_name'] = $request->cbo_driver_name;
            $data['status'] = 1;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table("pro_delivery_chalan_master_$company_id")->insert($data);
            return redirect()->route('delivery_challan_details', [$delivery_chalan_master_id, $company_id]);
        }
    }

    public function delivery_challan_details($id, $company_id)
    {

        $d_challan =   DB::table("pro_delivery_chalan_master_$company_id")->where('delivery_chalan_master_id', $id)->first();
        $d_challan_details = DB::table("pro_delivery_chalan_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_delivery_chalan_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_delivery_chalan_details_$company_id.*", "pro_finish_product_$company_id.product_name", 'pro_units.unit_name')
            ->where("pro_delivery_chalan_details_$company_id.delivery_chalan_master_id", $id)
            ->where("pro_delivery_chalan_details_$company_id.status", 1)
            ->get();


        $d_product_id = DB::table("pro_delivery_chalan_details_$company_id")->where("pro_delivery_chalan_details_$company_id.delivery_chalan_master_id", $id)->pluck('product_id');
        $product_id = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->whereNotIn('product_id', $d_product_id)->where('status', 2)->pluck('product_id');
        $product = DB::table("pro_finish_product_$company_id")->whereIn('product_id', $product_id)->get();

        return view('sales.delivery_challan_details', compact('d_challan', 'd_challan_details', 'product'));
    }

    public function delivery_challan_details_store(Request $request, $id, $company_id)
    {

        $rules = [
            'cbo_product' => 'required',
            'txt_qty' => 'required',

        ];

        $customMessages = [
            'cbo_product.required' => 'Select Product',
            'txt_qty.required' => 'Quantity field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")->where('delivery_chalan_master_id', $id)->first();
        $p_sid = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $request->cbo_product)->first();

        $sale_qty = $p_sid->qty;
        $delivery_qty = ($p_sid->deliver_qty == null ? '0' : $p_sid->deliver_qty) + $request->txt_qty;

        if ($delivery_qty > $sale_qty) {
            return back()->with('warning', "Deliver Qty Getter Then Sales Qty ($delivery_qty > $sale_qty)");
        } else {
            $data = array();
            $data['company_id'] = $d_challan->company_id;
            $data['delivery_chalan_master_id'] = $d_challan->delivery_chalan_master_id;
            $data['sim_id'] = $d_challan->sim_id;
            $data['customer_id'] = $d_challan->customer_id;
            $data['product_id'] = $request->cbo_product;
            $data['del_qty'] = $request->txt_qty;
            $data['status'] = 1;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;

            DB::table("pro_delivery_chalan_details_$company_id")->insert($data);
            DB::table("pro_sid_$company_id")
                ->where('sim_id', $d_challan->sim_id)
                ->where('product_id', $request->cbo_product)
                ->update([
                    'deliver_qty' => $delivery_qty,
                    'deliver_date' => $d_challan->dcm_date,
                ]);

            $p_sid_details = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $request->cbo_product)->first();
            if ($p_sid_details->qty == $p_sid_details->deliver_qty) {
                DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $request->cbo_product)->update(['status' => 3]);
            }

            $data1 =  DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('status', 3)->count();
            $data2 =  DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->count();

            if ($data1 == $data2) {
                DB::table("pro_sim_$company_id")->where('sim_id', $d_challan->sim_id)->update(['status' => 3]);
            }
            return back()->with('success', "Add Successfull");
        }
    }


    //D H serial 
    public function delivery_challan_serial($id, $company_id)
    {
        $d_challan_details =  DB::table("pro_delivery_chalan_details_$company_id")->where('delivery_chalan_details_id', $id)->first();
        return view('sales.delivery_challan_serial', compact('d_challan_details'));
    }

    public function delivery_challan_serial_store(Request $request, $id, $company_id)
    {
        $rules = [
            'cbo_serial' => 'required|integer|between:1,100000000000',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'cbo_serial.required' => 'Select Serial Number.',
            'cbo_serial.integer' => 'Select Serial Number.',
            'cbo_serial.between' => 'Select Serial Number.',
            'txt_qty.required' => 'Qty Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->txt_qty <= 0) {
            return back()->with('warning', 'Please Entry valid Number. ');
        }

        $d_challan_details =  DB::table("pro_delivery_chalan_details_$company_id")->where('delivery_chalan_details_id', $id)->first();

        $finish_product_serial_count = DB::table("pro_finish_product_serial_$company_id")
            ->where('delivery_chalan_details_id', $d_challan_details->delivery_chalan_details_id)
            ->where('delivery_chalan_master_id', $d_challan_details->delivery_chalan_master_id)
            ->where('product_id', $d_challan_details->product_id)
            ->count();

        if ($finish_product_serial_count >= $d_challan_details->del_qty) {
            return back()->with('warning', "Alredy Add Serial");
        } elseif ($request->txt_qty > $d_challan_details->del_qty) {
            return back()->with('warning', "Request Qty greatr than Sales qty ($d_challan_details->del_qty > $request->txt_qty).");
        } else {
            $flag = 0;
            for ($i = 0; $i < $request->txt_qty; $i++) {
                $serial_id =  $request->cbo_serial + $i;
                $check = DB::table("pro_finish_product_serial_$company_id")->where('serial_id', $serial_id)->where('product_id', $d_challan_details->product_id)->where('status', 2)->first();
                if (isset($check)) {
                    $flag =  $flag + 1;
                }
            }

            if ($flag == $request->txt_qty) {
                for ($i = 0; $i < $request->txt_qty; $i++) {
                    $serial_id =  $request->cbo_serial + $i;
                    $data = array();
                    $data['delivery_chalan_details_id'] = $d_challan_details->delivery_chalan_details_id;
                    $data['delivery_chalan_master_id'] = $d_challan_details->delivery_chalan_master_id;
                    $data['customer_id'] = $d_challan_details->customer_id;
                    $data['status'] = 3;
                    DB::table("pro_finish_product_serial_$company_id")
                        ->where('serial_id', $serial_id)
                        ->where('product_id', $d_challan_details->product_id)
                        ->update($data);
                }
            } else {
                return back()->with('warning', 'Please select valid Serial Number. ');
            }

            return back()->with('success', 'Add Successfully');
        }
    }

    //edit
    public function delivery_challan_details_edit($id, $company_id)
    {
        $d_challan_details_edit = DB::table("pro_delivery_chalan_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_delivery_chalan_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_delivery_chalan_details_$company_id.*", "pro_finish_product_$company_id.product_name", 'pro_units.unit_name')
            ->where("pro_delivery_chalan_details_$company_id.delivery_chalan_details_id", $id)
            ->first();

        $d_challan =   DB::table("pro_delivery_chalan_master_$company_id")->where('delivery_chalan_master_id', $d_challan_details_edit->delivery_chalan_master_id)->first();
        $product_id = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->pluck('product_id');
        $product = DB::table("pro_finish_product_$company_id")->whereIn('product_id', $product_id)->get();

        return view('sales.delivery_challan_details', compact('d_challan', 'd_challan_details_edit', 'product'));
    }

    public function delivery_challan_details_update(Request $request, $id, $company_id)
    {

        $rules = [
            'cbo_product' => 'required',
            'txt_qty' => 'required',

        ];

        $customMessages = [
            'cbo_product.required' => 'Select Product',
            'txt_qty.required' => 'Quantity field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->txt_qty <= 0) {
            return back()->with('warning', 'Please Entry valid Number. ');
        }

        $d_challan_details = DB::table("pro_delivery_chalan_details_$company_id")
            ->where("pro_delivery_chalan_details_$company_id.delivery_chalan_details_id", $id)
            ->first();

        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")->where('delivery_chalan_master_id', $d_challan_details->delivery_chalan_master_id)->first();
        $p_sid = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $request->cbo_product)->first();

        $sale_qty = $p_sid->qty;
        $delivery_qty = ($p_sid->deliver_qty == null ? '0' : $p_sid->deliver_qty) + $request->txt_qty - $d_challan_details->del_qty;

        if ($delivery_qty > $sale_qty) {
            return back()->with('warning', "Deliver Qty Getter Then Sales Qty ($delivery_qty > $sale_qty)");
        } else {
            $data = array();
            $data['company_id'] = $d_challan->company_id;
            $data['delivery_chalan_master_id'] = $d_challan->delivery_chalan_master_id;
            $data['sim_id'] = $d_challan->sim_id;
            $data['customer_id'] = $d_challan->customer_id;
            $data['product_id'] = $request->cbo_product;
            $data['del_qty'] = $request->txt_qty;
            $data['status'] = 1;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;

            DB::table("pro_delivery_chalan_details_$company_id")
                ->where("pro_delivery_chalan_details_$company_id.delivery_chalan_details_id", $id)
                ->update($data);
            DB::table("pro_sid_$company_id")
                ->where('sim_id', $d_challan->sim_id)
                ->where('product_id', $request->cbo_product)
                ->update([
                    'deliver_qty' => $delivery_qty,
                    'deliver_date' => $d_challan->dcm_date,
                ]);

            $p_sid_details = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $request->cbo_product)->first();
            if ($p_sid_details->qty == $p_sid_details->deliver_qty) {
                DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $request->cbo_product)->update(['status' => 3]);
            }

            $data1 =  DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('status', 3)->count();
            $data2 =  DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->count();

            if ($data1 == $data2) {
                DB::table("pro_sim_$company_id")->where('sim_id', $d_challan->sim_id)->update(['status' => 3]);
            }

            return redirect()->route('delivery_challan_details', [$d_challan_details->delivery_chalan_master_id, $company_id]);
        }
    }


    //Final 

    public function delivery_challan_details_final($id, $company_id)
    {
        DB::table("pro_delivery_chalan_master_$company_id")->where('delivery_chalan_master_id', $id)->update(['status' => 2]);
        DB::table("pro_delivery_chalan_details_$company_id")->where('delivery_chalan_master_id', $id)->update(['status' => 2]);
        return redirect()->route('rpt_delivery_challan_view', [$id, $company_id]);
    }



    //rpt
    public function rpt_delivery_challan()
    {
        return view('sales.rpt_delivery_challan');
    }

    public function rpt_delivery_challan_view($id, $company_id)
    {
        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name")
            ->where("pro_delivery_chalan_master_$company_id.delivery_chalan_master_id", $id)
            ->first();
        $d_details = DB::table("pro_delivery_chalan_details_$company_id")
            ->where('delivery_chalan_master_id', $id)
            ->get();
        return view('sales.rpt_delivery_challan_view', compact('d_challan', 'd_details'));
    }

    public function rpt_delivery_challan_print($id, $company_id)
    {
        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name")
            ->where("pro_delivery_chalan_master_$company_id.delivery_chalan_master_id", $id)
            ->first();
        $d_details = DB::table("pro_delivery_chalan_details_$company_id")
            ->where('delivery_chalan_master_id', $id)
            ->get();
        return view('sales.rpt_delivery_challan_print', compact('d_challan', 'd_details'));
    }

    //----End Delivery challan


    //Gate Pass
    public function gate_pass()
    {
        return view('sales.gate_pass');
    }

    public function gate_pass_info(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name")
            ->where("pro_delivery_chalan_master_$company_id.status", 2)
            ->where("pro_delivery_chalan_master_$company_id.gp_status", null)
            ->orderByDesc('delivery_chalan_master_id')
            ->get();
        return view('sales.gate_pass_info', compact('d_challan'));
    }


    public function gate_pass_store(Request $request, $id, $company_id)
    {
        $rules = [
            'txt_gate_pass_date' => 'required',

        ];

        $customMessages = [
            'txt_gate_pass_date.required' => 'Select Gate Pass Date!',

        ];
        $this->validate($request, $rules, $customMessages);

        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name")
            ->where("pro_delivery_chalan_master_$company_id.delivery_chalan_master_id", $id)
            ->first();

        $m_company = DB::table('pro_company')
            ->where('company_id', $company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";

        if ($d_challan) {

            $sim = DB::table("pro_sim_$company_id")->where("sim_id", $d_challan->sim_id)->first();
            $vat_no = $sim->mushok_no;


            $gate_pass_date = $request->txt_gate_pass_date;
            $invoice_date = date('Ym', strtotime($gate_pass_date));
            $invoice_search = $company_short_name . $invoice_date;
            $get_pass = DB::table("pro_gate_pass_master_$company_id")
                ->where('gate_pass_master_id', 'like', "$invoice_search%")
                ->orderByDesc("gate_pass_master_id")
                ->first();
            if (isset($get_pass)) {
                $gate_pass_master_id = "$invoice_search" . str_pad((substr($get_pass->gate_pass_master_id, -5) + 1), 5, '0', STR_PAD_LEFT);
            } else {
                $gate_pass_master_id =  $invoice_search . "00001";
            }


            $data = array();
            $data['gate_pass_master_id'] = $gate_pass_master_id;
            $data['gate_pass_date'] = $gate_pass_date;
            $data['company_id'] = $company_id;
            $data['delivery_chalan_master_id'] = $d_challan->delivery_chalan_master_id;
            $data['dcm_date'] = $d_challan->dcm_date;
            $data['sim_id'] = $d_challan->sim_id;
            $data['sim_date'] = $d_challan->sim_date;
            $data['customer_id'] = $d_challan->customer_id;
            $data['delivery_address'] = $d_challan->delivery_address;
            $data['vat_no'] = $vat_no;
            $data['status'] = 2;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table("pro_gate_pass_master_$company_id")->insert($data);

            $d_details = DB::table("pro_delivery_chalan_details_$company_id")
                ->where('delivery_chalan_master_id', $d_challan->delivery_chalan_master_id)
                ->get();

            foreach ($d_details as $row) {
                $data2 = array();
                $data2['company_id'] = $company_id;
                $data2['gate_pass_master_id'] = $gate_pass_master_id;
                $data2['delivery_chalan_master_id'] = $row->delivery_chalan_master_id;
                $data2['delivery_chalan_details_id'] = $row->delivery_chalan_details_id;
                $data2['sim_id'] = $row->sim_id;
                $data2['customer_id'] = $row->customer_id;
                $data2['product_id'] = $row->product_id;
                $data2['del_qty'] = $row->del_qty;
                $data2['status'] = 2;
                $data2['user_id'] = Auth::user()->emp_id;
                $data2['entry_date'] = date('Y-m-d');
                $data2['entry_time'] = date("h:i:sa");
                $data2['valid'] = 1;
                DB::table("pro_gate_pass_details_$company_id")->insert($data2);
            }

            DB::table("pro_delivery_chalan_master_$company_id")
                ->where("delivery_chalan_master_id", $id)
                ->update(['gp_status' => '1']);

            return redirect()->route('rpt_gate_pass_view', [$gate_pass_master_id, $company_id])->with('success', 'Add Successfully!');
        } else {
            return back()->with('warning', 'Data Not Found!');
        }
    }

    //Report
    public function rpt_gate_pass()
    {
        return view('sales.rpt_gate_pass');
    }

    public function GetRptGatePassList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_gate_pass_master_$company_id")
                ->leftJoin('pro_company', "pro_gate_pass_master_$company_id.company_id", 'pro_company.company_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_gate_pass_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_gate_pass_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_company.company_name')
                ->where("pro_gate_pass_master_$company_id.valid", 1)
                ->orderByDesc('gate_pass_id')
                ->get();
        } else {
            $data = DB::table("pro_gate_pass_master_$company_id")
                ->leftJoin('pro_company', "pro_gate_pass_master_$company_id.company_id", 'pro_company.company_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_gate_pass_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_gate_pass_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_company.company_name')
                ->where("pro_gate_pass_master_$company_id.valid", 1)
                ->whereBetween("pro_gate_pass_master_$company_id.gate_pass_date", [$form, $to])
                ->orderByDesc('gate_pass_id')
                ->get();
        }
        return response()->json($data);
    }

    public function rpt_gate_pass_view($id, $company_id)
    {

        $gate_pass = DB::table("pro_gate_pass_master_$company_id")
            ->leftJoin('pro_company', "pro_gate_pass_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_gate_pass_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select(
                "pro_gate_pass_master_$company_id.*",
                "pro_customer_information_$company_id.customer_name",
                'pro_company.company_name',
            )
            ->where("pro_gate_pass_master_$company_id.gate_pass_master_id", $id)
            ->first();

        $gp_details = DB::table("pro_gate_pass_details_$company_id")
            ->where("pro_gate_pass_details_$company_id.gate_pass_master_id", $id)
            ->get();

        return view('sales.rpt_gate_pass_view', compact('gate_pass', 'gp_details'));
    }

    public function rpt_gate_pass_print($id, $company_id)
    {

        $gate_pass = DB::table("pro_gate_pass_master_$company_id")
            ->leftJoin('pro_company', "pro_gate_pass_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_gate_pass_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin("pro_mushok_$company_id", "pro_gate_pass_master_$company_id.vat_no", "pro_mushok_$company_id.mushok_id")
            ->select(
                "pro_gate_pass_master_$company_id.*",
                "pro_customer_information_$company_id.customer_name",
                'pro_company.company_name',
                // "pro_mushok_$company_id.mushok_number"
            )
            ->where("pro_gate_pass_master_$company_id.gate_pass_master_id", $id)
            ->first();

        $gp_details = DB::table("pro_gate_pass_details_$company_id")
            ->where("pro_gate_pass_details_$company_id.gate_pass_master_id", $id)
            ->get();

        return view('sales.rpt_gate_pass_print', compact('gate_pass', 'gp_details'));
    }



    //---End Gate Pass


    //--Requisition 
    public function requisition()
    {

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        return view('sales.requisition', compact('user_company', 'customer_type'));
    }

    public function requisition_master_store(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required',
            'cbo_customer' => 'required',
            'txt_deposit_amount' => 'required',
            'txt_req_date' => 'required',
            // 'txt_po_no' => 'required',
            // 'txt_ref_date' => 'required',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company!',
            'cbo_customer.required' => 'Select Customer!',
            'txt_deposit_amount.required' => 'Deposit Required!',
            'txt_req_date.required' => 'Requisition Date Required!',
            // 'txt_po_no.required' => 'Po no Required!',
            // 'txt_ref_date.required' => 'Ref Date Required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $req = DB::table("pro_sales_requisition_master_$request->cbo_company_id")->orderByDesc("requisition_master_id")->first();
        if (isset($req)) {
            $requisition_master_id = "TSSR" . date("Ym") . str_pad((substr($req->requisition_master_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $requisition_master_id = "TSSR" . date("Ym") . "00001";
        }

        $data = array();
        $data['requisition_master_id'] =  $requisition_master_id;
        $data['requisition_date'] =  $request->txt_req_date;
        $data['company_id'] =  $request->cbo_company_id;
        $data['customer_id'] =  $request->cbo_customer;
        $data['deposit_amount'] =  $request->txt_deposit_amount == null ? "0" : $request->txt_deposit_amount;
        $data['last_balance'] =  $request->txt_customer_balance == null ? "0" : $request->txt_customer_balance;
        $data['pono_ref'] =  $request->txt_po_no;
        $data['pono_ref_date'] =  $request->txt_ref_date;
        $data['remarks'] =  $request->txt_remark;
        $data['status'] = 1;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        DB::table("pro_sales_requisition_master_$request->cbo_company_id")->insert($data);
        return redirect()->route('requisition_details', [$requisition_master_id, $request->cbo_company_id]);
    }

    public function requisition_details($id, $company_id)
    {
        $req_master = DB::table("pro_sales_requisition_master_$company_id")->where('requisition_master_id', $id)->first();
        $req_details = DB::table("pro_sales_requisition_details_$company_id")->where('requisition_master_id', $id)->get();
        return view('sales.requisition_details', compact('req_master', 'req_details'));
    }

    public function requisition_details_store(Request $request, $id, $company_id)
    {
        $rules = [
            'cbo_product' => 'required',
            'txt_qty' => 'required',
            'cbo_rate_policy' => 'required',

        ];

        $customMessages = [
            'cbo_product.required' => 'Select Product!',
            'txt_qty.required' => 'Qty Required!',
            'cbo_rate_policy.required' => 'Rate Required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $req_master = DB::table("pro_sales_requisition_master_$company_id")->where('requisition_master_id', $id)->first();
        $rate_policy = DB::table("pro_rate_policy_$req_master->company_id")
            ->where('rate_policy_id', $request->cbo_rate_policy)
            ->first();

        $rate_chart = DB::table("pro_rate_chart_$req_master->company_id")
            ->where('rate_group', $rate_policy->rate_group)
            ->where('product_id', $request->cbo_product)
            ->first();

        $rate = $rate_chart == null ? '0' : $rate_chart->rate;
        $commision_rate = $request->txt_commision_rate == null ? '0' : $request->txt_commision_rate;
        $cr_allowance = $request->txt_cr_allowance == null ? '0' : $request->txt_cr_allowance;
        $qty = $request->txt_qty == null ? '0' : $request->txt_qty;

        $total =  $rate * $qty;
        $commision_rate_total = $commision_rate * $qty;
        $cr_allowance_total = $cr_allowance * $qty;
        $net_total = $total - $commision_rate_total -   $cr_allowance_total;

        $data = array();
        $data['requisition_master_id'] = $req_master->requisition_master_id;
        $data['requisition_date'] = $req_master->requisition_date;
        $data['company_id'] = $req_master->company_id;
        $data['customer_id'] = $req_master->customer_id;
        $data['product_id'] = $request->cbo_product;
        $data['qty'] = $request->txt_qty;
        $data['rate'] = $rate;
        $data['total'] = $total;
        $data['rate_policy_id'] = $request->cbo_rate_policy;
        $data['comm_rate'] = $commision_rate;
        $data['comm_rate_total'] = $commision_rate_total;
        $data['transport_rate'] = $cr_allowance;
        $data['total_transport'] = $cr_allowance_total;
        $data['net_total'] = $net_total;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        $data['status'] = 1;

        DB::table("pro_sales_requisition_details_$company_id")->insert($data);

        return back()->with('success', 'Add Successfully');
    }

    public function requisition_final($id, $company_id)
    {
        $req_master = DB::table("pro_sales_requisition_master_$company_id")->where('requisition_master_id', $id)->update(['status' => 2]);
        $req_details = DB::table("pro_sales_requisition_details_$company_id")->where('requisition_master_id', $id)->update(['status' => 2]);
        return redirect()->route('rpt_requisition_view', [$id, $company_id]);
    }

    //End requisition 

    //requisition Approval
    public function requisition_approval_list()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_company.sales_status', 1)
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->get();
        return view('sales.requisition_approval_list', compact('user_company'));
    }

    public function requisition_approved_details($id, $company_id)
    {
        $req_master = DB::table("pro_sales_requisition_master_$company_id")
            ->leftJoin('pro_employee_info', "pro_sales_requisition_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select("pro_sales_requisition_master_$company_id.*", 'pro_employee_info.employee_name')
            ->where("pro_sales_requisition_master_$company_id.status", 2)
            ->where("pro_sales_requisition_master_$company_id.valid", 1)
            ->orderByDesc("pro_sales_requisition_master_$company_id.requisition_master_id")
            ->first();

        $req_details = DB::table("pro_sales_requisition_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_sales_requisition_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_sales_requisition_details_$company_id.*", "pro_finish_product_$company_id.product_name", "pro_finish_product_$company_id.product_description", 'pro_units.unit_name')
            ->where("pro_sales_requisition_details_$company_id.requisition_master_id", $req_master->requisition_master_id)
            ->where("pro_sales_requisition_details_$company_id.status", 2)
            ->get();

        $customer = DB::table("pro_customer_information_$company_id")
            ->where('customer_id', $req_master->customer_id)
            ->first();

        return view('sales.requisition_approved_details', compact('req_master', 'req_details', 'customer'));
    }

    public function requisition_approved_confirm(Request $request, $id, $company_id)
    {
        $rules = [
            // 'txt_comment' => 'required',
            'cbo_approved_status' => 'required',

        ];

        $customMessages = [
            'cbo_approved_status.required' => 'Select Approved!',
            // 'txt_comment.required' => 'Comment is Required!',

        ];
        $this->validate($request, $rules, $customMessages);

        DB::table("pro_sales_requisition_master_$company_id")->where('requisition_master_id', $id)
            ->update([
                'status' => 3,
                'comments' => $request->txt_comment,
                'approved' => $request->cbo_approved_status,
                'approved_id' => Auth::user()->emp_id,
            ]);

        return redirect()->route('requisition_approval_list')->with(['success' => "Successfull", 'company_id' => $company_id]);
    }



    public function GetReqNotFinalList($company_id)
    {
        $data = DB::table("pro_sales_requisition_master_$company_id")
            ->leftJoin('pro_employee_info', "pro_sales_requisition_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_sales_requisition_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_sales_requisition_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
            ->where("pro_sales_requisition_master_$company_id.status", 2)
            ->where("pro_sales_requisition_master_$company_id.valid", 1)
            ->orderByDesc("pro_sales_requisition_master_$company_id.requisition_master_id")
            ->get();
        return response()->json($data);
    }




    //RPT requisition
    public function rpt_requisition()
    {
        return view('sales.rpt_requisition');
    }

    public function GetRptRequisitionList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_sales_requisition_master_$company_id")
                ->leftJoin('pro_employee_info', "pro_sales_requisition_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->leftJoin('pro_employee_info as approved_info', "pro_sales_requisition_master_$company_id.approved_id", 'approved_info.employee_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_sales_requisition_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_sales_requisition_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name', 'approved_info.employee_name as approved_by')
                ->where("pro_sales_requisition_master_$company_id.valid", 1)
                ->where("pro_sales_requisition_master_$company_id.status", '>', 1)
                ->orderByDesc("pro_sales_requisition_master_$company_id.requisition_master_id")
                ->get();
        } else {
            $data = DB::table("pro_sales_requisition_master_$company_id")
                ->leftJoin('pro_employee_info', "pro_sales_requisition_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->leftJoin('pro_employee_info as approved_info', "pro_sales_requisition_master_$company_id.approved_id", 'approved_info.employee_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_sales_requisition_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_sales_requisition_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name', 'approved_info.employee_name as approved_by')
                ->where("pro_sales_requisition_master_$company_id.valid", 1)
                ->where("pro_sales_requisition_master_$company_id.status", '>', 1)
                ->whereBetween("pro_sales_requisition_master_$company_id.requisition_date", [$form, $to])
                ->orderByDesc("pro_sales_requisition_master_$company_id.requisition_master_id")
                ->get();
        }
        return response()->json($data);
    }

    public function rpt_requisition_view($id, $company_id)
    {
        $m_requisition_master = DB::table("pro_sales_requisition_master_$company_id")
            ->leftJoin('pro_company', "pro_sales_requisition_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_sales_requisition_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_sales_requisition_master_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", "pro_customer_information_$company_id.customer_mobile", 'pro_company.company_name')
            ->where("pro_sales_requisition_master_$company_id.valid", 1)
            ->where("pro_sales_requisition_master_$company_id.requisition_master_id", $id)
            ->first();

        $m_requisition_details =  DB::table("pro_sales_requisition_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_sales_requisition_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_sales_requisition_details_$company_id.*", "pro_finish_product_$company_id.product_name", "pro_finish_product_$company_id.product_description", 'pro_units.unit_name')
            ->where("pro_sales_requisition_details_$company_id.requisition_master_id", $id)
            ->get();

        return view('sales.rpt_requisition_view', compact('m_requisition_master', 'm_requisition_details'));
    }

    public function rpt_requisition_print($id, $company_id)
    {
        $m_requisition_master = DB::table("pro_sales_requisition_master_$company_id")
            ->leftJoin('pro_company', "pro_sales_requisition_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_sales_requisition_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_sales_requisition_master_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", "pro_customer_information_$company_id.customer_mobile", 'pro_company.company_name')
            ->where("pro_sales_requisition_master_$company_id.valid", 1)
            ->where("pro_sales_requisition_master_$company_id.requisition_master_id", $id)
            ->first();

        $m_requisition_details =  DB::table("pro_sales_requisition_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_sales_requisition_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_sales_requisition_details_$company_id.*", "pro_finish_product_$company_id.product_name", "pro_finish_product_$company_id.product_description", 'pro_units.unit_name')
            ->where("pro_sales_requisition_details_$company_id.requisition_master_id", $id)
            ->get();


        return view('sales.rpt_requisition_print', compact('m_requisition_master', 'm_requisition_details'));
    }

    //Return sales Invoice 
    public function return_invoice()
    {
        return view('sales.return_invoice');
    }

    public function return_invoice_details(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_invoice_id' => 'required',
            'txt_return_date' => 'required',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company!',
            'cbo_invoice_id.required' => 'Select Invoice!',
            'txt_return_date.required' => 'Return Date Required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['cbo_company_id'] = $request->cbo_company_id;
        $data['cbo_invoice_id'] = $request->cbo_invoice_id;
        $data['txt_return_date'] = $request->txt_return_date;

        return view('sales.return_invoice_details', compact('data'));
    }

    public function return_invoice_store(Request $request, $id, $company_id)
    {

        $rules = [
            'txt_return_date' => 'required',

        ];

        $customMessages = [
            'txt_return_date.required' => 'Return Date Required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_return_date = $request->txt_return_date;

        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_company', "pro_sim_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_sim_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", 'pro_company.company_name')
            ->where("pro_sim_$company_id.sim_id", $id)
            ->first();

        $rsim = DB::table("pro_return_invoice_master_$company_id")->orderByDesc("rsim_id")->first();

        $m_company = DB::table('pro_company')
            ->where('company_id', $company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";

        if (isset($rsim)) {
            $rsim_no = "$company_short_name" . date("Ym") . str_pad((substr($rsim->rsim_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $rsim_no = "$company_short_name" . date("Ym") . "00001";
        }

        $data = array();
        $data['rsim_id'] = $rsim_no;
        $data['rsim_date'] = $m_return_date;
        $data['sim_id'] = $m_sales->sim_id;
        $data['customer_id'] = $m_sales->customer_id;
        $data['pg_id'] = $m_sales->pg_id;
        $data['mushok_no'] = $m_sales->mushok_no;
        $data['ifb_no'] = $m_sales->ifb_no;
        $data['ifb_date'] = $m_sales->ifb_date;
        $data['contract_no'] = $m_sales->contract_no;
        $data['contract_date'] = $m_sales->contract_date;
        $data['allocation_no'] = $m_sales->allocation_no;
        $data['allocation_date'] = $m_sales->allocation_date;
        $data['pono_ref'] = $m_sales->pono_ref;
        $data['pono_ref_date'] = $m_sales->pono_ref_date;
        $data['company_id'] = $company_id;
        $data['money_receipt_no'] = $m_sales->money_receipt_no;
        $data['sinv_total'] = $m_sales->sinv_total;
        $data['sinv_date'] = $m_sales->sim_date;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        $data['status'] = 1;

        DB::table("pro_return_invoice_master_$company_id")->insert($data);
        return redirect()->route('return_sales_invoice_details', [$rsim_no, $company_id]);
    }

    public function return_sales_invoice_details($id, $company_id)
    {
        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->where('rsim_id', $id)
            ->first();

        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_company', "pro_sim_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_sim_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", 'pro_company.company_name')
            ->where("pro_sim_$company_id.sim_id", $riv_master->sim_id)
            ->first();

        $riv_details_product = DB::table("pro_return_invoice_details_$company_id")
            ->where('rsim_id', $id)
            ->pluck('product_id');

        $m_sales_details = DB::table("pro_sid_$company_id")
            ->where('rsim_status', null)
            ->where('sim_id', $riv_master->sim_id)
            ->whereNotIn('product_id', $riv_details_product)
            ->pluck('product_id');

        $product = DB::table("pro_finish_product_$company_id")
            ->whereIn('product_id', $m_sales_details)
            ->get();

        $m_return_invoice_details = DB::table("pro_return_invoice_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_return_invoice_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_return_invoice_details_$company_id.*",
                "pro_finish_product_$company_id.product_name",
                "pro_finish_product_$company_id.model_size",
                "pro_finish_product_$company_id.product_description",
            )
            ->where("pro_return_invoice_details_$company_id.rsim_id", $id)
            ->get();

        return view('sales.return_sales_invoice_details', compact('riv_master', 'm_sales', 'product', 'm_return_invoice_details'));
    }

    public function return_sales_invoice_details_store(Request $request, $id, $company_id)
    {

        $rules = [
            'txt_qty' => 'required',
            'cbo_damage' => 'required',
            'cbo_product_id' => 'required',

        ];

        $customMessages = [
            'txt_qty.required' => 'Return Qty Required',
            'cbo_damage.required' => 'Select Damage',
            'cbo_product_id.required' => 'Select Product',

        ];
        $this->validate($request, $rules, $customMessages);

        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->where('rsim_id', $id)
            ->first();

        $product = DB::table("pro_finish_product_$company_id")
            ->where('product_id', $request->cbo_product_id)
            ->first();

        $m_customer_information = DB::table("pro_customer_information_$company_id")
            ->where('customer_id', $riv_master->customer_id)
            ->where('valid', 1)
            ->first();
        $cust_sppl = $m_customer_information == null ? "" : $m_customer_information->cust_sppl;

        $m_sales_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $riv_master->sim_id)
            ->where('product_id', $request->cbo_product_id)
            ->first();

        $sales_total_qty = $m_sales_details->qty;
        $rsim_qty = $m_sales_details->rsim_qty == null ? 0 : $m_sales_details->rsim_qty;
        $total_rsim_qty = $request->txt_qty +  $rsim_qty;

        if ($total_rsim_qty > $sales_total_qty) {
            return back()->with('warning', "Return Qty Getter Then Sales Qty ($total_rsim_qty>$m_sales_details->qty)");
        } else {

            $return_qty =  $request->txt_qty == null ? "0" : $request->txt_qty;
            $sales_rate =  $m_sales_details->rate == null ? "0" : $m_sales_details->rate;
            $total_sales_price = $return_qty * $sales_rate;

            $vat_amount = $request->txt_vat_amount == null ? "0" : $request->txt_vat_amount;
            $discount = $request->txt_discount == null ? "0" : $request->txt_discount;
            $depreciation = $request->txt_depreciation == null ? "0" : $request->txt_depreciation;

            $net_payble =  $total_sales_price - ($vat_amount + $discount + $depreciation);

            $data = array();
            $data['rsim_id'] = $riv_master->rsim_id;
            $data['rsim_date'] = $riv_master->rsim_date;
            $data['company_id'] = $riv_master->company_id;
            $data['customer_id'] = $riv_master->customer_id;
            $data['cust_sppl'] = $cust_sppl;
            $data['pg_id'] = $product->pg_id;
            $data['product_id'] = $request->cbo_product_id;
            $data['return_qty'] = $request->txt_qty;
            $data['sales_rate'] = $sales_rate;
            $data['total_sales_price'] = $total_sales_price;
            $data['vat_amount'] = $vat_amount;
            $data['discount_amount'] = $discount;
            $data['depreciation'] = $depreciation;
            $data['net_payble'] = $net_payble;
            $data['remarks'] = $request->txt_remark;
            $data['status'] = 1;
            $data['damage_status'] = $request->cbo_damage;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            $data['status'] = 1;
            DB::table("pro_return_invoice_details_$company_id")->insert($data);

            //sid details status update
            if ($total_rsim_qty == $sales_total_qty) {
                DB::table("pro_sid_$company_id")
                    ->where('sim_id', $riv_master->sim_id)
                    ->where('product_id', $request->cbo_product_id)
                    ->update([
                        'rsim_qty' => $total_rsim_qty,
                        'rsim_status' => 1,
                    ]);
            } else {
                DB::table("pro_sid_$company_id")
                    ->where('sim_id', $riv_master->sim_id)
                    ->where('product_id', $request->cbo_product_id)
                    ->update([
                        'rsim_qty' => $total_rsim_qty,
                    ]);
            }

            //sim master status update
            $data1 = DB::table("pro_sid_$company_id")
                ->where('sim_id', $riv_master->sim_id)
                ->count();
            $data2 = DB::table("pro_sid_$company_id")
                ->where('sim_id', $riv_master->sim_id)
                ->where('rsim_status', 1)
                ->count();

            if ($data1 == $data2) {
                DB::table("pro_sim_$company_id")
                    ->where("sim_id", $riv_master->sim_id)
                    ->update([
                        'rsim_status' => 1
                    ]);
            }

            return back()->with('success', "Add Successfully");
        }
    }

    public function return_sales_invoice_final($id, $company_id)
    {
        DB::table("pro_return_invoice_master_$company_id")
            ->where('rsim_id', $id)
            ->update(['status' => 2]);

        DB::table("pro_return_invoice_details_$company_id")
            ->where('rsim_id', $id)
            ->update(['status' => 2]);

        return redirect()->route('rpt_return_sales_invoice_view', [$id, $company_id]);
    }

    public function return_sales_invoice_edit($id, $company_id)
    {
        $m_return_invoice_details = DB::table("pro_return_invoice_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_return_invoice_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_return_invoice_details_$company_id.*",
                "pro_finish_product_$company_id.product_name",
                "pro_finish_product_$company_id.model_size",
                "pro_finish_product_$company_id.product_description",
            )
            ->where("pro_return_invoice_details_$company_id.rsid_id", $id)
            ->first();

        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_company', "pro_return_invoice_master_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", 'pro_company.company_name')
            ->where("pro_return_invoice_master_$company_id.rsim_id", $m_return_invoice_details->rsim_id)
            ->first();

        $m_sales = DB::table("pro_sim_$company_id")
            ->where("pro_sim_$company_id.sim_id", $riv_master->sim_id)
            ->first();

        $m_sales_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $riv_master->sim_id)
            ->pluck('product_id');

        $product = DB::table("pro_finish_product_$company_id")
            ->whereIn('product_id', $m_sales_details)
            ->get();

        return view('sales.return_sales_invoice_edit', compact('m_return_invoice_details', 'riv_master', 'm_sales', 'product'));
    }

    public function return_sales_invoice_update(Request $request, $id, $company_id)
    {
        $rules = [
            'txt_qty' => 'required',
            'cbo_damage' => 'required',

        ];

        $customMessages = [
            'txt_qty.required' => 'Return Qty Required',
            'cbo_damage.required' => 'Select Damage',

        ];
        $this->validate($request, $rules, $customMessages);

        $riv_details = DB::table("pro_return_invoice_details_$company_id")
            ->where('rsid_id', $id)
            ->first();

        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->where('rsim_id', $riv_details->rsim_id)
            ->first();

        $m_sales_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $riv_master->sim_id)
            ->where('product_id', $riv_details->product_id)
            ->first();

        $total_qty = $m_sales_details->qty;
        $rsim_qty = $m_sales_details->rsim_qty == null ? 0 : $m_sales_details->rsim_qty;
        $total_reinvm_qty = $request->txt_qty +  $rsim_qty - $riv_details->return_qty;

        if ($total_reinvm_qty > $total_qty) {
            return back()->with('warning', "Return Qty Getter Then Sales Qty ($total_reinvm_qty>$m_sales_details->qty)");
        } else {

            $qty =  $request->txt_qty == null ? "0" : $request->txt_qty;
            $sales_rate =  $m_sales_details->rate == null ? "0" : $m_sales_details->rate;
            $sales_total = $qty * $sales_rate;

            $vat_amount = $request->txt_vat_amount == null ? "0" : $request->txt_vat_amount;
            $discount = $request->txt_discount == null ? "0" : $request->txt_discount;
            $depreciation = $request->txt_depreciation == null ? "0" : $request->txt_depreciation;

            $net_payble =  $sales_total - ($vat_amount + $discount + $depreciation);

            $data = array();
            $data['return_qty'] = $request->txt_qty;
            $data['sales_rate'] = $sales_rate;
            $data['total_sales_price'] = $sales_total;
            $data['vat_amount'] = $vat_amount;
            $data['discount_amount'] = $discount;
            $data['depreciation'] = $depreciation;
            $data['net_payble'] = $net_payble;
            $data['remarks'] = $request->txt_remark;
            $data['damage_status'] = $request->cbo_damage;
            DB::table("pro_return_invoice_details_$company_id")->where('rsid_id', $id)->update($data);

            //sid details status update

            if ($total_reinvm_qty == $total_qty) {
                DB::table("pro_sid_$company_id")
                    ->where('sim_id', $riv_master->sim_id)
                    ->where('product_id', $request->cbo_product_id)
                    ->update([
                        'rsim_qty' => $total_reinvm_qty,
                        'rsim_status' => 1,
                    ]);
            } else {

                DB::table("pro_sid_$company_id")
                    ->where('sim_id', $riv_master->sim_id)
                    ->where('product_id', $request->cbo_product_id)
                    ->update([
                        'rsim_qty' => $total_reinvm_qty,
                    ]);
            }

            //sim master status update
            $data1 = DB::table("pro_sid_$company_id")
                ->where('sim_id', $riv_master->sim_id)
                ->count();
            $data2 = DB::table("pro_sid_$company_id")
                ->where('sim_id', $riv_master->sim_id)
                ->where('rsim_status', 1)
                ->count();

            if ($data1 == $data2) {
                DB::table("pro_sim_$company_id")
                    ->where("sim_id", $riv_master->sim_id)
                    ->update([
                        'rsim_status' => 1
                    ]);
            }

            return redirect()->route('return_sales_invoice_details', [$riv_details->rsim_id, $company_id]);
        }
    }

    public function return_sales_invoice_serial($id, $company_id)
    {
        $m_return_invoice_details = DB::table("pro_return_invoice_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_return_invoice_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_return_invoice_details_$company_id.*",
                "pro_finish_product_$company_id.product_name",
                "pro_finish_product_$company_id.model_size",
                "pro_finish_product_$company_id.product_description",
            )
            ->where("pro_return_invoice_details_$company_id.rsid_id", $id)
            ->first();

        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.*",)
            ->where("pro_return_invoice_master_$company_id.rsim_id", $m_return_invoice_details->rsim_id)
            ->first();

        return view('sales.return_sales_invoice_serial', compact('m_return_invoice_details', 'riv_master'));
    }

    public function return_sales_invoice_serial_store(Request $request, $id, $company_id)
    {

        $rules = [
            'cbo_serial' => 'required|integer|between:1,100000000000',
            'txt_qty' => 'required',
        ];
        $customMessages = [
            'cbo_serial.required' => 'Select Serial Number.',
            'txt_qty.between' => 'Qty Required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_return_invoice_details = DB::table("pro_return_invoice_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_return_invoice_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_return_invoice_details_$company_id.*",
                "pro_finish_product_$company_id.product_name",
                "pro_finish_product_$company_id.model_size",
                "pro_finish_product_$company_id.product_description",
            )
            ->where("pro_return_invoice_details_$company_id.rsid_id", $id)
            ->first();

        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.*")
            ->where("pro_return_invoice_master_$company_id.rsim_id", $m_return_invoice_details->rsim_id)
            ->first();

        $finish_product_serial_count = DB::table("pro_finish_product_serial_$company_id")
            ->where('rsid_id', $m_return_invoice_details->rsid_id)
            ->where('rsim_id', $m_return_invoice_details->rsim_id)
            ->where('product_id', $m_return_invoice_details->product_id)
            ->count();

        if ($finish_product_serial_count >= $m_return_invoice_details->return_qty) {
            return back()->with('warning', "Alredy Add Serial");
        } elseif ($request->txt_qty > $m_return_invoice_details->return_qty) {
            return back()->with('warning', "Return qty getter then serial qty ($request->txt_qty > $m_return_invoice_details->return_qty)");
        } else {

            $flag = 0;
            for ($i = 0; $i < $request->txt_qty; $i++) {
                $serial_id =  $request->cbo_serial + $i;
                $check = DB::table("pro_finish_product_serial_$company_id")->where('serial_id', $serial_id)
                    ->where('sim_id', $riv_master->sim_id)
                    ->where('product_id', $m_return_invoice_details->product_id)
                    ->first();

                if (isset($check)) {
                    $flag =  $flag + 1;
                }
            }

            if ($flag == $request->txt_qty) {
                for ($i = 0; $i < $request->txt_qty; $i++) {
                    $serial_id =  $request->cbo_serial + $i;
                    $data = array();
                    $data['rsid_id'] = $m_return_invoice_details->rsid_id;
                    $data['rsim_id'] = $m_return_invoice_details->rsim_id;
                    $data['status'] = 4;
                    DB::table("pro_finish_product_serial_$company_id")
                        ->where('serial_id', $serial_id)
                        ->where('sim_id', $riv_master->sim_id)
                        ->where('product_id', $m_return_invoice_details->product_id)
                        ->update($data);
                }
            } else {
                return back()->with('warning', 'Please select valid Serial Number. ');
            }

            return back()->with('success', 'Add Successfully');
        }
    }

    //report sales return invoice
    public function rpt_return_sales_invoice()
    {
        return view('sales.rpt_return_sales_invoice');
    }

    public function rpt_return_sales_invoice_view($id, $company_id)
    {
        $rim_master =  DB::table("pro_return_invoice_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_employee_info', "pro_return_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", 'pro_employee_info.employee_name')
            ->where("pro_return_invoice_master_$company_id.rsim_id", $id)
            ->first();

        $rid_details = DB::table("pro_return_invoice_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_return_invoice_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_return_invoice_details_$company_id.*",
                "pro_finish_product_$company_id.product_name",
                "pro_finish_product_$company_id.model_size",
                "pro_finish_product_$company_id.product_description",
            )
            ->where("pro_return_invoice_details_$company_id.rsim_id", $id)
            ->get();

        return view('sales.rpt_return_sales_invoice_view', compact('rim_master', 'rid_details'));
    }

    public function rpt_return_sales_invoice_print($id, $company_id)
    {
        $rim_master =  DB::table("pro_return_invoice_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_employee_info', "pro_return_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", 'pro_employee_info.employee_name')
            ->where("pro_return_invoice_master_$company_id.rsim_id", $id)
            ->first();

        $rid_details = DB::table("pro_return_invoice_details_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_return_invoice_details_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_return_invoice_details_$company_id.*",
                "pro_finish_product_$company_id.product_name",
                "pro_finish_product_$company_id.model_size",
                "pro_finish_product_$company_id.product_description",
            )
            ->where("pro_return_invoice_details_$company_id.rsim_id", $id)
            ->get();

        return view('sales.rpt_return_sales_invoice_print', compact('rim_master', 'rid_details'));
    }


    // Repair Invoice Start

    public function repair_invoice()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->leftJoin('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $m_customer_type = DB::table('pro_customer_type')->get();
        return view('sales.repair_invoice', compact('m_customer_type', 'user_company'));
    }

    // ajax 

    public function customerAddressForRepairInvoice($id, $company_id)
    {
        $address = DB::table("pro_customer_information_$company_id")->where('customer_id', $id)->first();
        $customer_address = "$address->customer_address";
        return response()->json($customer_address);
    }

    public function MoneyReceiptForRepairInvoice($customer_id, $company_id)
    {
        $m_repair_mr_id = DB::table("pro_repair_invoice_master_$company_id")->pluck('mr_id');
        $data = DB::table("pro_money_receipt_$company_id")
            ->whereNotIn('mr_id', $m_repair_mr_id)
            ->where('customer_id', $customer_id)
            ->where('valid', 1)
            ->orderByDesc('mr_id')
            ->get();
        return response()->json($data);
    }

    public function GetSalesRepairInvoiceList($company_id, $form, $to, $pg_id)
    {
        if ($form == 0) {
            if ($pg_id == 0) {
                $data =  DB::table("pro_repair_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_repair_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_repair_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_repair_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->orderByDesc("pro_repair_invoice_master_$company_id.reinvm_id")
                    ->get();
            } else {
                $data =  DB::table("pro_repair_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_repair_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_repair_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_repair_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->where("pro_repair_invoice_master_$company_id.pg_id", $pg_id)
                    ->orderByDesc("pro_repair_invoice_master_$company_id.reinvm_id")
                    ->get();
            }
        } else {
            if ($pg_id == 0) {
                $data = DB::table("pro_repair_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_repair_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_repair_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_repair_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->whereBetween("pro_repair_invoice_master_$company_id.reinvm_date", [$form, $to])
                    ->orderByDesc("pro_repair_invoice_master_$company_id.reinvm_id")
                    ->get();
            } else {
                $data = DB::table("pro_repair_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_repair_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_repair_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_repair_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->whereBetween("pro_repair_invoice_master_$company_id.reinvm_date", [$form, $to])
                    ->where("pro_repair_invoice_master_$company_id.pg_id", $pg_id)
                    ->orderByDesc("pro_repair_invoice_master_$company_id.reinvm_id")
                    ->get();
            }
        }

        return response()->json($data);
    }

    public function GetSalesRepairInvoiceNotFinal($company_id)
    {
        $data =  DB::table("pro_repair_invoice_master_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_repair_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_employee_info', "pro_repair_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select("pro_repair_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
            ->where("pro_repair_invoice_master_$company_id.company_id", $company_id)
            ->where("pro_repair_invoice_master_$company_id.status", 1)
            ->where("pro_repair_invoice_master_$company_id.reinvm_date", '>', '2023-12-31')
            ->orderByDesc('reinvm_id')
            ->get();
        return response()->json($data);
    }


    public function GetSalesRepairProductList($id, $company_id)
    {
        $data = DB::table("pro_finish_product_$company_id")
            ->where('pg_id', $id)
            ->where('valid', 1)
            ->get();
        return response()->json($data);
    }


    //Store
    public function repair_invoice_store(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required',
            'cbo_transformer_ctpt' => 'required',
            'cbo_customer' => 'required',
            'txt_repair_date' => 'required',
            'cbo_product_name' => 'required',
            'txt_repair_qty' => 'required',
            // 'cbo_mr_number' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_transformer_ctpt.required' => 'Select Transformer / CTPT.',
            'cbo_customer.required' => 'Select Customer.',
            'txt_repair_date.required' => 'Repair Date required.',
            'cbo_product_name.required' => 'Select Product.',
            'txt_repair_qty.required' => 'Repair QTY required.',
            // 'cbo_mr_number.required' => 'Select MR Numberrequired.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $m_company = DB::table('pro_company')
            ->where('company_id', $company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";
        $m_customer_information = DB::table("pro_customer_information_$company_id")
            ->where('customer_id', $request->cbo_customer)
            ->where('valid', 1)
            ->first();
        $cust_sppl = $m_customer_information == null ? "" : $m_customer_information->cust_sppl;

        $rim = DB::table("pro_repair_invoice_master_$company_id")->orderByDesc("reinvm_id")->first();
        if (isset($rim)) {
            $reinvm_id = "$company_short_name" . date("Ym") . str_pad((substr($rim->reinvm_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $reinvm_id = "$company_short_name" . date("Ym") . "00001";
        }

        $data = array();
        $data['reinvm_id'] = $reinvm_id;
        $data['reinvm_date'] = $request->txt_repair_date;
        $data['company_id'] = $company_id;
        $data['customer_id'] = $request->cbo_customer;
        $data['cust_sppl'] =  $cust_sppl;
        $data['pg_id'] = $request->cbo_transformer_ctpt;
        $data['product_id'] = $request->cbo_product_name;
        $data['repair_qty'] = $request->txt_repair_qty;
        $data['repair_date'] = $request->txt_repair_date;
        $data['serial_no'] = $request->txt_serial_no;
        $data['sold_date'] = $request->txt_sold_date;
        $data['recived_date'] = $request->txt_receive_date;
        $data['mr_id'] = $request->cbo_mr_number;
        $data['remarks'] = $request->txt_remarks;
        $data['user_id'] = Auth::user()->emp_id;
        $data['status'] = 1;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date('H:i:s');
        $data['valid'] = 1;
        DB::table("pro_repair_invoice_master_$company_id")->insert($data);
        return redirect()->route('repair_Invoice_details', [$reinvm_id, $company_id])->with('success', 'Data Inserted Successfully!');
    }

    public function repair_Invoice_details($id, $company_id)
    {
        $m_repair_master =  DB::table("pro_repair_invoice_master_$company_id")->where('reinvm_id', $id)->first();
        $m_customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $m_repair_master->customer_id)->where('valid', 1)->first();
        $m_product = DB::table("pro_finish_product_$company_id")->where('product_id', $m_repair_master->product_id)->where('valid', 1)->first();
        $m_company = DB::table('pro_company')->where('company_id', $m_repair_master->company_id)->where('valid', 1)->first();
        $m_unit = DB::table('pro_units')->where('valid', 1)->get();
        $m_repair_details =  DB::table("pro_repair_invoice_details_$company_id")->where('reinvm_id', $id)->get();
        return view('sales.repair_invoice_details', compact('m_repair_master', 'm_customer', 'm_product', 'm_company', 'm_unit', 'm_repair_details'));
    }

    public function repair_invoice_details_store(Request $request)
    {
        $rules = [
            'txt_product_description' => 'required',
            'cbo_product_unit' => 'required',
            'txt_product_qty' => 'required',
            'txt_product_price' => 'required',

        ];
        $customMessages = [
            'txt_product_description.required' => 'Description is required.',
            'cbo_product_unit.required' => 'Unit is required.',
            'txt_product_qty.required' => 'Qty is required.',
            'txt_product_price.required' => 'Unit Price is required.',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->txt_company_id;
        $reinvm_id = $request->txt_repair_id;
        $qty = $request->txt_product_qty == null ? 0 : $request->txt_product_qty;
        $unit_price = $request->txt_product_price == null ? 0 : $request->txt_product_price;
        $total =  $qty * $unit_price;
        $m_repair_master =  DB::table("pro_repair_invoice_master_$company_id")->where('reinvm_id', $reinvm_id)->first();

        $data = array();
        $data['reinvm_id'] = $reinvm_id;
        $data['reinvm_date'] = $m_repair_master->reinvm_date;
        $data['company_id'] = $company_id;
        $data['customer_id'] = $m_repair_master->customer_id;
        $data['pg_id'] = $m_repair_master->pg_id;
        $data['pro_des'] = $request->txt_product_description;
        $data['unit'] = $request->cbo_product_unit;
        $data['qty'] = $qty;
        $data['unit_price'] = $unit_price;
        $data['total'] = $total;
        $data['user_id'] = Auth::user()->emp_id;
        $data['status'] = 1;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date('H:i:s');
        $data['valid'] = 1;
        DB::table("pro_repair_invoice_details_$company_id")->insert($data);
        return back()->with('success', 'Data Inserted Successfully!');
    }

    public function repair_invoice_final($id, $company_id)
    {
        $m_repair_details_total_sum = DB::table("pro_repair_invoice_details_$company_id")->where('status', 1)->where('reinvm_id', $id)->sum('total');
        DB::table("pro_repair_invoice_master_$company_id")
            ->where('reinvm_id', $id)
            ->update([
                'reinv_total' => $m_repair_details_total_sum,
                'status' => 2,
            ]);

        DB::table("pro_repair_invoice_details_$company_id")
            ->where('reinvm_id', $id)
            ->update([
                'status' => 2,
            ]);

        return redirect()->route('rpt_repair_invoice_view', [$id, $company_id])->with('success', 'Data Add Successfully!');;
    }

    public function repair_invoice_details_edit($id, $company_id)
    {
        $m_repair_details = DB::table("pro_repair_invoice_details_$company_id")->where('reinvd_id', $id)->first();
        $m_repair_master =  DB::table("pro_repair_invoice_master_$company_id")->where('reinvm_id', $m_repair_details->reinvm_id)->first();
        $m_customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $m_repair_master->customer_id)->where('valid', 1)->first();
        $m_product = DB::table("pro_finish_product_$company_id")->where('product_id', $m_repair_master->product_id)->where('valid', 1)->first();
        $m_company = DB::table('pro_company')->where('company_id', $m_repair_master->company_id)->where('valid', 1)->first();
        $m_unit = DB::table('pro_units')->where('valid', 1)->get();
        return view('sales.repair_invoice_details_edit', compact('m_repair_master', 'm_customer', 'm_product', 'm_company', 'm_unit', 'm_repair_details'));
    }

    public function repair_invoice_details_update(Request $request)
    {
        $company_id = $request->txt_company_id;
        $reinvd_id = $request->txt_repair_id;
        $qty = $request->txt_product_qty == null ? 0 : $request->txt_product_qty;
        $unit_price = $request->txt_product_price == null ? 0 : $request->txt_product_price;
        $total =  $qty * $unit_price;
        $m_repair_master =  DB::table("pro_repair_invoice_details_$company_id")->where('reinvd_id', $reinvd_id)->first();

        $data = array();
        $data['pro_des'] = $request->txt_product_description;
        $data['unit'] = $request->cbo_product_unit;
        $data['qty'] = $qty;
        $data['unit_price'] = $unit_price;
        $data['total'] = $total;
        DB::table("pro_repair_invoice_details_$company_id")->where('reinvd_id', $reinvd_id)->update($data);
        return redirect()->route('repair_Invoice_details', [$m_repair_master->reinvm_id, $company_id])->with('success', 'Data Updated Successfully!');
    }

    //report
    public function rpt_repair_invoice_list()
    {
        return view('sales.rpt_repair_invoice_list');
    }
    public function rpt_repair_invoice_view($id, $company_id)
    {
        $m_repair_master = DB::table("pro_repair_invoice_master_$company_id")->where('reinvm_id', $id)->where('status', 2)->first();
        $m_repair_details = DB::table("pro_repair_invoice_details_$company_id")->where('reinvm_id', $id)->where('status', 2)->get();
        $m_customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $m_repair_master->customer_id)->where('valid', 1)->first();
        $m_product = DB::table("pro_finish_product_$company_id")->where('product_id', $m_repair_master->product_id)->where('valid', 1)->first();
        return view('sales.rpt_repair_invoice_view', compact('m_repair_master', "m_repair_details", 'm_customer', 'm_product'));
    }
    public function rpt_repair_invoice_print($id, $company_id)
    {
        $m_repair_master = DB::table("pro_repair_invoice_master_$company_id")->where('reinvm_id', $id)->where('status', 2)->first();
        $m_repair_details = DB::table("pro_repair_invoice_details_$company_id")->where('reinvm_id', $id)->where('status', 2)->get();
        $m_customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $m_repair_master->customer_id)->where('valid', 1)->first();
        $m_product = DB::table("pro_finish_product_$company_id")->where('product_id', $m_repair_master->product_id)->where('valid', 1)->first();
        return view('sales.rpt_repair_invoice_print', compact('m_repair_master', "m_repair_details", 'm_customer', 'm_product'));
    }


    //end repair invoice

    //remaining_serial_list
    public function rpt_remaining_serial_list()
    {
        return view('sales.rpt_remaining_serial_list');
    }
    public function remaing_serial_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_product_id' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_product_id.required' => 'Select Product.',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $product_id = $request->cbo_product_id;
        $pg_id = $request->cbo_transformer;
        $m_product = DB::table("pro_finish_product_$company_id")->where('valid', 1)->get();
        $remaining_product_serial = DB::table("pro_finish_product_serial_$company_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_finish_product_serial_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select("pro_finish_product_serial_$company_id.*", "pro_finish_product_$company_id.product_name")
            ->where("pro_finish_product_serial_$company_id.product_id", $request->cbo_product_id)
            ->where("pro_finish_product_serial_$company_id.status", 1)
            ->where("pro_finish_product_serial_$company_id.valid", 1)
            ->orderBy("pro_finish_product_serial_$company_id.serial_no", 'DESC')
            ->get();

        return view('sales.remaing_serial_list', compact('remaining_product_serial', 'm_product', 'company_id', 'product_id', 'pg_id'));
    }

    //Debit voucher
    public function debit_voucher()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->leftJoin('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        return view('sales.debit_voucher', compact('user_company'));
    }
    public function debit_voucher_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'txt_name' => 'required',
            'txt_amount' => 'required',
            'txt_date' => 'required',
            'cbo_mr_number' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_name.required' => 'Name is required.',
            'txt_amount.required' => 'Amount is required.',
            'txt_date.required' => 'Date is required.',
            'cbo_mr_number.required' => 'Select Money Receipt.',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $m_company = DB::table('pro_company')
            ->where('company_id', $company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";
        $debit_voucher = DB::table("pro_debit_voucher_$company_id")->orderByDesc("debit_voucher_id")->first();
        if (isset($debit_voucher)) {
            $debit_voucher_id = "$company_short_name" . "DV" . date("Ym") . str_pad((substr($debit_voucher->debit_voucher_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $debit_voucher_id = "$company_short_name" . "DV" . date("Ym") . "00001";
        }
        //MR
        $m_money_receipt = DB::table("pro_money_receipt_$company_id")
            ->where('mr_id', $request->cbo_mr_number)
            ->where('valid', 1)
            ->first();

        $data = array();
        $data['debit_voucher_id'] = $debit_voucher_id;
        $data['debit_voucher_date'] = $request->txt_date;
        $data['mr_id'] = $m_money_receipt->mr_id;
        $data['mr_date'] = $m_money_receipt->collection_date;
        $data['customer_id'] = $m_money_receipt->customer_id;
        $data['company_id'] = $company_id;
        $data['accounts_name'] = $request->txt_ac_name;
        $data['name'] = $request->txt_name;
        $data['details'] = $request->txt_details;
        $data['amount'] = $request->txt_amount == null ? 0 : $request->txt_amount;
        $data['tr_amount'] = $request->txt_transport == null ? 0 : $request->txt_transport;
        $data['cr_amount'] = $request->txt_carry_allowance  == null ? 0 : $request->txt_carry_allowance;
        $data['cash_book_no'] = $request->txt_cash_book_no;
        $data['page_no'] = $request->txt_page_no;
        $data['folio_no'] = $request->txt_folio_no;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date('H:i:s');
        $data['valid'] = 1;
        // return $data;
        DB::table("pro_debit_voucher_$company_id")->insert($data);
        return redirect()->route('rpt_debit_voucher_view', [$debit_voucher_id, $company_id])->with('success', 'Add Successfully');
    }

    //report

    public function rpt_debit_voucher_list()
    {
        return view('sales.rpt_debit_voucher_list');
    }

    public function rpt_debit_voucher_view($id, $company_id)
    {
        $m_debit_voucher = DB::table("pro_debit_voucher_$company_id")
            ->where("pro_debit_voucher_$company_id.debit_voucher_id", $id)
            ->where("pro_debit_voucher_$company_id.valid", 1)
            ->first();

        return view('sales.rpt_debit_voucher_view', compact('m_debit_voucher'));
    }
    public function rpt_debit_voucher_print($id, $company_id)
    {
        $m_debit_voucher = DB::table("pro_debit_voucher_$company_id")
            ->where("pro_debit_voucher_$company_id.debit_voucher_id", $id)
            ->where("pro_debit_voucher_$company_id.valid", 1)
            ->first();

        return view('sales.rpt_debit_voucher_print', compact('m_debit_voucher'));
    }

    //ajax
    public function money_receipt_for_debit_voucher($company_id)
    {
        $m_debit_voucher_mr_id = DB::table("pro_debit_voucher_$company_id")
            ->where("pro_debit_voucher_$company_id.valid", 1)
            ->pluck('mr_id');
        $data = DB::table("pro_money_receipt_$company_id")
            ->whereNotIn('mr_id', $m_debit_voucher_mr_id)
            ->where('valid', 1)
            ->orderByDesc('mr_id')
            ->get();
        return response()->json($data);
    }
    public function debit_voucher_list($company_id)
    {
        $data = DB::table("pro_debit_voucher_$company_id")
            ->where('company_id', $company_id)
            ->where('valid', 1)
            ->orderByDesc('debit_voucher_id')
            ->get();
        return response()->json($data);
    }
    public function get_debit_voucher_list($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_debit_voucher_$company_id")
                ->leftJoin('pro_employee_info', "pro_debit_voucher_$company_id.user_id", 'pro_employee_info.employee_id')
                ->select("pro_debit_voucher_$company_id.*", 'pro_employee_info.employee_name')
                ->where("pro_debit_voucher_$company_id.company_id", $company_id)
                ->where("pro_debit_voucher_$company_id.valid", 1)
                ->orderByDesc("pro_debit_voucher_$company_id.debit_voucher_id")
                ->get();
        } else {
            $data = DB::table("pro_debit_voucher_$company_id")
                ->leftJoin('pro_employee_info', "pro_debit_voucher_$company_id.user_id", 'pro_employee_info.employee_id')
                ->select("pro_debit_voucher_$company_id.*", 'pro_employee_info.employee_name')
                ->where("pro_debit_voucher_$company_id.company_id", $company_id)
                ->where("pro_debit_voucher_$company_id.valid", 1)
                ->whereBetween("pro_debit_voucher_$company_id.debit_voucher_date", [$form, $to])
                ->orderByDesc("pro_debit_voucher_$company_id.debit_voucher_id")
                ->get();
        }
        return response()->json($data);
    }


    //debit voucher for tto
    public function debit_voucher_for_tto()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->leftJoin('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        return view('sales.debit_voucher_for_tto', compact('user_company'));
    }

    public function debit_voucher_for_tto_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'txt_date' => 'required',
            'cbo_sales_invoice' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_date.required' => 'Date is required.',
            'cbo_sales_invoice.required' => 'Select Sales Invoice.',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $m_sim_master =  DB::table("pro_sim_$company_id")
            ->where('sim_id', $request->cbo_sales_invoice)
            ->where('valid', 1)
            ->first();

        $data = array();
        $data['voucher_tto_date'] = $request->txt_date;
        $data['sim_id'] = $m_sim_master->sim_id;
        $data['sim_date'] = $m_sim_master->sim_date;
        $data['customer_id'] = $m_sim_master->customer_id;
        $data['company_id'] = $company_id;
        $data['test_fee'] = $request->txt_test_fee == null ? 0 : $request->txt_test_fee;
        $data['transport_fee'] = $request->txt_transport_fee == null ? 0 : $request->txt_transport_fee;
        $data['other_fee'] = $request->txt_other  == null ? 0 : $request->txt_other;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date('H:i:s');
        $data['valid'] = 1;
        $voucher_tto_id = DB::table("pro_debit_voucher_tto_$company_id")->insertGetId($data);
        return redirect()->route('rpt_debit_voucher_tto_view', [$voucher_tto_id, $company_id])->with('success', 'Add Successfully');
    }

    //report
    public function rpt_debit_voucher_tto_list()
    {
        return view('sales.rpt_debit_voucher_tto_list');
    }

    public function rpt_debit_voucher_tto_view($id, $company_id)
    {
        $m_debit_voucher_tto =  DB::table("pro_debit_voucher_tto_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_debit_voucher_tto_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_debit_voucher_tto_$company_id.*", "pro_customer_information_$company_id.customer_name")
            ->where("pro_debit_voucher_tto_$company_id.voucher_tto_id", $id)
            ->where("pro_debit_voucher_tto_$company_id.valid", 1)
            ->first();
        return view('sales.rpt_debit_voucher_tto_view', compact('m_debit_voucher_tto'));
    }
    public function rpt_debit_voucher_tto_print($id, $company_id)
    {
        $m_debit_voucher_tto =  DB::table("pro_debit_voucher_tto_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_debit_voucher_tto_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_debit_voucher_tto_$company_id.*", "pro_customer_information_$company_id.customer_name")
            ->where("pro_debit_voucher_tto_$company_id.voucher_tto_id", $id)
            ->where("pro_debit_voucher_tto_$company_id.valid", 1)
            ->first();
        return view('sales.rpt_debit_voucher_tto_print', compact('m_debit_voucher_tto'));
    }



    //Ajax
    public function sales_invoice_for_debit_voucher_tto($company_id)
    {
        $get_sales_invoice_id = DB::table("pro_debit_voucher_tto_$company_id")->where('valid', 1)->pluck('sim_id');
        $data = DB::table("pro_sim_$company_id")
            ->whereNotIn('sim_id', $get_sales_invoice_id)
            ->where('valid', 1)
            ->orderByDesc('sim_id')
            ->get();
        return response()->json($data);
    }
    public function customer_details_for_debit_voucher_tto($company_id, $id)
    {
        $m_sim = DB::table("pro_sim_$company_id")
            ->where('sim_id', $id)
            ->where('valid', 1)
            ->first();
        $customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $m_sim->customer_id)->first();
        $data = array();
        $data['customer_name'] = $customer->customer_name;
        $data['customer_address'] = $customer->customer_address;
        $data['customer_mobile'] = $customer->customer_mobile;
        return response()->json($data);
    }
    public function get_debit_voucher_tto_list($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_debit_voucher_tto_$company_id")
                ->leftJoin("pro_customer_information_$company_id", "pro_debit_voucher_tto_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_debit_voucher_tto_$company_id.*", "pro_customer_information_$company_id.customer_name")
                ->where("pro_debit_voucher_tto_$company_id.company_id", $company_id)
                ->where("pro_debit_voucher_tto_$company_id.valid", 1)
                ->orderByDesc("pro_debit_voucher_tto_$company_id.voucher_tto_id")
                ->get();
        } else {
            $data = DB::table("pro_debit_voucher_tto_$company_id")
                ->leftJoin("pro_customer_information_$company_id", "pro_debit_voucher_tto_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_debit_voucher_tto_$company_id.*", "pro_customer_information_$company_id.customer_name")
                ->where("pro_debit_voucher_tto_$company_id.company_id", $company_id)
                ->where("pro_debit_voucher_tto_$company_id.valid", 1)
                ->whereBetween("pro_debit_voucher_tto_$company_id.voucher_tto_date", [$form, $to])
                ->orderByDesc("pro_debit_voucher_tto_$company_id.voucher_tto_id")
                ->get();
        }
        return response()->json($data);
    }

    //End debit voucher TTO







    //All Ajax call

    // Ajax sales invoice
    public function GetInvoiceCustDetails($id, $company_id)
    {
        $customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $id)->first();
        $data = array();
        $data['address'] = $customer->customer_address;
        return response()->json($data);
    }

    public function GetInvoiceMusakno($company_id)
    {

        $year = date('Y');
        $month = date('m');

        if ($month >= 7 && $month  <= 12) {
            $next_year =  $year  + 1;
            $financial_year_name = "$year-$next_year";
        } else if ($month >= 1 && $month <= 6) {
            $last_year =  $year  - 1;
            $financial_year_name = "$last_year-$year";
        }

        $data = DB::table("pro_mushok_$company_id")
            ->where('valid', '1')
            ->orderByDesc('mushok_id')
            ->get();
        return response()->json($data);
    }

    public function GetRptSalesInvoiceList($company_id, $form, $to, $pg_id)
    {
        if ($form == 0) {
            if ($pg_id == 0) {
                $data =  DB::table("pro_sim_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_sim_$company_id.*", "pro_customer_information_$company_id.customer_name")
                    ->where("pro_sim_$company_id.status", ">", 1)
                    ->orderByDesc("pro_sim_$company_id.sim_id")
                    ->get();
            } else {
                $data =  DB::table("pro_sim_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_sim_$company_id.*",  "pro_customer_information_$company_id.customer_name")
                    ->where("pro_sim_$company_id.status", ">", 1)
                    ->where("pro_sim_$company_id.pg_id", $pg_id)
                    ->orderByDesc("pro_sim_$company_id.sim_id")
                    ->get();
            }
        } else {
            if ($pg_id == 0) {
                $data =  DB::table("pro_sim_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_sim_$company_id.*",  "pro_customer_information_$company_id.customer_name")
                    ->whereBetween("pro_sim_$company_id.sim_date", [$form, $to])
                    ->where("pro_sim_$company_id.status", ">", 1)
                    ->orderByDesc("pro_sim_$company_id.sim_id")
                    ->get();
            } else {
                $data =  DB::table("pro_sim_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->select("pro_sim_$company_id.*",  "pro_customer_information_$company_id.customer_name")
                    ->whereBetween("pro_sim_$company_id.sim_date", [$form, $to])
                    ->where("pro_sim_$company_id.status", ">", 1)
                    ->where("pro_sim_$company_id.pg_id", $pg_id)
                    ->orderByDesc("pro_sim_$company_id.sim_id")
                    ->get();
            }
        }
        return response()->json($data);
    }



    // Ajax Delivery challan 
    public function GetDeliveryProductDetails($product_id, $id, $company_id)
    {
        $d_challan = DB::table("pro_delivery_chalan_master_$company_id")->where('delivery_chalan_master_id', $id)->first();
        $p_sid = DB::table("pro_sid_$company_id")->where('sim_id', $d_challan->sim_id)->where('product_id', $product_id)->first();
        $data = array();
        $data['sale_qty'] = $p_sid->qty;
        $data['delivery_qty'] = $p_sid->deliver_qty == null ? '0' : $p_sid->deliver_qty;
        $data['balance_qty'] = $p_sid->qty - ($p_sid->deliver_qty == null ? '0' : $p_sid->deliver_qty);

        return response()->json($data);
    }

    public function GetUnDeliveryChallanList($company_id)
    {
        $data =  DB::table("pro_sim_$company_id")
            ->leftJoin('pro_company', "pro_sim_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_sim_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_company.company_name')
            ->where("pro_sim_$company_id.company_id", $company_id)
            ->where("pro_sim_$company_id.status", 2)
            ->orderByDesc("pro_sim_$company_id.sim_id")
            ->get();
        return response()->json($data);
    }

    public function GetDeliveryChallanNotFinalList($company_id)
    {
        $data =   DB::table("pro_delivery_chalan_master_$company_id")
            ->leftJoin('pro_company', "pro_delivery_chalan_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_company.company_name')
            ->where("pro_delivery_chalan_master_$company_id.status", 1)
            ->orderByDesc('delivery_chalan_master_id')
            ->get();
        return response()->json($data);
    }

    public function GetRptDeliverychallanList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data =  DB::table("pro_delivery_chalan_master_$company_id")
                ->leftJoin('pro_company', "pro_delivery_chalan_master_$company_id.company_id", 'pro_company.company_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_company.company_name')
                ->where("pro_delivery_chalan_master_$company_id.status", ">", 1)
                ->orderByDesc('delivery_chalan_master_id')
                ->get();
        } else {
            $data = DB::table("pro_delivery_chalan_master_$company_id")
                ->leftJoin('pro_company', "pro_delivery_chalan_master_$company_id.company_id", 'pro_company.company_id')
                ->leftJoin("pro_customer_information_$company_id", "pro_delivery_chalan_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                ->select("pro_delivery_chalan_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_company.company_name')
                ->whereBetween("pro_delivery_chalan_master_$company_id.dcm_date", [$form, $to])
                ->where("pro_delivery_chalan_master_$company_id.status", ">", 1)
                ->orderByDesc('delivery_chalan_master_id')
                ->get();
        }
        return response()->json($data);
    }



    //
    public function GetReqClintBalance($id, $company_id)
    {
        $customer = DB::table("pro_customer_information_$company_id")->where('customer_id', $id)->first();
        $m_money_receipt_totla = DB::table("pro_money_receipt_$company_id")->where('customer_id', $id)->sum('mr_amount');
        $m_sales_invoice_total = DB::table("pro_sim_$company_id")->where('customer_id', $id)->sum('sinv_total');
        $m_sales_discount_amount = DB::table("pro_sim_$company_id")->where('customer_id', $id)->sum('discount_amount');

        $balance =  $m_sales_invoice_total - ($m_money_receipt_totla + $m_sales_discount_amount);
        // $balance =  $m_money_receipt_totla;

        $data = array();
        $data['address'] = $customer->customer_address;
        $data['balance'] = $balance;
        return response()->json($data);
    }

    public function GetSalesReturnInvoiceList($company_id)
    {
        $previous_two_month =  date('Y-m-d', strtotime('- months'));
        $current_date = date('Y-m-d');
        $m_sales_invoice = DB::table("pro_sim_$company_id")
            ->where('status', '>', 2)
            ->where('reinvm_status', null)
            ->whereBetween('sim_date', [$previous_two_month, $current_date])
            ->orderByDesc('sim_id')
            ->get();
        return response()->json($m_sales_invoice);
    }

    public function GetSalesReturnInvoiceDetails($product_id, $rsim_id, $company_id)
    {
        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->where('rsim_id', $rsim_id)
            ->first();
        $m_sales_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $riv_master->sim_id)
            ->where('product_id', $product_id)
            // ->where('rsim_status', null)
            ->first();

        $total_qty = $m_sales_details->qty - ($m_sales_details->rsim_qty == null ? "0" : $m_sales_details->rsim_qty);

        $data = array();
        $data['qty'] = $total_qty;
        $data['rate'] = $m_sales_details->rate;
        $data['remarks'] = $m_sales_details->remarks;

        return response()->json($data);
    }
    public function GetSalesReturnInvoiceDetailsEdit($product_id, $rsim_id, $company_id)
    {
        $riv_master = DB::table("pro_return_invoice_master_$company_id")
            ->where('rsim_id', $rsim_id)
            ->first();
        $m_sales_details = DB::table("pro_sid_$company_id")
            ->where('sim_id', $riv_master->sim_id)
            ->where('product_id', $product_id)
            // ->where('rsim_status', null)
            ->first();

        $riv_details = DB::table("pro_return_invoice_details_$company_id")
            ->where('rsim_id', $rsim_id)
            ->where('product_id', $product_id)
            ->first();

        $return_qty = $riv_details->return_qty;

        $total_qty = $m_sales_details->qty - ($m_sales_details->rsim_qty == null ? "0" : $m_sales_details->rsim_qty) +  $return_qty;

        $data = array();
        $data['qty'] = $total_qty;
        $data['rate'] = $m_sales_details->rate;

        return response()->json($data);
    }

    public function GetRptSalesReturnInvoiceList($company_id, $form, $to, $pg_id)
    {
        if ($form == 0) {
            if ($pg_id == 0) {
                $data =  DB::table("pro_return_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_return_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->where("pro_return_invoice_master_$company_id.status", 2)
                    ->orderByDesc("pro_return_invoice_master_$company_id.rsim_id")
                    ->get();
            } else {
                $data =  DB::table("pro_return_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_return_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->where("pro_return_invoice_master_$company_id.status", 2)
                    ->where("pro_return_invoice_master_$company_id.pg_id", $pg_id)
                    ->orderByDesc("pro_return_invoice_master_$company_id.rsim_id")
                    ->get();
            }
        } else {
            if ($pg_id == 0) {
                $data = DB::table("pro_return_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_return_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->whereBetween("pro_return_invoice_master_$company_id.rsim_date", [$form, $to])
                    ->where("pro_return_invoice_master_$company_id.status", 2)
                    ->orderByDesc("pro_return_invoice_master_$company_id.rsim_id")
                    ->get();
            } else {
                $data = DB::table("pro_return_invoice_master_$company_id")
                    ->leftJoin("pro_customer_information_$company_id", "pro_return_invoice_master_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
                    ->leftJoin('pro_employee_info', "pro_return_invoice_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select("pro_return_invoice_master_$company_id.*", "pro_customer_information_$company_id.customer_name", 'pro_employee_info.employee_name')
                    ->whereBetween("pro_return_invoice_master_$company_id.rsim_date", [$form, $to])
                    ->where("pro_return_invoice_master_$company_id.status", 2)
                    ->where("pro_return_invoice_master_$company_id.pg_id", $pg_id)
                    ->orderByDesc("pro_return_invoice_master_$company_id.rsim_id")
                    ->get();
            }
        }
        return response()->json($data);
    }
    //end sales return invoice 



    //Report Daily Sales Report
    public function rpt_daily_sales_list()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        return view('sales.rpt_daily_sales_list', compact('user_company', 'customer_type'));
    }
    public function get_daliy_report_party_list($type_id, $company_id)
    {
        $data = DB::table("pro_customer_information_$company_id")
            ->select('customer_id', 'customer_name')
            ->where('customer_type', $type_id)
            ->where('valid', 1)
            ->get();
        return response()->json($data);
    }
    public function get_daliy_report_transformer_ctpt($id, $company_id)
    {
        $data = DB::table("pro_finish_product_$company_id")->where('pg_id', $id)->get();
        return response()->json($data);
    }
    public function rpt_daliy_sales_report(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_transformer' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            // 'cbo_customer_type_id' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_transformer.required' => 'Select Transformer / CTPT .',
            'txt_from_date.required' => 'From Date required.',
            'txt_to_date.required' => 'To Date is required.',
            // 'cbo_customer_type_id.required' => 'Customer Type is required.',

        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();

        //
        $form = $request->txt_from_date;
        $to = $request->txt_to_date;
        $company_id = $request->cbo_company_id;
        $m_transformer = $request->cbo_transformer;
        $m_customer_type_id = $request->cbo_customer_type_id == null ? "0" : $request->cbo_customer_type_id;
        $m_customer_id = $request->cbo_customer_id == null ? "0" : $request->cbo_customer_id;
        $m_product = $request->cbo_product == null ? "0" : $request->cbo_product;

        $data =  DB::table("pro_sid_$company_id")
            ->leftJoin("pro_sim_$company_id", "pro_sid_$company_id.sim_id", "pro_sim_$company_id.sim_id")
            ->leftJoin("pro_finish_product_$company_id", "pro_sid_$company_id.product_id", "pro_finish_product_$company_id.product_id")
            ->select(
                "pro_sid_$company_id.*",
                "pro_sim_$company_id.mushok_no",
                "pro_sim_$company_id.sales_type",
                "pro_finish_product_$company_id.product_name"
            )
            ->where("pro_sid_$company_id.pg_id", $request->cbo_transformer)
            ->where("pro_sid_$company_id.valid", '1')
            ->whereBetween("pro_sid_$company_id.sim_date", [$request->txt_from_date, $request->txt_to_date])
            ->orderBy("pro_sim_$company_id.mushok_no", 'asc')
            ->orderBy("pro_sid_$company_id.sim_date", 'asc');

        if ($request->cbo_customer_type_id && $request->cbo_customer_id == null && $request->cbo_product == null) {
            $customer_id_withtype = DB::table("pro_customer_information_$company_id")
                ->where('customer_type', $request->cbo_customer_type_id)
                ->pluck('customer_id');
            $sales_details = $data->whereIn("pro_sid_$company_id.customer_id", $customer_id_withtype)
                ->get();
        } elseif ($request->cbo_customer_id && $request->cbo_customer_type_id &&  $request->cbo_product == null) {
            $sales_details = $data->where("pro_sid_$company_id.customer_id", $request->cbo_customer_id)->get();
        } elseif ($request->cbo_product && $request->cbo_customer_id == null && $request->cbo_customer_type_id == null) {
            $sales_details = $data->where("pro_sid_$company_id.product_id", $request->cbo_product)->get();
        } elseif ($request->cbo_product && $request->cbo_customer_id  && $request->cbo_customer_type_id) {
            $sales_details = $data->where("pro_sid_$company_id.customer_id", $request->cbo_customer_id)
                ->where("pro_sid_$company_id.product_id", $request->cbo_product)->get();
        } elseif ($request->cbo_product && $request->cbo_customer_type_id && $request->cbo_customer_id == null) {
            $customer_id_withtype = DB::table("pro_customer_information_$company_id")
                ->where('customer_type', $request->cbo_customer_type_id)
                ->pluck('customer_id');
            $sales_details = $data->whereIn("pro_sid_$company_id.customer_id", $customer_id_withtype)
                ->where("pro_sid_$company_id.product_id", $request->cbo_product)
                ->get();
        } else {
            $sales_details = $data->get();
        }
        return view('sales.rpt_daliy_sales_report', compact('user_company', 'customer_type', 'sales_details', 'form', 'to', 'company_id', 'm_transformer', 'm_customer_type_id', 'm_customer_id', 'm_product'));
    }

    public function rpt_sales_ledger()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        return view('sales.rpt_sales_ledger', compact('user_company', 'customer_type'));
    }
    public function rpt_sales_ledger_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_customer_id' => 'required',
            'cbo_transformer' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_customer_id.required' => 'Select Name .',
            'cbo_transformer.required' => 'Select Transformer / CTPT .',
            'txt_from_date.required' => 'From Date required.',
            'txt_to_date.required' => 'To Date is required.',

        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        //
        $company_id = $request->cbo_company_id;
        $mm_from_date = $request->txt_from_date;
        $mm_to_date = $request->txt_to_date;
        $m_transformer = $request->cbo_transformer;
        $m_customer_type_id = $request->cbo_customer_type_id == null ? "0" : $request->cbo_customer_type_id;
        $m_customer_id = $request->cbo_customer_id == null ? "0" : $request->cbo_customer_id;

        //collection
        $balance_at_period = DB::table("pro_money_receipt_$company_id")
            ->where("pro_money_receipt_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_money_receipt_$company_id.pg_id", $request->cbo_transformer)
            ->where("pro_money_receipt_$company_id.collection_date", '<', $request->txt_from_date)
            // ->where("pro_money_receipt_$company_id.status", 1)
            ->sum('mr_amount');

        $opening_balance = DB::table("pro_cust_balance_$company_id")
            ->where("pro_cust_balance_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_cust_balance_$company_id.pg_id", $request->cbo_transformer)
            ->sum('amount');

        $m_mreceipt = DB::table("pro_money_receipt_$company_id")
            ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
            ->leftJoin('pro_bank', "pro_money_receipt_$company_id.bank_id", 'pro_bank.bank_id')
            ->select(
                "pro_money_receipt_$company_id.collection_date",
                "pro_money_receipt_$company_id.mr_id",
                "pro_money_receipt_$company_id.mr_amount",
                'pro_payment_type.payment_type',
                'pro_bank.bank_name'
            )
            ->whereBetween("pro_money_receipt_$company_id.collection_date", [$request->txt_from_date, $request->txt_to_date])
            ->where("pro_money_receipt_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_money_receipt_$company_id.pg_id", $request->cbo_transformer)
            ->where("pro_money_receipt_$company_id.valid", 1)
            ->orderByDesc("pro_money_receipt_$company_id.mr_id")
            ->get();

        //Discount / commission / carrying Allowance

        $m_debit_voucher_balance_at_period = DB::table("pro_debit_voucher_$company_id")
            ->where("pro_debit_voucher_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_debit_voucher_$company_id.debit_voucher_date", '<', $request->txt_from_date)
            ->orderByDesc("pro_debit_voucher_$company_id.customer_id")
            ->sum('amount');

        $m_debit_voucher = DB::table("pro_debit_voucher_$company_id")
            ->select(
                "pro_debit_voucher_$company_id.debit_voucher_date",
                "pro_debit_voucher_$company_id.debit_voucher_id",
                "pro_debit_voucher_$company_id.amount",
            )
            ->where("pro_debit_voucher_$company_id.customer_id", $request->cbo_customer_id)
            ->whereBetween("pro_debit_voucher_$company_id.debit_voucher_date", [$request->txt_from_date, $request->txt_to_date])
            ->orderByDesc("pro_debit_voucher_$company_id.customer_id")
            ->get();

        //sales
        $m_sales_invoice_balance_at_period =  DB::table("pro_sim_$company_id")
            ->where("pro_sim_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_sim_$company_id.pg_id", $request->cbo_transformer)
            ->where("pro_sim_$company_id.sim_date", '<', $request->txt_from_date)
            ->sum('total');
        $m_sales_invoice =  DB::table("pro_sim_$company_id")
            ->select(
                "pro_sim_$company_id.sim_id",
                "pro_sim_$company_id.sim_date",
                "pro_sim_$company_id.total",
            )
            ->where("pro_sim_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_sim_$company_id.pg_id", $request->cbo_transformer)
            ->whereBetween("pro_sim_$company_id.sim_date", [$request->txt_from_date, $request->txt_to_date])
            ->orderByDesc("pro_sim_$company_id.sim_id")
            ->get();



        //sales return
        $m_sales_return_balance_at_period =  DB::table("pro_return_invoice_details_$company_id")
            ->where("pro_return_invoice_details_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_return_invoice_details_$company_id.pg_id", $request->cbo_transformer)
            ->where("pro_return_invoice_details_$company_id.rsim_date", '<', $request->txt_from_date)
            ->where("pro_return_invoice_details_$company_id.valid", 1)
            ->sum('net_payble');

        $m_sales_return =  DB::table("pro_return_invoice_master_$company_id")
            ->select(
                "pro_return_invoice_master_$company_id.rsim_date",
                "pro_return_invoice_master_$company_id.rsim_id",
            )
            ->where("pro_return_invoice_master_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_return_invoice_master_$company_id.pg_id", $request->cbo_transformer)
            ->whereBetween("pro_return_invoice_master_$company_id.rsim_date", [$request->txt_from_date, $request->txt_to_date])
            ->where("pro_return_invoice_master_$company_id.valid", 1)
            ->orderByDesc("pro_return_invoice_master_$company_id.rsim_id")
            ->get();

        //repair invoice
        $m_sales_repaire_balance_at_period =  DB::table("pro_repair_invoice_details_$company_id")
            ->where("pro_repair_invoice_details_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_repair_invoice_details_$company_id.pg_id", $request->cbo_transformer)
            ->where("pro_repair_invoice_details_$company_id.reinvm_date", '<', $request->txt_from_date)
            ->sum('total');

        $m_sales_repair =  DB::table("pro_repair_invoice_details_$company_id")
            ->select(
                "pro_repair_invoice_details_$company_id.reinvm_date",
                "pro_repair_invoice_details_$company_id.reinvm_id",
                "pro_repair_invoice_details_$company_id.total",
            )
            ->where("pro_repair_invoice_details_$company_id.customer_id", $request->cbo_customer_id)
            ->where("pro_repair_invoice_details_$company_id.pg_id", $request->cbo_transformer)
            ->whereBetween("pro_repair_invoice_details_$company_id.reinvm_date", [$request->txt_from_date, $request->txt_to_date])
            ->orderByDesc("pro_repair_invoice_details_$company_id.reinvm_id")
            ->get();


        return view('sales.rpt_sales_ledger_list', compact(
            'user_company',
            'customer_type',
            'mm_from_date',
            'mm_to_date',
            'company_id',
            'm_transformer',
            'm_customer_type_id',
            'm_customer_id',
            'balance_at_period',
            'opening_balance',
            'm_mreceipt',
            'm_debit_voucher_balance_at_period',
            'm_debit_voucher',
            'm_sales_invoice_balance_at_period',
            'm_sales_invoice',
            'm_sales_return_balance_at_period',
            'm_sales_return',
            'm_sales_repaire_balance_at_period',
            'm_sales_repair'
        ));
    }
    //End sales ledger

    //start Total collection F
    public function rpt_total_collection()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $m_payment_type = DB::table('pro_payment_type')->get();
        return view('sales.rpt_total_collection', compact('user_company', 'm_payment_type'));
    }

    public function rpt_total_collection_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            // 'cbo_transformer' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            // 'cbo_transformer.required' => 'Select Transformer / CTPT .',
            'txt_from_date.required' => 'From Date required.',
            'txt_to_date.required' => 'To Date is required.',

        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $m_payment_type = DB::table('pro_payment_type')->get();

        //
        $form = $request->txt_from_date;
        $to = $request->txt_to_date;
        $company_id = $request->cbo_company_id;
        $m_transformer = $request->cbo_transformer;
        $m_payment_type_id = $request->cbo_payment_type == null ? "0" : $request->cbo_payment_type;


        $data = DB::table("pro_money_receipt_$company_id")
            ->leftJoin('pro_payment_type', "pro_money_receipt_$company_id.payment_type", 'pro_payment_type.payment_type_id')
            ->leftJoin("pro_customer_information_$company_id", "pro_money_receipt_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_bank', "pro_money_receipt_$company_id.bank_id", 'pro_bank.bank_id')
            ->leftJoin("pro_debit_voucher_$company_id", "pro_money_receipt_$company_id.mr_id", "pro_debit_voucher_$company_id.mr_id")
            ->leftJoin("pro_sim_$company_id", "pro_money_receipt_$company_id.sim_id", "pro_sim_$company_id.sim_id")
            ->select(
                "pro_money_receipt_$company_id.mr_id",
                "pro_money_receipt_$company_id.collection_date",
                "pro_money_receipt_$company_id.payment_type",
                "pro_money_receipt_$company_id.receive_type",
                "pro_money_receipt_$company_id.chq_po_dd_no",
                "pro_money_receipt_$company_id.mr_amount",
                "pro_money_receipt_$company_id.transport_fee",
                "pro_money_receipt_$company_id.test_fee",
                "pro_money_receipt_$company_id.other_fee",
                "pro_money_receipt_$company_id.sim_id",
                "pro_money_receipt_$company_id.sim_date",
                "pro_money_receipt_$company_id.company_id",
                "pro_customer_information_$company_id.customer_name",
                'pro_payment_type.payment_type as payment_type_name',
                'pro_bank.bank_name',
                "pro_debit_voucher_$company_id.amount",
                "pro_debit_voucher_$company_id.cr_amount",
                "pro_sim_$company_id.mushok_no"
            )
            ->whereBetween("pro_money_receipt_$company_id.collection_date", [$form, $to])
            ->groupby("pro_money_receipt_$company_id.mr_id")
            ->orderBy("pro_money_receipt_$company_id.collection_date",'ASC');

        if ($request->cbo_transformer && $request->cbo_payment_type == null) {
            $total_collection = $data->where("pro_money_receipt_$company_id.pg_id", $request->cbo_transformer)
                ->get();
        } elseif ($request->cbo_transformer == null && $request->cbo_payment_type) {
            $total_collection = $data->where("pro_money_receipt_$company_id.payment_type", $request->cbo_payment_type)
                ->get();
        } elseif ($request->cbo_transformer && $request->cbo_payment_type) {
            $total_collection = $data->where("pro_money_receipt_$company_id.pg_id", $request->cbo_transformer)
                ->where("pro_money_receipt_$company_id.payment_type", $request->cbo_payment_type)
                ->get();
        } else {
            $total_collection = $data->get();
        }


        return view('sales.rpt_total_collection_list', compact('user_company', 'm_payment_type', 'total_collection', 'form', 'to', 'company_id', 'm_transformer', 'm_payment_type_id'));
    }

    //Finish Product
    public function finish_product()
    {
        // $pro_cat = DB::table('pro_product_cat')->Where('valid', '1')->orderBy('product_cat_id', 'desc')->get(); //query builder
        $m_unit = DB::table('pro_units')
            ->Where('valid', '1')
            ->orderBy('unit_name', 'desc')
            ->get(); //query builder

        $m_yesno = DB::table('pro_yesno')
            ->Where('valid', '1')
            ->orderBy('yesno_name', 'desc')
            ->get(); //query builder

        return view('sales.finish_product', compact('m_unit', 'm_yesno'));
    }

    public function FinishProductStore(Request $request)
    {
        $rules = [
            'cbo_pg_id' => 'required|integer|between:1,99000',
            'cbo_pg_sub_id' => 'required|integer|between:1,10000',
            'txt_product_name' => 'required',
            'cbo_unit_id' => 'required|integer|between:1,10000',
            'cbo_company_id' => 'required',
        ];
        $customMessages = [
            'cbo_pg_id.required' => 'Select Product Group.',
            'cbo_pg_id.integer' => 'Select Product Group.',
            'cbo_pg_id.between' => 'Select Product Group.',

            'cbo_pg_sub_id.required' => 'Select Product Sub Group.',
            'cbo_pg_sub_id.integer' => 'Select Product Sub Group.',
            'cbo_pg_sub_id.between' => 'Select Product Sub Group.',

            'txt_product_name.required' => 'Product Name is required.',
            'cbo_company_id.required' => 'Company is required.',

            'cbo_unit_id.required' => 'Select Unit.',
            'cbo_unit_id.integer' => 'Select Unit.',
            'cbo_unit_id.between' => 'Select Unit.',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $company_id = $request->cbo_company_id;
        $m_product_name = strtoupper($request->txt_product_name);
        $m_product_type = strtoupper($request->txt_product_type);
        $m_brand_name = strtoupper($request->txt_brand_name);
        $m_finish_product = DB::table("pro_finish_product_$company_id")
            ->where('pg_id', $request->cbo_pg_id)
            ->where('pg_sub_id', $request->cbo_pg_sub_id)
            ->where('product_name', $m_product_name)
            ->first();
        //dd($abcd);

        if ($m_finish_product === null) {
            $m_valid = '1';
            $mentrydate = time();
            $m_entry_date = date("Y-m-d", $mentrydate);
            $m_entry_time = date("H:i:s", $mentrydate);

            $data = array();
            $data['company_id'] = $request->company_id;
            $data['pg_id'] = $request->cbo_pg_id;
            $data['pg_sub_id'] = $request->cbo_pg_sub_id;
            $data['product_category'] = $request->cbo_product_cat_id;
            $data['product_name'] = $m_product_name;
            $data['product_type'] = $m_product_type;
            $data['brand_name'] = $m_brand_name;
            $data['model_size'] = $request->txt_model_size;
            $data['product_description'] = $request->txt_product_description;
            $data['unit'] = $request->cbo_unit_id;
            $data['reorder_qty'] = $request->txt_reorder_qty;
            $data['get_discount'] = $request->cbo_discount;
            $data['warrenty'] = $request->cbo_warrenty;
            $data['user_id'] = $m_user_id;
            $data['valid'] = $m_valid;
            $data['entry_date'] = $m_entry_date;
            $data['entry_time'] = $m_entry_time;
            // dd($data);
            DB::table("pro_finish_product_$company_id")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($m_finish_product === null) {
    }

    public function finish_product_edit($id, $company_id)
    {
        $m_product = DB::table("pro_finish_product_$company_id")->where('product_id', $id)->first();
        // $pro_cat = DB::table('pro_product_cat')->Where('valid', '1')->orderBy('product_cat_id', 'desc')->get();
        $m_unit = DB::table('pro_units')
            ->Where('valid', '1')
            ->orderBy('unit_name', 'desc')
            ->get();

        $m_yesno = DB::table('pro_yesno')
            ->Where('valid', '1')
            ->orderBy('yesno_name', 'desc')
            ->get();

        $m_product_group = DB::table("pro_product_group_$company_id")
            ->Where('product_category', '2')
            ->Where('valid', '1')
            ->orderBy('pg_name', 'desc')
            ->get();

        $m_product_sub_group = DB::table("pro_product_sub_group_$company_id")
            ->Where('pg_sub_id', $m_product->pg_sub_id)
            ->Where('valid', '1')
            ->first();

        return view('sales.finish_product', compact('m_product', 'm_unit', 'm_yesno', 'm_product_group', 'm_product_sub_group'));
    }

    public function finish_product_update(Request $request, $id)
    {

        $rules = [
            'cbo_pg_id' => 'required|integer|between:1,99000',
            'cbo_pg_sub_id' => 'required|integer|between:1,10000',
            'txt_product_name' => 'required',
            'cbo_unit_id' => 'required|integer|between:1,10000',
            'cbo_company_id' => 'required',
        ];
        $customMessages = [
            'cbo_pg_id.required' => 'Select Product Group.',
            'cbo_pg_id.integer' => 'Select Product Group.',
            'cbo_pg_id.between' => 'Select Product Group.',

            'cbo_pg_sub_id.required' => 'Select Product Sub Group.',
            'cbo_pg_sub_id.integer' => 'Select Product Sub Group.',
            'cbo_pg_sub_id.between' => 'Select Product Sub Group.',

            'txt_product_name.required' => 'Product Name is required.',
            'cbo_company_id.required' => 'Company is required.',

            'cbo_unit_id.required' => 'Select Unit.',
            'cbo_unit_id.integer' => 'Select Unit.',
            'cbo_unit_id.between' => 'Select Unit.',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $company_id = $request->cbo_company_id;
        $m_product_name = strtoupper($request->txt_product_name);
        $m_product_type = strtoupper($request->txt_product_type);
        $m_brand_name = strtoupper($request->txt_brand_name);

        $m_finish_product = DB::table("pro_finish_product_$company_id")
            ->whereNotIn('product_id', ["$id"])
            ->where('pg_id', $request->cbo_pg_id)
            ->where('pg_sub_id', $request->cbo_pg_sub_id)
            ->where('product_name', $m_product_name)
            ->first();

        if ($m_finish_product === null) {
            $mentrydate = time();
            $m_entry_date = date("Y-m-d", $mentrydate);
            $m_entry_time = date("H:i:s", $mentrydate);

            $data = array();
            $data['pg_id'] = $request->cbo_pg_id;
            $data['pg_sub_id'] = $request->cbo_pg_sub_id;
            $data['product_category'] = $request->cbo_product_cat_id;
            $data['product_name'] = $m_product_name;
            $data['product_type'] = $m_product_type;
            $data['brand_name'] = $m_brand_name;
            $data['model_size'] = $request->txt_model_size;
            $data['product_description'] = $request->txt_product_description;
            $data['unit'] = $request->cbo_unit_id;
            $data['reorder_qty'] = $request->txt_reorder_qty;
            $data['get_discount'] = $request->cbo_discount;
            $data['warrenty'] = $request->cbo_warrenty;
            $data['last_user_id'] = $m_user_id;
            $data['last_edit_date'] = $m_entry_date;
            $data['last_edit_time'] = $m_entry_time;
            DB::table("pro_finish_product_$company_id")->where('product_id', $id)->update($data);
            return redirect()->route('finish_product')->with('success', 'Data Update Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($m_finish_product === null) {
    }

    public function GetSalesFinishProductGroupList($company_id)
    {
        $data = DB::table("pro_product_group_$company_id")
            ->Where('product_category', '2')
            ->Where('valid', '1')
            ->orderBy('pg_name', 'desc')
            ->get();
        return json_encode($data);
    }

    public function GetSalesFinishProductSubGroupList($pg_id, $company_id)
    {
        $data = DB::table("pro_product_sub_group_$company_id")
            ->Where('pg_id', $pg_id)
            ->Where('valid', '1')
            ->orderBy('pg_sub_name', 'desc')
            ->get();
        return json_encode($data);
    }

    public function GetAllFinishProductList($company_id)
    {
        $data = DB::table("pro_finish_product_$company_id")
            ->join("pro_product_cat", "pro_finish_product_$company_id.product_category", "pro_product_cat.product_cat_id")
            ->leftjoin("pro_product_group_$company_id", "pro_finish_product_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_finish_product_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_units", "pro_finish_product_$company_id.unit", "pro_units.unit_id")
            ->select(
                "pro_finish_product_$company_id.*",
                "pro_product_cat.product_category_name",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_units.unit_name"
            )
            ->Where("pro_finish_product_$company_id.product_category", '2')
            ->Where("pro_finish_product_$company_id.valid", '1')
            ->orderBy("pro_finish_product_$company_id.product_id", 'desc')
            ->get();
        return json_encode($data);
    }



    //Report Account Ledger
    public function rpt_acc_ledger()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.company_id', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        return view('sales.rpt_acc_ledger', compact('user_company', 'customer_type'));
    }
    public function rpt_acc_ledger_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_transformer' => 'required',
            'cbo_customer_type_id' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_transformer.required' => 'Select Transformer/CTPT.',
            'cbo_customer_type_id.required' => 'Select Search.',

        ];
        $this->validate($request, $rules, $customMessages);
        //
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.company_id', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->get();
        $company_id = $request->cbo_company_id;
        $m_transformer = $request->cbo_transformer;
        $m_customer_type_id = $request->cbo_customer_type_id;
        $form = $request->txt_from_date;
        $to = $request->txt_to_date;
        //
        $m_customer = DB::table("pro_customer_information_$company_id")
            ->where('customer_type', $request->cbo_customer_type_id)
            ->where('valid', 1)
            ->orderBy('customer_name', 'asc')
            ->get();

        return view('sales.rpt_acc_ledger_list', compact('user_company', 'customer_type', 'company_id', 'm_transformer', 'm_customer_type_id', 'form', 'to', 'm_customer'));
    }

    //Finish Product closing stock
    public function finish_product_closing_stock()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.company_id', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        return view('sales.finish_product_closing_stock', compact('user_company'));
    }

    public function finish_product_closing_stock_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_transformer' => 'required',
            'txt_month' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_transformer.required' => 'Select Transformer/CTPT.',
            'txt_month.required' => 'Month is required.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $m_user_id = Auth::user()->emp_id;
        $m_transformer = $request->cbo_transformer;

        //request month
        $txt_month = $request->txt_month;
        $m_year = substr($txt_month, 0, 4);
        $m_month = substr($txt_month, 5, 2);

        //previous month and year
        if ($m_month == '01') {
            $closing_year = $m_year - 1;
            $closing_month = '12';
        } elseif ($m_month > '01') {
            $closing_year = $m_year;
            $closing_month = str_pad(($m_month - 1), 2, '0', STR_PAD_LEFT);
        }

        //first date and last date
        $txt_start_date = "$m_year-$m_month-01";
        $last_day_this_month = date('t', strtotime($txt_start_date));
        $txt_end_date = "$m_year-$m_month-$last_day_this_month";

        //check
        if ($m_year < '2023') {
            return redirect()->back()->withInput()->with('warning', "$txt_month sorry !!");
        }

        //table name this month
        if ($request->txt_month) {
            $stock_close_request_table = "pro_fpcs_" . "$m_year$m_month" . "_$company_id";
            $stock_close_previous_month_table = "pro_fpcs_" . "$closing_year$closing_month" . "_$company_id";
        }

        if (Schema::hasTable("$stock_close_request_table")) {
        } else {
            //create table
            Schema::create("$stock_close_request_table", function (Blueprint $table1) {
                $table1->increments('fpcs_id');
                $table1->integer('company_id')->length(11);
                $table1->integer('product_category')->length(2);
                $table1->integer('pg_id')->length(11);
                $table1->integer('pg_sub_id')->length(11);
                $table1->integer('product_id')->length(11);
                $table1->double('qty', 15, 4);
                $table1->integer('unit')->length(2);
                $table1->string('user_id', 8);
                $table1->date('entry_date');
                $table1->time('entry_time');
                $table1->integer('valid')->length(1);
                $table1->string('year', 4);
                $table1->string('month', 2);
            });
        }

        $data_alredy_check = DB::table("$stock_close_request_table")->where('company_id', $company_id)->where('pg_id', $m_transformer)->where('valid', 1)->count();
        if ($data_alredy_check > 0) {
            return back()->with('warning', "$txt_month Data Alredy Insert !!");
        } else {
            $product = DB::table("pro_finish_product_$company_id")
                ->select('product_id', 'unit', 'product_category', 'pg_id', 'pg_sub_id')
                ->where('valid', 1)
                ->where('pg_id', $m_transformer)
                ->get();

            foreach ($product as $row) {
                $opening_balance = DB::table("$stock_close_previous_month_table")
                    ->where('company_id', $company_id)
                    ->where('product_id', $row->product_id)
                    ->where('valid', 1)
                    ->sum('qty');
                //sales
                $sales = DB::table("pro_sid_$company_id")
                    ->where('company_id', $company_id)
                    ->where('product_id', $row->product_id)
                    ->whereBetween('sim_date', [$txt_start_date, $txt_end_date])
                    ->sum('qty');

                //production
                $production = DB::table("pro_fpsd_$company_id")
                    ->where('company_id', $company_id)
                    ->where('product_id', $row->product_id)
                    ->whereBetween('fpsm_date',  [$txt_start_date, $txt_end_date])
                    ->sum('qty');

                //return
                $return = DB::table("pro_return_invoice_details_$company_id")
                    ->where('company_id', $company_id)
                    ->where('product_id', $row->product_id)
                    ->whereBetween('rsim_date',  [$txt_start_date, $txt_end_date])
                    ->where('valid', 1)
                    ->sum('return_qty');
                //stock
                $total_stock = ($opening_balance + $production + $return) - $sales;
                $data = array();
                $data['company_id'] = $company_id;
                $data['product_category'] = $row->product_category;
                $data['pg_id'] = $row->pg_id;
                $data['pg_sub_id'] = $row->pg_sub_id;
                $data['product_id'] = $row->product_id;
                $data['unit'] = $row->unit;
                $data['qty'] =  $total_stock;
                $data['user_id'] = $m_user_id;
                $data['entry_date'] = date('Y-m-d');
                $data['entry_time'] = date('H:i:s');
                $data['valid'] = 1;
                $data['year'] = $m_year;
                $data['month'] = $m_month;
                DB::table("$stock_close_request_table")->insert($data);
            }
        } //  if ($data_alredy_check>0) {
        return back()->with('success', "$txt_month Add Successfull !!");
    }



    //report fpcs
    public function rpt_finish_product_stock_details()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.company_id', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        return view('sales.rpt_finish_product_stock_details', compact('user_company'));
    }

    public function rpt_finish_product_stock_details_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_transformer' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_transformer.required' => 'Select Transformer/CTPT.',
            'txt_from_date.required' => 'Form Date required.',
            'txt_to_date.required' => 'To Date required.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $m_user_id = Auth::user()->emp_id;
        $m_transformer = $request->cbo_transformer;
        $form = $request->txt_from_date;
        $to = $request->txt_to_date;

        if ($form < "2024-06-31") {
            return back()->with('success', "Select date getter than 2024-06-31.");
        } else {

            $user_company = DB::table('pro_user_company')
                ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
                ->select('pro_user_company.company_id', 'pro_company.company_name')
                ->Where('employee_id', $m_user_id)
                ->Where('pro_company.sales_status', 1)
                ->get();

            $m_finish_product =  DB::table("pro_finish_product_$company_id")
                ->select("product_id", "product_name")
                ->where('pg_id', $m_transformer)
                ->where('valid', 1)
                ->get();

            $m_month = date('m', strtotime($form));
            $m_year = date('Y', strtotime($form));

            //previous month and year
            if ($m_month == '01') {
                $closing_year = $m_year - 1;
                $closing_month = '12';
            } elseif ($m_month > '01') {
                $closing_year = $m_year;
                $closing_month = str_pad(($m_month - 1), 2, '0', STR_PAD_LEFT);
            }

            //table 
            if ($m_month) {
                $fpsd_previous_month_table = 'pro_fpcs_' . "$closing_year$closing_month" . "_$company_id";
            }

            return view('sales.rpt_finish_product_stock_details_list', compact('user_company', 'company_id', 'm_transformer', 'form', 'to', 'm_finish_product', 'fpsd_previous_month_table'));
        }
    }

    public function rpt_finish_product_stock_more_details($company_id, $product_id, $form, $to)
    {
        $m_finish_product =  DB::table("pro_finish_product_$company_id")
            ->select("product_name", "product_id")
            ->where('product_id', $product_id)
            ->where('valid', 1)
            ->first();

        $data = array();
        $newDate = $form;
        while (strtotime($newDate) <= strtotime($to)) {
            array_push($data, $newDate);
            $newDate = date("Y-m-d", strtotime($newDate . " +1 day"));
        }
        return view('sales.rpt_finish_product_stock_more_details', compact('data', 'm_finish_product', 'company_id', 'form', 'to'));
    }
}
