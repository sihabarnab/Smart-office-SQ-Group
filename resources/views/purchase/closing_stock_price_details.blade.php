@extends('layouts.purchase_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Closing Stock Price</h1>
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
                        <div class="row">
                            <div class="col-2">
                                <p>Project</p>
                            </div>
                            <div class="col-2">
                                <p>Product Group</p>
                            </div>
                            <div class="col-2">
                                <p>Product Sub Group</p>
                            </div>
                            <div class="col-2">
                                <p>Product Name</p>
                            </div>
                            <div class="col-1">
                                <p>Unit</p>
                            </div>
                            <div class="col-1">
                                <p>Quantity</p>
                            </div>
                            <div class="col-1">
                                <p>Rate</p>
                            </div>
                            <div class="col-1">
                            </div>

                        </div>
                        @foreach ($m_stock_closing as $key => $m_stock_closing_update)
                            <form id="myForm{{ $key }}"
                                action="{{ route('closing_stock_price_details_update', [$m_stock_closing_update->stock_closing_id, $m_stock_closing_update->company_id]) }}"
                                method="post">
                                @csrf
                                <div class="row mb-1">

                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_project_id" name="txt_project_id"
                                            readonly value="{{ $m_stock_closing_update->project_name }}">
                                        @error('txt_project_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_pg_id" name="txt_pg_id" readonly
                                            value="{{ $m_stock_closing_update->pg_name }}">
                                        @error('txt_pg_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        @if (isset($m_stock_closing_update->pg_sub_name))
                                            <input type="text" class="form-control" id="txt_pg_sub_id"
                                                name="txt_pg_sub_id" readonly
                                                value="{{ $m_stock_closing_update->pg_sub_name }}">
                                        @else
                                            <input type="text" class="form-control" id="txt_pg_sub_id"
                                                name="txt_pg_sub_id" readonly value="">
                                        @endif
                                        @error('txt_pg_sub_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" id="txt_product_name"
                                            name="txt_product_name" readonly
                                            value="{{ $m_stock_closing_update->product_name }}">
                                        @error('txt_product_name')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        @php
                                            $unit = DB::table('pro_units')
                                                ->where('unit_id', $m_stock_closing_update->product_unit)
                                                ->first();
                                        @endphp
                                        @if (isset($unit))
                                            <input type="text" class="form-control" id="txt_unit" name="txt_unit"
                                                readonly value="{{ $unit->unit_name }}">
                                        @else
                                            <input type="text" class="form-control" id="txt_unit" name="txt_unit"
                                                readonly readonly>
                                        @endif
                                        @error('txt_unit')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control" id="txt_qty" name="txt_qty" readonly
                                            value="{{ $m_stock_closing_update->qty }}">
                                        @error('txt_qty')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1">
                                        <input type="text" class="form-control" id="txt_product_rate"
                                            name="txt_product_rate">
                                        @error('txt_rate')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-1 d-flex flex-row">
                                        <input type="checkbox" id="AYC" onclick='BTON("{{ $key }}")'
                                            name="AYC" class="mr-2">
                                        <button type="Submit" id="confirm_action{{ $key }}"
                                            onclick='BTOFF("{{ $key }}")' class="btn btn-primary btn-block"
                                            disabled>OK</button>
                                    </div>

                                </div>
                            </form>
                        @endforeach
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
                        <table id="data1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Project</th>
                                    <th>Product Group</th>
                                    <th>Product Sub Group</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_stock_closing as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->project_name }}</td>
                                        <td>{{ $row->pg_name }}</td>
                                        <td>
                                            @isset($row->pg_sub_name)
                                                {{ $row->pg_sub_name }}
                                            @endisset
                                        </td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $row->qty }}</td>
                                        <td>{{ $row->product_rate }}</td>
                                        <td>{{ $row->received_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
