@extends('layouts.finance_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Cheque</h1>
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
                        {{-- <h3 class="mb-5">Add</h3> --}}

                        <form action="{{ route('finance_cheque_store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
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
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <input type="text" class="form-control" placeholder="Cheque Book No" id="txt_seq_book_no" name="txt_seq_book_no"
                                        value="{{ old('txt_seq_book_no') }}" >
                                    @error('txt_seq_book_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_seq_total_page" placeholder="Cheque Total Page"
                                        value="{{ old('txt_seq_total_page') }}" name="txt_seq_total_page">
                                    @error('txt_seq_total_page')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="number" class="form-control" id="txt_seq_start_no" placeholder="Cheque Start No" 
                                        value="{{ old('txt_seq_start_no') }}" name="txt_seq_start_no">
                                    @error('txt_seq_start_no')
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

    @if(session()->has('cheque'))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Cheque</h1>
                <div class="card">
                    <div class="card-body">
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">Bank</th>
                                    <th class="text-left align-top">Account No.</th>
                                    <th class="text-left align-top">Cheque No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('cheque') as $key => $value)
                                    <tr>
                                        <td class="text-left align-top">{{ $key+1 }}</td>
                                        <td class="text-left align-top">{{ $value->bank_sname." | ".$value->branch_name }}</td>
                                        <td class="text-left align-top">
                                            @php
                                               $nccount_no= DB::table('pro_bank_acc')->where('acc_id',$value->acc_id)->first();
                                            @endphp
                                            {{ $nccount_no->acc_no  }}
                                    </td>
                                        <td class="text-left align-top">{{ $value->cheque_no }}</td>
                                        
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
    

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
   $('select[name="cbo_bank_details_id"]').on('change',function(){
    // console.log('ok')
        var bank_details_id = $(this).val();
        var cbo_company_id = $('#cbo_company_id').val();
        // console.log(cbo_company_id)
        // console.log(cbo_bank_id)
        if (bank_details_id) {

          $.ajax({
            url: "{{ url('/get/account_no/') }}/"+bank_details_id+'/'+cbo_company_id,
            type:"GET",
            dataType:"json",
            success:function(data) {
                // console.log(data)
            var d =$('select[name="cbo_acc_id"]').empty();
            $('select[name="cbo_acc_id"]').append('<option value="0">Account Number</option>');
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
@endsection
@endsection
