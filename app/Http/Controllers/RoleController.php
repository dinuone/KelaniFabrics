<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $roles = Role::when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]); // Keep search param in pagination links

        return view('role.index', compact('roles', 'search'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.manage', compact('permissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('role.manage', compact('role', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

        $role = Role::create(['name' => $request->name,'guard_name' => 'web']);
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Optional: detach permissions if needed
        $role->permissions()->detach();

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

   public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
        ]);

        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();

        $role->update(['name' => $request->name]);
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }
}

