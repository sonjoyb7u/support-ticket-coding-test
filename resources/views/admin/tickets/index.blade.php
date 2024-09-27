@extends('layouts.app')

@push('css')
@endpush

@section('content')
    <div class="container">
        <div class="row">
            @if (session('success_msg'))
                <div class="alert alert-success" role="alert">
                    {{ session('success_msg') }}
                </div>
            @endif

            @if (session('err_msg'))
                <div class="alert alert-danger" role="alert">
                    {{ session('err_msg') }}
                </div>
            @endif
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span><i class="bi bi-table me-2"></i>Manage All Tickets</span>
                        @if (auth()->user()->is_admin == 1)
                            <span><a href="{{ route('admin.tickets.create') }}">Add
                                    Ticket</a></span>
                        @else
                            <span><a href="{{ route('tickets.create') }}">Add
                                    Ticket</a></span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" style="width: 100%; height: auto">
                                <thead>
                                    <tr>
                                        <th>##</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($tickets))
                                        @forelse ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucwords($ticket->subject) }}</td>
                                                <td>
                                                    <span class="badge rounded-pill bg-dark"
                                                        id="ticket_status_{{ $ticket->id }}">{{ ucwords($ticket->status->name) }}</span>
                                                </td>
                                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                                <td>
                                                    @if (auth()->user()->is_admin == 1)
                                                        @if ($ticket->status->id == 1)
                                                            <a style="text-decoration: none" href="javascript:void(0)"
                                                                class="updateTicketClosedStatus"
                                                                id="ticket-id-{{ $ticket->id }}"
                                                                ticket_id="{{ $ticket->id }}" title="Ticket Closed?">
                                                                <i style="font-size: 30px; color: red"
                                                                    class="bi bi-toggle-off" status="close"></i>
                                                            </a>
                                                        @elseif($ticket->status->id == 5)
                                                            <a style="text-decoration: none" href="javascript:void(0)"
                                                                class="updateTicketClosedStatus"
                                                                id="ticket-id-{{ $ticket->id }}"
                                                                ticket_id="{{ $ticket->id }}" title="Ticket Is Closed.">
                                                                <i style="font-size: 30px; color: green"
                                                                    class="bi bi-toggle-on" status="open"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if (auth()->user()->is_admin == 1)
                                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                                            class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                                                    @else
                                                        <a href="{{ route('tickets.show', $ticket->id) }}"
                                                            class="btn btn-success btn-sm"><i class="bi bi-eye"></i></a>
                                                    @endif

                                                    <a href="" class="btn btn-info btn-sm disabled"><i
                                                            class="bi bi-pencil-square" disabled="disabled"></i></a>
                                                    <a href="" class="btn btn-danger btn-sm disabled"><i
                                                            class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-danger text-center font-bold">No Records
                                                    Founds!</td>
                                            </tr>
                                        @endforelse
                                    @endif


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>##</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="d-flex flex-row-reverse">
                                {!! $tickets->links() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
