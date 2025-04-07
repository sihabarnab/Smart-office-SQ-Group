@extends('layouts.finance_app')
@section('content')
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
                                    <th>SL No</th>
                                    <th>Company<br>FDR Name</th>
                                    <th>Bank</th>
                                    <th> Branch</th>
                                    <th>FDR # & <br> Block #</th>
                                    <th>Issue <br> Maturity</th>
                                    <th>Period</th>
                                    <th>Principal <br> Rate</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_fdr_closing as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->company_name }}<br>
                                        
                                        @if ($row->fdr_name == 1)
                                            {{ "A Z M Shofiuddin" }}
                                        @elseif($row->fdr_name == 2)
                                            {{ "Shohel Ahmed" }}
                                        @elseif($row->fdr_name == 3)
                                            {{ "A Z M Nurul Kader" }}
                                        @elseif($row->fdr_name == 4)
                                            {{ "Afroza Sultana" }}
                                        @elseif($row->fdr_name == 5)
                                            {{ "TS PROVIDENT FUND" }}
                                        @endif
                                        </td>
                                        <td>{{ $row->bank_name }} </td>
                                        <td> {{ $row->branch_name }}</td>
                                        <td>{{ $row->fdr_no }}<br> {{ $row->block_no }}</td>
                                        <td>{{ $row->issue_date }}<br> {{ $row->maturity_date }}</td>
                                        <td>{{ $row->period }}</td>
                                        <td>{{ $row->principal_amount }}<br> {{ $row->rate }}</td>
                                        <td> <a href="{{ route('fdr_closing', $row->fdr_id) }}">Closing</a></td>
                                        <td> <a href="{{ route('fdr_renew', $row->fdr_id) }}">Renew</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
