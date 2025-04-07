@extends('layouts.sales_app')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('rpt_requisition_print', [$m_requisition_master->requisition_master_id, $m_requisition_master->company_id]) }}"
                            class="btn btn-primary float-right">Print</a>


                        @php
                            $m_company = DB::table('pro_company')
                                ->where('company_id', $m_requisition_master->company_id)
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
                                        <h4 class="text-center text-uppercase">Requisition</h4>
                                    </div>
                                </div>



                                <div class="row mb-2">
                                    <div class="col-7">
                                        <strong>To </strong> <br>
                                        {{ $m_requisition_master->customer_name }} <br>
                                        {{ $m_requisition_master->customer_address }} <br>
                                        {{ $m_requisition_master->customer_mobile }}
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">
                                                Requisition No
                                            </div>
                                            <div class="col-1">
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $m_requisition_master->requisition_master_id }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5">
                                                Requisition Date
                                            </div>
                                            <div class="col-1">
                                                :
                                            </div>
                                            <div class="col-6">
                                                {{ $m_requisition_master->requisition_date }}
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        Remarks
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col-9">
                                        {{ $m_requisition_master->remarks }}
                                    </div>
                                </div>

                                <table class="table table-bordered table-striped table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Commision</th>
                                            <th>Carring</th>
                                            <th>Extended</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $net_total = 0;
                                        @endphp
                                        @foreach ($m_requisition_details as $key => $row)
                                            @php
                                                $net_total = $net_total + $row->net_total;
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->product_name }}</td>
                                                <td>{{ $row->product_description }}</td>
                                                <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->rate, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->comm_rate, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->transport_rate, 2) }}</td>
                                                <td class="text-right">{{ number_format($row->net_total, 2) }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class="text-right">Total:</td>
                                            <td class="text-right">{{ number_format($net_total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="row">
                                    <div class="col-10 text-right">
                                        Opening Balance:
                                    </div>
                                    <div class="col-2 text-right">
                                        {{ number_format($m_requisition_master->last_balance, 2) }}
                                        <hr class="m-0" style="border-top: 2px solid #fff;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10 text-right">
                                        Grand Total:
                                    </div>
                                    <div class="col-2 text-right">
                                        @php
                                            $grand_total = $net_total + $m_requisition_master->last_balance;
                                        @endphp
                                        {{ number_format($grand_total, 2) }}
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-10 text-right">
                                        Committed Deposit Amount:
                                    </div>
                                    <div class="col-2 text-right">
                                        {{ number_format($m_requisition_master->deposit_amount, 2) }}
                                        <hr class="m-0" style="border-top: 2px double #fff;">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-10 text-right">
                                        Net Balance:
                                    </div>
                                    <div class="col-2 text-right">
                                        @php
                                            $net_balance = $grand_total - $m_requisition_master->deposit_amount;
                                        @endphp
                                        {{ number_format($net_balance, 2) }}
                                    </div>
                                </div>
                                <br><br>
                                <div class="row mt-2">
                                    <div class="col-2">
                                        Comments by ED
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col-9">
                                        {{ $m_requisition_master->comments }}
                                    </div>
                                </div>
                                <br><br>
                                <div class="row mt-3">
                                    <div class="col-4">
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
                                     </div> 
                                     <div class="col-4 text-center">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                            ->leftJoin('pro_desig', "pro_employee_info.desig_id", 'pro_desig.desig_id')
                                            ->leftJoin('pro_department', "pro_employee_info.department_id", 'pro_department.department_id')
                                            ->where('pro_employee_info.employee_id', $m_requisition_master->user_id)
                                                ->first();
                                            
                                        @endphp
                                        For, <strong>{{ $m_company->company_name }}</strong> <br>
                                        Prepared By <br>
                                       {{$employee_info->employee_name}} <br>
                                       {{$employee_info->desig_name}} ({{$employee_info->department_name}})
                                    </div>

                                    <div class="col-4 text-right">
                                        @php
                                            $approved_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $m_requisition_master->approved_id)
                                                ->first();
                                          if($approved_info) {
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $approved_info->desig_id)
                                                ->first();
                                                $desig_name_01=$desig->desig_name;
                                                 $employee_name_01=$approved_info->employee_name;
                                            } else {
                                                $employee_name_01='';
                                                $desig_name_01 = '';
                                            }  
                                            
                                        @endphp
                                        For, <strong>{{ $m_company->company_name }}</strong> <br>
                                        Approved By <br>
                                       {{$employee_name_01}} <br>
                                       {{$desig_name_01}}
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
@endsection
