<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Money Receipt Not Final</h1>
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
                                <th>Money Receipt No</th>
                                <th>Sales Type</th>
                                <th>Date/Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $x=1;
                            @endphp
                            @foreach ($user_company as $company)
                                @php
                                    $company_id = $company->company_id;
                                    $mr_master = DB::table("pro_money_receipt_master_$company_id")
                                        ->where('status', '1')
                                        ->orderBy('mr_master_id', 'desc')
                                        ->get();
                                @endphp
                                @foreach ($mr_master as $key => $row)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ $row->mr_master_id }}</td>
                                        <td>
                                            @if ($row->sales_type == 1)
                                                {{ 'Sales' }}
                                            @elseif($row->sales_type == 2)
                                                {{ 'Repair' }}
                                            @elseif($row->sales_type == 3)
                                                {{ 'Sundry' }}
                                            @endif

                                        </td>
                                        <td>{{ $row->entry_date }} <br> {{ $row->entry_time }}</td>
                                        <td><a href="{{ route('money_receipt_details',[$row->mr_master_id,$row->company_id]) }}">Next</a>
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
