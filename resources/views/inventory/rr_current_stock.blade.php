<div class="content-header">
        <div class="container-fluid">
            <div class="row card">
                <div class="col-12">


                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Product Group</th>
                                <th>Product Name<br>Description</th>
                                <th>Section</th>
                                <th>Indent Qty</th>
                                <th>Approved Qty</th>
                                <th>RR Qty</th>
                                <th>Stock</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pro_indent_stock as $key => $value)
                            @php
                                $mentrydate=time();
                                $m_current_date=date("Y-m-d",$mentrydate);
                                $m_current_year=date("Y",$mentrydate);
                                $m_current_month=date("m",$mentrydate);

                                $txt_start_date="$m_current_year-$m_current_month-01";
                                $txt_end_date="$m_current_date";

                                $closing_date = date('Y-m-d', strtotime('-1 month', strtotime($txt_start_date)));
                                $closing_year=substr($closing_date, 0,4);
                                $closing_month=substr($closing_date, 5,2);

                                $ci_stock_closing  = DB::table("pro_stock_closing_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->where("year",$closing_year)
                                ->where("month",$closing_month)
                                ->sum('qty');
                               

                                if ($ci_stock_closing == '0')
                                {
                                    $txt_clossing_stock="0.0000";
                                } else {
                                    $txt_clossing_stock=round($ci_stock_closing,4);
                                }


                                $ci_grr_details1  = DB::table("pro_grr_details_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->where("indent_no",$pro_indent_master->indent_no)
                                // ->whereBetween('grr_date',[$txt_start_date,$txt_end_date])
                                ->sum('received_qty');
                                

                                $ci_grr_details  = DB::table("pro_grr_details_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->whereBetween('grr_date',[$txt_start_date,$txt_end_date])
                                ->sum('received_qty');
// dd("$ci_grr_details1 -- $ci_grr_details $txt_start_date -- $txt_end_date -- $value->product_id");
                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt1_rr_qty="$ci_grr_details";
                                    $txt_rr_qty=round($txt1_rr_qty,4);
                                }
                                // dd("$ci_grr_details -- $txt_rr_qty");
                                $ci_graw_issue_details  = DB::table("pro_graw_issue_details_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->whereBetween('rim_date',[$txt_start_date,$txt_end_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details === NULL)
                                {
                                    $txt_issue_qty="0.0000";
                                } else {
                                    $txt_issue_qty="$ci_graw_issue_details";
                                }

                                $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->whereBetween('return_date',[$txt_start_date,$txt_end_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details === NULL)
                                {
                                    $txt_return_qty="0.0000";
                                } else {
                                    $txt_return_qty="$ci_gmaterial_return_details";
                                }

                                $txt1_bal_qty=$txt_clossing_stock+$txt_rr_qty+$txt_return_qty-$txt_issue_qty;
                                $txt_bal_qty=number_format($txt1_bal_qty,4);

                            @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->pg_name }} <br> {{ $value->pg_sub_name }}</td>
                                    <td>{{ $value->product_name }}<br>{{ $value->description }}</td>
                                    <td>{{ $value->section_name }}</td>
                                    <td>{{ $value->qty }}</td>
                                    <td>{{ $value->approved_qty }}</td>
                                    <td>{{ $ci_grr_details1 }}</td>
                                    <td>{{ $txt_bal_qty }}</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

