@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">MATERIAL RETURN DETAILS</h1>
                    @if (isset($gm_return_details_edit))
                        {{ $gm_return_master->company_name }}
                    @else
                        {{ $gm_return_master->company_name }}
                    @endif
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($gm_return_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm"
                                action="{{ route('material_return_update', [$gm_return_details_edit->mreturnd_id, $gm_return_master->company_id]) }}"
                                method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_Requsition_no"
                                            id="txt_Requsition_no" value="{{ $gm_return_master->return_master_no }}"
                                            readonly>
                                        @error('txt_Requsition_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_return_date"
                                            name="txt_return_date" placeholder="Return Date" readonly
                                            value="{{ $gm_return_master->return_date }}">
                                        @error('txt_return_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="cbo_project_id" name="cbo_project_id"
                                            value="{{ $gm_return_master->project_name }}" readonly>
                                        @error('cbo_project_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="cbo_section_id" name="cbo_section_id"
                                            value="{{ $gm_return_master->section_name }}" readonly>
                                        @error('cbo_section_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_vouchar_no" id="txt_vouchar_no"
                                            value="{{ $gm_return_master->voucher_no }}" readonly
                                            placeholder="Requsition Numbers">
                                        @error('txt_vouchar_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="cbo_job_id" id="cbo_job_id"
                                            value="{{ $gm_return_master->jo_no }}" placeholder="Job No.">
                                        @error('cbo_job_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="txt_job_info" id="txt_job_info"
                                            value="{{ old('txt_job_info') }}" placeholder="Job ">
                                        @error('txt_job_info')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                            <option value="">-Select Product Group-</option>
                                            @foreach ($pro_product_group as $value)
                                                <option value="{{ $value->pg_id }}"
                                                    {{ $value->pg_id == $gm_return_details_edit->pg_id ? 'selected' : '' }}>
                                                    {{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="{{ $gm_return_details_edit->pg_sub_id }}">
                                                {{ $gm_return_details_edit->pg_sub_name }}</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option value="{{ $gm_return_details_edit->product_id }}">
                                                {{ $gm_return_details_edit->product_name }}</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" name="txt_unit_id" id="txt_unit_id">
                                        <input type="text" class="form-control" name="txt_unit_name" id="txt_unit_name"
                                            value="{{ $gm_return_details_edit->unit_name }}" placeholder="Unit">
                                        @error('txt_unit_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_good_qty" id="txt_good_qty"
                                            value="{{ $gm_return_details_edit->useable_qty }}" placeholder="Good Qty">
                                        @error('txt_good_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_bad_qty" id="txt_bad_qty"
                                            value="{{ $gm_return_details_edit->damage_qty }}" placeholder="Bad Qty">
                                        @error('txt_bad_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="txt_product_remarks"
                                            id="txt_product_remarks" value="{{ $gm_return_details_edit->comments }}"
                                            placeholder="Product Remarks">
                                        @error('txt_product_remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-10">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary btn-block" disabled>Update</button>
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
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm"
                                action="{{ route('inventory_material_return_details_store', $gm_return_master->company_id) }}"
                                method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_Requsition_no"
                                            id="txt_Requsition_no" value="{{ $gm_return_master->return_master_no }}"
                                            readonly>
                                        @error('txt_Requsition_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_return_date"
                                            name="txt_return_date" placeholder="Return Date" readonly
                                            value="{{ $gm_return_master->return_date }}">
                                        @error('txt_return_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="cbo_project_id"
                                            name="cbo_project_id" value="{{ $gm_return_master->project_name }}" readonly>
                                        @error('cbo_project_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="cbo_section_id"
                                            name="cbo_section_id" value="{{ $gm_return_master->section_name }}" readonly>
                                        @error('cbo_section_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_vouchar_no"
                                            id="txt_vouchar_no" value="{{ $gm_return_master->voucher_no }}" readonly
                                            placeholder="Requsition Numbers">
                                        @error('txt_vouchar_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="cbo_job_id" id="cbo_job_id"
                                            value="{{ $gm_return_master->jo_no }}" placeholder="Job No.">
                                        @error('cbo_job_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" name="txt_job_info" id="txt_job_info"
                                            value="{{ old('txt_job_info') }}" placeholder="Job ">
                                        @error('txt_job_info')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                            <option value="">-Select Product Group-</option>
                                            @foreach ($pro_product_group as $value)
                                                <option value="{{ $value->pg_id }}">{{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="0">-Select Product Sub Group-</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option selected>-Select Product-</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" name="txt_unit_id" id="txt_unit_id">
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" value="{{ old('txt_unit_name') }}" placeholder="Unit">
                                        @error('txt_unit_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_good_qty" id="txt_good_qty"
                                            value="{{ old('txt_good_qty') }}" placeholder="Good Qty">
                                        @error('txt_good_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_bad_qty" id="txt_bad_qty"
                                            value="{{ old('txt_bad_qty') }}" placeholder="Bad Qty">
                                        @error('txt_bad_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="txt_product_remarks"
                                            id="txt_product_remarks" value="{{ old('txt_product_remarks') }}"
                                            placeholder="Product Remarks">
                                        @error('txt_product_remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-7">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-5">
                                        <a id="confirm_action2"
                                            href="{{ route('inventory_material_return_final', [$gm_return_master->return_master_no, $gm_return_master->company_id]) }}"
                                            onclick="BTOFF2()"
                                            class="btn btn-primary float-right pl-5 pr-5 disabled">Final</a>

                                        <button id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary float-right pl-3 pr-3 mr-2 " disabled>
                                            Add Another</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('inventory.material_return_details_list')
    @endif
@section('script')
    <script>
        function BTON() {
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", false);
            } else {
                $("#confirm_action").prop("disabled", true);
            }

            if ($('#confirm_action2').hasClass('disabled')) {
                $("#confirm_action2").removeClass('disabled')
            } else {
                $("#confirm_action2").addClass('disabled');
            }

        }

        function BTOFF() {
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", true);
            } else {
                $("#confirm_action").prop("disabled", true);
            }
            document.getElementById("myForm").submit();
        }

        function BTOFF2() {
            if ($('#confirm_action2').hasClass('disabled')) {
                $("#confirm_action2").addClass('disabled');
            } else {
                $("#confirm_action2").addClass('disabled');
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {
                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/return/product_sub_group/') }}/" + cbo_product_group +
                            "/{{ $gm_return_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_product_sub_group"]').empty();
                            $('select[name="cbo_product_sub_group"]').append(
                                '<option value="0">-Select Product Sub Group-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product_sub_group"]').append(
                                    '<option value="' + value.pg_sub_id + '">' +
                                    value.pg_sub_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_sub_group"]').empty();
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_sub_group"]').on('change', function() {
                var cbo_product_sub_group = $(this).val();
                if (cbo_product_sub_group) {
                    $.ajax({
                        url: "{{ url('/get/material_return/product/') }}/" +
                            cbo_product_sub_group + '/' +
                            "{{ $gm_return_master->return_master_no }}" +
                            "/{{ $gm_return_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            //
                            $('select[name="cbo_product"]').empty();
                            document.getElementById("txt_unit_name").value = " ";
                            $('select[name="cbo_product"]').append(
                                '<option value="0">-Select Product-</option>');
                            //
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product"]').empty();
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/return/product_details/') }}/" + cbo_product + '/' +
                            "{{ $gm_return_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            var d = $('select[name="txt_unit_id"]').empty();
                            // var d = $('select[name="txt_product_remarks"]').empty();
                            // var d = $('select[name="txt_approved_qty"]').empty();
                            // console.log(value)
                            document.getElementById("txt_unit_id").value = data.unit_id;
                            document.getElementById("txt_unit_name").value = data.unit_name;
                            // document.getElementById("txt_product_remarks").value = data.product_description;
                            // document.getElementById("txt_approved_qty").value = data.reorder_qty;


                        },
                    });

                } else {
                    $('select[name="txt_unit_id"]').empty();
                }

            });
        });
    </script>
@endsection

@endsection
