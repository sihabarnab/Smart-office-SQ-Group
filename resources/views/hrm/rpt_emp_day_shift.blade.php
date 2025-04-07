@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Shifting Report</h1>
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
            <form action="{{ route('EmpDayShiftReport') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
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
              <div class="col-3">
                <select name="cbo_posting" id="cbo_posting" class="form-control">
                  <option value="">--Posting--</option>
                  @foreach ($m_placeofposting as $row_placeofposting)
                      <option value="{{ $row_placeofposting->placeofposting_id }}" {{ $row_placeofposting->placeofposting_id == old('cbo_posting')? 'selected':'' }}>
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
                  <option value="0">--Sub Posting--</option>
                </select>
                @error('cbo_sub_posting')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
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
                <button type="Submit" class="btn btn-primary btn-block">Next</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
{{-- @include('/hrm/leave_status') --}}
&nbsp;
  @section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
               getemployee();
               getPolicy();
            });
            
            $('select[name="cbo_posting"]').on('change', function() {
               getemployee();
               getSubPosting();
            });

            $('select[name="cbo_section"]').on('change', function() {
               getemployee();
            }); 

            $('select[name="cbo_sub_posting"]').on('change', function() {
               getemployee();
            });
        });

       function getemployee()
       {
         var cbo_company_id = $('#cbo_company_id').val();
         var cbo_posting = $('#cbo_posting').val();
         // var cbo_section = $('#cbo_section').val();
         var cbo_sub_posting = $('#cbo_sub_posting').val();
          if (cbo_company_id && cbo_posting) {

              $.ajax({
                  url: "{{ url('/get/employee/') }}/" + cbo_company_id+'/'+cbo_posting+'/'+cbo_sub_posting,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('select[name="cbo_employee_id"]').empty();
                    if(data){
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

          } 
          else
          {
            $('select[name="cbo_employee_id"]').empty();
          }
        }

       function getPolicy()
        {
           var cbo_company_id = $('#cbo_company_id').val();
           if(cbo_company_id)
           {
              $.ajax({
                  url: "{{ url('/get/policy/') }}/" + cbo_company_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('select[name="sele_att_policy"]').empty();
                    if(data){
                      $('select[name="sele_att_policy"]').append(
                          '<option value="">--Select Policy--</option>');
                      $.each(data, function(key, value) {
                          $('select[name="sele_att_policy"]').append(
                              '<option value="' + value.att_policy_id + '">' +
                              value.att_policy_name + ' | ' + value.in_time +' | '+value.out_time+ '</option>');
                      });
                    } // if(data){
                  },
              });
           }else{
             $('select[name="sele_att_policy"]').empty();
           }
        }

        function getSubPosting()
        {
           var cbo_posting = $('#cbo_posting').val();
           if(cbo_posting)
           {
              $.ajax({
                  url: "{{ url('/get/sub_posting/') }}/" + cbo_posting,
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
@endsection