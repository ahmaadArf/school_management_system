<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Grade;
use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\AttachFilesTrait;

class LibraryController extends Controller
{
    use AttachFilesTrait;

    public function index()
    {
        $books = Library::all();
        return view('pages.library.index',compact('books'));
    }

    public function create()
    {
        $grades = Grade::all();
        return view('pages.library.create',compact('grades'));
    }

    public function store(Request $request)
    {
        try {
            Library::create([
                'title'=>$request->title,
                'Grade_id'=>$request->Grade_id,
                'classroom_id'=>$request->Classroom_id,
                'section_id'=>$request->section_id,
                'file_name'=>$request->file('file_name')->getClientOriginalName(),
                'teacher_id'=>2



            ]);
            $this->uploadFile($request);
            return redirect()->route('dashboard.library.index')->
            with('msg', trans('messages.success'))->with('type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $grades = Grade::all();
        $book = library::findorFail($id);
        return view('pages.library.edit',compact('book','grades'));
    }

    public function update(Request $request)
    {
        try {

            $book = library::findorFail($request->id);
            $file_name=$book->file_name;

            if($request->hasfile('file_name')){

                $this->deleteFile($book->file_name);

                $this->uploadFile($request);

                $file_name = $request->file('file_name')->getClientOriginalName();

            }

            $book->update([
                'title'=>$request->title,
                'Grade_id'=>$request->Grade_id,
                'classroom_id'=>$request->Classroom_id,
                'section_id'=>$request->section_id,
                'file_name'=>$file_name,
                'teacher_id'=>2
            ]);



            // toastr()->success(trans('messages.Update'));
            return redirect()->route('dashboard.library.index')->
            with('msg', trans('messages.Update'))->with('type', 'success');;
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $this->deleteFile($request->file_name);
        Library::destroy($request->id);
        // toastr()->error(trans('messages.Delete'));
        return redirect()->route('dashboard.library.index');
    }

    public function downloadAttachment($filename)
    {
        return response()->download(public_path('attachments/library/'.$filename));
    }
}
