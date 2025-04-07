<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Account Info</h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Company</th>
                                <th>Account Number</th>
                                <th>Bank Name</th>
                                <th>Branch</th>
                                <th>Branch Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp

                            @foreach($user_company as $xy=>$row_company)
                            @php

                            $ci_bank_acc=DB::table('pro_bank_acc')
                            ->Where('company_id',$row_company->company_id)
                            ->Where('valid','1')
                            ->get();

                            @endphp
                            @foreach($ci_bank_acc as $key=>$row_bank_acc)
                            @php
                            $ci_company=DB::table('pro_company')->Where('company_id',$row_company->company_id)->first();
                            $txt_company_name=$ci_company->company_name;

                            $ci_bank_details=DB::table('pro_bank_details')->Where('bank_details_id',$row_bank_acc->bank_details_id)->first();
                            // $txt_company_name=$ci_company->company_name;

                            $ci_bank=DB::table('pro_bank')->Where('bank_id',$ci_bank_details->bank_id)->first();
                            // $txt_company_name=$ci_company->company_name;

                            $ci_bank_branch=DB::table('pro_bank_branch')->Where('branch_id',$ci_bank_details->branch_id)->first();
                            // $txt_company_name=$ci_company->company_name;

                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $txt_company_name }}</td>
                                <td>{{ $row_bank_acc->acc_no }}</td>
                                <td>{{ $ci_bank->bank_name }}<br>{{ $ci_bank->bank_sname }}</td>
                                <td>{{ $ci_bank_branch->branch_name }}</td>
                                <td>{{ $ci_bank_details->bank_add }}</td>
                                <td><a href="{{ route('bank_accounts_edit', $row_bank_acc->acc_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a></td>
                            </tr>
                            @php
                            $i++;
                            @endphp

                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
