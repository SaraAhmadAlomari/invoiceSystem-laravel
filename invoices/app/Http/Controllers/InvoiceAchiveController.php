<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
class InvoiceAchiveController extends Controller
{

    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('Invoices.Archive_Invoices',compact('invoices'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  public function update(Request $request)
    {
         $id = $request->invoice_id;
         $flight = invoices::withTrashed()->where('id', $id)->restore();
         session()->flash('restore_invoice','تم الغاء الارشفة');
         return redirect('/invoices');
    }

    public function destroy(Request $request)
    {
         $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
         $invoices->forceDelete();
         session()->flash('delete_invoice');
         return redirect('/Archive');

    }
}
