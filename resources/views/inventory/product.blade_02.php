@extends('layouts.inventory_app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <section class="content">
    <div class="container-fluid">
  @include('flash-message')
</div>
    @if(isset($m_product))
    <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
          <form method="post" action="{{ route('inventoryproductupdate',$m_product->product_id) }}">
            @csrf
            <div align="center" class="">
              <div class="row mb-2">
                <div class="col-2">
                  <input type="hidden" class="form-control" id="txt_product_id" name="txt_product_id" value="{{ $m_product->product_id }}">
 
                  <select name="cbo_product_cat_id" id="cbo_product_cat_id" class="form-control">
                    <option value="0">Product Category</option>
                      @foreach($pro_cat as $row_pro_cat)
                        <option value="{{$row_pro_cat->product_cat_id}}"  {{$row_pro_cat->product_cat_id == $m_product->product_category? 'selected':''}}>
                            {{$row_pro_cat->product_category_name}}
                        </option>
                      @endforeach
                  </select>
                    @error('cbo_product_cat_id')
                     <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>                

                <div class="col-3">
                  <select name="cbo_pg_id" id="cbo_pg_id" class="form-control">
                    <option value="0">Product Group</option>
                      @foreach($m_product_group as $row_product_group)
                        <option value="{{$row_product_group->pg_id}}"  {{$row_product_group->pg_id == $m_product->pg_id? 'selected':''}}>
                            {{$row_product_group->pg_name}}
                        </option>
                      @endforeach
                  </select>
                    @error('cbo_pg_id')
                     <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>                
                <div class="col-3">
                  <select name="cbo_pg_sub_id" id="cbo_pg_sub_id" class="form-control">
                    @php
                         $m_product1 = DB::table('pro_product_sub_group')
                         ->where('pg_sub_id', $m_product->pg_sub_id)
                         ->first()
                    @endphp
                    @if ($m_product1)
                    <option value="{{ $m_product1->pg_sub_id }}">
                        {{ $m_product1->pg_sub_name }}
                        </option>
                    @else
                    <option value="0">Product Sub Group</option>
                    @endif
                  </select>
                  @error('cbo_pg_sub_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="txt_product_name" name="txt_product_name" placeholder="Product Name" value="{{ $m_product->product_name }}">
                    @error('txt_product_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_brand_name" name="txt_brand_name" placeholder="Brand Name" value="{{ $m_product->brand_name }}">
                    @error('txt_brand_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_model_size" name="txt_model_size" placeholder="Size / Model" value="{{ $m_product->model_size }}">
                    @error('txt_model_size')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" id="txt_product_description" name="txt_product_description" placeholder="Product Description" value="{{ $m_product->product_description }}">
                    @error('txt_product_description')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-3">
                  <select name="cbo_unit_id" id="cbo_unit_id" class="form-control">
                    <option value="0">Product Unit</option>
                      @foreach($m_unit as $row_unit)
                        <option value="{{$row_unit->unit_id}}"  {{$row_unit->unit_id == $m_product->unit? 'selected':''}}>
                            {{$row_unit->unit_name}}
                        </option>
                      @endforeach
                  </select>
                    @error('cbo_unit_id')
                     <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_reorder_qty" name="txt_reorder_qty" placeholder="Reorder Qty" value="{{ $m_product->reorder_qty }}">
                    @error('txt_reorder_qty')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_discount" id="cbo_discount" class="form-control">
                    <option value="0">Discount</option>
                      @foreach($m_yesno as $row_discount)
                        <option value="{{$row_discount->yesno_id}}"  {{$row_discount->yesno_id == $m_product->get_discount? 'selected':''}}>
                            {{$row_discount->yesno_name}}
                        </option>
                      @endforeach
                  </select>
                    @error('cbo_discount')
                     <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_warrenty" id="cbo_warrenty" class="form-control">
                    <option value="0">Warrenty</option>
                      @foreach($m_yesno as $row_warrenty)
                        <option value="{{$row_warrenty->yesno_id}}"  {{$row_warrenty->yesno_id == $m_product->warrenty? 'selected':''}}>
                            {{$row_warrenty->yesno_name}}
                        </option>
                      @endforeach
                  </select>
                    @error('cbo_warrenty')
                     <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Update</button>
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
  @else
  <div class="container-fluid">    
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
          <form method="post" action="{{ route('inventoryproductstore') }}">
            @csrf
              <div class="row mb-2">
                <div class="col-2">
                  <select name="cbo_product_cat_id" id="cbo_product_cat_id" class="form-control">
                    <option value="0">Product Category</option>
                    @foreach ($pro_cat as $row_pro_cat)
                        <option value="{{ $row_pro_cat->product_cat_id }}">
                            {{ $row_pro_cat->product_category_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_product_cat_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_pg_id" id="cbo_pg_id" class="form-control">
                    <option value="0">Product Group</option>
                    @foreach ($m_product_group as $row_product_group)
                        <option value="{{ $row_product_group->pg_id }}">
                            {{ $row_product_group->pg_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_pg_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_pg_sub_id" id="cbo_pg_sub_id" class="form-control">
                      <option value="0">Product Sub Group</option>
                  </select>
                  @error('cbo_pg_sub_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-4">
                  <input type="text" class="form-control" id="txt_product_name" name="txt_product_name" value="{{ old('txt_product_name') }}" placeholder="Product Name">
                   @error('txt_product_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_brand_name" name="txt_brand_name" value="{{ old('txt_brand_name') }}" placeholder="Brand Name">
                   @error('txt_brand_name')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_model_size" name="txt_model_size" value="{{ old('txt_model_size') }}" placeholder="Size / Model">
                   @error('txt_model_size')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" id="txt_product_description" name="txt_product_description" value="{{ old('txt_product_description') }}" placeholder="Product Description">
                   @error('txt_product_description')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-3">
                  <select name="cbo_unit_id" id="cbo_unit_id" class="form-control">
                    <option value="0">Product Unit</option>
                    @foreach ($m_unit as $row_unit)
                        <option value="{{ $row_unit->unit_id }}">
                            {{ $row_unit->unit_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_unit_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <input type="text" class="form-control" id="txt_reorder_qty" name="txt_reorder_qty" value="{{ old('txt_reorder_qty') }}" placeholder="Reorder Qty">
                   @error('txt_reorder_qty')
                      <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_discount" id="cbo_discount" class="form-control">
                    <option value="0">Discount</option>
                    @foreach ($m_yesno as $row_discount)
                        <option value="{{ $row_discount->yesno_id }}">
                            {{ $row_discount->yesno_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_discount')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-3">
                  <select name="cbo_warrenty" id="cbo_warrenty" class="form-control">
                    <option value="0">Warrenty</option>
                    @foreach ($m_yesno as $row_warrenty)
                        <option value="{{ $row_warrenty->yesno_id }}">
                            {{ $row_warrenty->yesno_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_warrenty')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  
                </div>
                <div class="col-2">
                  <button type="submit"  class="btn btn-primary btn-block">Save</button>
                </div>
              </div>
            
          </form>
        </div>
      </div>
    </div>
  </section>

@endif
@include('inventory.product_list')

@endsection

@section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_pg_id"]').on('change', function() {
                console.log('ok')
                var cbo_pg_id = $(this).val();
                if (cbo_pg_id) {

                    $.ajax({
                        url: "{{ url('/get/pg/') }}/" + cbo_pg_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="cbo_pg_sub_id"]').empty();
                            $('select[name="cbo_pg_sub_id"]').append(
                                '<option value="0">Product Sub Group</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_pg_sub_id"]').append(
                                    '<option value="' + value.pg_sub_id + '">' +
                                    value.pg_sub_id + ' | ' + value.pg_sub_name + '</option>');
                            });
                        },
                    });

                }

            });
        });

    </script>
@endsection