<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function calendar(Request $request)
    {

        $data = null; // Initialize $data with a default value

        $user = Auth::user();
        $notifications = $user->notifications;

        if ($request->ajax()) {
            $data = Event::all();

            return response()->json($data);
        }

        return view('user.usersCalendar',
            compact('data','notifications'));
    }

    /**
     * Write code on Method
     *
//     * @return response()
     */
    public function ajax(Request $request)
    {

        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'update':
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                info("Default");
                break;
        }
    }
}
