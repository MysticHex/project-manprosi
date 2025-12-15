<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.categories.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">New Category</a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800">{{ session('success') }}</div>
                    @endif

                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Slug</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $category->name }}</td>
                                    <td class="px-4 py-2">{{ $category->slug }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 mr-2">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $categories->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
