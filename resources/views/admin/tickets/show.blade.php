@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span><i class="bi bi-table me-2"></i>View Ticket</span>
                        @if (auth()->user()->is_admin == 1)
                            <span><a href="{{ route('admin.tickets.index') }}">All Tickets</a></span>
                        @else
                            <span><a href="{{ route('tickets.index') }}">All Tickets</a></span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div>
                            <h4>Status: <span class="badge rounded-pill bg-dark">{{ $ticket->status->name }}</span></h4>
                            <h5>Ticket Id: {{ $ticket->uuid }}</h5>
                            <h4>Subject: {{ $ticket->subject }}</h4>
                        </div>
                        <div>
                            @if (!empty($ticket->ticketReplies))
                                <h5>Problem Details: </h5>
                                @foreach ($ticket->ticketReplies as $reply)
                                    @if (auth()->user()->id == $reply->user_id)
                                        <h6> --> {{ $reply->body }}
                                        </h6>
                                    @endif
                                @endforeach
                                <h5>Reply Details: </h5>
                                @foreach ($ticket->ticketReplies as $reply)
                                    @if (auth()->user()->id != $reply->user_id)
                                        <h6> <strong>--></strong> {{ $reply->body }}
                                            ({{ $reply->user->is_admin == 1 ? 'Reply From Admin' : 'Reply From Customer' }})
                                        </h6>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        @if ($ticket->status->name == 'open')
                            <div>
                                <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="problem" class="form-label">Reply: </label>
                                        <textarea class="form-control @error('body') is-invalid @enderror" placeholder="Leave a reply here..." id="problem"
                                            name="body" value="{{ old('body') }}"></textarea>
                                        @error('body')
                                            <p class="text-danger font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Reply</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
