<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\StudentGraduatedRepositoryInterface;

class GraduatedController extends Controller
{
    protected $Graduated;

    public function __construct(StudentGraduatedRepositoryInterface $Graduated)
    {
        $this->Graduated = $Graduated;
    }

    public function index()
    {
       return $this->Graduated->index();
    }

    public function create()
    {
        return $this->Graduated->create();
    }

    public function store(Request $request)
    {
        return $this->Graduated->SoftDelete($request);
    }

    public function update($id)
    {
        return $this->Graduated->ReturnData($id);
    }

    public function destroy($id)
    {
       return $this->Graduated->destroy($id);
    }

    public function edit($id){

       Student::find($id)->Delete();
        return redirect()->route('dashboard.students.index')->
        with('msg', trans('messages.Update'))->with('type', 'success');
    }


}
