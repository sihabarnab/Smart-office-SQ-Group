@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Requisition </h1>
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
                        <form id="myForm" action="{{ route('requisition_master_store') }}" method="post">
                            @csrf


                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <select class="form-control" name="cbo_customer_type_id" id="cbo_customer_type_id">
                                        <option value="">Customer Type</option>
                                        @foreach ($customer_type as $value)
                                            <option value="{{ $value->customer_type_id }}">
                                                {{ $value->customer_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer_type_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <select class="form-control" id="cbo_customer" name="cbo_customer">
                                        <option value="">--Customer--</option>
                                    </select>

                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" id="txt_customer_add" name="txt_customer_add" class="form-control"
                                        placeholder="Customer Address">
                                    @error('txt_customer_add')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" id="txt_customer_balance" name="txt_customer_balance"
                                        class="form-control" placeholder="Balance">
                                    @error('txt_customer_balance')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <input type="text" id="txt_deposit_amount" name="txt_deposit_amount"
                                        class="form-control" placeholder="Deposit Amount">
                                    @error('txt_deposit_amount')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_req_date" name="txt_req_date"
                                        value="{{ old('txt_req_date') }}" placeholder="Requisition Date."
                                        onfocus="(this.type='date')">
                                    @error('txt_req_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_po_no" name="txt_po_no"
                                        value="{{ old('txt_po_no') }}" placeholder="PO No">
                                    @error('txt_po_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_ref_date" name="txt_ref_date"
                                        value="{{ old('txt_ref_date') }}" placeholder="Ref Date."
                                        onfocus="(this.type='date')">
                                    @error('txt_ref_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Remark">
                                    @error('txt_remark')
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
                                    <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                        class="btn btn-primary btn-block" disabled>Next</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sales.requisition_not_final')
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

    <script type="text/javascript">
        $(document).ready(function() {

            $('select[name="cbo_customer_type_id"]').on('change', function() {
                var cbo_company_id = $('#cbo_company_id').val();
                var cbo_customer_type_id = $('#cbo_customer_type_id').val();
                if (cbo_company_id && cbo_customer_type_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/customer/') }}/" + cbo_customer_type_id + '/' +
                            cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_customer"]').empty();
                            $('select[name="cbo_customer"]').append(
                                '<option value="">--Select Customer--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_customer"]').append(
                                    '<option value="' + value.customer_id + '">' +
                                    value.customer_id + '|' +
                                    value.customer_name + '</option>');
                            });

                        },
                    });

                } else {
                    $('select[name="cbo_customer"]').empty();
                }

            });

            $('select[name="cbo_customer"]').on('change', function() {
                var cbo_company_id = $('#cbo_company_id').val();
                var cbo_customer = $(this).val();
                if (cbo_customer && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/client_balance/') }}/" + cbo_customer + '/' +
                            cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_customer_add').val(data.address);
                            var balance = data.balance;
                            $('#txt_customer_balance').val(balance);

                        },
                    });

                } else {
                    $('#txt_customer_add').val('');
                    $('#txt_customer_balance').val('');
                }

            });

        });
    </script>
@endsection
