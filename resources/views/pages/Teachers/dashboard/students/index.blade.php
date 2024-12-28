@extends('layouts.master')
@section('css')
@section('title')
    قائمة الحضور والغياب للطلاب
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    قائمة الحضور والغياب للطلاب
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ session('status') }}</li>
        </ul>
    </div>
@endif
@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

<h5 style="font-family: 'Cairo', sans-serif;color: red"> تاريخ اليوم : {{ date('Y-m-d') }}</h5>
<form action="{{ route('teacher.dashboard.attendance') }}" method="post" autocomplete="off">

    @csrf
    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
        style="text-align: center">
        <thead>
            <tr>
                <th class="alert-success">#</th>
                <th class="alert-success">{{ trans('Students_trans.name') }}</th>
                <th class="alert-success">{{ trans('Students_trans.email') }}</th>
                <th class="alert-success">{{ trans('Students_trans.gender') }}</th>
                <th class="alert-success">{{ trans('Students_trans.Grade') }}</th>
                <th class="alert-success">{{ trans('Students_trans.classrooms') }}</th>
                <th class="alert-success">{{ trans('Students_trans.section') }}</th>
                <th class="alert-success">الحضور والغياب</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->gender->Name }}</td>
                    <td>{{ $student->grade->Name }}</td>
                    <td>{{ $student->classroom->Name_Class }}</td>
                    <td>{{ $student->section->Name_Section }}</td>
                    <td>
                        @php
                            $attendance = $student->attendance()->where('attendence_date', date('Y-m-d'))->first();
                       @endphp

                        <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                            <input name="attendences[{{ $student->id }}]"
                            @if(isset($attendance))
                                    @if($attendance->attendence_status == 1)
                                        {{ 'checked' }}
                                    @endif
                            @endif
                            class="leading-tight"
                                type="radio" value="1">
                            <span class="text-success">حضور</span>
                        </label>

                        <label class="ml-4 block text-gray-500 font-semibold">
                            <input name="attendences[{{ $student->id }}]"
                            @if(isset($attendance))
                                    @if($attendance->attendence_status == 0)
                                        {{ 'checked' }}
                                    @endif
                            @endif
                            class="leading-tight"
                                type="radio" value="0">
                            <span class="text-danger">غياب</span>
                        </label>

                        <input type="hidden" name="grade_id" value="{{ $student->Grade_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $student->Classroom_id }}">
                        <input type="hidden" name="section_id" value="{{ $student->section_id }}">
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <P>
        <button class="btn btn-success" type="submit">{{ trans('Students_trans.submit') }}</button>
    </P>
</form><br>
<!-- row closed -->
@endsection
@section('js')
@endsection
