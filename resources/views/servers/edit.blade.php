@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-content">
                <div class="card-header d-flex justify-content-between">
                    <h4>
                        Edit Server
                    </h4>
                    <div class="actions">
                        <a href="{{ route('servers.index') }}" class="btn btn-primary">
                            List Servers
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('servers.update', $server) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('servers.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
