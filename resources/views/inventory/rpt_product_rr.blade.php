@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">PRODUCT RR</h1>
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
                        <div align="left" class=""></div>
                        <form id="myForm" action="{{ route('RptProductRRList') }}" method="Post">
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
                                    <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                        <option value="0">-Select Product Group-</option>
                                    </select>
                                    @error('cbo_product_group')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_product_sub_group" id="cbo_product_sub_group" class="form-control ">
                                        <option value="">-Select Product Sub Group-</option>
                                    </select>
                                    @error('cbo_product_sub_group')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="custom-select" id="cbo_product" name="cbo_product">
                                        <option value="">-Select Product-</option>
                                    </select>
                                    @error('cbo_product')
                                        <span class="text-warning">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                        placeholder="From Date" value="{{ old('txt_from_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_from_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
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
    &nbsp;
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getproductgroup();
            });
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
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
                            var d = $('select[name="cbo_product_sub_group"]').empty();
                            $('select[name="cbo_product_sub_group"]').append(
                                '<option value="">-Select Product Sub Group-</option>');
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
                                '<option value="">-Select Product-</option>');
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
@endsection
