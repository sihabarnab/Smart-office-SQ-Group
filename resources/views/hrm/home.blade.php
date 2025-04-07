@extends('layouts.hrm_app')

@php
    $all_company = DB::table('pro_company')->Where('valid', '1')->orderBy('company_id', 'asc')->count();
    $user_company = DB::table('pro_user_company')
        ->join('pro_company', 'pro_user_company.company_id', 'pro_company.company_id')
        ->select('pro_user_company.*', 'pro_company.company_name')
        ->Where('employee_id', Auth::user()->emp_id)
        ->count();

    $employee = DB::table('pro_employee_info')
        ->Where('valid', '1')
        ->Where('working_status', '1')
        ->where('ss', '1')
        ->count();
        
    $branch = DB::table('pro_placeofposting')->Where('valid', '1')->count();
    $m_user_id = Auth::user()->emp_id;
    $start_date = date('Y-m-01');
    $end_date = date('Y-m-t');
    $leave_application_approved = DB::table('pro_leave_info_master')
        ->Where('pro_leave_info_master.valid', '1')
        ->Where('pro_leave_info_master.status', '2')
        ->whereNotNull('pro_leave_info_master.approved_date')
        ->where('pro_leave_info_master.leave_approved', $m_user_id)
        ->whereBetween('pro_leave_info_master.entry_date', [$start_date, $end_date])
        ->count();

@endphp

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">HRM</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info animated-box"
                        style="background-image: url('{{ asset('public/image/dashboard/hrm/office-building.png') }}'); background-size: cover; background-repeat: round; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.5);">
                        <div class="overlay"></div> <!-- Black overlay -->
                        <div class="inner">
                            <h3 class="value" count="{{ $all_company }}">0</h3>
                            <p>Company</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info animated-box"
                        style="background-image: url('{{ asset('public/image/dashboard/hrm/crowd.png') }}'); background-size: cover; background-repeat: round; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.5);">
                        <div class="overlay"></div> <!-- Black overlay -->
                        <div class="inner">
                            <h3 class="value" count="{{ $employee }}">0</h3>
                            <p>Employees</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info animated-box"
                        style="background-image: url('{{ asset('public/image/dashboard/hrm/branch.png') }}'); background-size: cover; background-repeat: round; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.5);">
                        <div class="overlay"></div> <!-- Black overlay -->
                        <div class="inner">
                            <h3 class="value" count="{{ $branch }}">0</h3>
                            <p>Branches</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info animated-box"
                        style="background-image: url('{{ asset('public/image/dashboard/hrm/contract.png') }}'); background-size: cover; background-repeat: round; box-shadow: 0 4px 8px rgba(255, 255, 255, 0.5);">
                        <div class="overlay"></div> <!-- Black overlay -->
                        <div class="inner">
                            <h3 class="value" count="{{ $leave_application_approved }}">0</h3>
                            <p>Leave Application</p>
                        </div>
                    </div>
                </div>




                <style>
                    .small-box {
                        position: relative;
                    }

                    .small-box .overlay {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.588);
                        /* Black overlay with 50% opacity */
                        z-index: 1;
                        /* Make sure the overlay stays behind the text */
                    }

                    .small-box .inner {
                        position: relative;
                        z-index: 2;
                        /* Ensure the content is on top of the overlay */
                        color: #fff;
                        /* White text for contrast */
                    }

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

                <script>
                    const counters = document.querySelectorAll(".value");
                    const speed = 1000;

                    counters.forEach((counter) => {
                        const animate = () => {
                            const value = +counter.getAttribute("count");
                            const data = +counter.innerText;

                            const time = value / speed;
                            if (data < value) {
                                counter.innerText = Math.ceil(data + time);
                                setTimeout(animate, 1);
                            } else {
                                counter.innerText = value;
                            }
                        };

                        animate();
                    });
                </script>


            </div>
        </div>
    @endsection
    @section('img')
        <div class="row">
            <div class="col-12 ." style="position: relative">
                <img src="../../docupload/sqgroup/img/sq_group_logo_01.png" class=""
                    style="position: absolute; top:-124px; right:33%;" height="100px">
            </div>

        </div>
    @endsection
