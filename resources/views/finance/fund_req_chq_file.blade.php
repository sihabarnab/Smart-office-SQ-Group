@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Upload Cheque Scan Copy(PDF)</h1>
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
                    <div class="card-body mt-5">
                        {{-- <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div> --}}
                        <form action="{{ route('FundReqChqFileStore', [$m_cheque_issue_file->cheque_issue_id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id" readonly
                                        value="{{ $m_cheque_issue_file->company_id }}">

                                    <input type="text" class="form-control" id="txt_company_name" name="txt_company_name" readonly
                                        value="{{ $m_cheque_issue_file->company_name }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_fund_req_master_id" name="txt_fund_req_master_id" readonly
                                        value="{{ $m_cheque_issue_file->fund_req_master_id }}">

                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_cheque_no" name="txt_cheque_no" readonly
                                        value="{{ $m_cheque_issue_file->cheque_no }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_cheque_date" name="txt_cheque_date" readonly
                                        value="{{ $m_cheque_issue_file->cheque_date }}">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_customer_name" name="txt_customer_name" readonly
                                        value="{{ $m_cheque_issue_file->customer_name }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_bank" name="txt_bank"
                                        placeholder="" readonly value="{{ $m_cheque_issue_file->bank_name }}">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_branch" name="txt_branch"
                                        placeholder="" readonly value="{{ $m_cheque_issue_file->branch_name }}">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_bank" name="txt_bank"
                                        placeholder="" readonly value="{{ $m_cheque_issue_file->acc_no }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" accept=".pdf" class="form-control" id="txt_chq_file"
                                        value="" name="txt_chq_file"
                                        placeholder="Upload Cheque Scan Copy (Max 5Mb Size)." onfocus="(this.type='file')">
                                    @error('txt_chq_file')
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
@endsection
