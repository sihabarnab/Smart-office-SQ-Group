@extends('layouts.finance_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent (Check)</h1>
                    {{ $m_fund_req_master->company_name }}
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

                        <div class="row">
                            <div class="col-2">
                                <label>Indent No</label>
                                <p class="form-control">{{ $m_fund_req_master->fund_req_master_id }}</p>
                            </div>
                            <div class="col-2">
                                <label>Indent Date</label>
                                <p class="form-control">{{ $m_fund_req_master->fund_req_date }}</p>
                            </div>
                            @if ($m_fund_req_master->status == 3)
                                <div class="col-4">
                                    <label>Prepared By</label>
                                    <p class="form-control">{{ $m_fund_req_master->employee_name }}</p>
                                </div>

                                <div class="col-4">
                                    <label>1st Checked</label>
                                    <p class="form-control">{{ $m_fund_req_master->first_name }}</p>
                                </div>
                            @elseif($m_fund_req_master->status == 4)
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Prepared By</label>
                                            <p class="form-control">{{ $m_fund_req_master->employee_name }}</p>
                                        </div>

                                        <div class="col-4">
                                            <label>1st Checked</label>
                                            <p class="form-control">{{ $m_fund_req_master->first_name }}</p>
                                        </div>
                                        <div class="col-4">
                                            <label>2nd Checked</label>
                                            <p class="form-control">{{ $m_fund_req_master->second_name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-8">
                                    <label>Prepared By</label>
                                    <p class="form-control">{{ $m_fund_req_master->employee_name }}</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($m_fund_req_detail->count() > 0)
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h6>{{ 'Indent Details' }}</h6>
                            </div>

                            <div class="row">
                                <div class="col-1">
                                    <label>SL No</label>
                                </div>
                                <div class="col-3">
                                    <label>Description</label>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Transfer</label>
                                        </div>
                                        <div class="col-4">
                                            <label>Cash</label>
                                        </div>
                                        <div class="col-4">
                                            <label>Bank</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <label>Attach</label>
                                </div>
                                <div class="col-1">
                                    <label>&nbsp;</label>
                                </div>
                                <div class="col-1">
                                    <label>&nbsp;</label>
                                </div>
                                <div class="col-1">
                                    <label>&nbsp;</label>
                                </div>

                            </div>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($m_fund_req_detail as $key => $value)
                                @if ($value->status == 9)
                                @else
                                    <div class="row mb-1">
                                        <div class="col-1 p-0">
                                            <input type="text" class="form-control" readonly
                                                value="{{ $i++ }}">
                                        </div>
                                        <div class="col-3 p-0">
                                            <input type="text" id="txt_description" name="txt_description"
                                                class="form-control" value="{{ $value->description }}">
                                        </div>

                                        <div class="col-4 pr-1">
                                            <div class="row">
                                                <div class="col-4 p-0">
                                                    <input type="text" id="txt_req_transfer" name="txt_req_transfer"
                                                        class="form-control text-right" value="{{ $value->req_transfer }}"
                                                        readonly>
                                                </div>

                                                <div class="col-4 p-0">
                                                    <input type="text" id="txt_req_cash" name="txt_req_cash"
                                                        class="form-control text-right" value="{{ $value->req_cash }}"
                                                        readonly>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <input type="text" id="txt_req_chq" name="txt_req_chq"
                                                        class="form-control text-right" value="{{ $value->req_chq }}"
                                                        readonly>
                                                    @error('txt_req_chq')
                                                        <div class="text-warning">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-1 pr-1">
                                            @if (isset($value->fund_req_detail_file))
                                                @php
                                                    $pdf = url(
                                                        "../docupload/sqgroup/fundreqfile/$value->fund_req_detail_file",
                                                    );
                                                @endphp

                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#PdfModal" onclick='showPDF("{{ $pdf }}")'><i
                                                        class="fas fa-eye"></i>
                                                </button>
                                            @else
                                            @endif
                                        </div>
                                        @if ($value->status == $m_status)
                                            <div class="col-1 m-0 p-0">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#okModal"
                                                    onclick='OkFunction("{{ $m_fund_req_master->company_id }}","{{ $m_fund_req_master->fund_req_master_id }}","{{ $value->fund_req_detail_id }}")'>
                                                    ok
                                                </button>
                                            </div>
                                            <div class="col-1 m-0 p-0">
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#CancelModal"
                                                    onclick='QueryFunction("{{ $m_fund_req_master->company_id }}","{{ $m_fund_req_master->fund_req_master_id }}","{{ $value->fund_req_detail_id }}")'>
                                                    query
                                                </button>
                                            </div>
                                            <div class="col-1 m-0 p-0">
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#TotalCancelModal"
                                                    onclick='TotalCancelFunction("{{ $m_fund_req_master->company_id }}","{{ $m_fund_req_master->fund_req_master_id }}","{{ $value->fund_req_detail_id }}")'>
                                                    reject
                                                </button>
                                            </div>
                                        @elseif ($value->status == 6 || $value->status == 7 || $value->status == 8)
                                            <div class="col-3 m-0 p-0">
                                                {{ 'Query' }}
                                            </div>
                                        @elseif ($value->status == 9)
                                            <div class="col-3 m-0 p-0">
                                                {{ 'Reject' }}
                                            </div>
                                        @else
                                            <div class="col-3 m-0 p-0">
                                                {{ 'Approved' }}
                                            </div>
                                        @endif

                                    </div>
                                @endif
                            @endforeach

                            <hr>
                            <div class="row mt-2">
                                <div class="col-11 m-0 p-0">
                                </div>
                                <div class="col-1 m-0 p-0">
                                    <button type="button" class="btn btn-success " data-toggle="modal"
                                        data-target="#FinalModal"
                                        onclick='Final("{{ $m_fund_req_master->company_id }}","{{ $m_fund_req_master->fund_req_master_id }}")'>
                                        Final
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="PdfModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary ">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <iframe src="" id="showPdf" width="100%" height="450px"></iframe>

            </div>
        </div>
    </div>

    <!--OK Modal -->
    <div class="modal fade" id="okModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-x">
            <form action="{{ route('FundReqCheckok') }}" method="post">
                @csrf
                <input type="hidden" name="txt_company_id" id="txt_company_id">
                <input type="hidden" name="txt_fund_req_master_id" id="txt_fund_req_master_id">
                <input type="hidden" name="txt_fund_req_detail_id" id="txt_fund_req_detail_id">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-center">Are you Confirm ?</h2>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Cancel Modal -->
    <div class="modal fade" id="CancelModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-x">
            <form action="{{ route('FundReqCheckQuery') }}" method="post">
                @csrf
                <input type="hidden" name="txt_modal_company_id" id="txt_modal_company_id">
                <input type="hidden" name="txt_modal_fund_req_master_id" id="txt_modal_fund_req_master_id">
                <input type="hidden" name="txt_modal_fund_req_detail_id" id="txt_modal_fund_req_detail_id">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="txt_query_remark" name="txt_query_remark" class="form-control"
                                    placeholder="Remark">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Total  Cancel Modal -->
    <div class="modal fade" id="TotalCancelModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-x">
            <form action="{{ route('FundReqCheckTotalCancel') }}" method="post">
                @csrf
                <input type="hidden" name="txt_tcancel_company_id" id="txt_tcancel_company_id">
                <input type="hidden" name="txt_tcancel_fund_req_master_id" id="txt_tcancel_fund_req_master_id">
                <input type="hidden" name="txt_tcancel_fund_req_detail_id" id="txt_tcancel_fund_req_detail_id">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="txt_modal_remark" name="txt_modal_remark" class="form-control"
                                    placeholder="Remark">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!--Final Modal -->
    <div class="modal fade" id="FinalModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-x">
            <form action="{{ route('FundReqCheckFinal') }}" method="post">
                @csrf
                <input type="hidden" name="txt_Final_company_id" id="txt_Final_company_id">
                <input type="hidden" name="txt_Final_fund_req_master_id" id="txt_Final_fund_req_master_id">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-center">Are you Confirm ?</h2>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        function showPDF(pdf) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }
            $('#showPdf').attr('src', '');
            if (pdf) {
                $('#showPdf').attr('src', pdf);
            } else {
                $('#showPdf').attr('src', '');
            }

        }

        function OkFunction(company_id, fund_req_master_id, fund_req_detail_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#txt_company_id').val('');
            $('#txt_fund_req_master_id').val('');
            $('#txt_fund_req_detail_id').val('');

            $('#txt_company_id').val(company_id);
            $('#txt_fund_req_master_id').val(fund_req_master_id);
            $('#txt_fund_req_detail_id').val(fund_req_detail_id);

        }

        function QueryFunction(company_id, fund_req_master_id, fund_req_detail_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#txt_modal_company_id').val('');
            $('#txt_modal_fund_req_master_id').val('');
            $('#txt_modal_fund_req_detail_id').val('');

            $('#txt_modal_company_id').val(company_id);
            $('#txt_modal_fund_req_master_id').val(fund_req_master_id);
            $('#txt_modal_fund_req_detail_id').val(fund_req_detail_id);

        }

        function TotalCancelFunction(company_id, fund_req_master_id, fund_req_detail_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#txt_tcancel_company_id').val('');
            $('#txt_tcancel_fund_req_master_id').val('');
            $('#txt_tcancel_fund_req_detail_id').val('');

            $('#txt_tcancel_company_id').val(company_id);
            $('#txt_tcancel_fund_req_master_id').val(fund_req_master_id);
            $('#txt_tcancel_fund_req_detail_id').val(fund_req_detail_id);

        }

        function Final(company_id, fund_req_master_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#txt_Final_company_id').val('');
            $('#txt_Final_fund_req_master_id').val('');

            $('#txt_Final_company_id').val(company_id);
            $('#txt_Final_fund_req_master_id').val(fund_req_master_id);

        }
    </script>
@endsection
