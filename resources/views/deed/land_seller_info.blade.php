@extends('layouts.deed_app')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Deed Information | দলিলের তথ্য</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>


    @if ($pro_deed_masters)
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body">
                            <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="10%">ক্রমিক নং :</td>
                                    <td width="15%">{{ $pro_deed_masters->deed_sl }}</td>
                                    <td width="10%">বহি নং :</td>
                                    <td width="10%">{{ $pro_deed_masters->book_no }}</td>
                                    <td width="10%">দলিল নং :</td>
                                    <td width="10%">{{ $pro_deed_masters->deed_no }}</td>
                                    <td width="20%">তারিখ :</td>
                                    <td width="15%">{{ $pro_deed_masters->deed_date }}</td>
                                </tr>
                                <tr>
                                    <td width="" colspan="2">সাব-রেজিস্ট্রি :</td>
                                    <td width="" colspan="3">{{ $pro_deed_masters->sub_registry_bang }}</td>
                                    <td colspan="3">{{ $pro_deed_masters->sub_registry_eng }}</td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="8" class="text-center">দলিলের সার সংক্ষেপ</td>
                                </tr>
                                </table>
                                <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="18%">দলিলের প্রকৃতি</td>
                                    <td width="17%">বিভাগ</td>
                                    <td width="17%">জেলা</td>
                                    <td width="18%">উপজিলা/থানা</td>
                                    <td width="15%">ইউনিয়ন</td>
                                    <td width="15%">মৌজা</td>
                                </tr>
                                <tr>
                                    <td>{{ $pro_deed_masters->deed_type_bn_name }}</td>
                                    <td>{{ $pro_deed_masters->divisions_bn_name }}</td>
                                    <td>{{ $pro_deed_masters->district_bn_name }}</td>
                                    <td>{{ $pro_deed_masters->upazilas_bn_name }}</td>
                                    <td>@isset( $pro_deed_masters->unions_bn_name)
                                            {{ $pro_deed_masters->unions_bn_name }}
                                            @endisset</td>
                                    <td>{{ $pro_deed_masters->moujas_bn_name }}</td>
                                </tr>
                                <tr>
                                    <td>জমির পরিমাপ : </td>
                                    <td>{{ $pro_deed_masters->land_area }} {{ $pro_deed_masters->land_unit_bn_nane }}</td>
                                    <td>জমির ধরন : </td>
                                    <td>{{ $pro_deed_masters->land_type_bn_name }}</td>
                                    <td>মূল্য : </td>
                                    <td>{{ $pro_deed_masters->land_price }}</td>
                                </tr>

                            </table>

                            <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="100%" class="text-center">দলিল গ্রহীতার তথ্য</td>
                                </tr>
                            </table>
                            @if (isset($pro_land_owner))
                            <table id="" class="table table-bordered table-striped table-sm small">
                            @foreach ($pro_land_owner as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->owner_name_bang}}</td>
                                <td>{{ $value->owner_name_bang}}</td>
                            </tr>
                            @endforeach
                            </table>
                            @endif

                            
                            <table id="" class="table table-bordered table-striped table-sm small">
                                <tr>
                                    <td width="100%" class="text-center">দলিল দাতার তথ্য</td>
                                </tr>
                            </table>
                             @if (isset($pro_land_seller))

                            <table id="" class="table table-bordered table-striped table-sm small">

                            @foreach ($pro_land_seller as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->seller_name_bang}}</td>
                                <td>{{ $value->seller_name_eng}}</td>
                            </tr>
                            @endforeach
                            </table>
                            @endif

                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endif


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('DeedLandSellerInfoStore')}}" method="Post">
                                @csrf

                                @if (isset($pro_deed_masters))
                                <input type="hidden" name="deed_master_id"  value="{{ $pro_deed_masters->deed_master_id  }}">
                                @endif

                                <div class="row mb-2">
                                    <div class="col-3">
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

                                
                                <button type="Submit" class="btn btn-primary float-left">Add More</button>
                                @php
                                    $check = DB::table('pro_land_seller')
                                        ->where('deed_master_id', '=', $pro_deed_masters->deed_master_id)
                                        ->first();
                                @endphp
                                @if(isset($check))
                                <a href="{{route('DeedLandSellerInfoNext',$pro_deed_masters->deed_master_id)}}" class="btn btn-primary float-right">Next</a>
                                @else
                                <a href="#" class="btn btn-primary float-right">Next</a>
                                @endif
                            
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


@section('script')
<script>
    // Auto Fill up js code
    function addressFunction() {
        document.getElementById("txt_owner_present_add_bang").value = document.getElementById("txt_owner_parmanent_add_bang").value;
        document.getElementById("txt_owner_present_add_eng").value = document.getElementById("txt_owner_parmanent_add_eng").value;
    }
</script>
    <script>
        $(function() {
            $("#datatable").DataTable();
        });
    </script>
@endsection
@endsection
