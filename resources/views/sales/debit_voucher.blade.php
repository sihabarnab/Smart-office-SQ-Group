@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Debit Voucher</h1>
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
                        <form id="myForm" action="{{ route('debit_voucher_store') }}" method="GET">
                            @csrf

                            <div class="row mb-2">
                                <div class="col-4">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}"
                                                {{ old('cbo_company_id') == $value->company_id ? 'selected' : '' }}>
                                                {{ $value->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id='err_cbo_company_id'></div>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_ac_name" name="txt_ac_name"
                                        placeholder="Accounts Name" value="Commission on Sales">
                                    @error('txt_ac_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_name" name="txt_name"
                                        placeholder="Name" value="{{ old('txt_name') }}">
                                    @error('txt_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_details" name="txt_details"
                                        placeholder="Details" value="{{ old('txt_details') }}">
                                    @error('txt_details')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_amount" name="txt_amount"
                                        placeholder="Amount" value="{{ old('txt_amount') }}">
                                    @error('txt_amount')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_transport" name="txt_transport"
                                        placeholder="Transport" value="{{ old('txt_transport') }}">
                                    @error('txt_transport')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="number" class="form-control" id="txt_carry_allowance"
                                        name="txt_carry_allowance" placeholder="Carrying Allowance"
                                        value="{{ old('txt_carry_allowance') }}">
                                    @error('txt_carry_allowance')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_date" name="txt_date"
                                        value="{{ old('txt_date') }}" placeholder="Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select class="form-control" name="cbo_mr_number" id="cbo_mr_number">
                                        <option value="">-Select Money Receipt-</option>
                                    </select>
                                    @error('cbo_mr_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_cash_book_no" name="txt_cash_book_no"
                                        placeholder="Cash Book Number" value="{{ old('txt_cash_book_no') }}">
                                    @error('txt_cash_book_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_page_no" name="txt_page_no"
                                        placeholder="Page No" value="{{ old('txt_page_no') }}">
                                    @error('txt_page_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_folio_no" name="txt_folio_no"
                                        placeholder="Folio No" value="{{ old('txt_folio_no') }}">
                                    @error('txt_folio_no')
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
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('sales.debit_voucher_list')
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

    <script>
        window.onload = function() {
            $('#rr').hide();
        };
    </script>
    {{-- // --}}
    <script>
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getMRForDebitVoucher();
                callset();

            });

            function callset() {
                $('#er_company').hide();
                var company_id = $('#cbo_company_id').val();

                if (company_id) {
                    getrrlist(company_id);
                } else {
                    $("#err_cbo_company_id").append(
                        "<div class='text-warning' id='er_company'>Select Company</div>");
                }
            } //end call set

        });
    </script>

    <script type="text/javascript">
        // MR Number list
        function getMRForDebitVoucher() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('get/sales/money_receipt_for_debit_voucher') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // console.log(data);
                        $('select[name="cbo_mr_number"]').empty();
                        $('select[name="cbo_mr_number"]').append(
                            '<option value="">--Money Receipt--</option>');
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
                url: "{{ url('/get/sales/debit_voucher_list') }}/" + company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // console.log(data);
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
                                data: null,
                                render: function(data, type, full) {
                                    return data.debit_voucher_id + "<br>" + data
                                        .debit_voucher_date;
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, full) {
                                    return data.mr_id + "<br>" + data.mr_date;
                                }
                            },
                            {
                                "data": "accounts_name"
                            },
                            {
                                "data": "name"
                            },
                            {
                                "data": "details"
                            },
                            {
                                "data": "amount"
                            },
                            {
                                "data": "tr_amount"
                            },
                            {
                                "data": "cr_amount"
                            }
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
