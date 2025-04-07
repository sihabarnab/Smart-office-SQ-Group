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
            <form action="{{route('emp_day_shift_store')}}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_atten_date" name="txt_atten_date" placeholder="Attendance Date" value="{{ old('txt_atten_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" >
                  @error('txt_atten_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
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
            </div>
            <div class="row mb-2">
                <div class="col-3">
                </div>
                <div class="col-3">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="">--Employee--</option>
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
                  <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                      <option value="">--Policy--</option>
                  </select>
                  @error('sele_att_policy')
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


    {{-- //Employee to Desig Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_employee_id"]').on('change', function() {
                var cbo_employee_id = $(this).val();
                if (cbo_employee_id) {
                    $.ajax({
                        url: "{{ url('/get/desig/') }}/" + cbo_employee_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_desig_name').val('');
                            document.getElementById("txt_desig_id").value = data.desig_id;
                            document.getElementById("txt_desig_name").value = data.desig_name;
                            // document.getElementById("txt_placeofposting_name").value = data.placeofposting_name;

                        },
                    });

                } else {
                    $('#txt_desig_name').val('');
                    // $('txt_placeofposting_name').empty();
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