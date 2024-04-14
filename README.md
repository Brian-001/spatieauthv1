# Spatie Roles and Permissions

Create normal laravel app 

```php
composer create-project laravel/laravel spatie-auth
``` 
Install spatie package in the app


```php
cd project
composer require spatie/laravel-permission
```
In Service Provider inside `config` folder `app.php` add the following

```php
'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];
```
Publish the migration and the config/permission.php config file with:

```php
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Clear your config cache

```php
 php artisan optimize:clear
 # or
 php artisan config:clear
 ```

 Run the migrations

 ```php
 php artisan migrate
 ```

Inside `Models` folder select `User` model and update the following trait

```php
 use HasRoles;
 ```

Create a PermissionController

```php
php artisan make:controller PermissionController -r
```

In `views` folder create two folders called `components` and `perm`. 

Inside components folder, create a file called layout.blade.php


Inside perm folder create the following files:
* index.blade.php
* create.blade.php
* edit.blade.php

Let's now populate our files with respective code

`layout.blade.php`
```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spatie Auth| Brian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Navbar -->
        <nav class="flex items-center justify-between bg-blue-500 p-4 shadow-lg">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/avatar.png') }}" alt="Logo" class="h-8 w-8 mr-2">
                <span class="text-white text-lg font-semibold">Dashboard</span>
            </div>
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/" class="text-white hover:text-gray-300">Home</a>
                <a href="" class="text-white hover:text-gray-300">About</a>
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
```

`index.blade.php`

```php 
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
```


*create.blade.php*

```php
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
```
