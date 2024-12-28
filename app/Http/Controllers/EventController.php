<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEvents()
    {
        return response()->json(Event::select('id', 'title', 'start')->get());
    }

    public function addEvent(Request $request)
    {

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start
        ]);

        return response()->json($event);
    }

    public function updateEvent(Request $request)
    {
        $event = Event::find($request->id);
        if ($event) {
            $event->start = $request->start;
            $event->save();
        }

        return response()->json($event);
    }
}
