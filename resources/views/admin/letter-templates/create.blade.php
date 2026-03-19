@extends('layouts.admin')

@section('title', 'Create Template')
@section('page-title', 'Create Letter Template')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Letter Template</h1>
                <p class="text-gray-600">Design a reusable template for generating letters</p>
            </div>
            <a href="{{ route('admin.letter-templates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Templates
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Template Details</h2>
                    <p class="text-gray-600 mt-1">Fill in the template information</p>
                </div>
                
                <form action="{{ route('admin.letter-templates.store') }}" method="POST" class="p-6">
                    @csrf
                    
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-700 font-semibold">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <!-- Template Name -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 16h16"></path>
                            </svg>
                            Template Name
                        </label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="e.g., Standard Appointment Letter" required>
                    </div>

                    <!-- Template Content -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Template Content
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Use numbered placeholders like {1}, {2}, {3}, {4} etc. These will be replaced with actual values when generating letters.</p>
                        <textarea name="template_content" id="template_content" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors font-mono text-sm" rows="16" placeholder="Enter your template content here...&#10;&#10;Example:&#10;Hi {1},&#10;&#10;✅ Your order #{2} has been successfully placed.&#10;&#10;📦 Product: {3}&#10;💰 Amount: ₹{4}"></textarea>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="text-xs text-gray-500">Quick insert:</span>
                            <button type="button" onclick="insertPlaceholder()" class="px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs rounded transition-colors">Insert {n}</button>
                        </div>
                    </div>

                    <!-- Is Active -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" checked class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Active (available for use)</span>
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Template
                        </button>
                        <a href="{{ route('admin.letter-templates.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar - Instructions -->
        <div class="lg:col-span-1">
            <!-- How It Works -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <h3 class="text-lg font-semibold text-white">Numbered Placeholders</h3>
                    <p class="text-indigo-100 text-sm mt-1">Simple & flexible syntax</p>
                </div>
                <div class="p-4 space-y-3">
                    <p class="text-sm text-gray-700">Use numbers in curly braces to mark where values should be inserted:</p>
                    <ul class="text-xs text-gray-600 space-y-2">
                        <li>• <strong>{1}</strong> - First value</li>
                        <li>• <strong>{2}</strong> - Second value</li>
                        <li>• <strong>{3}</strong> - Third value</li>
                        <li>• And so on...</li>
                    </ul>
                </div>
            </div>

            <!-- Example -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 mb-2">Example Template</h4>
                        <div class="text-xs text-blue-700 space-y-2">
                            <p><strong>Content:</strong></p>
                            <p class="font-mono bg-white p-2 rounded">Hi {1},<br><br>✅ Order #{2} confirmed.<br><br>📦 Product: {3}<br>💰 Amount: ₹{4}</p>
                            
                            <p class="mt-2"><strong>When generating:</strong></p>
                            <ul class="list-disc list-inside ml-2">
                                <li>{1} → Ramakant</li>
                                <li>{2} → ORD-76765</li>
                                <li>{3} → ZYKA</li>
                                <li>{4} → 3000</li>
                            </ul>
                            
                            <p class="mt-2"><strong>Result:</strong></p>
                            <p class="font-mono bg-white p-2 rounded">Hi Ramakant,<br><br>✅ Order #ORD-76765 confirmed.<br><br>📦 Product: ZYKA<br>💰 Amount: ₹3000</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tips -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mt-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-green-900 mb-1">Tips</h4>
                        <ul class="text-xs text-green-700 space-y-1">
                            <li>• Use any numbers you want (1, 2, 3, 4, etc.)</li>
                            <li>• Same number can appear multiple times</li>
                            <li>• Numbers don't need to be sequential</li>
                            <li>• Keep templates clear and simple</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TinyMCE Rich Text Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '#template_content',
        height: 500,
        menubar: 'file edit view insert format tools table tcflow help',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'paste'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor forecolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'table link image | removeformat | help',
        content_style: `
            body { 
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
                font-size: 14px;
                line-height: 1.6;
            }
            ul, ol { 
                margin: 1em 0; 
                padding-left: 2.5em; 
                list-style-position: outside;
            }
            ul { list-style-type: disc; }
            ol { list-style-type: decimal; }
            li { 
                margin: 0.5em 0; 
                padding-left: 0.3em;
                line-height: 1.6;
            }
        `,
        branding: false,
        promotion: false,
        skin: 'oxide',
        content_css: 'default',
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        },
        init_instance_callback: function(editor) {
            console.log('TinyMCE initialized successfully');
        }
    });
});

let placeholderCounter = 1;

function insertPlaceholder() {
    // Check if TinyMCE is initialized
    if (tinymce.get('template_content')) {
        // Insert placeholder at cursor position in TinyMCE
        tinymce.get('template_content').execCommand('mceInsertContent', false, '{' + placeholderCounter + '}');
    } else {
        // Fallback to regular textarea
        const textarea = document.getElementById('template_content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        
        const text = textarea.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);
        
        // Insert next sequential placeholder
        const placeholder = `{${placeholderCounter}}`;
        textarea.value = before + placeholder + after;
        textarea.selectionStart = textarea.selectionEnd = start + placeholder.length;
        textarea.focus();
    }
    
    placeholderCounter++;
}
</script>
@endsection
