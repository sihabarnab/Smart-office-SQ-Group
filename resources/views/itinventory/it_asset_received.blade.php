@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Receiving Form</h1>
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
            <form action="{{ route('ItAssetReceivedStore') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-4">
                  <select name="cbo_company_id" id="cbo_company_id" class="form-control" onchange="acc()">
                    <option value="0">--Company--</option>
                    @foreach ($m_company as $row_company)
                        <option value="{{ $row_company->company_id }}">
                            {{ $row_company->company_name }}
                        </option>
                    @endforeach
                  </select>
                    <div id='demo1' class="text-warning"> </div>
                  @error('cbo_company_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <select name="cbo_placeofposting_id" id="cbo_placeofposting_id" class="form-control" onchange="acc()">
                    <option value="0">--Posting--</option>
                    @foreach ($m_placeofposting as $row_placeofposting)
                        <option value="{{ $row_placeofposting->placeofposting_id }}">
                            {{ $row_placeofposting->placeofposting_name }}
                        </option>
                    @endforeach
                  </select>
                  <div id='demo' class="text-warning"> </div>
                  @error('cbo_placeofposting_id')
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
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="hidden" name="txt_desig_id" id="txt_desig_id" readonly value="">
                <input type="text" class="form-control" name="txt_desig_name" id="txt_desig_name"
                    value="{{ old('txt_desig_name') }}" placeholder="Desig" readonly>
                @error('txt_desig_name')
                    <span class="text-warning">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-3">
                <input type="hidden" name="txt_department_id" id="txt_department_id" readonly value="">
                <input type="text" class="form-control" name="txt_department_name" id="txt_department_name"
                    value="{{ old('txt_department_name') }}" placeholder="Department" readonly>
                @error('txt_department_name')
                    <span class="text-warning">{{ $message }}</span>
                @enderror
              </div>
                <div class="col-6">
                    <input type="text" class="form-control" name="txt_remarks"
                        id="txt_remarks" value="{{ old('txt_remarks') }}"
                        placeholder="Remarks">
                    @error('txt_remarks')
                        <span class="text-warning">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="row mb-2">
              <div class="col-6">
                  <select name="cbo_it_asset_id" id="cbo_it_asset_id" class="form-control">
                    <option value="0">--Asset--</option>
                  </select>
                  @error('cbo_it_asset_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_qty" name="txt_qty" placeholder="Qty" value="{{ old('txt_qty') }}">
                  @error('txt_qty')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-10">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Add</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
{{-- @include('/itinventory/it_asset_issue_list') --}}

@endsection
@section('script')
  {{-- //Company to Employee Use Ajax --}}
  
  <script type="text/javascript">
      function acc(){
       // document.getElementById('demo').innerHTML="";
       $('#demo').empty();
       $('#demo1').empty();
          var cbo_placeofposting_id = $('#cbo_placeofposting_id').val();
          var cbo_company_id = $('#cbo_company_id').val();

          // console.log('test');
          console.log(cbo_company_id)
          console.log(cbo_placeofposting_id)
          if (cbo_placeofposting_id !=0 && cbo_company_id != 0) {

            $.ajax({
              url: "{{ url('/get/employee3/') }}/"+cbo_placeofposting_id+'/'+cbo_company_id,
              type:"GET",
              dataType:"json",
              success:function(data) {
                  // console.log(data)
              var d =$('select[name="cbo_employee_id"]').empty();
              $('select[name="cbo_employee_id"]').append('<option value="0">--Employee--</option>');
              $.each(data, function(key, value){
              $('select[name="cbo_employee_id"]').append('<option value="' + value.employee_id + '">' + value.employee_id + ' | ' + value.employee_name + '</option>');
              });
              },
            });

          }
          else if(cbo_placeofposting_id==0  && cbo_company_id == 0 ){
          document.getElementById('demo').innerHTML="place position required";
           document.getElementById('demo1').innerHTML="company required";
          }

          else if(cbo_placeofposting_id==0){
          document.getElementById('demo').innerHTML="place position required";
          }
          else if(cbo_company_id == 0){
            // alert('danger');
           document.getElementById('demo1').innerHTML="company required";
          }

      }
  </script>
  <script type="text/javascript">
      $(document).ready(function() {
          $('select[name="cbo_employee_id"]').on('change', function() {
              var cbo_employee_id = $(this).val();
              if (cbo_employee_id) {
                  $.ajax({
                      url: "{{ url('/get/it_asset_received') }}/" + cbo_employee_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          var d = $('select[name="cbo_it_asset_id"]').empty();
                          $('select[name="cbo_it_asset_id"]').append(
                              '<option value="0">--Select Asset--</option>');
                          $.each(data, function(key, value) {
                              $('select[name="cbo_it_asset_id"]').append(
                                  '<option value="' + value.itasset_id + '">' +
                                  value.itasset_id + ' | ' + value.product_type_name + ' | ' + value.brand_name + ' | ' + value.model + '</option>');
                          });
                      },
                  });

              } else {
                  alert('danger');
              }

          });
      });
  </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_employee_id"]').on('change', function() {
                $('#txt_desig_id').empty();
                $('#txt_desig_name').empty();
                $('#department_id').empty();
                $('#department_name').empty();
                var cbo_employee_id = $(this).val();
                if (cbo_employee_id) {
                    $.ajax({
                        url: "{{ url('/get/it_asset_emp_info') }}/" +
                            cbo_employee_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data1) {
                            $('#txt_desig_id').val(data1.desig_id);
                            $('#txt_desig_name').val(data1.desig_name);
                            $('#txt_department_id').val(data1.department_id);
                            $('#txt_department_name').val(data1.department_name);
                        },
                    });

                } else {
                    alert('danger');
                }

            });
        });
    </script>
  
@endsection
@section('css')
#it_asset_issue_list_filter {
    margin-top: -25px;
}
@endsection
