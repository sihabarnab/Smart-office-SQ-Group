@extends('layouts.finance_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Indent (Second Check)</h1>
                    {{$m_fund_req_master->company_name}}
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
                            <div class="col-4">
                                <label>Prepared By</label>
                                <p class="form-control">{{ $m_fund_req_master->employee_name }}</p>
                            </div>
                            <div class="col-4">
                                <label>1st Checked</label>
                                <p class="form-control">{{ $m_fund_req_master->first_name }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@if($m_fund_req_detail->count()>0)
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
                            <div class="col-5">
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
                        </div>
                        @foreach ($m_fund_req_detail as $key => $value)
                            <form action="{{ route('FundReqCheck02ok') }}"
                                method="post">
                                @csrf

                                <input type="hidden" name="txt_company_id" value="{{ $m_fund_req_master->company_id }}">

                                <input type="hidden" name="txt_fund_req_master_id" value="{{ $m_fund_req_master->fund_req_master_id }}">

                                <input type="hidden" name="txt_fund_req_detail_id" value="{{ $value->fund_req_detail_id }}">

                                <div class="row m-0">
                                    <div class="col-1 p-0">
                                        <input type="text" class="form-control" readonly value="{{ $key + 1 }}">
                                    </div>
                                    <div class="col-3 p-0">
                                        <input type="text" id="txt_description" name="txt_description" class="form-control" value="{{ $value->description }}">
                                    </div>

                                    <div class="col-5 pr-1">
                                        <div class="row">
                                            <div class="col-4 p-0">
                                                <input type="text" id="txt_req_transfer" name="txt_req_transfer" class="form-control text-right" value="{{ $value->req_transfer }}">
                                            </div>

                                            <div class="col-4 p-0">
                                                <input type="text" id="txt_req_cash" name="txt_req_cash" class="form-control text-right" value="{{ $value->req_cash }}">
                                            </div>
                                            <div class="col-4 p-0">
                                                <input type="text" id="txt_req_chq" name="txt_req_chq" class="form-control text-right" value="{{ $value->req_chq }}">
                                                @error('txt_req_chq')
                                                    <div class="text-warning">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-1 pr-1">
                                       @if(isset($value->fund_req_detail_file))
                                        @php
                                          $pdf = url("../docupload/sqgroup/fundreqfile/$value->fund_req_detail_file");
                                        @endphp

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#PdfModal" onclick='showPDF("{{$pdf}}")'><i class="fas fa-eye"></i>
                                        </button>
                                        @else

                                        @endif                                       
                                    </div>
                                    <div class="col-1 p-0">
                                        <button type="submit" class="btn btn-primary">ok</button>
                                    </div>
                                    <div class="col-1 p-0">ttt
                                    </div>
                                </div>
                            </form>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if($m_cheque_issue->count()>0)
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div align="left" class="">
                            <h6>{{ 'Cheque Details' }}</h6>
                        </div>

                        <div class="row">
                            <div class="col-1">
                                <label>SL No</label>
                            </div>
                            <div class="col-2 text-left">
                                <label>Customer</label>
                            </div>
                            <div class="col-3 text-left">
                                <label>Bank/Acc</label>
                            </div>
                            <div class="col-3 text-left">
                                <label>Cheque#/Date</label>
                            </div>
                            <div class="col-2 text-right">
                                <label>Amount</label>
                            </div>
                            <div class="col-1">
                                <label>ssss</label>
                            </div>
                        </div>
                        @foreach ($m_cheque_issue as $key => $row_cheque_issue)
                            <form action="{{ route('FundBankCheck02ok') }}"
                                method="post">
                                @csrf

                                <input type="hidden" name="txt_company_id" value="{{ $m_fund_req_master->company_id }}">

                                <input type="hidden" name="txt_fund_req_master_id" value="{{ $m_fund_req_master->fund_req_master_id }}">


                                <div class="row mb-1">
                                    <div class="col-1 p-0">
                                        <input type="text" class="form-control" readonly value="{{ $key + 1 }}">
                                    </div>
                                    <div class="col-2 p-0">
                                        <input type="text" id="txt_customer_name" name="txt_customer_name" class="form-control" value="{{ $row_cheque_issue->customer_name }}">
                                    </div>
                                    <div class="col-3 p-0">
                                        <input type="text" id="txt_acc_no" name="txt_acc_no" class="form-control" value="{{ $row_cheque_issue->bank_sname }} {{ $row_cheque_issue->acc_no }}">
                                    </div>
                                    <div class="col-3 p-0">
                                        <input type="hidden" id="txt_cheque" name="txt_cheque" class="form-control" value="{{ $row_cheque_issue->cheque_no }}">
                                        <input type="text" id="txt_cheque_no" name="txt_cheque_no" class="form-control" value="{{ $row_cheque_issue->cheque_no }} / {{ $row_cheque_issue->cheque_date }}">
                                    </div>
                                    <div class="col-2 p-0 text-right">
                                        <input type="text" id="txt_ammount" name="txt_ammount" class="form-control text-right" value="{{ numberBDFormat($row_cheque_issue->ammount,2) }}">
                                    </div>
                                    <div class="col-1 pr-1">
                                        <button type="submit" class="btn btn-primary">ok</button>
                                    </div>

                                </div>
                            </form>
                        @endforeach


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

@php

     function numberBDFormat($number,$decimals = 0)
     {
         // desimal (.) dat part
        if (strpos($number, '.') != null) {
            $decimalNumbers = substr($number, strpos($number, '.'));
            $decimalNumbers = str_pad(substr($decimalNumbers, 1, $decimals),2,'0',STR_PAD_RIGHT);
        } else {
            $decimalNumbers = 0;
            for ($i = 2; $i <= $decimals; $i++) {
                $decimalNumbers = $decimalNumbers . '0';
            }
        }
        // echo $decimalNumbers;
        $number = (int) $number;
        // reverse
        $number = strrev($number);
        $n = '';
        $stringlength = strlen($number);
        for ($i = 0; $i < $stringlength; $i++) {
            if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                $n = $n . $number[$i] . ',';
            } else {
                $n = $n . $number[$i];
            }
        }
        $number = $n;
        // reverse
        $number = strrev($number);
        $decimals != 0 ? ($number = $number . '.' . $decimalNumbers) : $number;
        return $number;
     }

@endphp

@endsection
@section('script')
<script type="text/javascript">
function showPDF(pdf)
{
    $('#showPdf').attr('src', '');  
    if(pdf){
        $('#showPdf').attr('src', pdf);
    }else{
        $('#showPdf').attr('src', '');   
    }
   
}
</script>
@endsection