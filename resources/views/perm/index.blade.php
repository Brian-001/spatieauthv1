<x-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-xl">
        <h1 class="text-2xl font-semibold mb-4">Permissions</h1>
        <div class="mb-4">
            <label for="perm_name" class="block text-gray-700 font-semibold mb-2">Permissions List</label>
            @if (session('status'))
            <div class="bg-green-400 mt-3">
                <p>{{ session('status')}}</p>
            </div>
            @endif
            <table class="table-auto w-full mt-4">
                <thead>
                    <tr>
                        <td class="border-2 px-4 py-2">Id</td>
                        <td class="border-2 px-4 py-2">Name</td>
                        <td class="border-2 px-4 py-2">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-2 px-4 py-2">1</td>
                        <td class="border-2 px-4 py-2">Create Post</td>
                        <td class="border-2 px-4 py-2">Delete</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-end">
            <a href="{{route('perm.create')}}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add</a>
        </div>
    </div>
</x-layout>
