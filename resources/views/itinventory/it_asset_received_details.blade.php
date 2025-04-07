@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Receiving Form</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>

@if (isset($m_itasset_receving_details_edit))
 
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
          <form action="{{ route('ItAssetReceivedDetailsUpdate',$m_itasset_receving_details_edit->itasset_receiving_details_id) }}" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-4">
                <input type="hidden" name="txt_company_id" id="txt_company_id" readonly value="{{ $m_itasset_receiving_master->company_id }}">
                <input type="text" class="form-control" name="txt_company_name" id="txt_company_name" readonly value="{{ $m_itasset_receiving_master->company_name }}">
              </div>
              <div class="col-3">
                <input type="hidden" name="txt_placeofposting_id" id="txt_placeofposting_id" readonly value="{{ $m_itasset_receiving_master->placeofposting_id }}">
                <input type="text" class="form-control" name="txt_placeofposting_name" id="txt_placeofposting_name" readonly value="{{ $m_itasset_receiving_master->placeofposting_name }}">
              </div>
              <div class="col-5">
                <input type="hidden" name="txt_employee_id" id="txt_employee_id" readonly value="{{ $m_itasset_receiving_master->employee_id }}">
                <input type="text" class="form-control" name="txt_employee_name" id="txt_employee_name" readonly value="{{ $m_itasset_receiving_master->employee_name }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" name="txt_desig_id" id="txt_desig_id" readonly value="{{ $m_itasset_receiving_master->desig_id }}">
                <input type="text" class="form-control" name="txt_desig_name" id="txt_desig_name" readonly value="{{ $m_itasset_receiving_master->desig_name }}">               
              </div>
              <div class="col-3">
                <input type="hidden" name="txt_department_id" id="txt_department_id" readonly value="{{ $m_itasset_receiving_master->department_id }}">
                <input type="text" class="form-control" name="txt_department_name" id="txt_department_name" readonly value="{{ $m_itasset_receiving_master->department_name }}">               
              </div>
              <div class="col-6">
                <input type="text" class="form-control" name="txt_remarks" id="txt_remarks" readonly value="{{ $m_itasset_receiving_master->remarks }}">               
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-6">
                  <select name="cbo_it_asset_id" id="cbo_it_asset_id" class="form-control">
                    <option value="">--Asset--</option>
                    @foreach ($m_itasset_issue as $value)
                        <option value="{{ $value->itasset_id }}" {{ $value->itasset_id == $m_itasset_receving_details_edit->itasset_id ? "selected":""  }}>{{ $value->itasset_id }} | {{ $value->product_type_name }} | {{ $value->brand_name }} | {{ $value->model }}</option>
                    @endforeach
                  </select>
                    @error('cbo_it_asset_id')
                        <span class="text-warning">{{ $message }}</span>
                    @enderror

              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_qty" name="txt_qty" placeholder="Qty" value="{{$m_itasset_receving_details_edit->itasset_qty }}">
                  @error('txt_qty')
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
          <form action="{{ route('ItAssetReceivedDetailsStore',$m_itasset_receiving_master->itasset_receiving_master_id) }}" method="Post">
            @csrf
            <div class="row mb-2">
              <div class="col-4">
                <input type="hidden" name="txt_company_id" id="txt_company_id" readonly value="{{ $m_itasset_receiving_master->company_id }}">
                <input type="text" class="form-control" name="txt_company_name" id="txt_company_name" readonly value="{{ $m_itasset_receiving_master->company_name }}">
              </div>
              <div class="col-3">
                <input type="hidden" name="txt_placeofposting_id" id="txt_placeofposting_id" readonly value="{{ $m_itasset_receiving_master->placeofposting_id }}">
                <input type="text" class="form-control" name="txt_placeofposting_name" id="txt_placeofposting_name" readonly value="{{ $m_itasset_receiving_master->placeofposting_name }}">
              </div>
              <div class="col-5">
                <input type="hidden" name="txt_employee_id" id="txt_employee_id" readonly value="{{ $m_itasset_receiving_master->employee_id }}">
                <input type="text" class="form-control" name="txt_employee_name" id="txt_employee_name" readonly value="{{ $m_itasset_receiving_master->employee_name }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" name="txt_desig_id" id="txt_desig_id" readonly value="{{ $m_itasset_receiving_master->desig_id }}">
                <input type="text" class="form-control" name="txt_desig_name" id="txt_desig_name" readonly value="{{ $m_itasset_receiving_master->desig_name }}">               
              </div>
              <div class="col-3">
                <input type="hidden" name="txt_department_id" id="txt_department_id" readonly value="{{ $m_itasset_receiving_master->department_id }}">
                <input type="text" class="form-control" name="txt_department_name" id="txt_department_name" readonly value="{{ $m_itasset_receiving_master->department_name }}">               
              </div>
              <div class="col-6">
                <input type="text" class="form-control" name="txt_remarks" id="txt_remarks" readonly value="{{ $m_itasset_receiving_master->remarks }}">               
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-6">
                  <select name="cbo_it_asset_id" id="cbo_it_asset_id" class="form-control">
                    <option value="">--Asset--</option>
                    @foreach ($m_itasset_issue as $value)
                        <option value="{{ $value->itasset_id }}">{{ $value->itasset_id }} | {{ $value->product_type_name }} | {{ $value->brand_name }} | {{ $value->model }}</option>
                    @endforeach
                  </select>
                    @error('cbo_it_asset_id')
                        <span class="text-warning">{{ $message }}</span>
                    @enderror

              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_qty" name="txt_qty" placeholder="Qty" value="{{ old('txt_qty') }}">
                  @error('txt_qty')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-8">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Add</button>
              </div>
              <div class="col-2">
                <a href="{{route('ItAssetReceivedFinal',$m_itasset_receiving_master->itasset_receiving_master_id)}}" class="btn btn-primary btn-block">Final</a>
              </div>
            </div>

            </form>
        </div>
      </div>
    </div>
  </div>
</div>

@include('/itinventory/it_asset_received_details_list')

@endif


@endsection
