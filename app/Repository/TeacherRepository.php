<?php

namespace App\Repository;
use Exception;
use App\Models\Gender;
use App\Models\Teacher;
use App\Models\Specialization;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface{

  public function getAllTeachers(){
      return Teacher::all();
  }

    public function Getspecialization(){
        return specialization::all();
    }

    public function GetGender(){
       return Gender::all();
    }

    public function StoreTeachers($request){

    try {
            Teacher::create([
                'Email'=>$request->Email,
                // 'Password'=>Hash::make($request->Password),
                'Password'=>Hash::make($request->Password),
                'Name'=>['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'Specialization_id'=>$request->Specialization_id,
                'Gender_id'=>$request->Gender_id,
                'Joining_Date'=>$request->Joining_Date,
                'Address'=>$request->Address,
            ]);


            return redirect()->route('dashboard.teachers.index')->
            with('msg', trans('messages.success'))->with('type', 'success');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function editTeachers($id)
    {
        return Teacher::findOrFail($id);
    }


    public function UpdateTeachers($request)
    {
        try {
            $teacher = Teacher::findOrFail($request->id);
            $teacher->update([
                'Email'=>$request->Email,
                'Password'=>Hash::make($request->Password),
                'Name'=>['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'Specialization_id'=>$request->Specialization_id,
                'Gender_id'=>$request->Gender_id,
                'Joining_Date'=>$request->Joining_Date,
                'Address'=>$request->Address,
            ]);
            return redirect()->route('dashboard.teachers.index')->
            with('msg', trans('messages.Update'))->with('type', 'success');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function DeleteTeachers($id)
    {
        Teacher::findOrFail($id)->delete();
        return redirect()->route('dashboard.teachers.index')->
        with('msg', trans('messages.Delete'))->with('type', 'danger');
    }



}
