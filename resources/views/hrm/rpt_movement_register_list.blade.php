@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Movement Report</h1>
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
              <form action="{{ route('rpt_movement_register_details') }}" method="Post">
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

  @if(isset($m_movement))

  <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h5><?= 'Movement Application List' ?></h5>
                    </div>
                    <table id="data2" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Type</th>
                                <th>Employee</th>
                                <th>Application<br>Date & Time</th>
                                <th>Applied For</th>
                                <th>Purpose</th>
                                <th class="text-center">Approved By</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($m_movement as $key => $row_late_app)
                                @php
                                    $ci_late_type = DB::table('pro_late_type')
                                        ->Where('valid', '1')
                                        ->Where('late_type_id', $row_late_app->late_type_id)
                                        ->first();

                                @endphp


                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $ci_late_type->late_type }}</td>
                                    <td>{{ $row_late_app->employee_name }} <br> {{ $row_late_app->employee_id }} </td>
                                    <td>{{ $row_late_app->entry_date }}<br>{{ $row_late_app->entry_time }}</td>
                                    <td>{{ $row_late_app->late_form }} to
                                        {{ $row_late_app->late_to }}<br>{{ $row_late_app->late_total }} day</td>
                                    <td>{{ $row_late_app->purpose_late }}</td>
                                    <td>
                                        <table id="" class="table table-borderless table-striped">
                                            @php

                                                $m_level_step = DB::table('pro_level_step')
                                                    ->leftjoin(
                                                        'pro_employee_info',
                                                        'pro_level_step.report_to_id',
                                                        'pro_employee_info.employee_id',
                                                    )
                                                    ->select('pro_level_step.*', 'pro_employee_info.employee_name')
                                                    ->Where(
                                                        'pro_level_step.employee_id',
                                                        $row_late_app->employee_id,
                                                    )
                                                    ->Where('pro_level_step.valid', '1')
                                                    ->orderby('pro_level_step.level_step', 'DESC')
                                                    ->get();

                                            @endphp

                                            @foreach ($m_level_step as $row)
                                                <tr>
                                                    <td>{{ $row->employee_name }}</td>
                                                    <td>
                                                        @php
                                                            $approved_check = DB::table('pro_late_approved_details')
                                                                ->where(
                                                                    'late_inform_master_id',
                                                                    $row_late_app->late_inform_master_id,
                                                                )
                                                                ->where('approved_id', $row->report_to_id)
                                                                ->first(); //approved other
                                                            $approved_check01 = DB::table('pro_late_inform_details')
                                                                ->where(
                                                                    'late_inform_master_id',
                                                                    $row_late_app->late_inform_master_id,
                                                                )
                                                                ->where('approved_id', $row->report_to_id)
                                                                ->first(); //direct approved
                                                        @endphp
                                                        @if (isset($approved_check) || isset($approved_check01))
                                                            {{ 'Approved' }}
                                                        @else
                                                            {{-- //reject person --}}
                                                            @if ($row_late_app->status == 3 && $row_late_app->late_approved == $row->report_to_id)
                                                                {{ 'Reject' }}
                                                            @else
                                                                {{ 'Pending' }}
                                                            @endif
                                                        @endif
                                                       <br> {{ $row_late_app->approved_date }}

                                                    </td>

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