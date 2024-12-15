<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassroomRole;
use App\Models\Classroom;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grades=Grade::all();
        $Classrooms=Classroom::all();
        return view('pages.My_Classes.My_Classes',compact('Grades','Classrooms'));
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
    public function store(ClassroomRole $request)
    {
        $List_Classes = $request->List_Classes;
        $validated = $request->validated();
        foreach ($List_Classes as $List_Class) {

            Classroom::create([
                'Name_Class'=>['en'=>$List_Class['Name_class_en'],'ar'=>$List_Class['Name']],
                'Grade_id'=>$List_Class['Grade_id']

            ]);



        }
        return redirect()->route('dashboard.classrooms.index')->
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomRole $request, string $id)
    {
        $request->validated();
        $classroom=Classroom::findOrFail($id);
        $classroom->update([
            'Name_Class'=>['en'=>$request->Name_en,'ar'=>$request->Name],
            'Grade_id'=>$request->Grade_id
        ]);
        return redirect()->route('dashboard.classrooms.index')->
        with('msg', trans('messages.Update'))->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Classroom::findOrFail($id)->delete();
        return redirect()->route('dashboard.classrooms.index')->
        with('msg', trans('messages.Delete'))->with('type', 'danger');
    }

    public function Filter_Classes(Request $request){

        $Grades = Grade::all();
        $Search = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        return view('pages.My_Classes.My_Classes',compact('Grades','Search'));
    }
    public function delete_all(Request $request)
    {
        $delete_all_ids = explode(',', $request->delete_all_id);
        Classroom::whereIn('id',$delete_all_ids)->delete();

        // foreach($delete_all_ids as $id){
        //     Classroom::find($id)->delete();
        // }
        return redirect()->route('dashboard.classrooms.index')->
        with('msg', trans('messages.Delete'))->with('type', 'danger');

    }
}
