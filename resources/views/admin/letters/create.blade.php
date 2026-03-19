@extends('layouts.admin')

@section('title', 'Generate Letter')
@section('page-title', 'Generate Letter')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Generate Letter</h1>
                <p class="text-gray-600">Create letters using templates with numbered placeholders</p>
            </div>
            <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Letters
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Letter Details</h2>
                    <p class="text-gray-600 mt-1">Select employee, template, and fill in placeholder values</p>
                </div>
                
                <form action="{{ route('admin.letters.store') }}" method="POST" class="p-6">
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
                    
                    <!-- Employee Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Employee (Optional - for reference)
                        </label>
                        <select name="employee_id" id="employee_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="">Select Employee (Optional)</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Template Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Letter Template
                        </label>
                        <select name="template_id" id="template_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required onchange="loadTemplate()">
                            <option value="">Select Template</option>
                            @foreach($templates as $template)
                            <option value="{{ $template->id }}">
                                {{ $template->name }}
                            </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Template will load with numbered placeholders like {1}, {2}, {3}</p>
                    </div>

                    <!-- Placeholder Values Input (Dynamic) -->
                    <div id="placeholder_inputs_container" class="mb-6 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 16h16"></path>
                            </svg>
                            Placeholder Values
                        </label>
                        <div id="placeholder_inputs" class="space-y-3">
                            <!-- Dynamic placeholder inputs will be added here -->
                        </div>
                    </div>

                    <!-- Letter Content (Read-only Preview) -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Template Preview
                            </label>
                            <button type="button" onclick="showPreviewModal()" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" id="preview_btn" disabled>
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Preview Template
                            </button>
                        </div>
                        <textarea name="content_preview" id="content_preview" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 font-mono text-sm" rows="10" readonly placeholder="Template content will appear here..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">This shows the template with placeholders. Final letter will be generated after filling values.</p>
                    </div>

                    <input type="hidden" name="placeholder_values" id="placeholder_values_json" value="{}">

                    <!-- Form Actions -->
                    <div class="flex items-center space-x-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md btn-hover">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Generate Letter
                        </button>
                        <a href="{{ route('admin.letters.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
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
                    <h3 class="text-lg font-semibold text-white">How It Works</h3>
                    <p class="text-indigo-100 text-sm mt-1">Simple 3-step process</p>
                </div>
                <div class="p-4 space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">1</div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900">Select Template</h4>
                            <p class="text-xs text-gray-600 mt-1">Choose a template with numbered placeholders like {1}, {2}, {3}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">2</div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900">Fill Values</h4>
                            <p class="text-xs text-gray-600 mt-1">Enter values for each numbered placeholder</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">3</div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900">Generate</h4>
                            <p class="text-xs text-gray-600 mt-1">Click "Replace Placeholders" to generate the letter</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Example -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 mb-2">Example</h4>
                        <div class="text-xs text-blue-700 space-y-2">
                            <p><strong>Template:</strong></p>
                            <p class="font-mono bg-white p-2 rounded">Hi {1},<br>Your order #{2} is confirmed.<br>Product: {3}</p>
                            
                            <p class="mt-2"><strong>Values:</strong></p>
                            <ul class="list-disc list-inside ml-2">
                                <li>{1} = Ramakant</li>
                                <li>{2} = ORD-76765</li>
                                <li>{3} = ZYKA</li>
                            </ul>
                            
                            <p class="mt-2"><strong>Output:</strong></p>
                            <p class="font-mono bg-white p-2 rounded">Hi Ramakant,<br>Your order #ORD-76765 is confirmed.<br>Product: ZYKA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentPlaceholders = [];

function loadTemplate() {
    const templateId = document.getElementById('template_id').value;
    
    if (!templateId) {
        document.getElementById('content_preview').value = '';
        document.getElementById('placeholder_inputs_container').classList.add('hidden');
        document.getElementById('preview_btn').disabled = true;
        return;
    }
    
    // Fetch template details via AJAX
    fetch(`/admin/letters/template/${templateId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('content_preview').value = data.content;
            currentPlaceholders = data.placeholders || [];
            
            // Enable preview button
            document.getElementById('preview_btn').disabled = false;
            
            if (currentPlaceholders.length > 0) {
                showPlaceholderInputs(currentPlaceholders);
            } else {
                document.getElementById('placeholder_inputs_container').classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error loading template:', error);
            alert('Error loading template. Please try again.');
        });
}

function showPlaceholderInputs(placeholders) {
    const container = document.getElementById('placeholder_inputs');
    const wrapper = document.getElementById('placeholder_inputs_container');
    
    container.innerHTML = '';
    
    // Sort placeholders numerically
    placeholders.sort((a, b) => a - b);
    
    placeholders.forEach(num => {
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-3';
        div.innerHTML = `
            <label class="w-24 text-sm font-medium text-gray-700">Value {${num}}:</label>
            <input type="text" 
                   id="placeholder_${num}" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                   placeholder="Enter value for {${num}}"
                   oninput="updatePlaceholderValue(${num}, this.value)">
        `;
        container.appendChild(div);
    });
    
    wrapper.classList.remove('hidden');
}

function updatePlaceholderValue(number, value) {
    // Store values in a JSON object
    let values = {};
    
    try {
        values = JSON.parse(document.getElementById('placeholder_values_json').value || '{}');
    } catch(e) {
        values = {};
    }
    
    values[number] = value;
    document.getElementById('placeholder_values_json').value = JSON.stringify(values);
}

function clearContent() {
    document.getElementById('content_preview').value = '';
    document.getElementById('placeholder_inputs_container').classList.add('hidden');
    document.getElementById('template_id').value = '';
    document.getElementById('preview_btn').disabled = true;
    document.getElementById('placeholder_values_json').value = '{}';
    currentPlaceholders = [];
}

// Preview Modal Functions
function showPreviewModal() {
    const content = document.getElementById('content_preview').value;
    if (!content) {
        alert('Please select a template first.');
        return;
    }
    
    // Decode HTML entities and render
    const decodedContent = htmlEntityDecode(content);
    document.getElementById('modal_content').innerHTML = decodedContent;
    document.getElementById('preview_modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closePreviewModal() {
    document.getElementById('preview_modal').classList.add('hidden');
    document.body.style.overflow = ''; // Restore scrolling
}

// Close modal when clicking outside
function closeModalOnClickOutside(event) {
    const modal = document.getElementById('preview_modal');
    if (event.target === modal) {
        closePreviewModal();
    }
}

// HTML Entity Decoder
function htmlEntityDecode(text) {
    const textarea = document.createElement('textarea');
    textarea.innerHTML = text;
    return textarea.value;
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('preview_modal');
        if (modal && !modal.classList.contains('hidden')) {
            closePreviewModal();
        }
    }
});
</script>

<!-- Preview Modal -->
<div id="preview_modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4" onclick="closeModalOnClickOutside(event)">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-purple-600">
            <h3 class="text-xl font-bold text-white">Template Preview</h3>
            <button type="button" onclick="closePreviewModal()" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
            <div class="font-sans text-gray-800 leading-normal letter-content-preview border border-gray-200 rounded-lg p-6 bg-white">
                <div id="modal_content"></div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
            <button type="button" onclick="closePreviewModal()" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<style>
/* Preview modal content styling */
#modal_content p {
    margin: 0.5em 0;
    line-height: 1.6;
}

#modal_content br {
    line-height: 1.4;
}

#modal_content ul, #modal_content ol {
    margin: 1em 0;
    padding-left: 2.5em;
    list-style-position: outside;
}

#modal_content ul {
    list-style-type: disc;
}

#modal_content ol {
    list-style-type: decimal;
}

#modal_content li {
    margin: 0.5em 0;
    padding-left: 0.3em;
    line-height: 1.6;
}

#modal_content li::marker {
    color: inherit;
}

#modal_content strong, #modal_content b {
    font-weight: 600;
}
</style>
@endsection