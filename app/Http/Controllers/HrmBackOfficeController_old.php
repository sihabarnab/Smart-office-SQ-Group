<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


// use sqlsrv;
// use Illuminate\Http\Request;
// use DB;

class HrmBackOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

// private $m_user_id=Auth::user()->emp_id;
// public $m_user_id=33;

//Company
    public function hrmbackcompany()
    {
        $data=DB::table('pro_company')->Where('valid','1')->orderBy('company_id', 'asc')->get(); //query builder
        return view('hrm.company',compact('data'));

        // return view('hrm.company');
    }

    public function hrmbackcompanystore(Request $request)
    {
        $rules = [
            'txt_company_name' => 'required',
            'txt_company_address' => 'required',
            'txt_company_zip' => 'required',
            'txt_company_city' => 'required',
            'txt_company_country' => 'required',
            'txt_company_phone' => 'required',
            'txt_company_mobile' => 'required',
            'txt_company_email' => 'required',
            'txt_company_url' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_company_name.required' => 'Company Name is required.',
            'txt_company_address.required' => 'Address is required.',
            'txt_company_zip.required' => 'Zip is required.',
            'txt_company_city.required' => 'City is required.',
            'txt_company_country.required' => 'Country is required.',
            'txt_company_phone.required' => 'Phone is required.',
            'txt_company_mobile.required' => 'Mobile is required.',
            'txt_company_email.required' => 'E-mail is required.',
            'txt_company_url.required' => 'URL is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_company')->where('company_name', $request->txt_company_name)->first();
        //dd($abcd);

        
        
        if ($abcd === null)
        {
        $m_valid='1';

        $data=array();
        $data['company_name']=$request->txt_company_name;
        $data['company_add']=$request->txt_company_address;
        $data['company_zip']=$request->txt_company_zip;
        $data['company_city']=$request->txt_company_city;
        $data['company_country']=$request->txt_company_country;
        $data['company_phone']=$request->txt_company_phone;
        $data['company_mobile']=$request->txt_company_mobile;
        $data['company_email']=$request->txt_company_email;
        $data['company_url']=$request->txt_company_url;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_company')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function hrmbackcompanyedit($id)
    {
        
        $m_company=DB::table('pro_company')->where('company_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_company')->Where('valid','1')->orderBy('company_id', 'desc')->get();
        return view('hrm.company',compact('data','m_company'));
    }

public function hrmbackcompanyupdate(Request $request)
    {      
        DB::table('pro_company')->where('company_id',$request->txt_company_id)->update([
            'company_name'=>$request->txt_company_name,
            'company_add'=>$request->txt_company_address,
            'company_zip'=>$request->txt_company_zip,
            'company_city'=>$request->txt_company_city,
            'company_country'=>$request->txt_company_country,
            'company_phone'=>$request->txt_company_phone,
            'company_mobile'=>$request->txt_company_mobile,
            'company_email'=>$request->txt_company_email,
            'company_url'=>$request->txt_company_url,
            'last_entry_date'=>date('Y-m-d'),
            'last_entry_time'=>date('H:i:s')
        ]);
        return redirect(route('company'))->with('success','Data Updated Successfully!');
    }


//Designation
        public function hrmbackdesignation()
    {
        $data=DB::table('pro_desig')->Where('valid','1')->orderBy('desig_id', 'desc')->get(); //query builder
        return view('hrm.designation',compact('data'));
    }

    public function hrmbackdesignationstore(Request $request)
    {
        $rules = [
            'txt_desig_name' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_desig_name.required' => 'Designation Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_desig')->where('desig_name', $request->txt_desig_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['desig_name']=$request->txt_desig_name;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_desig')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function hrmbackdesignationedit($id)
    {
        
        $m_desig=DB::table('pro_desig')->where('desig_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_desig')->Where('valid','1')->orderBy('desig_id', 'desc')->get();
        return view('hrm.designation',compact('data','m_desig'));
    }

public function hrmbackdesignationupdate(Request $request)
    {      
        DB::table('pro_desig')->where('desig_id',$request->txt_desig_id)->update([
            'desig_name'=>$request->txt_desig_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('designation'))->with('success','Data Updated Successfully!');
    }



//department

    public function hrmbackdepartment()
    {
    $data=DB::table('pro_department')->Where('valid','1')->orderBy('department_id', 'desc')->get(); //query builder
        return view('hrm.department',compact('data'));
    }
    public function hrmbackdepartmentstore(Request $request)
    {
        $rules = [
            'txt_department_name' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_department_name.required' => 'Department Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_department')->where('department_name', $request->txt_department_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['department_name']=$request->txt_department_name;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_department')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

public function hrmbackdepartmentedit($id)
    { 
        $m_dept=DB::table('pro_department')->where('department_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_department')->Where('valid','1')->orderBy('department_id', 'desc')->get();
        return view('hrm.department',compact('data','m_dept'));
    }

public function hrmbackdepartmentupdate(Request $request)
    {      
        DB::table('pro_department')->where('department_id',$request->txt_department_id)->update([
            'department_name'=>$request->txt_department_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('department'))->with('success','Data Updated Successfully!');
    }

//section

    public function hrmbacksection()
    {
        $data=DB::table('pro_section')->Where('valid','1')->orderBy('section_id', 'desc')->get(); //query builder
        return view('hrm.section',compact('data'));
        // return view('hrm.section');
    }
    public function hrmbacksectionstore(Request $request)
    {
        $rules = [
            'txt_section_name' => 'required'
                ];
        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        $customMessages1 = [
            'txt_section_name.required' => 'Section Name is required.'
        ];        
        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('pro_section')->where('section_name', $request->txt_section_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['section_name']=$request->txt_section_name;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_section')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }
    public function hrmbacksectionedit($id)
    { 
        $m_sec=DB::table('pro_section')->where('section_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_section')->Where('valid','1')->orderBy('section_id', 'desc')->get();
        return view('hrm.section',compact('data','m_sec'));
    }
    public function hrmbacksectionupdate(Request $request)
    {      
        DB::table('pro_section')->where('section_id',$request->txt_section_id)->update([
            'section_name'=>$request->txt_section_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('section'))->with('success','Data Updated Successfully!');
    }

//place of posting

    public function hrmbackplaceposting()
    {
        $data=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_id', 'desc')->get(); //query builder
        return view('hrm.placeposting',compact('data'));

        // return view('hrm.placeposting');

    }
    public function hrmbackplace_postingstore(Request $request)
    {
        $rules = [
            'txt_placeofposting_name' => 'required'
                ];
        $customMessages = [
            'required' => 'Place of Posting Name is required.'
        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_placeofposting')->where('placeofposting_name', $request->txt_placeofposting_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $data=array();
        $data['placeofposting_name']=$request->txt_placeofposting_name;
        $data['emp_id']=$request->txt_user_id;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_placeofposting')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success' );
          //dd($abcd)
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }
    public function hrmbackplace_postingedit($id)
    { 
        $m_placeofposting=DB::table('pro_placeofposting')->where('placeofposting_id',$id)->first();
        // return response()->json($data);
        $data=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_id', 'desc')->get();
        return view('hrm.placeposting',compact('data','m_placeofposting'));
    }

    public function hrmbackplace_postingupdate(Request $request,$update)
    {      
        DB::table('pro_placeofposting')->where('placeofposting_id',$update)->update([
            'placeofposting_name'=>$request->txt_placeofposting_name,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('placeposting'))->with('success','Data Updated Successfully!');
    }

//bio device
    public function hrmbackbio_device()
    {
        $data=DB::table('pro_biodevice')->Where('valid','1')->orderBy('biodevice_id', 'desc')->get(); //query builder
        return view('hrm.biodevice',compact('data'));
    }

    public function hrmbackbio_devicestore(Request $request)
    {
        $rules = [
            'txt_biodevice_name' => 'required',
            'sele_placeofposting_id' => 'required|integer|between:1,10000',
                ];
        $customMessages = [
            'txt_biodevice_name.required' => 'Bio Device ID / Terminal ID is required.',

            'sele_placeofposting_id.required' => 'Select Place/Branch.',
            'sele_placeofposting_id.integer' => 'Select Place/Branch.',
            'sele_placeofposting_id.between' => 'Chose Place/Branch.',

        ];
        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_biodevice')->where('biodevice_name', $request->txt_biodevice_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['biodevice_name']=$request->txt_biodevice_name;
        $data['placeofposting_id']=$request->sele_placeofposting_id;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_biodevice')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function hrmbackbio_deviceedit($id)
    {
        $m_biodevice=DB::table('pro_biodevice')->where('biodevice_id',$id)->first();
        $data=DB::table('pro_biodevice')->where('valid','1')->get();
        return view('hrm.biodevice',compact('data','m_biodevice'));
    }

    public function hrmbackbio_deviceupdate(Request $request,$update)
    {

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
      
        DB::table('pro_biodevice')->where('biodevice_id',$update)->update([
            'biodevice_name'=>$request->txt_biodevice_name,
            'placeofposting_id'=>$request->sele_placeofposting_id,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('biodevice'))->with('success','Data Updated Successfully!');
    }

//policy

    public function hrmbackpolicy()
    {

        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        // $data=DB::table('pro_att_policy')
        // ->join("pro_company", "pro_att_policy.company_id", "pro_company.company_id")
        // ->select("pro_att_policy.*", "pro_company.company_name")
        // ->Where('pro_att_policy.company_id',$user_company->company_id)
        // ->Where('pro_att_policy.valid','1')
        // ->orderBy('pro_att_policy.att_policy_id', 'desc')
        // ->get(); //query builder

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder
        
        return view('hrm.policy',compact('m_yesno','user_company'));

    }

    public function hrmbackpolicystore(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'txt_att_policy_name' => 'required',
            'txt_in_time' => 'required',
            'txt_out_time' => 'required',
            'sele_policy_status' => 'required|integer|between:1,2',
            'txt_grace_time' => 'required',
            'txt_lunch_time' => 'required',
            'txt_lunch_break' => 'required',
            'sele_weekly_holiday1' => 'required|integer|between:1,7',
            'sele_ot_elgble' => 'required|integer|between:1,2',
            'cbo_shift_status' => 'required|integer|between:1,2',
                ];
        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'txt_att_policy_name.required' => 'Policy / Shift Name is required.',
            'txt_in_time.required' => 'In Time is required.',
            'txt_out_time.required' => 'Out Time is required.',

            'sele_policy_status.required' => 'Select Yes / No.',
            'sele_policy_status.integer' => 'Select Yes / No.',
            'sele_policy_status.between' => 'Select Yes / No.',

            'txt_grace_time.required' => 'Grace Time is required.',
            'txt_lunch_time.required' => 'Lunch Time is required.',
            'txt_lunch_break.required' => 'Lunch Break minute is required.',

            'sele_weekly_holiday1.required' => 'Select Weekly Holiday.',
            'sele_weekly_holiday1.integer' => 'Select Weekly Holiday.',
            'sele_weekly_holiday1.between' => 'Chose Weekly Holiday.',

            'sele_ot_elgble.required' => 'Select Yes / No.',
            'sele_ot_elgble.integer' => 'Select Yes / No.',
            'sele_ot_elgble.between' => 'Chose Yes / No.',

            'cbo_shift_status.required' => 'Select Yes / No.',
            'cbo_shift_status.integer' => 'Select Yes / No.',
            'cbo_shift_status.between' => 'Select Yes / No.',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        $abcd = DB::table('pro_att_policy')->where('att_policy_name', $request->txt_att_policy_name)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_txt_in_time=$request->txt_in_time;
        $aa=strtotime($m_txt_in_time);
        $m_txt_grace_time=$request->txt_grace_time;
        $ab=$m_txt_grace_time*60;
        $txt_grace_time_cal=$aa+$ab;
        $graced_in_time=date('H:i:s',$txt_grace_time_cal);

        if ($request->sele_weekly_holiday1==1){
        $txt_holiday1='Saturday';  
        } else if ($request->sele_weekly_holiday1==2){
        $txt_holiday1='Sunday';  
        } else if ($request->sele_weekly_holiday1==3){
        $txt_holiday1='Monday';  
        } else if ($request->sele_weekly_holiday1==4){
        $txt_holiday1='Tuesday';  
        } else if ($request->sele_weekly_holiday1==5){
        $txt_holiday1='Wednesday';  
        } else if ($request->sele_weekly_holiday1==6){
        $txt_holiday1='Thursday';  
        } else if ($request->sele_weekly_holiday1==7){
        $txt_holiday1='Friday';  
        }

        if ($request->sele_weekly_holiday2==0){
        $txt_holiday2='N/A';  
        } else if ($request->sele_weekly_holiday2==1){
        $txt_holiday2='Saturday';  
        } else if ($request->sele_weekly_holiday2==2){
        $txt_holiday2='Sunday';  
        } else if ($request->sele_weekly_holiday2==3){
        $txt_holiday2='Monday';  
        } else if ($request->sele_weekly_holiday2==4){
        $txt_holiday2='Tuesday';  
        } else if ($request->sele_weekly_holiday2==5){
        $txt_holiday2='Wednesday';  
        } else if ($request->sele_weekly_holiday2==6){
        $txt_holiday2='Thursday';  
        } else if ($request->sele_weekly_holiday2==7){
        $txt_holiday2='Friday';  
        }


        $data=array();
        $data['company_id']=$request->cbo_company_id;
        $data['att_policy_name']=$request->txt_att_policy_name;
        $data['in_time']=$request->txt_in_time;
        $data['out_time']=$request->txt_out_time;
        $data['grace_time']=$request->txt_grace_time;
        $data['in_time_graced']=$graced_in_time;
        $data['lunch_time']=$request->txt_lunch_time;
        $data['lunch_break']=$request->txt_lunch_break;
        $data['weekly_holiday1']=$txt_holiday1;
        $data['weekly_holiday2']=$txt_holiday2;
        $data['ot_elgble']=$request->sele_ot_elgble;
        $data['user_id']=$m_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        $data['shift_status']=$request->cbo_shift_status;
        $data['policy_status']=$request->sele_policy_status;
        // dd($data);
        DB::table('pro_att_policy')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function hrmbackpolicyedit($id)
    {

        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_att_policy=DB::table('pro_att_policy')->where('att_policy_id',$id)->first();

        $data=DB::table('pro_att_policy')->where('valid','1')->get();

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder


        return view('hrm.policy',compact('user_company','data','m_att_policy','m_yesno'));
    }

    public function hrmbackpolicyupdate(Request $request,$update)
    {

        $m_user_id=Auth::user()->emp_id;

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_txt_in_time=$request->txt_in_time;
        $aa=strtotime($m_txt_in_time);
        $m_txt_grace_time=$request->txt_grace_time;
        $ab=$m_txt_grace_time*60;
        $txt_grace_time_cal=$aa+$ab;
        $graced_in_time=date('H:i:s',$txt_grace_time_cal);

        if ($request->sele_weekly_holiday1==1){
        $txt_holiday1='Saturday';  
        } else if ($request->sele_weekly_holiday1==2){
        $txt_holiday1='Sunday';  
        } else if ($request->sele_weekly_holiday1==3){
        $txt_holiday1='Monday';  
        } else if ($request->sele_weekly_holiday1==4){
        $txt_holiday1='Tuesday';  
        } else if ($request->sele_weekly_holiday1==5){
        $txt_holiday1='Wednesday';  
        } else if ($request->sele_weekly_holiday1==6){
        $txt_holiday1='Thursday';  
        } else if ($request->sele_weekly_holiday1==7){
        $txt_holiday1='Friday';  
        }

        if ($request->sele_weekly_holiday2==0){
        $txt_holiday2='N/A';  
        } else if ($request->sele_weekly_holiday2==1){
        $txt_holiday2='Saturday';  
        } else if ($request->sele_weekly_holiday2==2){
        $txt_holiday2='Sunday';  
        } else if ($request->sele_weekly_holiday2==3){
        $txt_holiday2='Monday';  
        } else if ($request->sele_weekly_holiday2==4){
        $txt_holiday2='Tuesday';  
        } else if ($request->sele_weekly_holiday2==5){
        $txt_holiday2='Wednesday';  
        } else if ($request->sele_weekly_holiday2==6){
        $txt_holiday2='Thursday';  
        } else if ($request->sele_weekly_holiday2==7){
        $txt_holiday2='Friday';  
        }


        DB::table('pro_att_policy')->where('att_policy_id',$update)->update([
            'company_id'=>$request->cbo_company_id,
            'att_policy_name'=>$request->txt_att_policy_name,
            'in_time'=>$request->txt_in_time,
            'out_time'=>$request->txt_out_time,
            'grace_time'=>$request->txt_grace_time,
            'in_time_graced'=>$graced_in_time,
            'lunch_time'=>$request->txt_lunch_time,
            'lunch_break'=>$request->txt_lunch_break,
            'weekly_holiday1'=>$txt_holiday1,
            'weekly_holiday2'=>$txt_holiday2,
            'ot_elgble'=>$request->sele_ot_elgble,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s'),
            'shift_status'=>$request->cbo_shift_status,
            'policy_status'=>$request->sele_policy_status,
        ]);
        return redirect(route('policy'))->with('success','Data Updated Successfully!');
    }

    public function HrmPolicySub()
    {

        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        // $m_att_policy=DB::table('pro_att_policy')
        // ->Where('valid','1')
        // ->Where('company_id',$user_company->company_id)
        // // ->orderBy('yesno_id','asc')
        // ->get();

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder
        
        return view('hrm.policy_sub',compact('m_yesno','user_company'));

    }




//holiday

    public function hrmbackholiday()
    {

        $mentrydate=time();
        $m_holiday_year=date("Y",$mentrydate);
       
        $data=DB::table('pro_holiday')->Where('valid','1')->where('holiday_year',$m_holiday_year)->orderBy('holiday_id', 'desc')->get(); //query builder
        return view('hrm.holiday',compact('data'));
    }

    public function hrmbackholidaystore(Request $request)
    {
        $rules = [
            'txt_holiday_name' => 'required',
            'txt_holiday_date' => 'required',
                ];
        $customMessages = [
            'txt_holiday_name.required' => 'Holiday Name is required.',
            'txt_holiday_date.required' => 'Holiday Date is required.',

        ];
        $this->validate($request, $rules, $customMessages);

        $m_holiday_date=$request->txt_holiday_date;
        $m_holiday_year=substr($m_holiday_date,0,4);

        $abcd = DB::table('pro_holiday')->where('holiday_name', $request->txt_holiday_name)->where('holiday_year', $m_holiday_year)->first();
        //dd($abcd);
        
        if ($abcd === null)
        {
        $m_valid='1';
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);


        $data=array();
        $data['holiday_name']=$request->txt_holiday_name;
        $data['holiday_year']=$m_holiday_year;
        $data['holiday_date']=$request->txt_holiday_date;
        $data['user_info_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        // dd($data);
        DB::table('pro_holiday')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
          return redirect()->back()->withInput()->with('warning' , 'Data already exists!!');  
        }
    }

    public function hrmbackholidayedit($id)
    {
        $m_holiday=DB::table('pro_holiday')->where('holiday_id',$id)->first();
        $data=DB::table('pro_holiday')->where('valid','1')->get();
        return view('hrm.holiday',compact('data','m_holiday'));
    }

    public function hrmbackholidayupdate(Request $request,$update)
    {

        $m_holiday_date=$request->txt_holiday_date;
        $m_holiday_year=substr($m_holiday_date,0,4);

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        DB::table('pro_holiday')->where('holiday_id',$update)->update([
            'holiday_name'=>$request->txt_holiday_name,
            'holiday_year'=>$m_holiday_year,
            'holiday_date'=>$request->txt_holiday_date,
            'entry_date'=>date('Y-m-d'),
            'entry_time'=>date('H:i:s')
        ]);
        return redirect(route('holiday'))->with('success','Data Updated Successfully!');
    }


//Basic Info

    public function hrmbackbasic_info()
    {
        $data=DB::table('pro_employee_info')->Where('valid','1')->Where('working_status','1')->orderBy('employee_id','asc')->get(); //query builder

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.basic_info',compact('data','user_company'));

    }

    //Basic Info insert
    public function hrmbackbasic_infostore(Request $request)
    {
    $rules = [
            'sele_company_id' => 'required|integer|between:1,10000',
            'txt_emp_id' => 'required|max:8|min:8',
            'txt_emp_name' => 'required|max:50|min:4',
            // 'sele_report' => 'required|integer|between:1,10000',
            'sele_desig' => 'required|integer|between:1,10000',
            'sele_department' => 'required|integer|between:1,10000',
            'sele_section' => 'required|integer|between:1,10000',
            'sele_placeofposting' => 'required|integer|between:1,10000',
            'txt_joining_date' => 'required',
            'sele_att_policy' => 'required|integer|between:1,10000',
            'sele_gender_id' => 'required|integer|between:1,10000',
            'txt_emp_mobile' => 'required',
            'sele_blood' => 'required|integer|between:1,10000',
        ];

        $customMessages = [

            'sele_company_id.required' => 'Select Company.',
            'sele_company_id.integer' => 'Select Company.',
            'sele_company_id.between' => 'Chose Company.',

            'txt_emp_id.required' => 'Employee ID is required.',
            'txt_emp_id.min' => 'Employee ID must be at least 3 characters.',
            'txt_emp_id.max' => 'Employee ID less then 20 characters.',

            'txt_emp_name.required' => 'Employee Name is required.',
            'txt_emp_name.min' => 'Employee Name must be at least 4 characters.',
            'txt_emp_name.max' => 'Employee Name less then 50 characters.',

            // 'sele_report.required' => 'Select Report To.',
            // 'sele_report.integer' => 'Select Report To.',
            // 'sele_report.between' => 'Chose Report To.',

            'sele_desig.required' => 'Chose Designation.',
            'sele_desig.integer' => 'Chose Designation.',
            'sele_desig.between' => 'Chose Designation.',

            'sele_department.required' => 'Chose Department.',
            'sele_department.integer' => 'Chose Department.',
            'sele_department.between' => 'Chose Department.',

            'sele_section.required' => 'Chose Section.',
            'sele_section.integer' => 'Chose Section.',
            'sele_section.between' => 'Chose Section.',

            'sele_placeofposting.required' => 'Chose Place of Posting.',
            'sele_placeofposting.integer' => 'Chose Place of Posting.',
            'sele_placeofposting.between' => 'Chose Place of Posting.',

            'txt_joining_date.required' => 'Joining Date is required.',

            'sele_att_policy.required' => 'Chose Attendance Policy.',
            'sele_att_policy.integer' => 'Chose Attendance Policy.',
            'sele_att_policy.between' => 'Chose Attendance Policy.',

            'sele_gender_id.required' => 'Chose Gender.',
            'sele_gender_id.integer' => 'Chose Gender.',
            'sele_gender_id.between' => 'Chose Gender.',

            'txt_emp_mobile.required' => 'Employee Mobile Number required.',

            'sele_blood.required' => 'Select Blood Group.',
            'sele_blood.integer' => 'Select Blood Group.',
            'sele_blood.between' => 'Select Blood Group.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $ci_employee_info = DB::table('pro_employee_info')->where('employee_id', $request->txt_emp_id)->first();
        //dd($abcd);
        
        if ($ci_employee_info === null)
        {

        $m_valid='1';
        $m_ss='1';
        $m_working_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['company_id']=$request->sele_company_id;
        $data['employee_id']=$request->txt_emp_id;
        $data['employee_name']=$request->txt_emp_name;
        // $data['report_to_id']=$request->sele_report;
        $data['desig_id']=$request->sele_desig;
        $data['department_id']=$request->sele_department;
        $data['section_id']=$request->sele_section;
        $data['placeofposting_id']=$request->sele_placeofposting;
        $data['joinning_date']=$request->txt_joining_date;
        $data['att_policy_id']=$request->sele_att_policy;
        $data['gender']=$request->sele_gender_id;
        $data['mobile']=$request->txt_emp_mobile;
        $data['blood_group']=$request->sele_blood;
        $data['grade']=$request->txt_grade;
        $data['working_status']=$m_working_status;
        $data['ss']=$m_ss;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;
        $data['psm_id']=$request->txt_psm_id;
        $data['staff_id']=$request->txt_staff_id;
        $data['level_step']=$request->txt_level_step;

        //dd($data);
        DB::table('pro_employee_info')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
        } else {
        return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }

    }

    public function hrmbackbasic_infoedit($id)
    {
        $m_basic_info=DB::table('pro_employee_info')->where('employee_info_id',$id)->first();
        $data=DB::table('pro_employee_info')->where('valid','1')->where('employee_info_id',$m_basic_info->employee_info_id)->first();
        $m_employee_info = DB::table('pro_employee_info')->Where('valid','1')->get();
        $m_pro_desig = DB::table('pro_desig')->Where('valid','1')->get();
        $m_pro_department = DB::table('pro_department')->Where('valid','1')->get();
        $m_pro_section = DB::table('pro_section')->Where('valid','1')->get();
        $m_pro_placeofposting = DB::table('pro_placeofposting')->Where('valid','1')->get();
        $m_pro_att_policy = DB::table('pro_att_policy')
        ->Where('valid','1')
        ->Where('company_id',$m_basic_info->company_id)
        ->get();
        $m_pro_gender = DB::table('pro_gender')->Where('valid','1')->get();
        $m_pro_blood = DB::table('pro_blood')->Where('valid','1')->get();
        $m_pro_company = DB::table('pro_company')->Where('valid','1')->get();

        // dd($data->company_id);
        return view('hrm.basic_info',compact('data','m_basic_info','m_employee_info','m_pro_desig','m_pro_department','m_pro_section','m_pro_placeofposting','m_pro_att_policy','m_pro_gender','m_pro_blood','m_pro_company'));
    }

    public function hrmbackbasic_infoupdate(Request $request,$update)
    {

    $rules = [
            'sele_company_id' => 'required|integer|between:1,100',
            // 'txt_emp_id' => 'required|max:20|min:3',
            'txt_emp_name' => 'required|max:50|min:4',
            // 'sele_report' => 'required|integer|between:1,10000',
            'sele_desig' => 'required|integer|between:1,10000',
            'sele_department' => 'required|integer|between:1,10000',
            'sele_section' => 'required|integer|between:1,10000',
            'sele_placeofposting' => 'required|integer|between:1,10000',
            'txt_joining_date' => 'required',
            'sele_att_policy' => 'required|integer|between:1,10000',
            'sele_gender_id' => 'required|integer|between:1,10000',
            'txt_emp_mobile' => 'required',
            'sele_blood' => 'required|integer|between:1,10000',
        ];

        $customMessages = [

            'sele_company_id.required' => 'Select Company.',
            'sele_company_id.integer' => 'Select Company.',
            'sele_company_id.between' => 'Select Company.',

            // 'txt_emp_id.required' => 'Employee ID is required.',
            // 'txt_emp_id.min' => 'Employee ID must be at least 3 characters.',
            // 'txt_emp_id.max' => 'Employee ID less then 20 characters.',

            'txt_emp_name.required' => 'Employee Name is required.',
            'txt_emp_name.min' => 'Employee Name must be at least 4 characters.',
            'txt_emp_name.max' => 'Employee Name less then 50 characters.',

            // 'sele_report.required' => 'Select Report To.',
            // 'sele_report.integer' => 'Select Report To.',
            // 'sele_report.between' => 'Chose Report To.',

            'sele_desig.required' => 'Chose Designation.',
            'sele_desig.integer' => 'Chose Designation.',
            'sele_desig.between' => 'Chose Designation.',

            'sele_department.required' => 'Chose Department.',
            'sele_department.integer' => 'Chose Department.',
            'sele_department.between' => 'Chose Department.',

            'sele_section.required' => 'Chose Section.',
            'sele_section.integer' => 'Chose Section.',
            'sele_section.between' => 'Chose Section.',

            'sele_placeofposting.required' => 'Chose Place of Posting.',
            'sele_placeofposting.integer' => 'Chose Place of Posting.',
            'sele_placeofposting.between' => 'Chose Place of Posting.',

            'txt_joining_date.required' => 'Joining Date is required.',

            'sele_att_policy.required' => 'Chose Attendance Policy.',
            'sele_att_policy.integer' => 'Chose Attendance Policy.',
            'sele_att_policy.between' => 'Chose Attendance Policy.',

            'sele_gender_id.required' => 'Chose Gender.',
            'sele_gender_id.integer' => 'Chose Gender.',
            'sele_gender_id.between' => 'Chose Gender.',

            'txt_emp_mobile.required' => 'Employee Mobile Number required.',

            'sele_blood.required' => 'Select Blood Group.',
            'sele_blood.integer' => 'Select Blood Group.',
            'sele_blood.between' => 'Select Blood Group.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $ci_employee_info = DB::table('pro_employee_info')->where('employee_id', $request->txt_emp_id)->where('employee_info_id','<>',$update)->first();
        //dd($abcd);
        
        if ($ci_employee_info === null)
        {

        DB::table('pro_employee_info')->where('employee_info_id',$update)->update([
            'company_id'=>$request->sele_company_id,
            // 'employee_id'=>$request->txt_emp_id,
            'employee_name'=>$request->txt_emp_name,
            // 'report_to_id'=>$request->sele_report,
            'desig_id'=>$request->sele_desig,
            'department_id'=>$request->sele_department,
            'section_id'=>$request->sele_section,
            'placeofposting_id'=>$request->sele_placeofposting,
            'placeofposting_sub_id'=>$request->cbo_sub_posting,
            'joinning_date'=>$request->txt_joining_date,
            'att_policy_id'=>$request->sele_att_policy,
            'gender'=>$request->sele_gender_id,
            'mobile'=>$request->txt_emp_mobile,
            'blood_group'=>$request->sele_blood,
            'grade'=>$request->txt_grade,
            'psm_id'=>$request->txt_psm_id,
            'staff_id'=>$request->txt_staff_id,
            'level_step'=>$request->txt_level_step,

            ]);

        return redirect(route('basic_info'))->with('success','Data Updated Successfully!');
        } else {
        return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }

    }

    public function HrmReportingBoss($id2)
    {
        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $ci_employee_info=DB::table('pro_employee_info')
        ->Where('valid','1')
        ->Where('working_status','1')
        ->orderBy('employee_id','asc')
        ->get(); //query builder


        // $m_basic_info=DB::table('pro_employee_info')
        // ->where('employee_info_id',$id)
        // ->first();

        $m_employee_info = DB::table('pro_employee_info')
        ->join('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
        ->join('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
        ->join('pro_department', 'pro_employee_info.department_id', 'pro_department.department_id')
        ->join('pro_placeofposting', 'pro_employee_info.placeofposting_id', 'pro_placeofposting.placeofposting_id')
        ->select('pro_employee_info.*', 'pro_company.*', 'pro_desig.*', 'pro_department.*', 'pro_placeofposting.*')
    
        ->where('employee_id', $id2)
        ->first();
        // dd($m_employee_info);
        return view('hrm.reporting_boss',compact('m_user_id','user_company','ci_employee_info','m_employee_info'));
    }
     

    //Basic Info insert
    public function HrmReportingBossStore(Request $request)
    {
    $rules = [
            'txt_level_step' => 'required|integer|between:1,10',
            'cbo_report_to_id' => 'required',
        ];

        $customMessages = [

            'txt_level_step.required' => 'Select Reporting Boss Step.',
            'txt_level_step.integer' => 'Select Reporting Boss Step.',
            'txt_level_step.between' => 'Select Reporting Boss Step.',

            'cbo_report_to_id.required' => 'Reporting Boss is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        $ci_employee_info = DB::table('pro_employee_info')
        ->where('employee_id', $request->cbo_employee_id)
        ->first();
        //dd($abcd);

        $ci_level_step=DB::table('pro_level_step')
        ->where('employee_id', $request->cbo_employee_id)
        ->where('valid','1')
        ->count();
        
        if ($ci_employee_info->level_step === $ci_level_step)
        {
        return redirect()->route('basic_info_up',$request->cbo_company_id)->with('warning',"$request->cbo_employee_id Data already exists!!");

            // return view('hrm.basic_info_up')->with('warning','Data already exists!!');
        } else {

        $m_valid='1';

        $data=array();
        $data['level_step']=$request->txt_level_step;
        $data['employee_id']=$request->cbo_employee_id;
        $data['report_to_id']=$request->cbo_report_to_id;
        $data['user_id']=$m_user_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid']=$m_valid;
        //dd($data);
        DB::table('pro_level_step')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');

        }

    }

public function HrmReportingBossEdit($id)
    {
        
        $m_level_step=DB::table('pro_level_step')->where('level_step_id',$id)->first();

        $mm_employee_info = DB::table('pro_employee_info')
        ->join('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
        ->select('pro_employee_info.*', 'pro_company.*')
        ->where('employee_id', $m_level_step->employee_id)
        ->first();

        $ci_employee_info=DB::table('pro_employee_info')
        ->Where('valid','1')
        ->Where('working_status','1')
        ->orderBy('employee_id','asc')
        ->get(); //query builder

        return view('hrm.reporting_boss',compact('m_level_step','ci_employee_info','mm_employee_info'));
    }

// public function hrmbackcompanyupdate(Request $request)
    // {      

    public function HrmReportingBosUpdate(Request $request,$update)
    {

        DB::table('pro_level_step')
        ->where('level_step_id',$update)
        ->update([
            'level_step'=>$request->txt_level_step,
            'report_to_id'=>$request->cbo_report_to_id,
        ]);
        return redirect(route('reporting_boss',$request->cbo_employee_id))->with('success',"$request->cbo_report_to_id Data Updated Successfully!");
    }

//Basic Info for HR

    public function HrmBasicInfoUp()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $data=DB::table('pro_employee_info')
        ->Where('valid','1')
        ->Where('working_status','1')
        ->orderBy('employee_id','asc')
        ->get(); //query builder

        return view('hrm.basic_info_up',compact('data','user_company'));

    }

    public function HrmBasicInfoUpEdit($id)
    {
        $m_user_id=Auth::user()->emp_id;

        $m_basic_info=DB::table('pro_employee_info')
        ->where('employee_info_id',$id)
        ->first();

        $data=DB::table('pro_employee_info')
        ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->select("pro_employee_info.*", "pro_company.company_name")
        ->where('pro_employee_info.valid','1')
        ->where('pro_employee_info.employee_info_id',$m_basic_info->employee_info_id)
        ->first();

        $m_employee_info = DB::table('pro_employee_info')->Where('valid','1')->get();
        $m_pro_desig = DB::table('pro_desig')->Where('valid','1')->get();
        $m_pro_department = DB::table('pro_department')->Where('valid','1')->get();
        $m_pro_section = DB::table('pro_section')->Where('valid','1')->get();
        $m_pro_placeofposting = DB::table('pro_placeofposting')->Where('valid','1')->get();
        $m_pro_att_policy = DB::table('pro_att_policy')->Where('valid','1')->get();
        $m_pro_gender = DB::table('pro_gender')->Where('valid','1')->get();
        $m_pro_blood = DB::table('pro_blood')->Where('valid','1')->get();
        // $m_pro_company = DB::table('pro_company')->Where('valid','1')->get();

        // dd($data->company_id);
        return view('hrm.basic_info_up',compact('data','m_basic_info','m_employee_info','m_pro_desig','m_pro_department','m_pro_section','m_pro_placeofposting','m_pro_att_policy','m_pro_gender','m_pro_blood'));
    }


    public function HrmBasicInfoUpupdate(Request $request,$update)
    {

    $rules = [
            'sele_desig' => 'required|integer|between:1,10000',
            'sele_department' => 'required|integer|between:1,10000',
            'sele_section' => 'required|integer|between:1,10000',
            'sele_placeofposting' => 'required|integer|between:1,10000',
            'txt_joining_date' => 'required',
            'sele_att_policy' => 'required|integer|between:1,10000',
            'sele_gender_id' => 'required|integer|between:1,10000',
            'txt_emp_mobile' => 'required',
            'sele_blood' => 'required|integer|between:1,10000',
        ];

        $customMessages = [

            'sele_desig.required' => 'Chose Designation.',
            'sele_desig.integer' => 'Chose Designation.',
            'sele_desig.between' => 'Chose Designation.',

            'sele_department.required' => 'Chose Department.',
            'sele_department.integer' => 'Chose Department.',
            'sele_department.between' => 'Chose Department.',

            'sele_section.required' => 'Chose Section.',
            'sele_section.integer' => 'Chose Section.',
            'sele_section.between' => 'Chose Section.',

            'sele_placeofposting.required' => 'Chose Place of Posting.',
            'sele_placeofposting.integer' => 'Chose Place of Posting.',
            'sele_placeofposting.between' => 'Chose Place of Posting.',

            'txt_joining_date.required' => 'Joining Date is required.',

            'sele_att_policy.required' => 'Chose Attendance Policy.',
            'sele_att_policy.integer' => 'Chose Attendance Policy.',
            'sele_att_policy.between' => 'Chose Attendance Policy.',

            'sele_gender_id.required' => 'Chose Gender.',
            'sele_gender_id.integer' => 'Chose Gender.',
            'sele_gender_id.between' => 'Chose Gender.',

            'txt_emp_mobile.required' => 'Employee Mobile Number required.',

            'sele_blood.required' => 'Select Blood Group.',
            'sele_blood.integer' => 'Select Blood Group.',
            'sele_blood.between' => 'Select Blood Group.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_employee_info=DB::table('pro_employee_info')
        // ->where('valid','1')
        ->where('employee_id',$request->txt_emp_id)
        ->first();

        $data=array();
        $data['company_id']=$m_employee_info->company_id;
        $data['employee_id']=$m_employee_info->employee_id;
        $data['employee_name']=$m_employee_info->employee_name;
        // $data['report_to_id']=$m_employee_info->report_to_id;
        $data['desig_id']=$m_employee_info->desig_id;
        $data['department_id']=$m_employee_info->department_id;
        $data['section_id']=$m_employee_info->section_id;
        $data['placeofposting_id']=$m_employee_info->placeofposting_id;
        $data['joinning_date']=$m_employee_info->joinning_date;
        $data['att_policy_id']=$m_employee_info->att_policy_id;
        $data['gender']=$m_employee_info->gender;
        $data['mobile']=$m_employee_info->mobile;
        $data['blood_group']=$m_employee_info->blood_group;
        $data['grade']=$m_employee_info->grade;
        $data['working_status']=$m_employee_info->working_status;
        $data['ss']=$m_employee_info->ss;
        $data['user_id']=$m_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_employee_info->valid;
        $data['psm_id']=$m_employee_info->psm_id;
        $data['staff_id']=$m_employee_info->staff_id;
        $data['level_step']=$m_employee_info->level_step;

        //dd($data);
        DB::table('pro_employee_info_up')->insert($data);

        DB::table('pro_employee_info')->where('employee_info_id',$update)
        ->update([
            // 'report_to_id'=>$request->sele_report,
            'desig_id'=>$request->sele_desig,
            'department_id'=>$request->sele_department,
            'section_id'=>$request->sele_section,
            'placeofposting_id'=>$request->sele_placeofposting,
            'joinning_date'=>$request->txt_joining_date,
            'att_policy_id'=>$request->sele_att_policy,
            'gender'=>$request->sele_gender_id,
            'mobile'=>$request->txt_emp_mobile,
            'blood_group'=>$request->sele_blood,
            'grade'=>$request->txt_grade,
            'psm_id'=>$request->txt_psm_id,
            'staff_id'=>$request->txt_staff_id,
            'level_step'=>$request->txt_level_step,

            ]);

        return redirect(route('basic_info_up'))->with('success',"$request->txt_emp_name Data Updated Successfully!");
    }

//bio_data
    
    public function hrmbackbio_data()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        // $company = DB::table('pro_company')->Where('valid','1')->get();
        $marital_status = DB::table('pro_marital_status')->Where('valid','1')->get();

        return view('hrm.bio_data',compact('user_company','marital_status'));

    }

    public function companyEmployee(Request $request, $id)
    {
        $data = DB::table('pro_employee_info')->where('company_id',$id)->get();
        return response()->json(['data' => $data]);
    }

    //Bio Data insert
    public function hrmbio_datastore(Request $request)
    {
         // return redirect()->route('biodata_file','00000130')->with('success','Data Inserted Successfully!');
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,30',
            'cbo_employee_id' => 'required',
            'txt_father_name' => 'required|min:4|max:50',
            'txt_mother_name' => 'required|min:4|max:50',
            'txt_dob' => 'required',
            'cbo_marital_status' => 'required|integer|between:1,10',
            // 'txt_spouse_name' => 'required|min:4|max:50',
            'txt_res_contact' => 'required|max:25',
            'txt_nationality' => 'required|max:20',
            'txt_national_id_no' => 'required|max:20',
            'txt_present_add' => 'required',
            'txt_permanent_add' => 'required',
            'txt_email_personal' => 'required',
            // 'txt_email_office' => 'required',
        ];

        $customMessages = [


            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Chose Company.',

            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_employee_id.integer' => 'Select Employee.',
            'cbo_employee_id.between' => 'Chose Employee.',

            'txt_father_name.required' => 'Father Name is required.',
            'txt_father_name.min' => 'Father Name must be at least 4 characters.',
            'txt_father_name.max' => 'Father Name less then 50 characters.',

            'txt_mother_name.required' => 'Mother Name is required.',
            'txt_mother_name.min' => 'Mother Name must be at least 4 characters.',
            'txt_mother_name.max' => 'Mother Name less then 50 characters.',

            'txt_dob.required' => 'Date of Birth is required.',

            'cbo_marital_status.required' => 'Select Marital Status.',
            'cbo_marital_status.integer' => 'Select Marital Status.',
            'cbo_marital_status.between' => 'Chose Marital Status.',

            // 'txt_spouse_name.required' => 'Spouse Name is required.',
            // 'txt_spouse_name.min' => 'Spouse Name must be at least 4 characters.',
            // 'txt_spouse_name.max' => 'Spouse Name less then 50 characters.',

            'txt_res_contact.required' => 'Residential Contact number is required.',
            'txt_res_contact.max' => 'Residential Contact number less then 50 characters.',

            'txt_nationality.required' => 'Nationality is required.',
            'txt_nationality.max' => 'Nationality less then 20 characters.',

            'txt_national_id_no.required' => 'NID is required.',
            'txt_national_id_no.max' => 'NID less then 50 characters.',

            'txt_present_add.required' => 'Present address is required.',
            'txt_permanent_add.required' => 'Permanent address is required.',
            'txt_email_personal.required' => 'Personal E-mail is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        // $mentrydate=time();
        // $m_entry_date=date("Y-m-d",$mentrydate);
        // $m_entry_time=date("H:i:s",$mentrydate);
        $m_bio_status='2';


        $ci_emp_info=DB::table('pro_employee_info')
        ->Where('employee_id',$request->cbo_employee_id)
        ->Where('bio_status','<','2')
        ->first();

        // dd($ci_emp_info);
        if($ci_emp_info === NULL)
        {
          return redirect()->back()->withInput()->with('warning'," $request->cbo_employee_id Data allready exists!!!");
        } else {
        $txt_employee_info_id=$ci_emp_info->employee_info_id;
        // $txt_employee_id=$ci_emp_info->employee_id;
        $txt_employee_name=$ci_emp_info->employee_name;

        $data=array();
        $data['employee_info_id']=$txt_employee_info_id;
        $data['company_id']=$request->cbo_company_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['employee_name']=$txt_employee_name;
        $data['father_name']=$request->txt_father_name;
        $data['mother_name']=$request->txt_mother_name;
        $data['dob']=$request->txt_dob;
        $data['marital_status_id']=$request->cbo_marital_status;
        $data['spouse_name']=$request->txt_spouse_name;
        $data['res_contact']=$request->txt_res_contact;
        $data['nationality']=$request->txt_nationality;
        $data['national_id_no']=$request->txt_national_id_no;
        $data['height']=$request->txt_height;
        $data['present_add']=$request->txt_present_add;
        $data['permanent_add']=$request->txt_permanent_add;
        $data['email_personal']=$request->txt_email_personal;
        $data['email_office']=$request->txt_email_office;
        $data['user_id']=$request->txt_emp_id;
        
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        $data['valid']=$m_valid;

        // dd($data);
        DB::table('pro_employee_biodata')->insert($data);

        DB::table('pro_employee_info')
        ->where('employee_id',$request->cbo_employee_id)
        ->update([
            'bio_status'=>$m_bio_status,
            ]);
        // return redirect()->back()->with('success','Data Inserted Successfully!');
        return redirect()->route('biodata_file',$request->cbo_employee_id)->with('success',"$request->cbo_employee_id Data Inserted Successfully!");

        }//if($ci_emp_info==NULL)
    }

    public function hrmbio_dataedit($id)
    {
        $m_employee_biodata=DB::table('pro_employee_biodata')
            ->join("pro_company", "pro_employee_biodata.company_id", "pro_company.company_id")


        ->where('biodata_id',$id)->first();
        $data=DB::table('pro_employee_biodata')->where('valid','1')->get();
        $company = DB::table('pro_company')->Where('valid','1')->get();
        $marital_status = DB::table('pro_marital_status')->Where('valid','1')->get();
        return view('hrm.bio_data',compact('data','m_employee_biodata','company','marital_status'));
    }


    public function hrmbio_dataupdate(Request $request,$update)
    {

    $rules = [
            'txt_father_name' => 'required',
            'txt_mother_name' => 'required',
            'txt_dob' => 'required',
            'cbo_marital_status' => 'required|integer|between:1,10',
            // 'txt_spouse_name' => 'required',
            'txt_res_contact' => 'required',
            'txt_nationality' => 'required',
            'txt_national_id_no' => 'required',
            'txt_present_add' => 'required',
            'txt_permanent_add' => 'required',
            'txt_email_personal' => 'required',
        ];

        $customMessages = [

            'txt_father_name.required' => 'Father Name is required.',
            'txt_mother_name.required' => 'Mother Name is required.',
            'txt_dob.required' => 'DOB is required.',

            'cbo_marital_status.required' => 'Marital Status.',
            'cbo_marital_status.integer' => 'Marital Status.',
            'cbo_marital_status.between' => 'Marital Status.',

            // 'txt_spouse_name.required' => 'Spouse Name is required.',
            'txt_res_contact.required' => 'Res. Contact is required.',
            'txt_nationality.required' => 'Nationality is required.',
            'txt_national_id_no.required' => 'NID is required.',
            'txt_present_add.required' => 'Present Add is required.',
            'txt_permanent_add.required' => 'Permanent Add is required.',
            'txt_email_personal.required' => 'Email Personal is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $ci_employee_biodata = DB::table('pro_employee_biodata')->where('employee_id', $request->sele_emp_id)->where('biodata_id','<>',$update)->first();
        // dd($ci_employee_biodata);
        
        if ($ci_employee_biodata === null)
        {

        DB::table('pro_employee_biodata')->where('biodata_id',$update)->update([
            'father_name'=>$request->txt_father_name,
            'mother_name'=>$request->txt_mother_name,
            'dob'=>$request->txt_dob,
            'marital_status_id'=>$request->cbo_marital_status,
            'spouse_name'=>$request->txt_spouse_name,
            'res_contact'=>$request->txt_res_contact,
            'nationality'=>$request->txt_nationality,
            'national_id_no'=>$request->txt_national_id_no,
            'height'=>$request->txt_height,
            'present_add'=>$request->txt_present_add,
            'permanent_add'=>$request->txt_permanent_add,
            'email_personal'=>$request->txt_email_personal,
            'email_office'=>$request->txt_email_office,

            ]);

        return redirect(route('bio_data'))->with('success','Data Updated Successfully!');
        } else {
        return redirect()->back()->withInput()->with('warning','Data already exists!!');  
        }

    }

    public function biodata_file($emp_id)
    {
        return view('hrm.biodata_file',compact('emp_id'));
    }

    public function biodata_file_store(Request $request)
    {


        $m_pic_check = DB::table('pro_employee_biodata')->where("employee_id", $request->txt_employ_id)->first();

        if ($m_pic_check->emp_pic == NULL && $request->hasFile('txt_profile_img') == NULL) {
            return back()->with('profile', 'Profile Picture recuired');
        }


        else if 
        ($request->txt_profile_img == NULL&& 
        $request->txt_nid_front_img == NULL && 
        $request->txt_nid_back_img == NULL && 
        $request->txt_bc_img == NULL)
        {
          return back()->with('warning', 'If you do not update any image please skip');
        }

        if ($request->hasFile('txt_profile_img')) {
            $rules = [
                'txt_profile_img' => 'required|mimes:jpg',
            ];

            $customMessages = [
                'txt_profile_img.required' => 'Profile Picture is required.',
                'txt_profile_img.mimes' => 'Only .jpg',

            ];
            $this->validate($request, $rules, $customMessages);
        }

        $data = array();
        //Profile
        $profile = $request->file('txt_profile_img');
        if ($request->hasFile('txt_profile_img')) {
            $m_profile_hw = getimagesize($profile);
            $m_profile_size = filesize($profile);
            if ($m_profile_size <= 154800 && $m_profile_hw[0] < 301 && $m_profile_hw[1] < 401) {
                //delete previous file
                if ($m_pic_check->emp_pic && $request->hasFile('txt_profile_img') && file_exists($m_pic_check->emp_pic)) {
                    unlink(url("../docupload/imagehrm/$m_pic_check->emp_pic"));
                }
                $filename = $request->txt_employ_id . '.' . $request->file('txt_profile_img')->getClientOriginalExtension();
                $upload_path = "../docupload/imagehrm/profile/";
                $image_url = 'profile/' . $filename;
                $profile->move($upload_path, $filename);
                $data['emp_pic'] = $image_url;
            } else {
                return redirect()->back()->withInput()->with('warning', 'Max Picture Size 150KB and Dimension 300X400');
            }
        }

        //NID Front
        $nid_front = $request->file('txt_nid_front_img');
        if ($request->hasFile('txt_nid_front_img')) {
            $m_nid_front_hw = getimagesize($nid_front);
            $m_nid_front_size = filesize($nid_front);
            if ($m_nid_front_size <= 154800 && $m_nid_front_hw[0] < 301 && $m_nid_front_hw[1] < 251) {
                if ($m_pic_check->nid_front && $request->hasFile('txt_nid_front_img')) {
                    unlink(url("../docupload/imagehrm/$m_pic_check->nid_front"));

                }
                $filename = "$request->txt_employ_id" . '.' . $request->file('txt_nid_front_img')->getClientOriginalExtension();
                $upload_path = "../docupload/imagehrm/nid_front/";
                $image_url = 'nid_front/' . $filename;
                $nid_front->move($upload_path, $filename);
                $data['nid_front'] = $image_url;
            } else {
                return redirect()->back()->withInput()->with('warning', 'Max file Size 150KB and Dimension 300X250');
            }
        }

        //NID Back
        $nid_back = $request->file('txt_nid_back_img');
        if ($request->hasFile('txt_nid_back_img')) {
            $m_nid_back_hw = getimagesize($nid_back);
            $m_nid_back_size = filesize($nid_back);
            if ($m_nid_back_size <= 154800 && $m_nid_back_hw[0] < 301 && $m_nid_back_hw[1] < 251) {
                if ($m_pic_check->nid_back && $request->hasFile('txt_nid_back_img')) {
                    unlink(url("../docupload/imagehrm/$m_pic_check->nid_back"));
                }
                $filename = "$request->txt_employ_id" . '.' . $request->file('txt_nid_back_img')->getClientOriginalExtension();
                $upload_path = "../docupload/imagehrm/nid_back/";
                $image_url = 'nid_back/' . $filename;
                $nid_back->move($upload_path, $filename);
                $data['nid_back'] = $image_url;
            } else {
                return redirect()->back()->withInput()->with('warning', 'Max file Size 150KB and Dimension 300X250');
            }
        }

        //birth_certificate image
        $bc_img = $request->file('txt_bc_img');
        if ($request->hasFile('txt_bc_img')) {
            if ($m_pic_check->bc_img && $request->hasFile('txt_bc_img')) {
                unlink(url("../docupload/imagehrm/$m_pic_check->bc_img"));
            }
            $filename = "$request->txt_employ_id" . '.' . $request->file('txt_bc_img')->getClientOriginalExtension();
            $upload_path = "../docupload/imagehrm/birth_certificate/";
            $image_url = 'birth_certificate/' . $filename;
            $bc_img->move($upload_path, $filename);
            $data['bc_img'] = $image_url;
        }
        // return $data;
        DB::table('pro_employee_biodata')->where("employee_id", $request->txt_employ_id)->update($data);
        return redirect()->route('educational_qualification', $request->txt_employ_id);
    }


    public function educational_qualification($emp_id)
    {
       return view('hrm.educational_qualification',compact('emp_id'));
    }

    public function educational_qualification_store( Request $request)
    {
        $rules = [
            'txt_institute' => 'required',
            'txt_exame_title' => 'required',
            'txt_group' => 'required',
            'txt_result' => 'required',
            'txt_passing_year' => 'required',
        ];

        $customMessages = [
            'txt_institute.required' => 'Institute required.',
            'txt_exame_title.required' => 'Exame Title required.',
            'txt_group.required' => 'Group required.',
            'txt_result.required' => 'Result required.',
            'txt_passing_year.required' => 'Passing Year required.',
        ];
        $this->validate($request, $rules, $customMessages);
        
        $m_user_id=Auth::user()->emp_id;
        $data=array();
        $data['employee_id']=$request->txt_employ_id;
        $data['institute']=$request->txt_institute;
        $data['exame_title']=$request->txt_exame_title;
        $data['edu_group']=$request->txt_group;
        $data['result']=$request->txt_result;
        $data['passing_year']=$request->txt_passing_year;
        $data['status']='1';
        $data['user_id']=$m_user_id;
        $data['valid']='1';
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table('pro_employee_edu')->insert($data);
        return back()->with('success','Successfull Inserted.');
    }

    public function professional_training($emp_id)
    {
       return view('hrm.training',compact('emp_id'));
    }

    public function professional_training_store(Request $request)
    {
        $rules = [
            'txt_institute' => 'required',
            'txt_traning_titel' => 'required',
            'txt_start_date' => 'required',
            'txt_end_date' => 'required',
        ];

        $customMessages = [
            'txt_institute.required' => 'Institute required.',
            'txt_traning_titel.required' => 'Traning Title required.',
            'txt_start_date.required' => 'Start date required.',
            'txt_end_date.required' => 'End date required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        $data=array();
        $data['employee_id']=$request->txt_employ_id;
        $data['institute']=$request->txt_institute;
        $data['address']=$request->txt_address;
        $data['traning_title']=$request->txt_traning_titel;
        $data['start_date']=$request->txt_start_date;
        $data['end_date']=$request->txt_end_date;
        $data['status']='1';
        $data['user_id']=$m_user_id;
        $data['valid']='1';
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table('pro_employee_training')->insert($data);
        return back()->with('success','Successfull Inserted.');
    }

    public function experience($emp_id)
    {
       return view('hrm.experience',compact('emp_id'));
    }
    public function experience_store(Request $request)
    {

        $m_user_id=Auth::user()->emp_id;
        $data=array();
        $data['employee_id']=$request->txt_employ_id;
        $data['organization']=$request->txt_organization;
        $data['address']=$request->txt_address;
        $data['designation']=$request->txt_designation;
        $data['responsibilities']=$request->txt_responsibilities;
        $data['start_date']=$request->txt_start_date;
        $data['end_date']=$request->txt_end_date;
        $data['status']='1';
        $data['user_id']=$m_user_id;
        $data['valid']='1';
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");

        DB::table('pro_employee_experiance')->insert($data);
        return back()->with('success','Successfull Inserted.');  
    }

public function biodata($employee_id)
    {
        // $employee_id=00000472
        $e_biodata = DB::table('pro_employee_biodata')->where('employee_id',$employee_id)->where('valid',1)->first();
        $employee_info = DB::table('pro_employee_info')->where('employee_id',$employee_id)->first();
        $e_edu = DB::table('pro_employee_edu')->where('employee_id',$employee_id)->where('valid',1)->get();
        $e_experiance = DB::table('pro_employee_experiance')->where('employee_id',$employee_id)->where('valid',1)->get();
        $e_training = DB::table('pro_employee_training')->where('employee_id',$employee_id)->where('valid',1)->get();
        return view('hrm.biodata_print', compact('e_biodata','employee_info','e_edu','e_experiance','e_training'));
    }


    // Employee Working Shifts Change
    public function shift_change()
    {
        return view('hrm.shift_change');
    }

    public function shift_change_list(Request $request)
    {
        $m_employee_list = DB::table("pro_employee_info")
            ->Where('company_id', $request->cbo_company_id)
            ->Where('placeofposting_id', $request->sele_placeofposting)
            ->get();

        $m_policy = DB::table('pro_att_policy')
            ->Where('company_id', $request->cbo_company_id)
            ->Where('valid', '1')
            ->orderBy('att_policy_id', 'asc')
            ->get();

        return view('hrm.shift_change', compact('m_employee_list','m_policy'));
    }

    //Ajax call Add Policy
    public function AddPolicy($policy, $employee)
    {
        $prev_policy = DB::table("pro_employee_info")->where("employee_id", $employee)->first();
        //Update
        DB::table("pro_employee_info")->where("employee_id", $employee)->update([
            'att_policy_id' => $policy,
        ]);
        $data = [
            'att_policy_id' => $prev_policy->att_policy_id,
            'employee_id' => $prev_policy->employee_id,
         ];
        return json_encode($data);
    }
    
//salary_info

    public function hrmbacksalary_info()
    {

        $ci_salary=DB::table('pro_salary')->Where('valid','1')->orderBy('employee_id','asc')->get(); //query builder
        return view('hrm.salary_info',compact('ci_salary'));

    }

//employee_clossing

    public function hrmbackemployee_clossing()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder

        return view('hrm.employee_clossing',compact('user_company','m_yesno'));

    }

    //Employee Closing insert
    public function hrmemp_closingstore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,30',
            'cbo_employee_id' => 'required',
            'cbo_yesno_id' => 'required|integer|between:1,2',
            'txt_remarks' => 'required',
            'txt_closing_date' => 'required',
        ];

        $customMessages = [


            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Select Employee.',

            'cbo_yesno_id.required' => 'Select Working Status.',
            'cbo_yesno_id.integer' => 'Select Working Status.',
            'cbo_yesno_id.between' => 'Select Working Status.',

            'txt_remarks.required' => 'Description required.',

            'txt_closing_date.required' => 'Closing Date is required.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $ci_emp_info=DB::table('pro_employee_info')->Where('employee_id',$request->cbo_employee_id)->first();
        $txt_employee_info_id=$ci_emp_info->employee_info_id;
        $txt_employee_name=$ci_emp_info->employee_name;

        $data=array();
        $data['company_id']=$request->cbo_company_id;
        $data['employee_id']=$request->cbo_employee_id;
        $data['employee_name']=$txt_employee_name;
        $data['working_status']=$request->cbo_yesno_id;
        $data['description']=$request->txt_remarks;
        $data['closing_date']=$request->txt_closing_date;
        $data['user_id']=$request->txt_emp_id;
        
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:s");

        // dd($data);
        DB::table('pro_emp_close')->insert($data);

        DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->update([
            'working_status'=>$request->cbo_yesno_id,
            ]);
        return redirect()->back()->with('success','Data Inserted Successfully!');
    }

//employee_clossing

    public function hrm_employee_extension()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder

        return view('hrm.employee_extension',compact('user_company','m_yesno'));

    }

    //Employee Closing insert
    public function hrmemp_extensionstore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,30',
            'cbo_employee_id' => 'required',
            'txt_extension' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Select Employee.',

            'txt_extension.required' => 'Description required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        // $ci_emp_info=DB::table('pro_employee_info')->Where('employee_id',$request->cbo_employee_id)->first();
        // $txt_employee_info_id=$ci_emp_info->employee_info_id;
        // $txt_employee_name=$ci_emp_info->employee_name;

        // $data=array();
        // $data['company_id']=$request->cbo_company_id;
        // $data['employee_id']=$request->cbo_employee_id;
        // $data['employee_name']=$txt_employee_name;
        // $data['working_status']=$request->cbo_yesno_id;
        // $data['description']=$request->txt_remarks;
        // $data['closing_date']=$request->txt_closing_date;
        // $data['user_id']=$request->txt_emp_id;
        
        // //Bangladesh Date and Time Zone
        // date_default_timezone_set("Asia/Dhaka");
        // $data['entry_date'] = date("Y-m-d");
        // $data['entry_time'] = date("h:i:s");

        // dd($data);
        // DB::table('pro_emp_close')->insert($data);

        DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->update([
            'extension'=>$request->txt_extension,
            ]);
        // return redirect(route('data_sync'))->with('success',"$m_sync_date Data Synchronization Successfully!");
        return redirect()->back()->with('success',"$request->cbo_employee_id Data Inserted Successfully!");
    }

//employee_extension

//attn_payroll_status

    public function hrmbackattn_payroll_status()
    {

        return view('hrm.attn_payroll_status');

    }


    public function EmpProfile()
    {
        $m_user_id=Auth::user()->emp_id;

        $m_employee_info = DB::table("pro_employee_info")
        ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->select("pro_employee_info.*", "pro_company.*", "pro_desig.*")

        ->where('employee_id',$m_user_id)
        ->first();
        
        $m_employee_biodata = DB::table("pro_employee_biodata")
        ->where('employee_id',$m_user_id)
        ->first();

        if ($m_employee_biodata === null)
        {
            return redirect()->back()->withInput()->with('warning' , 'Biodata Not exists!!');  

        } else {
            return view('hrm.profile',compact('m_employee_biodata','m_employee_info'));
        // return view('hrm.profile');
        }//if ($m_employee_biodata === null)
    }

    public function ResetPass()
    {

        return view('hrm.changepass');

    }
    public function ResetPassstore(Request $request)
    {
        $rules = [
            'txt_old_pass' => 'required|min:8|max:20',
            'txt_new_pass' => 'required|min:8|max:20',
            'txt_conf_pass' => 'required|min:8|max:20',
               ];

        $customMessages1 = [
            'txt_old_pass.required' => 'Old Password is required.',
            'txt_old_pass.min' => 'Old Password must be at least 8 characters.',
            'txt_old_pass.max' => 'Old Password not more 20 characters.',
            'txt_new_pass.required' => 'New Password is required.',
            'txt_new_pass.min' => 'New Password must be at least 8 characters.',
            'txt_new_pass.max' => 'New Password not more 20 characters.',
            'txt_conf_pass.required' => 'Confirm Password is required.',
            'txt_conf_pass.min' => 'Confirm Password must be at least 8 characters.',
            'txt_conf_pass.max' => 'Confirm Password not more 20 characters.',

        ];        

        $this->validate($request, $rules, $customMessages1);

        $abcd = DB::table('users')->where('emp_id', $request->txt_emp_id)->first();


        if( \Illuminate\Support\Facades\Hash::check( $request->txt_old_pass, $abcd->password) == false)
        {
            //dd('Password is not matching');
            return redirect()->back()->withInput()->with('warning' , 'Sorry old password mismatch!!');
        } else {
            $m_emp_id=$request->txt_emp_id;
            $m_new_pass=$request->txt_new_pass;
            $m_conf_pass=$request->txt_conf_pass;

            if ($m_new_pass == $m_conf_pass)
            {
                DB::table('users')->where('emp_id',$m_emp_id)->update([
                'password'=>Hash::make($m_new_pass),
                'updated_at'=>date('Y-m-d H:i:s')
                ]);
                return redirect(route('changepass'))->with('success','Password Change Successfully!');

            } else {
                return redirect()->back()->withInput()->with('warning' , 'New password and Confirm Password mismatch!!');

            }//if ($m_new_pass == $m_conf_pass)


        } //if( \Illuminate\Support\Facades\Hash::check( $request->txt_old_pass, $abcd->password) == false)
    }


//leave_type

    public function hrmbackleave_type()
    {

        $ci_leave_type=DB::table('pro_leave_type')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder
        return view('hrm.leave_type',compact('ci_leave_type'));

    }

    //Leave Type insert
    public function hrmbackleave_typestore(Request $request)
    {
    $rules = [
            'txt_leave_type' => 'required|max:25|min:4',
            'txt_leave_type_sname' => 'required|max:5|min:2',
        ];

        $customMessages = [

            'txt_leave_type.required' => 'Leave Type is required.',
            'txt_leave_type.min' => 'Leave Type must be at least 4 characters.',
            'txt_leave_type.max' => 'Leave Type less then 25 characters.',

            'txt_leave_type_sname.required' => 'Short Name is required.',
            'txt_leave_type_sname.min' => 'Short Name must be at least 2 characters.',
            'txt_leave_type_sname.max' => 'Short Name less then 5 characters.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['leave_type']=$request->txt_leave_type;
        $data['leave_type_sname']=$request->txt_leave_type_sname;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;

        //dd($data);
        DB::table('pro_leave_type')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');
    }


    public function hrmbackleave_typeedit($id)
    {
        $m_leave_type=DB::table('pro_leave_type')->where('leave_type_id',$id)->first();
        $data=DB::table('pro_leave_type')->where('valid','1')->get();
        return view('hrm.leave_type',compact('data','m_leave_type'));
    }

    public function hrmbackleave_typeupdate(Request $request,$update)
    {

    $rules = [
            'txt_leave_type' => 'required|max:25|min:4',
            'txt_leave_type_sname' => 'required|max:5|min:2',
        ];

        $customMessages = [

            'txt_leave_type.required' => 'Leave Type is required.',
            'txt_leave_type.min' => 'Leave Type must be at least 4 characters.',
            'txt_leave_type.max' => 'Leave Type less then 25 characters.',

            'txt_leave_type_sname.required' => 'Short Name is required.',
            'txt_leave_type_sname.min' => 'Short Name must be at least 2 characters.',
            'txt_leave_type_sname.max' => 'Short Name less then 5 characters.',
        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_leave_type')->where('leave_type_id',$update)->update([
            'leave_type'=>$request->txt_leave_type,
            'leave_type_sname'=>$request->txt_leave_type_sname,
            ]);

        return redirect(route('leave_type'))->with('success','Data Updated Successfully!');
    }



//leave_config

    public function hrmbackleave_config()
    {

        $ci_leave_config=DB::table('pro_leave_config')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder
        return view('hrm.leave_config',compact('ci_leave_config'));

    }

    //Leave Config insert
    public function hrmbackleave_configstore(Request $request)
    {
    $rules = [
            
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_leave_days' => 'required|numeric|min:1',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_leave_days.required' => 'Leave Type is required.',
            'txt_leave_days.min' => 'Leave Type must be at least 1 characters.',
            'txt_leave_days.numeric' => 'Leave Type Numeric.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $data=array();
        $data['leave_type_id']=$request->sele_leave_type;
        $data['leave_days']=$request->txt_leave_days;
        $data['user_id']=$request->txt_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=$m_valid;

        //dd($data);
        DB::table('pro_leave_config')->insert($data);
        return redirect()->back()->with('success','Data Inserted Successfully!');

    }

    public function hrmbackleave_configedit($id)
    {
        $m_leave_config=DB::table('pro_leave_config')->where('leave_config_id',$id)->first();
        $data=DB::table('pro_leave_config')->where('valid','1')->get();
        return view('hrm.leave_config',compact('data','m_leave_config'));
    }

    public function hrmbackleave_configupdate(Request $request,$update)
    {

    $rules = [
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_leave_days' => 'required|numeric|min:1',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_leave_days.required' => 'Leave Type is required.',
            'txt_leave_days.min' => 'Leave Type must be at least 1 characters.',
            'txt_leave_days.numeric' => 'Leave Type Numeric.',
        ];        

        $this->validate($request, $rules, $customMessages);

        $abcd = DB::table('pro_leave_config')->where('leave_type_id', $request->sele_leave_type)->first();
                
        DB::table('pro_leave_config')->where('leave_config_id',$update)->update([
            'leave_days'=>$request->txt_leave_days,
            ]);

        return redirect(route('leave_config'))->with('success','Data Updated Successfully!');

    }


//leave_application

    public function hrmbackleave_application()
    {
        $m_user_id = Auth::user()->emp_id;
        $mentrydate=time();
        $m_leave_year=date("Y",$mentrydate);

        $ci_leave_config_01=DB::table('pro_leave_config')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder

        $m_leave_info_master = DB::table('pro_leave_info_master')
        ->Where('employee_id',$m_user_id)
        ->Where('valid','1')
        ->Where('leave_year',$m_leave_year)
        ->Where('edit_status','1')
        // ->orderby('leave_form', 'DESC')
        ->get();


        return view('hrm.leave_application',compact('ci_leave_config_01','m_leave_info_master'));

    }

    //Leave Application insert
    public function hrmbackleave_applicationstore(Request $request)
    {
    $rules = [
            
            'sele_leave_type' => 'required|integer|between:1,10',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_purpose_leave' => 'required',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_from_date.required' => 'Leave Start Date is required.',
            'txt_to_date.required' => 'Leave End Date is required.',
            'txt_purpose_leave.required' => 'Leave Purpose is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';
        $m_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $txt_from_date=$request->txt_from_date;
        $txt_from_date1=date("m-d",strtotime($txt_from_date));
        $txt_to_date=$request->txt_to_date;
        $txt_to_date1=date("m-d",strtotime($txt_to_date));

        $c_year=date("Y",$mentrydate);
        //$c_year="2021";
        // $m_date=date("m-d",$mentrydate);
        $form_year=substr($txt_from_date,0,4);
        $to_year=substr($txt_to_date,0,4);

        // $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        // $txt_total_days = floor($diff / (1*60*60*24)+1);
        $txt_total_days = $request->txt_total;
        // //dd($txt_total_days);
        $txt_leave_type=$request->sele_leave_type;
        // dd("$request->txt_total");
        if ($form_year!=$to_year)
        {

            return redirect()->back()->withInput()->with('warning' , 'year mismatch!!');

        } else {
            if ($form_year!=$c_year)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
            } else {

            $ci_pro_leave_config=DB::table('pro_leave_config')->Where('leave_type_id',$request->sele_leave_type)->first();
            $txt_app_day=$ci_pro_leave_config->app_day;

                if ($txt_total_days>$txt_app_day)
                {
                return redirect()->back()->withInput()->with('warning',"You Choose more than $txt_app_day Days");
                } else {

                $ci_pro_cl_policy=DB::table('pro_cl_policy')->Where('cl_start','<=',$txt_from_date1)->Where('cl_end','>=',$txt_to_date1)->where('leave_type_id',$request->sele_leave_type)->first();
                // dd($ci_pro_cl_policy);
                if ($ci_pro_cl_policy)
                {

                    $ci_leave_info_master=DB::table('pro_leave_info_master')->Where('employee_id',$request->txt_user_id)->whereBetween('leave_form',[$txt_from_date,$txt_to_date])->first();
                    // $txt_employee_id=$ci_emp_info->employee_id;
                    // $txt_employee_name=$ci_emp_info->employee_name;
                    // dd($ci_leave_info_master);
                    if ($ci_leave_info_master===null)
                    {
                        
                        // $ci_leave_config=DB::table('pro_leave_config')->Where('leave_type_id',$txt_leave_type)->first();
                        // $txt_leave_days=$ci_leave_config->leave_days;
                        $txt_leave_days=$ci_pro_leave_config->leave_days;

                        $ci_leave_info_master=DB::table('pro_leave_info_master')->Where('leave_type_id',$txt_leave_type)->where('employee_id',$request->txt_user_id)->where('valid',1)->where('leave_year',$c_year)->orderby('leave_type_id')->get();

                        $m_avail_day = collect($ci_leave_info_master)->sum('g_leave_total'); // 60
                            // dd($sum);
                        $m_available=$txt_leave_days-$m_avail_day;
                        
                        if ($m_available>$txt_total_days)
                        {

                        $data=array();
                        $data['employee_id']=$request->txt_user_id;
                        $data['company_id']=$request->txt_company_id;
                        $data['desig_id']=$request->txt_desig_id;
                        $data['leave_type_id']=$request->sele_leave_type;
                        $data['leave_form']=$request->txt_from_date;
                        $data['leave_to']=$request->txt_to_date;
                        $data['leave_year']=$c_year;
                        $data['total']=$txt_total_days;
                        $data['purpose_leave']=$request->txt_purpose_leave;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['status']=$m_status;
                        $data['valid']=$m_valid;
                        $data['user_id']=$request->txt_user_id;

                        //dd($data);
                        DB::table('pro_leave_info_master')->insert($data);

                        $massage="$request->txt_user_id Leave Application";
                        DB::table('pro_alart_massage')->insert([
                        'message_id'=>$request->txt_user_id,
                        'report_id'=>'00000130',
                        'massage'=>$massage,
                        'valid'=>1,
                        'entry_date'=>$m_entry_date,
                        'entry_time'=>$m_entry_time,
                        ]);


                        return redirect()->back()->with('success','Data Inserted Successfully!');

                        } else {
                        return redirect()->back()->withInput()->with('warning','Sorry selected leave type not available');    
                        } //if ($m_available>$txt_total_days)

                    } else {
                        return redirect()->back()->withInput()->with('warning','Allready Applied');
                    } //if ($ci_leave_info_master===null)
                } else {
                    return redirect()->back()->withInput()->with('warning',"You Choose more no wwwww");
                } //if ($ci_pro_cl_policy)


                } //if ($txt_total_days>$txt_app_day)
            } //if ($form_year!=$c_year)

        } //if ($form_year!=$to_year)

    }

public function HrmLleaveAppEdit($id)
    {
        
        $m_user_id = Auth::user()->emp_id;
        $mentrydate=time();
        $m_leave_year=date("Y",$mentrydate);

        $ci_leave_info_master = DB::table('pro_leave_info_master')
        ->Where('leave_info_master_id',$id)
        ->first();

        $m_leave_type = DB::table('pro_leave_type')->Where('valid','1')->get();

        return view('hrm.leave_application',compact('ci_leave_info_master','m_leave_type'));
    }

public function HrmLeaveAppUpdate(Request $request,$update)
// public function HrmLeaveAppUpdate(Request $request)
    {      
        DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
            'leave_type_id'=>$request->sele_leave_type,
            'leave_form'=>$request->txt_from_date,
            'leave_to'=>$request->txt_to_date,
            // 'leave_year'=>$request->txt_company_city,
            'total'=>$request->txt_total,
            'purpose_leave'=>$request->txt_purpose_leave,
        ]);
        return redirect(route('leave_application'))->with('success','Data Updated Successfully!');
    }



//leave_approval
// $m_user_id=Auth::user()->emp_id;
    public function hrmbackleave_approval()
    {
        $m_user_id=Auth::user()->emp_id;

        $mentrydate=time();
        $m_leave_year=date("Y",$mentrydate);

        $ci_report=DB::table('pro_level_step')
        ->leftjoin("pro_employee_info", "pro_level_step.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        ->select("pro_level_step.*","pro_employee_info.employee_name","pro_employee_info.mobile", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
        ->Where('pro_level_step.valid','1')
        // ->Where('status','1')
        ->Where('pro_level_step.report_to_id',$m_user_id)
        ->orderBy('pro_level_step.employee_id','DESC')
        ->get();


        // $ci_report = DB::table("pro_employee_info")
        //     ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        //     ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        //     ->join("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        //     ->select("pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
        //     // ->Where('report_to_id',$m_user_id)
        //     ->get();
        

        return view('hrm.leave_approval',compact('ci_report','m_user_id','m_leave_year'));

        // return view('hrm.leave_approval');

    }

    public function hrmleave_app_approval($id)
    {

        $m_leave_info_master=DB::table('pro_leave_info_master')->where('leave_info_master_id',$id)->first();
        // $data=DB::table('pro_leave_info_master')->where('valid','1')->get();
        $m_yesno=DB::table('pro_yesno')->where('valid','1')->get();
        return view('hrm.leave_app_for_approval',compact('m_leave_info_master','m_yesno'));
    }

    public function hrmleave_appupdate(Request $request,$update)
    {

    $rules = [
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'cbo_approved_status' => 'required|integer|between:1,10',
        ];

        $customMessages = [

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_from_date.required' => 'From Date is required.',
            'txt_to_date.required' => 'To Date is required.',

            'cbo_approved_status.required' => 'Select Approved Status.',
            'cbo_approved_status.integer' => 'Select Approved Status.',
            'cbo_approved_status.between' => 'Select Approved Status.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // $txt_leave_status='1';
        $m_user_id=Auth::user()->emp_id;
        $m_valid=1;

        $ci_level_step=DB::table('pro_level_step')
            ->Where('valid','1')
            ->Where('employee_id',$request->txt_employee_id)
            ->Where('report_to_id',$m_user_id)
            ->first();

        $m2_level_step=$ci_level_step->level_step;

        if($request->cbo_approved_status=='1')
        {
            
            for($d=0; $d<$request->txt_total; $d++)
            {
            
            $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

            $data=array();
            $data['leave_info_master_id']=$request->txt_leave_info_master_id;
            $data['employee_id']=$request->txt_employee_id;
            $data['company_id']=$request->txt_company_id;
            $data['desig_id']=$request->txt_desig_id;
            $data['leave_type_id']=$request->sele_leave_type;
            $data['leave_date']=$atdate;
            $data['total']=$request->txt_total;
            $data['approved_id']=$request->txt_user_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid']=$m_valid;
            $data['approved_level']=$m2_level_step;

            //dd($data);
            DB::table('pro_leave_approved_details')->insert($data);
            
            }//for($d==1; $d<=txt_total_days; $d++)
            $m_edit_status='2';
            DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
            'approved_level'=>$m2_level_step,
            'edit_status'=>$m_edit_status,
            ]);

            $ci_employee_info=DB::table('pro_employee_info')
                ->Where('valid','1')
                ->Where('employee_id',$request->txt_employee_id)
                ->first();

            $ci_level_step1=DB::table('pro_level_step')
                ->Where('valid','1')
                ->Where('employee_id',$request->txt_employee_id)
                ->Where('report_to_id',$m_user_id)
                ->first();

            $ci_leave_info_master=DB::table('pro_leave_info_master')
                ->Where('leave_info_master_id',$request->txt_leave_info_master_id)
                ->first();


                $m1_level_step=$ci_employee_info->level_step;
                $m2_level_step1=$ci_level_step1->level_step;
                $m_approved_level=$ci_leave_info_master->approved_level;
                // dd("$m1_level_step -- $m2_level_step -- $m_approved_level");


            // if($m1_level_step==$m_approved_level)
            if($m_approved_level==1)
            {
                for($dd=0; $dd<$request->txt_total; $dd++)
                {
                
                $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$dd.' days'));

                $data=array();
                $data['leave_info_master_id']=$request->txt_leave_info_master_id;
                $data['employee_id']=$request->txt_employee_id;
                $data['company_id']=$request->txt_company_id;
                $data['desig_id']=$request->txt_desig_id;
                $data['leave_type_id']=$request->sele_leave_type;
                $data['leave_date']=$atdate;
                $data['total']=$request->txt_total;
                $data['approved_id']=$request->txt_user_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid']=$m_valid;
                // $data['level_step']=$m2_level_step1;

                //dd($data);
                DB::table('pro_leave_info_details')->insert($data);
            
                }//for($dd==1; $dd<=txt_total_days; $dd++)

                $m_status=2;
                DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
                'approved_level'=>$m2_level_step1,
                'status'=>$m_status,
                'g_leave_form'=>$request->txt_from_date,
                'g_leave_to'=>$request->txt_to_date,
                'g_leave_total'=>$request->txt_total,
                'leave_approved'=>$m_user_id,
                // date_default_timezone_set("Asia/Dhaka");
                'approved_date'=>date("Y-m-d"),
                
                ]);


            }


            return redirect(route('leave_approval'))->with('success','Leave Application  Approved');
        } else {
            $m_status=3;

            DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
            'status'=>$m_status,
            'leave_approved'=>$m_user_id,
            // date_default_timezone_set("Asia/Dhaka");
            'approved_date'=>date("Y-m-d"),
            ]);

            return redirect(route('leave_approval'))->with('success','Leave Application Cancel');

        }
    }

    public function HrmLeaveApplicationOp()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $ci_leave_config_01=DB::table('pro_leave_config')->Where('valid','1')->orderBy('leave_type_id','asc')->get(); //query builder
        return view('hrm.leave_application_op',compact('ci_leave_config_01','user_company'));

    }

    //Leave Application insert
    public function HrmLeaveApplicationOpStore(Request $request)
    {
    $rules = [
            
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_employee_id' => 'required',
            'sele_leave_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_purpose_leave' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select  Company.',

            'cbo_employee_id.required' => 'Select Employee.',

            'sele_leave_type.required' => 'Select Leave Type.',
            'sele_leave_type.integer' => 'Select Leave Type.',
            'sele_leave_type.between' => 'Chose  Leave Type.',

            'txt_from_date.required' => 'Leave Start Date is required.',
            'txt_to_date.required' => 'Leave End Date is required.',
            'txt_purpose_leave.required' => 'Leave Purpose is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;
        $m_valid='1';
        $m_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $txt_from_date=$request->txt_from_date;
        $txt_from_date1=date("m-d",strtotime($txt_from_date));
        $txt_to_date=$request->txt_to_date;
        $txt_to_date1=date("m-d",strtotime($txt_to_date));

        $c_year=date("Y",$mentrydate);
        //$c_year="2021";
        // $m_date=date("m-d",$mentrydate);
        $form_year=substr($txt_from_date,0,4);
        $to_year=substr($txt_to_date,0,4);

        // $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        // $txt_total_days = floor($diff / (1*60*60*24)+1);
        $txt_total_days = $request->txt_total;
        // //dd($txt_total_days);
        $txt_leave_type=$request->sele_leave_type;
        // dd("$request->txt_total");
        if ($form_year!=$to_year)
        {

            return redirect()->back()->withInput()->with('warning' , 'year mismatch!!');

        } else {
            if ($form_year!=$c_year)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
            } else {

            $ci_pro_leave_config=DB::table('pro_leave_config')->Where('leave_type_id',$request->sele_leave_type)->first();
            $txt_app_day=$ci_pro_leave_config->app_day;

                if ($txt_total_days>$txt_app_day)
                {
                return redirect()->back()->withInput()->with('warning',"You Choose more than $txt_app_day Days");
                } else {

                $ci_pro_cl_policy=DB::table('pro_cl_policy')->Where('cl_start','<=',$txt_from_date1)->Where('cl_end','>=',$txt_to_date1)->where('leave_type_id',$request->sele_leave_type)->first();
                // dd($ci_pro_cl_policy);
                if ($ci_pro_cl_policy)
                {

                    $ci_leave_info_master=DB::table('pro_leave_info_master')->Where('employee_id',$request->txt_user_id)->whereBetween('leave_form',[$txt_from_date,$txt_to_date])->first();
                    // $txt_employee_id=$ci_emp_info->employee_id;
                    // $txt_employee_name=$ci_emp_info->employee_name;
                    // dd($ci_leave_info_master);
                    if ($ci_leave_info_master===null)
                    {
                        
                        // $ci_leave_config=DB::table('pro_leave_config')->Where('leave_type_id',$txt_leave_type)->first();
                        // $txt_leave_days=$ci_leave_config->leave_days;
                        $txt_leave_days=$ci_pro_leave_config->leave_days;

                        $ci_leave_info_master=DB::table('pro_leave_info_master')->Where('leave_type_id',$txt_leave_type)->where('employee_id',$request->txt_user_id)->where('valid',1)->where('leave_year',$c_year)->orderby('leave_type_id')->get();

                        $m_avail_day = collect($ci_leave_info_master)->sum('g_leave_total'); // 60
                            // dd($sum);
                        $m_available=$txt_leave_days-$m_avail_day;
                        
                        if ($m_available>$txt_total_days)
                        {

                        $data=array();
                        $data['employee_id']=$request->cbo_employee_id;
                        $data['company_id']=$request->cbo_company_id;
                        $data['desig_id']=$request->txt_desig_id;
                        $data['leave_type_id']=$request->sele_leave_type;
                        $data['leave_form']=$request->txt_from_date;
                        $data['leave_to']=$request->txt_to_date;
                        $data['leave_year']=$c_year;
                        $data['total']=$txt_total_days;
                        $data['purpose_leave']=$request->txt_purpose_leave;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['status']=$m_status;
                        $data['valid']=$m_valid;
                        $data['user_id']=$m_user_id;

                        //dd($data);
                        DB::table('pro_leave_info_master')->insert($data);
                        return redirect()->back()->with('success','Data Inserted Successfully!');

                        } else {
                        return redirect()->back()->withInput()->with('warning','Sorry selected leave type not available');    
                        } //if ($m_available>$txt_total_days)

                    } else {
                        return redirect()->back()->withInput()->with('warning','Allready Applied');
                    } //if ($ci_leave_info_master===null)
                } else {
                    return redirect()->back()->withInput()->with('warning',"You Choose more no wwwww");
                } //if ($ci_pro_cl_policy)


                } //if ($txt_total_days>$txt_app_day)
            } //if ($form_year!=$c_year)

        } //if ($form_year!=$to_year)

    }

 public function hrmbackleave_approval_others(){

        $m_user_id=Auth::user()->emp_id;

        $mentrydate=time();
        $m_leave_year=date("Y",$mentrydate);

        $ci_list=DB::table('pro_leave_info_master')
        ->leftjoin("pro_employee_info", "pro_leave_info_master.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        ->select("pro_leave_info_master.*","pro_employee_info.employee_name","pro_employee_info.mobile", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
        ->Where('pro_leave_info_master.valid','1')
        ->Where('pro_leave_info_master.status','1')
        // ->Where('pro_level_step.report_to_id',$m_user_id)
        // ->orderBy('pro_level_step.employee_id','asc')
        ->get();

        return view('hrm.leave_approval_others',compact('ci_list','m_user_id','m_leave_year'));
    }
    public function hrmbackleave_app_for_approval_other($id)
    {

        $m_leave_info_master=DB::table('pro_leave_info_master')->where('leave_info_master_id',$id)->first();
        // $data=DB::table('pro_leave_info_master')->where('valid','1')->get();

        $m_approved_id = DB::table('pro_leave_approved_details')
        ->where('leave_info_master_id', $id)
        // ->where('approved_level', 2)
        ->pluck('approved_id');

         $ci_report=DB::table('pro_level_step')
        ->leftjoin("pro_employee_info", "pro_level_step.report_to_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")

        ->select("pro_level_step.*","pro_employee_info.*", "pro_desig.desig_name")
        ->Where('pro_level_step.valid','1')
        // ->Where('status','1')
        ->Where('pro_level_step.employee_id',$m_leave_info_master->employee_id)
        ->WhereNotIn('pro_level_step.report_to_id',$m_approved_id)
        ->orderBy('pro_level_step.level_step','DESC')
        ->get();


        return view('hrm.leave_app_for_approval_other',compact('m_leave_info_master','ci_report'));
    }

    public function leave_app_for_approval_other_update(Request $request,$update)
    {

    $rules = [
           
            'cbo_approved_id' => 'required',
        ];

        $customMessages = [

            // 'sele_leave_type.required' => 'Select Leave Type.',
            // 'sele_leave_type.integer' => 'Select Leave Type.',
            // 'sele_leave_type.between' => 'Chose  Leave Type.',

            // 'txt_from_date.required' => 'From Date is required.',
            // 'txt_to_date.required' => 'To Date is required.',

            'cbo_approved_id.required' => 'Select Report To.',
            // 'cbo_approved_status.integer' => 'Select Approved Status.',
            // 'cbo_approved_status.between' => 'Select Approved Status.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // $txt_leave_status='1';
        $m_user_id=Auth::user()->emp_id;
        $m_valid=1;
        

        $ci_level_step=DB::table('pro_level_step')
            ->Where('valid','1')
            ->Where('employee_id',$request->txt_employee_id)
            ->Where('report_to_id',$request->cbo_approved_id)
            ->first();

        $m2_level_step=$ci_level_step->level_step;

                    
            for($d=0; $d<$request->txt_total; $d++)
            {
            
            $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

            $data=array();
            $data['leave_info_master_id']=$request->txt_leave_info_master_id;
            $data['employee_id']=$request->txt_employee_id;
            $data['company_id']=$request->txt_company_id;
            $data['desig_id']=$request->txt_desig_id;
            $data['leave_type_id']=$request->sele_leave_type;
            $data['leave_date']=$atdate;
            $data['total']=$request->txt_total;
            $data['approved_id']=$request->cbo_approved_id;
            $data['user_id']=$m_user_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid']=$m_valid;
            $data['approved_level']=$m2_level_step;

            //dd($data);
            DB::table('pro_leave_approved_details')->insert($data);
            
            }//for($d==1; $d<=txt_total_days; $d++)
            $m_edit_status='2';
            DB::table('pro_leave_info_master')->where('leave_info_master_id',$update)->update([
            'approved_level'=>$m2_level_step,
            'edit_status'=>$m_edit_status,
            ]);

            return back()->with('success','Leave Application Approved');
        

    }

    public function leave_app_for_approval_upload($id){

     $m_leave_info_master=DB::table('pro_leave_info_master')->where('leave_info_master_id',$id)->first();

      return view('hrm.leave_app_for_approval_upload',compact('m_leave_info_master'));
    }

    public function leave_file_store(Request $request,$id){

        $rules = [
            'txt_file' => 'required',
        ];

        $customMessages = [
            'txt_file.required' => 'File is required.',
        ];        

        $this->validate($request, $rules, $customMessages);
        $m_leave_info_master=DB::table('pro_leave_info_master')->where('leave_info_master_id',$id)->first();

        $m_user_id=Auth::user()->emp_id;
        $m_valid=1;

        $data=array();

        $txt_doc_file = $request->file('txt_file');
            if ($request->hasFile('txt_file')) {
                
                $filename = $id . '.' . $request->file('txt_file')->getClientOriginalExtension();

                $upload_path = "../docupload/sqgroup/leaveapp/";

                // $image_url = "$upload_path/" . $filename;
                $txt_doc_file->move($upload_path, $filename);
                $data['approved_file'] = $filename;
            }

            DB::table('pro_leave_info_master')
            ->where('leave_info_master_id',$id)
            ->update($data);

                for($dd=0; $dd<$m_leave_info_master->total; $dd++)
                {
                
                $atdate = date('Y-m-d', strtotime($m_leave_info_master->leave_form.' + '.$dd.' days'));

                $data=array();
                $data['leave_info_master_id']=$id;
                $data['employee_id']=$m_leave_info_master->employee_id;
                $data['company_id']=$m_leave_info_master->company_id;
                $data['desig_id']=$m_leave_info_master->desig_id;
                $data['leave_type_id']=$m_leave_info_master->leave_type_id;
                $data['leave_date']=$atdate;
                $data['total']=$m_leave_info_master->total;
                // $data['approved_id']=$request->txt_user_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid']=$m_valid;
                // $data['level_step']=$m2_level_step1;

                //dd($data);
                DB::table('pro_leave_info_details')->insert($data);
            
                }//for($dd==1; $dd<=txt_total_days; $dd++)

                $m_status=2;
                DB::table('pro_leave_info_master')->where('leave_info_master_id',$id)->update([
                // 'approved_level'=>$m2_level_step1,
                'status'=>$m_status,
                'g_leave_form'=>$request->leave_form,
                'g_leave_to'=>$m_leave_info_master->leave_to,
                'g_leave_total'=>$m_leave_info_master->total,
                'approved_user_id'=>$m_user_id,
                // date_default_timezone_set("Asia/Dhaka");
                'approved_date'=>date("Y-m-d"),
                
                ]);

    return redirect()->route('leave_approval_others');

    }

//movement

    public function hrmbackmovement()
    {

        $m_user_id=Auth::user()->emp_id;

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $c_year=date("Y",$mentrydate);

        $ci_late_inform_master=DB::table('pro_late_inform_master')
        ->Where('employee_id',$m_user_id)
        ->Where('valid','1')
        ->Where('late_year',$c_year)
        ->orderBy('late_inform_master_id','DESC')
        ->get(); //query builder

        $m_level_step = DB::table('pro_level_step')
        ->join("pro_employee_info", "pro_level_step.report_to_id", "pro_employee_info.employee_id")
        ->select("pro_level_step.*", "pro_employee_info.employee_name")
        ->Where('pro_level_step.employee_id',$m_user_id)
        ->Where('pro_level_step.valid','1')
        ->orderby('pro_level_step.level_step', 'ASC')
        ->get();


        return view('hrm.movement',compact('ci_late_inform_master','m_level_step'));
        // return view('hrm.movement');
    }

    //Movement Application insert
    public function hrmlate_applicationstore(Request $request)
    {
    $rules = [
            
            'sele_late_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_purpose_late' => 'required',
        ];

        $customMessages = [

            'sele_late_type.required' => 'Select Late Type.',
            'sele_late_type.integer' => 'Select Late Type.',
            'sele_late_type.between' => 'Chose  Late Type.',

            'txt_from_date.required' => 'Late Start Date is required.',
            'txt_to_date.required' => 'Late End Date is required.',
            'txt_purpose_leave.required' => 'Late Purpose is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;
        $m_valid='1';
        $m_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $txt_from_date=$request->txt_from_date;
        // $txt_from_date1=date("m-d",strtotime($txt_from_date));
        $txt_to_date=$request->txt_to_date;
        // $txt_to_date1=date("m-d",strtotime($txt_to_date));

        $c_year=date("Y",$mentrydate);
        $form_year=substr($txt_from_date,0,4);
        $to_year=substr($txt_to_date,0,4);

        $txt_total_days = $request->txt_total;
        $txt_leave_type=$request->sele_leave_type;
        if ($form_year!=$to_year)
        {

            return redirect()->back()->withInput()->with('warning' , 'year mismatch!!');

        } else {
            if ($form_year!=$c_year)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
            } else {

            $ci_late_type=DB::table('pro_late_type')->Where('late_type_id',$request->sele_late_type)->first();
            $txt_late_day=$ci_late_type->late_day;

                if ($txt_total_days>$txt_late_day)
                {
                return redirect()->back()->withInput()->with('warning',"You Choose more than $txt_late_day Days");
                } else {


                    // $ci_late_inform_master=DB::table('pro_late_inform_master')
                    // ->Where('employee_id',$request->txt_user_id)
                    // ->whereBetween('late_form',[$txt_from_date,$txt_to_date])
                    // ->first();

                    $ci_late_inform_master_02=DB::table('pro_late_inform_master_02')
                    ->Where('employee_id',$request->txt_user_id)
                    ->whereBetween('late_date',[$txt_from_date,$txt_to_date])
                    ->first();


                    if ($ci_late_inform_master_02===null)
                    {
                        
                        $data=array();
                        $data['employee_id']=$request->txt_user_id;
                        // $data['report_to_id']=$request->txt_report_to_id;
                        $data['company_id']=$request->txt_company_id;
                        $data['desig_id']=$request->txt_desig_id;
                        $data['department_id']=$request->txt_department_id;
                        $data['section_id']=$request->txt_section_id;
                        $data['placeofposting_id']=$request->txt_placeofposting_id;
                        $data['late_type_id']=$request->sele_late_type;
                        $data['late_form']=$request->txt_from_date;
                        $data['late_to']=$request->txt_to_date;
                        $data['late_year']=$c_year;
                        $data['late_total']=$txt_total_days;
                        $data['purpose_late']=$request->txt_purpose_late;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['status']=$m_status;
                        $data['valid']=$m_valid;
                        $data['user_id']=$m_user_id;

                        //dd($data);
                        DB::table('pro_late_inform_master')->insert($data);

                        $m_late_inform_master_id = DB::table("pro_late_inform_master")
                        ->where('valid','1')
                        ->max('late_inform_master_id');

                        for($d=0; $d<$request->txt_total; $d++)
                        {
                        
                        $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

                        $data=array();
                        $data['late_inform_master_id']=$m_late_inform_master_id;
                        $data['employee_id']=$request->txt_user_id;
                        $data['company_id']=$request->txt_company_id;
                        $data['desig_id']=$request->txt_desig_id;
                        $data['late_type_id']=$request->sele_late_type;
                        $data['late_date']=$atdate;
                        $data['late_total']=$request->txt_total;
                        $data['user_id']=$m_user_id;
                        $data['entry_date'] = date("Y-m-d");
                        $data['entry_time'] = date("h:i:sa");
                        $data['valid']=$m_valid;

                        //dd($data);
                        DB::table('pro_late_inform_master_02')->insert($data);
                        
                        }//for($d==1; $d<=txt_total_days; $d++)

                        return redirect()->back()->with('success','Data Inserted Successfully!');

                    } else {

                        if($request->sele_late_type>3 || $request->sele_late_type==2 )
                        {
                            return redirect()->back()->withInput()->with('warning',"You Can not applied for oooo absent");
                        }

                        elseif($request->sele_late_type==1)
                        {
                             $ci_late_inform_master_late=DB::table('pro_late_inform_master_02')
                            ->Where('employee_id',$request->txt_user_id)
                            ->where('late_date',$request->txt_from_date)
                            ->WhereIn('late_type_id',['1','2'])
                            ->first();
// dd($ci_late_inform_master_late);


                            if($ci_late_inform_master_late===null)
                            {


                                // dd("insert late 111");
                                $data=array();
                                $data['employee_id']=$request->txt_user_id;
                                $data['company_id']=$request->txt_company_id;
                                $data['desig_id']=$request->txt_desig_id;
                                $data['department_id']=$request->txt_department_id;
                                $data['section_id']=$request->txt_section_id;
                                $data['placeofposting_id']=$request->txt_placeofposting_id;
                                $data['late_type_id']=$request->sele_late_type;
                                $data['late_form']=$request->txt_from_date;
                                $data['late_to']=$request->txt_to_date;
                                $data['late_year']=$c_year;
                                $data['late_total']=$txt_total_days;
                                $data['purpose_late']=$request->txt_purpose_late;
                                $data['entry_date']=$m_entry_date;
                                $data['entry_time']=$m_entry_time;
                                $data['status']=$m_status;
                                $data['valid']=$m_valid;
                                $data['user_id']=$m_user_id;

                                //dd($data);
                                DB::table('pro_late_inform_master')->insert($data);

                                $m_late_inform_master_id = DB::table('pro_late_inform_master')
                                ->where('valid','1')
                                ->max('late_inform_master_id');

                                for($d=0; $d<$request->txt_total; $d++)
                                {
                                
                                $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

                                $data=array();
                                $data['late_inform_master_id']=$m_late_inform_master_id;
                                $data['employee_id']=$request->txt_user_id;
                                $data['company_id']=$request->txt_company_id;
                                $data['desig_id']=$request->txt_desig_id;
                                $data['late_type_id']=$request->sele_late_type;
                                $data['late_date']=$atdate;
                                $data['late_total']=$request->txt_total;
                                $data['user_id']=$m_user_id;
                                $data['entry_date'] = date("Y-m-d");
                                $data['entry_time'] = date("h:i:sa");
                                $data['valid']=$m_valid;

                                //dd($data);
                                DB::table('pro_late_inform_master_02')->insert($data);
                                
                                }//for($d==1; $d<=txt_total_days; $d++)

                                return redirect()->back()->with('success','Data Inserted Successfully!');

                            } else {
                                return redirect()->back()->withInput()->with('warning',"You allready applied for Late");
                            }//if($ci_late_inform_master_late===null)
                        }//if($request->sele_late_type==1)

                        elseif($request->sele_late_type==3)
                        {
                             $ci_late_inform_master_early=DB::table('pro_late_inform_master_02')
                            ->Where('employee_id',$request->txt_user_id)
                            ->where('late_date',$request->txt_from_date)
                            ->WhereIn('late_type_id',['3','2'])
                            ->first();

                            if($ci_late_inform_master_early===null)
                            {
                                // dd("insert Early");
                                $data=array();
                                $data['employee_id']=$request->txt_user_id;
                                $data['company_id']=$request->txt_company_id;
                                $data['desig_id']=$request->txt_desig_id;
                                $data['department_id']=$request->txt_department_id;
                                $data['section_id']=$request->txt_section_id;
                                $data['placeofposting_id']=$request->txt_placeofposting_id;
                                $data['late_type_id']=$request->sele_late_type;
                                $data['late_form']=$request->txt_from_date;
                                $data['late_to']=$request->txt_to_date;
                                $data['late_year']=$c_year;
                                $data['late_total']=$txt_total_days;
                                $data['purpose_late']=$request->txt_purpose_late;
                                $data['entry_date']=$m_entry_date;
                                $data['entry_time']=$m_entry_time;
                                $data['status']=$m_status;
                                $data['valid']=$m_valid;
                                $data['user_id']=$m_user_id;

                                //dd($data);
                                DB::table('pro_late_inform_master')->insert($data);

                                $m_late_inform_master_id = DB::table('pro_late_inform_master')
                                ->where('valid','1')
                                ->max('late_inform_master_id');

                                for($d=0; $d<$request->txt_total; $d++)
                                {
                                
                                $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

                                $data=array();
                                $data['late_inform_master_id']=$m_late_inform_master_id;
                                $data['employee_id']=$request->txt_user_id;
                                $data['company_id']=$request->txt_company_id;
                                $data['desig_id']=$request->txt_desig_id;
                                $data['late_type_id']=$request->sele_late_type;
                                $data['late_date']=$atdate;
                                $data['late_total']=$request->txt_total;
                                $data['user_id']=$m_user_id;
                                $data['entry_date'] = date("Y-m-d");
                                $data['entry_time'] = date("h:i:sa");
                                $data['valid']=$m_valid;

                                //dd($data);
                                DB::table('pro_late_inform_master_02')->insert($data);
                                
                                }//for($d==1; $d<=txt_total_days; $d++)

                                return redirect()->back()->with('success','Data Inserted Successfully!');

                            } else {
                                return redirect()->back()->withInput()->with('warning',"You allready applied for Early");

                            }//if($ci_late_inform_master_late===null)
                        }//if($request->sele_late_type==3)
                        
                        return redirect()->back()->withInput()->with('warning','Allready Applied');
                    } //if ($ci_late_inform_master===null)


                } //if ($txt_total_days>$txt_app_day)
            } //if ($form_year!=$c_year)

        } //if ($form_year!=$to_year)

    }

//movement_approval

    public function hrmmovement_approval()
    {
        $m_user_id=Auth::user()->emp_id;
        $mentrydate=time();
        $m_late_year=date("Y",$mentrydate);

        // $ci_report = DB::table("pro_employee_info")
        //     ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        //     ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        //     ->join("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        //     ->select("pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
        //     ->Where('report_to_id',$m_user_id)
        //     ->get();

        $ci_report=DB::table('pro_level_step')
        ->leftjoin("pro_employee_info", "pro_level_step.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        ->select("pro_level_step.*","pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
        ->Where('pro_level_step.valid','1')
        // ->Where('status','1')
        ->Where('pro_level_step.report_to_id',$m_user_id)
        ->orderBy('pro_level_step.employee_id','DESC')
        ->get();

       

        return view('hrm.movement_approval',compact('ci_report','m_user_id','m_late_year'));
    }

    public function hrmmove_app_approval($id)
    {
        $m_late_info_master=DB::table('pro_late_inform_master')->where('late_inform_master_id',$id)->first();
        $m_yesno=DB::table('pro_yesno')->where('valid','1')->get();
        return view('hrm.move_app_for_approval',compact('m_late_info_master','m_yesno'));
    }

    public function hrmmove_appupdate(Request $request,$update)
    {

    $rules = [
            'sele_late_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'cbo_approved_status' => 'required|integer|between:1,10',
        ];

        $customMessages = [

            'sele_late_type.required' => 'Select Leave Type.',
            'sele_late_type.integer' => 'Select Leave Type.',
            'sele_late_type.between' => 'Chose  Leave Type.',

            'txt_from_date.required' => 'From Date is required.',
            'txt_to_date.required' => 'To Date is required.',

            'cbo_approved_status.required' => 'Select Approved Status.',
            'cbo_approved_status.integer' => 'Select Approved Status.',
            'cbo_approved_status.between' => 'Select Approved Status.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // $txt_leave_status='1';
        $m_user_id=Auth::user()->emp_id;
        $m_valid=1;

        $ci_level_step=DB::table('pro_level_step')
            ->Where('valid','1')
            ->Where('employee_id',$request->txt_employee_id)
            ->Where('report_to_id',$m_user_id)
            ->first();

        $m2_level_step=$ci_level_step->level_step;

        if($request->cbo_approved_status=='1')
        {
            // $m_status=2;
            for($d=0; $d<$request->txt_total; $d++)
            {
            
            $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

            $data=array();
            $data['late_inform_master_id']=$request->txt_late_info_master_id;
            $data['employee_id']=$request->txt_employee_id;
            $data['company_id']=$request->txt_company_id;
            $data['desig_id']=$request->txt_desig_id;
            $data['late_type_id']=$request->sele_late_type;
            $data['late_date']=$atdate;
            $data['late_total']=$request->txt_total;
            $data['approved_id']=$request->txt_user_id;
            //Bangladesh Date and Time Zone
            // date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid']=$m_valid;

            //dd($data);
            DB::table('pro_late_inform_details')->insert($data);
            
            }//for($d==1; $d<=txt_total_days; $d++)
            $m_edit_status='2';
            DB::table('pro_late_inform_master')->where('late_inform_master_id',$update)->update([
            'approved_level'=>$m2_level_step,
            'edit_status'=>$m_edit_status,
            ]);

            $ci_employee_info=DB::table('pro_employee_info')
                ->Where('valid','1')
                ->Where('employee_id',$request->txt_employee_id)
                ->first();

            $ci_level_step1=DB::table('pro_level_step')
                ->Where('valid','1')
                ->Where('employee_id',$request->txt_employee_id)
                ->Where('report_to_id',$m_user_id)
                ->first();

            $ci_late_info_master=DB::table('pro_late_inform_master')
                ->Where('late_inform_master_id',$request->txt_late_info_master_id)
                ->first();


                $m1_level_step=$ci_employee_info->level_step;
                $m2_level_step1=$ci_level_step1->level_step;
                $m_approved_level=$ci_late_info_master->approved_level;
                // dd("$m1_level_step -- $m2_level_step -- $m_approved_level");

            if($m_approved_level==1)
            {
                for($dd=0; $dd<$request->txt_total; $dd++)
                {
                
                $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$dd.' days'));

                $data=array();
                $data['late_inform_master_id']=$request->txt_late_info_master_id;
                $data['employee_id']=$request->txt_employee_id;
                $data['company_id']=$request->txt_company_id;
                $data['desig_id']=$request->txt_desig_id;
                $data['late_type_id']=$request->sele_late_type;
                $data['late_date']=$atdate;
                $data['late_total']=$request->txt_total;
                $data['approved_id']=$request->txt_user_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid']=$m_valid;
                // $data['level_step']=$m2_level_step1;

                //dd($data);
                DB::table('pro_late_inform_details')->insert($data);
            
                }//for($dd==1; $dd<=txt_total_days; $dd++)

                $m_status=2;
                DB::table('pro_late_inform_master')->where('late_inform_master_id',$update)->update([
                'approved_level'=>$m2_level_step1,
                'status'=>$m_status,
                'g_late_form'=>$request->txt_from_date,
                'g_late_to'=>$request->txt_to_date,
                'g_late_total'=>$request->txt_total,
                'late_approved'=>$m_user_id,
                // date_default_timezone_set("Asia/Dhaka");
                'approved_date'=>date("Y-m-d"),
                
                ]);


            }

            return redirect(route('movement_approval'))->with('success','Movement Application  Approved');
        } else {
            $m_status=3;

            DB::table('pro_late_inform_master')->where('late_inform_master_id',$update)->update([
            'status'=>$m_status,
            'late_approved'=>$m_user_id,
            // date_default_timezone_set("Asia/Dhaka");
            'approved_date'=>date("Y-m-d"),
            ]);

            return redirect(route('movement_approval'))->with('success','Late Application Cancel');

        }
    }

    public function HrmMoveApplicationOp()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $ci_pro_late_type=DB::table('pro_late_type')
        ->Where('valid','1')
        ->orderBy('late_type_id','asc')
        ->get();
        return view('hrm.movement_application_op',compact('ci_pro_late_type','user_company'));

    }

    //Leave Application insert
    public function HrmMoveApplicationOpStore(Request $request)
    {
    $rules = [
            
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_employee_id' => 'required',
            'sele_late_type' => 'required|integer|between:1,100',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_purpose_late' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select  Company.',

            'cbo_employee_id.required' => 'Select Employee.',

            'sele_late_type.required' => 'Select Movement Type.',
            'sele_late_type.integer' => 'Select Movement Type.',
            'sele_late_type.between' => 'Chose  Movement Type.',

            'txt_from_date.required' => 'Leave Start Date is required.',
            'txt_to_date.required' => 'Leave End Date is required.',
            'txt_purpose_late.required' => 'Move Purpose is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;
        $m_valid='1';
        $m_status='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $txt_from_date=$request->txt_from_date;
        $txt_from_date1=date("m-d",strtotime($txt_from_date));
        $txt_to_date=$request->txt_to_date;
        $txt_to_date1=date("m-d",strtotime($txt_to_date));

        $c_year=date("Y",$mentrydate);
        //$c_year="2021";
        // $m_date=date("m-d",$mentrydate);
        $form_year=substr($txt_from_date,0,4);
        $to_year=substr($txt_to_date,0,4);

        // $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        // $txt_total_days = floor($diff / (1*60*60*24)+1);
        $txt_total_days = $request->txt_total;
        // //dd($txt_total_days);
        $txt_late_type=$request->sele_late_type;
        // dd("$request->txt_total");
        if ($form_year!=$to_year)
        {

            return redirect()->back()->withInput()->with('warning' , 'year mismatch!!');

        } else {
            if ($form_year!=$c_year)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
            } else {

            $ci_pro_late_type=DB::table('pro_late_type')->Where('late_type_id',$request->sele_late_type)->first();
            $txt_late_day=$ci_pro_late_type->late_day;

                if ($txt_total_days>$txt_late_day)
                {
                return redirect()->back()->withInput()->with('warning',"You Choose more than $txt_late_day Days");
                } else {

                    $ci_late_inform_master=DB::table('pro_late_inform_master')->Where('employee_id',$request->cbo_employee_id)->whereBetween('late_form',[$txt_from_date,$txt_to_date])->first();

                    $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$request->cbo_employee_id)->first();

                    $txt_company_id=$ci_employee_info->company_id;
                    $txt_desig_id=$ci_employee_info->desig_id;
                    $txt_department_id=$ci_employee_info->department_id;
                    $txt_section_id=$ci_employee_info->section_id;
                    $txt_placeofposting_id=$ci_employee_info->placeofposting_id;
                    $txt_department_id=$ci_employee_info->department_id;



                    if ($ci_late_inform_master===null)
                    {
                        
                        $data=array();
                        $data['employee_id']=$request->cbo_employee_id;
                        $data['company_id']=$request->cbo_company_id;
                        $data['desig_id']=$txt_desig_id;
                        $data['department_id']=$txt_department_id;
                        $data['section_id']=$txt_section_id;
                        $data['placeofposting_id']=$txt_placeofposting_id;
                        $data['late_type_id']=$request->sele_late_type;
                        $data['late_form']=$request->txt_from_date;
                        $data['late_to']=$request->txt_to_date;
                        $data['late_year']=$c_year;
                        $data['late_total']=$txt_total_days;
                        $data['purpose_late']=$request->txt_purpose_late;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['status']=$m_status;
                        $data['valid']=$m_valid;
                        $data['user_id']=$m_user_id;

                        //dd($data);
                        DB::table('pro_late_inform_master')->insert($data);
                        return redirect()->back()->with('success','Data Inserted Successfully!');

                    } else {
                        return redirect()->back()->withInput()->with('warning','Allready Applied');
                    } //if ($ci_late_inform_master===null)

                } //if ($txt_total_days>$txt_app_day)
            } //if ($form_year!=$c_year)

        } //if ($form_year!=$to_year)

    }

public function HrmMoveApprovalOthers(){

        $m_user_id=Auth::user()->emp_id;

        $mentrydate=time();
        $m_late_year=date("Y",$mentrydate);

        $ci_list=DB::table('pro_late_inform_master')
        ->leftjoin("pro_employee_info", "pro_late_inform_master.employee_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
        ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
        ->select("pro_late_inform_master.*","pro_employee_info.employee_name", "pro_employee_info.mobile","pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
        ->Where('pro_late_inform_master.valid','1')
        ->Where('pro_late_inform_master.status','1')
        // ->Where('pro_level_step.report_to_id',$m_user_id)
        ->orderBy('pro_late_inform_master.late_inform_master_id','DESC')
        ->get();

        return view('hrm.move_approval_others',compact('ci_list','m_user_id','m_late_year'));
    }
 
    public function hrmbackmove_app_for_approval_other($id)
    {

        $m_late_inform_master=DB::table('pro_late_inform_master')->where('late_inform_master_id',$id)->first();
        // $data=DB::table('pro_leave_info_master')->where('valid','1')->get();

        $m_approved_id = DB::table('pro_late_approved_details')
        ->where('late_inform_master_id', $id)
        ->pluck('approved_id');

        $ci_report=DB::table('pro_level_step')
        ->leftjoin("pro_employee_info", "pro_level_step.report_to_id", "pro_employee_info.employee_id")
        ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")

        ->select("pro_level_step.*","pro_employee_info.*", "pro_desig.desig_name")
        ->Where('pro_level_step.valid','1')
        // ->Where('status','1')
        ->Where('pro_level_step.employee_id',$m_late_inform_master->employee_id)
        ->WhereNotIn('pro_level_step.report_to_id',$m_approved_id)
        ->orderBy('pro_level_step.level_step','DESC')
        ->get();


        return view('hrm.move_app_for_approval_other',compact('m_late_inform_master','ci_report'));
    }

    public function move_app_for_approval_other_update(Request $request,$update)
    {

    $rules = [
           
            'cbo_approved_id' => 'required',
        ];

        $customMessages = [

            'cbo_approved_id.required' => 'Select Report To.',

        ];        

        $this->validate($request, $rules, $customMessages);
        // $txt_leave_status='1';
        $m_user_id=Auth::user()->emp_id;
        $m_valid=1;
        

        $ci_level_step=DB::table('pro_level_step')
            ->Where('valid','1')
            ->Where('employee_id',$request->txt_employee_id)
            ->Where('report_to_id',$request->cbo_approved_id)
            ->first();

        $m2_level_step=$ci_level_step->level_step;

                    
            for($d=0; $d<$request->txt_total; $d++)
            {
            
            $atdate = date('Y-m-d', strtotime($request->txt_from_date.' + '.$d.' days'));

            $data=array();
            $data['late_inform_master_id']=$request->txt_late_inform_master;
            $data['employee_id']=$request->txt_employee_id;
            $data['company_id']=$request->txt_company_id;
            $data['desig_id']=$request->txt_desig_id;
            $data['late_type_id']=$request->sele_late_type;
            $data['late_date']=$atdate;
            $data['total']=$request->txt_total;
            $data['approved_id']=$request->cbo_approved_id;
            $data['user_id']=$m_user_id;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid']=$m_valid;
            $data['approved_level']=$m2_level_step;

            //dd($data);
            DB::table('pro_late_approved_details')->insert($data);
            
            }//for($d==1; $d<=txt_total_days; $d++)
            $m_edit_status='2';
            DB::table('pro_late_inform_master')->where('late_inform_master_id',$update)->update([
            'approved_level'=>$m2_level_step,
            'edit_status'=>$m_edit_status,
            ]);

            return back()->with('success','Movement Application Approved');
        

    }

    public function move_app_for_approval_upload($id){

     $m_late_inform_master=DB::table('pro_late_inform_master')
     ->where('late_inform_master_id',$id)
     ->first();

      return view('hrm.move_app_for_approval_upload',compact('m_late_inform_master'));
    }

    public function move_file_store(Request $request,$id){

        $rules = [
            'txt_file' => 'required',
        ];

        $customMessages = [
            'txt_file.required' => 'File is required.',
        ];        

        $this->validate($request, $rules, $customMessages);
        $m_late_inform_master=DB::table('pro_late_inform_master')->where('late_inform_master_id',$id)->first();

        $m_user_id=Auth::user()->emp_id;
        $m_valid=1;

        $data=array();

        $txt_doc_file = $request->file('txt_file');
            if ($request->hasFile('txt_file')) {
                
                $filename = $id . '.' . $request->file('txt_file')->getClientOriginalExtension();

                $upload_path = "../docupload/sqgroup/moveapp/";

                // $image_url = "$upload_path/" . $filename;
                $txt_doc_file->move($upload_path, $filename);
                $data['approved_file'] = $filename;
            }

            DB::table('pro_late_inform_master')
            ->where('late_inform_master_id',$id)
            ->update($data);

                for($dd=0; $dd<$m_late_inform_master->late_total; $dd++)
                {
                
                $atdate = date('Y-m-d', strtotime($m_late_inform_master->late_form.' + '.$dd.' days'));

                $data=array();
                $data['late_inform_master_id']=$id;
                $data['employee_id']=$m_late_inform_master->employee_id;
                $data['company_id']=$m_late_inform_master->company_id;
                $data['desig_id']=$m_late_inform_master->desig_id;
                $data['late_type_id']=$m_late_inform_master->late_type_id;
                $data['late_date']=$atdate;
                $data['late_total']=$m_late_inform_master->late_total;
                // $data['approved_id']=$request->txt_user_id;
                $data['entry_date'] = date("Y-m-d");
                $data['entry_time'] = date("h:i:sa");
                $data['valid']=$m_valid;
                // $data['level_step']=$m2_level_step1;

                //dd($data);
                DB::table('pro_late_inform_details')->insert($data);
            
                }//for($dd==1; $dd<=txt_total_days; $dd++)

                $m_status=2;
                DB::table('pro_late_inform_master')->where('late_inform_master_id',$id)->update([
                // 'approved_level'=>$m2_level_step1,
                'status'=>$m_status,
                'g_late_form'=>$request->late_form,
                'g_late_to'=>$m_late_inform_master->late_to,
                'g_late_total'=>$m_late_inform_master->late_total,
                'approved_user_id'=>$m_user_id,
                // date_default_timezone_set("Asia/Dhaka");
                'approved_date'=>date("Y-m-d"),
                
                ]);

    return redirect()->route('move_approval_others');

    }






    public function MoveApproManual()
    {
        $m_user_id=Auth::user()->emp_id;
        $ci_report = DB::table("pro_employee_info")
            ->join("pro_company", "pro_employee_info.company_id", "pro_company.company_id")
            ->join("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
            ->join("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
            ->select("pro_employee_info.*", "pro_company.company_name", "pro_desig.desig_name", "pro_department.department_name")
            ->Where('report_to_id',$m_user_id)
            ->get();
       
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        $m_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_id','asc')->get(); //query builder

        return view('hrm.move_appro_manual',compact('ci_report','user_company','m_yesno'));
    }

    //Movement Manual Application insert and update
    public function MoveApproManualStore(Request $request)
    {
    $rules = [
            
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_employee_id' => 'required|integer|between:1,99999999',
            'txt_move_date' => 'required',
            'sele_late_type' => 'required|integer|between:1,10',
            'txt_purpose_late' => 'required',
            'cbo_approved_status' => 'required|integer|between:1,10',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Chose  Company.',

            'cbo_employee_id.required' => 'Select Employee.',
            'cbo_employee_id.integer' => 'Select Employee.',
            'cbo_employee_id.between' => 'Chose  Employee.',

            'txt_move_date.required' => 'Date is required.',

            'sele_late_type.required' => 'Select Movement type.',
            'sele_late_type.integer' => 'Select Movement type.',
            'sele_late_type.between' => 'Chose  Movement type.',

            'txt_purpose_late.required' => 'Movement Purpose is required.',

            'cbo_approved_status.required' => 'Select Approved Status.',
            'cbo_approved_status.integer' => 'Select Approved Status.',
            'cbo_approved_status.between' => 'Chose  Approved Status.',


        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;
        $m_valid='1';

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);
        $m_move_date=$request->txt_move_date;
        $c_year=date("Y",$mentrydate);
        $c_month=date("m",$mentrydate);
        $m_year=substr($m_move_date,0,4);
        $m_month=substr($m_move_date,5,2);

        if ($m_year!=$c_year)
        {
            return redirect()->back()->withInput()->with('warning' , 'This is not current year!!');
        } else {
            if ($c_month!=$m_month)
            {
                return redirect()->back()->withInput()->with('warning' , 'This is not current Month!!');
            } else {

                $ci_attendance = DB::table("pro_attendance")
                ->Where('employee_id',$request->cbo_employee_id)
                ->Where('attn_date',$request->txt_move_date)
                ->first();

                    if ($ci_attendance===null)
                    {
                        return redirect()->back()->withInput()->with('warning','Data Not Found');
                    } else {

                        $ci_late_manual = DB::table("pro_late_manual_details")
                        ->Where('employee_id',$request->cbo_employee_id)
                        ->Where('late_date',$request->txt_move_date)
                        ->first();

                        if ($ci_late_manual===null)
                        {

                        $data=array();
                        $data['employee_id']=$request->cbo_employee_id;
                        $data['company_id']=$request->cbo_company_id;
                        // $data['desig_id']=$request->txt_desig_id;
                        $data['late_type_id']=$request->sele_late_type;
                        $data['late_date']=$request->txt_move_date;
                        $data['purpose_late']=$request->txt_purpose_late;
                        $data['approve_status']=$request->cbo_approved_status;
                        $data['approved_id']=$m_user_id;
                        $data['entry_date']=$m_entry_date;
                        $data['entry_time']=$m_entry_time;
                        $data['valid']=$m_valid;

                        //dd($data);
                        DB::table('pro_late_manual_details')->insert($data);
                        $m_status='P';
                        DB::table('pro_attendance')
                        ->where('employee_id',$request->cbo_employee_id)
                        ->where('attn_date',$request->txt_move_date)
                        ->update([
                        'status'=>$m_status,
                        ]);

                        return redirect()->back()->with('success','Data Inserted Successfully!');
                        } else {
                        return redirect()->back()->withInput()->with('warning','Allready Approved');
                        }//if ($ci_late_manual===null)
                    }//if ($ci_attendance===null)

            }//if ($c_month!=$m_month)
        }//if ($m_year!=$c_year)
    }


//data_sync

    public function hrmbackdata_sync()
    {

        return view('hrm.data_sync');

    }

    //Data Synchronization
    public function hrmbackdata_syncstore(Request $request)
    {
    $rules = [
            'txt_sync_date' => 'required',
        ];

        $customMessages = [

            'txt_sync_date.required' => 'Synchronization Date is required.',
        ];        

        $this->validate($request, $rules, $customMessages);
        $m_sync_date=$request->txt_sync_date;

        $txt_end_date=date('Y-m-d', strtotime($m_sync_date . ' +1 day'));
        $m_valid='1';

        $m_month=date("m",strtotime($m_sync_date));
        $m_year=date("y",strtotime($m_sync_date));

        $m_table1="pro_tmp_log_$m_month$m_year";

        if (Schema::hasTable("$m_table1"))
        {
            // dd('yes');
            //Nitgen Server
            $ci_NGAC_AUTHLOG=DB::connection('sqlsrv1')->table('NGAC_AUTHLOG')
            ->where('TransactionTime','>=',$m_sync_date)
            ->where('TransactionTime','<=',$txt_end_date)
            ->where('AuthResult',0)
            // ->where('is_read',null)
            ->get();

            foreach ($ci_NGAC_AUTHLOG as $key => $row) {
                $data=array();
                $data['tmp_records_id']=$row->IndexKey;
                $data['logdate']=date('Y-m-d', strtotime($row->TransactionTime));
                $data['logtime']=date('H:i:s', strtotime($row->TransactionTime));
                $data['emp_id']=$row->UserID;
                $data['nodeid']=$row->TerminalID;
                $data['is_read']=1;
                $data['valid']=1;

                //dd($data);
                DB::table("$m_table1")->insert($data);
                
                DB::connection('sqlsrv1')->table('NGAC_AUTHLOG')
                ->where('IndexKey',$row->IndexKey)
                ->update(['AuthResult'=>2]);
            }

            //Timmy Server
            $ci_tmpTRecords=DB::connection('sqlsrv2')->table('tmpTRecords')
            ->where('KqDate',$m_sync_date)
            ->where('is_read',null)
            ->get();

            foreach ($ci_tmpTRecords as $key => $row_tmpTRecords) {
                $data=array();
                $data['tmp_records_id']=$row_tmpTRecords->ID;
                $data['logdate']=date('Y-m-d', strtotime($row_tmpTRecords->KqDate));
                $data['logtime']=date('H:i:s', strtotime($row_tmpTRecords->KqTime));
                $data['emp_id']=$row_tmpTRecords->emp_id;
                $data['nodeid']=$row_tmpTRecords->clock_id;
                $data['is_read']=1;
                $data['valid']=1;

                //dd($data);
                DB::table("$m_table1")->insert($data);
                
                DB::connection('sqlsrv2')->table('tmpTRecords')
                ->where('ID',$row_tmpTRecords->ID)
                ->update(['is_read'=>1]);
            }

             $m_table_name1=date('Ym', strtotime($m_sync_date));
             $m_table_name="auth_logs_$m_table_name1";

            //Face Server
            $ci_auth_logs=DB::connection('mysql2')->table("$m_table_name")
            ->where('event_time','>=',$m_sync_date)
            ->where('event_time','<=',$txt_end_date)
            ->where('auth_result',0)
            ->get();
            // dd($ci_auth_logs);
            foreach ($ci_auth_logs as $row_auth_logs) {
                $data=array();
                $data['tmp_records_id']=$row_auth_logs->index_key;
                $data['logdate']=date('Y-m-d', strtotime($row_auth_logs->event_time));
                $data['logtime']=date('H:i:s', strtotime($row_auth_logs->event_time));
                $data['emp_id']=str_pad($row_auth_logs->user_id,8,'0',STR_PAD_LEFT);
                $data['nodeid']=$row_auth_logs->terminal_id;
                $data['is_read']=1;
                $data['valid']=1;

                // dd($row_auth_logs);
                DB::table("$m_table1")->insert($data);
                
                DB::connection('mysql2')->table("$m_table_name")
                ->where('index_key',$row_auth_logs->index_key)
                ->update(['auth_result'=>2]);
            }

            return redirect(route('data_sync'))->with('success',"$m_sync_date Data Synchronization Successfully!");


        } else {//if (Schema::hasTable("$m_table1"))
            // dd('No');

            Schema::create("$m_table1", function (Blueprint $table1) {
            $table1->increments('tmp_login_id');
            $table1->integer('tmp_records_id')->length(11);
            $table1->date('logdate');
            $table1->time('logtime');
            $table1->string('emp_id', 8);
            $table1->integer('nodeid')->length(11);
            $table1->integer('authtype')->length(11);
            $table1->integer('is_read')->length(1);
            $table1->integer('valid')->length(1);
            });

            //Nitgen Server
            $ci_NGAC_AUTHLOG=DB::connection('sqlsrv1')->table('NGAC_AUTHLOG')
            ->where('TransactionTime','>=',$m_sync_date)
            ->where('TransactionTime','<=',$txt_end_date)
            ->where('AuthResult',0)
            // ->where('is_read',null)
            ->get();

            foreach ($ci_NGAC_AUTHLOG as $key => $row) {
                $data=array();
                $data['tmp_records_id']=$row->IndexKey;
                $data['logdate']=date('Y-m-d', strtotime($row->TransactionTime));
                $data['logtime']=date('H:i:s', strtotime($row->TransactionTime));
                $data['emp_id']=$row->UserID;
                $data['nodeid']=$row->TerminalID;
                $data['is_read']=1;
                $data['valid']=1;

                //dd($data);
                DB::table("$m_table1")->insert($data);
                
                DB::connection('sqlsrv1')->table('NGAC_AUTHLOG')
                ->where('IndexKey',$row->IndexKey)
                ->update(['AuthResult'=>2]);
            }

            //Timmy Server
            $ci_tmpTRecords=DB::connection('sqlsrv2')->table('tmpTRecords')
            ->where('KqDate',$m_sync_date)
            ->where('is_read',null)
            ->get();

            foreach ($ci_tmpTRecords as $key => $row_tmpTRecords) {
                $data=array();
                $data['tmp_records_id']=$row_tmpTRecords->ID;
                $data['logdate']=date('Y-m-d', strtotime($row_tmpTRecords->KqDate));
                $data['logtime']=date('H:i:s', strtotime($row_tmpTRecords->KqTime));
                $data['emp_id']=$row_tmpTRecords->emp_id;
                $data['nodeid']=$row_tmpTRecords->clock_id;
                $data['is_read']=1;
                $data['valid']=1;

                //dd($data);
                DB::table("$m_table1")->insert($data);
                
                DB::connection('sqlsrv2')->table('tmpTRecords')
                ->where('ID',$row_tmpTRecords->ID)
                ->update(['is_read'=>1]);
            }

             $m_table_name1=date('Ym', strtotime($m_sync_date));
             $m_table_name="auth_logs_$m_table_name1";

            //Face Server
            $ci_auth_logs=DB::connection('mysql2')->table("$m_table_name")
            ->where('event_time','>=',$m_sync_date)
            ->where('event_time','<=',$txt_end_date)
            ->where('auth_result',0)
            ->get();
            // dd($ci_auth_logs);
            foreach ($ci_auth_logs as $row_auth_logs) {
                $data=array();
                $data['tmp_records_id']=$row_auth_logs->index_key;
                $data['logdate']=date('Y-m-d', strtotime($row_auth_logs->event_time));
                $data['logtime']=date('H:i:s', strtotime($row_auth_logs->event_time));
                $data['emp_id']=str_pad($row_auth_logs->user_id,8,'0',STR_PAD_LEFT);
                $data['nodeid']=$row_auth_logs->terminal_id;
                $data['is_read']=1;
                $data['valid']=1;

                // dd($row_auth_logs);
                DB::table("$m_table1")->insert($data);
                
                DB::connection('mysql2')->table("$m_table_name")
                ->where('index_key',$row_auth_logs->index_key)
                ->update(['auth_result'=>2]);
            }

            return redirect(route('data_sync'))->with('success',"$m_sync_date Data Synchronization Successfully!");

        }//if (Schema::hasTable("$m_table1"))

        //Nitgen Server
        $ci_NGAC_AUTHLOG=DB::connection('sqlsrv1')->table('NGAC_AUTHLOG')
        ->where('TransactionTime','>=',$m_sync_date)
        ->where('TransactionTime','<=',$txt_end_date)
        ->where('AuthResult',0)
        // ->where('is_read',null)
        ->get();

        foreach ($ci_NGAC_AUTHLOG as $key => $row) {
            $data=array();
            $data['tmp_records_id']=$row->IndexKey;
            $data['logdate']=date('Y-m-d', strtotime($row->TransactionTime));
            $data['logtime']=date('H:i:s', strtotime($row->TransactionTime));
            $data['emp_id']=$row->UserID;
            $data['nodeid']=$row->TerminalID;
            $data['is_read']=1;
            $data['valid']=1;

            //dd($data);
            DB::table('pro_tmp_log')->insert($data);
            
            DB::connection('sqlsrv1')->table('NGAC_AUTHLOG')
            ->where('IndexKey',$row->IndexKey)
            ->update(['AuthResult'=>2]);
        }

        //Timmy Server
        $ci_tmpTRecords=DB::connection('sqlsrv2')->table('tmpTRecords')
        ->where('KqDate',$m_sync_date)
        ->where('is_read',null)
        ->get();

        foreach ($ci_tmpTRecords as $key => $row_tmpTRecords) {
            $data=array();
            $data['tmp_records_id']=$row_tmpTRecords->ID;
            $data['logdate']=date('Y-m-d', strtotime($row_tmpTRecords->KqDate));
            $data['logtime']=date('H:i:s', strtotime($row_tmpTRecords->KqTime));
            $data['emp_id']=$row_tmpTRecords->emp_id;
            $data['nodeid']=$row_tmpTRecords->clock_id;
            $data['is_read']=1;
            $data['valid']=1;

            //dd($data);
            DB::table('pro_tmp_log')->insert($data);
            
            DB::connection('sqlsrv2')->table('tmpTRecords')
            ->where('ID',$row_tmpTRecords->ID)
            ->update(['is_read'=>1]);
        }

         $m_table_name1=date('Ym', strtotime($m_sync_date));
         $m_table_name="auth_logs_$m_table_name1";

        //Face Server
        $ci_auth_logs=DB::connection('mysql2')->table("$m_table_name")
        ->where('event_time','>=',$m_sync_date)
        ->where('event_time','<=',$txt_end_date)
        ->where('auth_result',0)
        ->get();
        // dd($ci_auth_logs);
        foreach ($ci_auth_logs as $row_auth_logs) {
            $data=array();
            $data['tmp_records_id']=$row_auth_logs->index_key;
            $data['logdate']=date('Y-m-d', strtotime($row_auth_logs->event_time));
            $data['logtime']=date('H:i:s', strtotime($row_auth_logs->event_time));
            $data['emp_id']=str_pad($row_auth_logs->user_id,8,'0',STR_PAD_LEFT);
            $data['nodeid']=$row_auth_logs->terminal_id;
            $data['is_read']=1;
            $data['valid']=1;

            // dd($row_auth_logs);
            DB::table('pro_tmp_log')->insert($data);
            
            DB::connection('mysql2')->table("$m_table_name")
            ->where('index_key',$row_auth_logs->index_key)
            ->update(['auth_result'=>2]);
        }

// dd($data);

        return redirect(route('data_sync'))->with('success',"$m_sync_date Data Synchronization Successfully!");

        //}//if ($ci_tmp_log>0)

    }

//attendance_process

    public function hrmbackattendance_process()
    {
        return view('hrm.attendance_process');
    }

    //Attendance Process 01
    public function hrmbackattendance_processstore(Request $request)
    {
    $rules = [
            'txt_atten_date' => 'required',
        ];

        $customMessages = [

            'txt_atten_date.required' => 'Attendance Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_valid='1';

        $m_atten_date=$request->txt_atten_date;

        $m_month=date("m",strtotime($m_atten_date));
        $m_year=date("y",strtotime($m_atten_date));

        $m_table="pro_attendance_$m_month$m_year";
// dd($m_table);
        if (Schema::hasTable("$m_table"))
        {
            // dd('yes');
            $ci_attendance=DB::table("$m_table")
            ->where('attn_date',$m_atten_date)
            ->where('valid','1')
            ->count();
        
            if ($ci_attendance>0)
            {

                return redirect()->back()->withInput()->with('warning','Attendance Process Allready Done');
            } else {

            $m_employee_info = DB::table('pro_employee_info')
            ->where('valid','1')
            ->where('working_status','1')
            ->where('ss','1')
            ->WhereNotIn('placeofposting_id',['8','80'])
            ->orderBy('employee_id','asc')
            ->get();
            // return $m_employee_info;
            foreach ($m_employee_info as $row_emp_info){

                $m_employee_id=$row_emp_info->employee_id;
                $m_company_id=$row_emp_info->company_id;
                $m_placeofposting_id=$row_emp_info->placeofposting_id;
                $m_desig_id=$row_emp_info->desig_id;
                $m_department_id=$row_emp_info->department_id;
                $m_att_policy_id=$row_emp_info->att_policy_id;
                $m_psm_id=$row_emp_info->psm_id;

                $prweekday = date('l', strtotime($m_atten_date));
                $m_process_status='2';
                $m_valid='1';

                $m_user_id=Auth::user()->emp_id;

                $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
                
                $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
                $m_weekly_holiday2=$m_att_policy->weekly_holiday2;
                $m_policy_status=$m_att_policy->policy_status;

                if($m_policy_status==2)
                {
                    $m_att_policy_sub=DB::table('pro_att_policy_sub')
                    ->Where('att_policy_id',$m_att_policy_id)
                    ->Where('day',$prweekday)
                    ->first();

                    $m_in_time=$m_att_policy_sub->in_time;
                    $m_in_time_graced=$m_att_policy_sub->in_time_graced;
                    $m_out_time=$m_att_policy_sub->out_time;

                } else {
                    $m_in_time=$m_att_policy->in_time;
                    $m_in_time_graced=$m_att_policy->in_time_graced;
                    $m_out_time=$m_att_policy->out_time;
                }
                // return $m_atten_date;
                // Govt Holi checking here
                $m_holiday=DB::table('pro_holiday')
                ->Where('holiday_date',$m_atten_date)
                ->first();
                // $m_holiday_date=$m_holiday->holiday_date;

                if ($m_holiday===null)
                {
                $daysts="R";
                $sts="A";
                }
                else
                {
                $daysts="H";
                $sts="H";
                }

                //Weekly Holiday Checki here if not Govt Holidy
                if ($daysts!="H")
                {
                if ($prweekday==$m_weekly_holiday1)
                {
                $daysts="W";
                $sts="W";
                }
                else if ($prweekday==$m_weekly_holiday2)
                {
                $daysts="W";
                $sts="W";
                }
                else
                {
                $daysts="R";
                $sts="A";
                }
                }//if ($daysts!="H")*/
                // $m_process_status='2';

                    $data=array();
                    $data['company_id']=$m_company_id;
                    $data['employee_id']=$m_employee_id;
                    $data['desig_id']=$m_desig_id;
                    $data['department_id']=$m_department_id;
                    $data['placeofposting_id']=$m_placeofposting_id;
                    $data['att_policy_id']=$m_att_policy_id;
                    $data['attn_date']=$m_atten_date;
                    $data['day_name']=$prweekday;
                    $data['process_status']=$m_process_status;
                    $data['user_id']=$request->txt_user_id;
                    $data['entry_date']=$m_entry_date;
                    $data['entry_time']=$m_entry_time;
                    $data['valid']=$m_valid;
                    $data['psm_id']=$m_psm_id;
                    $data['r_in_time']=$m_in_time;
                    $data['p_in_time']=$m_in_time_graced;
                    $data['p_out_time']=$m_out_time;
                    $data['day_status']=$daysts;
                    $data['status']=$sts;
                    $data['psm_id']=$m_psm_id;

                DB::table("$m_table")->insert($data);
                //}//if ($ci_check_emp==NULL)
               
            } //foreach ($m_employee_info as $row_emp_info){
            
            //end of step 2

            return redirect()->back()->with('success',"$request->txt_atten_date Data Process 01 Successfully!");
           
            } //if ($ci_attendance>1)


        } else {//if (Schema::hasTable("$m_table"))
            // dd('No');
            Schema::create("$m_table", function (Blueprint $table) {
            $table->increments('attendance_id');
            $table->integer('company_id')->length(11);
            $table->string('employee_id', 8);
            $table->integer('machine_id')->length(11);
            $table->integer('desig_id')->length(11);
            $table->integer('department_id')->length(11);
            $table->integer('placeofposting_id')->length(11);
            $table->integer('att_policy_id')->length(2);
            $table->date('attn_date');
            $table->time('r_in_time');
            $table->time('p_in_time');
            $table->time('p_out_time');
            $table->time('in_time');
            $table->integer('nodeid_in')->length(11);
            $table->time('out_time');
            $table->integer('nodeid_out')->length(11);
            $table->string('day_name', 25);
            $table->char('day_status', 2);
            $table->float('total_working_hour', 8, 2);
            $table->integer('ot_minute')->length(5);
            $table->integer('late_min')->length(4);
            $table->integer('early_min')->length(4);
            $table->char('status', 2);
            $table->integer('is_quesitonable')->length(1);
            $table->integer('process_status')->length(1);
            $table->string('user_id', 8);
            $table->date('entry_date');
            $table->time('entry_time');
            $table->integer('valid')->length(1);
            $table->string('psm_id',20)->nullable();
            $table->integer('working_min')->length(11);
            });

            $m_employee_info = DB::table('pro_employee_info')
            ->where('valid','1')
            ->where('working_status','1')
            ->where('ss','1')
            ->WhereNotIn('placeofposting_id',['8','80'])
            ->orderBy('employee_id','asc')
            ->get();
            // return $m_employee_info;
            foreach ($m_employee_info as $row_emp_info){

                $m_employee_id=$row_emp_info->employee_id;
                $m_company_id=$row_emp_info->company_id;
                $m_placeofposting_id=$row_emp_info->placeofposting_id;
                $m_desig_id=$row_emp_info->desig_id;
                $m_department_id=$row_emp_info->department_id;
                $m_att_policy_id=$row_emp_info->att_policy_id;
                $m_psm_id=$row_emp_info->psm_id;

                $prweekday = date('l', strtotime($m_atten_date));
                $m_process_status='2';
                $m_valid='1';

                $m_user_id=Auth::user()->emp_id;

                $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();

                $m_policy_status=$m_att_policy->policy_status;

                if($m_policy_status==2)
                {
                    $m_att_policy_sub=DB::table('pro_att_policy_sub')
                    ->Where('att_policy_id',$m_att_policy_id)
                    ->Where('day',$prweekday)
                    ->first();

                    $m_in_time=$m_att_policy_sub->in_time;
                    $m_in_time_graced=$m_att_policy_sub->in_time_graced;
                    $m_out_time=$m_att_policy_sub->out_time;
                    $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
                    $m_weekly_holiday2=$m_att_policy->weekly_holiday2;

                } else {
                    $m_in_time=$m_att_policy->in_time;
                    $m_in_time_graced=$m_att_policy->in_time_graced;
                    $m_out_time=$m_att_policy->out_time;
                    $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
                    $m_weekly_holiday2=$m_att_policy->weekly_holiday2;
                }
                
                // return $m_atten_date;
                // Govt Holi checking here
                $m_holiday=DB::table('pro_holiday')
                ->Where('holiday_date',$m_atten_date)
                ->first();
                // $m_holiday_date=$m_holiday->holiday_date;

                if ($m_holiday===null)
                {
                $daysts="R";
                $sts="A";
                }
                else
                {
                $daysts="H";
                $sts="H";
                }

                //Weekly Holiday Checki here if not Govt Holidy
                if ($daysts!="H")
                {
                if ($prweekday==$m_weekly_holiday1)
                {
                $daysts="W";
                $sts="W";
                }
                else if ($prweekday==$m_weekly_holiday2)
                {
                $daysts="W";
                $sts="W";
                }
                else
                {
                $daysts="R";
                $sts="A";
                }
                }//if ($daysts!="H")*/

                    $data=array();
                    $data['company_id']=$m_company_id;
                    $data['employee_id']=$m_employee_id;
                    $data['desig_id']=$m_desig_id;
                    $data['department_id']=$m_department_id;
                    $data['placeofposting_id']=$m_placeofposting_id;
                    $data['att_policy_id']=$m_att_policy_id;
                    $data['attn_date']=$m_atten_date;
                    $data['day_name']=$prweekday;
                    $data['process_status']=$m_process_status;
                    $data['user_id']=$request->txt_user_id;
                    $data['entry_date']=$m_entry_date;
                    $data['entry_time']=$m_entry_time;
                    $data['valid']=$m_valid;
                    $data['psm_id']=$m_psm_id;
                    $data['r_in_time']=$m_in_time;
                    $data['p_in_time']=$m_in_time_graced;
                    $data['p_out_time']=$m_out_time;
                    $data['day_status']=$daysts;
                    $data['status']=$sts;
                    $data['psm_id']=$m_psm_id;

                    DB::table("$m_table")->insert($data);
           
            } //foreach ($m_employee_info as $row_emp_info){
        
            return redirect()->back()->with('success',"$request->txt_atten_date Data Process 01 Successfully!");

        }//if (Schema::hasTable("$m_table"))        

    }

//Company and posting wise update process
    public function HrmAttenReProcessComPosting()
    {
        
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.atten_re_process_com_posting',compact('user_company'));
    }

    //Company and posting wise update process 01
    public function HrmAttenReProcessComPostingUpdate(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required',
            'cbo_placeofposting_id' => 'required',
            'txt_atten_date' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Company is required.',
            'cbo_placeofposting_id.required' => 'Place of Posting is required.',
            'txt_atten_date.required' => 'Attendance Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_valid='1';

        $m_atten_date=$request->txt_atten_date;

        $m_month=date("m",strtotime($m_atten_date));
        $m_year=date("y",strtotime($m_atten_date));

        $m_table="pro_attendance_$m_month$m_year";
// dd($m_table);
        if (Schema::hasTable("$m_table"))
        {
            // dd('yes');
            $ci_attendance=DB::table("$m_table")
            ->where('attn_date',$m_atten_date)
            ->where('company_id',$request->cbo_company_id)
            ->where('placeofposting_id',$request->cbo_placeofposting_id)
            ->where('valid','1')
            ->count();
        
            if ($ci_attendance>0)
            {

            $m_employee_info = DB::table('pro_employee_info')
            ->where('valid','1')
            ->where('working_status','1')
            ->where('ss','1')
            ->Where('company_id',$request->cbo_company_id)
            ->Where('placeofposting_id',$request->cbo_placeofposting_id)
            ->orderBy('employee_id','asc')
            ->get();


            foreach ($m_employee_info as $row_emp_info){

                $m_employee_id=$row_emp_info->employee_id;
                $m_company_id=$row_emp_info->company_id;
                $m_placeofposting_id=$row_emp_info->placeofposting_id;
                $m_desig_id=$row_emp_info->desig_id;
                $m_department_id=$row_emp_info->department_id;
                $m_att_policy_id=$row_emp_info->att_policy_id;
                $m_psm_id=$row_emp_info->psm_id;

                $prweekday = date('l', strtotime($m_atten_date));
                $m_process_status='2';
                $m_valid='1';

                $m_user_id=Auth::user()->emp_id;

                $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
                
                $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
                $m_weekly_holiday2=$m_att_policy->weekly_holiday2;
                $m_policy_status=$m_att_policy->policy_status;

                if($m_policy_status==2)
                {
                    $m_att_policy_sub=DB::table('pro_att_policy_sub')
                    ->Where('att_policy_id',$m_att_policy_id)
                    ->Where('day',$prweekday)
                    ->first();

                    $m_in_time=$m_att_policy_sub->in_time;
                    $m_in_time_graced=$m_att_policy_sub->in_time_graced;
                    $m_out_time=$m_att_policy_sub->out_time;

                } else {
                    $m_in_time=$m_att_policy->in_time;
                    $m_in_time_graced=$m_att_policy->in_time_graced;
                    $m_out_time=$m_att_policy->out_time;
                }
                // return $m_atten_date;
                // Govt Holi checking here
                $m_holiday=DB::table('pro_holiday')
                ->Where('holiday_date',$m_atten_date)
                ->first();
                // $m_holiday_date=$m_holiday->holiday_date;

                if ($m_holiday===null)
                {
                $daysts="R";
                $sts="A";
                }
                else
                {
                $daysts="H";
                $sts="H";
                }

                //Weekly Holiday Checki here if not Govt Holidy
                if ($daysts!="H")
                {
                if ($prweekday==$m_weekly_holiday1)
                {
                $daysts="W";
                $sts="W";
                }
                else if ($prweekday==$m_weekly_holiday2)
                {
                $daysts="W";
                $sts="W";
                }
                else
                {
                $daysts="R";
                $sts="A";
                }
                }//if ($daysts!="H")*/
                // $m_process_status='2';


                    DB::table("$m_table")
                    ->where('employee_id',$m_employee_id)
                    ->where('attn_date',$m_atten_date)
                    ->update([
                    'att_policy_id'=>$m_att_policy_id,
                    'day_name'=>$prweekday,
                    'process_status'=>$m_process_status,
                    'r_in_time'=>$m_in_time,
                    'p_in_time'=>$m_in_time_graced,
                    'p_out_time'=>$m_out_time,
                    'day_status'=>$daysts,
                    'status'=>$sts,
                    'psm_id'=>$m_psm_id,
                    ]);

               
            } //foreach ($m_employee_info as $row_emp_info){
            
            //end of step 2

            return redirect()->back()->with('success',"$request->txt_atten_date Data Process 01 Successfully Update!");

            } else {

            return redirect()->back()->withInput()->with('warning','Data Not Found');

           
            } //if ($ci_attendance>1)


        } else {//if (Schema::hasTable("$m_table"))
        
            return redirect()->back()->withInput()->with('warning','Attendance Update Process not allow');


        }//if (Schema::hasTable("$m_table"))        

    }










    //Attendance Process 02

    public function HrmAttendanceProcess_02()
    {
        return view('hrm.attendance_process_02');
    }

    public function HrmAttenProcessStore_02(Request $request)
    {
    $rules = [
            'txt_atten_date' => 'required',
        ];

        $customMessages = [

            'txt_atten_date.required' => 'Attendance Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $m_atten_date=$request->txt_atten_date;
        $prweekday = date('l', strtotime($m_atten_date));


        $m_month=date("m",strtotime($m_atten_date));
        $m_year=date("y",strtotime($m_atten_date));

        $m_attendance="pro_attendance_$m_month$m_year";
        $m_pro_tmp_log="pro_tmp_log_$m_month$m_year";

        $ci_attendance=DB::table("$m_attendance")
        ->where('attn_date',$m_atten_date)
        ->where('process_status','>','6')
        ->where('valid','1')->count();
        
        if ($ci_attendance>0)
        {

            return redirect()->back()->withInput()->with('warning','Attendance Process Allready Done');
        } else {

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $m_attn_employee_03 = DB::table("$m_attendance")
        // ->where('process_status',2)
        // ->where('employee_id','30000136')
        // ->where('employee_id','00000201')
        ->where('attn_date',$m_atten_date)
        ->orderBy('attendance_id','asc')
        ->get();

        foreach ($m_attn_employee_03 as $row_attn_employee_03){

            $latetime='0';
            $questionable='0';
        
            $m_employee_id=$row_attn_employee_03->employee_id;
            $m_attn_date=$row_attn_employee_03->attn_date;
            $m_r_in_time=$row_attn_employee_03->r_in_time;
            $m_p_in_time=$row_attn_employee_03->p_in_time;
            $m_att_policy_id=$row_attn_employee_03->att_policy_id;
            $m_status=$row_attn_employee_03->status;

            $m_att_policy_03=DB::table('pro_att_policy')
            ->Where('att_policy_id',$m_att_policy_id)
            ->first();
            
            if ($m_att_policy_03->policy_status=='1')
            {
            $mm_grace_time=$m_att_policy_03->grace_time;
            $mm_out_time=$m_att_policy_03->out_time;
            $mm_shift_status=$m_att_policy_03->shift_status;
            $mm_in_time=$m_att_policy_03->in_time;
            } else {

            $m_att_policy_sub=DB::table('pro_att_policy_sub')
            ->Where('att_policy_id',$m_att_policy_id)
            ->Where('day',$prweekday)
            ->first();

            $mm_grace_time=$m_att_policy_sub->grace_time;
            $mm_out_time=$m_att_policy_sub->out_time;
            $mm_shift_status=$m_att_policy_sub->shift_status;
            $mm_in_time=$m_att_policy_sub->in_time;
            }



            if ($mm_shift_status=='1')
            {

                $m_tmp_log = DB::table("$m_pro_tmp_log")
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$m_attn_date)
                ->selectRaw("MIN(logtime) as first, MAX(logtime) as last")
                ->first();
                $m_tmp_log_min=$m_tmp_log->first;
                $m_tmp_log_max=$m_tmp_log->last;

                if ($m_tmp_log_min === null)
                {
                    $m_in_time='00:00:00';
                } else {
                    $m_in_time=$m_tmp_log_min;
                }

                if ($m_tmp_log_max === null)
                {
                    $m_out_time='00:00:00';
                } else {
                    $m_out_time=$m_tmp_log_max;
                }

                // $tot_minuts = (strtotime($m_p_in_time) - strtotime($m_in_time));
                $tot_minuts = (strtotime($m_in_time) - strtotime($m_p_in_time));
                $timeDiffin = floor($tot_minuts / 60);

// dd("$m_employee_id - $mm_shift_status - $m_in_time - $m_p_in_time - $m_out_time - $timeDiffin");

                if ($m_in_time == '00:00:00')
                {
                    if ($m_status!="H")
                    {
                        if ($m_status!="W")
                        {
                            if ($m_status!="L")
                            {
                            $m_status="A";  
                            }
                        }
                    }

                } else {
                    if ($timeDiffin>0)
                    {
                        $latetime=$timeDiffin+$mm_grace_time;
                        $m_status="D";
                    } else {
                        $latetime=0;
                        $m_status="P";
                    } //if ($timeDiffin>0)
                    
                }//if ($m_in_time == '00:00:00')

                if ($m_in_time==$m_out_time)
                {
                    $questionable=1;
                } else {
                    $questionable=0;
                } //if ($m_in_time==$m_out_time)

                if($m_in_time=='00:00:00')
                {
                    $m_nodeid_in='0';
                }
                else
                {
                    $m_tmp_log_in = DB::table("$m_pro_tmp_log")
                    ->where('emp_id',$m_employee_id)
                    ->where('logdate',$m_attn_date)
                    ->where('logtime',$m_in_time)
                    ->first();
                    $m_nodeid_in=$m_tmp_log_in->nodeid;
                }

                if($m_out_time=='00:00:00')
                {
                    $m_nodeid_out='0';
                }
                else
                {
                $m_tmp_log_out_04 = DB::table("$m_pro_tmp_log")
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$m_attn_date)
                ->where('logtime',$m_out_time)
                ->orderBy('tmp_login_id','asc')
                ->first();

                    if ($m_tmp_log_out_04 === null)
                    {
                        $m_nodeid_out='0';
                    } else {
                        $m_nodeid_out=$m_tmp_log_out_04->nodeid;
                    }
                }//if($m_out_time=='00:00:00')

                $timeDiffin_out='0';
                $m_process_status='5';
                $m_early_grace_time='10';

                if($m_status=='A' || $m_status=='W' || $m_status=='H' || $m_status=='L')
                {
                    $timeDiffin_out = '0';
                } else {
                $tot_early_minuts = (strtotime($m_out_time) - strtotime($mm_out_time));
                $timeDiffin_out = floor($tot_early_minuts / 60);
                }

            } else {

                $mm_r_in_time_01=(strtotime($m_r_in_time) - (60*60));
                $mm_r_in_time_02=(strtotime($m_r_in_time) + (60*60));
                $mm_r_out_time_01=(strtotime($mm_out_time) - (60*60));
                $mm_r_out_time_02=(strtotime($mm_out_time) + (60*60));

                $check_in_time_01=date('H:i:s',$mm_r_in_time_01);
                $check_in_time_02=date('H:i:s',$mm_r_in_time_02);
                $check_out_time_01=date('H:i:s',$mm_r_out_time_01);
                $check_out_time_02=date('H:i:s',$mm_r_out_time_02);

                $m_tmp_log_min = DB::table("$m_pro_tmp_log")
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$m_atten_date)
                ->whereBetween('logtime',[$check_in_time_01,$check_in_time_02])
                ->min('logtime');

                $txt_out_date=date('Y-m-d', strtotime($m_atten_date . ' +1 day'));

                $m_tmp_log_max = DB::table("$m_pro_tmp_log")
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$txt_out_date)
                ->whereBetween('logtime',[$check_out_time_01,$check_out_time_02])
                ->max('logtime');

                if ($m_tmp_log_min === null)
                {
                    $m_in_time='00:00:00';
                } else {
                    $m_in_time=$m_tmp_log_min;
                }

                if ($m_tmp_log_max === null)
                {
                    $m_out_time='00:00:00';
                } else {
                    $m_out_time=$m_tmp_log_max;
                }

                // $tot_minuts = (strtotime($m_p_in_time) - strtotime($m_in_time));
                $tot_minuts = (strtotime($m_in_time) - strtotime($m_p_in_time));
                $timeDiffin = floor($tot_minuts / 60);

                if ($m_in_time == '00:00:00')
                {
                    if ($m_status!="H")
                    {
                        if ($m_status!="W")
                        {
                            if ($m_status!="L")
                            {
                            $m_status="A";  
                            }
                        }
                    }

                } else {
                    if ($timeDiffin>0)
                    {
                        $latetime=$timeDiffin+$mm_grace_time;
                        $m_status="D";
                    } else {
                        $latetime=0;
                        $m_status="P";
                    } //if ($timeDiffin>0)
                    
                }//if ($m_in_time == '00:00:00')

                if ($m_in_time==$m_out_time)
                {
                    $questionable=1;
                } else {
                    $questionable=0;
                } //if ($m_in_time==$m_out_time)

                if($m_in_time=='00:00:00')
                {
                    $m_nodeid_in='0';
                }
                else
                {
                    $m_tmp_log_in = DB::table("$m_pro_tmp_log")
                    ->where('emp_id',$m_employee_id)
                    ->where('logdate',$m_attn_date)
                    ->where('logtime',$m_in_time)
                    ->first();
                    $m_nodeid_in=$m_tmp_log_in->nodeid;
                }

                if($m_out_time=='00:00:00')
                {
                    $m_nodeid_out='0';
                }
                else
                {
                $m_tmp_log_out_04 = DB::table("$m_pro_tmp_log")
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$txt_out_date)
                ->where('logtime',$m_out_time)
                ->orderBy('tmp_login_id','asc')
                ->first();

                    if ($m_tmp_log_out_04 === null)
                    {
                        $m_nodeid_out='0';
                    } else {
                        $m_nodeid_out=$m_tmp_log_out_04->nodeid;
                    }
                }//if($m_out_time=='00:00:00')

                $timeDiffin_out='0';
                $m_process_status='5';
                $m_early_grace_time='10';

                if($m_status=='A' || $m_status=='W' || $m_status=='H' || $m_status=='L')
                {
                    $timeDiffin_out = '0';
                } else {
                $tot_early_minuts = (strtotime($m_out_time) - strtotime($mm_out_time));
                $timeDiffin_out = floor($tot_early_minuts / 60);
                }

            }

            DB::table("$m_attendance")->where('employee_id',$m_employee_id)->where('attn_date',$m_attn_date)->update([
            'in_time'=>$m_in_time,
            'out_time'=>$m_out_time,
            'late_min'=>$latetime,
            'status'=>$m_status,
            'nodeid_in'=>$m_nodeid_in,
            'nodeid_out'=>$m_nodeid_out,
            'early_min'=>$timeDiffin_out,
            'is_quesitonable'=>$questionable,
            'process_status'=>$m_process_status,
            ]);


        } //foreach ($m_attn_employee_03 as $row_attn_employee_03){


        return redirect()->back()->with('success',"$request->txt_atten_date Data Process 02 Successfully!");
       
        } //if ($ci_attendance>1)
    }

    public function hrmbackattendance_re_process()
    {

        return view('hrm.attendance_re_process');

    }


    //Attendance Re Process 01
    public function attendance_re_processstore(Request $request)
    {
    $rules = [
            'txt_atten_date' => 'required',
        ];

        $customMessages = [

            'txt_atten_date.required' => 'Attendance Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $m_atten_date=$request->txt_atten_date;

        // $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        // $tot_days = floor($diff / (1*60*60*24)+1);

        $ci_attendance=DB::table('pro_attendance')
        ->where('attn_date',$m_atten_date)
        ->where('valid','1')
        ->count();
        
        if ($ci_attendance>0)
        {

       
        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);


        $m_employee_info = DB::table('pro_employee_info')
        ->where('valid','1')
        ->where('working_status','1')
        ->where('ss','1')
        ->orderBy('employee_id','asc')
        ->get();

        foreach ($m_employee_info as $row_emp_info){

            $m_employee_id=$row_emp_info->employee_id;
            $m_company_id=$row_emp_info->company_id;
            $m_placeofposting_id=$row_emp_info->placeofposting_id;
            $m_desig_id=$row_emp_info->desig_id;
            $m_department_id=$row_emp_info->department_id;
            $m_att_policy_id=$row_emp_info->att_policy_id;
            $m_psm_id=$row_emp_info->psm_id;

            $prweekday = date('l', strtotime($m_atten_date));
            $m_process_status='2';
            $m_valid='1';

            $m_user_id=Auth::user()->emp_id;

            $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
            
            $m_in_time=$m_att_policy->in_time;
            $m_in_time_graced=$m_att_policy->in_time_graced;
            $m_out_time=$m_att_policy->out_time;
            $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
            $m_weekly_holiday2=$m_att_policy->weekly_holiday2;

            // return $m_atten_date;
            // Govt Holi checking here
            $m_holiday=DB::table('pro_holiday')
            ->Where('holiday_date',$m_atten_date)
            ->first();
            // $m_holiday_date=$m_holiday->holiday_date;

            if ($m_holiday===null)
            {
            $daysts="R";
            $sts="A";
            }
            else
            {
            $daysts="H";
            $sts="H";
            }

            //Weekly Holiday Checki here if not Govt Holidy
            if ($daysts!="H")
            {
            if ($prweekday==$m_weekly_holiday1)
            {
            $daysts="W";
            $sts="W";
            }
            else if ($prweekday==$m_weekly_holiday2)
            {
            $daysts="W";
            $sts="W";
            }
            else
            {
            $daysts="R";
            $sts="A";
            }
            }//if ($daysts!="H")*/

            DB::table('pro_attendance')
            ->where('employee_id',$m_employee_id)
            ->where('attn_date',$m_atten_date)->update([
            'r_in_time'=>$m_in_time,
            'p_in_time'=>$m_in_time_graced,
            'p_out_time'=>$m_out_time,
            'day_status'=>$daysts,
            'status'=>$sts,
            'process_status'=>$m_process_status,
            ]);

           
        } //foreach ($m_employee_info as $row_emp_info){
        
        //end of step 2

        return redirect()->back()->with('success',"$request->txt_atten_date Data Process 01 Update!");
        } else {

            return redirect()->back()->withInput()->with('warning','Attendance Process Not Cpmpleate');

        } //if ($ci_attendance>1)
    }


    public function hrmbackattendance_ind_process()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();
        return view('hrm.attendance_ind_process',compact('user_company'));

    }

    public function attendance_ind_processstore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'cbo_employee_id' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Employee is required.',
            // 'cbo_employee_id.integer' => 'Employee is required.',
            // 'cbo_employee_id.between' => 'Employee is required.',
            'txt_from_date.required' => 'Start Date is required.',
            'txt_to_date.required' => 'End Date is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id=Auth::user()->emp_id;

        $m_employee_info = DB::table('pro_employee_info')
        ->where('employee_id',$request->cbo_employee_id)
        ->first();

        $m_employee_id=$request->cbo_employee_id;
        $m_company_id=$m_employee_info->company_id;
        $m_placeofposting_id=$m_employee_info->placeofposting_id;
        $m_desig_id=$m_employee_info->desig_id;
        $m_department_id=$m_employee_info->department_id;
        $m_att_policy_id=$m_employee_info->att_policy_id;
        $m_psm_id=$m_employee_info->psm_id;

        $m_valid='1';

   

        // date diffarence

        $diff = (strtotime($request->txt_to_date) - strtotime($request->txt_from_date));
        $tot_days = floor($diff / (1*60*60*24)+1);

        $i=1;
        //While loop
        $first_date = $request->txt_from_date;

        while($i <= $tot_days){
      
        // echo "$first_date<br>";





        $m_pro_attendance = DB::table('pro_attendance')
        ->where('attn_date',$first_date)
        ->where('employee_id',$request->cbo_employee_id)
        ->first();

            if ($m_pro_attendance===null)
            {

            $prweekday = date('l', strtotime($first_date));
            $m_process_status='1';


            $data=array();
            $data['company_id']=$m_company_id;
            $data['employee_id']=$m_employee_id;
            $data['desig_id']=$m_desig_id;
            $data['department_id']=$m_department_id;
            $data['placeofposting_id']=$m_placeofposting_id;
            $data['att_policy_id']=$m_att_policy_id;
            $data['attn_date']=$first_date;
            $data['day_name']=$prweekday;
            $data['process_status']=$m_process_status;
            $data['user_id']=$m_user_id;
            $data['entry_date']=date("Y-m-d");
            $data['entry_time']=date("H:i:s");
            $data['valid']=$m_valid;
            $data['psm_id']=$m_psm_id;

            DB::table('pro_attendance')->insert($data);

            // step 2

            $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
            
            $m_in_time=$m_att_policy->in_time;
            $m_in_time_graced=$m_att_policy->in_time_graced;
            $m_out_time=$m_att_policy->out_time;
            $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
            $m_weekly_holiday2=$m_att_policy->weekly_holiday2;


            // Govt Holi checking here
            $m_holiday=DB::table('pro_holiday')->Where('holiday_date',$first_date)->first();
            // $m_holiday_date=$m_holiday->holiday_date;

            if ($m_holiday===null)
            {
            $daysts="R";
            $sts="A";
            }
            else
            {
            $daysts="H";
            $sts="H";
            }

            //Weekly Holiday Checki here if not Govt Holidy
            if ($daysts!="H")
            {
            if ($prweekday==$m_weekly_holiday1)
            {
            $daysts="W";
            $sts="W";
            }
            else if ($prweekday==$m_weekly_holiday2)
            {
            $daysts="W";
            $sts="W";
            }
            else
            {
            $daysts="R";
            $sts="A";
            }
            }//if ($daysts!="H")*/
            $m_process_status=2;

            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$first_date)->update([
            'r_in_time'=>$m_in_time,
            'p_in_time'=>$m_in_time_graced,
            'p_out_time'=>$m_out_time,
            'day_status'=>$daysts,
            'status'=>$sts,
            'process_status'=>$m_process_status,
            ]);


//end of step 2
// step 3

            $m_attn_employee_03 = DB::table('pro_attendance')
            ->where('employee_id',$m_employee_id)
            ->where('process_status',2)
            ->where('attn_date',$first_date)
            ->first();


            $latetime='0';
            $questionable='0';
        
            $m_r_in_time=$m_attn_employee_03->r_in_time;
            $m_p_in_time=$m_attn_employee_03->p_in_time;
            $m_status=$m_attn_employee_03->status;

            $m_att_policy_03=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
            
            $m_grace_time=$m_att_policy_03->grace_time;
            $m_out_time=$m_att_policy_03->out_time;

            $mm_r_in_time_01=(strtotime($m_r_in_time) - (60*60));
            $mm_r_in_time_02=(strtotime($m_r_in_time) + (60*60));
            $mm_r_out_time_01=(strtotime($m_out_time) - (60*60));
            $mm_r_out_time_02=(strtotime($m_out_time) + (60*60));

            $check_in_time_01=date('H:i:s',$mm_r_in_time_01);
            $check_in_time_02=date('H:i:s',$mm_r_in_time_02);
            $check_out_time_01=date('H:i:s',$mm_r_out_time_01);
            $check_out_time_02=date('H:i:s',$mm_r_out_time_02);
            // dd("$m_r_in_time - $check_in_time_01 - $check_in_time_02");


            $m_tmp_log_min = DB::table("$m_pro_tmp_log")
            ->where('emp_id',$m_employee_id)
            ->where('logdate',$first_date)
            ->whereBetween('logtime',[$check_in_time_01,$check_in_time_02])
            ->min('logtime');

            $aa="09:00:00";
            if (strtotime($m_out_time)<strtotime($aa))
            {
            $txt_out_date=date('Y-m-d', strtotime($first_date . ' +1 day'));

            $m_tmp_log_max = DB::table('pro_tmp_log')
            ->where('emp_id',$m_employee_id)
            ->where('logdate',$txt_out_date)
            ->whereBetween('logtime',[$check_out_time_01,$check_out_time_02])
            ->max('logtime');

                // dd("$m_out_time - $check_out_time_01 - $check_out_time_02 - $m_tmp_log_out");
            } else {

            $m_tmp_log_max = DB::table('pro_tmp_log')
            ->where('emp_id',$m_employee_id)
            ->where('logdate',$first_date)
            ->whereBetween('logtime',[$check_out_time_01,$check_out_time_02])
            ->max('logtime');

            }
            // dd('aaaaa');

            if ($m_tmp_log_min === null)
            {
                $m_in_time='00:00:00';
            } else {
                $m_in_time=$m_tmp_log_min;
            }

            if ($m_tmp_log_max === null)
            {
                $m_out_time='00:00:00';
            } else {
                $m_out_time=$m_tmp_log_max;
            }

            $tot_minuts = (strtotime($m_in_time) - strtotime($m_p_in_time));
            $timeDiffin = floor($tot_minuts / 60);

            if ($m_in_time == '00:00:00')
            {
                if ($m_status!="H")
                {
                    if ($m_status!="W")
                    {
                        if ($m_status!="L")
                        {
                        $m_status="A";  
                        }
                    }
                }

            } else {
                if ($timeDiffin>0)
                {
                    $latetime=$timeDiffin+$m_grace_time;
                    $m_status="D";
                } else {
                    $latetime=0;
                    $m_status="P";
                } //if ($timeDiffin>0)
                
                if ($m_in_time==$m_out_time)
                {
                    $questionable=1;
                } else {
                    $questionable=0;
                } //if ($m_in_time==$m_out_time)
            }//if ($m_in_time == '00:00:00')

            $m_process_status=3;

            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$first_date)->update([
            'in_time'=>$m_in_time,
            'out_time'=>$m_out_time,
            'late_min'=>$latetime,
            'status'=>$m_status,
            'is_quesitonable'=>$questionable,
            'process_status'=>$m_process_status,
            ]);


// step 4

            $m_attn_employee_04 = DB::table('pro_attendance')
            ->where('employee_id',$m_employee_id)
            ->where('process_status',3)
            ->where('attn_date',$first_date)
            ->first();

            // $m_employee_id=$m_attn_employee_04->employee_id;
            // $m_attn_date_01=$m_attn_employee_04->attn_date;
            $m_in_time=$m_attn_employee_04->in_time;
            $m_out_time=$m_attn_employee_04->out_time;
            $m_att_policy_id_04=$m_attn_employee_04->att_policy_id;
            $m_process_status='4';

            if($m_in_time=='00:00:00')
            {
                $m_nodeid_in='0';
            }
            else
            {
                $m_tmp_log_in = DB::table('pro_tmp_log')
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$first_date)
                ->where('logtime',$m_in_time)
                ->first();
                $m_nodeid_in=$m_tmp_log_in->nodeid;
            }

            if($m_out_time=='00:00:00')
            {
                $m_nodeid_out='0';
            }
            else
            {

            $m_att_policy_04=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id_04)->first();
            
            $m_out_time_04=$m_att_policy_04->out_time;

            $mmm_r_out_time_01=(strtotime($m_out_time_04) - (60*60));
            $mmm_r_out_time_02=(strtotime($m_out_time_04) + (60*60));

            $check_out_time_011=date('H:i:s',$mmm_r_out_time_01);
            $check_out_time_022=date('H:i:s',$mmm_r_out_time_02);

            $aa="09:00:00";
            if (strtotime($m_out_time_04)<strtotime($aa))
            {
                $txt_out_date_04=date('Y-m-d', strtotime($first_date . ' +1 day'));

                $m_tmp_log_out = DB::table('pro_tmp_log')
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$txt_out_date_04)
                ->where('logtime',$m_out_time)
                ->orderBy('tmp_login_id','asc')
                ->first();
                $m_nodeid_out=$m_tmp_log_out->nodeid;
            } else {
                $m_tmp_log_out = DB::table('pro_tmp_log')
                ->where('emp_id',$m_employee_id)
                ->where('logdate',$first_date)
                ->where('logtime',$m_out_time)
                ->orderBy('tmp_login_id','asc')
                ->first();
                $m_nodeid_out=$m_tmp_log_out->nodeid;

            }//if (strtotime($m_out_time_04)<strtotime($aa))
            }//if($m_out_time=='00:00:00')


            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$first_date)->update([
            'nodeid_in'=>$m_nodeid_in,
            'nodeid_out'=>$m_nodeid_out,
            'process_status'=>$m_process_status,
            ]);

//step 5

            $m_attn_employee_05 = DB::table('pro_attendance')
            ->where('employee_id',$m_employee_id)
            ->where('day_status','R')
            ->where('attn_date',$first_date)
            ->first();

            if ($m_attn_employee_05===null)
            {
            $timeDiffin_out='0';
            $m_p_out_time=$m_attn_employee_04->p_out_time;//m_out_time
            $m_out_time=$m_attn_employee_04->out_time;
            $m_status=$m_attn_employee_04->status;
            $m_process_status='5';
            $m_early_grace_time='10';

            } else {

            $timeDiffin_out='0';
            $m_p_out_time=$m_attn_employee_05->p_out_time;//m_out_time
            $m_out_time=$m_attn_employee_05->out_time;
            $m_status=$m_attn_employee_05->status;
            $m_process_status='5';
            $m_early_grace_time='10';
            }

            if($m_status=='A')
            {
                $timeDiffin_out = '0';
            } else {
            $tot_early_minuts = (strtotime($m_out_time) - strtotime($m_p_out_time));
            $timeDiffin_out = floor($tot_early_minuts / 60);
            }

            DB::table('pro_attendance')->where('employee_id',$m_employee_id)->where('attn_date',$first_date)->update([
            'early_min'=>$timeDiffin_out,
            'process_status'=>$m_process_status,
            ]);

            // return "$first_date - $m_in_time - $m_out_time - $daysts";


            } else {//if ($m_pro_attendance===null)

            // return "aa $first_date - $request->cbo_employee_id";
            }//if ($m_pro_attendance===null)


        
        //increase date and i
        $first_date=date('Y-m-d', strtotime($first_date . ' +1 day'));
        $i++;
        } //while($i <= $tot_days){

        return redirect()->back()->with('success',"$request->txt_atten_date Data Individual Process Successfully!");




    } //public function attendance_ind_processstore(Request $request)




//leave_process

    public function hrmbackleave_process()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.leave_process',compact('user_company'));

    }
    public function hrm_leave_process(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";


        $ci_pro_attendance=DB::table("$m_attendance")
        ->Where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        // ->Where('process_status','>','4')
        ->groupBy('company_id')
        ->first(); //query builder
// dd($ci_pro_attendance);
        if ($ci_pro_attendance===null)
        {
            return redirect()->back()->withInput()->with('warning','Data Not Found');  

        } else {

            $m_leave_sql_01=DB::table('pro_leave_info_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('leave_date',[$txt_frist_date,$txt_last_date])
            ->Where('valid','1')
            ->orderBy('leave_info_details_id','asc')
            ->count();

            if ($m_leave_sql_01=='0')
            {
              return redirect()->back()->withInput()->with('warning','Data Not Found');  

            } else {

            $m_leave_sql=DB::table('pro_leave_info_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('leave_date',[$txt_frist_date,$txt_last_date])
            ->Where('valid','1')
            ->orderBy('leave_info_details_id','asc')
            ->get();
         
            foreach($m_leave_sql as $key=>$row_leave_sql)
            {

            $m_employee_id=$row_leave_sql->employee_id;
            $m_leave_date=$row_leave_sql->leave_date;
            $m_process_status='6';
            $m_status="L";
// dd("$m_employee_id -- $m_leave_date");
            DB::table("$m_attendance")
            ->where('employee_id',$m_employee_id)
            ->where('attn_date',$m_leave_date)
            ->update([
            'status'=>$m_status,
            'process_status'=>$m_process_status,
            ]);
            }//foreach($m_leave_sql as $key=>$row_leave_sql)  

              return redirect()->back()->withInput()->with('success','Leave Process');
            }//if ($m_leave_sql===null)
        }//if ($ci_pro_attendance===null)

    }

//movement_process

    public function hrmbackmovement_process()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.movement_process',compact('user_company'));

    }

    public function hrm_movement_process(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";

        $ci_pro_attendance=DB::table("$m_attendance")
        ->Where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        // ->Where('process_status','>','4')
        ->groupBy('company_id')
        ->first(); //query builder

        if ($ci_pro_attendance===null)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  

        } else {
        // DD($ci_pro_attendance->company_id);

            $m_move_sql_01=DB::table('pro_late_inform_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('late_date',[$txt_frist_date,$txt_last_date])
            ->whereBetween('late_type_id',[1,2])
            ->Where('valid','1')
            ->orderBy('late_info_details_id','asc')
            ->count();

            if ($m_move_sql_01=='0')
            {
              return redirect()->back()->withInput()->with('warning','Data Not Found');  

            } else {

                $m_move_sql=DB::table('pro_late_inform_details')
                ->Where('company_id',$request->cbo_company_id)
                ->whereBetween('late_date',[$txt_frist_date,$txt_last_date])
                ->Where('valid','1')
                ->orderBy('late_info_details_id','asc')
                ->get();

                foreach($m_move_sql as $key=>$row_move_sql)
                {
                $m_employee_id=$row_move_sql->employee_id;
                $m_move_date=$row_move_sql->late_date;
                $m_process_status='6';
                $m_status="P";

                DB::table("$m_attendance")
                ->where('employee_id',$m_employee_id)
                ->where('attn_date',$m_move_date)
                ->update([
                    'status'=>$m_status,
                    'process_status'=>$m_process_status,
                ]);
                }//foreach($m_move_sql as $key=>$row_move_sql)
                  return redirect()->back()->withInput()->with('success','Movement Process');  
                
            }//if ($m_move_sql_01=='0')
        }//if ($ci_pro_attendance===null)

    }

//early_process

    public function HrmEarlyProcess()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.early_process',compact('user_company'));

    }

    public function HrmEarlyProcessStore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";

        $ci_pro_attendance=DB::table("$m_attendance")
        ->Where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        // ->Where('process_status','>','4')
        ->groupBy('company_id')
        ->first(); //query builder

        if ($ci_pro_attendance===null)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  

        } else {
        // DD($ci_pro_attendance->company_id);

            $m_move_sql_01=DB::table('pro_late_inform_details')
            ->Where('company_id',$request->cbo_company_id)
            ->whereBetween('late_date',[$txt_frist_date,$txt_last_date])
            ->where('late_type_id','3')
            ->Where('valid','1')
            ->orderBy('late_info_details_id','asc')
            ->count();

            if ($m_move_sql_01=='0')
            {
              return redirect()->back()->withInput()->with('warning','Data Not Found');  

            } else {

                $m_move_sql=DB::table('pro_late_inform_details')
                ->Where('company_id',$request->cbo_company_id)
                ->whereBetween('late_date',[$txt_frist_date,$txt_last_date])
                ->Where('late_type_id','3')
                ->Where('valid','1')
                ->orderBy('late_info_details_id','asc')
                ->get();

                foreach($m_move_sql as $key=>$row_move_sql)
                {
                $m_employee_id=$row_move_sql->employee_id;
                $m_move_date=$row_move_sql->late_date;
                $m_process_status='6';
                $m_early_min='0';

                DB::table("$m_attendance")
                ->where('employee_id',$m_employee_id)
                ->where('attn_date',$m_move_date)
                ->update([
                    'early_min'=>$m_early_min,
                    'process_status'=>$m_process_status,
                ]);
                }//foreach($m_move_sql as $key=>$row_move_sql)
                  return redirect()->back()->withInput()->with('success','Early Process');  
                
            }//if ($m_move_sql_01=='0')
        }//if ($ci_pro_attendance===null)

    }

//time_process

    public function HrmTimeProcess()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.time_process',compact('user_company'));

    }

    public function HrmTimeProcessStore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";

        $ci_pro_attendance=DB::table("$m_attendance")
        ->Where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        // ->Where('process_status','>','4')
        ->groupBy('company_id')
        ->first(); //query builder

        if ($ci_pro_attendance===null)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  

        } else {
        // DD($ci_pro_attendance->company_id);
        // $txt_employee_id="30000114";
        $m_pro_attendance=DB::table("$m_attendance")
        ->Where('company_id',$request->cbo_company_id)
        // ->Where('employee_id',$txt_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->get(); //query builder

// dd("$m_pro_attendance");
        foreach($m_pro_attendance as $key=>$row_pro_attendance)
        {
        $m_employee_id=$row_pro_attendance->employee_id;
        $m_attn_date=$row_pro_attendance->attn_date;
        $m_in_time=$row_pro_attendance->in_time;
        $m_out_time=$row_pro_attendance->out_time;
        $m_att_policy_id=$row_pro_attendance->att_policy_id;
        $m_process_status='7';
        // $m_working_min='0';
// dd("$m_employee_id");
        $ci_att_policy=DB::table('pro_att_policy')
        ->Where('att_policy_id',$m_att_policy_id)
        ->first();

        $prweekday = date('l', strtotime($m_attn_date));
        $m_policy_status=$ci_att_policy->policy_status;

        if($m_policy_status==2)
        {
            $m_att_policy_sub=DB::table('pro_att_policy_sub')
            ->Where('att_policy_id',$m_att_policy_id)
            ->Where('day',$prweekday)
            ->first();

            $m_lunch_break=$m_att_policy_sub->lunch_break;

        } else {
            $m_lunch_break='60';
        }//if($m_policy_status==2)

        // $working_minuts = (strtotime($m_in_time) - strtotime($m_out_time));
        $working_minuts = (strtotime($m_out_time) - strtotime($m_in_time));
        $timeDiffin = floor($working_minuts / 60);
        $m_working_minuts = $timeDiffin - $m_lunch_break;
        // dd($timeDiffin);

        DB::table("$m_attendance")
        ->where('employee_id',$m_employee_id)
        ->where('attn_date',$m_attn_date)
        ->update([
            'working_min'=>$m_working_minuts,
            'process_status'=>$m_process_status,
        ]);
        }//foreach($m_pro_attendance as $key=>$row_pro_attendance)

        return redirect()->back()->withInput()->with('success','Working Time Process');  
                
        }//if ($ci_pro_attendance===null)

    }


//summary_process

    public function hrmbacksummary_process()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        // return view('hrm.employee_attendance',compact('user_company'));

        $ci_summ_attn_master=DB::table('pro_summ_attn_master')->Where('valid','1')->orderBy('summ_attn_master_id','asc')->get(); //query builder
        return view('hrm.summary_process',compact('user_company','ci_summ_attn_master'));

    }

    public function hrmbacksummary_processstore(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);
        $m_user_id=Auth::user()->emp_id;
        $m_valid='1';
        $m_status='1';

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";


        $m_summ_attn_master=DB::table('pro_summ_attn_master')
        ->Where('company_id',$request->cbo_company_id)
        ->Where('month',$month_number)
        ->Where('year',$txt_year)
        ->Where('valid','1')
        ->orderby('company_id')
        ->first(); //query builder

        if ($m_summ_attn_master===null)
        {
            // dd($this->m_user_id);

            $data=array();
            $data['company_id']=$request->cbo_company_id;
            $data['month']=$txt_month1;
            $data['year']=$txt_year;
            $data['prepare_id']=$m_user_id;
            $data['status']=$m_status;
            $data['entry_date']=date('Y-m-d');
            $data['entry_time']=date('H:i:s');
            $data['valid']=$m_valid;

            DB::table('pro_summ_attn_master')->insert($data);

            $m_summ_attn_master = DB::table('pro_summ_attn_master')
            ->where('month',$txt_month1)
            ->where('year',$txt_year)
            ->max('summ_attn_master_id');

            $m_attn_employee = DB::table("$m_attendance")
            ->where('company_id',$request->cbo_company_id)
            ->where('process_status','>','3')
            ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
            ->where('valid','1')
            ->groupBy('employee_id')->get();

            foreach ($m_attn_employee as $row_attn_employee)
            {
                $m_employee_id=$row_attn_employee->employee_id;
                $m_desig_id=$row_attn_employee->desig_id;
                $m_department_id=$row_attn_employee->department_id;
                $m_placeofposting_id=$row_attn_employee->placeofposting_id;

                //company Info
                $m_company=DB::table('pro_company')
                ->Where('company_id',$request->cbo_company_id)
                ->Where('valid',1)
                ->first();
                $mm_company=$m_company->company_name;

                //Employee Info
                $m_employee_info=DB::table('pro_employee_info')
                ->Where('employee_id',$m_employee_id)
                ->Where('valid',1)
                ->first();
                $mm_employee_name=$m_employee_info->employee_name;

                //desig Info
                $m_desig=DB::table('pro_desig')
                ->Where('desig_id',$m_desig_id)
                ->Where('valid',1)
                ->first();
                $mm_desig=$m_desig->desig_name;

                //department Info
                $m_department_info=DB::table('pro_department')
                ->Where('department_id',$m_department_id)
                ->Where('valid',1)
                ->first();
                $mm_department_name=$m_department_info->department_name;

                //placeofposting Info
                $m_placeofposting_info=DB::table('pro_placeofposting')
                ->Where('placeofposting_id',$m_placeofposting_id)
                ->Where('valid',1)
                ->first();
                $mm_placeofposting_name=$m_placeofposting_info->placeofposting_name;

                $m_working_day=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','R')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_twd=$m_working_day;

                $m_weekend=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','W')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_w=$m_weekend;

                $m_holiday=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','H')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_h=$m_holiday;

                $m_leave=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','L')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_l=$m_leave;

                $m_present=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','P')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_present=$m_present;

                $m_absent=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','A')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_absent=$m_absent;

                $m_late=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','D')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_late=$m_late;

                $m_early=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('early_min','<', 0)
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_early=$m_early;

                // dd("$m_summ_attn_master -- $mm_company -- $m_employee_id -- $m_desig_id -- $m_department_id -- $m_placeofposting_id");

                $data=array();
                $data['summ_attn_master_id']=$m_summ_attn_master;
                $data['company_id']=$request->cbo_company_id;
                $data['company_name']=$mm_company;
                $data['employee_id']=$m_employee_id;
                $data['employee_name']=$mm_employee_name;
                $data['desig_id']=$m_desig_id;
                $data['desig_name']=$mm_desig;
                $data['department_id']=$m_department_id;
                $data['department_name']=$mm_department_name;
                $data['placeofposting_id']=$m_placeofposting_id;
                $data['placeofposting_name']=$mm_placeofposting_name;
                $data['working_day']=$m_twd;
                $data['weekend']=$m_w;
                $data['holiday']=$m_h;
                $data['total_leave']=$m_l;
                $data['present']=$m_present;
                $data['absent']=$m_absent;
                $data['late']=$m_late;
                $data['early_out']=$m_early;
                $data['user_id']=$m_user_id;
                $data['entry_date']=date('Y-m-d');
                $data['entry_time']=date('H:i:s');
                $data['valid']=$m_valid;
                $data['month']=$txt_month1;
                $data['year']=$txt_year;

                DB::table('pro_summ_attn_details')->insert($data);



            }//foreach ($m_attn_employee as $row_attn_employee)
          return redirect()->back()->withInput()->with('success',"$request->cbo_company_id Summery Process Completed");  

        } else {

            $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

            $m_attn_employee = DB::table("$m_attendance")
            ->where('company_id',$request->cbo_company_id)
            // ->where('process_status','>','3')
            ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
            ->where('valid','1')
            ->groupBy('employee_id')
            ->get();

            foreach ($m_attn_employee as $row_attn_employee)
            {
                $m_employee_id=$row_attn_employee->employee_id;
                // $m_desig_id=$row_attn_employee->desig_id;
                // $m_department_id=$row_attn_employee->department_id;
                // $m_placeofposting_id=$row_attn_employee->placeofposting_id;

                $m_working_day=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','R')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_twd=$m_working_day;
                // dd($m_twd);

                $m_weekend=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','W')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_w=$m_weekend;

                $m_holiday=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('day_status','H')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_h=$m_holiday;

                $m_leave=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','L')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_l=$m_leave;

                $m_present=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','P')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_present=$m_present;

                $m_absent=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','A')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_absent=$m_absent;

                $m_late=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('status','D')
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_late=$m_late;

                $m_early=DB::table("$m_attendance")
                ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
                ->where('early_min','<', 0)
                ->where('employee_id',$m_employee_id)
                ->groupBy('attn_date')
                ->having('attn_date','>',1)
                ->count();
                $m_early=$m_early;

                // dd("$m_summ_attn_master -- $mm_company -- $m_employee_id -- $m_desig_id -- $m_department_id -- $m_placeofposting_id");

                DB::table('pro_summ_attn_details')
                ->where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->where('employee_id',$m_employee_id)
                // ->where('attn_date',$m_move_date)
                ->update([
                    'working_day'=>$m_twd,
                    'weekend'=>$m_w,
                    'holiday'=>$m_h,
                    'total_leave'=>$m_l,
                    'present'=>$m_present,
                    'absent'=>$m_absent,
                    'late'=>$m_late,
                    'early_out'=>$m_early,
                ]);

            }//foreach ($m_attn_employee as $row_attn_employee)




          // return redirect()->back()->withInput()->with('warning','Data already exists!!');  
          return redirect()->back()->withInput()->with('warning',"$request->cbo_company_id Data Update Successfully !!!");  
        }//if ($m_summ_attn_master===null)

    }




//payroll_process

    public function hrmbackpayroll_process()
    {

        return view('hrm.payroll_process');

    }

    public function HrmDataQuery()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();
        return view('hrm.data_query',compact('user_company'));


    }

    public function HrmDataQueryList(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'txt_query_date' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'txt_query_date.required' => 'Select Query Date.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';
        $m_employee_info = DB::table('pro_employee_info')
        ->where('company_id',$request->cbo_company_id)
        ->where('working_status',1)
        ->where('valid',1)
        ->where('ss',1)
        ->get();

        $txt_date=$request->txt_query_date;
        $m_year=date("y",strtotime($txt_date));
        $m_month=date("m",strtotime($txt_date));
        $m_month_year="$m_month$m_year";

        return view('hrm.data_query_list',compact('m_employee_info','txt_date','m_month_year'));

        // foreach ($m_employee_info as $row_emp_info){


        // $m_tmp_log = DB::table('pro_tmp_log')
        // ->where('emp_id',$m_employee_info->employee_id)
        // ->where('logdate',$request->txt_query_date)
        // ->get();
        // }
        // dd($m_tmp_log);
    }



//summery_attendance report

    public function hrmbacksummary_attendance()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        // $ci_summ_attn_master=DB::table('pro_summ_attn_master')->Where('valid','1')->orderBy('summ_attn_master_id','asc')->get(); //query builder
        return view('hrm.summary_attendance',compact('user_company'));

        // return view('hrm.summary_attendance');

    }

public function hrmbacksummary_attendance_report(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'txt_month.required' => 'Month is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_summ_attn_master=DB::table('pro_summ_attn_master')
        ->Where('company_id',$request->cbo_company_id)
        ->Where('month',$txt_month1)
        ->Where('year',$txt_year)
        ->first();

        if ($m_summ_attn_master === null)
        {
            return redirect()->back()->withInput()->with('warning','Sorry Data not found !!!!!!');
        } else {


        $ci_company=DB::table('pro_company')->Where('company_id',$request->cbo_company_id)->first();
        $txt_company_name=$ci_company->company_name;

        $data = array();
        $data['summ_attn_master_id']=$m_summ_attn_master->summ_attn_master_id;
        $data['company_id']=$request->cbo_company_id;
        $data['company_name']= $txt_company_name;
        $data['month']=$txt_month1;
        $data['month_name']=$month_name;
        $data['year']=$txt_year;
        $data['sele_placeofposting']=$request->sele_placeofposting;


            if($request->sele_placeofposting=='0')
            {
                $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

                $ci_summ_attn_report=DB::table('pro_summ_attn_details')
                ->Where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->Where('valid','1')
                ->orderBy('summ_attn_details_id','asc')
                ->get(); //query builder
                return view('hrm.summary_attendance_report',compact('ci_summ_attn_report','data'));
            } else {

                $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

                $ci_summ_attn_report=DB::table('pro_summ_attn_details')
                ->Where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->Where('placeofposting_id',$request->sele_placeofposting)
                ->Where('valid','1')
                ->orderBy('summ_attn_details_id','asc')
                ->get(); //query builder
                return view('hrm.summary_attendance_report',compact('ci_summ_attn_report','data'));
            }//if($request->sele_placeofposting=='0')

        }//if ($m_summ_attn_master === null)


    }

public function hrmbacksummary_attendance_print($summ_attn_master_id,$sele_placeofposting)
    {
        $m_summ_attn_master=DB::table('pro_summ_attn_master')
        ->Where('summ_attn_master_id',$summ_attn_master_id)
        ->first();

        $ci_company=DB::table('pro_company')->Where('company_id',$m_summ_attn_master->company_id)->first();
        $txt_company_name=$ci_company->company_name;

        $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$sele_placeofposting)->first();
        if(isset($ci_placeofposting)){
            $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;
        }else{
            $txt_placeofposting_name='All Place';
        }


        $data = array();
        $data['company_name']= $txt_company_name;
        $data['month_name']= date("F", mktime(0, 0, 0, $m_summ_attn_master->month, 10));
        $data['year']=$m_summ_attn_master->year;
        $data['txt_placeofposting_name']=$txt_placeofposting_name;


        if ($m_summ_attn_master === null)
        {
            return redirect()->back()->withInput()->with('warning','Sorry Data not found !!!!!!');
        } else {

            if($sele_placeofposting=='0')
            {
                $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

                $ci_summ_attn_report=DB::table('pro_summ_attn_details')
                ->Where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->Where('valid','1')
                ->orderBy('summ_attn_details_id','asc')
                ->get(); //query builder
                return view('hrm.summary_attendance_report_print',compact('ci_summ_attn_report','data'));
            } else {

                $txt_summ_attn_master_id=$m_summ_attn_master->summ_attn_master_id;

                $ci_summ_attn_report=DB::table('pro_summ_attn_details')
                ->Where('summ_attn_master_id',$txt_summ_attn_master_id)
                ->Where('placeofposting_id',$sele_placeofposting)
                ->Where('valid','1')
                ->orderBy('summ_attn_details_id','asc')
                ->get(); //query builder

             

                return view('hrm.summary_attendance_report_print',compact('ci_summ_attn_report','data'));
            }//if($request->sele_placeofposting=='0')

        }//if ($m_summ_attn_master === null)

    }    
//summery Leave report

    public function hrmsummary_leave()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.summary_leave',compact('user_company'));

    }

    public function hrmsummary_leave_report(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,100',
            'txt_year' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'txt_year.required' => 'Year is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $m_year=$request->txt_year;

        $txt_frist_date="$m_year-01-01";
        $txt_last_date="$m_year-12-31";

        // $txt_month1=date("m",strtotime($txt_frist_date));
        // $txt_year=date("Y",strtotime($txt_frist_date));

        // $month_number = $txt_month1;
        // $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $ci_leave_config = DB::table("pro_leave_config")
            ->join("pro_leave_type", "pro_leave_config.leave_type_id", "pro_leave_type.leave_type_id")
            ->select("pro_leave_config.*", "pro_leave_type.*")
            ->Where('pro_leave_type.valid','1')
            ->get();


        $ci_company=DB::table('pro_company')
        ->Where('company_id',$request->cbo_company_id)
        ->first();

        $ci_employee_info=DB::table('pro_employee_info')
        ->Where('company_id',$request->cbo_company_id)
        ->Where('working_status','1')
        ->Where('valid','1')
        ->Where('ss','1')
        ->get();

        return view('hrm.summary_leave_report',compact('ci_leave_config','m_year','ci_company','ci_employee_info'));

    }









    public function hrmsummary_attendance_posting()
    {

        $m_placeofposting = DB::table("pro_placeofposting")
            ->Where('valid',1)
            ->get();

        return view('hrm.summary_attn_posting',compact('m_placeofposting'));

    }

    public function HrmSummaryPostingAttnReport(Request $request)
    {
    $rules = [
            'cbo_placeofposting' => 'required|integer|between:1,1000',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_placeofposting.required' => 'Select Place of Posting.',
            'cbo_placeofposting.integer' => 'Select Place of Posting.',
            'cbo_placeofposting.between' => 'Select Place of Posting.',

            'txt_month.required' => 'Month is required.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            // ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            // ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();
            // dd("$user_company->company_id");

        if($request->cbo_placeofposting!='0')
        {
            // dd($request->sele_placeofposting);

            $ci_summ_attn_report_posting=DB::table('pro_summ_attn_details')
            ->Where('month',$txt_month1)
            ->Where('year',$txt_year)
            ->Where('placeofposting_id',$request->cbo_placeofposting)
            // ->Where('company_id',$row1->company_id)
            ->Where('valid','1')
            ->orderBy('summ_attn_details_id','asc')
            ->get(); //query builder
            return view('hrm.summary_attn_posting_report',compact('ci_summ_attn_report_posting','txt_month1','txt_year','month_name'));

        }
        

    }


    public function postingEmployee(Request $request, $id)
    {
        $data = DB::table('pro_employee_info')->where('placeofposting_id',$id)->where('valid',1)->get();
        return response()->json(['data' => $data]);
    }

//attendance report

    public function hrmattenind()
    {

        return view('hrm.rpt_atten_ind');

    }

    public function hrmattenindrpt(Request $request)
    {
    $rules = [
            'txt_month' => 'required',
        ];

        $customMessages = [

            'txt_month.required' => 'Select Year Month.',
        ];        

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['txt_month'] = $request->txt_month;
        $data['cbo_employee_id'] = $request->txt_user_id;


        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance1="pro_attendance_$txt_month1$m_year";

        // dd("$txt_month -- $txt_frist_date -- $txt_last_date -- $month_number -- $month_name -- $txt_year -- $m_attendance");

        $m_atten_emp=DB::table("$m_attendance1")
        ->Where('employee_id',$request->txt_user_id)
        ->first();
        if ($m_atten_emp === null)
        {
            return redirect()->back()->withInput()->with('warning','Sorry Data not found !!!!!!');
        } else {


        $m_attendance=DB::table("$m_attendance1")
        ->groupBy('attn_date')
        ->having('attn_date','>',1)
        ->Where('employee_id',$request->txt_user_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        // ->orderBy('attendance_id','asc')
        ->get(); //query builder
        // dd($m_attendance);
        return view('hrm.rpt_atten_ind_show',compact('m_attendance','data'));
        }
        // return view('hrm.rpt_atten_ind');

    }

    public function HrmAttnIndReportPrint($txt_month , $cbo_employee_id)
    {
        $txt_month=$txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";

        $m_pro_attendance=DB::table("$m_attendance")
        ->Where('employee_id',$cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->count(); //query builder

        if ($m_pro_attendance<1)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  
        } else {

      $ci_pro_attendance=DB::table("$m_attendance")
        ->groupBy('attn_date')
        ->having('attn_date','>',1)
        ->Where('employee_id',$cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('process_status','>','2')
        ->Where('valid','1')
        // ->orderBy('attendance_id','asc')
        ->get(); //query builder

          return view('hrm.emp_attn_report_print',compact('ci_pro_attendance'));
        }
    }

//employee_attendance report

    public function hrmbackemployee_attendance()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.employee_attendance',compact('user_company'));

        // return view('hrm.employee_attendance');

    }

 
 public function hrmbackemp_attn_report(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'cbo_employee_id' => 'required',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'txt_month.required' => 'Select Month Year.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['txt_month'] = $request->txt_month;
        $data['cbo_employee_id'] = $request->cbo_employee_id;

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";

        if (Schema::hasTable("$m_attendance"))
        {

        $m_pro_attendance=DB::table("$m_attendance")
        ->Where('employee_id',$request->cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('process_status','>','2')
        ->Where('valid','1')
        ->count(); //query builder

        if ($m_pro_attendance<1)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  
        } else {

      $ci_pro_attendance=DB::table("$m_attendance")
        ->groupBy('attn_date')
        ->having('attn_date','>',1)
        ->Where('employee_id',$request->cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('process_status','>','2')
        ->Where('valid','1')
        // ->orderBy('attendance_id','asc')
        ->get(); //query builder

          return view('hrm.emp_attn_report',compact('ci_pro_attendance','data'));
        }
        } else {//if (Schema::hasTable("$m_attendance"))
            return redirect()->back()->withInput()->with('warning',"$month_name Data Not Found");
        }

    }

    public function hrmbackemp_attn_report_print($txt_month , $cbo_employee_id)
    {
        $txt_month=$txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        $txt_year=date("Y",strtotime($txt_frist_date));

        $month_number = $txt_month1;
        $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_attendance="pro_attendance_$txt_month1$m_year";

        $m_pro_attendance=DB::table("$m_attendance")
        ->Where('employee_id',$cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('valid','1')
        ->count(); //query builder

        if ($m_pro_attendance<1)
        {
          return redirect()->back()->withInput()->with('warning','Data Not Found');  
        } else {

      $ci_pro_attendance=DB::table("$m_attendance")
        ->groupBy('attn_date')
        ->having('attn_date','>',1)
        ->Where('employee_id',$cbo_employee_id)
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->Where('process_status','>','2')
        ->Where('valid','1')
        // ->orderBy('attendance_id','asc')
        ->get(); //query builder

          return view('hrm.emp_attn_report_print',compact('ci_pro_attendance'));
        }
    }
//Daily Punch report

    public function hrmbackdaily_punch()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();
        return view('hrm.daily_punch',compact('user_company'));


    }

    public function hrmbackdaily_punch_report(Request $request)
    {
    $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            'cbo_employee_id' => 'required',
            'txt_month' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'txt_month.required' => 'Select Punch Month.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $txt_month=$request->txt_month;

        $txt_frist_date=date("Y-m-01", strtotime($txt_month));
        $txt_last_date=date("Y-m-t", strtotime($txt_month));

        $txt_month1=date("m",strtotime($txt_frist_date));
        // $txt_year=date("Y",strtotime($txt_frist_date));
        $txt_year=date("y",strtotime($txt_frist_date));

        // $month_number = $txt_month1;
        // $month_name = date("F", mktime(0, 0, 0, $month_number, 10));

        $m_year=date("y",strtotime($txt_frist_date));
        $m_tmp_log1="pro_tmp_log_$txt_month1$m_year";

        if (Schema::hasTable("$m_tmp_log1"))
        {
            $txt_from_date=$txt_frist_date;
            $txt_to_date=$txt_last_date;
            $txt_employee_id=$request->cbo_employee_id;

            $m_tmp_log = DB::table("$m_tmp_log1")
            ->where('emp_id',$txt_employee_id)
            ->whereBetween('logdate',[$txt_from_date,$txt_to_date])
            ->get();

            if ($m_tmp_log === null)
            {
              return redirect()->back()->withInput()->with('warning' , 'Data Not Found!!');  

            } else {

              return view('hrm.emp_punch_report',compact('m_tmp_log'));

            }//if ($m_from_date === null)
        } else { //if (Schema::hasTable("$m_tmp_log1"))
            return redirect()->back()->withInput()->with('warning' , 'Data Not Found!!');
        }
    }

//Data Split

    public function HrmDataSplit()
    {

        $m_user_id=Auth::user()->emp_id;
        
        return view('hrm.data_split');


    }

    public function HrmDataSplitStore(Request $request)
    {
    $rules = [
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];

        $customMessages = [

            'txt_from_date.required' => 'Select From Date.',
            'txt_to_date.required' => 'Select To Dater.',

        ];        

        $this->validate($request, $rules, $customMessages);

        // $txt_month=$request->txt_month;

        $txt_frist_date=$request->txt_from_date;
        $txt_last_date=$request->txt_to_date;

// for temp log

        // $m_tmp_log = DB::table('pro_tmp_log')
        // ->whereBetween('logdate',[$txt_frist_date,$txt_last_date])
        // ->where('valid','1')
        // ->get();

        //     foreach ($m_tmp_log as $row_tmp_log)
        //     {

        //     $data=array();
        //     $data['tmp_records_id']=$row_tmp_log->tmp_records_id;
        //     $data['logdate']=$row_tmp_log->logdate;
        //     $data['logtime']=$row_tmp_log->logtime;
        //     $data['emp_id']=$row_tmp_log->emp_id;
        //     $data['nodeid']=$row_tmp_log->nodeid;
        //     $data['authtype']=$row_tmp_log->authtype;
        //     $data['is_read']=$row_tmp_log->is_read;
        //     $data['valid']=$row_tmp_log->valid;

        //     DB::table('pro_tmp_log_0823')->insert($data);

        //     }//foreach ($m_tmp_log as $row_tmp_log)


//for daily attendance

        $m_pro_attendance = DB::table('pro_attendance')
        ->whereBetween('attn_date',[$txt_frist_date,$txt_last_date])
        ->where('valid','1')
        ->get();

            foreach ($m_pro_attendance as $row_pro_attendance)
            {

            $data=array();
            $data['company_id']=$row_pro_attendance->company_id;
            $data['employee_id']=$row_pro_attendance->employee_id;
            $data['machine_id']=$row_pro_attendance->machine_id;
            $data['desig_id']=$row_pro_attendance->desig_id;
            $data['department_id']=$row_pro_attendance->department_id;
            $data['placeofposting_id']=$row_pro_attendance->placeofposting_id;
            $data['att_policy_id']=$row_pro_attendance->att_policy_id;
            $data['attn_date']=$row_pro_attendance->attn_date;
            $data['r_in_time']=$row_pro_attendance->r_in_time;
            $data['p_in_time']=$row_pro_attendance->p_in_time;
            $data['p_out_time']=$row_pro_attendance->p_out_time;
            $data['in_time']=$row_pro_attendance->in_time;
            $data['nodeid_in']=$row_pro_attendance->nodeid_in;
            $data['out_time']=$row_pro_attendance->out_time;
            $data['nodeid_out']=$row_pro_attendance->nodeid_out;
            $data['day_name']=$row_pro_attendance->day_name;
            $data['day_status']=$row_pro_attendance->day_status;
            $data['total_working_hour']=$row_pro_attendance->total_working_hour;
            $data['ot_minute']=$row_pro_attendance->ot_minute;
            $data['late_min']=$row_pro_attendance->late_min;
            $data['early_min']=$row_pro_attendance->early_min;
            $data['status']=$row_pro_attendance->status;
            $data['is_quesitonable']=$row_pro_attendance->is_quesitonable;
            $data['process_status']=$row_pro_attendance->process_status;
            $data['is_quesitonable']=$row_pro_attendance->is_quesitonable;
            $data['user_id']=$row_pro_attendance->user_id;
            $data['entry_date']=$row_pro_attendance->entry_date;
            $data['entry_time']=$row_pro_attendance->entry_time;
            $data['valid']=$row_pro_attendance->valid;
            $data['psm_id']=$row_pro_attendance->psm_id;

            DB::table('pro_attendance_0823')->insert($data);

            }//foreach ($m_tmp_log as $row_tmp_log)

          return redirect()->back()->withInput()->with('success',"$txt_frist_date");  




    }




//Daily Attendance aaa

    public function hrmAttenAaa()
    {

        $m_user_id=Auth::user()->emp_id;
        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();
        return view('hrm.rpt_atten_date_range',compact('user_company'));


    }

    public function hrmAaaReport(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
            // 'cbo_employee_id' => 'required',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            // 'cbo_employee_id.required' => 'Select Employee.',
            // 'cbo_employee_id.integer' => 'Select Employee.',
            // 'cbo_employee_id.between' => 'Select Employee.',

            'txt_from_date.required' => 'Select Start Date.',
            'txt_to_date.required' => 'Select End Date.',

        ];        

        $this->validate($request, $rules, $customMessages);

        $m_valid='1';
        $txt_from_date=$request->txt_from_date;
        $txt_to_date=$request->txt_to_date;
        $txt_employee_id=$request->cbo_employee_id;
        // $txt_employee_id=104;
        if ($txt_employee_id=='0')
        {
        $m_employee_info = DB::table('pro_employee_info')
        ->where('company_id',$request->cbo_company_id)
        ->where('working_status', '1')
        ->where('ss', '1')
        ->get();           
        } else {
        $m_employee_info = DB::table('pro_employee_info')
        ->where('company_id',$request->cbo_company_id)
        ->where('employee_id',$txt_employee_id)
        ->get();           
        }

        $m_atten_aaa = DB::table('pro_attendance')
        ->where('company_id',$request->cbo_company_id)
        ->whereBetween('attn_date',[$txt_from_date,$txt_to_date])
        ->get();

        $m_company = DB::table('pro_company')
        ->where('company_id',$request->cbo_company_id)
        ->where('valid','1')
        ->first();

        // return $m_employee_info;

        // dd($m_tmp_log);
        if ($m_atten_aaa === null)
        {
            return redirect()->back()->withInput()->with('warning' , 'Data Not Found!!');  

        } else {

            return view('hrm.date_range_atten_report',compact('m_employee_info','txt_from_date','txt_to_date','m_company'));

        }//if ($m_from_date === null)
    }


//leave_application_list

    public function hrmbackleave_application_list()
    {

        $m_user_id=Auth::user()->emp_id;

        $mentrydate=time();
        $m_leave_year=date("Y",$mentrydate);
        
        // dd($m_leave_year);
        // $user_company = DB::table("pro_user_company")
        //     ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        //     ->select("pro_user_company.*", "pro_company.company_name")
        //     ->Where('employee_id',$m_user_id)
        //     ->get();

        $m_leave_info_master = DB::table('pro_leave_info_master')
        ->Where('employee_id',$m_user_id)
        ->Where('valid','1')
        ->Where('leave_year',$m_leave_year)
        ->orderby('leave_form', 'DESC')
        ->get();

        $m_level_step = DB::table('pro_level_step')
        ->join("pro_employee_info", "pro_level_step.report_to_id", "pro_employee_info.employee_id")
        ->select("pro_level_step.*", "pro_employee_info.employee_name")
        ->Where('pro_level_step.employee_id',$m_user_id)
        ->Where('pro_level_step.valid','1')
        ->orderby('pro_level_step.level_step', 'ASC')
        ->get();

        return view('hrm.leave_application_list',compact('m_leave_info_master','m_level_step'));
        // return view('hrm.leave_application_list');

    }

    public function RptEmpList()
    {
        $m_user_id=Auth::user()->emp_id;
        
        $data=DB::table('pro_employee_info')->Where('valid','1')->Where('working_status','1')->orderBy('employee_id','asc')->get(); //query builder

        
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id',$m_user_id)
            ->get();

        return view('hrm.rpt_basic_info_list',compact('data','user_company'));

    }

    public function RptEmpListAll()
    {
        // $m_user_id=Auth::user()->emp_id;
        
        $data=DB::table('pro_employee_info')->Where('valid','1')->Where('working_status','1')->orderBy('employee_id','asc')->get(); //query builder

        
        // $user_company = DB::table("pro_user_company")
        //     ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        //     ->select("pro_user_company.*", "pro_company.company_name")
        //     ->Where('employee_id',$m_user_id)
        //     ->get();

        return view('hrm.rpt_basic_info_list_all',compact('data'));

    }


//Sub Place Of Postion
    public function HrmSubPlaceOfPosting()
    {
       $m_placeofposting=DB::table('pro_placeofposting')
        ->Where('valid','1')
        ->orderBy('placeofposting_id','asc')
        ->get();
        return view('hrm.sub_placeofposting',compact('m_placeofposting'));
    }    

    public function HrmSubPlaceOfPostingStore(Request $request)
    {
        $rules = [
            'cbo_posting' => 'required',
            'txt_sub_posting' => 'required',
        ];

        $customMessages = [
            'cbo_posting.required' => 'Select Posting.',
            'txt_sub_posting.integer' => 'Sub-Posting is required.',
        ];        
        $this->validate($request, $rules, $customMessages);
        $m_user_id=Auth::user()->emp_id;
        $m_entry_date=date('Y-m-d');
        $m_entry_time=date('H:i:s');

        $check =  DB::table('pro_sub_placeofposting')
        ->where('placeofposting_id',$request->cbo_posting)
        ->where('sub_placeofposting_name',$request->txt_sub_posting)
        ->first();
        if($check){
         return back()->with('warning',"Alredy Taken $request->txt_sub_posting!");
        }else{            
        $data = array();
        $data['placeofposting_id']=$request->cbo_posting;
        $data['sub_placeofposting_name']=$request->txt_sub_posting;
        $data['user_id']=$m_user_id;
        $data['entry_date']=$m_entry_date;
        $data['entry_time']=$m_entry_time;
        $data['valid']=1;
        DB::table('pro_sub_placeofposting')->insert($data);
        return back()->with('success',"$request->txt_sub_posting Add Successfully!");
        }
    }
//End Sub Place Of Postion

//Daily Shift Change

    
    public function HrmEmpDayShift()
    {
        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_placeofposting=DB::table('pro_placeofposting')
        ->Where('valid','1')
        ->orderBy('placeofposting_id','asc')
        ->get();

        $m_section=DB::table('pro_section')
        ->Where('valid','1')
        ->orderBy('section_id','asc')
        ->get();

        return view('hrm.emp_day_shift',compact('user_company','m_placeofposting','m_section'));

    }
 
    public function HrmEmpDayShiftStore(Request $request)
    {
        $rules = [
            'txt_atten_date' => 'required',
            'cbo_company_id' => 'required',
            'cbo_posting' => 'required',
            'cbo_section' => 'required',
            'cbo_employee_id' => 'required',
            'sele_att_policy' => 'required',
        ];

        $customMessages = [
            'txt_atten_date.required' => 'Attendance date is required.',
            'cbo_company_id.required' => 'Select Company.',
            'cbo_posting.required' => 'Select Posting.',
            'cbo_section.required' => 'Select Section.',
            'cbo_employee_id.required' => 'Select Employee.',
            'sele_att_policy.required' => 'Select Policy.',
        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->update([
            'att_policy_id'=>$request->sele_att_policy
        ]);
         
         return redirect()->route('emp_day_shift_details',[$request->txt_atten_date,$request->cbo_company_id,$request->cbo_posting,$request->cbo_sub_posting]);
    }


    public function HrmEmpDayShiftDetails($attn_date,$id,$id1,$id2){
        $m_user_id=Auth::user()->emp_id;
        
        $m_company=DB::table('pro_company')
        ->Where('company_id',$id)
        ->first();

        $m_placeofposting=DB::table('pro_placeofposting')
        ->Where('placeofposting_id',$id1)
        ->first();

        $m_sub_placeofposting=DB::table('pro_sub_placeofposting')
        ->Where('placeofposting_sub_id',$id2)
        ->first();

        $m_section=DB::table('pro_section')
        ->Where('valid','1')
        ->orderBy('section_id','asc')
        ->get();

        // return view('hrm.emp_day_shift_details',compact('m_company','m_placeofposting','m_section','attn_date','m_employee','sub_placeofposting_name'));
        return view('hrm.emp_day_shift_details',compact('attn_date','m_company','m_placeofposting','m_sub_placeofposting','m_section'));
    }

    
    public function HrmEmpDayShiftDetailsStore(Request $request)
    {
        $rules = [
            'cbo_section' => 'required',
            'cbo_employee_id' => 'required',
            'sele_att_policy' => 'required',
        ];

        $customMessages = [
            'cbo_section.required' => 'Select Section.',
            'cbo_employee_id.required' => 'Select Employee.',
            'sele_att_policy.required' => 'Select Policy.',
        ];        

        $this->validate($request, $rules, $customMessages);

        DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->update([
            'att_policy_id'=>$request->sele_att_policy
        ]);

       $employee = DB::table('pro_employee_info')->where('employee_id',$request->cbo_employee_id)->first();
       $employee_name = $employee->employee_name;

         return redirect()->route('emp_day_shift_details',[$request->txt_atten_date,$request->cbo_company_id,$request->cbo_posting,$request->cbo_sub_posting])->with('success',"$request->cbo_employee_id | $employee_name -Shift Updated Successfull! ");
    }

    public function HrmEmpDayShiftFinal($attn_date,$id,$id1,$id2)
    {
        $m_user_id = Auth::user()->emp_id;

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $all_employee = DB::table('pro_employee_info')
        ->where('company_id',$id)
        ->where('placeofposting_id',$id1)
        ->where('placeofposting_sub_id',$id2)
        ->where('working_status', '1')
        ->where('ss', '1')
        ->where('valid', '1')
        ->get();

        $prweekday = date('l', strtotime($attn_date));

        foreach ($all_employee as $value)
        {

            $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$value->att_policy_id)->first();
            
            $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
            $m_weekly_holiday2=$m_att_policy->weekly_holiday2;
            $m_policy_status=$m_att_policy->policy_status;

            if($m_policy_status==2)
            {
                $m_att_policy_sub=DB::table('pro_att_policy_sub')
                ->Where('att_policy_id',$value->att_policy_id)
                ->Where('day',$prweekday)
                ->first();

                $m_in_time=$m_att_policy_sub->in_time;
                $m_in_time_graced=$m_att_policy_sub->in_time_graced;
                $m_out_time=$m_att_policy_sub->out_time;

            } else {
                $m_in_time=$m_att_policy->in_time;
                $m_in_time_graced=$m_att_policy->in_time_graced;
                $m_out_time=$m_att_policy->out_time;
            }


            $data = array();
            $data['attn_date'] = $attn_date;
            $data['company_id'] = $value->company_id;
            $data['employee_id'] = $value->employee_id;
            $data['desig_id'] = $value->desig_id;
            $data['department_id'] = $value->department_id;
            $data['section_id'] = $value->section_id;
            $data['placeofposting_id'] = $value->placeofposting_id;
            $data['placeofposting_sub_id'] = $value->placeofposting_sub_id;
            $data['att_policy_id'] = $value->att_policy_id;
            $data['r_in_time'] = $m_in_time;
            $data['p_in_time'] = $m_in_time_graced;
            $data['p_out_time'] = $m_out_time;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = $m_entry_date;
            $data['entry_time'] = $m_entry_time;
            $data['valid'] = $value->valid;
            $data['psm_id'] = $value->psm_id;
            $data['staff_id'] = $value->staff_id;

            $check =  DB::table('pro_emp_day_policy')
            ->where('employee_id',$value->employee_id)
            ->where('attn_date',$attn_date)
            ->first();
            // return $check;
            if(isset($check)){
            DB::table('pro_emp_day_policy')
            ->where('employee_id',$value->employee_id)
            ->where('attn_date',$attn_date)
            ->update($data);
            }else{
             DB::table('pro_emp_day_policy')->insert($data);
            }
        }
        return redirect()->route('emp_day_shift')->with('success',"Day Shift Change Successfully!");


    }

    public function HrmEmpDayShiftNoChange()
    {
        $m_user_id=Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
        ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        ->select("pro_user_company.*", "pro_company.company_name")
        ->Where('employee_id',$m_user_id)
        ->get();

        $m_placeofposting=DB::table('pro_placeofposting')
        ->Where('valid','1')
        ->orderBy('placeofposting_id','asc')
        ->get();

        return view('hrm.emp_day_shift_no_change',compact('user_company','m_placeofposting'));

    }

    public function HrmEmpDayShiftFinalnoChange(Request $request)
    {
        $rules = [
            'txt_atten_date' => 'required',
            'cbo_company_id' => 'required',
            'cbo_posting' => 'required',
        ];

        $customMessages = [
            'txt_atten_date.required' => 'Attendance date is required.',
            'cbo_company_id.required' => 'Select Company.',
            'cbo_posting.required' => 'Select Posting.',
        ];        

        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;

        $mentrydate=time();
        $m_entry_date=date("Y-m-d",$mentrydate);
        $m_entry_time=date("H:i:s",$mentrydate);

        $all_employee = DB::table('pro_employee_info')
        ->where('company_id', $request->cbo_company_id)
        ->where('placeofposting_id', $request->cbo_posting)
        ->where('working_status', '1')
        ->where('ss', '1')
        ->where('valid', '1')
        ->get();

        $prweekday = date('l', strtotime($request->txt_atten_date));

        foreach ($all_employee as $value)
        {

            $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$value->att_policy_id)->first();
            
            $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
            $m_weekly_holiday2=$m_att_policy->weekly_holiday2;
            $m_policy_status=$m_att_policy->policy_status;

            if($m_policy_status==2)
            {
                $m_att_policy_sub=DB::table('pro_att_policy_sub')
                ->Where('att_policy_id',$value->att_policy_id)
                ->Where('day',$prweekday)
                ->first();

                $m_in_time=$m_att_policy_sub->in_time;
                $m_in_time_graced=$m_att_policy_sub->in_time_graced;
                $m_out_time=$m_att_policy_sub->out_time;

            } else {
                $m_in_time=$m_att_policy->in_time;
                $m_in_time_graced=$m_att_policy->in_time_graced;
                $m_out_time=$m_att_policy->out_time;
            }

            $data = array();
            $data['attn_date'] = $request->txt_atten_date;
            $data['company_id'] = $value->company_id;
            $data['employee_id'] = $value->employee_id;
            $data['desig_id'] = $value->desig_id;
            $data['department_id'] = $value->department_id;
            $data['section_id'] = $value->section_id;
            $data['placeofposting_id'] = $value->placeofposting_id;
            $data['placeofposting_sub_id'] = $value->placeofposting_sub_id;
            $data['att_policy_id'] = $value->att_policy_id;
            $data['r_in_time'] = $m_in_time;
            $data['p_in_time'] = $m_in_time_graced;
            $data['p_out_time'] = $m_out_time;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = $m_entry_date;
            $data['entry_time'] = $m_entry_time;
            $data['valid'] = $value->valid;
            $data['psm_id'] = $value->psm_id;
            $data['staff_id'] = $value->staff_id;

            $check =  DB::table('pro_emp_day_policy')
            ->where('employee_id',$value->employee_id)
            ->where('attn_date',$request->txt_atten_date)
            ->first();
            // return $check;
            if(isset($check)){
            DB::table('pro_emp_day_policy')
            ->where('employee_id',$value->employee_id)
            ->where('attn_date',$request->txt_atten_date)
            ->update($data);
            }else{
             DB::table('pro_emp_day_policy')->insert($data);
            }
        }

       $m_company = DB::table('pro_company')
       ->where('company_id',$request->cbo_company_id)
       ->first();
       $txt_company_name = $m_company->company_name;

       $m_placeofposting = DB::table('pro_placeofposting')
       ->where('placeofposting_id',$request->cbo_posting)
       ->first();
       $txt_placeofposting_name = $m_placeofposting->placeofposting_name;

        return redirect()->route('emp_day_shift_no_change')->with('success',"$request->txt_atten_date |  $txt_company_name | $txt_placeofposting_name Day Shift Change Successfully!");

    }


    //Ajax call get- Employee
    public function GetEmployee($id)
    {
        $data = DB::table('pro_employee_info')
        ->where('working_status', '1')
        ->where('ss', '1')
        ->where('company_id', $id)
        ->get();
        return json_encode($data);
    }    

    public function GetEmployeeDayShift($m_company,$m_posting,$m_section,$m_sub_posting)
    {
        if($m_sub_posting == 0){     
            $data = DB::table('pro_employee_info')
            ->where('working_status', '1')
            ->where('ss', '1')
            ->where('company_id', $m_company)
            ->where('placeofposting_id', $m_posting)
            ->where('section_id', $m_section)
            ->get();
        }else{
             $data = DB::table('pro_employee_info')
            ->where('working_status', '1')
            ->where('ss', '1')
            ->where('company_id', $m_company)
            ->where('placeofposting_id', $m_posting)
            ->where('placeofposting_sub_id', $m_sub_posting)
            ->where('section_id', $m_section)
            ->get();
        }

        return json_encode($data);
    }

    public function GetPolicy($m_company)
    {
        $data = DB::table('pro_att_policy')
          ->Where('valid', '1')
          ->Where('company_id', $m_company)
          ->orderBy('att_policy_id', 'asc')
          ->get();
        return json_encode($data);
    }    

    public function GetSubPosting($placeofposting_id)
    {
        $data=DB::table('pro_sub_placeofposting')
        ->Where('placeofposting_id',$placeofposting_id)
        ->Where('valid','1')
        ->get();
        return json_encode($data);
    }

    public function GetEmployeeBio($id)
    {
        $data = DB::table('pro_employee_info')
        ->where('working_status', '1')
        // ->where('ss', '1')
        ->where('company_id', $id)
        ->get();
        return json_encode($data);
    }

    public function GetEmployeeWS($id)
    {
        $data = DB::table('pro_employee_info')
        // ->where('working_status', '1')
        ->where('ss', '1')
        ->where('company_id', $id)
        ->get();
        return json_encode($data);
    }

    public function GetEmployeeDesig($id)
    {
        $data = DB::table('pro_employee_info')
            ->leftJoin('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->leftJoin('pro_placeofposting', 'pro_employee_info.placeofposting_id', 'pro_placeofposting.placeofposting_id')
            ->select('pro_employee_info.*', 'pro_desig.desig_name', 'pro_placeofposting.placeofposting_name')
            ->where('pro_employee_info.employee_id', $id)
            ->first();

        return json_encode($data);
    }


    public function GetHrmBasicInfoList()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->where('employee_id', $m_user_id)
            ->where('valid',1)
            ->pluck('company_id');

        $data = DB::table('pro_employee_info')
            ->leftJoin('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
            ->leftJoin('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->leftJoin('pro_department', 'pro_employee_info.department_id', 'pro_department.department_id')
            ->leftJoin('pro_section', 'pro_employee_info.section_id', 'pro_section.section_id')
            ->leftJoin('pro_placeofposting', 'pro_employee_info.placeofposting_id', 'pro_placeofposting.placeofposting_id')
            ->leftJoin('pro_blood', 'pro_employee_info.blood_group', 'pro_blood.blood_id')
            ->leftJoin('pro_att_policy', 'pro_employee_info.att_policy_id', 'pro_att_policy.att_policy_id')
            ->leftJoin('pro_yesno', 'pro_employee_info.working_status', 'pro_yesno.yesno_id')
            ->leftJoin('pro_employee_info as report_to', 'report_to.employee_id','=','pro_employee_info.report_to_id')
            ->select(
                "pro_employee_info.*",
                "pro_company.company_name",
                "pro_desig.desig_name",
                "pro_department.department_name",
                "pro_section.section_name",
                "pro_placeofposting.placeofposting_name",
                "pro_blood.blood_name",
                "pro_att_policy.att_policy_name",
                "pro_yesno.yesno_name",
                "report_to.employee_name as report_name",

            )
            ->whereIn('pro_employee_info.company_id', $user_company)
            ->where('pro_employee_info.valid', '1')
            ->where('pro_employee_info.working_status', '1')
            ->orderBy('pro_employee_info.employee_id', 'asc')
            ->get();

        return json_encode($data);
    }

    public function GetHrmBasicInfoUpList()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->where('employee_id', $m_user_id)
            ->where('valid',1)
            ->pluck('company_id');

        $data = DB::table('pro_employee_info')
            ->leftJoin('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
            ->leftJoin('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->leftJoin('pro_department', 'pro_employee_info.department_id', 'pro_department.department_id')
            ->leftJoin('pro_section', 'pro_employee_info.section_id', 'pro_section.section_id')
            ->leftJoin('pro_placeofposting', 'pro_employee_info.placeofposting_id', 'pro_placeofposting.placeofposting_id')
            ->leftJoin('pro_blood', 'pro_employee_info.blood_group', 'pro_blood.blood_id')
            ->leftJoin('pro_att_policy', 'pro_employee_info.att_policy_id', 'pro_att_policy.att_policy_id')
            ->leftJoin('pro_yesno', 'pro_employee_info.working_status', 'pro_yesno.yesno_id')
            ->leftJoin('pro_employee_info as report_to', 'report_to.employee_id','=','pro_employee_info.report_to_id')
            ->select(
                "pro_employee_info.*",
                "pro_company.company_name",
                "pro_desig.desig_name",
                "pro_department.department_name",
                "pro_section.section_name",
                "pro_placeofposting.placeofposting_name",
                "pro_blood.blood_name",
                "pro_att_policy.att_policy_name",
                "pro_yesno.yesno_name",
                "report_to.employee_name as report_name",

            )
            ->whereIn('pro_employee_info.company_id', $user_company)
            ->where('pro_employee_info.valid', '1')
            ->where('pro_employee_info.working_status', '1')
            ->orderBy('pro_employee_info.employee_id', 'asc')
            ->get();

        return json_encode($data);
    }

    public function GetRptBasicInfoList()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->where('employee_id', $m_user_id)
            ->where('valid',1)
            ->pluck('company_id');

        $data = DB::table('pro_employee_info')
            ->leftJoin('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
            ->leftJoin('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->leftJoin('pro_department', 'pro_employee_info.department_id', 'pro_department.department_id')
            ->leftJoin('pro_section', 'pro_employee_info.section_id', 'pro_section.section_id')
            ->leftJoin('pro_placeofposting', 'pro_employee_info.placeofposting_id', 'pro_placeofposting.placeofposting_id')
            ->leftJoin('pro_blood', 'pro_employee_info.blood_group', 'pro_blood.blood_id')
            ->leftJoin('pro_att_policy', 'pro_employee_info.att_policy_id', 'pro_att_policy.att_policy_id')
            ->leftJoin('pro_yesno', 'pro_employee_info.working_status', 'pro_yesno.yesno_id')
            ->leftJoin('pro_employee_info as report_to', 'report_to.employee_id','=','pro_employee_info.report_to_id')
            ->select(
                "pro_employee_info.*",
                "pro_company.company_name",
                "pro_desig.desig_name",
                "pro_department.department_name",
                "pro_section.section_name",
                "pro_placeofposting.placeofposting_name",
                "pro_blood.blood_name",
                "pro_att_policy.att_policy_name",
                "pro_yesno.yesno_name",
                "report_to.employee_name as report_name",

            )
            ->whereIn('pro_employee_info.company_id', $user_company)
            ->where('pro_employee_info.valid', '1')
            ->where('pro_employee_info.working_status', '1')
            ->orderBy('pro_employee_info.employee_id', 'asc')
            ->get();

        return json_encode($data);
    }




    public function GetRptBasicInfoListAll()
    {

        $data = DB::table('pro_employee_info')
            ->leftJoin('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
            ->leftJoin('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->leftJoin('pro_department', 'pro_employee_info.department_id', 'pro_department.department_id')
            ->leftJoin('pro_placeofposting', 'pro_employee_info.placeofposting_id', 'pro_placeofposting.placeofposting_id')
            ->leftJoin('pro_blood', 'pro_employee_info.blood_group', 'pro_blood.blood_id')
            ->select(
                "pro_employee_info.*",
                "pro_company.company_name",
                "pro_desig.desig_name",
                "pro_department.department_name",
                "pro_placeofposting.placeofposting_name",
                "pro_blood.blood_name",

            )
            ->where('pro_employee_info.valid', '1')
            ->where('pro_employee_info.working_status', '1')
            // ->orderBy('pro_employee_info.employee_name', 'asc')
            ->orderBy('pro_company.company_id')
            ->get();


        return json_encode($data);
    }

    //Get- Product Sub Group
    public function GetCompanyPolicy($id)
    {
        $data = DB::table('pro_att_policy')
            ->where('valid', '1')
            ->where('company_id', $id)
            ->get();
        return json_encode($data);
    }



}