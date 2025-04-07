@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">All Policy Change</h1>
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
            <form action="{{route('HrmAllPolicyChangeStore')}}" method="Post">
            @csrf

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
              <div class="col-2">
                <select name="cbo_posting" id="cbo_posting" class="form-control">
                  <option value="0">--Posting--</option>
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
                  <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                      <option value="">--Policy--</option>
                  </select>
                  @error('sele_att_policy')
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
&nbsp;
@endsection



@section('script')



  @section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
               getPosting();
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



       function getPosting()
        {
           var cbo_company_id = $('#cbo_company_id').val();
           if(cbo_company_id)
           {
              $.ajax({
                  url: "{{ url('/get/posting/') }}/" + cbo_company_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('select[name="cbo_posting"]').empty();
                    if(data){
                      $('select[name="cbo_posting"]').append(
                          '<option value="">--Posting--</option>');
                      $.each(data, function(key, value) {
                          $('select[name="cbo_posting"]').append(
                              '<option value="' + value.placeofposting_id + '">' +
                              value.placeofposting_name +'</option>');
                      });
                    } // if(data){
                  },
              });
           }else{
             $('select[name="cbo_posting"]').empty();
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
                          '<option value="">--Policy--</option>');
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
                          '<option value="0">--Sub-Posting--</option>');
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
