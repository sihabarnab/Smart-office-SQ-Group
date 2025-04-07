@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-1">
                <div class="col-sm-6">
                    <h1 class="m-0">Movement</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('hrmbackrptovementList') }}" method="post">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-3">
                            <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                <option value="">--Select Company--</option>
                                @foreach ($user_company as $company)
                                    <option value="{{ $company->company_id }}"
                                        {{ $company->company_id == $company_id ? 'selected' : '' }}>
                                        {{ $company->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cbo_company_id')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-3">
                            <select name="cbo_posting" id="cbo_posting" class="form-control">
                                <option value="">--Select Posting--</option>
                                @foreach ($m_placeofposting as $row_placeofposting)
                                    <option value="{{ $row_placeofposting->placeofposting_id }}"
                                        {{ $row_placeofposting->placeofposting_id == $placeofposting_id ? 'selected' : '' }}>
                                        {{ $row_placeofposting->placeofposting_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cbo_posting')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-3">
                            <select name="cbo_sub_posting" id="cbo_sub_posting" class="form-control">
                                <option value="0">--Select Sub Posting--</option>
                            </select>
                            @error('cbo_sub_posting')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-3">
                            <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                <option value="">--Select Employee--</option>
                            </select>
                            @error('cbo_employee_id')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-3">
                            <input type="date" class="form-control" id="txt_from_date" name="txt_from_date"
                                placeholder="From Date" value="{{ $form }}">
                            <div id='err_txt_form_date'>
                            </div>
                            @error('txt_from_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <input type="date" class="form-control" id="txt_to_date" name="txt_to_date"
                                placeholder="To Date" value="{{ $to }}">
                            @error('txt_to_date')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-4">

                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block mt-2">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>


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
                                    <th>Approved For</th>
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
                                        <td>{{ $row_late_app->approved_date }}</td>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getPosting();
            $('select[name="cbo_company_id"]').on('change', function() {
                getPosting();
                getEmployee();
            });
            $('select[name="cbo_posting"]').on('change', function() {
                getSubPosting();
                getEmployee();
            });
            $('select[name="cbo_sub_posting"]').on('change', function() {
                getEmployee();
                employeeDivShow();
            });
        });

        //Company to Posting 
        function getPosting() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/hrm/placeofposting/') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_posting"]').empty();
                        $('select[name="cbo_posting"]').append(
                            '<option value="">--Select Posting--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_posting"]').append(
                                '<option value="' + value.placeofposting_id + '">' + value
                                .placeofposting_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_posting"]').empty();
            }
        }

        // posting to sub posting 
        function getSubPosting() {
            var cbo_posting = $('#cbo_posting').val();
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_posting && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/hrm/placeofsubposting/') }}/" + cbo_posting + '/' +
                        cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                      if(data.length > 0){
                         employeeDivHide();
                      }
                        $('select[name="cbo_sub_posting"]').empty();
                        $('select[name="cbo_sub_posting"]').append(
                            '<option value="">--Select Sub Posting--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_sub_posting"]').append(
                                '<option value="' + value.placeofposting_sub_id + '">' + value
                                .sub_placeofposting_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_sub_posting"]').empty();
            }
        }


        // Get Employee 
        function getEmployee() {
            var cbo_posting = $('#cbo_posting').val();
            var cbo_company_id = $("#cbo_company_id").val();
            var cbo_sub_posting = $("#cbo_sub_posting").val();
            if(cbo_sub_posting){
             var sub_posting = cbo_sub_posting;
            }else{
              var sub_posting = 0;
            }
            if (cbo_company_id && cbo_posting) {
                $.ajax({
                    url: "{{ url('/get/hrm/employee/') }}/" + cbo_posting + '/' +
                    sub_posting+'/'+cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                      console.log(data);
                        var d = $('select[name="cbo_employee_id"]').empty();
                        $('select[name="cbo_employee_id"]').append(
                            '<option value="0">--Employee--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="' + value.employee_id + '">' +
                                value.employee_id + ' | ' + value
                                .employee_name + '</option>');
                        });
                    },
                });

            }
        }

        function employeeDivHide()
        {
            $('#cbo_employee_id').attr('disabled', 'disabled');
        }
        function employeeDivShow()
        {
            $('#cbo_employee_id').removeAttr('disabled');
        }
    </script>
@endsection