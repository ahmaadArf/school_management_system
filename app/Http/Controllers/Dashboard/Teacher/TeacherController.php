<?php

namespace App\Http\Controllers\Dashboard\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\TeacherRepositoryInterface;

class TeacherController extends Controller
{
    protected $teacher;

    public function __construct(TeacherRepositoryInterface $teacher)
    {

        $this->teacher = $teacher;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = $this->teacher->getAllTeachers();
        return view('pages.Teachers.index',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = $this->teacher->Getspecialization();
        $genders = $this->teacher->GetGender();
        return view('pages.Teachers.create',compact('specializations','genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->teacher->StoreTeachers($request);

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
        $teacher = $this->teacher->editTeachers($id);
        $specializations = $this->teacher->Getspecialization();
        $genders = $this->teacher->GetGender();
        return view('pages.Teachers.edit',compact('teacher','specializations','genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->teacher->UpdateTeachers($request);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->teacher->DeleteTeachers( $id);

    }
}
