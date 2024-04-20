<h1 style= "color:cyan;">Spatie Roles and Permissions</h1> 

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
                        <td class="border-2 px-4 py-4">Id</td>
                        <td class="border-2 px-4 py-4">Name</td>
                        <td class="border-2 px-4 py-4">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission )
                    <tr>
                        <td class="border-2 px-4 py-4">{{$permission->id}}</td>
                        <td class="border-2 px-4 py-4">{{$permission->name}}</td>
                        <td class="border-2 px-4 py-4">
                            <div class="inline-flex">
                                <a href="{{ route('perm.edit', $permission->id)}}" class="decoration-none bg-green-500 text-white hover:bg-green-700 px-4 py-2 rounded-lg cursor-pointer">Edit</a>
                                <form action="{{ route('perm.destroy', $permission->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="decoration-none bg-red-500 text-white hover:bg-red-700 px-4 py-2 rounded-lg cursor-pointer">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="border-2">Sorry! No Permission Found</td>
                    </tr>
                    @endforelse

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
*edit.blade.php*

```php
<x-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-xl">
        <h1 class="text-2xl font-semibold mb-4">Edit Permissions</h1>
        <form action="{{route('perm.update', $permission->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4 mt-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Permission Name</label>
                <input type="text" name="name" value="{{ $permission->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                @error('name')
                <p class="text-red-500 text-xs mt-1">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</x-layout>
```
*PermissionController*
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions  = Permission::get();
        return view('perm.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('perm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);
        Permission::create([
            'name' => $request->name
        ]);
        return redirect('/')->with('status', 'Permission Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $permission = Permission::findOrFail($id); // Fetch the permission data
        return view('perm.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $request->route('permission')->id
        ]);

        //Handles an exception that might occur during update gracefully
        try {

            $permission->update([
                'name' => $request->name
            ]);
            return redirect('/')->with('status', 'Permission updated successfully');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to update permission']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($permissionId)
    {
        //
        $permission = Permission::findOrFail($permissionId);
        $permission->delete($permissionId);

        return redirect('/')->with('status', 'Permission deleted successfully');
    }
}

```

*web.php*

```php
<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/**********************************************************************************************/
                            /*Routes that handle Permission*/
/**********************************************************************************************/
Route::get('/', [PermissionController::class, 'index']); //Default route
Route::get('/perm', [PermissionController::class, 'index'])->name('perm.index');
Route::get('/perm/create', [PermissionController::class, 'create'])->name('perm.create');
Route::post('/perm', [PermissionController::class, 'store'])->name('perm.store');
Route::get('/perm/{id}', [PermissionController::class, 'show'])->name('perm.show');
Route::get('/perm/{id}/edit', [PermissionController::class, 'edit'])->name('perm.edit');
Route::put('/perm/{permission}', [PermissionController::class, 'update'])->name('perm.update');
Route::delete('/perm/{permissionId}', [PermissionController::class, 'destroy'])->name('perm.destroy');

```

>Create the same structure for roles and remember to forego the default route in web.php


Create a form called `add-permissions.blade.php`. Since you are adding permissions to roles naming the blade file `add-permissions.blade.php is still fine

```php
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
```
Form action is specified using `route()` helper function and the `route name` defined.
Let's breakdown this form action just a little bit.

```php
<form action="{{route('rol.give-permissions', ['roleId' => $role->id])}}" method="POST">
```
This form is specifying a route using Laravel route() helper function. It is pointing to a route named `rol.give-permissions` and passing a parameter `roleId` with the value of `role->id`. This means when the form is submitted, it will send a `POST` request to the route named `rol.give-permissions` with role Id as a parameter.

```php

Route::get('/rol/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('rol.give-permissions');

```
This route definition in Laravel maps a `GET` request to the URL pattern `/rol/{roleId}/give-permissions` to the `addPermissionToRole() `method within the `RoleController` class. 

It also assigns the name `rol.give-permissions` to this route, allowing it to be referenced easily in other parts of the application using Laravel's route helper functions. The `{roleId}` part in the URL pattern represents a dynamic parameter that will be passed to the controller method.


Add the following to the `RoleController`

```php
    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get(); //Gets all permissions from Spatie Permission Model
        $role = Role::findOrFail($roleId); //Finds roleId from Spatie Role Model
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        /**Passes role, permissions and rolePermissions to the view called add-permissions.blade.php**/
        return view('rol.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**This functions updates permissions assigned to roles*/
    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([

            'permission' => 'required'
        ]);
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status', 'Permission added to role');
    }
```
Let's Start by breaking down the first method
```php
public function addPermissionToRole($roleId)
```
This method accepts parameter `$roleId` which represents the the ID of the role to which permissions will be added.

*Fetching Role Permissions*
```php
$permissions = Permission::get();
$role = Role::findOrFail($roleId);
```
It fetches all `permissions` from the `Spatie Permission model` and stores them in the `$permissions` variable.

It also finds the `role` with the given `$roleId` using the `Spatie Role model` and stores it in the `$role` variable

```php
$rolePermissions = DB::table('role_has_permissions')
    ->where('role_has_permissions.role_id', $role->id)
    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
    ->all();
```
The above fetches the `permissions` assigned to the specified `role ($roleId)` from the `role_has_permissions` table.

The `pluck()` method retrieves only the `permission_id` column from the result and creates `an associative array` where the `permission_id` is both the key and the value.

The `all()` method converts the result to an array.

*Passing data to the view*

```php
return view('rol.add-permissions', [
    'role' => $role,
    'permissions' => $permissions,
    'rolePermissions' => $rolePermissions
]);
```
Returns a view named `add-permissions.blde.php` in `rol` folder.

It passes the data to the view in associative array

* The `$role variable`, containing the `role object`.
* The `$permissions variable`, containing `all permissions`
* The `$rolePermissions variable`, containing `permissions` assigned to the `role`
