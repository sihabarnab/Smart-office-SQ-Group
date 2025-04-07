@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Gate Pass </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="container-fluid" id='rr'>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="delivary_challan_list" class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width='6%'>SL No</th>
                                    <th>Delivery challan No.</th>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Delivery Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($d_challan as $key => $row)
                                <form id="myForm{{$key}}" action="{{route('gate_pass_store',[$row->delivery_chalan_master_id,$row->company_id])}}" method="POST">
                                    @csrf
                                    <tr>
                                        <td><input type="text" value="{{ $key + 1 }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $row->delivery_chalan_master_id }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $row->sim_id }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $row->customer_name }}" class="form-control" readonly></td>
                                        <td><input type="text" value="{{ $row->delivery_address }}" class="form-control" readonly></td>
                                        <td>
                                            <input type="text" class="form-control" id="txt_gate_pass_date" name="txt_gate_pass_date"
                                            placeholder="Gate Pass Date" value="{{ old('txt_gate_pass_date') }}" onfocus="(this.type='date')"
                                            onblur="if(this.value==''){this.type='text'}">
                                        @error('txt_gate_pass_date')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                        </td>
                                        <td class="d-flex flex-row">
                                            <input type="checkbox" id="AYC" onclick='BTON("{{$key}}")' name="AYC" class="mr-2">
                                             <button type="Submit"  id="confirm_action{{$key}}" onclick='BTOFF("{{$key}}")'  class="btn btn-primary btn-block" disabled>Create</button>
                                        </td>
                                    </tr>
                                </form>
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