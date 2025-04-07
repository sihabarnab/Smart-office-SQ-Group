@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Date Wise Atten Data Query</h1>
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
            <form action="{{ route('HrmDataQueryList') }}" method="Post">
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
              <div class="col-2">
                <select name="cbo_posting" id="cbo_posting" class="form-control">
                  <option value="">--Posting--</option>
                  @foreach ($m_user_posting as $row_user_posting)
                      <option value="{{ $row_user_posting->placeofposting_id }}" {{ $row_user_posting->placeofposting_id == old('cbo_posting')? 'selected':'' }}>
                          {{ $row_user_posting->placeofposting_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_posting')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-3">
                <input type="text" class="form-control" id="txt_query_date"
                    name="txt_query_date" placeholder="Date"
                    value="{{ old('txt_query_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_query_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-1">
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
&nbsp;
@endsection
@section('script')

  <script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  
    
@endsection
