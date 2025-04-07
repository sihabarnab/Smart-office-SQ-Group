@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Repair Invoice Details</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h5>{{ 'Edit' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('repair_invoice_details_update') }}" method="Post">
                            @csrf

                            {{-- //hidden --}}
                            <input type="hidden" name="txt_repair_id" value="{{ $m_repair_details->reinvd_id }}">
                            <input type="hidden" name="txt_company_id" value="{{ $m_repair_details->company_id }}">

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_repair_master->reinvm_id }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_repair_master->reinvm_date }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_company->company_name }}"
                                        readonly>
                                </div>

                                <div class="col-3">
                                    <select class="form-control" id="cbo_transformer_ctpt" name="cbo_transformer_ctpt">
                                        <option value="">--Transformer / CTPT--</option>
                                        <option value="28" {{ $m_repair_master->pg_id == 28 ? 'selected' : '' }}>
                                            Transformer
                                        </option>
                                        <option value="33" {{ $m_repair_master->pg_id == 33 ? 'selected' : '' }}>CTPT
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_customer->customer_name }}"
                                        readonly>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" value="{{ $m_customer->customer_address }}"
                                        readonly>
                                </div>
                                <div class="co3-5">
                                    <input type="text" class="form-control" value="{{ $m_customer->customer_mobile }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_product->product_name }}"
                                        readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_repair_master->serial_no }}"
                                        placeholder="SI NO" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_repair_master->sold_date }}"
                                        placeholder="Sold Date" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_repair_master->recived_date }}"
                                        placeholder="Receive Date" readonly>
                                </div>
                            </div>

                            <div class="row mb-1 btn-primary">
                                <div class="col-6">
                                    {{ 'Product Description' }}
                                </div>
                                <div class="col-2">
                                    {{ 'Unit' }}
                                </div>
                                <div class="col-2">
                                    {{ 'Qty' }}
                                </div>
                                <div class="col-2">
                                    {{ 'Unit Price' }}
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_product_description"
                                        name="txt_product_description" placeholder="Product Description"
                                        value="{{ $m_repair_details->pro_des }}">
                                    @error('txt_product_description')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="cbo_product_unit" name="cbo_product_unit">
                                        <option value="">--Select Unit--</option>
                                        @foreach ($m_unit as $value)
                                            <option value="{{ $value->unit_id }}"  {{$value->unit_id ==  $m_repair_details->unit ?"selected":""}}>
                                                {{ $value->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product_unit')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_product_qty" name="txt_product_qty"
                                        placeholder="Qty" value="{{ $m_repair_details->qty }}">
                                    @error('txt_product_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_product_price"
                                        name="txt_product_price" placeholder="Unit Price"
                                        value="{{ $m_repair_details->unit_price }}">
                                    @error('txt_product_price')
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
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    &nbsp;
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