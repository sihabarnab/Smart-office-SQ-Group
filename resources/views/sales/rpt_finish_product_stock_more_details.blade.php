@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Finish Product Stock Details</h1>
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th colspan="6">{{ $m_finish_product->product_name }}</th>

                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <th>Opening</th>
                                    <th>Production</th>
                                    <th>Sales </th>
                                    <th>Return </th>
                                    <th>Balance </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_stock = 0;
                                    $all_qty = 0;

                                @endphp
                                @foreach ($data as $value)
                                    @php
                                        $m_month = date('m', strtotime($value));
                                        $m_year = date('Y', strtotime($value));
                                        $txt_start_date = $m_year . '-' . $m_month . '-01';
                                        $txt_value_date = date('Y-m-d', strtotime($value . ' -1 day'));

                                        //previous month and year
                                        if ($m_month == '01') {
                                            $closing_year = $m_year - 1;
                                            $closing_month = '12';
                                        } elseif ($m_month > '01') {
                                            $closing_year = $m_year;
                                            $closing_month = str_pad(($m_month - 1), 2, '0', STR_PAD_LEFT);
                                        }

                                        //table
                                        if ($m_month) {
                                            $fpsd_previous_month_table = 'pro_fpcs_' . "$closing_year$closing_month"."_$company_id";
                                        }
                                        
                                        //opening balance
                                        $previous_month_opening_balance = DB::table("$fpsd_previous_month_table")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->where('valid', 1)
                                            ->sum('qty');

                                        //sales
                                        $sales_01 = DB::table("pro_sid_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->whereBetween('sim_date', [$txt_start_date, $txt_value_date])
                                            ->sum('qty');

                                        //production
                                        $production_01 = DB::table("pro_fpsd_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->whereBetween('fpsm_date', [$txt_start_date, $txt_value_date])
                                            ->sum('qty');

                                        //return
                                        $return_01 = DB::table("pro_return_invoice_details_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->whereBetween('rsim_date', [$txt_start_date, $txt_value_date])
                                            ->where('valid', 1)
                                            ->sum('return_qty');
                                        //
                                        $opening_balance =
                                            $previous_month_opening_balance + $production_01 + $return_01 - $sales_01;

                                        //********************************************************



                                        //sales
                                        $sales = DB::table("pro_sid_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->where('sim_date', $value)
                                            ->sum('qty');

                                        //production
                                        $production = DB::table("pro_fpsd_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->where('fpsm_date', $value)
                                            ->sum('qty');

                                        //return
                                        $return = DB::table("pro_return_invoice_details_$company_id")
                                            ->where('company_id', $company_id)
                                            ->where('product_id', $m_finish_product->product_id)
                                            ->where('rsim_date', $value)
                                            ->where('valid', 1)
                                            ->sum('return_qty');

                                        //total
                                        $total_stock = $opening_balance + $production + $return - $sales;
                                        $all_qty = $total_stock;

                                        //

                                    @endphp
                                    <tr>
                                        <td>{{ $value }}</td>
                                        <td class="text-right">{{ number_format($opening_balance, 2) }}</td>
                                        <td class="text-right">{{ number_format($production, 2) }}</td>
                                        <td class="text-right">{{ number_format($sales, 2) }}</td>
                                        <td class="text-right">{{ number_format($return, 2) }}</td>
                                        <td class="text-right">{{ number_format($total_stock, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="5">Total</td>
                                    <td class="text-right" colspan="1">{{ number_format($all_qty, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
