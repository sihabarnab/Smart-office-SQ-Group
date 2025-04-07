@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Return Product Serial</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $finish_product_serial = DB::table("pro_finish_product_serial_$riv_master->company_id")
            ->where('sim_id', $riv_master->sim_id)
            ->where('product_id', $m_return_invoice_details->product_id)
            ->where('status', 3)
            ->get();

        $serial = DB::table("pro_finish_product_serial_$m_return_invoice_details->company_id")
            ->where('rsim_id', $m_return_invoice_details->rsim_id)
            ->where('rsid_id', $m_return_invoice_details->rsid_id)
            ->where('product_id', $m_return_invoice_details->product_id)
            ->get();

    @endphp


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm"
                            action="{{ route('return_sales_invoice_serial_store', [$m_return_invoice_details->rsid_id, $m_return_invoice_details->company_id]) }}"
                            method="post">
                            @csrf

                            {{-- <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $riv_master->customer_name }}"
                                        readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" value="{{ $riv_master->customer_address }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $riv_master->customer_phone }}"
                                        readonly>
                                </div>
                            </div> --}}

                            <div class="row mb-1 btn-primary">
                                <div class="col-3">Return Invoice No</div>
                                <div class="col-3">Return Invoice Date</div>
                                <div class="col-3">Product</div>
                                <div class="col-3">QTY</div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $m_return_invoice_details->rsim_id }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $m_return_invoice_details->rsim_date }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $m_return_invoice_details->product_name }}" readonly>

                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control"
                                        value="{{ $m_return_invoice_details->return_qty }}" readonly>
                                </div>
                            </div>



                            <div class="row mb-1">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_serial" name="cbo_serial">
                                        <option value="">--Start Serial Number--</option>
                                        @foreach ($finish_product_serial as $value)
                                            <option value="{{ $value->serial_id }}">{{ $value->serial_no }}</option>
                                        @endforeach

                                    </select>
                                    @error('cbo_serial')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="number" id="txt_qty" name="txt_qty" class="form-control"
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
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Add</button>
                                </div>
                                <div class="col-2">
                                    @php
                                        $check = DB::table(
                                            "pro_finish_product_serial_$m_return_invoice_details->company_id",
                                        )
                                            ->where('rsid_id', $m_return_invoice_details->rsid_id)
                                            ->where('product_id', $m_return_invoice_details->product_id)
                                            ->first();
                                    @endphp
                                    @if (count($serial) == $m_return_invoice_details->return_qty)
                                        <a  id="confirm_action2" onclick="BTOFF2()" href="{{ route('return_sales_invoice_details', [$m_return_invoice_details->rsim_id, $m_return_invoice_details->company_id]) }}"
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

    @include('sales.return_sales_invoice_serial_list')
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
