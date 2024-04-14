<x-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-xl">
        <h1 class="text-2xl font-semibold mb-4">Add Permissions</h1>
        <form action="{{ route('perm.store')}}" method="POST">
            @csrf
            <div class="mb-4 mt-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Permission Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter permission name">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add</button>
            </div>
        </form>
    </div>
</x-layout>
