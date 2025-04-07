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
                                ->where('company_id', $gate_pass->company_id)
                                ->where('valid', 1)
                                ->first();

                            $image_url = "../../../../docupload/sqgroup/company_logo/$m_company->logo";
                        @endphp
                        <div class="row m-4">
                            <div class="col-12">



                                <div class="row mb-0">
                                    <div class="col-12">
                                        <img class="mx-auto d-block" src="{{ $image_url }}" width="100"
                                            height="100" />
                                        <h3 class="text-center text-uppercase">{{ $m_company->company_name }} </h3>
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
                                        <h4 class="text-center text-uppercase">Gate Pass</h4>
                                    </div>
                                </div>





                                <div class="row mb-3">

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                Vat No. <br>
                                                Delivery Challan No



                                            </div>
                                            <div class="col-1">
                                                : <br>
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $gate_pass->vat_no }} <br>
                                                {{ $gate_pass->delivery_chalan_master_id }}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                Gate Pass No <br>
                                                Gate Pass Date
                                            </div>
                                            <div class="col-1">
                                                : <br>
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $gate_pass->gate_pass_master_id }} <br>
                                                {{ $gate_pass->gate_pass_date }}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-2">
                                        Name <br>
                                        Address
                                    </div>

                                    <div class="col-10">
                                        : {{ $gate_pass->customer_name }} <br>
                                        : {{ $gate_pass->delivery_address }}
                                    </div>
                                </div>

                                @php
                                    $total_qty = 0;
                                @endphp

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gp_details as $key => $row)
                                            @php
                                                $product = DB::table("pro_finish_product_$row->company_id")
                                                    ->where('product_id', $row->product_id)
                                                    ->first();
                                                $unit = DB::table('pro_units')
                                                    ->where('unit_id', $product->unit)
                                                    ->first();
                                                $total_qty = $total_qty + $row->del_qty;

                                                $serial = DB::table("pro_finish_product_serial_$row->company_id")
                                                    ->where(
                                                        'delivery_chalan_master_id',
                                                        $row->delivery_chalan_master_id,
                                                    )
                                                    ->where(
                                                        'delivery_chalan_details_id',
                                                        $row->delivery_chalan_details_id,
                                                    )
                                                    ->where('product_id', $row->product_id)
                                                    ->get();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    {{ $product->product_name }} <br>
                                                    @foreach ($serial as $value)
                                                        {{ $value->serial_no }},
                                                    @endforeach
                                                </td>
                                                <td style="text-align: right;">{{ number_format($row->del_qty, 2) }}
                                                </td>
                                                <td>{{ $unit->unit_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" style="text-align: right;">Total</td>
                                            <td colspan="1" style="text-align: right;">
                                                {{ number_format(round($total_qty, 4), 2) }}</td>
                                            <td colspan="1"></td>
                                        </tr>
                                    </tfoot>
                                </table>
<br><br><br>
                                <div class="row mt-3">
                                   <div class="col-4">
                                        <span style="text-decoration: overline;">Received By</span>
                                    </div>
                                    <div class="col-4">
                                        @php
                                            $Prepared_employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $gate_pass->user_id)
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

                                        @endphp
                                        <span style="text-decoration: overline;">
                                        For, <strong>{{ $m_company->company_name }}</strong></span><br>
                                        Prepared By {{ $employee_name }} <br>
                                        {{ $desig_name }}
                                    </div>

                                    <div class="col-4 text-right">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', Auth::user()->emp_id)
                                                ->first();
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $employee_info->desig_id)
                                                ->first();

                                        @endphp
                                        <span style="text-decoration: overline;">
                                        For, <strong>{{ $m_company->company_name }}</strong></span><br>
                                    </div>
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
