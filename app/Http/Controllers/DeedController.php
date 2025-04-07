<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeedController extends Controller
{

    //Land Owner Function
    public function DeedLandOwnerInfo()
    {
        $pro_land_owner_info = DB::table("pro_land_owner_info")->get();
        return view('deed.land_owner_info', compact('pro_land_owner_info'));
    }
    public function DeedLandOwnerInfoStore(Request $request)
    {
        $rules = [
            'txt_owner_name_bang' => 'required',
            'txt_owner_father_name_bang' => 'required',
            'txt_owner_mother_name_bang' => 'required',
            'txt_owner_dob' => 'required',
            'txt_owner_name_eng' => 'required',
            'txt_owner_father_name_eng' => 'required',
            'txt_owner_mother_name_eng' => 'required',
            'txt_owner_religious_bang' => 'required',
            'txt_owner_profession_bang' => 'required',
            'txt_owner_nationality_bang' => 'required',
            'txt_owner_nid_bang' => 'required',
            'txt_owner_religious_eng' => 'required',
            'txt_owner_profession_eng' => 'required',
            'txt_owner_nationality_eng' => 'required',
            'txt_owner_nid_eng' => 'required',
            'txt_owner_parmanent_add_bang' => 'required',
            'txt_owner_parmanent_add_eng' => 'required',
            'txt_owner_present_add_bang' => 'required',
            'txt_owner_present_add_eng' => 'required',
        ];

        $customMessages = [
            'txt_owner_name_bang.required' => 'Name field is required!',
            'txt_owner_name_eng.required' => 'Name field is required!',
            'txt_owner_father_name_bang.required' => 'Father name field is required!',
            'txt_owner_father_name_eng.required' => 'Father name field is required!',
            'txt_owner_mother_name_bang.required' => 'Mother name field is required!',
            'txt_owner_mother_name_eng.required' => 'Mother name field is required!',
            'txt_owner_dob.required' => 'Date of birth field is required!',
            'txt_owner_religious_bang.required' => 'Religious field is required!',
            'txt_owner_religious_eng.required' => 'Religious field is required!',
            'txt_owner_profession_bang.required' => 'Profession field is required!',
            'txt_owner_profession_eng.required' => 'Profession field is required!',
            'txt_owner_nationality_bang.required' => 'Nationality field is required!',
            'txt_owner_nationality_eng.required' => 'Nationality field is required!',
            'txt_owner_nid_bang.required' => 'NID field is required!',
            'txt_owner_nid_eng.required' => 'NID field is required!',
            'txt_owner_parmanent_add_bang.required' => 'Permanent Address field is required!',
            'txt_owner_parmanent_add_eng.required' => 'Permanent Address field is required!',
            'txt_owner_present_add_bang.required' => 'Pressent Address field is required!',
            'txt_owner_present_add_eng.required' => 'Pressent Address field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        // check land owner
        $land_owner = DB::table('pro_land_owner_info')->where('owner_name_eng', $request->txt_owner_name_eng)->first();
        //dd($abcd);

        if ($land_owner === null) {

            $m_valid = '1';

            $data = array();
            // $data['user_info_id'] = Auth::id();
            $data['owner_name_bang'] = $request->txt_owner_name_bang;
            $data['owner_name_eng'] = $request->txt_owner_name_eng;
            $data['owner_father_name_bang'] = $request->txt_owner_father_name_bang;
            $data['owner_father_name_eng'] = $request->txt_owner_father_name_eng;
            $data['owner_mother_name_bang'] = $request->txt_owner_mother_name_bang;
            $data['owner_mother_name_eng'] = $request->txt_owner_mother_name_eng;
            $data['owner_dob'] = $request->txt_owner_dob;
            $data['owner_religous_bang'] = $request->txt_owner_religious_bang;
            $data['owner_religous_eng'] = $request->txt_owner_religious_eng;
            $data['owner_profession_bang'] = $request->txt_owner_profession_bang;
            $data['owner_profession_eng'] = $request->txt_owner_profession_eng;
            $data['owner_nationality_bang'] = $request->txt_owner_nationality_bang;
            $data['owner_nationality_eng'] = $request->txt_owner_nationality_eng;
            $data['owner_nid_bang'] = $request->txt_owner_nid_bang;
            $data['owner_nid_eng'] = $request->txt_owner_nid_eng;
            $data['owner_permanent_add_bang'] = $request->txt_owner_parmanent_add_bang;
            $data['owner_permanent_add_eng'] = $request->txt_owner_parmanent_add_eng;
            $data['owner_present_add_bang'] = $request->txt_owner_present_add_bang;
            $data['owner_present_add_eng'] = $request->txt_owner_present_add_eng;
            $data['emp_id'] = $request->txt_emp_id;
            $data['valid'] = $m_valid;
            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            DB::table("pro_land_owner_info")->insert($data);

            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $land_owner_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($land_owner === null)

    }

    public function DeedLandOwnerInfoEdit($id)
    {
        $pro_land_owner_info_edit = DB::table("pro_land_owner_info")->where('land_owner_info_id', $id)->first();
        $data = DB::table('pro_land_owner_info')->Where('valid', '1')->orderBy('land_owner_info_id', 'desc')->get();
        return view('deed.land_owner_info', compact('data', 'pro_land_owner_info_edit'));
    }

    public function DeedLandOwnerInfoUpdate(Request $request, $id)
    {
        $rules = [
            'txt_owner_name_bang' => 'required',
            'txt_owner_father_name_bang' => 'required',
            'txt_owner_mother_name_bang' => 'required',
            'txt_owner_dob' => 'required',
            'txt_owner_name_eng' => 'required',
            'txt_owner_father_name_eng' => 'required',
            'txt_owner_mother_name_eng' => 'required',
            'txt_owner_religious_bang' => 'required',
            'txt_owner_profession_bang' => 'required',
            'txt_owner_nationality_bang' => 'required',
            'txt_owner_nid_bang' => 'required',
            'txt_owner_religious_eng' => 'required',
            'txt_owner_profession_eng' => 'required',
            'txt_owner_nationality_eng' => 'required',
            'txt_owner_nid_eng' => 'required',
            'txt_owner_parmanent_add_bang' => 'required',
            'txt_owner_parmanent_add_eng' => 'required',
            'txt_owner_present_add_bang' => 'required',
            'txt_owner_present_add_eng' => 'required',
        ];

        $customMessages = [
            'txt_owner_name_bang.required' => 'Name field is required!',
            'txt_owner_name_eng.required' => 'Name field is required!',
            'txt_owner_father_name_bang.required' => 'Father name field is required!',
            'txt_owner_father_name_eng.required' => 'Father name field is required!',
            'txt_owner_mother_name_bang.required' => 'Mother name field is required!',
            'txt_owner_mother_name_eng.required' => 'Mother name field is required!',
            'txt_owner_dob.required' => 'Date of birth field is required!',
            'txt_owner_religious_bang.required' => 'Religious field is required!',
            'txt_owner_religious_eng.required' => 'Religious field is required!',
            'txt_owner_profession_bang.required' => 'Profession field is required!',
            'txt_owner_profession_eng.required' => 'Profession field is required!',
            'txt_owner_nationality_bang.required' => 'Nationality field is required!',
            'txt_owner_nationality_eng.required' => 'Nationality field is required!',
            'txt_owner_nid_bang.required' => 'NID field is required!',
            'txt_owner_nid_eng.required' => 'NID field is required!',
            'txt_owner_parmanent_add_bang.required' => 'Permanent Address field is required!',
            'txt_owner_parmanent_add_eng.required' => 'Permanent Address field is required!',
            'txt_owner_present_add_bang.required' => 'Pressent Address field is required!',
            'txt_owner_present_add_eng.required' => 'Pressent Address field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        // $data = array();

        DB::table('pro_land_owner_info')->where('land_owner_info_id', $id)->update([

            'owner_name_bang' => $request->txt_owner_name_bang,
            'owner_name_eng' => $request->txt_owner_name_eng,
            'owner_father_name_bang' => $request->txt_owner_father_name_bang,
            'owner_father_name_eng' => $request->txt_owner_father_name_eng,
            'owner_mother_name_bang' => $request->txt_owner_mother_name_bang,
            'owner_mother_name_eng' => $request->txt_owner_mother_name_eng,
            'owner_dob' => $request->txt_owner_dob,
            'owner_religous_bang' => $request->txt_owner_religious_bang,
            'owner_religous_eng' => $request->txt_owner_religious_eng,
            'owner_profession_bang' => $request->txt_owner_profession_bang,
            'owner_profession_eng' => $request->txt_owner_profession_eng,
            'owner_nationality_bang' => $request->txt_owner_nationality_bang,
            'owner_nationality_eng' => $request->txt_owner_nationality_eng,
            'owner_nid_bang' => $request->txt_owner_nid_bang,
            'owner_nid_eng' => $request->txt_owner_nid_eng,
            'owner_permanent_add_bang' => $request->txt_owner_parmanent_add_bang,
            'owner_permanent_add_eng' => $request->txt_owner_parmanent_add_eng,
            'owner_present_add_bang' => $request->txt_owner_present_add_bang,
            'owner_present_add_eng' => $request->txt_owner_present_add_eng,
        ]);
        return redirect(route('land_owner_info'))->with('success', 'Data Updated Successfully!');
    }
    //End Land Owner Function

    //Thana Info
    public function DeedThanaInfo()
    {
        $pro_thana_infos = DB::table("pro_upazilas")
            ->join("pro_divisions", "pro_upazilas.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_upazilas.districts_id", "pro_districts.districts_id")
            ->select("pro_upazilas.*", "pro_divisions.divisions_name", "pro_divisions.divisions_bn_name", "pro_districts.district_name", "pro_districts.district_bn_name")
            ->get();

        $pro_divisions = DB::table('pro_divisions')->get();
        return view('deed.thana_info', compact('pro_divisions', 'pro_thana_infos'));
    }

    public function DeedThanaInfoStore(Request $request)
    {

        $rules = [
            'cbo_division_id' => 'required|integer|between:1,10',
            'cbo_district_id' => 'required|integer|between:1,70',
            'txt_upazilas_name' => 'required',
            'txt_upazilas_bn_name' => 'required',
        ];

        $customMessages = [
            'cbo_division_id.required' => 'Select Division.',
            'cbo_division_id.integer' => 'Select Division.',
            'cbo_division_id.between' => 'Select Division.',
            'cbo_district_id.required' => 'Select District.',
            'cbo_district_id.integer' => 'Select District.',
            'cbo_district_id.between' => 'Select District.',
            'txt_upazilas_name.required' => 'Thana / Upazila Name English.',
            'txt_upazilas_bn_name.required' => 'Thana / Upazila Name Bangla.',
        ];
        $this->validate($request, $rules, $customMessages);

        $thana_upazila = DB::table('pro_upazilas')->where('upazilas_name', $request->txt_upazilas_name)->where('divisions_id', $request->cbo_division_id)->where('districts_id', $request->cbo_district_id)->first();
        //dd($abcd);

        if ($thana_upazila === null) {
            $m_valid = '1';
            $data = array();
            $data['divisions_id'] = $request->cbo_division_id;
            $data['districts_id'] = $request->cbo_district_id;
            $data['upazilas_name'] = $request->txt_upazilas_name;
            $data['upazilas_bn_name'] = $request->txt_upazilas_bn_name;
            $data['valid'] = $m_valid;

            DB::table("pro_upazilas")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $thana_upazila_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($thana_upazila === null)

    }

    public function DeedUpzilaEdit($id)
    {

        $pro_thana_info_edit = DB::table('pro_upazilas')
            ->join("pro_districts", "pro_upazilas.districts_id", "pro_districts.districts_id")
            ->select("pro_upazilas.*",  "pro_districts.district_name", "pro_districts.district_bn_name")
            ->where('upazilas_id', $id)
            ->first();
        // return $pro_upazilas;
        $pro_divisions = DB::table('pro_divisions')->get();
        return view('deed.thana_info', compact('pro_divisions', 'pro_thana_info_edit'));
    }

    public function DeedUpzilaUpdate(Request $request, $id)
    {

        $rules = [
            'cbo_division_id' => 'required|integer|between:1,10',
            'cbo_district_id' => 'required|integer|between:1,70',
            'txt_upazilas_name' => 'required',
            'txt_upazilas_bn_name' => 'required',
        ];

        $customMessages = [
            'cbo_division_id.required' => 'Select Division.',
            'cbo_division_id.integer' => 'Select Division.',
            'cbo_division_id.between' => 'Select Division.',
            'cbo_district_id.required' => 'Select District.',
            'cbo_district_id.integer' => 'Select District.',
            'cbo_district_id.between' => 'Select District.',
            'txt_upazilas_name.required' => 'Thana / Upazila Name English.',
            'txt_upazilas_bn_name.required' => 'Thana / Upazila Name Bangla.',
        ];
        $this->validate($request, $rules, $customMessages);

        $thana_upazila_edit = DB::table('pro_upazilas')->where('upazilas_name', $request->txt_upazilas_name)->where('divisions_id', $request->cbo_division_id)->where('districts_id', $request->cbo_district_id)->first();

        if ($thana_upazila_edit === null) {
            DB::table('pro_upazilas')->where('upazilas_id', $id)->update([

                'divisions_id' => $request->cbo_division_id,
                'districts_id' => $request->cbo_district_id,
                'upazilas_name' => $request->txt_upazilas_name,
                'upazilas_bn_name' => $request->txt_upazilas_bn_name,
            ]);
            return redirect(route('thana_info'))->with('success', 'Data Updated Successfully!');
        } else {
            $thana_upazila_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($thana_upazila_edit === null)

    }
    //End Thana info

    //Mouja info
    public function DeedMoujaInfo()
    {
        $pro_mouja_infos = DB::table("pro_moujas")
            ->join("pro_divisions", "pro_moujas.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_moujas.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_moujas.upazilas_id", "pro_upazilas.upazilas_id")
            ->select("pro_moujas.*", "pro_divisions.divisions_name", "pro_divisions.divisions_bn_name", "pro_districts.district_name", "pro_districts.district_bn_name", "pro_upazilas.upazilas_name", "pro_upazilas.upazilas_bn_name")
            ->get();
        $pro_divisions = DB::table('pro_divisions')->get();
        return view('deed.mouja_info', compact('pro_divisions', 'pro_mouja_infos'));
    }

    public function DeedMoujaInfoStore(Request $request)
    {

        $rules = [
            'cbo_division_id' => 'required|integer|between:1,10',
            'cbo_district_id' => 'required|integer|between:1,70',
            'cbo_upazila_id' => 'required|integer|between:1,700',
            'txt_moujas_name' => 'required',
            'txt_moujas_bn_name' => 'required',
        ];

        $customMessages = [
            'cbo_division_id.required' => 'Select Division.',
            'cbo_division_id.integer' => 'Select Division.',
            'cbo_division_id.between' => 'Select Division.',
            'cbo_district_id.required' => 'Select District.',
            'cbo_district_id.integer' => 'Select District.',
            'cbo_district_id.between' => 'Select District.',
            'cbo_upazila_id.required' => 'Select Upazila.',
            'cbo_upazila_id.integer' => 'Select Upazila.',
            'cbo_upazila_id.between' => 'Select Upazila.',
            'txt_moujas_name.required' => 'Mouja Name English.',
            'txt_moujas_bn_name.required' => 'Mouja Name Bangla.',
        ];
        $this->validate($request, $rules, $customMessages);

        $mouja = DB::table('pro_moujas')->where('moujas_name', $request->txt_moujas_name)->where('divisions_id', $request->cbo_division_id)->where('districts_id', $request->cbo_district_id)->first();
        //dd($abcd);

        if ($mouja === null) {
            $m_valid = '1';


            $data = array();
            $data['divisions_id'] = $request->cbo_division_id;
            $data['districts_id'] = $request->cbo_district_id;
            $data['upazilas_id'] = $request->cbo_upazila_id;
            $data['moujas_name'] = $request->txt_moujas_name;
            $data['moujas_bn_name'] = $request->txt_moujas_bn_name;
            $data['valid'] = $m_valid;
            DB::table("pro_moujas")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $mouja_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($mouja === null)

    }

    public function DeedMoujaEdit($id)
    {

        $pro_moujas_edit = DB::table("pro_moujas")
            ->join("pro_divisions", "pro_moujas.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_moujas.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_moujas.upazilas_id", "pro_upazilas.upazilas_id")
            ->select(
                "pro_moujas.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name"
            )
            ->where('moujas_id', $id)
            ->first();
        $pro_divisions = DB::table('pro_divisions')->get();
        return view('deed.mouja_info', compact('pro_divisions', 'pro_moujas_edit'));
    }

    public function DeedMoujaInfoUpdate(Request $request, $id)
    {
        $rules = [
            'cbo_division_id' => 'required|integer|between:1,10',
            'cbo_district_id' => 'required|integer|between:1,70',
            'cbo_upazila_id' => 'required|integer|between:1,700',
            'txt_moujas_name' => 'required',
            'txt_moujas_bn_name' => 'required',
        ];

        $customMessages = [
            'cbo_division_id.required' => 'Select Division.',
            'cbo_division_id.integer' => 'Select Division.',
            'cbo_division_id.between' => 'Select Division.',
            'cbo_district_id.required' => 'Select District.',
            'cbo_district_id.integer' => 'Select District.',
            'cbo_district_id.between' => 'Select District.',
            'cbo_upazila_id.required' => 'Select Upazila.',
            'cbo_upazila_id.integer' => 'Select Upazila.',
            'cbo_upazila_id.between' => 'Select Upazila.',
            'txt_moujas_name.required' => 'Mouja Name English.',
            'txt_moujas_bn_name.required' => 'Mouja Name Bangla.',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['divisions_id'] = $request->cbo_division_id;
        $data['districts_id'] = $request->cbo_district_id;
        $data['upazilas_id'] = $request->cbo_upazila_id;
        $data['moujas_name'] = $request->txt_moujas_name;
        $data['moujas_bn_name'] = $request->txt_moujas_bn_name;
        DB::table("pro_moujas")->where('moujas_id', $id)->update($data);
        return redirect()->route('mouja_info')->with('success', "Mouja info updated Successfull !");
    }

    //End Mouja info

    //Union info
    public function DeedUnionInfo()
    {
        $pro_union_infos = DB::table("pro_unions")
            ->join("pro_upazilas", "pro_unions.upazilas_id", "pro_upazilas.upazilas_id")
            ->select("pro_unions.*", "pro_upazilas.upazilas_name", "pro_upazilas.upazilas_bn_name")
            ->get();
        $pro_divisions = DB::table('pro_divisions')->get();
        return view('deed.union_info', compact('pro_union_infos', 'pro_divisions'));
    }

    public function DeedUnionInfoStore(Request $request)
    {

        $rules = [
            'cbo_division_id' => 'required|integer|between:1,10',
            'cbo_district_id' => 'required|integer|between:1,70',
            'cbo_upazila_id' => 'required|integer|between:1,700',
            'txt_unions_name' => 'required',
            'txt_unions_bn_name' => 'required',
        ];

        $customMessages = [
            'cbo_division_id.required' => 'Select Division.',
            'cbo_division_id.integer' => 'Select Division.',
            'cbo_division_id.between' => 'Select Division.',
            'cbo_district_id.required' => 'Select District.',
            'cbo_district_id.integer' => 'Select District.',
            'cbo_district_id.between' => 'Select District.',
            'cbo_upazila_id.required' => 'Select Upazila.',
            'cbo_upazila_id.integer' => 'Select Upazila.',
            'cbo_upazila_id.between' => 'Select Upazila.',
            'txt_unions_name.required' => 'Union Name English.',
            'txt_unions_bn_name.required' => 'Union Name Bangla.',
        ];
        $this->validate($request, $rules, $customMessages);

        $union = DB::table('pro_unions')->where('unions_name', $request->txt_unions_name)->where('upazilas_id', $request->cbo_upazila_id)->first();
        //dd($abcd);

        if ($union === null) {
            $m_valid = '1';


            $data = array();
            $data['upazilas_id'] = $request->cbo_upazila_id;
            $data['unions_name'] = $request->txt_unions_name;
            $data['unions_bn_name'] = $request->txt_unions_bn_name;
            $data['valid'] = $m_valid;
            DB::table("pro_unions")->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $union_check = array('message' => 'Data duplicate', 'alert-type' => 'success');
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        } //if ($union === null)

    }



    //End Union Info


    //Deeed Master info
    public function DeedMasterInfo()
    {
        $pro_deed_masters = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->get();

        $pro_deed_types = DB::table('pro_deed_type')->get();
        $pro_divisions = DB::table('pro_divisions')->get();
        $pro_moujas = DB::table('pro_moujas')->get();
        $pro_land_types = DB::table('pro_land_type')->get();
        $pro_land_units = DB::table('pro_land_unit')->get();
        return view('deed.deed_master_info', compact('pro_divisions', 'pro_deed_types', 'pro_moujas', 'pro_land_types', 'pro_land_units', 'pro_deed_masters'));
    }

    public function DeedMasterInfoEnglish($id)
    {
        $pro_deed_master = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->where('deed_master_id', $id)
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->first();

        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang", 'pro_land_owner_info.owner_name_eng')
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->get();
        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id', $id)->first();
        $pro_namjari = DB::table("pro_namjari")->where('deed_master_id', $id)->get();

        return view('deed.deed_master_info_english', compact('pro_deed_master', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'));
    }
    public function DeedMasterInfoBangla($id)
    {
        $pro_deed_master = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->where('deed_master_id', $id)
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->first();

        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang", 'pro_land_owner_info.owner_name_eng')
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->get();
        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id', $id)->first();
        $pro_namjari = DB::table("pro_namjari")->where('deed_master_id', $id)->get();

        return view('deed.deed_master_info_bangla', compact('pro_deed_master', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'));
    }
    public function DeedMasterInfoEnPrint($id)
    {
        $pro_deed_master = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->where('deed_master_id', $id)
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->first();

        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang", 'pro_land_owner_info.owner_name_eng')
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->get();
        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id', $id)->first();
        $pro_namjari = DB::table("pro_namjari")->where('deed_master_id', $id)->get();

        // $pdf = PDF::loadView('deed.test2',compact('pro_deed_master', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'))->setPaper('a4', 'portrait');
        // return $pdf->download('Deed_info.pdf');
        return view('deed.deed_master_info_en_print', compact('pro_deed_master', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'));
    }
    public function DeedMasterInfoBnPrint($id)
    {
        $pro_deed_master = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->where('deed_master_id', $id)
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->first();

        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang", 'pro_land_owner_info.owner_name_eng')
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->get();
        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id', $id)->first();
        $pro_namjari = DB::table("pro_namjari")->where('deed_master_id', $id)->get();

        // $pdf = PDF::loadView('deed.test',compact('pro_deed_master', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'))->setPaper('a4', 'portrait');
        // return $pdf->download('Deed_info.pdf');
        return view('deed.deed_master_info_bn_print', compact('pro_deed_master', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'));
    }

    //deed master edit part
    public function DeedMasterInfoEdit($id)
    {
        $pro_deed_master = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->where('deed_master_id', $id)
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_id",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.districts_id",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_id",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_id",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_id",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_id",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->first();
        $pro_deed_types = DB::table('pro_deed_type')->get();
        $pro_divisions = DB::table('pro_divisions')->get();
        $pro_moujas = DB::table('pro_moujas')->get();
        $pro_land_types = DB::table('pro_land_type')->get();
        $pro_land_units = DB::table('pro_land_unit')->get();
        return view('deed.deed_master_info_edit', compact('pro_divisions', 'pro_deed_types', 'pro_moujas', 'pro_land_types', 'pro_land_units', 'pro_deed_master'));
    }

    public function DeedMasterInfoUpdate(Request $request)
    {
        $data = array();
        $data['user_id'] = Auth::id();
        $data['deed_sl'] = $request->txt_deed_sl;
        $data['book_no'] = $request->txt_book_no;
        $data['deed_no'] = $request->txt_deed_no;
        $data['deed_date'] = $request->txt_deed_date;
        $data['sub_registry_bang'] = $request->txt_sub_registry_bang;
        $data['sub_registry_eng'] = $request->txt_sub_registry_eng;
        $data['deed_type_id'] = $request->cbo_deed_type_id;
        $data['divisions_id'] = $request->cbo_division_id;
        $data['districts_id'] = $request->cbo_district_id;
        $data['upazilas_id'] = $request->cbo_upazila_id;
        $data['unions_id'] = $request->cbo_union_id;
        $data['moujas_id'] = $request->cbo_mouja_id;
        $data['land_area'] = $request->txt_land_area;
        $data['land_unit_id'] = $request->cbo_land_unit_id;
        $data['land_type_id'] = $request->cbo_land_type_id;
        $data['land_price'] = $request->txt_land_price;
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        DB::table("pro_deed_master")->where('deed_master_id', $request->txt_deed_master_id)->update($data);
        return redirect()->route('DeedLandOwnerEdit', $request->txt_deed_master_id); 
    }

    public function DeedLandOwnerEdit($id)
    {
        $union_check = DB::table('pro_deed_master')->where('deed_master_id', $id)->first();
        if ($union_check->unions_id) {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    "pro_unions.unions_name",
                    "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        } else {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    // "pro_unions.unions_name",
                    // "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        }

        $pro_land_owner_info = DB::table('pro_land_owner_info')->get();
        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang")
            ->get();
        if ($pro_land_owner === null) {
            return view('deed.land_owner_edit', compact('pro_deed_masters', 'pro_land_owner_info'));
        } else {
            return view('deed.land_owner_edit', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_owner_info'));
        }
    }
    //End deed master edit part

    public function DeedMasterInfoStore(Request $request)
    {
        $deed_check = DB::table("pro_deed_master")
        ->where('deed_no', $request->txt_deed_no)
        ->where('moujas_id', $request->cbo_mouja_id)
        ->first();
        // return $request;
        if($deed_check === null){
            $rules = [
                'txt_deed_sl' => 'required',
                'txt_book_no' => 'required',
                'txt_deed_no' => 'required',
                'txt_deed_date' => 'required',
                'txt_sub_registry_bang' => 'required',
                'txt_sub_registry_eng' => 'required',
                'cbo_deed_type_id' => 'required|integer|between:1,100',
                'cbo_division_id' => 'required|integer|between:1,100',
                'cbo_district_id' => 'required|integer|between:1,100',
                'cbo_upazila_id' => 'required|integer|between:1,10000',
                // 'cbo_union_id' => 'required',
                'cbo_mouja_id' => 'required|integer|between:1,10000',
                'txt_land_area' => 'required',
                'cbo_land_unit_id' => 'required|integer|between:1,100',
                'cbo_land_type_id' => 'required|integer|between:1,100',
                'txt_land_price' => 'required'
            ];

            $customMessages = [
                'txt_deed_sl.required' => 'Deed SI field is required!',
                'txt_book_no.required' => 'Book No field is required!',
                'txt_deed_no.required' => 'Deed No field is required!',
                'txt_deed_date.required' => 'Deed Date field is required!',
                'txt_sub_registry_bang.required' => 'Sub-registry field is required!',
                'txt_sub_registry_eng.required' => 'Sub-registry field is required!',
                'cbo_deed_type_id.required' => 'Deed Type field is required!',
                'cbo_deed_type_id.integer' => 'Deed Type field is required!',
                'cbo_deed_type_id.between' => 'Deed Type field is required!',
                'cbo_division_id.required' => 'Division field is required!',
                'cbo_division_id.integer' => 'Division field is required!',
                'cbo_division_id.between' => 'Division field is required!',
                'cbo_district_id.required' => 'District field is required!',
                'cbo_district_id.integer' => 'District field is required!',
                'cbo_district_id.between' => 'District field is required!',
                'cbo_upazila_id.required' => 'Upazila field is required!',
                'cbo_upazila_id.integer' => 'Upazila field is required!',
                'cbo_upazila_id.between' => 'Upazila field is required!',
                'cbo_mouja_id.required' => 'Mouja field is required!',
                'cbo_mouja_id.integer' => 'Mouja field is required!',
                'cbo_mouja_id.between' => 'Mouja field is required!',
                'txt_land_area.required' => 'Land Area field is required!',
                'cbo_land_unit_id.required' => 'Land Unit field is required!',
                'cbo_land_unit_id.integer' => 'Land Unit field is required!',
                'cbo_land_unit_id.between' => 'Land Unit field is required!',
                'cbo_land_type_id.required' => 'Land Type field is required!',
                'cbo_land_type_id.integer' => 'Land Type field is required!',
                'cbo_land_type_id.between' => 'Land Type field is required!',
                'txt_land_price.required' => 'Land Price field is required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['user_id'] = Auth::id();
            $data['deed_sl'] = $request->txt_deed_sl;
            $data['book_no'] = $request->txt_book_no;
            $data['deed_no'] = $request->txt_deed_no;
            $data['deed_date'] = $request->txt_deed_date;
            $data['sub_registry_bang'] = $request->txt_sub_registry_bang;
            $data['sub_registry_eng'] = $request->txt_sub_registry_eng;
            $data['deed_type_id'] = $request->cbo_deed_type_id;
            $data['divisions_id'] = $request->cbo_division_id;
            $data['districts_id'] = $request->cbo_district_id;
            $data['upazilas_id'] = $request->cbo_upazila_id;
            $data['unions_id'] = $request->cbo_union_id;
            $data['moujas_id'] = $request->cbo_mouja_id;
            $data['land_area'] = $request->txt_land_area;
            $data['land_unit_id'] = $request->cbo_land_unit_id;
            $data['land_type_id'] = $request->cbo_land_type_id;
            $data['land_price'] = $request->txt_land_price;
            $data['valid'] = 1;
            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $id = DB::table("pro_deed_master")->insertGetId($data);
            return redirect()->route('DeedLandOwner', $id);
        }else{
          return back()->with('warning', 'Data already exists!!');
        }
    }
    //End Deed Master info

    //land Owner

    public function DeedLandOwner($id)
    {

        $union_check = DB::table('pro_deed_master')->where('deed_master_id', $id)->first();
        if ($union_check->unions_id) {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    "pro_unions.unions_name",
                    "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        } else {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    // "pro_unions.unions_name",
                    // "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        }

        $pro_land_owner_info = DB::table('pro_land_owner_info')->get();

        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang")
            ->get();

        if ($pro_land_owner === null) {
            return view('deed.land_owner', compact('pro_deed_masters', 'pro_land_owner_info'));
        } else {
            return view('deed.land_owner', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_owner_info'));
        }
    }

    public function DeedLandOwnerStore(Request $request)
    {
        $rules = [
            'cbo_land_owner_info_id' => 'required',
        ];
        $customMessages = [
            'cbo_land_owner_info_id.required' => 'land Owner info field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_info_id'] = Auth::id();
        $data['land_owner_info_id'] = $request->cbo_land_owner_info_id;
        $data['deed_master_id'] = $request->deed_master_id;
        $data['valid'] = 1;
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        DB::table("pro_land_owner")->insertGetId($data);
        return redirect()->route('DeedLandOwner', $request->deed_master_id);
    }

    //land Seller
    public function DeedLandSellerInfo($id)
    {
        $union_check = DB::table('pro_deed_master')->where('deed_master_id', $id)->first();
        if ($union_check->unions_id) {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    "pro_unions.unions_name",
                    "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        } else {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    // "pro_unions.unions_name",
                    // "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        }
        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang")
            ->get();

        $pro_land_seller = DB::table("pro_land_seller")
            ->where('deed_master_id', $id)
            ->get();

        if ($pro_land_seller === null) {
            return view('deed.land_seller_info', compact('pro_deed_masters', 'pro_land_owner'));
        } else {
            return view('deed.land_seller_info', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller'));
        }
    }

    public function DeedLandSellerInfoStore(Request $request)
    {
        $rules = [
            'txt_owner_name_bang' => 'required',
            'txt_owner_father_name_bang' => 'required',
            'txt_owner_mother_name_bang' => 'required',
            'txt_owner_dob' => 'required',
            'txt_owner_name_eng' => 'required',
            'txt_owner_father_name_eng' => 'required',
            'txt_owner_mother_name_eng' => 'required',
            'txt_owner_religious_bang' => 'required',
            'txt_owner_profession_bang' => 'required',
            'txt_owner_nationality_bang' => 'required',
            'txt_owner_nid_bang' => 'required',
            'txt_owner_religious_eng' => 'required',
            'txt_owner_profession_eng' => 'required',
            'txt_owner_nationality_eng' => 'required',
            'txt_owner_nid_eng' => 'required',
            'txt_owner_parmanent_add_bang' => 'required',
            'txt_owner_parmanent_add_eng' => 'required',
            'txt_owner_present_add_bang' => 'required',
            'txt_owner_present_add_eng' => 'required',
        ];

        $customMessages = [
            'txt_owner_name_bang.required' => 'Name field is required!',
            'txt_owner_name_eng.required' => 'Name field is required!',
            'txt_owner_father_name_bang.required' => 'Father name field is required!',
            'txt_owner_father_name_eng.required' => 'Father name field is required!',
            'txt_owner_mother_name_bang.required' => 'Mother name field is required!',
            'txt_owner_mother_name_eng.required' => 'Mother name field is required!',
            'txt_owner_dob.required' => 'Date of birth field is required!',
            'txt_owner_religious_bang.required' => 'Religious field is required!',
            'txt_owner_religious_eng.required' => 'Religious field is required!',
            'txt_owner_profession_bang.required' => 'Profession field is required!',
            'txt_owner_profession_eng.required' => 'Profession field is required!',
            'txt_owner_nationality_bang.required' => 'Nationality field is required!',
            'txt_owner_nationality_eng.required' => 'Nationality field is required!',
            'txt_owner_nid_bang.required' => 'NID field is required!',
            'txt_owner_nid_eng.required' => 'NID field is required!',
            'txt_owner_parmanent_add_bang.required' => 'Permanent Address field is required!',
            'txt_owner_parmanent_add_eng.required' => 'Permanent Address field is required!',
            'txt_owner_present_add_bang.required' => 'Pressent Address field is required!',
            'txt_owner_present_add_eng.required' => 'Pressent Address field is required!',
        ];
        $this->validate($request, $rules, $customMessages);


        $data = array();
        $data['user_info_id'] = Auth::id();
        $data['deed_master_id'] = $request->deed_master_id;
        $data['seller_name_eng'] = $request->txt_owner_name_eng;
        $data['seller_name_bang'] = $request->txt_owner_name_bang;
        $data['seller_father_name_eng'] = $request->txt_owner_father_name_eng;
        $data['seller_father_name_bang'] = $request->txt_owner_father_name_bang;
        $data['seller_mother_name_eng'] = $request->txt_owner_mother_name_eng;
        $data['seller_mother_name_bang'] = $request->txt_owner_mother_name_bang;
        $data['seller_dob'] = $request->txt_owner_dob;
        $data['seller_religous_eng'] = $request->txt_owner_religious_eng;
        $data['seller_religous_bang'] = $request->txt_owner_religious_bang;
        $data['seller_profession_eng'] = $request->txt_owner_profession_eng;
        $data['seller_profession_bang'] = $request->txt_owner_profession_bang;
        $data['seller_nationality_eng'] = $request->txt_owner_nationality_eng;
        $data['seller_nationality_bang'] = $request->txt_owner_nationality_bang;
        $data['seller_nid_eng'] = $request->txt_owner_nid_eng;
        $data['seller_nid_bang'] = $request->txt_owner_nid_bang;
        $data['seller_permanent_add_eng'] = $request->txt_owner_parmanent_add_eng;
        $data['seller_permanent_add_bang'] = $request->txt_owner_parmanent_add_bang;
        $data['seller_present_add_eng'] = $request->txt_owner_present_add_eng;
        $data['seller_present_add_bang'] = $request->txt_owner_present_add_bang;
        $data['valid'] = 1;
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        DB::table("pro_land_seller")->insert($data);
        return redirect()->route('DeedLandSellerInfo', $request->deed_master_id);
    }

    //land seller Next step
    public function DeedLandSellerInfoNext($id)
    {
        $union_check = DB::table('pro_deed_master')->where('deed_master_id', $id)->first();
        if ($union_check->unions_id) {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    "pro_unions.unions_name",
                    "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        } else {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    // "pro_unions.unions_name",
                    // "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        }
        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang")
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->where('deed_master_id', $id)
            ->where('harahari_status', '!=', '2')
            ->get();
        $pro_land_unit = DB::table('pro_land_unit')->get();

        $pro_land_seller2 = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->where('land_area', '!=', '')
            ->get();

        if ($pro_land_seller === null) {
            return view('deed.land_seller_info2', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller', 'pro_land_unit'));
        } else {
            return view('deed.land_seller_info2', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller', 'pro_land_unit', 'pro_land_seller2'));
        }
    }

    public function DeedLandSellerInfoUpdate(Request $request)
    {
        $rules = [
            'cbo_land_owner_info_id' => 'required',
            'txt_land_area' => 'required',
            'cbo_land_unit_id' => 'required',
        ];
        $customMessages = [
            'cbo_land_owner_info_id.required' => 'land owner info field is required!',
            'txt_land_area.required' => 'land area field is required!',
            'cbo_land_unit_id.required' => 'land unit field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['land_area'] = $request->txt_land_area;
        $data['land_unit'] = $request->cbo_land_unit_id;
        $data['harahari_status'] = 2;
        DB::table("pro_land_seller")->where('land_seller_id', $request->cbo_land_owner_info_id)->update($data);
        return redirect()->route('DeedLandSellerInfoNext', $request->deed_master_id);
    }

    //Tapsil
    public function DeedTapsilInfo($id)
    {
        $union_check = DB::table('pro_deed_master')->where('deed_master_id', $id)->first();
        if ($union_check->unions_id) {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    "pro_unions.unions_name",
                    "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        } else {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    // "pro_unions.unions_name",
                    // "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        }
        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang")
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->get();

        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id', $id)->first();
        if ($pro_tapsil === null) {
            return view('deed.tapsil_info', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller'));
        } else {
            return view('deed.tapsil_info', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil'));
        }
    }

    public function DeedTapsilInfoStore(Request $request)
    {
        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id',$request->deed_master_id)->first();
        if ($pro_tapsil === null) {
            $rules = [
                'txt_jl_cs' => 'required',
                'txt_jl_sa' => 'required',
                'txt_jl_rs' => 'required',
                'txt_khatian_cs' => 'required',
                'txt_khatian_sa' => 'required',
                'txt_khatian_rs' => 'required',
                'txt_dag_bang' => 'required',
                'txt_dag_eng' => 'required',
            ];

            $customMessages = [
                'txt_jl_cs.required' => 'JL CS field is required!',
                'txt_jl_sa.required' => 'JL SA field is required!',
                'txt_jl_rs.required' => 'Jl RS field is required!',
                'txt_khatian_cs.required' => 'Khatian CS field is required!',
                'txt_khatian_sa.required' => 'Khatian SA field is required!',
                'txt_khatian_rs.required' => 'Khatian RS field is required!',
                'txt_dag_bang.required' => 'Dag field is required!',
                'txt_dag_eng.required' => 'Dag field is required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['user_info_id'] = Auth::id();
            $data['deed_master_id'] = $request->deed_master_id;
            $data['jl_cs'] = $request->txt_jl_cs;
            $data['jl_sa'] = $request->txt_jl_sa;
            $data['jl_rs'] = $request->txt_jl_rs;
            $data['khatian_cs'] = $request->txt_khatian_cs;
            $data['khatian_sa'] = $request->txt_khatian_sa;
            $data['khatian_rs'] = $request->txt_khatian_rs;
            $data['dag_bang'] = $request->txt_dag_bang;
            $data['dag_eng'] = $request->txt_dag_eng;
            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table("pro_tapsil")->insert($data);
            return redirect()->route('DeedNamjari', $request->deed_master_id);
        }
        else{
            $rules = [
                'txt_jl_cs' => 'required',
                'txt_jl_sa' => 'required',
                'txt_jl_rs' => 'required',
                'txt_khatian_cs' => 'required',
                'txt_khatian_sa' => 'required',
                'txt_khatian_rs' => 'required',
                'txt_dag_bang' => 'required',
                'txt_dag_eng' => 'required',
            ];

            $customMessages = [
                'txt_jl_cs.required' => 'JL CS field is required!',
                'txt_jl_sa.required' => 'JL SA field is required!',
                'txt_jl_rs.required' => 'Jl RS field is required!',
                'txt_khatian_cs.required' => 'Khatian CS field is required!',
                'txt_khatian_sa.required' => 'Khatian SA field is required!',
                'txt_khatian_rs.required' => 'Khatian RS field is required!',
                'txt_dag_bang.required' => 'Dag field is required!',
                'txt_dag_eng.required' => 'Dag field is required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['user_info_id'] = Auth::id();
            $data['deed_master_id'] = $request->deed_master_id;
            $data['jl_cs'] = $request->txt_jl_cs;
            $data['jl_sa'] = $request->txt_jl_sa;
            $data['jl_rs'] = $request->txt_jl_rs;
            $data['khatian_cs'] = $request->txt_khatian_cs;
            $data['khatian_sa'] = $request->txt_khatian_sa;
            $data['khatian_rs'] = $request->txt_khatian_rs;
            $data['dag_bang'] = $request->txt_dag_bang;
            $data['dag_eng'] = $request->txt_dag_eng;
            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            DB::table("pro_tapsil")->where('deed_master_id',$request->deed_master_id)->update($data);
            return redirect()->route('DeedNamjari', $request->deed_master_id);
        
        }
    }

    //Namejari 
    public function DeedNamjari($id)
    {
        $union_check = DB::table('pro_deed_master')->where('deed_master_id', $id)->first();
        if ($union_check->unions_id) {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    "pro_unions.unions_name",
                    "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        } else {
            $pro_deed_masters = DB::table('pro_deed_master')
                ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
                ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
                ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
                ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
                ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
                // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
                ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
                ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
                ->where('deed_master_id', $id)
                ->select(
                    "pro_deed_master.*",
                    "pro_divisions.divisions_name",
                    "pro_divisions.divisions_bn_name",
                    "pro_districts.district_name",
                    "pro_districts.district_bn_name",
                    "pro_upazilas.upazilas_name",
                    "pro_upazilas.upazilas_bn_name",
                    "pro_moujas.moujas_name",
                    "pro_moujas.moujas_bn_name",
                    "pro_deed_type.deed_type_name",
                    "pro_deed_type.deed_type_bn_name",
                    // "pro_unions.unions_name",
                    // "pro_unions.unions_bn_name",
                    "pro_land_unit.land_unit_bn_nane",
                    "pro_land_type.land_type_bn_name",
                )
                ->first();
        }
        $pro_land_owner = DB::table('pro_land_owner')
            ->join("pro_land_owner_info", "pro_land_owner.land_owner_info_id", "pro_land_owner_info.land_owner_info_id")
            ->where('deed_master_id', $id)
            ->select("pro_land_owner.*", "pro_land_owner_info.owner_name_bang")
            ->get();
        $pro_land_seller = DB::table("pro_land_seller")
            ->join("pro_land_unit", "pro_land_seller.land_unit", "pro_land_unit.land_unit_id")
            ->select("pro_land_seller.*", "pro_land_unit.land_unit_bn_nane", "pro_land_unit.land_unit_nane")
            ->where('deed_master_id', $id)
            ->get();
        $pro_tapsil = DB::table("pro_tapsil")->where('deed_master_id', $id)->first();
        $pro_namjari = DB::table("pro_namjari")->where('deed_master_id', $id)->get();

        if ($pro_namjari === null) {
            return view('deed.namjari_info', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil'));
        } else {
            return view('deed.namjari_info', compact('pro_deed_masters', 'pro_land_owner', 'pro_land_seller', 'pro_tapsil', 'pro_namjari'));
        }
    }

    public function DeedNamjariStore(Request $request)
    {
        $rules = [
            'txt_namjari_no' => 'required',
            'txt_namjari_details_bang' => 'required',
            'txt_namjari_details_eng' => 'required',
        ];
        $customMessages = [
            'txt_namjari_no.required' => 'Namjari No field is required!',
            'txt_namjari_details_bang.required' => 'Namjari field is required!',
            'txt_namjari_details_eng.required' => 'Namjari field is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_info_id'] = Auth::id();
        $data['deed_master_id'] = $request->deed_master_id;
        $data['namjari_no'] = $request->txt_namjari_no;
        $data['namjari_details_bang'] = $request->txt_namjari_details_bang;
        $data['namjari_details_eng'] = $request->txt_namjari_details_eng;
        //Bangladesh Date and Time Zone
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        DB::table("pro_namjari")->insert($data);
        return redirect()->route('DeedNamjari', $request->deed_master_id);
    }
    //End Deed Master info

    // Doc File
    public function DeedDocUploadList()
    {
        $pro_deed_masters = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            // ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            // ->where('report_status','!=','1')
            ->where('upload_status', '!=', '1')
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                // "pro_unions.unions_name",
                // "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_bn_name",
            )
            ->get();


        return view('deed.doc_upload', compact('pro_deed_masters'));
    }

    public function DeedDocFile($id)
    {
        $pro_deed_masters = DB::table('pro_deed_master')
            ->where('deed_master_id', '=', $id)
            ->first();
        $pro_doc_infos = DB::table('pro_doc_info')->get();
        return view('deed.doc_file', compact('pro_deed_masters', 'pro_doc_infos'));
    }

    public function DeedDocFileStore(Request $request)
    {

        $m_doc_file = DB::table('pro_doc_file')
            ->where('deed_no', $request->txt_deed_no)
            ->where('doc_info_id', $request->cbo_doc_id)
            ->where('moujas_id', $request->txt_moujas_id)
            ->first();

        if ($m_doc_file)
        {
            // $data = DB::table('pro_doc_info')->where('doc_info_id', '=', $request->cbo_doc_id)->first();
            // return redirect()->back()->with('warning', "$data->doc_info_name already exist !!");
            $rules = [
                'cbo_doc_id' => 'required',
                'txt_doc_file' => 'required',
            ];

            $customMessages = [
                'txt_doc_file.required' => 'please, File Required!',
            ];
            $this->validate($request, $rules, $customMessages);



            $data = array();
            $data['deed_no'] = $request->txt_deed_no;
            $data['doc_info_id'] = $request->cbo_doc_id;
            $data['moujas_id'] = $request->txt_moujas_id;
            $txt_doc_file = $request->file('txt_doc_file');
            if ($request->hasFile('txt_doc_file')) {
                $filename = $request->txt_deed_no . $request->cbo_doc_id . $request->txt_moujas_id. '.' . $request->file('txt_doc_file')->getClientOriginalExtension();
                $doc_type = DB::table('pro_doc_info')->where('doc_info_id', $request->cbo_doc_id)->first();
                $second_path = strtolower(str_replace(' ', '_', "$doc_type->doc_info_name"));
                $upload_path = "../docupload/sqgroup/imagedeed/$second_path/";
                // $image_url = $upload_path . $filename;
                $image_url = "$second_path/" . $filename;
                $txt_doc_file->move($upload_path, $filename);
                $data['file_name'] = $image_url;
            }

            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['created_at'] = date("Y-m-d h:i:sa");
            $inserted = DB::table("pro_doc_file")->where('doc_file_id',$m_doc_file->doc_file_id)->update($data);
            //
            if ($inserted) {
                $doc_file = DB::table('pro_doc_file')->where('deed_no', '=', $request->txt_deed_no)
                    ->select("pro_doc_file.doc_info_id")
                    ->pluck('doc_info_id');

                $doc_info = DB::table('pro_doc_info')
                    ->select("pro_doc_info.doc_info_id")
                    ->pluck('doc_info_id');

                if ($doc_file ==  $doc_info) {
                    DB::table('pro_deed_master')->where('deed_no', '=', $request->txt_deed_no)->insert(['upload_status' => 1]);
                }
            }
            return redirect()->back()->with('success', "Upload File Successfully!");





        } elseif (!$m_doc_file) {
            $rules = [
                'cbo_doc_id' => 'required',
                'txt_doc_file' => 'required',
            ];

            $customMessages = [
                'txt_doc_file.required' => 'please, File Required!',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = array();
            $data['deed_no'] = $request->txt_deed_no;
            $data['doc_info_id'] = $request->cbo_doc_id;
            $data['moujas_id'] = $request->txt_moujas_id;
            $txt_doc_file = $request->file('txt_doc_file');
            if ($request->hasFile('txt_doc_file')) {
                $filename = $request->txt_deed_no . $request->cbo_doc_id . $request->txt_moujas_id. '.' . $request->file('txt_doc_file')->getClientOriginalExtension();
                $doc_type = DB::table('pro_doc_info')->where('doc_info_id', $request->cbo_doc_id)->first();
                $second_path = strtolower(str_replace(' ', '_', "$doc_type->doc_info_name"));
                $upload_path = "../docupload/sqgroup/imagedeed/$second_path/";
                // $image_url = $upload_path . $filename;
                $image_url = "$second_path/" . $filename;
                $txt_doc_file->move($upload_path, $filename);
                $data['file_name'] = $image_url;
            }

            //Bangladesh Date and Time Zone
            date_default_timezone_set("Asia/Dhaka");
            $data['created_at'] = date("Y-m-d h:i:sa");
            $inserted = DB::table("pro_doc_file")->insert($data);
            //
            if ($inserted) {
                $doc_file = DB::table('pro_doc_file')->where('deed_no', '=', $request->txt_deed_no)
                    ->select("pro_doc_file.doc_info_id")
                    ->pluck('doc_info_id');

                $doc_info = DB::table('pro_doc_info')
                    ->select("pro_doc_info.doc_info_id")
                    ->pluck('doc_info_id');

                if ($doc_file ==  $doc_info) {
                    DB::table('pro_deed_master')->where('deed_no', '=', $request->txt_deed_no)->insert(['upload_status' => 1]);
                }
            }
            return redirect()->back()->with('success', "Upload File Successfully!");
        }
    }

    // End Doc File

    //Doc info
    public function DeedDocInfo()
    {
        $pro_doc_info = DB::table("pro_doc_info")->get();
        return view('deed.doc_info', compact('pro_doc_info'));
    }

    public function DeedDocInfoStore(Request $request)
    {
        $rules = [
            'txt_doc_info' => 'required',
        ];

        $customMessages = [
            'txt_doc_info.required' => 'Doc info File Required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $data = array();
        $data['user_info_id'] = Auth::id();
        $data['doc_info_name'] = $request->txt_doc_info;
        $data['valid'] = '1';
        date_default_timezone_set("Asia/Dhaka");
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $check = DB::table('pro_doc_info')->insert($data);
        if ($check) {
            DB::table('pro_deed_master')->update(['upload_status' => 0]);
        }
        return redirect()->back()->with('success', "Doc Info Added Successfully!");
    }

    public function DeedDocInfoEdit($id)
    {

        $m_doc_type = DB::table('pro_doc_info')->where('doc_info_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_doc_info')->Where('valid', '1')->orderBy('doc_info_id', 'desc')->get();
        return view('deed.doc_info', compact('data', 'm_doc_type'));
    }

    public function DeedDocInfoUpdate(Request $request, $id)
    {

        DB::table('pro_doc_info')->where('doc_info_id', $id)->update([

            'doc_info_name' => $request->txt_doc_info,
        ]);
        return redirect(route('doc_info'))->with('success', 'Data Updated Successfully!');
    }

    //End Doc info

    public function DeedRptList()
    {

        $rpt_deed_master = DB::table('pro_deed_master')
            ->join("pro_divisions", "pro_deed_master.divisions_id", "pro_divisions.divisions_id")
            ->join("pro_districts", "pro_deed_master.districts_id", "pro_districts.districts_id")
            ->join("pro_upazilas", "pro_deed_master.upazilas_id", "pro_upazilas.upazilas_id")
            ->join("pro_moujas", "pro_deed_master.moujas_id", "pro_moujas.moujas_id")
            ->join("pro_deed_type", "pro_deed_master.deed_type_id", "pro_deed_type.deed_type_id")
            ->join("pro_unions", "pro_deed_master.unions_id", "pro_unions.unions_id")
            ->join("pro_land_unit", "pro_deed_master.land_unit_id", "pro_land_unit.land_unit_id")
            ->join("pro_land_type", "pro_deed_master.land_type_id", "pro_land_type.land_type_id")
            ->select(
                "pro_deed_master.*",
                "pro_divisions.divisions_name",
                "pro_divisions.divisions_bn_name",
                "pro_districts.district_name",
                "pro_districts.district_bn_name",
                "pro_upazilas.upazilas_name",
                "pro_upazilas.upazilas_bn_name",
                "pro_moujas.moujas_name",
                "pro_moujas.moujas_bn_name",
                "pro_deed_type.deed_type_name",
                "pro_deed_type.deed_type_bn_name",
                "pro_unions.unions_name",
                "pro_unions.unions_bn_name",
                "pro_land_unit.land_unit_nane",
                "pro_land_unit.land_unit_bn_nane",
                "pro_land_type.land_type_name",
                "pro_land_type.land_type_bn_name",
            )
            ->get();

        return view('deed.rpt_deed_list', compact('rpt_deed_master'));

        // $rpt_deed_master = DB::table("pro_deed_master")->get();
        // return view('deed.rpt_deed_list', compact('rpt_deed_master'));
    }


    //Ajax call get- District,Upzila,Union,Mouja
    public function GetDistrict($id)
    {
        $data = DB::table('pro_districts')->where('divisions_id', $id)->get();
        return json_encode($data);
    }
    public function GetUpazila($id)
    {
        $data = DB::table('pro_upazilas')->where('districts_id', $id)->get();
        return json_encode($data);
    }
    public function GetUnion($id)
    {
        $data = DB::table('pro_unions')->where('upazilas_id', $id)->get();
        return json_encode($data);
    }
    public function GetMouja($id)
    {
        $data = DB::table('pro_moujas')->where('upazilas_id', $id)->get();
        return json_encode($data);
    }
    //end Ajax call get- District,Upzila,Union,Mouja



}
