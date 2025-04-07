@extends('layouts.finance_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Cheque Issue Information</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

{{-- @foreach($ci_pro_attendance as $key1=>$row1)
@php

$ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row1->employee_id)->first();
$txt_employee_name=$ci_employee_info->employee_name;

$ci_desig=DB::table('pro_desig')->Where('desig_id',$row1->desig_id)->first();
$txt_desig_name=$ci_desig->desig_name;

$ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row1->placeofposting_id)->first();
$txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

// $ci_biodevice=DB::table('pro_biodevice')->Where('biodevice_name',$row1->nodeid)->first();
// $txt_biodevice_name=$ci_biodevice->biodevice_name;

@endphp
@endforeach --}}


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Company</th>
                                <th>Issue Date</th>
                                <th>Customer</th>
                                <th>Particulars</th>
                                <th>Account Number</th>
                                <th>Cheque Date</th>
                                <th>Cheque Number</th>
                                <th>Bank/Branch</th>
                                <th>Ammount</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($ci_cheque_issue as $key=>$row_cheque_issue)
                            @php
                            $ci_company=DB::table('pro_company')->Where('company_id',$row_cheque_issue->company_id)->first();
                            $txt_company_name=$ci_company->company_name;

                            if($row_cheque_issue->acc_id=='0')
                            {
                              $txt_acc_no="N/A";  
                            } else {
                            $ci_bank_acc=DB::table('pro_bank_acc')->Where('acc_id',$row_cheque_issue->acc_id)->first();
                            $txt_acc_no=$ci_bank_acc->acc_no;
                            }

                            if($row_cheque_issue->cheque_details_id=='0')
                            {
                              $txt_cheque_no="N/A";  
                            } else {
                            $ci_cheque_details=DB::table('pro_cheque_details')->Where('cheque_details_id',$row_cheque_issue->cheque_details_id)->first();
                            $txt_cheque_no=$ci_cheque_details->cheque_no;
                            }

                            if($row_cheque_issue->bank_details_id=='0')
                            {
                              $txt_bank_name="N/A";  
                              $txt_branch_name="N/A";  
                            } else {
                            $ci_bank_details=DB::table('pro_bank_details')->Where('bank_details_id',$row_cheque_issue->bank_details_id)->first();
                            
                            $ci_bank=DB::table('pro_bank')->Where('bank_id',$ci_bank_details->bank_id)->first();
                            $txt_bank_name=$ci_bank->bank_name;

                            $ci_bank_branch=DB::table('pro_bank_branch')->Where('branch_id',$ci_bank_details->branch_id)->first();
                            $txt_branch_name=$ci_bank_branch->branch_name;
                            }

                            $txt_amount_01=$row_cheque_issue->ammount;
                            $txt_amount=number_format($txt_amount_01,2);
                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $txt_company_name }}</td>
                                <td>{{ $row_cheque_issue->issue_date }}</td>
                                <td>{{ $row_cheque_issue->customer_name }}</td>
                                <td>
                                  {{ $row_cheque_issue->particulars }} <br>
                                  @isset( $row_cheque_issue->fund_req_master_id)
                                    {{$row_cheque_issue->fund_req_master_id}}
                                  @endisset

                                </td>
                                <td>{{ $txt_acc_no }}</td>
                                <td>{{ $row_cheque_issue->cheque_date }}</td>
                                <td>{{ $txt_cheque_no }}</td>
                                <td>{{ $txt_bank_name }} | {{ $txt_branch_name }}</td>
                                <td>{{ $txt_amount }}</td>
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