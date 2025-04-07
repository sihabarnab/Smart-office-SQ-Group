@extends('layouts.sales_app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('rpt_repair_invoice_print', [$m_repair_master->reinvm_id, $m_repair_master->company_id]) }}"
                            class="btn btn-primary float-right">Print</a>


                        @php
                            $m_company = DB::table('pro_company')
                                ->where('company_id', $m_repair_master->company_id)
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
                                        <h4 class="text-center text-uppercase">Repair Invoice</h4>

                                        <div class="row mb-3 mt-3">
                                            <div class="col-6 text-left">
                                                <strong>To </strong> <br>
                                                {{ $m_customer->customer_name }} <br>
                                                {{ $m_customer->customer_address }} <br>
                                                {{ $m_customer->customer_mobile }}
                                            </div>
                                            <div class="col-6 text-right">
                                                <div class="row">
                                                    <div class="col-5">
                                                        Invoice No <br>
                                                        Invoice Date <br>
                                                        Sold Date <br>
                                                        Received Date <br>
                                                        MR Number <br>
                                                        SI No
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
                                                        {{ $m_repair_master->reinvm_id }} <br>
                                                        {{ $m_repair_master->reinvm_date }} <br>
                                                        {{ $m_repair_master->sold_date }} <br>
                                                        {{ $m_repair_master->recived_date }} <br>
                                                        {{ $m_repair_master->mr_id }} <br>
                                                        {{ $m_repair_master->serial_no }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>SL No</th>
                                                <th>Description</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Extended Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($m_repair_details as $key => $row)
                                                @php
                                                    $total = $row->total + $total;
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $row->pro_des }}</td>
                                                    <td>{{ $row->unit }}</td>
                                                    <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                                    <td class="text-right">{{ number_format($row->unit_price, 2) }}</td>
                                                    <td class="text-right">{{ number_format($row->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right">Total:</td>
                                                <td class="text-right">{{ number_format($total, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">In Words: {{ convert_number($total) }} Only</td>
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
                                                ->where('employee_id', $m_repair_master->user_id)
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
