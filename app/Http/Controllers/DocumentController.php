<?php

namespace App\Http\Controllers;

use App\Models\RequiredDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        try {
            Log::info('Document upload started', [
                'user_id' => Auth::id(),
                'type' => $request->type,
                'file' => $request->file('document') ? $request->file('document')->getClientOriginalName() : 'no file'
            ]);

            $request->validate([
                'type' => ['required', 'string', Rule::in(array_keys(RequiredDocument::getDocumentTypes()))],
                'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            ]);

            $user = Auth::user();
            $file = $request->file('document');
            $path = $file->store('documents/' . $request->type, 'public');

            Log::info('File stored', ['path' => $path]);

            // Check if user already has a document of this type
            $existingDocument = RequiredDocument::where('user_id', $user->id)
                ->where('type', $request->type)
                ->first();
            
            if ($existingDocument) {
                Log::info('Updating existing document', ['document_id' => $existingDocument->id]);
                
                // Delete old file if it exists
                if ($existingDocument->file_path) {
                    Storage::disk('public')->delete($existingDocument->file_path);
                }
                
                // Update existing document
                $existingDocument->update([
                    'file_path' => $path,
                    'status' => 'pending',
                    'admin_notes' => null
                ]);
            } else {
                Log::info('Creating new document');
                
                // Create new document
                $document = RequiredDocument::create([
                    'user_id' => $user->id,
                    'type' => $request->type,
                    'file_path' => $path,
                    'status' => 'pending'
                ]);

                Log::info('New document created', ['document_id' => $document->id]);
            }

            return redirect()->back()->with('success', 'Document uploaded successfully. Waiting for admin approval.');
        } catch (\Exception $e) {
            Log::error('Document upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    public function download(RequiredDocument $document)
    {
        $user = Auth::user();
        
        // Check if the user owns the document or is an admin
        if ($document->user_id !== $user->id && !$user->hasRole('admin')) {
            abort(403);
        }

        return response()->download(storage_path('app/public/' . $document->file_path));
    }
} 