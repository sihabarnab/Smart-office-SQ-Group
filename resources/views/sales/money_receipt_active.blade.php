@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Money Recipt </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $banks = DB::table('pro_bank')->where('valid', 1)->get();
        // $bank_cat = ['--Select Bank--', 'PRIME BANK', 'NATIONAL BANK', 'JANATA BANK', 'DUTCH BANGLA BANK', 'STANDARD BANK'];
        $pay_type = DB::table('pro_payment_type')->where('valid', 1)->get();
        $customer = DB::table("pro_customer_information_$mr_master->company_id")
            ->where('valid', 1)
            ->get();
        $customer_type = DB::table('pro_customer_type')->where('valid', 1)->get();
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('money_receipt_valid', [$mr_details->mr_id, $mr_master->company_id]) }}"
                            method="GET">
                            @csrf


                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_collection_date"
                                        name="txt_collection_date" value="{{ $mr_details->collection_date }}"
                                        placeholder="Collection Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_collection_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                        <option value="0">-Transformer / CTPT-</option>
                                        <option value="28" {{ $mr_details->pg_id == 28 ? 'selected' : '' }}>TRANSFORMER
                                        </option>
                                        <option value="33" {{ $mr_details->pg_id == 33 ? 'selected' : '' }}>CTPT
                                        </option>
                                    </select>
                                    @error('cbo_transformer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_customer_type" name="cbo_customer_type">
                                        <option value="">{{ '--Customer Type--' }}</option>
                                        @foreach ($customer_type as $value)
                                            <option value="{{ $value->customer_type_id }}"
                                                {{ $mr_details->cust_sppl == $value->cust_sppl ? 'selected' : '' }}>
                                                {{ $value->customer_type }}</option>
                                        @endforeach

                                    </select>
                                    @error('cbo_customer_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_customer" name="cbo_customer">
                                        <option value="0">--Customer--</option>
                                        @foreach ($customer as $row)
                                            <option value="{{ $row->customer_id }}"
                                                {{ $mr_details->customer_id == $row->customer_id ? 'selected' : '' }}>
                                                {{ $row->customer_id }} | {{ $row->customer_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-7">
                                    <input type="text" id="txt_customer_details" name="txt_customer_details"
                                        class="form-control" placeholder="Description" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" id="txt_previous_blance" name="txt_previous_blance"
                                        class="form-control" placeholder="Previous Balance" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" id="txt_dt_price" name="txt_dt_price" class="form-control"
                                        placeholder="DT Price" value="{{ $mr_details->dt_price }}">
                                    @error('txt_dt_price')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_transport" name="txt_transport" class="form-control"
                                        placeholder="Transport" value="{{ $mr_details->transport_fee }}" readonly>
                                    @error('txt_transport')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_test_fee" name="txt_test_fee" class="form-control"
                                        placeholder="Test Fee" value="{{ $mr_details->test_fee }}" readonly>
                                    @error('txt_test_fee')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_other" name="txt_other" class="form-control"
                                        placeholder="Other" value="{{ $mr_details->other_fee }}" readonly>
                                    @error('txt_other')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_payment_type" name="cbo_payment_type">
                                        <option value="0">{{ '--Payment Type--' }}</option>
                                        @foreach ($pay_type as $value)
                                            <option value="{{ $value->payment_type_id }}"
                                                {{ $mr_details->payment_type == $value->payment_type_id ? 'selected' : '' }}>
                                                {{ $value->payment_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_payment_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- disable input  --}}
                                <div class="col-3" id="disable_in">
                                    <input type="text" class="form-control" disabled>
                                </div>

                                {{-- //cash  --}}
                                <div class="col-3" id="cash" style="display:  none">
                                    <select class="form-control" id="cbo_received" name="cbo_received">
                                        <option value="0">-Recived By-</option>
                                        <option value="1" {{ $mr_details->receive_type == 1 ? 'selected' : '' }}>Head
                                            Office</option>
                                        <option value="2" {{ $mr_details->receive_type == 2 ? 'selected' : '' }}>
                                            Factory</option>
                                    </select>
                                    @error('cbo_received')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- //online Deposite --}}
                                <div class="col-3" id="online" style="display:  none">
                                    <select class="form-control" id="cbo_online_deposite" name="cbo_online_deposite">

                                        {{--                                         @foreach ($bank_cat as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ $mr_details->bank_id == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
 --}} <option value="">-Select Bank-</option>
                                        @foreach ($banks as $row)
                                            <option value="{{ $row->bank_id }}"
                                                {{ $mr_details->bank_id == $row->bank_id ? 'selected' : '' }}>
                                                {{ $row->bank_name }} |
                                                {{ $row->bank_sname }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_online_deposite')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="text" id="txt_dd_no" name="txt_dd_no" class="form-control"
                                        placeholder="Chq/PO/DD No." value="{{ $mr_details->chq_po_dd_no }}">
                                    @error('txt_dd_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_dd_date" name="txt_dd_date"
                                        value="{{ $mr_details->chq_po_dd_date }}" placeholder="Chq/PO/DD Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_dd_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="cbo_active" name="cbo_active">
                                        <option value="">-Active-</option>
                                        <option value="1" {{ $mr_details->status == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="2" {{ $mr_details->status == 2 ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('cbo_active')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Remark" value="{{ $mr_details->remarks }}" readonly>
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
                                        class="btn btn-primary btn-block" disabled>Active</button>
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

            getEmployeedata();

            var p_type = $('#cbo_payment_type').val();
            if (p_type) {
                callSection(p_type)
            }

            $('#cbo_payment_type').on('change', function() {
                var section = $(this).val();
                callSection(section);

            });

            function callSection(section) {
                if (section == '1') {
                    $('#disable_in').hide();
                    $('#online').hide();
                    $('#cash').show();
                } else if (section == '0') {
                    $('#disable_in').show();
                    $('#online').hide();
                    $('#cash').hide();
                } else {
                    $('#disable_in').hide();
                    $('#cash').hide();
                    $('#online').show();
                }
            }
            //end

        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_customer"]').on('change', function() {
                var cbo_customer = $(this).val();
                var company_id = "{{ $mr_master->company_id }}";
                if (cbo_customer != 0 && company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/customer_previous_balance/') }}/" + cbo_customer +
                            '/' + company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_previous_blance').val(data.balance);
                            $('#txt_customer_details').val(data.address);

                        },
                    });

                } else {
                    $('#txt_previous_blance').val('');
                    $('#txt_customer_details').val('');
                }

            });
        });
    </script>

    <script type="text/javascript">
        function getEmployeedata() {
            var cbo_customer = $('#cbo_customer').val();
            var company_id = "{{ $mr_master->company_id }}";
            if (cbo_customer != 0 && company_id) {
                $.ajax({
                    url: "{{ url('/get/sales/customer_previous_balance/') }}/" + cbo_customer + '/' + company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#txt_previous_blance').val(data.balance);
                        $('#txt_customer_details').val(data.address);

                    },
                });

            } else {
                $('#txt_previous_blance').val('');
                $('#txt_customer_details').val('');
            }
        }
    </script>
@endsection
