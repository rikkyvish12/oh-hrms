@extends('layouts.admin')

@section('title', 'View Template')
@section('page-title', 'Template Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $letterTemplate->name }}</h1>
                <p class="text-gray-600">Template details and preview</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.letter-templates.edit', $letterTemplate->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Template
                </a>
                <a href="{{ route('admin.letter-templates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Templates
                </a>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Type</p>
                    <p class="text-lg font-semibold text-gray-900 capitalize">{{ ucfirst($letterTemplate->letter_type) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="text-lg font-semibold text-gray-900">
                        @if($letterTemplate->is_default)
                            <span class="text-green-600">Default Template</span>
                        @else
                            Custom Template
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 16h16"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Variables</p>
                    <p class="text-lg font-semibold text-gray-900">{{ count($letterTemplate->variables ?? []) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Content -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Template Content</h2>
            <p class="text-gray-600 mt-1">Preview of formatted template</p>
        </div>
        <div class="p-6 bg-white">
            <div class="font-sans text-gray-800 leading-normal letter-content-preview border border-gray-200 rounded-lg p-6 bg-white">
                @php
                    // Decode HTML entities if present and render
                    $content = html_entity_decode($letterTemplate->template_content);
                @endphp
                {!! $content !!}
            </div>
        </div>
    </div>

    <!-- Variables List -->
    @if($letterTemplate->variables && count($letterTemplate->variables) > 0)
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Used Variables</h2>
            <p class="text-gray-600 mt-1">Variables detected in this template</p>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-2">
                @foreach($letterTemplate->variables as $variable)
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                        {{ $variable }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Metadata -->
    <div class="mt-6 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Template Information</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Created At</p>
                <p class="text-base font-medium text-gray-900">{{ $letterTemplate->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Last Updated</p>
                <p class="text-base font-medium text-gray-900">{{ $letterTemplate->updated_at->format('d M Y, h:i A') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Created By</p>
                <p class="text-base font-medium text-gray-900">System</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">ID</p>
                <p class="text-base font-medium text-gray-900">#{{ $letterTemplate->id }}</p>
            </div>
        </div>
    </div>
</div>
<style>
/* Template preview content styling */
.letter-content-preview p {
    margin: 0.5em 0;
    line-height: 1.6;
}

.letter-content-preview br {
    line-height: 1.4;
}

.letter-content-preview ul, .letter-content-preview ol {
    margin: 1em 0;
    padding-left: 2.5em;
    list-style-position: outside;
}

.letter-content-preview ul {
    list-style-type: disc;
}

.letter-content-preview ol {
    list-style-type: decimal;
}

.letter-content-preview li {
    margin: 0.5em 0;
    padding-left: 0.3em;
    line-height: 1.6;
}

.letter-content-preview li::marker {
    color: inherit;
}

.letter-content-preview strong, .letter-content-preview b {
    font-weight: 600;
}
</style>
@endsection
