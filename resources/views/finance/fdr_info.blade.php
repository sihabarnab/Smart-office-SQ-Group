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

    @php
        $m_employee = [
            '1' => 'A Z M Shofiuddin',
            '2' => 'Shohel Ahmed',
            '3' => 'A Z M Nurul Kader',
            '4' => 'Afroza Sultana',
            '5' => 'TS PROVIDENT FUND',
        ];
    @endphp

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_fdr_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('fdr_info_update', $m_fdr_edit->fdr_id) }}" method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                            <option value="0">-Select Company-</option>
                                            @foreach ($m_company as $value)
                                                <option value="{{ $value->company_id }}"
                                                    {{ $value->company_id == $m_fdr_edit->company_id ? 'selected' : '' }}>
                                                    {{ $value->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-3">
                                        <select class="form-control" id="cbo_employee_id" name="cbo_employee_id">
                                            <option value="0">-FDR NAME-</option>
                                            @foreach ($m_employee as $key => $value)
                                                <option value="{{ $key }}"
                                                {{ $key == $m_fdr_edit->fdr_name ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_employee_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_bank_id" name="cbo_bank_id">
                                            <option value="0">-Select Bank-</option>
                                            @foreach ($m_bank as $value)
                                                <option value="{{ $value->bank_id }}"
                                                    {{ $value->bank_id == $m_fdr_edit->bank_id ? 'selected' : '' }}>
                                                    {{ $value->bank_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_branch_id" name="cbo_branch_id">
                                            <option value="0">-Select Branch-</option>
                                            @foreach ($m_bank_branch as $value)
                                                <option value="{{ $value->branch_id }}"
                                                    {{ $value->branch_id == $m_fdr_edit->branch_id ? 'selected' : '' }}>
                                                    {{ $value->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_branch_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_period" name="txt_period"
                                            value="{{ $m_fdr_edit->period }}" placeholder="PERIOD">
                                        @error('txt_period')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_fdr" name="txt_fdr"
                                            value="{{ $m_fdr_edit->fdr_no }}" placeholder="FDR DIGIT ONLY , MAX 14">
                                        @error('txt_fdr')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_block" name="txt_block"
                                            value="{{ $m_fdr_edit->block_no }}" placeholder="BLOCK DIGIT ONLY , MAX 14">
                                        @error('txt_block')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_issue_date" name="txt_issue_date"
                                            value="{{ $m_fdr_edit->issue_date }}" placeholder="ISSUE DATE"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_issue_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_maturity_date"
                                            name="txt_maturity_date" value="{{ $m_fdr_edit->maturity_date }}"
                                            placeholder="MATURITY DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_maturity_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_principle_amount"
                                            name="txt_principle_amount" value="{{ $m_fdr_edit->principal_amount }}"
                                            placeholder="PRINCIPAL AMOUNT">
                                        @error('txt_principle_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_rate" name="txt_rate"
                                            value="{{ $m_fdr_edit->rate }}" placeholder="RATE">
                                        @error('txt_rate')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id=""
                                            class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('fdr_info_store') }}" method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                            <option value="0">-Select Company-</option>
                                            @foreach ($m_company as $value)
                                                <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_employee_id" name="cbo_employee_id">
                                            <option value="0">-FDR NAME-</option>
                                            @foreach ($m_employee as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_employee_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_bank_id" name="cbo_bank_id">
                                            <option value="0">-Select Bank-</option>
                                            @foreach ($m_bank as $value)
                                                <option value="{{ $value->bank_id }}">{{ $value->bank_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_branch_id" name="cbo_branch_id">
                                            <option value="0">-Select Branch-</option>
                                            @foreach ($m_bank_branch as $value)
                                                <option value="{{ $value->branch_id }}">{{ $value->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_branch_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_period" name="txt_period"
                                            value="{{ old('txt_period') }}" placeholder="PERIOD">
                                        @error('txt_period')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_fdr" name="txt_fdr"
                                            value="{{ old('txt_fdr') }}" placeholder="FDR DIGIT ONLY , MAX 14">
                                        @error('txt_fdr')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_block" name="txt_block"
                                            value="{{ old('txt_block') }}" placeholder="BLOCK DIGIT ONLY , MAX 14">
                                        @error('txt_block')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_issue_date"
                                            name="txt_issue_date" value="{{ old('txt_issue_date') }}"
                                            placeholder="ISSUE DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_issue_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_maturity_date"
                                            name="txt_maturity_date" value="{{ old('txt_maturity_date') }}"
                                            placeholder="MATURITY DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_maturity_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_principle_amount"
                                            name="txt_principle_amount" value="{{ old('txt_principle_amount') }}"
                                            placeholder="PRINCIPAL AMOUNT">
                                        @error('txt_principle_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_rate" name="txt_rate"
                                            value="{{ old('txt_rate') }}" placeholder="RATE">
                                        @error('txt_rate')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" id=""
                                            class="btn btn-primary btn-block">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('finance.fdr_info_list')
    @endif

@endsection

