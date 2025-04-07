@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sales Invoice </h1>
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
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
        $m_customer_type = DB::table('pro_customer_type')->get();
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('sales_invoice_master_store') }}" method="post">
                            @csrf


                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="0">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}"
                                                {{ old('cbo_company_id') == $value->company_id ? 'selected' : '' }}>
                                                {{ $value->company_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_sales_date" name="txt_sales_date"
                                        value="{{ old('txt_sales_date') }}" placeholder="Sales Date"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">

                                    @error('txt_sales_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                        <option value="0">--Transformer / CTPT--</option>
                                        <option value="28">TRANSFORMER</option>
                                        <option value="33">CTPT</option>
                                    </select>
                                    @error('cbo_transformer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_customer_type_id" name="cbo_customer_type_id">
                                        <option value="0">--Customer Type--</option>
                                        @foreach ($m_customer_type as $row_customer_type)
                                            <option value="{{ $row_customer_type->customer_type_id }}">
                                                {{ $row_customer_type->customer_type_id }} |
                                                {{ $row_customer_type->customer_type }}</option>
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
                                <div class="col-6">
                                    <input type="text" id="txt_customer_add" name="txt_customer_add" class="form-control"
                                        placeholder="Customer Address">
                                    @error('txt_customer_add')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" id="txt_reff_name" name="txt_reff_name" class="form-control"
                                        placeholder="Reff. Name">
                                    @error('txt_reff_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" id="txt_reff_mobile" name="txt_reff_mobile" class="form-control"
                                        placeholder="Reff. Mobile">
                                    @error('txt_reff_mobile')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_mushok_no" name="cbo_mushok_no">
                                        <option value="0">--Mushok. No.--</option>

                                    </select>
                                    @error('cbo_mushok_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" id="txt_ifb_no" name="txt_ifb_no" class="form-control"
                                        placeholder="IFB No.">
                                    @error('txt_ifb_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_ifb_date" name="txt_ifb_date"
                                        value="{{ old('txt_ifb_date') }}" placeholder="IFB Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">

                                    @error('txt_ifb_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_contract_no" name="txt_contract_no"
                                        class="form-control" placeholder="Contract No.">
                                    @error('txt_contract_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_contract_date"
                                        name="txt_contract_date" value="{{ old('txt_contract_date') }}"
                                        placeholder="Contract Date." onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">

                                    @error('txt_contract_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" id="txt_allocation_no" name="txt_allocation_no"
                                        class="form-control" placeholder="Allocation No.">
                                    @error('txt_allocation_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_allocation_date"
                                        name="txt_allocation_date" value="{{ old('txt_allocation_date') }}"
                                        placeholder="Allocation Date." onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">

                                    @error('txt_allocation_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_po_no" name="txt_po_no" class="form-control"
                                        placeholder="Po No.">
                                    @error('txt_po_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_ref_date" name="txt_ref_date"
                                        value="{{ old('txt_ref_date') }}" placeholder="Ref Date."
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">

                                    @error('txt_ref_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_sales_type" name="cbo_sales_type">
                                        <option value="0">{{ '--Sales Type--' }}</option>
                                        <option value="1">{{ 'Cash' }}</option>
                                        <option value="2">{{ 'Credit' }}</option>
                                    </select>
                                    @error('cbo_sales_type')
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
                                    <button  id="confirm_action" onclick="BTOFF()"
                                        class="btn btn-primary btn-block" disabled>Add
                                        Details</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sales.sales_invoice_master_list')
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
                var cbo_customer_type_id = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_customer_type_id && cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/sales_customer_id/') }}/" + cbo_customer_type_id + '/' +
                            cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_customer"]').empty();
                            $('select[name="cbo_customer"]').append(
                                '<option value="">--Customer--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_customer"]').append(
                                    '<option value="' + value.customer_id + '">' +
                                    value.customer_id + ' | ' + value
                                    .customer_name + '</option>');
                            });
                        },
                    });

                }

            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_customer"]').on('change', function() {
                var cbo_customer = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_customer != 0 && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/invoice_cust_details/') }}/" + cbo_customer +
                            '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_customer_add').val(data.address);

                        },
                    });

                } else {
                    $('#txt_customer_add').val('');
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                callMushok(cbo_company_id);
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id != 0) {
                    callMushok(cbo_company_id);

                } else {
                    $('select[name="cbo_mushok_no"]').empty();
                }

            });
        });
    </script>



    <script type="text/javascript">
        function callMushok(cbo_company_id) {
            $.ajax({
                url: "{{ url('/get/sales/musak_no/') }}/" + cbo_company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('select[name="cbo_mushok_no"]').empty();
                    $('select[name="cbo_mushok_no"]').append(
                        '<option value="">--Mushok. No.--</option>');
                    $.each(data, function(key, value) {
                        $('select[name="cbo_mushok_no"]').append(
                            '<option value="' + value.mushok_id + '">' +
                            value.mushok_number + '|' + value
                            .financial_year_name + '</option>');
                    });

                },
            });
        }
    </script>
@endsection
