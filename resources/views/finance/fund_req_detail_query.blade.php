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

    @if (isset($m_fund_req_detail_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form
                                action="{{ route('FinanceFundReqDetailReUpdate', [$m_fund_req_detail_edit->fund_req_detail_id, $m_fund_req_detail_edit->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id"
                                            readonly value="{{ $m_fund_req_detail_edit->company_id }}">

                                        <input type="text" class="form-control" id="txt_company_name"
                                            name="txt_company_name" readonly
                                            value="{{ $m_fund_req_detail_edit->company_name }}" redonly>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_fund_req_master_id"
                                            name="txt_fund_req_master_id"
                                            value="{{ $m_fund_req_detail_edit->fund_req_master_id }}" redonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" id="txt_fund_req_date"
                                            name="txt_fund_req_date" readonly
                                            value="{{ $m_fund_req_detail_edit->fund_req_date }}">

                                        <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                            readonly value="{{ $m_fund_req_detail_edit->req_form }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                            readonly value="{{ $m_fund_req_detail_edit->req_to }}">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="txt_description"
                                            name="txt_description" placeholder="Description / Particular's"
                                            value="{{ $m_fund_req_detail_edit->description }}">
                                        @error('txt_description')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_transfer" name="txt_transfer"
                                            placeholder="Transfer Amount"
                                            value="{{ $m_fund_req_detail_edit->req_transfer }}">
                                        @error('txt_transfer')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_cash" name="txt_cash"
                                            placeholder="Cash Amount" value="{{ $m_fund_req_detail_edit->req_cash }}">
                                        @error('txt_cash')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_chq" name="txt_chq"
                                            placeholder="Bank Amount" value="{{ $m_fund_req_detail_edit->req_chq }}">
                                        @error('txt_chq')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                            placeholder="Remarks" value="{{ $m_fund_req_detail_edit->remarks }}">
                                        @error('txt_remarks')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2"></div>
                                    <div class="col-8">

                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="form-control  bg-primary">Update</button>
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
                            <table id="" class="table table-border table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Description / Particular's</th>
                                        <th style="text-align:right;">Transfer(A)</th>
                                        <th style="text-align:right;">Cash(B)</th>
                                        <th style="text-align:right;">Cheque(C)</th>
                                        <th style="text-align:right;">Total (B+C)</th>
                                        <th>Remarks</th>
                                        <th>Attach</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $txt_transfer = 0;
                                        $txt_cash = 0;
                                        $txt_bank = 0;
                                        $txt_total = 0;
                                    @endphp

                                    @foreach ($m_fund_req_detail as $key => $row_fund_req_detail)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row_fund_req_detail->description }} </td>
                                            <td style="text-align:right;">
                                                {{ number_format($row_fund_req_detail->req_transfer, 2) }}</td>
                                            <td style="text-align:right;">
                                                {{ number_format($row_fund_req_detail->req_cash, 2) }}
                                            </td>
                                            <td style="text-align:right;">
                                                {{ number_format($row_fund_req_detail->req_chq, 2) }}
                                            </td>
                                            <td style="text-align:right;">
                                                {{ number_format($row_fund_req_detail->total_amt, 2) }}
                                            </td>
                                            <td>{{ $row_fund_req_detail->remarks }}</td>
                                            <td>

                                                @if (isset($row_fund_req_detail->fund_req_detail_file))
                                                    @php
                                                        $pdf = url(
                                                            "../docupload/sqgroup/fundreqfile/$row_fund_req_detail->fund_req_detail_file",
                                                        );
                                                    @endphp

                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#PdfModal"
                                                        onclick='showPDF("{{ $pdf }}")'><i
                                                            class="fas fa-eye"></i>
                                                    </button>
                                                @else
                                                @endif

                                            </td>
                                            <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#FileUpModal"
                                                        onclick='OkFunction("{{ $row_fund_req_detail->company_id }}","{{ $row_fund_req_detail->fund_req_detail_id }}")'>
                                                        <i class="fas fa-upload"></i>
                                                    </button>
                                                
                                            </td>
                                            <td> 
                                                @if($row_fund_req_detail->status == 9)
                                                <h6 style="color:red;">{{"Reject"}}</h6>
                                                @elseif ($row_fund_req_detail->status == 3 || $row_fund_req_detail->status == 4 || $row_fund_req_detail->status == 5)
                                                {{"Approved"}}
                                                @else
                                                <a href="{{ route('FinanceFundReqDetailReEdit', [$row_fund_req_detail->fund_req_detail_id, $row_fund_req_detail->company_id]) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                        @php
                                            $txt_transfer_01 = $row_fund_req_detail->req_transfer;
                                            $txt_cash_01 = $row_fund_req_detail->req_cash;
                                            $txt_bank_01 = $row_fund_req_detail->req_chq;
                                            $txt_total_01 = $row_fund_req_detail->total_amt;

                                            $txt_transfer = $txt_transfer + $txt_transfer_01;
                                            $txt_cash = $txt_cash + $txt_cash_01;
                                            $txt_bank = $txt_bank + $txt_bank_01;
                                            $txt_total = $txt_total + $txt_total_01;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="text-align: right;">{{ 'Total' }}</td>
                                        <td style="text-align: right;">{{ number_format($txt_transfer, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($txt_cash, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($txt_bank, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($txt_total, 2) }}</td>
                                        <td colspan="2">&nbsp;</td>
                                        <td>
                                            <button type="button" class="btn btn-success " data-toggle="modal"
                                                data-target="#FinalModal"
                                                onclick='Final("{{ $m_fund_req_master->company_id }}","{{ $m_fund_req_master->fund_req_master_id }}")'>
                                                Final
                                            </button>
                                        </td>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Query/Reject</h1>
                    </div><!-- /.col -->
    
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="" class="table table-border table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th width='5%'>SL</th>
                                        <th width='20%'>Query</th>
                                        <th width='20%'>Reject</th>
                                        <th width='55%'>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($m_fund_req_detail as $key => $row_fund_req_detail)
                                        @if (
                                            $row_fund_req_detail->status == 6 ||
                                                $row_fund_req_detail->status == 7 ||
                                                $row_fund_req_detail->status == 8 ||
                                                $row_fund_req_detail->status == 9)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>

                                                <td>
                                                    @php
                                                        if (isset($row_fund_req_detail->query_user_id)) {
                                                            $emp = DB::table('pro_employee_info')
                                                                ->where('company_id', $row_fund_req_detail->company_id)
                                                                ->where(
                                                                    'employee_id',
                                                                    $row_fund_req_detail->query_user_id,
                                                                )
                                                                ->select('employee_name')
                                                                ->first();
                                                            $employee_name = $emp == null ? '' : $emp->employee_name;
                                                        } else {
                                                            $employee_name = '';
                                                        }
                                                    @endphp
                                                     {{$row_fund_req_detail->query_user_id}} <br>
                                                    {{ $employee_name }}
                                                </td>

                                                <td>
                                                    @php
                                                        if (isset($row_fund_req_detail->reject_user_id)) {
                                                            $emp_re = DB::table('pro_employee_info')
                                                                ->where('company_id', $row_fund_req_detail->company_id)
                                                                ->where(
                                                                    'employee_id',
                                                                    $row_fund_req_detail->reject_user_id,
                                                                )
                                                                ->select('employee_name')
                                                                ->first();
                                                            $re_employee_name = $emp_re == null ? '' : $emp_re->employee_name;
                                                        } else {
                                                            $re_employee_name = '';
                                                        }
                                                    @endphp
                                                    {{$row_fund_req_detail->reject_user_id}} <br>
                                                    {{$re_employee_name}}
                                                </td>

                                                </td>
                                                <td>
                                                    @isset($row_fund_req_detail->reject_remarks)
                                                    Reject: <br>
                                                      {{$row_fund_req_detail->reject_remarks}} <br>
                                                    @endisset
                                                    @isset($row_fund_req_detail->query_remarks)
                                                    Query: <br>
                                                      {{$row_fund_req_detail->query_remarks}}
                                                    @endisset
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

        <!-- File Upload Modal -->
        <div class="modal fade" id="FileUpModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-x">
                <form action="{{ route('FundReqFileStore') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="txt_company_id" id="txt_company_id"
                        value="{{ old('txt_company_id') }}">
                    <input type="hidden" name="txt_fund_req_detail_id" id="txt_fund_req_detail_id"
                        value="{{ old('txt_fund_req_detail_id') }}">
                    <div class="modal-content">
                        <div class="modal-header bg-primary ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" accept=".pdf" class="form-control"
                                        id="txt_fund_req_detail_file" name="txt_fund_req_detail_file"
                                        placeholder="Upload Scan Copy (Max 5Mb Size)." onfocus="(this.type='file')">
                                    @error('txt_fund_req_detail_file')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
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
                <form action="{{ route('FinanceFundReqDetailReFinal') }}" method="post">
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
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var fff = "{{ $errors->first('txt_fund_req_detail_file') }}";
            if (fff) {
                var element = document.querySelector(".ctm_anim");
                if (element) {
                    element.classList.remove("ctm_anim");
                }
                $('#FileUpModal').modal('show');

            }

        });


        function OkFunction(company_id, fund_req_detail_id) {
            var element = document.querySelector(".ctm_anim");
            if (element) {
                element.classList.remove("ctm_anim");
            }

            $('#txt_company_id').val('');
            $('#txt_fund_req_detail_id').val('');

            $('#txt_company_id').val(company_id);
            $('#txt_fund_req_detail_id').val(fund_req_detail_id);

        }

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
