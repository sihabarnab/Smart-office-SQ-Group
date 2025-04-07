<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public') }}/dist/css/adminlte.min.css">

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
                margin-top: 7%;
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
        $company = DB::table('pro_company')
            ->where('company_id', $grr_master->company_id)
            ->first();
        $company_name = $company == null ? '' : $company->company_name;
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="row mb-2">
                    <div class="col-12">
                        <div class=" pt-3" class="text-center">
                            <h2 class="text-center">{{$company_name}}</h2>
                            <h4 class="text-center">Receving Report</h4>

                        </div>
                        <div class="row ">
                            <div class="col-2"></div>
                            <div class="col-6">
                                RR No : {{ $grr_master->grr_no }} <br>
                                Challan No : {{ $grr_master->chalan_no }} <br>
                                Indent No : {{ $grr_master->indent_no }} <br>
                                LC No : {{ $grr_master->glc_no }} <br>
                                Project : {{ $grr_master->project_name }} <br>
                                Supply Name: {{ $grr_master->supplier_name }} <br>
                                Remark : {{ $grr_master->remarks }}
                            </div>
                            <div class="col-4">
                                RR Date : {{ $grr_master->grr_date }} <br>
                                Challan Date : {{ $grr_master->chalan_date }} <br>
                                Indent Date : {{ $grr_master->indent_date }} <br>
                                LC Date : {{ $grr_master->glc_date }} <br>
                                Supply Add : {{ $grr_master->supplier_address }}
                                Indent Category : {{ $grr_master->category_name }}
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-left align-top">SL No.</th>
                            <th class="text-left align-top">Product Group</th>
                            <th class="text-left align-top">Product Name</th>
                            <th class="text-left align-top">RR Qty</th>
                            <th class="text-left align-top">Unit</th>
                            <th class="text-left align-top">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pro_grr_details as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->pg_name }} <br> {{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>{{ $value->received_qty }}</td>
                                <td>
                                    @isset($value->unit_name)
                                        {{ $value->unit_name }}
                                    @endisset
                                </td>
                                <td>{{ $value->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            window.location.replace(
                "{{ route('rpt_rr_list_details', [$grr_master->grr_master_id, $grr_master->company_id]) }}");
        }, 2000);
    </script>

</body>

</html>
