@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION</h1>
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
                        <form id="myForm" action="{{ route('quotation_store') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-3">
                                    <select class="form-control" id="cbo_company_id" name="cbo_company_id">
                                        <option value="0">-Select Company-</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}">{{ $value->company_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                    <p id="err_company_mass" style="display: none; color:yellow;">Select Company</p>
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_date" name="txt_date"
                                        value="{{ old('txt_date') }}" placeholder="Date" onfocus="(this.type='date')"
                                        onblur="if(this.value==''){this.type='text'}">
                                    @error('txt_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_customer_name"
                                        onkeyup="getCustomer()" onchange="GetCustomerDetails()" list="list_customer"
                                        name="txt_customer_name" value="{{ old('txt_customer_name') }}"
                                        placeholder="Customer Name">
                                    <datalist id="list_customer">
                                    </datalist>
                                    @error('txt_customer_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_address" name="txt_address"
                                        value="{{ old('txt_address') }}" placeholder="Address">
                                    @error('txt_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-1">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_mobile_number"
                                        name="txt_mobile_number" value="{{ old('txt_mobile_number') }}"
                                        placeholder="Mobile Number">
                                    @error('txt_mobile_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="email" class="form-control" id="txt_email" name="txt_email"
                                        value="{{ old('txt_email') }}" placeholder="Email">
                                    @error('txt_email')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_attention" name="txt_attention"
                                        value="{{ old('txt_attention') }}" placeholder="Attention">
                                    @error('txt_attention')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_valid_until" name="txt_valid_until"
                                        value="{{ old('txt_valid_until') }}" placeholder="Valid Until">
                                    @error('txt_valid_until')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_subject" name="txt_subject"
                                        value="{{ old('txt_subject') }}" placeholder="Subject">
                                    @error('txt_subject')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reference_name"
                                        name="txt_reference_name" value="{{ old('txt_reference_name') }}"
                                        placeholder="Reference Name">
                                    @error('txt_reference_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reference_number"
                                        name="txt_reference_number" value="{{ old('txt_reference_number') }}"
                                        placeholder="Reference Number">
                                    @error('txt_reference_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-10">
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                                <div class="col-2">
                                    <button type="Submit" id="confirm_action" onclick="BTOFF()"
                                        class="btn btn-primary btn-block" disabled>Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sales.quotation_not_final_list')
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
        function getCustomer() {
            let cbo_company_id = $('#cbo_company_id').val();
            let name = $('#txt_customer_name').val();
            let token = "{{ csrf_token() }}";
            if (cbo_company_id == 0) {
                $('#err_company_mass').show();
            } else if (name && cbo_company_id) {
                $('#err_company_mass').hide();

                $.ajax({
                    url: "{{ route('GetCustomerList') }}",
                    type: "get",
                    data: {
                        name: name,
                        cbo_company_id: cbo_company_id,
                        _token: token
                    },
                    success: function(data) {
                        $('#list_customer').empty();
                        $.each(data, function(key, value) {
                            $('#list_customer').append(
                                '<option value="' + value.customer_name + '">');
                        });

                    },
                });

            } else {
                $('#list_customer').empty();
            }
        }

        function GetCustomerDetails() {
            let name = $('#txt_customer_name').val();
            let cbo_company_id = $('#cbo_company_id').val();
            if (name && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/sales/quotation/customer_details/') }}/" + name+'/'+cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data != '0') {
                            $('#list_customer').empty();
                            $('#txt_address').val('');
                            $('#txt_email').val('');
                            $('#txt_mobile_number').val('');
                            $('#txt_attention').val('');
                            //
                            $('#txt_address').val(data.customer_address);
                            $('#txt_mobile_number').val(data.customer_phone);
                            $('#txt_email').val(data.customer_email);
                            $('#txt_attention').val(data.contact_person);
                        }


                    },
                });

            } else {
                $('#txt_address').val('');
                $('#txt_email').val('');
                $('#txt_mobile_number').val('');
                $('#txt_attention').val('');
            }
        }
    </script>
@endsection
