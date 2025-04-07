@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Challan </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php

        $customer = DB::table("pro_customer_information_$d_challan_details->company_id")
            ->where('customer_id', $d_challan_details->customer_id)
            ->first();

        $product = DB::table("pro_finish_product_$d_challan_details->company_id")
            ->where('product_id', $d_challan_details->product_id)
            ->first();

        $my_date = strtotime(date('Y-m-d'));
        $prev_date = date('Y-m-d', strtotime('-2 month', $my_date));
        $current_date = date('Y-m-d');

        $finish_product_serial = DB::table("pro_finish_product_serial_$d_challan_details->company_id")
            ->whereBetween('entry_date', [$prev_date, $current_date])
            ->where('product_id', $d_challan_details->product_id)
            ->where('status', 2)
            ->get();

        $serial = DB::table("pro_finish_product_serial_$d_challan_details->company_id")
            ->where('delivery_chalan_details_id', $d_challan_details->delivery_chalan_details_id)
            ->where('delivery_chalan_master_id', $d_challan_details->delivery_chalan_master_id)
            ->where('product_id', $d_challan_details->product_id)
            ->get();

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm"
                            action="{{ route('delivery_challan_serial_store', [$d_challan_details->delivery_chalan_details_id, $d_challan_details->company_id]) }}"
                            method="post">
                            @csrf

                            <div class="row mb-1 btn-primary">
                                <div class="col-4">Invoice No</div>
                                <div class="col-4">Product</div>
                                <div class="col-4">QTY</div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control"
                                        value="{{ $d_challan_details->delivery_chalan_master_id }}" readonly>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control"
                                        value="{{ $product == null ? '' : $product->product_name }}" readonly>

                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $d_challan_details->del_qty }}"
                                        readonly>
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
                                            <option value="{{ $value->serial_id }}">
                                                {{ $value->serial_id . '|' . $value->serial_no }}</option>
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
                                    @if (count($serial) == $d_challan_details->del_qty)
                                        <a id="confirm_action2" onclick="BTOFF2()" href="{{ route('delivery_challan_details', [$d_challan_details->delivery_chalan_master_id, $d_challan_details->company_id]) }}"
                                            class="btn btn-primary btn-block disabled">Final</a>
                                    @else
                                        <button class="btn btn-primary btn-block" disabled>Final</button>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="quotation_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Product Name</th>
                                    <th>Serial Number</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($serial as $key => $row)
                                    @php
                                        $product = DB::table("pro_finish_product_$d_challan_details->company_id")
                                            ->where('product_id', $row->product_id)
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $product->product_name }}
                                        </td>
                                        <td>{{ $row->serial_no }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
