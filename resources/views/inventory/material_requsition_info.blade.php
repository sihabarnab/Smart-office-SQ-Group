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


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('inventory_material_req_store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Select Company--</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}"  {{old('cbo_company_id') == $value->company_id ? "selected":""}}>
                                                {{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div><!-- /.col -->
                                <div class="col-3">
                                    <select class="custom-select" id="cbo_project_id" name="cbo_project_id">
                                        <option value="">-Select Project-</option>
                                        @foreach ($pro_project_name as $value)
                                            <option value="{{ $value->project_id }}" {{old('cbo_project_id') == $value->project_id ? "selected":""}}>{{ $value->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="custom-select" id="cbo_section_id" name="cbo_section_id">
                                        <option selected>-Select Section-</option>
                                        @foreach ($pro_section_information as $value)
                                            <option value="{{ $value->section_id }}" {{old('cbo_section_id') == $value->section_id ? "selected":""}}>{{ $value->section_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_section_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="txt_serial_no" id="txt_serial_no"
                                        value="{{ old('txt_serial_no') }}" placeholder="Serial No">
                                    @error('txt_serial_no')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_serial_date" name="txt_serial_date"
                                        placeholder="Serial Date" value="{{ old('txt_serial_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_serial_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="custom-select" id="cbo_job_id" name="cbo_job_id">
                                        <option value="">-Select JOB-</option>
                                    </select>
                                    @error('cbo_job_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="txt_remarks" id="txt_remarks"
                                        value="{{ old('txt_remarks') }}" placeholder=" ">
                                    @error('txt_remarks')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                        <option value="0">-Select Product Group-</option>

                                    </select>
                                    @error('cbo_product_group')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_product_sub_group" id="cbo_product_sub_group" class="form-control ">
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
                                    <input type="hidden" name="txt_unit_id" id="txt_unit_id" readonly>
                                    <input type="text" class="form-control" name="txt_unit_name" id="txt_unit_name"
                                        value="{{ old('txt_unit_name') }}" placeholder="Unit" readonly>
                                    @error('txt_unit_id')
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
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                        disabled>Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('inventory.material_requsition_list_not_final')


@section('script')
    <script>
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getproductgroup();
            });
        });
    </script>

    <script>
        function BTON() {

            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", false);
            } else {
                $("#confirm_action").prop("disabled", true);
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
    </script>

    <script>
        function getproductgroup() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/product_group/company/') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_product_group"]').empty();
                        $('select[name="cbo_product_group"]').append(
                            '<option value="">--Select Product Group--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_product_group"]').append(
                                '<option value="' + value.pg_id + '">' +
                                value.pg_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_product_group"]').empty();
                $('select[name="cbo_product_sub_group"]').empty();
                $('select[name="cbo_product"]').empty();
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product_group"]').on('change', function() {
                var cbo_product_group = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_product_group && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/matrial_requsition/product_sub_group/') }}/" +
                            cbo_product_group + '/' + cbo_company_id,
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
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_product_sub_group && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/matrial_requsition/product/') }}/" +
                            cbo_product_sub_group + '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product"]').empty();
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
                $('#txt_unit_id').empty();
                $('#txt_unit_name').empty();
                $('#txt_req_qty').empty();
                $('#txt_product_remarks').empty();
                var cbo_product = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_product && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/matrial_requsition/unit/product_list/') }}/" +
                            cbo_product + '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_unit_id').val(data.unit);
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
