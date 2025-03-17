@extends('layouts.app')

@section('title', 'Create Pet')

@section('header', 'Create New Pet')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('pets.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success mt-3">Create Pet</button>
                        <a href="{{ route('pets.index') }}" class="btn btn-secondary mt-3 ml-2">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection