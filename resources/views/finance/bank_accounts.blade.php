@extends('layouts.finance_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Bank Accounts Info</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_bank_acc))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('bank_accounts_update') }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-4">
                <input type="hidden" class="form-control" id="txt_acc_id" name="txt_acc_id" value="{{ $m_bank_acc->acc_id }}">
                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                  <option value="0">--Company--</option>
                  @foreach ($user_company as $company)
                      <option value="{{$company->company_id}}"  {{$company->company_id == $m_bank_acc->company_id? 'selected':''}}>
                          {{$company->company_name}}
                      </option>
                  @endforeach
                </select>
                @error('cbo_company_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-8">
                @php
                  $m_bank_details=DB::table('pro_bank_details')
                  ->Where('valid','1')
                  ->orderBy('bank_details_id', 'asc')
                  ->get(); //query builder
                @endphp

                <select name="cbo_bank_details_id" id="cbo_bank_details_id" class="form-control">
                  <option value="0">--Bank--</option>
                  @foreach ($m_bank_details as $row_bank_details)

                      @php
                        $m_bank=DB::table('pro_bank')
                        ->Where('bank_id',$row_bank_details->bank_id)
                        ->orderBy('bank_id', 'asc')
                        ->first(); //query builder

                         $m_branch=DB::table('pro_bank_branch')
                         ->Where('branch_id',$row_bank_details->branch_id)
                         ->orderBy('branch_id', 'asc')
                         ->first(); //query builder
                      @endphp

                      <option value="{{$row_bank_details->bank_details_id}}"  {{$row_bank_details->bank_details_id == $m_bank_acc->bank_details_id? 'selected':''}}>
                          {{$m_bank->bank_name}} | {{ $m_branch->branch_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_bank_details_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <input type="text" class="form-control" id="txt_bank_add" name="txt_bank_add" placeholder="Bank Address" value="{{ $m_bank_add->bank_add }}">
                      @error('txt_bank_add')
                        <div class="text-warning">{{ $message }}</div>
                      @enderror
                </div>
                <div class="col-3">
                <select name="cbo_bank_acc_type_id" id="cbo_bank_acc_type_id" class="form-control">
                  <option value="0">--Bank--</option>
                  @foreach ($m_bank_acc_type as $row_bank_acc_type)
                    <option value="{{$row_bank_acc_type->bank_acc_type_id}}"  {{$row_bank_acc_type->bank_acc_type_id == $m_bank_acc->bank_acc_type_id? 'selected':''}}>
                          {{$row_bank_acc_type->acc_type_name}}
                    </option>
                  @endforeach
                </select>
                @error('cbo_bank_details_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="txt_acc_no" name="txt_acc_no" placeholder="Account Number" value="{{ $m_bank_acc->acc_no }}">
                      @error('txt_acc_no')
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
</div>
@else
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('bank_accounts_store') }}" method="Post">
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
              <div class="col-8">
                @php
                  $m_bank_details=DB::table('pro_bank_details')
                  ->Where('valid','1')
                  ->orderBy('bank_details_id', 'asc')
                  ->get(); //query builder
                @endphp
                  <select name="cbo_bank_details_id" id="cbo_bank_details_id" class="form-control">
                    <option value="0">--Bank--</option>
                    @foreach ($m_bank_details as $row_bank_details)
                      @php
                        $m_bank=DB::table('pro_bank')
                        ->Where('bank_id',$row_bank_details->bank_id)
                        ->orderBy('bank_id', 'asc')
                        ->first(); //query builder

                        $m_branch=DB::table('pro_bank_branch')
                        ->Where('branch_id',$row_bank_details->branch_id)
                        ->orderBy('branch_id', 'asc')
                        ->first(); //query builder
                      @endphp
                      
                        <option value="{{ $row_bank_details->bank_details_id }}">
                            {{ $m_bank->bank_name }} | {{ $m_branch->branch_name }}
                        </option>
                    @endforeach
                    
                  </select>
                  @error('cbo_bank_details_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-6">
                <input type="text" class="form-control" id="txt_bank_add" name="txt_bank_add" placeholder="Bank Address" readonly value="{{ old('txt_bank_add') }}">
                  @error('txt_bank_add')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror

              </div>
              <div class="col-3">
                <select name="cbo_bank_acc_type_id" id="cbo_bank_acc_type_id" class="form-control">
                  <option value="0">--A/C Type--</option>
                  @foreach ($m_bank_acc_type as $row_bank_acc_type)
                      <option value="{{ $row_bank_acc_type->bank_acc_type_id }}">
                          {{ $row_bank_acc_type->acc_type_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_bank_acc_type_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_acc_no" name="txt_acc_no" placeholder="Account Number" value="{{ old('txt_acc_no') }}">
                  @error('txt_acc_no')
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
@include('/finance/bank_accounts_list')
&nbsp;
@endif
@endsection

@section('script')
<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $("select").select2();
});
</script>
    {{-- //divison to District Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cbo_bank_details_id').on('change', function() {
                console.log('ok')
                var cbo_bank_details_id = $(this).val();
                if (cbo_bank_details_id) {

                    $.ajax({
                        url: "{{ url('/get/branch_add/') }}/" + cbo_bank_details_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                          console.log(data)
                            var d = $('#txt_bank_add').empty();
                            $('#txt_bank_add').val(data.bank_add);
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>


@endsection
