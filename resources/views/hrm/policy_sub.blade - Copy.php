@extends('layouts.hrm_app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Attendance Sub Policy</h1>
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

@if(isset($m_att_policy))
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div align="left" class=""><h5>{{ "Edit" }}</h5></div>
            <form name="" method="post" action="" >
            @csrf
            <div class="row mb-2">
              <div class="col-4">
                <select name="cbo_company_id" id="cbo_company_id" class="form-control">
                    <option value="0">--Company--</option>
                    @foreach ($user_company as $row_company)
                        <option value="{{ $row_company->company_id }}"
                            {{ $row_company->company_id == $m_att_policy->company_id ? 'selected' : '' }}>
                            {{ $row_company->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('sele_company_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror

              </div>

              <div class="col-4">
                <input type="text" class="form-control" id="txt_att_policy_name" name="txt_att_policy_name" placeholder="Attendance Policy Name / Shift" value="{{ $m_att_policy->att_policy_name }}">
                  @error('txt_att_policy_name')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_in_time" name="txt_in_time" placeholder="In Time 00:00:00" value="{{ $m_att_policy->in_time }}">
                  @error('txt_in_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_out_time" name="txt_out_time" placeholder="Out Time 00:00:00" value="{{ $m_att_policy->out_time }}">
                  @error('txt_out_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_policy_status" id="sele_policy_status" class="form-control">
                    <option value="0">Regular Policy</option>
                    @foreach ($m_yesno as $row_yesno)
                        <option value="{{ $row_yesno->yesno_id }}" {{$row_yesno->yesno_id == $m_att_policy->policy_status? 'selected':''}}>
                            {{ $row_yesno->yesno_name }}
                        </option>
                    @endforeach
                </select>
                @error('sele_policy_status')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_grace_time" name="txt_grace_time" placeholder="Grace Time (minute 00)" value="{{ $m_att_policy->grace_time }}">
                  @error('txt_grace_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_lunch_time" name="txt_lunch_time" placeholder="Lunch Time 00:00:00" value="{{ $m_att_policy->lunch_time }}">
                  @error('txt_lunch_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_lunch_break" name="txt_lunch_break" placeholder="Lunch Break (minute)" value="{{ $m_att_policy->lunch_break }}">
                  @error('txt_lunch_break')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <label>Weekly Holiday</label>
              </div>
              <div class="col-3">
                <label>Multiple Holiday</label>
              </div>
              <div class="col-3">
                <label>Is Eligible for Over Time</label>
              </div>
              <div class="col-3">
                <label>General Duty</label>
              </div>             
            </div>                
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_weekly_holiday1" id="sele_weekly_holiday1" class="from-control custom-select">
                    @php

                      if($m_att_policy->weekly_holiday1=='N/A'){
                        $txt_holiday1=0;  
                      } else if ($m_att_policy->weekly_holiday1=='Saturday'){
                        $txt_holiday1=1;  
                      } else if ($m_att_policy->weekly_holiday1=='Sunday'){
                        $txt_holiday1=2;  
                      } else if ($m_att_policy->weekly_holiday1=='Monday'){
                        $txt_holiday1=3;  
                      } else if ($m_att_policy->weekly_holiday1=='Tuesday'){
                        $txt_holiday1=4;  
                      } else if ($m_att_policy->weekly_holiday1=='Wednesday'){
                        $txt_holiday1=5;  
                      } else if ($m_att_policy->weekly_holiday1=='Thursday'){
                        $txt_holiday1=6;  
                      } else if ($m_att_policy->weekly_holiday1=='Friday'){
                        $txt_holiday1=7;  
                      }

                    @endphp

                    <option value="{{ $txt_holiday1 }}">{{ $m_att_policy->weekly_holiday1 }}</option>

                    @foreach($weekday as $key1=>$value)
                      <option value="{{ $key1 }}">{{ $value }}</option>
                    @endforeach
                </select>
                      @error('sele_weekly_holiday1')
                        <div class="text-warning">{{ $message }}</div>
                      @enderror
                
              </div>
              <div class="col-3">
                <select name="sele_weekly_holiday2" id="sele_weekly_holiday2" class="from-control custom-select">
                    @php

                      if($m_att_policy->weekly_holiday2=='N/A'){
                        $txt_holiday2=0;  
                      } else if ($m_att_policy->weekly_holiday2=='Saturday'){
                        $txt_holiday2=1;  
                      } else if ($m_att_policy->weekly_holiday2=='Sunday'){
                        $txt_holiday2=2;  
                      } else if ($m_att_policy->weekly_holiday2=='Monday'){
                        $txt_holiday2=3;  
                      } else if ($m_att_policy->weekly_holiday2=='Tuesday'){
                        $txt_holiday2=4;  
                      } else if ($m_att_policy->weekly_holiday2=='Wednesday'){
                        $txt_holiday2=5;  
                      } else if ($m_att_policy->weekly_holiday2=='Thursday'){
                        $txt_holiday2=6;  
                      } else if ($m_att_policy->weekly_holiday2=='Friday'){
                        $txt_holiday2=7;  
                      }

                    @endphp

                    <option value="{{ $txt_holiday2 }}">{{ $m_att_policy->weekly_holiday2 }}</option>

                    @foreach($weekday as $key2=>$value)
                      <option value="{{ $key2 }}">{{ $value }}</option>
                    @endforeach
                </select>
                      @error('sele_weekly_holiday2')
                        <div class="text-warning">{{ $message }}</div>
                      @enderror
                
              </div>
              <div class="col-3">
                <select name="sele_ot_elgble" id="sele_ot_elgble" class="from-control custom-select">
                    @php

                      if($m_att_policy->ot_elgble==1){
                          $txt_ot_elgble='Yes';
                      } else if($m_att_policy->ot_elgble==2){
                          $txt_ot_elgble='No';
                      }

                    @endphp

                    <option value="{{ $m_att_policy->ot_elgble }}">{{ $txt_ot_elgble }}</option>

                    @foreach($yesno as $key=>$value)
                      <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                      @error('sele_ot_elgble')
                        <div class="text-warning">{{ $message }}</div>
                      @enderror
              </div>
              <div class="col-3">
                <select name="cbo_shift_status" id="cbo_shift_status" class="form-control">
                    <option value="0">--Over Time--</option>
                    @foreach ($m_yesno as $row_yesno)
                        <option value="{{ $row_yesno->yesno_id }}" {{$row_yesno->yesno_id == $m_att_policy->shift_status? 'selected':''}}>
                            {{ $row_yesno->yesno_name }}
                        </option>
                    @endforeach
                </select>
                @error('cbo_shift_status')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <div class="row mb-2">
              <div class="col-10">
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
            <form action="" method="Post">
            @csrf

            <div class="row mb-2">
              <div class="col-4">
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
              <div class="col-4">
                <select name="cbo_att_policy_id" id="cbo_att_policy_id"
                    class="form-control ">
                    <option value="0">Select Main Policy</option>
                </select>
                @error('cbo_att_policy_id')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_in_time" name="txt_in_time" placeholder="In Time 00:00:00" value="{{ old('txt_in_time') }}">
                  @error('txt_in_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-2">
                <input type="text" class="form-control" id="txt_out_time" name="txt_out_time" placeholder="Out Time 00:00:00" value="{{ old('txt_out_time') }}">
                  @error('txt_out_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_policy_status" id="sele_policy_status" class="form-control">
                  <option value="0">Regular Policy</option>
                  @foreach ($m_yesno as $row_yesno)
                      <option value="{{ $row_yesno->yesno_id }}">
                        {{ $row_yesno->yesno_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_policy_status')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_grace_time" name="txt_grace_time" placeholder="Grace Time 00" value="{{ old('txt_grace_time') }}">
                  @error('txt_grace_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_lunch_time" name="txt_lunch_time" placeholder="Lunch Time 00:00:00" value="{{ old('txt_lunch_time') }}">
                  @error('txt_lunch_time')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="txt_lunch_break" name="txt_lunch_break" placeholder="Lunch Break (minute)" value="{{ old('txt_lunch_break') }}">
                  @error('txt_lunch_break')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-3">
                <label>Weekly Holiday</label>
              </div>
              <div class="col-3">
                <label>Multiple Holiday</label>
              </div>
              <div class="col-3">
                <label>Is Eligible for Over Time</label>
              </div>
              <div class="col-3">
                <label>General Duty</label>
              </div>
            </div>                
            <div class="row mb-2">
              <div class="col-3">
                <select name="sele_weekly_holiday1" id="sele_weekly_holiday1" class="from-control custom-select">
                @foreach($weekday as $key1=>$value)
                  <option value="{{ $key1 }}">{{ $value }}</option>
                @endforeach
                </select>
                  @error('sele_weekly_holiday1')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_weekly_holiday2" id="sele_weekly_holiday2" class="from-control custom-select">
                @foreach($weekday as $key2=>$value)
                  <option value="{{ $key2 }}">{{ $value }}</option>
                @endforeach
                </select>
                  @error('sele_weekly_holiday2')
                    <div class="text-warning">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-3">
                <select name="sele_ot_elgble" id="sele_ot_elgble" class="form-control">
                  <option value="0">Over Time</option>
                  @foreach ($m_yesno as $row_yesno)
                      <option value="{{ $row_yesno->yesno_id }}">
                        {{ $row_yesno->yesno_name }}
                      </option>
                  @endforeach
                </select>
                @error('sele_ot_elgble')
                    <div class="text-warning">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-3">
                <select name="cbo_shift_status" id="cbo_shift_status" class="form-control">
                  <option value="0">General Duty</option>
                  @foreach ($m_yesno as $row_yesno)
                      <option value="{{ $row_yesno->yesno_id }}">
                        {{ $row_yesno->yesno_name }}
                      </option>
                  @endforeach
                </select>
                @error('cbo_shift_status')
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
@include('/hrm/policy_list')
&nbsp;
@endif
@endsection
