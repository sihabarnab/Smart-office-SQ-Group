@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Sales Requisition Approval </h1>
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


                        <div class="row mb-1">
                            <div class="col-4">
                                <input type="text" class="form-control" value="{{ $req_master->requisition_master_id }}"
                                    readonly>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="{{ $req_master->requisition_date }}"
                                    readonly>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" value="{{ $req_master->last_balance }}"
                                    placeholder="Opening Balance" readonly>
                            </div>

                        </div>

                        <div class="row mb-1">
                            <div class="col-4">
                                <input type="text" class="form-control" value="{{ $customer->customer_name }}" readonly>
                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control" value="{{ $customer->customer_address }}" placeholder="Address"
                                    readonly>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" value="{{ $customer->customer_phone }}" placeholder="Mobile" readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $net_total = 0;

    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="quotation_list" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Commision</th>
                                    <th>Carring</th>
                                    <th>Extended</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($req_details as $key => $row)
                                    @php
                                        $net_total = $net_total + $row->net_total;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $row->product_description }}</td>
                                        <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->rate, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->comm_rate, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->transport_rate, 2) }}</td>
                                        <td class="text-right">{{ number_format($row->net_total, 2) }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-right">Total:</td>
                                    <td class="text-right">{{ number_format($net_total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="row">
                            <div class="col-10 text-right">
                                Opening Balance:
                            </div>
                            <div class="col-2 text-right">
                                {{ number_format($req_master->last_balance, 2) }}
                                <hr class="m-0" style="border-top: 2px solid #fff;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10 text-right">
                                Grand Total:
                            </div>
                            <div class="col-2 text-right">
                                @php
                                    $grand_total = $net_total + $req_master->last_balance;
                                @endphp
                                {{ number_format($grand_total, 2) }}
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-10 text-right">
                                Committed Deposit Amount:
                            </div>
                            <div class="col-2 text-right">
                                {{ number_format($req_master->deposit_amount, 2) }}
                                <hr class="m-0" style="border-top: 2px double #fff;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-10 text-right">
                                Net Balance:
                            </div>
                            <div class="col-2 text-right">
                                @php
                                    $net_balance = $grand_total - $req_master->deposit_amount;
                                @endphp
                                {{ number_format($net_balance, 2) }}
                            </div>
                        </div>



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

                        <form id="myForm"
                            action="{{ route('requisition_approved_confirm', [$req_master->requisition_master_id, $req_master->company_id]) }}"
                            method="post">
                            @csrf
                            <div class="row mb-1">

                                <div class="col-6">
                                    <input type="text" class="form-control" name="txt_comment" id="txt_comment"
                                        placeholder="Comments">
                                    @error('txt_comment')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-2">
                                    <select class="form-control" id="cbo_approved_status" name="cbo_approved_status">
                                        <option value="">--Approved--</option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                    @error('cbo_approved_status')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                                  <div class="col-2">
                                    <input type="text" class="form-control" value="{{ $req_master->employee_name }}" readonly>
                                </div>

                                <div class="col-2">
                                    <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Submit</button>
                                    <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                    <label for="AYC">Are you Confirm</label>
                                </div>
                            </div>
                        </form>

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
            }else{
                $("#confirm_action").prop("disabled", true);  
            }
            document.getElementById("myForm").submit(); 
            
        }
    </script>
@endsection
