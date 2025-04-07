@php
    $total_qty = 0;
    $total_price = 0;
    $total_vat_amount = 0;
    $total_discount = 0;
    $total_depreciation = 0;
    $total_net_payble = 0;
@endphp
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
                                <th>SL</th>
                                <th>Item</th>
                                <th>Specification</th>
                                {{-- <th>Remarks</th> --}}
                                <th>Sales Rate</th>
                                <th>Return Qty</th>
                                <th>Sales Price</th>
                                <th>Vat Amount</th>
                                <th>Discount</th>
                                <th>Depreciation</th>
                                <th>Net Payble</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($m_return_invoice_details as $key => $row)
                                @php
                                    $total_qty = $total_qty + $row->return_qty;
                                    $total_price = $total_price + $row->total_sales_price;
                                    $total_vat_amount = $total_vat_amount + $row->vat_amount;
                                    $total_discount = $total_discount + $row->discount_amount;
                                    $total_depreciation = $total_depreciation + $row->depreciation;
                                    $total_net_payble = $total_net_payble + $row->net_payble;

                                    $serial_count = DB::table("pro_finish_product_serial_$row->company_id")
                                        ->where('rsid_id', $row->rsid_id)
                                        ->where('product_id', $row->product_id)
                                        ->count();
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->model_size }}<br>{{ $row->product_description }}</td>
                                    {{-- <td>{{ $row->remark }}</td> --}}
                                    <td class="text-right">{{ numberFormat($row->sales_rate,2) }}</td>
                                    <td class="text-right">{{ numberFormat($row->return_qty,2) }}</td>
                                    <td class="text-right">{{ numberFormat($row->total_sales_price,2) }}</td>
                                    <td class="text-right">{{ numberFormat($row->vat_amount,2) }}</td>
                                    <td class="text-right">{{ numberFormat($row->discount_amount,2) }}</td>
                                    <td class="text-right">{{ numberFormat($row->depreciation,2) }}</td>
                                    <td class="text-right">{{ numberFormat($row->net_payble,2) }}</td>
                                    @if ($serial_count == $row->return_qty)
                                    <td></td>
                                    <td></td>
                                    @else
                                    <td>
                                        <a href="{{route('return_sales_invoice_serial',[$row->rsid_id,$row->company_id])}}" >Serial</a>
                                    </td>
                                    <td>
                                        <a href="{{route('return_sales_invoice_edit',[$row->rsid_id,$row->company_id])}}" >Edit</a>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">Total:</td>
                                <td colspan="1" class="text-right">{{ numberFormat($total_qty,2) }}</td>
                                <td colspan="1" class="text-right">{{ numberFormat($total_price,2) }}</td>
                                <td colspan="1" class="text-right">{{ numberFormat($total_vat_amount,2) }}</td>
                                <td colspan="1" class="text-right">{{ numberFormat($total_discount,2) }}</td>
                                <td colspan="1" class="text-right">{{ numberFormat($total_depreciation,2) }}</td>
                                <td colspan="1" class="text-right">{{ numberFormat($total_net_payble,2) }}</td>
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
