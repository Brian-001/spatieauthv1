<x-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-xl">
        <h1 class="text-2xl font-semibold mb-4">Create Users</h1>
        <form action="{{ route('users.store')}}" method="POST">
            @csrf
            <div class="mb-4 mt-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter User name">
                @error('name')
                <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="mb-4 mt-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter User email">
                @error('email')
                <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="mb-4 mt-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" placeholder="Enter User Password">
                @error('password')
                <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="mb-4 mt-4">
                <label for="roles" class="block text-gray-700 font-semibold mb-2">Roles</label>
                <select name="roles[]" multiple class="w-full">
                    <option value="" disabled class="w-full px-4 py-2 shadow-lg mb-4">----Select Role----</option>
                    @foreach($roles as $role)
                    <div class="">
                        <option value="{{$role}}" class="w-full px-4 py-2 shadow-lg mb-4 rounded-2xl text-center hover:bg-blue-400">{{$role}}</option>
                    </div>
                    @endforeach
                </select>
                @error('password')
                <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Add</button>
            </div>
        </form>
    </div>
</x-layout>
