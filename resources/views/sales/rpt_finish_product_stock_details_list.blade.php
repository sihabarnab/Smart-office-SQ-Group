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


    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rpt_finish_product_stock_details_list') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ $value->company_id == $company_id ? 'selected' : '' }}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{ $m_transformer == '28' ? 'selected' : '' }}>
                                        TRANSFORMER
                                    </option>
                                    <option value="33" {{ $m_transformer == '33' ? 'selected' : '' }}>CTPT
                                    </option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ $form }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ $to }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div><!-- /.row -->

                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>




    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $form }} TO {{ $to }}</h4>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product</th>
                                    <th class="text-right">Opening Stock <br> {{ $form }}</th>
                                    <th class="text-right">Production</th>
                                    <th class="text-right">Sales</th>
                                    <th class="text-right">Return</th>
                                    <th class="text-right">Balance</th>
                                    <th class="text-center">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_stock = 0;
                                    $opening_balance = 0;
                                    $production = 0;
                                    $sales = 0;
                                    $return = 0;
                                @endphp
                                @foreach ($m_finish_product as $key => $row)
                                    @php

                                        $m_month = date('m', strtotime($form));
                                        $m_year = date('Y', strtotime($form));
                                        $txt_start_date = $m_year . '-' . $m_month . '-01';
                                        $txt_end_date = date('Y-m-d', strtotime($form . ' -1 day'));

                                        //previous balance
                                        $previous_month_opening_balance = DB::table("$fpsd_previous_month_table")
                                            ->where('product_id', $row->product_id)
                                            ->where('company_id', $company_id)
                                            ->where('valid', 1)
                                            ->sum('qty');

                                        //sales
                                        $sales_01 = DB::table("pro_sid_$company_id")
                                            ->where('product_id', $row->product_id)
                                            ->where('company_id', $company_id)
                                            ->whereBetween('sim_date', [$txt_start_date, $txt_end_date])
                                            ->sum('qty');

                                        //production
                                        $production_01 = DB::table("pro_fpsd_$company_id")
                                            ->where('product_id', $row->product_id)
                                            ->where('company_id', $company_id)
                                            ->whereBetween('fpsm_date', [$txt_start_date, $txt_end_date])
                                            ->sum('qty');

                                        //return
                                        $return_01 = DB::table("pro_return_invoice_details_$company_id")
                                            ->where('product_id', $row->product_id)
                                            ->where('company_id', $company_id)
                                            ->whereBetween('rsim_date', [$txt_start_date, $txt_end_date])
                                            ->where('valid', 1)
                                            ->sum('return_qty');
                                        //
                                        $opening_balance =
                                            ($previous_month_opening_balance + $production_01 + $return_01) - $sales_01;

                                        //*************************End opening balance *******************************

                                        //sales
                                        $sales = DB::table("pro_sid_$company_id")
                                            ->where('product_id', $row->product_id)
                                            ->whereBetween('sim_date', [$form, $to])
                                            ->sum('qty');

                                        //production
                                        $production = DB::table("pro_fpsd_$company_id")
                                            ->where('product_id', $row->product_id)
                                            ->whereBetween('fpsm_date', [$form, $to])
                                            ->sum('qty');

                                        //return
                                        $return = DB::table("pro_return_invoice_details_$company_id")
                                            ->where('product_id', $row->product_id)
                                            ->whereBetween('rsim_date', [$form, $to])
                                            ->where('valid', 1)
                                            ->sum('return_qty');

                                        $total_stock = $opening_balance + $production + $return - $sales;

                                        //

                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td class="text-right">{{ number_format($opening_balance,2) }}</td>
                                        <td class="text-right">{{ number_format($production,2) }}</td>
                                        <td class="text-right">{{ number_format($sales,2) }}</td>
                                        <td class="text-right">{{ number_format($return,2) }}</td>
                                        <td class="text-right">{{ number_format($total_stock,2) }}</td>
                                        <td class="text-center"><a target="_blank"
                                                href="{{ route('rpt_finish_product_stock_more_details', [$company_id, $row->product_id, $form, $to]) }}">Details</a>
                                        </td>
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
