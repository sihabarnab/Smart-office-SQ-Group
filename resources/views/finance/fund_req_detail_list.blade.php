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
                                    <td>{{ $row_fund_req_detail->description }}</td>
                                    <td style="text-align:right;">
                                        {{ number_format($row_fund_req_detail->req_transfer, 2) }}</td>
                                    <td style="text-align:right;">{{ number_format($row_fund_req_detail->req_cash, 2) }}
                                    </td>
                                    <td style="text-align:right;">{{ number_format($row_fund_req_detail->req_chq, 2) }}
                                    </td>
                                    <td style="text-align:right;">
                                        {{ number_format($row_fund_req_detail->total_amt, 2) }}</td>
                                    <td>{{ $row_fund_req_detail->remarks }}</td>
                                    <td>

                                        @if (isset($row_fund_req_detail->fund_req_detail_file))
                                            @php
                                                $pdf = url(
                                                    "../docupload/sqgroup/fundreqfile/$row_fund_req_detail->fund_req_detail_file",
                                                );
                                            @endphp

                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#PdfModal" onclick='showPDF("{{ $pdf }}")'><i
                                                    class="fas fa-eye"></i>
                                            </button>
                                        @else
                                        @endif

                                        {{--  <a target="_blank" href="{{ url("../docupload/sqgroup/fundreqfile/$row_fund_req_detail->fund_req_detail_file") }}">{{$row_fund_req_detail->fund_req_detail_file}}</a> --}}



                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#FileUpModal"
                                            onclick='OkFunction("{{ $row_fund_req_detail->company_id }}","{{ $row_fund_req_detail->fund_req_detail_id }}")'>
                                            <i class="fas fa-upload"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('FinanceFundReqDetailEdit', [$row_fund_req_detail->fund_req_detail_id, $row_fund_req_detail->company_id]) }}"
                                            class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
                                <td style="text-align: right;">{{ 'Total' }}</td>
                                <td style="text-align: right;">{{ number_format($txt_transfer, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($txt_cash, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($txt_bank, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($txt_total, 2) }}</td>
                                <td colspan="4">&nbsp;</td>

                            </tr>
                        </tfoot>
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
            <input type="hidden" name="txt_company_id" id="txt_company_id" value="{{ old('txt_company_id') }}">
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
                            <input type="text" accept=".pdf" class="form-control" id="txt_fund_req_detail_file"
                                 name="txt_fund_req_detail_file"
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


