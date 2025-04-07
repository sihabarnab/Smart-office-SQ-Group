@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Data Split</h1>
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
            <form action="{{ route('HrmDataSplitStore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-2">
                <input type="text" class="form-control" id="txt_from_date"
                    name="txt_from_date" placeholder="From Date"
                    value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_from_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_to_date"
                    name="txt_to_date" placeholder="To Date"
                    value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}" onchange="DateDiff(this.value)">

                @error('txt_to_date')
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
