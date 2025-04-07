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
                                ->where('company_id', $d_challan->company_id)
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


                                <table class="table table-bordered table-sm  mt-3">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="row m-0">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Challan No <br>
                                                                challan Date
                                                            </div>
                                                            <div class="col-1">
                                                                : <br>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $d_challan->delivery_chalan_master_id }} <br>
                                                                {{ $d_challan->dcm_date }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Invoice No <br>
                                                                Invoice Date <br>
                                                            </div>
                                                            <div class="col-1">
                                                                : <br>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $d_challan->sim_id }} <br>
                                                                {{ $d_challan->sim_date }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="text-center text-uppercase">Delivery Challan</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-sm mt-1">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong>To </strong> <br>
                                                {{ $d_challan->customer_name }} <br>
                                                {{ $d_challan->delivery_address }}
                                            </td>
                                            <td>
                                                <div class="row m-0">
                                                    <div class="col-5">
                                                        IFB No & Date <br>
                                                        Contact No & Date <br>
                                                        Allocation No & Date <br>

                                                    </div>
                                                    <div class="col-1">
                                                        : <br>
                                                        : <br>
                                                        :
                                                    </div>
                                                    <div class="col-6">
                                                        {{ $d_challan->ifb_no }} {{ $d_challan->ifb_date }} <br>
                                                        {{ $d_challan->contract_no }} {{ $d_challan->contract_date }}
                                                        <br>
                                                        {{ $d_challan->allocation_no }}
                                                        {{ $d_challan->allocation_date }}
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-sm mt-1">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h6 class="text-center">Marerials Described Below Carried By The Follwing Truck Number</h6>
                                                <div class="row">
                                                    <div class="col-2"></div>
                                                    <div class="col-8">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Truck No <br>
                                                                Driver Name

                                                            </div>
                                                            <div class="col-1">
                                                                : <br>
                                                                :
                                                            </div>
                                                            <div class="col-6">
                                                                {{ $d_challan->truck_no }} <br>
                                                                {{ $d_challan->driver_name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2"></div>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>




                                @php
                                    $total_qty = 0;
                                @endphp

                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Description Of Materials</th>
                                            <th>Specification</th>
                                            <th>Qty(Nos.)</th>
                                            <th>Crate No(S)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($d_details as $key => $row)
                                            @php
                                                $product = DB::table("pro_finish_product_$row->company_id")
                                                    ->where('product_id', $row->product_id)
                                                    ->first();
                                                $unit = DB::table('pro_units')
                                                    ->where('unit_id', $product->unit)
                                                    ->first();
                                                $total_qty = $total_qty + $row->del_qty;
                                                $product_serial = DB::table(
                                                    "pro_finish_product_serial_$row->company_id",
                                                )
                                                    ->where('product_id', $row->product_id)
                                                    ->where(
                                                        'delivery_chalan_master_id',
                                                        $row->delivery_chalan_master_id,
                                                    )
                                                    ->where(
                                                        'delivery_chalan_details_id',
                                                        $row->delivery_chalan_details_id,
                                                    )
                                                    ->get();
                                            @endphp
                                              <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <small>
                                                        {{ $product->product_name }} <br>
                                                        @if (isset($product_serial))
                                                            @foreach ($product_serial as $key => $serial)
                                                                {{ $serial->serial_no }},
                                                            @endforeach
                                                        @endif

                                                    </small>
                                                </td>
                                                <td>
                                                    <small>{{ $product->model_size }} <br>
                                                        {{ $product->product_description }} </small>
                                                </td>
                                                <td style="text-align: right;">{{ number_format($row->del_qty, 2) }}
                                                    {{ $unit->unit_name }}</td>
                                                <td></td>
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

                                <div class="mt-3">
                                    Note: This is Only Carrying Permit and is in on Way a Certificate Related to Payment or
                                    Ownership of the Goods.
                                </div>
<br><br><br>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <span style="text-decoration: overline;">Received By</span>
                                    </div>
                                    <div class="col-4">
                                        @php
                                            $Prepared_employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $d_challan->user_id)
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
                                        <span style="text-decoration: overline;">
                                        For, <strong>{{ $m_company->company_name }}</strong></span><br>
                                        Prepared By {{$employee_name}} <br>
                                       {{$desig_name}}
                                    </div>


                                    <div class="col-4">
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
            window.location.replace(
                "{{ route('rpt_delivery_challan_view', [$d_challan->delivery_chalan_master_id, $d_challan->company_id]) }}"
            );
        }, 2000);
    </script>

</body>

</html>
