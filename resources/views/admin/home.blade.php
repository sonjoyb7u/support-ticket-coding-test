@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

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

                        {{ __('You are logged in!') }}
                        <h4>Welcome, Admin Dashboard</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
