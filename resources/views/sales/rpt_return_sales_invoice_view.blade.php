@extends('layouts.sales_app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('rpt_return_sales_invoice_print', [$rim_master->rsim_id, $rim_master->company_id]) }}"
                            class="btn btn-primary float-right">Print</a>
                        @php
                            $total_qty = 0;
                            $total_price = 0;
                            $total_vat_amount = 0;
                            $total_discount = 0;
                            $total_depreciation = 0;
                            $total_net_payble = 0;
                            $m_company = DB::table('pro_company')
                                ->where('company_id', $rim_master->company_id)
                                ->where('valid', 1)
                                ->first();
                            $image_url = "../../../../docupload/sqgroup/company_logo/$m_company->logo";
                        @endphp
                        {{-- start page --}}
                        <div class="row m-4">
                            <div class="col-12">


                                <div class="row mb-0">
                                    <div class="col-12">
                                        <img class="mx-auto d-block" src="{{ $image_url }}" width="100"
                                            height="100" />
                                        <h4 class="text-center text-uppercase">{{ $m_company->company_name }}</h4>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-12 text-center " style="font-size: 15px;">
                                        Office :
                                        {{ $m_company->company_add . ',' . $m_company->company_city . '-' . $m_company->company_zip . ',' . $m_company->company_country }}.<br>
                                        Mail: {{ $m_company->company_email }}, URL: {{ $m_company->company_url }} <br>
                                        Cel: {{ $m_company->company_phone }}, {{ $m_company->company_mobile }}. <br>
                                    </div>
                                </div>

                                <div class="row mb-2 mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase">Return Sales Invoice</h4>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                Return Invoice No <br>
                                                Return Invoice Date <br>
                                                Invoice <br>
                                                Invoice Date <br>
                                                Customer <br>
                                                Address

                                            </div>
                                            <div class="col-1">
                                                : <br>
                                                : <br>
                                                : <br>
                                                : <br>
                                                : <br>
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $rim_master->rsim_id }} <br>
                                                {{ $rim_master->rsim_date }} <br>
                                                {{ $rim_master->sim_id }} <br>
                                                {{ $rim_master->sinv_date }} <br>
                                                {{ $rim_master->customer_name }} <br>
                                                {{ $rim_master->customer_address }} <br>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                Ref. Name <br>
                                                IFB No & Date <br>
                                                Contract No & Date <br>
                                                Allocation No & Date <br>
                                                PO No & Date <br>
                                                Mushok. No.

                                            </div>
                                            <div class="col-1">
                                                : <br>
                                                : <br>
                                                : <br>
                                                : <br>
                                                : <br>
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $rim_master->ref_name }} <br>
                                                {{ $rim_master->ifb_no }} - {{ $rim_master->ifb_date }} <br>
                                                {{ $rim_master->contract_no }} - {{ $rim_master->contract_date }} <br>
                                                {{ $rim_master->allocation_no }} - {{ $rim_master->allocation_date }} <br>
                                                {{ $rim_master->pono_ref }} - {{ $rim_master->pono_ref_date }} <br>
                                                {{ $rim_master->mushok_no }} 

                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>



                                <table class="table table-bordered table-sm mt-3">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Item</th>
                                            <th>Specification</th>
                                            {{-- <th>Remarks</th> --}}
                                            <th>Sales Rate</th>
                                            <th>Return Qty</th>
                                            <th>Sales Price</th>
                                            <th>Vat Amount</th>
                                            <th>Discount</th>
                                            <th>Depreciation</th>
                                            <th>Net Payble</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rid_details as $key => $row)
                                            @php
                                                $total_qty = $total_qty + $row->return_qty;
                                                $total_price = $total_price + $row->total_sales_price;
                                                $total_vat_amount = $total_vat_amount + $row->vat_amount;
                                                $total_discount = $total_discount + $row->discount_amount;
                                                $total_depreciation = $total_depreciation + $row->depreciation;
                                                $total_net_payble = $total_net_payble + $row->net_payble;

                                                $serial1 = DB::table("pro_finish_product_serial_$row->company_id")
                                                    ->where('rsid_id', $row->rsid_id)
                                                    ->where('product_id', $row->product_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->product_name }}</td>
                                                <td>{{ $row->model_size }}<br>{{ $row->product_description }}</td>
                                                {{-- <td>{{ $row->remark }}</td> --}}
                                                <td class="text-right">{{ number_format($row->sales_rate, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->return_qty, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->total_sales_price, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->vat_amount, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->discount_amount, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->depreciation, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->net_payble, 2) }}</td>
                                            
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">Total:</td>
                                            <td colspan="1" class="text-right">{{ number_format($total_qty, 2) }}</td>
                                            <td colspan="1" class="text-right">{{ number_format($total_price, 2) }}</td>
                                            <td colspan="1" class="text-right">{{ number_format($total_vat_amount, 2) }}
                                            </td>
                                            <td colspan="1" class="text-right">{{ number_format($total_discount, 2) }}
                                            </td>
                                            <td colspan="1" class="text-right">
                                                {{ number_format($total_depreciation, 2) }}
                                            </td>
                                            <td colspan="1" class="text-right">{{ number_format($total_net_payble, 2) }}
                                            </td>
                                            {{-- <td colspan="2"></td> --}}
                                        </tr>
                                    </tfoot>
                                </table>


                                <div class="row mt-3">
                                    <div class="col-6">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', Auth::user()->emp_id)
                                                ->first();
                                          if(isset($employee_info)) {
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $employee_info->desig_id)
                                                ->first();
                                            }else{
                                                $desig =[];
                                            } 
                                            
                                        @endphp
                                        For, <strong>{{ $m_company->company_name }}</strong> <br>
                                        Print By, <br>
                                        @isset($employee_info)
                                            {{ $employee_info->employee_name }} <br>
                                        @endisset
                                        @isset($desig)
                                            {{ $desig->desig_name }}
                                        @endisset
                                    </div> 
                                     <div class="col-6 text-right">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $rim_master->user_id)
                                                ->first();
                                          if($employee_info) {
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $employee_info->desig_id)
                                                ->first();
                                                $desig_name=$desig->desig_name;
                                                 $employee_name=$employee_info->employee_name;
                                            }else{
                                                $employee_name='';
                                                $desig_name = '';
                                            }  
                                            
                                        @endphp
                                        For, <strong>{{ $m_company->company_name }}</strong> <br>
                                        Prepared By <br>
                                       {{$employee_name}} <br>
                                       {{$desig_name}}
                                    </div>

                                    {{-- {{$gate_pass->user_id}} --}}
                                </div>




                            </div>
                        </div>
                        {{-- Close pge part --}}


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
