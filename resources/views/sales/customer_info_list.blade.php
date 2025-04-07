<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h3 class="card-title"></h3> --}}
                </div>
                <div class="card-body">
                    <table id="customer_list" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Contact Person</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                       {{-- Get dynamic data  --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function() {
            $('select[name="cbo_company"]').on('change', function() {
                getEmployee();
            });
        }); // end document

        function getEmployee(){
            var cbo_company = $('#cbo_company').val();
            if(cbo_company){
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/customer_list') }}/"+cbo_company,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#customer_list")) {
                            $('#customer_list').DataTable().clear().destroy();
                        }
                    }
                    $('#customer_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        order: [[0, 'desc']],
                        dom: 'Blfrtip',
                        buttons: [{
                                extend: 'csvHtml5',
                                title: 'Quotation'
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Quotation'
                                // orientation: 'landscape',
                                // pageSize: 'LEGAL'
                            },
                            {
                                extend: 'print',
                                title: 'Quotation',
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
                                    return data.customer_id;
                                }
                            },
                            {
                                "data": "customer_name"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.customer_address + "<br>" + data
                                        .customer_email;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.contact_person + "<br>" + data
                                        .customer_phone;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/sales/customer_info/edit/' +
                                        data.customer_id +'/'+data.company_id+
                                        '"><i class="fas fa-edit"></i></a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax                
        } //endif

        } //End function
    </script>


<script>
    function BTON() {

        if ($('#confirm_action').prop('disabled')) {
            $("#confirm_action").prop("disabled", false);
        } else {
            $("#confirm_action").prop("disabled", true);
        }
    }

    function BTOFF() {
        if ($('#confirm_action').prop('disabled')) {
            $("#confirm_action").prop("disabled", true);
        } else {
            $("#confirm_action").prop("disabled", true);
        }
        document.getElementById("myForm").submit();
    }
</script>
@endsection

@section('CSS')
    <style>
        #customer_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
