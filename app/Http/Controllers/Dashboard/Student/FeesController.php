<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Models\Fee;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeesRequest;

class FeesController extends Controller
{
    public function index(){

        $fees = Fee::all();
        $Grades = Grade::all();
        return view('pages.Fees.index',compact('fees','Grades'));

    }

    public function create(){

        $Grades = Grade::all();
        return view('pages.Fees.add',compact('Grades'));
    }


    public function store(StoreFeesRequest $request)
    {
        try {

             Fee::create([

                'title'=>['en' => $request->title_en, 'ar' => $request->title_ar],
                'amount'=>$request->amount,
                'Grade_id'=>$request->Grade_id,
                'Classroom_id'=>$request->Classroom_id,
                'description'=>$request->description,
                'year'=>$request->year,
                'Fee_type'=>$request->Fee_type,

             ]);

            // toastr()->success(trans('messages.success'));
            return redirect()->route('dashboard.fees.index')->
            with('msg', trans('messages.success'))->with('type', 'success');

        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id){

        $fee = Fee::findorfail($id);
        $Grades = Grade::all();
        return view('pages.Fees.edit',compact('fee','Grades'));

    }

    public function update($id,StoreFeesRequest $request)
    {
        try {
             Fee::findorfail($id)->update([
                'title'=>['en' => $request->title_en, 'ar' => $request->title_ar],
                'amount'=>$request->amount,
                'Grade_id'=>$request->Grade_id,
                'Classroom_id'=>$request->Classroom_id,
                'description'=>$request->description,
                'year'=>$request->year,
                'Fee_type'=>$request->Fee_type,

            ]);

            // toastr()->success(trans('messages.Update'));
            return redirect()->route('dashboard.fees.index')->
            with('msg', trans('messages.Update'))->with('type', 'success');;
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            Fee::destroy($id);
            return redirect()->back()->
            with('msg', trans('messages.Delete'))->with('type', 'danger');
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
