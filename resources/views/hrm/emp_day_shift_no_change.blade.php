@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Daily Working Time</h1>
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{route('emp_day_shift_final_nochange')}}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-2">
                <input type="text" class="form-control" id="txt_atten_date" name="txt_atten_date" placeholder="Attendance Date" value="{{ old('txt_atten_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" >
                  @error('txt_atten_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                  <option value="">--Company--</option>
                  @foreach ($user_company as $company)
                      <option value="{{ $company->company_id }}" {{ $company->company_id == old('cbo_company_id')? 'selected':'' }}>
                          {{ $company->company_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_company_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-4">
                <select name="cbo_placeofposting_id" id="cbo_placeofposting_id" class="form-control">
                  <option value="">--Posting--</option>
                  @foreach ($ci_placeofposting as $m_posting)
                      <option value="{{ $m_posting->placeofposting_id }}">
                          {{ $m_posting->placeofposting_id }} | {{ $m_posting->placeofposting_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_placeofposting_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror

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
@endsection