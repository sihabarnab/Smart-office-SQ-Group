<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Cheque Issue List</h1>
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Concern</th>
                                <th class="text-left align-top">Issue Date</th>
                                <th class="text-left align-top">Customer</th>
                                <th class="text-left align-top">Particulars</th>
                                <th class="text-left align-top">Account No.</th>
                                <th class="text-left align-top">Cheque Date</th>
                                <th class="text-left align-top">Cheque No</th>
                                <th class="text-left align-top">Bank</th>
                                <th class="text-left align-top">Amount</th>
                                <th class="text-left align-top"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $key => $value)
                                <tr>
                                    <td class="text-left align-top">{{ $key+1 }}</td>
                                    <td class="text-left align-top">{{ $value->company_name }}</td>
                                    <td class="text-left align-top">{{ $value->issue_date }}</td>
                                    <td class="text-left align-top">{{ $value->customer_name }}</td>
                                    <td class="text-left align-top">{{ $value->particulars }}</td>
                                    <td class="text-left align-top">{{ $value->acc_id }}</td>
                                    <td class="text-left align-top">{{ $value->cheque_date }}</td>
                                    <td class="text-left align-top">{{ $value->cheque_no }}</td>
                                    <td class="text-left align-top">{{ $value->bank_sname." | ".$value->branch_name }}</td>
                                    <td class="text-left align-top">{{ $value->ammount }}</td>
                                    <td class="text-left align-top">
                                        <a href="#">Edit</a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
