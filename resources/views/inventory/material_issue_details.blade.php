@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Issue</h1>
                    @if (isset($rim_details_edit))
                        {{ $rim_details_edit->company_name }}
                    @else
                        {{ $rim_master->company_name }}
                    @endif
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @if (isset($rim_details_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm"
                                action="{{ route('req_material_issue_update', [$rim_details_edit->rid_id, $rim_details_edit->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row bg-secondary ">
                                    <div class="col-2 ">
                                        Issue No.
                                    </div>
                                    <div class="col-2">
                                        Issue Date
                                    </div>
                                    <div class="col-2">
                                        Project
                                    </div>
                                    <div class="col-2">
                                        Section
                                    </div>
                                    <div class="col-2">
                                        Requesition No.
                                    </div>
                                    <div class="col-2">
                                        Requesition Date
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" name="txt_rim_no" id="txt_rim_no"
                                            value="{{ $rim_master->rim_no }}">
                                        {{ $rim_master->rim_no }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->rim_date }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->project_name }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->section_name }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->mrm_no }}
                                        <input type="hidden" class="form-control" name="txt_Requsition_no"
                                            id="txt_Requsition_no" value="{{ $rim_master->mrm_no }}">
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->mrm_date }}
                                    </div>
                                </div>

                                <div class="row bg-primary mb-1">
                                    <div class="col-3">
                                        Product Group
                                    </div>
                                    <div class="col-3">
                                        Product Sub group
                                    </div>
                                    <div class="col-3">
                                        Product
                                    </div>
                                    <div class="col-1">
                                        Unit
                                    </div>
                                    <div class="col-2">
                                        QTY
                                    </div>
                                </div>

                                {{-- <div class="row bg-primary mb-2">
                            <div class="col-2 ">
                                Product Group
                            </div>
                            <div class="col-2">
                                Product
                            </div>
                            <div class="col-1">
                                Unit
                            </div>
                            <div class="col-2">
                                Stock Qty
                            </div>
                            <div class="col-2">
                                Requesition Qty
                            </div>
                            <div class="col-2">
                                Per. Issue Qty
                            </div>
                            <div class="col-1">
                                Issue Qty
                            </div>
                        </div> --}}


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                            <option selected>{{ $rim_details_edit->pg_name }}</option>
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option selected>{{ $rim_details_edit->pg_sub_name }}</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option selected>{{ $rim_details_edit->product_name }}</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-1">
                                        <input type="text" class="form-control" name="txt_unit_name" id="txt_unit_name"
                                            value="{{ $rim_details_edit->unit_name }}" readonly>
                                        @error('txt_unit')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_issue_qty" id="txt_issue_qty"
                                            value="{{ $rim_details_edit->product_qty }}" placeholder="Issue Qty">
                                        @error('txt_issue_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="txt_Remarks" id="txt_Remarks"
                                            value="{{ $rim_details_edit->remarks }}" placeholder="Remarks">
                                        @error('txt_Remarks')
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
                                        <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary btn-block" disabled>Update</button>
                                    </div>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="myForm"
                                action="{{ route('inventory_req_material_issue_details_store', $rim_master->company_id) }}"
                                method="post">
                                @csrf
                                <div class="row bg-secondary ">
                                    <div class="col-2 ">
                                        Issue No.
                                    </div>
                                    <div class="col-2">
                                        Issue Date
                                    </div>
                                    <div class="col-2">
                                        Project
                                    </div>
                                    <div class="col-2">
                                        Section
                                    </div>
                                    <div class="col-2">
                                        Requesition No.
                                    </div>
                                    <div class="col-2">
                                        Requesition Date
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" name="txt_rim_no" id="txt_rim_no"
                                            value="{{ $rim_master->rim_no }}">
                                        {{ $rim_master->rim_no }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->rim_date }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->project_name }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->section_name }}
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->mrm_no }}
                                        <input type="hidden" class="form-control" name="txt_Requsition_no"
                                            id="txt_Requsition_no" value="{{ $rim_master->mrm_no }}">
                                    </div>
                                    <div class="col-2">
                                        {{ $rim_master->mrm_date }}
                                    </div>
                                </div>

                                <div class="row bg-primary mb-1">
                                    <div class="col-3">
                                        Product Group
                                    </div>
                                    <div class="col-3">
                                        Product Sub group
                                    </div>
                                    <div class="col-4">
                                        Product
                                    </div>
                                    <div class="col-2">
                                        Unit
                                    </div>
                                </div>

                                {{-- <div class="row bg-primary mb-2">
                                <div class="col-2 ">
                                    Product Group
                                </div>
                                <div class="col-2">
                                    Product
                                </div>
                                <div class="col-1">
                                    Unit
                                </div>
                                <div class="col-2">
                                    Stock Qty
                                </div>
                                <div class="col-2">
                                    Requesition Qty
                                </div>
                                <div class="col-2">
                                    Per. Issue Qty
                                </div>
                                <div class="col-1">
                                    Issue Qty
                                </div>
                            </div> --}}


                                <div class="row mb-1">
                                    <div class="col-3">
                                        <select class="custom-select" id="cbo_product_group" name="cbo_product_group">
                                            <option value="0">-Select Product Group-</option>
                                            @foreach ($pro_product_group as $value)
                                                <option value="{{ $value->pg_id }}">{{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="0">-Select Product Sub Group-</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="custom-select" id="cbo_product" name="cbo_product">
                                            <option value="0">-Select Product-</option>
                                        </select>
                                        @error('cbo_product')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" readonly placeholder="Unit">
                                        @error('txt_unit')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row bg-primary mb-1">
                                    <div class="col-3">
                                        Stock Qty
                                    </div>
                                    <div class="col-3">
                                        Requesition Qty
                                    </div>
                                    <div class="col-3">
                                        Pre. Issue Qty
                                    </div>
                                    <div class="col-3">
                                        Issue Qty
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_stock_qty"
                                            id="txt_stock_qty" value="{{ old('txt_stock_qty') }}"
                                            placeholder="Stock Qty" readonly>
                                        @error('txt_stock_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_requsition_qty"
                                            id="txt_requsition_qty" value="{{ old('txt_requsition_qty') }}"
                                            placeholder="Requesition Qty" readonly>
                                        @error('txt_requsition_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_pre_issue_qty"
                                            id="txt_pre_issue_qty" value="{{ old('txt_pre_issue_qty') }}"
                                            placeholder="Pre. Issue Qty" readonly>
                                        @error('txt_pre_issue_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_issue_qty"
                                            id="txt_issue_qty" value="{{ old('txt_issue_qty') }}"
                                            placeholder="Issue Qty">
                                        @error('txt_issue_qty')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="txt_Remarks" id="txt_Remarks"
                                            value="{{ old('txt_Remarks') }}" placeholder="Remarks">
                                        @error('txt_Remarks')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="row mb-2">
                                    <div class="col-7">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-5">
                                        @php
                                            $havadata = DB::table("pro_graw_issue_details_$rim_master->company_id")
                                                ->where('rim_no', '=', $rim_master->rim_no)
                                                ->count();
                                        @endphp
                                        @if ($havadata>0)
                                            <a id="confirm_action2"
                                                href="{{ route('inventory_req_material_issue_details_final', [$rim_master->rim_no, $rim_master->company_id]) }}"
                                                onclick="BTOFF2()"
                                                class="btn btn-primary float-right pl-5 pr-5 disabled">Final</a>
                                        @else
                                            <a  class="btn btn-primary float-right pl-5 pr-5 disabled">Final</a>
                                        @endif

                                        <button id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary float-right pl-3 pr-3 mr-2 " disabled>
                                            Issue</button>
                                    </div>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('inventory.material_issue_details_list')
    @endif

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
            $('select[name="cbo_product_group"]').on('change', function() {
                var cbo_product_group = $(this).val();
                if (cbo_product_group) {
                    $.ajax({
                        url: "{{ url('/get/rim_issue/product_sub_group/') }}/" +
                            cbo_product_group +
                            '/' + "{{ $rim_master->mrm_no }}" + '/' +
                            "{{ $rim_master->rim_no }}" + "/{{ $rim_master->company_id }}",

                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // console.log(data);
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
                        url: "{{ url('/get/rim_issue/product/') }}/" + cbo_product_sub_group +
                            '/' + "{{ $rim_master->mrm_no }}" + '/' +
                            "{{ $rim_master->rim_no }}" + "/{{ $rim_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_product"]').empty();
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_product"]').on('change', function() {
                console.log('ok2')
                var cbo_product = $(this).val();
                if (cbo_product) {
                    $.ajax({
                        url: "{{ url('/get/issue/qty/details') }}/" + cbo_product + '/' +
                            "{{ $rim_master->mrm_no }}" + "/{{ $rim_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            var d = $('select[name="txt_unit_name"]').empty();
                            document.getElementById("txt_unit_name").value = data.unit_name;
                            document.getElementById("txt_requsition_qty").value = data
                                .requsition_qty;
                            document.getElementById("txt_pre_issue_qty").value = data.issue_qty;
                            document.getElementById("txt_issue_qty").value = data.total;

                        },
                    });

                    $.ajax({
                        url: "{{ url('/get/issue/total/stock') }}/" + cbo_product + '/' +
                            "{{ $rim_master->mrm_no }}" + "/{{ $rim_master->company_id }}",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            // document.getElementById("txt_stock_qty").value = data;
                            $('#txt_stock_qty').val(data);
                        },
                    });

                } else {
                    $('#txt_unit_name').empty();
                    $('#txt_requsition_qty').empty();
                    $('#txt_pre_issue_qty').empty();
                    $('#txt_issue_qty').empty();
                    $('#txt_stock_qty').empty();
                }

            });
        });
    </script>
@endsection

@endsection
