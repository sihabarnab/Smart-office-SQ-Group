@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Requsition Indent</h1>
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('FinanceFundReqStore') }}" method="Post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                            <option value="">--Company--</option>
                                            @foreach ($user_company as $company)
                                                <option value="{{ $company->company_id }}" {{old('cbo_company_id') == $company->company_id?"selected":"" }}>
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                            placeholder="From Date" value="{{ old('txt_from_date') }}"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_from_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                            placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_to_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_description" name="txt_description"
                                            placeholder="Description / Particular's" value="{{ old('txt_description') }}">
                                        @error('txt_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_transfer" name="txt_transfer"
                                            placeholder="Transfer Amount" value="{{ old('txt_transfer') }}">
                                        @error('txt_transfer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_cash" name="txt_cash"
                                            placeholder="Cash Amount" value="{{ old('txt_cash') }}">
                                        @error('txt_cash')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_chq" name="txt_chq"
                                            placeholder="Bank Amount" value="{{ old('txt_chq') }}">
                                        @error('txt_chq')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                            placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                        @error('txt_remarks')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('finance.fund_req_query_list')
        @include('finance.fund_req_nf_list')

@endsection
