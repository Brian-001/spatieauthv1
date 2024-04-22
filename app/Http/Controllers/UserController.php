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

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'nullable',
            'roles' => 'required'
        ]);

        $data = [
            'name' =>$request->name,
            'email'=>$request->email
        ];

        if(!empty($request->password))
        {
            $data +=[
                'password' => Hash::make($request->password)
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User with roles updated successfully');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->destroy($userId);

        return redirect('/users')->with('status', 'User Deleted successfully');
    }
}
