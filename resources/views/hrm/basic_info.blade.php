@extends('layouts.hrm_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee Basic Information</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        @include('flash-message')
    </div>
    @if (isset($m_basic_info))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div align="left" class="">
                                <h5>{{ 'Edit' }}</h5>
                            </div>
                            <form name="" method="post"
                                action="{{ route('hrmbackbasic_infoupdate', $m_basic_info->employee_info_id) }}">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id"
                                            placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                                        <select name="sele_company_id" id="sele_company_id" class="form-control">
                                            <option value="0">--Company--</option>
                                            @foreach ($m_pro_company as $row_company)
                                                <option value="{{ $row_company->company_id }}"
                                                    {{ $row_company->company_id == $m_basic_info->company_id ? 'selected' : '' }}>
                                                    {{ $row_company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_emp_id" name="txt_emp_id"
                                            placeholder="Employee ID" readonly value="{{ $m_basic_info->employee_id }}">
                                        @error('txt_emp_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_emp_name" name="txt_emp_name"
                                            placeholder="Employee Name" value="{{ $m_basic_info->employee_name }}">
                                        @error('txt_emp_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_level_step" name="txt_level_step"
                                            placeholder="Employee Name" value="{{ $m_basic_info->level_step }}">
                                        @error('txt_level_step')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select name="sele_desig" id="sele_desig" class="form-control">
                                            <option value="">Select Desig</option>
                                            @foreach ($m_pro_desig as $row_desig)
                                                <option value="{{ $row_desig->desig_id }}"
                                                    {{ $row_desig->desig_id == $m_basic_info->desig_id ? 'selected' : '' }}>
                                                    {{ $row_desig->desig_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_desig')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="sele_department" id="sele_department" class="form-control">
                                            <option value="">Select Department</option>
                                            @foreach ($m_pro_department as $row_department)
                                                <option value="{{ $row_department->department_id }}"
                                                    {{ $row_department->department_id == $m_basic_info->department_id ? 'selected' : '' }}>
                                                    {{ $row_department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_department')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="sele_section" id="sele_section" class="form-control">
                                            <option value="">Select Section</option>
                                            @foreach ($m_pro_section as $row_section)
                                                <option value="{{ $row_section->section_id }}"
                                                    {{ $row_section->section_id == $m_basic_info->section_id ? 'selected' : '' }}>
                                                    {{ $row_section->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_section')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="sele_placeofposting" id="sele_placeofposting" class="form-control">
                                            <option value="">Select Place of Posting</option>
                                            @foreach ($m_pro_placeofposting as $row_placeofposting)
                                                <option value="{{ $row_placeofposting->placeofposting_id }}"
                                                    {{ $row_placeofposting->placeofposting_id == $m_basic_info->placeofposting_id ? 'selected' : '' }}>
                                                    {{ $row_placeofposting->placeofposting_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_placeofposting')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                  <div class="col-3">
                                    <select name="cbo_sub_posting" id="cbo_sub_posting" class="form-control">
                                      <option value="0">--Sub Posting--</option>
                                    </select>
                                    @error('cbo_sub_posting')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                  </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_joining_date"
                                            name="txt_joining_date" placeholder="Joinning Date"
                                            value="{{ $m_basic_info->joinning_date }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_joining_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                                            <option value="">Select Policy</option>
                                            @foreach ($m_pro_att_policy as $row_att_policy)
                                                <option value="{{ $row_att_policy->att_policy_id }}"
                                                    {{ $row_att_policy->att_policy_id == $m_basic_info->att_policy_id ? 'selected' : '' }}>
                                                    {{ $row_att_policy->att_policy_name }} |
                                                    {{ $row_att_policy->in_time }} | | {{ $row_att_policy->out_time }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_att_policy')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <select name="sele_gender_id" id="sele_gender_id" class="form-control">
                                            <option value="">Select Gender</option>
                                            @foreach ($m_pro_gender as $row_gender)
                                                <option value="{{ $row_gender->gender_id }}"
                                                    {{ $row_gender->gender_id == $m_basic_info->gender ? 'selected' : '' }}>
                                                    {{ $row_gender->gender_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_gender_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_emp_mobile"
                                            name="txt_emp_mobile" placeholder="Mobile No."
                                            value="{{ $m_basic_info->mobile }}">
                                        @error('txt_emp_mobile')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <select name="sele_blood" id="sele_blood" class="form-control">
                                            <option value="">Select Blood</option>
                                            @foreach ($m_pro_blood as $row_blood)
                                                <option value="{{ $row_blood->blood_id }}"
                                                    {{ $row_blood->blood_id == $m_basic_info->blood_group ? 'selected' : '' }}>
                                                    {{ $row_blood->blood_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_blood')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_grade" name="txt_grade"
                                            placeholder="Grade" value="{{ $m_basic_info->grade }}">
                                        @error('txt_grade')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_psm_id" name="txt_psm_id"
                                            placeholder="PSM ID" value="{{ $m_basic_info->psm_id }}">
                                        @error('txt_psm_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_staff_id" name="txt_staff_id"
                                            placeholder="Staff ID" value="{{ $m_basic_info->staff_id }}">
                                        @error('txt_staff_id')
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>
                            <form action="{{ route('hrmbackbasic_infostore') }}" method="Post">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <input type="hidden" class="form-control" id="txt_user_id" name="txt_user_id"
                                            placeholder="" readonly value="{{ Auth::user()->emp_id }}">

                                        <select name="sele_company_id" id="sele_company_id" class="form-control">
                                            <option value="">--Company--</option>
                                            @foreach ($user_company as $company)
                                                <option value="{{ $company->company_id }}">
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_emp_id" name="txt_emp_id"
                                            placeholder="Employee ID" value="{{ old('txt_emp_id') }}">
                                        @error('txt_emp_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_emp_name" name="txt_emp_name"
                                            placeholder="Employee Name" value="{{ old('txt_emp_name') }}">
                                        @error('txt_emp_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_level_step" name="txt_level_step"
                                            placeholder="Report" value="{{ old('txt_level_step') }}">
                                        @error('txt_level_step')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        @php
                                            $data_pro_desig = DB::table('pro_desig')
                                                ->Where('valid', '1')
                                                ->orderBy('desig_id', 'asc')
                                                ->get(); //query builder
                                        @endphp
                                        <select name="sele_desig" id="sele_desig" class="form-control">
                                            <option value="">--Select Designation--</option>
                                            @foreach ($data_pro_desig as $emp_desig)
                                                <option value="{{ $emp_desig->desig_id }}">
                                                    {{ $emp_desig->desig_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_desig')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        @php
                                            $data_pro_department = DB::table('pro_department')
                                                ->Where('valid', '1')
                                                ->orderBy('department_id', 'asc')
                                                ->get(); //query builder
                                        @endphp
                                        <select name="sele_department" id="sele_department" class="form-control">
                                            <option value="">--Select Department--</option>
                                            @foreach ($data_pro_department as $emp_department)
                                                <option value="{{ $emp_department->department_id }}">
                                                    {{ $emp_department->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_department')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        @php
                                            $data_pro_section = DB::table('pro_section')
                                                ->Where('valid', '1')
                                                ->orderBy('section_id', 'asc')
                                                ->get(); //query builder
                                        @endphp
                                        <select name="sele_section" id="sele_section" class="form-control">
                                            <option value="">--Select Section--</option>
                                            @foreach ($data_pro_section as $emp_section)
                                                <option value="{{ $emp_section->section_id }}">
                                                    {{ $emp_section->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_section')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        @php
                                            $data_pro_placeofposting = DB::table('pro_placeofposting')
                                                ->Where('valid', '1')
                                                ->orderBy('placeofposting_id', 'asc')
                                                ->get(); //query builder
                                        @endphp
                                        <select name="sele_placeofposting" id="sele_placeofposting" class="form-control">
                                            <option value="">Select Place of Posting</option>
                                            @foreach ($data_pro_placeofposting as $emp_placeofposting)
                                                <option value="{{ $emp_placeofposting->placeofposting_id }}">
                                                    {{ $emp_placeofposting->placeofposting_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_placeofposting')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3">
                                        <select name="cbo_sub_posting" id="cbo_sub_posting" class="form-control">
                                          <option value="0">--Sub Posting--</option>
                                        </select>
                                        @error('cbo_sub_posting')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror                                       
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="txt_joining_date"
                                            name="txt_joining_date" placeholder="Joining Date"
                                            value="{{ old('txt_joining_date') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_joining_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">

                                      <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                                          <option value="0">Select Policy</option>
                                      </select>
                                      @error('sele_att_policy')
                                          <div class="text-warning">{{ $message }}</div>
                                      @enderror

                                    </div>
                                    <div class="col-2">
                                        @php
                                            $data_pro_gender = DB::table('pro_gender')
                                                ->Where('valid', '1')
                                                ->orderBy('gender_id', 'asc')
                                                ->get(); //query builder
                                        @endphp
                                        <select name="sele_gender_id" id="sele_gender_id" class="form-control">
                                            <option value="">Select Gender</option>
                                            @foreach ($data_pro_gender as $emp_gender)
                                                <option value="{{ $emp_gender->gender_id }}">
                                                    {{ $emp_gender->gender_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_gender_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_emp_mobile"
                                            name="txt_emp_mobile" placeholder="Mobile No."
                                            value="{{ old('txt_emp_mobile') }}">
                                        @error('txt_emp_mobile')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        @php
                                            $data_pro_blood = DB::table('pro_blood')
                                                ->Where('valid', '1')
                                                ->orderBy('blood_id', 'asc')
                                                ->get(); //query builder
                                        @endphp
                                        <select name="sele_blood" id="sele_blood" class="form-control">
                                            <option value="">Select Blood</option>
                                            @foreach ($data_pro_blood as $emp_blood)
                                                <option value="{{ $emp_blood->blood_id }}">
                                                    {{ $emp_blood->blood_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sele_blood')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_grade" name="txt_grade"
                                            placeholder="Grade" value="{{ old('txt_grade') }}">
                                        @error('txt_grade')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_psm_id" name="txt_psm_id"
                                            placeholder="PSM ID" value="{{ old('txt_psm_id') }}">
                                        @error('txt_psm_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_staff_id" name="txt_staff_id"
                                            placeholder="Staff ID" value="{{ old('txt_staff_id') }}">
                                        @error('txt_staff_id')
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
        @include('/hrm/basic_info_list')
        {{-- @include('/hrm/basic_info_face_list') --}}
        &nbsp;
    @endif
@section('script')

    {{-- //Company to Policy Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {

            //get place posting
             getSubPosting();
            //get policy 
            $('select[name="sele_company_id"]').on('change', function() {
                console.log('ok')
                var sele_company_id = $(this).val();
                if (sele_company_id) {

                    $.ajax({
                        url: "{{ url('/get/company_policy/') }}/" + sele_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="sele_att_policy"]').empty();
                            $('select[name="sele_att_policy"]').append(
                                '<option value="0">Select Policy</option>');
                            $.each(data, function(key, value) {
                                $('select[name="sele_att_policy"]').append(
                                    '<option value="' + value.att_policy_id + '">' +
                                    value.att_policy_id + ' | ' + value.att_policy_name + ' | ' + value.in_time + ' | ' + value.out_time + '</option>');
                            });
                        },
                    });

                }

            });
        });

    $('select[name="sele_placeofposting"]').on('change', function() {
        getSubPosting();
    });

    function getSubPosting()
        {
           var sele_placeofposting = $('#sele_placeofposting').val();
           if(sele_placeofposting)
           {
              $.ajax({
                  url: "{{ url('/get/sub_posting/') }}/" + sele_placeofposting,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('select[name="cbo_sub_posting"]').empty();
                    if(data){
                      $('select[name="cbo_sub_posting"]').append(
                          '<option value="0">--Select Sub-Posting --</option>');
                      $.each(data, function(key, value) {
                          $('select[name="cbo_sub_posting"]').append(
                              '<option value="' + value.placeofposting_sub_id + '">' +
                              value.sub_placeofposting_name + '</option>');
                      });
                    } // if(data){
                  },
              });
           }else{
             $('select[name="cbo_sub_posting"]').empty();
           } 
        }

    </script>


    <script>
        window.onload = function() {
            var k = 1;
            $.ajax({
                url: "{{ url('/get/hrm/basic_info_list') }}/",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#basic_info_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Employee Information'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Employee Information',
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
                            },
                            {
                                extend: 'print',
                                title: 'Employee Information',
                                autoPrint: true,
                                exportOptions: {
                                    columns: ':visible'
                                },
                            },
                            'colvis',
                        ],
                        "data": data,
                        "columns": [{
                                data: null,
                                render: function(data, type, full) {
                                    return k++;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.company_name + '<br>' + data
                                        .employee_id+'<br>'+data.employee_name;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.desig_name + '<br>' + data
                                        .department_name+'<br>'+data.placeofposting_name;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.joinning_date + '/' + data
                                        .att_policy_name+'/'+data.yesno_name+
                                        '<br>'+data.mobile+'/'+data.blood_name
                                        '<br>'+data.psm_id;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                   if(data.report_to_id =='0'){
                                    return 'N/A';
                                   }else{
                                    return data.level_step;
                                   }
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                  return '<a href="{{ url('/') }}/hrm/basic_info/' +
                                        data.employee_info_id + '">Edit</a>';
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                  return '<a href="{{ url('/') }}/hrm/emp_id_card/' +
                                        data.employee_id + '">ID Card Print</a>';
                                }
                            },

                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        }; // end document
    </script>
@endsection

@section('CSS')
    <style>
        #basic_info_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection

@endsection
