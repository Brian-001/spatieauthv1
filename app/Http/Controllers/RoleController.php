<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index()
    {
        //
        $roles  = Role::get();
        return view('rol.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('rol.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);
        Role::create([
            'name' => $request->name
        ]);
        return redirect('rol')->with('status', 'Role Created Successfully');
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
        $role = Role::findOrFail($id); // Fetch the permission data
        return view('rol.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $request->route('role')->id
        ]);
        try {

            $role->update([
                'name' => $request->name
            ]);
            return redirect('rol')->with('status', 'Role updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Failed to update role']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($roleId)
    {
        //
        $role = Role::findOrFail($roleId);
        $role->delete($roleId);

        return redirect('rol')->with('status', 'Role deleted successfully');
    }
}
