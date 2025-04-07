<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales Invoice Not Final </h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>Created By</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $x = 1;
                            @endphp
                            @foreach ($user_company as $company)
                                @php
                                    $company_id = $company->company_id;
                                    // $company_id = 1;
                                    $sales_not_complite = DB::table("pro_sim_$company_id")
                                        ->leftjoin(
                                            'pro_company',
                                            "pro_sim_$company_id.company_id",
                                            'pro_company.company_id',
                                        )
                                        ->select("pro_sim_$company_id.*", 'pro_company.company_name')
                                        ->whereIn('status', [1])
                                        ->where('sim_date', '>', '2023-12-31')
                                        ->orderByDesc('sim_id')
                                        ->get();
                                @endphp
                                @foreach ($sales_not_complite as $key => $row)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ $row->company_name }} <br> {{ $row->sim_id }}</td>
                                        <td>{{ $row->sim_date }}</td>
                                        <td>
                                            @php
                                            $emp_name = DB::table('pro_employee_info')
                                                ->where('employee_id', $row->user_id)
                                                ->first();
                                            if($emp_name == null){
                                                $employee_name = '';
                                            }else{
                                              $employee_name = $emp_name->employee_name;  
                                            }

                                        @endphp
                                        {{ $employee_name }}
                                        </td>
                                        <td><a
                                                href="{{ route('sales_invoice_details', [$row->sim_id, $row->company_id]) }}">Next</a>
                                        </td>
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
