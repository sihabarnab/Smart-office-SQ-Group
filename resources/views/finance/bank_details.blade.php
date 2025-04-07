@extends('layouts.finance_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Bank Details Info</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_bank_details))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('bank_details_update') }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-4">
                
                <input type="hidden" class="form-control" id="txt_bank_details_id" name="txt_bank_details_id" value="{{ $m_bank_details->bank_details_id }}">

@php
        $m_bank=DB::table('pro_bank')
        ->Where('valid','1')
        ->orderBy('bank_id', 'desc')
        ->get();
@endphp

                <select name="cbo_bank_id" id="cbo_bank_id" class="form-control">
                  <option value="">--Bank--</option>
                    @foreach($m_bank as $row_bank)
                      <option value="{{$row_bank->bank_id}}"  {{$row_bank->bank_id == $m_bank_details->bank_id? 'selected':''}}>
                          {{$row_bank->bank_name}} | {{$row_bank->bank_sname}}
                      </option>
                    @endforeach
                </select>
                  @error('cbo_bank_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">

@php
        $m_bank_branch=DB::table('pro_bank_branch')
        ->Where('valid','1')
        ->orderBy('branch_id', 'desc')
        ->get();
@endphp

                <select name="cbo_branch_id" id="cbo_branch_id" class="form-control">
                  <option value="">--Bank--</option>
                    @foreach($m_bank_branch as $row_bank_branch)
                      <option value="{{$row_bank_branch->branch_id}}"  {{$row_bank_branch->branch_id == $m_bank_details->branch_id? 'selected':''}}>
                          {{$row_bank_branch->branch_name}}
                      </option>
                    @endforeach
                </select>
                  @error('cbo_branch_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
                <div class="col-4">
                    <input type="text" class="form-control" id="txt_swift_code" name="txt_swift_code" placeholder="Swift Code" value="{{ $m_bank_details->swift_code }}">
                      @error('txt_swift_code')
                        <div class="text-warning">{{ $message }}</div>
                      @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <input type="text" class="form-control" id="txt_bank_add" name="txt_bank_add" placeholder="Bank Address" value="{{ $m_bank_details->bank_add }}">
                      @error('txt_bank_add')
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
            <form action="{{ route('bank_details_store') }}" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-4">
                @php
                  $m_bank=DB::table('pro_bank')
                  ->Where('valid','1')
                  ->orderBy('bank_id', 'asc')
                  ->get(); //query builder
                @endphp
                  <select name="cbo_bank_id" id="cbo_bank_id" class="form-control">
                    <option value="0">--Bank--</option>
                    @foreach ($m_bank as $row_bank)
                        <option value="{{ $row_bank->bank_id }}">
                            {{ $row_bank->bank_name }}
                        </option>
                    @endforeach
                    
                  </select>
                  @error('cbo_bank_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                @php
                  $m_bank_branch=DB::table('pro_bank_branch')
                  ->Where('valid','1')
                  ->orderBy('branch_id', 'asc')
                  ->get(); //query builder
                @endphp
                  <select name="cbo_branch_id" id="cbo_branch_id" class="form-control">
                    <option value="0">--Bank Branch--</option>
                    @foreach ($m_bank_branch as $row_bank_branch)
                        <option value="{{ $row_bank_branch->branch_id }}">
                            {{ $row_bank_branch->branch_name }}
                        </option>
                    @endforeach
                    
                  </select>
                  @error('cbo_branch_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="txt_swift_code" name="txt_swift_code" placeholder="Swift Code" value="{{ old('txt_swift_code') }}">
                  @error('txt_swift_code')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_bank_add" name="txt_bank_add" placeholder="Bank Address" value="{{ old('txt_bank_add') }}">
                  @error('txt_bank_add')
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
@include('/finance/bank_details_list')
&nbsp;
@endif
@endsection
