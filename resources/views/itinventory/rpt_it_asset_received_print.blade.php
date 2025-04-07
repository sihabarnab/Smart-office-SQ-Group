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
        <div class="row m-5">
            <div class="col-12">

                <div class="row">
                    <div class="col-12">
                        <div class=" pt-3">
                            <h1 class="text-center">SQ GROUP</h1>
                            <p class="text-center">Suvastu Sursiys Trade Center, House #57, Kamal Ataturk Avenue,
                                Block-B, Banani, Dhaka-1213</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class=" text-center">
                                    <h2 class="text-center">Received document</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        DATE: {{ $m_itasset_receiving_master->entry_date }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div>NAME: {{ $m_itasset_receiving_master->employee_name }}
                            ({{ $m_itasset_receiving_master->employee_id }})</div>
                        <div>DESIGNATION:
                            {{ $m_itasset_receiving_master->desig_name }},{{ $m_itasset_receiving_master->department_name }}
                        </div>
                        <div>MOBILE NUMBER: {{ $m_itasset_receiving_master->mobile }}</div>
                        <div>COMPANY NAME: {{ $m_itasset_receiving_master->company_name }}</div>
                    </div>
                </div>

                <div class="mt-4">
                    IT IS ACKNOWLEDGE THAT I RECEIVED BELOW MENTION ITEM WITH GOOD CONDITION AND TECHINICIAN INSTALL
                    CORRECTLY. IT IS WORK AND OPERATE FULL FUNCTIONAL.
                </div>


                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>SERIAL</th>
                            <th>DESCRIPTION</th>
                            <th>QTY</th>


                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($m_itasset_receving_details as $value)
                        <tr>
                            <td>  {{$value->itasset_id}} </td>
                            <td>{{ $value->product_type_name }} | {{ $value->brand_name }} | {{ $value->model }}</td>
                            <td>{{ $value->itasset_qty }}</td>
                        </tr>
                    @endforeach

                    
                    </tbody>
                </table>




                <div class="row mt-5">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <p> ------------------------------------ <br> SIGNATURE AND DATE <br> IT DEPARTMENT </p>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-4">
                        <p> ------------------------------------ <br> SIGNATURE AND DATE <br> RECEIVED PERSON </p>
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
