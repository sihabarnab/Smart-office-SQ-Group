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

        $customer = DB::table("pro_customer_information_$sales_details->company_id")
            ->where('customer_id', $sales_master->customer_id)
            ->first();

        $product = DB::table("pro_finish_product_$sales_details->company_id")
            ->where('product_id', $sales_details->product_id)
            ->first();

        $my_date = strtotime(date('Y-m-d'));
        $prev_date = date('Y-m-d', strtotime('-2 month', $my_date));
        $current_date = date('Y-m-d');

        $finish_product_serial = DB::table("pro_finish_product_serial_$sales_details->company_id")
            ->whereBetween('entry_date', [$prev_date, $current_date])
            ->where('product_id', $sales_details->product_id)
            ->where('status', 1)
            ->get();

        $serial = DB::table("pro_finish_product_serial_$sales_master->company_id")
            ->where('sid_id', $sales_details->sid_id)
            ->where('sim_id', $sales_details->sim_id)
            ->where('product_id', $sales_details->product_id)
            ->get();

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm"
                            action="{{ route('sales_invoice_serial_store', [$sales_details->sid_id, $sales_master->company_id]) }}"
                            method="post">
                            @csrf

                            <div class="row mb-1 btn-primary">
                                <div class="col-3">Invoice No</div>
                                <div class="col-3">Date </div>
                                <div class="col-3">Product</div>
                                <div class="col-3">QTY</div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->sim_id }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->sim_date }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $product == null ? '' : $product->product_name }}" readonly>

                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_details->qty }}" readonly>
                                </div>
                            </div>

                            {{-- <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $customer->customer_name }}"
                                        readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" value="{{ $customer->customer_address }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $customer->customer_phone }}"
                                        readonly>
                                </div>
                            </div> --}}



                            {{-- <div class="row mb-1 btn-primary" >
                                <div class="col-4">Start Serial Number</div>
                                <div class="col-3">QTY</div>
                            </div> --}}

                            <div class="row mb-1">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_serial" name="cbo_serial">
                                        <option value="0">--Start Serial Number--</option>
                                        @foreach ($finish_product_serial as $value)
                                            <option value="{{ $value->serial_id }}">{{ $value->serial_no }}</option>
                                        @endforeach

                                    </select>
                                    @error('cbo_serial')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" id="txt_qty" name="txt_qty" class="form-control"
                                        placeholder="Qty">
                                    @error('txt_qty')
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
                                    @if (count($serial) == $sales_details->qty)
                                        <a  id="confirm_action2" onclick="BTOFF2()" href="{{ route('sales_invoice_details', [$sales_master->sim_id, $sales_master->company_id]) }}"
                                            class="btn btn-primary btn-block disabled">Final</a>
                                    @else
                                        <a  class="btn btn-primary btn-block disabled" >Final</a>
                                    @endif
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sales.sales_invoice_add_serial_list')
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
@endsection
