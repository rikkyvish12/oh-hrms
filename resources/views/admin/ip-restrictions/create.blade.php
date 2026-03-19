@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Add IP Restriction</h1>
    
    <form action="{{ route('admin.ip-restrictions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>IP Address</label>
            <input type="text" name="ip_address" class="form-control" placeholder="192.168.1.1" required>
        </div>
        <div class="mb-3">
            <label>
                <input type="checkbox" name="is_active" checked> Active
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.ip-restrictions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection