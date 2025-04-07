@extends('layouts.deed_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Land Owner Information <br> দলিল গ্রহীতার তথ্য</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($pro_land_owner_info_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5 class="mb-4">{{ 'Edit' }}</h5>
                            </div>
                            <form action="{{ route('DeedLandOwnerInfoUpdate',$pro_land_owner_info_edit->land_owner_info_id) }}" method="Post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="txt_emp_id" name="txt_emp_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">                                        
                                        <input type="text" class="form-control" id="txt_owner_name_bang"
                                            name="txt_owner_name_bang" placeholder="নাম"
                                            value="{{ $pro_land_owner_info_edit->owner_name_bang }}">
                                        @error('txt_owner_name_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_father_name_bang"
                                            name="txt_owner_father_name_bang" placeholder="পিতার নাম"
                                            value="{{ $pro_land_owner_info_edit->owner_father_name_bang }}">
                                        @error('txt_owner_father_name_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_mother_name_bang"
                                            name="txt_owner_mother_name_bang" placeholder="মাতার নাম"
                                            value="{{ $pro_land_owner_info_edit->owner_mother_name_bang }}">
                                        @error('txt_owner_mother_name_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_dob" name="txt_owner_dob"
                                            placeholder="জন্ম তারিখ/DOB" value="{{ $pro_land_owner_info_edit->owner_dob }}"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_owner_dob')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_name_eng"
                                            name="txt_owner_name_eng" placeholder="Name"
                                            value="{{ $pro_land_owner_info_edit->owner_name_eng }}">
                                        @error('txt_owner_name_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_father_name_eng"
                                            name="txt_owner_father_name_eng" placeholder="Father's Name"
                                            value="{{ $pro_land_owner_info_edit->owner_father_name_eng }}">
                                        @error('txt_owner_father_name_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_mother_name_eng"
                                            name="txt_owner_mother_name_eng" placeholder="Mother's Name"
                                            value="{{ $pro_land_owner_info_edit->owner_mother_name_eng }}">
                                        @error('txt_owner_mother_name_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_religious_bang"
                                            name="txt_owner_religious_bang" placeholder="ধর্ম"
                                            value="{{ $pro_land_owner_info_edit->owner_religous_bang }}">
                                        @error('txt_owner_religious_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_profession_bang"
                                            name="txt_owner_profession_bang" placeholder="পেশা"
                                            value="{{ $pro_land_owner_info_edit->owner_profession_bang }}">
                                        @error('txt_owner_profession_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nationality_bang"
                                            name="txt_owner_nationality_bang" placeholder="জাতীয়তা"
                                            value="{{ $pro_land_owner_info_edit->owner_nationality_bang }}">
                                        @error('txt_owner_nationality_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nid_bang"
                                            name="txt_owner_nid_bang" placeholder="জাতীয় পরিচিতি নং"
                                            value="{{ $pro_land_owner_info_edit->owner_nid_bang }}">
                                        @error('txt_owner_nid_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_religious_eng"
                                            name="txt_owner_religious_eng" placeholder="Religious"
                                            value="{{ $pro_land_owner_info_edit->owner_religous_eng }}">
                                        @error('txt_owner_religious_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_profession_eng"
                                            name="txt_owner_profession_eng" placeholder="Profession"
                                            value="{{ $pro_land_owner_info_edit->owner_profession_eng }}">
                                        @error('txt_owner_profession_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nationality_eng"
                                            name="txt_owner_nationality_eng" placeholder="Nationality"
                                            value="{{ $pro_land_owner_info_edit->owner_nationality_eng }}">
                                        @error('txt_owner_nationality_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nid_eng"
                                            name="txt_owner_nid_eng" placeholder="NID No."
                                            value="{{ $pro_land_owner_info_edit->owner_nid_eng }}">
                                        @error('txt_owner_nid_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_parmanent_add_bang"
                                            name="txt_owner_parmanent_add_bang" placeholder="স্থায়ী ঠিকানা"
                                            value="{{ $pro_land_owner_info_edit->owner_permanent_add_bang }}">
                                        @error('txt_owner_parmanent_add_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_parmanent_add_eng"
                                            name="txt_owner_parmanent_add_eng" placeholder="Parmanent Address"
                                            value="{{ $pro_land_owner_info_edit->owner_permanent_add_eng }}">
                                        @error('txt_owner_parmanent_add_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">

                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-primary" id='same' style="width: 100%;"
                                            onclick="addressFunction()">Same as Above</a>
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_present_add_bang"
                                            name="txt_owner_present_add_bang" placeholder="বর্তমান ঠিকানা"
                                            value="{{ $pro_land_owner_info_edit->owner_present_add_bang }}">
                                        @error('txt_owner_present_add_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_present_add_eng"
                                            name="txt_owner_present_add_eng" placeholder="Present Address"
                                            value="{{ $pro_land_owner_info_edit->owner_present_add_eng }}">
                                        @error('txt_owner_present_add_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5 class="mb-4">{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('DeedLandOwnerInfoStore') }}" method="Post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="txt_emp_id" name="txt_emp_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                                        <input type="text" class="form-control" id="txt_owner_name_bang"
                                            name="txt_owner_name_bang" placeholder="নাম"
                                            value="{{ old('txt_owner_name_bang') }}">
                                        @error('txt_owner_name_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_father_name_bang"
                                            name="txt_owner_father_name_bang" placeholder="পিতার নাম"
                                            value="{{ old('txt_owner_father_name_bang') }}">
                                        @error('txt_owner_father_name_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_mother_name_bang"
                                            name="txt_owner_mother_name_bang" placeholder="মাতার নাম"
                                            value="{{ old('txt_owner_mother_name_bang') }}">
                                        @error('txt_owner_mother_name_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_dob"
                                            name="txt_owner_dob" placeholder="জন্ম তারিখ/DOB"
                                            value="{{ old('txt_owner_dob') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_owner_dob')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_name_eng"
                                            name="txt_owner_name_eng" placeholder="Name"
                                            value="{{ old('txt_owner_name_eng') }}">
                                        @error('txt_owner_name_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_father_name_eng"
                                            name="txt_owner_father_name_eng" placeholder="Father's Name"
                                            value="{{ old('txt_owner_father_name_eng') }}">
                                        @error('txt_owner_father_name_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_mother_name_eng"
                                            name="txt_owner_mother_name_eng" placeholder="Mother's Name"
                                            value="{{ old('txt_owner_mother_name_eng') }}">
                                        @error('txt_owner_mother_name_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_religious_bang"
                                            name="txt_owner_religious_bang" placeholder="ধর্ম"
                                            value="{{ old('txt_owner_religious_bang') }}">
                                        @error('txt_owner_religious_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_profession_bang"
                                            name="txt_owner_profession_bang" placeholder="পেশা"
                                            value="{{ old('txt_owner_profession_bang') }}">
                                        @error('txt_owner_profession_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nationality_bang"
                                            name="txt_owner_nationality_bang" placeholder="জাতীয়তা"
                                            value="{{ old('txt_owner_nationality_bang') }}">
                                        @error('txt_owner_nationality_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nid_bang"
                                            name="txt_owner_nid_bang" placeholder="জাতীয় পরিচিতি নং"
                                            value="{{ old('txt_owner_nid_bang') }}">
                                        @error('txt_owner_nid_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_religious_eng"
                                            name="txt_owner_religious_eng" placeholder="Religious"
                                            value="{{ old('txt_owner_religious_eng') }}">
                                        @error('txt_owner_religious_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_profession_eng"
                                            name="txt_owner_profession_eng" placeholder="Profession"
                                            value="{{ old('txt_owner_profession_eng') }}">
                                        @error('txt_owner_profession_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nationality_eng"
                                            name="txt_owner_nationality_eng" placeholder="Nationality"
                                            value="{{ old('txt_owner_nationality_eng') }}">
                                        @error('txt_owner_nationality_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_owner_nid_eng"
                                            name="txt_owner_nid_eng" placeholder="NID No."
                                            value="{{ old('txt_owner_nid_eng') }}">
                                        @error('txt_owner_nid_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_parmanent_add_bang"
                                            name="txt_owner_parmanent_add_bang" placeholder="স্থায়ী ঠিকানা"
                                            value="{{ old('txt_owner_parmanent_add_bang') }}">
                                        @error('txt_owner_parmanent_add_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_parmanent_add_eng"
                                            name="txt_owner_parmanent_add_eng" placeholder="Parmanent Address"
                                            value="{{ old('txt_owner_parmanent_add_eng') }}">
                                        @error('txt_owner_parmanent_add_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">

                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-primary" id='same' style="width: 100%;"
                                            onclick="addressFunction()">Same as Above</a>
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_present_add_bang"
                                            name="txt_owner_present_add_bang" placeholder="বর্তমান ঠিকানা"
                                            value="{{ old('txt_owner_present_add_bang') }}">
                                        @error('txt_owner_present_add_bang')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_owner_present_add_eng"
                                            name="txt_owner_present_add_eng" placeholder="Present Address"
                                            value="{{ old('txt_owner_present_add_eng') }}">
                                        @error('txt_owner_present_add_eng')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- land Owner info list --}}
        @include('/deed/land_owner_info_list')
    @endif


@section('script')
    <script>
        // Auto Fill up js code
        function addressFunction() {
            document.getElementById("txt_owner_present_add_bang").value = document.getElementById("txt_owner_parmanent_add_bang").value;
            document.getElementById("txt_owner_present_add_eng").value = document.getElementById("txt_owner_parmanent_add_eng").value;
        }
    </script>
{{--     <script>
        $(function() {
            $("#datatable").DataTable();
        });
    </script>
 --}}@endsection
@endsection
