<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\section;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit', 'update']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create', 'store']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    public function index()
    {
        $sections=section::all();
        $products=products::all();
       return view('products.products',compact('sections', 'products'));
    }
    public function create()
    {

    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'product_name' => 'required|max:255',
        ], [

            'product_name.required' => 'يرجي ادخال اسم القسم',


        ]);
        products::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id
        ]);

        session()->flash('Add', 'تم اضافة المنتج بنجاح'); // Use flash instead of flush for a single message
        return redirect('/products');
    }
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    public function update(Request $request)
    {
        $id = section::where('section_name', $request->section_name)->first()->id;

        $Products = products::findOrFail($request->id);

        $Products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');

    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        products::find($id)->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/products');
    }
}
