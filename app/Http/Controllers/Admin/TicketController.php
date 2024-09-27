<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\TicketClosedNotification;
use App\Notifications\TicketGenerateNotification;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Str;
use Auth;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function index()
    {
        if(auth()->user()->is_admin == 1)
        {
            $tickets = Ticket::with('status', 'priority', 'department', 'ticketReplies')->latest()->simplePaginate(10);
        } else {
            $tickets = Ticket::with('status', 'priority', 'department', 'ticketReplies')->where('user_id', auth()->user()->id)->latest()->simplePaginate(10);
        }

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $statuses = Status::pluck('name', 'id');
        $priorities = Priority::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        return view('customer.tickets.create', compact('statuses', 'departments', 'priorities'));
    }

    public function adminCreateTicket()
    {
        $statuses = Status::pluck('name', 'id');
        $priorities = Priority::pluck('name', 'id');
        $departments = Department::pluck('name', 'id');
        return view('admin.tickets.create', compact('statuses', 'departments', 'priorities'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'department' => 'required',
                'subject' => 'required',
                'body' => 'required',
            ]);
            // Ticket details create ... 
            $ticket = new Ticket();
            $ticket->status_id = 1;
            $ticket->priority_id = 2;
            if ($request->has('department')) {
                $ticket->department_id = $request->get('department');
            }
            $ticket->user_id = Auth::id();
            $ticket->uuid = Str::uuid();
            $ticket->subject = $request->get('subject');
            $ticket->saveOrFail();
            // Ticket details create ... 
            // Ticket Reply details create ... 
            $ticketReply = new TicketReply();
            $ticketReply->ticket_id = $ticket->id;
            $ticketReply->user_id = Auth::id();
            $ticketReply->body = $request->get('body');
            $ticket->ticketReplies()->save($ticketReply);
            // Ticket Reply details create ... 
            // Notification send to admin email ... 
            $admin = User::where('is_admin', 1)->first();
            // $admin->notify(new TicketGenerateNotification());
            Notification::send($admin, new TicketGenerateNotification());
            // Notification send to admin email ... 
            DB::commit();
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.tickets.index')->with('success_msg', "Tickets added succefully done.");
            } else {
                return redirect()->route(route: 'tickets.index')->with('success_msg', "Tickets added succefully done.");
            }
        } catch (\Exception $e) {
            DB::rollback();
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.tickets.create')->with('err_msg', "Something went wrong!.");
            } else {
                return redirect()->route(route: 'tickets.create')->with('err_msg', "Something went wrong!");
            }
        }


    }

    // Customer view ticket & with respond ... 
    public function show($id)
    {
        $ticket = Ticket::with('status', 'priority', 'department', 'ticketReplies')->findOrFail($id);
        if(auth()->user()->is_admin == 1)
        {
            return view('admin.tickets.show', compact('ticket'));
        } else {
            return view('customer.tickets.show', compact('ticket'));
        }

    } 

    public function customerTicketWiseReponse(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'body' => 'required',
            ]);
            $ticket = Ticket::where('id',$id)->first();
            $ticketReply = new TicketReply();
            $ticketReply->ticket_id = $ticket->id;
            $ticketReply->user_id = auth()->user()->id;
            $ticketReply->body = $request->get('body');
            $ticket->ticketReplies()->save($ticketReply);
            DB::commit();
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.tickets.index')->with('success_msg', "Ticket Wise Reply Successfully done.");
            } else {
                return redirect()->route(route: 'tickets.index')->with('success_msg', "Ticket Wise Reply Successfully done.");
            }
        } catch (\Exception $e) {
            DB::rollback();
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.tickets.create')->with('err_msg', "Something went wrong!.");
            } else {
                return redirect()->route(route: 'tickets.create')->with('err_msg', "Something went wrong!");
            }
            
        }
    }
    // Customer view ticket & with respond ...

    // Admin view ticket & with respond ... 
    public function adminTicketShow($id)
    {
        $ticket = Ticket::with('status', 'priority', 'department', 'ticketReplies')->findOrFail($id);
        if(auth()->user()->is_admin == 1)
        {
            return view('admin.tickets.show', compact('ticket'));
        } else {
            return view('customer.ticket.show');
        }

    }  
    
    public function adminTicketWiseReponse(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'body' => 'required',
            ]);
            $ticket = Ticket::where('id',$id)->first();
            $ticketReply = new TicketReply();
            $ticketReply->ticket_id = $ticket->id;
            $ticketReply->user_id = auth()->user()->id;
            $ticketReply->body = $request->get('body');
            $ticket->ticketReplies()->save($ticketReply);
            DB::commit();
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.tickets.index')->with('success_msg', "Ticket Wise Reply Successfully done.");
            } else {
                return redirect()->route(route: 'tickets.index')->with('success_msg', "Ticket Wise Reply Successfully done.");
            }
        } catch (\Exception $e) {
            DB::rollback();
            if(Auth::user()->is_admin == 1)
            {
                return redirect()->route('admin.tickets.create')->with('err_msg', "Something went wrong!.");
            } else {
                return redirect()->route(route: 'tickets.create')->with('err_msg', "Something went wrong!");
            }
            
        }
    }
    // Admin view ticket & with respond ... 

    // Admin Closed the ticket functionality ... 
    public function updateTicketCloseStatus(Request $request)
    {
        if($request->ajax())
        {
            try {
                $ticket = $request->all();
                // dd($ticket);
                if($ticket['status'] == 'open')
                {
                    $status = 1;
                    $message = 'Ticket Opened.';
                } else {
                    $status = 5;
                    $message = 'Ticket Closed.';
                }
                $date = date('Y-m-d H:i:s');
                $closed_at = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
                Ticket::select('id')->where('id', $ticket['id'])->update(['status_id'=>$status, 'closed_by'=>auth()->user()->id, 'closed_at'=>$closed_at]);
                $updated_ticket = Ticket::select('id', 'status_id', 'user_id')->where('id', $ticket['id'])->first();
                if($updated_ticket->status_id == 5) 
                {
                    $user = User::where('id', $updated_ticket->user_id)->first();
                    Notification::send($user, new TicketClosedNotification());
                }
                return response()->json(['status'=>$status, 'id'=>$ticket['id'], 'message'=>$message]);
            } catch (\Exception $e) {
                $message = 'Something wrong!';
                return response()->json(['message'=>$e->getMessage()]);
            }
            
        }
    }
    // Admin Closed the ticket functionality ... 
}
