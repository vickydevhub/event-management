@extends('layouts.default')
@section('content')
<main class="login-form">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create Event</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('status'))

                        <p class="alert alert-success">{{Session::get('status') }}</p>

                        @endif
                    <div class="card-body">
                        <form action="{{route('event.store')}}" method="POST" autocomplete="off" id="event_store">
                            @csrf
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Event Name</label>
                                <div class="col-md-8">
                                    <input type="text" id="name" class="form-control" name="name" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Event Description</label>
                                <div class="col-md-8">
                                    <textarea id="description" class="form-control" name="description" ></textarea>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <div class="col">
                                <label for="start_date" class="col-md-6 col-form-label text-md-right">Start date</label>
                                <input type="text" class="form-control" id="start_date" placeholder="Start date" name="start_date">
                                </div>
                                <div class="col">
                                <label for="end_date" class="col-md-6 col-form-label text-md-right">End Date</label>
                                <input type="text" class="form-control" placeholder="End Date" name="end_date" id="end_date">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="organizer" class="col-md-4 col-form-label text-md-right">Organizer</label>
                                <div class="col-md-8">
                                    <input type="text" id="organizer" class="form-control" name="organizer" >
                                </div>
                            </div>

                            <a href="javascript:void(0)" id="add_ticket" class="btn btn-link">
                                   Add new Ticket
                                </a>

                            <div class="form-group row" id="tickets">
                                <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Ticket No</th>
                                        <th scope="col">Price</th>
                                        <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="ticket_body">
                                    @if(count($tickets))
                                        @foreach($tickets as $ticket)
                                        <tr>

                                        <td><span class="label">{{$ticket->id}}</span><input type="number" value="{{$ticket->id}}" name="id" class="id" style="display:none;"><span class="error"></span></td>
                                        <td><span class="label">{{$ticket->ticket_no}}</span><input type="number" value="{{$ticket->ticket_no}}" name="ticket_no" class="ticket_no" style="display:none;"><span class="error"></span></td>
                                        <td><span class="label">{{$ticket->price}}</span><input name="price" value="{{$ticket->price}}" class="price" min="0" value="0" step="0.01" style="display:none;"><span class="error"></span></td>
                                        <td><input type="button" value="Edit" onclick="updateTicket(this)"></td>
                                        <td><input type="button" value="Delete" onclick="deleteTicket(this)"></td>
                                        <td><input type="hidden" class="ticket_id" name="ticket_id[]" value="{{$ticket->id}}"></td>
                                        </tr>
                                        <tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    </table>
                                </div>
                            </div>



                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Event
                                </button>

                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</main>
@stop
@push('scripts')
<script>
  $( function() {

    $("#event_store").validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },

            organizer: {
                required: true
            },
        },
        submitHandler: function(form) {

            $(form).submit();
        }
    });

    var dateFormat = "mm/dd/yy",
      from = $( "#start_date" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#end_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }

      return date;
    }
    //add new ticket
    $('#add_ticket').click(function(){
        var html='<tr>';
            html+='<td><input type="number" name="id" class="id"><span class="error"></span></td>';
            html+='<td><input type="number" name="ticket_no" class="ticket_no"><span class="error"></span></td>';
            html+='<td><input type="number"  name="price" min="0" value="0" step="0.01" class="price"><span class="error"></span></td>';
            html+='<td><input type="button" value="Save" onclick="saveTicket(this)"></td>';
            html+='<td><input name="update" value="no" class="is_updated" type="hidden"/></td>';
            html+='</tr>';


            $(".table tbody").append(html);
    });


  } );

  function saveTicket(elm){
      var id = $(elm).parents('tr').find('td').find('input.id');
     var price = $(elm).parents('tr').find('td').find('input.price');
     var ticket_no = $(elm).parents('tr').find('td').find('input.ticket_no');
     var is_updated = $(elm).parents('tr').find('td').find('input.is_updated');
     if(id.val()==""){
        id.next().text('This field is required');
     }

     if(ticket_no.val()==""){
        ticket_no.next().text('This field is required');
     }

     if(price.val()==""){
        price.next().text('This field is required');
     }
    if(id.val() !="" && ticket_no.val() !="" && price.val() !="")
    {
        var data = {
                'id': id.val(),
                'ticket_no': ticket_no.val(),
                'price': price.val(),

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{url('/')}}/ticket",
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 200)
                    {
                            var html='';

                            html+='<td><span class="label">'+response.data.id+'</span><input type="number" name="id" class="id" value="'+response.data.id+'" style="display:none;"><span class="error"></span></td>';
                            html+='<td><span class="label">'+response.data.ticket_no+'</span><input type="number" name="ticket_no" value="'+response.data.ticket_no+'" class="ticket_no" style="display:none;"><span class="error"></span></td>';
                            html+='<td><span class="label">'+response.data.price+'</span><input type="number"  name="price" min="0" value="'+response.data.price+'" step="0.01" class="price" style="display:none;"><span class="error"></span></td>';
                            html+='<td><input type="button" value="Edit" onclick="updateTicket(this)"></td>';
                            html+='<td><input type="button" value="Delete" onclick="deleteTicket(this)"></td>';
                            html+='<td><input type="hidden" class="ticket_id" name="ticket_id[]" value="'+response.data.id+'"></td>';

                        if(is_updated && is_updated.val() == "yes")
                        {
                            $(elm).parents('tr').html(html);
                        }
                        else
                        {
                            $(elm).parents('tr').remove();
                            $(".table tbody").append('<tr>'+html+'</tr>');
                        }

                    }
                    else  if (response.status == 422)
                    {
                        id.next().text(response.errors);
                    }
                    else {
                        console.log('Error comes')
                    }
                }
            });
    }

  }

  function updateTicket(elem){
    $(elem).parents('tr').find('td').find('span.label').css({'display':'none'});
    $(elem).parents('tr').find('td').find('input').css({'display':'block'});
    $(elem).parents('tr').find('td').append('<input name="update" class="is_updated" value="yes" type="hidden"/>');
    $(elem).replaceWith('<input type="button" value="Update" onclick="saveTicket(this)">');

  }

  function deleteTicket(elem){
    var id = $(elem).parents('tr').find('td').find('input.ticket_id');
    if(id && id.val() != ""){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $.ajax(
        {
            url: "{{url('/')}}/ticket/"+id.val(),
            type: 'DELETE',

            success: function (response){
                console.log(response.msg);
                $(elem).parents('tr').remove();
            }
        });
    }


  }
  </script>
@endpush
