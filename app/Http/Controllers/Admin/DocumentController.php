<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequiredDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = RequiredDocument::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.documents.index', compact('documents'));
    }

    public function show(RequiredDocument $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    public function approve(RequiredDocument $document)
    {
        $document->update([
            'status' => 'approved',
            'admin_notes' => null
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document approved successfully.');
    }

    public function reject(Request $request, RequiredDocument $document)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:255'
        ]);

        $document->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Document rejected successfully.');
    }

    public function download(RequiredDocument $document)
    {
        return response()->download(storage_path('app/public/' . $document->file_path));
    }
} 