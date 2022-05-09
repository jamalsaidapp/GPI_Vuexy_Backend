<?php


namespace App\Http\Services;


use Spatie\Permission\Models\Role;

class RoleService
{
  public function getRoles()
  {
    return Role::with('permissions')->get();
  }

  public function CreateRole($data)
  {
    $role = Role::create($data);
    $permissions =  $data['permissions'];
    $role->syncPermissions($permissions);
    return ['msg' => 'Role Ajouter !'];
  }

  public function UpdateRole($data, $role)
  {
    $role->update($data);
    $permissions =  $data['permissions'];
    $role->syncPermissions($permissions);
    return ['msg' => 'Role Modifier !'];
  }

}
