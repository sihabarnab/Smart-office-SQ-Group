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
     $company = DB::table('pro_company')->where('company_id',$gm_return_master->company_id)->first();
       $company_name=  $company == null ? '' : $company->company_name;
@endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12" >
                {{-- <a href="{{ route('rpt_return_print',$gm_return_master->return_master_no) }}" class=" btn btn-info float-right mr-5 mt-4"> Print </a> --}}

                <div class="row mb-2">
                    <div class="col-12">
                        <div class=" pt-3" class="text-center">
                            <h2 class="text-center">{{  $company_name}}</h2>
                            <h4 class="text-center">Return Report</h4>
                            
                        </div>
                        <div class="row ">
                            <div class="col-2"></div>
                            <div class="col-6">
                                Return No : {{ $gm_return_master->return_master_no }} <br>
                                Voucher No : {{ $gm_return_master->voucher_no }} <br>
                                Remark : {{ $gm_return_master->remarks }}
                            </div>
                            <div class="col-4">
                                Return Date : {{ $gm_return_master->return_date }} <br>
                                Project : {{ $gm_return_master->project_name }} <br>
                                Section : {{ $gm_return_master->section_name }} <br>
                            </div>
                        </div>
                    </div>
                </div>

                <table  class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-left align-top">SL No.</th>
                            <th class="text-left align-top">Product Group</th>
                            <th class="text-left align-top">Product Name</th>
                            <th class="text-left align-top">Unit</th>
                            <th class="text-left align-top">Usable Qty</th>
                            <th class="text-left align-top">Damage Qty</th>
                            <th class="text-left align-top">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gm_return_details as $key => $value)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value->pg_name }} <br> {{ $value->pg_sub_name }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>
                                    @isset($value->unit_name)
                                        {{ $value->unit_name }}
                                    @endisset
                                </td>
                                <td>{{ $value->useable_qty }}</td>
                                <td>{{ $value->damage_qty }}</td>
                                <td>{{ $value->comments }}</td>
                                  
                               
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
            window.location.replace("{{ route('rpt_return_details',[$gm_return_master->return_master_no,$gm_return_master->company_id]) }}");
        }, 2000);
    </script>

</body>

</html>
