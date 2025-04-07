@extends('layouts.inventory_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Closing Stock Qty</h1>
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

                                <div class="col-4">
                                    <p>Company</p>
                                </div>
                                <div class="col-4">
                                    <p>Project</p>
                                </div>
                                <div class="col-4">
                                    <p>Product Group</p>
                                </div>

                            </div>
                            <div class="row mb-1">

                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_company_id" name="txt_company_id"
                                        readonly value="{{ $ci_company->company_name }}">
                                    @error('txt_company_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_project_id" name="txt_project_id"
                                        readonly value="{{ $ci_project->project_name }}">
                                    @error('txt_project_id')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_pg_id" name="txt_pg_id"
                                        readonly value="{{ $ci_product_group->pg_name }}">
                                    @error('txt_pg_id')
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
                            <div class="col-1">
                                <p>SL</p>
                            </div>
                            <div class="col-2">
                                <p>PGID | PRO ID</p>
                            </div>
                            <div class="col-4">
                                <p>Product Name</p>
                            </div>
                            <div class="col-2">
                                <p>Unit</p>
                            </div>
                            <div class="col-2">
                                <p>Stock Qty</p>
                            </div>
                            <div class="col-1">
                                <p>Action</p>
                            </div>
                        </div>
                            @foreach ($ci_stock_closing as $key => $row_stock_closing)
                                <form id="myForm{{$key}}" action="{{ route('ClosingStockQtyUpdate_02') }}" method="post"> 
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-1">
                                        <input type="hidden" class="form-control" id="txt_table" name="txt_table" readonly value="{{ $m_stock_closing }}">

                                        <input type="hidden" class="form-control" id="txt_stock_closing_id" name="txt_stock_closing_id" readonly value="{{ $row_stock_closing->stock_closing_id }}">

                                        <input type="text" class="form-control" id="txt_aa" name="txt_aa"
                                            readonly value="{{ $key+1 }}">
                                        @error('txt_aa')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_product_id" name="txt_product_id"
                                            readonly value="{{ $row_stock_closing->pg_id }} | {{ $row_stock_closing->product_id }}">
                                        @error('txt_product_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="txt_product_name" name="txt_product_name"
                                            readonly value="{{ $row_stock_closing->product_name }}">
                                        @error('txt_product_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_unit_name" name="txt_unit_name"
                                            readonly value="{{ $row_stock_closing->unit_name }}">
                                        @error('txt_unit_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_qty" name="txt_qty"
                                            value="{{ $row_stock_closing->qty }}">
                                        @error('txt_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-1 d-flex flex-row">
                                        <input type="checkbox" id="AYC" onclick='BTON("{{ $key }}")'
                                            name="AYC" class="mr-2">
                                        <button type="submit" id="confirm_action{{ $key }}"
                                            onclick='BTOFF("{{ $key }}")' class="btn btn-primary mb-2"
                                            disabled>ok</button>
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
    <script>
        function BTON(key) {
            var btname = `confirm_action${key}`;
            if ($(`#${btname}`).prop('disabled')) {
                $(`#${btname}`).prop("disabled", false);
            } else {
                $(`#${btname}`).prop("disabled", true);
            }
        }

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