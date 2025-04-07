@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Closing Stock List For Update</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="myForm" action="{{ route('ClosingStockQtyUpdate_01') }}" method="get">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="0">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}">
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-3">
                                <select name="cbo_project_id" id="cbo_project_id" class="form-control">
                                    <option value="0">--Select Project--</option>
                                    @foreach ($pro_project_name as $row_project_name)
                                        <option value="{{ $row_project_name->project_id }}">
                                            {{ $row_project_name->project_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_project_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-3">
                                <select name="cbo_pg_id" id="cbo_pg_id" class="form-control">
                                    <option value="0">--Select Product Group--</option>
                                </select>
                                @error('cbo_pg_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <div class="input-group date" id="sedate3" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="txt_month"
                                        name="txt_month" placeholder="Year Month" value="{{ old('txt_month') }}"
                                        data-target="#sedate3">
                                    <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                @error('txt_month')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- /.col -->
                        </div><!-- /.row -->
                        <div class="row mb-2">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                    disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                getproductgroup();
            });
        });
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

    <script>
        function getproductgroup() {
            var cbo_company_id = $('#cbo_company_id').val();
            if (cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/product_group/company/') }}/" + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_pg_id"]').empty();
                        $('select[name="cbo_pg_id"]').append(
                            '<option value="0">--Select Product Group--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_pg_id"]').append(
                                '<option value="' + value.pg_id + '">' +
                                value.pg_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_pg_id"]').empty();
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
    <script>
        $('#sedate3').datetimepicker({
            format: 'YYYY-MM'
        });
    </script>
@endsection
