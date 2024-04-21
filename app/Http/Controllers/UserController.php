<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', [

            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->name),
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User created successfully');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,name',
            'password' => 'required'
        ]);

    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->destroy($userId);

        return redirect('/users')->with('status', 'User Deleted successfully');
    }
}
