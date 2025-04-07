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

            header
             {
                display: none;
            }

            @page {
                size: auto;
                margin-top: 7%;
                margin-bottom: 7%;
            }


            /* @page {
                size: A4;
                margin: 11mm 17mm 17mm 17mm;
            } */


        }
    </style>

</head>

<body>


    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-12">
                        <div class=" pt-3" style="text-align: center;">
                            <h2 style="text-transform: uppercase;">indent</h2>
                            {{-- <h3>Transformer</h3> --}}
                        </div>
                        <div class="row ">
                            <div class="col-2"></div>
                            <div class="col-6">
                                Indent No : {{ $pro_indent_master->indent_no }} <br>
                                Project : {{ $pro_indent_master->project_name }}
                            </div>
                            <div class="col-4">
                                Indent Date : {{ $pro_indent_master->entry_date }} <br>
                                Indent Category : {{ $pro_indent_master->category_name }}
                            </div>
                        </div>
                    </div>
                </div>

                <table id="ta" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Group|Sub Group</th>
                            <th>Product Name |Description</th>
                            <th>Section</th>
                            <th>Indent Qty</th>
                            <th>Approved Qty</th>
                            <th>RR Qty</th>
                            <th>Unit</th>
                            <th>Remarks</th>
                            <th>Product Require Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pro_indent_detail_all as $key => $value)

                            @php
                                $ci_grr_details  = DB::table("pro_grr_details_$value->company_id")
                                ->where("product_id",$value->product_id)
                                ->where("indent_no",$value->indent_no)
                                ->sum('received_qty');

                                if ($ci_grr_details === NULL)
                                {
                                    $txt_rr_qty="0.0000";
                                } else {
                                    $txt1_rr_qty="$ci_grr_details";
                                    $txt_rr_qty=number_format($txt1_rr_qty,4);
                                }

                            @endphp


                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->pg_name }} <hr class="m-0" color='white'> {{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}<hr class="m-0" color='white'>{{ $value->description }}</td>
                                <td>{{ $value->section_name }}</td>
                                <td>{{ $value->qty }}</td>
                                <td>{{ $value->approved_qty }}</td>
                                <td>{{ $txt_rr_qty }}</td>
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
                                <td class="text-left align-top">{{ $value->remarks }}</td>
                                <td class="text-left align-top">{{ $value->req_date }}</td>
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
            window.location.replace("{{ route('purchase_indent_view',[$pro_indent_master->indent_id,$pro_indent_master->company_id]) }}");
        }, 2000);
    </script>

</body>

</html>
