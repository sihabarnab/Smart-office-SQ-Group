@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Supplier Information</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_supplier_info))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('itsupplier_infoupdate',$m_supplier_info->supplier_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                <input type="text" class="form-control"mid="txt_supplier_name" name="txt_supplier_name" placeholder="Supplier Name" value="{{ $m_supplier_info->supplier_name }}">
                  @error('txt_supplier_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-9">
                <input type="text" class="form-control"mid="txt_supplier_add" name="txt_supplier_add" placeholder="Supplier Address" value="{{ $m_supplier_info->supplier_add }}">
                  @error('txt_supplier_add')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-3">
                <input type="text" class="form-control"mid="txt_supplier_phone" name="txt_supplier_phone" placeholder="Contact Number." value="{{ $m_supplier_info->supplier_phone }}">
                  @error('txt_supplier_phone')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-9">
                <input type="text" class="form-control"mid="txt_contact_person" name="txt_contact_person" placeholder="Contact Person." value="{{ $m_supplier_info->contact_person }}">
                  @error('txt_contact_person')
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
            <form action="{{ route('supplier_info_store') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id" placeholder="" readonly value="{{ Auth::user()->emp_id }}">
                <input type="text" class="form-control"mid="txt_supplier_name" name="txt_supplier_name" placeholder="Supplier Name" value="{{ old('txt_supplier_name') }}">
                  @error('txt_supplier_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror

              </div>
              <div class="col-9">
                <input type="text" class="form-control"mid="txt_supplier_add" name="txt_supplier_add" placeholder="Supplier Address" value="{{ old('txt_supplier_add') }}">
                  @error('txt_supplier_add')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-4">
                <input type="text" class="form-control" id="txt_supplier_phone" name="txt_supplier_phone" placeholder="Contact Number." value="{{ old('txt_supplier_phone') }}">
                  @error('txt_supplier_phone')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-8">
                <input type="text" class="form-control" id="txt_contact_person" name="txt_contact_person" placeholder="Contact Person." value="{{ old('txt_contact_person') }}">
                  @error('txt_contact_person')
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
@include('/itinventory/supplier_info_list')
&nbsp;
@endif
@endsection
