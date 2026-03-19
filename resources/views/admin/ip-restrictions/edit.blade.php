@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit IP Restriction</h1>
    
    <form action="{{ route('admin.ip-restrictions.update', $ipRestriction->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>IP Address</label>
            <input type="text" name="ip_address" class="form-control" value="{{ $ipRestriction->ip_address }}" required>
        </div>
        <div class="mb-3">
            <label>
                <input type="checkbox" name="is_active" {{ $ipRestriction->is_active ? 'checked' : '' }}> Active
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.ip-restrictions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection