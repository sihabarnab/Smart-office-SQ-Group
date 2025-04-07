@extends('layouts.finance_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cheque Information</h1>
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
                        <form action="{{ route('RptChequeIssueList') }}" method="post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="0">-Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_bank" name="cbo_bank">
                                        <option value="0">All Bank</option>
                                        @foreach ($m_banks as $value)
                                            <option value="{{ $value->bank_id }}">{{ $value->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_bank')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <select class="form-control" id="cbo_branch" name="cbo_branch">
                                        <option value="0">All Branch</option>
                                        @foreach ($m_branchs as $value)
                                            <option value="{{ $value->branch_id }}">{{ $value->branch_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_branch')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-10">
                                    &nbsp;
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
  <script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  
@endsection
