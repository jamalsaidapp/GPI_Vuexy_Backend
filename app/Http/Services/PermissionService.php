<?php


namespace App\Http\Services;


use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function getPermissions()
    {
        return Permission::all();
    }

    public function CreatePermission($data): array
    {
         Permission::create($data);
        return ['msg' => 'Permission Ajouter !'];
    }

    public function UpdatePermission($data, $permissions): array
    {
         $permissions->update($data);
        return ['msg' => 'Permission Modifier !'];
    }

    public function getUserPermissions($id): array
    {
        $user= User::findOrFail($id);
        $permissions = $user->getAllPermissions();
        $initialPerms = Permission::all();
        return compact('permissions','initialPerms');
    }

    public function setUserPermissions($permissions,$id)
    {
        $user= User::findOrFail($id);
        $user->syncPermissions($permissions);
        return ['msg' => 'Permissions Affecter !'];
    }
}
