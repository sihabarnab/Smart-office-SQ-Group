<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">

    <style>
        @media print {
            .noPrint {
                display: none;
            }

            header,
            footer {
                display: none;
            }

            @page {
                size: auto;
            }


            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */
        }
    </style>

</head>

<body>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @php
                            $m_company = DB::table('pro_company')
                                ->where('company_id', $m_sales->company_id)
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
                                        <h3 class="text-center text-uppercase">{{ $m_company->company_name }}</h3>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-12 text-center " style="font-size: 15px;">
                                        Office :
                                        {{ $m_company->company_add . ',' . $m_company->company_city . '-' . $m_company->company_zip . ',' . $m_company->company_country }}.<br>
                                        Mail: {{ $m_company->company_email }}, URL: {{ $m_company->company_url }} <br>
                                        Cell: {{ $m_company->company_phone }}, {{ $m_company->company_mobile }}. <br>
                                    </div>
                                </div>

                                <div class="row mb-2 mt-3">
                                    <div class="col-12">
                                        <h4 class="text-center text-uppercase">Invoice / Bill</h4>
                                    </div>
                                </div>

                                <div class="mt-2 mb-2" id="qd">
                                    <strong>To </strong> <br>
                                    {{ $m_sales->customer_name }} <br>
                                    {{ $m_sales->customer_address }} <br>
                                    {{ $m_sales->customer_mobile }} <br>
                                    {{ $m_sales->ref_name }}
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                Invoice No <br>
                                                Invoice Date <br>
                                                Money Receipt #
                                            </div>
                                            <div class="col-1">
                                                : <br>
                                                : <br>
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $m_sales->sim_id }} <br>
                                                {{ $m_sales->sim_date }} <br>
                                                @php
                                                    $m_money_receipt = DB::table("pro_money_receipt_$company_id")
                                                    ->where('sim_id', $m_sales->sim_id)
                                                    ->get();
                                                @endphp
                                                @foreach($m_money_receipt as $key=>$row_money_receipt)
                                                    @php
                                                    if($row_money_receipt->mr_id==null)
                                                    {
                                                        $txt_mr_id='';
                                                    } else {
                                                        $txt_mr_id=$row_money_receipt->mr_id;
                                                    }
                                                    @endphp
                                                {{ $txt_mr_id }}
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                PO No <br>
                                                Date
                                            </div>
                                            <div class="col-1">
                                                : <br>
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $m_sales->pono_ref }} <br>
                                                {{ $m_sales->pono_ref_date }} <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Description</th>
                                            <th>Specification</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="text-right">Extended Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sub_total = 0;
                                        @endphp
                                        @foreach ($m_details as $key => $row)
                                            @php
                                                $sub_total += $row->total;
                                                $extended = number_format($row->total, 2);
                                                $qty = number_format($row->qty, 2);
                                                $unit = number_format($row->rate, 2);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @php
                                                        $product = DB::table("pro_finish_product_$row->company_id")
                                                            ->where('product_id', $row->product_id)
                                                            ->first();

                                                        $product_serial = DB::table(
                                                            "pro_finish_product_serial_$row->company_id",
                                                        )
                                                            ->where('product_id', $row->product_id)
                                                            ->where('sim_id', $row->sim_id)
                                                            ->get();

                                                    @endphp
                                                    <small>
                                                    {{ $product->product_name }}<br>
                                                        @if (isset($product_serial))
                                                            @foreach ($product_serial as $key => $serial)
                                                                {{ $serial->serial_no }},
                                                            @endforeach
                                                        @endif
                                                    </small>
                                                </td>
                                                <td></td>
                                                <td class="text-right">
                                                    {{ $qty }}
                                                </td>
                                                <td class="text-right">{{ $unit }}</td>
                                                <td class="text-right">{{ $extended }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right font-weight-bold">Sub Total:</td>
                                            <td class="text-right font-weight-bold ">
                                                @php
                                                    $sub_total_new = number_format($sub_total, 2);
                                                @endphp
                                                {{ $sub_total_new }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row text-right">
                                    <div class="col-6">

                                    </div>
                                    <div class="col-4 font-weight-bold">
                                        <p class="m-0">Discount</p>
                                        <p class="m-0">Transport Discount</p>
                                        <p class="m-0">Transportation Cost</p>
                                        <p class="m-0">Test Fee</p>
                                        <p class="m-0">Other</p>
                                    </div>
                                    <div class="col-2 font-weight-bold ">
                                        @php
                                            $discount_amount = number_format($m_sales->discount_amount, 2);
                                            $tr_discount_amount = number_format($m_sales->tr_discount_amount, 2);
                                            $transport_cost = number_format($m_sales->transport_cost, 2);
                                            $test_fee = number_format($m_sales->test_fee, 2);
                                            $other_expense = number_format($m_sales->other_expense, 2);
                                            $total = number_format($m_sales->total, 2);
                                            $total_word = $m_sales->total;
                                        @endphp
                                        <p class="m-0">{{ $discount_amount }}</p>
                                        <p class="m-0 "> {{ $tr_discount_amount }} </p>
                                        <p class="m-0 "> {{ $transport_cost }} </p>
                                        <p class="m-0 "> {{ $test_fee }} </p>
                                        <p class="m-0 "> {{ $other_expense }} </p>
                                    </div>
                                </div>


                                <div class="row text-right border">
                                    <div class="col-8">

                                    </div>
                                    <div class="col-2 font-weight-bold">
                                        <p class="m-0">Grand Total</p>

                                    </div>
                                    <div class="col-2 font-weight-bold border">
                                        <p class=" m-0">{{ $total }}</p>
                                    </div>
                                </div>
                                <div class="row border mb-2">
                                    <p class="m-0"> <span class="font-weight-bold">In Words :</span>
                                        @php
                                            $quotation_total_word = convert_number($total_word);
                                        @endphp
                                        {{ $quotation_total_word }} Only
                                    </p>
                                </div>
<br><br><br>
                              <div class="row mt-5">
                                    <div class="col-6">
{{--                                         @php
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
 --}}                                    </div> 
                                     <div class="col-6 text-right">
                                        @php
                                            $Prepared_employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $m_sales->user_id)
                                                ->first();
                                          if($Prepared_employee_info) {
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $Prepared_employee_info->desig_id)
                                                ->first();
                                                $desig_name=$desig->desig_name;
                                                 $employee_name=$Prepared_employee_info->employee_name;
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

            $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eightteen', 'Nineteen'];
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

    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
        setTimeout(function() {
            window.history.back();
        }, 2000);
    </script>

</body>

</html>
