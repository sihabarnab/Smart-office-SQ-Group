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

      @php
        $m_company = DB::table('pro_company')
            ->where('company_id', $m_quotation_master->company_id)
            ->where('valid', 1)
            ->first();

        $image_url = "../../../../docupload/sqgroup/company_logo/$m_company->logo";

        @endphp

    <div class="m-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="row">
                        <div class="col-12">
                            @if (isset($m_company->logo))
                               <img class="mx-auto d-block" src="{{ $image_url }}" width="100"  height="100" />
                            @else
                                <img class="mx-auto d-block" src="" alt="" height="80px"
                                    width="80px">
                            @endif
                        </div>

                        <div class="col-12 text-center">
                            <h3>{{ $m_company->company_name }}</h3>
                            <h6>Corporate Office : {{ $m_company->company_add }}</h6>
                            @isset($m_company->company_cell)
                                <h6>Cell: {{ $m_company->company_cell }}</h6>
                            @endisset
                            <h6>Factory : Bhabanipur, Gazipur</h6>
                            @isset($m_company->company_cell2)
                                <h6>Cell: {{ $m_company->company_cell2 }}</h6>
                            @endisset
                        </div>
                    </div>



                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="row" id="qd">
                                <div class="col-2">
                                    <p class="m-0">Quotation Number</p>
                                    <p class="m-0">Reference Name</p>
                                </div>
                                <div class="col-6">
                                    <p class="m-0">
                                        <span>:&nbsp;</span>{{ $m_quotation_master->quotation_master_id }}
                                    </p>
                                    <p class="m-0"> <span>:&nbsp;</span> {{ $m_quotation_master->reference }}</p>
                                </div>
                                <div class="col-2">
                                    <p class="m-0">Quotation Date</p>
                                    <p class="m-0">Reference Mobile</p>
                                </div>
                                <div class="col-2 ">
                                    <p class="m-0"><span>:&nbsp;</span> {{ $m_quotation_master->quotation_date }}</p>
                                    <p class="m-0"><span>:&nbsp;</span> {{ $m_quotation_master->reference_mobile }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 mb-2" id="qd">
                        To <br>
                        {{ $m_quotation_master->customer_name }} <br>
                        {{ $m_quotation_master->customer_address }} <br>
                        {{ $m_quotation_master->customer_mobile }}

                    </div>
                    <div class="row mb-2">
                        <div class="col-2">
                            <strong>Subject</strong>
                        </div>
                        <div class="col-10">
                            <strong>: {{ $m_quotation_master->subject }}</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            Dear Sir/Madam, <br>
                            Please refer to your subsequence discussion. We would like to quote you the following prices
                            against your query.
                        </div>
                    </div>

                    <table id="ta" class="table table-bordered m-0 ">
                        <thead>
                            <tr>
                                <th>SL No.</th>
                                <th>Description</th>
                                <th>Specification</th>
                                <th>Qty</th>
                                <th >Unit Price</th>
                                <th >Extended Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sub_total = 0;
                            @endphp
                            @foreach ($m_quotation_details as $key => $row)
                                @php
                                    $sub_total += $row->total;
                                    $unit = number_format($row->rate, 2);
                                    $extended = number_format($row->qty * $row->rate, 2);
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->product_description }}</td>
                                    <td class="text-right">{{ number_format($row->qty,2) }}</td>
                                    <td class="text-right">{{ $unit }}</td>
                                    <td class="text-right">{{ $extended }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right font-weight-bold">Sub Total:</td>
                                <td class="text-right font-weight-bold ">
                                    @php
                                        $sub_total_new = number_format($sub_total, 2);
                                    @endphp
                                    {{ $sub_total_new }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-4 font-weight-bold text-right">
                            Discount <br>
                            Trnsportation Cost <br>
                            Test Fee <br>
                            Other
                        </div>
                        <div class="col-2 font-weight-bold text-right">
                            @php
                                $discount = number_format($m_quotation_master->discount_amount, 2);
                                $transport_cost = number_format($m_quotation_master->transport_cost, 2);
                                $test_fee = number_format($m_quotation_master->test_fee, 2);
                                $other_expense = number_format($m_quotation_master->other_expense, 2);
                                $quotation_total = number_format($m_quotation_master->quotation_total, 2);
                            @endphp
                            {{ $discount ? $discount : '0.00' }} <br>
                            {{ $transport_cost ? $transport_cost : '0.00' }} <br>
                            {{ $test_fee ? $test_fee : '0.00' }} <br>
                            {{ $other_expense ? $other_expense : '0.00' }}
                        </div>
                    </div>


                    <div class="row text-right border">
                        <div class="col-8"></div>
                        <div class="col-2 font-weight-bold">
                            Grand Total
                        </div>
                        <div class="col-2 font-weight-bold border">
                            {{ $quotation_total }}
                        </div>
                    </div>
                    <div class="row border font-weight-bold mb-2">
                        <div class="col-12">
                            @php
                                $quotation_total_word = convert_number($m_quotation_master->quotation_total);
                            @endphp
                            In Words : <strong> {{ $quotation_total_word }} Only</strong>
                        </div>
                    </div>

                    @if ($m_company->short_code == 'TSTL')
                        <div class="row mb-2">
                            <div class="col-7">
                                <h6 class="text-center font-weight-bold">Special Notes &amp; Instruction</h6>

                                <div class="row border " style="font-size: smaller;">
                                      <ol>
                                            <li>Transformers &amp; CTPT will be delivered as per BREB/PDB/DPDC/DESCO
                                                specifications
                                                and it will be collected from our factory</li>
                                            <li>100% payment will be made along with the supply order</li>
                                            <li>Payment will made through cash/DD/PO in favor of "TS TRANSFORMERS
                                                LTD"</li>
                                            <li>One year warranty for CTPT &amp; 3 phase DT and 3 years warranty for
                                                single
                                                phase DT
                                                for any manufacturing defect from the date of selling.</li>
                                            <li>Price including VAT, Excluding AIT.</li>
                                        </ol>
                                </div>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-4">
                                <h6 class="text-center font-weight-bold">Bank Information</h6>
                                <div class="row border pl-4" style="font-size: smaller;">
                                    <p>TS TRANSFORMERS LTD. <br> DUTCH BANGLA BANK LTD., BANANI BR. <br> AC NO. :
                                        103.110.20833 Routing : 090260434</p>
                                    <p>TS TRANSFORMERS LTD. <br> PRIME BANK LTD., MOHAKHALI BR. <br> AC NO. :
                                        11011010000501 Routing : 170263193
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">Thanking You for your business <br>
                                If you have any quiries about this quotation please feel free to contact with us.</p>
                        </div>
                    </div>

                       <div class="row">
                                    <div class="col-6">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', Auth::user()->emp_id)
                                                ->first();
                                          if(isset($employee_info)) {
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $employee_info->desig_id)
                                                ->first();
                                            }else{
                                                $desig =[];
                                            } 
                                            
                                        @endphp
                                        For, <strong>{{ $m_company->company_name }}</strong> <br>
                                        Print By, <br>
                                        @isset($employee_info)
                                            {{ $employee_info->employee_name }} <br>
                                        @endisset
                                        @isset($desig)
                                            {{ $desig->desig_name }}
                                        @endisset
                                    </div> 
                                     <div class="col-6 text-right">
                                        @php
                                            $employee_info = DB::table('pro_employee_info')
                                                ->where('employee_id', $m_quotation_master->user_id)
                                                ->first();
                                          if($employee_info) {
                                            $desig = DB::table('pro_desig')
                                                ->where('desig_id', $employee_info->desig_id)
                                                ->first();
                                                $desig_name=$desig->desig_name;
                                                 $employee_name=$employee_info->employee_name;
                                            }else{
                                                $employee_name='';
                                                $desig_name = '';
                                            }  
                                            
                                        @endphp
                                        For, <strong>{{ $m_company->company_name }}</strong> <br>
                                        Prepared By <br>
                                       {{$employee_name}} <br>
                                       {{$desig_name}}
                                    </div>

                                    {{-- {{$gate_pass->user_id}} --}}
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
            window.location.replace("{{ route('rpt_quotation_view',[$m_quotation_master->quotation_id,$m_quotation_master->company_id]) }}");
        }, 2000);
    </script>
</body>

</html>

@php
    
    //Number Formate
    function numberFormat($number, $decimals = 0)
    {
        // desimal (.) dat part
        if (strpos($number, '.') != null) {
            $decimalNumbers = substr($number, strpos($number, '.'));
            $decimalNumbers = str_pad(substr($decimalNumbers, 1, $decimals),2,'0',STR_PAD_RIGHT);
        } else {
            $decimalNumbers = 0;
            for ($i = 2; $i <= $decimals; $i++) {
                $decimalNumbers = $decimalNumbers . '0';
            }
        }
        // echo $decimalNumbers;
        $number = (int) $number;
        // reverse
        $number = strrev($number);
        $n = '';
        $stringlength = strlen($number);
        for ($i = 0; $i < $stringlength; $i++) {
            if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
                $n = $n . $number[$i] . ',';
            } else {
                $n = $n . $number[$i];
            }
        }
        $number = $n;
        // reverse
        $number = strrev($number);
        $decimals != 0 ? ($number = $number . '.' . $decimalNumbers) : $number;
        return $number;
    }
    
    //Number to word BD Taka
    function convert_number($number)
    {
        $my_number = $number;
    
        if ($number < 0 || $number > 999999999) {
            throw new Exception('Number is out of range');
        }
        $Kt = floor($number / 10000000); /* Koti */
        $number -= $Kt * 10000000;
        $Gn = floor($number / 100000); /* lakh  */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000); /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100); /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10); /* Tens (deca) */
        $n = $number % 10; /* Ones */
    
        $res = '';
    
        if ($Kt) {
            $res .= convert_number($Kt) . ' Koti ';
        }
        if ($Gn) {
            $res .= convert_number($Gn) . ' Lakh';
        }
    
        if ($kn) {
            $res .= (empty($res) ? '' : ' ') . convert_number($kn) . ' Thousand';
        }
    
        if ($Hn) {
            $res .= (empty($res) ? '' : ' ') . convert_number($Hn) . ' Hundred';
        }
    
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eightteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Fourty', 'Fifty', 'Sixty', 'Seventy', 'Eigthy', 'Ninety'];
    
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= ' and ';
            }
    
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
    
                if ($n) {
                    $res .= '-' . $ones[$n];
                }
            }
        }
    
        if (empty($res)) {
            $res = 'zero';
        }
    
        return $res;
    }
@endphp
