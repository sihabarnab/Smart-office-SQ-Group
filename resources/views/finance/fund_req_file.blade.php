@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upload Scan Copy(PDF)</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

{{--     @php
        $m_employee_info = DB::table('pro_employee_info')
            ->join('pro_company', 'pro_employee_info.company_id', 'pro_company.company_id')
            ->join('pro_desig', 'pro_employee_info.desig_id', 'pro_desig.desig_id')
            ->select('pro_employee_info.*', 'pro_company.*', 'pro_desig.*')
        
            ->where('employee_id', $emp_id)
            ->first();
        
        $m_employee_biodata = DB::table('pro_employee_biodata')
            ->where('employee_id', $emp_id)
            ->first();
        
    @endphp
 --}}    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body mt-5">
                        {{-- <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div> --}}
                        <form action="{{ route('FundReqFileStore', [$m_fund_req_detail_file->fund_req_detail_id, $m_fund_req_detail_file->company_id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id" readonly
                                        value="{{ $m_fund_req_detail_file->company_id }}">

                                    <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" readonly
                                        value="{{ $m_fund_req_detail_file->company_name }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_fund_req_master_id" name="txt_fund_req_master_id" readonly
                                        value="{{ $m_fund_req_detail_file->fund_req_master_id }}">

                                    <input type="hidden" class="form-control" id="txt_fund_req_detail_id" name="txt_fund_req_detail_id" readonly
                                        value="{{ $m_fund_req_detail_file->fund_req_detail_id }}">

                                </div>
                                <div class="col-2">
                                    <input type="hidden" class="form-control" id="txt_fund_req_date" name="txt_fund_req_date" readonly
                                        value="{{ $m_fund_req_detail_file->fund_req_date }}">

                                    <input type="text" class="form-control" id="txt_from_date" name="txt_from_date" readonly
                                        value="{{ $m_fund_req_detail_file->req_form }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_to_date" name="txt_to_date" readonly
                                        value="{{ $m_fund_req_detail_file->req_to }}">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_purpose" name="txt_purpose" readonly
                                        value="">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_description" name="txt_description"
                                        placeholder="Description" readonly value="{{ $m_fund_req_detail_file->description }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_cash" name="txt_cash"
                                        placeholder="Cash Amount" readonly value="{{ $m_fund_req_detail_file->req_cash }}">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_chq" name="txt_chq"
                                        placeholder="Cheque Amount" readonly value="{{ $m_fund_req_detail_file->req_chq }}">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                        placeholder="Remarks" readonly value="{{ $m_fund_req_detail_file->remarks }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" accept=".pdf" class="form-control" id="txt_fund_req_detail_file"
                                        value="{{ old('txt_fund_req_detail_file') }}" name="txt_fund_req_detail_file"
                                        placeholder="Upload Scan Copy (Max 5Mb Size)." onfocus="(this.type='file')">
                                    @error('txt_fund_req_detail_file')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="save_event"
                                        class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>

                        
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if ($m_employee_biodata->emp_pic) --}}
        {{-- @include('/hrm/biodata_file_list') --}}
   {{--  @else
    @endif --}}
@endsection
