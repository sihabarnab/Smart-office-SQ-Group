@extends('layouts.purchase_app')

@section('content')
    <div class="container-fluid">
        @include('flash-message')
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <a href="{{ route('rpt_rr_price_list_print', [$pro_grr_master->grr_master_id,$pro_grr_master->company_id]) }}"
                        class=" btn btn-info float-right mr-5 mt-4"> Print </a>

                    <div class="row mb-2">
                        <div class="col-12">
                            <h2 class="text-center mb-2">RR PRICE</h2>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-1"></div>
                        <div class="col-7">
                            Indent No : {{ $pro_grr_master->indent_no }} <br>
                            RR No : {{ $pro_grr_master->grr_no }} <br>
                            Project : {{ $pro_grr_master->project_name }} <br>
                            Supplier Address : {{ $pro_grr_master->supplier_address }}
                        </div>
                        <div class="col-4">
                            Indent Date : {{ $pro_grr_master->indent_date }} <br>
                            RR Date : {{ $pro_grr_master->grr_date }} <br>
                            Indent Category : {{ $pro_grr_master->category_name }} <br>
                            Supplier Name : {{ $pro_grr_master->supplier_name }}
                        </div>
                    </div>

                    <table  class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Group|Sub Group</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>RR Qty</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_amount=0;
                            @endphp

                            @foreach ($pro_grr_details as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->pg_name }} <hr class="m-0" color='white'> {{ $value->pg_sub_name }}</td>
                                    <td>{{ $value->product_name }}</td>
                                    <td>
                                        @php
                                            $unit = DB::table('pro_units')
                                                ->where('unit_id', '=', $value->unit)
                                                ->first();
                                        @endphp
                                        @isset($unit)
                                            {{ $unit->unit_name }}
                                        @endisset
                                    </td>

                                    <td style="text-align: right;">{{ $value->received_qty }}</td>
                                    <td style="text-align: right;">{{ number_format($value->product_rate,2) }}</td>
                                    <td style="text-align: right;">{{ number_format($value->received_total,2) }}</td>
                                </tr>
                                @php
                                $txt_amount_01=$value->received_total;
                                $total_amount=$total_amount+$txt_amount_01;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" >&nbsp;</td>
                                <td style="text-align: right;">{{ "Total" }}</td>
                                <td style="text-align: right;">{{ number_format($total_amount,2) }}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
