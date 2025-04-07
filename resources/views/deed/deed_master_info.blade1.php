@extends('layouts.deed_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Deed info<br>দলিলের তথ্য</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>


    <section class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-5">Add</h3>

                            <form action="{{ route('deed.master_info.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_deed_sl"
                                                value="{{ old('txt_deed_sl') }}" name="txt_deed_sl"
                                                placeholder="Serial No.">
                                            @if ($errors->has('txt_deed_sl'))
                                                <span class="errorDate text-danger">{{ $errors->first('txt_deed_sl') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_book_no"
                                                value="{{ old('txt_book_no') }}" name="txt_book_no"
                                                placeholder="Book No.">
                                            @if ($errors->has('txt_book_no'))
                                                <span class="errorDate text-danger">{{ $errors->first('txt_book_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_deed_no"
                                                value="{{ old('txt_deed_no') }}" name="txt_deed_no"
                                                placeholder="Deed No.">
                                            @if ($errors->has('txt_deed_no'))
                                                <span class="errorDate text-danger">{{ $errors->first('txt_deed_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_deed_date" name="txt_deed_date"
                                            placeholder="Deed Date" value="{{ old('txt_deed_date') }}"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @if ($errors->has('txt_deed_date'))
                                            <span class="errorDate text-danger">{{ $errors->first('txt_deed_date') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_sub_registry_bang"
                                                value="{{ old('txt_sub_registry_bang') }}" name="txt_sub_registry_bang"
                                                placeholder="সাব-রেজিস্ট্রি">
                                            @if ($errors->has('txt_sub_registry_bang'))
                                                <span class="errorDate text-danger">{{ $errors->first('txt_sub_registry_bang') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_sub_registry_eng"
                                                value="{{ old('txt_sub_registry_eng') }}" name="txt_sub_registry_eng"
                                                placeholder="Sub-Registry">
                                            @if ($errors->has('txt_sub_registry_eng'))
                                                <span class="errorDate text-danger">{{ $errors->first('txt_sub_registry_eng') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="cbo_deed_type_id" id="cbo_deed_type_id" class="form-control">
                                                <option value="">--দলিলের প্রকৃতি--</option>
                                                @foreach ($pro_deed_types as $pro_deed_type)
                                                    <option value="{{ $pro_deed_type->deed_type_id }}">
                                                        {{ $pro_deed_type->deed_type_id }}|{{ $pro_deed_type->deed_type_name }}|{{ $pro_deed_type->deed_type_bn_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cbo_deed_type_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_deed_type_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="cbo_division_id" id="cbo_division_id" class="form-control">
                                                <option value="">--বিভাগ--</option>
                                                @foreach ($pro_divisions as $pro_division)
                                                    <option value="{{ $pro_division->divisions_id }}">
                                                        {{ $pro_division->divisions_id }}|{{ $pro_division->divisions_name }}|{{ $pro_division->divisions_bn_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cbo_division_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_division_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="cbo_district_id" id="cbo_district_id" class="form-control">
                                                <option value="">--জেলা--</option>
                                            </select>
                                            @if ($errors->has('cbo_district_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_district_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="cbo_upazila_id" id="cbo_upazila_id" class="form-control">
                                                <option value="">--উপজিলা/থানা--</option>
                                            </select>
                                            @if ($errors->has('cbo_upazila_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_upazila_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <select name="cbo_union_id" id="cbo_union_id" class="form-control">
                                                <option value="">--ইউনিয়ন--</option>
                                            </select>
                                            @if ($errors->has('cbo_union_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_union_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <select name="cbo_mouja_id" id="cbo_mouja_id" class="form-control">
                                                <option value="">--মৌজা--</option>
                                            </select>
                                            @if ($errors->has('cbo_mouja_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_mouja_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_land_area"
                                                value="{{ old('txt_land_area') }}" name="txt_land_area"
                                                placeholder="Land Area">
                                            @if ($errors->has('txt_land_area'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('txt_land_area') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select name="cbo_land_unit_id" id="cbo_land_unit_id" class="form-control">
                                                <option value="">--শতক|SATAK--</option>
                                                @foreach ($pro_land_units as $pro_land_unit)
                                                    <option value="{{ $pro_land_unit->land_unit_id }}">
                                                        {{ $pro_land_unit->land_unit_id }}|{{ $pro_land_unit->land_unit_nane }}|{{ $pro_land_unit->land_unit_bn_nane }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cbo_land_unit_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_land_unit_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <select name="cbo_land_type_id" id="cbo_land_type_id" class="form-control">
                                                <option value="">--জমির ধরন--</option>
                                                @foreach ($pro_land_types as $pro_land_type)
                                                    <option value="{{ $pro_land_type->land_type_id }}">
                                                        {{ $pro_land_type->land_type_id }}|{{ $pro_land_type->land_type_name }}|{{ $pro_land_type->land_type_bn_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('cbo_land_type_id'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('cbo_land_type_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="txt_land_price"
                                                value="{{ old('txt_land_price') }}" name="txt_land_price"
                                                placeholder="Price">
                                            @if ($errors->has('txt_land_price'))
                                                <span
                                                    class="errorDate text-danger">{{ $errors->first('txt_land_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="form-control  bg-primary">Save</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- Mouja info list --}}
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
                            '<option value="">--জেলা--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_district_id"]').append(
                                '<option value="' + value.districts_id + '">' +
                                value.districts_id + '|' + value.district_name +
                                '|' + value.district_bn_name + '</option>');
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
                            '<option value="">--উপজিলা/থানা--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_upazila_id"]').append(
                                '<option value="' + value.upazilas_id + '">' +
                                value.upazilas_id + '|' + value.upazilas_name +
                                '|' + value.upazilas_bn_name + '</option>');
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
                            '<option value="">--ইউনিয়ন--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_union_id"]').append(
                                '<option value="' + value.unions_id + '">' +
                                value.unions_id + '|' + value.unions_name +
                                '|' + value.unions_bn_name + '</option>');
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
                            '<option value="">--মৌজা--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_mouja_id"]').append(
                                '<option value="' + value.moujas_id  + '">' +
                                value.moujas_id  + '|' + value.moujas_name +
                                '|' + value.moujas_bn_name + '</option>');
                        });
                    },
                });

            } else {
                alert('danger');
            }

        });
    });
</script>

<script>
    $(function() {
        $("#datatable").DataTable();
    });
</script>

@endsection
@endsection
