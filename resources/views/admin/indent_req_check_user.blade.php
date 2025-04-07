@extends('layouts.admin_app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fund Indent User Permission</h1>
                    @if(isset($employee_details))
                    <h1 class="m-0">{{ $employee_details->employee_id }}</h1>
                    <h1 class="m-0">{{ $employee_details->employee_name }}</h1>
                    @endif
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container-fluid">
        @include('flash-message')
    </div>

    @if (isset($employee_details))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width='9%' class="text-left align-top">SL</th>
                                        <th class="text-left align-top">Company Name</th>
                                        <th class="text-left align-top">Email</th>
                                        <th class="text-left align-top">Lebel</th>
                                        <th class="text-left align-top">Valid</th>
                                        <th class="text-left align-top"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $mail_id = $mial;
                                        $lebel = 0;
                                        $valid = 0;
                                    @endphp
                                    @foreach ($companies as $key => $value)
                                        <tr>
                                            <form action="{{ route('indent_req_check_user_store') }}" method="post">
                                                @csrf

                                                @php
                                                    $fund_req_check = DB::table('pro_fund_req_check')
                                                        ->where('company_id', $value->company_id)
                                                        ->where('employee_id', $employee_details->employee_id)
                                                        ->first();

                                                    if (isset($fund_req_check)) {
                                                        $mail_id = $fund_req_check->mail_id;
                                                        $lebel = $fund_req_check->status;
                                                        $valid = $fund_req_check->valid;
                                                    } else {
                                                        $mail_id = $mial;
                                                        $lebel = 0;
                                                        $valid = 0;
                                                    }
                                                @endphp

                                                <input type="hidden" name="txt_employee_id" id="txt_employee_id"
                                                    value="{{ $employee_details->employee_id }}">
                                                <td>
                                                    <input type="text" value="{{ $key + 1 }}" class="form-control"
                                                        redonly>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="txt_company_id" id="txt_company_id"
                                                        value="{{ $value->company_id }}">
                                                    <input type="text" value="{{ $value->company_name }}"
                                                        class="form-control" redonly>
                                                </td>

                                                <td>
                                                    <input type="text" name="txt_mail" id="txt_mail"
                                                        class="form-control" value="{{ $mail_id }}">
                                                  
                                                </td>
                                                <td>
                                                    <select name="cbo_level_id" id="cbo_level_id" class="form-control">
                                                        <option value="">--Level--</option>
                                                        <option value="1" {{ $lebel == 1 ? 'selected' : '' }}>First
                                                            Check
                                                        </option>
                                                        <option value="2" {{ $lebel == 2 ? 'selected' : '' }}>Second
                                                            Check
                                                        </option>
                                                        <option value="3" {{ $lebel == 3 ? 'selected' : '' }}>Approved
                                                            By
                                                        </option>

                                                    </select>
                                                   
                                                </td>



                                                <td>
                                                    <div class="form-check">

                                                        @if ($valid == 1)
                                                            <input class="form-check-input" type="checkbox" name="txt_valid"
                                                                id="txt_valid" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="txt_valid"
                                                                id="txt_valid">
                                                        @endif

                                                        <label class="form-check-label" for="txt_valid">Valid</label>
                                                    </div>
                                                </td>


                                                <td class="text-left align-top">
                                                    <button type="submit" class="btn bg-primary">Submit</button>
                                                </td>

                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <div align="left" class="">
                                <h5>{{ 'Add' }}</h5>
                            </div>

                            <form action="{{ route('indent_req_check_user_permission') }}" method="GET">
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-4">
                                        <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                                            <option value="">--Company--</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->company_id }}">
                                                    {{ $company->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cbo_company_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-4">
                                        <select name="cbo_employee_id" id="cbo_employee_id" class="form-control">
                                            <option value="">--Employee--</option>

                                        </select>
                                        @error('cbo_employee_id')
                                            <div class="text-warning">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-2">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Next</button>
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
                        <div class="card-body">
                            <table id="data1" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left align-top">SL No.</th>
                                        <th class="text-left align-top">Company</th>
                                        <th class="text-left align-top">Name</th>
                                        <th class="text-left align-top">Email</th>
                                        <th class="text-left align-top">Level</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_user as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->company_name }}</td>
                                            <td>{{ $value->employee_name }}</td>
                                            <td>{{ $value->mail_id }}</td>
                                            <td>
                                                @if ($value->status == 1)
                                                    {{ 'First Check' }}
                                                @elseif ($value->status == 2)
                                                    {{ 'Second Check' }}
                                                @elseif ($value->status == 3)
                                                    {{ 'Approved By' }}
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    {{-- //Company to Employee Use Ajax --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="cbo_company_id"]').on('change', function() {
                var cbo_company_id = $(this).val();
                if (cbo_company_id) {

                    $.ajax({
                        url: "{{ url('/get/employee1/') }}/" + cbo_company_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="cbo_employee_id"]').empty();
                            $('select[name="cbo_employee_id"]').append(
                                '<option value="">--Employee--</option>');
                            $.each(data, function(key, value) {
                                $('select[name="cbo_employee_id"]').append(
                                    '<option value="' + value.employee_id + '">' +
                                    value.employee_id + ' | ' + value
                                    .employee_name + '</option>');
                            });
                        },
                    });

                } else {
                    $('select[name="cbo_employee_id"]').empty();
                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            //change selectboxes to selectize mode to be searchable
            $("select").select2();
        });
    </script>
@endsection
