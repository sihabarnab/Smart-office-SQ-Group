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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="rpt_basic_info_list" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Company Name<br />Employee ID/Name</th>
                                <th>Designation/Department/<br />Posting</th>
                                <th>Joining Date/Policy /Working<br />Mobile /Blood Group /PSM ID</th>
                                <th>Report To</th>
                                <th>Extension</th>
                            </tr>
                        </thead>
                        <tbody>
                    

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        window.onload = function() {
            var k = 1;
            $.ajax({
                url: "{{ url('/get/rpt_basic_info_list') }}/",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#rpt_basic_info_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Employee List'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Employee List'
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
                            },
                            {
                                extend: 'print',
                                title: 'Employee List',
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
                                   if(data.report_to_id =='0000000'){
                                    return 'N/A';
                                   }else{
                                    return data.report_name;
                                   }
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    if(data.extension){
                                        return data.extension;
                                   }else{
                                    return "";
                                   }
                                    
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
        #rpt_basic_info_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection