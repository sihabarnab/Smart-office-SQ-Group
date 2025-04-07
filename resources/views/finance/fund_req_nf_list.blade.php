<div class="container-fluid pt-1 pb-2">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="m-0">Fund Requsition List (Not Final)</h4>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requsition #</th>
                                <th>Date</th>
                                <th>Company</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_company as $row_table)
                                @php
                                    $y = $row_table->company_id;
                                    $m_fund_req_master_nf = DB::table("pro_fund_req_master_$y")
                                        ->leftjoin('pro_company', "pro_fund_req_master_$y.company_id", 'pro_company.company_id')
                                        ->select("pro_fund_req_master_$y.*", 'pro_company.company_name',)
                                        ->where("pro_fund_req_master_$y.status", '=', 1)
                                        ->where("pro_fund_req_master_$y.company_id", '=', $y)
                                        ->orderBy("pro_fund_req_master_$y.fund_req_master_id", 'DESC')
                                        ->get();

                                @endphp
                            @foreach($m_fund_req_master_nf as $key=>$row_fund_req_master_nf)

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_fund_req_master_nf->fund_req_master_id }}</td>
                                <td>{{ $row_fund_req_master_nf->fund_req_date }}</td>
                                <td>{{ $row_fund_req_master_nf->company_name }}</td>
                                <td>{{ $row_fund_req_master_nf->req_form }}</td>
                                <td>{{ $row_fund_req_master_nf->req_to }}</td>
                                <td>{{ "aaa" }}</td>
                                <td>
                                    <a href="{{ route('fund_req_detail', [$row_fund_req_master_nf->fund_req_master_id,$row_fund_req_master_nf->company_id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
