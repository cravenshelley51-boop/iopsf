@props(['document'])

<div class="mt-4">
    @if(in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
        <img src="{{ asset('storage/' . $document->file_path) }}" 
             alt="{{ $document->title }}"
             class="max-w-full h-auto rounded-lg shadow">
    @else
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-sm text-gray-500">PDF Document</p>
            <a href="{{ asset('storage/' . $document->file_path) }}" 
               target="_blank"
               class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                View PDF
            </a>
        </div>
    @endif
</div> 

<div class="mt-4">
    @if(in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
        <img src="{{ asset('storage/' . $document->file_path) }}" 
             alt="{{ $document->title }}"
             class="max-w-full h-auto rounded-lg shadow">
    @else
        <div class="bg-gray-50 rounded-lg p-4 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-sm text-gray-500">PDF Document</p>
            <a href="{{ asset('storage/' . $document->file_path) }}" 
               target="_blank"
               class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                View PDF
            </a>
        </div>
    @endif
</div> 