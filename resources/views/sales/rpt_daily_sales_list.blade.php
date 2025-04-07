@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daily Sales Report</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('rpt_daliy_sales_report') }}" method="GET">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ $value->company_id == old('cbo_company_id') ? 'selected' : '' }}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{ '28' == old('cbo_transformer') ? 'selected' : '' }}>
                                        TRANSFORMER
                                    </option>
                                    <option value="33" {{ '33' == old('cbo_transformer') ? 'selected' : '' }}>CTPT
                                    </option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">

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
                        </div><!-- /.row -->

                        <div class="row mb-2">
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_type_id" id="cbo_customer_type_id">
                                    <option value="">-Customer Type-</option>
                                    @foreach ($customer_type as $value)
                                        <option value="{{ $value->customer_type_id }}"
                                            {{ old('cbo_customer_type_id') == $value->customer_type_id ? 'selected' : '' }}>
                                            {{ $value->customer_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_customer_type_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_id" id="cbo_customer_id">
                                    <option value="">-Party Name-</option>
                                </select>
                                @error('cbo_customer_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="cbo_product" name="cbo_product">
                                    <option value="">--KVA--</option>

                                </select>
                                @error('cbo_product')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

@section('script')
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


    <script type="text/javascript">
        $(document).ready(function() {
            getpartyname();
            $('select[name="cbo_customer_type_id"]').on('change', function() {
                getpartyname();

            });
        });

        function getpartyname() {
            var cbo_customer_type_id = $('#cbo_customer_type_id').val();
            var cbo_company_id = $('#cbo_company_id').val();
            var cbo_customer_id = "{{ old('cbo_customer_id') }}";
            if (cbo_customer_type_id) {
                $.ajax({
                    url: "{{ url('/get/sales/daliy_report_party_list/') }}/" +
                        cbo_customer_type_id + '/' + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_customer_id"]').empty();
                        $('select[name="cbo_customer_id"]').append(
                            '<option value="">-Party Name-</option>');
                        $.each(data, function(key, value) {
                            if (cbo_customer_id == value.customer_id) {
                                $('select[name="cbo_customer_id"]').append(
                                    '<option selected value="' + value.customer_id + '">' +
                                    value.customer_id + '|' +
                                    value.customer_name + '</option>');
                            } else {
                                $('select[name="cbo_customer_id"]').append(
                                    '<option value="' + value.customer_id + '">' +
                                    value.customer_id + '|' +
                                    value.customer_name + '</option>');
                            }
                        });
                    },
                });

            } else {
                $('select[name="cbo_customer_id"]').empty();
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            getFinishProduct();
            $('select[name="cbo_transformer"]').on('change', function() {
                getFinishProduct();

            });
        });

        function getFinishProduct() {
            var cbo_transformer = $('#cbo_transformer').val();
            var cbo_company_id = $('#cbo_company_id').val();
            var cbo_product = "{{ old('cbo_product') }}";
            if (cbo_transformer && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/sales/cbo_transformer_ctpt/') }}/" +
                        cbo_transformer + '/' + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_product"]').empty();
                        $('select[name="cbo_product"]').append(
                            '<option value="">-KVA-</option>');
                        $.each(data, function(key, value) {
                            if (cbo_product == value.product_id) {
                                $('select[name="cbo_product"]').append(
                                    '<option selected value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            } else {
                                $('select[name="cbo_product"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            }
                        });
                    },
                });

            } else {
                $('select[name="cbo_product"]').empty();
            }
        }
    </script>
@endsection
@endsection
