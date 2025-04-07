@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Leave Report</h1>
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
              <form action="{{ route('leave_application_details_02') }}" method="Post">
              @csrf
  
              <div class="row mb-2">
                <div class="col-3">
                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                      <option value="">--Company--</option>
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
                <div class="col-2">
                  <select name="cbo_sub_posting" id="cbo_sub_posting" class="form-control">
                    <option value="0">--Sub Posting--</option>
                  </select>
                  @error('cbo_sub_posting')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
  
                <div class="col-3">
                      <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                          <option value="">--Employee--</option>
                      </select>
                      @error('cbo_employee_id')
                          <div class="text-warning">{{ $message }}</div>
                      @enderror
                </div>
                <div class="col-2">
                  <div class="input-group date" id="sedate3" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" id="txt_month"
                      name="txt_month" placeholder="Year Month"
                      value="{{ old('txt_month') }}" data-target="#sedate3">
                      <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div>
                  </div>
                  @error('txt_month')
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

  @if(isset($m_leave_info_master))

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <table id="" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Description</th>
                                <th>Approved For</th>
                                <th class="text-center">Approved By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_leave_info_master as $key=>$row_leave)
                            @php
                            $ci_leave_type=DB::table('pro_leave_type')
                            ->Where('valid','1')
                            ->Where('leave_type_id',$row_leave->leave_type_id)
                            ->first();
                            // dd($row_leave);
                            @endphp

                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $ci_leave_type->leave_type }} | {{ $ci_leave_type->leave_type_sname }}</td>
                                <td>{{ $row_leave->entry_date }}<br>{{ $row_leave->entry_time }}</td>
                                <td>{{ $row_leave->leave_form }} to {{ $row_leave->leave_to }}<br>{{ $row_leave->total }} day</td>
                                <td>{{ $row_leave->purpose_leave }}{{ $row_leave->leave_info_master_id }}</td>
                                <td>{{ $row_leave->g_leave_form }} to {{ $row_leave->g_leave_to }}<br>{{ $row_leave->g_leave_total }} day</td>
                                <td>
                                    <table id="" class="table table-borderless table-striped">
                                        @foreach($m_level_step as $key=>$row_level_step)
                                        @php
                                        // if ($row_leave->leave_info_master_id==NULL)
                                        // {
                                        //     $txt_leave_status="ffffffffff";
                                        // } else {
                                        $ci_leave_approved_details=DB::table('pro_leave_approved_details')
                                        ->Where('approved_id',$row_level_step->report_to_id)
                                        ->Where('leave_info_master_id',$row_leave->leave_info_master_id)
                                        ->Where('valid','1')
                                        ->first();
                                        // dd($ci_leave_approved_details);

                                        if($ci_leave_approved_details == NULL)
                                        {
                                            $txt_leave_status="Pending";
                                            $txt_approved_date='';
                                        } else {
                                            $txt_leave_status="Approved";
                                            $txt_approved_date=$ci_leave_approved_details->entry_date;
                                        }
                                        // }
                                        @endphp
                                        <tr>
                                            <td>{{ $row_level_step->employee_name }}</td>
                                            <td>{{ $txt_leave_status }} <br> {{$txt_approved_date}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection


@section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getemployee();
            });

            $('select[name="cbo_posting"]').on('change', function() {
                getemployee();
                getSubPosting();
            });

            $('select[name="cbo_sub_posting"]').on('change', function() {
                employeeDivShow();
                getemployee();
            });
        });

        function getemployee() {
            var cbo_company_id = $('#cbo_company_id').val();
            var cbo_posting = $('#cbo_posting').val();
            // var cbo_section = $('#cbo_section').val();
            var cbo_sub_posting = $('#cbo_sub_posting').val();
            if (cbo_company_id && cbo_posting) {

                $.ajax({
                    url: "{{ url('/get/employee/') }}/" + cbo_company_id + '/' + cbo_posting + '/' +
                        cbo_sub_posting,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_employee_id"]').empty();
                        if (data) {
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="">--Select Employee--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_employee_id"]').append(
                                    '<option value="' + value.employee_id + '">' +
                                    value.employee_id + ' | ' + value.employee_name + '</option>');
                            });
                        } // if(data){
                    },
                });

            } else {
                $('select[name="cbo_employee_id"]').empty();
            }
        }


        function getSubPosting() {
            var cbo_posting = $('#cbo_posting').val();
            if (cbo_posting) {
                $.ajax({
                    url: "{{ url('/get/sub_posting/') }}/" + cbo_posting,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                       
                        if (data.length > 0) {
                            $('select[name="cbo_sub_posting"]').empty();
                            $('select[name="cbo_sub_posting"]').append(
                                '<option value="0">--Select Sub-Posting --</option>');
                            employeeDivHide();
                        }else{
                            $('select[name="cbo_sub_posting"]').empty();
                            $('select[name="cbo_sub_posting"]').append(
                                '<option value="0">--Select Sub-Posting --</option>');
                            getEmployee();
                            employeeDivShow();
                        }
                        if (data) {
                            $.each(data, function(key, value) {
                                $('select[name="cbo_sub_posting"]').append(
                                    '<option value="' + value.placeofposting_sub_id + '">' +
                                    value.sub_placeofposting_name + '</option>');
                            });
                        } // if(data){
                    },
                });
            } else {
                $('select[name="cbo_sub_posting"]').empty();
            }
        }


        function employeeDivHide() {
            $('#cbo_employee_id').attr('disabled', 'disabled');
        }

        function employeeDivShow() {
            // $("#cbo_placeofposting_sub_id").val('0')
            $('#cbo_employee_id').removeAttr('disabled');
        }
    </script>

    <script>
        $(document).ready(function() {
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