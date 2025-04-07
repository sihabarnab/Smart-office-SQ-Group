<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ITBackOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

//Supplier
    public function itsupp()
    {
        $data=DB::table('pro_suppliers')->Where('valid','1')->orderBy('supplier_id', 'asc')->get(); //query builder
        return view('itinventory.supplier_info',compact('data'));

        // return view('hrm.company');
    }

    public function supplier_info_store(Request $request)
    {
        $rules = [
            'txt_supplier_name' => 'required',
            'txt_supplier_add' => 'required',
            'txt_supplier_phone' => 'required',
            'txt_contact_person' => 'required',
                ];
        $customMessages = [
            'txt_supplier_name.required' => 'Supplier Name is required.',
            'txt_supplier_add.required' => 'Supplier Address is required.',
            'txt_supplier_phone.required' => 'Supplier Phone is required.',
            'txt_contact_person.required' => 'Contact Person is required.'
        ];        
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_suppliers')->where('supplier_name', $request->txt_supplier_name)->where('supplier_add', $request->txt_supplier_add)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['supplier_name']=$request->txt_supplier_name;
        $data['supplier_add']=$request->txt_supplier_add;
        $data['supplier_phone']=$request->txt_supplier_phone;
        $data['contact_person']=$request->txt_contact_person;
        $data['valid']=$m_valid;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        // dd($data);
        DB::table('pro_suppliers')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function supplier_infoedit($id)
    {
        
        $m_supplier_info=DB::table('pro_suppliers')->where('supplier_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_suppliers')->Where('valid','1')->orderBy('supplier_id', 'desc')->get();
        return view('itinventory.supplier_info',compact('data','m_supplier_info'));
    }

    public function itsupplier_infoupdate(Request $request,$update)
    {

    $rules = [
            'txt_supplier_name' => 'required',
            'txt_supplier_add' => 'required',
            'txt_supplier_phone' => 'required',
            'txt_contact_person' => 'required',
        ];

        $customMessages = [

            'txt_supplier_name.required' => 'Supplier Name is required.',
            'txt_supplier_add.required' => 'Supplier Address is required.',
            'txt_supplier_phone.required' => 'Supplier Phone is required.',
            'txt_contact_person.required' => 'Contact Person is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_suppliers')->where('supplier_id',$update)->update([
            'supplier_name'=>$request->txt_supplier_name,
            'supplier_add'=>$request->txt_supplier_add,
            'supplier_phone'=>$request->txt_supplier_phone,
            'contact_person'=>$request->txt_contact_person,

            ]);

        return redirect(route('supplier_info'))->with('success','Data Updated Successfully!');

    }

    public function itproduct_type()
    {
        $data=DB::table('pro_product_type')->Where('valid','1')->orderBy('product_type_id', 'asc')->get(); //query builder
        return view('itinventory.product_type',compact('data'));
    }

    public function itproduct_type_store(Request $request)
    {
        $rules = [
            'txt_product_type_name' => 'required',
            'txt_product_short_name' => 'required',
                ];
        $customMessages = [
            'txt_product_type_name.required' => 'Product Type Name is required.',
            'txt_product_short_name.required' => 'Product Short Name is required.',
        ];        
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_product_type')->where('product_type_name', $request->txt_product_type_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['product_type_name']=strtoupper($request->txt_product_type_name);
        $data['product_short_name']=strtoupper($request->txt_product_short_name);
        $data['employee_id']=$request->txt_user_id;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_product_type')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function itproduct_typeedit($id)
        {
            
            $m_product_type=DB::table('pro_product_type')->where('product_type_id',$id)->first();
            $data=DB::table('pro_product_type')->Where('valid','1')->orderBy('product_type_id', 'desc')->get();
            return view('itinventory.product_type',compact('data','m_product_type'));
        }

    public function itproduct_typeupdate(Request $request,$update)
    {
    $rules = [
            'txt_product_type_name' => 'required',
            'txt_product_short_name' => 'required',
        ];

        $customMessages = [

            'txt_product_type_name.required' => 'Product Type is required.',
            'txt_product_short_name.required' => 'Product Short Name is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_product_type')->where('product_type_id',$update)->update([
            'product_type_name'=>strtoupper($request->txt_product_type_name),
            'product_short_name'=>strtoupper($request->txt_product_short_name),
            ]);

        return redirect(route('product_type'))->with('success','Data Updated Successfully!');

    }

    public function itbrand()
    {
        $data=DB::table('pro_brands')->Where('valid','1')->orderBy('brand_id', 'asc')->get(); //query builder
        return view('itinventory.brand',compact('data'));
    }

    public function itbrand_store(Request $request)
    {
        $rules = [
            'txt_brand_name' => 'required'
                ];
        $customMessages = [
            'txt_brand_name.required' => 'Brand Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_brands')->where('brand_name', $request->txt_brand_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['brand_name']=$request->txt_brand_name;
        $data['employee_id']=$request->txt_user_id;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_brands')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function itbrandedit($id)
        {
            
            $m_brand=DB::table('pro_brands')->where('brand_id',$id)->first();
            $data=DB::table('pro_brands')->Where('valid','1')->orderBy('brand_id', 'desc')->get();
            return view('itinventory.brand',compact('data','m_brand'));
        }

    public function itbrandupdate(Request $request,$update)
    {
    $rules = [
            'txt_brand_name' => 'required',
        ];

        $customMessages = [

            'txt_brand_name.required' => 'Brand Name is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_brands')->where('brand_id',$update)->update([
            'brand_name'=>$request->txt_brand_name,
            ]);

        return redirect(route('brand'))->with('success','Data Updated Successfully!');

    }

    public function itprocessor()
    {
        $data=DB::table('pro_processors')->Where('valid','1')->orderBy('processor_id', 'asc')->get(); //query builder
        return view('itinventory.processor',compact('data'));
    }

    public function itprocessor_store(Request $request)
    {
        $rules = [
            'txt_processor_name' => 'required'
                ];
        $customMessages = [
            'txt_processor_name.required' => 'Processor is required.'
        ];        
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_processors')->where('processor_name', $request->txt_processor_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['processor_name']=$request->txt_processor_name;
        $data['employee_id']=$request->txt_user_id;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_processors')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function itprocessoredit($id)
        {
            
            $m_processor=DB::table('pro_processors')->where('processor_id',$id)->first();
            $data=DB::table('pro_processors')->Where('valid','1')->orderBy('processor_id', 'desc')->get();
            return view('itinventory.processor',compact('data','m_processor'));
        }

    public function itprocessorupdate(Request $request,$update)
    {
    $rules = [
            'txt_processor_name' => 'required',
        ];

        $customMessages = [

            'txt_processor_name.required' => 'Processor is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_processors')->where('processor_id',$update)->update([
            'processor_name'=>$request->txt_processor_name,
            ]);

        return redirect(route('processor'))->with('success','Data Updated Successfully!');

    }

    public function itasset()
    {

        $companies = DB::table('pro_company')
        ->where('valid','1')
        ->get();

        $m_suppliers = DB::table('pro_suppliers')
        ->where('valid','1')
        ->get();

        $m_product_type = DB::table('pro_product_type')
        ->where('valid','1')
        ->get();

        $m_brand = DB::table('pro_brands')
        ->where('valid','1')
        ->get();

        $m_processor = DB::table('pro_processors')
        ->where('valid','1')
        ->get();

        $data=DB::table('pro_itassets')->Where('valid','1')->orderBy('id', 'asc')->get(); //query builder
        return view('itinventory.it_asset',compact('data','companies','m_suppliers','m_product_type','m_brand','m_processor'));
    }

    public function itasset_store(Request $request)
    {
        $rules = [
            'sele_company_id' => 'required|integer|between:1,10000',
            'sele_supplier_id' => 'required|integer|between:1,10000',
            'txt_sinv_no' => 'required',
            'txt_sinv_date' => 'required',
            'sele_product_type_id' => 'required|integer|between:1,10000',
            'sele_brand_id' => 'required|integer|between:1,10000',
            'txt_model' => 'required',
            // 'sele_processor_id' => 'required|integer|between:1,10000',
            // 'txt_ram' => 'required',
            // 'txt_hdd' => 'required',
            // 'txt_ssd' => 'required',
            // 'txt_display' => 'required',
            // 'txt_serial' => 'required',
            // 'sele_yesno_id' => 'required|integer|between:1,10000',
            // 'txt_warranty_year' => 'required',
            'txt_amount' => 'required',

                ];
        $customMessages = [
            'sele_company_id.required' => 'Select Company.',
            'sele_company_id.integer' => 'Select Company.',
            'sele_company_id.between' => 'Select Company.',

            'sele_supplier_id.required' => 'Select Supplier.',
            'sele_supplier_id.integer' => 'Select Supplier.',
            'sele_supplier_id.between' => 'Select Supplier.',

            'txt_sinv_no.required' => 'Invoice Number required.',
            'txt_sinv_date.required' => 'Invoice Date required.',

            'sele_product_type_id.required' => 'Select Product Type.',
            'sele_product_type_id.integer' => 'Select Product Type.',
            'sele_product_type_id.between' => 'Select Product Type.',

            'sele_brand_id.required' => 'Select Brand.',
            'sele_brand_id.integer' => 'Select Brand.',
            'sele_brand_id.between' => 'Select Brand.',

            'txt_model.required' => 'Model required.',

            // 'sele_processor_id.required' => 'Select Processor Type.',
            // 'sele_processor_id.integer' => 'Select Processor Type.',
            // 'sele_processor_id.between' => 'Select Processor Type.',

            // 'txt_ram.required' => 'RAM required.',
            // 'txt_hdd.required' => 'HDD required.',
            // 'txt_ssd.required' => 'SSD required.',
            // 'txt_display.required' => 'Display required.',
            // 'txt_serial.required' => 'Serial required.',

            // 'sele_yesno_id.required' => 'Warranty yes or no.',
            // 'sele_yesno_id.integer' => 'Warranty yes or no.',
            // 'sele_yesno_id.between' => 'Warranty yes or no.',

            // 'txt_warranty_year.required' => 'Warranty Time.',
            'txt_amount.required' => 'Asset Price.',

        ];        
        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;
        $abcd = DB::table('pro_product_type')->where('product_type_name', $request->txt_product_type_name)->first();

        $ci_product_type=DB::table('pro_product_type')->Where('product_type_id',$request->sele_product_type_id)->first();
        $txt_product_short_name=$ci_product_type->product_short_name;

        $m_id = DB::table('pro_itassets')->max('id');
        // $m_itasset_id = DB::table('pro_itassets')->max('itasset_id');
        // $txt_itasset_id=$m_itasset_id;
        // $txt_itasset_id=$m_id->itasset_id;
        // dd($m_id);
        if ($m_id === null)
        {

            $txt_itasset_id = 1;
            $m_itasset_id=str_pad($txt_itasset_id, 8, '0', STR_PAD_LEFT); // returns 04

        } else {

            //$txt_itasset_id = $m_itasset_id;
            // $txt_itasset_id = $m_id;
            // $x=substr($m_id,4,8);
            $xx=$m_id+1;
            $m_itasset_id=str_pad($xx, 8, '0', STR_PAD_LEFT);
        }

        // dd("$txt_product_short_name-$m_itasset_id");
        $txt_itasset_id="$txt_product_short_name-$m_itasset_id";
        // dd("$m_id-$txt_itasset_id");
        $m_valid='1';
        $data=array();
        $data['itasset_id']=$txt_itasset_id;
        $data['company_id']=$request->sele_company_id;
        $data['supplier_id']=$request->sele_supplier_id;
        $data['sinv_no']=$request->txt_sinv_no;
        $data['sinv_date']=$request->txt_sinv_date;
        $data['product_type_id']=$request->sele_product_type_id;
        $data['brand_id']=$request->sele_brand_id;
        $data['model']=$request->txt_model;
        $data['processor_id']=$request->sele_processor_id;
        $data['ram']=$request->txt_ram;
        $data['hdd']=$request->txt_hdd;
        $data['ssd']=$request->txt_ssd;
        $data['display']=$request->txt_display;
        $data['serial']=$request->txt_serial;
        $data['warranty']=$request->sele_yesno_id;
        $data['warranty_year']=$request->txt_warranty_year;
        $data['amount']=$request->txt_amount;
        $data['employee_id']=$m_user_id;
        $data['valid']=$m_valid;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        $data['remarks']=$request->txt_remarks;
        // dd($data);
        DB::table('pro_itassets')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
    }

    public function it_assetedit($id)
    {
        
        $m_itasset=DB::table('pro_itassets')->where('itasset_id',$id)->first();
        $data=DB::table('pro_itassets')->Where('valid','1')->orderBy('itasset_id', 'desc')->get();
        $m_pro_company = DB::table('pro_company')->Where('valid','1')->get();

        $m_suppliers = DB::table('pro_suppliers')
        ->where('valid','1')
        ->get();

        $m_product_type = DB::table('pro_product_type')
        ->where('valid','1')
        ->get();

        $m_brand = DB::table('pro_brands')
        ->where('valid','1')
        ->get();

        $m_processor = DB::table('pro_processors')
        ->where('valid','1')
        ->get();

        $m_yesno = DB::table('pro_yesno')
        ->where('valid','1')
        ->get();

        return view('itinventory.it_asset',compact('data','m_itasset','m_pro_company','m_suppliers','m_product_type','m_brand','m_processor','m_yesno'));
    }

    public function it_assetupdate(Request $request,$update)
    {
        $rules = [
            'sele_company_id' => 'required|integer|between:1,10000',
            'sele_supplier_id' => 'required|integer|between:1,10000',
            'txt_sinv_no' => 'required',
            // 'txt_sinv_date' => 'required',
            'sele_product_type_id' => 'required|integer|between:1,10000',
            'sele_brand_id' => 'required|integer|between:1,10000',
            'txt_model' => 'required',
            // 'sele_processor_id' => 'required|integer|between:1,10000',
            // 'txt_ram' => 'required',
            // 'txt_hdd' => 'required',
            // 'txt_ssd' => 'required',
            // 'txt_display' => 'required',
            // 'txt_serial' => 'required',
            // 'sele_yesno_id' => 'required|integer|between:1,10000',
            // 'txt_warranty_year' => 'required',
            'txt_amount' => 'required',

                ];
        $customMessages = [
            'sele_company_id.required' => 'Select Company.',
            'sele_company_id.integer' => 'Select Company.',
            'sele_company_id.between' => 'Select Company.',

            'sele_supplier_id.required' => 'Select Supplier.',
            'sele_supplier_id.integer' => 'Select Supplier.',
            'sele_supplier_id.between' => 'Select Supplier.',

            'txt_sinv_no.required' => 'Invoice Number required.',
            // 'txt_sinv_date.required' => 'Invoice Date required.',

            'sele_product_type_id.required' => 'Select Product Type.',
            'sele_product_type_id.integer' => 'Select Product Type.',
            'sele_product_type_id.between' => 'Select Product Type.',

            'sele_brand_id.required' => 'Select Brand.',
            'sele_brand_id.integer' => 'Select Brand.',
            'sele_brand_id.between' => 'Select Brand.',

            'txt_model.required' => 'Model required.',

            // 'sele_processor_id.required' => 'Select Processor Type.',
            // 'sele_processor_id.integer' => 'Select Processor Type.',
            // 'sele_processor_id.between' => 'Select Processor Type.',

            // 'txt_ram.required' => 'RAM required.',
            // 'txt_hdd.required' => 'HDD required.',
            // 'txt_ssd.required' => 'SSD required.',
            // 'txt_display.required' => 'Display required.',
            // 'txt_serial.required' => 'Serial required.',

            // 'sele_yesno_id.required' => 'Warranty yes or no.',
            // 'sele_yesno_id.integer' => 'Warranty yes or no.',
            // 'sele_yesno_id.between' => 'Warranty yes or no.',

            // 'txt_warranty_year.required' => 'Warranty Time.',
            'txt_amount.required' => 'Asset Price.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        DB::table('pro_itassets')->where('itasset_id',$update)->update([
            'company_id'=>$request->sele_company_id,
            'supplier_id'=>$request->sele_supplier_id,
            'sinv_no'=>$request->txt_sinv_no,
            'sinv_date'=>$request->txt_sinv_date,
            'product_type_id'=>$request->sele_product_type_id,
            'brand_id'=>$request->sele_brand_id,
            'model'=>$request->txt_model,
            'processor_id'=>$request->sele_processor_id,
            'ram'=>$request->txt_ram,
            'hdd'=>$request->txt_hdd,
            'ssd'=>$request->txt_ssd,
            'display'=>$request->txt_display,
            'serial'=>$request->txt_serial,
            'warranty'=>$request->sele_yesno_id,
            'warranty_year'=>$request->txt_warranty_year,
            'amount'=>$request->txt_amount,
            'remarks'=>$request->txt_remarks,
            'employee_id'=>$m_user_id,
            ]);

        return redirect(route('it_asset'))->with('success','Data Updated Successfully!');

    }
  
    public function GetItAsset()
    {

        $data = DB::table('pro_itassets')
        ->leftjoin("pro_company", "pro_itassets.company_id", "pro_company.company_id")
        ->leftjoin("pro_suppliers", "pro_itassets.supplier_id", "pro_suppliers.supplier_id")
        // ->leftjoin("pro_product_sub_group", "pro_product.pg_sub_id", "pro_product_sub_group.pg_sub_id")
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
        ->leftjoin("pro_processors", "pro_itassets.processor_id", "pro_processors.processor_id")
        ->leftjoin("pro_yesno", "pro_itassets.warranty", "pro_yesno.yesno_id")

        ->select(
            "pro_itassets.*",
            "pro_company.company_name",
            "pro_suppliers.supplier_name",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
            "pro_processors.processor_name",
            "pro_yesno.yesno_name"
        )
        // ->Where('pro_product.product_category', '1')
        ->Where('pro_itassets.valid', '1')
        // ->orderBy('product_id', 'desc')
        ->get();    
        // $data='aaaaaaaaaaaa';
        return json_encode($data);
    }


    public function ItAssetIssue()
    {

        $m_company = DB::table('pro_company')
        ->where('valid','1')
        ->get();

        $m_placeofposting = DB::table('pro_placeofposting')
        ->where('valid','1')
        ->get();

        $mm_itasset = DB::table('pro_itassets')
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")

        ->select(
            "pro_itassets.*",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
        )

        ->where('pro_itassets.valid','1')
        ->where('pro_itassets.issue_status','1')
        ->get();

        return view('itinventory.it_asset_issue',compact('m_company','m_placeofposting','mm_itasset'));

    }

    public function ItAssetIssueStore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            // 'cbo_employee_id' => 'required|integer|between:1,10000',
            'cbo_placeofposting_id' => 'required|integer|between:1,1000',
            'cbo_it_asset_id' => 'required',
            'txt_issue_date' => 'required',

                ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_placeofposting_id.required' => 'Select Place of Posting.',
            'cbo_placeofposting_id.integer' => 'Select Place of Posting.',
            'cbo_placeofposting_id.between' => 'Select Place of Posting.',

            // 'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'cbo_it_asset_id.required' => 'Select Asset.',

            'txt_issue_date.required' => 'Issue Date required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        // dd("$txt_product_short_name-$m_itasset_id");
        $m_valid='1';
        $data=array();
        $data['company_id']=$request->cbo_company_id;
        $data['placeofposting_id']=$request->cbo_placeofposting_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['itasset_id']=$request->cbo_it_asset_id;
        $data['issue_date']=$request->txt_issue_date;
        $data['remarks']=$request->txt_remarks;
        $data['valid']=$m_valid;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        // dd($data);
        DB::table('pro_itasset_issue')->insert($data);

        $m_issue_status='2';
        DB::table('pro_itassets')->where('itasset_id',$request->cbo_it_asset_id)->update([
            'issue_status'=>$m_issue_status,
            ]);

        return redirect()->back()->with('success',"$request->cbo_it_asset_id Asset Issue to $request->cbo_employee_id");

    }

    public function GetItAssetIssueList()
    {

        $data = DB::table('pro_itasset_issue')
        ->leftjoin("pro_company", "pro_itasset_issue.company_id", "pro_company.company_id")
        ->leftjoin("pro_placeofposting", "pro_itasset_issue.placeofposting_id", "pro_placeofposting.placeofposting_id")
        ->leftjoin("pro_employee_info", "pro_itasset_issue.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_itassets", "pro_itasset_issue.itasset_id", "pro_itassets.itasset_id")
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
        // ->leftjoin("pro_processors", "pro_itassets.processor_id", "pro_processors.processor_id")
        // ->leftjoin("pro_yesno", "pro_itassets.warranty", "pro_yesno.yesno_id")

        ->select(
            "pro_itasset_issue.*",
            "pro_company.company_name",
            "pro_employee_info.employee_name",
            "pro_itassets.model",
            "pro_itassets.ram",
            "pro_itassets.hdd",
            "pro_itassets.ssd",
            "pro_itassets.display",
            "pro_itassets.serial",
            "pro_itassets.warranty_year",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
            "pro_placeofposting.placeofposting_name",
            // "pro_yesno.yesno_name"
            // "it_asset.model as model_name",

        )
        ->Where('pro_itasset_issue.valid', '1')
        ->get();    
        return json_encode($data);
    }

    public function ItAssetIssueEdit($id)
    {
        
        $m_itasset_issue=DB::table('pro_itasset_issue')->where('itasset_issue_id',$id)->first();

        $m_company = DB::table('pro_company')
        ->where('valid','1')
        ->get();

        $m_placeofposting = DB::table('pro_placeofposting')
        ->where('valid','1')
        ->get();

        $m_employee_info = DB::table('pro_employee_info')
        ->where('valid','1')
        ->get();

        // $m_itassets = DB::table('pro_itassets')
        // ->where('valid','1')
        // ->get();


        $m_itassets = DB::table('pro_itassets')
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")

        ->select(
            "pro_itassets.*",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
        )

        ->where('pro_itassets.valid','1')
        // ->where('pro_itassets.issue_status','1')
        ->get();

        return view('itinventory.it_asset_issue',compact('m_itasset_issue','m_company','m_placeofposting','m_employee_info','m_itassets'));
    }

    public function ItAssetIssueUpdate(Request $request,$update)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_placeofposting_id' => 'required|integer|between:1,1000',
            'cbo_it_asset_id' => 'required',
            'txt_issue_date' => 'required',

                ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_placeofposting_id.required' => 'Select Place of Posting.',
            'cbo_placeofposting_id.integer' => 'Select Place of Posting.',
            'cbo_placeofposting_id.between' => 'Select Place of Posting.',

            'cbo_it_asset_id.required' => 'Select Asset.',

            'txt_issue_date.required' => 'Issue Date required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        DB::table('pro_itasset_issue')->where('itasset_issue_id',$update)->update([
            'company_id'=>$request->cbo_company_id,
            'placeofposting_id'=>$request->cbo_placeofposting_id,
            'employee_id'=>$request->cbo_employee_id,
            'itasset_id'=>$request->cbo_it_asset_id,
            'issue_date'=>$request->txt_issue_date,
            'remarks'=>$request->txt_remarks,
            ]);

        return redirect(route('it_asset_issue'))->with('success','Data Updated Successfully!');

    }

    //ItAssetReceived
    public function ItAssetReceived()
    {

        $m_company = DB::table('pro_company')
            ->where('valid', '1')
            ->get();

        $m_placeofposting = DB::table('pro_placeofposting')
            ->where('valid', '1')
            ->get();

        return view('itinventory.it_asset_received', compact('m_company', 'm_placeofposting'));
    }

    public function ItAssetReceivedStore(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_placeofposting_id' => 'required',
            'cbo_employee_id' => 'required',
            'cbo_it_asset_id' => 'required',
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',
            'cbo_placeofposting_id.required' => 'Place of Posting is required!',
            'cbo_employee_id.required' => 'Employee is required!',
            'cbo_it_asset_id.required' => 'IT Asset is required!',
            'txt_qty.required' => 'Asset Quantity is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['company_id'] = $request->cbo_company_id;
        $data['placeofposting_id'] = $request->cbo_placeofposting_id;
        $data['employee_id'] = $request->cbo_employee_id;
        $data['desig_id'] = $request->txt_desig_id;
        $data['department_id'] = $request->txt_department_id;
        $data['remarks'] = $request->txt_remarks;
        $data['valid'] = 1;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        DB::table('pro_itasset_receiving_master')->insert($data);


        $last_receiving_master = DB::table('pro_itasset_receiving_master')
            ->max('itasset_receiving_master_id');
        $txt_last_receiving_master_id = "$last_receiving_master";

        $data1 = array();
        $data1['itasset_receiving_master_id'] = $txt_last_receiving_master_id;
        $data1['company_id'] = $request->cbo_company_id;
        $data1['placeofposting_id'] = $request->cbo_placeofposting_id;
        $data1['employee_id'] = $request->cbo_employee_id;
        $data1['desig_id'] = $request->txt_desig_id;
        $data1['department_id'] = $request->txt_department_id;
        $data1['itasset_id'] = $request->cbo_it_asset_id;
        $data1['itasset_qty'] = $request->txt_qty;
        $data1['remarks'] = $request->txt_remarks;
        $data1['valid'] = 1;
        $data1['entry_date'] = date("Y-m-d");
        $data1['entry_time'] = date("h:i:sa");
        DB::table('pro_itasset_receving_details')->insert($data1);

        DB::table('pro_itasset_issue')
        ->where('employee_id',$request->cbo_employee_id)
        ->where('itasset_id',$request->cbo_it_asset_id)
        ->update(['received_status'=>'2']);

        return redirect()->route('ItAssetReceivedDetails', $txt_last_receiving_master_id);
    }


    public function ItAssetReceivedDetails($id)
    {

        $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
            ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
            ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
            ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
            ->select(
                "pro_itasset_receiving_master.*",
                'pro_company.company_name',
                'pro_placeofposting.placeofposting_name',
                'pro_employee_info.*',
                'pro_desig.desig_name',
                'pro_department.department_name',
            )
            ->where("pro_itasset_receiving_master.itasset_receiving_master_id", '=', $id)
            ->first();


        $m_itasset_receving_details = DB::table("pro_itasset_receving_details")
            ->leftjoin("pro_itassets", "pro_itasset_receving_details.itasset_id", "pro_itassets.itasset_id")
            ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
            ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
            ->select(
                "pro_itasset_receving_details.*",
                'pro_itassets.*',
                "pro_product_type.product_type_name",
                "pro_brands.brand_name",

            )
            ->where("pro_itasset_receving_details.itasset_receiving_master_id", '=', $id)
            ->get();

        $m_itasset_issue = DB::table('pro_itasset_issue')
            ->leftjoin("pro_itassets", "pro_itasset_issue.itasset_id", "pro_itassets.itasset_id")
            ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
            ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
            ->select(
                "pro_itasset_issue.*",
                "pro_itassets.*",
                "pro_product_type.product_type_name",
                "pro_brands.brand_name",
            )

            // ->where('pro_itasset_issue.return_status', '1')
            // ->where('pro_itasset_issue.itasset_id', $m_itasset_receving_details->itasset_id)
            ->where('pro_itasset_issue.received_status', '1')
            ->where('pro_itasset_issue.employee_id', $m_itasset_receiving_master->employee_id)
            ->get();


        return view('itinventory.it_asset_received_details', compact('m_itasset_receiving_master', 'm_itasset_issue', 'm_itasset_receving_details'));
    }



    public function ItAssetReceivedDetailsStore(Request $request, $id)
    {

        $rules = [
            'cbo_it_asset_id' => 'required',
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'cbo_it_asset_id.required' => 'IT Asset is required!',
            'txt_qty.required' => 'Asset Quantity is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
            ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
            ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
            ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
            ->select(
                "pro_itasset_receiving_master.*",
                'pro_company.company_name',
                'pro_placeofposting.placeofposting_name',
                'pro_employee_info.*',
                'pro_desig.desig_name',
                'pro_department.department_name',
            )
            ->where("pro_itasset_receiving_master.itasset_receiving_master_id", '=', $id)
            ->first();

        $data1 = array();
        $data1['itasset_receiving_master_id'] = $id;
        $data1['company_id'] = $m_itasset_receiving_master->company_id;
        $data1['placeofposting_id'] = $m_itasset_receiving_master->placeofposting_id;
        $data1['employee_id'] = $m_itasset_receiving_master->employee_id;
        $data1['desig_id'] = $m_itasset_receiving_master->desig_id;
        $data1['department_id'] = $m_itasset_receiving_master->department_id;
        $data1['itasset_id'] = $request->cbo_it_asset_id;
        $data1['itasset_qty'] = $request->txt_qty;
        $data1['remarks'] = $request->txt_remarks;
        $data1['valid'] = 1;
        $data1['entry_date'] = date("Y-m-d");
        $data1['entry_time'] = date("h:i:sa");
        DB::table('pro_itasset_receving_details')->insert($data1);
        return back()->with('success', 'Add Successfull !');
        // return redirect()->route('ItAssetReceivedDetails', $id);
    }


    public function ItAssetReceivedDetailsEdit($id)
    {
        $m_itasset_receving_details_edit = DB::table("pro_itasset_receving_details")
            ->leftjoin("pro_itassets", "pro_itasset_receving_details.itasset_id", "pro_itassets.itasset_id")
            ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
            ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
            ->select(
                "pro_itasset_receving_details.*",
                'pro_itassets.*',
                "pro_product_type.product_type_name",
                "pro_brands.brand_name",

            )
            ->where("pro_itasset_receving_details.itasset_receiving_details_id", '=', $id)
            ->first();

        $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
            ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
            ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
            ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
            ->select(
                "pro_itasset_receiving_master.*",
                'pro_company.company_name',
                'pro_placeofposting.placeofposting_name',
                'pro_employee_info.*',
                'pro_desig.desig_name',
                'pro_department.department_name',
            )
            ->where("pro_itasset_receiving_master.itasset_receiving_master_id", '=', $m_itasset_receving_details_edit->itasset_receiving_master_id)
            ->first();

        $m_itasset_issue = DB::table('pro_itasset_issue')
            ->leftjoin("pro_itassets", "pro_itasset_issue.itasset_id", "pro_itassets.itasset_id")
            ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
            ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
            ->select(
                "pro_itasset_issue.*",
                "pro_itassets.*",
                "pro_product_type.product_type_name",
                "pro_brands.brand_name",
            )

            // ->where('pro_itasset_issue.received_status', '1')
            ->where('pro_itasset_issue.employee_id', $m_itasset_receiving_master->employee_id)
            ->get();


        return view('itinventory.it_asset_received_details', compact('m_itasset_receiving_master', 'm_itasset_issue', 'm_itasset_receving_details_edit'));
    }

    public function ItAssetReceivedDetailsUpdate(Request $request, $id)
    {

        $rules = [
            'cbo_it_asset_id' => 'required',
            'txt_qty' => 'required',
        ];

        $customMessages = [
            'cbo_it_asset_id.required' => 'IT Asset is required!',
            'txt_qty.required' => 'Asset Quantity is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_itasset_receving_details_edit = DB::table("pro_itasset_receving_details")
        ->where("itasset_receiving_details_id", $id)
        ->first();
        
        DB::table('pro_itasset_issue')
        ->where('employee_id',$request->cbo_employee_id)
        ->where('itasset_id',$m_itasset_receving_details_edit->itasset_id)
        ->update(['received_status'=>'1']);

        // $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
        //     ->where("itasset_receiving_master_id", $m_itasset_receving_details_edit->itasset_receiving_master_id)
        //     ->first();

        $data1 = array();
        $data1['itasset_id'] = $request->cbo_it_asset_id;
        $data1['itasset_qty'] = $request->txt_qty;

        DB::table('pro_itasset_receving_details')->where("itasset_receiving_details_id", $id)->update($data1);

        DB::table('pro_itasset_issue')
        ->where('employee_id',$request->cbo_employee_id)
        ->where('itasset_id',$request->cbo_it_asset_id)
        ->update(['received_status'=>'2']);

        return redirect()->route('ItAssetReceivedDetails', $m_itasset_receving_details_edit->itasset_receiving_master_id);
    }

    public function ItAssetReceivedFinal($id)
    {
        // $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
        //     ->where("itasset_receiving_master_id", $id)
        //     ->first();
        // ->update(['']);

    return redirect()->route('rpt_it_asset_received_view',$id);

    }

    public function RptItAssetReceived()
    { 
            return view('itinventory.rpt_it_asset_received');
        
    }

    public function RptItAssetReceivedView($id)
    { 
        $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
        ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
        ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
        ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
        ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
        ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
        ->select(
            "pro_itasset_receiving_master.*",
            'pro_company.company_name',
            'pro_placeofposting.placeofposting_name',
            'pro_employee_info.employee_name',
            'pro_employee_info.mobile',
            'pro_desig.desig_name',
            'pro_department.department_name',
        )
        ->where("pro_itasset_receiving_master.itasset_receiving_master_id", $id)
        ->first();

        $m_itasset_receving_details = DB::table("pro_itasset_receving_details")
        ->leftjoin("pro_itassets", "pro_itasset_receving_details.itasset_id", "pro_itassets.itasset_id")
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
        ->select(
            "pro_itasset_receving_details.*",
            'pro_itassets.*',
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",

        )
        ->where("pro_itasset_receving_details.itasset_receiving_master_id", '=', $id)
        ->get();

        return view('itinventory.rpt_it_asset_received_view',compact('m_itasset_receiving_master','m_itasset_receving_details'));
        
    }
    public function RptItAssetReceivedPrint($id)
    { 
        $m_itasset_receiving_master = DB::table("pro_itasset_receiving_master")
        ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
        ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
        ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
        ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
        ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
        ->select(
            "pro_itasset_receiving_master.*",
            'pro_company.company_name',
            'pro_placeofposting.placeofposting_name',
            'pro_employee_info.employee_name',
            'pro_employee_info.mobile',
            'pro_desig.desig_name',
            'pro_department.department_name',
        )
        ->where("pro_itasset_receiving_master.itasset_receiving_master_id", $id)
        ->first();

        $m_itasset_receving_details = DB::table("pro_itasset_receving_details")
        ->leftjoin("pro_itassets", "pro_itasset_receving_details.itasset_id", "pro_itassets.itasset_id")
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
        ->select(
            "pro_itasset_receving_details.*",
            'pro_itassets.*',
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",

        )
        ->where("pro_itasset_receving_details.itasset_receiving_master_id", '=', $id)
        ->get();

        return view('itinventory.rpt_it_asset_received_print',compact('m_itasset_receiving_master','m_itasset_receving_details'));
        
    }

    public function RptItAssetReceivedList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_itasset_receiving_master")
            ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
            ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
            ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
            ->select(
                "pro_itasset_receiving_master.*",
                'pro_company.company_name',
                'pro_placeofposting.placeofposting_name',
                'pro_employee_info.employee_name',
                'pro_desig.desig_name',
                'pro_department.department_name',
            )
            ->where('pro_itasset_receiving_master.company_id',$company_id)
            ->get();

        } else {
            $data = DB::table("pro_itasset_receiving_master")
            ->leftjoin('pro_company', "pro_itasset_receiving_master.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_itasset_receiving_master.employee_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_placeofposting', "pro_itasset_receiving_master.placeofposting_id", 'pro_placeofposting.placeofposting_id')
            ->leftjoin('pro_desig', "pro_itasset_receiving_master.desig_id", 'pro_desig.desig_id')
            ->leftjoin('pro_department', "pro_itasset_receiving_master.department_id", 'pro_department.department_id')
            ->select(
                "pro_itasset_receiving_master.*",
                'pro_company.company_name',
                'pro_placeofposting.placeofposting_name',
                'pro_employee_info.*',
                'pro_desig.desig_name',
                'pro_department.department_name',
            )
            ->whereBetween("pro_itasset_receiving_master.entry_date", [$form, $to])
            ->where('pro_itasset_receiving_master.company_id',$company_id)
            ->get();
        }
        return response()->json($data);
        
    }


    public function ItAssetReturn()
    {

        $m_company = DB::table('pro_company')
        ->where('valid','1')
        ->get();

        $m_placeofposting = DB::table('pro_placeofposting')
        ->where('valid','1')
        ->get();

        $m_yesno = DB::table('pro_yesno')
        ->where('valid','1')
        ->get();

        $mm_itasset = DB::table('pro_itassets')
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")

        ->select(
            "pro_itassets.*",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
        )

        ->where('pro_itassets.valid','1')
        ->where('pro_itassets.issue_status','1')
        ->get();

        return view('itinventory.it_asset_return',compact('m_company','m_placeofposting','mm_itasset','m_yesno'));

    }

    public function ItAssetReturnStore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_placeofposting_id' => 'required|integer|between:1,1000',
            'txt_return_date' => 'required',

                ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_placeofposting_id.required' => 'Select Place of Posting.',
            'cbo_placeofposting_id.integer' => 'Select Place of Posting.',
            'cbo_placeofposting_id.between' => 'Select Place of Posting.',

            'txt_return_date.required' => 'Issue Date required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        // dd("$txt_product_short_name-$m_itasset_id");
        $m_valid='1';
        $data=array();
        $data['company_id']=$request->cbo_company_id;
        $data['placeofposting_id']=$request->cbo_placeofposting_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['itasset_id']=$request->cbo_it_asset_id;
        $data['return_date']=$request->txt_return_date;
        $data['remarks']=$request->txt_remarks;
        $data['reusable']=$request->cbo_reusable;
        $data['valid']=$m_valid;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        // dd($data);
        DB::table('pro_itasset_return')->insert($data);

        $m_reusable=$request->cbo_reusable;
        if ($m_reusable=='1')
        {
        DB::table('pro_itassets')->where('itasset_id',$request->cbo_it_asset_id)->update([
            'issue_status'=>'1',
            ]);
        DB::table('pro_itasset_issue')->where('itasset_id',$request->cbo_it_asset_id)->update([
            'return_status'=>'2',
            ]);

        } else {
        DB::table('pro_itassets')->where('itasset_id',$request->cbo_it_asset_id)->update([
            'issue_status'=>'3',
            ]);           
        DB::table('pro_itasset_issue')->where('itasset_id',$request->cbo_it_asset_id)->update([
            'return_status'=>'2',
            ]);
        }
        return redirect()->back()->with('success',"$request->cbo_it_asset_id Asset Return from $request->cbo_employee_id");
    }




    public function IpMacInfo()
    {

        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_product_type = DB::table('pro_product_type')
        ->where('valid','1')
        ->get();

        $m_wifilan = DB::table('pro_wifilan')
        ->where('valid','1')
        ->get();

        return view('itinventory.ip_mac_info',compact('user_company','m_product_type','m_wifilan'));

    }

    public function ItIpMacStore(Request $request)
    {
        // return $request;

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_employee_id' => 'required',
            'cbo_product_type_id' => 'required|integer|between:1,1000',
            'cbo_wifilan_id' => 'required|integer|between:1,10',
            'txt_ip' => 'required',
            'txt_mac' => 'required',

                ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'cbo_product_type_id.required' => 'Select Device.',
            'cbo_product_type_id.integer' => 'Select Device.',
            'cbo_product_type_id.between' => 'Select Device.',

            'cbo_wifilan_id.required' => 'Select Connection Type.',
            'cbo_wifilan_id.integer' => 'Select Connection Type.',
            'cbo_wifilan_id.between' => 'Select Connection Type.',

            'txt_ip.required' => 'IP Address required.',
            'txt_mac.required' => 'Mac required.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // return $request;

        $m_user_id=Auth::user()->emp_id;

        // dd("$txt_product_short_name-$m_itasset_id");
        $m_valid='1';
        $data=array();
        $data['company_id']=$request->cbo_company_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['product_type_id']=$request->cbo_product_type_id;
        $data['wifilan_id']=$request->cbo_wifilan_id;
        $data['ip']=$request->txt_ip;
        $data['mac']=$request->txt_mac;
        $data['description']=$request->txt_description;
        $data['valid']=$m_valid;
        $data['entry_date']=date('Y-m-d');
        $data['entry_time']=date('H:i:s');
        // dd($data);
        DB::table('pro_ipmac_info')->insert($data);

        return redirect()->back()->with('success',"$request->cbo_employee_id IP Mac Information add successfully");

    }

    public function ItIpMacEdit($id)
    {

        $m_user_id=Auth::user()->emp_id;
        
        $m_ipmac_info=DB::table('pro_ipmac_info')->where('ipmac_info_id',$id)->first();
        // return response()->json($data);

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_product_type = DB::table('pro_product_type')
        ->where('valid','1')
        ->get();

        $m_product_type_01 = DB::table('pro_product_type')
        ->where('product_type_id',$m_ipmac_info->product_type_id)
        ->first();

        $m_wifilan = DB::table('pro_wifilan')
        ->where('valid','1')
        ->get();

        $m_wifilan_01 = DB::table('pro_wifilan')
        ->where('wifilan_id',$m_ipmac_info->wifilan_id)
        ->first();

        $m_employee_info = DB::table('pro_employee_info')
        ->where('employee_id',$m_ipmac_info->employee_id)
        ->where('valid','1')
        ->first();

        return view('itinventory.ip_mac_info',compact('m_ipmac_info','user_company','m_product_type','m_wifilan','m_employee_info','m_product_type_01','m_wifilan_01'));
    }

    public function ItIpMacUpdate(Request $request,$update)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_employee_id' => 'required',
            'cbo_product_type_id' => 'required|integer|between:1,1000',
            'cbo_wifilan_id' => 'required|integer|between:1,10',
            'txt_ip' => 'required',
            'txt_mac' => 'required',

                ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Select Employee.',

            'cbo_product_type_id.required' => 'Select Device.',
            'cbo_product_type_id.integer' => 'Select Device.',
            'cbo_product_type_id.between' => 'Select Device.',

            'cbo_wifilan_id.required' => 'Select Connection Type.',
            'cbo_wifilan_id.integer' => 'Select Connection Type.',
            'cbo_wifilan_id.between' => 'Select Connection Type.',

            'txt_ip.required' => 'IP Address required.',
            'txt_mac.required' => 'Mac required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        // $ci_ipmac_info = DB::table('pro_ipmac_info')->where('mac', $request->txt_mac)->where('mac','<>',$update)->first();
        // dd($ci_ipmac_info);
        
        // if ($ci_ipmac_info === null)
        // {

        DB::table('pro_ipmac_info')->where('ipmac_info_id',$update)->update([
            'company_id'=>$request->cbo_company_id,
            'employee_id'=>$request->cbo_employee_id,
            'product_type_id'=>$request->cbo_product_type_id,
            'wifilan_id'=>$request->cbo_wifilan_id,
            'ip'=>$request->txt_ip,
            'mac'=>$request->txt_mac,
            'description'=>$request->txt_description,
            ]);

        return redirect(route('ip_mac_info'))->with('success','Data Updated Successfully!');
        // } else {
        // return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        // }

    }

    public function RptItAsset()
    {

        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_product_type = DB::table('pro_product_type')
        ->where('valid','1')
        ->get();

        return view('itinventory.rpt_it_asset',compact('user_company','m_product_type'));

    }

    //Report Product wise stock list
    public function RptItAssetList(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            // 'cbo_product_type_id' => 'required|integer|between:1,10000',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            // 'cbo_product_type_id.required' => 'Select Product Type.',
            // 'cbo_product_type_id.integer' => 'Select Product Type.',
            // 'cbo_product_type_id.between' => 'Select Product Type.',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_product_type = DB::table('pro_product_type')
        ->where('valid','1')
        ->get();

        if($request->cbo_product_type_id=='0')
        {
        $ci_itassets  = DB::table('pro_itassets')
        ->leftJoin('pro_company', 'pro_itassets.company_id', 'pro_company.company_id')
        ->leftJoin('pro_suppliers', 'pro_itassets.supplier_id', 'pro_suppliers.supplier_id')
        ->leftJoin('pro_product_type', 'pro_itassets.product_type_id', 'pro_product_type.product_type_id')
        ->leftJoin('pro_brands', 'pro_itassets.brand_id', 'pro_brands.brand_id')
        ->leftJoin('pro_processors', 'pro_itassets.processor_id', 'pro_processors.processor_id')
        ->select('pro_itassets.*', 'pro_company.company_name','pro_suppliers.supplier_name','pro_product_type.product_type_name','pro_brands.brand_name','pro_processors.processor_name')
        ->where('pro_itassets.company_id',$request->cbo_company_id)
        ->where('pro_itassets.valid',1)
        ->get();

        } else {

        $ci_itassets  = DB::table('pro_itassets')
        ->leftJoin('pro_company', 'pro_itassets.company_id', 'pro_company.company_id')
        ->leftJoin('pro_suppliers', 'pro_itassets.supplier_id', 'pro_suppliers.supplier_id')
        ->leftJoin('pro_product_type', 'pro_itassets.product_type_id', 'pro_product_type.product_type_id')
        ->leftJoin('pro_brands', 'pro_itassets.brand_id', 'pro_brands.brand_id')
        ->leftJoin('pro_processors', 'pro_itassets.processor_id', 'pro_processors.processor_id')
        ->select('pro_itassets.*', 'pro_company.company_name','pro_suppliers.supplier_name','pro_product_type.product_type_name','pro_brands.brand_name','pro_processors.processor_name')
        ->where('pro_itassets.company_id',$request->cbo_company_id)
        ->where('pro_itassets.product_type_id',$request->cbo_product_type_id)
        ->where('pro_itassets.valid',1)
        ->get();           
        }
        return view('itinventory.rpt_it_asset', compact('ci_itassets','user_company','m_product_type'));
    }



    //Ajax call get- Employee
    public function GetEmployee2($id)
    {
        $data = DB::table('pro_employee_info')
        ->where('working_status', '1')
        // ->where('ss', '1')
        ->where('company_id', $id)
        ->get();
        return json_encode($data);
    }

    public function GetEmployee3($id,$id2)
    {
        $data = DB::table('pro_employee_info')
        ->where('working_status', '1')
        // ->where('ss', '1')
        ->where('placeofposting_id', $id)
        ->where('company_id', $id2)
        ->get();
        if($data)
        {
           return response()->json($data); 
        }
    }

    public function GetAsset($id)
    {
        $data = DB::table('pro_itasset_issue')
        ->where('return_status', '1')
        ->where('employee_id', $id)
        ->get();
        return json_encode($data);
    }

    public function GetIssueAsset($id)
    {
        $data = DB::table('pro_itasset_issue')
        ->where('return_status', '1')
        ->where('employee_id', $id)
        ->get();
        return json_encode($data);
    }

    public function GetItAssetReturnList()
    {

        $data = DB::table('pro_itasset_return')
        ->leftjoin("pro_company", "pro_itasset_return.company_id", "pro_company.company_id")
        ->leftjoin("pro_placeofposting", "pro_itasset_return.placeofposting_id", "pro_placeofposting.placeofposting_id")
        ->leftjoin("pro_employee_info", "pro_itasset_return.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_itassets", "pro_itasset_return.itasset_id", "pro_itassets.itasset_id")
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
        // ->leftjoin("pro_processors", "pro_itassets.processor_id", "pro_processors.processor_id")
        ->leftjoin("pro_yesno", "pro_itasset_return.reusable", "pro_yesno.yesno_id")

        ->select(
            "pro_itasset_return.*",
            "pro_company.company_name",
            "pro_employee_info.employee_name",
            "pro_itassets.model",
            "pro_itassets.ram",
            "pro_itassets.hdd",
            "pro_itassets.ssd",
            "pro_itassets.display",
            "pro_itassets.serial",
            "pro_itassets.warranty_year",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
            "pro_placeofposting.placeofposting_name",
            "pro_yesno.yesno_name"
            // "it_asset.model as model_name",

        )
        ->Where('pro_itasset_return.valid', '1')
        ->get();    
        return json_encode($data);
    }

    public function GetAssetReceived($id)
    {
        $data = DB::table('pro_itasset_issue')
        ->leftjoin("pro_itassets", "pro_itasset_issue.itasset_id", "pro_itassets.itasset_id")
        ->leftjoin("pro_product_type", "pro_itassets.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_brands", "pro_itassets.brand_id", "pro_brands.brand_id")
        ->select(
            "pro_itasset_issue.*",
            "pro_itassets.*",
            "pro_product_type.product_type_name",
            "pro_brands.brand_name",
        )

        // ->where('pro_itasset_issue.return_status', '1')
        ->where('pro_itasset_issue.received_status', '1')
        ->where('pro_itasset_issue.employee_id', $id)
        ->get();
        return json_encode($data);
    }

    public function GetAssetEmpInfo($id1)
    {
        $data11 = DB::table('pro_employee_info')
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        ->select(
            "pro_employee_info.*",
            "pro_desig.desig_name",
            "pro_department.department_name",
        )

        ->where('pro_employee_info.employee_id', $id1)
        ->first();
        return json_encode($data11);
    }


    public function GetIPMacList()
    {
        $data = DB::table('pro_ipmac_info')
        ->leftjoin("pro_company", "pro_ipmac_info.company_id", "pro_company.company_id")
        ->leftjoin("pro_employee_info", "pro_ipmac_info.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_product_type", "pro_ipmac_info.product_type_id", "pro_product_type.product_type_id")
        ->leftjoin("pro_wifilan", "pro_ipmac_info.wifilan_id", "pro_wifilan.wifilan_id")
        // ->join("pro_units", "pro_product.unit", "pro_units.unit_id")
        ->select(
            "pro_ipmac_info.*",
            "pro_company.company_name",
            "pro_employee_info.employee_name",
            "pro_product_type.product_type_name",
            "pro_wifilan.wifilan_name",
        )
        ->Where('pro_ipmac_info.valid', '1')
        ->orderBy('pro_ipmac_info.employee_id', 'desc')
        ->get();    
        return json_encode($data);
    }


}
