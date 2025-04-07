@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">BGPG/FDR Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $fdr_name = [
            '1' => 'A Z M Shofiuddin',
            '2' => 'Shohel Ahmed',
            '3' => 'A Z M Nurul Kader',
            '4' => 'Afroza Sultana',
            '5' => 'TS PROVIDENT FUND',
        ];
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('fdr_and_bgpg_alart_list') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="0">-Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_fdr_name" name="cbo_fdr_name">
                                        <option value="">-FDR Name-</option>
                                        @foreach ($fdr_name as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_fdr_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_fdr_bgpg" name="cbo_fdr_bgpg">
                                            <option value="0">{{ "ALL" }}</option>
                                            <option value="1">{{ "FDR" }}</option>
                                            <option value="2">{{ "BGPG" }}</option>
                                    </select>
                                    @error('cbo_fdr_bgpg')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row ">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
