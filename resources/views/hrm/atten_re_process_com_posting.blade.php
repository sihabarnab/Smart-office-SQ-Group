@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1 class="m-0">Company & Posting Wise Attendance Re Process</h1>
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
            <form action="" method="Post">
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
                @php
                $data_pro_placeofposting=DB::table('pro_placeofposting')->Where('valid','1')->orderBy('placeofposting_id','asc')->get(); //query builder
                @endphp
                <select name="cbo_placeofposting_id" id="cbo_placeofposting_id" class="form-control">
                  <option value="0">All Place of Posting</option>
                  @foreach ($data_pro_placeofposting as $emp_placeofposting)
                      <option value="{{ $emp_placeofposting->placeofposting_id }}">
                          {{ $emp_placeofposting->placeofposting_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_placeofposting_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>


              <div class="col-3">
                <input type="text" class="form-control" id="txt_atten_date" name="txt_atten_date" placeholder="Attendance Date" value="{{ old('txt_atten_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_atten_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
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


<div class="container-fluid">

  <div class="row mb-2">
    <div class="col-12">
      <div align="center" class="">
        <h4>Check First</h4>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12">
      <div align="center" class="">
        <mark>Data Synchronization</mark>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12">
      <div align="center" class="">
        <mark>Attendance Policy</mark>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-12">
      <div align="center" class="">
        <mark>Holiday Entry</mark>
      </div>
    </div>
  </div>
</div>

@endsection
