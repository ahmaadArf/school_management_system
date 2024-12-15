<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Requests\GradesRole;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grades=Grade::all();
        return view('pages.Grades.Grades',compact('Grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradesRole $request)
    {
        $request->validated();
        if (Grade::where('Name->ar', $request->Name)->orWhere('Name->en',$request->Name_en)->exists()) {

            return redirect()->back()->withErrors(trans('Grades_trans.exists'));
        }
        Grade::create([
            'Name'=>['en'=>$request->Name_en,'ar'=>$request->Name],
            'Notes'=>$request->Notes
        ]);
        return redirect()->route('dashboard.grades.index')->
        with('msg', trans('messages.success'))->with('type', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradesRole $request, string $id)
    {
        $request->validated();
        $grade=Grade::findOrFail($id);
        $grade->update([
            'Name'=>['en'=>$request->Name_en,'ar'=>$request->Name],
            'Notes'=>$request->Notes
        ]);
        return redirect()->route('dashboard.grades.index')->
        with('msg', trans('messages.Update'))->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grade=Grade::findOrFail($id);

        if(count($grade->Classrooms)!=0){
            return redirect()->route('dashboard.grades.index')->
            with('msg', trans('Grades_trans.delete_Grade_Error'))->with('type', 'danger');
        }
        $grade->delete();
        return redirect()->route('dashboard.grades.index')->
        with('msg', trans('messages.Delete'))->with('type', 'danger');
    }
}
