@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Finished Product Stock Details</h1>
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
                    <form id="myForm" action="{{ route('rpt_finish_product_stock_view') }}" method="POST">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}" {{ $value->company_id ==  old('cbo_company_id') ? 'selected':''}}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div><!-- /.col -->
                            <div class="col-3">
                                <select class="form-control" id="cbo_pg_id" name="cbo_pg_id">
                                    <option value="">--Product Group--</option>
                                    <option value="28" {{ "28" ==  old('cbo_pg_id') ? 'selected':''}}>TRANSFORMER</option>
                                    <option value="33" {{ "33" ==  old('cbo_pg_id') ? 'selected':''}} >CTPT</option>
                                </select>
                                @error('cbo_pg_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="cbo_pg_sub_id" name="cbo_pg_sub_id">
                                    <option value="">--Product Sub Group--</option>
                                </select>
                                @error('cbo_pg_sub_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="cbo_product_id" name="cbo_product_id">
                                    <option value="">--Product--</option>
                                </select>
                                @error('cbo_product_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                   
                       
                        </div><!-- /.row -->
                        <div class="row">                      
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ old('txt_from_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ old('txt_to_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block"
                                disabled>Search</button>
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                        </div><!-- /.row -->

                       
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

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

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_pg_id"]').on('change', function() {
                var cbo_pg_id = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_pg_id && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/inventory/fpsd_sub_group/') }}/" +
                        cbo_pg_id+'/'+cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_pg_sub_id"]').empty();
                            $('select[name="cbo_pg_sub_id"]').append(
                                '<option value="">--Product Sub Group--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_pg_sub_id"]').append(
                                    '<option value="' + value.pg_sub_id + '">' + value.pg_sub_id + '|'+
                                    value.pg_sub_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_pg_sub_id"]').empty();
                }

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_pg_sub_id"]').on('change', function() {
                var cbo_pg_sub_id = $(this).val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_pg_sub_id && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/inventory/fpsd_product/') }}/" +
                        cbo_pg_sub_id+'/'+cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product_id"]').empty();
                            $('select[name="cbo_product_id"]').append(
                                '<option value="">-Product-</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_product_id"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_id"]').empty();
                }

            });
        });
    </script>
@endsection
@endsection
