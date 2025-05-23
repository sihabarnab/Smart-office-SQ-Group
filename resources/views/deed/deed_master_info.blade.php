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

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-5">Add</h3>

                        <form action="{{ route('DeedMasterInfoStore') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_deed_sl"
                                        value="{{ old('txt_deed_sl') }}" name="txt_deed_sl"
                                        placeholder="Serial No.">
                                    @error('txt_deed_sl')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_book_no"
                                        value="{{ old('txt_book_no') }}" name="txt_book_no" placeholder="Book No.">
                                    @error('txt_book_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_deed_no"
                                        value="{{ old('txt_deed_no') }}" name="txt_deed_no" placeholder="Deed No.">
                                    @error('txt_deed_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_deed_date" name="txt_deed_date"
                                        placeholder="Deed Date" value="{{ old('txt_deed_date') }}"
                                        onfocus="(this.type='date')">
                                    @error('txt_deed_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_sub_registry_bang"
                                        value="{{ old('txt_sub_registry_bang') }}" name="txt_sub_registry_bang"
                                        placeholder="সাব-রেজিস্ট্রি">
                                    @error('txt_sub_registry_bang')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_sub_registry_eng"
                                        value="{{ old('txt_sub_registry_eng') }}" name="txt_sub_registry_eng"
                                        placeholder="Sub-Registry">
                                    @error('txt_sub_registry_eng')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="cbo_deed_type_id" id="cbo_deed_type_id" class="form-control">
                                        <option value="0">--দলিলের প্রকৃতি--</option>
                                        @foreach ($pro_deed_types as $pro_deed_type)
                                            <option value="{{ $pro_deed_type->deed_type_id }}">
                                                {{ $pro_deed_type->deed_type_id }}|{{ $pro_deed_type->deed_type_name }}|{{ $pro_deed_type->deed_type_bn_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_deed_type_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <select name="cbo_division_id" id="cbo_division_id" class="form-control">
                                        <option value="0">--বিভাগ--</option>
                                        @foreach ($pro_divisions as $pro_division)
                                            <option value="{{ $pro_division->divisions_id }}">
                                                {{ $pro_division->divisions_id }} | {{ $pro_division->divisions_name }} | {{ $pro_division->divisions_bn_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_division_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="cbo_district_id" id="cbo_district_id" class="form-control">
                                        <option value="0">--জেলা--</option>
                                    </select>
                                    @error('cbo_district_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select name="cbo_upazila_id" id="cbo_upazila_id" class="form-control">
                                        <option value="0">--উপজিলা/থানা--</option>
                                    </select>
                                    @error('cbo_upazila_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <select name="cbo_union_id" id="cbo_union_id" class="form-control">
                                        <option value="0">--ইউনিয়ন--</option>
                                    </select>
                                    @error('cbo_union_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <select name="cbo_mouja_id" id="cbo_mouja_id" class="form-control">
                                        <option value="0">--মৌজা--</option>
                                    </select>
                                    @error('cbo_mouja_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_land_area"
                                        value="{{ old('txt_land_area') }}" name="txt_land_area"
                                        placeholder="Land Area">
                                    @error('txt_land_area')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_land_unit_id" id="cbo_land_unit_id" class="form-control">
                                        <option value="0">--জমির মাপ--</option>
                                        @foreach ($pro_land_units as $pro_land_unit)
                                            <option value="{{ $pro_land_unit->land_unit_id }}">
                                                {{ $pro_land_unit->land_unit_id }}|{{ $pro_land_unit->land_unit_nane }}|{{ $pro_land_unit->land_unit_bn_nane }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_land_unit_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_land_type_id" id="cbo_land_type_id" class="form-control">
                                        <option value="0">--জমির ধরন--</option>
                                        @foreach ($pro_land_types as $pro_land_type)
                                            <option value="{{ $pro_land_type->land_type_id }}">
                                                {{ $pro_land_type->land_type_id }}|{{ $pro_land_type->land_type_name }}|{{ $pro_land_type->land_type_bn_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_land_type_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_land_price"
                                        value="{{ old('txt_land_price') }}" name="txt_land_price"
                                        placeholder="Price">
                                    @error('txt_land_price')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6"></div>
                                <div class="col-5"></div>
                                <div class="col-1">
                                    <button type="Submit" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('/deed/deed_master_info_list')

@section('script')
    {{-- //divison to District Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_division_id"]').on('change', function() {
                console.log('ok')
                var cbo_division_id = $(this).val();
                if (cbo_division_id) {

                    $.ajax({
                        url: "{{ url('/get/district/') }}/" + cbo_division_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_district_id"]').empty();
                            $('select[name="cbo_district_id"]').append(
                                '<option value="0">--জেলা--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_district_id"]').append(
                                    '<option value="' + value.districts_id + '">' +
                                    value.districts_id + ' | ' + value.district_name +
                                    ' | ' + value.district_bn_name + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>

    {{-- //District to upazilas use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_district_id"]').on('change', function() {
                console.log('ok')
                var cbo_district_id = $(this).val();
                if (cbo_district_id) {

                    $.ajax({
                        url: "{{ url('/get/upazilas/') }}/" + cbo_district_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_upazila_id"]').empty();
                            $('select[name="cbo_upazila_id"]').append(
                                '<option value="0">--উপজিলা/থানা--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_upazila_id"]').append(
                                    '<option value="' + value.upazilas_id + '">' +
                                    value.upazilas_id + ' | ' + value.upazilas_name +
                                    ' | ' + value.upazilas_bn_name + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
    {{-- //Upazilas to Union use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_upazila_id"]').on('change', function() {
                console.log('ok')
                var cbo_upazila_id = $(this).val();
                if (cbo_upazila_id) {

                    $.ajax({
                        url: "{{ url('/get/union/') }}/" + cbo_upazila_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_union_id"]').empty();
                            $('select[name="cbo_union_id"]').append(
                                '<option value="0">--ইউনিয়ন--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_union_id"]').append(
                                    '<option value="' + value.unions_id + '">' +
                                    value.unions_id + ' | ' + value.unions_name +
                                    ' | ' + value.unions_bn_name + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
    {{-- //Upazilas to Mouja use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_upazila_id"]').on('change', function() {
                console.log('ok')
                var cbo_upazila_id = $(this).val();
                if (cbo_upazila_id) {

                    $.ajax({
                        url: "{{ url('/get/mouja/') }}/" + cbo_upazila_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_mouja_id"]').empty();
                            $('select[name="cbo_mouja_id"]').append(
                                '<option value="0">--মৌজা--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_mouja_id"]').append(
                                    '<option value="' + value.moujas_id + '">' +
                                    value.moujas_id + ' | ' + value.moujas_name +
                                    ' | ' + value.moujas_bn_name + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>

@endsection
@endsection
