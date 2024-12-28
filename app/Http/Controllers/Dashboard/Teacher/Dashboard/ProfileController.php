<?php

namespace App\Http\Controllers\Dashboard\Teacher\Dashboard;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {

        $information = Teacher::findorFail(Auth::user()->id);
        return view('pages.Teachers.dashboard.profile', compact('information'));

    }

    public function update(Request $request, $id)
    {

        $teacher = Teacher::findorFail($id);

        if (!empty($request->password)) {
            $teacher->update([
                'name'=>['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'password'=> Hash::make($request->password)

            ]);
        }
        else
        {
            $teacher->update([
                'name'=>['en' => $request->Name_en, 'ar' => $request->Name_ar],
            ]);
        }
        // toastr()->success(trans('messages.Update'));
        return redirect()->back()->
        with('msg', trans('messages.Update'))->with('type', 'success');;


    }
}
