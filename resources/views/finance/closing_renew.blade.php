@extends('layouts.finance_app')
@section('content')

    @php
        $m_employee = [
            '1' => 'A Z M Shofiuddin',
            '2' => 'Shohel Ahmed',
            '3' => 'A Z M Nurul Kader',
            '4' => 'Afroza Sultana',
            '5' => 'TS PROVIDENT FUND',
        ];
    @endphp

    @if (isset($m_fdr_closing))
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">FDR Closing</h1>
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
                            <form action="{{ route('fdr_closing_update', $m_fdr_closing->fdr_id) }}" method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                            <option value="0">-Select Company-</option>
                                            @foreach ($m_company as $value)
                                                <option value="{{ $value->company_id }}"
                                                    {{ $value->company_id == $m_fdr_closing->company_id ? 'selected' : '' }}>
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
                                                    {{ $key == $m_fdr_closing->fdr_name ? 'selected' : '' }}>
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
                                                    {{ $value->bank_id == $m_fdr_closing->bank_id ? 'selected' : '' }}>
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
                                                    {{ $value->branch_id == $m_fdr_closing->branch_id ? 'selected' : '' }}>
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
                                            value="{{ $m_fdr_closing->period }}" placeholder="PERIOD">
                                        @error('txt_period')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_fdr" name="txt_fdr"
                                            value="{{ $m_fdr_closing->fdr_no }}" placeholder="FDR DIGIT ONLY , MAX 14">
                                        @error('txt_fdr')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_block" name="txt_block"
                                            value="{{ $m_fdr_closing->block_no }}" placeholder="BLOCK DIGIT ONLY , MAX 14">
                                        @error('txt_block')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_issue_date" name="txt_issue_date"
                                            value="{{ $m_fdr_closing->issue_date }}" placeholder="ISSUE DATE"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_issue_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_maturity_date"
                                            name="txt_maturity_date" value="{{ $m_fdr_closing->maturity_date }}"
                                            placeholder="MATURITY DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_maturity_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_principle_amount"
                                            name="txt_principle_amount" value="{{ $m_fdr_closing->principal_amount }}"
                                            placeholder="PRINCIPAL AMOUNT">
                                        @error('txt_principle_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_rate" name="txt_rate"
                                            value="{{ $m_fdr_closing->rate }}" placeholder="RATE">
                                        @error('txt_rate')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="txt_closing_remark"
                                            name="txt_closing_remark" value="{{ old('txt_closing_remark') }}"
                                            placeholder="REMARK">
                                        @error('txt_closing_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_closing_date"
                                            name="txt_closing_date" value="{{ old('txt_closing_date') }}"
                                            placeholder="CLOSING DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_closing_date')
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">FDR RENEW</h1>
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
                            <form action="{{ route('fdr_renew_update', $m_fdr_renew->fdr_id) }}" method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                            <option value="0">-Select Company-</option>
                                            @foreach ($m_company as $value)
                                                <option value="{{ $value->company_id }}"
                                                    {{ $value->company_id == $m_fdr_renew->company_id ? 'selected' : '' }}>
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
                                                    {{ $key == $m_fdr_renew->fdr_name ? 'selected' : '' }}>
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
                                                    {{ $value->bank_id == $m_fdr_renew->bank_id ? 'selected' : '' }}>
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
                                                    {{ $value->branch_id == $m_fdr_renew->branch_id ? 'selected' : '' }}>
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
                                            value="{{ $m_fdr_renew->period }}" placeholder="PERIOD">
                                        @error('txt_period')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_fdr" name="txt_fdr"
                                            value="{{ $m_fdr_renew->fdr_no }}" placeholder="FDR DIGIT ONLY , MAX 14">
                                        @error('txt_fdr')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="number" class="form-control" id="txt_block" name="txt_block"
                                            value="{{ $m_fdr_renew->block_no }}" placeholder="BLOCK DIGIT ONLY , MAX 14">
                                        @error('txt_block')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_issue_date"
                                            name="txt_issue_date" value="{{ $m_fdr_renew->issue_date }}"
                                            placeholder="ISSUE DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_issue_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_maturity_date"
                                            name="txt_maturity_date" value="{{ $m_fdr_renew->maturity_date }}"
                                            placeholder="MATURITY DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_maturity_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_principle_amount"
                                            name="txt_principle_amount" value="{{ $m_fdr_renew->principal_amount }}"
                                            placeholder="PRINCIPAL AMOUNT">
                                        @error('txt_principle_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" class="form-control" id="txt_rate" name="txt_rate"
                                            value="{{ $m_fdr_renew->rate }}" placeholder="RATE">
                                        @error('txt_rate')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_renew_remark"
                                            name="txt_renew_remark" value="{{ old('txt_renew_remark') }}"
                                            placeholder="REMARK">
                                        @error('txt_renew_remark')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-10">
                                        &nbsp;
                                    </div>
                                    <div class="col-2">
                                        <button type="Submit" class="btn btn-primary btn-block">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/finance/fdr_employee_name/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_employee_id"]').empty();
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="0">-Select Employee-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_employee_id"]').append(
                                    '<option value="' + value.employee_id + '">' +
                                    value.employee_name + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
@endsection
