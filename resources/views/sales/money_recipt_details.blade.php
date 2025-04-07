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
        $bank_cat = [
            '--Select Bank--',
            'PRIME BANK',
            'NATIONAL BANK',
            'JANATA BANK',
            'DUTCH BANGLA BANK',
            'STANDARD BANK',
        ];
        $pay_type = DB::table('pro_payment_type')->where('valid', 1)->get();
        $customer = DB::table("pro_customer_information_$mr_master->company_id")->get();
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
                        <form id="myForm"
                            action="{{ route('money_receipt_details_store', [$mr_master->mr_master_id, $mr_master->company_id]) }}"
                            method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_collection_date"
                                        name="txt_collection_date" value="{{ old('txt_collection_date') }}"
                                        placeholder="Collection Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_collection_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                        <option value="0">-Transformer / CTPT-</option>
                                        <option value="28" {{ old('cbo_transformer') == '28' ? 'selected' : '' }}>
                                            TRANSFORMER</option>
                                        <option value="33" {{ old('cbo_transformer') == '33' ? 'selected' : '' }}>CTPT
                                        </option>
                                    </select>
                                    @error('cbo_transformer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_customer_type" name="cbo_customer_type">
                                        <option value="0">{{ '--Customer Type--' }}</option>
                                        @foreach ($customer_type as $value)
                                            <option value="{{ $value->customer_type_id }}"
                                                {{ old('cbo_customer_type') == $value->customer_type_id ? 'selected' : '' }}>
                                                {{ $value->customer_type }}
                                            </option>
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
                                        placeholder="DT Price" value="{{ old('txt_dt_price') }}">
                                    @error('txt_dt_price')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_transport" name="txt_transport" class="form-control"
                                        placeholder="Transport" value="{{ old('txt_transport') }}">
                                    @error('txt_transport')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_test_fee" name="txt_test_fee" class="form-control"
                                        placeholder="Test Fee" value="{{ old('txt_test_fee') }}">
                                    @error('txt_test_fee')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_other" name="txt_other" class="form-control"
                                        placeholder="Other" value="{{ old('txt_other') }}">
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
                                                {{ old('cbo_payment_type') == $value->payment_type_id ? 'selected' : '' }}>
                                                {{ $value->payment_type }}
                                            </option>
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
                                        <option value="">-Recived By-</option>
                                        <option value="1" {{ old('cbo_received') == 1 ? 'selected' : '' }}>Head
                                            Office
                                        </option>
                                        <option value="2" {{ old('cbo_received') == 2 ? 'selected' : '' }}>Factory
                                        </option>
                                    </select>
                                    @error('cbo_received')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- //online Deposite --}}
                                <div class="col-3" id="online" style="display:  none">
                                    <select class="form-control" id="cbo_online_deposite" name="cbo_online_deposite">
                                        <option value="">-Select Bank-</option>
                                        @foreach ($banks as $row)
                                            <option value="{{ $row->bank_id }}"
                                                {{ old('cbo_online_deposite') == $row->bank_id ? 'selected' : '' }}>
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
                                        placeholder="Chq/PO/DD No." value="{{ old('txt_dd_no') }}">
                                    @error('txt_dd_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_dd_date" name="txt_dd_date"
                                        value="{{ old('txt_dd_date') }}" placeholder="Chq/PO/DD Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_dd_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="cbo_active" name="cbo_active">
                                        <option value="">-Active-</option>
                                        <option value="1" {{ old('cbo_active') == '1' ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="2" {{ old('cbo_active') == '2' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('cbo_active')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" id="txt_remark" name="txt_remark" class="form-control"
                                        placeholder="Remark" value="{{ old('txt_remark') }}">
                                    @error('txt_remark')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-8">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Add</button>
                                </div>
                                <div class="col-2">
                                    @php
                                        $mr_details = DB::table("pro_money_receipt_$mr_master->company_id")
                                            ->where('mr_master_id', $mr_master->mr_master_id)
                                            ->first();
                                    @endphp
                                    @if (isset($mr_details))
                                        <a href="{{ route('money_receipt_final', [$mr_master->mr_master_id, $mr_master->company_id]) }}"
                                            id="confirm_action2" onclick="BTOFF2()"  class="btn btn-primary btn-block disabled">Final</a>
                                    @else
                                        <a href="#"  class="btn btn-primary btn-block disabled">Final</a>
                                    @endif
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sales.money_reeipt_details_list')
@endsection
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

    <script>
        $(document).ready(function() {
            var section = $('#cbo_payment_type').val();
            if (section) {
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

            $('#cbo_payment_type').on('change', function() {
                var section = $(this).val();

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

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_customer"]').on('change', function() {
                var cbo_customer = $(this).val();
                var company_id = "{{ $mr_master->company_id }}";
                if (cbo_customer != 0 && company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/customer_previous_balance/') }}/" + cbo_customer+'/'+company_id,
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
        $(document).ready(function() {
            var cbo_customer_type_id = $('select[name="cbo_customer_type"]').val();
            if (cbo_customer_type) {
                GetDailyPartyReportName();
            }

            $('select[name="cbo_customer_type"]').on('change', function() {
                GetDailyPartyReportName();
            });

            function GetDailyPartyReportName(m_customer_id) {
                var cbo_customer_type_id = $('select[name="cbo_customer_type"]').val();
                var company_id = "{{ $mr_master->company_id }}";
                if (cbo_customer_type_id && company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/daliy_report_party_list/') }}/" +
                            cbo_customer_type_id + "/" + company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_customer"]').empty();
                            $('select[name="cbo_customer"]').append(
                                '<option value="0">-Customer-</option>');
                            $.each(data, function(key, value) {

                                $('select[name="cbo_customer"]').append(
                                    '<option value="' + value.customer_id + '">' + value
                                    .customer_id + '|' +
                                    value.customer_name + '</option>');


                            });
                        },
                    });

                } else {
                    $('select[name="cbo_customer"]').empty();
                }
            }
        });
    </script>
@endsection
