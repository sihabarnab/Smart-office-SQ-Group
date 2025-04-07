@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Stock</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @php
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();
    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('RptProductStockList') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Select Company--</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">
                                                {{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div><!-- /.col -->
                                <div class="col-3">
                                    <select class="custom-select" id="cbo_project_id" name="cbo_project_id">
                                        <option value="0">-Select Project-</option>
                                        @foreach ($pro_project_name as $value)
                                            <option value="{{ $value->project_id }}">{{ $value->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_project_id')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
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
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="custom-select" id="cbo_product" name="cbo_product">
                                        <option value="0">-Select Product-</option>
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                        placeholder="From Date" value="{{ old('txt_from_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_from_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                        placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_to_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                        disabled>Submit</button>
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- @include('inventory.material_requsition_list_not_final') --}}


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
                if (cbo_product_sub_group) {
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
                if (cbo_product) {
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
