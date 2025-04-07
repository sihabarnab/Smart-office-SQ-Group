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

        $mr_id = DB::table("pro_money_receipt_$sales_master->company_id")
            ->where('valid', 2)
            ->pluck('mr_id');
        
        $money_receipt = DB::table("pro_money_receipt_$sales_master->company_id")
            ->where('customer_id', $sales_master->customer_id)
            ->whereNotIn('mr_id', $mr_id)
            ->orderbyDesc('mr_id')
            ->get();

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm" action="{{ route('sales_invoice_add_mr', [$sales_master->sim_id,$sales_master->company_id]) }}" method="post">
                            @csrf


                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->sim_id }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->sim_date }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $sales_master->pg_id == 28 ? 'TRANSFORMER' : 'CTPT' }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $customer->customer_name }}"
                                        readonly>
                                </div>

                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $customer->customer_address }}" placeholder="Customer Address"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->ref_name }}"  placeholder="Reff. Name"
                                        readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" value="{{ $sales_master->ref_mobile }}" placeholder="Reff. Mobile"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $sales_master->mushok_no . '|' . $mushok->financial_year_name }}" readonly>
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->ifb_no }}" placeholder="IFB No." readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->ifb_date }}"  placeholder="IFB Date."
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
                            <div class="row mb-2">
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

                            <div class="row mb-1 btn-primary">
                                <div class="col-3">Type</div>
                                <div class="col-4">Money Receipt No</div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $sales_master->sales_type == 2 ? 'Credit' : 'Cash' }}" readonly>

                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_mr_id" name="cbo_mr_id">
                                        <option value="">{{ '--Money Receipt No--' }}</option>
                                        @foreach ($money_receipt as $value)
                                            <option value="{{ $value->mr_id }}">{{ $value->mr_id }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_mr_id')
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
                                        $check = DB::table("pro_money_receipt_$sales_master->company_id")
                                            ->where('sim_id',$sales_master->sim_id)
                                            ->first();
                                    @endphp
                                    @if ($check)
                                    <a  id="confirm_action2" onclick="BTOFF2()" href="{{ route('sales_invoice_details',[$sales_master->sim_id,$sales_master->company_id]) }}" class="btn btn-primary btn-block disabled">Next</a>
                                    @else
                                    <a id="confirm_action2" onclick="BTOFF2()"  class="btn btn-primary btn-block disabled">Next</a>
                                    @endif
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sales.sales_invoice_mr_add_list')
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
