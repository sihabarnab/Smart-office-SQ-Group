@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Attendance Report</h1>
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
            <form action="{{ route('MoveApproManualStore') }}" method="Post">
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
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_move_date"
                    name="txt_move_date" placeholder="Date"
                    value="{{ old('txt_move_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_move_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                @php
                  $ci_pro_late_type=DB::table('pro_late_type')->Where('valid','1')->orderBy('late_type', 'desc')->get();
                @endphp

                <select name="sele_late_type" id="sele_late_type" class="form-control">
                  <option value="0">Select Movement Type</option>
                  @foreach ($ci_pro_late_type as $r_late_type)
                      <option value="{{ $r_late_type->late_type_id }}">
                          {{ $r_late_type->late_type }}
                      </option>
                  @endforeach
                </select>
                @error('sele_late_type')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-9">
                <input type="text" class="form-control" id="txt_purpose_late" name="txt_purpose_late" placeholder="Short Descrive" value="{{ old('txt_purpose_late') }}">
                  @error('txt_purpose_late')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>

            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="cbo_approved_status" id="cbo_approved_status" class="form-control">
                  <option value="0">Approved Status</option>
                  @foreach ($m_yesno as $row_yesno)
                      <option value="{{ $row_yesno->yesno_id }}">
                        {{ $row_yesno->yesno_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_approved_status')
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
&nbsp;
@endsection
@section('script')

  {{-- //Company to Employee Use Ajax --}}
  <script type="text/javascript">
      $(document).ready(function() {
          $('select[name="cbo_company_id"]').on('change', function() {
              console.log('ok')
              var cbo_company_id = $(this).val();
              if (cbo_company_id) {

                  $.ajax({
                      url: "{{ url('/get/employee/') }}/" + cbo_company_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          var d = $('select[name="cbo_employee_id"]').empty();
                          $('select[name="cbo_employee_id"]').append(
                              '<option value="0">--Employee--</option>');
                          $.each(data, function(key, value) {
                              $('select[name="cbo_employee_id"]').append(
                                  '<option value="' + value.employee_id + '">' +
                                  value.employee_id + ' | ' + value.employee_name + '</option>');
                          });
                      },
                  });

              }

          });
      });
  </script>

  <script>
  $(document).ready(function () {
  //change selectboxes to selectize mode to be searchable
     $("select").select2();
  });
  </script>  
  <script>
    $('#sedate3').datetimepicker({
         format: 'YYYY-MM'
     });
  </script>  
    
@endsection
