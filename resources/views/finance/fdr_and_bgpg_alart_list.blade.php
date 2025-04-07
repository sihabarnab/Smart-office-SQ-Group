@extends('layouts.finance_app')
@section('content')


    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_bg_pg))
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">BGPG Information</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered  table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Company</th>
                                        <th>Tender Package No</th>
                                        <th>Beneficiary</th>
                                        <th>Beneficiary Type</th>
                                        <th>Bank </th>
                                        <th>Branch</th>
                                        <th>BGPG No.</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>BGPG Amount</th>
                                        <th>Margin %</th>
                                        <th>Total Margin</th>
                                        <th>Expence</th>
                                        <th>Nature of BG/PG</th>
                                        <th>Ref. Name</th>
                                        <th>Days remain to expire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_bg_pg as $key => $raw)
                                        @php
                                            $expire_days = strtotime($raw->expiry_date) - strtotime('now');
                                            $expire_days = floor($expire_days / (60 * 60 * 24));
                                        @endphp

                                        @if ($expire_days <= 31 && $expire_days >= 0)
                                            @php
                                                // Mail::send('finance.mail', $data, function ($message) use ($data) {
                                                //     $message->to('sihab_hossain@shahrier.com', 'Shahrier Enterprise')->subject($data['contact_subject']);
                                                //     $message->from($data['contact_email'], $data['contact_name']);
                                                // });
                                            @endphp
                                        @endif


                                        @if ($expire_days < 0)
                                            <tr class="alert alert-danger">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}</td>
                                                <td>{{ $raw->tender_package }}</td>
                                                <td>{{ $raw->beneficiary }}</td>
                                                <td>{{ $raw->beneficiary_type }}</td>
                                                <td>{{ $raw->bank_name }} </td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->bgpg_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->expiry_date }}</td>
                                                <td>{{ $raw->bgpg_amout }}</td>
                                                <td>{{ $raw->margin }}</td>
                                                <td>{{ $raw->total_margin }}</td>
                                                <td>{{ $raw->expense }}</td>
                                                <td>{{ $raw->nature_bgpg }}</td>
                                                <td>{{ $raw->ref_id }}</td>
                                                <td>
                                                    {{ $expire_days }}
                                                </td>
                                            </tr>
                                        @elseif ($expire_days <= 31 && $expire_days > 0)
                                            <tr class="alert alert-warning">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}</td>
                                                <td>{{ $raw->tender_package }}</td>
                                                <td>{{ $raw->beneficiary }}</td>
                                                <td>{{ $raw->beneficiary_type }}</td>
                                                <td>{{ $raw->bank_name }} </td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->bgpg_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->expiry_date }}</td>
                                                <td>{{ $raw->bgpg_amout }}</td>
                                                <td>{{ $raw->margin }}</td>
                                                <td>{{ $raw->total_margin }}</td>
                                                <td>{{ $raw->expense }}</td>
                                                <td>{{ $raw->nature_bgpg }}</td>
                                                <td>{{ $raw->ref_id }}</td>
                                                <td>
                                                    {{ $expire_days }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}</td>
                                                <td>{{ $raw->tender_package }}</td>
                                                <td>{{ $raw->beneficiary }}</td>
                                                <td>{{ $raw->beneficiary_type }}</td>
                                                <td>{{ $raw->bank_name }} </td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->bgpg_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->expiry_date }}</td>
                                                <td>{{ $raw->bgpg_amout }}</td>
                                                <td>{{ $raw->margin }}</td>
                                                <td>{{ $raw->total_margin }}</td>
                                                <td>{{ $raw->expense }}</td>
                                                <td>{{ $raw->nature_bgpg }}</td>
                                                <td>{{ $raw->ref_id }}</td>
                                                <td>
                                                    {{ $expire_days }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(isset($m_fdr))
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">FDR Information</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered  table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Company<br>FDR Name</th>
                                        <th>Bank </th>
                                        <th>Branch</th>
                                        <th>FDR </th>
                                        <th>Block #</th>
                                        <th>Issue Date </th>
                                        <th>Maturity Date</th>
                                        <th>Days remain to expire</th>
                                        <th>Period</th>
                                        <th>Principal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($m_fdr as $key => $raw)
                                        @php
                                            $maturity_days = strtotime($raw->maturity_date) - strtotime('now');
                                            $expire_days = floor($maturity_days / (60 * 60 * 24));
                                        @endphp

                                        @if ($expire_days <= 31 && $expire_days >= 0)
                                            @php
                                                // Mail::send('finance.mail', $data, function ($message) use ($data) {
                                                //     $message->to('sihab_hossain@shahrier.com', 'Shahrier Enterprise')->subject($data['contact_subject']);
                                                //     $message->from($data['contact_email'], $data['contact_name']);
                                                // });
                                            @endphp
                                        @endif


                                        @if ($expire_days < 0)
                                            <tr class="alert alert-danger">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}<br>
                                                    @if ($raw->fdr_name == 1)
                                                        {{ "A Z M Shofiuddin" }}
                                                    @elseif($raw->fdr_name == 2)
                                                        {{ "Shohel Ahmed" }}
                                                    @elseif($raw->fdr_name == 3)
                                                        {{ "A Z M Nurul Kader" }}
                                                    @elseif($raw->fdr_name == 4)
                                                        {{ "Afroza Sultana" }}
                                                    @elseif($raw->fdr_name == 5)
                                                        {{ "TS PROVIDENT FUND" }}
                                                    @endif
                                                </td>
                                                <td>{{ $raw->bank_name }}</td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->fdr_no }}</td>
                                                <td>{{ $raw->block_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->maturity_date }}</td>
                                                <td> {{ $expire_days }} </td>
                                                <td>{{ $raw->period }}</td>
                                                <td>{{ $raw->principal_amount }}</td>
                                            </tr>
                                        @elseif ($expire_days <= 31 && $expire_days > 0)
                                            <tr class="alert alert-warning">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}<br>
                                                    @if ($raw->fdr_name == 1)
                                                        {{ "A Z M Shofiuddin" }}
                                                    @elseif($raw->fdr_name == 2)
                                                        {{ "Shohel Ahmed" }}
                                                    @elseif($raw->fdr_name == 3)
                                                        {{ "A Z M Nurul Kader" }}
                                                    @elseif($raw->fdr_name == 4)
                                                        {{ "Afroza Sultana" }}
                                                    @elseif($raw->fdr_name == 5)
                                                        {{ "TS PROVIDENT FUND" }}
                                                    @endif
                                                </td>
                                                <td>{{ $raw->bank_name }}</td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->fdr_no }}</td>
                                                <td>{{ $raw->block_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->maturity_date }}</td>
                                                <td> {{ $expire_days }} </td>
                                                <td>{{ $raw->period }}</td>
                                                <td>{{ $raw->principal_amount }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}<br>
                                                    @if ($raw->fdr_name == 1)
                                                        {{ "A Z M Shofiuddin" }}
                                                    @elseif($raw->fdr_name == 2)
                                                        {{ "Shohel Ahmed" }}
                                                    @elseif($raw->fdr_name == 3)
                                                        {{ "A Z M Nurul Kader" }}
                                                    @elseif($raw->fdr_name == 4)
                                                        {{ "Afroza Sultana" }}
                                                    @elseif($raw->fdr_name == 5)
                                                        {{ "TS PROVIDENT FUND" }}
                                                    @endif
                                                </td>
                                                <td>{{ $raw->bank_name }}</td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->fdr_no }}</td>
                                                <td>{{ $raw->block_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->maturity_date }}</td>
                                                <td> {{ $expire_days }} </td>
                                                <td>{{ $raw->period }}</td>
                                                <td>{{ $raw->principal_amount }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- //BGPG --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">BGPG Information</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data1" class="table table-bordered  table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Company</th>
                                        <th>Tender Package No</th>
                                        <th>Beneficiary</th>
                                        <th>Beneficiary Type</th>
                                        <th>Bank </th>
                                        <th>Branch</th>
                                        <th>BGPG No.</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>BGPG Amount</th>
                                        <th>Margin %</th>
                                        <th>Total Margin</th>
                                        <th>Expence</th>
                                        <th>Nature of BG/PG</th>
                                        <th>Ref. Name</th>
                                        <th>Days remain to expire</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_bg_pg as $key => $raw)
                                        @php
                                            $expire_days = strtotime($raw->expiry_date) - strtotime('now');
                                            $expire_days = floor($expire_days / (60 * 60 * 24));
                                        @endphp

                                        @if ($expire_days <= 31 && $expire_days >= 0)
                                            @php
                                                // Mail::send('finance.mail', $data, function ($message) use ($data) {
                                                //     $message->to('sihab_hossain@shahrier.com', 'Shahrier Enterprise')->subject($data['contact_subject']);
                                                //     $message->from($data['contact_email'], $data['contact_name']);
                                                // });
                                            @endphp
                                        @endif


                                        @if ($expire_days < 0)
                                            <tr class="alert alert-danger">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}</td>
                                                <td>{{ $raw->tender_package }}</td>
                                                <td>{{ $raw->beneficiary }}</td>
                                                <td>{{ $raw->beneficiary_type }}</td>
                                                <td>{{ $raw->bank_name }} </td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->bgpg_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->expiry_date }}</td>
                                                <td>{{ $raw->bgpg_amout }}</td>
                                                <td>{{ $raw->margin }}</td>
                                                <td>{{ $raw->total_margin }}</td>
                                                <td>{{ $raw->expense }}</td>
                                                <td>{{ $raw->nature_bgpg }}</td>
                                                <td>{{ $raw->ref_id }}</td>
                                                <td>
                                                    {{ $expire_days }}
                                                </td>
                                            </tr>
                                        @elseif ($expire_days <= 31 && $expire_days > 0)
                                            <tr class="alert alert-warning">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}</td>
                                                <td>{{ $raw->tender_package }}</td>
                                                <td>{{ $raw->beneficiary }}</td>
                                                <td>{{ $raw->beneficiary_type }}</td>
                                                <td>{{ $raw->bank_name }} </td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->bgpg_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->expiry_date }}</td>
                                                <td>{{ $raw->bgpg_amout }}</td>
                                                <td>{{ $raw->margin }}</td>
                                                <td>{{ $raw->total_margin }}</td>
                                                <td>{{ $raw->expense }}</td>
                                                <td>{{ $raw->nature_bgpg }}</td>
                                                <td>{{ $raw->ref_id }}</td>
                                                <td>
                                                    {{ $expire_days }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}</td>
                                                <td>{{ $raw->tender_package }}</td>
                                                <td>{{ $raw->beneficiary }}</td>
                                                <td>{{ $raw->beneficiary_type }}</td>
                                                <td>{{ $raw->bank_name }} </td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->bgpg_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->expiry_date }}</td>
                                                <td>{{ $raw->bgpg_amout }}</td>
                                                <td>{{ $raw->margin }}</td>
                                                <td>{{ $raw->total_margin }}</td>
                                                <td>{{ $raw->expense }}</td>
                                                <td>{{ $raw->nature_bgpg }}</td>
                                                <td>{{ $raw->ref_id }}</td>
                                                <td>
                                                    {{ $expire_days }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- //FDR --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">FDR Information</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="data2" class="table table-bordered  table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Company</th>
                                        <th>Bank </th>
                                        <th>Branch</th>
                                        <th>FDR </th>
                                        <th>Block #</th>
                                        <th>Issue Date </th>
                                        <th>Maturity Date</th>
                                        <th>Days remain to expire</th>
                                        <th>Period</th>
                                        <th>Principal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_fdr as $key => $raw)
                                        @php
                                            $maturity_days = strtotime($raw->maturity_date) - strtotime('now');
                                            $expire_days = floor($maturity_days / (60 * 60 * 24));
                                        @endphp

                                        @if ($expire_days <= 31 && $expire_days >= 0)
                                            @php
                                                // Mail::send('finance.mail', $data, function ($message) use ($data) {
                                                //     $message->to('sihab_hossain@shahrier.com', 'Shahrier Enterprise')->subject($data['contact_subject']);
                                                //     $message->from($data['contact_email'], $data['contact_name']);
                                                // });
                                            @endphp
                                        @endif


                                        @if ($expire_days < 0)
                                            <tr class="alert alert-danger">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}<br>
                                                    @if ($raw->fdr_name == 1)
                                                        {{ "A Z M Shofiuddin" }}
                                                    @elseif($raw->fdr_name == 2)
                                                        {{ "Shohel Ahmed" }}
                                                    @elseif($raw->fdr_name == 3)
                                                        {{ "A Z M Nurul Kader" }}
                                                    @elseif($raw->fdr_name == 4)
                                                        {{ "Afroza Sultana" }}
                                                    @elseif($raw->fdr_name == 5)
                                                        {{ "TS PROVIDENT FUND" }}
                                                    @endif
                                                </td>
                                                <td>{{ $raw->bank_name }}</td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->fdr_no }}</td>
                                                <td>{{ $raw->block_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->maturity_date }}</td>
                                                <td> {{ $expire_days }} </td>
                                                <td>{{ $raw->period }}</td>
                                                <td>{{ $raw->principal_amount }}</td>
                                            </tr>
                                        @elseif ($expire_days <= 31 && $expire_days > 0)
                                            <tr class="alert alert-warning">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}<br>
                                                    @if ($raw->fdr_name == 1)
                                                        {{ "A Z M Shofiuddin" }}
                                                    @elseif($raw->fdr_name == 2)
                                                        {{ "Shohel Ahmed" }}
                                                    @elseif($raw->fdr_name == 3)
                                                        {{ "A Z M Nurul Kader" }}
                                                    @elseif($raw->fdr_name == 4)
                                                        {{ "Afroza Sultana" }}
                                                    @elseif($raw->fdr_name == 5)
                                                        {{ "TS PROVIDENT FUND" }}
                                                    @endif
                                                </td>
                                                <td>{{ $raw->bank_name }}</td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->fdr_no }}</td>
                                                <td>{{ $raw->block_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->maturity_date }}</td>
                                                <td> {{ $expire_days }} </td>
                                                <td>{{ $raw->period }}</td>
                                                <td>{{ $raw->principal_amount }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $raw->company_name }}<br>
                                                    @if ($raw->fdr_name == 1)
                                                        {{ "A Z M Shofiuddin" }}
                                                    @elseif($raw->fdr_name == 2)
                                                        {{ "Shohel Ahmed" }}
                                                    @elseif($raw->fdr_name == 3)
                                                        {{ "A Z M Nurul Kader" }}
                                                    @elseif($raw->fdr_name == 4)
                                                        {{ "Afroza Sultana" }}
                                                    @elseif($raw->fdr_name == 5)
                                                        {{ "TS PROVIDENT FUND" }}
                                                    @endif
                                                </td>
                                                <td>{{ $raw->bank_name }}</td>
                                                <td>{{ $raw->branch_name }}</td>
                                                <td>{{ $raw->fdr_no }}</td>
                                                <td>{{ $raw->block_no }}</td>
                                                <td>{{ $raw->issue_date }}</td>
                                                <td>{{ $raw->maturity_date }}</td>
                                                <td> {{ $expire_days }} </td>
                                                <td>{{ $raw->period }}</td>
                                                <td>{{ $raw->principal_amount }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
