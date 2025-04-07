@extends('layouts.finance_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Bank Info</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_bank))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('bank_update') }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-6">
                  <input type="hidden" class="form-control" id="txt_bank_id" name="txt_bank_id" value="{{ $m_bank->bank_id }}">

                <input type="text" class="form-control"mid="txt_bank_name" name="txt_bank_name" placeholder="Bank Name" value="{{ $m_bank->bank_name }}">
                  @error('txt_bank_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control"mid="txt_bank_sname" name="txt_bank_sname" placeholder="Bank Short Name" value="{{ $m_bank->bank_sname }}">
                  @error('txt_bank_sname')
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
            <form action="{{ route('bank_store') }}" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-6">
                <input type="text" class="form-control"mid="txt_bank_name" name="txt_bank_name" placeholder="Bank Name" value="{{ old('txt_bank_name') }}">
                  @error('txt_bank_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                <input type="text" class="form-control"mid="txt_bank_sname" name="txt_bank_sname" placeholder="Bank Short Name" value="{{ old('txt_bank_sname') }}">
                  @error('txt_bank_sname')
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
@include('/finance/bank_list')
&nbsp;
@endif
@endsection
