@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Daily Working Time</h1>
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
            <form action="{{route('emp_day_shift_details_store')}}" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-3">
                <input type="text" class="form-control" id="txt_atten_date" name="txt_atten_date" value="{{$attn_date}}" readonly>
              </div>
              <div class="col-3">
                <input type="hidden" class="form-control" name="cbo_company_id" id="cbo_company_id" value="{{$m_company->company_id}}" readonly>
                <input type="text" class="form-control" name="cbo_company_name" id="cbo_company_name" value="{{$m_company->company_name}}" readonly>
              </div>
              <div class="col-3">
                <input type="hidden" class="form-control" name="cbo_posting" id="cbo_posting" value="{{$m_placeofposting->placeofposting_id}}" readonly>
                <input type="text" class="form-control" name="cbo_posting_name" id="cbo_posting_name" value="{{$m_placeofposting->placeofposting_name}}" readonly>
              </div>
              <div class="col-3">
                <input type="hidden" class="form-control" name="cbo_sub_posting" id="cbo_sub_posting" value="{{$m_sub_placeofposting->placeofposting_sub_id}}" readonly>
                <input type="text" name="sub_posting_name" id="sub_posting_name" class="form-control" value="{{$m_sub_placeofposting->sub_placeofposting_name}}" readonly>
              </div>
              
            </div>
            <div class="row mb-2">
                <div class="col-3">
                </div>
                <div class="col-3">
                    <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                        <option value="0">--Employee--</option>
                    </select>
                    @error('cbo_employee_id')
                        <div class="text-warning">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-3">
                  <input type="hidden" class="form-control" name="txt_desig_id" id="txt_desig_id" value="" readonly>
                  <input type="text" class="form-control" name="txt_desig_name" id="txt_desig_name" value="" readonly>
                  @error('txt_desig_name')
                    <span class="text-warning">{{ $message }}</span>
                  @enderror
                </div>
                 <div class="col-3">
                  <select name="sele_att_policy" id="sele_att_policy" class="form-control">
                      <option value="">--Policy--</option>
                  </select>
                  @error('sele_att_policy')
                      <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-8">
                &nbsp;
              </div>
              <div class="col-2">
                <button type="Submit" class="btn btn-primary btn-block">Add More</button>
              </div>
              <div class="col-2">
                <a href="{{route('emp_day_shift_final',[$attn_date,$m_company->company_id,$m_placeofposting->placeofposting_id,$m_sub_placeofposting->placeofposting_sub_id])}}" class="btn btn-primary btn-block">Final</a>
              </div>
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>


&nbsp;
  @section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
           
            getemployee();
            getPolicy();
        });

       function getemployee()
       {
         var cbo_company_id = $('#cbo_company_id').val();
         var cbo_posting = $('#cbo_posting').val();
         // var cbo_section = $('#cbo_section').val();
         var cbo_sub_posting = $('#cbo_sub_posting').val();
          if (cbo_company_id && cbo_posting ) {

              $.ajax({
                  url: "{{ url('/get/employee/') }}/" + cbo_company_id+'/'+cbo_posting+'/'+ cbo_sub_posting,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('select[name="cbo_employee_id"]').empty();
                    if(data){
                      $('select[name="cbo_employee_id"]').append(
                          '<option value="0">--Employee--</option>');
                      $.each(data, function(key, value) {
                          $('select[name="cbo_employee_id"]').append(
                              '<option value="' + value.employee_id + '">' +
                              value.employee_id + ' | ' + value.employee_name + '</option>');
                      });
                    } // if(data){
                  },
              });

          } 
          else
          {
            $('select[name="cbo_employee_id"]').empty();
          }
        }

       function getPolicy()
        {
           var cbo_company_id = $('#cbo_company_id').val();
           if(cbo_company_id)
           {
              $.ajax({
                  url: "{{ url('/get/policy/') }}/" + cbo_company_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                     $('select[name="sele_att_policy"]').empty();
                    if(data){
                      $('select[name="sele_att_policy"]').append(
                          '<option value="">--Select Policy--</option>');
                      $.each(data, function(key, value) {
                          $('select[name="sele_att_policy"]').append(
                              '<option value="' + value.att_policy_id + '">' +
                              value.att_policy_name + ' | ' + value.in_time +' | '+value.out_time+ '</option>');
                      });
                    } // if(data){
                  },
              });
           }else{
             $('select[name="sele_att_policy"]').empty();
           }
        }

    </script>
    {{-- //Employee to Desig Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_employee_id"]').on('change', function() {
                var cbo_employee_id = $(this).val();
                if (cbo_employee_id) {
                    $.ajax({
                        url: "{{ url('/get/desig/') }}/" + cbo_employee_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#txt_desig_name').val('');
                            document.getElementById("txt_desig_id").value = data.desig_id;
                            document.getElementById("txt_desig_name").value = data.desig_name;
                            // document.getElementById("txt_placeofposting_name").value = data.placeofposting_name;

                        },
                    });

                } else {
                    $('#txt_desig_name').val('');
                    // $('txt_placeofposting_name').empty();
                }

            });
        });

    </script>


  <script>
          function DateDiff(val) {
           var date1 = new Date(document.getElementById("txt_from_date").value)
           var date2 = new Date(val);
           var Difference_In_Time = date2.getTime() - date1.getTime();
           var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
           document.getElementById("txt_total").value=Difference_In_Days+1;
          }
      </script>
  @endsection

  <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="basic_info_list" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Employee ID | Name</th>
                                <th>Designation/Department</th>
                                <th>Policy</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $ci_emp_day_policy=DB::table('pro_employee_info')
                            ->leftjoin("pro_desig", "pro_employee_info.desig_id", "pro_desig.desig_id")
                            ->leftjoin("pro_department", "pro_employee_info.department_id", "pro_department.department_id")
                            ->leftjoin("pro_att_policy", "pro_employee_info.att_policy_id", "pro_att_policy.att_policy_id")

                            ->select(
                              "pro_employee_info.*",
                              "pro_desig.desig_name",
                              "pro_department.department_name",
                              "pro_att_policy.att_policy_name",
                            )
                            ->Where('pro_employee_info.company_id',$m_company->company_id)
                            ->Where('pro_employee_info.placeofposting_id',$m_placeofposting->placeofposting_id)
                            ->Where('pro_employee_info.placeofposting_sub_id',$m_sub_placeofposting->placeofposting_sub_id)
                            ->Where('pro_employee_info.valid','1')
                            ->Where('pro_employee_info.emp_day_policy_status','1')
                            // ->orderBy('pro_att_policy.att_policy_id', 'desc')
                            ->get(); //query builder
                            @endphp

                            @foreach($ci_emp_day_policy as $key=>$row)
                              <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->employee_id }} | {{ $row->employee_name }}</td>
                                <td>{{ $row->desig_name }} | {{ $row->department_name }}</td>
                                <td>{{ $row->att_policy_name }}</td>
                              </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection