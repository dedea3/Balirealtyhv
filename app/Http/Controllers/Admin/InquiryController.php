<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with(['villa', 'assignedTo'])
            ->latest()
            ->paginate(20);
        
        $stats = [
            'new' => Inquiry::where('status', 'new')->count(),
            'contacted' => Inquiry::where('status', 'contacted')->count(),
            'confirmed' => Inquiry::where('status', 'confirmed')->count(),
            'archived' => Inquiry::where('status', 'archived')->count(),
        ];
        
        return view('admin.inquiries.index', compact('inquiries', 'stats'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['villa', 'assignedTo']);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,confirmed,cancelled,archived',
            'admin_notes' => 'nullable|string',
        ]);

        $inquiry->update($validated);

        return back()->with('success', 'Inquiry updated successfully.');
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,confirmed,cancelled,archived',
        ]);

        $inquiry->update($validated);

        if ($validated['status'] === 'contacted') {
            $inquiry->update(['contacted_at' => now()]);
        } elseif ($validated['status'] === 'confirmed') {
            $inquiry->update(['confirmed_at' => now()]);
        }

        return back()->with('success', 'Inquiry status updated successfully.');
    }

    public function assign(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $inquiry->update(['assigned_to' => $validated['assigned_to']]);

        return back()->with('success', 'Inquiry assigned successfully.');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        
        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry deleted successfully.');
    }
}
