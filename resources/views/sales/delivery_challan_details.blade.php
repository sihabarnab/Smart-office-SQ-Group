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
        $customer = DB::table("pro_customer_information_$d_challan->company_id")
            ->where('customer_id', $d_challan->customer_id)
            ->first();
        $mushok = DB::table("pro_mushok_$d_challan->company_id")
            ->where('mushok_id', $d_challan->mushok_no)
            ->first();
        $mr_id = DB::table("pro_money_receipt_$d_challan->company_id")
            ->where('sim_id', $d_challan->sim_id)
            ->pluck('mr_id');

        $money_receipt = DB::table("pro_money_receipt_$d_challan->company_id")
            ->where('customer_id', $d_challan->customer_id)
            ->whereNotIn('mr_id', $mr_id)
            ->get();

    @endphp

    @if (isset($d_challan_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form id="myForm"
                                action="{{ route('delivery_challan_details_update', [$d_challan_details_edit->delivery_chalan_details_id, $d_challan->company_id]) }}"
                                method="post">
                                @csrf

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->delivery_chalan_master_id }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->entry_date }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->sim_id }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->sim_date }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <input type="text" class="form-control" value="{{ $customer->customer_name }}"
                                            readonly>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" value="{{ $customer->customer_address }}"
                                            readonly>
                                    </div>

                                </div>




                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->ifb_no }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->ifb_date }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->contract_no }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->contract_date }}"
                                            readonly>
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->allocation_no }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->allocation_date }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->pono_ref }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->pono_ref_date }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_dcm_date" name="txt_dcm_date"
                                            placeholder="DCM Date" value="{{ $d_challan->dcm_date }}" readonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" value="{{ $d_challan->truck_no }}"
                                            readonly>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->driver_name | $d_challan->delivery_address }}" readonly>
                                        @error('cbo_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1 btn-primary">
                                    <div class="col-4">Product </div>
                                    <div class="col-2">Sales Qty </div>
                                    <div class="col-2">Delivery Qty </div>
                                    <div class="col-2">Balance Qty </div>
                                    <div class="col-2">Quantity</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_product" name="cbo_product">
                                            <option value="">--Product--</option>
                                            @foreach ($product as $value)
                                                <option value="{{ $value->product_id }}"
                                                    {{ $d_challan_details_edit->product_id == $value->product_id ? 'selected' : '' }}>
                                                    {{ $value->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_sale_qty" name="txt_sale_qty" class="form-control"
                                            readonly>
                                        @error('txt_sale_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_delivery_qty" name="txt_delivery_qty"
                                            class="form-control" readonly>
                                        @error('txt_delivery_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_balance_qty" name="txt_balance_qty"
                                            class="form-control" readonly>
                                        @error('txt_balance_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_qty" name="txt_qty" class="form-control"
                                            value="{{ $d_challan_details_edit->del_qty }}">
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
                                            class="btn btn-primary btn-block" disabled>Update
                                        </button>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

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

            <script>
                $(document).ready(function() {
                    GetData();

                    function GetData() {
                        var cbo_product = $('#cbo_product').val();
                        if (cbo_product) {
                            $.ajax({
                                url: "{{ url('/get/delivery_challan/product_details') }}/" + cbo_product +
                                    "/{{ $d_challan->delivery_chalan_master_id }}" +
                                    "/{{ $d_challan->company_id }}",
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    console.log(data)
                                    document.getElementById("txt_sale_qty").value = data.sale_qty;
                                    document.getElementById("txt_delivery_qty").value = data
                                        .delivery_qty;
                                    document.getElementById("txt_balance_qty").value = data.balance_qty;

                                },
                            });

                        } else {
                            $('#txt_sale_qty').empty();
                            $('#txt_delivery_qty').empty();
                            $('#txt_balance_qty').empty();
                        }
                    }

                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('select[name="cbo_product"]').on('change', function() {
                        GetData();

                    });
                });
            </script>
        @endsection
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form id="myForm"
                                action="{{ route('delivery_challan_details_store', [$d_challan->delivery_chalan_master_id, $d_challan->company_id]) }}"
                                method="post">
                                @csrf


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->delivery_chalan_master_id }}" readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->entry_date }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->sim_id }}"
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->sim_date }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <input type="text" class="form-control"
                                            value="{{ $customer->customer_name }}" readonly>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control"
                                            value="{{ $customer->customer_address }}" readonly>
                                    </div>

                                </div>




                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->ifb_no }}"
                                            placeholder="IFB No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->ifb_date }}"
                                            placeholder="IFB Date." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->contract_no }}"
                                            placeholder="Contract No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->contract_date }}" placeholder="Contract Date."
                                            readonly>
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->allocation_no }}" placeholder="Allocation No."
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->allocation_date }}" placeholder="Allocation Date."
                                            readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" value="{{ $d_challan->pono_ref }}"
                                            placeholder="Po No." readonly>
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->pono_ref_date }}" placeholder="Ref Date." readonly>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_dcm_date" name="txt_dcm_date"
                                            placeholder="DCM Date" value="{{ $d_challan->dcm_date }}" readonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" value="{{ $d_challan->truck_no }}"
                                            placeholder="Truck No" readonly>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control"
                                            value="{{ $d_challan->driver_name | $d_challan->delivery_address }}"
                                            placeholder="Address" readonly>
                                        @error('cbo_address')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1 btn-primary">
                                    <div class="col-4">Product </div>
                                    <div class="col-2">Sales Qty </div>
                                    <div class="col-2">Delivery Qty </div>
                                    <div class="col-2">Balance Qty </div>
                                    <div class="col-2">Quantity</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
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
                                        <input type="text" id="txt_sale_qty" name="txt_sale_qty" class="form-control"
                                            readonly>
                                        @error('txt_sale_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_delivery_qty" name="txt_delivery_qty"
                                            class="form-control" readonly>
                                        @error('txt_delivery_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_balance_qty" name="txt_balance_qty"
                                            class="form-control" readonly>
                                        @error('txt_balance_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" id="txt_qty" name="txt_qty" class="form-control">
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
                                            class="btn btn-primary btn-block" disabled>Add
                                        </button>
                                    </div>
                                    <div class="col-2">
                                        @php
                                            $serial = DB::table("pro_finish_product_serial_$d_challan->company_id")
                                                ->where(
                                                    'delivery_chalan_master_id',
                                                    $d_challan->delivery_chalan_master_id,
                                                )
                                                ->count();

                                            $m_details = DB::table("pro_delivery_chalan_details_$d_challan->company_id")
                                                ->where(
                                                    'delivery_chalan_master_id',
                                                    $d_challan->delivery_chalan_master_id,
                                                )
                                                ->sum('del_qty');
                                        @endphp
                                        @if ($m_details == 0)
                                            <button class="btn btn-primary btn-block " disabled>
                                                Final</button>
                                        @elseif ($m_details == $serial)
                                            <a id="confirm_action2" onclick="BTOFF2()"
                                                href="{{ route('delivery_challan_details_final', [$d_challan->delivery_chalan_master_id, $d_challan->company_id]) }}"
                                                class="btn btn-primary btn-block disabled">
                                                Final</a>
                                        @else
                                            <button class="btn btn-primary btn-block " disabled>
                                                Final</button>
                                        @endif

                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('sales.delivery_challan_details_list')

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
            <script type="text/javascript">
                $(document).ready(function() {
                    $('select[name="cbo_product"]').on('change', function() {
                        var cbo_product = $(this).val();
                        if (cbo_product) {
                            $.ajax({
                                url: "{{ url('/get/delivery_challan/product_details') }}/" + cbo_product +
                                    "/{{ $d_challan->delivery_chalan_master_id }}" +
                                    "/{{ $d_challan->company_id }}",
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    console.log(data)
                                    document.getElementById("txt_sale_qty").value = data.sale_qty;
                                    document.getElementById("txt_delivery_qty").value = data
                                        .delivery_qty;
                                    document.getElementById("txt_balance_qty").value = data.balance_qty;

                                },
                            });

                        } else {
                            $('#txt_sale_qty').empty();
                            $('#txt_delivery_qty').empty();
                            $('#txt_balance_qty').empty();
                        }

                    });
                });
            </script>
        @endsection
    @endif
@endsection
