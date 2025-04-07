@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Requsition Indent (bank)</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($m_fund_req_bank_edit))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form
                                action="{{ route('FinanceFundReqBankUpdate', [$m_fund_req_bank_edit->cheque_issue_id, $m_fund_req_bank_edit->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="cbo_chq_issue_id"
                                            name="cbo_chq_issue_id" readonly
                                            value="{{ $m_fund_req_bank_edit->cheque_issue_id }}">

                                        <input type="hidden" class="form-control" id="cbo_company_id" name="cbo_company_id"
                                            readonly value="{{ $m_fund_req_bank_edit->company_id }}">

                                        <input type="text" class="form-control" id="txt_company_name"
                                            name="txt_company_name" readonly
                                            value="{{ $m_fund_req_bank_edit->company_name }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_fund_req_master_id"
                                            name="txt_fund_req_master_id" readonly
                                            value="{{ $m_fund_req_bank_edit->fund_req_master_id }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" id="txt_fund_req_date"
                                            name="txt_fund_req_date" readonly
                                            value="{{ $m_fund_req_bank_edit->fund_req_date }}">

                                        <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                            readonly value="{{ $m_fund_req_bank_edit->req_form }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                            readonly value="{{ $m_fund_req_bank_edit->req_to }}">
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_chq_type" name="cbo_chq_type">
                                            <option value="0">-Select Cheque Type-</option>
                                            @foreach ($m_chq_type as $value)
                                                <option value="{{ $value->cheque_type_id }}"
                                                    {{ $value->cheque_type_id == $m_fund_req_bank_edit->chq_type ? 'selected' : '' }}>
                                                    {{ $value->cheque_type_name }}
                                                </option>
                                               
                                            @endforeach
                                            @error('cbo_chq_type')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror

                                        </select>

                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" placeholder="Pay To"
                                            value="{{ $m_fund_req_bank_edit->customer_name }}">
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-5">
                                        <select name="cbo_bank_details_id" id="cbo_bank_details_id" class="form-control">
                                            <option value="0">--Bank--</option>
                                            @foreach ($m_banks as $row_banks)
                                                <option value="{{ $row_banks->bank_details_id }}"
                                                    {{ $row_banks->bank_details_id == $m_fund_req_bank_edit->bank_details_id ? 'selected' : '' }}>
                                                    {{ $row_banks->bank_name }} | {{ $row_banks->bank_sname }} |
                                                    {{ $row_banks->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_details_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <select name="cbo_acc_id" id="cbo_acc_id" class="form-control">
                                            <option value="{{ $m_fund_req_bank_edit->acc_id }}">
                                                {{ $m_fund_req_bank_edit->acc_no }}</option>
                                        </select>
                                        @error('cbo_acc_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <select name="cbo_cheque_details_id" id="cbo_cheque_details_id"
                                            class="form-control">
                                            <option value="{{ $m_fund_req_bank_edit->cheque_details_id }}">
                                                {{ $m_fund_req_bank_edit->cheque_no }}</option>
                                        </select>
                                        @error('cbo_cheque_details_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_cheque_date"
                                            name="txt_cheque_date" placeholder="Cheque Date"
                                            value="{{ $m_fund_req_bank_edit->cheque_date }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_cheque_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_amount" id="txt_amount"
                                            placeholder="Amount" value="{{ $m_fund_req_bank_edit->ammount }}">
                                        @error('txt_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="txt_remarks" id="txt_remarks"
                                            placeholder="Remarks" value="{{ $m_fund_req_bank_edit->remarks }}">
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('FinanceFundReqBankStore', [$m_pro_fund_req_master->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="cbo_company_id"
                                            name="cbo_company_id" readonly
                                            value="{{ $m_pro_fund_req_master->company_id }}">

                                        <input type="text" class="form-control" id="txt_company_name"
                                            name="txt_company_name" readonly
                                            value="{{ $m_pro_fund_req_master->company_name }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_fund_req_master_id"
                                            name="txt_fund_req_master_id" readonly
                                            value="{{ $m_pro_fund_req_master->fund_req_master_id }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" id="txt_fund_req_date"
                                            name="txt_fund_req_date" readonly
                                            value="{{ $m_pro_fund_req_master->fund_req_date }}">

                                        <input type="text" class="form-control" id="txt_from_date"
                                            name="txt_from_date" readonly value="{{ $m_pro_fund_req_master->req_form }}">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                            readonly value="{{ $m_pro_fund_req_master->req_to }}">
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" id="cbo_chq_type" name="cbo_chq_type">
                                            <option value="0">-Select Cheque Type-</option>
                                            @foreach ($m_chq_type as $value)
                                                <option value="{{ $value->cheque_type_id }}">
                                                    {{ $value->cheque_type_name }}
                                                </option>
                                            @endforeach
                                            @error('cbo_chq_type')
                                                <div class="text-warning">{{ $message }}</div>
                                            @enderror

                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_customer_name"
                                            name="txt_customer_name" placeholder="Customer Name"
                                            value="{{ old('txt_customer_name') }}">
                                        @error('txt_customer_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-5">
                                        <select name="cbo_bank_details_id" id="cbo_bank_details_id" class="form-control">
                                            <option value="">--Bank--</option>
                                            @foreach ($m_banks as $bank)
                                                <option value="{{ $bank->bank_details_id }}">
                                                    {{ $bank->bank_name }} | {{ $bank->bank_sname }} |
                                                    {{ $bank->branch_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_bank_details_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <select name="cbo_acc_id" id="cbo_acc_id" class="form-control">
                                            <option value="">--Account Number--</option>
                                        </select>
                                        @error('cbo_acc_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <select name="cbo_cheque_details_id" id="cbo_cheque_details_id"
                                            class="form-control">
                                            <option value="">--Cheque Number--</option>
                                        </select>
                                        @error('cbo_cheque_details_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_cheque_date"
                                            name="txt_cheque_date" placeholder="Cheque Date"
                                            value="{{ old('txt_cheque_date') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_cheque_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="txt_amount" id="txt_amount"
                                            placeholder="Amount" value="{{ old('txt_amount') }}">
                                        @error('txt_amount')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="txt_remarks" id="txt_remarks"
                                            placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                        @error('txt_remarks')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-9"></div>
                                    <div class="col-2">
                                        <button type="submit" class="form-control btn  bg-primary">Add Cheque</button>
                                    </div>
                                    <div class="col-1">
                                        @if($final_button_status == 1)
                                        <a href="{{route('FinanceFundReqBankFinal',[$m_pro_fund_req_master->fund_req_master_id,$m_pro_fund_req_master->company_id])}}" class="form-control btn bg-primary">Final</a>
                                        @else
                                        <button  class="form-control btn bg-primary" disabled>Final</button>
                                        @endif
                                    </div>
                                    <div class="col-2"></div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('finance.fund_req_bank_list')
    @endif


@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_bank_details_id"]').on('change', function() {
                console.log('ok')
                var bank_details_id = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                // console.log(cbo_company_id)
                if (bank_details_id) {

                    $.ajax({
                        url: "{{ url('/get/account_no/') }}/" + bank_details_id + '/' +
                            cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            var d = $('select[name="cbo_acc_id"]').empty();
                            $('select[name="cbo_acc_id"]').append(
                                '<option value="">--Account Number--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_acc_id"]').append(
                                    '<option value="' + value.acc_id + '">' + value
                                    .acc_no + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_acc_id"]').on('change', function() {
                console.log('ok')
                var cbo_acc_id = $(this).val();
                if (cbo_acc_id) {

                    $.ajax({
                        url: "{{ url('/get/cheque_no/') }}/" + cbo_acc_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_cheque_details_id"]').empty();
                            $('select[name="cbo_cheque_details_id"]').append(
                                '<option value="">--Cheque Number--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_cheque_details_id"]').append(
                                    '<option value="' + value.cheque_details_id +
                                    '">' + value.cheque_no + '</option>');
                            });
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>

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
