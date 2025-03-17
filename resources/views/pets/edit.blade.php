@extends('layouts.app')

@section('title', 'Edit Pet')

@section('header', 'Edit Pet')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $pet['name']) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available" {{ old('status', $pet['status']) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="pending" {{ old('status', $pet['status']) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="sold" {{ old('status', $pet['status']) == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mt-3">Update Pet</button>
                        <a href="{{ route('pets.index') }}" class="btn btn-secondary mt-3 ml-2">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection