<?php

namespace App\Http\Controllers\Dashboard\Parent;

use App\Models\Degree;
use App\Models\Student;
use App\Models\MyParent;
use App\Models\Attendance;
use App\Models\Fee_invoice;
use Illuminate\Http\Request;
use App\Models\ReceiptStudent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChildrenController extends Controller
{
    public function index()
    {

        $students = Student::where('parent_id', Auth::user()->id)->get();
        return view('pages.parents.children.index', compact('students'));
    }

    public function results($id)
    {

        $student = Student::findorFail($id);

        if ($student->parent_id !== Auth::user()->id) {
            // toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('parent.dashboard.sons.index')->
            with('msg', 'يوجد خطا في كود الطالب')->with('type', 'danger');
            ;
        }
        $degrees = Degree::where('student_id', $id)->get();

        if ($degrees->isEmpty()) {
            // toastr()->error('لا توجد نتائج لهذا الطالب');
            return redirect()->route('parent.dashboard.sons.index')->
            with('msg', 'لا توجد نتائج لهذا الطالب')->with('type', 'danger');
        }

        return view('pages.parents.degrees.index', compact('degrees'));

    }


    public function attendances()
    {
        $students = Student::where('parent_id', Auth::user()->id)->get();
        return view('pages.parents.Attendance.index', compact('students'));
    }

    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);

        $students = Student::where('parent_id', Auth::user()->id)->get();

        if ($request->student_id == 0) {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
            return view('pages.parents.Attendance.index', compact('Students', 'students'));
        } else {
            // $students = Student::find($request->student_id);
            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.parents.Attendance.index', compact('Students', 'students'));

        }

    }

    public function fees(){
        $students_ids = Student::where('parent_id', Auth::user()->id)->pluck('id');
        $Fee_invoices = Fee_invoice::whereIn('student_id',$students_ids)->get();
        return view('pages.parents.fees.index', compact('Fee_invoices'));

    }

    public function receiptStudent($id){

        $student = Student::findorFail($id);
        if ($student->parent_id !== Auth::user()->id) {
            // toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('parent.dashboard.sons.fees')->
            with('msg', 'يوجد خطا في كود الطالب')->with('type', 'danger');;
        }

        $receipt_students = ReceiptStudent::where('student_id',$id)->get();

        if ($receipt_students->isEmpty()) {
            // toastr()->error('لا توجد مدفوعات لهذا الطالب');
            return redirect()->route('parent.dashboard.sons.fees')->
            with('msg', 'لا توجد مدفوعات لهذا الطالب')->with('type', 'danger');;
        }
        return view('pages.parents.Receipt.index', compact('receipt_students'));

    }


    public function profile()
    {
        $information = MyParent::findorFail(Auth::user()->id);
        return view('pages.parents.profile', compact('information'));
    }

    public function update(Request $request, $id)
    {

        $information = MyParent::findorFail($id);

        if (!empty($request->password)) {
            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }
        // toastr()->success(trans('messages.Update'));
        return redirect()->back()->
        with('msg', trans('messages.Update'))->with('type', 'success');;


    }
}
