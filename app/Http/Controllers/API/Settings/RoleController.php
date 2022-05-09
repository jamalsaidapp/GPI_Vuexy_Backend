<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRole;
use App\Http\Requests\Role\UpdateRole;
use App\Http\Services\RoleService;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Role[]
     */
    public function index()
    {
        return $this->roleService->getRoles();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRole $request)
    {
        return $this->roleService->CreateRole($request->validated()) ;
    }

    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request,Role $role)
    {
        return $this->roleService->UpdateRole($request->validated(), $role ) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string[]
     */
    public function destroy($id): array
    {
        return ['msg' => 'Role Supprimer !'];
    }
}
