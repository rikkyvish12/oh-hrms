@extends('layouts.admin')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Edit Role</h1>
        <p class="text-gray-600">Update role details and permissions</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Role Details</h2>
        </div>
        
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        value="{{ old('name', $role->name) }}"
                        required
                        placeholder="e.g., manager, supervisor">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors @error('description') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                        placeholder="Describe the purpose and responsibilities of this role">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Permissions Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Permissions
                    </label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="view" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" {{ in_array('view', old('permissions', json_decode($role->permissions ?? '[]'))) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">View Records</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="create" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" {{ in_array('create', old('permissions', json_decode($role->permissions ?? '[]'))) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Create Records</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="edit" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" {{ in_array('edit', old('permissions', json_decode($role->permissions ?? '[]'))) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Edit Records</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="permissions[]" value="delete" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" {{ in_array('delete', old('permissions', json_decode($role->permissions ?? '[]'))) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Delete Records</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection