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

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm"
                            action="{{ route('return_sales_invoice_update', [$m_return_invoice_details->rsid_id, $m_return_invoice_details->company_id]) }}"
                            method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $riv_master->company_name }}"
                                        readonly>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $riv_master->rsim_id }}" readonly>
                                </div>
                                <div class="col-4">
                                    <input type="date" class="form-control" id="txt_return_date" name="txt_return_date"
                                        value="{{ $riv_master->rsim_date }}" placeholder="Return Date." readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $riv_master->customer_name }}"
                                        placeholder="Customer" readonly>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" value="{{ $riv_master->customer_address }}"
                                        placeholder="Address" readonly>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->ref_name }}"
                                        placeholder="Ref. Name" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->pono_ref }}"
                                        placeholder="PO No" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->pono_ref_date }}"
                                        placeholder="PO Date" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $m_sales->mushok_no }}"
                                        placeholder="Mushok No" readonly>
                                </div>
                            </div>

                            {{-- <div class="row mb-2">
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
                            </div> --}}

                            <div class="row btn-primary mb-1">
                                <div class="col-3">Product Name</div>
                                <div class="col-2">Sales Qty</div>
                                <div class="col-2">Unit Price</div>
                                <div class="col-5">Remark</div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="cbo_product_id" name="cbo_product_id"
                                        value="{{ $m_return_invoice_details->product_name }}" placeholder="Product Name"
                                        readonly>
                                    {{-- <select class="form-control" id="cbo_product_id" name="cbo_product_id" readonly>
                                        <option value="">-Select Product-</option>
                                        @foreach ($product as $row)
                                            <option value="{{ $row->product_id }}"
                                                {{ $m_return_invoice_details->product_id == $row->product_id ? 'selected' : '' }}>
                                                {{ $row->product_name }}</option>
                                        @endforeach
                                    </select> --}}
                                    @error('cbo_product_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="qty" name="qty"
                                        placeholder="Qty" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" name="unit_price" id="unit_price"
                                        placeholder="Unit Price" readonly>
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="txt_remark" id="txt_remark"
                                        value="{{ $m_return_invoice_details->remarks }}" placeholder="Remark">
                                </div>
                            </div>

                            <div class="row btn-primary mb-1">
                                <div class="col-2">Return Qty</div>
                                <div class="col-3">Vat Amount</div>
                                <div class="col-2">Discount</div>
                                <div class="col-3">Depreciation</div>
                                <div class="col-2">Damage</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_qty" name="txt_qty"
                                        value="{{ $m_return_invoice_details->return_qty }}" placeholder="Return Qty">
                                    @error('txt_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control" id="txt_vat_amount" name="txt_vat_amount"
                                        value="{{ $m_return_invoice_details->vat_amount }}" placeholder="Vat Amount">
                                    @error('txt_vat_amount')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" name="txt_discount" id="txt_discount"
                                        value="{{ $m_return_invoice_details->discount_amount }}" placeholder="Discount">
                                    @error('txt_discount')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control" name="txt_depreciation"
                                        value="{{ $m_return_invoice_details->depreciation }}" id="txt_depreciation"
                                        placeholder="Depreciation">
                                    @error('txt_depreciation')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="cbo_damage" name="cbo_damage">
                                        <option value="">-Select-</option>
                                        <option value="1"
                                            {{ $m_return_invoice_details->damage_status == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="2"
                                            {{ $m_return_invoice_details->damage_status == 2 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('cbo_damage')
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
                                    <button  id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Update
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
    <script type="text/javascript">
        $(document).ready(function() {
            var cbo_product_id = "{{ $m_return_invoice_details->product_id }}";
            if (cbo_product_id) {
                $.ajax({
                    url: "{{ url('/get/sales/return_sales_invoice_details_edit/') }}/" +
                        cbo_product_id + "/{{ $riv_master->rsim_id }}" +
                        "/{{ $riv_master->company_id }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            $('#qty').val(data.qty);
                            $('#unit_price').val(data.rate);
                        } else {
                            $('#qty').val('');
                            $('#unit_price').val('');
                        }


                    },
                });

            } else {
                $('#qty').val('');
                $('#unit_price').val('');
            }


        });
    </script>
@endsection
