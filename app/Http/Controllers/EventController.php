<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'organizer' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $save = Event::create($request->all());
        if($save){
             if($request->filled('ticket_id') && count($request->input('ticket_id')) > 0)
             {
                 foreach($request->input('ticket_id') as $ticket)
                 {

                     EventTicket::create([
                         'event_id'=>$save->id,
                         'ticket_id'=>$ticket
                     ]);
                 }
             }
        }
        $request->session()->flash('status', 'Event created Successfully!');
        return redirect()
                ->back();

    }
}
