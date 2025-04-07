<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Requisition Not Final</h1>
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
                                <th>Company Name.</th>
                                <th>Requisition No.</th>
                                <th>Requisition Date</th>
                                <th>Customer Name</th>
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

                                    $sales_not_complite = DB::table("pro_sales_requisition_master_$company_id")
                                        ->leftJoin(
                                            'pro_company',
                                            "pro_sales_requisition_master_$company_id.company_id",
                                            'pro_company.company_id',
                                        )
                                        ->leftJoin(
                                            "pro_customer_information_$company_id",
                                            "pro_sales_requisition_master_$company_id.customer_id",
                                            "pro_customer_information_$company_id.customer_id",
                                        )
                                        ->select(
                                            "pro_sales_requisition_master_$company_id.*",
                                            "pro_customer_information_$company_id.customer_name",
                                            'pro_company.company_name',
                                        )
                                        ->where("pro_sales_requisition_master_$company_id.status", 1)
                                        //start 2024 
                                        ->where("pro_sales_requisition_master_$company_id.requisition_date",'>', "2023-12-30")
                                        ->orderByDesc('requisition_master_id')
                                        ->get();

                                @endphp
                                @foreach ($sales_not_complite as $key => $row)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ $row->company_name }}</td>
                                        <td>{{ $row->requisition_master_id }}</td>
                                        <td>{{ $row->requisition_date }}</td>
                                        <td>
                                            {{ $row->customer_name }}</td>
                                        <td><a
                                                href="{{ route('requisition_details', [$row->requisition_master_id, $row->company_id]) }}">Next</a>
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
