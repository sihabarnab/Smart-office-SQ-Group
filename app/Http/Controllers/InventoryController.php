<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

date_default_timezone_set("Asia/Dhaka");

class InventoryController extends Controller
{

    //Product Group
    public function inventoryproductgroup()
    {
        return view('inventory.product_group');
    }
    public function GetAllProductGroupList($id2)
    {
        $data = DB::table("pro_product_group_$id2")->Where('valid', '1')->orderBy('pg_id', 'desc')->get(); //query builder
        return json_encode($data);
    }

    public function inventorypgstore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'txt_pg_name' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_pg_name.required' => 'Product Group Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $abcd = DB::table("pro_product_group_$company_id")
            ->where('pg_name', $request->txt_pg_name)
            ->first();
        // dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['company_id'] = $request->cbo_company_id;
            $data['pg_name'] = $request->txt_pg_name;
            $data['valid'] = $m_valid;
            $data['product_category'] = 1;
            // dd($data);
            DB::table("pro_product_group_$company_id")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function inventorypgedit($id, $id2)
    {
        $m_pg = DB::table("pro_product_group_$id2")->where('pg_id', $id)->first();
        return view('inventory.product_group', compact('m_pg'));
    }

    public function inventorypgupdate(Request $request, $update)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'txt_pg_name' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_pg_name.required' => 'Product Group Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $ci_pro_product_group = DB::table("pro_product_group_$company_id")->where('pg_id', $request->txt_pg_id)->where('pg_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_product_group === null) {

            DB::table("pro_product_group_$company_id")->where('pg_id', $update)->update([
                'company_id' => $request->cbo_company_id,
                'pg_name' => $request->txt_pg_name,
            ]);

            return redirect(route('product_group'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!');
        }
    }

    //Product Sub Group
    public function inventoryproductsubgroup()
    {
        return view('inventory.product_sub_group');
    }
    public function GetAllProductSubGroupList($id2)
    {
        $data = DB::table("pro_product_sub_group_$id2")
            ->leftJoin("pro_product_group_$id2", "pro_product_sub_group_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->select("pro_product_sub_group_$id2.*", "pro_product_group_$id2.pg_name")
            ->Where("pro_product_sub_group_$id2.valid", '1')
            ->orderBy("pro_product_sub_group_$id2.pg_sub_id", 'desc')
            ->get();
        return json_encode($data);
    }

    public function GetProductGroupCompanyWise($id2)
    {
        $data = DB::table("pro_product_group_$id2")->Where('valid', '1')->orderBy('pg_id', 'desc')->get();
        return json_encode($data);
    }

    public function inventorypgsubstore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_product_group' => 'required',
            'txt_pg_sub_name' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_product_group.required' => 'Select Product Group.',
            'txt_pg_sub_name.required' => 'Product Sub Group Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $abcd = DB::table("pro_product_sub_group_$company_id")->where('pg_sub_name', strtoupper($request->txt_pg_sub_name))->first();
        //dd($abcd);
        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['company_id'] = $request->cbo_company_id;
            $data['pg_id'] = $request->cbo_product_group;
            $data['pg_sub_name'] = strtoupper($request->txt_pg_sub_name);
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table("pro_product_sub_group_$company_id")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            // $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function inventorypgsubedit($id, $id2)
    {
        $m_pg_sub = DB::table("pro_product_sub_group_$id2")->where('pg_sub_id', $id)->first();
        return view('inventory.product_sub_group', compact('m_pg_sub'));
    }

    public function inventorypgsubupdate(Request $request, $update)
    {

        $rules = [
            'cbo_company_id' => 'required',
            'cbo_product_group' => 'required',
            'txt_pg_sub_name' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_product_group.required' => 'Select Product Group.',
            'txt_pg_sub_name.required' => 'Product Sub Group Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $ci_pro_product_sub_group = DB::table("pro_product_sub_group_$company_id")->where('pg_sub_id', $request->txt_pg_sub_id)->where('pg_sub_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_product_sub_group === null) {

            DB::table("pro_product_sub_group_$company_id")->where('pg_sub_id', $update)->update([
                'company_id' => $request->cbo_company_id,
                'pg_id' => $request->cbo_product_group,
                'pg_sub_name' => strtoupper($request->txt_pg_sub_name),
            ]);

            return redirect(route('product_sub_group'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product
    public function inventoryproduct()
    {
        $m_unit = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_name', 'desc')->get(); //query builder
        $m_yesno = DB::table('pro_yesno')->Where('valid', '1')->orderBy('yesno_name', 'desc')->get(); //query builder
        return view('inventory.product', compact('m_unit', 'm_yesno'));
    }

    public function inventoryproductstore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'cbo_product_cat_id' => 'required',
            'cbo_pg_id' => 'required',
            'cbo_pg_sub_id' => 'required',
            'txt_product_name' => 'required',
            'cbo_unit_id' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_product_cat_id.required' => 'Select Product Category.',
            'cbo_pg_id.required' => 'Select Product Group.',
            'cbo_pg_sub_id.required' => 'Select Product Sub Group.',
            'txt_product_name.required' => 'Product Name is required.',
            'cbo_unit_id.required' => 'Select Unit.',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $m_user_id = Auth::user()->emp_id;
        $m_product_name = strtoupper($request->txt_product_name);
        $abcd = DB::table("pro_product_$company_id")
            ->where('pg_id', $request->cbo_pg_id)
            ->where('pg_sub_id', $request->cbo_pg_sub_id)
            ->where('product_name', $m_product_name)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $mentrydate = time();
            $m_entry_date = date("Y-m-d", $mentrydate);
            $m_entry_time = date("H:i:s", $mentrydate);

            $data = array();
            $data['company_id'] = $company_id;
            $data['pg_id'] = $request->cbo_pg_id;
            $data['pg_sub_id'] = $request->cbo_pg_sub_id;
            $data['product_category'] = $request->cbo_product_cat_id;
            $data['product_name'] = $m_product_name;
            $data['brand_name'] = $request->txt_brand_name;
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
            DB::table("pro_product_$company_id")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            // $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }



    public function inventoryproductedit($id, $id2)
    {
        $m_product = DB::table("pro_product_$id2")->where('product_id', $id)->first();
        $m_product_group = DB::table("pro_product_group_$id2")->Where('valid', '1')->orderBy('pg_name', 'desc')->get(); //query builder
        $m_product_sub_group = DB::table("pro_product_sub_group_$id2")->Where('valid', '1')->orderBy('pg_sub_name', 'desc')->get(); //query builder
        $m_unit = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_name', 'desc')->get(); //query builder
        $m_yesno = DB::table('pro_yesno')->Where('valid', '1')->orderBy('yesno_name', 'desc')->get(); //query builder
        return view('inventory.product', compact('m_product','m_product_group', 'm_product_sub_group', 'm_unit', 'm_yesno'));
    }

    public function inventoryproductupdate(Request $request, $update)
    {

        $rules = [
            'cbo_company_id' => 'required',
            'cbo_product_cat_id' => 'required',
            'cbo_pg_id' => 'required',
            'cbo_pg_sub_id' => 'required',
            'txt_product_name' => 'required',
            'cbo_unit_id' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company',
            'cbo_product_cat_id.required' => 'Select Product Category.',
            'cbo_pg_id.required' => 'Select Product Group.',
            'cbo_pg_sub_id.required' => 'Select Product Sub Group.',
            'txt_product_name.required' => 'Product Name is required.',
            'cbo_unit_id.required' => 'Select Unit.',

        ];

        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $m_user_id = Auth::user()->emp_id;
        $ci_pro_product = DB::table("pro_product_$company_id")
            ->where('product_name', strtoupper($request->txt_product_name))
            ->whereNotIn('product_id', ["$update"])
            ->first();

        if ($ci_pro_product === null) {

            DB::table("pro_product_$company_id")->where('product_id', $update)->update([
                'company_id' => $company_id,
                'pg_id' => $request->cbo_pg_id,
                'pg_sub_id' => $request->cbo_pg_sub_id,
                'product_name' => strtoupper($request->txt_product_name),
                'unit' => $request->cbo_unit_id,
                'model_size' => $request->txt_model_size,
                'product_description' => $request->txt_product_des,
            ]);

            $ci_user_company = DB::table('pro_user_company')
                ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
                ->select('pro_user_company.*', 'pro_company.company_name')
                ->Where('pro_user_company.employee_id', $m_user_id)
                ->Where('pro_company.inventory_status', 1)
                ->get();

            foreach ($ci_user_company as $row_company) {

                $m_company_id = $row_company->company_id;


                DB::table("pro_indent_details_$m_company_id")->where('product_id', $update)->update(['pg_sub_id' => $request->cbo_pg_sub_id]);
                DB::table("pro_grr_details_$m_company_id")->where('product_id', $update)->update(['pg_sub_id' => $request->cbo_pg_sub_id]);
                DB::table("pro_gmaterial_requsition_details_$m_company_id")->where('product_id', $update)->update(['pg_sub_id' => $request->cbo_pg_sub_id]);
                DB::table("pro_graw_issue_details_$m_company_id")->where('product_id', $update)->update(['pg_sub_id' => $request->cbo_pg_sub_id]);
                DB::table("pro_gmaterial_return_details_$m_company_id")->where('product_id', $update)->update(['pg_sub_id' => $request->cbo_pg_sub_id]);
                // DB::table("pro_stock_closing_$m_company_id")->where('product_id', $update)->update(['pg_sub_id' => $request->cbo_pg_sub_id]);
            } //foreach($ci_user_company as $row_company)

            return redirect(route('product'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function GetProduct($id2)
    {
        $data = DB::table("pro_product_$id2")
            ->join("pro_product_cat", "pro_product_$id2.product_category", "pro_product_cat.product_cat_id")
            ->leftjoin("pro_product_group_$id2", "pro_product_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_product_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftjoin("pro_units", "pro_product_$id2.unit", "pro_units.unit_id")
            ->select(
                "pro_product_$id2.*",
                "pro_product_cat.product_category_name",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_id",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_units.unit_name"
            )
            ->Where("pro_product_$id2.product_category", '1')
            ->Where("pro_product_$id2.valid", '1')
            ->get();
        return json_encode($data);
    }

    //Product Unit
    public function productunit()
    {
        $data = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_id', 'desc')->get(); //query builder
        return view('inventory.product_unit', compact('data'));

        // return view('inventory.product_group');
    }

    public function unitstore(Request $request)
    {
        $rules = [
            'txt_unit_name' => 'required'
        ];
        $customMessages = [
            'txt_unit_name.required' => 'Unit Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_units')->where('unit_name', $request->txt_unit_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['unit_name'] = strtoupper($request->txt_unit_name);
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');

            // dd($data);
            DB::table('pro_units')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function prounitedit($id)
    {

        $m_unit = DB::table('pro_units')->where('unit_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_id', 'desc')->get();
        return view('inventory.product_unit', compact('data', 'm_unit'));
    }

    public function prounitupdate(Request $request, $update)
    {

        $rules = [
            'txt_unit_name' => 'required',
        ];
        $customMessages = [
            'txt_unit_name.required' => 'Unit Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_units = DB::table('pro_units')->where('unit_id', $request->txt_unit_id)->where('unit_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_units === null) {

            DB::table('pro_units')->where('unit_id', $update)->update([
                'unit_name' => strtoupper($request->txt_unit_name),
            ]);

            return redirect(route('product_unit'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product Size
    public function productsize()
    {
        $data = DB::table('pro_sizes')->Where('valid', '1')->orderBy('size_id', 'desc')->get(); //query builder
        return view('inventory.product_size', compact('data'));
    }

    public function sizestore(Request $request)
    {
        $rules = [
            'txt_size_name' => 'required'
        ];
        $customMessages = [
            'txt_size_name.required' => 'Size Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_sizes')->where('size_name', $request->txt_size_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['size_name'] = $request->txt_size_name;
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');

            // dd($data);
            DB::table('pro_sizes')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function prosizeedit($id)
    {

        $m_size = DB::table('pro_sizes')->where('size_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_sizes')->Where('valid', '1')->orderBy('size_id', 'desc')->get();
        return view('inventory.product_size', compact('data', 'm_size'));
    }

    public function prosizeupdate(Request $request, $update)
    {

        $rules = [
            'txt_size_name' => 'required',
        ];
        $customMessages = [
            'txt_size_name.required' => 'Size Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_sizes = DB::table('pro_sizes')->where('size_id', $request->txt_size_id)->where('size_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_sizes === null) {

            DB::table('pro_sizes')->where('size_id', $update)->update([
                'size_name' => $request->txt_size_name,
            ]);

            return redirect(route('product_size'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Product Origin
    public function productorigin()
    {
        $data = DB::table('pro_origins')->Where('valid', '1')->orderBy('origin_id', 'desc')->get(); //query builder
        return view('inventory.product_origin', compact('data'));
    }

    public function originstore(Request $request)
    {
        $rules = [
            'txt_origin_name' => 'required'
        ];
        $customMessages = [
            'txt_origin_name.required' => 'Origin Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_origins')->where('origin_name', $request->txt_origin_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $data = array();
            $data['origin_name'] = $request->txt_origin_name;
            $data['valid'] = $m_valid;
            $data['created_at'] = date('Y-m-d H:i:s');

            // dd($data);
            DB::table('pro_origins')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function prooriginedit($id)
    {

        $m_origin = DB::table('pro_origins')->where('origin_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_origins')->Where('valid', '1')->orderBy('origin_id', 'desc')->get();
        return view('inventory.product_origin', compact('data', 'm_origin'));
    }

    public function prooriginupdate(Request $request, $update)
    {

        $rules = [
            'txt_origin_name' => 'required',
        ];
        $customMessages = [
            'txt_origin_name.required' => 'Origin Name is required.'
        ];

        $this->validate($request, $rules, $customMessages);

        $ci_pro_origins = DB::table('pro_origins')->where('origin_id', $request->txt_origin_id)->where('origin_id', '<>', $update)->first();
        //dd($abcd);

        if ($ci_pro_origins === null) {

            DB::table('pro_origins')->where('origin_id', $update)->update([
                'origin_name' => $request->txt_origin_name,
            ]);

            return redirect(route('product_origin'))->with('success', 'Data Updated Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    //Supplier
    public function supplierinfo()
    {
        // $data = DB::table('pro_supplier_information')->Where('valid', '1')->orderBy('supplier_id', 'desc')->get(); //query builder
        return view('inventory.supplier_information');
    }

    public function GetSupplier($company_id)
    {
        $data = DB::table("pro_supplier_information_$company_id")
            ->Where('valid', '1')
            ->Where('cust_sppl', 'S')
            ->orderBy('supplier_id', 'desc')
            ->get();
        return json_encode($data);
    }

    public function supplierinfostore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'txt_supplier_name' => 'required',
            'cbo_supplier_type' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_supplier_name.required' => 'Supplier Name is required.',
            'cbo_supplier_type.required' => 'Supplier Type is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;
        $abcd = DB::table("pro_supplier_information_$company_id")
            ->where('supplier_name', $request->txt_supplier_name)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $data = array();
            $data['company_id'] = $company_id;
            $data['supplier_name'] = $request->txt_supplier_name;
            $data['supplier_contact'] = $request->txt_contact_person;
            $data['supplier_type'] = $request->cbo_supplier_type;
            $data['supplier_address'] = $request->txt_address;
            $data['supplier_zip'] = $request->txt_zip_code;
            $data['supplier_city'] = $request->txt_city;
            $data['supplier_country'] = $request->txt_country;
            $data['supplier_state'] = $request->txt_state;
            $data['supplier_phone'] = $request->txt_phone;
            $data['supplier_mobile'] = $request->txt_mobile;
            $data['supplier_fax'] = $request->txt_fax;
            $data['supplier_email'] = $request->txt_email;
            $data['supplier_url'] = $request->txt_url;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = '1';
            $data['cust_sppl'] = 'S';

            // dd($data);
            DB::table("pro_supplier_information_$company_id")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function supplierinfoedit($id,$company_id)
    {

        $m_supplier = DB::table("pro_supplier_information_$company_id")->where('supplier_id', $id)->first();
        return view('inventory.supplier_information', compact('m_supplier'));
    }


    public function supplierinfoupdate(Request $request, $update)
    {


        $rules = [
            'cbo_company_id' => 'required',
            'txt_supplier_name' => 'required',
            'cbo_supplier_type' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_supplier_name.required' => 'Supplier Name is required.',
            'cbo_supplier_type.required' => 'Supplier Type is required.',
        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $data = array();
        $data['company_id'] = $company_id;
        $data['supplier_name'] = $request->txt_supplier_name;
        $data['supplier_contact'] = $request->txt_contact_person;
        $data['supplier_type'] = $request->cbo_supplier_type;
        $data['supplier_address'] = $request->txt_address;
        $data['supplier_zip'] = $request->txt_zip_code;
        $data['supplier_city'] = $request->txt_city;
        $data['supplier_country'] = $request->txt_country;
        $data['supplier_state'] = $request->txt_state;
        $data['supplier_phone'] = $request->txt_phone;
        $data['supplier_mobile'] = $request->txt_mobile;
        $data['supplier_fax'] = $request->txt_fax;
        $data['supplier_email'] = $request->txt_email;
        $data['supplier_url'] = $request->txt_url;
        $data['last_user_id'] = Auth::user()->emp_id;
        $data['last_edit_date'] = date('Y-m-d');
        $data['last_edit_time'] = date('H:i:s');
        DB::table("pro_supplier_information_$company_id")->where('supplier_id', $update)->update($data);
        return redirect()->route('supplier_information')->with('success', 'Data Updated Successfully!');
    }

    //Indent List For RR
    public function InventoryIndentListRR()
    {
        return view('inventory.indent_list_for_rr');
    }

    public function company_wise_list_for_rr(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $pro_indent_master  = DB::table("pro_indent_master_$company_id")
            ->leftJoin('pro_project_name', "pro_indent_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_indent_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->leftJoin('pro_company', "pro_indent_master_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_indent_master_$company_id.*", 'pro_project_name.project_name', 'pro_indent_category.category_name', 'pro_company.company_name')
            ->where("pro_indent_master_$company_id.rr_status", 1)
            ->where("pro_indent_master_$company_id.status", 3)
            ->orderBy("pro_indent_master_$company_id.indent_no", 'DESC')
            ->get();

        $m_grr_master = DB::table("pro_grr_master_$company_id")
            ->leftJoin('pro_company', "pro_grr_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->leftJoin("pro_supplier_information_$company_id", "pro_grr_master_$company_id.supplier_id", "pro_supplier_information_$company_id.supplier_id")
            ->select("pro_grr_master_$company_id.*", 'pro_company.company_name', 'pro_project_name.project_name', 'pro_indent_category.category_name', "pro_supplier_information_$company_id.supplier_name", "pro_supplier_information_$company_id.supplier_address")
            ->where("pro_grr_master_$company_id.company_id", $company_id)
            ->where("pro_grr_master_$company_id.status", 1)
            ->orderBy("pro_grr_master_$company_id.grr_master_id", 'desc')
            ->get();

        return view('inventory.indent_list_for_rr', compact('pro_indent_master', 'm_grr_master'));
    }

    public function inventory_indent_receiving_report($id, $id2)
    {

        $pro_indent_stock = DB::table("pro_indent_details_$id2")
            ->LeftJoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->LeftJoin("pro_product_sub_group_$id2", "pro_indent_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->LeftJoin("pro_product_$id2", "pro_indent_details_$id2.product_id", "pro_product_$id2.product_id")
            ->LeftJoin('pro_section_information', "pro_indent_details_$id2.section_id", 'pro_section_information.section_id')
            ->select("pro_indent_details_$id2.*", "pro_product_group_$id2.pg_name", "pro_product_sub_group_$id2.pg_sub_name", "pro_product_$id2.product_name", "pro_product_$id2.unit", 'pro_section_information.section_name')
            ->where("pro_indent_details_$id2.indent_no", '=', $id)
            // ->where('pro_indent_details.status', '!=', '1')
            ->get();

        $pro_indent_master  = DB::table("pro_indent_master_$id2")
            ->leftjoin('pro_project_name', "pro_indent_master_$id2.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_indent_category', "pro_indent_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->leftjoin('pro_company', "pro_indent_master_$id2.company_id", 'pro_company.company_id')
            ->select("pro_indent_master_$id2.*", 'pro_project_name.project_name', 'pro_indent_category.category_name', 'pro_company.company_name')
            ->where("pro_indent_master_$id2.indent_no", '=', $id)
            ->first();
        $pro_supplier_information = DB::table("pro_supplier_information_$id2")
            ->where('cust_sppl', '=', 'S')
            ->orderBy('supplier_id', 'DESC')
            ->get();
        return view('inventory.receiving_report', compact('pro_indent_master', 'pro_supplier_information', 'pro_indent_stock'));
    }
    public function inventory_indent_receiving_report_store(Request $request, $id2)
    {
        $rules = [
            'cbo_supplier' => 'required',
            'txt_challan_no' => 'required',
            'txt_challan_date' => 'required',
        ];

        $customMessages = [
            'cbo_supplier.required' => 'supplier field is required!',
            'txt_challan_no.required' => 'challan no field is required!',
            'txt_challan_date.required' => 'challan Date field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['project_id'] = $request->txt_indent_project;
        $data['company_id'] = $id2;
        $data['indent_category'] = $request->txt_indent_category;
        $data['indent_no'] = $request->txt_indent_no;
        $data['indent_date'] = $request->txt_indent_date;
        $data['supplier_id'] = $request->cbo_supplier;
        $data['glc_no'] = $request->txt_lc_no;
        $data['glc_date'] = $request->txt_lc_date;
        $data['chalan_no'] = $request->txt_challan_no;
        $data['chalan_date'] = $request->txt_challan_date;
        $data['trnsport_company'] = $request->txt_trnsport_company;
        $data['transport_no'] = $request->txt_trnsport_no;
        $data['remarks'] = $request->txt_remarks;
        $data['valid'] = 1;
        $data['status'] = 1;
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        // $grr_no = 'RR' . substr(date("Y"), -2) . date("m") . mt_rand(1, 100000);
        $last_grr = DB::table("pro_grr_master_$id2")->orderByDesc("grr_no")->first();
        $grr_no = "RR" . date("ym") . str_pad((substr($last_grr->grr_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        $data['grr_no'] = $grr_no;
        $data['grr_date'] = date("Y-m-d");
        $grr_master_id = DB::table("pro_grr_master_$id2")->insertGetId($data);
        return redirect()->route('inventory_receiving_report_details', [$grr_master_id, $id2]);
    }
    public function inventory_receiving_report_details($id, $id2)
    {
        $grr_master_recived = DB::table("pro_grr_master_$id2")
            ->leftjoin('pro_project_name', "pro_grr_master_$id2.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_indent_category', "pro_grr_master_$id2.indent_category", 'pro_indent_category.category_id')
            ->leftjoin("pro_supplier_information_$id2", "pro_grr_master_$id2.supplier_id", "pro_supplier_information_$id2.supplier_id")
            ->leftjoin('pro_company', "pro_grr_master_$id2.company_id", 'pro_company.company_id')

            ->select(
                "pro_grr_master_$id2.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                "pro_supplier_information_$id2.supplier_name",
                "pro_supplier_information_$id2.supplier_address",
                'pro_company.company_name'
            )
            ->where("pro_grr_master_$id2.grr_master_id", $id)
            ->where("pro_grr_master_$id2.status", 1)
            ->first();

        $product_id = DB::table("pro_grr_details_$id2")
            ->where('indent_no', '=', $grr_master_recived->indent_no)
            ->where('grr_no', '=', $grr_master_recived->grr_no)
            ->where('status', '=', '1')
            ->pluck('product_id');

        $pro_product_group = DB::table("pro_indent_details_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_indent_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->select("pro_indent_details_$id2.*", "pro_product_group_$id2.pg_name")
            ->where("pro_indent_details_$id2.indent_no", '=', $grr_master_recived->indent_no)
            ->whereNotIn("pro_indent_details_$id2.product_id", $product_id)
            ->where("pro_indent_details_$id2.rr_status", '=', '1')
            ->pluck('pg_id', 'pg_name');

        $pro_grr_details = DB::table("pro_grr_details_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_grr_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_grr_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftjoin("pro_product_$id2", "pro_grr_details_$id2.product_id", "pro_product_$id2.product_id")
            ->select(
                "pro_grr_details_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_product_$id2.product_name"
            )
            ->where("pro_grr_details_$id2.indent_no", '=', $grr_master_recived->indent_no)
            ->where("pro_grr_details_$id2.grr_no", '=', $grr_master_recived->grr_no)
            // ->where('status', '=', '1')
            ->get();

        return view('inventory.receiving_report_details', compact('grr_master_recived', 'pro_product_group', 'pro_grr_details'));
    }

    public function inventory_indent_report_receiving(Request $request, $id2)
    {
        $rules = [
            'cbo_product_group' => 'required',
            'cbo_product' => 'required',
            'txt_indent_qty' => 'required',
            'txt_rr_qty' => 'required',
            'txt_indent_no' => 'required',
            'txt_grr_no' => 'required',
        ];

        $customMessages = [
            'cbo_product_group.required' => 'product group field is required!',
            'cbo_product.required' => 'product field is required!',
            'txt_indent_qty.required' => 'indent qty field is required!',
            'txt_rr_qty.required' => 'rr qty field is required!',
        ];
        $this->validate($request, $rules, $customMessages);



        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $id2;

        //
        $grr_master = DB::table("pro_grr_master_$id2")
            ->where('indent_no', '=',  $request->txt_indent_no)
            ->where('grr_no', '=', $request->txt_grr_no)
            ->first();

        $data['grr_no'] = $grr_master->grr_no;
        $data['grr_date'] = $grr_master->grr_date;
        $data['project_id'] = $grr_master->project_id;
        $data['indent_category'] = $grr_master->indent_category;
        $data['indent_no'] = $grr_master->indent_no;
        $data['indent_date'] = $grr_master->indent_date;
        $data['supplier_id'] = $grr_master->supplier_id;
        $data['glc_no'] = $grr_master->glc_no;
        $data['glc_date'] = $grr_master->glc_date;
        $data['chalan_no'] = $grr_master->chalan_no;
        $data['chalan_date'] = $grr_master->chalan_date;
        //
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        //
        $get_product = DB::table("pro_product_$id2")->where('product_id', $request->cbo_product)->first();
        $data['unit'] = $get_product->unit;

        $data['received_qty'] = $request->txt_rr_qty;
        $data['remarks'] = $request->txt_Remarks;
        $data['valid'] = 1;
        $data['status'] = 1;
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");


        $pro_indent_details = DB::table("pro_indent_details_$id2")
            ->where('indent_no', '=', $request->txt_indent_no)
            ->where('product_id', '=', $request->cbo_product)
            ->first();
        $data['indent_details_id'] = $pro_indent_details->indent_details_id;
        $data['indent_qty'] = $pro_indent_details->approved_qty;

        //
        $newrr_qty = $pro_indent_details->rr_qty + $request->txt_rr_qty;
        if ($newrr_qty == $pro_indent_details->approved_qty) {
            DB::table("pro_indent_details_$id2")
                ->where('indent_no', '=', $request->txt_indent_no)
                ->where('product_id', '=', $request->cbo_product)
                ->update(['rr_status' => 2, 'rr_qty' => $newrr_qty]);

            DB::table("pro_grr_details_$id2")
                ->where('grr_no', '=', $request->txt_grr_no)
                ->where('product_id', '=', $request->cbo_product)
                ->update(['status' => 2]);
        } elseif ($newrr_qty > $pro_indent_details->approved_qty) {
            return back()->with('warning', 'Approved QTY getter then RR QTY');
        } else {
            DB::table("pro_indent_details_$id2")
                ->where('indent_no', '=', $request->txt_indent_no)
                ->where('product_id', '=', $request->cbo_product)
                ->update(['rr_qty' => $newrr_qty]);
        }

        //
        DB::table("pro_grr_details_$id2")->insert($data);
        return back()->with('success', 'Receiving Successfull !');
    }

    public function inventory_receiving_report_final($id, $id2)
    {

        $grr_master =  DB::table("pro_grr_details_$id2")->where('grr_no', '=', $id)->first();

        $with_rr_status =  DB::table("pro_indent_details_$id2")
            ->where('indent_no', $grr_master->indent_no)
            ->where('rr_status', 2)
            ->count();

        $without_rr_status =  DB::table("pro_indent_details_$id2")
            ->where('indent_no', $grr_master->indent_no)
            ->count();

        if ($with_rr_status == $without_rr_status) {

            DB::table("pro_indent_master_$id2")->where('indent_no', $grr_master->indent_no)->update(['rr_status' => 2]);

            DB::table("pro_grr_details_$id2")->where('grr_no', '=', $id)->update(['status' => 2]);
            DB::table("pro_grr_master_$id2")->where('grr_no', '=', $id)->update(['status' => 2]);
            return redirect()->route('indent_list_for_rr');
        } else {
            DB::table("pro_grr_details_$id2")->where('grr_no', '=', $id)->update(['status' => 2]);
            DB::table("pro_grr_master_$id2")->where('grr_no', '=', $id)->update(['status' => 2]);
            return redirect()->route('indent_list_for_rr');
        }
    }

    public function inventory_receiving_report_edit($id, $id2)
    {
        $pro_grr_details_Edit = DB::table("pro_grr_details_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_grr_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_grr_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftjoin("pro_product_$id2", "pro_grr_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftjoin('pro_company', "pro_grr_details_$id2.company_id", 'pro_company.company_id')

            ->select(
                "pro_grr_details_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_product_$id2.product_name",
                'pro_company.company_name'
            )
            ->where("pro_grr_details_$id2.grr_details_id", '=', $id)
            ->first();
        return view('inventory.receiving_report_details', compact('pro_grr_details_Edit'));
    }
    public function inventory_receiving_report_update(Request $request, $id, $id2)
    {
        $check = DB::table("pro_grr_details_$id2")->where("grr_details_id", '=', $id)->first();

        if ($check->indent_qty >= $request->txt_rr_qty) {
            $rules = [
                'txt_rr_qty' => 'required',
            ];

            $customMessages = [
                'txt_rr_qty.required' => 'rr qty field is required!',
            ];
            $this->validate($request, $rules, $customMessages);
            //
            $pro_indent_details = DB::table("pro_indent_details_$id2")
                ->where('indent_no', '=', $request->txt_indent_no)
                ->where('product_id', '=', $request->cbo_product)
                ->first();

            $previous_qty = DB::table("pro_grr_details_$id2")->where('grr_details_id', '=', $id)->first();
            $newrr_qty = $pro_indent_details->rr_qty + $request->txt_rr_qty - $previous_qty->received_qty;
            if ($newrr_qty == $pro_indent_details->approved_qty) {
                DB::table("pro_indent_details_$id2")
                    ->where('indent_no', '=', $request->txt_indent_no)
                    ->where('product_id', '=', $request->cbo_product)
                    ->update(['rr_status' => 2, 'rr_qty' => $newrr_qty]);

                DB::table("pro_grr_details_$id2")
                    ->where('grr_no', '=', $request->txt_grr_no)
                    ->where('product_id', '=', $request->cbo_product)
                    ->update(['status' => 2]);
            } elseif ($newrr_qty > $pro_indent_details->approved_qty) {
                return back()->with('warning', 'Approved QTY getter then RR QTY');
            } else {
                DB::table("pro_indent_details_$id2")
                    ->where('indent_no', '=', $request->txt_indent_no)
                    ->where('product_id', '=', $request->cbo_product)
                    ->update(['rr_status' => 1, 'rr_qty' => $newrr_qty]);
            }
            // DB::table('pro_indent_details')
            //     ->where('indent_no', '=', $request->txt_indent_no)
            //     ->where('product_id', '=', $request->cbo_product)
            //     ->update(['rr_status' => 1, 'rr_qty' => $newrr_qty]);
            //
            DB::table("pro_grr_details_$id2")->where('grr_details_id', $id)->update([
                'received_qty' => $request->txt_rr_qty,
                'remarks' => $request->txt_remarks,
            ]);
            $grr_master = DB::table("pro_grr_master_$id2")->where('grr_no', $request->txt_grr_no)->first();
            return redirect()->route('inventory_receiving_report_details', [$grr_master->grr_master_id, $id2]);
        } else {
            return back()->with('warning', 'received qty no more !');
        }
    }


    //Report RPT RR List
    public function RPTRRList()
    {
        return view('inventory.rpt_rr_list');
    }

    public function RPTRRListView($grr_master_id, $company_id)
    {
        $grr_master = DB::table("pro_grr_master_$company_id")
            ->leftJoin('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->leftJoin("pro_supplier_information_$company_id", "pro_grr_master_$company_id.supplier_id", "pro_supplier_information_$company_id.supplier_id")
            ->leftJoin('pro_employee_info', "pro_grr_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select(
                "pro_grr_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                "pro_supplier_information_$company_id.supplier_name",
                "pro_supplier_information_$company_id.supplier_address",
                'pro_employee_info.employee_name'
            )
            ->where("pro_grr_master_$company_id.grr_master_id", $grr_master_id)
            ->first();

        $pro_grr_details = DB::table("pro_grr_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_grr_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_grr_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_grr_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_grr_details_$company_id.unit", 'pro_units.unit_id')
            ->select(
                "pro_grr_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_grr_details_$company_id.grr_no", $grr_master->grr_no)
            ->get();

        return view('inventory.rpt_rr_view', compact('grr_master', 'pro_grr_details'));
    }

    public function RPTRRListPrint($grr_master_id, $company_id)
    {
        $grr_master = DB::table("pro_grr_master_$company_id")
            ->leftJoin('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
            ->leftJoin("pro_supplier_information_$company_id", "pro_grr_master_$company_id.supplier_id", "pro_supplier_information_$company_id.supplier_id")
            ->leftJoin('pro_employee_info', "pro_grr_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->select(
                "pro_grr_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_indent_category.category_name',
                "pro_supplier_information_$company_id.supplier_name",
                "pro_supplier_information_$company_id.supplier_address",
                'pro_employee_info.employee_name'
            )
            ->where("pro_grr_master_$company_id.grr_master_id", $grr_master_id)
            ->first();

        $pro_grr_details = DB::table("pro_grr_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_grr_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_grr_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_grr_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_grr_details_$company_id.unit", 'pro_units.unit_id')
            ->select(
                "pro_grr_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_grr_details_$company_id.grr_no", $grr_master->grr_no)
            ->get();

        return view('inventory.rpt_rr_print', compact('grr_master', 'pro_grr_details'));
    }
    public function GetRPTRRList($company_id, $form, $to)
    {

        //  return $form;
        if ($form == 0) {
            $data = DB::table("pro_grr_master_$company_id")
                ->leftJoin('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
                ->leftJoin("pro_supplier_information_$company_id", "pro_grr_master_$company_id.supplier_id", "pro_supplier_information_$company_id.supplier_id")
                ->select(
                    "pro_grr_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_indent_category.category_name',
                    "pro_supplier_information_$company_id.supplier_name",
                    "pro_supplier_information_$company_id.supplier_address",
                )
                ->where("pro_grr_master_$company_id.company_id", $company_id)
                // ->whereBetween("pro_grr_master_$company_id.entry_date",[$form,$to])
                ->where("pro_grr_master_$company_id.status", 2)
                ->orderBy("pro_grr_master_$company_id.grr_master_id", "desc")
                // ->take(10)
                ->get();
        } else {
            $data = DB::table("pro_grr_master_$company_id")
                ->leftJoin('pro_project_name', "pro_grr_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_indent_category', "pro_grr_master_$company_id.indent_category", 'pro_indent_category.category_id')
                ->leftJoin("pro_supplier_information_$company_id", "pro_grr_master_$company_id.supplier_id", "pro_supplier_information_$company_id.supplier_id")
                ->select(
                    "pro_grr_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_indent_category.category_name',
                    "pro_supplier_information_$company_id.supplier_name",
                    "pro_supplier_information_$company_id.supplier_address",
                )
                ->where("pro_grr_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_grr_master_$company_id.entry_date", [$form, $to])
                ->where("pro_grr_master_$company_id.status", 2)
                ->orderBy("pro_grr_master_$company_id.grr_master_id", "desc")
                // ->take(10)
                ->get();
        }

        return response()->json($data);
    }

    //End Indent List For RR

    public function RPTRRExcel($grr_no, $company_id)
    {
        $company = DB::table('pro_company')->where('company_id', $company_id)->first();
        $name =  $company == null ? '' : $company->company_name;
        //remove space 
        if ($name != '') {
            $x = explode(' ', $name);
            $y = implode('_', $x);
            $company_name = strtolower($y);
        } else {
            $company_name = '';
        }
        //File Name
        $filename = "$company_name$grr_no";
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
        $fields = array('SL No.', 'Product Group', 'Product Name', 'RR Qty', 'Unit', 'Remarks');

        // Display column names as first row 
        $excelColume = implode($sep, array_values($fields)) . $new;
        echo $excelColume;

        // Display My data 
        $data =  DB::table("pro_grr_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_grr_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_grr_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_grr_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_grr_details_$company_id.unit", 'pro_units.unit_id')
            ->select(
                "pro_grr_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_grr_details_$company_id.company_id", $company_id)
            ->where("pro_grr_details_$company_id.grr_no", $grr_no)
            ->get();

        foreach ($data as $key => $row) {
            $key = $key + 1;
            $value = array("$key", "$row->pg_name/$row->pg_sub_name", "$row->product_name", "$row->received_qty", "$row->unit_name", "$row->remarks");
            $result = implode($sep, array_values($value)) . $new;
            echo $result;
        }
        // return back();
    }

    //Material Requsition
    public function material_requsition_info()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();
        $pro_project_name = DB::table('pro_project_name')->get();
        $pro_section_information = DB::table('pro_section_information')->get();
        return view('inventory.material_requsition_info', compact('pro_project_name', 'pro_section_information', 'user_company'));
    }

    public function inventory_material_req_store(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_project_id' => 'required',
            'cbo_section_id' => 'required',
            'txt_serial_no' => 'required',
            'txt_serial_date' => 'required',
            // 'cbo_job_id' => 'required',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            'txt_req_qty' => 'required',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',
            'cbo_project_id.required' => 'Project Name field is required!',
            'cbo_section_id.required' => 'Section field is required!',
            'txt_serial_no.required' => 'serial no field is required!',
            'txt_serial_date.required' => 'serial date field is required!',
            // 'cbo_job_id.required' => 'job field is required!',
            'cbo_product_group.required' => 'product Group field is required!',
            'cbo_product_group.integer' => 'product Group field is required!',
            'cbo_product_group.between' => 'product Group field is required!',
            'cbo_product_sub_group.required' => 'product Sub Group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub Group field is required!',
            'cbo_product_sub_group.between' => 'product Sub Group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            'txt_req_qty.required' => 'Requsition qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_date = date("Y-m-d");
        // $m_date="2024-07-31";

        // $mm=date("Ym",strtotime($m_date));

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['project_id'] = $request->cbo_project_id;
        $data['section_id'] = $request->cbo_section_id;
        $data['jo_no'] = $request->cbo_job_id;
        // $data['jo_date']=$request->cbo_job_id;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['product_unit'] = $request->txt_unit_id;
        $data['requsition_qty'] = $request->txt_req_qty;
        $data['remarks'] = $request->txt_product_remarks;
        $data['issue_status'] = 1;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['entry_date'] = $m_date;
        $data['entry_time'] = date("h:i:sa");
        $last_mrm = DB::table("pro_gmaterial_requsition_master_$request->cbo_company_id")->orderByDesc("mrm_no")->first();
        $mrm_no = date("Ym", strtotime($m_date)) . str_pad((substr($last_mrm->mrm_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        // $mrm_no = "202407".str_pad((substr($last_mrm->mrm_no,-5)+1),5,'0',STR_PAD_LEFT);
        $data['mrm_no'] =  $mrm_no;
        $data['mrm_date'] = $m_date;

        DB::table("pro_gmaterial_requsition_master_$request->cbo_company_id")->insert([
            'mrm_no' => $mrm_no,
            'company_id' => $request->cbo_company_id,
            'mrm_date' => $m_date,
            // 'mrm_date' => "2023-07-31",
            'user_id' => Auth::user()->emp_id,
            'project_id' => $request->cbo_project_id,
            'section_id' => $request->cbo_section_id,
            'mrm_serial_no' => $request->txt_serial_no,
            'mrm_serial_date' => $request->txt_serial_date,
            'jo_no' => $request->cbo_job_id,
            // 'jo_date'=>$request->cbo_job_id,
            'issue_status' => '1',
            'status' => '1',
            'remarks' => $request->txt_product_remarks,
            'entry_date' => $m_date,
            'entry_time' => date("h:i:sa"),
            'valid' => '1',
        ]);

        DB::table("pro_gmaterial_requsition_details_$request->cbo_company_id")->insert($data);

        return redirect()->route('inventory_material_req_details', [$mrm_no, $request->cbo_company_id]);
    }

    public function inventory_material_req_details($id, $id2)
    {
        $mr_master = DB::table("pro_gmaterial_requsition_master_$id2")
            ->leftjoin('pro_project_name', "pro_gmaterial_requsition_master_$id2.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_section_information', "pro_gmaterial_requsition_master_$id2.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_gmaterial_requsition_master_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_requsition_master_$id2.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_requsition_master_$id2.mrm_no", '=', $id)
            ->first();

        $mr_details = DB::table("pro_gmaterial_requsition_details_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_gmaterial_requsition_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_gmaterial_requsition_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftjoin("pro_product_$id2", "pro_gmaterial_requsition_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$id2.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_requsition_details_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_product_$id2.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_requsition_details_$id2.mrm_no", '=', $id)
            // ->where('pro_gmaterial_requsition_details.status', '=', 1)
            ->get();

        $pro_product_group = DB::table("pro_product_group_$id2")->get();
        return view('inventory.material_requsition_details', compact('mr_master', 'mr_details', 'pro_product_group'));
    }

    public function inventory_material_req_details_store(Request $request, $id2)
    {
        $rules = [
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            // 'txt_approved_qty' => 'required|integer|between:1,99999999',
            'txt_req_qty' => 'required',
        ];

        $customMessages = [
            'cbo_product_group.required' => 'product Group field is required!',
            'cbo_product_group.integer' => 'product Group field is required!',
            'cbo_product_group.between' => 'product Group field is required!',
            'cbo_product_sub_group.required' => 'product Sub Group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub Group field is required!',
            'cbo_product_sub_group.between' => 'product Sub Group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            // 'txt_approved_qty.required' => 'Approved qty field is required!',
            'txt_req_qty.required' => 'Requsition qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_date = date("Y-m-d");
        // $m_date="2024-07-31";

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['project_id'] = $request->txt_project_id;
        $data['company_id'] = $id2;
        $data['section_id'] = $request->txt_section_id;
        $data['jo_no'] = $request->txt_job_no;
        // $data['jo_date']=$request->cbo_job_id;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        //
        $get_product = DB::table("pro_product_$id2")->where('product_id', $request->cbo_product)->first();
        $data['product_unit'] = $get_product->unit;
        //
        // $data['approved_qty'] = $request->txt_approved_qty;
        $data['requsition_qty'] = $request->txt_req_qty;
        $data['remarks'] = $request->txt_product_remarks;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['issue_status'] = 1;
        $data['entry_date'] = $m_date;
        $data['entry_time'] = date("h:i:sa");
        $data['mrm_no'] =  $request->txt_mrm_no;
        $data['mrm_date'] = $request->txt_mrm_date;
        DB::table("pro_gmaterial_requsition_details_$id2")->insert($data);
        return redirect()->route('inventory_material_req_details', [$request->txt_mrm_no, $id2]);
    }
    public function inventory_material_req_details_edit($id, $id2)
    {
        $mr_details_edit = DB::table("pro_gmaterial_requsition_details_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_gmaterial_requsition_details_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_gmaterial_requsition_details_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftjoin("pro_product_$id2", "pro_gmaterial_requsition_details_$id2.product_id", "pro_product_$id2.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$id2.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_requsition_details_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_product_$id2.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_requsition_details_$id2.mrd_id", '=', $id)
            ->where("pro_gmaterial_requsition_details_$id2.status", '=', 1)
            ->first();

        $mr_master = DB::table("pro_gmaterial_requsition_master_$id2")
            ->leftjoin('pro_project_name', "pro_gmaterial_requsition_master_$id2.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_section_information', "pro_gmaterial_requsition_master_$id2.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_gmaterial_requsition_master_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_requsition_master_$id2.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_requsition_master_$id2.mrm_no", '=', $mr_details_edit->mrm_no)
            ->first();

        $pro_product_group = DB::table("pro_product_group_$id2")->get();
        return view('inventory.material_requsition_details', compact('mr_master', 'mr_details_edit', 'pro_product_group'));
    }

    public function inventory_material_req_details_update(Request $request, $id, $id2)
    {
        $rules = [
            // 'cbo_product_group' => 'required|integer|between:1,99999999',
            // 'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            // 'cbo_product' => 'required|integer|between:1,99999999',
            'txt_req_qty' => 'required',
        ];

        $customMessages = [
            'txt_req_qty.required' => 'Requsition qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        // $data['product_unit'] = $request->txt_unit_id;
        $data['requsition_qty'] = $request->txt_req_qty;
        $data['remarks'] = $request->txt_product_remarks;
        DB::table("pro_gmaterial_requsition_details_$id2")->where('mrd_id', $id)->update($data);
        return redirect()->route('inventory_material_req_details', [$request->txt_mrm_no, $id2]);
    }
    public function inventory_material_req_details_final($id, $id2)
    {
        DB::table("pro_gmaterial_requsition_details_$id2")
            ->where('mrm_no', '=', $id)
            ->update(['status' => 2]);
        DB::table("pro_gmaterial_requsition_master_$id2")
            ->where('mrm_no', '=', $id)
            ->update(['status' => 2]);
        return redirect()->route('material_requsition_info');
    }

    public function material_requsition_approval_list()
    {
        return view('inventory.material_requsition_approval_list');
    }

    public function company_wise_material_requsition_approval_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->leftjoin('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_gmaterial_requsition_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_requsition_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_requsition_master_$company_id.status", '=', 2)
            ->get();

        return view('inventory.material_requsition_approval_list', compact('mr_master'));
    }

    public function inventory_material_req_approval($id, $company_id)
    {
        $mr_details = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_requsition_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_requsition_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_requsition_details_$company_id.mrm_no", '=', $id)
            ->where("pro_gmaterial_requsition_details_$company_id.status", '=', 2)
            ->get();

        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->leftjoin('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_gmaterial_requsition_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_requsition_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_requsition_master_$company_id.mrm_no", '=', $id)
            ->where("pro_gmaterial_requsition_master_$company_id.status", '=', 2)
            ->first();

        return view('inventory.material_requsition_approval', compact('mr_master', 'mr_details'));
    }

    public function inventory_material_req_approval_ok(Request $request, $id, $company_id)
    {
        date_default_timezone_set("Asia/Dhaka");
        DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrd_id', '=', $id)
            ->where('mrm_no', '=', $request->txt_mrm_no)
            ->update([
                'status' => 3,
                'approved_by' => Auth::user()->emp_id,
                'approved_qty' => $request->txt_approved_qty,
                'approved_remarks' => $request->txt_approved_remarks,
                'approved_date' => date("Y-m-d"),
                // 'approved_date' => "2023-07-31",
                'approved_time' => date("h:i:sa"),
            ]);

        // all approved -> then Final redirection
        $mr_details =  DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $request->txt_mrm_no)
            ->where('status', '=', 3)
            ->get();

        $all_mr_details = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $request->txt_mrm_no)
            ->get();

        if (count($all_mr_details) == count($mr_details)) {
            DB::table("pro_gmaterial_requsition_master_$company_id")
                ->where('mrm_no', '=', $request->txt_mrm_no)
                ->update(['status' => 3]);
            return redirect()->route('material_requsition_approval_list');
        } else {
            return back();
        }
    }

    //RPT Requsition
    public function RPTRequsitionList()
    {
        return view('inventory.rpt_requsition_list');
    }

    public function RPTRequsitionView($mrm_no, $company_id)
    {
        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->leftJoin('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
            ->select(
                "pro_gmaterial_requsition_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
            )
            ->where("pro_gmaterial_requsition_master_$company_id.mrm_no", $mrm_no)
            ->where("pro_gmaterial_requsition_master_$company_id.status", 3)
            ->first();

        $mr_details = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_requsition_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_requsition_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_requsition_details_$company_id.mrm_no", $mr_master->mrm_no)
            ->where("pro_gmaterial_requsition_details_$company_id.status", 3)
            ->get();



        return view('inventory.rpt_requsition_view', compact('mr_master', 'mr_details'));
    }

    public function RPTRequsitionPrint($mrm_no, $company_id)
    {
        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->leftJoin('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
            ->select(
                "pro_gmaterial_requsition_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
            )
            ->where("pro_gmaterial_requsition_master_$company_id.mrm_no", $mrm_no)
            ->where("pro_gmaterial_requsition_master_$company_id.status", 3)
            ->first();

        $mr_details = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_requsition_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_requsition_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_requsition_details_$company_id.mrm_no", $mr_master->mrm_no)
            ->where("pro_gmaterial_requsition_details_$company_id.status", 3)
            ->get();

        return view('inventory.rpt_requsition_print', compact('mr_master', 'mr_details'));
    }

    public function RPTRequsitionExcel($mrm_no, $company_id)
    {

        $company = DB::table('pro_company')->where('company_id', $company_id)->first();
        $name =  $company == null ? '' : $company->company_name;
        //remove space 
        if ($name != '') {
            $x = explode(' ', $name);
            $y = implode('_', $x);
            $company_name = strtolower($y);
        } else {
            $company_name = '';
        }

        //File Name
        $filename = "$company_name$mrm_no";
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
        $fields = array('SL No.', 'Product Group', 'Product Name', 'Requsition Qty', 'Approved Qty', 'Unit', 'Remarks');

        // Display column names as first row 
        $excelColume = implode($sep, array_values($fields)) . $new;
        echo $excelColume;

        // Display My data 
        $data =  DB::table("pro_gmaterial_requsition_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_requsition_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_requsition_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_requsition_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_requsition_details_$company_id.mrm_no", $mrm_no)
            ->get();

        foreach ($data as $key => $row) {
            $key = $key + 1;
            $value = array("$key", "$row->pg_name/$row->pg_sub_name", "$row->product_name", "$row->requsition_qty", "$row->approved_qty", "$row->unit_name", "$row->remarks");
            $result = implode($sep, array_values($value)) . $new;
            echo $result;
        }
    }

    public function GetRPTRequsitionList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_gmaterial_requsition_master_$company_id")
                ->join('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
                ->join('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
                ->select(
                    "pro_gmaterial_requsition_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_section_information.section_name',
                )
                ->where("pro_gmaterial_requsition_master_$company_id.company_id", $company_id)
                // ->whereBetween("pro_gmaterial_requsition_master_$company_id.entry_date", [$form, $to])
                ->where("pro_gmaterial_requsition_master_$company_id.status", 3)
                ->orderBy("pro_gmaterial_requsition_master_$company_id.mrm_no", "desc")
                ->get();
        } else {
            $data = DB::table("pro_gmaterial_requsition_master_$company_id")
                ->join('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
                ->join('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
                ->select(
                    "pro_gmaterial_requsition_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_section_information.section_name',
                )
                ->where("pro_gmaterial_requsition_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_gmaterial_requsition_master_$company_id.entry_date", [$form, $to])
                ->where("pro_gmaterial_requsition_master_$company_id.status", 3)
                ->orderBy("pro_gmaterial_requsition_master_$company_id.mrm_no", "desc")
                ->get();
        }
        return response()->json($data);
    }


    // Ajax requsition
    public function GetRequsitionProductSubGroup($id, $id2)
    {
        $data = DB::table("pro_product_sub_group_$id2")->where('pg_id', $id)->get();
        return json_encode($data);
    }
    public function GetRequsitionProduct($id, $id2)
    {
        $data = DB::table("pro_product_$id2")
            ->join('pro_units', "pro_product_$id2.unit", 'pro_units.unit_id')
            ->select(
                "pro_product_$id2.*",
                'pro_units.unit_id',
                'pro_units.unit_name',
            )
            ->where("pro_product_$id2.pg_sub_id", $id)
            ->get();
        return json_encode($data);
    }
    public function GetProductList($id, $id2)
    {
        $data = DB::table("pro_product_$id2")->where('product_id', $id)
            ->leftJoin('pro_units', "pro_product_$id2.unit", 'pro_units.unit_id')
            ->select("pro_product_$id2.*", 'pro_units.unit_name', 'pro_units.unit_id')
            ->first();
        return json_encode($data);
    }

    public function GetMRMProduct($id, $mrm_no, $id2)
    {
        $requsition_product_id = DB::table("pro_gmaterial_requsition_details_$id2")->where('mrm_no', '=', $mrm_no)->pluck('product_id');
        $data = DB::table("pro_product_$id2")
            ->whereNotIn('product_id', $requsition_product_id)
            ->where('pg_sub_id', $id)
            ->get();
        return json_encode($data);
    }
    //End Material Requsition


    //Material Issue
    public function InventoryRequsitionListForIssue()
    {
        return view('inventory.requsition_list_for_issue');
    }

    public function company_wise_requsition_list_for_issue(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->leftjoin('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_gmaterial_requsition_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_requsition_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_requsition_master_$company_id.status", '=', 3)
            ->where("pro_gmaterial_requsition_master_$company_id.issue_status", '=', 1)
            ->orderBy("pro_gmaterial_requsition_master_$company_id.mrm_no", 'DESC')
            ->get();

        return view('inventory.requsition_list_for_issue', compact('mr_master'));
    }

    public function inventory_req_material_issue($id, $company_id)
    {
        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->leftjoin('pro_project_name', "pro_gmaterial_requsition_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftjoin('pro_section_information', "pro_gmaterial_requsition_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_gmaterial_requsition_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_requsition_master_$company_id.*",
                'pro_project_name.project_id',
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_section_information.section_id',
                'pro_company.company_name',
                'pro_company.company_id',
            )
            ->where("pro_gmaterial_requsition_master_$company_id.mrm_no", '=', $id)
            ->first();


        $issue_master_check = DB::table("pro_graw_issue_master_$company_id")
            ->where('mrm_no', '=', $mr_master->mrm_no)
            ->where('status', '=', 1)
            ->first();

        if (isset($issue_master_check)) {

            return redirect()->route('inventory_req_material_issue_details', [$issue_master_check->rim_no, $company_id]);
        } else {
            $pro_project_name = DB::table('pro_project_name')->get();
            $pro_section_information = DB::table('pro_section_information')->get();

            return view('inventory.material_issue_info', compact('pro_project_name', 'pro_section_information', 'mr_master'));
        }
    }

    public function inventory_req_material_issue_store(Request $request, $company_id)
    {
        $rules = [
            // 'txt_project_id' => 'required',
            // 'txt_section_id' => 'required',
            'txt_requsition_no' => 'required',
            'txt_requsition_date' => 'required',
        ];

        $customMessages = [
            // 'txt_project_id.required' => 'project field is required!',
            // 'txt_section_id.required' => 'section field is required!',
            'txt_requsition_no.required' => 'requsition no field is required!',
            'txt_requsition_date.required' => 'requsition date field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_date = date("Y-m-d");
        // $m_date="2024-07-31";

        $mr_master = DB::table("pro_gmaterial_requsition_master_$company_id")
            ->where('mrm_no', '=', $request->txt_requsition_no)
            ->first();

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $company_id;
        $data['project_id'] = $mr_master->project_id;
        $data['section_id'] = $mr_master->section_id;
        $data['mrm_no'] = $mr_master->mrm_no;
        $data['mrm_date'] = $mr_master->mrm_date;
        // $data['job_no'] = $request->txt_job_no;
        // $data['job_date'] = $request->txt_job_info;
        $data['remrks'] = $request->txt_Remarks;
        $data['status'] = '1';
        $data['valid'] = '1';
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = $m_date;
        $data['entry_time'] = date("h:i:sa");
        // $rim_no = 'IM' . substr(date("Y"), -2) . date("m") . str_pad(mt_rand(1, 100000), 5, '0', STR_PAD_LEFT);
        $last_rim = DB::table("pro_graw_issue_master_$company_id")->orderByDesc("rim_no")->first();
        $rim_no = "IM" . date("ym", strtotime($m_date)) . str_pad((substr($last_rim->rim_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        $data['rim_no'] =  $rim_no;
        $data['rim_date'] = $m_date;

        $check = DB::table("pro_graw_issue_master_$company_id")->insert($data);
        if ($check) {
            return redirect()->route('inventory_req_material_issue_details', [$rim_no, $company_id]);
        }
    }

    public function inventory_req_material_issue_details($id, $company_id)
    {
        $rim_master = DB::table("pro_graw_issue_master_$company_id")
            ->leftJoin('pro_project_name', "pro_graw_issue_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_graw_issue_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftjoin('pro_company', "pro_graw_issue_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_graw_issue_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
                'pro_company.company_id',
            )
            ->where("pro_graw_issue_master_$company_id.rim_no", '=', $id)
            ->first();


        $rim_details = DB::table("pro_graw_issue_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_graw_issue_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_graw_issue_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_graw_issue_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_graw_issue_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_graw_issue_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_graw_issue_details_$company_id.rim_no", '=', $id)
            // ->where('pro_graw_issue_details.status', '=', '1')
            ->orderBy("pro_graw_issue_details_$company_id.rid_id")
            // ->orderByDesc("mrm_no")
            ->get();

        $issu_product = DB::table("pro_graw_issue_details_$company_id")
            ->where('rim_no', $id)
            ->where('status', '=', '1')
            ->pluck('product_id');

        $pg_id = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', $rim_master->mrm_no)
            ->whereNotIn('product_id', $issu_product)
            ->where('issue_status', '=', 1)
            ->pluck('pg_id');

        $pro_product_group = DB::table("pro_product_group_$company_id")
            ->whereIn('pg_id', $pg_id)
            ->get();
        return view('inventory.material_issue_details', compact('rim_master', 'pro_product_group', 'rim_details'));
    }
    public function inventory_req_material_issue_details_store(Request $request, $company_id)
    {

        // previous issue
        $previous_issue_qty = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $request->txt_Requsition_no)
            ->where('pg_id', '=', $request->cbo_product_group)
            ->where('product_id', '=', $request->cbo_product)
            ->select("pro_gmaterial_requsition_details_$company_id.issue_qty")
            ->first();

        $total_issue_qty = $request->txt_issue_qty + $previous_issue_qty->issue_qty;

        if ($total_issue_qty == $request->txt_requsition_qty &&  $request->txt_stock_qty >= $total_issue_qty) {
            DB::table("pro_gmaterial_requsition_details_$company_id")
                ->where('mrm_no', '=', $request->txt_Requsition_no)
                ->where('pg_id', '=', $request->cbo_product_group)
                ->where('product_id', '=', $request->cbo_product)
                ->update([
                    'issue_status' => '2',
                    'issue_qty' => $total_issue_qty,
                ]);

            DB::table("pro_graw_issue_details_$company_id")->where('rim_no', $request->txt_rim_no)->update(['status' => '2']);
        } elseif ($total_issue_qty > $request->txt_requsition_qty  && $request->txt_stock_qty > $total_issue_qty) {
            return back()->with('warning', 'Issue QTY getter then Previous QTY');
        } elseif ($total_issue_qty > $request->txt_stock_qty) {
            return back()->with('warning', 'Issue QTY getter then RR QTY');
        } else {
            DB::table("pro_gmaterial_requsition_details_$company_id")
                ->where('mrm_no', '=', $request->txt_Requsition_no)
                ->where('pg_id', '=', $request->cbo_product_group)
                ->where('product_id', '=', $request->cbo_product)
                ->update([
                    'issue_status' => '1',
                    'issue_qty' => $total_issue_qty,
                ]);
        }

        $rules = [
            'cbo_product_group' => 'required',
            'cbo_product_sub_group' => 'required',
            'cbo_product' => 'required',
            'txt_issue_qty' => 'required',
        ];

        $customMessages = [
            'cbo_product_group.required' => 'product group is required!',
            'cbo_product_sub_group.required' => 'product Sub Group is required!',
            'cbo_product_sub_group.integer' => 'product Sub Group is required!',
            'cbo_product_sub_group.between' => 'product Sub Group is required!',
            'cbo_product.required' => 'product is required!',
            'txt_issue_qty.required' => 'Issue Qty is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_date = date("Y-m-d");
        // $m_date="2024-07-31";

        $rim_master = DB::table("pro_graw_issue_master_$company_id")
            ->where('rim_no', '=', $request->txt_rim_no)
            ->first();

        $data = array();
        $data['company_id'] = $company_id;
        $data['rim_no'] =  $rim_master->rim_no;
        $data['rim_date'] = $rim_master->rim_date;
        $data['user_id'] = Auth::user()->emp_id;
        $data['project_id'] = $rim_master->project_id;
        $data['section_id'] = $rim_master->section_id;
        $data['mrm_no'] = $rim_master->mrm_no;
        $data['mrm_date'] = $rim_master->mrm_date;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        //
        $get_product = DB::table("pro_product_$company_id")->where('product_id', $request->cbo_product)->first();
        $data['product_unit'] = $get_product->unit;
        //
        $data['product_qty'] = $request->txt_issue_qty;
        $data['remarks'] = $request->txt_Remarks;
        $data['status'] = '1';
        $data['valid'] = '1';
        $data['entry_date'] =  $m_date;
        $data['entry_time'] = date("h:i:sa");
        DB::table("pro_graw_issue_details_$company_id")->insert($data);
        return redirect()->route('inventory_req_material_issue_details', [$request->txt_rim_no, $company_id])->with('success', 'Issue Sucessfull');
    }

    public function inventory_req_material_issue_details_final($id, $company_id)
    {
        $rim_master = DB::table("pro_graw_issue_master_$company_id")->where('rim_no', $id)->first();

        $total_details = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $rim_master->mrm_no)
            ->get();

        $mrm_details = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $rim_master->mrm_no)
            ->where('issue_status', '=', '2')
            ->get();

        if (count($total_details) == count($mrm_details)) {
            DB::table("pro_gmaterial_requsition_master_$company_id")->where('mrm_no', $rim_master->mrm_no)->update(['issue_status' => 2]);
            DB::table("pro_gmaterial_requsition_details_$company_id")->where('mrm_no', $rim_master->mrm_no)->update(['issue_status' => 2]);
        }
        //
        DB::table("pro_graw_issue_details_$company_id")->where('rim_no', '=', $id)->update(['status' => 2]);
        DB::table("pro_graw_issue_master_$company_id")->where('rim_no', '=', $id)->update(['status' => 2]);
        return redirect()->route('requsition_list_for_issue');
    }

    public function inventory_req_material_issue_edit($rid_id, $company_id)
    {
        $rim_details_edit = DB::table("pro_graw_issue_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_graw_issue_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_graw_issue_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_graw_issue_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_graw_issue_details_$company_id.product_unit", 'pro_units.unit_id')
            ->leftJoin('pro_company', "pro_graw_issue_details_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_graw_issue_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
                'pro_company.company_name',
                'pro_company.company_id',
            )
            ->where("pro_graw_issue_details_$company_id.rid_id", $rid_id)
            // ->where('pro_graw_issue_details.status', '=', '1')
            ->first();


        $rim_master = DB::table("pro_graw_issue_master_$company_id")
            ->leftJoin('pro_project_name', "pro_graw_issue_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_graw_issue_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftJoin('pro_company', "pro_graw_issue_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_graw_issue_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
                'pro_company.company_id',
            )
            ->where("pro_graw_issue_master_$company_id.rim_no", $rim_details_edit->rim_no)
            ->first();
        return view('inventory.material_issue_details', compact('rim_master', 'rim_details_edit'));
    }

    public function inventory_req_material_issue_details_update(Request $request, $rid_id, $company_id)
    {

        $m_entry_date = date("Y-m-d");
        // $m_entry_time=date("H:i:s");


        $rim_details_edit = DB::table("pro_graw_issue_details_$company_id")
            ->where('rid_id', $rid_id)
            ->first();

        $rim_master = DB::table("pro_graw_issue_master_$company_id")
            ->where('rim_no', $rim_details_edit->rim_no)
            ->first();

        //Stock
        $total_grr_qty = DB::table("pro_grr_details_$company_id")
            ->where('product_id', '=', $rim_details_edit->product_id)
            ->sum('received_qty');

        $mrmissueqty = DB::table("pro_graw_issue_details_$company_id")
            ->where('product_id', '=', $rim_details_edit->product_id)
            ->sum('product_qty');


        $mrmreturnqty = DB::table("pro_gmaterial_return_details_$company_id")
            ->where('product_id', '=', $rim_details_edit->product_id)
            ->sum('useable_qty');

        $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($m_entry_date)));
        $closing_year = substr($closing_date, 0, 4);
        $closing_month = substr($closing_date, 5, 2);

        $table_name = "pro_stock_closing_" . "$closing_year$closing_month" . "_$company_id";

        $closing_stock_qty =  DB::table("$table_name")
            ->where('product_id', '=', $rim_details_edit->product_id)
            ->where('year', $closing_year)
            ->where('month', $closing_month)
            ->sum('qty');

        $stock =  $total_grr_qty -  $mrmissueqty + $mrmreturnqty + $closing_stock_qty;
        //

        // previous issue
        $previous_issue_qty = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $rim_details_edit->mrm_no)
            ->where('pg_id', '=', $rim_details_edit->pg_id)
            ->where('product_id', '=', $rim_details_edit->product_id)
            ->select("pro_gmaterial_requsition_details_$company_id.*")
            ->first();

        $total_issue_qty = $request->txt_issue_qty + $previous_issue_qty->issue_qty - $rim_details_edit->product_qty;

        // dd("$stock -- $total_issue_qty -- $request->txt_issue_qty -- $previous_issue_qty->issue_qty -- $rim_details_edit->product_qty");
        if ($total_issue_qty == $previous_issue_qty->approved_qty &&   $stock >= $total_issue_qty) {
            DB::table("pro_gmaterial_requsition_details_$company_id")
                ->where('mrm_no', '=', $rim_details_edit->mrm_no)
                ->where('pg_id', '=', $rim_details_edit->pg_id)
                ->where('product_id', '=', $rim_details_edit->product_id)
                ->update([
                    'issue_status' => '2',
                    'issue_qty' => $total_issue_qty,
                    'remarks' => $request->txt_Remarks,
                ]);

            DB::table("pro_graw_issue_details_$company_id")->where('rim_no', $request->txt_rim_no)->update(['status' => '2']);
        } elseif ($total_issue_qty > $previous_issue_qty->approved_qty  &&  $stock > $total_issue_qty) {
            return back()->with('warning', 'Issue QTY getter then Previous QTY');
        } elseif ($total_issue_qty >  $stock) {
            dd("$total_issue_qty -- $stock");
            return back()->with('warning', 'Issue QTY getter then RR QTY');
        } else {
            DB::table("pro_gmaterial_requsition_details_$company_id")
                ->where('mrm_no', '=', $rim_details_edit->mrm_no)
                ->where('pg_id', '=', $rim_details_edit->pg_id)
                ->where('product_id', '=', $rim_details_edit->product_id)
                ->update([
                    'issue_status' => '1',
                    'issue_qty' => $total_issue_qty,
                    'remarks' => $request->txt_Remarks,
                ]);
        }


        $data = array();
        $data['product_qty'] = $request->txt_issue_qty;
        $data['remarks'] = $request->txt_Remarks;

        DB::table("pro_graw_issue_details_$company_id")->where('rid_id', $rid_id)->update($data);
        return redirect()->route('inventory_req_material_issue_details', [$rim_details_edit->rim_no, $company_id])->with('success', 'Issue Update Sucessfull');
    }

    //RPT Requsition
    public function RPTRequsitionIssueList()
    {
        return view('inventory.rpt_issue_list');
    }

    public function RPTRequsitionIssueView($rim_no, $company_id)
    {
        $issue_master = DB::table("pro_graw_issue_master_$company_id")
            ->leftJoin('pro_project_name', "pro_graw_issue_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_graw_issue_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftJoin("pro_gmaterial_requsition_master_$company_id", "pro_graw_issue_master_$company_id.mrm_no", "pro_gmaterial_requsition_master_$company_id.mrm_no")
            ->select(
                "pro_graw_issue_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                "pro_gmaterial_requsition_master_$company_id.mrm_serial_no",
                "pro_gmaterial_requsition_master_$company_id.mrm_serial_date",
            )
            ->where("pro_graw_issue_master_$company_id.rim_no", $rim_no)
            // ->orderBy("pro_graw_issue_master.rim_no", "desc")
            ->first();

        $issue_details = DB::table("pro_graw_issue_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_graw_issue_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_graw_issue_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_graw_issue_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_graw_issue_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_graw_issue_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_graw_issue_details_$company_id.rim_no", $rim_no)
            ->where("pro_graw_issue_details_$company_id.status", 2)
            ->get();
        return view('inventory.rpt_requsition_issue_view', compact('issue_master', 'issue_details'));
    }

    public function RPTRequsitionIssuePrint($rim_no, $company_id)
    {
        $issue_master = DB::table("pro_graw_issue_master_$company_id")
            ->leftJoin('pro_project_name', "pro_graw_issue_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_graw_issue_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftJoin("pro_gmaterial_requsition_master_$company_id", "pro_graw_issue_master_$company_id.mrm_no", "pro_gmaterial_requsition_master_$company_id.mrm_no")
            ->select(
                "pro_graw_issue_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                "pro_gmaterial_requsition_master_$company_id.mrm_serial_no",
                "pro_gmaterial_requsition_master_$company_id.mrm_serial_date",
            )
            ->where("pro_graw_issue_master_$company_id.rim_no", $rim_no)
            // ->orderBy("pro_graw_issue_master.rim_no", "desc")
            ->first();

        $issue_details = DB::table("pro_graw_issue_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_graw_issue_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_graw_issue_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_graw_issue_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_graw_issue_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_graw_issue_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_graw_issue_details_$company_id.rim_no", $rim_no)
            ->where("pro_graw_issue_details_$company_id.status", 2)
            ->get();

        return view('inventory.rpt_requsition_issue_print', compact('issue_master', 'issue_details'));
    }

    public function RPTIssueExcel($rim_no, $company_id)
    {

        $company = DB::table('pro_company')->where('company_id', $company_id)->first();
        $name =  $company == null ? '' : $company->company_name;
        //remove space 
        if ($name != '') {
            $x = explode(' ', $name);
            $y = implode('_', $x);
            $company_name = strtolower($y);
        } else {
            $company_name = '';
        }

        $filename = "$company_name$rim_no";         //File Name
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
        $fields = array('SL No.', 'Product Group', 'Product Name', 'Issue Qty', 'Unit', 'Remarks');

        // Display column names as first row 
        $excelColume = implode($sep, array_values($fields)) . $new;
        echo $excelColume;

        // Display My data 
        $data =  DB::table("pro_graw_issue_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_graw_issue_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_graw_issue_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_graw_issue_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_graw_issue_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_graw_issue_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_graw_issue_details_$company_id.rim_no", $rim_no)
            ->get();

        foreach ($data as $key => $row) {
            $key = $key + 1;
            $value = array("$key", "$row->pg_name/$row->pg_sub_name", "$row->product_name", "$row->product_qty", "$row->unit_name", "$row->remarks");
            $result = implode($sep, array_values($value)) . $new;
            echo $result;
        }
        // return back();
    }



    public function GetRPTRequsitionIssueList($company_id, $form, $to)
    {

        if ($form == 0) {
            $data = DB::table("pro_graw_issue_master_$company_id")
                ->leftJoin('pro_project_name', "pro_graw_issue_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_section_information', "pro_graw_issue_master_$company_id.section_id", 'pro_section_information.section_id')
                ->leftJoin("pro_gmaterial_requsition_master_$company_id", "pro_graw_issue_master_$company_id.mrm_no", "pro_gmaterial_requsition_master_$company_id.mrm_no")
                ->select(
                    "pro_graw_issue_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_section_information.section_name',
                    "pro_gmaterial_requsition_master_$company_id.mrm_serial_no",
                    "pro_gmaterial_requsition_master_$company_id.mrm_serial_date",
                )
                ->where("pro_graw_issue_master_$company_id.company_id", $company_id)
                // ->whereBetween("pro_graw_issue_master_$company_id.entry_date", [$form, $to])
                ->where("pro_graw_issue_master_$company_id.status", 2)
                ->orderBy("pro_graw_issue_master_$company_id.rim_no", "desc")
                ->get();
        } else {

            $data = DB::table("pro_graw_issue_master_$company_id")
                ->leftJoin('pro_project_name', "pro_graw_issue_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_section_information', "pro_graw_issue_master_$company_id.section_id", 'pro_section_information.section_id')
                ->leftJoin("pro_gmaterial_requsition_master_$company_id", "pro_graw_issue_master_$company_id.mrm_no", "pro_gmaterial_requsition_master_$company_id.mrm_no")
                ->select(
                    "pro_graw_issue_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_section_information.section_name',
                    "pro_gmaterial_requsition_master_$company_id.mrm_serial_no",
                    "pro_gmaterial_requsition_master_$company_id.mrm_serial_date",
                )
                ->where("pro_graw_issue_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_graw_issue_master_$company_id.entry_date", [$form, $to])
                ->where("pro_graw_issue_master_$company_id.status", 2)
                ->orderBy("pro_graw_issue_master_$company_id.rim_no", "desc")
                ->get();
        }

        return response()->json($data);
    }

    //End Material Issue


    //Material Return
    public function InventoryMaterialReturn()
    {
        $pro_project_name = DB::table('pro_project_name')->get();
        $pro_section_information = DB::table('pro_section_information')->get();
        return view('inventory.material_return_info', compact('pro_project_name', 'pro_section_information'));
    }

    public function inventory_material_return_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_project_id' => 'required',
            'cbo_section_id' => 'required',
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            'txt_return_date' => 'required',
            'txt_vouchar_no' => 'required',
            'txt_vouchar_no' => 'required',
            'txt_good_qty' => 'required',
            'txt_bad_qty' => 'required',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',
            'cbo_project_id.required' => 'project  field is required!',
            'cbo_section_id.required' => 'section field is required!',
            'cbo_product_group.required' => 'product group field is required!',
            'cbo_product_group.integer' => 'product group field is required!',
            'cbo_product_group.between' => 'product group field is required!',
            'cbo_product_sub_group.required' => 'product Sub Group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub Group field is required!',
            'cbo_product_sub_group.between' => 'product Sub Group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            'txt_return_date.required' => 'return date field is required!',
            'txt_vouchar_no.required' => 'vouchar no field is required!',
            'txt_good_qty.required' => 'good qty field is required!',
            'txt_bad_qty.required' => 'bad qty field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $company_id;
        $data['return_date'] = $request->txt_return_date;
        $data['project_id'] = $request->cbo_project_id;
        $data['section_id'] = $request->cbo_section_id;
        $data['voucher_no'] = $request->txt_vouchar_no;
        $data['jo_no'] = $request->cbo_job_id;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        //
        $get_product = DB::table("pro_product_$company_id")->where('product_id', $request->cbo_product)->first();
        $data['product_unit'] = $get_product->unit;

        $data['useable_qty'] = $request->txt_good_qty;
        $data['damage_qty'] = $request->txt_bad_qty;
        $data['comments'] = $request->txt_product_remarks;
        $data['status'] = 1;
        $data['valid'] = 1;
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        //$return_master_no = date("Y") . date("m") . str_pad(mt_rand(1, 100000), 5, '0', STR_PAD_LEFT);
        $last_mrm = DB::table("pro_gmaterial_return_master_$company_id")->orderByDesc("return_master_no")->first();
        $return_master_no = date("Ym") . str_pad((substr($last_mrm->return_master_no, -5) + 1), 5, '0', STR_PAD_LEFT);
        $data['return_master_no'] = $return_master_no;
        DB::table("pro_gmaterial_return_details_$company_id")->insert($data);

        //
        DB::table("pro_gmaterial_return_master_$company_id")->insert([
            'user_id' => Auth::user()->emp_id,
            'company_id' => $company_id,
            'return_master_no' => $return_master_no,
            'return_date' => $request->txt_return_date,
            'project_id' => $request->cbo_project_id,
            'section_id' => $request->cbo_section_id,
            'voucher_no' => $request->txt_vouchar_no,
            'jo_no' => $request->cbo_job_id,
            'remarks' => $request->txt_product_remarks,
            'status' => 1,
            'valid' => 1,
            'entry_date' => date("Y-m-d"),
            'entry_time' => date("h:i:sa"),
        ]);

        return redirect()->route('inventory_material_return_details', [$return_master_no, $company_id]);
    }
    public function inventory_material_return_details($id, $company_id)
    {
        $gm_return_master = DB::table("pro_gmaterial_return_master_$company_id")
            ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_gmaterial_return_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftJoin('pro_company', "pro_gmaterial_return_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_return_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_return_master_$company_id.return_master_no", $id)
            ->first();

        $gm_return_details = DB::table("pro_gmaterial_return_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_return_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_return_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_return_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_return_details_$company_id.return_master_no", $id)
            ->get();

        $pro_product_group = DB::table("pro_product_group_$company_id")->get();
        return view('inventory.material_return_details', compact('gm_return_master', 'pro_product_group', 'gm_return_details'));
    }
    public function inventory_material_return_details_store(Request $request, $company_id)
    {
        $rules = [
            'cbo_product_group' => 'required|integer|between:1,99999999',
            'cbo_product_sub_group' => 'required|integer|between:1,99999999',
            'cbo_product' => 'required|integer|between:1,99999999',
            'txt_good_qty' => 'required',
            'txt_bad_qty' => 'required',
            'txt_Requsition_no' => 'required',
        ];

        $customMessages = [
            'cbo_product_group.required' => 'product group field is required!',
            'cbo_product_group.integer' => 'product group field is required!',
            'cbo_product_group.between' => 'product group field is required!',
            'cbo_product_sub_group.required' => 'product Sub Group field is required!',
            'cbo_product_sub_group.integer' => 'product Sub Group field is required!',
            'cbo_product_sub_group.between' => 'product Sub Group field is required!',
            'cbo_product.required' => 'product field is required!',
            'cbo_product.integer' => 'product field is required!',
            'cbo_product.between' => 'product field is required!',
            'txt_good_qty.required' => 'good qty field is required!',
            'txt_bad_qty.required' => 'bad qty field is required!',
            'txt_Requsition_no.required' => 'Requsition no field is required!',

        ];
        $this->validate($request, $rules, $customMessages);
        $return_master = DB::table("pro_gmaterial_return_master_$company_id")
            ->where('return_master_no', '=', $request->txt_Requsition_no)
            ->first();

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['return_date'] = $return_master->return_date;
        $data['project_id'] = $return_master->project_id;
        $data['section_id'] = $return_master->section_id;
        $data['voucher_no'] = $return_master->voucher_no;
        $data['jo_no'] = $return_master->jo_no;

        $data['return_master_no'] = $request->txt_Requsition_no;
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        //
        $get_product = DB::table("pro_product_$company_id")->where('product_id', $request->cbo_product)->first();
        $data['product_unit'] = $get_product->unit;

        $data['useable_qty'] = $request->txt_good_qty;
        $data['damage_qty'] = $request->txt_bad_qty;
        $data['comments'] = $request->txt_product_remarks;
        $data['status'] = '1';
        $data['valid'] = '1';
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table("pro_gmaterial_return_details_$company_id")->insert($data);
        return redirect()->route('inventory_material_return_details', [$request->txt_Requsition_no, $company_id]);
    }
    public function inventory_material_return_final($id, $company_id)
    {
        DB::table("pro_gmaterial_return_details_$company_id")
            ->where('return_master_no', '=', $id)
            ->update(['status' => '2']);

        DB::table("pro_gmaterial_return_master_$company_id")
            ->where('return_master_no', '=', $id)
            ->update(['status' => '2']);

        return redirect()->route('material_return_info');
    }

    //edit

    public function inventory_material_return_edit($mreturnd_id, $company_id)
    {
        $gm_return_details_edit = DB::table("pro_gmaterial_return_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_return_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_return_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_return_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_return_details_$company_id.mreturnd_id", $mreturnd_id)
            ->first();


        $gm_return_master = DB::table("pro_gmaterial_return_master_$company_id")
            ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_gmaterial_return_master_$company_id.section_id", 'pro_section_information.section_id')
            ->leftJoin('pro_company', "pro_gmaterial_return_master_$company_id.company_id", 'pro_company.company_id')
            ->select(
                "pro_gmaterial_return_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
                'pro_company.company_name',
            )
            ->where("pro_gmaterial_return_master_$company_id.return_master_no", $gm_return_details_edit->return_master_no)
            ->first();
        $pro_product_group = DB::table("pro_product_group_$company_id")->get();
        return view('inventory.material_return_details', compact('gm_return_master', 'pro_product_group', 'gm_return_details_edit'));
    }

    public function inventory_material_return_update(Request $request, $mreturnd_id, $company_id)
    {
        $rules = [
            'txt_good_qty' => 'required',
            'txt_bad_qty' => 'required',
        ];

        $customMessages = [
            'txt_good_qty.required' => 'good qty field is required!',
            'txt_bad_qty.required' => 'bad qty field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['pg_id'] = $request->cbo_product_group;
        $data['pg_sub_id'] = $request->cbo_product_sub_group;
        $data['product_id'] = $request->cbo_product;
        $data['product_unit'] = $request->txt_unit_id;
        $data['useable_qty'] = $request->txt_good_qty;
        $data['damage_qty'] = $request->txt_bad_qty;
        $data['comments'] = $request->txt_product_remarks;

        DB::table("pro_gmaterial_return_details_$company_id")->where('mreturnd_id', $mreturnd_id)->update($data);
        $g_return_details =  DB::table("pro_gmaterial_return_details_$company_id")->where('mreturnd_id', $mreturnd_id)->first();

        return redirect()->route('inventory_material_return_details', [$g_return_details->return_master_no, $company_id]);
    }

    public function RPTMaterialReturnList()
    {
        return view('inventory.rpt_return_list');
    }
    public function RPTMaterialReturnView($return_master_no, $company_id)
    {

        $gm_return_master = DB::table("pro_gmaterial_return_master_$company_id")
            ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_gmaterial_return_master_$company_id.section_id", 'pro_section_information.section_id')
            ->select(
                "pro_gmaterial_return_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
            )
            ->where("pro_gmaterial_return_master_$company_id.return_master_no", $return_master_no)
            ->first();

        $gm_return_details = DB::table("pro_gmaterial_return_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_return_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_return_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_return_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_return_details_$company_id.return_master_no", $gm_return_master->return_master_no)
            ->where("pro_gmaterial_return_details_$company_id.status", 2)
            ->get();

        return view('inventory.rpt_return_view', compact('gm_return_master', 'gm_return_details'));
    }

    public function RPTMaterialReturnPrint($return_master_no, $company_id)
    {

        $gm_return_master = DB::table("pro_gmaterial_return_master_$company_id")
            ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$company_id.project_id", 'pro_project_name.project_id')
            ->leftJoin('pro_section_information', "pro_gmaterial_return_master_$company_id.section_id", 'pro_section_information.section_id')
            ->select(
                "pro_gmaterial_return_master_$company_id.*",
                'pro_project_name.project_name',
                'pro_section_information.section_name',
            )
            ->where("pro_gmaterial_return_master_$company_id.return_master_no", $return_master_no)
            ->first();

        $gm_return_details = DB::table("pro_gmaterial_return_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_return_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_return_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_return_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_return_details_$company_id.return_master_no", $gm_return_master->return_master_no)
            ->where("pro_gmaterial_return_details_$company_id.status", 2)
            ->get();

        return view('inventory.rpt_return_print', compact('gm_return_master', 'gm_return_details'));
    }

    public function RPTReturnExcel($return_master_no, $company_id)
    {

        $company = DB::table('pro_company')->where('company_id', $company_id)->first();
        $name =  $company == null ? '' : $company->company_name;
        //remove space 
        if ($name != '') {
            $x = explode(' ', $name);
            $y = implode('_', $x);
            $company_name = strtolower($y);
        } else {
            $company_name = '';
        }

        $filename = " $company_name$return_master_no";         //File Name
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
        $fields = array('SL No.', 'Product Group', 'Product Name', 'Issue Qty', 'Unit', 'Remarks');

        // Display column names as first row 
        $excelColume = implode($sep, array_values($fields)) . $new;
        echo $excelColume;

        // Display My data 
        $data =  DB::table("pro_gmaterial_return_details_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_gmaterial_return_details_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftjoin("pro_product_$company_id", "pro_gmaterial_return_details_$company_id.product_id", "pro_product_$company_id.product_id")
            ->leftJoin('pro_units', "pro_gmaterial_return_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_gmaterial_return_details_$company_id.*",
                "pro_product_group_$company_id.pg_name",
                "pro_product_sub_group_$company_id.pg_sub_name",
                "pro_product_$company_id.product_name",
                'pro_units.unit_name',
            )
            ->where("pro_gmaterial_return_details_$company_id.return_master_no", $return_master_no)
            ->get();

        foreach ($data as $key => $row) {
            $key = $key + 1;
            $value = array("$key", "$row->pg_name/$row->pg_sub_name", "$row->product_name", "$row->useable_qty", "$row->damage_qty", "$row->unit_name", "$row->comments");
            $result = implode($sep, array_values($value)) . $new;
            echo $result;
        }
        // return back();
    }


    //End Material Return

    // Report all stock
    public function RptAllStock()
    {
        return view('inventory.rpt_all_stock');
    }

    //Report All stock list
    public function RptAllStockList(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;

        $mentrydate = time();
        $m_current_date = date("Y-m-d", $mentrydate);
        $m_current_year = date("Y", $mentrydate);
        $m_current_month = date("m", $mentrydate);

        $txt_from_date = $request->txt_month_from;
        $txt_to_date = $request->txt_month_to;


        if ($txt_from_date === null && $txt_to_date === null) {
            $m_from_year = $m_current_year;
            $m_to_year = $m_current_year;
            $m_from_month = $m_current_month;
            $m_to_month = $m_current_month;

            $txt_start_date = "$m_from_year-$m_from_month-01";
            // $last_day_this_month = date('t', strtotime($txt_to_date));
            $txt_end_date = "$m_current_date";
        } else {
            $m_from_year = substr($txt_from_date, 0, 4);
            $m_to_year = substr($txt_to_date, 0, 4);
            $m_from_month = substr($txt_from_date, 5, 2);
            $m_to_month = substr($txt_to_date, 5, 2);

            $txt_start_date = "$m_from_year-$m_from_month-01";
            $last_day_this_month = date('t', strtotime($txt_to_date));
            $txt_end_date = "$m_to_year-$m_to_month-$last_day_this_month";
        }

        if ($m_from_year < '2023' || $m_to_year < '2023') {
            return redirect()->back()->withInput()->with('warning', "$m_from_year sorry !!");
        } else {
            // return 'OK';
            // $txt_start_date="$m_from_year-$m_from_month-01";
            // $last_day_this_month = date('t', strtotime($txt_to_date));
            // $txt_end_date="$m_to_year-$m_to_month-$last_day_this_month";


            $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($txt_start_date)));
            $closing_year = substr($closing_date, 0, 4);
            $closing_month = substr($closing_date, 5, 2);


            return view('inventory.rpt_all_stock_list', compact('txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'company_id'));
        } //
    }

    // End Report all stock

    // Report Damage stock
    public function RptDamageStock()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();

        return view('inventory.rpt_damage_stock', compact('user_company'));
    }

    //Report All stock list
    public function RptDamageStockList(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;

        $mentrydate = time();
        $m_current_date = date("Y-m-d", $mentrydate);
        $m_current_year = date("Y", $mentrydate);
        $m_current_month = date("m", $mentrydate);

        $txt_from_date = $request->txt_month_from;
        $txt_to_date = $request->txt_month_to;


        if ($txt_from_date === null && $txt_to_date === null) {
            $m_from_year = $m_current_year;
            $m_to_year = $m_current_year;
            $m_from_month = $m_current_month;
            $m_to_month = $m_current_month;

            $txt_start_date = "$m_from_year-$m_from_month-01";
            // $last_day_this_month = date('t', strtotime($txt_to_date));
            $txt_end_date = "$m_current_date";
        } else {
            $m_from_year = substr($txt_from_date, 0, 4);
            $m_to_year = substr($txt_to_date, 0, 4);
            $m_from_month = substr($txt_from_date, 5, 2);
            $m_to_month = substr($txt_to_date, 5, 2);

            $txt_start_date = "$m_from_year-$m_from_month-01";
            $last_day_this_month = date('t', strtotime($txt_to_date));
            $txt_end_date = "$m_to_year-$m_to_month-$last_day_this_month";
        }

        if ($m_from_year < '2023' || $m_to_year < '2023') {
            return redirect()->back()->withInput()->with('warning', "$m_from_year sorry !!");
        } else {
            // return 'OK';
            // $txt_start_date="$m_from_year-$m_from_month-01";
            // $last_day_this_month = date('t', strtotime($txt_to_date));
            // $txt_end_date="$m_to_year-$m_to_month-$last_day_this_month";


            $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($txt_start_date)));
            $closing_year = substr($closing_date, 0, 4);
            $closing_month = substr($closing_date, 5, 2);


            return view('inventory.rpt_damage_stock_list', compact('txt_start_date', 'txt_end_date', 'company_id'));
        } //
    }

    // End Report Damage stock




    // Report Product stock
    public function RptProductStock()
    {
        $pro_project_name = DB::table('pro_project_name')->get();
        return view('inventory.rpt_product_stock', compact('pro_project_name'));
    }

    //Report Product stock list
    public function RptProductStockList(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            // 'cbo_product_group' => 'required|integer|between:1,10000',
            'cbo_project_id' => 'required|integer|between:1,10000',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            // 'cbo_product_group.required' => 'Select Product Group.',
            // 'cbo_product_group.integer' => 'Select Product Group.',
            // 'cbo_product_group.between' => 'Select Product Group.',
            'cbo_project_id.required' => 'Select Project.',
            'cbo_project_id.integer' => 'Select Project.',
            'cbo_project_id.between' => 'Select Project.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_company_id = $request->cbo_company_id;

        $m_from_date = $request->txt_from_date;
        $m_to_date = $request->txt_to_date;
        // dd("$m_from_date -- $m_to_date");
        if ($m_from_date === NULL && $m_to_date === NULL) {

            $mentrydate = time();
            $m_current_date = date("Y-m-d", $mentrydate);
            $m_current_year = date("Y", $mentrydate);
            $m_current_month = date("m", $mentrydate);

            $txt_start_date = "$m_current_year-$m_current_month-01";
            // $last_day_this_month = date('t', strtotime($txt_to_date));
            $txt_end_date = "$m_current_date";

            $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($txt_start_date)));
            $closing_year = substr($closing_date, 0, 4);
            $closing_month = substr($closing_date, 5, 2);
            $txt_day = 0;
            $m_date = 0;
        } else {
            if ($m_from_date > $m_to_date) {
                return redirect()->back()->withInput()->with('warning', 'Date Mismatch!!');
            } else {
                $m_day = substr($m_from_date, 8, 2);
                $m_month = substr($m_from_date, 5, 2);
                $m_year = substr($m_from_date, 0, 4);
                // $txt_day=$m_day;

                if ($m_day > 01) {

                    $txt_start_date = "$m_from_date";
                    $txt_end_date = "$m_to_date";

                    $m_date = "$m_year-$m_month-01";

                    $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($m_date)));
                    $closing_year = substr($closing_date, 0, 4);
                    $closing_month = substr($closing_date, 5, 2);
                    $txt_day = $m_day;


                    // dd("aaaaaaaaa $m_day");
                } else {

                    $txt_start_date = "$m_from_date";
                    $txt_end_date = "$m_to_date";

                    $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($txt_start_date)));
                    $closing_year = substr($closing_date, 0, 4);
                    $closing_month = substr($closing_date, 5, 2);
                    $txt_day = 0;
                    $m_date = 0;
                }
            } //if($m_from_date>$m_to_date)

        } //if($m_from_date === NULL && $m_to_date === NULL)

        $txt_pg_id = $request->cbo_product_group;
        $txt_sub_pg_id = $request->cbo_product_sub_group;
        $txt_product_id = $request->cbo_product;
        $txt_project_id = $request->cbo_project_id;


        // dd("$m_day -- $txt_start_date -- $txt_end_date -- $txt_pg_id -- $txt_sub_pg_id --$txt_product_id");

        if ($txt_pg_id == 0 && $txt_sub_pg_id == 0 && $txt_product_id == 0) {

            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->get();

            return view('inventory.rpt_product_group_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        } else if ($txt_sub_pg_id == 0 && $txt_product_id == 0 && $txt_project_id == 0) {
            // dd("$txt_pg_id");

            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->where("pro_product_$m_company_id.pg_id", $txt_pg_id)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->get();

            return view('inventory.rpt_product_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        } else if ($txt_product_id == 0 && $txt_project_id == 0) {
            // dd("$txt_pg_id -- $txt_sub_pg_id");

            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->where("pro_product_$m_company_id.pg_id", $txt_pg_id)
                ->where("pro_product_$m_company_id.pg_sub_id", $txt_sub_pg_id)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->get();

            return view('inventory.rpt_product_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        } else if ($txt_project_id == 0) {

            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->where("pro_product_$m_company_id.pg_sub_id", $txt_sub_pg_id)
                ->where("pro_product_$m_company_id.product_id", $txt_product_id)
                ->where("pro_product_$m_company_id.pg_id", $txt_pg_id)
                ->get();

            return view('inventory.rpt_product_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        } else if ($txt_sub_pg_id == 0 && $txt_product_id == 0) {

            // dd($txt_project_id);

            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->where("pro_product_$m_company_id.pg_id", $txt_pg_id)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->get();

            return view('inventory.rpt_product_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        } else if ($txt_product_id == 0) {
            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->where("pro_product_$m_company_id.pg_id", $txt_pg_id)
                ->where("pro_product_$m_company_id.pg_sub_id", $txt_sub_pg_id)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->get();

            return view('inventory.rpt_product_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        } else {
            $ci_product_list  = DB::table("pro_product_$m_company_id")
                ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                ->where("pro_product_$m_company_id.valid", 1)
                ->where("pro_product_$m_company_id.pg_id", $txt_pg_id)
                ->where("pro_product_$m_company_id.pg_sub_id", $txt_sub_pg_id)
                ->where("pro_product_$m_company_id.product_id", $txt_product_id)
                ->orderby("pro_product_$m_company_id.pg_id", 'ASC')
                ->get();

            return view('inventory.rpt_product_stock_list', compact('m_company_id', 'txt_start_date', 'txt_end_date', 'closing_year', 'closing_month', 'ci_product_list', 'txt_project_id', 'txt_day', 'm_date'));
        }
    }



    // Report all stock
    public function ClosingStock()
    {
        $pro_project_name = DB::table('pro_project_name')->get();
        return view('inventory.closing_stock', compact('pro_project_name'));
    }


    public function ClosingStockList(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999',
            'txt_month' => 'required',
            'cbo_project_id' => 'required|integer|between:1,50',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',
            'txt_month.required' => 'Month and Year is required.',
            'cbo_project_id.required' => 'Project is required!',
            'cbo_project_id.integer' => 'Project is required!',
            'cbo_project_id.between' => 'Project is required!',

        ];
        $this->validate($request, $rules, $customMessages);
        $m_company_id = $request->cbo_company_id;

        $mentrydate = time();
        $m_current_date = date("Y-m-d", $mentrydate);
        $m_current_year = date("Y", $mentrydate);
        $m_current_month = date("m", $mentrydate);

        $txt_month1 = $request->txt_month;
        $m_year = substr($txt_month1, 0, 4);
        $m_month = substr($txt_month1, 5, 2);
        $txt_project_id = $request->cbo_project_id;

        //table name
        if ($request->txt_month) {
            $table_name = "pro_stock_closing_" . "$m_year$m_month" . "_$m_company_id";
        } else {
            $table_name = "pro_stock_closing_" . "$m_current_year$m_current_month" . "_$m_company_id";
        }

        if (Schema::hasTable("$table_name")) {
            //no action
        } else {
            //create table
            Schema::create("$table_name", function (Blueprint $table1) {
                $table1->increments('stock_closing_id');
                $table1->integer('company_id')->length(11);
                $table1->integer('project_id')->length(2);
                $table1->integer('pg_id')->length(11);
                $table1->integer('pg_sub_id')->length(11);
                $table1->integer('product_id')->length(11);
                $table1->double('qty', 15, 4);
                $table1->integer('product_unit')->length(2);
                $table1->double('product_rate', 15, 2);
                $table1->double('received_total', 15, 2);
                $table1->integer('price_status')->length(1);
                $table1->string('price_user_id', 8);
                $table1->date('price_entry_date');
                $table1->time('price_entry_time');
                $table1->integer('financial_year_id')->length(11);
                $table1->string('financial_year_name', 9);
                $table1->string('user_id', 8);
                $table1->date('entry_date');
                $table1->time('entry_time');
                $table1->integer('valid')->length(1);
                $table1->string('year', 4);
                $table1->string('month', 2);
            });
        }

        $m_user_id = Auth::user()->emp_id;

        if ($m_year < '2023') {
            return redirect()->back()->withInput()->with('warning', "$txt_month1 sorry !!");
        } else {

            $m_stock_closing = DB::table("$table_name")
                ->where('year', $m_year)
                ->where('month', $m_month)
                ->where('project_id', $txt_project_id)
                ->where('valid', 1)
                ->first();
            // dd($abcd);
            $ci_project_name  = DB::table('pro_project_name')
                ->where("project_id", $txt_project_id)
                ->where("valid", 1)
                ->first();

            $txt_project_name = $ci_project_name->project_name;


            if ($m_stock_closing === null) {
                $m_valid = '1';
                // $mentrydate = time();
                $m_entry_date = date("Y-m-d", $mentrydate);
                $m_entry_time = date("H:i:s", $mentrydate);

                if ($m_month == '01') {
                    $closing_year = $m_year - 1;
                    $closing_month = '12';
                } elseif ($m_month > '01') {
                    $closing_year = $m_year;
                    $closing_month = str_pad(($m_month - 1), 2, '0', STR_PAD_LEFT);
                }

                // $txt_financial_year_name='2021-2022';
                $txt_start_date = "$m_year-$m_month-01";
                $last_day_this_month = date('t', strtotime($txt_start_date));
                $txt_end_date = "$m_year-$m_month-$last_day_this_month";
                // $txt_project_id="5";
                // $txt_year=$m_year;
                // $txt_month='12';

                // dd("$m_year--$m_month--$closing_year--$closing_month--$txt_start_date--$txt_end_date--$last_day_this_month");

                $ci_product_list  = DB::table("pro_product_$m_company_id")
                    ->leftJoin("pro_product_group_$m_company_id", "pro_product_$m_company_id.pg_id", "pro_product_group_$m_company_id.pg_id")
                    ->leftJoin("pro_product_sub_group_$m_company_id", "pro_product_$m_company_id.pg_sub_id", "pro_product_sub_group_$m_company_id.pg_sub_id")
                    ->leftJoin('pro_units', "pro_product_$m_company_id.unit", 'pro_units.unit_id')
                    ->select("pro_product_$m_company_id.*", "pro_product_group_$m_company_id.pg_name", "pro_product_sub_group_$m_company_id.pg_sub_name", 'pro_units.unit_name')
                    ->where("pro_product_$m_company_id.valid", 1)
                    ->get();


                foreach ($ci_product_list as $row_product_list) {
                    $table_name_01 = "pro_stock_closing_" . "$closing_year$closing_month" . "_$m_company_id";
                    $ci_stock_closing  = DB::table("$table_name_01")
                        ->where("product_id", $row_product_list->product_id)
                        ->where("project_id", $txt_project_id)
                        ->where("year", $closing_year)
                        ->where("month", $closing_month)
                        // ->where("financial_year_name",$txt_financial_year_name)
                        ->sum('qty');

                    if ($ci_stock_closing === NULL) {
                        $txt_clossing_stock = "0.0000";
                    } else {
                        $txt_clossing_stock = "$ci_stock_closing";
                    }

                    $ci_grr_details  = DB::table("pro_grr_details_$m_company_id")
                        ->where("product_id", $row_product_list->product_id)
                        ->where("project_id", $txt_project_id)
                        ->whereBetween('grr_date', [$txt_start_date, $txt_end_date])
                        ->sum('received_qty');

                    if ($ci_grr_details === NULL) {
                        $txt_rr_qty = "0.0000";
                    } else {
                        $txt_rr_qty = "$ci_grr_details";
                    }

                    $ci_graw_issue_details  = DB::table("pro_graw_issue_details_$m_company_id")
                        ->where("product_id", $row_product_list->product_id)
                        ->where("project_id", $txt_project_id)
                        ->whereBetween('rim_date', [$txt_start_date, $txt_end_date])
                        ->sum('product_qty');

                    if ($ci_graw_issue_details === NULL) {
                        $txt_issue_qty = "0.0000";
                    } else {
                        $txt_issue_qty = "$ci_graw_issue_details";
                    }

                    $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$m_company_id")
                        ->where("product_id", $row_product_list->product_id)
                        ->where("project_id", $txt_project_id)
                        ->whereBetween('return_date', [$txt_start_date, $txt_end_date])
                        ->sum('useable_qty');

                    if ($ci_gmaterial_return_details === NULL) {
                        $txt_return_qty = "0.0000";
                    } else {
                        $txt_return_qty = "$ci_gmaterial_return_details";
                    }

                    $txt1_bal_qty = $txt_clossing_stock + $txt_rr_qty + $txt_return_qty - $txt_issue_qty;

                    $txt_bal_qty = "$txt1_bal_qty";

                    // if ($txt1_bal_qty < 1)
                    // {
                    //     $txt_bal_qty="0.0000";
                    // } else {
                    //     $txt_bal_qty="$txt1_bal_qty";
                    // }

                    // $txt_bal_qty=number_format($txt1_bal_qty,4);

                    $data = array();
                    $data['company_id'] = $m_company_id;
                    $data['project_id'] = $txt_project_id;
                    $data['pg_id'] = $row_product_list->pg_id;
                    $data['pg_sub_id'] = $row_product_list->pg_sub_id;
                    $data['product_id'] = $row_product_list->product_id;
                    $data['qty'] = $txt_bal_qty;
                    $data['product_unit'] = $row_product_list->unit;
                    $data['user_id'] = $m_user_id;
                    $data['entry_date'] = $m_entry_date;
                    $data['entry_time'] = $m_entry_time;
                    $data['valid'] = $m_valid;
                    $data['year'] = $m_year;
                    $data['month'] = $m_month;

                    DB::table("$table_name")->insert($data);
                } //foreach($ci_product_list as $key=>$row_product_list)
                //dd("$row_product_list->pg_name -- $txt_clossing_stock");

                return redirect()->back()->with('success', "$m_company_id $m_month $m_year $txt_project_name Data Inserted Successfully!");
            } else {
                //     // $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
                //     //dd($abcd)
                return redirect()->back()->withInput()->with('warning', "$m_company_id $m_month $m_year $txt_project_name Data already exists!!");
            } //if ($m_stock_closing === null) {
        } //if ($m_year > 2022) {


    }

    //Closing Stock List for Update
    public function ClosingStockQtyUpdate()
    {

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.purchase_status', '1')
            ->get();

        $pro_project_name = DB::table('pro_project_name')
            ->where('valid', '1')
            ->get();

        return view('inventory.closing_stock_list', compact('user_company', 'pro_project_name'));
    }

    public function ClosingStockQtyUpdate_01(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_project_id' => 'required|integer|between:1,10',
            'cbo_pg_id' => 'required|integer|between:1,100',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company is required!',
            'cbo_company_id.integer' => 'Company is required!',
            'cbo_company_id.between' => 'Company is required!',

            'cbo_project_id.required' => 'Project is required!',
            'cbo_project_id.integer' => 'Project is required!',
            'cbo_project_id.between' => 'Project is required!',

            'cbo_pg_id.required' => 'Product Group is required!',
            'cbo_pg_id.integer' => 'Product Group is required!',
            'cbo_pg_id.between' => 'Product Group is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_company_id = $request->cbo_company_id;
        $m_project_id = $request->cbo_project_id;
        $m_pg_id = $request->cbo_pg_id;
        $m_month = $request->txt_month;

        $txt_frist_date = date("Y-m-01", strtotime($m_month));
        $txt_last_date = date("Y-m-t", strtotime($m_month));

        $txt_month1 = date("m", strtotime($txt_frist_date));
        $txt_year = date("Y", strtotime($txt_frist_date));

        // dd("$txt_month$txt_year");
        // $month_number = $txt_month1;
        // $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        // $m_year=date("y",strtotime($txt_frist_date));
        // $m_attendance="pro_attendance_$txt_month1$m_year";
        $mm_company = "_$m_company_id";
        $table_name = "pro_stock_closing_" . "$txt_year$txt_month1" . "$mm_company";
        $m_stock_closing = "$table_name";

        $ci_company = DB::table("pro_company")
            ->where('company_id', $m_company_id)
            ->first();

        $ci_project = DB::table("pro_project_name")
            ->where('project_id', $m_project_id)
            ->first();

        $ci_product_group = DB::table("pro_product_group_$m_company_id")
            ->where('pg_id', $m_pg_id)
            ->first();

        $ci_stock_closing = DB::table("$m_stock_closing")
            ->leftJoin("pro_product_$m_company_id", "$m_stock_closing.product_id", "pro_product_$m_company_id.product_id")
            ->leftJoin("pro_product_group_$m_company_id", "$m_stock_closing.pg_id", "pro_product_group_$m_company_id.pg_id")
            ->leftJoin('pro_units', "$m_stock_closing.product_unit", 'pro_units.unit_id')
            ->select(
                "$m_stock_closing.*",
                "pro_product_$m_company_id.product_name",
                "pro_product_group_$m_company_id.pg_name",
                'pro_units.unit_name'
            )
            ->where("$m_stock_closing.company_id", $m_company_id)
            ->where("$m_stock_closing.project_id", $m_project_id)
            ->where("$m_stock_closing.pg_id", $m_pg_id)
            ->where("$m_stock_closing.valid", '1')
            ->where("$m_stock_closing.year", $txt_year)
            ->where("$m_stock_closing.month", $txt_month1)
            ->get();

        return view('inventory.closing_stock_qty_update', compact('ci_company', 'ci_project', 'ci_product_group', 'ci_stock_closing', 'm_stock_closing'));
    }

    public function ClosingStockQtyUpdate_02(Request $request)
    {
        $rules = [
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'txt_qty.required' => 'Qty is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_table = $request->txt_table;


        $data = array();
        $data['qty'] = $request->txt_qty;
        DB::table("$request->txt_table")
            ->where('stock_closing_id', $request->txt_stock_closing_id)
            ->update($data);

        return redirect()->back()->with('success', 'Closing Qty Update Successfull !');
    }



    public function RptProductRR()
    {
        return view('inventory.rpt_product_rr');
    }

    //Report Product wise stock list
    public function RptProductRRList(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_product_group' => 'required|integer|between:1,100',
            'cbo_product_sub_group' => 'required',
            'cbo_product' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'cbo_product_group.required' => 'Select Product Group.',
            'cbo_product_group.integer' => 'Select Product Group.',
            'cbo_product_group.between' => 'Select Product Group.',

            'cbo_product_sub_group.required' => 'Select Product Sub Group.',
            'cbo_product.required' => 'Select Product.',
            'txt_from_date.required' => 'Select From Date.',
            'txt_to_date.required' => 'Select To Date.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;

        $m_from_date = $request->txt_from_date;
        $m_to_date = $request->txt_to_date;

        $ci_product  = DB::table("pro_product_$company_id")
            ->where('product_id', $request->cbo_product)
            ->where('valid', 1)
            ->get();

        return view('inventory.rpt_product_rr_list', compact('ci_product', 'm_from_date', 'm_to_date', 'company_id'));
    }

    public function RptProductSupplyRR()
    {

        return view('inventory.rpt_product_supply_rr');
    }

    public function RptProductSupplyRRList(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required',
            'cbo_supplier_id' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_supplier_id.required' => 'Select Supplier.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $supplier_id = $request->cbo_supplier_id;

        $m_from_date = $request->txt_from_date;
        $m_to_date = $request->txt_to_date;

        $data = array();
        $data['company_id'] = $request->cbo_company_id;
        $data['supplier_id'] = $request->cbo_supplier_id;

        if ($request->txt_from_date && $request->txt_to_date) {
            $data['check'] = 1;
            $data['from_date'] = $request->txt_from_date;
            $data['to_date'] = $request->txt_to_date;
        } else {
            $data['check'] = 2;
        }


        $ci_product  = DB::table("pro_product_$company_id")
            ->where('valid', 1)
            ->get();

        return view('inventory.rpt_product_supply_rr', compact('ci_product', 'data'));
    }

    public function RptProductIssue()
    {
        return view('inventory.rpt_product_issue');
    }

    //Report Product wise stock list
    public function RptProductIssueList(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'cbo_product_group' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'cbo_product_group.required' => 'Select Product Group.',
            'cbo_product_group.integer' => 'Select Product Group.',
            'cbo_product_group.between' => 'Select Product Group.',

            'txt_from_date.required' => 'Select From Date.',
            'txt_to_date.required' => 'Select To Date.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;


        $m_from_date = $request->txt_from_date;
        $m_to_date = $request->txt_to_date;

        $ci_product  = DB::table("pro_product_$company_id")
            ->where('product_id', $request->cbo_product)
            ->where('valid', 1)
            ->get();
        $pro_product_group = DB::table("pro_product_group_$company_id")->get();
        return view('inventory.rpt_product_issue', compact('company_id', 'ci_product', 'm_from_date', 'm_to_date', 'pro_product_group'));
    }

    //Finish Product Stock Master
    public function FinishProductStockMaster()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();

        $pro_project_name = DB::table('pro_project_name')->get();
        $pro_section_information = DB::table('pro_section_information')->get();
        return view('inventory.fpsm', compact('pro_project_name', 'pro_section_information', 'user_company'));
    }

    public function FinishProductStockMasterStore(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99',
            'cbo_pg_id' => 'required|integer|between:1,99',
            'cbo_pg_sub_id' => 'required|integer|between:1,99999',
            'txt_stock_date' => 'required',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',
            'cbo_pg_id.required' => 'Product Group field is required!',
            'cbo_pg_id.integer' => 'Product Group field is required!',
            'cbo_pg_id.between' => 'Product Group field is required!',
            'cbo_pg_sub_id.required' => 'Product Sub Group field is required!',
            'cbo_pg_sub_id.integer' => 'Product Sub Group field is required!',
            'cbo_pg_sub_id.between' => 'Product Sub Group field is required!',
            'txt_stock_date.required' => 'Stock Date field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $m_entry_date = date("Y-m-d");

        $m_company = DB::table('pro_company')
            ->where('company_id', $request->cbo_company_id)
            ->where('valid', 1)
            ->first();
        $company_short_name = "$m_company->short_code";

        $m_fpsm = DB::table("pro_fpsm_$request->cbo_company_id")
            ->orderByDesc("fpsm_id")
            ->first();

        if (isset($m_fpsm)) {
            $m_fpsm_id = "$company_short_name" . date("Ym") . str_pad((substr($m_fpsm->fpsm_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $m_fpsm_id = "$company_short_name" . date("Ym") . "00001";
        }

        $data = array();
        $data['fpsm_id'] = $m_fpsm_id;
        $data['fpsm_date'] = $request->txt_stock_date;
        $data['company_id'] = $request->cbo_company_id;
        $data['pg_id'] = $request->cbo_pg_id;
        $data['pg_sub_id'] = $request->cbo_pg_sub_id;
        $data['remarks'] = $request->txt_remarks;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = $m_entry_date;
        $data['entry_time'] = date("h:i:sa");
        $data['status'] = 1;
        $data['valid'] = 1;

        DB::table("pro_fpsm_$request->cbo_company_id")->insert($data);

        return redirect()->route('FinishProductDetails', [$m_fpsm_id, $request->cbo_company_id]);
    }

    public function FinishProductDetails($id, $id2)
    {
        $m_fpsm = DB::table("pro_fpsm_$id2")
            ->leftjoin('pro_company', "pro_fpsm_$id2.company_id", 'pro_company.company_id')
            ->leftjoin("pro_product_group_$id2", "pro_fpsm_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_fpsm_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->select(
                "pro_fpsm_$id2.*",
                'pro_company.company_name',
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
            )
            ->where("pro_fpsm_$id2.fpsm_id", '=', $id)
            ->where("pro_fpsm_$id2.status", '1')
            ->first();

        $m_fpsd = DB::table("pro_fpsd_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_fpsd_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_fpsd_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftJoin("pro_finish_product_$id2", "pro_fpsd_$id2.product_id", "pro_finish_product_$id2.product_id")
            ->leftJoin('pro_units', "pro_fpsd_$id2.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_fpsd_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_finish_product_$id2.product_name",
                "pro_finish_product_$id2.product_description",
                'pro_units.unit_name',
            )
            ->where("pro_fpsd_$id2.fpsm_id", '=', $id)
            ->where("pro_fpsd_$id2.status", '1')
            ->get();

        $m_finish_product = DB::table("pro_finish_product_$id2")
            ->where('pg_id', $m_fpsm->pg_id)
            ->where('pg_sub_id', $m_fpsm->pg_sub_id)
            ->where('valid', '1')
            ->get();

        return view('inventory.fpsd', compact('m_fpsm', 'id2', 'm_finish_product', 'm_fpsd'));
    }

    public function FinishProductDetailsStore(Request $request, $id2)
    {
        $rules = [
            'cbo_product_id' => 'required|integer|between:1,99999999',
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'cbo_product_id.required' => 'product field is required!',
            'cbo_product_id.integer' => 'product field is required!',
            'cbo_product_id.between' => 'product field is required!',
            'txt_qty.required' => 'Qunatity is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;
        $m_entry_date = date("Y-m-d");

        $data = array();
        $data['fpsm_id'] = $request->txt_fpsm_id;
        $data['fpsm_date'] = $request->txt_fpsm_date;
        $data['company_id'] = $id2;
        $data['product_id'] = $request->cbo_product_id;
        $data['pg_id'] = $request->cbo_pg_id;
        $data['pg_sub_id'] = $request->cbo_pg_sub_id;
        $data['product_unit'] = $request->txt_unit_id;
        $data['qty'] = $request->txt_qty;
        $data['user_id'] = $m_user_id;
        $data['entry_date'] = $m_entry_date;
        $data['entry_time'] = date("h:i:sa");
        $data['status'] = 1;
        $data['valid'] = 1;
        DB::table("pro_fpsd_$id2")->insert($data);
        return redirect()->route('FinishProductDetails', [$request->txt_fpsm_id, $id2]);
    }

    public function FinishProductDetailsEdit($id, $id2)
    {
        $m_fpsd_edit = DB::table("pro_fpsd_$id2")
            ->leftjoin("pro_product_group_$id2", "pro_fpsd_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_fpsd_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->leftJoin("pro_finish_product_$id2", "pro_fpsd_$id2.product_id", "pro_finish_product_$id2.product_id")
            ->leftJoin('pro_units', "pro_fpsd_$id2.product_unit", 'pro_units.unit_id')
            ->select(
                "pro_fpsd_$id2.*",
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
                "pro_finish_product_$id2.product_name",
                "pro_finish_product_$id2.product_description",
                'pro_units.unit_id',
                'pro_units.unit_name',
            )
            ->where("pro_fpsd_$id2.fpsd_id", '=', $id)
            ->where("pro_fpsd_$id2.status", '=', 1)
            ->where("pro_fpsd_$id2.valid", '=', 1)
            ->first();

        $m_fpsm_edit = DB::table("pro_fpsm_$id2")
            ->leftjoin('pro_company', "pro_fpsm_$id2.company_id", 'pro_company.company_id')
            ->leftjoin("pro_product_group_$id2", "pro_fpsm_$id2.pg_id", "pro_product_group_$id2.pg_id")
            ->leftjoin("pro_product_sub_group_$id2", "pro_fpsm_$id2.pg_sub_id", "pro_product_sub_group_$id2.pg_sub_id")
            ->select(
                "pro_fpsm_$id2.*",
                'pro_company.company_id',
                'pro_company.company_name',
                "pro_product_group_$id2.pg_name",
                "pro_product_sub_group_$id2.pg_sub_name",
            )

            ->where("pro_fpsm_$id2.fpsm_id", '=', $m_fpsd_edit->fpsm_id)
            ->first();

        $m_finish_product = DB::table("pro_finish_product_$id2")
            ->where('pg_id', $m_fpsm_edit->pg_id)
            ->where('pg_sub_id', $m_fpsm_edit->pg_sub_id)
            ->where('valid', '1')
            ->get();

        return view('inventory.fpsd', compact('m_fpsm_edit', 'm_fpsd_edit', 'm_finish_product'));
    }

    public function FinishProductDetailsUpdate(Request $request, $id, $id2)
    {
        $rules = [
            'cbo_product_id' => 'required|integer|between:1,99999999',
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'cbo_product_id.required' => 'product field is required!',
            'cbo_product_id.integer' => 'product field is required!',
            'cbo_product_id.between' => 'product field is required!',
            'txt_qty.required' => 'Qunatity is required!',

        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['product_id'] = $request->cbo_product_id;
        $data['qty'] = $request->txt_qty;
        DB::table("pro_fpsd_$id2")
            ->where('fpsd_id', $id)
            ->update($data);
        return redirect()->route('FinishProductDetails', [$request->txt_fpsm_id, $id2]);
    }

    public function FinishProductDetailsFinal($id, $id2)
    {
        DB::table("pro_fpsd_$id2")
            ->where('fpsm_id', '=', $id)
            ->update(['status' => 2]);
        DB::table("pro_fpsm_$id2")
            ->where('fpsm_id', '=', $id)
            ->update(['status' => 2]);
        return redirect()->route('fpsm');
    }






    //Ajax call

    public function GetRPTMaterialReturnList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_gmaterial_return_master_$company_id")
                ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_section_information', "pro_gmaterial_return_master_$company_id.section_id", 'pro_section_information.section_id')
                ->select(
                    "pro_gmaterial_return_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_section_information.section_name',
                )
                ->where("pro_gmaterial_return_master_$company_id.company_id", $company_id)
                // ->whereBetween("pro_gmaterial_return_master_$company_id.entry_date", [$form, $to])
                ->where("pro_gmaterial_return_master_$company_id.status", 2)
                ->orderBy("pro_gmaterial_return_master_$company_id.return_master_no", "desc")
                ->get();
        } else {
            $data = DB::table("pro_gmaterial_return_master_$company_id")
                ->leftJoin('pro_project_name', "pro_gmaterial_return_master_$company_id.project_id", 'pro_project_name.project_id')
                ->leftJoin('pro_section_information', "pro_gmaterial_return_master_$company_id.section_id", 'pro_section_information.section_id')
                ->select(
                    "pro_gmaterial_return_master_$company_id.*",
                    'pro_project_name.project_name',
                    'pro_section_information.section_name',
                )
                ->where("pro_gmaterial_return_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_gmaterial_return_master_$company_id.entry_date", [$form, $to])
                ->where("pro_gmaterial_return_master_$company_id.status", 2)
                ->orderBy("pro_gmaterial_return_master_$company_id.return_master_no", "desc")
                ->get();
        }
        return response()->json($data);
    }


    // list of rr
    public function GetSupplyAddress($id,$company_id)
    {
        $data = DB::table("pro_supplier_information_$company_id")->where('supplier_id', $id)->first();
        return json_encode($data);
    }

    public function GetInvProductSubGroup($pg_id, $indent_no, $grr_no, $id2)
    {

        $grr_product_sub_id = DB::table("pro_grr_details_$id2")
            ->where('grr_no', $grr_no)
            // ->where('indent_no', $indent_no)
            ->where('pg_id', $pg_id)
            ->pluck('product_id');

        $product_sub_id = DB::table("pro_indent_details_$id2")
            ->whereNotIn('product_id', $grr_product_sub_id)
            ->where('indent_no', '=', $indent_no)
            ->where('pg_id', '=', $pg_id)
            ->where('rr_status', 1)
            ->pluck('pg_sub_id');

        $data =  DB::table("pro_product_sub_group_$id2")->whereIn('pg_sub_id', $product_sub_id)->get();

        return json_encode($data);
    }

    public function GetInvProduct($pg_sub_id, $indent_no, $grr_no, $id2)
    {
        $grr_product_id = DB::table("pro_grr_details_$id2")
            ->where('grr_no', '=', $grr_no)
            // ->where('indent_no', '=', $indent_no)
            ->pluck('product_id');

        $product_id = DB::table("pro_indent_details_$id2")
            ->where('indent_no', '=', $indent_no)
            ->whereNotIn('product_id', $grr_product_id)
            ->where('pg_sub_id', '=', $pg_sub_id)
            ->where('rr_status', '=', '1')
            ->pluck('product_id');
        $data =  DB::table("pro_product_$id2")->whereIn('product_id', $product_id)->get();
        return json_encode($data);
    }

    //quantity
    public function GetIndentQty($product_id, $indent_no, $id2)
    {
        $data3 = DB::table("pro_indent_details_$id2")
            ->where('indent_no', '=', $indent_no)
            ->where('product_id', '=', $product_id)
            // ->where('rr_status', '=', '0')
            ->first();

        $data2 = DB::table("pro_grr_details_$id2")
            ->where('indent_no', '=', $indent_no)
            ->where('product_id', '=', $product_id)
            // ->where('rr_status', '=', '0')
            ->sum('received_qty');
        // $txt_bal_qty=number_format($data2,4);
        $txt_bal_qty = round($data2, 4);

        $data = array();
        $data['remarks'] = $data3->remarks;
        $data['approved_qty'] = $data3->approved_qty;
        $data['rr_qty'] = $txt_bal_qty;

        return json_encode($data);
    }

    //unit name
    public function GetProductUnit($product_id, $id2)
    {
        $product = DB::table("pro_product_$id2")
            ->where('product_id', '=', $product_id)
            ->first();

        $data = DB::table('pro_units')
            ->where('unit_id', '=', $product->unit)
            ->first();

        return json_encode($data);
    }
    //end list of rr


    //issue
    public function GetIssueSubGroup($pg_id, $mrm_no, $rim_no, $company_id)
    {
        $product_id = DB::table("pro_graw_issue_details_$company_id")
            ->where('rim_no', $rim_no)
            ->where('pg_id', $pg_id)
            ->where('status', '=', 1)
            ->pluck('product_id');

        $g_pg_sub_id = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', $mrm_no)
            ->where('pg_id', $pg_id)
            ->whereNotIn('product_id', $product_id)
            ->where('issue_status', 1)
            ->pluck('pg_sub_id');

        $data =  DB::table("pro_product_sub_group_$company_id")->whereIn('pg_sub_id', $g_pg_sub_id)->get();

        return json_encode($data);
    }

    public function GetIssueProductGroup($pg_sub_id, $mrm_no, $rim_no, $company_id)
    {
        $issu_product =  DB::table("pro_graw_issue_details_$company_id")
            ->where('rim_no', $rim_no)
            ->where('pg_sub_id', $pg_sub_id)
            ->where('status', '=', 1)
            ->pluck('product_id');

        $product_id = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->where('mrm_no', '=', $mrm_no)
            ->where('pg_sub_id', '=', $pg_sub_id)
            ->whereNotIn('product_id', $issu_product)
            ->where('issue_status', '=', 1)
            ->pluck('product_id');

        $data =  DB::table("pro_product_$company_id")->whereIn('product_id', $product_id)->get();

        return json_encode($data);
    }

    public function GetIssueQtyDetails($product_id, $mrm_no, $company_id)
    {
        $data = DB::table("pro_gmaterial_requsition_details_$company_id")
            ->leftJoin('pro_units', "pro_gmaterial_requsition_details_$company_id.product_unit", 'pro_units.unit_id')
            ->select("pro_gmaterial_requsition_details_$company_id.*", 'pro_units.unit_name')
            ->where("pro_gmaterial_requsition_details_$company_id.mrm_no", $mrm_no)
            ->where("pro_gmaterial_requsition_details_$company_id.product_id", $product_id)
            ->first();

        // $req = round($data->requsition_qty,4);
        // $issu = round($data->issue_qty,4);

        $data1 = array();
        $data1['requsition_qty'] = $data->approved_qty;
        $data1['issue_qty'] = $data->issue_qty;
        $data1['unit_name'] = $data->unit_name;
        // $data1['total']=round(($req-$issu),4);
        $data1['total'] = round(($data->requsition_qty - $data->issue_qty), 4);

        return response()->json($data1);
    }

    public function GetIssueTotalStock($product_id, $mrm_no, $company_id)
    {

        $mentrydate = time();
        $m_current_date = date("Y-m-d", $mentrydate);
        $m_current_year = date("Y", $mentrydate);
        // $m_current_month = date("m", $mentrydate);
        $m_current_month = '07';

        $txt_start_date = "$m_current_year-$m_current_month-01";
        // $txt_start_date="2023-07-01";
        $txt_end_date = "$m_current_date";
        // $txt_end_date="2023-07-31";

        $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($txt_start_date)));
        $closing_year = substr($closing_date, 0, 4);
        $closing_month = substr($closing_date, 5, 2);

        $table_name = "pro_stock_closing_" . "$closing_year$closing_month" . "_$company_id";

        $ci_stock_closing  = DB::table("$table_name")
            ->where("product_id", $product_id)
            ->where("year", $closing_year)
            ->where("month", $closing_month)
            ->sum('qty');

        if ($ci_stock_closing === NULL) {
            $txt_clossing_stock = "0.0000";
        } else {
            $txt_clossing_stock = round($ci_stock_closing, 4);
        }


        $m_total_grr_qty = DB::table("pro_grr_details_$company_id")
            // ->where('mrm_no', '=', $mrm_no)
            ->where('product_id', '=', $product_id)
            ->whereBetween('grr_date', [$txt_start_date, $txt_end_date])
            ->where('valid', 1)
            ->sum('received_qty');
        $total_grr_qty = round($m_total_grr_qty, 4);
        $m_mrmissueqty = DB::table("pro_graw_issue_details_$company_id")
            // ->where('mrm_no', '=', $mrm_no)
            ->where('product_id', '=', $product_id)
            ->whereBetween('rim_date', [$txt_start_date, $txt_end_date])
            ->where('valid', 1)
            ->sum('product_qty');
        $mrmissueqty = round($m_mrmissueqty, 4);

        $m_mrmreturnqty = DB::table("pro_gmaterial_return_details_$company_id")
            // ->where('mrm_no', '=', $mrm_no)
            ->where('product_id', '=', $product_id)
            ->whereBetween('return_date', [$txt_start_date, $txt_end_date])
            ->where('valid', 1)
            ->sum('useable_qty');
        $mrmreturnqty = round($m_mrmreturnqty, 4);
        $data =  $txt_clossing_stock + $total_grr_qty -  $mrmissueqty + $mrmreturnqty;
        // $data =  "$ci_stock_closing";
        // $m_data=round($data,4);
        // dd($ci_stock_closing);
        return json_encode($data);
    }

    //RPT Finish Product Stock
    public function rpt_finish_product_stock()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', 1)
            ->get();
        return view('inventory.rpt_finish_product_stock', compact('user_company'));
    }

    public function rpt_finish_product_stock_view(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'txt_from_date.required' => 'Select From Date.',
            'txt_to_date.required' => 'Select To Date.',

        ];
        $this->validate($request, $rules, $customMessages);
        $company_id = $request->cbo_company_id;
        $pg_id = $request->cbo_pg_id;
        $m_from_date = $request->txt_from_date;
        $m_to_date = $request->txt_to_date;
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', 1)
            ->get();
        $m_unit = DB::table('pro_units')->Where('valid', '1')->orderBy('unit_name', 'desc')->get(); //query builder

        $data = DB::table("pro_finish_product_$company_id")
            ->leftjoin("pro_product_group_$company_id", "pro_finish_product_$company_id.pg_id", "pro_product_group_$company_id.pg_id")
            ->leftjoin("pro_product_sub_group_$company_id", "pro_finish_product_$company_id.pg_sub_id", "pro_product_sub_group_$company_id.pg_sub_id")
            ->leftJoin('pro_units', "pro_finish_product_$company_id.unit", 'pro_units.unit_id')
            ->select("pro_finish_product_$company_id.*", 'pro_units.unit_name', "pro_product_group_$company_id.pg_name", "pro_product_sub_group_$company_id.pg_sub_name");


        if ($request->cbo_pg_id && $request->cbo_pg_sub_id == null) {
            $product = $data->where("pro_finish_product_$company_id.pg_id", $request->cbo_pg_id)->get();
        } elseif ($request->cbo_pg_sub_id && $request->cbo_product_id == null) {
            $product = $data->where("pro_finish_product_$company_id.pg_sub_id", $request->cbo_pg_sub_id)->get();
        } elseif ($request->cbo_product_id) {
            $product = $data->where("pro_finish_product_$company_id.product_id", $request->cbo_product_id)->get();
        } else {
            $product = $data->get();
        }
        return view('inventory.rpt_finish_product_stock_view', compact('user_company', 'm_from_date', 'm_to_date', 'company_id', 'pg_id', 'product'));
    }

    public function rpt_fps_details($product_id, $company_id, $form, $to)
    {
        $m_finish_product = DB::table("pro_finish_product_$company_id")->where('product_id', $product_id)->first();
        $my_date = array();
        $newDate = $form;
        while (strtotime($newDate) <= strtotime($to)) {
            array_push($my_date, $newDate);
            $newDate = date("Y-m-d", strtotime($newDate . " +1 day"));
        }
        return view('inventory.rpt_fps_details', compact('my_date', 'm_finish_product', 'company_id'));
    }

    public function GetInvFinishProductSubGroup($id, $id2)
    {
        $data = DB::table("pro_product_sub_group_$id2")->where('pg_id', $id)->get();
        return json_encode($data);
    }

    public function GetInvFinishProduct($id, $id2)
    {
        $data = DB::table("pro_finish_product_$id2")->where('pg_sub_id', $id)->get();
        return json_encode($data);
    }
    //End RPT Finish Product Stock



    //Return 
    public function GetReturnProductSubGroup($pg_id, $id2)
    {
        $data =  DB::table("pro_product_sub_group_$id2")->where('pg_id', $pg_id)->get();
        return json_encode($data);
    }

    public function GetReturnProduct($pg_sub_id, $id2)
    {
        $data = DB::table("pro_product_$id2")
            ->where('pg_sub_id', $pg_sub_id)
            ->get();

        return json_encode($data);
    }

    public function GetMaterialReturnProduct($pg_sub_id, $return_master_no, $company_id)
    {
        if ($return_master_no == 0) {
            $return_product_id = [];
        } else {
            $return_product_id = DB::table("pro_gmaterial_return_details_$company_id")->where('return_master_no', $return_master_no)->pluck('product_id');
        }

        $data = DB::table("pro_product_$company_id")
            ->whereNotIn('product_id', $return_product_id)
            ->where('pg_sub_id', $pg_sub_id)
            ->get();

        return json_encode($data);
    }

    public function GetReturnProductDetails($product_id, $id2)
    {
        $product =  DB::table("pro_product_$id2")->where('product_id', $product_id)->first();
        $data = DB::table('pro_units')->where('unit_id', $product->unit)->first();

        return json_encode($data);
    }

    // inventory- get product name 
    public function GetProductName($id)
    {
        $data = DB::table('pro_product')->where('product_id', $id)->first();
        return json_encode($data);
    }

    //end Ajax















    //Ajax call

 


    //Get- Product Sub Group
    public function GetPgSub($id, $id2)
    {
        $data = DB::table("pro_product_sub_group_$id2")
            ->where('valid', '1')
            ->where('pg_id', $id)
            ->get();
        return json_encode($data);
    }
}
