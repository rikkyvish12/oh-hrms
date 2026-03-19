@extends('layouts.admin')

@section('title', '')
@section('page-title', '')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Letter Preview</h1>
                <p class="text-gray-600">Generated letter document</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print / Save as PDF
                </button>
                <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Letters
                </a>
            </div>
        </div>
    </div>

    <!-- Letter Document (PDF-style) -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden print:shadow-none print:border-0">
        <!-- Letter Header (Hidden on Print - For Screen Only) -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 print:hidden">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ config('app.name', 'OHA-HRMS') }}</h2>
                    <p class="text-indigo-100 text-sm mt-1">Official Letter Document</p>
                </div>
                <div class="text-right">
                    <p class="text-white text-sm">Generated: {{ $letter->generated_at->format('d M Y, h:i A') }}</p>
                    <p class="text-indigo-100 text-xs mt-1">ID: #{{ $letter->id }}</p>
                </div>
            </div>
        </div>

        <!-- Letter Content -->
        <div class="p-8 print:p-0">
            <!-- Template Info (Hidden on Print - For Screen Only) -->
            @if($letter->template)
            <div class="mb-6 pb-4 border-b border-gray-200 print:hidden">
                <p class="text-sm text-gray-600"><strong>Template:</strong> {{ $letter->template->name }}</p>
                @if($letter->employee)
                <p class="text-sm text-gray-600 mt-1"><strong>Employee:</strong> {{ $letter->employee->name }} ({{ $letter->employee->email }})</p>
                @endif
            </div>
            @endif

            <!-- Letter Body -->
            <div class="prose max-w-none print:prose-lg">
                <div class="font-sans text-gray-800 leading-normal print:text-black print:text-base letter-content">
                    {!! $letter->content !!}
                </div>
            </div>

            <!-- Footer (Hidden on Print - For Screen Only) -->
            <div class="mt-12 pt-6 border-t-2 border-gray-200 print:hidden">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <p>This is a System-generated document.</p>
                    <p>Generated on {{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 print:hidden">
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Template Used</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter->template->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Generated At</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter->generated_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">For Employee</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $letter->employee->name ?? 'General' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Letter content styling */
.letter-content p {
    margin: 0.5em 0;
    line-height: 1.6;
}

.letter-content br {
    line-height: 1.4;
}

.letter-content ul, .letter-content ol {
    margin: 1em 0;
    padding-left: 2.5em;
    list-style-position: outside;
}

.letter-content ul {
    list-style-type: disc;
}

.letter-content ol {
    list-style-type: decimal;
}

.letter-content li {
    margin: 0.5em 0;
    padding-left: 0.3em;
    line-height: 1.6;
}

.letter-content li::marker {
    color: inherit;
}

.letter-content strong, .letter-content b {
    font-weight: 600;
}

/* Print styles for ALL pages - consistent margins on every page */
@page {
    size: A4;
    margin-top: 4.5cm;   /* Header space: ~12 lines (3cm) + content buffer (1.5cm) */
    margin-bottom: 3cm;  /* Footer space: ~8 lines (2cm) + content buffer (1cm) */
    margin-left: 2cm;
    margin-right: 2cm;
}

@media print {
    /* Hide everything initially */
    body * {
        visibility: hidden;
    }
    
    /* Hide page header section (Letter Preview title area) */
    .mb-8 {
        display: none !important;
    }
    
    /* Hide metadata cards grid */
    .grid {
        display: none !important;
    }
    
    /* Show the letter document container */
    .bg-white.rounded-xl.shadow-lg {
        visibility: visible !important;
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        box-shadow: none !important;
        overflow: visible !important;
    }
    
    /* Ensure all nested divs inside letter document are visible */
    .bg-white.rounded-xl.shadow-lg * {
        visibility: visible !important;
    }
    
    /* Hide colored header bar (OHA-HRMS branding) */
    .bg-gradient-to-r {
        display: none !important;
    }
    
    /* Hide template info */
    .print\\:hidden {
        display: none !important;
    }
    
    /* Letter content styling */
    .letter-content p, .letter-content br, .letter-content li {
        margin: 0.3em 0;
        line-height: 1.5;
    }
    
    /* Set proper padding on letter content container */
    .p-8 {
        padding: 0 !important;
    }
}
</style>
@endsection
