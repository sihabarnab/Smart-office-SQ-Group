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

            body {
                font-weight: bold;
            }

            hr {
                border: 1px solid black;
            }

            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */
        }
    </style>

</head>

<body>


    @php

        $customer = DB::table("pro_customer_information_$m_money_receipt->company_id")
            ->where('customer_id', $m_money_receipt->customer_id)
            ->first();
        $customer_name = $customer == null ? '' : $customer->customer_name;
        $customer_add = $customer == null ? '' : $customer->customer_address;
        $customer_city = $customer == null ? '' : $customer->customer_city;

        $pay_type = DB::table('pro_payment_type')
            ->where('payment_type_id', $m_money_receipt->payment_type)
            ->first();
        $payment_type = $pay_type == null ? '' : $pay_type->payment_type;

        if ($m_money_receipt->payment_type != 1) {
            $m_bank = DB::table('pro_bank')
                ->where('bank_id', $m_money_receipt->bank_id)
                ->first();
            // $bank_or_office = $m_bank->bank_name;
            $bank_or_office = $m_bank == null ? '' : $m_bank->bank_name;            
        } else {
            if ($m_money_receipt->receive_type == 1) {
                $bank_or_office = 'Head Office';
            } elseif ($m_money_receipt->receive_type == 2) {
                $bank_or_office = 'Factory';
            }
        }

        $m_company = DB::table('pro_company')
            ->where('company_id', $m_money_receipt->company_id)
            ->where('valid', 1)
            ->first();

        $image_url = "../../../../docupload/sqgroup/company_logo/$m_company->logo";

        $Prepared_employee_info = DB::table('pro_employee_info')
            ->where('employee_id', $m_money_receipt->user_id)
            ->first();
        if ($Prepared_employee_info) {
            $desig = DB::table('pro_desig')
                ->where('desig_id', $Prepared_employee_info->desig_id)
                ->first();
            $desig_name = $desig->desig_name;
            $employee_name = $Prepared_employee_info->employee_name;
        } else {
            $employee_name = '';
            $desig_name = '';
        }

        
        if ($m_money_receipt->chq_po_dd_date == null)
        {
            $chq_po_dd_date="";
        } else {
            $chq_po_dd_date=date("d-m-Y",strtotime($m_money_receipt->chq_po_dd_date));
        }

    @endphp

    <section class="m-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-0">
                                <div class="col-12">
                                    <img class="mx-auto d-block" src="{{ $image_url }}" width="100"
                                        height="100" />
                                    <h4 class="text-center">{{ $m_company->company_name }}</h4>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-12 text-center">
                                    Corporate Office :
                                    {{ $m_company->company_add . ',' . $m_company->company_city . '-' . $m_company->company_zip . ',' . $m_company->company_country }}.<br>

                                    {{-- Cell: {{ $m_company->company_phone }}, {{ $m_company->company_mobile }}. <br> --}}
                                    Cell: {{ '01709643463(HO), 01816253654(HO), 01819061358(HO)' }}, <br>
                                    Factory: {{ 'Bhabanipur, Gazipur' }} <br>
                                    Cell: {{ ' 01718506722(Fac), 01709643461-62(Fac), 01709643470-71(CTPT)' }} <br>
                                </div>
                            </div>


                            <div class="row mb-2 mt-3">
                                <div class="col-12">
                                    <h4 class="text-center">Money Receipt</h4>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-4 text-left text-uppercase"> M R NO :
                                    <strong>{{ $m_money_receipt->mr_id }} </strong></div>
                                <div class="col-5"></div>
                                <div class="col-3 text-right">Date :
                                    <strong> {{ date('F j, Y', strtotime($m_money_receipt->collection_date)) }}
                                    </strong>
                                </div>
                            </div>
                            <hr color="black" class="m-0 ">

                    
                            <table width="100%" class="mt-3 mb-2">
                                <tr class="text-left">
                                    <td> Received with thanks form</td>
                                    <td style="border-bottom: 2px dotted black;">
                                        <div> {{ $customer_name }}, {{ $customer_add }}, {{ $customer_city }}</div>
                                    </td>
                                </tr>
                            </table>

                            <div class="row mb-2">
                                <div class="col-5 text-left">
                                    <div class="row">
                                        <div class="col-5">Amount of TK. : </div>
                                        <div class="col-7" style="border-bottom: 2px dotted black;">
                                            <strong> {{ number_format($m_money_receipt->mr_amount) }} </strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 text-left">
                                    <div class="row">
                                        <div class="col-2 text-right">Taka</div>
                                        <div class="col-10" style="border-bottom: 2px dotted black;">
                                                {{ convert_number($m_money_receipt->mr_amount) }} Only</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-2">
                                    By
                                </div>
                                <div class="col-2 text-left" style="border-bottom: 2px dotted black;">
                                    {{ 'Cheque/PO/DD' }}
                                </div>

                                <div class="col-1 text-center">No</div>
                                <div class="col-3 text-left" style="border-bottom: 2px dotted black;">
                                
                                        {{ $m_money_receipt->chq_po_dd_no ? $m_money_receipt->chq_po_dd_no : '' }}
                                </div>
                                <div class="col-1 text-center">Dated</div>
                                <div class="col-3 text-left" style="border-bottom: 2px dotted black;">
                                   {{ $chq_po_dd_date }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6 text-left ml-0">
                                    <div class="row">
                                        <div class="col-2"> In</div>
                                        <div class="col-9" style="border-bottom: 2px dotted black;">
                                            <strong>{{ $payment_type }}</strong>
                                        </div>
                                        <div class="col-1">,</div>
                                    </div>
                                </div>
                                <div class="col-6 text-left" style="border-bottom: 2px dotted black;">
                                    <strong> {{ $bank_or_office }}</strong>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-2">
                                    Remarks
                                </div>
                                <div class="col-10 text-left" style="border-bottom: 2px dotted black;">
                                    {{ $m_money_receipt->remarks }}
                                </div>
                            </div>

                            <div class="row mt-3 mb-5">
                                <div class="col-12 text-right">
                                    <strong class="mb-2">For {{ $m_company->company_name }}</strong> <br>
                                    {{ $employee_name }} <br>
                                    {{ $desig_name }}
                                </div>
                            </div>


                           
                            <hr color="black" class="m-0">
                            <p class="text-center">Thanking you for business with us <br> This is computer generated
                                copy and
                                does not require any signature and seal</p>



                            @php
                               

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
                                    $tens = [
                                        '',
                                        '',
                                        'Twenty',
                                        'Thirty',
                                        'Fourty',
                                        'Fifty',
                                        'Sixty',
                                        'Seventy',
                                        'Eigthy',
                                        'Ninety',
                                    ];

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


                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <!-- AdminLTE App -->
        <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>
        <script type="text/javascript">
            window.onload = function() {
                window.print();
            }
            setTimeout(function() {
                window.location.replace(
                    "{{ route('rpt_money_receipt_view', [$m_money_receipt->mr_id, $m_money_receipt->company_id]) }}"
                );
            }, 2000);
        </script>

</body>

</html>
