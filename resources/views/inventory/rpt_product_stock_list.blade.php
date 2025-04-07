@extends('layouts.inventory_app')

@php
$ci_project_name  = DB::table('pro_project_name')
->where("project_id",$txt_project_id)
->first();

if ($ci_project_name === NULL)
{
    $txt_project_name="ALL Project";
} else {
    $txt_project_name=$ci_project_name->project_name;
}

$company = DB::table('pro_company')->where('company_id', $m_company_id)->first();

@endphp

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $company->company_name }}</h1>
                    <h4 class="m-0">Material Stock Price</h4>
                    <h5 class="m-0">Project : {{ $txt_project_name }}</h5>
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
                    <table id="data1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th width="5%">SL No</th>
                                <th width="15%">Group| Sub Group</th>
                                <th width="15%">Product<br>Unit</th>
                                <th width="10%">Opening<br>{{ $txt_start_date }}</th>
                                <th width="10%">Receive<br>Issue<br>Return</th>
                                <th width="14%">Balance<br>{{ $txt_end_date }}</th>
                                <th width="13%">RR<br>Date</th>
                                <th width="8%">Rate</th>
                                <th width="10%">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_balance=0;
                            $total_amount=0;
                            @endphp

                            @foreach($ci_product_list as $key=>$row_product_list)
                            @php
                            // dd("$txt_start_date, $txt_end_date, $closing_year, $closing_month, $txt_project_id");
                            if($txt_day == 0)
                            {

                                if($txt_project_id == 0)
                                {
                                $table_name ="pro_stock_closing_"."$closing_year$closing_month"."_$m_company_id";
                                // $ci_stock_closing  = DB::table("pro_stock_closing_$company_id")
                                $ci_stock_closing  = DB::table("$table_name")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("year",$closing_year)
                                ->where("month",$closing_month)
                                ->sum('qty');

                                if ($ci_stock_closing === NULL)
                                {
                                    $txt_clossing_stock="0.0000";
                                } else {
                                    $txt_clossing_stock=round($ci_stock_closing,4);
                                }

                                $ci_grr_details  =DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('grr_date',[$txt_start_date,$txt_end_date])
                                ->sum('received_qty');

                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt_rr_qty="$ci_grr_details";
                                }

                                $ci_grr_details_rate_01  = DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("product_rate","!=","0")
                                ->max('grr_details_id');

                                if ($ci_grr_details_rate_01 === NULL)
                                {
                                    $txt_rr_rate="0.0000";
                                    $txt_grr_no="";
                                    $txt_grr_details_id="";
                                    $txt_price_entry_date="";                               
                                } else {

                                $ci_grr_details_rate  = DB::table("pro_grr_details_$m_company_id")
                                // ->where("product_id",$row_product_list->product_id)
                                ->where("grr_details_id",$ci_grr_details_rate_01)
                                ->first();

                                $txt_rr_rate=$ci_grr_details_rate->product_rate;
                                $txt_grr_no=$ci_grr_details_rate->grr_no;
                                $txt_grr_details_id=$ci_grr_details_rate->grr_details_id;
                                $txt_price_entry_date=$ci_grr_details_rate->price_entry_date;

                                }                           

                                $ci_graw_issue_details  = DB::table("pro_graw_issue_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('rim_date',[$txt_start_date,$txt_end_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details === NULL)
                                {
                                    $txt_issue_qty="0.0000";
                                } else {
                                    $txt_issue_qty="$ci_graw_issue_details";
                                }

                                $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('return_date',[$txt_start_date,$txt_end_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details === NULL)
                                {
                                    $txt_return_qty="0.0000";
                                } else {
                                    $txt_return_qty="$ci_gmaterial_return_details";
                                }

                                $txt1_bal_qty=$txt_clossing_stock+$txt_rr_qty+$txt_return_qty-$txt_issue_qty;
                                // $txt_bal_qty=number_format($txt1_bal_qty,4);
                                $txt_bal_qty=round($txt1_bal_qty,4);

                                $txt_amount_01=$txt1_bal_qty*$txt_rr_rate;
                                // $txt_amount=number_format($txt_amount_01,4);
                                $txt_amount=round($txt_amount_01,4);

                                $total_balance=$total_balance+$txt1_bal_qty;
                                $total_amount=$total_amount+$txt_amount_01;


                                } else if($txt_project_id != 0){

                                // dd("$txt_start_date, $txt_end_date, $closing_year, $closing_month, $txt_project_id");

                                $table_name ="pro_stock_closing_"."$closing_year$closing_month"."_$m_company_id";
                                // $ci_stock_closing  = DB::table("pro_stock_closing_$company_id")
                                $ci_stock_closing  = DB::table("$table_name")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("year",$closing_year)
                                ->where("month",$closing_month)
                                ->where("project_id",$txt_project_id)
                                ->sum('qty');

                                if ($ci_stock_closing === NULL)
                                {
                                    $txt_clossing_stock="0.0000";
                                } else {
                                    $txt_clossing_stock=round($ci_stock_closing,4);
                                }

                                $ci_grr_details  =  DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->whereBetween('grr_date',[$txt_start_date,$txt_end_date])
                                ->sum('received_qty');

                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt_rr_qty="$ci_grr_details";
                                }

                                $ci_grr_details_rate_01  = DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->where("product_rate","!=","0")
                                ->max('grr_details_id');

                                if ($ci_grr_details_rate_01 === NULL)
                                {
                                    $txt_rr_rate="0.0000";
                                    $txt_grr_no="";
                                    $txt_grr_details_id="";
                                    $txt_price_entry_date="";                               
                                } else {

                                $ci_grr_details_rate  =  DB::table("pro_grr_details_$m_company_id")
                                // ->where("product_id",$row_product_list->product_id)
                                ->where("grr_details_id",$ci_grr_details_rate_01)
                                ->first();

                                $txt_rr_rate=$ci_grr_details_rate->product_rate;
                                $txt_grr_no=$ci_grr_details_rate->grr_no;
                                $txt_grr_details_id=$ci_grr_details_rate->grr_details_id;
                                $txt_price_entry_date=$ci_grr_details_rate->price_entry_date;

                                }                           

                                $ci_graw_issue_details  = DB::table("pro_graw_issue_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->whereBetween('rim_date',[$txt_start_date,$txt_end_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details === NULL)
                                {
                                    $txt_issue_qty="0.0000";
                                } else {
                                    $txt_issue_qty="$ci_graw_issue_details";
                                }

                                $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->whereBetween('return_date',[$txt_start_date,$txt_end_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details === NULL)
                                {
                                    $txt_return_qty="0.0000";
                                } else {
                                    $txt_return_qty="$ci_gmaterial_return_details";
                                }

                                $txt1_bal_qty=$txt_clossing_stock+$txt_rr_qty+$txt_return_qty-$txt_issue_qty;
                                $txt_bal_qty=round($txt1_bal_qty,4);

                                $txt_amount_01=$txt1_bal_qty*$txt_rr_rate;
                                // $txt_amount=number_format($txt_amount_01,4);
                                $txt_amount=round($txt_amount_01,4);

                                $total_balance=$total_balance+$txt1_bal_qty;
                                $total_amount=$total_amount+$txt_amount_01;

                                }//if($txt_project_id == 0)
                            } else {//if($txt_day == 0)

                                if($txt_project_id == 0)
                                {

                                $table_name ="pro_stock_closing_"."$closing_year$closing_month"."_$m_company_id";

                                // $ci_stock_closing_01  = DB::table("pro_stock_closing_$company_id")
                                $ci_stock_closing_01  = DB::table("$table_name")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("year",$closing_year)
                                ->where("month",$closing_month)
                                ->sum('qty');

                                if ($ci_stock_closing_01 === NULL)
                                {
                                    $txt_clossing_stock_01="0.0000";
                                } else {
                                    $txt_clossing_stock_01=$ci_stock_closing_01;
                                }

// date deferance stok
                                $ci_grr_details_stock  =  DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('grr_date',[$m_date,$txt_start_date])
                                ->sum('received_qty');

                                if ($ci_grr_details_stock === NULL)
                                {
                                    $txt_rr_qty_stock="0.0000";
                                } else {
                                    $txt_rr_qty_stock="$ci_grr_details_stock";
                                }

                                $ci_graw_issue_details_stock  = DB::table("pro_graw_issue_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('rim_date',[$m_date,$txt_start_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details_stock === NULL)
                                {
                                    $txt_issue_qty_stock="0.0000";
                                } else {
                                    $txt_issue_qty_stock="$ci_graw_issue_details_stock";
                                }

                                $ci_gmaterial_return_details_stock  = DB::table("pro_gmaterial_return_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('return_date',[$m_date,$txt_start_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details_stock === NULL)
                                {
                                    $txt_return_qty_stock="0.0000";
                                } else {
                                    $txt_return_qty_stock="$ci_gmaterial_return_details_stock";
                                }

                                $txt1_bal_qty_stock=$txt_clossing_stock_01+$txt_rr_qty_stock+$txt_return_qty_stock-$txt_issue_qty_stock;
                                $txt_clossing_stock=$txt1_bal_qty_stock;




// date deferance stok
                                $ci_grr_details  =  DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('grr_date',[$txt_start_date,$txt_end_date])
                                ->sum('received_qty');

                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt_rr_qty="$ci_grr_details";
                                }

                                $ci_grr_details_rate_01  =  DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("product_rate","!=","0")
                                ->max('grr_details_id');

                                if ($ci_grr_details_rate_01 === NULL)
                                {
                                    $txt_rr_rate="0.0000";
                                    $txt_grr_no="";
                                    $txt_grr_details_id="";
                                    $txt_price_entry_date="";                               
                                } else {

                                $ci_grr_details_rate  =  DB::table("pro_grr_details_$m_company_id")
                                // ->where("product_id",$row_product_list->product_id)
                                ->where("grr_details_id",$ci_grr_details_rate_01)
                                ->first();

                                $txt_rr_rate=$ci_grr_details_rate->product_rate;
                                $txt_grr_no=$ci_grr_details_rate->grr_no;
                                $txt_grr_details_id=$ci_grr_details_rate->grr_details_id;
                                $txt_price_entry_date=$ci_grr_details_rate->price_entry_date;

                                }                           

                                $ci_graw_issue_details  =DB::table("pro_graw_issue_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('rim_date',[$txt_start_date,$txt_end_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details === NULL)
                                {
                                    $txt_issue_qty="0.0000";
                                } else {
                                    $txt_issue_qty="$ci_graw_issue_details";
                                }

                                $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('return_date',[$txt_start_date,$txt_end_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details === NULL)
                                {
                                    $txt_return_qty="0.0000";
                                } else {
                                    $txt_return_qty="$ci_gmaterial_return_details";
                                }

                                $txt1_bal_qty=$txt_clossing_stock+$txt_rr_qty+$txt_return_qty-$txt_issue_qty;
                                // $txt_bal_qty=number_format($txt1_bal_qty,4);
                                $txt_bal_qty=round($txt1_bal_qty,4);

                                $txt_amount_01=$txt1_bal_qty*$txt_rr_rate;
                                // $txt_amount=number_format($txt_amount_01,4);
                                $txt_amount=round($txt_amount_01,4);

                                $total_balance=$total_balance+$txt1_bal_qty;
                                $total_amount=$total_amount+$txt_amount_01;


                                } else if($txt_project_id != 0){
                                $table_name ="pro_stock_closing_"."$closing_year$closing_month"."_$m_company_id";

                                // $ci_stock_closing_01  = DB::table("pro_stock_closing_$company_id")
                                $ci_stock_closing_01  = DB::table("$table_name")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("year",$closing_year)
                                ->where("month",$closing_month)
                                ->sum('qty');

                                if ($ci_stock_closing_01 === NULL)
                                {
                                    $txt_clossing_stock_01="0.0000";
                                } else {
                                    $txt_clossing_stock_01=$ci_stock_closing_01;
                                }

// date deferance stok
                                $ci_grr_details_stock  =  DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('grr_date',[$m_date,$txt_start_date])
                                ->sum('received_qty');

                                if ($ci_grr_details_stock === NULL)
                                {
                                    $txt_rr_qty_stock="0.0000";
                                } else {
                                    $txt_rr_qty_stock="$ci_grr_details_stock";
                                }

                                $ci_graw_issue_details_stock  = DB::table("pro_graw_issue_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('rim_date',[$m_date,$txt_start_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details_stock === NULL)
                                {
                                    $txt_issue_qty_stock="0.0000";
                                } else {
                                    $txt_issue_qty_stock="$ci_graw_issue_details_stock";
                                }

                                $ci_gmaterial_return_details_stock  = DB::table("pro_gmaterial_return_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->whereBetween('return_date',[$m_date,$txt_start_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details_stock === NULL)
                                {
                                    $txt_return_qty_stock="0.0000";
                                } else {
                                    $txt_return_qty_stock="$ci_gmaterial_return_details_stock";
                                }

                                $txt1_bal_qty_stock=$txt_clossing_stock_01+$txt_rr_qty_stock+$txt_return_qty_stock-$txt_issue_qty_stock;
                                $txt_clossing_stock=$txt1_bal_qty_stock;




// date deferance stok


                                // $ci_stock_closing  = DB::table('pro_stock_closing')
                                // ->where("product_id",$row_product_list->product_id)
                                // ->where("year",$closing_year)
                                // ->where("month",$closing_month)
                                // ->where("project_id",$txt_project_id)
                                // ->sum('qty');

                                // if ($ci_stock_closing === NULL)
                                // {
                                //     $txt_clossing_stock="0.0000";
                                // } else {
                                //     $txt_clossing_stock=round($ci_stock_closing,4);
                                // }

                                $ci_grr_details  = DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->whereBetween('grr_date',[$txt_start_date,$txt_end_date])
                                ->sum('received_qty');

                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt_rr_qty="$ci_grr_details";
                                }

                                $ci_grr_details_rate_01  =  DB::table("pro_grr_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->where("product_rate","!=","0")
                                ->max('grr_details_id');

                                if ($ci_grr_details_rate_01 === NULL)
                                {
                                    $txt_rr_rate="0.0000";
                                    $txt_grr_no="";
                                    $txt_grr_details_id="";
                                    $txt_price_entry_date="";                               
                                } else {

                                $ci_grr_details_rate  =  DB::table("pro_grr_details_$m_company_id")
                                // ->where("product_id",$row_product_list->product_id)
                                ->where("grr_details_id",$ci_grr_details_rate_01)
                                ->first();

                                $txt_rr_rate=$ci_grr_details_rate->product_rate;
                                $txt_grr_no=$ci_grr_details_rate->grr_no;
                                $txt_grr_details_id=$ci_grr_details_rate->grr_details_id;
                                $txt_price_entry_date=$ci_grr_details_rate->price_entry_date;

                                }                           

                                $ci_graw_issue_details  = DB::table("pro_graw_issue_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->whereBetween('rim_date',[$txt_start_date,$txt_end_date])
                                ->sum('product_qty');

                                if ($ci_graw_issue_details === NULL)
                                {
                                    $txt_issue_qty="0.0000";
                                } else {
                                    $txt_issue_qty="$ci_graw_issue_details";
                                }

                                $ci_gmaterial_return_details  = DB::table("pro_gmaterial_return_details_$m_company_id")
                                ->where("product_id",$row_product_list->product_id)
                                ->where("project_id",$txt_project_id)
                                ->whereBetween('return_date',[$txt_start_date,$txt_end_date])
                                ->sum('useable_qty');

                                if ($ci_gmaterial_return_details === NULL)
                                {
                                    $txt_return_qty="0.0000";
                                } else {
                                    $txt_return_qty="$ci_gmaterial_return_details";
                                }

                                $txt1_bal_qty=$txt_clossing_stock+$txt_rr_qty+$txt_return_qty-$txt_issue_qty;
                                $txt_bal_qty=round($txt1_bal_qty,4);

                                $txt_amount_01=$txt1_bal_qty*$txt_rr_rate;
                                // $txt_amount=number_format($txt_amount_01,4);
                                $txt_amount=round($txt_amount_01,4);

                                $total_balance=$total_balance+$txt1_bal_qty;
                                $total_amount=$total_amount+$txt_amount_01;

                                }//if($txt_project_id == 0)


                            }

                            @endphp

                            @if($txt1_bal_qty>0)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_product_list->pg_name }}<hr class="m-0" color='white'>{{ $row_product_list->pg_sub_name }}</td>
                                <td>{{ $row_product_list->product_name }}<br>{{ $row_product_list->unit_name }}</td>
                                <td style="text-align: right;">{{ $txt_clossing_stock }}</td>
                                <td style="text-align: right;">{{ $txt_rr_qty }}<br>{{ $txt_issue_qty }}<br>{{ $txt_return_qty }}</td>
                                <td style="text-align: right;">{{ $txt_bal_qty }}</td>
                                <td>{{ $txt_grr_no }}<br>{{ $txt_price_entry_date }}</td>
                                <td style="text-align: right;">{{ $txt_rr_rate }}</td>
                                <td style="text-align: right;">{{ $txt_amount }}</td>
                                
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" >&nbsp;</td>
                                <td style="text-align: right;">{{ "Total" }}</td>
                                <td colspan="1" style="text-align: right;">{{ number_format($total_balance,4) }}</td>
                                <td colspan="2">&nbsp;</td>
                                <td style="text-align: right;">{{ number_format($total_amount,4) }}</td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection