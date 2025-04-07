@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Report</h1>
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
          <div align="left" class=""></div>
            <form action="{{ route('RptItAssetList') }}" method="Post">
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
                  <select name="cbo_product_type_id" id="cbo_product_type_id" class="form-control">
                    <option value="0">--Product Type--</option>
                    @foreach ($m_product_type as $row_product_type)
                        <option value="{{ $row_product_type->product_type_id }}">
                            {{ $row_product_type->product_type_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_product_type_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <button type="Submit" class="btn btn-primary btn-block">Submit</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
&nbsp;
@include('itinventory.rpt_it_asset_list')
@endsection
{{-- @section('script')
  <script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  
@endsection
 --}}