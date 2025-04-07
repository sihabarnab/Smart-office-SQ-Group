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


    @php

        $customer = DB::table("pro_customer_information_$req_master->company_id")
            ->where('customer_id', $req_master->customer_id)
            ->first();

        $product_id = DB::table("pro_sales_requisition_details_$req_master->company_id")
            ->where('requisition_master_id', $req_master->requisition_master_id)
            ->pluck('product_id');

        $product = DB::table("pro_finish_product_$req_master->company_id")
            ->where('product_category', 2)
            ->whereNotIn('product_id', $product_id)
            ->get();
        $rate_policy = DB::table("pro_rate_policy_$req_master->company_id")->where('valid',1)->get();

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm"
                            action="{{ route('requisition_details_store', [$req_master->requisition_master_id,$req_master->company_id]) }}"
                            method="post">
                            @csrf


                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control"
                                        value="{{ $req_master->requisition_master_id }}" readonly>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $req_master->requisition_date }}"
                                        readonly>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{$req_master->last_balance}}" placeholder="Opening Balance"
                                        readonly>
                                </div>

                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $customer->customer_name }}"
                                        readonly>
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" value="{{ $customer->customer_address }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $customer->customer_phone }}"
                                        readonly>
                                </div>
                                
                            </div>





                            <div class="row mb-1 btn-primary">
                                <div class="col-3">Product </div>
                                <div class="col-2">Qty</div>
                                <div class="col-3">Rate Policy </div>
                                <div class="col-2">Commission Rate </div>
                                <div class="col-2">Carring Allowance</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_product" name="cbo_product">
                                        <option value="">--Product--</option>
                                        @foreach ($product as $value)
                                            <option value="{{ $value->product_id }}">{{ $value->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" id="txt_qty" name="txt_qty" class="form-control"
                                        placeholder="Qty">
                                    @error('txt_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <select class="form-control" id="cbo_rate_policy" name="cbo_rate_policy">
                                        <option value="0">--Rate Policy--</option>
                                        @foreach ($rate_policy as $value)
                                            <option value="{{ $value->rate_policy_id }}">
                                                {{ $value->rate_policy_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_rate_policy')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="text" id="txt_commision_rate" name="txt_commision_rate"
                                        class="form-control" placeholder="Commission Rate">
                                    @error('txt_commision_rate')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" id="txt_cr_allowance" name="txt_cr_allowance" class="form-control"
                                        placeholder="Carring Allowance">
                                    @error('txt_cr_allowance')
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
                                        $check = DB::table("pro_sales_requisition_details_$req_master->company_id")
                                            ->where('requisition_master_id', $req_master->requisition_master_id)
                                            ->count();
                                    @endphp
                                    @if ($check>0)
                                        <a href="{{ route('requisition_final', [$req_master->requisition_master_id, $req_master->company_id]) }}"
                                            id="confirm_action2" onclick="BTOFF2()"  class="btn btn-primary btn-block disabled">Final</a>
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

    @include('sales.requisition_details_list')
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
