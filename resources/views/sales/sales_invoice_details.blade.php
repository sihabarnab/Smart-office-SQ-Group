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


    @if (isset($edit_sales_details))
        @php
            $customer = DB::table("pro_customer_information_$sales_master->company_id")
                ->where('customer_id', $sales_master->customer_id)
                ->first();
            $mushok = DB::table("pro_mushok_$sales_master->company_id")
                ->where('sim_id', $sales_master->sim_id)
                ->first();

            $product = DB::table("pro_finish_product_$sales_master->company_id")
                ->where('product_category', 2)
                ->get();
            $rate_policy = DB::table("pro_rate_policy_$sales_master->company_id")
                ->where('valid', 1)
                ->get();
        @endphp
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form id="myForm"
                                action="{{ route('sales_invoice_details_update', [$edit_sales_details->sid_id, $sales_master->company_id]) }}"
                                method="post">
                                @csrf

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->sim_id }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->sim_date }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->sales_type == 2 ? 'Credit' : 'Cash' }}" readonly>

                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->pg_id == 28 ? 'TRANSFORMER' : 'CTPT' }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-4">
                                        <input type="text" class="form-control" value="{{ $customer->customer_name }}"
                                            placeholder="Customer Address" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->ref_name }}"
                                            placeholder="Reff. Name" readonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" value="{{ $sales_master->ref_mobile }}"
                                            placeholder="Reff. Mobile" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $mushok->mushok_number . '|' . $mushok->financial_year_name }}"
                                            readonly>
                                    </div>
                                </div>


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->ifb_no }}"
                                            placeholder="IFB No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->ifb_date }}"
                                            placeholder="IFB Date." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->contract_no }}"
                                            placeholder="Contract No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->contract_date }}" placeholder="Contract Date."
                                            readonly>
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->allocation_no }}" placeholder="Allocation No."
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->allocation_date }}" placeholder="Allocation Date."
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->pono_ref }}"
                                            placeholder="Po No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->pono_ref_date }}" placeholder="Ref Date." readonly>
                                    </div>

                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="0">--Product--</option>
                                            @foreach ($product as $value)
                                                <option value="{{ $value->product_id }}"
                                                    {{ $edit_sales_details->product_id == $value->product_id ? 'selected' : '' }}>
                                                    {{ $value->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="number" id="txt_discount" name="txt_discount" class="form-control"
                                            placeholder="Discount" value="{{ $edit_sales_details->discount_rate }}">
                                        @error('txt_discount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="number" id="txt_tr_discount" name="txt_tr_discount"
                                            class="form-control" placeholder="Transport Discount"
                                            value="{{ $edit_sales_details->transport_rate }}">
                                        @error('txt_tr_discount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_ref_no" name="txt_ref_no" class="form-control"
                                            placeholder="Ref.No." value="{{ $edit_sales_details->auth_ref_no }}">
                                        @error('txt_ref_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_rate_policy" name="cbo_rate_policy">
                                            <option value="0">--Rate Policy--</option>
                                            @foreach ($rate_policy as $value)
                                                <option value="{{ $value->rate_policy_id }}"
                                                    {{ $edit_sales_details->rate_policy_id == $value->rate_policy_id ? 'selected' : '' }}>
                                                    {{ $value->rate_policy_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_rate_policy')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="number" id="txt_qty" name="txt_qty" class="form-control"
                                            placeholder="Qty" value="{{ $edit_sales_details->qty }}">
                                        @error('txt_qty')
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
                                            class="btn btn-primary btn-block" disabled>Update</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @php

            $customer = DB::table("pro_customer_information_$sales_master->company_id")
                ->where('customer_id', $sales_master->customer_id)
                ->first();

            if ($sales_master->mushok_no) {
                $mushok = DB::table("pro_mushok_$sales_master->company_id")
                    ->where('sim_id', $sales_master->sim_id)
                    ->first();

                $mushok_number = $mushok->mushok_number;
                $financial_year_name = $mushok->financial_year_name;
            } else {
                $mushok_number = '';
                $financial_year_name = '';
            }

            $product_id = DB::table("pro_sid_$sales_master->company_id")
                ->where('sim_id', $sales_master->sim_id)
                ->pluck('product_id');

            $product = DB::table("pro_finish_product_$sales_master->company_id")
                ->where('product_category', 2)
                ->whereNotIn('product_id', $product_id)
                ->get();
            $rate_policy = DB::table("pro_rate_policy_$sales_master->company_id")
                ->where('valid', 1)
                ->get();

        @endphp

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form id="myForm"
                                action="{{ route('sales_invoice_details_store', [$sales_master->sim_id, $sales_master->company_id]) }}"
                                method="post">
                                @csrf


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->sim_id }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->sim_date }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->sales_type == 2 ? 'Credit' : 'Cash' }}" readonly>

                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->pg_id == 28 ? 'TRANSFORMER' : 'CTPT' }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-4">
                                        <input type="text" class="form-control"
                                            value="{{ $customer->customer_name }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->ref_name }}"
                                            placeholder="Reff. Name" readonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->ref_mobile }}" placeholder="Reff. Mobile" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $mushok_number . '|' . $financial_year_name }}" readonly>
                                    </div>
                                </div>


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->ifb_no }}"
                                            placeholder="IFB No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->ifb_date }}"
                                            placeholder="IFB Date." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->contract_no }}" placeholder="Contract No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->contract_date }}" placeholder="Contract Date."
                                            readonly>
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->allocation_no }}" placeholder="Allocation No."
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->allocation_date }}" placeholder="Allocation Date."
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $sales_master->pono_ref }}"
                                            placeholder="Po No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $sales_master->pono_ref_date }}" placeholder="Ref Date." readonly>
                                    </div>

                                </div>


                                <div class="row mb-1 btn-primary">
                                    <div class="col-2">Product </div>
                                    <div class="col-2">Discount </div>
                                    <div class="col-2">Transport Discount </div>
                                    <div class="col-2">Ref.No. </div>
                                    <div class="col-3">Rate Policy </div>
                                    <div class="col-1">Qty</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="0">--Product--</option>
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
                                        <input type="text" id="txt_discount" name="txt_discount" class="form-control"
                                            placeholder="Discount">
                                        @error('txt_discount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_tr_discount" name="txt_tr_discount"
                                            class="form-control" placeholder="Transport Discount">
                                        @error('txt_tr_discount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_ref_no" name="txt_ref_no" class="form-control"
                                            placeholder="Ref.No.">
                                        @error('txt_ref_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_rate_policy" name="cbo_rate_policy">
                                            <option value="">--Rate Policy--</option>
                                            @foreach ($rate_policy as $value)
                                                <option value="{{ $value->rate_policy_id }}">
                                                    {{ $value->rate_policy_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_rate_policy')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
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
                                        <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary btn-block" disabled>Add</button>
                                    </div>
                                    <div class="col-2">
                                        @php
                                            $m_details = DB::table("pro_sid_$sales_master->company_id")
                                                ->where('sim_id', $sales_master->sim_id)
                                                ->sum('qty');
                                            $serial = DB::table("pro_finish_product_serial_$sales_master->company_id")
                                                ->where('sim_id', $sales_master->sim_id)
                                                ->count();

                                        @endphp
                                        @if ($m_details == 0)
                                            <a  class="btn btn-primary btn-block disabled" >
                                                Continue</a>
                                        @elseif ($m_details == $serial)
                                            <a id="confirm_action2" onclick="BTOFF2()" href="{{ route('sales_invoice_end', [$sales_master->sim_id, $sales_master->company_id]) }}"
                                                class="btn btn-primary btn-block disabled">Continue</a>
                                            {{-- <button class="btn btn-primary btn-block" disabled>Continue</button> --}}
                                        @else
                                            <a  class="btn btn-primary btn-block disabled" >Continue</a>
                                        @endif
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('sales.sales_invoice_details_list')
    @endif


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
