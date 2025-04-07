@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Remaining Serial Number List</h1>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @php
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();
    @endphp

    <div class="content-header">


            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm" action="{{ route('remaing_serial_list') }}" method="GET">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-3">
                                    <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                        <option value="">--Select Company--</option>
                                        @foreach ($user_company as $value)
                                            <option value="{{ $value->company_id }}" {{$company_id == $value->company_id?"selected":""}}>
                                                {{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cbo_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div><!-- /.col -->
    
                                <div class="col-3">
                                    <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                        <option value="">--Product Group--</option>
                                        <option value="28" {{ $pg_id == '28' ? 'selected' : '' }}>
                                            TRANSFORMER</option>
                                        <option value="33" {{ $pg_id == '33' ? 'selected' : '' }}>CTPT
                                        </option>
                                    </select>
                                    @error('cbo_transformer')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <select name="cbo_product_id" id="cbo_product_id" class="form-control">
                                        <option value="">--Select Product--</option>
                                    </select>
                                    @error('cbo_product_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div><!-- /.col -->
                                <div class="col-2">
                                    <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Submit</button>
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                            </div><!-- /.row -->
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
    

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <table id="data1" class="table table-border table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Product Group</th>
                                        <th>Product Name</th>
                                        <th>Serial Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($remaining_product_serial as $key=>$row)
                                     <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                           @if ($row->pg_id == 28)
                                               {{'Transformer'}}
                                           @elseif($row->pg_id == 33)
                                               {{'CTPT'}}
                                           @endif
                                        </td>
                                        <td>{{$row->product_name}}</td>
                                        <td>{{$row->serial_no}}</td>
                                     </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
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

    <script type="text/javascript">
        $(document).ready(function() {
            var cbo_transformer = $('select[name="cbo_transformer"]').val();
            var cbo_company_id = $('select[name="cbo_company_id"]').val();
            if (cbo_transformer && cbo_company_id) {
                GetProduct();
            }

            $('select[name="cbo_transformer"]').on('change', function() {
                GetProduct();
            });

            function GetProduct() {
                var cbo_transformer = $('select[name="cbo_transformer"]').val();
                var cbo_company_id = $('select[name="cbo_company_id"]').val();
                if (cbo_transformer && cbo_company_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/cbo_transformer_ctpt/') }}/" +
                            cbo_transformer+'/'+cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product_id"]').empty();
                            $('select[name="cbo_product_id"]').append(
                                '<option value="">-Select Product-</option>');
                            $.each(data, function(key, value) {
                                var product_id = "{{$product_id}}"
                                if(product_id ==  value.product_id ){
                                    $('select[name="cbo_product_id"]').append(
                                    '<option selected value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                                }else{
                                    $('select[name="cbo_product_id"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                                }
                              
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product_id"]').empty();
                }
            }
        });
    </script>
@endsection