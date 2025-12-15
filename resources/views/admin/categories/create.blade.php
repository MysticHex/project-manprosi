<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Category</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300" required>
                        @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.categories.index') }}" class="mr-2 px-4 py-2 border rounded">Cancel</a>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
