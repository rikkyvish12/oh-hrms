<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Letter;
use App\Models\User;
use App\Models\LetterTemplate;

class LetterController extends Controller
{
    /**
     * Display a listing of letters.
     */
    public function index()
    {
        $letters = Letter::with(['employee.employeeDetail', 'template'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.letters.index', compact('letters'));
    }

    /**
     * Show the form for creating a new letter.
     */
    public function create()
    {
        $employees = User::where('user_type', 'employee')
            ->with('employeeDetail')
            ->get();
        
        $templates = LetterTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.letters.create', compact('employees', 'templates'));
    }

    /**
     * Get template details for AJAX requests
     */
    public function getTemplate($templateId)
    {
        $template = LetterTemplate::findOrFail($templateId);
        return response()->json([
            'content' => $template->template_content,
            'placeholders' => $template->placeholders,
            'placeholder_count' => $template->placeholder_count,
        ]);
    }

    /**
     * Store a newly created letter.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:users,id',
            'template_id' => 'required|exists:letter_templates,id',
            'placeholder_values' => 'required|string', // It's a JSON string
        ]);

        $template = LetterTemplate::findOrFail($request->template_id);
        
        // Decode the JSON placeholder values
        $placeholderValues = json_decode($request->placeholder_values, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->withErrors(['placeholder_values' => 'Invalid placeholder values format.'])->withInput();
        }
        
        // Debug: Check if values are empty
        if (empty($placeholderValues)) {
            return back()->withErrors(['placeholder_values' => 'No placeholder values provided. Please fill in all placeholder fields.'])->withInput();
        }
        
        // Generate content from template with placeholder values
        $content = $template->generateContent($placeholderValues);

        Letter::create([
            'employee_id' => $request->employee_id,
            'template_id' => $request->template_id,
            'content' => $content,
            'generated_at' => now(),
        ]);

        return redirect()->route('admin.letters.index')
            ->with('success', 'Letter generated successfully.');
    }

    /**
     * Display the specified letter.
     */
    public function show(Letter $letter)
    {
        $letter->load('employee.employeeDetail', 'template');
        return view('admin.letters.show', compact('letter'));
    }

    /**
     * Show the form for editing the specified letter.
     */
    public function edit(Letter $letter)
    {
        return view('admin.letters.edit', compact('letter'));
    }

    /**
     * Update the specified letter.
     */
    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $letter->update([
            'content' => $request->content,
        ]);

        return redirect()->route('admin.letters.index')
            ->with('success', 'Letter updated successfully.');
    }

    /**
     * Remove the specified letter.
     */
    public function destroy(Letter $letter)
    {
        $letter->delete();
        return redirect()->route('admin.letters.index')
            ->with('success', 'Letter deleted successfully.');
    }
}
