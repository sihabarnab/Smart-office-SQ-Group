<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cheque Details</h3>
                </div>
                <div class="card-body">
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Bank</th>
                                <th>Type</th>
                                <th>Pay To</th>
                                <th>Cheque #</th>
                                <th>Date</th>
                                <th style="text-align:right;">Amount</th>
                                <th>Remarks</th>
                                <th>Attach</th>
                                <th>upload</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $txt_amount=0;
                            $txt_total_amount=0;
                            @endphp

                            @foreach($m_cheque_issue as $key1=>$row_cheque_issue)
                            @php 
                            if($row_cheque_issue->chq_type==1)
                            {
                                $txt_chq_type="Party Cheque";
                            } else if ($row_cheque_issue->chq_type==2){
                                $txt_chq_type="Cash Cheque";
                            } else if ($row_cheque_issue->chq_type==3){
                                $txt_chq_type="Transfer Cheque";
                            }

                            @endphp
                            <tr>
                                <td>{{ $key1+1 }}</td>
                                <td>{{ $row_cheque_issue->bank_sname }}<br>{{ $row_cheque_issue->branch_name }}<br>{{ $row_cheque_issue->acc_no }}</td>
                                <td>{{ $txt_chq_type }}</td>
                                <td>{{ $row_cheque_issue->customer_name }}</td>
                                <td>{{ $row_cheque_issue->cheque_no }}</td>
                                <td>{{ $row_cheque_issue->cheque_date }}</td>
                                <td style="text-align:right;">{{ number_format($row_cheque_issue->ammount,2) }}</td>
                                <td>{{ $row_cheque_issue->remarks }}</td>
                                <td>
                                   @if(isset($row_cheque_issue->chq_file))
                                    @php
                                      $pdf = url("../docupload/sqgroup/fundreqfile/cheque/$row_cheque_issue->chq_file");
                                    @endphp

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PdfModal" onclick='showPDF("{{$pdf}}")'><i class="fas fa-eye"></i>
                                    </button>
                                    @else

                                    @endif
                                    
                                </td>
                                @if($row_cheque_issue->status == 2)
                                <td></td>
                                <td></td>
                                @else
                                <td>
                                    <a href="{{ route('FundReqChqFile',[$row_cheque_issue->cheque_issue_id,$row_cheque_issue->fund_req_master_id]) }}" class="btn btn-info btn-sm"><i class="fas fa-upload"></i></a>                                    
                                </td>
                                <td>
                                    <a href="{{ route('FinanceFundReqBankEdit',[$row_cheque_issue->cheque_issue_id,$row_cheque_issue->company_id]) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                </td>
                                @endif

                            </tr>
                            @php
                            $txt_amount_01=$row_cheque_issue->ammount;

                            $txt_amount=$txt_amount+$txt_amount_01;
                            @endphp

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">{{ "Total" }}</td>
                                <td style="text-align: right;">{{ number_format($txt_amount,2) }}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Requsition Details</h3>
                </div>
                <div class="card-body">
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Description</th>
                                <th style="text-align:right;">Transfer</th>
                                <th style="text-align:right;">Cash</th>
                                <th style="text-align:right;">Bank</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $txt_transfer=0;
                            $txt_cash=0;
                            $txt_bank=0;
                            @endphp

                            @foreach($m_fund_req_detail as $key=>$row_fund_req_detail)

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_fund_req_detail->description }}</td>
                                <td style="text-align:right;">{{ number_format($row_fund_req_detail->req_transfer,2) }}</td>
                                <td style="text-align:right;">{{ number_format($row_fund_req_detail->req_cash,2) }}</td>
                                <td style="text-align:right;">{{ number_format($row_fund_req_detail->req_chq,2) }}</td>
                            </tr>
                            @php
                            $txt_transfer_01=$row_fund_req_detail->req_transfer;
                            $txt_cash_01=$row_fund_req_detail->req_cash;
                            $txt_bank_01=$row_fund_req_detail->req_chq;

                            $txt_transfer=$txt_transfer+$txt_transfer_01;
                            $txt_cash=$txt_cash+$txt_cash_01;
                            $txt_bank=$txt_bank+$txt_bank_01;
                            @endphp

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="text-align: right;">{{ "Total" }}</td>
                                <td style="text-align: right;">{{ number_format($txt_transfer,2) }}</td>
                                <td style="text-align: right;">{{ number_format($txt_cash,2) }}</td>
                                <td style="text-align: right;">{{ number_format($txt_bank,2) }}</td>
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

