@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IP and Mac Information</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>

@if(isset($m_ipmac_info))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form action="{{ route('ItIpMacUpdate',$m_ipmac_info->ipmac_info_id) }}" method="Post">
            @csrf
              <div class="row mb-2">
                <div class="col-6">
                  <input type="hidden" class="form-control" id="txt_ipmac_info_id" name="txt_ipmac_info_id" value="{{ $m_ipmac_info->ipmac_info_id }}">
                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                      <option value="0">--Company--</option>
                      @foreach ($user_company as $company)
                          <option value="{{ $company->company_id }}" {{$company->company_id == $m_ipmac_info->company_id? 'selected':''}}>
                              {{ $company->company_name }}
                          </option>
                      @endforeach
                    </select>
                    @error('cbo_company_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6">
                  <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                    <option value="{{ $m_ipmac_info->employee_id }}">{{ $m_employee_info->employee_name }}</option>
                    <option value="0">--Employee--</option>
                  </select>
                  @error('cbo_employee_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>                
              </div>
              <div class="row mb-2">
                <div class="col-3">
                  <select name="cbo_product_type_id" id="cbo_product_type_id" class="form-control">
                      <option value="0">--Device--</option>
                      @foreach ($m_product_type as $row_product_type)
                          <option value="{{ $row_product_type->product_type_id }}" {{$row_product_type->product_type_id == $m_ipmac_info->product_type_id? 'selected':''}}>
                              {{ $row_product_type->product_type_name }}
                          </option>
                      @endforeach
                  </select>
                  @error('cbo_product_type_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_wifilan_id" id="cbo_wifilan_id" class="form-control">
                      <option value="0">--Connection Method--</option>
                      @foreach ($m_wifilan as $row_wifilan)
                          <option value="{{ $row_wifilan->wifilan_id }}" {{$row_wifilan->wifilan_id == $m_ipmac_info->wifilan_id? 'selected':''}}>
                              {{ $row_wifilan->wifilan_name }}
                          </option>
                      @endforeach
                  </select>
                  @error('cbo_wifilan_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_ip" name="txt_ip" placeholder="IP" value="{{ $m_ipmac_info->ip }}">
                    @error('txt_ip')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_mac" name="txt_mac" placeholder="MAC" value="{{ $m_ipmac_info->mac }}">
                    @error('txt_mac')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-12">
                  <input type="text" class="form-control" id="txt_description" name="txt_description" placeholder="Description" value="{{ $m_ipmac_info->description }}">
                    @error('txt_description')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Update</button>
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
  <div class="card">
    <div class="card-body">
      <div align="left" class=""></div>
        <form action="{{ route('ItIpMacStore') }}" method="Post">
        @csrf

        <div class="row mb-2">
          <div class="col-6">
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
          <div class="col-6">
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
              <select name="cbo_product_type_id" id="cbo_product_type_id" class="form-control">
                <option value="0">--Device--</option>
                @foreach ($m_product_type as $row_product_type)
                    <option value="{{ $row_product_type->product_type_id }}">
                        {{ $row_product_type->product_type_name }}
                    </option>
                @endforeach
              </select>
              @error('cbo_product_type_id')
                  <div class="text-warning">{{ $message }}</div>
              @enderror
          </div>
          <div class="col-3">
              <select name="cbo_wifilan_id" id="cbo_wifilan_id" class="form-control">
                <option value="0">--Connection Method--</option>
                @foreach ($m_wifilan as $row_wifilan)
                    <option value="{{ $row_wifilan->wifilan_id }}">
                        {{ $row_wifilan->wifilan_name }}
                    </option>
                @endforeach
              </select>
              @error('cbo_wifilan_id')
                  <div class="text-warning">{{ $message }}</div>
              @enderror
          </div>
          <div class="col-3">
            <input type="text" class="form-control" id="txt_ip" name="txt_ip" placeholder="IP" value="{{ old('txt_ip') }}">
              @error('txt_ip')
                <div class="text-warning">{{ $message }}</div>
              @enderror
          </div>
          <div class="col-3">
            <input type="text" class="form-control" id="txt_mac" name="txt_mac" placeholder="MAC" value="{{ old('txt_mac') }}">
              @error('txt_mac')
                <div class="text-warning">{{ $message }}</div>
              @enderror
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <input type="text" class="form-control" id="txt_description" name="txt_description" placeholder="Description" value="{{ old('txt_description') }}">
              @error('txt_description')
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
@endif
@include('itinventory.ip_mac_list')

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
                      url: "{{ url('/get/employee2/') }}/" + cbo_company_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          var d = $('select[name="cbo_employee_id"]').empty();
                          $('select[name="cbo_employee_id"]').append(
                              '<option value="">--Employee--</option>');
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
        window.onload = function() {
            var k=1;
            $.ajax({
                url: "{{ url('/get/ip_mac_list') }}/",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#ip_mac_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": true,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'IP/MAC Information'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'IP/MAC Information'
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
                            },
                            {
                                extend: 'print',
                                title: 'IP/MAC Information',
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
                                "data": "company_name"
                            },
                            {
                                "data": "employee_name"
                            },
                            {
                              data: null,
                              render: function(data, type, full) {

                                return data.product_type_name + '<br>' + data.wifilan_name; 
                              }
                            },
                            {
                              data: null,
                              render: function(data, type, full) {

                                return data.ip + '<br>' + data.mac; 
                              }

                            },
                            {
                                "data": "description"
                            },
                            {
                                data: null,
                                render: function(data, type,full) {
                                    return '<a href="{{ url("/")}}/itinventory/ip_mac_info/edit/'+data.ipmac_info_id+'" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>'; 
                                }
                            },

                        ]
                    }) // end dataTable

                },  // End Sucess
            });  // end Ajax

        } // end Windows onload
    </script>
   
@endsection
