<?php

namespace Modules\User\Helpers;

use Modules\User\Entities\Role;
use Nwidart\Modules\Facades\Module;

class RoleHelper
{
    public function getAllRoles()
    {
        $roles = Role::select(app(Role::class)->getTable() . '.*')->get();

        return $roles;
    }

    public function createRole($data, $permissions)
    {
        $role = Role::create($data);
        $role->syncPermissions($permissions);

        return $role;
    }

    public function updateRole($roleId, $data, $permissions)
    {
        $role = Role::find($roleId);
        $role->name = $data['name'];
        $role->save();
        $role->syncPermissions($permissions);

        return $role;
    }

    public function getRole($roleId)
    {
        return Role::find($roleId);
    }

    public function getAllRole()
    {
        return Role::all();
    }

    public function delete($roleId)
    {
        return Role::find($roleId)->delete();
    }

    public function searchRole($keyword, $gaurd)
    {
        $role = Role::where('name', 'like', "%{$keyword}%")->where('guard_name', $gaurd);

        if (auth()->user()->roles_array) {
            $role = $role->whereIn('id', auth()->user()->roles_array);
        }

        return $role->orderBy('name', 'asc')->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getPermissions($guardName = null)
    {
        $modules = Module::all();
        $permissions = [];

        foreach ($modules as $module) {

            $modulePermissions = $module->json('permissions.json')->getAttributes();

            foreach ($modulePermissions as $modulePermission) {
                array_push($permissions, $modulePermission);
            }
        }
        $keys = array_column($permissions, 'label');
        array_multisort($keys, SORT_ASC, $permissions);

        return $permissions;
    }

    public function getRoleIdByRole($role)
    {
        return Role::where('name', $role)->first();
    }
}
