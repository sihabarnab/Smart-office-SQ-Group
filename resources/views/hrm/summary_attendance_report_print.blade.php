<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">
    <title>Summery Attendance</title>
    <style>
        @media print {
            .noPrint {
                display: none;
            }

            header,
            footer {
                display: none;
            }

            @page {
                size: auto;
                
            }


            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */
        }
    </style>

</head>

<body>

@php
   $txt_company_name = $data['company_name'];
   $txt_year = $data['year'];
   $month_name = $data['month_name'];
   $txt_placeofposting_name = $data['txt_placeofposting_name'];
@endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row m-4">
                            <div class="col-12">

                                <h3 class="text-center">{{ $txt_company_name }} <br>
                                    {{$txt_placeofposting_name}} <br>
                                    {{ $month_name}}, {{ $txt_year }}</h3>

                                <table class="table table-border table-striped table-sm mt-2">
                                    <thead>
                                        
                                        <tr>
                                            <th>SL</th>
                                            <th>ID<br>Name/Desig.</th>
                                            <th>Department<br>Posting/PSM</th>
                                            <th>W.Day</th>
                                            <th>Weekly</th>
                                            <th>Holiday</th>
                                            <th>Leave</th>
                                            <th>Present</th>
                                            <th>Absent</th>
                                            <th>Late</th>
                                            <th>E.Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ci_summ_attn_report as $key=>$row)
                                        @php
            
                                        // $txt_joinning_date=date("d-m-Y",strtotime("$row->joinning_date"));
            
                                        $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$row->placeofposting_id)->first();
                                        $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;
            
            
                                        @endphp
                                        
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $row->employee_id }}<BR>{{ $row->employee_name }}<BR>{{ $row->desig_name }}</td>
                                            <td>{{ $row->department_name }}<BR>{{ $txt_placeofposting_name }}<BR>{{ $row->psm_id }}</td>
                                            <td align="center">{{ $row->working_day }}</td>
                                            <td align="center">{{ $row->weekend }}</td>
                                            <td align="center">{{ $row->holiday }}</td>
                                            <td align="center">{{ $row->total_leave }}</td>
                                            <td align="center">{{ $row->present }}</td>
                                            <td align="center">{{ $row->absent }}</td>
                                            <td align="center">{{ $row->late }}</td>
                                            <td align="center">{{ $row->early_out }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table> {{-- end table --}}

                            </div>  {{-- end col 12 --}}
                        </div>
                        {{-- end row m-4 --}}


                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- AdminLTE App -->
    <script src="{{ asset('public') }}/dist/js/adminlte.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
        setTimeout(function() {
            window.history.back()
        }, 2000);
    </script>

</body>

</html>
