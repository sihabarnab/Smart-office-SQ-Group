<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        return view('admin/home');
    }
    public function hrm()
    {
        return view('hrm/home');
    }
    public function itinventory()
    {
        return view('itinventory/home');
    }
    public function deed()
    {
        return view('deed/home');
    }
    public function finance()
    {
        return view('finance/home');
    }
    public function purchase()
    {
        return view('purchase/home');
    }
    public function inventory()
    {
        return view('inventory/home');
    }
    public function sales()
    {
        return view('sales/home');
    }
    public function file_manager()
    {
        return view('file_manager/home');
    }

}
