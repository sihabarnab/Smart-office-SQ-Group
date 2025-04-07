@extends('layouts.inventory_app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Material Stock</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
    @include('flash-message')
</div>


@php
$m_user_id = Auth::user()->emp_id;

$user_company = DB::table("pro_user_company")
->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
->select("pro_user_company.*", "pro_company.company_name")
->Where('pro_user_company.employee_id', $m_user_id)
->Where('pro_company.inventory_status', '1')
->get();
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class=""></div>
                    <!-- <form action="{{ route('RptAllStockList') }}" method="Post">
                            @csrf -->

                    <div class="row mb-2">
                        <div class="col-4">
                            <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                <option value="0">--Select Company--</option>
                                @foreach ($user_company as $value)
                                <option value="{{ $value->company_id }}">
                                    {{ $value->company_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('cbo_company_id')
                            <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div><!-- /.col -->
                        <div class="col-3">
                            <div class="input-group date" id="sedate3" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="txt_month_from"
                                    name="txt_month_from" placeholder="From Year Month"
                                    value="{{ old('txt_month_from') }}" data-target="#sedate3">
                                <div class="input-group-append" data-target="#sedate3" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @error('txt_month_from')
                            <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="input-group date" id="sedate4" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="txt_month_to"
                                    name="txt_month_to" placeholder="To Year Month"
                                    value="{{ old('txt_month_to') }}" data-target="#sedate4">
                                <div class="input-group-append" data-target="#sedate4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            @error('txt_month_to')
                            <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <button type="Submit" class="btn btn-primary btn-block"
                                onclick="getAllStock()">Submit</button>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="data102" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Product Group</th>
                                    <th>Sub Group</th>
                                    <th>Product</th>
                                    <th>Unit</th>
                                    <th>Opening</th>
                                    <th>Receive</th>
                                    <th>Issue</th>
                                    <th>Return</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody id="mybody">

                            </tbody>
                        </table>

                        <div id ='spl'>
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("select").select2();
        $("#spl").hide();

    });
</script>
<script>
    $('#sedate3').datetimepicker({
        format: 'YYYY-MM'
    });
</script>
<script>
    $('#sedate4').datetimepicker({
        format: 'YYYY-MM'
    });
</script>


<script>
    function getAllStock() {
        $("#spl").show();
        var k =1;
        var cbo_company_id = $('#cbo_company_id').val();
        var txt_month_from = $('#txt_month_from').val();
        var txt_month_to = $('#txt_month_to').val();
        // const jsdate = new Date(txt_month_from);
        // var closing_year = jsdate.getFullYear;
        // var closing_month = (jsdate.getMonth).toString().padStart(2, "0");

        if (cbo_company_id) {
            
            $.ajax({
                url: "{{ url('/get_inventory/all_product') }}/" + cbo_company_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, value) {
                        var x = k++;
                        var  product_id=value.product_id;
                        var txt_clossing_stock = stock_closing(product_id,cbo_company_id,txt_month_from);
                        var txt_rr_qty = grr_details(product_id,cbo_company_id,txt_month_from,txt_month_to);
                        var txt_issue_qty = graw_issue_details(product_id,cbo_company_id,txt_month_from,txt_month_to);
                        var txt_return_qty = gmaterial_return_details(product_id,cbo_company_id,txt_month_from,txt_month_to);
                        $txt1_bal_qty = $txt_clossing_stock + $txt_rr_qty + $txt_return_qty - $txt_issue_qty;
                       

                        $('#mybody').append(
                            '<tr>'+
                            '<td>'+x+'</td>'+
                            '<td>'+value.pg_name+'</td>'+
                            '<td>'+value.pg_sub_name+'</td>'+
                            '<td>'+value.product_name+'</td>'+
                            '<td>'+value.unit_name+'</td>'+
                            '<td>'+txt_clossing_stock+'</td>'+
                            '<td>'+txt_rr_qty+'</td>'+
                            '<td>'+txt_issue_qty+'</td>'+
                            '<td>'+txt1_bal_qty+'</td>'+
                            '</tr>'
                        
                        );

                    });

                    $("#spl").hide();
                    var table = $('#data102').DataTable();
                },
            });
        }

    }
</script>

<script>
    function stock_closing(product_id,cbo_company_id,txt_month_from){
        var closing_result = 0;
        if(product_id){
            $.ajax({
                url: "{{ url('/get_inventory/closing_stock') }}/" + product_id+'/'+cbo_company_id+'/'+txt_month_from,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var closing_result = data;
                },
            });

            return closing_result;

        }
        else{
            return 0.0000;
        }
    }
    function grr_details(product_id,cbo_company_id,txt_month_from,txt_month_to){
        var grr_details_result = 0;
        if(product_id){
            $.ajax({
                url: "{{ url('/get_inventory/grr_details') }}/" + product_id+'/'+cbo_company_id+'/'+txt_month_from+'/'+txt_month_to,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var grr_details_result = data;
                },
            });

            return grr_details_result;

        }
        else{
            return grr_details_result;
        }
    }
    function graw_issue_details(product_id,cbo_company_id,txt_month_from,txt_month_to){
        var graw_issue_details_result = 0;
        if(product_id){
            $.ajax({
                url: "{{ url('/get_inventory/graw_issue_details') }}/" + product_id+'/'+cbo_company_id+'/'+txt_month_from+'/'+txt_month_to,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var graw_issue_details_result = data;
                },
            });

            return graw_issue_details_result;

        }
        else{
            return graw_issue_details_result;
        }
    }

    function gmaterial_return_details(product_id,cbo_company_id,txt_month_from,txt_month_to){
        var gmaterial_return_details_result = 0;
        if(product_id){
            $.ajax({
                url: "{{ url('/get_inventory/gmaterial_return_details') }}/" + product_id+'/'+cbo_company_id+'/'+txt_month_from+'/'+txt_month_to,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var gmaterial_return_details_result = data;
                },
            });

            return gmaterial_return_details_result;

        }
        else{
            return gmaterial_return_details_result;
        }
    }
</script>
@endsection