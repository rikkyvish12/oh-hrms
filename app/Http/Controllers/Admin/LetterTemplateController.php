<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use Illuminate\Http\Request;

class LetterTemplateController extends Controller
{
    /**
     * Display a listing of letter templates.
     */
    public function index()
    {
        $templates = LetterTemplate::orderBy('name')
            ->paginate(15);
        
        return view('admin.letter-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new letter template.
     */
    public function create()
    {
        return view('admin.letter-templates.create');
    }

    /**
     * Store a newly created letter template.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_content' => 'required|string',
        ]);

        // Extract placeholders from content
        preg_match_all('/\{(\d+)\}/', $request->template_content, $matches);
        $placeholders = array_map('intval', array_unique($matches[1]));

        LetterTemplate::create([
            'name' => $request->name,
            'template_content' => $request->template_content,
            'placeholders' => $placeholders,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Letter template created successfully.');
    }

    /**
     * Display the specified letter template.
     */
    public function show(LetterTemplate $letterTemplate)
    {
        return view('admin.letter-templates.show', compact('letterTemplate'));
    }

    /**
     * Show the form for editing the specified letter template.
     */
    public function edit(LetterTemplate $letterTemplate)
    {
        return view('admin.letter-templates.edit', compact('letterTemplate'));
    }

    /**
     * Update the specified letter template.
     */
    public function update(Request $request, LetterTemplate $letterTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_content' => 'required|string',
        ]);

        // Extract placeholders from content
        preg_match_all('/\{(\d+)\}/', $request->template_content, $matches);
        $placeholders = array_map('intval', array_unique($matches[1]));

        $letterTemplate->update([
            'name' => $request->name,
            'template_content' => $request->template_content,
            'placeholders' => $placeholders,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Letter template updated successfully.');
    }

    /**
     * Remove the specified letter template.
     */
    public function destroy(LetterTemplate $letterTemplate)
    {
        $letterTemplate->delete();
        
        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Letter template deleted successfully.');
    }
}
