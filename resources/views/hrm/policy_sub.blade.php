@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Attendance Sub Policy</h1>
        {{-- {{$m_fund_req_master->company_name}} --}}
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">
  @include('flash-message')
</div>
@php
  $weekday = array("Select Weekday","Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday");

  $yesno = array("Select","Yes","No");
@endphp
{{-- @if($ci_att_policy_sub->count()>0) --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div align="left" class="">
                        <h6>{{ 'Company-' }}{{ $m_att_policy->company_name }} | {{'Policy-'}}{{ $m_att_policy->att_policy_name }} | {{ 'Weekly Holiday-' }}{{ $m_att_policy->weekly_holiday1 }}</h6>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label>SL No</label>
                        </div>
                        <div class="col-2">
                            <label>Day Name</label>
                        </div>
                        <div class="col-2">
                            <label>In Time</label>
                        </div>
                        <div class="col-2">
                            <label>Out Time</label>
                        </div>
                        <div class="col-1">
                            <label>Grace Time</label>
                        </div>
                        <div class="col-2">
                            <label>Lunch Time</label>
                        </div>
                        <div class="col-1">
                            <label>Lunch Break</label>
                        </div>
                        <div class="col-1">
                            <label>Act</label>
                        </div>
                    </div>



                    @foreach ($ci_att_policy_sub as $key => $row_att_policy_sub)
                        <form action="{{ route('HrmPolicySubOk') }}" method="post">
                            @csrf

                        <input type="hidden" name="txt_company_id" value="{{ $m_att_policy->company_id }}">

                        <input type="hidden" name="txt_att_policy_id" value="{{ $m_att_policy->att_policy_id }}">

                        <input type="hidden" name="txt_att_policy_sub_id" value="{{ $row_att_policy_sub->att_policy_sub_id }}">

                        <div class="row m-0">
                            <div class="col-1 p-0">
                                <input type="text" class="form-control" readonly value="{{ $key + 1 }}">
                            </div>
                            <div class="col-2 p-0">
                                <input type="text" id="txt_day" name="txt_day" class="form-control" readonly value="{{ $row_att_policy_sub->day }}">
                            </div>
                            <div class="col-2 p-0">
                                <input type="text" id="txt_in_time" name="txt_in_time" class="form-control" value="{{ $row_att_policy_sub->in_time }}">
                            </div>
                            <div class="col-2 p-0">
                                <input type="text" id="txt_out_time" name="txt_out_time" class="form-control" value="{{ $row_att_policy_sub->out_time }}">
                            </div>
                            <div class="col-1 p-0">
                                <input type="text" id="txt_grace_time" name="txt_grace_time" class="form-control" readonly value="{{ $row_att_policy_sub->grace_time }}">
                            </div>
                            <div class="col-2 p-0">
                                <input type="text" id="txt_lunch_time" name="txt_lunch_time" class="form-control" readonly value="{{ $row_att_policy_sub->lunch_time }}">
                            </div>
                            <div class="col-1 p-0">
                                <input type="text" id="txt_lunch_break" name="txt_lunch_break" class="form-control" readonly value="{{ $row_att_policy_sub->lunch_break }}">
                            </div>
                            <div class="col-1 p-0">
                                <button type="submit" class="btn btn-primary">ok</button>
                            </div>
                        </div>

                        </form>

                    @endforeach

                </div>
            </div>
        </div>
    </div>

</div>
{{-- @endif --}}



@endsection
