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

        $customer = DB::table("pro_customer_information_$sales_master->company_id")
            ->where('customer_id', $sales_master->customer_id)
            ->first();
        $mushok = DB::table("pro_mushok_$sales_master->company_id")
            ->where('sim_id', $sales_master->sim_id)
            ->first();
           

        $total = 0;
        $discount = 0;
        $transport = 0;

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm" action="{{ route('sales_invoice_final', [$sales_master->sim_id,$sales_master->company_id]) }}" method="post">
                            @csrf


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
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->ref_name }}" placeholder="Reff. Name"
                                        readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" value="{{ $sales_master->ref_mobile }}" placeholder="Reff. Mobile"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"  value="{{ $mushok->mushok_number . '|' . $mushok->financial_year_name }}"
                                        readonly>
                                </div>
                            </div>


                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->ifb_no }}" placeholder="IFB No." readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->ifb_date }}" placeholder="IFB Date."
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->contract_no }}" placeholder="Contract No."
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->contract_date }}" placeholder="Contract Date."
                                        readonly>
                                </div>

                            </div>
                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->allocation_no }}" placeholder="Allocation No."
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->allocation_date }}" placeholder="Allocation Date."
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->pono_ref }}" placeholder="Po No."
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->pono_ref_date }}" placeholder="Ref Date."
                                        readonly>
                                </div>

                            </div>



                            <table class="table table-bordered table-striped table-sm m-0">
                                <thead class="btn-primary">
                                    <tr>
                                        <th>SL No</th>
                                        <th>Item</th>
                                        <th>Vendor</th>
                                        <th>Auth. Reference</th>
                                        <th>Rate Policy</th>
                                        <th>Unit</th>
                                        <th>QTY</th>
                                        <th>Unit Price</th>
                                        <th>Extended Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales_details as $key => $row)
                                        @php
                                            $total = $total + $row->total;
                                            $discount = $discount + $row->total_discount;
                                            $transport = $transport + $row->total_transport;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td></td>
                                            <td>{{ $row->auth_ref_no }}</td>
                                            <td>{{ $row->rate_policy_name }}</td>
                                            <td>{{ $row->unit_name }}</td>
                                            <td class="text-right">{{ number_format($row->qty,2) }}</td>
                                            <td class="text-right">{{ number_format($row->rate,2) }}</td>
                                            <td class="text-right">{{ number_format($row->total,2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right">SubTotal:</td>
                                        <td colspan="3" class="text-right">{{ number_format($total,2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="row mb-1 mt-1">
                                <div class="col-7"></div>
                                <div class="col-2">Discount Amount:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control text-right" name="txt_discount"
                                        value="{{ number_format($discount,2) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7"></div>
                                <div class="col-2">Transport Discount:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control text-right" name="txt_tr_discount"
                                        value="{{ number_format($transport,2) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7"></div>
                                <div class="col-2">Transportation Cost:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control text-right" name="txt_tr_cost_discount">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7"></div>
                                <div class="col-2">Test Fee:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control text-right" name="txt_test_fee">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-7"></div>
                                <div class="col-2">Other:</div>
                                <div class="col-3">
                                    <input type="text" class="form-control text-right" name="txt_other">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-9"></div>
                                <div class="col-3">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Final</button>
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
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
@endsection
