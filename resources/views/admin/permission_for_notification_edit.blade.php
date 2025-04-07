@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notification Rules </h1>
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
                        <form
                            action="{{ route('permission_for_notification_update', $m_fund_req_check->fund_req_check_id) }}"
                            method="Post">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="0">--Company--</option>
                                        @foreach ($user_company as $company)
                                            <option value="{{ $company->company_id }}"
                                                {{ $company->company_id == $m_fund_req_check->company_id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_first_check" id="cbo_first_check" class="form-control">
                                        <option value="0">--First Check--</option>

                                    </select>
                                    @error('cbo_first_check')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_second_check" id="cbo_second_check" class="form-control">
                                        <option value="0">--Second Check--</option>

                                    </select>
                                    @error('cbo_second_check')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                                    <select name="cbo_final_check" id="cbo_final_check" class="form-control">
                                        <option value="0">--Final Check--</option>

                                    </select>
                                    @error('cbo_final_check')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-10 col-md-12 col-sm-12 mb-2">
                                    &nbsp;
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 mb-2">
                                    <button type="Submit" class="btn btn-primary btn-block">Update</button>
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
    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
    {{-- //divison to District Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            //initial get employee
            getEmployee();
            //onchange get employee
            $('#cbo_company_id').on('change', function() {
                getEmployee();
            });
        });
    </script>

    <script>
        function getEmployee() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {

                $.ajax({
                    url: "{{ url('/get/permission_for_notification/employee_info/') }}/" +
                        cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        //cbo_first_check
                        var employee_id_01 = "{{ $m_fund_req_check->employee_id_01 }}";
                        $('select[name="cbo_first_check"]').empty();
                        $('select[name="cbo_first_check"]').append(
                            '<option value="">--First Check--</option>');
                        $.each(data, function(key, value) {
                            if (value.employee_id == employee_id_01) {
                                $('select[name="cbo_first_check"]').append(
                                    '<option value="' + value.employee_id + '" selected > ' +
                                    value.employee_id + "|" +
                                    value.employee_name + '</option>');
                            } else {
                                $('select[name="cbo_first_check"]').append(
                                    '<option value="' + value.employee_id + '" > ' +
                                    value.employee_id + "|" +
                                    value.employee_name + '</option>');
                            }

                        });
                        //cbo_second_check
                        var employee_id_02 = "{{ $m_fund_req_check->employee_id_02 }}";
                        $('select[name="cbo_second_check"]').empty();
                        $('select[name="cbo_second_check"]').append(
                            '<option value="">--Second Check--</option>');
                        $.each(data, function(key, value) {
                            if (value.employee_id == employee_id_02) {
                                $('select[name="cbo_second_check"]').append(
                                    '<option value="' + value.employee_id + '" selected > ' +
                                    value.employee_id + "|" +
                                    value.employee_name + '</option>');
                            } else {
                                $('select[name="cbo_second_check"]').append(
                                    '<option value="' + value.employee_id + '" > ' +
                                    value.employee_id + "|" +
                                    value.employee_name + '</option>');
                            }
                        });
                        //cbo_final_check
                        var employee_id_03 = "{{ $m_fund_req_check->employee_id_03 }}";
                        $('select[name="cbo_final_check"]').empty();
                        $('select[name="cbo_final_check"]').append(
                            '<option value="">--Final Check--</option>');
                        $.each(data, function(key, value) {
                            if (value.employee_id == employee_id_02) {
                                $('select[name="cbo_final_check"]').append(
                                    '<option value="' + value.employee_id + '" selected > ' +
                                    value.employee_id + "|" +
                                    value.employee_name + '</option>');

                            } else {
                                $('select[name="cbo_final_check"]').append(
                                    '<option value="' + value.employee_id + '" > ' +
                                    value.employee_id + "|" +
                                    value.employee_name + '</option>');
                            }
                        });
                    },
                });

            }
        }
    </script>
@endsection
