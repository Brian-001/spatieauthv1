<x-layout>
    <div class="min-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-xl">
        @if (session('status'))
        <div class="bg-green-400 mt-3">
            <p>{{ session('status')}}</p>
        </div>
        @endif
        <h1 class="text-2xl font-semibold mb-4">Role: <span class="text-blue-600">{{$role->name}}</span></h1>
        <form action="{{route('rol.give-permissions', ['roleId' => $role->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4 mt-4">
                @error('permission')
                <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>
                @enderror
                <label for="permissions" class="block text-gray-700 font-semibold mb-2">Permissions</label>
                <div class="flex flex-wrap mt-2">
                    @foreach ($permissions as $permission)
                    <label class="inline-flex items-center mr-16 mb-2">
                        <input
                        type="checkbox"
                        name="permission[]"
                        value="{{ $permission->name }}"
                        {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}
                        class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</x-layout>
