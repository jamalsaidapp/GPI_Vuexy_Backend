<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\PermissionCreate;
use App\Http\Requests\Permission\PermissionUpdate;
use App\Http\Services\PermissionService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use function Sodium\compare;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return $this->permissionService->getPermissions();
    }

    public function store(PermissionCreate $request)
    {
        return $this->permissionService->CreatePermission($request->validated());
    }

    public function show($id)
    {
       return $this->permissionService->getUserPermissions($id);
    }


    public function update(PermissionUpdate $request, Permission $permission)
    {
        return $this->permissionService->UpdatePermission($request->validated(), $permission);
    }

    public function destroy(Permission $permission)
    {
        //
    }

    public function setUserPermissions(Request $request,$id)
    {
      return  $this->permissionService->setUserPermissions($request->permissions ,$id);
    }
}
