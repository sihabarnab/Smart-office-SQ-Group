@extends('layouts.sales_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QUATATION DETAILS</h1>
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
                            <div class="row mb-1">
                                <div class="col-2"></div>
                                <div class="col-4">
                                    <input type="text" class="form-control" readonly value="{{ $m_quotation_master->quotation_master_id }}"
                                        id="txt_quatation_number" name="txt_quatation_number">
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" readonly value="{{ $m_quotation_master->quotation_date }}"
                                        id="txt_quatation_date" name="txt_quatation_date">
                                </div>
                                <div class="col-2"></div>

                            </div>
                            <div class="row mb-1">
                                <div class="col-4">
                                    <input type="text" class="form-control" id="txt_customer_name"
                                        name="txt_customer_name" value="{{ $m_quotation_master->customer_name}}" readonly>
                                    @error('txt_customer_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_mobile_number"
                                        name="txt_mobile_number" value="{{ $m_quotation_master->customer_mobile }}" placeholder="Mobile Number" readonly>
                                    @error('txt_mobile_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-5">
                                    <input type="text" class="form-control" id="txt_address" name="txt_address" placeholder="Address"
                                        value="{{ $m_quotation_master->customer_address }}" readonly>
                                    @error('txt_address')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="txt_subject" name="txt_subject" placeholder="Subject" readonly
                                        value="{{ $m_quotation_master->subject }}">
                                    @error('txt_subject')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reference_name"
                                        name="txt_reference_name"  value="{{ $m_quotation_master->reference }}" placeholder="Reference Name" readonly>
                                    @error('txt_reference_name')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="txt_reference_number"
                                        name="txt_reference_number" value="{{ $m_quotation_master->reference_mobile }}" placeholder="Reference Number" readonly
                                        >
                                    @error('txt_reference_number')
                                        <div class="text-warning">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $sub_total=0;
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="myForm" action="{{ route('quotation_details_final',[$m_quotation_master->quotation_id,$m_quotation_master->company_id]) }}" method="post">
                            @csrf
                        <table id="" class="table table-bordered table-striped table-sm mb-1">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Item</th>
                                    <th>Specification</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Extended Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($m_quotation_details as $key=>$row) 
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->product_name }}</td>
                                    <td>{{ $row->product_description }}</td>
                                    <td class="text-right">{{ number_format($row->qty,2) }}</td>
                                    <td class="text-right">{{ number_format($row->rate,2) }}</td>
                                    <td class="text-right">{{ number_format($row->qty*$row->rate,2)  }}</td>
                                    @php
                                          $sub_total+=$row->total;
                                    @endphp
                                </tr>
                                 @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Sub Total :</td>
                                    <td  class="text-right">
                                        <input type="hidden" name="txt_subtotal" id="txt_subtotal" value="{{ $sub_total}}">
                                    {{  number_format($sub_total,2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-2">
                                <p class="mt-1">Discount</p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_discount" name="txt_discount"
                                    value="{{ old('txt_discount') }}" placeholder="Discount">
                                @error('txt_discount')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>                                    
                        </div>                     
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-2">
                                <p class="mt-1">Transportation Cost</p>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_transportation_cost" name="txt_transportation_cost"
                                    value="{{ old('txt_transportation_cost') }}" placeholder="Transportation Cost">
                                @error('txt_transportation_cost')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>                                    
                        </div>                     
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-2">
                                <p class="mt-1">Test Fee</p>                                                                
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_test_fee" name="txt_test_fee"
                                    value="{{ old('txt_test_fee') }}" placeholder="Test Fee">
                                @error('txt_test_fee')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>                                    
                        </div>                     
                        <div class="row">
                            <div class="col-7"></div>
                            <div class="col-2">
                                <p class="mt-1">Other</p>                                                                
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="txt_other" name="txt_other"
                                    value="{{ old('txt_other') }}" placeholder="Other">
                                @error('txt_other')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>                                    
                        </div>                     
                        <div class="row">
                            <div class="col-10">
                                
                            </div>
                            <div class="col-2 d-flex flex-row">
                                <input type="checkbox" id="AYC" onclick="BTON()" name="AYC">
                                <button type="Submit" id="confirm_action" onclick="BTOFF()" class="btn btn-primary btn-block ml-2" disabled>Final</button>
                            </div>           
                        </div> 
                    </form>                     
                    </div>                  
                </div>                
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function BTON() {
            
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", false);
            } else {
                $("#confirm_action").prop("disabled", true);
            }
        }
        function BTOFF() {
            if ($('#confirm_action').prop('disabled')) {
                $("#confirm_action").prop("disabled", true);
            }else{
                $("#confirm_action").prop("disabled", true);  
            }
            document.getElementById("myForm").submit(); 
            
        }
    </script>
@endsection