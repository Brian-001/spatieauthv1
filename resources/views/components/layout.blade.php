<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spatie Auth| Brian</title>
    @vite(['resources/css/app.css'], ['resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Navbar -->
        <nav class="flex items-center justify-between bg-blue-500 p-4 shadow-lg">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/avatar.png') }}" alt="Logo" class="h-8 w-8 mr-2">
                <span class="text-white text-lg font-semibold">SpatieAuth</span>
            </div>
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/" class="text-white hover:text-gray-300">Home</a>
                <a href="{{route('perm.create')}}" class="text-white hover:text-gray-300">+ Permissions</a>
                <a href="{{route('rol.create')}}" class="text-white hover:text-gray-300">+ Roles</a>
                <a href="{{route('rol.index')}}" class="text-white hover:text-gray-300">Roles</a>
                <!-- Add more navigation links as needed -->
            </div>
            <!-- Dropdown for Login/Logout -->
            <div class="relative">
                <button class="text-white hover:text-gray-300 focus:outline-none">
                    User
                </button>
                <div class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Login</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="flex-1 p-4">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
