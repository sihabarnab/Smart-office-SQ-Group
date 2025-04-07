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
                            @foreach($user_company as $xy=>$row_company)
                            @php
                            $m_bank_acc = DB::table('pro_bank_acc')
                                ->where('company_id',$row_company->company_id)
                                ->get();
dd($row_company);
                            @endphp

                            
                            @foreach($m_bank_acc as $key=>$row)
                              @php
                                // $m_bank=DB::table('pro_bank')
                                // ->Where('bank_id',$row->bank_id)
                                // ->orderBy('bank_id', 'asc')
                                // ->first(); //query builder

                                // $m_branch=DB::table('pro_bank_branch')
                                // ->Where('branch_id',$row->branch_id)
                                // ->orderBy('branch_id', 'asc')
                                // ->first(); //query builder

                              // dd($row);
                              @endphp

                            <tr>
                                <td>{{ $key+1 }}</td>
{{--                                 <td>{{ $row->company_name }}</td>
                                <td>{{ $row->acc_no }}</td>
                                <td>{{ $m_bank->bank_name }} | {{ $m_bank->bank_sname }}</td>
                                <td>{{ $m_branch->branch_name }}</td>
                                <td>{{ $row->bank_add }}</td>
                                <td>
                                    <a href="{{ route('bank_accounts_edit', $row->acc_id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
 --}}                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
