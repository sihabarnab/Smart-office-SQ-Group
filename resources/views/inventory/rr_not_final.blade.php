<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Receving Report Not Final</h1>
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
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Company</th>
                                <th class="text-left align-top">Project/Indent Category</th>
                                <th class="text-left align-top">Supply</th>
                                <th class="text-left align-top">Indent No / Date</th>
                                <th class="text-left align-top">RR No / Date</th>
                                <th class="text-left align-top">Challan No / Date</th>
                                <th class="text-left align-top"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $m_user_id = Auth::user()->emp_id;
                                $x = 1;
                                $user_company = DB::table('pro_user_company')
                                    ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
                                    ->select('pro_user_company.*', 'pro_company.company_name')
                                    ->Where('pro_user_company.employee_id', $m_user_id)
                                    ->Where('pro_company.inventory_status', '1')
                                    ->get();
                            @endphp

                            @foreach ($m_grr_master as $row)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>{{ $row->company_name }} </td>
                                    <td>{{ $row->project_name }} <br> {{ $row->category_name }}</td>
                                    <td>{{ $row->supplier_name }} <br> {{ $row->supplier_address }}</td>
                                    <td>{{ $row->indent_no }} <br> {{ $row->indent_date }}</td>
                                    <td>{{ $row->grr_no }} <br> {{ $row->grr_date }}</td>
                                    <td>{{ $row->chalan_no }} <br> {{ $row->chalan_date }}</td>
                                    <td> <a
                                            href="{{ route('inventory_receiving_report_details', [$row->grr_master_id, $row->company_id]) }}">Next</a>
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
