<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IpRestriction;

class IpRestrictionController extends Controller
{
    /**
     * Display a listing of IP restrictions.
     */
    public function index()
    {
        $ipRestrictions = IpRestriction::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ip-restrictions.index', compact('ipRestrictions'));
    }

    /**
     * Show the form for creating a new IP restriction.
     */
    public function create()
    {
        return view('admin.ip-restrictions.create');
    }

    /**
     * Store a newly created IP restriction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:ip_restrictions',
            'is_active' => 'boolean',
        ]);

        IpRestriction::create([
            'ip_address' => $request->ip_address,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.ip-restrictions.index')
            ->with('success', 'IP restriction created successfully.');
    }

    /**
     * Display the specified IP restriction.
     */
    public function show(IpRestriction $ipRestriction)
    {
        return view('admin.ip-restrictions.show', compact('ipRestriction'));
    }

    /**
     * Show the form for editing the specified IP restriction.
     */
    public function edit(IpRestriction $ipRestriction)
    {
        return view('admin.ip-restrictions.edit', compact('ipRestriction'));
    }

    /**
     * Update the specified IP restriction.
     */
    public function update(Request $request, IpRestriction $ipRestriction)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:ip_restrictions,ip_address,' . $ipRestriction->id,
            'is_active' => 'boolean',
        ]);

        $ipRestriction->update([
            'ip_address' => $request->ip_address,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.ip-restrictions.index')
            ->with('success', 'IP restriction updated successfully.');
    }

    /**
     * Toggle the active status of the specified IP restriction.
     */
    public function toggle(IpRestriction $ipRestriction)
    {
        $ipRestriction->update([
            'is_active' => !$ipRestriction->is_active,
        ]);

        return back()->with('success', 'IP restriction status updated successfully.');
    }

    /**
     * Remove the specified IP restriction.
     */
    public function destroy(IpRestriction $ipRestriction)
    {
        $ipRestriction->delete();
        return redirect()->route('admin.ip-restrictions.index')
            ->with('success', 'IP restriction deleted successfully.');
    }
}
