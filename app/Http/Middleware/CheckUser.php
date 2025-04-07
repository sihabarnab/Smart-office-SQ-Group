<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $m_employee = DB::table('pro_employee_info')->where('employee_id', Auth::user()->emp_id)->first();
        if ($m_employee->valid != 1 || $m_employee->working_status != 1) {
            Auth::logout();
            return redirect()->route('login');
        }
         return $next($request);
    }
}
