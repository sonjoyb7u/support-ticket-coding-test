@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span><i class="bi bi-table me-2"></i>Add Ticket</span>
                        @if (auth()->user()->is_admin == 1)
                            <span><a href="{{ route('admin.tickets.index') }}">All Tickets</a></span>
                        @else
                            <span><a href="{{ route('tickets.index') }}">All Tickets</a></span>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.store') }}}" method="POST">
                            @csrf

                            @if (auth()->user()->is_admin == 1)
                                <div class="mb-3">
                                    <label for="priorities" class="form-label">Priority</label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                        name="priority">
                                        <option selected>Select Option</option>
                                        @if (!empty($priorities))
                                            @foreach ($priorities as $key => $priority)
                                                <option value="{{ $key }}">{{ ucwords($priority) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                    name="department">
                                    {{-- <option selected>Select Option</option> --}}
                                    @if (!empty($departments))
                                        @foreach ($departments as $key => $department)
                                            <option value="{{ $key }}">{{ ucwords($department) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" value="{{ old('subject') }}">
                                @error('subject')
                                    <p class="text-danger font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="problem" class="form-label">Problem</label>
                                <textarea class="form-control @error('body') is-invalid @enderror" placeholder="Leave a problems here" id="problem"
                                    name="body" value="{{ old('body') }}"></textarea>
                                @error('body')
                                    <p class="text-danger font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Create Ticket</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
