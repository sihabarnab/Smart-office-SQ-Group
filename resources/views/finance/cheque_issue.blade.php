@extends('layouts.finance_app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cheque Issue</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    @include('flash-message')
</div>

@if(isset($m_cheque_issue))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
                <div class="col-6">
                    <input type="hidden" class="form-control" id="txt_cheque_issue_id" name="txt_cheque_issue_id" value="{{ $m_cheque_issue->cheque_issue_id }}">
                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                      <option value="0">--Company--</option>
                      @foreach ($user_company as $company)
                          <option value="{{$company->company_id}}"  {{$company->company_id == $m_cheque_issue->company_id? 'selected':''}}>
                              {{$company->company_name}}
                          </option>
                      @endforeach
                    </select>
                    @error('cbo_company_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_issue_date"
                        name="txt_issue_date" placeholder="Issue Date"
                        value="{{ $m_cheque_issue->issue_date }}" onfocus="(this.type='date')"
                        onblur="if(this.value==''){this.type='text'}">
                    @error('txt_issue_date')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_customer_name"
                        name="txt_customer_name" placeholder="Customer Name"
                        value="{{ $m_cheque_issue->customer_name }}">
                    @error('txt_customer_name')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_particulars"
                        name="txt_particulars" placeholder="Particulars"
                        value="{{ $m_cheque_issue->particulars }}">
                    @error('txt_particulars')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5">
                    <select name="cbo_bank_id" id="cbo_bank_id" class="form-control">
                      <option value="0">--Bank--</option>
                      @foreach ($m_banks as $bank)
                          <option value="{{$bank->bank_id}}"  {{$bank->bank_details_id == $m_cheque_issue->bank_details_id? 'selected':''}}>
                              {{ $bank->bank_sname }}|{{ $bank->branch_name }}
                          </option>
                      @endforeach
                    </select>
                    @error('cbo_bank_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                    <select name="cbo_acc_no_id" id="cbo_acc_no_id" class="form-control">
                        @php
                            $ci_bank_acc=DB::table('pro_bank_acc')->Where('acc_id',$m_cheque_issue->acc_id)->first();
                        @endphp
                      <option value="$m_cheque_issue->acc_id">{{ $ci_bank_acc->acc_no }}</option>
                    </select>
                    @error('cbo_acc_no_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <select name="cbo_cheque_details_id" id="cbo_cheque_details_id" class="form-control">
                        @php
                            $ci_cheque_details=DB::table('pro_cheque_details')->Where('cheque_details_id',$m_cheque_issue->cheque_details_id)->first();
                        @endphp

                      <option value="$m_cheque_issue->cheque_details_id">{{ $ci_cheque_details->cheque_no }}</option>
                    </select>
                    @error('cbo_cheque_details_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <input type="text" class="form-control" id="txt_cheque_date"
                        name="txt_cheque_date" placeholder="Cheque Date"
                        value="{{ $m_cheque_issue->cheque_date }}" onfocus="(this.type='date')"
                        onblur="if(this.value==''){this.type='text'}">
                    @error('txt_cheque_date')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" id="txt_amount"
                        name="txt_amount" placeholder="Amount"
                        value="{{ $m_cheque_issue->ammount }}">
                    @error('txt_amount')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" id="txt_remark"
                        name="txt_remark" placeholder="Remarks"
                        value="{{ $m_cheque_issue->remarks }}">
                    @error('txt_remark')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Update</button>
              </div>
            </div>
            </form>
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
                    <div align="left" class=""><h5>{{ "Add" }}</h5></div>

                    <form action="{{ route('finance_cheque_issue_store') }}" method="post">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-6">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                  <option value="0">--Company--</option>
                                  @foreach ($user_company as $company)
                                      <option value="{{ $company->company_id }}">
                                          {{ $company->company_name }}
                                      </option>
                                  @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="txt_issue_date"
                                    name="txt_issue_date" placeholder="Issue Date"
                                    value="{{ old('txt_issue_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_issue_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <input type="text" class="form-control" id="txt_customer_name" name="txt_customer_name" placeholder="Customer Name" 
                                    value="{{ old('txt_customer_name') }}" >
                                @error('txt_customer_name')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="txt_particulars" name="txt_particulars" placeholder="Particulars" 
                                    value="{{ old('txt_particulars') }}" >
                                @error('txt_particulars')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-5">
                                <select name="cbo_bank_details_id" id="cbo_bank_details_id" class="form-control">
                                    <option value="0">--Bank--</option>
                                    @foreach ($m_banks as $bank)
                                        <option value="{{ $bank->bank_details_id }}">
                                             {{ $bank->bank_name }} | {{ $bank->bank_sname }} | {{ $bank->branch_name }} 
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_bank_details_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select name="cbo_acc_id" id="cbo_acc_id" class="form-control">
                                    <option value="0">--Account Number--</option>
                                </select>
                                @error('cbo_acc_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select name="cbo_cheque_details_id" id="cbo_cheque_details_id" class="form-control">
                                    <option value="0">--Cheque Number--</option>
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
                                <input type="text" class="form-control" name="txt_amount" id="txt_amount" placeholder="Amount" 
                                    value="{{ old('txt_amount') }}">
                                @error('txt_amount')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-7">
                                <input type="text" class="form-control" name="txt_remark" id="txt_remark" placeholder="Remarks" 
                                    value="{{ old('txt_remark') }}">
                                @error('txt_remark')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-10">
                                &nbsp;
                            </div>
                            <div class="col-2">
                                <button type="Submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@include('finance.cheque_issue_list')
@endif
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
   $('select[name="cbo_bank_details_id"]').on('change',function(){
    // console.log('ok')
        var bank_details_id = $(this).val();
        var cbo_company_id = $('#cbo_company_id').val();
        // console.log(cbo_company_id)
        if (bank_details_id) {

          $.ajax({
            url: "{{ url('/get/account_no/') }}/"+bank_details_id+'/'+cbo_company_id,
            type:"GET",
            dataType:"json",
            success:function(data) {
                console.log(data)
            var d =$('select[name="cbo_acc_id"]').empty();
            $('select[name="cbo_acc_id"]').append('<option value="0">--Account Number--</option>');
            $.each(data, function(key, value){
            $('select[name="cbo_acc_id"]').append('<option value="'+ value.acc_id + '">' + value.acc_no+ '</option>');
            });
            },
          });

        }else{
          alert('danger');
        }

          });
    });

</script>
<script type="text/javascript">
    $(document).ready(function(){
   $('select[name="cbo_acc_id"]').on('change',function(){
    console.log('ok')
        var cbo_acc_id = $(this).val();
        if (cbo_acc_id) {

          $.ajax({
            url: "{{ url('/get/cheque_no/') }}/"+cbo_acc_id,
            type:"GET",
            dataType:"json",
            success:function(data) {
            var d =$('select[name="cbo_cheque_details_id"]').empty();
            $('select[name="cbo_cheque_details_id"]').append('<option value="0">--Cheque Number--</option>');
            $.each(data, function(key, value){
            $('select[name="cbo_cheque_details_id"]').append('<option value="'+ value.cheque_details_id + '">' + value.cheque_no+ '</option>');
            });
            },
          });

        }else{
          alert('danger');
        }

          });
    });

</script>
@endsection
