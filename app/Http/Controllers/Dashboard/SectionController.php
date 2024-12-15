<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRole;
use App\Models\Section;

class SectionController extends Controller
{
    public function index(){
        $Grades = Grade::with(['Sections'])->get();
        $list_Grades = Grade::all();
        $teachers = Teacher::all();
        return view('pages.Sections.Sections',compact('Grades','list_Grades','teachers'));

    }
    public function getclasses($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");

        return $list_classes;
    }
    public function store(SectionRole $request)
   {
      $validated = $request->validated();
      $section=Section::create([
        'Name_Section'=>['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En],
        'Grade_id'=>$request->Grade_id,
        'Class_id'=>$request->Class_id,
        'Status'=>1
      ]);

      $section->teachers()->attach($request->teacher_id);

      return redirect()->route('dashboard.sections.index')->
        with('msg', trans('messages.success'))->with('type', 'success');

    }
    public function update(SectionRole $request){
        $validated = $request->validated();
        $section = Section::findOrFail($request->id);

        if(!$request->Status)$status = 0;
        else $status = 1;

        $section->update([
        'Name_Section'=>['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En],
        'Grade_id'=>$request->Grade_id,
        'Class_id'=>$request->Class_id,
        'Status'=>$status

        ]);
        // update pivot tABLE

        $section->teachers()->sync($request->teacher_id);


        return redirect()->route('dashboard.sections.index')->
        with('msg', trans('messages.Update'))->with('type', 'success');




    }

}
