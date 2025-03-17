@extends('layouts.app')
<style>
    table {
        table-layout: fixed;
        width: 100%;
    }
</style>
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <h1 class="my-4">Pets List</h1>

    <a href="{{ route('pets.create') }}" class="btn btn-success mb-3">Add Pet</a>

    @if (empty($pets))
        <p>No pets available.</p>
    @else
    <table class="table table-bordered table-sm">
    <thead>
        <tr>
            <th class="text-center">Name</th>
            <th class="text-center">Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pets as $pet)
            <tr class="text-center">
                <td>{{ $pet['name'] ?? 'N/A' }}</td>
                <td>{{ $pet['status'] ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-primary mr-4">Edit</a>
                    
                    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    @endif
</div>
@endsection