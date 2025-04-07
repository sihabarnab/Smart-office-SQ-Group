@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Return Sales Invoice </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $company_id = $data['cbo_company_id'];
        $m_invoice_id = $data['cbo_invoice_id'];
        $m_return_date = $data['txt_return_date'];

        $m_sales = DB::table("pro_sim_$company_id")
            ->leftJoin("pro_customer_information_$company_id", "pro_sim_$company_id.customer_id", "pro_customer_information_$company_id.customer_id")
            ->leftJoin('pro_company', "pro_sim_$company_id.company_id", 'pro_company.company_id')
            ->select("pro_sim_$company_id.*", "pro_customer_information_$company_id.customer_name", "pro_customer_information_$company_id.customer_address", 'pro_company.company_name')
            ->where("pro_sim_$company_id.sim_id", $m_invoice_id)
            ->first();
    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm" action="{{ route('return_invoice_store', [$m_invoice_id, $company_id]) }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $m_sales->company_name }}"
                                        readonly>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $m_invoice_id }}" readonly>
                                </div>
                                <div class="col-4">
                                    <input type="date" class="form-control" id="txt_return_date" name="txt_return_date"
                                        value="{{ $m_return_date }}" placeholder="Return Date." readonly>

                                    @error('txt_return_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $m_sales->customer_name }}"
                                    placeholder="Customer"  readonly>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="{{ $m_sales->customer_address }}"  placeholder="Address" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->ref_name }}" placeholder="Ref. Name" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->pono_ref }}"
                                    placeholder="PO No"  readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->pono_ref_date }}"
                                    placeholder="PO Date"  readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->mushok_no }}" placeholder="Mushok No" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->pg_id == 28 ? 'TRANSFORMER' : 'CTPT' }}" placeholder="Product Group" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->sinv_total }}"
                                    placeholder="Invoice Total"  readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->sim_date }}"
                                    placeholder="invoice Date"  readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button  id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Next
                                    </button>
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