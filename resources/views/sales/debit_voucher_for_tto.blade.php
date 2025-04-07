@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Debit Voucher for Test, Transport and Other</h1>
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
                        <form id="myForm" action="{{ route('debit_voucher_for_tto_store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}"
                                                {{ old('cbo_company_id') == $value->company_id ? 'selected' : '' }}>
                                                {{ $value->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id='err_cbo_company_id'></div>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_date" name="txt_date"
                                        value="{{ old('txt_date') }}" placeholder="Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" name="cbo_sales_invoice" id="cbo_sales_invoice">
                                        <option value="">-Select Sales Invoice-</option>
                                    </select>
                                    @error('cbo_sales_invoice')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="test" class="form-control" id="txt_name" name="txt_name"
                                        placeholder="Customer Name" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="test" class="form-control" id="txt_address" name="txt_address"
                                        placeholder="Customer Address" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="test" class="form-control" id="txt_mobile" name="txt_mobile"
                                        placeholder="Mobile" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_test_fee" name="txt_test_fee"
                                        placeholder="Test Fee" value="{{ old('txt_test_fee') }}">
                                    @error('txt_test_fee')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_transport_fee"
                                        name="txt_transport_fee" placeholder="Transport Fee"
                                        value="{{ old('txt_transport_fee') }}">
                                    @error('txt_transport_fee')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_other" name="txt_other"
                                        placeholder="Other Expense" value="{{ old('txt_other') }}">
                                    @error('txt_other')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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

    <script>
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getSalesInvoiceForDebitVouchertto();
            });
            $('select[name="cbo_sales_invoice"]').on('change', function() {
                getCustomerDetailsForDebitVouchertto();
            });
        });
    </script>

    <script type="text/javascript">
        // MR Number list
        function getSalesInvoiceForDebitVouchertto() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('get/sales/sales_invoice_for_debit_voucher_tto') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // console.log(data);
                        $('select[name="cbo_sales_invoice"]').empty();
                        $('select[name="cbo_sales_invoice"]').append(
                            '<option value="">--Sales Invoice--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_sales_invoice"]').append(
                                '<option value="' + value.sim_id + '">' +
                                value.sim_id + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_sales_invoice"]').empty();
            }
        }

        function getCustomerDetailsForDebitVouchertto() {
            var cbo_company_id = $('#cbo_company_id').val();
            var cbo_sales_invoice = $('#cbo_sales_invoice').val();
            if (cbo_sales_invoice) {
                $.ajax({
                    url: "{{ url('get/sales/customer_details_for_debit_voucher_tto') }}/" + cbo_company_id + '/' +
                        cbo_sales_invoice,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('#txt_name').val(data.customer_name);
                        $('#txt_address').val(data.customer_address);
                        $('#txt_mobile').val(data.customer_mobile);
                    },
                });

            } else {
                $('#txt_name').val('');
                $('#txt_address').val('');
                $('#txt_mobile').val('');
            }
        }
    </script>
@endsection
