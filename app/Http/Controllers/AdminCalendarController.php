<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCalendarController extends Controller
{

    public function showCalendar(){

        $admin_id = Auth::guard('admin')->id();
        $events = Appointment::where('admin_id',$admin_id)->get()->all();

        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'title' => $event->note,
                'start' => $event->start_time,
                'end' => $event->end_time,
                'id' => $event->id,
            ];
        }

        return view('adminCalendar',compact('formattedEvents'));

    }

    public function addEvent(){

        $this->validate(\request(),[
            'title' => 'required',
            'end_date' => 'required',
        ]);

        $admin_id = Auth::guard('admin')->id();

        Appointment::create([
            'admin_id' => $admin_id,
            'start_time' => \request('start_time'),
            'end_time' => \request('end_date'),
            'note' => \request('title'),
        ]);

        return redirect()->back()->with('success', 'Event Added Successfully');

    }

    public function updateEvent(Request $request, $id)
    {
        $event = Appointment::findOrFail($id);

        $event->note = $request->input('event-details');
        $event->start_time = $request->input('start_time');
        $event->end_time = $request->input('end_date');
        $event->save();

        return response()->json(['message' => 'Event updated successfully']);
    }

    public function deleteEvent($id)
    {
       Appointment::where('id',$id)->delete();

       return redirect()->back()->with('success', 'Event Deleted');
    }

}
