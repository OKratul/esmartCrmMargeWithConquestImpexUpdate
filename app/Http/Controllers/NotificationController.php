<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function markAsRead($id){


            $notification = Auth::user()->unreadNotifications->where('id', $id)->first();

            if ($notification) {
                // Mark the specific notification as read
                $notification->markAsRead();
            }

            $query_id = $notification->data['query_id'];

            return redirect()->route('view-single-query', [$query_id]);


    }
}
