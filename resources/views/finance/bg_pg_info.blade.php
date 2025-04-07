@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">BG/PG Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>


    @php
        $beneficiary_type = [
            '1' => 'BREB',
            '2' => 'BPDB',
            '3' => 'DESCO',
            '4' => 'DPDC',
            '5' => 'NESCO',
            '6' => 'WZPDCL',
        ];
        $nature_bg_pg = ['1' => 'BG', '2' => 'PG', '3' => 'BB'];
        
    @endphp

    @if (isset($m_bg_pg_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('bg_pg_info_update', $m_bg_pg_edit->bgpg_id) }}" method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                            <option value="0">--Select Company--</option>
                                            @foreach ($m_company as $value)
                                                <option value="{{ $value->company_id }}"
                                                    {{ $m_bg_pg_edit->company_id == $value->company_id ? 'selected' : '' }}>
                                                    {{ $value->company_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_tender_package_no"
                                            name="txt_tender_package_no" value="{{ $m_bg_pg_edit->tender_package }}"
                                            placeholder="TENDER PACKAGE NUMBER">
                                        @error('txt_tender_package_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_beneficiary"
                                            name="txt_beneficiary" value="{{ $m_bg_pg_edit->beneficiary }}"
                                            placeholder="BENEFICIARY">
                                        @error('txt_beneficiary')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_beneficiary_type" name="cbo_beneficiary_type">
                                            <option value="0">--Select Beneficiary Type--</option>
                                            @foreach ($beneficiary_type as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $m_bg_pg_edit->beneficiary_type == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach

                                        </select>
                                        @error('cbo_beneficiary_type')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_bank_id" name="cbo_bank_id">
                                            <option value="0">--Select Bank--</option>
                                            @foreach ($m_bank as $value)
                                                <option value="{{ $value->bank_id }}"
                                                    {{ $m_bg_pg_edit->bank_id == $value->bank_id ? 'selected' : '' }}>
                                                    {{ $value->bank_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_branch_id" name="cbo_branch_id">
                                            <option value="0">--Select Branch--</option>
                                            @foreach ($m_bank_branch as $value)
                                                <option value="{{ $value->branch_id }}"
                                                    {{ $m_bg_pg_edit->branch_id == $value->branch_id ? 'selected' : '' }}>
                                                    {{ $value->branch_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_branch_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-1">

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_bgpg_no" name="txt_bgpg_no"
                                            value="{{ $m_bg_pg_edit->bgpg_no }}" placeholder="BG/PG NO.">
                                        @error('txt_bgpg_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_bgpg_amount"
                                            name="txt_bgpg_amount" value="{{ $m_bg_pg_edit->bgpg_amout }}"
                                            placeholder="BG/PG AMOUNT">
                                        @error('txt_bgpg_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_margin" name="txt_margin"
                                            value="{{ $m_bg_pg_edit->margin }}" placeholder="MARGIN (%)">
                                        @error('txt_margin')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_issue_date" name="txt_issue_date"
                                            value="{{ $m_bg_pg_edit->issue_date }}" placeholder="ISSUE DATE"
                                            onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_issue_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_expiry_date"
                                            name="txt_expiry_date" value="{{ $m_bg_pg_edit->expiry_date }}"
                                            placeholder="EXPIRY DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_expiry_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_expence" name="txt_expence"
                                            value="{{ $m_bg_pg_edit->expense }}" placeholder="EXPENCE">
                                        @error('txt_expence')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_nature_bg_pg" name="cbo_nature_bg_pg">
                                            <option value="0">--Select Nature of BG/PG--</option>
                                            @foreach ($nature_bg_pg as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $m_bg_pg_edit->nature_bgpg == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_nature_bg_pg')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @php
                                        $m_employee_info = DB::table('pro_employee_info')
                                            ->where('company_id',$m_bg_pg_edit->ref_id)
                                            ->first();
                                    @endphp
                                    <div class="col-3">
                                        <select class="form-control" id="txt_reff_name" name="txt_reff_name">
                                            <option value="{{ $m_employee_info->employee_id }}">{{ $m_employee_info->employee_name }}</option>
                                        </select>
                                        @error('txt_reff_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                            value="{{ $m_bg_pg_edit->remarks }}" placeholder="REMARKS">
                                        @error('txt_remark')
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

                            <form action="{{ route('bg_pg_info_store') }}" method="post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                            <option value="0">--Select Company--</option>
                                            @foreach ($m_company as $value)
                                                <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_tender_package_no"
                                            name="txt_tender_package_no" value="{{ old('txt_tender_package_no') }}"
                                            placeholder="TENDER PACKAGE NUMBER">
                                        @error('txt_tender_package_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_beneficiary"
                                            name="txt_beneficiary" value="{{ old('txt_beneficiary') }}"
                                            placeholder="BENEFICIARY">
                                        @error('txt_beneficiary')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_beneficiary_type"
                                            name="cbo_beneficiary_type">
                                            <option value="0">--Select Beneficiary Type--</option>
                                            @foreach ($beneficiary_type as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach

                                        </select>
                                        @error('cbo_beneficiary_type')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_bank_id" name="cbo_bank_id">
                                            <option value="0">--Select Bank--</option>
                                            @foreach ($m_bank as $value)
                                                <option value="{{ $value->bank_id }}">{{ $value->bank_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="cbo_branch_id" name="cbo_branch_id">
                                            <option value="0">--Select Branch--</option>
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

                                <div class="row mb-1">

                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_bgpg_no" name="txt_bgpg_no"
                                            value="{{ old('txt_bgpg_no') }}" placeholder="BG/PG NO.">
                                        @error('txt_bgpg_no')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_bgpg_amount"
                                            name="txt_bgpg_amount" value="{{ old('txt_bgpg_amount') }}"
                                            placeholder="BG/PG AMOUNT">
                                        @error('txt_bgpg_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_margin" name="txt_margin"
                                            value="{{ old('txt_margin') }}" placeholder="MARGIN (%)">
                                        @error('txt_margin')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_issue_date"
                                            name="txt_issue_date" value="{{ old('txt_issue_date') }}"
                                            placeholder="ISSUE DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_issue_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_expiry_date"
                                            name="txt_expiry_date" value="{{ old('txt_expiry_date') }}"
                                            placeholder="EXPIRY DATE" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_expiry_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_expence" name="txt_expence"
                                            value="{{ old('txt_expence') }}" placeholder="EXPENCE">
                                        @error('txt_expence')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_nature_bg_pg" name="cbo_nature_bg_pg">
                                            <option value="0">--Select Nature of BG/PG--</option>
                                            @foreach ($nature_bg_pg as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach

                                        </select>
                                        @error('cbo_nature_bg_pg')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="txt_reff_name" name="txt_reff_name">
                                            <option value="0">--Select Ref. Name--</option>

                                        </select>
                                        @error('txt_reff_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_remark" name="txt_remark"
                                            value="{{ old('txt_remark') }}" placeholder="REMARKS">
                                        @error('txt_remark')
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
                                            class="btn btn-primary btn-block">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('finance.bg_pg_info_list')
    @endif

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/finance/bg_pg_reff_name/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="txt_reff_name"]').empty();
                            $('select[name="txt_reff_name"]').append(
                                '<option value="0">--Select Ref. Name--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="txt_reff_name"]').append(
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
