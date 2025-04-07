@if(isset($ci_itassets))

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">IT Asset</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Company Name<br>Asset ID</th>
                                <th>Supplier/Invoice<br />Date</th>
                                <th>Description</th>
                                <th>Serial/Warranty</th>
                                <th>Issue/Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ci_itassets as $key=>$row_itassets)
                            @php

                            $ci_itasset_issue  = DB::table('pro_itasset_issue')
                            ->leftJoin('pro_employee_info', 'pro_itasset_issue.employee_id', 'pro_employee_info.employee_id')
                            ->select('pro_itasset_issue.*', 'pro_employee_info.employee_name')
                            ->where('pro_itasset_issue.itasset_id',$row_itassets->itasset_id)
                            ->where('pro_itasset_issue.valid',1)
                            ->first();
                            if($ci_itasset_issue==NULL)
                            {
                                $m_employee_name="N/A";
                                $m_issue_date="N/A";
                            } else {
                                $m_employee_name=$ci_itasset_issue->employee_name;
                                $m_issue_date=$ci_itasset_issue->issue_date;
                            }

                            @endphp


                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_itassets->company_name }}<br>{{ $row_itassets->itasset_id }}</td>
                                <td>{{ $row_itassets->supplier_name }}<br>{{ $row_itassets->sinv_no }}<br>{{ $row_itassets->sinv_date }}</td>
                                <td>{{ $row_itassets->product_type_name }} {{ $row_itassets->brand_name }}</td>
                                <td>{{ $row_itassets->serial }}<br>{{ $row_itassets->warranty_year }} {{'year'}}</td>
                                <td>{{ $m_employee_name }}<br>{{ $m_issue_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@endif