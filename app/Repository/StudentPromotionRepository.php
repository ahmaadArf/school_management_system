<?php


namespace App\Repository;


use App\Models\Grade;
use App\Models\Student;
use App\Models\promotion;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Repository\StudentPromotionRepositoryInterface;

class StudentPromotionRepository implements StudentPromotionRepositoryInterface
{

    public function index()
    {
        $Grades = Grade::all();
        return view('pages.Students.promotion.index',compact('Grades'));
    }
    public function create()
    {
        $promotions = promotion::all();
        return view('pages.Students.promotion.management',compact('promotions'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            // student::where('Grade_id',$request->Grade_id)
            // ->where('Classroom_id',   $request->Classroom_id)
            // ->where('section_id',$request->section_id)
            // ->get();

            $students = student::where('Grade_id',$request->Grade_id)
            ->where('Classroom_id',   $request->Classroom_id)
            ->where('section_id',$request->section_id)
            ->where('academic_year',$request->academic_year)
            ->get();

            if($students->count() < 1){
                return redirect()->back()->with('error_promotions', __('لاتوجد بيانات في جدول الطلاب'));
            }

            // update in table student
            foreach ($students as $student){

                // $ids = explode(',',$student->id);
                Student::find($student->id)
                    ->update([
                        'Grade_id'=>$request->Grade_id_new,
                        'Classroom_id'=>$request->Classroom_id_new,
                        'section_id'=>$request->section_id_new,
                        'academic_year'=>$request->academic_year_new,
                    ]);

                // insert in to promotions
                Promotion::updateOrCreate([
                    'student_id'=>$student->id,
                    'from_grade'=>$request->Grade_id,
                    'from_Classroom'=>$request->Classroom_id,
                    'from_section'=>$request->section_id,
                    'to_grade'=>$request->Grade_id_new,
                    'to_Classroom'=>$request->Classroom_id_new,
                    'to_section'=>$request->section_id_new,
                    'academic_year'=>$request->academic_year,
                    'academic_year_new'=>$request->academic_year_new,
                ]);

            }
            DB::commit();
            return redirect()->back()->
            with('msg', trans('messages.Update'))->with('type', 'success');;

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }
    public function destroy($request)
    {
        DB::beginTransaction();

        try {

            // التراجع عن الكل
            if($request->page_id ==1){

             $Promotions = Promotion::all();
             foreach ($Promotions as $Promotion){

                 //التحديث في جدول الطلاب
                 $ids = explode(',',$Promotion->student_id);
                 student::whereIn('id', $ids)
                 ->update([
                 'Grade_id'=>$Promotion->from_grade,
                 'Classroom_id'=>$Promotion->from_Classroom,
                 'section_id'=> $Promotion->from_section,
                 'academic_year'=>$Promotion->academic_year,
               ]);

                 //حذف جدول الترقيات
                 Promotion::truncate();

             }
                DB::commit();
                return redirect()->back();


            }

        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}