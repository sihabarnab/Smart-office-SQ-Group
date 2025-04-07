@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Receiving Report</h1>

                    @if (isset($pro_grr_details_Edit))
                        {{ $pro_grr_details_Edit->company_name }}
                    @else
                        {{ $grr_master_recived->company_name }}
                    @endif

                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($pro_grr_details_Edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm"
                                action="{{ route('inventory_receiving_report_update', [$pro_grr_details_Edit->grr_details_id, $pro_grr_details_Edit->company_id]) }}"
                                method="post">
                                @csrf
                                <div align="left" class="">
                                    <h5>{{ 'Edit' }}</h5>
                                </div>

                                {{-- hidden  --}}
                                <input type="hidden" name="txt_indent_no" id="txt_indent_no"
                                    value="{{ $pro_grr_details_Edit->indent_no }}">
                                <input type="hidden" name="txt_grr_no" id="txt_grr_no"
                                    value="{{ $pro_grr_details_Edit->grr_no }}">

                                <div class="row bg-secondary mb-1">
                                    <div class="col-3">LC No.</div>
                                    <div class="col-3">LC Date</div>
                                    <div class="col-3">Challan No.</div>
                                    <div class="col-3">Challan Date.</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" name='txt_glc_no'
                                            value="{{ $pro_grr_details_Edit->glc_no }}">
                                        {{ $pro_grr_details_Edit->glc_no }}
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" name='txt_glc_date'
                                            value="{{ $pro_grr_details_Edit->glc_date }}">
                                        {{ $pro_grr_details_Edit->glc_date }}
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" name='txt_chalan_no'
                                            value="{{ $pro_grr_details_Edit->chalan_no }}">
                                        {{ $pro_grr_details_Edit->chalan_no }}
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" name='txt_chalan_date'
                                            value="{{ $pro_grr_details_Edit->chalan_date }}">
                                        {{ $pro_grr_details_Edit->chalan_date }}

                                    </div>
                                </div>

                                <div class="row bg-primary mb-2 ">
                                    <div class="col-3 ">
                                        Product Group
                                    </div>
                                    <div class="col-3">
                                        Product
                                    </div>
                                    <div class="col-2">
                                        Unit
                                    </div>
                                    <div class="col-2">
                                        Approved Qty
                                    </div>
                                    <div class="col-2">
                                        RR Qty
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" readonly name="cbo_product_group" id="cbo_product_group"
                                            class="form-control" value="{{ $pro_grr_details_Edit->pg_name }}">
                                        @error('cbo_product_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">

                                        <input type="hidden" readonly name="cbo_product" id="cbo_product"
                                            class="form-control" value="{{ $pro_grr_details_Edit->product_id }}">
                                        <input type="text" readonly name="cbo_product2" id="cbo_product2"
                                            class="form-control" value="{{ $pro_grr_details_Edit->product_name }}">
                                        @error('cbo_product2')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @php
                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', $pro_grr_details_Edit->unit)
                                            ->first();
                                    @endphp
                                    <div class="col-2">
                                        <input type="text" class="form-control" readonly name="txt_unit" id="txt_unit"
                                            value=" {{ $unit->unit_name }}" style="margin-left: -10px;">
                                        @error('txt_unit')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_indent_qty" id="txt_indent_qty"
                                            readonly value="{{ $pro_grr_details_Edit->indent_qty }}"
                                            placeholder="Indent Qty" style="margin-left: -10px;">
                                        @error('txt_indent_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_rr_qty" id="txt_rr_qty"
                                            value="{{ $pro_grr_details_Edit->received_qty }}" placeholder="RR Qty">
                                        @error('txt_rr_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="txt_remarks" id="txt_remarks"
                                            value="{{ $pro_grr_details_Edit->remarks }}">
                                        @error('txt_remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-10">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-2">
                                        <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                            disabled>Update</button>
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
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            {{-- <h5>{{ 'Add' }}</h5> --}}
                        </div>
                        <form id="myForm"
                            action="{{ route('inventory_indent_report_receiving', $grr_master_recived->company_id) }}"
                            method="post">
                            @csrf
                            <div class="row bg-secondary mb-1">
                                <div class="col-2">RR No.</div>
                                <div class="col-2">RR Date</div>
                                <div class="col-2">Project</div>
                                <div class="col-2">Indent Category</div>
                                <div class="col-2">Indent No.</div>
                                <div class="col-2">Indent Date</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-2">
                                    <input type="hidden" class="form-control" name="txt_grr_no"
                                        value="{{ $grr_master_recived->grr_no }}">
                                    {{ $grr_master_recived->grr_no }}
                                </div>
                                <div class="col-2">
                                    {{ $grr_master_recived->grr_date }}
                                </div>
                                <div class="col-2">
                                    {{ $grr_master_recived->project_name }}

                                </div>
                                <div class="col-2">
                                    {{ $grr_master_recived->category_name }}

                                </div>
                                <div class="col-2">
                                    <input type="hidden" class="form-control" name='txt_indent_no'
                                        value="{{ $grr_master_recived->indent_no }}">
                                    {{ $grr_master_recived->indent_no }}
                                </div>
                                <div class="col-2">
                                    {{ $grr_master_recived->indent_date }}

                                </div>
                            </div>

                            <div class="row bg-secondary mb-1">
                                <div class="col-4">
                                    Supplier
                                </div>
                                <div class="col-8">
                                    Supplier Address
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4">
                                    {{ $grr_master_recived->supplier_name }}

                                </div>
                                <div class="col-8">
                                    {{ $grr_master_recived->supplier_address }}

                                </div>
                            </div>

                            <div class="row bg-secondary mb-1">
                                <div class="col-3">
                                    LC No.
                                </div>
                                <div class="col-3">
                                    LC Date
                                </div>
                                <div class="col-3">
                                    Challan No.
                                </div>
                                <div class="col-3">
                                    Challan Date.
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="hidden" class="form-control" name='txt_glc_no'
                                        value="{{ $grr_master_recived->glc_no }}">
                                    {{ $grr_master_recived->glc_no }}
                                </div>
                                <div class="col-3">
                                    {{ $grr_master_recived->glc_date }}
                                </div>
                                <div class="col-3">
                                    <input type="hidden" class="form-control" name='txt_chalan_no'
                                        value="{{ $grr_master_recived->chalan_no }}">
                                    {{ $grr_master_recived->chalan_no }}
                                </div>
                                <div class="col-3">
                                    <input type="hidden" class="form-control" name='txt_chalan_date'
                                        value="{{ $grr_master_recived->chalan_date }}">
                                    {{ $grr_master_recived->chalan_date }}

                                </div>
                            </div>

                            <div class="row bg-primary mb-1">
                                <div class="col-3">
                                    Product Group
                                </div>
                                <div class="col-3">
                                    Product Sub Group
                                </div>
                                <div class="col-3">
                                    Product
                                </div>
                                <div class="col-3">
                                    Unit
                                </div>

                            </div>

                            <div class="row mb-1">
                                <div class="col-3">
                                    <select name="cbo_product_group" id="cbo_product_group" class="form-control">
                                        <option value="0">-Select Product Group-</option>
                                        @foreach ($pro_product_group as $key => $value)
                                            <option value="{{ $value }}">
                                                {{ $key }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_product_group')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                        class="form-control">
                                        <option value="0">-Select Product Sub Group-</option>
                                    </select>
                                    @error('cbo_product_sub_group')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_product" id="cbo_product" class="form-control">
                                        <option value="0">-Select Product-</option>
                                    </select>
                                    @error('cbo_product')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="text" class="form-control" name="txt_unit2" readonly
                                        id="txt_unit2" placeholder="Unit">
                                </div>

                            </div>


                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control" readonly name="txt_indent_qty"
                                        id="txt_indent_qty" value="{{ old('txt_indent_qty') }}"
                                        placeholder="Indent Qty">
                                    @error('txt_indent_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" readonly class="form-control" name="txt_pre_rr_qty"
                                        id="txt_pre_rr_qty" value="{{ old('txt_pre_rr_qty') }}"
                                        placeholder="Pre.RR Qty">
                                    @error('txt_pre_rr_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="txt_rr_qty" id="txt_rr_qty"
                                        value="{{ old('txt_rr_qty') }}" placeholder="RR Qty">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="txt_Remarks" id="txt_Remarks"
                                        placeholder="Remarks">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-7">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-5">
                                    @php
                                        $check = DB::table("pro_grr_details_$grr_master_recived->company_id")
                                            ->where('grr_no', '=', $grr_master_recived->grr_no)
                                            ->first();
                                    @endphp
                                    @if ($check)
                                        <a id="confirm_action2"
                                            href="{{ route('inventory_receiving_report_final', [$grr_master_recived->grr_no, $grr_master_recived->company_id]) }}"
                                            onclick="BTOFF2()"
                                            class="btn btn-primary float-right pl-3 pr-3 disabled">Final</a>
                                    @else
                                        <a href="#"
                                            class="btn btn-primary float-right pl-3 pr-3 disabled">Final</a>
                                    @endif
                                    <button id="confirm_action" onclick="BTOFF()"
                                        class="btn btn-primary float-right pl-3 pr-3 mr-2 " disabled>
                                        Received</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('inventory.receiving_report_details_list')


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

        {{-- //Product --}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('select[name="cbo_product_group"]').on('change', function() {
                    var cbo_product_group = $(this).val();
                    if (cbo_product_group) {
                        $.ajax({
                            url: "{{ url('/get/inventory/product_sub_group/') }}/" +
                                cbo_product_group +
                                '/' + "{{ $grr_master_recived->indent_no }}" +
                                "/{{ $grr_master_recived->grr_no }}/" +
                                "{{ $grr_master_recived->company_id }}",
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                var d = $('select[name="cbo_product_sub_group"]').empty();
                                $('select[name="cbo_product_sub_group"]').append(
                                    '<option value="0">-Select Product Sub Group-</option>');
                                $.each(data, function(key, value) {
                                    $('select[name="cbo_product_sub_group"]').append(
                                        '<option value="' + value.pg_sub_id + '">' +
                                        value.pg_sub_name + '</option>');
                                });
                            },
                        });

                    } else {
                        $('select[name="cbo_product_sub_group"]').empty();
                        $('#txt_unit2').empty();
                        $('txt_indent_qty').empty();
                        $('txt_Remarks').empty();
                        $('txt_pre_rr_qty').empty();
                        $('txt_rr_qty').empty();
                    }

                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('select[name="cbo_product_sub_group"]').on('change', function() {
                    var cbo_product_sub_group = $(this).val();
                    if (cbo_product_sub_group) {
                        $.ajax({
                            url: "{{ url('/get/inventory/product/') }}/" + cbo_product_sub_group +
                                '/' +
                                "{{ $grr_master_recived->indent_no }}" + '/' +
                                "{{ $grr_master_recived->grr_no }}/" +
                                "{{ $grr_master_recived->company_id }}",
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="cbo_product"]').empty();
                                $('select[name="cbo_product"]').append(
                                    '<option value="0">-Select Product-</option>');
                                //
                                $.each(data, function(key, value) {
                                    $('select[name="cbo_product"]').append(
                                        '<option value="' + value.product_id + '">' +
                                        value.product_name + '</option>');
                                });
                            },
                        });

                    } else {
                        $('select[name="cbo_product"]').empty();

                    }

                });
            });
        </script>

        {{-- //Qty, Unit --}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('select[name="cbo_product"]').on('change', function() {
                    var cbo_product = $(this).val();
                    console.log(cbo_product)
                    if (cbo_product) {
                        $.ajax({
                            url: "{{ url('/get/inventory/product_unit/') }}/" + cbo_product + '/' +
                                "{{ $grr_master_recived->company_id }}",
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('#txt_unit2').empty();
                                document.getElementById("txt_unit2").value = data.unit_name;
                            },
                        });

                        $.ajax({
                            url: "{{ url('/get/inventory/indent_qty/') }}/" + cbo_product +
                                "/{{ $grr_master_recived->indent_no }}/" +
                                "{{ $grr_master_recived->company_id }}",
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                var a = $('txt_indent_qty').empty();
                                var b = $('txt_Remarks').empty();
                                var c = $('txt_pre_rr_qty').empty();
                                var d = $('txt_rr_qty').empty();
                                document.getElementById("txt_Remarks").value = data.remarks;
                                document.getElementById("txt_indent_qty").value = data.approved_qty;
                                document.getElementById("txt_pre_rr_qty").value = data.rr_qty;
                                document.getElementById("txt_rr_qty").value = data.approved_qty -
                                    data.rr_qty;
                            },
                        });

                    } else {
                        $('#txt_unit2').empty();
                        $('txt_indent_qty').empty();
                        $('txt_Remarks').empty();
                        $('txt_pre_rr_qty').empty();
                        $('txt_rr_qty').empty();
                    }

                });
            });
        </script>
    @endsection
@endsection
@endif
