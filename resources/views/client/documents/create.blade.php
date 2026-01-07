<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('client.documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                        <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       required>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                        </div>

                        <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Document Type</label>
                                <select name="type" id="type" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        required>
                                    <option value="">Select a type</option>
                                    <option value="id_proof">ID Proof</option>
                                    <option value="address_proof">Address Proof</option>
                                    <option value="bank_statement">Bank Statement</option>
                            </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                        </div>

                        <div>
                                <label for="document" class="block text-sm font-medium text-gray-700">Document File</label>
                                <input type="file" name="document" id="document" 
                                       class="mt-1 block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-indigo-50 file:text-indigo-700
                                              hover:file:bg-indigo-100"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       required>
                                <p class="mt-1 text-sm text-gray-500">
                                    Accepted formats: PDF, JPG, JPEG, PNG (max 2MB)
                                </p>
                                @error('document')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                        </div>

                            <div class="flex justify-end">
                                <a href="{{ route('client.documents.index') }}" 
                                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                                <button type="submit" 
                                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Upload Document
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-client-layout> 