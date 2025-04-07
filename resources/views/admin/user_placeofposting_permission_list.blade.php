@extends('layouts.admin_app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1 class="m-0">
                        {{ $m_company->company_name }} <br>
                        {{ $m_employee->employee_name }} <br> {{ $m_employee->employee_id }}

                    </h1>
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <form action="{{ route('all_placeofposting_permission') }}" method="get">
                                    @csrf
                                    {{-- //hidden --}}
                                    <input type="hidden" name="txt_company_id" value="{{ $m_company->company_id }}">
                                    <input type="hidden" name="txt_employee_id" value="{{ $m_employee->employee_id }}">
                                    <th class="text-left align-top" colspan="3">All Place of Posting</th>
                                    <th class="text-left align-top ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="txt_valid_all"
                                                id="txt_valid_all">
                                            <label class="form-check-label" for="txt_valid_all">
                                                Valid All
                                            </label>
                                        </div>
                                    </th>
                                    <th class="text-left align-top">
                                        <button type="Submit" id="save_event"
                                            class="btn btn-primary btn-block">Add</button>
                                    </th>
                                    </form>
                                </tr>
                                <tr>
                                    <th class="text-left align-top">SL No.</th>
                                    <th class="text-left align-top">Posting Name</th>
                                    <th class="text-left align-top">Posting Status</th>
                                    <th class="text-left align-top">Valid</th>
                                    <th class="text-left align-top">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- //head array --}}
                                @php
                                    $catagory = [1, 2];
                                @endphp

                                @for ($i = 0; $i < 2; $i++)
                                    @php
                                        $x = 1;
                                        //posting catagory 1 -> Sales Center
                                        $sales_center = DB::table('pro_placeofposting')
                                            ->where('posting_catagory', $catagory[$i])
                                            ->where('valid', 1)
                                            ->get();
                                    @endphp


                                    <form action="{{ route('catagory_wise_placeofposting_permission') }}" method="get">
                                    @csrf
                                    {{-- //hidden --}}
                                    <input type="hidden" name="txt_company_id" value="{{ $m_company->company_id }}">
                                    <input type="hidden" name="txt_employee_id" value="{{ $m_employee->employee_id }}">
                                    <input type="hidden" name="txt_catagory" value="{{ $catagory[$i] }}">
                                    <tr>
                                        @if ($catagory[$i] == 1)
                                            <th class="text-center align-top " colspan="3">Sales Center</th>
                                        @elseif($catagory[$i] == 2)
                                            <th class="text-center align-top" colspan="3">Other</th>
                                        @endif
                                        <th class="text-left align-top ">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="txt_cattagory_valid"
                                                    id="txt_cattagory_valid">
                                                <label class="form-check-label" for="txt_cattagory_valid">
                                                    Valid All
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-left align-top">
                                            <button type="Submit" id="save_event"
                                                class="btn btn-primary btn-block">Add</button>
                                        </th>
                                    </tr>
                                    </form>

                                    @foreach ($sales_center as $key => $row)
                                        <form action="{{ route('only_one_placeofposting_permission',$row->placeofposting_id) }}" method="get">
                                        @csrf

                                        @php
                                            $m_user_posting = DB::table('pro_user_posting')
                                                ->where('company_id', $m_company->company_id)
                                                ->where('employee_id', $m_employee->employee_id)
                                                ->where('placeofposting_id', $row->placeofposting_id)
                                                ->where('valid', 1)
                                                ->first();

                                        @endphp


                                        {{-- //hidden --}}
                                        <input type="hidden" name="txt_company_id" value="{{ $m_company->company_id }}">
                                        <input type="hidden" name="txt_employee_id" value="{{ $m_employee->employee_id }}">
                                        <tr>
                                            <td> {{ $x++ }} </td>
                                            <td>{{ $row->placeofposting_name }} </td>
                                            <td>{{ $row->sub_posting_status }} </td>
                                            <td>

                                                <div class="form-check">
                                                    @if (isset($m_user_posting->valid))
                                                        @if ($m_user_posting->valid == 1)
                                                            <input class="form-check-input" type="checkbox"
                                                                name="txt_posting_status" id="txt_posting_status" checked>
                                                        @else
                                                            <input class="form-check-input" type="checkbox"
                                                                name="txt_posting_status" id="txt_posting_status">
                                                        @endif
                                                    @else
                                                        <input class="form-check-input" type="checkbox"
                                                            name="txt_posting_status" id="txt_posting_status">
                                                    @endif

                                                    <label class="form-check-label" for="txt_posting_status">Valid</label>

                                                </div>


                                            </td>
                                            <td>
                                                <button type="Submit" id="save_event"
                                                    class="btn btn-primary btn-block">Add</button>
                                            </td>
                                        </tr>
                                        </form>
                                    @endforeach
                                    {{-- // @foreach ($sales_center as $key => $row) --}}
                                @endfor
                                {{-- //   @for ($i = 0; $i < 2; $i++) --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
