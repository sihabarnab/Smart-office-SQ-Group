@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Return</h1>
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
              <div class="col-4">
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
              <div class="col-4">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
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
              <div class="col-3">
                <input type="text" class="form-control" id="txt_return_date" name="txt_return_date" placeholder="Return Date" value="{{ old('txt_return_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_return_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <select name="cbo_reusable" id="cbo_reusable" class="form-control">
                    <option value="0">--Re Usable--</option>
                    @foreach ($m_yesno as $row_yesno)
                        <option value="{{ $row_yesno->yesno_id }}">
                            {{ $row_yesno->yesno_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_reusable')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>

            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Remarks/Comments/Note" value="{{ old('txt_remarks') }}">
                  @error('txt_remarks')
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
@include('/itinventory/it_asset_return_list')
&nbsp;
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

  <script>
    window.onload = function() {
        var k=1;
        $.ajax({
            url: "{{ url('/get/it_asset_return_list') }}/",
            type: "GET",
            dataType: "json",
            success: function(data) {
              // console.log(data);
                $('#it_asset_return_list').dataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    dom: 'Blfrtip',
                    buttons: [{
                            extend: 'csvHtml5',
                            title: 'IT Asset Return List'
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'IT Asset Return List'
                            // orientation: 'landscape',
                            // pageSize: 'LEGAL'
                        },
                        {
                            extend: 'print',
                            title: 'IT Asset Return List',
                            autoPrint: true,
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        'colvis',
                    ],


                    "aaData": data,
                    "columns": [{
                              data: null,
                              render: function(data, type, full) {
                                return k++; 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.company_name + '<br>' + (data.placeofposting_name==null?"":data.placeofposting_name); 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.employee_name +'<br>'+data.employee_id; 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {
                              return data.itasset_id +'<br>'+ data.model;
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.product_type_name + ' ' + (data.brand_name==null?"":data.brand_name) + ' ' + (data.ram==null?"":data.ram) + ' ' + (data.hdd==null? "":data.hdd) + '<br>' + (data.ssd==null?"":data.ssd) + ' ' + (data.display==null?"":data.display) + ' ' + (data.serial==null?"":data.serial) + '<br>' + (data.warranty_year==null?"":data.warranty_year + ' ' + 'Year'); 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.return_date; 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {
                              return data.remarks;

                            }
                        },
                        {
                            data: null,
                            render: function(data, type,full) {
                                return data.yesno_name; 
                            }
                        },
                    ]
                }) // end dataTable

            },  // End Sucess
        });  // end Ajax

    } // end Windows onload
  </script>

  <script type="text/javascript">
      $(document).ready(function() {
          $('select[name="cbo_employee_id"]').on('change', function() {
              console.log('ok')
              var cbo_employee_id = $(this).val();
              if (cbo_employee_id) {

                  $.ajax({
                      url: "{{ url('/get/issue_asset/') }}/" + cbo_employee_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          var d = $('select[name="cbo_it_asset_id"]').empty();
                          $('select[name="cbo_it_asset_id"]').append(
                              '<option value="0">--Asset--</option>');
                          $.each(data, function(key, value) {
                              $('select[name="cbo_it_asset_id"]').append(
                                  '<option value="' + value.itasset_id + '">' +
                                  value.itasset_id + ' | ' + value.itasset_id + '</option>');
                          });
                      },
                  });

              }

          });
      });
  </script>

   
@endsection
@section('css')
#it_asset_return_list_filter {
    margin-top: -25px;
}
@endsection
