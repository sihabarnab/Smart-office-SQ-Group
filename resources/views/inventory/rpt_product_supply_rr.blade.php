@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Supplier Receving Report</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', '1')
            ->get();

    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('company_wise_list_for_supply_rr') }}" method="GET">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-4">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}">
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror

                            </div><!-- /.col -->
                            <div class="col-4">
                                <select name="cbo_supplier_id" id="cbo_supplier_id" class="form-control">
                                    <option value="">--Select Supplier--</option>

                                </select>
                                @error('cbo_supplier_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror

                            </div><!-- /.col -->
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">


                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!-- /.row -->
                        <div class="row mb-2">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                    disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @if (isset($ci_product))
        @php

            $company_id = $data['company_id'];
            $supplier_id = $data['supplier_id'];
            $check = $data['check'];
            if ($check == 1) {
                $from_date = $data['from_date'];
                $to_date = $data['to_date'];
            }

        @endphp

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Project</th>
                                        <th>RR No.<br>Date</th>
                                        <th>Indent No.<br>Date</th>
                                        <th>Challan No.<br>Date</th>
                                        <th>LC No.<br>Date</th>
                                        <th>Supplier</th>
                                        <th>Group<br>Sub<br>Product</th>
                                        <th>Indent Qty</th>
                                        <th>RR Qty</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $ttl_indent_qty = 0;
                                        $ttl_rr_qty = 0;
                                    @endphp
                                    @php

                                        if ($check == 2) {
                                            $ci_grr_details = DB::table("pro_grr_details_$company_id")
                                                ->leftJoin(
                                                    'pro_project_name',
                                                    "pro_grr_details_$company_id.project_id",
                                                    'pro_project_name.project_id',
                                                )
                                                ->leftJoin(
                                                    'pro_indent_category',
                                                    "pro_grr_details_$company_id.indent_category",
                                                    'pro_indent_category.category_id',
                                                )
                                                ->leftJoin(
                                                    "pro_supplier_information_$company_id",
                                                    "pro_grr_details_$company_id.supplier_id",
                                                    "pro_supplier_information_$company_id.supplier_id",
                                                )
                                                ->leftjoin(
                                                    "pro_product_group_$company_id",
                                                    "pro_grr_details_$company_id.pg_id",
                                                    "pro_product_group_$company_id.pg_id",
                                                )
                                                ->leftjoin(
                                                    "pro_product_sub_group_$company_id",
                                                    "pro_grr_details_$company_id.pg_sub_id",
                                                    "pro_product_sub_group_$company_id.pg_sub_id",
                                                )
                                                ->leftjoin(
                                                    "pro_product_$company_id",
                                                    "pro_grr_details_$company_id.product_id",
                                                    "pro_product_$company_id.product_id",
                                                )
                                                ->leftJoin(
                                                    'pro_units',
                                                    "pro_grr_details_$company_id.unit",
                                                    'pro_units.unit_id',
                                                )
                                                ->select(
                                                    "pro_grr_details_$company_id.*",
                                                    'pro_project_name.project_name',
                                                    'pro_indent_category.category_name',
                                                    "pro_supplier_information_$company_id.supplier_name",
                                                    "pro_supplier_information_$company_id.supplier_address",
                                                    "pro_product_group_$company_id.pg_name",
                                                    "pro_product_sub_group_$company_id.pg_sub_name",
                                                    "pro_product_$company_id.product_name",
                                                    'pro_units.unit_name',
                                                )
                                                ->where("pro_grr_details_$company_id.valid", 1)
                                                ->where("pro_grr_details_$company_id.supplier_id", $supplier_id)

                                                ->get();
                                        } else {
                                            $ci_grr_details = DB::table("pro_grr_details_$company_id")
                                                ->leftJoin(
                                                    'pro_project_name',
                                                    "pro_grr_details_$company_id.project_id",
                                                    'pro_project_name.project_id',
                                                )
                                                ->leftJoin(
                                                    'pro_indent_category',
                                                    "pro_grr_details_$company_id.indent_category",
                                                    'pro_indent_category.category_id',
                                                )
                                                ->leftJoin(
                                                    "pro_supplier_information_$company_id",
                                                    "pro_grr_details_$company_id.supplier_id",
                                                    "pro_supplier_information_$company_id.supplier_id",
                                                )
                                                ->leftjoin(
                                                    "pro_product_group_$company_id",
                                                    "pro_grr_details_$company_id.pg_id",
                                                    "pro_product_group_$company_id.pg_id",
                                                )
                                                ->leftjoin(
                                                    "pro_product_sub_group_$company_id",
                                                    "pro_grr_details_$company_id.pg_sub_id",
                                                    "pro_product_sub_group_$company_id.pg_sub_id",
                                                )
                                                ->leftjoin(
                                                    "pro_product_$company_id",
                                                    "pro_grr_details_$company_id.product_id",
                                                    "pro_product_$company_id.product_id",
                                                )
                                                ->leftJoin(
                                                    'pro_units',
                                                    "pro_grr_details_$company_id.unit",
                                                    'pro_units.unit_id',
                                                )
                                                ->select(
                                                    "pro_grr_details_$company_id.*",
                                                    'pro_project_name.project_name',
                                                    'pro_indent_category.category_name',
                                                    "pro_supplier_information_$company_id.supplier_name",
                                                    "pro_supplier_information_$company_id.supplier_address",
                                                    "pro_product_group_$company_id.pg_name",
                                                    "pro_product_sub_group_$company_id.pg_sub_name",
                                                    "pro_product_$company_id.product_name",
                                                    'pro_units.unit_name',
                                                )
                                                ->where("pro_grr_details_$company_id.valid", 1)
                                                ->where("pro_grr_details_$company_id.supplier_id", $supplier_id)
                                                ->whereBetween("pro_grr_details_$company_id.grr_date", [
                                                    $from_date,
                                                    $to_date,
                                                ])
                                                ->get();
                                        }

                                    @endphp
                                    {{-- @php
                                        $ttl_indent_qty = 0;
                                        $ttl_rr_qty = 0;
                                    @endphp --}}

                                    @foreach ($ci_grr_details as $key1 => $row_grr_details)
                                        <tr>
                                            <td>{{ $key1 + 1 }}</td>
                                            <td>{{ $row_grr_details->project_name }}</td>
                                            <td>{{ $row_grr_details->grr_no }}<br>{{ $row_grr_details->old_grr_no }}<br>{{ $row_grr_details->grr_date }}
                                            </td>
                                            <td>{{ $row_grr_details->indent_no }}<br>{{ $row_grr_details->indent_date }}<br>{{ $row_grr_details->category_name }}
                                            </td>
                                            <td>{{ $row_grr_details->chalan_no }}<br>{{ $row_grr_details->chalan_date }}
                                            </td>
                                            <td>{{ $row_grr_details->glc_no }}<br>{{ $row_grr_details->glc_date }}</td>
                                            <td>{{ $row_grr_details->supplier_name }}<br>{{ $row_grr_details->supplier_address }}
                                            </td>
                                            <td>{{ $row_grr_details->pg_name }}
                                                <hr class="m-0" color='white'>{{ $row_grr_details->pg_sub_name }}
                                                <hr class="m-0" color='white'>{{ $row_grr_details->product_name }}
                                            </td>
                                            <td>{{ $row_grr_details->indent_qty }}</td>
                                            <td>{{ $row_grr_details->received_qty }}</td>
                                            <td>{{ $row_grr_details->unit_name }}</td>
                                        </tr>
                                        @php
                                            $ttl_indent_qty = $ttl_indent_qty + $row_grr_details->indent_qty;
                                            $ttl_rr_qty = $ttl_rr_qty + $row_grr_details->received_qty;
                                        @endphp
                                    @endforeach
                                    {{-- @endforeach --}}

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">&nbsp;</td>
                                        <td style="text-align: right;">{{ 'Total' }}</td>
                                        <td style="text-align: right;">{{ $ttl_indent_qty }}</td>
                                        <td style="text-align: right;">{{ $ttl_rr_qty }}</td>
                                        <td colspan="1">&nbsp;</td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/supply_info/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_supplier_id"]').empty();
                            $('select[name="cbo_supplier_id"]').append(
                                '<option value="">--Select Supplier--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_supplier_id"]').append(
                                    '<option value="' + value.supplier_id + '">' +
                                    value.supplier_name + '<br>' + value
                                    .supplier_address + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_supplier_id"]').empty();
                }

            });
        });
    </script>
@endsection
