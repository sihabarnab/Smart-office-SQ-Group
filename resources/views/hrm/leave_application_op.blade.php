@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Application</h1>
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
            <form action="" method="Post">
            @csrf
            @php
              $txt_emp_id=Auth::user()->emp_id;
              $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$txt_emp_id)->first();

              $txt_company_id=$ci_employee_info->company_id;
              $txt_employee_name=$ci_employee_info->employee_name;
              $txt_desig_id=$ci_employee_info->desig_id;

              $ci_company=DB::table('pro_company')->Where('company_id',$txt_company_id)->first();
              $txt_company=$ci_company->company_name;

              $ci_desig=DB::table('pro_desig')->Where('desig_id',$txt_desig_id)->first();
              $txt_desig=$ci_desig->desig_name;

            @endphp

            <div class="row mb-2">
              <div class="col-3">
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
                <div class="col-3">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <input type="hidden" class="form-control" name="txt_desig_id" id="txt_desig_id" value="" readonly>
                  <input type="text" class="form-control" name="txt_desig_name" id="txt_desig_name" value="" readonly>
                  @error('txt_desig_name')
                    <span class="text-warning">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" name="txt_placeofposting_name" id="txt_placeofposting_name" value="" readonly>
                  @error('txt_placeofposting_name')
                    <span class="text-warning">{{ $message }}</span>
                  @enderror
                </div>
            </div>

            <div class="row mb-2">
              <div class="col-3">
                @php
                  $ci_pro_leave_type=DB::table('pro_leave_type')->Where('valid','1')->orderBy('leave_type', 'asc')->get();
                @endphp

                <select name="sele_leave_type" id="sele_leave_type" class="form-control">
                  <option value="0">Select Leave Type</option>
                  @foreach ($ci_pro_leave_type as $r_leave_type)
                      <option value="{{ $r_leave_type->leave_type_id }}">
                          {{ $r_leave_type->leave_type }}
                      </option>
                  @endforeach
                </select>
                @error('sele_leave_type')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_from_date"
                    name="txt_from_date" placeholder="From Date"
                    value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_from_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_to_date"
                    name="txt_to_date" placeholder="To Date"
                    value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}" onchange="DateDiff(this.value)">

                @error('txt_to_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_total" name="txt_total" value="{{ old('txt_total') }}">
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_purpose_leave" name="txt_purpose_leave" placeholder="Purpose Of Leave" value="{{ old('txt_purpose_leave') }}">
                  @error('txt_purpose_leave')
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
@include('/hrm/leave_status')
&nbsp;
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
    {{-- //Employee to Desig Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_employee_id"]').on('change', function() {
                console.log('ok2')
                var cbo_employee_id = $(this).val();
                if (cbo_employee_id) {
                    $.ajax({
                        url: "{{ url('/get/desig/') }}/" + cbo_employee_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            var d = $('select[name="txt_desig_name"]').empty();
                            document.getElementById("txt_desig_id").value = data.desig_id;
                            document.getElementById("txt_desig_name").value = data.desig_name;
                            document.getElementById("txt_placeofposting_name").value = data.placeofposting_name;

                        },
                    });

                } else {
                    $('txt_desig_name').empty();
                    $('txt_placeofposting_name').empty();
                }

            });
        });
    </script>


  <script>
          function DateDiff(val) {
           var date1 = new Date(document.getElementById("txt_from_date").value)
           var date2 = new Date(val);
           var Difference_In_Time = date2.getTime() - date1.getTime();
           var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
           document.getElementById("txt_total").value=Difference_In_Days+1;
          }
      </script>
  @endsection
@endsection