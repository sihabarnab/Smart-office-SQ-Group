@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Stock</h1>
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
                                    <th>Product Group</th>
                                    <th>Sub Group</th>
                                    <th>Product</th>
                                    <th>Unit</th>
                                    <th>Opening<br>{{ $txt_start_date }}</th>
                                    <th>Receive</th>
                                    <th>Issue</th>
                                    <th>Return</th>
                                    <th>Balance<br>{{ $txt_end_date }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php

                                    $ci_product_list = DB::table("pro_product_$company_id")
                                        ->leftjoin(
                                            "pro_product_group_$company_id",
                                            "pro_product_$company_id.pg_id",
                                            "pro_product_group_$company_id.pg_id",
                                        )
                                        ->leftjoin(
                                            "pro_product_sub_group_$company_id",
                                            "pro_product_$company_id.pg_sub_id",
                                            "pro_product_sub_group_$company_id.pg_sub_id",
                                        )
                                        ->leftJoin('pro_units', "pro_product_$company_id.unit", 'pro_units.unit_id')
                                        ->select(
                                            "pro_product_$company_id.*",
                                            "pro_product_group_$company_id.pg_name",
                                            "pro_product_sub_group_$company_id.pg_sub_name",
                                            'pro_units.unit_name',
                                        )
                                        ->where("pro_product_$company_id.product_category", 1)
                                        ->where("pro_product_$company_id.valid", 1)
                                        ->get();
                                @endphp
                                @foreach ($ci_product_list as $key => $row_product_list)
                                    @php
                                        $table_name =
                                            'pro_stock_closing_' . "$closing_year$closing_month" . "_$company_id";

                                        // $ci_stock_closing  = DB::table("pro_stock_closing_$company_id")
                                        $ci_stock_closing = DB::table("$table_name")
                                            ->where('product_id', $row_product_list->product_id)
                                            ->where('year', $closing_year)
                                            ->where('month', $closing_month)
                                            ->sum('qty');

                                        if ($ci_stock_closing === null) {
                                            $txt_clossing_stock = '0.0000';
                                        } else {
                                            $txt_clossing_stock = round($ci_stock_closing, 4);
                                        }

                                        $ci_grr_details = DB::table("pro_grr_details_$company_id")
                                            ->where('product_id', $row_product_list->product_id)
                                            ->whereBetween('grr_date', [$txt_start_date, $txt_end_date])
                                            ->sum('received_qty');

                                        if ($ci_grr_details === null) {
                                            $txt_rr_qty = '0.0000';
                                        } else {
                                            $txt_rr_qty = "$ci_grr_details";
                                        }

                                        $ci_graw_issue_details = DB::table("pro_graw_issue_details_$company_id")
                                            ->where('product_id', $row_product_list->product_id)
                                            ->whereBetween('rim_date', [$txt_start_date, $txt_end_date])
                                            ->sum('product_qty');

                                        if ($ci_graw_issue_details === null) {
                                            $txt_issue_qty = '0.0000';
                                        } else {
                                            $txt_issue_qty = "$ci_graw_issue_details";
                                        }

                                        $ci_gmaterial_return_details = DB::table(
                                            "pro_gmaterial_return_details_$company_id",
                                        )
                                            ->where('product_id', $row_product_list->product_id)
                                            ->whereBetween('return_date', [$txt_start_date, $txt_end_date])
                                            ->sum('useable_qty');

                                        if ($ci_gmaterial_return_details === null) {
                                            $txt_return_qty = '0.0000';
                                        } else {
                                            $txt_return_qty = "$ci_gmaterial_return_details";
                                        }

                                        $txt1_bal_qty =
                                            $txt_clossing_stock + $txt_rr_qty + $txt_return_qty - $txt_issue_qty;
                                        $txt_bal_qty = number_format($txt1_bal_qty, 4);

                                    @endphp


                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row_product_list->pg_name }}</td>
                                        <td>{{ $row_product_list->pg_sub_name }}</td>
                                        <td>{{ $row_product_list->product_name }}</td>
                                        <td>{{ $row_product_list->unit_name }}</td>
                                        <td>{{ $txt_clossing_stock }}</td>
                                        <td>{{ $txt_rr_qty }}</td>
                                        <td>{{ $txt_issue_qty }}</td>
                                        <td>{{ $txt_return_qty }}</td>
                                        <td>{{ $txt_bal_qty }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
