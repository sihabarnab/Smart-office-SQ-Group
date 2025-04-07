@extends('layouts.sales_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Total Collection Report</h1>
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
                    <form  id="myForm" action="{{ route('rpt_total_collection_list') }}" method="GET">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control" required>
                                    <option value="">--Select Company--</option>
                                    @foreach ($user_company as $value)
                                        <option value="{{ $value->company_id }}"
                                            {{ $value->company_id == $company_id ? 'selected' : '' }}>
                                            {{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror

                            </div><!-- /.col -->
                            <div class="col-2">
                                <input type="date" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ $form }}">
                                <div id='err_txt_form_date'>
                                </div>
                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="date" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ $to }}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{  $m_transformer == '28'? 'selected':''}}>TRANSFORMER</option>
                                    <option value="33" {{  $m_transformer == '33'? 'selected':''}}>CTPT</option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-2">
                                <select name="cbo_payment_type" id="cbo_payment_type" class="form-control">
                                    <option value="">-Payment Type-</option>
                                    @foreach ($m_payment_type as $value)
                                        <option value="{{ $value->payment_type_id }}" {{$m_payment_type_id ==  $value->payment_type_id ? 'selected':''}}>
                                            {{ $value->payment_type }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_payment_type')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror

                            </div><!-- /.col -->

                        </div><!-- /.row -->
                        <div class="row mb-2">
                            <div class="col-10">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <label for="AYC">Are you Confirm</label>
                            </div>
                            <div class="col-2">
                                <button id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block" disabled>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @php
        $net_cash = 0;
        $total_net_cash = 0;
        $total_mr_amount = 0;
        $total_discount = 0;
        $total_cr_amount = 0;
        $total_transport_fee = 0;
        $total_test_fee = 0;
        $total_other_fee = 0;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table  class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">MR No. <br> Date</th>
                                    <th class="text-left align-top">Customer Name</th>
                                    <th class="text-left align-top">Payment Type</th>
                                    <th class="text-left align-top">Bank</th>
                                    <th class="text-left align-top">Mushok</th>
                                    <th class="text-left align-top">MR Amount</th>
                                    <th class="text-left align-top">Discount</th>
                                    <th class="text-left align-top">Carrying Allowance</th>
                                    <th class="text-left align-top">Net Cash</th>
                                    <th class="text-left align-top">Transport</th>
                                    <th class="text-left align-top">Test</th>
                                    <th class="text-left align-top">Others</th>
                                    <th class="text-left align-top">Invoice No <br> Date</th>
                                    <th class="text-left align-top">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($total_collection as $key => $row)
                                    @php
                                        $net_cash = $row->mr_amount - $row->amount - $row->cr_amount;
                                        $total_net_cash = $net_cash + $total_net_cash;
                                        $total_mr_amount = $row->mr_amount + $total_mr_amount;
                                        $total_discount = $row->amount + $total_discount;
                                        $total_cr_amount = $row->cr_amount + $total_cr_amount;
                                        $total_transport_fee = $row->transport_fee + $total_transport_fee;
                                        $total_test_fee = $row->test_fee + $total_test_fee;
                                        $total_other_fee = $row->other_fee + $total_other_fee;
                                    @endphp
                                    <tr>
                                        <td class="text-left align-top">{{ $key + 1 }}</td>
                                        <td class="text-left align-top"> {{ $row->mr_id }} <br>
                                            {{ $row->collection_date }} </td>
                                        <td class="text-left align-top"> {{ $row->customer_name }} </td>
                                        <td class="text-left align-top"> {{ $row->payment_type_name }} </td>
                                        <td class="text-left align-top">
                                            @if ($row->payment_type == 1)
                                                @if ($row->receive_type == 1)
                                                    {{ 'Head Office' }}
                                                @elseif($row->receive_type == 2)
                                                    {{ 'Factory' }}
                                                @endif
                                            @else
                                                {{ $row->bank_name }} <br>
                                                {{ $row->chq_po_dd_no }}
                                            @endif
                                        </td>
                                        <td class="text-left align-top">{{ $row->mushok_no }} </td>
                                        <td class="text-left align-top">{{ number_format($row->mr_amount,2) }}</td>
                                        <td class="text-left align-top">{{ number_format($row->amount,2) }}</td>
                                        <td class="text-left align-top">{{ number_format($row->cr_amount,2) }}</td>
                                        <td class="text-left align-top">{{ number_format($net_cash,2) }}</td>
                                        <td class="text-left align-top">{{ number_format($row->transport_fee,2) }}</td>
                                        <td class="text-left align-top">{{ number_format($row->test_fee,2) }}</td>
                                        <td class="text-left align-top">{{ number_format($row->other_fee,2) }}</td>
                                        <td class="text-left align-top">
                                            @if ($row->sim_id)
                                                <a target="_blank"
                                                    href="{{ route('rpt_sales_invoice_view', [$row->sim_id, $row->company_id]) }}">{{ $row->sim_id }}</a>
                                                <br>
                                                {{ $row->sim_date }}
                                            @else
                                            @endif

                                        </td>
                                        <td class="text-left align-top">
                                            <a target="_blank"
                                                href="{{ route('rpt_money_receipt_view', [$row->mr_id, $row->company_id]) }}">View/Print</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"></td>
                                    <td colspan="1" class="text-right">{{ number_format($total_mr_amount,2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_discount,2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_cr_amount,2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_net_cash,2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_transport_fee,2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_test_fee,2) }}</td>
                                    <td colspan="1" class="text-right">{{ number_format($total_other_fee,2) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    //Number Formate
    function numberFormat($number, $decimals = 0)
    {
        // desimal (.) dat part
        if (strpos($number, '.') != null) {
            $decimalNumbers = substr($number, strpos($number, '.'));
            $decimalNumbers = substr($decimalNumbers, 1, $decimals);
        } else {
            $decimalNumbers = 0;
            for ($i = 2; $i <= $decimals; $i++) {
                $decimalNumbers = $decimalNumbers . '0';
            }
        }
        // echo $decimalNumbers;
        $number = (int) $number;
        // reverse
        $number = strrev($number);
        $n = '';
        $stringlength = strlen($number);
        for ($i = 0; $i < $stringlength; $i++) {
            if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                $n = $n . $number[$i] . ',';
            } else {
                $n = $n . $number[$i];
            }
        }
        $number = $n;
        // reverse
        $number = strrev($number);
        $decimals != 0 ? ($number = $number . '.' . $decimalNumbers) : $number;
        return $number;
    }

@endphp
   
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
@endsection