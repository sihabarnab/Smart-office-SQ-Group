<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AutoProcessController extends Controller
{
    public function AutoAttProcess01()
    {

    $mentrydate=time();
    // $m_entry_date="2023-09-25";
    $m_entry_date=date("Y-m-d",$mentrydate);
    $m_entry_time=date("H:i:s",$mentrydate);

    $m_atten_date=date('Y-m-d', strtotime($m_entry_date . ' -1 day'));

    $m_month=date("m",strtotime($m_atten_date));
    $m_year=date("y",strtotime($m_atten_date));

    $m_table="pro_attendance_$m_month$m_year";

        if (Schema::hasTable("$m_table"))
        {

            $ci_attendance=DB::table("$m_table")
            ->where('attn_date',$m_atten_date)
            ->where('valid','1')
            ->count();
        
            if ($ci_attendance>0)
            {

                return "Attendance Process Allready Done";
            } else {

            $m_employee_info = DB::table('pro_employee_info')
            ->where('valid','1')
            ->where('working_status','1')
            ->where('ss','1')
            ->orderBy('employee_id','asc')
            ->get();

            foreach ($m_employee_info as $row_emp_info){

                $m_employee_id=$row_emp_info->employee_id;
                $m_company_id=$row_emp_info->company_id;
                $m_placeofposting_id=$row_emp_info->placeofposting_id;
                $m_desig_id=$row_emp_info->desig_id;
                $m_department_id=$row_emp_info->department_id;
                $m_att_policy_id=$row_emp_info->att_policy_id;
                $m_psm_id=$row_emp_info->psm_id;

                $prweekday = date('l', strtotime($m_atten_date));
                $m_process_status='2';
                $m_valid='1';

                $m_user_id='00000130';

                $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
                
                $m_in_time=$m_att_policy->in_time;
                $m_in_time_graced=$m_att_policy->in_time_graced;
                $m_out_time=$m_att_policy->out_time;
                $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
                $m_weekly_holiday2=$m_att_policy->weekly_holiday2;

                // return $m_atten_date;
                // Govt Holi checking here
                $m_holiday=DB::table('pro_holiday')
                ->Where('holiday_date',$m_atten_date)
                ->first();
                // $m_holiday_date=$m_holiday->holiday_date;

                if ($m_holiday===null)
                {
                $daysts="R";
                $sts="A";
                }
                else
                {
                $daysts="H";
                $sts="H";
                }

                //Weekly Holiday Checki here if not Govt Holidy
                if ($daysts!="H")
                {
                if ($prweekday==$m_weekly_holiday1)
                {
                $daysts="W";
                $sts="W";
                }
                else if ($prweekday==$m_weekly_holiday2)
                {
                $daysts="W";
                $sts="W";
                }
                else
                {
                $daysts="R";
                $sts="A";
                }
                }//if ($daysts!="H")*/
                // $m_process_status='2';

                    $data=array();
                    $data['company_id']=$m_company_id;
                    $data['employee_id']=$m_employee_id;
                    $data['desig_id']=$m_desig_id;
                    $data['department_id']=$m_department_id;
                    $data['placeofposting_id']=$m_placeofposting_id;
                    $data['att_policy_id']=$m_att_policy_id;
                    $data['attn_date']=$m_atten_date;
                    $data['day_name']=$prweekday;
                    $data['process_status']=$m_process_status;
                    $data['user_id']=$m_user_id;
                    $data['entry_date']=$m_entry_date;
                    $data['entry_time']=$m_entry_time;
                    $data['valid']=$m_valid;
                    $data['psm_id']=$m_psm_id;
                    $data['r_in_time']=$m_in_time;
                    $data['p_in_time']=$m_in_time_graced;
                    $data['p_out_time']=$m_out_time;
                    $data['day_status']=$daysts;
                    $data['status']=$sts;
                    $data['psm_id']=$m_psm_id;

                DB::table("$m_table")->insert($data);
                //}//if ($ci_check_emp==NULL)
               
            } //foreach ($m_employee_info as $row_emp_info){
            
            //end of step 2

            return "$m_atten_date Data Process 01 Successfully!";
           
            } //if ($ci_attendance>1)


        } else {//if (Schema::hasTable("$m_table"))

            Schema::create("$m_table", function (Blueprint $table) {
            $table->increments('attendance_id');
            $table->integer('company_id')->length(11);
            $table->string('employee_id', 8);
            $table->integer('machine_id')->length(11);
            $table->integer('desig_id')->length(11);
            $table->integer('department_id')->length(11);
            $table->integer('placeofposting_id')->length(11);
            $table->integer('att_policy_id')->length(2);
            $table->date('attn_date');
            $table->time('r_in_time');
            $table->time('p_in_time');
            $table->time('p_out_time');
            $table->time('in_time');
            $table->integer('nodeid_in')->length(11);
            $table->time('out_time');
            $table->integer('nodeid_out')->length(11);
            $table->string('day_name', 25);
            $table->char('day_status', 2);
            $table->float('total_working_hour', 8, 2);
            $table->integer('ot_minute')->length(5);
            $table->integer('late_min')->length(4);
            $table->integer('early_min')->length(4);
            $table->char('status', 2);
            $table->integer('is_quesitonable')->length(1);
            $table->integer('process_status')->length(1);
            $table->string('user_id', 8);
            $table->date('entry_date');
            $table->time('entry_time');
            $table->integer('valid')->length(1);
            $table->string('psm_id',20)->nullable();
            });

            $m_employee_info = DB::table('pro_employee_info')
            ->where('valid','1')
            ->where('working_status','1')
            ->where('ss','1')
            ->orderBy('employee_id','asc')
            ->get();

            foreach ($m_employee_info as $row_emp_info){

                $m_employee_id=$row_emp_info->employee_id;
                $m_company_id=$row_emp_info->company_id;
                $m_placeofposting_id=$row_emp_info->placeofposting_id;
                $m_desig_id=$row_emp_info->desig_id;
                $m_department_id=$row_emp_info->department_id;
                $m_att_policy_id=$row_emp_info->att_policy_id;
                $m_psm_id=$row_emp_info->psm_id;

                $prweekday = date('l', strtotime($m_atten_date));
                $m_process_status='2';
                $m_valid='1';

                $m_user_id='00000130';

                $m_att_policy=DB::table('pro_att_policy')->Where('att_policy_id',$m_att_policy_id)->first();
                
                $m_in_time=$m_att_policy->in_time;
                $m_in_time_graced=$m_att_policy->in_time_graced;
                $m_out_time=$m_att_policy->out_time;
                $m_weekly_holiday1=$m_att_policy->weekly_holiday1;
                $m_weekly_holiday2=$m_att_policy->weekly_holiday2;

                // return $m_atten_date;
                // Govt Holi checking here
                $m_holiday=DB::table('pro_holiday')
                ->Where('holiday_date',$m_atten_date)
                ->first();
                // $m_holiday_date=$m_holiday->holiday_date;

                if ($m_holiday===null)
                {
                $daysts="R";
                $sts="A";
                }
                else
                {
                $daysts="H";
                $sts="H";
                }

                //Weekly Holiday Checki here if not Govt Holidy
                if ($daysts!="H")
                {
                if ($prweekday==$m_weekly_holiday1)
                {
                $daysts="W";
                $sts="W";
                }
                else if ($prweekday==$m_weekly_holiday2)
                {
                $daysts="W";
                $sts="W";
                }
                else
                {
                $daysts="R";
                $sts="A";
                }
                }//if ($daysts!="H")*/

                    $data=array();
                    $data['company_id']=$m_company_id;
                    $data['employee_id']=$m_employee_id;
                    $data['desig_id']=$m_desig_id;
                    $data['department_id']=$m_department_id;
                    $data['placeofposting_id']=$m_placeofposting_id;
                    $data['att_policy_id']=$m_att_policy_id;
                    $data['attn_date']=$m_atten_date;
                    $data['day_name']=$prweekday;
                    $data['process_status']=$m_process_status;
                    $data['user_id']=$m_user_id;
                    $data['entry_date']=$m_entry_date;
                    $data['entry_time']=$m_entry_time;
                    $data['valid']=$m_valid;
                    $data['psm_id']=$m_psm_id;
                    $data['r_in_time']=$m_in_time;
                    $data['p_in_time']=$m_in_time_graced;
                    $data['p_out_time']=$m_out_time;
                    $data['day_status']=$daysts;
                    $data['status']=$sts;
                    $data['psm_id']=$m_psm_id;

                    DB::table("$m_table")->insert($data);
           
            } //foreach ($m_employee_info as $row_emp_info){
        
            return "$m_atten_date Data Process 01 Successfully with $m_table create";


           // return "Table Create";

        }




    }//public function AutoAttProcess01()
}
