<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FinanceController extends Controller
{
    public function finance_bank()
    {
        $data = DB::table('pro_bank')
            ->Where('valid', '1')
            ->orderBy('bank_id', 'asc')
            ->get(); //query builder
        return view('finance.bank', compact('data'));

        // return view('finance.bank');
    }
    public function bank_store(Request $request)
    {
        $rules = [
            'txt_bank_name' => 'required',
            'txt_bank_sname' => 'required',
        ];
        $customMessages = [
            'txt_bank_name.required' => 'Bank Name is required.',
            'txt_bank_sname.required' => 'Bank Short Name is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;

        $abcd = DB::table('pro_bank')->where('bank_name', $request->txt_bank_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';

            $data = array();
            $data['bank_name'] = $request->txt_bank_name;
            $data['bank_sname'] = $request->txt_bank_sname;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_bank')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function bank_edit($id)
    {

        $m_bank = DB::table('pro_bank')->where('bank_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_bank')->Where('valid', '1')->orderBy('bank_id', 'desc')->get();
        return view('finance.bank', compact('data', 'm_bank'));
    }

    public function bank_update(Request $request)
    {
        DB::table('pro_bank')->where('bank_id', $request->txt_bank_id)->update([
            'bank_name' => $request->txt_bank_name,
            'bank_sname' => $request->txt_bank_sname,
        ]);
        return redirect(route('bank'))->with('success', 'Data Updated Successfully!');
    }

    public function finance_bank_branch()
    {
        $data = DB::table('pro_bank_branch')
            ->Where('valid', '1')
            ->orderBy('branch_id', 'asc')
            ->get(); //query builder
        return view('finance.bank_branch', compact('data'));
    }

    public function bank_branch_store(Request $request)
    {
        $rules = [
            'txt_bank_branch_name' => 'required',
        ];
        $customMessages = [
            'txt_bank_branch_name.required' => 'Bank Branch Name is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;

        $abcd = DB::table('pro_bank_branch')->where('branch_name', $request->txt_bank_branch_name)->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';

            $data = array();
            $data['branch_name'] = $request->txt_bank_branch_name;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_bank_branch')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function bank_branch_edit($id)
    {

        $m_bank_branch = DB::table('pro_bank_branch')->where('branch_id', $id)->first();
        // return response()->json($data);
        $data = DB::table('pro_bank_branch')->Where('valid', '1')->orderBy('branch_id', 'desc')->get();
        return view('finance.bank_branch', compact('data', 'm_bank_branch'));
    }

    public function bank_branch_update(Request $request)
    {
        DB::table('pro_bank_branch')->where('branch_id', $request->txt_branch_id)->update([
            'branch_name' => $request->txt_bank_branch_name,
        ]);
        return redirect(route('bank_branch'))->with('success', 'Data Updated Successfully!');
    }

    public function finance_bank_details()
    {
        $data = DB::table("pro_bank_details")
            ->join("pro_bank", "pro_bank_details.bank_id", "pro_bank.bank_id")
            ->join("pro_bank_branch", "pro_bank_details.branch_id", "pro_bank_branch.branch_id")
            ->select("pro_bank_details.*", "pro_bank.bank_name", "pro_bank.bank_sname", "pro_bank_branch.branch_name")
            ->get();

        return view('finance.bank_details', compact('data'));
    }

    public function bank_details_store(Request $request)
    {
        $rules = [
            'cbo_bank_id' => 'required|integer|between:1,200',
            'cbo_branch_id' => 'required|integer|between:1,500',
            // 'txt_swift_code' => 'required',
            'txt_bank_add' => 'required',
        ];
        $customMessages = [
            'cbo_bank_id.required' => 'Select Bank.',
            'cbo_bank_id.integer' => 'Select Bank.',
            'cbo_bank_id.between' => 'Select Bank.',

            'cbo_branch_id.required' => 'Select Branch.',
            'cbo_branch_id.integer' => 'Select Branch.',
            'cbo_branch_id.between' => 'Select Branch.',

            // 'txt_swift_code.required' => 'Swift Code is required.',
            'txt_bank_add.required' => 'Bank Branch Address is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;

        $abcd = DB::table('pro_bank_details')
            ->where('bank_id', $request->cbo_bank_id)
            ->where('branch_id', $request->cbo_branch_id)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';

            $data = array();
            $data['bank_id'] = $request->cbo_bank_id;
            $data['bank_add'] = $request->txt_bank_add;
            $data['branch_id'] = $request->cbo_branch_id;
            $data['swift_code'] = $request->txt_swift_code;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_bank_details')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function bank_details_edit($id)
    {

        $m_bank_details = DB::table('pro_bank_details')->where('bank_details_id', $id)->first();
        $data = DB::table('pro_bank_details')->where('valid', '1')->where('valid', '1')->first();


        // $m_bank_details=DB::table('pro_bank_details')
        //     ->join("pro_bank", "pro_bank_details.bank_id", "pro_bank.bank_id")
        //     ->join("pro_bank_branch", "pro_bank_details.branch_id", "pro_bank_branch.branch_id")
        //     ->select("pro_bank_details.*", "pro_bank.bank_name", "pro_bank.bank_sname", "pro_bank_branch.branch_name")
        //     ->where('bank_details_id',$id)
        //     ->first();

        // $data=DB::table('pro_bank_details')->where('valid','1')->get();

        return view('finance.bank_details', compact('data', 'm_bank_details'));
    }

    public function bank_details_update(Request $request)
    {

        DB::table('pro_bank_details')
            ->where('bank_details_id', $request->txt_bank_details_id)
            ->update([
                'bank_id' => $request->cbo_bank_id,
                'bank_add' => $request->txt_bank_add,
                'branch_id' => $request->cbo_branch_id,
                'swift_code' => $request->txt_swift_code,
            ]);
        return redirect(route('bank_details'))->with('success', 'Data Updated Successfully!');
    }

    public function finance_bank_accounts()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->get();

        $m_bank_acc_type = DB::table("pro_bank_acc_type")
            ->Where('valid', 1)
            ->get();

        // $data = DB::table("pro_bank_acc")
        //     ->join("pro_company", "pro_bank_acc.company_id", "pro_company.company_id")
        //     ->join("pro_bank_details", "pro_bank_acc.bank_details_id", "pro_bank_details.bank_details_id")
        //     ->select("pro_bank_acc.*", "pro_company.company_name","pro_bank_details.bank_id", "pro_bank_details.branch_id", "pro_bank_details.bank_add")
        //     ->get();


        return view('finance.bank_accounts', compact('user_company', 'm_bank_acc_type'));
    }

    public function bank_accounts_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,200',
            'cbo_bank_details_id' => 'required|integer|between:1,500',
            'txt_acc_no' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_bank_details_id.required' => 'Select Bank with Branch.',
            'cbo_bank_details_id.integer' => 'Select Bank with Branch.',
            'cbo_bank_details_id.between' => 'Select Bank with Branch.',

            // 'txt_swift_code.required' => 'Swift Code is required.',
            'txt_acc_no.required' => 'Account Number is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;

        $abcd = DB::table('pro_bank_acc')
            ->where('bank_details_id', $request->cbo_bank_details_id)
            ->where('acc_no', $request->txt_acc_no)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';

            $data = array();
            $data['bank_details_id'] = $request->cbo_bank_details_id;
            $data['acc_no'] = $request->txt_acc_no;
            $data['company_id'] = $request->cbo_company_id;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_bank_acc')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }
    public function bank_accounts_edit($id)
    {

        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_bank_acc = DB::table('pro_bank_acc')->where('acc_id', $id)->first();

        $m_bank_add = DB::table('pro_bank_details')
            ->where('bank_details_id', $m_bank_acc->bank_details_id)
            ->first();

        $m_bank_acc_type = DB::table("pro_bank_acc_type")
            ->Where('valid', 1)
            ->get();


        return view('finance.bank_accounts', compact('m_bank_acc', 'user_company', 'm_bank_add', 'm_bank_acc_type'));
    }

    public function bank_accounts_update(Request $request)
    {

        DB::table('pro_bank_acc')
            ->where('acc_id', $request->txt_acc_id)
            ->update([
                'bank_details_id' => $request->cbo_bank_details_id,
                'acc_no' => $request->txt_acc_no,
                'company_id' => $request->cbo_company_id,
            ]);
        return redirect(route('bank_accounts'))->with('success', 'Data Updated Successfully!');
    }

    public function BankAccType()
    {
        $data = DB::table('pro_bank_acc_type')
            ->Where('valid', '1')
            ->orderBy('bank_acc_type_id', 'asc')
            ->get(); //query builder
        return view('finance.bank_accounts_type', compact('data'));

        // return view('finance.bank');
    }

    public function BankAccTypeStore(Request $request)
    {
        $rules = [
            'txt_acc_type_name' => 'required',
        ];
        $customMessages = [
            'txt_acc_type_name.required' => 'Account Type is required.',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_user_id = Auth::user()->emp_id;

        $abcd = DB::table('pro_bank_acc_type')
            ->where('acc_type_name', $request->txt_acc_type_name)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';

            $data = array();
            $data['acc_type_name'] = $request->txt_acc_type_name;
            $data['acc_type_sname'] = $request->txt_acc_type_sname;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_bank_acc_type')->insert($data);
            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function BankAccTypeEdit($id)
    {

        $m_bank_acc_type = DB::table('pro_bank_acc_type')
            ->where('bank_acc_type_id', $id)
            ->first();

        return view('finance.bank_accounts_type', compact('m_bank_acc_type'));
    }

    public function BankAccTypeUpdate(Request $request)
    {
        DB::table('pro_bank_acc_type')
            ->where('bank_acc_type_id', $request->txt_bank_acc_type_id)
            ->update([
                'acc_type_name' => $request->txt_acc_type_name,
                'acc_type_sname' => $request->txt_acc_type_sname,
            ]);
        return redirect(route('bank_accounts_type'))->with('success', 'Data Updated Successfully!');
    }


    public function finance_create_cheque()
    {
        $m_banks = DB::table('pro_bank_details')
            ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
            ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
            ->select('pro_bank_details.*', 'pro_bank_branch.*', 'pro_bank.*')
            ->get();

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        return view('finance.create_cheque', compact('m_banks', 'user_company'));
    }

    public function finance_cheque_store(Request $request)
    {
        // return $request;
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,200',
            'cbo_bank_details_id' => 'required|integer|between:1,2000',
            'cbo_acc_id' => 'required|integer|between:1,2000',
            'txt_seq_book_no' => 'required',
            'txt_seq_total_page' => 'required',
            'txt_seq_start_no' => 'required',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'cbo_bank_details_id.required' => 'Select Bank and Branch.',
            'cbo_bank_details_id.integer' => 'Select Bank and Branch.',
            'cbo_bank_details_id.between' => 'Select Bank and Branch.',

            'cbo_acc_id.required' => 'Select Account Number.',
            'cbo_acc_id.integer' => 'Select Account Number.',
            'cbo_acc_id.between' => 'Select Account Number.',

            'txt_seq_book_no.required' => 'Cheque Book No is required!',
            'txt_seq_total_page.required' => 'Cheque Total Page is required!',
            'txt_seq_start_no.required' => 'Cheque Start Number is required!',
        ];
        $this->validate($request, $rules, $customMessages);

        //Bangladesh Date and Time Zone
        // date_default_timezone_set("Asia/Dhaka");

        $cheque_id = DB::table("pro_cheque_info")->insertGetId([
            'user_id' =>  Auth::id(),
            'bank_details_id' => $request->cbo_bank_details_id,
            'acc_id' => $request->cbo_acc_id,
            'cheque_book_no' => $request->txt_seq_book_no,
            'cheque_start_no' => $request->txt_seq_start_no,
            'page_qty' => $request->txt_seq_total_page,
            'entry_date' => date("Y-m-d"),
            'entry_time' => date("h:i:sa"),
            'valid' => 1,
        ]);

        for ($i = 0; $i < $request->txt_seq_total_page; $i++) {
            $data = array();
            $data['user_id'] = Auth::id();
            $data['cheque_id'] = $cheque_id;
            $data['bank_details_id'] = $request->cbo_bank_details_id;
            $data['acc_id'] = $request->cbo_acc_id;
            $data['cheque_no'] = $request->txt_seq_start_no + $i;
            $data['status'] = 1;
            $data['entry_date'] = date("Y-m-d");
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = 1;
            DB::table("pro_cheque_details")->insert($data);
        }

        $cheque = DB::table('pro_cheque_details')
            ->join('pro_bank_details', 'pro_cheque_details.bank_details_id', 'pro_bank_details.bank_details_id')
            ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
            ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
            ->select('pro_cheque_details.*', 'pro_bank_branch.*', 'pro_bank.*')
            ->where('cheque_id', $cheque_id)
            ->where('acc_id', $request->cbo_acc_id)
            ->get();

        // return redirect()->back()->with('success','Data Inserted Successfully!');

        return redirect()->back()->with([
            'cheque' => $cheque,
            'success' => 'Inserted Sucessfull',

        ]);
    }

    public function finance_cheque_issue()
    {
        $m_banks = DB::table('pro_bank_details')
            ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
            ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
            ->select('pro_bank_details.*', 'pro_bank_branch.*', 'pro_bank.*')
            ->get();

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        return view('finance.cheque_issue', compact('m_banks', 'user_company'));
    }

    public function finance_cheque_issue_store(Request $request)
    {
        // return $request;
        $m_user_id = Auth::user()->emp_id;

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,200',
            'txt_issue_date' => 'required',
            'txt_customer_name' => 'required',
            'txt_particulars' => 'required',
            'cbo_bank_details_id' => 'required|integer|between:1,2000',
            'cbo_acc_id' => 'required|integer|between:1,2000',
            'cbo_cheque_details_id' => 'required|integer|between:1,20000',
            'txt_cheque_date' => 'required',
            'txt_amount' => 'required',
        ];

        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

            'txt_issue_date.required' => 'Issue Date is required!',
            'txt_customer_name.required' => 'Customer Name is required!',
            'txt_particulars.required' => 'Particulars is required!',

            'cbo_bank_details_id.required' => 'Select Bank and Branch.',
            'cbo_bank_details_id.integer' => 'Select Bank and Branch.',
            'cbo_bank_details_id.between' => 'Select Bank and Branch.',

            'cbo_acc_id.required' => 'Select Account Number.',
            'cbo_acc_id.integer' => 'Select Account Number.',
            'cbo_acc_id.between' => 'Select Account Number.',

            'cbo_cheque_details_id.required' => 'Select Cheque Number.',
            'cbo_cheque_details_id.integer' => 'Select Cheque Number.',
            'cbo_cheque_details_id.between' => 'Select Cheque Number.',

            'txt_cheque_date.required' => 'Cheque Date is required!',
            'txt_amount.required' => 'Cheque Amount is required!',
        ];
        $this->validate($request, $rules, $customMessages);
        $m_user_id = Auth::user()->emp_id;

        $abcd = DB::table('pro_cheque_issue')
            ->where('cheque_details_id', $request->cbo_cheque_details_id)
            ->first();
        //dd($abcd);

        if ($abcd === null) {
            $m_valid = '1';
            $m_status = '2';

            $ci_bank_details = DB::table('pro_bank_details')
                ->where('bank_details_id', $request->cbo_bank_details_id)
                ->first();

            $data = array();
            $data['company_id'] = $request->cbo_company_id;
            $data['customer_name'] = $request->txt_customer_name;
            $data['particulars'] = $request->txt_particulars;
            $data['bank_id'] = $ci_bank_details->bank_id;
            $data['branch_id'] = $ci_bank_details->branch_id;
            $data['bank_details_id'] = $request->cbo_bank_details_id;
            $data['acc_id'] = $request->cbo_acc_id;
            $data['cheque_details_id'] = $request->cbo_cheque_details_id;
            $data['cheque_date'] = $request->txt_cheque_date;
            $data['issue_date'] = $request->txt_issue_date;
            $data['ammount'] = $request->txt_amount;
            $data['remarks'] = $request->txt_remark;
            $data['user_id'] = $m_user_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date('H:i:s');
            $data['valid'] = $m_valid;
            // dd($data);
            DB::table('pro_cheque_issue')->insert($data);

            DB::table('pro_cheque_details')
                ->where('cheque_details_id', $request->cbo_cheque_details_id)
                ->update([
                    'status' => $m_status,
                ]);

            return redirect()->back()->with('success', 'Data Inserted Successfully!');
        } else {
            $abcd1 = array('message' => 'Data duplicate', 'alert-type' => 'success');
            //dd($abcd)
            return redirect()->back()->withInput()->with('warning', 'Data already exists!!');
        }
    }

    public function cheque_issue_edit($id)
    {

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_cheque_issue = DB::table('pro_cheque_issue')->where('cheque_issue_id', $id)->first();

        $m_banks = DB::table('pro_bank_details')
            ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
            ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
            ->select('pro_bank_details.*', 'pro_bank_branch.*', 'pro_bank.*')
            ->get();

        return view('finance.cheque_issue', compact('user_company', 'm_cheque_issue', 'm_banks'));
    }

    public function cheque_issue_update(Request $request)
    {

        DB::table('pro_cheque_issue')
            ->where('cheque_issue_id', $request->txt_cheque_issue_id)
            ->update([
                'bank_details_id' => $request->cbo_bank_details_id,
                'acc_no' => $request->txt_acc_no,
                'company_id' => $request->cbo_company_id,
            ]);
        return redirect(route('bank_accounts'))->with('success', 'Data Updated Successfully!');
    }

    //FDR Information
    public function fdr_info()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->Where('employee_id', $m_user_id)
            ->pluck('company_id');

        $m_fdr_list = DB::table('pro_fdr')
            ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_fdr.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->where('pro_fdr.valid', 1)
            ->whereIn("pro_fdr.company_id", $user_company)
            ->get();


        $m_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.fdr_info', compact('m_fdr_list', 'm_company', 'm_bank', 'm_bank_branch'));
    }

    public function fdr_employee_name($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('company_id', $id)
            ->get();
        return json_encode($data);
    }

    public function fdr_info_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_bank_id' => 'required|integer|between:1,99999999',
            'cbo_branch_id' => 'required|integer|between:1,99999999',
            'txt_period' => 'required',
            'txt_fdr' => 'required',
            'txt_block' => 'required',
            'txt_issue_date' => 'required',
            'txt_maturity_date' => 'required',
            'txt_principle_amount' => 'required',
            'txt_rate' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_bank_id.required' => 'Select Bank required.',
            'cbo_bank_id.integer' => 'Select Bank required.',
            'cbo_bank_id.between' => 'Select Bank required',
            'cbo_branch_id.required' => 'Select Branch required',
            'cbo_branch_id.integer' => 'Select Branch required',
            'cbo_branch_id.between' => 'Select Branch required',
            'txt_period.required' => 'Period required',
            'txt_fdr.required' => 'FDR required',
            'txt_block.required' => 'BLOCK required',
            'txt_issue_date.required' => 'ISSUE DATE required',
            'txt_maturity_date.required' => 'MATURITY DATE required',
            'txt_principle_amount.required' => 'PRINCIPAL AMOUNT required',
            'txt_rate.required' => 'RATE required',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['fdr_name'] = $request->cbo_employee_id;
        $data['bank_id'] = $request->cbo_bank_id;
        $data['branch_id'] = $request->cbo_branch_id;
        $data['fdr_no'] = $request->txt_fdr;
        $data['block_no'] = $request->txt_block;
        $data['period'] = $request->txt_period;
        $data['issue_date'] = $request->txt_issue_date;
        $data['maturity_date'] = $request->txt_maturity_date;
        $data['principal_amount'] = $request->txt_principle_amount;
        $data['rate'] = $request->txt_rate;

        //
        $interest = ($request->txt_principle_amount * $request->txt_rate * ($request->txt_period / 12)) / 100;
        $tax = ($interest * 10) / 100;
        $data['interest'] = $interest;
        $data['tax'] =  $tax;
        $data['return_amount'] = $request->txt_principle_amount - $interest +  $tax;
        //

        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        DB::table('pro_fdr')->insert($data);
        return back()->with('success', "Add Successfully !");
    }
    public function fdr_info_edit($id)
    {
        $m_fdr_edit = DB::table('pro_fdr')
            ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_fdr.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->where('pro_fdr.fdr_id', $id)
            ->where('pro_fdr.valid', 1)
            ->first();

        $m_user_id = Auth::user()->emp_id;

        $m_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();
        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.fdr_info', compact('m_fdr_edit', 'm_company', 'm_bank', 'm_bank_branch'));
    }

    public function fdr_info_update(Request $request, $id)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_bank_id' => 'required|integer|between:1,99999999',
            'cbo_branch_id' => 'required|integer|between:1,99999999',
            'txt_period' => 'required',
            'txt_fdr' => 'required',
            'txt_block' => 'required',
            'txt_issue_date' => 'required',
            'txt_maturity_date' => 'required',
            'txt_principle_amount' => 'required',
            'txt_rate' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_bank_id.required' => 'Select Bank required.',
            'cbo_bank_id.integer' => 'Select Bank required.',
            'cbo_bank_id.between' => 'Select Bank required',
            'cbo_branch_id.required' => 'Select Branch required',
            'cbo_branch_id.integer' => 'Select Branch required',
            'cbo_branch_id.between' => 'Select Branch required',
            'txt_period.required' => 'Period required',
            'txt_fdr.required' => 'FDR required',
            'txt_block.required' => 'BLOCK required',
            'txt_issue_date.required' => 'ISSUE DATE required',
            'txt_maturity_date.required' => 'MATURITY DATE required',
            'txt_principle_amount.required' => 'PRINCIPAL AMOUNT required',
            'txt_rate.required' => 'RATE required',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['fdr_name'] = $request->cbo_employee_id;
        $data['bank_id'] = $request->cbo_bank_id;
        $data['branch_id'] = $request->cbo_branch_id;
        $data['fdr_no'] = $request->txt_fdr;
        $data['block_no'] = $request->txt_block;
        $data['period'] = $request->txt_period;
        $data['issue_date'] = $request->txt_issue_date;
        $data['maturity_date'] = $request->txt_maturity_date;
        $data['principal_amount'] = $request->txt_principle_amount;
        $data['rate'] = $request->txt_rate;

        //
        $interest = ($request->txt_principle_amount * $request->txt_rate * ($request->txt_period / 12)) / 100;
        $tax = ($interest * 10) / 100;
        $data['interest'] = $interest;
        $data['tax'] =  $tax;
        $data['return_amount'] = $request->txt_principle_amount + $interest - $tax;
        //

        DB::table('pro_fdr')->where('fdr_id', $id)->update($data);
        return redirect()->route('fdr_info')->with('success', "Updated Successfully !");
    }

    //closing_renew_list
    public function closing_renew_list()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table('pro_user_company')
            ->Where('employee_id', $m_user_id)
            ->pluck('company_id');

        $m_fdr_closing = DB::table('pro_fdr')
            ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_fdr.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->whereIn("pro_fdr.company_id", $user_company)
            ->where('pro_fdr.closing_status', 1)
            ->where('pro_fdr.renew', 0)
            ->where('pro_fdr.valid', 1)
            ->get();
        return view('finance.closing_renew_list', compact('m_fdr_closing'));
    }
    public function fdr_closing($id)
    {
        $m_fdr_closing = DB::table('pro_fdr')
            ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_fdr.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->where('pro_fdr.fdr_id', $id)
            ->where('pro_fdr.valid', 1)
            ->first();

        $m_user_id = Auth::user()->emp_id;

        $m_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();
        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.closing_renew', compact('m_fdr_closing', 'm_company', 'm_bank', 'm_bank_branch'));
    }
    public function fdr_closing_update(Request $request, $id)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_bank_id' => 'required|integer|between:1,99999999',
            'cbo_branch_id' => 'required|integer|between:1,99999999',
            'txt_period' => 'required',
            'txt_fdr' => 'required',
            'txt_block' => 'required',
            'txt_issue_date' => 'required',
            'txt_maturity_date' => 'required',
            'txt_principle_amount' => 'required',
            'txt_rate' => 'required',
            'txt_closing_date' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_bank_id.required' => 'Select Bank required.',
            'cbo_bank_id.integer' => 'Select Bank required.',
            'cbo_bank_id.between' => 'Select Bank required',
            'cbo_branch_id.required' => 'Select Branch required',
            'cbo_branch_id.integer' => 'Select Branch required',
            'cbo_branch_id.between' => 'Select Branch required',
            'txt_period.required' => 'Period required',
            'txt_fdr.required' => 'FDR required',
            'txt_block.required' => 'BLOCK required',
            'txt_issue_date.required' => 'ISSUE DATE required',
            'txt_maturity_date.required' => 'MATURITY DATE required',
            'txt_principle_amount.required' => 'PRINCIPAL AMOUNT required',
            'txt_rate.required' => 'RATE required',
            'txt_closing_date.required' => 'CLOSING DATE required',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['user_id'] = Auth::user()->emp_id;
        $data['company_id'] = $request->cbo_company_id;
        $data['fdr_name'] = $request->cbo_employee_id;
        $data['bank_id'] = $request->cbo_bank_id;
        $data['branch_id'] = $request->cbo_branch_id;
        $data['fdr_no'] = $request->txt_fdr;
        $data['block_no'] = $request->txt_block;
        $data['period'] = $request->txt_period;
        $data['issue_date'] = $request->txt_issue_date;
        $data['maturity_date'] = $request->txt_maturity_date;
        $data['principal_amount'] = $request->txt_principle_amount;
        $data['rate'] = $request->txt_rate;

        //
        $interest = ($request->txt_principle_amount * $request->txt_rate * ($request->txt_period / 12)) / 100;
        $tax = ($interest * 10) / 100;
        $data['interest'] = $interest;
        $data['tax'] =  $tax;
        $data['return_amount'] = $request->txt_principle_amount + $interest - $tax;
        //
        $data['closing_remarks'] = $request->txt_closing_remark;
        $data['closing_date'] = $request->txt_closing_date;
        $data['closing_status'] = 2;

        DB::table('pro_fdr')->where('fdr_id', $id)->update($data);
        return redirect()->route('closing_renew_list')->with('success', "FDR Closing Successfully !");
    }
    public function fdr_renew($id)
    {
        $m_fdr_renew = DB::table('pro_fdr')
            ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_fdr.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->where('pro_fdr.fdr_id', $id)
            ->where('pro_fdr.valid', 1)
            ->first();

        $m_user_id = Auth::user()->emp_id;

        $m_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.closing_renew', compact('m_fdr_renew', 'm_company', 'm_bank', 'm_bank_branch'));
    }
    public function fdr_renew_update(Request $request, $id)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_bank_id' => 'required|integer|between:1,99999999',
            'cbo_branch_id' => 'required|integer|between:1,99999999',
            'txt_period' => 'required',
            'txt_fdr' => 'required',
            'txt_block' => 'required',
            'txt_issue_date' => 'required',
            'txt_maturity_date' => 'required',
            'txt_principle_amount' => 'required',
            'txt_rate' => 'required',
            'txt_renew_remark' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_bank_id.required' => 'Select Bank required.',
            'cbo_bank_id.integer' => 'Select Bank required.',
            'cbo_bank_id.between' => 'Select Bank required',
            'cbo_branch_id.required' => 'Select Branch required',
            'cbo_branch_id.integer' => 'Select Branch required',
            'cbo_branch_id.between' => 'Select Branch required',
            'txt_period.required' => 'Period required',
            'txt_fdr.required' => 'FDR required',
            'txt_block.required' => 'BLOCK required',
            'txt_issue_date.required' => 'ISSUE DATE required',
            'txt_maturity_date.required' => 'MATURITY DATE required',
            'txt_principle_amount.required' => 'PRINCIPAL AMOUNT required',
            'txt_rate.required' => 'RATE required',
            'txt_renew_remark.required' => 'Renew Remark required',
        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        //
        $older_fdr = DB::table('pro_fdr')->where('fdr_id', $id)->first();
        $data['old_fdr_id'] = $id;
        $data['old_user_id'] = $older_fdr->user_id;
        $data['old_entry_date'] = $older_fdr->entry_date;
        $data['old_entry_time'] = $older_fdr->entry_time;
        if ($older_fdr->fdr_name) {
            $data['fdr_name'] = $older_fdr->fdr_name;
        }
        $data['company_id'] = $older_fdr->company_id;
        $data['bank_id'] = $older_fdr->bank_id;
        $data['branch_id'] = $older_fdr->branch_id;
        $data['fdr_no'] = $older_fdr->fdr_no;
        $data['block_no'] = $older_fdr->block_no;
        $data['period'] = $older_fdr->period;
        $data['issue_date'] = $older_fdr->issue_date;
        $data['maturity_date'] = $older_fdr->maturity_date;
        $data['principal_amount'] = $older_fdr->principal_amount;
        $data['rate'] = $older_fdr->rate;
        $data['interest'] = $older_fdr->interest;
        $data['tax'] =  $older_fdr->tax;
        $data['return_amount'] = $older_fdr->return_amount;
        //
        $data['renew_remarks'] = $older_fdr->txt_renew_remark;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        DB::table('pro_fdr_renew')->insert($data);

        //new fdr
        $interest = ($request->txt_principle_amount * $request->txt_rate * ($request->txt_period / 12)) / 100;
        $tax = ($interest * 10) / 100;

        DB::table('pro_fdr')->where('fdr_id', $id)
            ->update([
                'fdr_no' => $request->txt_fdr,
                'block_no' => $request->txt_block,
                'period' => $request->txt_period,
                'issue_date' => $request->txt_issue_date,
                'maturity_date' => $request->txt_maturity_date,
                'principal_amount' => $request->txt_principle_amount,
                'rate' => $request->txt_rate,
                'interest' => $interest,
                'tax' => $tax,
                'return_amount' =>  $request->txt_principle_amount + $interest - $tax,
                'renew' => 1,
                'renew_remarks' => $request->txt_renew_remark,
            ]);
        return redirect()->route('closing_renew_list')->with('success', "FDR RENEW Successfully !");
    }

    //report finance
    //cheque

    public function RptChequeIssue()
    {
        // $m_banks = DB::table('pro_bank_details')
        //     ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
        //     ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
        //     ->select('pro_bank_details.*', 'pro_bank_branch.*', 'pro_bank.*')
        //     ->get();

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_banks = DB::table('pro_bank')
            ->Where('valid', 1)
            ->get();

        $m_branchs = DB::table('pro_bank_branch')
            ->Where('valid', 1)
            ->get();


        return view('finance.rpt_cheque_issue', compact('user_company', 'm_banks', 'm_branchs'));
    }

    public function RptChequeIssueList(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,10000',
        ];

        $customMessages = [

            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',

        ];

        $this->validate($request, $rules, $customMessages);

        if ($request->cbo_bank == '0' && $request->cbo_branch == '0') {
            $ci_cheque_issue = DB::table('pro_cheque_issue')
                ->Where('company_id', $request->cbo_company_id)
                ->Where('valid', '1')
                ->get(); //query builder
            return view('finance.rpt_cheque_issue_list', compact('ci_cheque_issue'));
        } else if ($request->cbo_bank != '0' && $request->cbo_branch == '0') {
            $ci_cheque_issue = DB::table('pro_cheque_issue')
                ->Where('company_id', $request->cbo_company_id)
                ->Where('valid', '1')
                ->get(); //query builder
            return view('finance.rpt_cheque_issue_list', compact('ci_cheque_issue'));
        }
    }




    //report fdr_and_bgpg_alart_list
    public function rpt_fdr_bgpg()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        return view('finance.rpt_fdr_bgpg', compact('user_company'));
    }

    public function rpt_fdr_bgpg_list(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_fdr_bgpg' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_fdr_bgpg.required' => 'Select FDR/BGPG required',
        ];

        $this->validate($request, $rules, $customMessages);

        if ($request->cbo_fdr_bgpg == 2) //BGPG
        {
            $m_bg_pg = DB::table('pro_bgpg')
                ->join('pro_company', 'pro_bgpg.company_id', 'pro_company.company_id')
                ->join('pro_bank', 'pro_bgpg.bank_id', 'pro_bank.bank_id')
                ->join('pro_bank_branch', 'pro_bgpg.branch_id', 'pro_bank_branch.branch_id')
                ->select(
                    'pro_bgpg.*',
                    'pro_company.company_id',
                    'pro_company.company_name',
                    'pro_bank.bank_id',
                    'pro_bank.bank_name',
                    'pro_bank_branch.branch_id',
                    'pro_bank_branch.branch_name'
                )
                // ->where('pro_bgpg.renew', 0)
                ->where('pro_bgpg.closing_status', 1)
                ->where('pro_bgpg.company_id', $request->cbo_company_id)
                // ->where('pro_bgpg.issue_date', '>=', '2000-01-01')
                // ->where('pro_bgpg.expiry_date', '<=', date('Y-m-d'))
                ->get();
            return view('finance.rpt_fdr_bgpg_list', compact('m_bg_pg'));
        } elseif ($request->cbo_fdr_bgpg == 1) {
            $m_fdr = DB::table('pro_fdr')
                ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
                ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
                ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
                ->select(
                    'pro_fdr.*',
                    'pro_company.company_id',
                    'pro_company.company_name',
                    'pro_bank.bank_id',
                    'pro_bank.bank_name',
                    'pro_bank_branch.branch_id',
                    'pro_bank_branch.branch_name'
                )
                // ->where('pro_bgpg.renew', 0)
                ->where('pro_fdr.closing_status', 1)
                ->where('pro_fdr.company_id', $request->cbo_company_id)
                ->where('pro_fdr.fdr_name', $request->cbo_fdr_name)
                ->get();
            return view('finance.rpt_fdr_bgpg_list', compact('m_fdr'));
        } else {
            $all_bg_pg = DB::table('pro_bgpg')
                ->join('pro_company', 'pro_bgpg.company_id', 'pro_company.company_id')
                ->join('pro_bank', 'pro_bgpg.bank_id', 'pro_bank.bank_id')
                ->join('pro_bank_branch', 'pro_bgpg.branch_id', 'pro_bank_branch.branch_id')
                ->select(
                    'pro_bgpg.*',
                    'pro_company.company_id',
                    'pro_company.company_name',
                    'pro_bank.bank_id',
                    'pro_bank.bank_name',
                    'pro_bank_branch.branch_id',
                    'pro_bank_branch.branch_name'
                )
                // ->where('pro_bgpg.renew', 0)
                ->where('pro_bgpg.closing_status', 1)
                ->where('pro_bgpg.company_id', $request->cbo_company_id)
                // ->where('pro_bgpg.issue_date', '>=', '2000-01-01')
                // ->where('pro_bgpg.expiry_date', '<=', date('Y-m-d'))
                ->get();
            $all_fdr = DB::table('pro_fdr')
                ->join('pro_company', 'pro_fdr.company_id', 'pro_company.company_id')
                ->join('pro_bank', 'pro_fdr.bank_id', 'pro_bank.bank_id')
                ->join('pro_bank_branch', 'pro_fdr.branch_id', 'pro_bank_branch.branch_id')
                ->select(
                    'pro_fdr.*',
                    'pro_company.company_id',
                    'pro_company.company_name',
                    'pro_bank.bank_id',
                    'pro_bank.bank_name',
                    'pro_bank_branch.branch_id',
                    'pro_bank_branch.branch_name'
                )
                // ->where('pro_bgpg.renew', 0)
                ->where('pro_fdr.closing_status', 1)
                ->where('pro_fdr.company_id', $request->cbo_company_id)
                ->where('pro_fdr.fdr_name', $request->cbo_fdr_name)
                ->get();
            return view('finance.rpt_fdr_bgpg_list', compact('all_bg_pg', 'all_fdr'));
        }
    }



    //BG PG Information
    public function bg_pg_info()
    {
        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table('pro_user_company')
            ->Where('employee_id', $m_user_id)
            ->pluck('company_id');

        $m_bg_pg = DB::table('pro_bgpg')
            ->join('pro_company', 'pro_bgpg.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_bgpg.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_bgpg.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_bgpg.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->whereIn("pro_bgpg.company_id", $user_company)
            ->get();
        // $m_company = DB::table('pro_company')->where('valid', 1)->get();


        $m_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->get();

        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.bg_pg_info', compact('m_bg_pg', 'm_company', 'm_bank', 'm_bank_branch'));
    }
    public function bg_pg_info_store(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_bank_id' => 'required|integer|between:1,99999999',
            'cbo_beneficiary_type' => 'required|integer|between:1,99999999',
            'cbo_branch_id' => 'required|integer|between:1,99999999',
            'cbo_nature_bg_pg' => 'required|integer|between:1,99999999',

            'txt_tender_package_no' => 'required',
            'txt_beneficiary' => 'required',
            'txt_bgpg_no' => 'required',
            'txt_bgpg_amount' => 'required',
            'txt_margin' => 'required',
            'txt_issue_date' => 'required',
            'txt_expiry_date' => 'required',
            'txt_expence' => 'required',
            'txt_reff_name' => 'required',
            'txt_remark' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_beneficiary_type.required' => 'Select beneficiary Type required.',
            'cbo_beneficiary_type.integer' => 'Select beneficiary Type required.',
            'cbo_beneficiary_type.between' => 'Select beneficiary Type required.',
            'cbo_bank_id.required' => 'Select Bank required.',
            'cbo_bank_id.integer' => 'Select Bank required.',
            'cbo_bank_id.between' => 'Select Bank required',
            'cbo_branch_id.required' => 'Select Branch required',
            'cbo_branch_id.integer' => 'Select Branch required',
            'cbo_branch_id.between' => 'Select Branch required',
            'cbo_nature_bg_pg.required' => 'Select Nature of BG/PG required',
            'cbo_nature_bg_pg.integer' => 'Select Nature of BG/PG required',
            'cbo_nature_bg_pg.between' => 'Select Nature of BG/PG required',

            'txt_tender_package_no.required' => 'Tender Package No required.',
            'txt_beneficiary.required' => 'Beneficiary required.',
            'txt_bgpg_no.required' => 'Bg/Pg No required.',
            'txt_bgpg_amount.required' => 'Bg/Pg Amount Max(12) required.',
            'txt_margin.required' => 'Margin (%) required.',
            'txt_issue_date.required' => 'Issue Date required.',
            'txt_expiry_date.required' => 'Expiry Date required.',
            'txt_expence.required' => 'Expence Date required.',
            'txt_reff_name.required' => 'Reff. Name required.',
            'txt_remark.required' => 'Remark required.',

        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();

        $data['company_id'] = $request->cbo_company_id;
        $data['bank_id'] = $request->cbo_bank_id;
        $data['branch_id'] = $request->cbo_branch_id;
        $data['tender_package'] = $request->txt_tender_package_no;
        $data['beneficiary'] = $request->txt_beneficiary;
        $data['beneficiary_type'] = $request->cbo_beneficiary_type;
        $data['bgpg_no'] = $request->txt_bgpg_no;
        $data['issue_date'] = $request->txt_issue_date;
        $data['expiry_date'] = $request->txt_expiry_date;
        $data['bgpg_amout'] = $request->txt_bgpg_amount;
        $data['margin'] = $request->txt_margin;
        //
        $total_margin = ($request->txt_bgpg_amount * $request->txt_margin) / 100;
        $data['total_margin'] =   $total_margin;
        //
        $data['expense'] = $request->txt_expence;
        $data['nature_bgpg'] = $request->cbo_nature_bg_pg;
        $data['ref_id'] = $request->txt_reff_name;
        $data['remarks'] = $request->txt_remark;

        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date("Y-m-d");
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = 1;
        DB::table('pro_bgpg')->insert($data);
        return redirect()->route('bg_pg_info')->with('success', "BG/PG Information Inserted Successfully !");
    }
    public function bg_pg_info_edit($id)
    {
        $m_bg_pg_edit = DB::table('pro_bgpg')
            ->join('pro_company', 'pro_bgpg.company_id', 'pro_company.company_id')
            ->join('pro_bank', 'pro_bgpg.bank_id', 'pro_bank.bank_id')
            ->join('pro_bank_branch', 'pro_bgpg.branch_id', 'pro_bank_branch.branch_id')
            ->select(
                'pro_bgpg.*',
                'pro_company.company_id',
                'pro_company.company_name',
                'pro_bank.bank_id',
                'pro_bank.bank_name',
                'pro_bank_branch.branch_id',
                'pro_bank_branch.branch_name',
            )
            ->where('pro_bgpg.bgpg_id', $id)
            ->first();
        $m_company = DB::table('pro_company')->where('valid', 1)->get();
        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.bg_pg_info', compact('m_bg_pg_edit', 'm_company', 'm_bank', 'm_bank_branch'));
    }
    public function bg_pg_info_update(Request $request, $id)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99999999',
            'cbo_bank_id' => 'required|integer|between:1,99999999',
            'cbo_beneficiary_type' => 'required|integer|between:1,99999999',
            'cbo_branch_id' => 'required|integer|between:1,99999999',
            'cbo_nature_bg_pg' => 'required|integer|between:1,99999999',
            'txt_tender_package_no' => 'required',
            'txt_beneficiary' => 'required',
            'txt_bgpg_no' => 'required',
            'txt_bgpg_amount' => 'required',
            'txt_margin' => 'required',
            'txt_issue_date' => 'required',
            'txt_expiry_date' => 'required',
            'txt_expence' => 'required',
            'txt_reff_name' => 'required',
            'txt_remark' => 'required',

        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company required.',
            'cbo_company_id.integer' => 'Select Company required.',
            'cbo_company_id.between' => 'Select Company required',
            'cbo_beneficiary_type.required' => 'Select beneficiary Type required.',
            'cbo_beneficiary_type.integer' => 'Select beneficiary Type required.',
            'cbo_beneficiary_type.between' => 'Select beneficiary Type required.',
            'cbo_bank_id.required' => 'Select Bank required.',
            'cbo_bank_id.integer' => 'Select Bank required.',
            'cbo_bank_id.between' => 'Select Bank required',
            'cbo_branch_id.required' => 'Select Branch required',
            'cbo_branch_id.integer' => 'Select Branch required',
            'cbo_branch_id.between' => 'Select Branch required',
            'cbo_nature_bg_pg.required' => 'Select Nature of BG/PG required',
            'cbo_nature_bg_pg.integer' => 'Select Nature of BG/PG required',
            'cbo_nature_bg_pg.between' => 'Select Nature of BG/PG required',

            'txt_tender_package_no.required' => 'Tender Package No required.',
            'txt_beneficiary.required' => 'Beneficiary required.',
            'txt_bgpg_no.required' => 'Bg/Pg No required.',
            'txt_bgpg_amount.required' => 'Bg/Pg Amount Max(12) required.',
            'txt_margin.required' => 'Margin (%) required.',
            'txt_issue_date.required' => 'Issue Date required.',
            'txt_expiry_date.required' => 'Expiry Date required.',
            'txt_expence.required' => 'Expence Date required.',
            'txt_reff_name.required' => 'Reff. Name required.',
            'txt_remark.required' => 'Remark required.',

        ];

        $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['company_id'] = $request->cbo_company_id;
        $data['bank_id'] = $request->cbo_bank_id;
        $data['branch_id'] = $request->cbo_branch_id;
        $data['tender_package'] = $request->txt_tender_package_no;
        $data['beneficiary'] = $request->txt_beneficiary;
        $data['beneficiary_type'] = $request->cbo_beneficiary_type;
        $data['bgpg_no'] = $request->txt_bgpg_no;
        $data['issue_date'] = $request->txt_issue_date;
        $data['expiry_date'] = $request->txt_expiry_date;
        $data['bgpg_amout'] = $request->txt_bgpg_amount;
        $data['margin'] = $request->txt_margin;
        //
        $total_margin = ($request->txt_bgpg_amount * $request->txt_margin) / 100;
        $data['total_margin'] =   $total_margin;
        //
        $data['expense'] = $request->txt_expence;
        $data['nature_bgpg'] = $request->cbo_nature_bg_pg;
        $data['ref_id'] = $request->txt_reff_name;
        $data['remarks'] = $request->txt_remark;

        $data['user_id'] = Auth::user()->emp_id;
        DB::table('pro_bgpg')->where('bgpg_id', $id)->update($data);
        return redirect()->route('bg_pg_info')->with('success', "BG/PG Information Updated Successfully !");
    }




    //Fund Requsition Information
    public function fund_req()
    {
        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('pro_user_company.employee_id', $m_user_id)
            ->Where('pro_company.finance_status', '1')
            ->get();


        $m_bank = DB::table('pro_bank')->where('valid', 1)->get();
        $m_bank_branch = DB::table('pro_bank_branch')->where('valid', 1)->get();
        return view('finance.fund_req', compact('user_company', 'm_bank', 'm_bank_branch'));
    }

    public function FinanceFundReqStore(Request $request)
    {

        $rules = [
            'cbo_company_id' => 'required|integer|between:1,50',
            'txt_from_date' => 'required',
            'txt_to_date' => 'required',
            'txt_description' => 'required',
            'txt_transfer' => 'required',
            'txt_cash' => 'required',
            'txt_chq' => 'required',
        ];
        $customMessages = [
            'cbo_company_id.required' => 'Select Company.',
            'cbo_company_id.integer' => 'Select Company.',
            'cbo_company_id.between' => 'Select Company.',
            'txt_from_date.required' => 'Select From Date.',
            'txt_to_date.required' => 'Select To Date.',
            'txt_description.required' => 'Description.',
            'txt_transfer.required' => 'Transfer Amount',
            'txt_cash.required' => 'Cash Amount',
            'txt_chq.required' => 'Cheque Amount',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_company  = DB::table("pro_company")
            ->Where('company_id', $request->cbo_company_id)
            ->first();
        $txt_short_code = $m_company->short_code;

        $m_fund_req_master  = DB::table("pro_fund_req_master_$request->cbo_company_id")->orderByDesc("fund_req_master_id")->first();
        if (isset($m_fund_req_master)) {
            $txt_fund_req_master_id = "$txt_short_code" . date("Y") . str_pad((substr($m_fund_req_master->fund_req_master_id, -5) + 1), 5, '0', STR_PAD_LEFT);
        } else {
            $txt_fund_req_master_id = "$txt_short_code" . date("Y") . "00001";
        }

        // dd($txt_fund_req_master_id);

        $data = array();
        $data['fund_req_master_id'] = $txt_fund_req_master_id;
        $data['fund_req_date'] = date('Y-m-d');
        $data['company_id'] = $request->cbo_company_id;
        $data['req_form'] = $request->txt_from_date;
        $data['req_to'] = $request->txt_to_date;
        $data['user_id'] = Auth::user()->emp_id;
        $data['entry_date'] = date('Y-m-d');
        $data['entry_time'] = date("h:i:sa");
        $data['valid'] = '1';

        DB::table("pro_fund_req_master_$request->cbo_company_id")->insert($data);

        $txt_total = $request->txt_cash + $request->txt_chq;

        $data1 = array();
        $data1['fund_req_master_id'] = $txt_fund_req_master_id;
        $data1['fund_req_date'] = date('Y-m-d');
        $data1['company_id'] = $request->cbo_company_id;
        $data1['req_form'] = $request->txt_from_date;
        $data1['req_to'] = $request->txt_to_date;
        $data1['description'] = $request->txt_description;
        $data1['req_transfer'] = $request->txt_transfer;
        $data1['req_cash'] = $request->txt_cash;
        $data1['req_chq'] = $request->txt_chq;
        $data1['total_amt'] = $txt_total;
        $data1['remarks'] = $request->txt_remarks;
        $data1['user_id'] = Auth::user()->emp_id;
        $data1['entry_date'] = date('Y-m-d');
        $data1['entry_time'] = date("h:i:sa");
        $data1['valid'] = '1';

        DB::table("pro_fund_req_detail_$request->cbo_company_id")->insert($data1);

        return redirect()->route('fund_req_detail', [$txt_fund_req_master_id, $request->cbo_company_id]);
    }


    public function FinanceFundReqDetail($id, $id2)
    {

        $m_pro_fund_req_master = DB::table("pro_fund_req_master_$id2")
            ->leftJoin('pro_company', "pro_fund_req_master_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_master_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_master_$id2.fund_req_master_id", '=', $id)
            ->first();

        $m_fund_req_detail = DB::table("pro_fund_req_detail_$id2")
            ->leftJoin('pro_company', "pro_fund_req_detail_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_detail_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_detail_$id2.fund_req_master_id", '=', $id)
            ->get();

        $m_cheque_issue = DB::table("pro_cheque_issue")
            ->leftJoin('pro_bank', "pro_cheque_issue.bank_id", 'pro_bank.bank_id')
            ->leftJoin('pro_bank_branch', "pro_cheque_issue.branch_id", 'pro_bank_branch.branch_id')
            ->leftJoin('pro_bank_acc', "pro_cheque_issue.acc_id", 'pro_bank_acc.acc_id')
            ->leftJoin('pro_cheque_details', "pro_cheque_issue.cheque_details_id", 'pro_cheque_details.cheque_details_id')
            ->select(
                "pro_cheque_issue.*",
                'pro_bank.bank_sname',
                'pro_bank_branch.branch_name',
                'pro_bank_acc.acc_no',
                'pro_cheque_details.cheque_no',
            )
            ->where("pro_cheque_issue.fund_req_master_id", '=', $id)
            ->get();

        return view('finance.fund_req_detail', compact('m_pro_fund_req_master', 'm_fund_req_detail', 'm_cheque_issue'));
    }



    public function FinanceFundReqDetailStore(Request $request, $id2)
    {
        $rules = [
            'txt_description' => 'required',
            'txt_transfer' => 'required',
            'txt_cash' => 'required',
            'txt_chq' => 'required',
        ];
        $customMessages = [
            'txt_description.required' => 'Description.',
            'txt_transfer.required' => 'Transfer Amount',
            'txt_cash.required' => 'Cash Amount',
            'txt_chq.required' => 'Bank Amount',
        ];
        $this->validate($request, $rules, $customMessages);

        $txt_total = $request->txt_cash + $request->txt_chq;

        $data1 = array();
        $data1['fund_req_master_id'] = $request->txt_fund_req_master_id;
        $data1['fund_req_date'] = $request->txt_fund_req_date;
        $data1['company_id'] = $request->cbo_company_id;
        $data1['req_form'] = $request->txt_from_date;
        $data1['req_to'] = $request->txt_to_date;
        $data1['description'] = $request->txt_description;
        $data1['req_transfer'] = $request->txt_transfer;
        $data1['req_cash'] = $request->txt_cash;
        $data1['req_chq'] = $request->txt_chq;
        $data1['total_amt'] = $txt_total;
        $data1['remarks'] = $request->txt_remarks;
        $data1['user_id'] = Auth::user()->emp_id;
        $data1['entry_date'] = date('Y-m-d');
        $data1['entry_time'] = date("h:i:sa");
        $data1['valid'] = '1';

        DB::table("pro_fund_req_detail_$request->cbo_company_id")->insert($data1);

        return redirect()->route('fund_req_detail', [$request->txt_fund_req_master_id, $id2]);
    }

    //Query edit
    public function FinanceFundReqDetailQuery($id, $id2)
    {

        $m_fund_req_master = DB::table("pro_fund_req_master_$id2")
            ->leftJoin('pro_company', "pro_fund_req_master_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_master_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_master_$id2.fund_req_master_id", '=', $id)
            ->first();

        $m_fund_req_detail = DB::table("pro_fund_req_detail_$id2")
            ->leftJoin('pro_company', "pro_fund_req_detail_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_detail_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_detail_$id2.fund_req_master_id", '=', $id)
            ->get();


        return view('finance.fund_req_detail_query', compact('m_fund_req_master', 'm_fund_req_detail'));
    }

    public function FinanceFundReqDetailReEdit($id, $id2)
    {
        $m_fund_req_detail_edit = DB::table("pro_fund_req_detail_$id2")
            ->leftJoin('pro_company', "pro_fund_req_detail_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_detail_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_detail_$id2.fund_req_detail_id", '=', $id)
            ->first();
        if ($m_fund_req_detail_edit) {
            return view('finance.fund_req_detail_query', compact('m_fund_req_detail_edit'));
        } else {
            return back()->with('warning', 'Data Not Found');
        }
    }

    public function FinanceFundReqDetailReUpdate(Request $request, $id, $id2)
    {
        $rules = [
            'txt_description' => 'required',
            'txt_transfer' => 'required',
            'txt_cash' => 'required',
            'txt_chq' => 'required',
        ];

        $customMessages = [
            'txt_description.required' => 'Description.',
            'txt_transfer.required' => 'Transfer Amount',
            'txt_cash.required' => 'Cash Amount',
            'txt_chq.between' => 'Cheque Amount',
        ];
        $this->validate($request, $rules, $customMessages);

        $fund_master_id = $request->txt_fund_req_master_id;
        $txt_total = $request->txt_cash + $request->txt_chq;
        $data = array();
        $data['description'] = $request->txt_description;
        $data['req_transfer'] = $request->txt_transfer;
        $data['req_cash'] = $request->txt_cash;
        $data['req_chq'] = $request->txt_chq;
        $data['total_amt'] = $txt_total;
        $data['remarks'] = $request->txt_remarks;
        $data['status'] = 2;

        DB::table("pro_fund_req_detail_$id2")->where('fund_req_detail_id', $id)->update($data);
        return redirect()->route('FinanceFundReqDetailQuery', [$fund_master_id, $id2]);
    }

    public function FinanceFundReqDetailReFinal(Request $request)
    {
        $m_employee_id = Auth::user()->emp_id;
        $company_id = $request->txt_Final_company_id;
        $fund_master_id = $request->txt_Final_fund_req_master_id;

        $m_fund_req_check = DB::table("pro_fund_req_detail_$company_id")
            ->where("fund_req_master_id", $fund_master_id)
            ->whereIn("status", [6, 7, 8])
            ->count();

        if ($m_fund_req_check == 0) {
            DB::table("pro_fund_req_master_$company_id")
                ->where('fund_req_master_id', $fund_master_id)
                ->update([
                    'status' => 2,
                    'query_status' => NULL,
                ]);

            //App Notification 
            DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]); //disable current notification
            $m_fund_req_user = DB::table("pro_fund_req_check")
                ->where('valid', 1)
                ->where('status', 1)
                ->where('company_id', $company_id)
                ->get();
            $companies = DB::table('pro_company')
                ->select("pro_company.company_id", "pro_company.company_name")
                ->where('valid', '1')
                ->where('company_id', $company_id)
                ->first();
            $company_name = strtoupper($companies->company_name);
            $massage = "Fund Indent for $company_name Indent No: $fund_master_id";
            foreach ($m_fund_req_user as  $value) {
                DB::table('pro_alart_massage')->insert([
                    'message_id' => Auth::user()->emp_id,
                    'report_id' => $value->employee_id,
                    'massage' => $massage,
                    'refarence_id' => "finance_$fund_master_id",
                    'valid' => 1,
                    'entry_date' => date('Y-m-d'),
                    'entry_time' => date("h:i:sa"),
                ]);
            }
            //End App Notification 


            // //Send Mail
            // foreach ($m_fund_req_user as  $value) {
            //     if ($value->mail_id) {
            //         $data = array();
            //         $data['to_email'] = "razume2@gmail.com";
            //         $data['from_email'] = $value->mail_id;
            //         $data['mess'] = $massage;
            //         $data['subject'] = "Fund Indent";

            //         Mail::send('finance.mail', $data, function ($message) use ($data) {
            //             $message->to($data['to_email'], '')
            //                 ->subject($data['subject']);
            //             $message->from($data['from_email'], '');
            //         });
            //     }
            // }
            // //End Send Mail 

            return redirect()->route('fund_req')->with('success', "Update Successfully");
        } else {
            return back()->with('warning', "Not Complite Query");
        }
    }



    //End Query edit

    public function FinanceFundReqDetailEdit($id, $id2)
    {
        $m_fund_req_detail_edit = DB::table("pro_fund_req_detail_$id2")
            ->leftJoin('pro_company', "pro_fund_req_detail_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_detail_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_detail_$id2.fund_req_detail_id", '=', $id)
            ->where("pro_fund_req_detail_$id2.status", '=', 1)
            ->first();

        return view('finance.fund_req_detail', compact('m_fund_req_detail_edit'));
    }

    public function FinanceFundReqDetailUpdate(Request $request, $id, $id2)
    {
        $rules = [
            'txt_description' => 'required',
            'txt_transfer' => 'required',
            'txt_cash' => 'required',
            'txt_chq' => 'required',
        ];

        $customMessages = [
            'txt_description.required' => 'Description.',
            'txt_transfer.required' => 'Transfer Amount',
            'txt_cash.required' => 'Cash Amount',
            'txt_chq.between' => 'Cheque Amount',
        ];
        $this->validate($request, $rules, $customMessages);

        $txt_total = $request->txt_cash + $request->txt_chq;
        // dd("$txt_total -- $request->txt_cash -- $request->txt_chq");
        $data = array();
        $data['description'] = $request->txt_description;
        $data['req_transfer'] = $request->txt_transfer;
        $data['req_cash'] = $request->txt_cash;
        $data['req_chq'] = $request->txt_chq;
        $data['total_amt'] = $txt_total;
        $data['remarks'] = $request->txt_remarks;

        DB::table("pro_fund_req_detail_$id2")->where('fund_req_detail_id', $id)->update($data);

        return redirect()->route('fund_req_detail', [$request->txt_fund_req_master_id, $id2]);
    }

    //upload file
    public function FundReqFileStore(Request $request)
    {

        $file_size = 0;
        if ($request->hasFile('txt_fund_req_detail_file')) {
            $bytes = $request->file('txt_fund_req_detail_file')->getSize();
            $precision = 2;
            if ($bytes > pow(1024, 3)) {
                $file_size = round($bytes / pow(1024, 3), $precision) . 'Gb';
            } elseif ($bytes > pow(1024, 2)) {
                $file_size = round($bytes / pow(1024, 2), $precision) . 'Mb';
            } elseif ($bytes > 1024) {
                $file_size = round($bytes / 1024, $precision) . 'Kb';
            } else {
                $file_size = $bytes . 'B';
            }
        }
        $rules = [
            'txt_fund_req_detail_file' => 'required|mimes:pdf|max:5600',
        ];

        $customMessages = [
            'txt_fund_req_detail_file.required' => 'File is required!',
            'txt_fund_req_detail_file.max' => "Maxmium File Size 5 Mb! Your Uploded File Size is $file_size",
            'txt_fund_req_detail_file.mimes' => 'pdf',
        ];
        $this->validate($request, $rules, $customMessages);

        $id = $request->txt_fund_req_detail_id;
        $id2 = $request->txt_company_id;

        $m_file_check = DB::table("pro_fund_req_detail_$id2")
            ->where("fund_req_detail_id", $id)
            ->first();

        $data = array();
        $data['status'] = 2;

        //pdf
        $m_fund_req_detail_file = $request->file('txt_fund_req_detail_file');
        if ($request->hasFile('txt_fund_req_detail_file')) {

            if ($m_file_check->fund_req_detail_file && file_exists($m_file_check->fund_req_detail_file)) {
                $upload_path2 = "../docupload/sqgroup/fundreqfile/$m_file_check->fund_req_detail_file";
                unlink($upload_path2);
            }

            $filename = "$id" . '.' . $request->file('txt_fund_req_detail_file')->getClientOriginalExtension();
            $upload_path = "../docupload/sqgroup/fundreqfile/";
            $image_url = $filename;
            $m_fund_req_detail_file->move($upload_path, $filename);
            $data['fund_req_detail_file'] = $image_url;
        }
        // return $data;
        DB::table("pro_fund_req_detail_$id2")
            ->where("fund_req_detail_id", $id)
            ->update($data);

        return back()->with('success', "Upload Successfully");
    }


    //final fund req chq

    public function FinanceFundReqDetailFinal($id, $id2)
    {

        DB::table("pro_fund_req_master_$id2")
            ->where('fund_req_master_id', '=', $id)
            ->update(['status' => 2]);
        DB::table("pro_fund_req_detail_$id2")
            ->where('fund_req_master_id', '=', $id)
            ->update(['status' => 2]);

        //app notification
        $m_fund_req_check = DB::table("pro_fund_req_check")
            ->where('company_id', $id2)
            ->where('valid', 1)
            ->where('status', 1)
            ->get();
        $companies = DB::table('pro_company')
            ->select("pro_company.company_id", "pro_company.company_name")
            ->where('valid', '1')
            ->where('company_id', $id2)
            ->first();
        $company_name = strtoupper($companies->company_name);
        $massage = "Fund Indent for $company_name Indent No: $id";
        foreach ($m_fund_req_check as  $value) {
            DB::table('pro_alart_massage')->insert([
                'message_id' => Auth::user()->emp_id,
                'report_id' => $value->employee_id,
                'massage' => $massage,
                'refarence_id' => "finance_$id",
                'valid' => 1,
                'entry_date' => date('Y-m-d'),
                'entry_time' => date("h:i:sa"),
            ]);
        }
        //End app notification

        // //Send Mail
        // foreach ($m_fund_req_user as  $value) {
        //     if ($value->mail_id) {
        //         $data = array();
        //         $data['to_email'] = "razume2@gmail.com";
        //         $data['from_email'] = $value->mail_id;
        //         $data['mess'] = $massage;
        //         $data['subject'] = "Fund Indent";

        //         Mail::send('finance.mail', $data, function ($message) use ($data) {
        //             $message->to($data['to_email'], '')
        //                 ->subject($data['subject']);
        //             $message->from($data['from_email'], '');
        //         });
        //     }
        // }
        // //End Send Mail


        return redirect()->route('fund_req');
    }

    public function FundReqCheckok(Request $request)
    {

        $m_employee_id = Auth::user()->emp_id;
        $company_id = $request->txt_company_id;
        $fund_detail_id = $request->txt_fund_req_detail_id;
        $fund_master_id = $request->txt_fund_req_master_id;
        $m_status = 0;

        $fund_req_checker_lebel = DB::table('pro_fund_req_check')
            ->where('company_id', $company_id)
            ->where('employee_id', $m_employee_id)
            ->where('valid', 1)
            ->first();
        //check user lebel 
        if ($fund_req_checker_lebel) {

            //ok 
            $m_lebel = $fund_req_checker_lebel->status;
            if ($m_lebel == 1) {
                DB::table("pro_fund_req_detail_$company_id")
                    ->where('fund_req_detail_id', '=', $fund_detail_id)
                    ->update([
                        'status' => 3,
                        'first_check' => $m_employee_id,
                    ]);
            } elseif ($m_lebel == 2) {
                DB::table("pro_fund_req_detail_$company_id")
                    ->where('fund_req_detail_id', '=', $fund_detail_id)
                    ->update([
                        'status' => 4,
                        'second_check' => $m_employee_id,
                    ]);
            } elseif ($m_lebel == 3) {
                DB::table("pro_fund_req_detail_$company_id")
                    ->where('fund_req_detail_id', '=', $fund_detail_id)
                    ->update([
                        'status' => 5,
                        'approved_by' => $m_employee_id,
                    ]);
            }
            //ok 

            return back()->with('success', "Indent Check Successfull");
        } else {
            return back()->with('Warning', "Level Not Found");
        } // End check user lebel 
    }


    public function FundReqCheckQuery(Request $request)
    {
        if (empty($request->txt_query_remark)) {
            return back()->with('warning', "Query Remark is Required");
        } else {

            $m_employee_id = Auth::user()->emp_id;
            $company_id = $request->txt_modal_company_id;
            $fund_master_id = $request->txt_modal_fund_req_master_id;
            $fund_req_details_id = $request->txt_modal_fund_req_detail_id;
            $m_status = 0;

            $fund_req_checker_lebel = DB::table('pro_fund_req_check')
                ->where('company_id', $company_id)
                ->where('employee_id', $m_employee_id)
                ->where('valid', 1)
                ->first();
            //check user lebel 
            if ($fund_req_checker_lebel) {


                // Start approved status
                $m_lebel = $fund_req_checker_lebel->status;
                if ($m_lebel == 1) {
                    $m_status = 6;
                } elseif ($m_lebel == 2) {
                    $m_status = 7;
                } elseif ($m_lebel == 3) {
                    $m_status = 8;
                }
                // End approved status


                DB::table("pro_fund_req_detail_$company_id")
                    ->where('fund_req_detail_id', $fund_req_details_id)
                    ->update([
                        'status' => $m_status,
                        "query_remarks" => $request->txt_query_remark,
                        "query_user_id" => $m_employee_id
                    ]);
                return back()->with('success', "Query Successfully");
            } else {
                return back()->with('Warning', "Level Not Found");
            }  //End check user lebel 

        } //need remark

    }

    public function FundReqCheckTotalCancel(Request $request)
    {
        if (empty($request->txt_modal_remark)) {
            return back()->with('warning', "Reject Remark is Required");
        } else {

            $m_employee_id = Auth::user()->emp_id;
            $company_id = $request->txt_tcancel_company_id;
            $fund_master_id = $request->txt_tcancel_fund_req_master_id;
            $fund_req_details_id = $request->txt_tcancel_fund_req_detail_id;
            $m_status = 0;
            $checker_field = "";

            //fund req details row-> total cancel 
            DB::table("pro_fund_req_detail_$company_id")
                ->where('fund_req_detail_id', $fund_req_details_id)
                ->update([
                    'status' => 9, //9 ->total cancel
                    "reject_remarks" => $request->txt_modal_remark,
                    "reject_user_id" => $m_employee_id
                ]);
            return back()->with('success', "Reject Successfully");
        } //Remark Required
    }


    public function FundReqCheckFinal(Request $request)
    {
        $m_employee_id = Auth::user()->emp_id;
        $company_id = $request->txt_Final_company_id;
        $fund_master_id = $request->txt_Final_fund_req_master_id;
        $m_status = 0;
        $checker_field = "";

        $fund_req_checker_lebel = DB::table('pro_fund_req_check')
            ->where('company_id', $company_id)
            ->where('employee_id', $m_employee_id)
            ->where('valid', 1)
            ->first();
        //check user lebel 
        if ($fund_req_checker_lebel) {

            // Start approved status
            $m_lebel = $fund_req_checker_lebel->status;
            if ($m_lebel == 1) {
                $m_status = 3;
                $checker_field = "first_check";
            } elseif ($m_lebel == 2) {
                $m_status = 4;
                $checker_field = "second_check";
            } elseif ($m_lebel == 3) {
                $m_status = 5;
                $checker_field = "approved_by";
            }
            // End approved status


            //Final Check null /not check clik
            $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
            ->where('fund_req_master_id', $fund_master_id)
            ->whereIn('status', [6, 7, 8,"$m_status",9])
            ->count();
            if($m_fund_req_detail == 0){
              return back()->with('warning',"check all, Fund Indent");
            }


            //start master update and direction 

            $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
                ->where('fund_req_master_id', $fund_master_id)
                ->whereIn('status', [6, 7, 8])
                ->count();
            if ($m_fund_req_detail == 0) {
                DB::table("pro_fund_req_master_$company_id")
                    ->where('fund_req_master_id', $fund_master_id)
                    ->update([
                        'status' => $m_status,
                        "$checker_field" => Auth::user()->emp_id,
                    ]);
            } else {
                DB::table("pro_fund_req_master_$company_id")
                    ->where('fund_req_master_id', $fund_master_id)
                    ->update([
                        'query_status' => 1,
                        'status' => 1,
                    ]);
            }
            //start master update and direction 



            //App Notification 
            DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]); //disable current notification
            $companies = DB::table('pro_company')
                ->select("pro_company.company_id", "pro_company.company_name")
                ->where('valid', '1')
                ->where('company_id', $company_id)
                ->first();
            $company_name = strtoupper($companies->company_name);
            if ($m_lebel < 3) {
                $m_fund_req_user = DB::table("pro_fund_req_check")
                    ->where('status', ($m_lebel + 1)) //next cheeck user
                    ->where('company_id', $company_id)
                    ->where('valid', 1)
                    ->get();
                $massage = "Fund Indent for $company_name Indent N0: $fund_master_id";
                foreach ($m_fund_req_user as  $value) {
                    DB::table('pro_alart_massage')->insert([
                        'message_id' => Auth::user()->emp_id,
                        'report_id' => $value->employee_id,
                        'massage' => $massage,
                        'refarence_id' => "finance_$fund_master_id",
                        'valid' => 1,
                        'entry_date' => date('Y-m-d'),
                        'entry_time' => date("h:i:sa"),
                    ]);
                }
            } elseif ($m_lebel == 3) {
                $fund_req_master =  DB::table("pro_fund_req_master_$company_id")
                    ->where('fund_req_master_id', $fund_master_id)
                    ->first();

                if ($m_fund_req_detail == 0) {
                    $massage = "Fund Indent for $company_name (Indent N0: $fund_master_id) Approved";
                } else {
                    $massage = "Fund Indent for $company_name (Indent N0: $fund_master_id) Query";
                }
                DB::table('pro_alart_massage')->insert([
                    'message_id' => Auth::user()->emp_id,
                    'report_id' => $fund_req_master->user_id,
                    'massage' => $massage,
                    'refarence_id' => "finance_$fund_master_id",
                    'valid' => 1,
                    'entry_date' => date('Y-m-d'),
                    'entry_time' => date("h:i:sa"),
                ]);
            } //approvel 


            //End App Notification 

            return redirect()->route('fund_req_check_list')->with('success', "Fund Check Successfully");
        } else {
            return back()->with('Warning', "Level Not Found");
        }  //End check user lebel 



    }

    //Report Fund Indent 
    public function RptFundReqist()
    {
        return view('finance.rpt_fund_indent_list');
    }

    public function GetRPTFundIndentList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_fund_req_master_$company_id")
                ->leftjoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                ->leftjoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->leftjoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
                ->leftjoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
                ->leftjoin('pro_employee_info as approved', "pro_fund_req_master_$company_id.approved_by", 'approved.employee_id')
                ->select(
                    "pro_fund_req_master_$company_id.*",
                    'pro_company.company_name',
                    'pro_employee_info.employee_id',
                    'pro_employee_info.employee_name',
                    'first.employee_name as first_employee_name',
                    'second.employee_name as second_employee_name',
                    'approved.employee_name as approved_employee_name',
                )
                ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                ->where("pro_fund_req_master_$company_id.status", '>', '4')
                ->orderBy("pro_fund_req_master_$company_id.fund_req_master_id", "desc")
                ->get();
        } else {
            $data = DB::table("pro_fund_req_master_$company_id")
                ->leftjoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                ->leftjoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->leftjoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
                ->leftjoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
                ->leftjoin('pro_employee_info as approved', "pro_fund_req_master_$company_id.approved_by", 'approved.employee_id')
                ->select(
                    "pro_fund_req_master_$company_id.*",
                    'pro_company.company_name',
                    'pro_employee_info.employee_id',
                    'pro_employee_info.employee_name',
                    'first.employee_name as first_employee_name',
                    'second.employee_name as second_employee_name',
                    'approved.employee_name as approved_employee_name',
                )
                ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_fund_req_master_$company_id.fund_req_date", [$form, $to])
                ->where("pro_fund_req_master_$company_id.status", '>', '4')
                ->orderBy("pro_fund_req_master_$company_id.fund_req_master_id", "desc")
                ->get();
        }

        return response()->json($data);
    }


    public function RPTFundIndentView($fund_req_master_id, $company_id)
    {
        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->leftjoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
            ->leftjoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
            ->leftjoin('pro_employee_info as approved', "pro_fund_req_master_$company_id.approved_by", 'approved.employee_id')

            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_id',
                'pro_employee_info.employee_name',
                'first.employee_name as first_employee_name',
                'second.employee_name as second_employee_name',
                'approved.employee_name as approved_employee_name',

            )
            ->where("pro_fund_req_master_$company_id.company_id", $company_id)
            ->where("pro_fund_req_master_$company_id.fund_req_master_id", $fund_req_master_id)
            ->where("pro_fund_req_master_$company_id.status", '>', 4)
            ->first();

        $m_fund_req_detail = DB::table("pro_fund_req_detail_$company_id")
            ->where("pro_fund_req_detail_$company_id.fund_req_master_id", $m_fund_req_master->fund_req_master_id)
            ->where("pro_fund_req_detail_$company_id.status", '>', 4)
            ->get();

        $ci_cheque_issue = DB::table('pro_cheque_issue')
            ->Where('company_id', $company_id)
            ->Where('fund_req_master_id', $fund_req_master_id)
            ->Where('status', '>', '1')
            ->Where('valid', '1')
            ->get();

        return view('finance.rpt_fund_indent_view', compact('m_fund_req_master', 'm_fund_req_detail', 'ci_cheque_issue'));
    }

    public function RPTFundIndentPrint($fund_req_master_id, $company_id)
    {
        // return 'ok';
        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->leftjoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->leftjoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftjoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
            ->leftjoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
            ->leftjoin('pro_employee_info as approved', "pro_fund_req_master_$company_id.approved_by", 'approved.employee_id')

            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_id',
                'pro_employee_info.employee_name',
                'first.employee_name as first_employee_name',
                'second.employee_name as second_employee_name',
                'approved.employee_name as approved_employee_name',

            )
            ->where("pro_fund_req_master_$company_id.company_id", $company_id)
            ->where("pro_fund_req_master_$company_id.fund_req_master_id", $fund_req_master_id)
            ->where("pro_fund_req_master_$company_id.status", '>', 4)
            ->first();

        $m_fund_req_detail = DB::table("pro_fund_req_detail_$company_id")
            ->where("pro_fund_req_detail_$company_id.fund_req_master_id", $m_fund_req_master->fund_req_master_id)
            ->where("pro_fund_req_detail_$company_id.status", '>', 4)
            ->get();

        $ci_cheque_issue = DB::table('pro_cheque_issue')
            ->Where('company_id', $company_id)
            ->Where('fund_req_master_id', $fund_req_master_id)
            ->Where('status', '>', '1')
            ->Where('valid', '1')
            ->get();

        return view('finance.rpt_fund_indent_print', compact('m_fund_req_master', 'm_fund_req_detail', 'ci_cheque_issue'));
    }


    //Excel
    public function RPTFundIndentExcel($fund_req_master_id, $company_id)
    {

        $company = DB::table('pro_company')->where('company_id', $company_id)->first();
        $name =  $company == null ? '' : $company->company_name;
        //remove space 
        if ($name != '') {
            $x = explode(' ', $name);
            $y = implode('_', $x);
            $company_name = strtolower($y);
        } else {
            $company_name = '';
        }

        //File Name
        $filename = "$company_name$fund_req_master_id";
        $file_ending = "xls";

        //header info for browser
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=$filename.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");


        //tabbed character
        $sep = "\t";
        $new = "\n";

        // Column names 
        $fields = array('SL No.', 'Description', 'Transfer', 'Cash', 'Bank', 'Remarks');

        // Display column names as first row 
        $excelColume = implode($sep, array_values($fields)) . $new;
        echo $excelColume;

        // Display My data 
        $data =  DB::table("pro_fund_req_detail_$company_id")
            ->where("pro_fund_req_detail_$company_id.fund_req_master_id", $fund_req_master_id)
            ->where('status', 5)
            ->get();

        foreach ($data as $key => $row) {
            $key = $key + 1;
            $value = array("$key", "$row->description", "$row->req_cash", "$row->req_cash", "$row->req_chq", "$row->remarks");
            $result = implode($sep, array_values($value)) . $new;
            echo $result;
        }
    }


    //End Indent fund cheq


    //Start Bank cheque issue
    public function FundIndentReqist()
    {
        return view('finance.fund_indent_approved_list');
    }
    public function GetFundIndentApprovedList($company_id, $form, $to)
    {
        if ($form == 0) {
            $data = DB::table("pro_fund_req_master_$company_id")
                ->leftjoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                ->leftjoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->leftjoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
                ->leftjoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
                ->leftjoin('pro_employee_info as approved', "pro_fund_req_master_$company_id.approved_by", 'approved.employee_id')
                ->select(
                    "pro_fund_req_master_$company_id.*",
                    'pro_company.company_name',
                    'pro_employee_info.employee_id',
                    'pro_employee_info.employee_name',
                    'first.employee_name as first_employee_name',
                    'second.employee_name as second_employee_name',
                    'approved.employee_name as approved_employee_name',
                )
                ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                ->where("pro_fund_req_master_$company_id.status", '>', '4')
                ->whereNull("pro_fund_req_master_$company_id.cheque_status")
                ->orderBy("pro_fund_req_master_$company_id.fund_req_master_id", "desc")
                ->get();
        } else {
            $data = DB::table("pro_fund_req_master_$company_id")
                ->leftjoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                ->leftjoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                ->leftjoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
                ->leftjoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
                ->leftjoin('pro_employee_info as approved', "pro_fund_req_master_$company_id.approved_by", 'approved.employee_id')
                ->select(
                    "pro_fund_req_master_$company_id.*",
                    'pro_company.company_name',
                    'pro_employee_info.employee_id',
                    'pro_employee_info.employee_name',
                    'first.employee_name as first_employee_name',
                    'second.employee_name as second_employee_name',
                    'approved.employee_name as approved_employee_name',
                )
                ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                ->whereBetween("pro_fund_req_master_$company_id.fund_req_date", [$form, $to])
                ->where("pro_fund_req_master_$company_id.status", '>', '4')
                ->whereNull("pro_fund_req_master_$company_id.cheque_status")
                ->orderBy("pro_fund_req_master_$company_id.fund_req_master_id", "desc")
                ->get();
        }

        return response()->json($data);
    }
    public function FinanceFundReqBank($id, $id2)
    {

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_pro_fund_req_master = DB::table("pro_fund_req_master_$id2")
            ->leftJoin('pro_company', "pro_fund_req_master_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_master_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_master_$id2.fund_req_master_id", '=', $id)
            ->where("pro_fund_req_master_$id2.status", 5)
            ->first();

        $m_fund_req_detail = DB::table("pro_fund_req_detail_$id2")
            ->leftJoin('pro_company', "pro_fund_req_detail_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_detail_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_detail_$id2.fund_req_master_id", '=', $id)
            ->where("pro_fund_req_detail_$id2.status", 5)
            ->get();

        $m_banks = DB::table('pro_bank_details')
            ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
            ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
            ->select('pro_bank_details.*', 'pro_bank_branch.*', 'pro_bank.*')
            ->get();

        $m_cheque_issue = DB::table("pro_cheque_issue")
            ->leftJoin('pro_bank', "pro_cheque_issue.bank_id", 'pro_bank.bank_id')
            ->leftJoin('pro_bank_branch', "pro_cheque_issue.branch_id", 'pro_bank_branch.branch_id')
            ->leftJoin('pro_bank_acc', "pro_cheque_issue.acc_id", 'pro_bank_acc.acc_id')
            ->leftJoin('pro_cheque_details', "pro_cheque_issue.cheque_details_id", 'pro_cheque_details.cheque_details_id')
            ->select(
                "pro_cheque_issue.*",
                'pro_bank.bank_sname',
                'pro_bank_branch.branch_name',
                'pro_bank_acc.acc_no',
                'pro_cheque_details.cheque_no',
            )
            ->where("pro_cheque_issue.fund_req_master_id", '=', $id)
            ->get();

        $m_chq_type = DB::table('pro_cheque_type')->where('valid', 1)->get();

        $m_cheque_issue_with_file = DB::table("pro_cheque_issue")
            ->where("fund_req_master_id", $id)
            ->whereNotNull('chq_file')
            ->count();
        if ($m_cheque_issue_with_file == $m_cheque_issue->count()) {
            $final_button_status = 1;
        } else {
            $final_button_status = 0;
        }
        return view('finance.fund_req_bank', compact('m_pro_fund_req_master', 'm_fund_req_detail', 'm_banks', 'm_cheque_issue', 'm_chq_type', 'final_button_status'));
    }

    public function FinanceFundReqBankStore(Request $request, $id2)
    {
        $rules = [
            'cbo_chq_type' => 'required|integer|between:1,5',
            'txt_customer_name' => 'required',
            // 'cbo_fund_req_detail_id' => 'required',
            'cbo_bank_details_id' => 'required',
            'cbo_acc_id' => 'required',
            'cbo_cheque_details_id' => 'required',
            'txt_cheque_date' => 'required',
            'txt_amount' => 'required',
        ];
        $customMessages = [
            'cbo_chq_type.required' => 'Select Cheque Type.',
            'cbo_chq_type.integer' => 'Select Cheque Type.',
            'cbo_chq_type.between' => 'Select Cheque Type.',

            'txt_customer_name.required' => 'Customer name.',
            // 'cbo_fund_req_detail_id.required' => 'Select Indent',
            'cbo_bank_details_id.required' => 'Select Bank',
            'cbo_acc_id.required' => 'Select Account',
            'cbo_cheque_details_id.required' => 'Select Cheque No.',
            'txt_cheque_date.required' => 'Cheque date',
            'txt_amount.required' => 'Cheque Amount',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_status = '2';
        $ci_bank_details = DB::table('pro_bank_details')
            ->where('bank_details_id', $request->cbo_bank_details_id)
            ->first();

        $ci_cheque_details = DB::table('pro_cheque_details')
            ->where('cheque_details_id', $request->cbo_cheque_details_id)
            ->first();

        if ($request->cbo_chq_type == '1') {

            $ci_fund_req_detail = DB::table("pro_fund_req_detail_$id2")
                ->where('fund_req_master_id', $request->txt_fund_req_master_id)
                ->sum('req_chq');
            $txt_req_chq = $ci_fund_req_detail;
        } else if ($request->cbo_chq_type == '2') {
            $ci_fund_req_detail_cash = DB::table("pro_fund_req_detail_$id2")
                ->where('fund_req_master_id', $request->txt_fund_req_master_id)
                ->sum('req_cash');
            $txt_req_chq = $ci_fund_req_detail_cash;
        } else if ($request->cbo_chq_type == '3') {
            $ci_fund_req_detail_transfer = DB::table("pro_fund_req_detail_$id2")
                ->where('fund_req_master_id', $request->txt_fund_req_master_id)
                ->sum('req_transfer');
            $txt_req_chq = $ci_fund_req_detail_transfer;
        }


        // $txt_req_transfer=$ci_fund_req_detail->req_transfer;
        // $txt_req_chq=$ci_fund_req_detail->req_chq;


        $ci_cheque_issue = DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', $request->txt_fund_req_master_id)
            ->where('chq_type', $request->cbo_chq_type)
            ->where('company_id', $id2)
            ->sum('ammount');


        $m_txt_amount = $request->txt_amount;
        $m_cheque_issue_01 = $m_txt_amount + $ci_cheque_issue;

        // $txt_transfer_chq=$txt_req_transfer + $txt_req_chq;

        // if($m_cheque_issue_01>$ci_fund_req_detail->req_chq)
        if ($m_cheque_issue_01 > $txt_req_chq) {
            return redirect()->route('FinanceFundReqBank', [$request->txt_fund_req_master_id, $id2])->with('warning', "$request->txt_amount");
        } else {


            $data = array();
            $data['company_id'] = $request->cbo_company_id;
            $data['customer_name'] = $request->txt_customer_name;
            $data['fund_req_master_id'] = $request->txt_fund_req_master_id;
            // $data['fund_req_detail_id'] = $request->cbo_fund_req_detail_id;
            $data['chq_type'] = $request->cbo_chq_type;
            // $data['fund_req_date'] = $request->txt_fund_req_date;
            $data['bank_id'] = $ci_bank_details->bank_id;
            $data['branch_id'] = $ci_bank_details->branch_id;
            $data['bank_details_id'] = $request->cbo_bank_details_id;
            $data['acc_id'] = $request->cbo_acc_id;
            $data['cheque_details_id'] = $request->cbo_cheque_details_id;
            $data['cheque_no'] = $ci_cheque_details->cheque_no;
            $data['cheque_date'] = $request->txt_cheque_date;
            $data['issue_date'] = $request->txt_fund_req_date;
            $data['ammount'] = $request->txt_amount;
            $data['remarks'] = $request->txt_remarks;
            $data['user_id'] = Auth::user()->emp_id;
            $data['entry_date'] = date('Y-m-d');
            $data['entry_time'] = date("h:i:sa");
            $data['valid'] = '1';
            // dd($request->txt_fund_req_master_id);
            DB::table("pro_cheque_issue")->insert($data);

            DB::table('pro_cheque_details')
                ->where('cheque_details_id', $request->cbo_cheque_details_id)
                ->update([
                    'status' => $m_status,
                ]);

            return redirect()->route('FinanceFundReqBank', [$request->txt_fund_req_master_id, $id2]);
        } //if($request->txt_amount>$ci_fund_req_detail->req_chq)
    }


    public function FinanceFundReqBankEdit($id, $id2)
    {

        $m_user_id = Auth::user()->emp_id;

        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->get();

        $m_banks = DB::table('pro_bank_details')
            ->join('pro_bank_branch', 'pro_bank_details.branch_id', 'pro_bank_branch.branch_id')
            ->join('pro_bank', 'pro_bank_details.bank_id', 'pro_bank.bank_id')
            ->select('pro_bank_details.*', 'pro_bank_branch.*', 'pro_bank.*')
            ->get();


        $m_fund_req_bank_edit = DB::table("pro_cheque_issue")
            ->leftJoin('pro_company', "pro_cheque_issue.company_id", 'pro_company.company_id')
            ->leftJoin('pro_bank', "pro_cheque_issue.bank_id", 'pro_bank.bank_id')
            ->leftJoin('pro_bank_branch', "pro_cheque_issue.branch_id", 'pro_bank_branch.branch_id')
            ->leftJoin('pro_bank_acc', "pro_cheque_issue.acc_id", 'pro_bank_acc.acc_id')
            ->leftJoin('pro_cheque_details', "pro_cheque_issue.cheque_details_id", 'pro_cheque_details.cheque_details_id')
            ->leftJoin("pro_fund_req_master_$id2", "pro_cheque_issue.fund_req_master_id", "pro_fund_req_master_$id2.fund_req_master_id")

            ->select(
                "pro_cheque_issue.*",
                'pro_bank.bank_sname',
                'pro_bank_branch.branch_name',
                'pro_bank_acc.acc_no',
                'pro_cheque_details.cheque_no',
                'pro_company.company_name',
                "pro_fund_req_master_$id2.fund_req_date",
                "pro_fund_req_master_$id2.req_form",
                "pro_fund_req_master_$id2.req_to",
            )
            ->where("pro_cheque_issue.cheque_issue_id", '=', $id)
            // ->where("pro_cheque_issue.status", '=', 1)
            ->first();

        $m_chq_type = DB::table('pro_cheque_type')->where('valid', 1)->get();


        return view('finance.fund_req_bank', compact('m_fund_req_bank_edit', 'm_banks', 'm_chq_type'));
    }

    public function FinanceFundReqBankUpdate(Request $request, $id, $id2)
    {
        $rules = [
            'txt_customer_name' => 'required',
            'cbo_bank_details_id' => 'required',
            'cbo_acc_id' => 'required',
            'cbo_cheque_details_id' => 'required',
            'txt_cheque_date' => 'required',
            'txt_amount' => 'required',
        ];
        $customMessages = [
            'txt_customer_name.required' => 'Customer name.',
            'cbo_bank_details_id.required' => 'Select Bank',
            'cbo_acc_id.required' => 'Select Account',
            'cbo_cheque_details_id.required' => 'Select Cheque No.',
            'txt_cheque_date.required' => 'Cheque date',
            'txt_amount.required' => 'Cheque Amount',
        ];
        $this->validate($request, $rules, $customMessages);

        $m_status = '2';
        $ci_bank_details = DB::table('pro_bank_details')
            ->where('bank_details_id', $request->cbo_bank_details_id)
            ->first();

        $ci_cheque_details = DB::table('pro_cheque_details')
            ->where('cheque_details_id', $request->cbo_cheque_details_id)
            ->first();

        if ($request->cbo_chq_type == '1') {

            $ci_fund_req_detail = DB::table("pro_fund_req_detail_$id2")
                ->where('fund_req_master_id', $request->txt_fund_req_master_id)
                ->sum('req_chq');
            $txt_req_chq = $ci_fund_req_detail;
        } else if ($request->cbo_chq_type == '2') {
            $ci_fund_req_detail_cash = DB::table("pro_fund_req_detail_$id2")
                ->where('fund_req_master_id', $request->txt_fund_req_master_id)
                ->sum('req_cash');
            $txt_req_chq = $ci_fund_req_detail_cash;
        } else if ($request->cbo_chq_type == '3') {
            $ci_fund_req_detail_transfer = DB::table("pro_fund_req_detail_$id2")
                ->where('fund_req_master_id', $request->txt_fund_req_master_id)
                ->sum('req_transfer');
            $txt_req_chq = $ci_fund_req_detail_transfer;
        }

        $ci_cheque_issue = DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', $request->txt_fund_req_master_id)
            ->where('chq_type', $request->cbo_chq_type)
            ->where('company_id', $id2)
            ->where('cheque_issue_id', '!=', $request->cbo_chq_issue_id)
            ->sum('ammount');


        $m_txt_amount = $request->txt_amount;
        $m_cheque_issue_01 = $m_txt_amount + $ci_cheque_issue;


        if ($m_cheque_issue_01 > $txt_req_chq) {
            return redirect()->route('FinanceFundReqBank', [$request->txt_fund_req_master_id, $id2])->with('warning', "$request->txt_amount");
        } else {


            $data = array();
            $data['customer_name'] = $request->txt_customer_name;
            // $data['bank_id'] = $ci_bank_details->bank_id;
            // $data['branch_id'] = $ci_bank_details->branch_id;
            // $data['bank_details_id'] = $request->cbo_bank_details_id;
            // $data['acc_id'] = $request->cbo_acc_id;
            // $data['cheque_details_id'] = $request->cbo_cheque_details_id;
            // $data['cheque_no'] = $ci_cheque_details->cheque_no;
            $data['chq_type'] = $request->cbo_chq_type;
            $data['cheque_date'] = $request->txt_cheque_date;
            $data['issue_date'] = $request->txt_fund_req_date;
            $data['ammount'] = $request->txt_amount;
            $data['remarks'] = $request->txt_remarks;
            DB::table("pro_cheque_issue")
                ->where('cheque_issue_id', $id)
                ->update($data);

            // DB::table('pro_cheque_details')
            // ->where('cheque_details_id',$request->cbo_cheque_details_id)
            // ->update([
            //     'status'=>$m_status,
            // ]);



            return redirect()->route('FinanceFundReqBank', [$request->txt_fund_req_master_id, $id2]);
        } //if($m_cheque_issue_01>$txt_req_chq)
    }

    public function FundReqChqFile($id, $id2)
    {

        $m_cheque_issue_file = DB::table("pro_cheque_issue")
            ->leftJoin('pro_company', "pro_cheque_issue.company_id", 'pro_company.company_id')
            ->leftJoin('pro_bank', "pro_cheque_issue.bank_id", 'pro_bank.bank_id')
            ->leftJoin('pro_bank_branch', "pro_cheque_issue.branch_id", 'pro_bank_branch.branch_id')
            ->leftJoin('pro_bank_acc', "pro_cheque_issue.acc_id", 'pro_bank_acc.acc_id')
            ->select(
                "pro_cheque_issue.*",
                'pro_company.company_name',
                'pro_bank.bank_name',
                'pro_bank.bank_sname',
                'pro_bank_branch.branch_name',
                'pro_bank_acc.acc_no',
            )
            ->where("pro_cheque_issue.cheque_issue_id", '=', $id)
            ->where("pro_cheque_issue.status", '=', 0)
            ->first();

        return view('finance.fund_req_chq_file', compact('m_cheque_issue_file'));
    }

    public function FundReqChqFileStore(Request $request, $id)
    {
        $file_size = 0;
        if ($request->hasFile('txt_chq_file')) {
            $bytes = $request->file('txt_chq_file')->getSize();
            $precision = 2;
            if ($bytes > pow(1024, 3)) {
                $file_size = round($bytes / pow(1024, 3), $precision) . 'Gb';
            } elseif ($bytes > pow(1024, 2)) {
                $file_size = round($bytes / pow(1024, 2), $precision) . 'Mb';
            } elseif ($bytes > 1024) {
                $file_size = round($bytes / 1024, $precision) . 'Kb';
            } else {
                $file_size = $bytes . 'B';
            }
        }

        $rules = [
            'txt_chq_file' => 'required|mimes:pdf|max:5600',
        ];

        $customMessages = [
            'txt_chq_file.required' => 'File is required!',
            'txt_chq_file.max' => "Maxmium File Size 5 Mb! Your Uploded File Size is $file_size",
            'txt_chq_file.mimes' => 'pdf',
        ];
        $this->validate($request, $rules, $customMessages);


        $m_chqfile_check = DB::table("pro_cheque_issue")
            ->where("cheque_issue_id", $id)
            ->first();

        $data = array();

        //pdf
        $m_fund_req_chq_file = $request->file('txt_chq_file');
        if ($request->hasFile('txt_chq_file')) {

            if ($m_chqfile_check->chq_file && file_exists($m_chqfile_check->chq_file)) {
                $upload_path2 = "../docupload/sqgroup/fundreqfile/cheque/$m_chqfile_check->chq_file";
                unlink($upload_path2);
            }

            $filename = "$id" . '.' . $request->file('txt_chq_file')->getClientOriginalExtension();
            $upload_path = "../docupload/sqgroup/fundreqfile/cheque/";
            $image_url = $filename;
            $m_fund_req_chq_file->move($upload_path, $filename);
            $data['chq_file'] = $image_url;
        }
        // return $data;
        DB::table("pro_cheque_issue")
            ->where("cheque_issue_id", $id)
            ->update($data);
        return redirect()->route('FinanceFundReqBank', [$request->txt_fund_req_master_id, $request->cbo_company_id]);
    }


    public function FinanceFundReqBankFinal($id, $id2)
    {
        DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', $id)
            ->update(['status' => 2]);

        $m_chq_type = DB::table('pro_cheque_type')->where('valid', 1)->get();
        $mfalse = 0;

        foreach ($m_chq_type as $value) {
            $data1 =  DB::table("pro_cheque_issue")
                ->where('company_id', $id2)
                ->where('fund_req_master_id', $id)
                ->where('chq_type', $value->cheque_type_id)
                ->sum('ammount');

            if ($value->cheque_type_id == 1) {
                $data2 =  DB::table("pro_fund_req_detail_$id2")
                    ->where('fund_req_master_id', $id)
                    ->where('status', 5)
                    ->sum('req_chq');
            }
            if ($value->cheque_type_id == 2) {
                $data2 =  DB::table("pro_fund_req_detail_$id2")
                    ->where('fund_req_master_id', $id)
                    ->where('status', 5)
                    ->sum('req_cash');
            }
            if ($value->cheque_type_id == 3) {
                $data2 =  DB::table("pro_fund_req_detail_$id2")
                    ->where('fund_req_master_id', $id)
                    ->where('status', 5)
                    ->sum('req_transfer');
            }

            //check total amount
            if ($data1 == $data2) {
            } else {
                $mfalse = 1;
            }
        }
        //end foreach

        if ($mfalse == 1) {
        } else {
            $data2 =  DB::table("pro_fund_req_master_$id2")
                ->where('fund_req_master_id', $id)
                ->where('status', 5)
                ->update(['cheque_status' => 1]);
        }

        return redirect()->route('fund_indent_approved_list')->with('success', 'Fund Requsition Indent (bank) Successfully');
    }


    ////

















    public function FundReqFile($id, $id2)
    {

        $m_fund_req_detail_file = DB::table("pro_fund_req_detail_$id2")
            ->leftJoin('pro_company', "pro_fund_req_detail_$id2.company_id", 'pro_company.company_id')
            ->select(
                "pro_fund_req_detail_$id2.*",
                'pro_company.company_name',
            )
            ->where("pro_fund_req_detail_$id2.fund_req_detail_id", '=', $id)
            ->where("pro_fund_req_detail_$id2.status", '=', 1)
            ->first();

        return view('finance.fund_req_file', compact('m_fund_req_detail_file'));
    }



    //leave_application_list

    public function FundReqList()
    {

        $m_user_id = Auth::user()->emp_id;
        $user_company = DB::table("pro_user_company")
            ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
            ->select("pro_user_company.*", "pro_company.company_name")
            ->Where('employee_id', $m_user_id)
            ->Where('pro_company.finance_status', '1')

            ->get();

        // $mentrydate=time();
        // $m_leave_year=date("Y",$mentrydate);

        // dd($m_leave_year);
        // $user_company = DB::table("pro_user_company")
        //     ->join("pro_company", "pro_user_company.company_id", "pro_company.company_id")
        //     ->select("pro_user_company.*", "pro_company.company_name")
        //     ->Where('employee_id',$m_user_id)
        //     ->get();

        // $m_leave_info_master = DB::table('pro_leave_info_master')
        // ->Where('employee_id',$m_user_id)
        // ->Where('valid','1')
        // ->Where('leave_year',$m_leave_year)
        // ->orderby('leave_form', 'DESC')
        // ->get();

        // $m_level_step = DB::table('pro_level_step')
        // ->join("pro_employee_info", "pro_level_step.report_to_id", "pro_employee_info.employee_id")
        // ->select("pro_level_step.*", "pro_employee_info.employee_name")
        // ->Where('pro_level_step.employee_id',$m_user_id)
        // ->Where('pro_level_step.valid','1')
        // ->orderby('pro_level_step.level_step', 'ASC')
        // ->get();

        return view('finance.rpt_fund_req', compact('user_company'));
    }

    //Fund Indent Check
    public function FundReqCheckList()
    {
        return view('finance.fund_req_check_list');
    }

    public function CompanyFundReqCheckList(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',

        ];
        $this->validate($request, $rules, $customMessages);
        $m_employee_id = Auth::user()->emp_id;
        $company_id = $request->cbo_company_id;
        $fund_req_checker_lebel = DB::table('pro_fund_req_check')
            ->where('company_id', $company_id)
            ->where('employee_id', $m_employee_id)
            ->where('valid', 1)
            ->first();
        //check user lebel 
        if ($fund_req_checker_lebel) {
            //approved status
            $m_lebel = $fund_req_checker_lebel->status;
            if ($m_lebel == 1) {
                $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
                    ->join('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                    ->join('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->select(
                        "pro_fund_req_master_$company_id.*",
                        'pro_company.company_name',
                        'pro_employee_info.employee_id',
                        'pro_employee_info.employee_name',
                    )
                    ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                    ->where("pro_fund_req_master_$company_id.status", '=', 2)
                    ->get();


                return view('finance.fund_req_check_list', compact('m_fund_req_master'));
            } elseif ($m_lebel == 2) {
                $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
                    ->leftJoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                    ->leftJoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->leftJoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
                    ->select(
                        "pro_fund_req_master_$company_id.*",
                        'pro_company.company_name',
                        'pro_employee_info.employee_id',
                        'pro_employee_info.employee_name',
                        'first.employee_name as first_name',
                    )
                    ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                    ->where("pro_fund_req_master_$company_id.status", '=', 3)
                    ->get();


                return view('finance.fund_req_check_list', compact('m_fund_req_master'));
            } elseif ($m_lebel == 3) {
                $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
                    ->join('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
                    ->join('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
                    ->leftJoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
                    ->leftJoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
                    ->select(
                        "pro_fund_req_master_$company_id.*",
                        'pro_company.company_name',
                        'pro_employee_info.employee_id',
                        'pro_employee_info.employee_name',
                        'first.employee_name as first_name',
                        'second.employee_name as second_name',
                    )
                    ->where("pro_fund_req_master_$company_id.company_id", $company_id)
                    ->where("pro_fund_req_master_$company_id.status", '=', 4)
                    ->get();


                return view('finance.fund_req_check_list', compact('m_fund_req_master'));
            } else {
                return back()->with('Warning', "Level Not Found");
            } // End approved status
        } else {
            return back()->with('Warning', "Data Not Found");
        }  //End check user lebel 
    }

    public function FundReqCheck01($id, $company_id)
    {
        $m_employee_id = Auth::user()->emp_id;
        $m_status = 0;
        $fund_req_checker_lebel = DB::table('pro_fund_req_check')
            ->where('company_id', $company_id)
            ->where('employee_id', $m_employee_id)
            ->where('valid', 1)
            ->first();

        // Start approved status
        $m_lebel = $fund_req_checker_lebel->status;
        if ($m_lebel == 1) {
            $m_status = 2;
        } elseif ($m_lebel == 2) {
            $m_status = 3;
        } elseif ($m_lebel == 3) {
            $m_status = 4;
        }
        // End approved status
        $m_fund_req_detail = DB::table("pro_fund_req_detail_$company_id")
            ->where("pro_fund_req_detail_$company_id.fund_req_master_id", '=', $id)
            ->get();

        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->leftJoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as pro_employee_info_01', "pro_fund_req_master_$company_id.first_check", 'pro_employee_info_01.employee_id')
            ->leftJoin('pro_employee_info as pro_employee_info_02', "pro_fund_req_master_$company_id.second_check", 'pro_employee_info_02.employee_id')
            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_name',
                'pro_employee_info_01.employee_name as first_name',
                'pro_employee_info_02.employee_name as second_name',
            )
            ->where("pro_fund_req_master_$company_id.fund_req_master_id", '=', $id)
            ->first();
        return view('finance.fund_req_check_01', compact('m_fund_req_master', 'm_fund_req_detail', 'm_status'));
    }




    public function FundBankCheck01ok(Request $request)
    {

        $company_id = $request->txt_company_id;
        $fund_master_id = $request->txt_fund_req_master_id;
        $m_cheque_no = $request->txt_cheque;

        DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('cheque_no', '=', $m_cheque_no)
            ->update([
                'status' => 3,
            ]);

        $m_cheque_issue =  DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('status', '=', 1)
            ->count();


        if ($m_cheque_issue == 0) {

            $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->where('status', '=', 2)
                ->count();

            if ($m_fund_req_detail == 0) {

                //Start alart massage
                DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]);
                $m_fund_req_check = DB::table("pro_fund_req_check")
                    ->where('company_id', $company_id)
                    ->where('valid', 1)
                    ->get();
                $m_company = DB::table('pro_company')->where('company_id', $company_id)->first();
                $company_name = $m_company->company_name;
                $massage = "Fund Indent for $company_name";
                foreach ($m_fund_req_check as  $value) {
                    DB::table('pro_alart_massage')->insert([
                        'message_id' => Auth::user()->emp_id,
                        'report_id' => $value->employee_id_02,
                        'massage' => $massage,
                        'refarence_id' => "finance_$fund_master_id",
                        'valid' => 1,
                        'entry_date' => date('Y-m-d'),
                        'entry_time' => date("h:i:sa"),
                    ]);
                }
                //End alart massage

                return redirect()->route('fund_req_check_list');
            } else {
                return back();
            }
        } else {
            return back();
        } //if ($m_fund_req_detail==0)
    }




    //Fund Indent Second Check 
    public function FundReqCheckList2()
    {
        return view('finance.fund_req_check_list_2');
    }

    public function CompanyFundReqCheckList2(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->leftJoin('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->leftJoin('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_id',
                'pro_employee_info.employee_name',
                'first.employee_name as first_name',
            )
            ->where("pro_fund_req_master_$company_id.company_id", $company_id)
            ->where("pro_fund_req_master_$company_id.status", '=', 3)
            ->get();


        return view('finance.fund_req_check_list_2', compact('m_fund_req_master'));
    }

    public function FundReqCheck02($id, $company_id)
    {


        $m_fund_req_detail = DB::table("pro_fund_req_detail_$company_id")
            ->where("pro_fund_req_detail_$company_id.fund_req_master_id", '=', $id)
            ->where("pro_fund_req_detail_$company_id.status", '=', 3)
            ->get();

        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->join('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->join('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')

            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_id',
                'pro_employee_info.employee_name',
                'first.employee_name as first_name',
            )
            ->where("pro_fund_req_master_$company_id.fund_req_master_id", '=', $id)
            // ->where("pro_fund_req_master_$company_id.company_id", $company_id)
            // ->where("pro_fund_req_master_$company_id.status", '=',2)
            ->first();

        $m_cheque_issue = DB::table("pro_cheque_issue")
            ->leftJoin('pro_company', "pro_cheque_issue.company_id", 'pro_company.company_id')
            ->leftJoin('pro_bank', "pro_cheque_issue.bank_id", 'pro_bank.bank_id')
            ->leftJoin('pro_bank_branch', "pro_cheque_issue.branch_id", 'pro_bank_branch.branch_id')
            ->leftJoin('pro_bank_acc', "pro_cheque_issue.acc_id", 'pro_bank_acc.acc_id')
            ->leftJoin('pro_cheque_details', "pro_cheque_issue.cheque_details_id", 'pro_cheque_details.cheque_details_id')

            ->select(
                "pro_cheque_issue.*",
                'pro_bank.bank_sname',
                'pro_bank_branch.branch_name',
                'pro_bank_acc.acc_no',
                'pro_cheque_details.cheque_no',
                'pro_company.company_name',
            )
            ->where("pro_cheque_issue.fund_req_master_id", '=', $id)
            ->where("pro_cheque_issue.status", '=', 3)
            ->get();


        return view('finance.fund_req_check_02', compact('m_fund_req_master', 'm_fund_req_detail', 'm_cheque_issue'));
    }


    public function FundReqCheck02ok(Request $request)
    {

        $company_id = $request->txt_company_id;
        $fund_detail_id = $request->txt_fund_req_detail_id;
        $fund_master_id = $request->txt_fund_req_master_id;


        DB::table("pro_fund_req_detail_$company_id")
            ->where('fund_req_detail_id', '=', $fund_detail_id)
            ->update([
                'status' => 4,
                'second_check' => Auth::user()->emp_id,
            ]);

        $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('status', '=', 3)
            ->count();


        if ($m_fund_req_detail == 0) {
            DB::table("pro_fund_req_master_$company_id")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->update([
                    'status' => 4,
                    'second_check' => Auth::user()->emp_id,

                ]);

            $m_cheque_issue =  DB::table("pro_cheque_issue")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->where('status', '=', 3)
                ->count();
            if ($m_cheque_issue == 0) {
                //Start alart massage
                DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]);
                $m_fund_req_check = DB::table("pro_fund_req_check")
                    ->where('company_id', $company_id)
                    ->where('valid', 1)
                    ->get();
                $m_company = DB::table('pro_company')->where('company_id', $company_id)->first();
                $company_name = $m_company->company_name;
                $massage = "Fund Indent for $company_name";
                foreach ($m_fund_req_check as  $value) {
                    DB::table('pro_alart_massage')->insert([
                        'message_id' => Auth::user()->emp_id,
                        'report_id' => $value->employee_id_03,
                        'massage' => $massage,
                        'refarence_id' => "finance_$fund_master_id",
                        'valid' => 1,
                        'entry_date' => date('Y-m-d'),
                        'entry_time' => date("h:i:sa"),
                    ]);
                }
                //End alart massage
                return redirect()->route('fund_req_check_list_2');
            } else {
                return back();
                // return redirect()->route('FundReqCheck01',[$fund_master_id,$company_id]);
            } //if ($m_cheque_issue==0)

        } else {
            return back();
        } //if ($m_fund_req_detail==0)
    }

    public function FundBankCheck02ok(Request $request)
    {

        $company_id = $request->txt_company_id;
        $fund_master_id = $request->txt_fund_req_master_id;
        $m_cheque_no = $request->txt_cheque;

        DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('cheque_no', '=', $m_cheque_no)
            ->update([
                'status' => 4,
            ]);

        $m_cheque_issue =  DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('status', '=', 3)
            ->count();


        if ($m_cheque_issue == 0) {

            $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->where('status', '=', 3)
                ->count();

            if ($m_fund_req_detail == 0) {
                //Start alart massage
                DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]);
                $m_fund_req_check = DB::table("pro_fund_req_check")
                    ->where('company_id', $company_id)
                    ->where('valid', 1)
                    ->get();
                $m_company = DB::table('pro_company')->where('company_id', $company_id)->first();
                $company_name = $m_company->company_name;
                $massage = "Fund Indent for $company_name";
                foreach ($m_fund_req_check as  $value) {
                    DB::table('pro_alart_massage')->insert([
                        'message_id' => Auth::user()->emp_id,
                        'report_id' => $value->employee_id_03,
                        'massage' => $massage,
                        'refarence_id' => "finance_$fund_master_id",
                        'valid' => 1,
                        'entry_date' => date('Y-m-d'),
                        'entry_time' => date("h:i:sa"),
                    ]);
                }
                //End alart massage
                return redirect()->route('fund_req_check_list_2');
            } else {
                return back();
            }
        } else {
            return back();
        } //if ($m_fund_req_detail==0)
    }

    //Fund Indent Approved
    public function FundReqApprovedList()
    {
        return view('finance.fund_req_approved_list');
    }
    public function CompanyFundReqApprovedList(Request $request)
    {
        $rules = [
            'cbo_company_id' => 'required|integer|between:1,99',

        ];

        $customMessages = [
            'cbo_company_id.required' => 'Company field is required!',
            'cbo_company_id.integer' => 'Company field is required!',
            'cbo_company_id.between' => 'Company field is required!',

        ];
        $this->validate($request, $rules, $customMessages);

        $company_id = $request->cbo_company_id;

        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->join('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->join('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
            ->leftJoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_id',
                'pro_employee_info.employee_name',
                'first.employee_name as first_name',
                'second.employee_name as second_name',
            )
            ->where("pro_fund_req_master_$company_id.company_id", $company_id)
            ->where("pro_fund_req_master_$company_id.status", '=', 4)
            ->get();


        return view('finance.fund_req_approved_list', compact('m_fund_req_master'));
    }

    public function FundReqApproved($id, $company_id)
    {


        $m_fund_req_detail = DB::table("pro_fund_req_detail_$company_id")
            ->where("pro_fund_req_detail_$company_id.fund_req_master_id", '=', $id)
            ->where("pro_fund_req_detail_$company_id.status", '=', 4)
            ->get();

        $m_fund_req_master = DB::table("pro_fund_req_master_$company_id")
            ->join('pro_company', "pro_fund_req_master_$company_id.company_id", 'pro_company.company_id')
            ->join('pro_employee_info', "pro_fund_req_master_$company_id.user_id", 'pro_employee_info.employee_id')
            ->leftJoin('pro_employee_info as first', "pro_fund_req_master_$company_id.first_check", 'first.employee_id')
            ->leftJoin('pro_employee_info as second', "pro_fund_req_master_$company_id.second_check", 'second.employee_id')
            ->select(
                "pro_fund_req_master_$company_id.*",
                'pro_company.company_name',
                'pro_employee_info.employee_id',
                'pro_employee_info.employee_name',
                'first.employee_name as first_name',
                'second.employee_name as second_name',
            )
            ->where("pro_fund_req_master_$company_id.fund_req_master_id", '=', $id)
            // ->where("pro_fund_req_master_$company_id.company_id", $company_id)
            // ->where("pro_fund_req_master_$company_id.status", '=',2)
            ->first();

        $m_cheque_issue = DB::table("pro_cheque_issue")
            ->leftJoin('pro_company', "pro_cheque_issue.company_id", 'pro_company.company_id')
            ->leftJoin('pro_bank', "pro_cheque_issue.bank_id", 'pro_bank.bank_id')
            ->leftJoin('pro_bank_branch', "pro_cheque_issue.branch_id", 'pro_bank_branch.branch_id')
            ->leftJoin('pro_bank_acc', "pro_cheque_issue.acc_id", 'pro_bank_acc.acc_id')
            ->leftJoin('pro_cheque_details', "pro_cheque_issue.cheque_details_id", 'pro_cheque_details.cheque_details_id')

            ->select(
                "pro_cheque_issue.*",
                'pro_bank.bank_sname',
                'pro_bank_branch.branch_name',
                'pro_bank_acc.acc_no',
                'pro_cheque_details.cheque_no',
                'pro_company.company_name',
            )
            ->where("pro_cheque_issue.fund_req_master_id", '=', $id)
            ->where("pro_cheque_issue.status", '=', 4)
            ->get();


        return view('finance.fund_req_approved', compact('m_fund_req_master', 'm_fund_req_detail', 'm_cheque_issue'));
    }

    public function FundReqApprovedok(Request $request)
    {

        $company_id = $request->txt_company_id;
        $fund_detail_id = $request->txt_fund_req_detail_id;
        $fund_master_id = $request->txt_fund_req_master_id;


        DB::table("pro_fund_req_detail_$company_id")
            ->where('fund_req_detail_id', '=', $fund_detail_id)
            ->update([
                'status' => 5,
                'approved_by' => Auth::user()->emp_id,
            ]);

        $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('status', '=', 4)
            ->count();


        if ($m_fund_req_detail == 0) {
            DB::table("pro_fund_req_master_$company_id")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->update([
                    'status' => 5,
                    'approved_by' => Auth::user()->emp_id,

                ]);

            $m_cheque_issue =  DB::table("pro_cheque_issue")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->where('status', '=', 4)
                ->count();
            if ($m_cheque_issue == 0) {
                DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]);
                return redirect()->route('fund_req_approved_list');
            } else {
                return back();
                // return redirect()->route('FundReqCheck01',[$fund_master_id,$company_id]);
            } //if ($m_cheque_issue==0)

        } else {
            return back();
        } //if ($m_fund_req_detail==0)
    }

    public function FundBankApprovedok(Request $request)
    {

        $company_id = $request->txt_company_id;
        $fund_master_id = $request->txt_fund_req_master_id;
        $m_cheque_no = $request->txt_cheque;

        DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('cheque_no', '=', $m_cheque_no)
            ->update([
                'status' => 5,
            ]);

        $m_cheque_issue =  DB::table("pro_cheque_issue")
            ->where('fund_req_master_id', '=', $fund_master_id)
            ->where('status', '=', 4)
            ->count();


        if ($m_cheque_issue == 0) {

            $m_fund_req_detail =  DB::table("pro_fund_req_detail_$company_id")
                ->where('fund_req_master_id', '=', $fund_master_id)
                ->where('status', '=', 4)
                ->count();

            if ($m_fund_req_detail == 0) {
                DB::table('pro_alart_massage')->where('refarence_id', "finance_$fund_master_id")->update(['valid' => 0]);
                return redirect()->route('fund_req_approved_list');
            } else {
                return back();
            }
        } else {
            return back();
        } //if ($m_fund_req_detail==0)
    }











    //Ajax call get- Employee
    public function GetEmployee($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('working_status', '1')
            ->where('ss', '1')
            ->where('company_id', $id)
            ->get();
        return json_encode($data);
    }

    public function GetBranchAdd($id)
    {
        $data = DB::table('pro_bank_details')
            ->where('bank_details_id', $id)
            ->first();
        return json_encode($data);
    }
    public function GetAccNo($id, $id2)
    {
        return $data = DB::table("pro_bank_acc")
            ->where('bank_details_id', $id)
            ->where('company_id', $id2)
            ->get();
        if ($data) {
            return response()->json($data);
        }
    }
    public function GetChequeNo($id)
    {
        $data = DB::table("pro_cheque_details")
            ->where('acc_id', $id)
            ->where('status', 1)
            ->get();
        return response()->json($data);
    }

    //Reff Namebg pg ajax
    public function bg_pg_reff_name($id)
    {
        $data = DB::table('pro_employee_info')
            ->where('company_id', $id)
            ->get();
        return json_encode($data);
    }
}
