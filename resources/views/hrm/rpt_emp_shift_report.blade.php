@extends('layouts.hrm_app')
@section('content')


<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Employee Shifting Report</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="container-fluid">
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- <a href="" class="btn btn-primary float-right" >Print</a> -->
                    <h3 class="card-title">{{ $txt_company_name }}, {{ $txt_placeofposting_name }}, {{ $txt_sub_placeofposting_name }}<BR>{{ $month_name}}, {{ $txt_year }}</h3>
                </div>
                <div class="card-body">
                    <table id="" class="table table-bordered table-sm" >

                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID<br>Name/Desig.</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_employee_info as $key=>$row_m_employee_info)
                            <tr style="border">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row_m_employee_info->employee_id }}<br>{{ $row_m_employee_info->employee_name }}<br>{{ $row_m_employee_info->desig_name }}</td>
                                <td>
                                <table>
                                <tr>
                                @php
                                for($d=0; $d<$tot_days; $d++)
                                {
                                @endphp
                                <td>{{ $d+1 }}</td>
                                @php
                                }
                                @endphp
                                </tr>

                                    <tr>
                                        

                                    @php
                                    $m_atten_date1=$txt_frist_date;

                                    $year = date('Y', strtotime($m_atten_date1));
                                    $month = date('m', strtotime($m_atten_date1));
                                    $m_emp_day_policy_table = "pro_emp_day_policy_$year$month";

                                    for($dd=0; $dd<$tot_days; $dd++)
                                    {
                                        $m_atten_date = date('Y-m-d', strtotime($m_atten_date1.' + '.$dd.' days'));

                                        $mm_emp_day_policy=DB::table("$m_emp_day_policy_table")
                                        ->leftjoin("pro_att_policy", "$m_emp_day_policy_table.att_policy_id", "pro_att_policy.att_policy_id")
                                        ->select(
                                            "$m_emp_day_policy_table.*", 
                                            "pro_att_policy.pshortname",
                                        )

                                        ->Where("$m_emp_day_policy_table.employee_id",$row_m_employee_info->employee_id)
                                        ->Where("$m_emp_day_policy_table.valid",'1')
                                        ->where("$m_emp_day_policy_table.attn_date",$m_atten_date)
                                        ->first();
                                    @endphp
                                        <td width="3%">
                                        @php
                                        if($mm_emp_day_policy==null)
                                        {
                                            $txt_pshortname="-";                                        
                                        } else {
                                            $txt_pshortname="$mm_emp_day_policy->pshortname";                                        
                                        }
                                        @endphp
                                        {{ $txt_pshortname }}
                                        </td>
                                        @php
                                            }
                                        @endphp
                                
                                    </tr>
                                </table>
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
@endsection