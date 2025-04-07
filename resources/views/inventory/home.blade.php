@extends('layouts.inventory_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inventory </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @php
        $total_rr = 0;
        $total_requisition = 0;
        $total_issue = 0;
        $total_return = 0;
        $m_user_id = Auth::user()->emp_id;
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $user_company = DB::table('pro_user_company')
            ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
            ->select('pro_user_company.*', 'pro_company.company_name')
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.inventory_status', 1)
            ->get();

        foreach ($user_company as $key => $value) {
            $company_id = $value->company_id;
            //rr
            $rr_data = DB::table("pro_grr_master_$company_id")
                ->where("pro_grr_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_grr_master_$company_id.entry_date", [$start_date, $end_date])
                ->where("pro_grr_master_$company_id.status", 2)
                ->count();
            $total_rr = $total_rr + $rr_data;

            //requistion
            $requistion_data = DB::table("pro_gmaterial_requsition_master_$company_id")
                ->where("pro_gmaterial_requsition_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_gmaterial_requsition_master_$company_id.entry_date", [$start_date, $end_date])
                ->where("pro_gmaterial_requsition_master_$company_id.status", 3)
                ->count();

            $total_requisition = $total_requisition + $requistion_data;

            //issue
            $issue_data = DB::table("pro_graw_issue_master_$company_id")
                ->where("pro_graw_issue_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_graw_issue_master_$company_id.entry_date", [$start_date, $end_date])
                ->where("pro_graw_issue_master_$company_id.status", 2)
                ->orderBy("pro_graw_issue_master_$company_id.rim_no", 'desc')
                ->count();
            $total_issue = $total_issue + $issue_data;

            //return
            $return_data = DB::table("pro_gmaterial_return_master_$company_id")
                ->where("pro_gmaterial_return_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_gmaterial_return_master_$company_id.entry_date", [$start_date, $end_date])
                ->where("pro_gmaterial_return_master_$company_id.status", 2)
                ->count();
            $total_return = $total_return + $return_data;
        }
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info custom-box-shadow animated-box">
                        <div class="inner">
                            <h4>RR: {{ $total_rr}} </h4>
                            <p class="current-month-year"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info custom-box-shadow animated-box">
                        <div class="inner">
                            <h4>Requisition: {{ $total_requisition }}</h4>
                            <p class="current-month-year"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info custom-box-shadow animated-box">
                        <div class="inner">
                            <h4>Issue: {{ $total_issue }}</h4>
                            <p class="current-month-year"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info custom-box-shadow animated-box">
                        <div class="inner">
                            <h4>Return: {{ $total_return }}</h4>
                            <p class="current-month-year"></p>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                /* 3D shadow effect */
                .custom-box-shadow {
                    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.8),
                        0 6px 15px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                    padding: 20px;
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

    <script>
        // JavaScript to get the current month and year and display them
        var months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        var now = new Date(); // Get the current date
        var currentMonth = months[now.getMonth()]; // Get the current month name
        var currentYear = now.getFullYear(); // Get the current year

        // Combine month and year
        var monthYear = currentMonth + " " + currentYear;

        // Select all elements with the class "current-month-year"
        var monthYearElements = document.querySelectorAll(".current-month-year");

        // Loop through each element and set its text content to the current month and year
        monthYearElements.forEach(function(element) {
            element.textContent = monthYear;
        });
    </script>
@endsection


@section('img')
    <div class="row">
        <div class="col-12" style="position: relative">
            <img src="../../docupload/sqgroup/img/sq_group_logo_01.png" class=""
                style="position: absolute; top:-124px; right:33%;" height="100px">
        </div>

    </div>
@endsection
