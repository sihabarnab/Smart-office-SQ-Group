@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Repair Invoice</h1>
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
                        <div align="left" class="">
                            <h5>{{ 'Add' }}</h5>
                        </div>
                        <form id="myForm" action="{{ route('repair_invoice_store') }}" method="Post">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}"
                                                {{ old('cbo_company_id') == $value->company_id ? 'selected' : '' }}>
                                                {{ $value->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id='err_cbo_company_id'>

                                    </div>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <select class="form-control" id="cbo_transformer_ctpt" name="cbo_transformer_ctpt">
                                        <option value="">--Transformer / CTPT--</option>
                                        <option value="28">Transformer</option>
                                        <option value="33">CTPT</option>

                                    </select>
                                    @error('cbo_transformer_ctpt')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_customer_type_id" name="cbo_customer_type_id">
                                        <option value="">--Customer Type--</option>
                                        @foreach ($m_customer_type as $row_customer_type)
                                            <option value="{{ $row_customer_type->customer_type_id }}">
                                                {{ $row_customer_type->customer_type_id }} |
                                                {{ $row_customer_type->customer_type }}</option>
                                        @endforeach
                                    </select>

                                    @error('cbo_customer_type_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_customer" name="cbo_customer">
                                        <option value="">--Select Customer--</option>

                                    </select>
                                    @error('cbo_customer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_customer_address"
                                        name="txt_customer_address" placeholder="Address" readonly
                                        value="{{ old('txt_customer_address') }}">
                                    @error('txt_customer_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_product_name" name="cbo_product_name">
                                        <option value="">--Select product--</option>


                                    </select>
                                    @error('cbo_product_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_repair_qty" name="txt_repair_qty"
                                        placeholder="Repair Qty" value="{{ old('txt_repair_qty') }}">
                                    @error('txt_repair_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_repair_date" name="txt_repair_date"
                                        placeholder="Repair Date" value="{{ old('txt_repair_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_repair_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_serial_no" name="txt_serial_no"
                                        placeholder="Serial No." value="{{ old('txt_serial_no') }}">
                                    @error('txt_serial_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_sold_date" name="txt_sold_date"
                                        placeholder="Sold Date" value="{{ old('txt_sold_date') }}"
                                        onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_sold_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_receive_date"
                                        name="txt_receive_date" placeholder="Receive Date"
                                        value="{{ old('txt_receive_date') }}" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_receive_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="cbo_mr_number" name="cbo_mr_number">
                                        <option value="">--MR Number--</option>
                                    </select>
                                    @error('cbo_mr_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="txt_remarks" name="txt_remarks"
                                        placeholder="Remarks" value="{{ old('txt_remarks') }}">
                                    @error('txt_remarks')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="row mb-2">
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Add Details</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sales.repair_invoice_not_final_list')
    &nbsp;
@endsection


@section('script')

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


    {{-- // --}}
    <script>
        window.onload = function() {
            $('#rr').hide();
        };

        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getCustomerList();
                getMRForRepair();
                callset();
                getFinishProduct();

            });
            $('select[name="cbo_customer_type_id"]').on('change', function() {
                getCustomerList();
            });

            $('select[name="cbo_customer"]').on('change', function() {
                getMRForRepair();
            });

            $('select[name="cbo_transformer_ctpt"]').on('change', function() {
                getFinishProduct();
            });

        });

        function callset() {
            $('#er_company').hide();
            var company_id = $('#cbo_company_id').val();

            if (company_id) {
                getrrlist(company_id);
            } else {
                $("#err_cbo_company_id").append("<div class='text-warning' id='er_company'>Select Company</div>");
            }
        } //end call set
    </script>

    <script type="text/javascript">
        function getCustomerList() {
            var cbo_customer_type_id = $('#cbo_customer_type_id').val();
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_customer_type_id && cbo_company_id) {

                $.ajax({
                    url: "{{ url('/get/sales_customer_id/') }}/" + cbo_customer_type_id + '/' +
                        cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var d = $('select[name="cbo_customer"]').empty();
                        $('select[name="cbo_customer"]').append(
                            '<option value="">--Select Customer--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_customer"]').append(
                                '<option value="' + value.customer_id + '">' +
                                value.customer_id + ' | ' + value
                                .customer_name + '</option>');
                        });
                    },
                });
            }
        }
    </script>


    <script>
        function getFinishProduct() {
            var cbo_company_id = $('#cbo_company_id').val();
            var pg_id = $('#cbo_transformer_ctpt').val();
            if (pg_id && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get_sales_repeair_product') }}/" + pg_id + '/' + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_product_name"]').empty();
                        $('select[name="cbo_product_name"]').append(
                            '<option value="">--Product Name--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_product_name"]').append(
                                '<option value="' + value.product_id + '">' +
                                value.product_name + (value.model_size ? value.model_size : "") + (
                                    value.product_description ? value.product_description : "") +
                                '</option>');
                        });
                    }
                });

            } else {
                $('#cbo_product_name').empty();
            }
        }
    </script>

    <script type="text/javascript">
        // customer address
        $(document).ready(function() {
            $('select[name="cbo_customer"]').on('change', function() {
                var cbo_customer = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_customer && cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get_customer_address_for_repair_invoice') }}/" +
                            cbo_customer+'/'+cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_customer_address').empty();
                            $('#txt_customer_address').val(data);
                        },
                    });

                } else {
                    $('#txt_customer_address').empty();
                }

            });
        });
    </script>
    <script type="text/javascript">
        // MR Number list
        function getMRForRepair() {
            var cbo_customer = $('#cbo_customer').val();
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_customer && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get_money_receipt_for_repair_invoice') }}/" +
                        cbo_customer + '/' + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('select[name="cbo_mr_number"]').empty();
                        $('select[name="cbo_mr_number"]').append(
                            '<option value="">--MR Number--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_mr_number"]').append(
                                '<option value="' + value.mr_id + '">' +
                                value.mr_id + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_mr_number"]').empty();
            }
        }
    </script>




    <script>
        function getrrlist(company_id) {
            $('#rr').show();
            // $('#loader').show();
            var k = 1;
            $.ajax({
                url: "{{ url('/get/sales/repair_invoice_not_final') }}/" + company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (data) {
                        // $('#loader').hide();
                        if ($.fn.DataTable.isDataTable("#sales_dch_list")) {
                            $('#sales_dch_list').DataTable().clear().destroy();
                        }
                    }
                    $('#sales_dch_list').dataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
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
                                    return k++;
                                }
                            },
                            {
                                "data": "reinvm_id"
                            },
                            {
                                "data": "repair_date"
                            },
                            {
                                "data": "employee_name"
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return '<a target="_blank" href="{{ url('/') }}/sales/repair_invoice_details/' +
                                        data.reinvm_id + '/' + data.company_id +
                                        '">Next</a>';
                                }
                            },
                        ], // end colume
                    }); // end dataTable
                }, // End Sucess
            }); // end Ajax
        } // end document
    </script>
@endsection

@section('CSS')
    <style>
        #sales_dch_list_filter {
            width: 100px;
            float: right;
            margin: 5px 130px 0 0;
        }
    </style>
@endsection
