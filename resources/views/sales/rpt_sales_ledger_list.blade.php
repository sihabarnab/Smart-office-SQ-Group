@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Party Sales Ledger</h1>
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
                    <form id="myForm" action="{{ route('rpt_sales_ledger_list') }}" method="GET">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-4">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
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
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_type_id" id="cbo_customer_type_id">
                                    <option value="">--Customer Type--</option>
                                    @foreach ($customer_type as $value)
                                        <option value="{{ $value->customer_type_id }}"
                                            {{ $value->customer_type_id == $m_customer_type_id ? 'selected' : '' }}>
                                            {{ $value->customer_type }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_customer_type_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_id" id="cbo_customer_id">
                                    <option value="">--Name--</option>
                                </select>
                                @error('cbo_customer_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!-- /.row -->



                        <div class="row mb-1">
                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{ $m_transformer == '28' ? 'selected' : '' }}>TRANSFORMER
                                    </option>
                                    <option value="33" {{ $m_transformer == '33' ? 'selected' : '' }}>CTPT</option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value={{ $mm_from_date }}>

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ $mm_to_date }}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
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


    @php
        $total_mr_amount = 0;
        $total_debit_amount = 0;
        $total_sales_invoice = 0;
        $total_sales_return = 0;
        $total_sales_repair = 0;
        $sales_balance = 0;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Collection --}}
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="btn-primary">
                                    <th colspan="6" class="text-left">Collection</th>
                                </tr>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Date</th>
                                    <th>MR No.</th>
                                    <th colspan="3" class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-right">{{ 'Opening Balance' }}</td>
                                    <td class="text-right">{{ number_format($opening_balance, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">{{ "Balance at period start: $mm_from_date" }}
                                    </td>
                                    <td class="text-right">{{ number_format($balance_at_period, 2) }}</td>
                                </tr>
                                @foreach ($m_mreceipt as $key => $row)
                                    @php
                                        $total_mr_amount = $row->mr_amount + $total_mr_amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->collection_date }}</td>
                                        <td>{{ $row->mr_id }}</td>
                                        <td>{{ $row->payment_type }}</td>
                                        <td>{{ $row->bank_name }}</td>
                                        <td class="text-right">{{ number_format($row->mr_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">{{ 'Sub Total:' }}</td>
                                    <td class="text-right">{{ number_format($total_mr_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- Discount / Commission / Carrying Allowance --}}
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="btn-primary">
                                    <th colspan="6" class="text-left"> Discount / Commission / Carrying Allowance</th>
                                </tr>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Date</th>
                                    <th>Debit Voucher No.</th>
                                    <th colspan="3" class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-right">{{ "Balance at period start: $mm_from_date" }}
                                    </td>
                                    <td class="text-right">{{ number_format($m_debit_voucher_balance_at_period, 2) }}</td>
                                </tr>
                                @foreach ($m_debit_voucher as $key => $row)
                                    @php
                                        $total_debit_amount = $row->amount + $total_debit_amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->debit_voucher_date }}</td>
                                        <td>{{ $row->debit_voucher_id }}</td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{ number_format($row->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">{{ 'Total:' }}</td>
                                    <td class="text-right">{{ number_format($total_debit_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- Sales --}}
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="btn-primary">
                                    <th colspan="6" class="text-left">Sales</th>
                                </tr>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Date</th>
                                    <th>Invoice No.</th>
                                    <th colspan="3" class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-right">{{ "Balance at period start: $mm_from_date" }}
                                    </td>
                                    <td class="text-right">{{ number_format($m_sales_invoice_balance_at_period, 2) }}</td>
                                </tr>
                                @foreach ($m_sales_invoice as $key => $row)
                                    @php
                                        $total_sales_invoice = $row->total + $total_sales_invoice;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->sim_date }}</td>
                                        <td>{{ $row->sim_id }}</td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{ number_format($row->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">{{ 'Total:' }}</td>
                                    <td class="text-right">{{ number_format($total_sales_invoice, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- Sales Return --}}
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="btn-primary">
                                    <th colspan="6" class="text-left">Sales Return</th>
                                </tr>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Date</th>
                                    <th>Invoice No.</th>
                                    <th colspan="3" class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-right">{{ "Balance at period start: $mm_from_date" }}
                                    </td>
                                    <td class="text-right">{{ number_format($m_sales_return_balance_at_period, 2) }}</td>
                                </tr>
                                @foreach ($m_sales_return as $key => $row)
                                    @php
                                        $m_total_return_net_payble = DB::table("pro_return_invoice_details_$company_id")
                                            ->where("pro_return_invoice_details_$company_id.rsim_id", $row->rsim_id)
                                            ->where("pro_return_invoice_details_$company_id.valid", 1)
                                            ->sum('net_payble');
                                        $total_sales_return = $m_total_return_net_payble + $total_sales_return;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->rsim_date }}</td>
                                        <td>{{ $row->rsim_id }}</td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{ number_format($m_total_return_net_payble, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">{{ 'Total:' }}</td>
                                    <td class="text-right">{{ number_format($total_sales_return, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- Repair Invoice --}}
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="btn-primary">
                                    <th colspan="6" class="text-left">Repair Invoice</th>
                                </tr>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Date</th>
                                    <th>Invoice No.</th>
                                    <th colspan="3" class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-right">{{ "Balance at period start: $mm_from_date" }}
                                    </td>
                                    <td class="text-right">{{ number_format($m_sales_repaire_balance_at_period, 2) }}</td>
                                </tr>
                                @foreach ($m_sales_repair as $key => $row)
                                    @php
                                        $total_sales_repair = $row->total + $total_sales_repair;
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->reinvm_date }}</td>
                                        <td>{{ $row->reinvm_id }}</td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">{{ number_format($row->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">{{ 'Total:' }}</td>
                                    <td class="text-right">{{ number_format($total_sales_repair, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        @php
                            $sales_balance =
                                $total_sales_invoice +
                                $m_sales_invoice_balance_at_period +
                                $opening_balance +
                                ($total_sales_repair + $m_sales_repaire_balance_at_period) -
                                ($total_mr_amount + $balance_at_period - $total_debit_amount) -
                                ($total_sales_return + $m_sales_return_balance_at_period);
                        @endphp

                        <div class="row">
                            <div class="col-12 text-center">
                                <strong>Balance : {{ number_format($sales_balance, 2) }}</strong>
                            </div>
                        </div>

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
            GetProduct("{{ $m_customer_id }}");
            $('select[name="cbo_customer_type_id"]').on('change', function() {
                GetProduct("0");
            });

            function GetProduct(m_customer_id) {
                var cbo_customer_type_id = $('#cbo_customer_type_id').val();
                var cbo_company_id = $('#cbo_company_id').val();
                if (cbo_customer_type_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/daliy_report_party_list/') }}/" +
                            cbo_customer_type_id + '/' + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_customer_id"]').empty();
                            $('select[name="cbo_customer_id"]').append(
                                '<option value="">-Name-</option>');
                            $.each(data, function(key, value) {

                                if (m_customer_id == value.customer_id) {
                                    $('select[name="cbo_customer_id"]').append(
                                        '<option value="' + value.customer_id +
                                        '" selected>' + value.customer_id + '|' +
                                        value.customer_name + '</option>');
                                } else {
                                    $('select[name="cbo_customer_id"]').append(
                                        '<option value="' + value.customer_id + '">' + value
                                        .customer_id + '|' +
                                        value.customer_name + '</option>');
                                }

                            });
                        },
                    });

                } else {
                    $('#cbo_customer_id').empty();
                }
            }
        });
    </script>
@endsection
@endsection
