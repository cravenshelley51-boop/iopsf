<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Document Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Document Information</h3>
                            <dl class="mt-4 grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $document->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $document->type)) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <x-document-status-badge :status="$document->status" />
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Requested By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        @if($document->requested_by)
                                            {{ $document->requestedBy->name }}
                                        @else
                                            Self-uploaded
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Uploaded At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                                @if($document->processed_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Processed By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->processedBy->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Processed At</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $document->processed_at->format('M d, Y H:i') }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Admin Notes -->
                        @if($document->admin_notes)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Admin Notes</h3>
                                <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-700">{{ $document->admin_notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Document Preview -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">Document Preview</h3>
                        <x-document-preview :document="$document" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('client.documents.index') }}" 
                           class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Documents
                        </a>
                        @if($document->status === 'pending')
                            <form action="{{ route('client.documents.destroy', $document) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete Document
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-client-layout> 