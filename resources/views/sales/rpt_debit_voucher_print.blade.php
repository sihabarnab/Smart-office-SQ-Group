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
                                ->where('company_id', $m_debit_voucher->company_id)
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
                                        <h4 class="text-center text-uppercase">Debit Voucher</h4>

                                        <div class="row mb-3 mt-5">
                                            <div class="col-6 text-left">
                                                <div class="row">
                                                    <div class="col-5">
                                                        Voucher No
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        {{ $m_debit_voucher->debit_voucher_id }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 text-right">
                                                <div class="row">
                                                    <div class="col-5">
                                                        Date
                                                    </div>
                                                    <div class="col-1">
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        {{ $m_debit_voucher->debit_voucher_date }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                  </div>

                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th width='70%'>Description</th>
                                                <th width='30%'>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ $m_debit_voucher->accounts_name }} <br>
                                                    {{ 'Transport' }} <br>
                                                    {{ 'Carrying Allowance' }} <br>
                                                    {{ $m_debit_voucher->name }} <br>
                                                    {{ $m_debit_voucher->details }}
                                                     <br><br><br>
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($m_debit_voucher->amount, 2) }} <br>
                                                    {{ number_format($m_debit_voucher->tr_amount, 2) }} <br>
                                                    {{ number_format($m_debit_voucher->cr_amount, 2) }} <br>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            @php
                                                $total =
                                                    $m_debit_voucher->amount +
                                                    $m_debit_voucher->tr_amount +
                                                    $m_debit_voucher->cr_amount;
                                            @endphp
                                            <tr class="text-right">
                                                <td colspan="1">Total</td>
                                                <td colspan="1">{{ number_format($total) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">In Words: {{ convert_number($total) }} Only</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <br>
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
                                        Received By, <br>
                                    </div> 
                                     <div class="col-6 text-right">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $m_debit_voucher->user_id)
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
                                        For, <strong>{{ $m_company->company_name }}</strong><br><br><br><br><br>
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
                        {{-- start page --}}




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
