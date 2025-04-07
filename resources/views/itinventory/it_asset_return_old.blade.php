@extends('layouts.itinventory_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">IT Asset Return</h1>
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
          <div align="left" class=""><h5>{{ "Add" }}</h5></div>
            <form action="" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-6">
                  <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                    <option value="0">--Company--</option>
                    @foreach ($user_company as $company)
                        <option value="{{ $company->company_id }}">
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_company_id')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-6">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-6">
                    <select name="cbo_it_asset_id" id="cbo_it_asset_id" class="form-control">
                        <option value="0">--Asset--</option>
                    </select>
                    @error('cbo_it_asset_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_return_date" name="txt_return_date" placeholder="Return Date" value="{{ old('txt_return_date') }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                  @error('txt_return_date')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                  <select name="cbo_reusable" id="cbo_reusable" class="form-control">
                    <option value="0">--Re Usable--</option>
                    @foreach ($m_yesno as $row_yesno)
                        <option value="{{ $row_yesno->yesno_id }}">
                            {{ $row_yesno->yesno_name }}
                        </option>
                    @endforeach
                  </select>
                  @error('cbo_reusable')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>

            </div>
            <div class="row mb-2">
              <div class="col-12">
                <input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Remarks/Comments/Note" value="{{ old('txt_remarks') }}">
                  @error('txt_remarks')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-10">
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
{{-- @include('/itinventory/it_asset_list') --}}
&nbsp;
@endsection
@section('script')
  {{-- //Company to Employee Use Ajax --}}
  <script type="text/javascript">
      $(document).ready(function() {
          $('select[name="cbo_company_id"]').on('change', function() {
              console.log('ok')
              var cbo_company_id = $(this).val();
              if (cbo_company_id) {

                  $.ajax({
                      url: "{{ url('/get/employee2/') }}/" + cbo_company_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          var d = $('select[name="cbo_employee_id"]').empty();
                          $('select[name="cbo_employee_id"]').append(
                              '<option value="0">--Employee--</option>');
                          $.each(data, function(key, value) {
                              $('select[name="cbo_employee_id"]').append(
                                  '<option value="' + value.employee_id + '">' +
                                  value.employee_id + ' | ' + value.employee_name + '</option>');
                          });
                      },
                  });

              }

          });
      });
  </script>

  {{-- //Employee to asset Use Ajax --}}
  <script type="text/javascript">
      $(document).ready(function() {
          $('select[name="cbo_employee_id"]').on('change', function() {
              console.log('ok')
              var cbo_employee_id = $(this).val();
              if (cbo_employee_id) {

                  $.ajax({
                      url: "{{ url('/get/issue_asset/') }}/" + cbo_employee_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          var d = $('select[name="cbo_it_asset_id"]').empty();
                          $('select[name="cbo_it_asset_id"]').append(
                              '<option value="0">--Asset--</option>');
                          $.each(data, function(key, value) {
                              $('select[name="cbo_it_asset_id"]').append(
                                  '<option value="' + value.itasset_id + '">' +
                                  value.itasset_id + ' | ' + value.itasset_id + '</option>');
                          });
                      },
                  });

              }

          });
      });
  </script>

  <script>
    $(document).ready(function () {
    //change selectboxes to selectize mode to be searchable
       $("select").select2();
    });
  </script>  

    
@endsection
