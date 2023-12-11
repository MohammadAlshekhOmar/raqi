<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function all($guard)
    {
        return Role::where('guard_name', $guard)->get();
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function add($request)
    {
        $role = Role::create($request);
        $role->syncPermissions($request['permissions']);
        return $role;
    }

    public function edit($request)
    {
        $role = Role::find($request['id']);
        $role->update($request);
        $role->syncPermissions($request['permissions']);
        return $role;
    }

    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        return $role;
    }
}
