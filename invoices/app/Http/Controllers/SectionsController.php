<?php

namespace App\Http\Controllers;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:الاقسام', ['only' => ['index']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create', 'store']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    public function index()
    {
        $sections=section::all();
        return view('sections.sections',compact('sections'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',


        ]);
            section::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'created_by' => (Auth::user()->name),
            ]);

            session()->flash('add', 'تم اضافة القسم بنجاح'); // Use flash instead of flush for a single message
            return redirect('/sections');
    }
    public function show(section $section)
    {
        //
    }


    public function edit(section $section)
    {
        //
    }


    public function update(Request $request)
    {
         $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required',
        ],
        [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال البيانات',

        ]);

        $sections = section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'تم تعديل القسم بنجاج');
        return redirect('/sections');
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        section::find($id)->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
