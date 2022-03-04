<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(userservice $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
       return $this->userService->getUsers();
    }

    public function show(User $user)
    {
       return $this->userService->showUser($user);
    }

    public function store(UserCreateRequest $request)
    {
       return $this->userService->CreateUser($request->validated());
    }

    public function update(UserUpdateRequest $request, User $user)
    {
       return $this->userService->UpdateUser($request->validated(), $user);
    }

    public function destroy($ids)
    {
       return $this->userService->DeleteUser($ids);
    }
    public function restore($id)
    {
        User::onlyTrashed()->where('id', $id)->restore();
        return ['msg' => 'Utilisateur Restaurer !'];
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }

    public function GetUserPermissions($id)
    {
        return $id;
    }


}
