<?php

namespace App\Http\Controllers\Dashboard;

use auth;
use App\Models\Grade;
use App\Models\OnlineClass;
use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;
use App\Http\Controllers\Controller;
use App\Http\Traits\MeetingZoomTrait;

class OnlineClasseController extends Controller
{
    public function index()
    {
        $online_classes = OnlineClass::all();
        return view('pages.online_classes.index', compact('online_classes'));
    }


    public function create()
    {
        $Grades = Grade::all();
        return view('pages.online_classes.add', compact('Grades'));
    }

    public function indirectCreate()
    {
        $Grades = Grade::all();
        return view('pages.online_classes.indirect', compact('Grades'));
    }

    public function store(Request $request)
    {
        try {
            $meeting = Zoom::createMeeting([
                "topic" => $request->topic,
                "duration" => $request->duration, // in minutes
                "timezone" => config('zoom.timezone'), // set your timezone
                "password" => '22password',
                "start_time" => $request->start_time, // set your start time
            ]);

            OnlineClass::create([
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'user_id' => 1,
                'meeting_id' => $meeting['data']['id'],
                'topic' => $request->topic,
                'start_time' => $request->start_time,
                'duration' => $meeting['data']['duration'],
                'password' => $meeting['data']['password'],
                'start_url' =>$meeting['data']['start_url'] ,
                'join_url' =>$meeting['data']['join_url'] ,
            ]);
            return redirect()->route('dashboard.online_classes.index')->
            with('msg', trans('messages.success'))->with('type', 'success');

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
    public function storeIndirect(Request $request)
    {
        try {
            OnlineClass::create([
                'integration' => 0,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'user_id' => 1,
                'meeting_id' => $request->meeting_id,
                'topic' => $request->topic,
                'start_time' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'start_url' => $request->start_url,
                'join_url' => $request->join_url,
            ]);
            // toastr()->success(trans('messages.success'));
            return redirect()->route('dashboard.online_classes.index')->
            with('msg', trans('messages.success'))->with('type', 'success');;
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {
       try {
        $onlineClass=OnlineClass::where('meeting_id', $request->meeting_id)->first();
            // return $onlineClass;
        if($onlineClass->integration==1){
            Zoom::deleteMeeting($request->meeting_id);
        }
            $onlineClass->delete();
            return redirect()->route('dashboard.online_classes.index')->
            with('msg', trans('messages.Delete'))->with('type', 'danger');;
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
}
