<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'       => 'required',
            'ticket_no'       => 'required',
            'price' => 'required',
          ]);

          if ($validator->fails()) {
              return response()->json(['status'=>422, 'errors'=>$validator->errors()], 200);
        }
          $ticket = Ticket::updateOrCreate(['id'=> $request->input('id')],$request->all());

          return response()->json(['status'=>200, 'message'=>'Ticket Created successfully','data' => $ticket], 200);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::find($id)->delete($id);

        return response()->json([
            'msg' => 'Record deleted successfully!'
        ]);
    }
}
