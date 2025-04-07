@extends('layouts.finance_app')

@section('content')
    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $company = DB::table('pro_company')
            ->where('company_id', $m_fund_req_master->company_id)
            ->first();
        $company_name = $company == null ? '' : $company->company_name;
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-10">&nbsp;
                        </div>
                        <div class="col-1">
                            <a href="{{ route('rpt_fund_indent_excel', [$m_fund_req_master->fund_req_master_id, $m_fund_req_master->company_id]) }}"
                                class=" btn btn-success">Excel</a>
                        </div>
                        <div class="col-1">
                            <a href="{{ route('rpt_fund_indent_print', [$m_fund_req_master->fund_req_master_id, $m_fund_req_master->company_id]) }}"
                                class="btn btn-info"> Print </a>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <div class="col-12">
                            <div class=" pt-3" class="text-center">
                                <h2 class="text-center">{{ $company_name }}</h2>
                                <h4 class="text-center">Fund Indent</h4>

                            </div>
                            <div class="row ">
                                <div class="col-2"></div>
                                <div class="col-6">
                                    Indent No : {{ $m_fund_req_master->fund_req_master_id }} <br>
                                    From Date : {{ $m_fund_req_master->req_form }} <br>
                                </div>
                                <div class="col-4">
                                    Indent Date : {{ $m_fund_req_master->fund_req_date }} <br>
                                    To Date : {{ $m_fund_req_master->req_to }} <br>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-left align-top">SL No.</th>
                                <th class="text-left align-top">Description</th>
                                <th class="text-right align-top">Transfer</th>
                                <th class="text-right align-top">Cash</th>
                                <th class="text-right align-top">Bank</th>
                                <th class="text-left align-top">Remarks</th>
                                <th class="text-left align-top">Attach</th>
                                <th class="text-left align-top"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $txt_transfer = 0;
                                $txt_cash = 0;
                                $txt_bank = 0;
                                $txt_total = 0;
                            @endphp

                            @foreach ($m_fund_req_detail as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->description }}</td>
                                    <td style="text-align: right;">{{ $value->req_transfer }}</td>
                                    <td style="text-align: right;">{{ $value->req_cash }}</td>
                                    <td style="text-align: right;">{{ $value->req_chq }}</td>
                                    <td>{{ $value->remarks }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        @if ($value->status == 5)
                                            {{ 'Approved' }}
                                        @elseif($value->status == 9)
                                            {{ 'Reject' }}
                                            @isset($value->reject_user_id)
                                                <br>{{ $value->reject_user_id }}
                                            @endisset
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $txt_transfer_01 = $value->req_transfer;
                                    $txt_cash_01 = $value->req_cash;
                                    $txt_bank_01 = $value->req_chq;
                                    $txt_total_01 = $value->total_amt;

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
                                <td style="text-align: right;">&nbsp;</td>
                                <td>&nbsp;</td>

                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
       
        @if($ci_cheque_issue->count()>0)
        <h4 class="text-center p-2">Cheque Details</h4>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <div class="">
                            <table  class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Company</th>
                                        <th>Issue Date</th>
                                        <th>Customer</th>
                                        <th>Particulars</th>
                                        <th>Account Number</th>
                                        <th>Cheque Date</th>
                                        <th>Cheque Number</th>
                                        <th>Bank/Branch</th>
                                        <th>Ammount</th>
                                    </tr>
                                </thead>
                                <tbody>
        
                                    @foreach($ci_cheque_issue as $key=>$row_cheque_issue)
                                    @php
                                    $ci_company=DB::table('pro_company')->Where('company_id',$row_cheque_issue->company_id)->first();
                                    $txt_company_name=$ci_company->company_name;
        
                                    if($row_cheque_issue->acc_id=='0')
                                    {
                                      $txt_acc_no="N/A";  
                                    } else {
                                    $ci_bank_acc=DB::table('pro_bank_acc')->Where('acc_id',$row_cheque_issue->acc_id)->first();
                                    $txt_acc_no=$ci_bank_acc->acc_no;
                                    }
        
                                    if($row_cheque_issue->cheque_details_id=='0')
                                    {
                                      $txt_cheque_no="N/A";  
                                    } else {
                                    $ci_cheque_details=DB::table('pro_cheque_details')->Where('cheque_details_id',$row_cheque_issue->cheque_details_id)->first();
                                    $txt_cheque_no=$ci_cheque_details->cheque_no;
                                    }
        
                                    if($row_cheque_issue->bank_details_id=='0')
                                    {
                                      $txt_bank_name="N/A";  
                                      $txt_branch_name="N/A";  
                                    } else {
                                    $ci_bank_details=DB::table('pro_bank_details')->Where('bank_details_id',$row_cheque_issue->bank_details_id)->first();
                                    
                                    $ci_bank=DB::table('pro_bank')->Where('bank_id',$ci_bank_details->bank_id)->first();
                                    $txt_bank_name=$ci_bank->bank_name;
        
                                    $ci_bank_branch=DB::table('pro_bank_branch')->Where('branch_id',$ci_bank_details->branch_id)->first();
                                    $txt_branch_name=$ci_bank_branch->branch_name;
                                    }
        
                                    $txt_amount_01=$row_cheque_issue->ammount;
                                    $txt_amount=number_format($txt_amount_01,2);
                                    @endphp
        
        
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $txt_company_name }}</td>
                                        <td>{{ $row_cheque_issue->issue_date }}</td>
                                        <td>{{ $row_cheque_issue->customer_name }}</td>
                                        <td>
                                          {{ $row_cheque_issue->particulars }} <br>
                                          @isset( $row_cheque_issue->fund_req_master_id)
                                            {{$row_cheque_issue->fund_req_master_id}}
                                          @endisset
        
                                        </td>
                                        <td>{{ $txt_acc_no }}</td>
                                        <td>{{ $row_cheque_issue->cheque_date }}</td>
                                        <td>{{ $txt_cheque_no }}</td>
                                        <td>{{ $txt_bank_name }} | {{ $txt_branch_name }}</td>
                                        <td>{{ $txt_amount }}</td>
                                    </tr>
                                    @endforeach
        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-1">&nbsp;</div>
                <div class="col-10">
                    <div class="row mb-2">
                        <div class="col-3">Prepared By</div>
                        <div class="col-3">Checked By</div>
                        <div class="col-3">Checked By</div>
                        <div class="col-3">Approved By</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">
                            <br>
                            <br>
                            {{ $m_fund_req_master->user_id }}<br>{{ $m_fund_req_master->employee_name }}
                        </div>
                        <div class="col-3">
                            <br>
                            <br>
                            {{ $m_fund_req_master->first_check }}<br>{{ $m_fund_req_master->first_employee_name }}</div>
                        <div class="col-3">
                            <br>
                            <br>
                            {{ $m_fund_req_master->second_check }}<br>{{ $m_fund_req_master->second_employee_name }}</div>
                        <div class="col-3">
                            <br>
                            <br>
                            {{ $m_fund_req_master->approved_by }}<br>{{ $m_fund_req_master->approved_employee_name }}
                        </div>
                    </div>
                </div>
                <div class="col-1">&nbsp;</div>
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
    </script>
@endsection
