@extends('layouts.purchase_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($pro_indent_detail_edit))
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>

                            <form id="myForm"
                                action="{{ route('purchase_indent_update2', [$pro_indent_detail_edit->indent_details_id, $pro_indent_detail_edit->company_id]) }}"
                                method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" readonly class="form-control"
                                            value="{{ $pro_indent_detail_edit->company_name }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="txt_indent_no" id="txt_indent_no" readonly
                                            class="form-control" value="{{ $pro_indent_detail_edit->indent_no }}">
                                        @error('txt_indent_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" readonly class="form-control"
                                            value="{{ $pro_indent_detail_edit->project_name }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" readonly class="form-control"
                                            value="{{ $pro_indent_detail_edit->category_name }}">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select name="cbo_product_group" id="cbo_product_group" class="form-control">
                                            <option value="">--Select Product Group--</option>
                                            @foreach ($pro_product_group as $value)
                                                <option value="{{ $value->pg_id }}"
                                                    {{ $value->pg_id == $pro_indent_detail_edit->pg_id ? 'selected' : '' }}>
                                                    {{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="{{ $pro_indent_detail_edit->pg_sub_id }}">
                                                {{ $pro_indent_detail_edit->pg_sub_name }}</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_product" id="cbo_product" class="form-control">
                                            <option value="{{ $pro_indent_detail_edit->product_id }}">
                                                {{ $pro_indent_detail_edit->product_name }}</option>

                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @php
                                        $unit = DB::table('pro_units')
                                            ->where('unit_id', '=', $pro_indent_detail_edit->product_unit)
                                            ->first();
                                    @endphp
                                    <div class="col-1">
                                        <input type="hidden" name="txt_unit_id" id="txt_unit_id" readonly
                                            value="{{ $pro_indent_detail_edit->product_unit }}">
                                        <input type="text" class="form-control" name="txt_unit_name" id="txt_unit_name"
                                            value="{{ $unit == null ? '' : $unit->unit_name }}" placeholder="Unit"
                                            readonly>
                                        @error('txt_unit_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" name="txt_product_description" id="txt_product_description"
                                            class="form-control" placeholder="Product Description"
                                            value="{{ $pro_indent_detail_edit->description }}">
                                        @error('txt_product_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" name="txt_remarks" id="txt_remarks" class="form-control"
                                            placeholder="Remarks" value="{{ $pro_indent_detail_edit->remarks }}">
                                        @error('txt_remarks')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select name="cbo_section" id="cbo_section" class="form-control">
                                            <option value="">--Select Section--</option>
                                            @foreach ($pro_section_information as $value)
                                                <option value="{{ $value->section_id }}"
                                                    {{ $value->section_id == $pro_indent_detail_edit->section_id ? 'selected' : '' }}>
                                                    {{ $value->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_section')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" name="txt_product_quanity" id="txt_product_quanity"
                                            class="form-control" placeholder="Product Quantity"
                                            value="{{ $pro_indent_detail_edit->qty }}">
                                        @error('txt_product_quanity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_req_date" name="txt_req_date"
                                            placeholder="Product Require Date"
                                            value="{{ $pro_indent_detail_edit->req_date }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_req_date')
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
                                            class="btn btn-primary btn-block" disabled>Update</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('script')
            <script type="text/javascript">
                $(document).ready(function() {
                    $('select[name="cbo_product_group"]').on('change', function() {
                        var cbo_product_group = $(this).val();
                        if (cbo_product_group) {

                            $.ajax({
                                url: "{{ url('/get/purchase/indent_product_sub_group') }}/" +
                                    cbo_product_group + '/' +
                                    "{{ $pro_indent_detail_edit->indent_no }}/" +
                                    "{{ $pro_indent_detail_edit->company_id }}",
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product_sub_group"]').empty();
                                    $('select[name="cbo_product_sub_group"]').append(
                                        '<option value="0">--Select Product--</option>');
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
                                url: "{{ url('/get/purchase/indent_product') }}/" + cbo_product_sub_group +
                                    '/' +
                                    "{{ $pro_indent_detail_edit->indent_no }}/" +
                                    "{{ $pro_indent_detail_edit->company_id }}",
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product"]').empty();
                                    $('select[name="cbo_product"]').append(
                                        '<option value="0">--Select Product--</option>');
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
                        $('#txt_unit_id').empty();
                        $('#txt_unit_name').empty();
                        // $('#txt_req_qty').empty();
                        // $('#txt_product_remarks').empty();
                        var cbo_product = $(this).val();
                        var cbo_company_id = "{{ $pro_indent_detail_edit->company_id }}";
                        if (cbo_product && cbo_company_id) {
                            $.ajax({
                                url: "{{ url('/get/purchase/unit/') }}/" +
                                    cbo_product + '/' + cbo_company_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('#txt_unit_id').val(data.unit);
                                    $('#txt_unit_name').val(data.unit_name);
                                    // $('#txt_req_qty').val(data.reorder_qty);
                                    // $('#txt_product_remarks').val(data.product_description);
                                },
                            });

                        } else {
                            $('#txt_unit_id').val('');
                            $('#txt_unit_name').val('');
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
    @elseif (isset($pro_indent_detail_all))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id='myForm' action="{{ route('purchase_indent_add_another') }}" method="post">
                                @csrf
                                <input type="hidden" name="txt_id" value="{{ $pro_indent_master->company_id }}"
                                    readonly>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" readonly class="form-control"
                                            value="{{ $pro_indent_master->company_name }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="txt_indent_no" id="txt_indent_no" readonly
                                            class="form-control" value="{{ $pro_indent_master->indent_no }}">
                                        @error('txt_indent_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" name="cbo_project_id"
                                            value="{{ $pro_indent_master->project_id }}">
                                        <input type="text" readonly class="form-control" name="cbo_project_name"
                                            id="cbo_project_name" value="{{ $pro_indent_master->project_name }}">
                                        @error('cbo_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="hidden" readonly class="form-control" name="cbo_indent_category"
                                            id="cbo_indent_category" value="{{ $pro_indent_master->indent_category }}">
                                        <input type="text" readonly class="form-control"
                                            value="{{ $pro_indent_master->category_name }}">
                                        @error('cbo_indent_category')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select name="cbo_product_group" id="cbo_product_group" class="form-control">
                                            <option value="">--Select Product Group--</option>
                                            @foreach ($pro_product_group as $value)
                                                <option value="{{ $value->pg_id }}">
                                                    {{ $value->pg_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_product_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="0">--Select Product Sub Group--</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_product" id="cbo_product" class="form-control">
                                            <option value="0">--Select Product--</option>

                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="hidden" name="txt_unit_id" id="txt_unit_id" readonly>
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" value="{{ old('txt_unit_name') }}" placeholder="Unit"
                                            readonly>
                                        @error('txt_unit_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" name="txt_product_description" id="txt_product_description"
                                            class="form-control" placeholder="Product Description"
                                            value="{{ old('txt_product_description') }}">
                                        @error('txt_product_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" name="txt_remarks" id="txt_remarks" class="form-control"
                                            placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                        @error('txt_remarks')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select name="cbo_section" id="cbo_section" class="form-control">
                                            <option value="">--Select Section--</option>
                                            @foreach ($pro_section_information as $value)
                                                <option value="{{ $value->section_id }}">
                                                    {{ $value->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_section')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" name="txt_product_quanity" id="txt_product_quanity"
                                            class="form-control" placeholder="Product Quantity"
                                            value="{{ old('txt_product_quanity') }}">
                                        @error('txt_product_quanity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_req_date" name="txt_req_date"
                                            placeholder="Product Require Date" value="{{ old('txt_req_date') }}"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_req_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-7">
                                        <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                        <label for="AYC">Are you Confirm</label>
                                    </div>
                                    <div class="col-5">
                                        <a id="confirm_action2"
                                            href="{{ route('purchase_indent_final', [$pro_indent_master->indent_no, $pro_indent_master->company_id]) }}"
                                            onclick="BTOFF2()"
                                            class="btn btn-primary float-right pl-5 pr-5 disabled">Final</a>

                                        <button id="confirm_action" onclick="BTOFF()"
                                            class="btn btn-primary float-right pl-3 pr-3 mr-2 " disabled>Add
                                            Another</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- indent list --}}
        @include('purchase.indent_info_list')

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
                    $('select[name="cbo_product_group"]').on('change', function() {
                        var cbo_product_group = $(this).val();
                        if (cbo_product_group) {

                            $.ajax({
                                url: "{{ url('/get/purchase/indent_product_sub_group') }}/" +
                                    cbo_product_group + '/' +
                                    "{{ $pro_indent_master->indent_no }}/" +
                                    "{{ $pro_indent_master->company_id }}",
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product_sub_group"]').empty();
                                    $('select[name="cbo_product_sub_group"]').append(
                                        '<option value="">--Select Product--</option>');
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
                                url: "{{ url('/get/purchase/indent_product') }}/" + cbo_product_sub_group +
                                    '/' + "{{ $pro_indent_master->indent_no }}/" +
                                    "{{ $pro_indent_master->company_id }}",
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product"]').empty();
                                    $('select[name="cbo_product"]').append(
                                        '<option value="">--Select Product--</option>');
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
                        $('#txt_unit_id').empty();
                        $('#txt_unit_name').empty();
                        // $('#txt_req_qty').empty();
                        // $('#txt_product_remarks').empty();
                        var cbo_product = $(this).val();
                        var cbo_company_id = "{{ $pro_indent_master->company_id }}";
                        if (cbo_product && cbo_company_id) {
                            $.ajax({
                                url: "{{ url('/get/purchase/unit/') }}/" +
                                    cbo_product + '/' + cbo_company_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('#txt_unit_id').val(data.unit);
                                    $('#txt_unit_name').val(data.unit_name);
                                    // $('#txt_req_qty').val(data.reorder_qty);
                                    // $('#txt_product_remarks').val(data.product_description);
                                },
                            });

                        } else {
                            $('#txt_unit_id').empty();
                            $('#txt_unit_name').empty();
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
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form id="myForm" action="{{ route('purchase_indent_store') }}" method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                            <option value="0">--Select Company--</option>
                                            @foreach ($user_company as $value)
                                                <option value="{{ $value->company_id }}">
                                                    {{ $value->company_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_project_name" id="cbo_project_name" class="form-control">
                                            <option value="0">--Select Project--</option>
                                            @foreach ($pro_project_name as $value)
                                                <option value="{{ $value->project_id }}">{{ $value->project_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_project_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_indent_category" id="cbo_indent_category" class="form-control">
                                            <option value="0">--Select Indent Category--</option>
                                            @foreach ($pro_indent_category as $value)
                                                <option value="{{ $value->category_id }}">{{ $value->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_indent_category')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select name="cbo_product_group" id="cbo_product_group" class="form-control ">
                                            <option value="">--Select Product Group--</option>

                                        </select>
                                        @error('cbo_product_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_product_sub_group" id="cbo_product_sub_group"
                                            class="form-control ">
                                            <option value="0">--Select Product Sub Group--</option>
                                        </select>
                                        @error('cbo_product_sub_group')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="cbo_product" id="cbo_product" class="form-control ">
                                            <option value="0">--Select Product--</option>

                                        </select>
                                        @error('cbo_product')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="hidden" name="txt_unit_id" id="txt_unit_id" readonly>
                                        <input type="text" class="form-control" name="txt_unit_name"
                                            id="txt_unit_name" value="{{ old('txt_unit_name') }}" placeholder="Unit"
                                            readonly>
                                        @error('txt_unit_id')
                                            <span class="text-warning">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" name="txt_product_description" id="txt_product_description"
                                            class="form-control" placeholder="Product Description"
                                            value="{{ old('txt_product_description') }}">
                                        @error('txt_product_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" name="txt_remarks" id="txt_remarks" class="form-control"
                                            placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                        @error('txt_remarks')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select name="cbo_section" id="cbo_section" class="form-control">
                                            <option value="0">--Select Section--</option>
                                            @foreach ($pro_section_information as $value)
                                                <option value="{{ $value->section_id }}">{{ $value->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_section')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" name="txt_product_quanity" id="txt_product_quanity"
                                            class="form-control" placeholder="Product Quantity"
                                            value="{{ old('txt_product_quanity') }}">
                                        @error('txt_product_quanity')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_req_date" name="txt_req_date"
                                            placeholder="Product Require Date" value="{{ old('txt_req_date') }}"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_req_date')
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
                                            class="btn btn-primary btn-block" disabled>Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- indent list --}}
        @include('purchase.indent_info_list_not_final')

        @section('script')
            <script type="text/javascript">
                $(document).ready(function() {
                    $('select[name="cbo_company_id"]').on('change', function() {
                        var cbo_company_id = $(this).val();
                        if (cbo_company_id) {
                            $.ajax({
                                url: "{{ url('/get/purchase/product_group/') }}/" + cbo_company_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product_group"]').empty();
                                    $('select[name="cbo_product_group"]').append(
                                        '<option value="">--Select Product Group--</option>');
                                    $.each(data, function(key, value) {
                                        $('select[name="cbo_product_group"]').append(
                                            '<option value="' + value.pg_id + '">' +
                                            value.pg_name + '</option>');
                                    });
                                },
                            });

                        } else {
                            $('select[name="cbo_product_group"]').empty();
                        }

                    });
                });
            </script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('select[name="cbo_product_group"]').on('change', function() {
                        var cbo_product_group = $(this).val();
                        var cbo_company_id = $('#cbo_company_id').val();
                        if (cbo_product_group && cbo_company_id) {
                            $.ajax({
                                url: "{{ url('/get/purchase/product_sub_group/') }}/" +
                                    cbo_product_group + '/' + cbo_company_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product_sub_group"]').empty();
                                    $('select[name="cbo_product_sub_group"]').append(
                                        '<option value="">--Select Product Sub Group--</option>');
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
                        var cbo_company_id = $('#cbo_company_id').val();
                        if (cbo_product_sub_group && cbo_company_id) {
                            $.ajax({
                                url: "{{ url('/get/purchase/product') }}/" + cbo_product_sub_group + '/' +
                                    cbo_company_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('select[name="cbo_product"]').empty();
                                    $('select[name="cbo_product"]').append(
                                        '<option value="0">--Select Product--</option>');
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
                        $('#txt_unit_id').empty();
                        $('#txt_unit_name').empty();
                        // $('#txt_req_qty').empty();
                        // $('#txt_product_remarks').empty();
                        var cbo_product = $(this).val();
                        var cbo_company_id = $('#cbo_company_id').val();
                        if (cbo_product && cbo_company_id) {
                            $.ajax({
                                url: "{{ url('/get/purchase/unit/') }}/" +
                                    cbo_product + "/" + cbo_company_id,
                                type: "GET",
                                dataType: "json",
                                success: function(data) {
                                    $('#txt_unit_id').val(data.unit);
                                    $('#txt_unit_name').val(data.unit_name);
                                    // $('#txt_req_qty').val(data.reorder_qty);
                                    // $('#txt_product_remarks').val(data.product_description);
                                },
                            });

                        } else {
                            $('#txt_unit_id').val('');
                            $('#txt_unit_name').val('');
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
    @endif
@endsection
