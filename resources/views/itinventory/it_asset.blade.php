@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Information</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@if(isset($m_itasset))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="{{ route('it_assetupdate',$m_itasset->itasset_id) }}" >
            @csrf
            {{-- {{method_field('patch')}} --}}
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_company_id" id="sele_company_id" class="form-control">
                  <option value="0">--Company--</option>
                    @foreach($m_pro_company as $row_company)
                      <option value="{{$row_company->company_id}}"  {{$row_company->company_id == $m_itasset->company_id? 'selected':''}}>
                          {{$row_company->company_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_company_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_supplier_id" id="sele_supplier_id" class="form-control">
                  <option value="0">--Supplier--</option>
                    @foreach($m_suppliers as $row_suppliers)
                      <option value="{{$row_suppliers->supplier_id}}"  {{$row_suppliers->supplier_id == $m_itasset->supplier_id? 'selected':''}}>
                          {{$row_suppliers->supplier_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_supplier_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_sinv_no" name="txt_sinv_no" placeholder="Invoice Number." value="{{ $m_itasset->sinv_no }}">
                  @error('txt_sinv_no')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_sinv_date" name="txt_sinv_date" placeholder="Invoice Date" value="{{ $m_itasset->sinv_date }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                @error('txt_sinv_date')
                  <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_product_type_id" id="sele_product_type_id" class="form-control">
                  <option value="0">--Product Type--</option>
                    @foreach($m_product_type as $row_product_type)
                      <option value="{{$row_product_type->product_type_id}}"  {{$row_product_type->product_type_id == $m_itasset->product_type_id? 'selected':''}}>
                          {{$row_product_type->product_type_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_product_type_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_brand_id" id="sele_brand_id" class="form-control">
                  <option value="0">--Brand--</option>
                    @foreach($m_brand as $row_brand)
                      <option value="{{$row_brand->brand_id}}"  {{$row_brand->brand_id == $m_itasset->brand_id? 'selected':''}}>
                          {{$row_brand->brand_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_brand_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_model" name="txt_model" placeholder="Model." value="{{ $m_itasset->model }}">
                  @error('txt_model')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_processor_id" id="sele_processor_id" class="form-control">
                  <option value="0">--Processor--</option>
                    @foreach($m_processor as $row_processor)
                      <option value="{{$row_processor->processor_id}}"  {{$row_processor->processor_id == $m_itasset->processor_id? 'selected':''}}>
                          {{$row_processor->processor_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_processor_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_ram" name="txt_ram" placeholder="RAM" value="{{ $m_itasset->ram }}">
                  @error('txt_ram')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_hdd" name="txt_hdd" placeholder="HDD" value="{{ $m_itasset->hdd }}">
                  @error('txt_hdd')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_ssd" name="txt_ssd" placeholder="SSD." value="{{ $m_itasset->ssd }}">
                  @error('txt_ssd')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_display" name="txt_display" placeholder="Display." value="{{ $m_itasset->display }}">
                  @error('txt_display')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_serial" name="txt_serial" placeholder="Serial Number" value="{{ $m_itasset->serial }}">
                  @error('txt_serial')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_yesno_id" id="sele_yesno_id" class="form-control">
                  <option value="0">--Processor--</option>
                    @foreach($m_yesno as $row_yesno)
                      <option value="{{$row_yesno->yesno_id}}"  {{$row_yesno->yesno_id == $m_itasset->warranty? 'selected':''}}>
                          {{$row_yesno->yesno_name}}
                      </option>
                    @endforeach
                </select>
                  @error('sele_yesno_id')
                   <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_warranty_year" name="txt_warranty_year" placeholder="Warranty" value="{{ $m_itasset->warranty_year }}">
                  @error('txt_warranty_year')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_amount" name="txt_amount" placeholder="Tk." value="{{ $m_itasset->amount }}">
                  @error('txt_amount')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-9">
                <input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Remarks" value="{{ $m_itasset->remarks }}">
                  @error('txt_remarks')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-1">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Update</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="{{ route('itasset_store') }}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                  <select name="sele_company_id" id="sele_company_id" class="form-control">
                    <option value="0">--Company--</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->company_id }}">
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('sele_company_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <select name="sele_supplier_id" id="sele_supplier_id" class="form-control">
                    <option value="0">--Supplier--</option>
                    @foreach ($m_suppliers as $row_suppliers)
                        <option value="{{ $row_suppliers->supplier_id }}">
                            {{ $row_suppliers->supplier_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('sele_supplier_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_sinv_no" name="txt_sinv_no" placeholder="Invoice Number." value="{{ old('txt_sinv_no') }}">
                  @error('txt_sinv_no')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_sinv_date" name="txt_sinv_date" placeholder="Invoice Date" value="{{ old('txt_sinv_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_sinv_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                  <select name="sele_product_type_id" id="sele_product_type_id" class="form-control">
                    <option value="0">--Product Type--</option>
                    @foreach ($m_product_type as $row_product_type)
                        <option value="{{ $row_product_type->product_type_id }}">
                            {{ $row_product_type->product_type_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('sele_product_type_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <select name="sele_brand_id" id="sele_brand_id" class="form-control">
                    <option value="0">--Brand--</option>
                    @foreach ($m_brand as $row_brand)
                        <option value="{{ $row_brand->brand_id }}">
                            {{ $row_brand->brand_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('sele_brand_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_model" name="txt_model" placeholder="Model" value="{{ old('txt_model') }}">
                  @error('txt_model')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <select name="sele_processor_id" id="sele_processor_id" class="form-control">
                    <option value="0">--Processor--</option>
                    @foreach ($m_processor as $row_processor)
                        <option value="{{ $row_processor->processor_id }}">
                            {{ $row_processor->processor_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('sele_processor_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_ram" name="txt_ram" placeholder="RAM" value="{{ old('txt_ram') }}">
                  @error('txt_ram')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_hdd" name="txt_hdd" placeholder="HDD" value="{{ old('txt_hdd') }}">
                  @error('txt_hdd')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_ssd" name="txt_ssd" placeholder="SSD" value="{{ old('txt_model') }}">
                  @error('txt_ssd')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_display" name="txt_display" placeholder="Display" value="{{ old('txt_display') }}">
                  @error('txt_display')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_serial" name="txt_serial" placeholder="Serial Number." value="{{ old('txt_serial') }}">
                  @error('txt_serial')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_yesno_id" id="sele_yesno_id" class="from-control custom-select">
                    @php
                      $ci1_pro_yesno=DB::table('pro_yesno')->Where('yesno_id',old('sele_yesno_id'))->orderBy('yesno_name','asc')->get();
                    @endphp

                    @foreach($ci1_pro_yesno as $r_ci1_pro_yesno)
                    <option value="{{ $r_ci1_pro_yesno->yesno_id }}">{{ $r_ci1_pro_yesno->yesno_name }}</option>
                    @endforeach  

                  <option value="0">Select Warranty</option>
                    @php
                      $ci_pro_yesno=DB::table('pro_yesno')->Where('valid','1')->orderBy('yesno_name', 'asc')->get();
                    @endphp
                    @foreach($ci_pro_yesno as $r_ci_pro_yesno)
                    <option value="{{ $r_ci_pro_yesno->yesno_id }}">{{ $r_ci_pro_yesno->yesno_name }}</option>
                    @endforeach    
                </select>
                  @error('sele_yesno_id')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_warranty_year" name="txt_warranty_year" placeholder="Warranty Year." value="{{ old('txt_warranty_year') }}">
                  @error('txt_warranty_year')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_amount" name="txt_amount" placeholder="Tk." value="{{ old('txt_amount') }}">
                  @error('txt_amount')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-9">
                <input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Remarks" value="{{ old('txt_remarks') }}">
                  @error('txt_remarks')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-1">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Submit</button>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@include('/itinventory/it_asset_list')
&nbsp;
@endif
@endsection
@section('script')

<script>
    window.onload = function() {
        var k=1;
        $.ajax({
            url: "{{ url('/get/it_asset_info') }}/",
            type: "GET",
            dataType: "json",
            success: function(data) {
              // console.log(data);
                $('#it_asset_info').dataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": true,
                    dom: 'Blfrtip',
                    buttons: [{
                            extend: 'csvHtml5',
                            title: 'IT Asset Information'
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'IT Asset Information'
                            // orientation: 'landscape',
                            // pageSize: 'LEGAL'
                        },
                        {
                            extend: 'print',
                            title: 'IT Asset Information',
                            autoPrint: true,
                            exportOptions: {
                                columns: ':visible'
                            },
                        },
                        'colvis',
                    ],


                    "aaData": data,
                    "columns": [{
                              data: null,
                              render: function(data, type, full) {
                                return k++; 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.company_name+'<br>'+data.itasset_id; 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.supplier_name+'<br>'+data.sinv_no+'<br>'+data.sinv_date; 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return data.product_type_name+' '+data.brand_name+' '+data.model+'<br>'+(data.processor_name==null?'':data.processor_name)+' '+(data.ram==null?'':data.ram)+' '+(data.hdd==null?'':data.hdd)+' '+(data.ssd==null?'':data.ssd)+'<br>'+(data.display==null?'':data.display); 
                                }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return (data.serial==null?'':data.serial)+'<br>'+(data.warranty_year==null?'':data.warranty_year+' '+'year'); 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                                return (data.remarks==null?'':data.remarks); 
                            }
                        },
                        {
                            data: null,
                              render: function(data, type, full) {

                            var yy=data.amount;
                            var yyy=yy.toLocaleString('hi-IN',{style: 'decimal', minimumFractionDigits:2});
                                return yyy; 

                            }
                        },
                        {
                            data: null,
                            render: function(data, type,full) {
                                return '<a href="{{ url("/")}}/itinventory/it_asset/edit/'+data.itasset_id+'" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>'; 
                            }
                        },
                    ]
                }) // end dataTable

            },  // End Sucess
        });  // end Ajax

    } // end Windows onload
</script>


    
@endsection
