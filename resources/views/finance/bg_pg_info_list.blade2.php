<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">BG/PG Info List</h1>
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
                                <th>Company</th>
                                <th>Tender Package No</th>
                                <th>Beneficiary</th>
                                <th>Beneficiary Type</th>
                                <th>Bank <br> Branch</th>
                                <th>BGPG No.</th>
                                <th>Issue Date</th>
                                <th>Expiry Date</th>
                                <th>BGPG Amount</th>
                                <th>Margin %</th>
                                <th>Total Margin</th>
                                <th>Expence</th>
                                <th>Nature of BG/PG</th>
                                <th>Ref. Name</th>
                                <th>Remarks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($m_bg_pg as $key => $raw)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $raw->company_name }}</td>
                                    <td>{{ $raw->tender_package }}</td>
                                    <td>{{ $raw->beneficiary }}</td>
                                    <td>{{ $raw->beneficiary_type }}</td>
                                    <td>{{ $raw->bank_name }} <br> {{ $raw->branch_name }}</td>
                                    <td>{{ $raw->bgpg_no }}</td>
                                    <td>{{ $raw->issue_date }}</td>
                                    <td>{{ $raw->expiry_date }}</td>
                                    <td>{{ $raw->bgpg_amout }}</td>
                                    <td>{{ $raw->margin }}</td>
                                    <td>{{ $raw->total_margin }}</td>
                                    <td>{{ $raw->expense }}</td>
                                    <td>{{ $raw->nature_bgpg }}</td>
                                    <td>{{ $raw->ref_id }}</td>
                                    <td>{{ $raw->remarks }}</td>
                                    <td> <a href="{{ route('bg_pg_info_edit', $raw->bgpg_id) }}">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
