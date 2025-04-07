<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quatation(Not Final)</h1>
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
                                <th>Date<br>Qutation Number</th>
                                <th>Customer Name</th>
                                <th>Customer Address</th>
                                <th>Valid</th>
                                <th>Subject</th>
                                <th>Ref. Info</th>
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
                                    $all_quotation_master = DB::table("pro_quotation_master_$company_id")
                                        ->where('status', 1)
                                        ->orderBydesc('quotation_id')
                                        ->get();
                                @endphp
                                @foreach ($all_quotation_master as $key => $row)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ $row->quotation_date }}<br> {{ $row->quotation_master_id }}</td>
                                        <td>{{ $row->customer_name }}</td>
                                        <td>{{ $row->customer_address }}</td>
                                        <td>{{ $row->offer_valid }}</td>
                                        <td>{{ $row->subject }}</td>
                                        <td>{{ $row->reference }}<br> {{ $row->reference_mobile }}</td>
                                        <td> <a
                                                href="{{ route('quotation_details', [$row->quotation_id, $row->company_id]) }}">Edit</a>
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