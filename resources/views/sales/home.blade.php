@extends('layouts.sales_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">SALES</h1>
                </div><!-- /.col -->



            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @php
        $total_collection_transformer = 0;
        $total_collection_ctpt = 0;
        $total_sales_transformer = 0;
        $total_sales_ctpt = 0;
        $total_due_transformer = 0;
        $total_due_ctpt = 0;
        $total_quotation_transformer = '';
        $total_quotation_ctpt = '';
        $m_user_id = Auth::user()->emp_id;
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');

        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.sales_status', 1)
            ->get();

    @endphp
    <div class="content-header">
        <div class="container-fluid">
            @foreach ($user_company as $key => $value)
                @php
                    $company_id = $value->company_id;

                    //collection 28-transformer,33-ctpt
                    $mr_balance_transformer = DB::table("pro_money_receipt_$company_id")
                        ->where('pg_id', 28)
                        ->whereBetween('collection_date', [$start_date, $end_date])
                        ->where('status', 1)
                        ->orderBy('customer_id', 'asc')
                        ->sum('mr_amount');
                    //Debit voucher
                    $m_debit_voucher_transformer = DB::table("pro_debit_voucher_$company_id")
                        ->leftjoin(
                            "pro_money_receipt_$company_id",
                            "pro_debit_voucher_$company_id.mr_id",
                            "pro_money_receipt_$company_id.mr_id",
                        )
                        ->whereBetween("pro_debit_voucher_$company_id.debit_voucher_date", [$start_date, $end_date])
                        ->where("pro_money_receipt_$company_id.pg_id", 28)
                        ->sum('amount');
                    $collection_transformer = $mr_balance_transformer - $m_debit_voucher_transformer;
                    // $total_collection_transformer = $total_collection_transformer + $collection_transformer;

                    $mr_balance_ctpt = DB::table("pro_money_receipt_$company_id")
                        ->where('pg_id', 33)
                        ->whereBetween('collection_date', [$start_date, $end_date])
                        ->where('status', 1)
                        ->orderBy('customer_id', 'asc')
                        ->sum('mr_amount');

                    $m_debit_voucher_ctpt = DB::table("pro_debit_voucher_$company_id")
                        ->leftjoin(
                            "pro_money_receipt_$company_id",
                            "pro_debit_voucher_$company_id.mr_id",
                            "pro_money_receipt_$company_id.mr_id",
                        )
                        ->whereBetween("pro_debit_voucher_$company_id.debit_voucher_date", [$start_date, $end_date])
                        ->where("pro_money_receipt_$company_id.pg_id", 33)
                        ->sum('amount');

                    $collection_ctpt = $mr_balance_ctpt - $m_debit_voucher_ctpt;
                    // $total_collection_ctpt = $total_collection_ctpt + $collection_ctpt;

                    //sales
                    $sales_invoice_balance_transformer = DB::table("pro_sim_$company_id")
                        ->where("pro_sim_$company_id.pg_id", 28)
                        ->whereBetween("pro_sim_$company_id.sim_date", [$start_date, $end_date])
                        ->sum('total');
                    $sales_transformer_data = $total_sales_transformer - $sales_invoice_balance_transformer;
                    // $total_sales_transformer = $total_sales_transformer + $sales_transformer_data;

                    $sales_invoice_balance_ctpt = DB::table("pro_sim_$company_id")
                        ->where("pro_sim_$company_id.pg_id", 33)
                        ->whereBetween("pro_sim_$company_id.sim_date", [$start_date, $end_date])
                        ->sum('total');
                    $sales_ctpt_data = $total_sales_ctpt - $sales_invoice_balance_ctpt;
                    // $total_sales_ctpt = $total_sales_ctpt + $sales_ctpt_data;

                    //Due
                    $total_due_transformer = $sales_transformer_data - $collection_transformer;
                    $total_due_ctpt = $sales_ctpt_data - $collection_ctpt;

                @endphp

                <h5>{{ $value->company_name }}</h5>
                <div class="row">
                    <div class="col-lg-3 col-12">
                        <div class="card border-success bg-primary mb-3 custom-box-shadow animated-box"
                            style="max-hight: 10rem;">
                            <div class="card-header bg-success border-success pl-2 pt-0 pb-0 ">Sales</div>
                            <div class="card-body m-0 p-0" style="color: white;">
                                <table class="table-sm ml-2">
                                    <tbody style="font-size: 16px;">
                                        <tr style="margin: 0px; border-bottom:1px solid white;">
                                            <td>Transformer</td>
                                            <td>{{ $sales_transformer_data }} <sup style="font-size: 10px">BDT</sup></td>
                                        </tr>
                                        <tr style="margin: 0px;">
                                            <td>CTPT</td>
                                            <td>{{ $sales_ctpt_data }} <sup style="font-size: 10px">BDT</sup></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-transparent m-0 pl-2">{{ date('F Y') }} </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card border-success bg-primary mb-3 custom-box-shadow animated-box"
                            style="max-hight: 10rem;">
                            <div class="card-header bg-success border-success pl-2 pt-0 pb-0 ">Collection</div>
                            <div class="card-body m-0 p-0" style="color: white;">
                                <table class="table-sm ml-2">
                                    <tbody style="font-size: 16px;">
                                        <tr style="margin: 0px; border-bottom:1px solid white;">
                                            <td>Transformer</td>
                                            <td>{{ $collection_transformer }} <sup style="font-size: 10px">BDT</sup></td>
                                        </tr>
                                        <tr style="margin: 0px;">
                                            <td>CTPT</td>
                                            <td>{{ $collection_ctpt }} <sup style="font-size: 10px">BDT</sup></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-transparent m-0 pl-2">{{ date('F Y') }} </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card border-success bg-primary mb-3 custom-box-shadow animated-box"
                            style="max-hight: 10rem;">
                            <div class="card-header bg-success border-success pl-2 pt-0 pb-0 ">Due</div>
                            <div class="card-body m-0 p-0" style="color: white;">
                                <table class="table-sm ml-2">
                                    <tbody style="font-size: 16px;">
                                        <tr style="margin: 0px; border-bottom:1px solid white;">
                                            <td>Transformer</td>
                                            <td>{{ $total_due_transformer }} <sup style="font-size: 10px">BDT</sup></td>
                                        </tr>
                                        <tr style="margin: 0px;">
                                            <td>CTPT</td>
                                            <td>{{ $total_due_ctpt }} <sup style="font-size: 10px">BDT</sup></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-transparent m-0 pl-2">{{ date('F Y') }} </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-3 col-6">
                        <div class="card border-success bg-primary mb-3 custom-box-shadow animated-box"
                            style="max-hight: 10rem;">
                            <div class="card-header bg-success border-success pl-2 pt-0 pb-0 ">Quatation</div>
                            <div class="card-body m-0 p-0" style="color: white;">
                                <table class="table-sm ml-2">
                                    <tbody style="font-size: 16px;">
                                        <tr style="margin: 0px; border-bottom:1px solid white;">
                                            <td>Transformer</td>
                                            <td>{{ $total_quotation_transformer }} </td>
                                        </tr>
                                        <tr style="margin: 0px;">
                                            <td>CTPT</td>
                                            <td>{{ $total_quotation_ctpt }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-transparent m-0 pl-2">{{ date('F Y') }} </div>
                        </div>
                    </div> --}}
                </div>
            @endforeach

            <style>
                /* 3D shadow effect */
                .custom-box-shadow {
                    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.8),
                        0 6px 15px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                /* Hover effect: Lift up on hover */
                .custom-box-shadow:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 6px 15px rgba(255, 255, 255, 0.8),
                        0 8px 20px rgba(0, 0, 0, 0.15);
                }

                /* Animation for fade-in effect */
                .animated-box {
                    opacity: 0;
                    /* Initially invisible */
                    animation: fadeIn 1.2s ease forwards;
                    /* Fade-in animation */
                }

                /* Fade-in keyframes */
                @keyframes fadeIn {
                    0% {
                        opacity: 0;
                        transform: translateY(20px);
                        /* Start slightly below the final position */
                    }

                    100% {
                        opacity: 1;
                        transform: translateY(0);
                        /* End at the final position */
                    }
                }

                /* Delays for staggered animations */
                .col-lg-3:nth-child(1) .animated-box {
                    animation-delay: 0.2s;
                    /* Slight delay for staggered effect */
                }

                .col-lg-3:nth-child(2) .animated-box {
                    animation-delay: 0.4s;
                }

                .col-lg-3:nth-child(3) .animated-box {
                    animation-delay: 0.6s;
                }

                .col-lg-3:nth-child(4) .animated-box {
                    animation-delay: 0.8s;
                }
            </style>

        </div>
    </div>
@endsection
@section('img')
    <div class="row">
        <div class="col-12" style="position: relative">
            <img src="../../docupload/sqgroup/img/sq_group_logo_01.png"  class="" style="position: absolute; top:-124px; right:33%;" height="100px">
        </div>
        
    </div>
@endsection