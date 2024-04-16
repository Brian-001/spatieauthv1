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
