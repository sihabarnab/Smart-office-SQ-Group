@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Requsition</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($mr_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form id="myForm"
                                action="{{ route('inventory_material_req_details_update', [$mr_details_edit->mrd_id, $mr_details_edit->company_id]) }}"
                                method="post">
                                @csrf

                                <div class="row form-group" style="margin-bottom: 0.5rem !important;">
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $mr_master->company_name }}">
                                    </div>

                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly id="txt_mrm_no"
                                            name="txt_mrm_no" value="{{ $mr_master->mrm_no }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly id="txt_mrm_date"
                                            name="txt_mrm_date" value="{{ $mr_master->mrm_date }}">
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="hidden" id="txt_project_id" name="txt_project_id"
                                            value="{{ $mr_master->project_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $mr_master->project_name }}">
                                        @error('txt_project_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" id="txt_section_id" name="txt_section_id"
                                            value="{{ $mr_master->section_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $mr_master->section_name }}">
                                        @error('txt_section_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_serial_no" readonly
                                            id="txt_serial_no" value="{{ $mr_master->mrm_serial_no }}">
                                        @error('txt_serial_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_serial_date" readonly
                                            name="txt_serial_date" value="{{ $mr_master->mrm_serial_date }}">
                                        @error('txt_serial_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_job_no" id="txt_job_no"
                                            readonly value="{{ $mr_master->jo_no }}">
                                        @error('txt_job_no')
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
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <select name="cbo_product_group" id="cbo_product_group" class="form-control">
                                            <option value="0">--Product Group--</option>
                                            @foreach ($pro_product_group as $row_product_group)
                                                <option value="{{ $row_product_group->pg_id }}"
                                                    {{ $row_product_group->pg_id == $mr_details_edit->pg_id ? 'selected' : '' }}>
                                                    {{ $row_product_group->pg_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control " redonly>
                                            <option value="{{ $mr_details_edit->pg_sub_id }}">
                                                {{ $mr_details_edit->pg_sub_name }}</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option value="{{ $mr_details_edit->product_id }}" redonly>
                                                {{ $mr_details_edit->product_name }}</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="hidden" name="txt_unit_id" class="form-control" id="txt_unit_id">
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" value="{{ $mr_details_edit->unit_name }}" readonly>
                                        @error('txt_unit_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_req_qty" id="txt_req_qty"
                                            value="{{ $mr_details_edit->requsition_qty }}" placeholder="Qty">
                                        @error('txt_req_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="txt_product_remarks"
                                            id="txt_product_remarks" value="{{ $mr_details_edit->remarks }}"
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
                            <form id="myForm" action="{{ route('inventory_material_req_details_store', $mr_master->company_id) }}"
                                method="post">
                                @csrf

                                <div class="row form-group" style="margin-bottom: 0.5rem !important;">
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $mr_master->company_name }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly id="txt_mrm_no"
                                            name="txt_mrm_no" value="{{ $mr_master->mrm_no }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" readonly id="txt_mrm_date"
                                            name="txt_mrm_date" value="{{ $mr_master->mrm_date }}">
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="hidden" id="txt_project_id" name="txt_project_id"
                                            value="{{ $mr_master->project_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $mr_master->project_name }}">
                                        @error('txt_project_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" id="txt_section_id" name="txt_section_id"
                                            value="{{ $mr_master->section_id }}">
                                        <input type="text" class="form-control" readonly
                                            value="{{ $mr_master->section_name }}">
                                        @error('txt_section_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_serial_no" readonly
                                            id="txt_serial_no" value="{{ $mr_master->mrm_serial_no }}">
                                        @error('txt_serial_no')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_serial_date" readonly
                                            name="txt_serial_date" value="{{ $mr_master->mrm_serial_date }}">
                                        @error('txt_serial_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_job_no" id="txt_job_no"
                                            readonly value="{{ $mr_master->jo_no }}">
                                        @error('txt_job_no')
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
                                <div class="row mb-1">
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
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option value="0">-Select Product-</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" value="{{ old('txt_unit_name') }}" placeholder=""
                                            readonly>
                                        @error('txt_unit_name')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_req_qty" id="txt_req_qty"
                                            value="{{ old('txt_req_qty') }}" placeholder="Qty">
                                        @error('txt_req_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="txt_product_remarks"
                                            id="txt_product_remarks" value="{{ old('txt_product_remarks') }}"
                                            placeholder="Product Remarks">
                                        @error('txt_product_remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                             

                                <div class="row mb-2">
                                    <div class="col-7">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-5">
                                        <a id="confirm_action2"
                                           href="{{ route('inventory_material_req_details_final', [$mr_master->mrm_no, $mr_master->company_id]) }}"
                                            onclick="BTOFF2()"
                                            class="btn btn-primary float-right pl-5 pr-5 disabled">Final</a>

                                        <button id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary float-right pl-3 pr-3 mr-2 " disabled>Add
                                            Another</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('inventory.material_requsition_details_list')
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
                //
                $('#txt_unit_id').empty();
                $('#txt_unit_name').empty();
                $('#txt_req_qty').empty();
                $('#txt_product_remarks').empty();
                //
                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/matrial_requsition/product_sub_group/') }}/" +
                            cbo_product_group + '/' + "{{ $mr_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product_sub_group"]').empty();
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
                    $('select[name="cbo_product"]').empty();
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
                        url: "{{ url('/get/matrial_requsition_product/') }}/" +
                            cbo_product_sub_group + '/' + "{{ $mr_master->mrm_no }}/" +
                            "{{ $mr_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product"]').empty();
                            $('select[name="cbo_product"]').append(
                                '<option value="0">-Select Product-</option>');
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
                $('#txt_unit_id').empty();
                $('#txt_unit_name').empty();
                $('#txt_req_qty').empty();
                $('#txt_product_remarks').empty();
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/matrial_requsition/unit/product_list/') }}/" +
                            cbo_product + '/' + "{{ $mr_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_unit_name').val(data.unit_name);
                            // $('#txt_req_qty').val(data.reorder_qty);
                            $('#txt_product_remarks').val(data.product_description);
                        },
                    });

                } else {
                    $('#txt_unit_id').empty();
                    $('#txt_unit_name').empty();
                }

            });
        });
    </script>
@endsection
@endsection
