<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
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

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get(); //Gets all permissions from Spatie Permission Model
        $role = Role::findOrFail($roleId); //Finds roleId from Spatie Role Model

        /*fetches the permissions assigned to the specified role ($roleId)
        from the role_has_permissions table.
        */
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
}
