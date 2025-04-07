@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Material Price</h1>
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
                        <form action="" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-3">
                                    <p>Project</p>
                                </div>
                                <div class="col-3">
                                    <p>Indent No.</p>
                                </div>
                                <div class="col-2">
                                    <p>Indent Date</p>
                                </div>
                                <div class="col-2">
                                    <p>RR No.</p>
                                </div>
                                <div class="col-2">
                                    <p>RR Date</p>
                                </div>

                            </div>
                            <div class="row mb-1">

                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_Project_id" name="txt_Project_id"
                                        readonly value="{{ $pro_indent_master->project_name }}">
                                    @error('txt_Project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_Indent_no" name="txt_Indent_no"
                                        readonly value="{{ $pro_indent_master->indent_no }}">
                                    @error('txt_Indent_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_indent_date" name="txt_indent_date"
                                        readonly value="{{ $pro_indent_master->indent_date }}">
                                    @error('txt_indent_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_rr_no" name="txt_rr_no" readonly
                                        value="{{ $pro_indent_master->grr_no }}">
                                    @error('txt_rr_no')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_rr_date" name="txt_rr_date" readonly
                                        value="{{ $pro_indent_master->grr_date }}">
                                    @error('txt_rr_date')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-1">

                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_customer_id" name="txt_customer_id"
                                        readonly value="{{ $pro_indent_master->supplier_name }}.">
                                    @error('txt_customer_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_customer_address"
                                        name="txt_customer_address" readonly
                                        value="{{ $pro_indent_master->supplier_address }}">
                                    @error('txt_customer_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
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
                        <div class="row">
                            <div class="col-4">
                                <p>Product Name</p>
                            </div>
                            <div class="col-1">
                                <p>Unit</p>
                            </div>

                            <div class="col-2">
                                <p>RR Qty</p>
                            </div>
                            <div class="col-2">
                                <p>Rate</p>
                            </div>
                            <div class="col-2">
                                <p>Total</p>
                            </div>
                            <div class="col-1">
                            </div>
                        </div>
                            @foreach ($pro_grr_details as $key=>$pro_grr_detail)
                            <form id="myForm{{$key}}" action="{{ route('material_price_update',[$pro_grr_detail->grr_details_id,$pro_grr_detail->company_id]) }}" method="post">
                            @csrf

                            <input type="hidden" class="form-control" id="txt_grr_no" name="txt_grr_no"
                            readonly value="{{ $pro_grr_detail->grr_no }}">

                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_project_name" name="txt_project_name"
                                        readonly value="{{ $pro_grr_detail->product_name }}">
                                    @error('txt_project_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-1">
                                    <input type="text" class="form-control" id="txt_unit" name="txt_unit" readonly
                                        value="{{ $pro_grr_detail->unit_name }}">
                                    @error('txt_unit')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_rr_qty" name="txt_rr_qty"
                                        readonly value="{{ $pro_grr_detail->received_qty }}">
                                    @error('txt_rr_qty')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_rate" name="txt_rate" >
                                    @error('txt_rate')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control" id="txt_total" name="txt_total" readonly >
                                    @error('txt_total')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-1 d-flex flex-row">
                                    <input type="checkbox" id="AYC" onclick='BTON("{{$key}}")' name="AYC" class="mr-2">
                                    <button type="Submit" id="confirm_action{{$key}}" onclick='BTOFF("{{$key}}")' class="btn btn-primary btn-block m-2" disabled>OK</button>
                                </div>
                            </div>
                            
                            </form>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#txt_rate').on('change', function() {
        var txt_rr_qty = document.getElementById("txt_rr_qty").value;
        var txt_rate = document.getElementById("txt_rate").value;
        document.getElementById("txt_total").value = txt_rr_qty*txt_rate;
     });
    });
</script>
<script>
    function BTON(key) {
        var btname = `confirm_action${key}`;
        if ($(`#${btname}`).prop('disabled')) {
            $(`#${btname}`).prop("disabled", false);
        } else {
            $(`#${btname}`).prop("disabled", true);
        }
    }
</script>

<script>
      function BTOFF(key) {
        var btname = `confirm_action${key}`;
        if ($(`#${btname}`).prop('disabled')) {
            $(`#${btname}`).prop("disabled", true);
        } else {
            $(`#${btname}`).prop("disabled", true);
        }
            document.getElementById(`myForm${key}`).submit(); 
            
        }
</script>
@endsection
