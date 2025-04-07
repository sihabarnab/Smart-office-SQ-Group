@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daily Sales Report</h1>
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
                    <form id="myForm" action="{{ route('rpt_daliy_sales_report') }}" method="GET">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-3">
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
                            <div class="col-3">
                                <select class="form-control" id="cbo_transformer" name="cbo_transformer">
                                    <option value="">--Transformer / CTPT--</option>
                                    <option value="28" {{ '28' == $m_transformer ? 'selected' : '' }}>TRANSFORMER
                                    </option>
                                    <option value="33" {{ '33' == $m_transformer ? 'selected' : '' }}>CTPT</option>
                                </select>
                                @error('cbo_transformer')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_from_date" name="txt_from_date"
                                    placeholder="From Date" value="{{ $form }}">

                                @error('txt_from_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" id="txt_to_date" name="txt_to_date"
                                    placeholder="To Date" value="{{ $to }}">
                                @error('txt_to_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!-- /.row -->

                        <div class="row mb-2">
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_type_id" id="cbo_customer_type_id">
                                    <option value="">-Customer Type-</option>
                                    @foreach ($customer_type as $value)
                                        <option value="{{ $value->customer_type_id }}"
                                            {{ $m_customer_type_id == $value->customer_type_id ? 'selected' : '' }}>
                                            {{ $value->customer_type }}</option>
                                    @endforeach
                                </select>
                                @error('cbo_customer_type_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="cbo_customer_id" id="cbo_customer_id">
                                    <option value="">-Party Name-</option>
                                </select>
                                @error('cbo_customer_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="cbo_product" name="cbo_product">
                                    <option value="">--KVA--</option>

                                </select>
                                @error('cbo_product')
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
            getpartyname();
            $('select[name="cbo_customer_type_id"]').on('change', function() {
                getpartyname();
            });
        });

        function getpartyname() {
            var cbo_customer_type_id = $('#cbo_customer_type_id').val();
            var cbo_company_id = $('#cbo_company_id').val();
            var m_customer_id = "{{ $m_customer_id }}";
            if (cbo_customer_type_id) {
                $.ajax({
                    url: "{{ url('/get/sales/daliy_report_party_list/') }}/" +
                        cbo_customer_type_id+'/'+cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_customer_id"]').empty();
                        $('select[name="cbo_customer_id"]').append(
                            '<option value="">-Party Name-</option>');
                        $.each(data, function(key, value) {
                            if (m_customer_id == value.customer_id) {
                                $('select[name="cbo_customer_id"]').append(
                                    '<option selected value="' + value.customer_id + '">' + value
                                    .customer_id + '|' +
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
                $('select[name="cbo_customer_id"]').empty();
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            finishproduct();
            $('select[name="cbo_transformer"]').on('change', function() {
                finishproduct();

            });
        });

        function finishproduct() {
            var cbo_transformer = $('#cbo_transformer').val();
            var cbo_company_id = $('#cbo_company_id').val();
            var m_product = "{{ $m_product }}";
            if (cbo_transformer && cbo_company_id) {
                $.ajax({
                    url: "{{ url('/get/sales/cbo_transformer_ctpt/') }}/" +
                        cbo_transformer + '/' + cbo_company_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_product"]').empty();
                        $('select[name="cbo_product"]').append(
                            '<option value="">-KVA-</option>');
                        $.each(data, function(key, value) {
                            if (m_product == value.product_id) {
                                $('select[name="cbo_product"]').append(
                                    '<option selected value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            } else {
                                $('select[name="cbo_product"]').append(
                                    '<option value="' + value.product_id + '">' +
                                    value.product_name + '</option>');
                            }

                        });
                    },
                });

            } else {
                $('select[name="cbo_product"]').empty();
            }
        }
    </script>
@endsection


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name Of Party.</th>
                                <th>Type Of Party</th>
                                <th>Mode Of Payment</th>
                                <th>Money Receipt</th>
                                <th>Vat No.</th>
                                <th>KVA</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Discount</th>
                                <th>TR.Discount</th>
                                <th>Net Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $customer_name = '';
                                $customer_type_name = '';
                                $total_qty = 0;
                                $total_price = 0;
                                $total_discount = 0;
                                $total_tr_discount = 0;
                                $total = 0;
                                $net_total = 0;
                                $money_receipt_no = '';
                            @endphp
                            @foreach ($sales_details as $row)
                                @php
                                    $m_customer = DB::table("pro_customer_information_$row->company_id")
                                        ->select('customer_name', 'customer_type')
                                        ->where('customer_id', $row->customer_id)
                                        ->where('valid', 1)
                                        ->first();
                                    if ($m_customer) {
                                        $customer_name = $m_customer->customer_name;
                                        $cust_type = DB::table('pro_customer_type')
                                            ->select('pro_customer_type.customer_type')
                                            ->where('customer_type_id', $m_customer->customer_type)
                                            ->first();
                                        // $customer_type_name = $cust_type->customer_type;
                                    } else {
                                        $customer_name = '';
                                        $customer_type_name = '';
                                    }

                                    $m_recipt = DB::table("pro_money_receipt_$row->company_id")
                                        ->select('mr_id')
                                        ->where('sim_id', $row->sim_id)
                                        ->first();
                                    if ($m_recipt) {
                                        $money_receipt_no = $m_recipt->mr_id;
                                    } else {
                                        $money_receipt_no = '';
                                    }

                                    //
                                    $total_qty = $row->qty + $total_qty;
                                    $total_price = $row->qty * $row->rate + $total_price;
                                    $total_discount = $row->total_discount + $total_discount;
                                    $total_tr_discount = $row->total_transport + $total_tr_discount;
                                    $total = $row->total - $row->total_discount - $row->total_transport;
                                    $net_total = $total + $net_total;

                                @endphp
                                <tr>
                                    <td>{{ $row->sim_date }}</td>
                                    <td>{{ $customer_name }}</td>
                                    <td>{{ $customer_type_name }}</td>
                                    <td>
                                        @if ($row->sales_type == 1)
                                            {{ 'Cash' }}
                                        @elseif($row->sales_type == 2)
                                            {{ 'Credit' }}
                                        @endif
                                    </td>
                                    <td>{{ $money_receipt_no }}</td>
                                    <td>{{ $row->mushok_no }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td class="text-right">{{ number_format($row->qty, 2) }}</td>
                                    <td class="text-right">{{ number_format($row->rate, 2) }}</td>
                                    <td class="text-right">{{ number_format($row->qty * $row->rate, 2) }}</td>
                                    <td class="text-right">{{ number_format($row->total_discount, 2) }}</td>
                                    <td class="text-right">{{ number_format($row->total_transport, 2) }}</td>
                                    <td class="text-right">{{ number_format($total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"></td>
                                <td class="text-right">{{ number_format($total_qty, 2) }}</td>
                                <td colspan="1"></td>
                                <td class="text-right">{{ number_format($total_price, 2) }}</td>
                                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                                <td class="text-right">{{ number_format($total_tr_discount, 2) }}</td>
                                <td class="text-right">{{ number_format($net_total, 2) }}</td>
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

    //Number to word BD Taka
    function convert_number($number)
    {
        $my_number = $number;

        if ($number < 0 || $number > 999999999) {
            throw new Exception('Number is out of range');
        }
        $Kt = floor($number / 10000000); /* Koti */
        $number -= $Kt * 10000000;
        $Gn = floor($number / 100000); /* lakh  */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000); /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100); /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10); /* Tens (deca) */
        $n = $number % 10; /* Ones */

        $res = '';

        if ($Kt) {
            $res .= convert_number($Kt) . ' Koti ';
        }
        if ($Gn) {
            $res .= convert_number($Gn) . ' Lakh';
        }

        if ($kn) {
            $res .= (empty($res) ? '' : ' ') . convert_number($kn) . ' Thousand';
        }

        if ($Hn) {
            $res .= (empty($res) ? '' : ' ') . convert_number($Hn) . ' Hundred';
        }

        $ones = [
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Thirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eightteen',
            'Nineteen',
        ];
        $tens = ['', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eigthy', 'Ninety'];

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= ' and ';
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= '-' . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = 'zero';
        }

        return $res;
    }
@endphp

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            GetDailyPartyReportName("{{ $m_customer_id }}");
            $('select[name="cbo_customer_type_id"]').on('change', function() {
                GetDailyPartyReportName('0');
            });

            function GetDailyPartyReportName(m_customer_id) {
                var cbo_customer_type_id = $('select[name="cbo_customer_type_id"]').val();
                if (cbo_customer_type_id) {
                    $.ajax({
                        url: "{{ url('/get/sales/daliy_report_party_list/') }}/" +
                            cbo_customer_type_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_customer_id"]').empty();
                            $('select[name="cbo_customer_id"]').append(
                                '<option value="">-Party Name-</option>');
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
                    $('select[name="cbo_customer_id"]').empty();
                }
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            GetProduct("{{ $m_product }}");
            $('select[name="cbo_transformer"]').on('change', function() {
                GetProduct("0");
            });

            function GetProduct(m_product) {
                var cbo_transformer = $('select[name="cbo_transformer"]').val();
                if (cbo_transformer) {
                    $.ajax({
                        url: "{{ url('/get/sales/cbo_transformer_ctpt/') }}/" +
                            cbo_transformer,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_product"]').empty();
                            $('select[name="cbo_product"]').append(
                                '<option value="">-KVA-</option>');
                            $.each(data, function(key, value) {

                                if (m_product == value.product_id) {
                                    $('select[name="cbo_product"]').append(
                                        '<option value="' + value.product_id +
                                        '" selected>' +
                                        value.product_name + '</option>');
                                } else {
                                    $('select[name="cbo_product"]').append(
                                        '<option value="' + value.product_id + '">' +
                                        value.product_name + '</option>');
                                }

                            });
                        },
                    });

                } else {
                    $('select[name="cbo_product"]').empty();
                }
            }
        });
    </script>
@endsection
@endsection
