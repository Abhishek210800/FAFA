@extends('layouts.app') {{-- or whatever your layout file is --}}

@section('content')
    <h1>All Mediations</h1>

    @foreach ($mediations as $mediation)
        <div>
            <strong>Case ID:</strong> {{ $mediation->case_id }}<br>
            <strong>Status:</strong> {{ $mediation->status }}
        </div>
        <hr>
    @endforeach
@endsection
