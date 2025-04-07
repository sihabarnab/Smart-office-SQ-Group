@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Accounts Receivable</h1>
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
                    <form action="{{ route('rpt_acc_ledger_list') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-4">
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
                            </div><!-- /.col -->
                            <div class="col-4">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{ $m_transformer == '28' ? 'selected' : '' }}>TRANSFORMER
                                    </option>
                                    <option value="33" {{ $m_transformer == '33' ? 'selected' : '' }}>CTPT</option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_type_id" id="cbo_customer_type_id">
                                    <option value="">--Search--</option>
                                    @foreach ($customer_type as $value)
                                        <option
                                            value="{{ $value->customer_type_id }}"{{ $value->customer_type_id == $m_customer_type_id ? 'selected' : '' }}>
                                            {{ $value->customer_type }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_customer_type_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!-- /.row -->

                        <div class="row mb-1">
                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ $form }}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ $to }}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4"></div>
                            <div class="col-2">
                                <button type="Submit" id="save_event" class="btn btn-primary btn-block">Search</button>
                            </div>
                        </div>
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
                        <table id="" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="100" class="text-center"><strong>SL No</strong></td>
                                    <td width="350" class="text-left"><strong>Particulars</strong></td>
                                    <td width="150" class="text-right"><strong>Opening Balance</strong></td>
                                    <td width="150" class="text-right"><strong>Debit</strong></td>
                                    <td width="150" class="text-right"><strong>Credit</strong></td>
                                    <td width="150" class="text-right"><strong>Closing Balance</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $m_total_sales = 0;
                                    $m_total_collection = 0;
                                    $m_balance = 0;
                                    $add_opening = 0;
                                    $add_sales = 0;
                                    $add_collection = 0;
                                    $add_balance = 0;
                                    //
                                    $m_total_sales_01=0;
                                    $m_total_collection_01=0;
                                    $i = 1;
                                @endphp
                                @foreach ($m_customer as $key => $row)
                                    @php

                                        if ($form && $to) {
                                            $m_ob_01 = DB::table("pro_cust_balance_$company_id")
                                                ->select('amount')
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->first();
                                            $m_opening_balance_01 =$m_ob_01 == null? 0 : $m_ob_01->amount;

                                            //sales invoice
                                            $m_sim_balance_01 = DB::table("pro_sim_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('sim_date', '<', $form)
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('sinv_total');

                                            $m_sim_discount_01 = DB::table("pro_sim_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('sim_date', '<', $form)
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('discount_amount');

                                            //money receipt
                                            $m_mr_balance_01 = DB::table("pro_money_receipt_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('collection_date', '<', $form)
                                                ->where('status', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('mr_amount');

                                            //Debit voucher
                                            $m_debit_voucher_01 = DB::table("pro_debit_voucher_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('debit_voucher_date', '<', $form)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('amount');

                                            //Return Invoice
                                            $m_rsinv_balance1_01= DB::table("pro_return_invoice_details_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('rsim_date', '<', $form)
                                                ->where('pg_id', $m_transformer)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('net_payble');

                                            //Return Invoice
                                            $m_rid_balance_01 = DB::table("pro_repair_invoice_details_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('reinvm_date', '<', $form)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('total');
                                           //***************************************

                                           //sales invoice
                                            $m_sim_balance = DB::table("pro_sim_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->whereBetween("sim_date", [$form, $to])
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('sinv_total');

                                            $m_sim_discount = DB::table("pro_sim_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->whereBetween("sim_date", [$form, $to])
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('discount_amount');

                                            //money receipt
                                            $m_mr_balance = DB::table("pro_money_receipt_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->whereBetween("collection_date", [$form, $to])
                                                ->where('status', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('mr_amount');

                                            //Debit voucher
                                            $m_debit_voucher = DB::table("pro_debit_voucher_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->whereBetween("debit_voucher_date", [$form, $to])
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('amount');

                                            //Return Invoice
                                            $m_rsinv_balance1= DB::table("pro_return_invoice_details_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->whereBetween("rsim_date", [$form, $to])
                                                ->where('pg_id', $m_transformer)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('net_payble');

                                            //Return Invoice
                                            $m_rid_balance = DB::table("pro_repair_invoice_details_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->whereBetween("reinvm_date", [$form, $to])
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('total');

                                            //les then (<) form date
                                            $m_total_sales_01=$m_sim_balance_01+$m_rid_balance_01-$m_sim_discount_01-$m_rsinv_balance1_01;
                                            $m_total_collection_01=$m_mr_balance_01-$m_debit_voucher_01;
                                            $m_opening_balance=$m_opening_balance_01+$m_total_sales_01-$m_total_collection_01;
                                            
                                            //(form between to) date
                                            $m_total_sales=$m_sim_balance+$m_rid_balance-$m_sim_discount-$m_rsinv_balance1;
                                            $m_total_collection=$m_mr_balance-$m_debit_voucher;
                                            $m_balance=$m_opening_balance+$m_total_sales-$m_total_collection;
                                            
                                            //total
                                            $add_opening=$add_opening+$m_opening_balance;
                                            $add_sales=$add_sales+$m_total_sales;
                                            $add_collection=$add_collection+$m_total_collection;
                                            $add_balance=$add_balance+$m_balance;

                                            
                                        } else {
                                            $m_ob = DB::table("pro_cust_balance_$company_id")
                                                ->select('amount')
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->first();
                                                $m_opening_balance = $m_ob == null? 0: $m_ob->amount;

                                            //sales invoice
                                            $m_sim_balance = DB::table("pro_sim_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('sinv_total');

                                            $m_sim_discount = DB::table("pro_sim_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('valid', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('discount_amount');

                                            //money receipt
                                            $m_mr_balance = DB::table("pro_money_receipt_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->where('status', 1)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('mr_amount');

                                            //Debit voucher
                                            $m_debit_voucher = DB::table("pro_debit_voucher_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('amount');

                                            //Return Invoice
                                            $m_rsinv_balance1 = DB::table("pro_return_invoice_details_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->where('pg_id', $m_transformer)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('net_payble');

                                            //Return Invoice
                                            $m_rid_balance = DB::table("pro_repair_invoice_details_$company_id")
                                                ->where('customer_id', $row->customer_id)
                                                ->orderBy('customer_id', 'asc')
                                                ->sum('total');

                                            // without date
                                            $m_total_sales =
                                                $m_sim_balance + $m_rid_balance - $m_sim_discount - $m_rsinv_balance1;

                                            $m_total_collection = $m_mr_balance - $m_debit_voucher;
                                            $m_balance = $m_opening_balance + $m_total_sales - $m_total_collection;

                                            //total
                                            $add_opening = $add_opening + $m_opening_balance;
                                            $add_sales = $add_sales + $m_total_sales;
                                            $add_collection = $add_collection + $m_total_collection;
                                            $add_balance = $add_balance + $m_balance;
                                        }

                                    @endphp

                                  @if ($m_opening_balance!=0 || $m_sim_balance!=0 || $m_sim_discount!=0 || $m_rsinv_balance1!=0 || $m_rid_balance!=0 || $m_balance!=0)
                                    <tr>
                                        <td class="text-center">{{ $i++}}</td>
                                        <td class="text-left">{{ $row->customer_name }}</td>
                                        <td class="text-right">{{ numberFormat($m_opening_balance, 2) }}</td>
                                        <td class="text-right">{{ numberFormat($m_total_sales, 2) }}</td>
                                        <td class="text-right">{{ numberFormat($m_total_collection, 2) }}</td>
                                        <td class="text-right">{{ numberFormat($m_balance, 2) }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right"></td>
                                    <td colspan="1" class="text-right">{{ numberFormat($add_opening, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ numberFormat($add_sales, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ numberFormat($add_collection, 2) }}</td>
                                    <td colspan="1" class="text-right">{{ numberFormat($add_balance, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        //Number Formate
        function numberFormat($number, $decimals = 0)
        {
            // desimal (.) dat part
            if (strpos($number, '.') != null) {
                $decimalNumbers = substr($number, strpos($number, '.'));
                $decimalNumbers = substr($decimalNumbers, 1, $decimals);
            } else {
                $decimalNumbers = 0;
                for ($i = 2; $i <= $decimals; $i++) {
                    $decimalNumbers = $decimalNumbers . '0';
                }
            }
            // echo $decimalNumbers;
            $number = (int) $number;
            // reverse
            $number = strrev($number);
            $n = '';
            $stringlength = strlen($number);
            for ($i = 0; $i < $stringlength; $i++) {
                if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                    $n = $n . $number[$i] . ',';
                } else {
                    $n = $n . $number[$i];
                }
            }
            $number = $n;
            // reverse
            $number = strrev($number);
            $decimals != 0 ? ($number = $number . '.' . $decimalNumbers) : $number;
            return $number;
        }

        //Number to word BD Taka
        function convert_number($number)
        {
            $my_number = $number;

            if ($number < 0 || $number > 999999999) {
                throw new Exception('Number is out of range');
            }
            $Kt = floor($number / 10000000); /* Koti */
            $number -= $Kt * 10000000;
            $Gn = floor($number / 100000); /* lakh  */
            $number -= $Gn * 100000;
            $kn = floor($number / 1000); /* Thousands (kilo) */
            $number -= $kn * 1000;
            $Hn = floor($number / 100); /* Hundreds (hecto) */
            $number -= $Hn * 100;
            $Dn = floor($number / 10); /* Tens (deca) */
            $n = $number % 10; /* Ones */

            $res = '';

            if ($Kt) {
                $res .= convert_number($Kt) . ' Koti ';
            }
            if ($Gn) {
                $res .= convert_number($Gn) . ' Lakh';
            }

            if ($kn) {
                $res .= (empty($res) ? '' : ' ') . convert_number($kn) . ' Thousand';
            }

            if ($Hn) {
                $res .= (empty($res) ? '' : ' ') . convert_number($Hn) . ' Hundred';
            }

            $ones = [
                '',
                'One',
                'Two',
                'Three',
                'Four',
                'Five',
                'Six',
                'Seven',
                'Eight',
                'Nine',
                'Ten',
                'Eleven',
                'Twelve',
                'Thirteen',
                'Fourteen',
                'Fifteen',
                'Sixteen',
                'Seventeen',
                'Eightteen',
                'Nineteen',
            ];
            $tens = ['', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eigthy', 'Ninety'];

            if ($Dn || $n) {
                if (!empty($res)) {
                    $res .= ' and ';
                }

                if ($Dn < 2) {
                    $res .= $ones[$Dn * 10 + $n];
                } else {
                    $res .= $tens[$Dn];

                    if ($n) {
                        $res .= '-' . $ones[$n];
                    }
                }
            }

            if (empty($res)) {
                $res = 'zero';
            }

            return $res;
        }
    @endphp
@endsection
