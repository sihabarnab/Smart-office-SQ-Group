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
        $mushok = DB::table("pro_mushok_$sales_master->company_id")
            ->where('mushok_number', $sales_master->mushok_no)
            ->first();
        $mr_id = DB::table("pro_money_receipt_$sales_master->company_id")
            ->where('sim_id', $sales_master->sim_id)
            ->pluck('mr_id');

        $money_receipt = DB::table("pro_money_receipt_$sales_master->company_id")
            ->where('customer_id', $sales_master->customer_id)
            ->whereNotIn('mr_id', $mr_id)
            ->get();
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form id="myForm"
                            action="{{ route('create_delivery_challan_master', [$sales_master->sim_id, $sales_master->company_id]) }}"
                            method="post">
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
                                        value="{{ $sales_master->pg_id == 28 ? 'TRANSFORMER' : 'CTPT' }}" readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->customer_name }}"
                                        readonly>
                                </div>

                            </div>

                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control" value="{{ $sales_master->customer_address }}"
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
                                        value="{{ $mushok->mushok_number . '|' . $mushok->financial_year_name }}" readonly>
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
                                    <input type="text" class="form-control" value="{{ $sales_master->contract_date }}"
                                        placeholder="Contract Date." readonly>
                                </div>

                            </div>
                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->allocation_no }}"
                                        placeholder="Allocation No." readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->allocation_date }}"
                                        placeholder="Allocation Date." readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->pono_ref }}"
                                        placeholder="Po No." readonly>
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" value="{{ $sales_master->pono_ref_date }}"
                                        placeholder="Ref Date." readonly>
                                </div>
                            </div>

                            <div class="row bg-primary mb-1">
                                <div class="col-3">
                                    DCM Date
                                </div>
                                <div class="col-3">
                                    New/As Above
                                </div>
                                <div class="col-6">
                                    Delivery Address
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_dcm_date" name="txt_dcm_date"
                                        placeholder="DCM Date" value="{{ old('txt_dcm_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_dcm_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_address_type" name="cbo_address_type">
                                        <option value="1">--New--</option>
                                        <option value="2">--As Above--</option>
                                    </select>
                                    @error('cbo_address_type')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="cbo_address" name="cbo_address" class="form-control"
                                        placeholder="Delivery Address">
                                    @error('cbo_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-6">
                                    <input type="text" id="cbo_driver_name" name="cbo_driver_name"
                                        class="form-control" placeholder="Driver Name">
                                    @error('cbo_driver_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" id="cbo_truck_no" name="cbo_truck_no" class="form-control"
                                        placeholder="Vehicle No">
                                    @error('cbo_truck_no')
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
                                    <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Add
                                        Details</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_address_type"]').on('change', function() {
                var cbo_address_type = $(this).val();
                if (cbo_address_type == 2) {
                    var add = "{{ $sales_master->customer_address }}";
                    $('#cbo_address').val(add);
                } else {
                    $('#cbo_address').val('');

                }

            });
        });
    </script>
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
