<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function __construct(
        private readonly AuditService $auditService
    ) {}

    public function index(): View
    {
        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'C','location'=>'Client/DocumentController.php:19','message'=>'Documents index method called','data'=>['userId'=>auth()->id()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion
        
        $documents = Document::where('user_id', auth()->id())
            ->with(['requestedBy', 'approvedBy'])
            ->latest()
            ->paginate(10);

        // #region agent log
        file_put_contents('/Users/liam/Desktop/fidget/iopsf/securevault/.cursor/debug.log', json_encode(['sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'C','location'=>'Client/DocumentController.php:25','message'=>'Documents retrieved','data'=>['count'=>$documents->count()],'timestamp'=>time()*1000])."\n", FILE_APPEND);
        // #endregion

        return view('client.documents.index', compact('documents'));
    }

    public function create(): View
    {
        return view('client.documents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:id_proof,address_proof,bank_statement',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('document');
        $path = $file->store('documents/' . auth()->id(), 'public');

        $document = Document::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        $this->auditService->logDocument('uploaded', [
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'type' => $document->type,
        ]);

        return redirect()->route('client.documents.index')
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document): View
    {
        $this->authorize('view', $document);
        return view('client.documents.show', compact('document'));
    }

    public function download(Document $document)
    {
        $this->authorize('view', $document);
        
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found');
        }
        
        return response()->download(storage_path('app/public/' . $document->file_path));
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);

        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('client.documents.index')
            ->with('success', 'Document deleted successfully.');
    }
} 