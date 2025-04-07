@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Issue</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_itasset_issue))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('ItAssetIssueUpdate',$m_itasset_issue->itasset_issue_id) }}" >
            @csrf
            <div class="row mb-2">
              <div class="col-4">
                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                  <option value="0">--Company--</option>
                    @foreach($m_company as $row_company)
                      <option value="{{$row_company->company_id}}"  {{$row_company->company_id == $m_itasset_issue->company_id? 'selected':''}}>
                          {{$row_company->company_name}}
                      </option>
                    @endforeach
                </select>
                  @error('cbo_company_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="cbo_placeofposting_id" id="cbo_placeofposting_id" class="form-control">
                  <option value="0">--Posting--</option>
                    @foreach($m_placeofposting as $row_placeofposting)
                      <option value="{{$row_placeofposting->placeofposting_id}}"  {{$row_placeofposting->placeofposting_id == $m_itasset_issue->placeofposting_id? 'selected':''}}>
                          {{$row_placeofposting->placeofposting_name}}
                      </option>
                    @endforeach
                </select>
                  @error('cbo_placeofposting_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                  <option value="0">--Employee--</option>
                    @foreach($m_employee_info as $row_employee_info)
                      <option value="{{$row_employee_info->employee_id}}"  {{$row_employee_info->employee_id == $m_itasset_issue->employee_id? 'selected':''}}>
                          {{$row_employee_info->employee_name}}
                      </option>
                    @endforeach
                </select>
                  @error('cbo_employee_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-8">
                <select name="cbo_it_asset_id" id="cbo_it_asset_id" class="form-control">
                  <option value="0">--Asset--</option>
                  <option value="{{ $m_itasset_issue->itasset_id }}">{{ $m_itasset_issue->itasset_id }}</option>
                    @foreach($m_itassets as $row_itassets)
                      <option value="{{$row_itassets->itasset_id}}"  {{$row_itassets->itasset_id == $m_itasset_issue->itasset_id? 'selected':''}}>
                            {{ $row_itassets->itasset_id }} | {{ $row_itassets->product_type_name }} | {{ $row_itassets->brand_name }} | {{ $row_itassets->serial }}
                      </option>
                    @endforeach
                </select>
                  @error('cbo_it_asset_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="txt_issue_date"
                    name="txt_issue_date" placeholder="Issue Date"
                    value="{{ $m_itasset_issue->issue_date }}" onfocus="(this.type='date')"
                    onblur="if(this.value==''){this.type='text'}">
                @error('txt_issue_date')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>              
            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_remarks"
                    name="txt_remarks" placeholder="Remarks/Comments/Note"
                    value="{{ $m_itasset_issue->remarks }}">
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('ItAssetIssueStore') }}" method="Post">
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
              <div class="col-8">
                  <select name="cbo_it_asset_id" id="cbo_it_asset_id" class="form-control">
                    <option value="0">--Asset--</option>
                    @foreach ($mm_itasset as $row_itasset)
                        <option value="{{ $row_itasset->itasset_id }}">
                            {{ $row_itasset->itasset_id }} | {{ $row_itasset->product_type_name }} | {{ $row_itasset->brand_name }} | {{ $row_itasset->serial }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_it_asset_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-4">
                <input type="text" class="form-control" id="txt_issue_date" name="txt_issue_date" placeholder="Issue Date" value="{{ old('txt_issue_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_issue_date')
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
@include('/itinventory/it_asset_issue_list')

@endif
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
            url: "{{ url('/get/it_asset_issue_list') }}/",
            type: "GET",
            dataType: "json",
            success: function(data) {
              // console.log(data);
                $('#it_asset_issue_list').dataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    dom: 'Blfrtip',
                    buttons: [{
                            extend: 'csvHtml5',
                            title: 'IT Asset Issue List'
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'IT Asset Issue List'
                            // orientation: 'landscape',
                            // pageSize: 'LEGAL'
                        },
                        {
                            extend: 'print',
                            title: 'IT Asset Issue List',
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

                                return data.product_type_name + ' ' + data.brand_name + ' ' + (data.ram==null?"":data.ram) + ' ' + (data.hdd==null? "":data.hdd) + '<br>' + (data.ssd==null?"":data.ssd) + ' ' + (data.display==null?"":data.display) + ' ' + (data.serial==null?"":data.serial) + '<br>' + (data.warranty_year==0?"":data.warranty_year + ' ' + 'Year'); 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.issue_date; 
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
                                return '<a href="{{ url("/")}}/itinventory/it_asset_issue/edit/'+data.itasset_issue_id+'" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>'; 
                            }
                        },
                    ]
                }) // end dataTable

            },  // End Sucess
        });  // end Ajax

    } // end Windows onload
  </script>
  
@endsection
@section('css')
#it_asset_issue_list_filter {
    margin-top: -25px;
}
@endsection
