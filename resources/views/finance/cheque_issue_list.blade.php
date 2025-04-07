<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cheque Issue Information</h3>
                </div>
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
                            @foreach($user_company as $xy=>$row_company)
                            @php

                            $m_cheque_issue=DB::table('pro_cheque_issue')
                            ->Where('company_id',$row_company->company_id)
                            ->Where('valid','1')
                            ->orderBy('cheque_issue_id', 'DESC')
                            ->get();

                            @endphp

                            @foreach($m_cheque_issue as $key=>$row_cheque_issue)
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
                                <td>{{ $row_cheque_issue->particulars }}</td>
                                <td>{{ $txt_acc_no }}</td>
                                <td>{{ $row_cheque_issue->cheque_date }}</td>
                                <td>{{ $txt_cheque_no }}</td>
                                <td>{{ $txt_bank_name }} | {{ $txt_branch_name }}</td>
                                <td>{{ $txt_amount }}</td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
