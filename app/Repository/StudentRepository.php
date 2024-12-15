<?php

namespace App\Repository;
use App\Models\Grade;
use App\Models\Image;
use App\Models\Gender;
use App\Models\Section;
use App\Models\Student;
use App\Models\MyParent;
use App\Models\Classroom;
use App\Models\My_Parent;
use App\Models\TypeBlood;
use App\Models\Type_Blood;
use App\Models\Nationalitie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repository\StudentRepositoryInterface;


class StudentRepository implements StudentRepositoryInterface{


    public function Get_Student()
    {
        $students = Student::all();
        return view('pages.Students.index',compact('students'));
    }

    public function Edit_Student($id)
    {
        $data['Grades'] = Grade::all();
        $data['parents'] = MyParent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = TypeBlood::all();
        $Students =  Student::findOrFail($id);
        return view('pages.Students.edit',$data,compact('Students'));
    }

    public function Update_Student($id,$request)
    {
        try {
            $student = Student::findorfail($id);
            $student->update([
                'name'=>['en' => $request->name_en, 'ar' => $request->name_ar],
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'gender_id'=>$request->gender_id,
                'nationalitie_id'=>$request->nationalitie_id,
                'blood_id'=>$request->blood_id,
                'Date_Birth'=>$request->Date_Birth,
                'Grade_id'=>$request->Grade_id,
                'Classroom_id'=>$request->Classroom_id,
                'section_id'=>$request->section_id,
                'parent_id'=>$request->parent_id,
                'academic_year'=>$request->academic_year,
            ]);

            return redirect()->route('dashboard.students.index')->
            with('msg', trans('messages.Update'))->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function Create_Student(){

       $data['my_classes'] = Grade::all();
       $data['parents'] = MyParent::all();
       $data['Genders'] = Gender::all();
       $data['nationals'] = Nationalitie::all();
       $data['bloods'] = TypeBlood::all();
       return view('pages.Students.add',$data);

    }

    public function Show_Student($id)
    {
        $Student = Student::findorfail($id);
        return view('pages.Students.show',compact('Student'));
    }


    public function Get_classrooms($id){
        // $grade=Grade::find($id);
        return  Grade::find($id)->Classrooms->pluck("Name_Class", "id");
        // $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
        // return $list_classes;

    }

    //Get Sections
    public function Get_Sections($id){

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }

    public function Store_Student($request){


        DB::beginTransaction();

        try {
            $student= Student::create([
                'name'=>['en' => $request->name_en, 'ar' => $request->name_ar],
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'gender_id'=>$request->gender_id,
                'nationalitie_id'=>$request->nationalitie_id,
                'blood_id'=>$request->blood_id,
                'Date_Birth'=>$request->Date_Birth,
                'Grade_id'=>$request->Grade_id,
                'Classroom_id'=>$request->Classroom_id,
                'section_id'=>$request->section_id,
                'parent_id'=>$request->parent_id,
                'academic_year'=>$request->academic_year,


             ]);

            // insert img
            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$student->name, $file->getClientOriginalName(),'upload_attachments');

                    // insert in image_table
                    Image::create([
                        'filename'=>$name,
                        'imageable_id'=>$student->id,
                        'imageable_type'=>Student::class,
                    ]);
                }
            }
            DB::commit();
            //  insert data
            return redirect()->route('dashboard.students.index')->
            with('msg', trans('messages.success'))->with('type', 'success');

        }

        catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function Delete_Student($id)
    {

        Student::destroy($id);
        return redirect()->route('dashboard.students.index')->
        with('msg', trans('messages.Delete'))->with('type', 'danger');

    }

    public function Upload_attachment($request)
    {
        foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

                    // insert in image_table
                    Image::create([
                        'filename'=>$name,
                        'imageable_id'=>$request->student_id,
                        'imageable_type'=>Student::class,
                    ]);
                }
        return redirect()->route('dashboard.students.show',$request->student_id);
    }

    public function Download_attachment($studentsname, $filename)
    {
        return response()->download(public_path('attachments/students/'.$studentsname.'/'.$filename));
    }

    public function Delete_attachment($request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);

        // Delete in data
        Image::where('id',$request->id)->where('filename',$request->filename)->delete();
        return redirect()->route('dashboard.students.show',$request->student_id);
    }


}
