@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Date Wise Punch Report</h1>
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
                    <div align="left" class=""></div>
                    <form action="{{ route('hrmbackdaily_punch_report_02') }}" method="GET">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-3">
                                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                    <option value="0">--Company--</option>
                                    @foreach ($user_company as $company)
                                        <option value="{{ $company->company_id }}" {{ $company->company_id==$company_id?"selected":"" }}>
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_company_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-3">
                                <select name="cbo_placeofposting_id" id="cbo_placeofposting_id" class="form-control">
                                    <option value="">--Select Posting--</option>
                                    @foreach ($m_user_posting as $posting)
                                        <option value="{{ $posting->placeofposting_id }}">
                                            {{ $posting->placeofposting_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cbo_placeofposting_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-2">
                                <select name="cbo_placeofposting_sub_id" id="cbo_placeofposting_sub_id"
                                    class="form-control">
                                    <option value="0">--Select Sub Posting--</option>
                                </select>
                                @error('cbo_placeofposting_sub_id')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" id="txt_date" name="txt_date"
                                    placeholder="From Date" value="{{ old('txt_date') }}" onfocus="(this.type='date')"
                                    onblur="if(this.value==''){this.type='text'}">
                                <div id='err_txt_form_date'>
                                </div>
                                @error('txt_date')
                                    <div class="text-warning">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="data1" class="table table-border table-striped table-sm">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Punch Location</th>
                                <th>Punch Date</th>
                                <th>Punch Time</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($m_tmp_log as $key=>$row)
                            @php
                                $ci_employee_info=DB::table('pro_employee_info')->Where('employee_id',$row->emp_id)->first();
                                $txt_employee_id=$ci_employee_info->employee_id;
                                $txt_employee_name=$ci_employee_info->employee_name;

                                $ci_desig=DB::table('pro_desig')->Where('desig_id',$ci_employee_info->desig_id)->first();
                                $txt_desig_name=$ci_desig->desig_name;

                                $ci_placeofposting=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_employee_info->placeofposting_id)->first();
                                $txt_placeofposting_name=$ci_placeofposting->placeofposting_name;

                                $ci_biodevice=DB::table('pro_biodevice')->Where('biodevice_name',$row->nodeid)->first();

                                if(isset($ci_biodevice->placeofposting_id))
                                {
                                    $ci_punch_location=DB::table('pro_placeofposting')->Where('placeofposting_id',$ci_biodevice->placeofposting_id)->first();
                                    $txt_punch_location = $ci_punch_location->placeofposting_name;
                                } else {
                                    $txt_punch_location = '';
                                }

                            @endphp
                            
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->emp_id }}<br>{{ $txt_placeofposting_name }}</td>
                                <td>{{ $txt_employee_name }}<br>{{ $txt_desig_name }}</td>
                                <td>{{ $txt_punch_location }}</td>
                                <td>{{ $row->logdate }}</td>
                                <td>{{ $row->logtime }}</td>
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

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_placeofposting_id"]').on('change', function() {
                getSubPosting();
               
            });
        });

        // posting to sub posting 
        function getSubPosting() {
            var cbo_placeofposting_id = $('#cbo_placeofposting_id').val();
            if (cbo_placeofposting_id) {
                $.ajax({
                    url: "{{ url('/get/hrm/placeofsubposting/') }}/" + cbo_placeofposting_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="cbo_placeofposting_sub_id"]').empty();
                            $('select[name="cbo_placeofposting_sub_id"]').append(
                            '<option value="0">--Select Sub Posting--</option>');
                        $.each(data, function(key, value) {
                            $('select[name="cbo_placeofposting_sub_id"]').append(
                                '<option value="' + value.placeofposting_sub_id + '">' + value
                                .sub_placeofposting_name + '</option>');
                        });
                    },
                });

            } else {
                $('select[name="cbo_placeofposting_sub_id"]').empty();
            }
        }
    </script>
@endsection