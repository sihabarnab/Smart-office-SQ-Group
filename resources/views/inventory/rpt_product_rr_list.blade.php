@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">PRODUCT RR</h1>
                    @php
                        $company = DB::table('pro_company')->where('company_id', $company_id)->first();
                    @endphp
                    {{ $company->company_name }}
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
                                @foreach ($ci_product as $key => $row_product)
                                    @php

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
                                            ->leftJoin(
                                                "pro_product_group_$company_id",
                                                "pro_grr_details_$company_id.pg_id",
                                                "pro_product_group_$company_id.pg_id",
                                            )
                                            ->leftJoin(
                                                "pro_product_sub_group_$company_id",
                                                "pro_grr_details_$company_id.pg_sub_id",
                                                "pro_product_sub_group_$company_id.pg_sub_id",
                                            )
                                            ->leftJoin(
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
                                            ->where("pro_grr_details_$company_id.product_id", $row_product->product_id)
                                            ->where("pro_grr_details_$company_id.valid", 1)
                                            ->whereBetween("pro_grr_details_$company_id.grr_date", [
                                                $m_from_date,
                                                $m_to_date,
                                            ])
                                            ->get();

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
                                @endforeach

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
@endsection
