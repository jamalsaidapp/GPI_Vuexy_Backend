<?php


namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use App\Http\JsonResponse;
use mysql_xdevapi\Exception;


class UserService
{
    private $response;

    public function __construct()
    {
        $this->response = new JsonResponse();
    }

    public function getUsers()

    {
        // return UserResource::collection(Cache::remember('users', 60 * 60 * 24, function () {
        //     return User::with('roles')->get();
        // }));
        //    $user = User::findOrFail(2);

        //    $user->restore();

        // return UserResource::collection(User::onlyTrashed()->with('roles')->with('permissions')->whereNull('deleted_at')->get());
        return UserResource::collection(User::with('roles')->with('permissions')->withTrashed()->get());

    }

    public function showUser($user): User
    {
        return $user;
    }

    public function CreateUser($data)
    {
        $newData = data_set($data, 'password', \Hash::make($data['password']));
        try {
            $user = User::create($newData);
            if ($data['role']) {
                $this->handleRoles($user, $data['role']);
            }
            return $this->response->success('Utlisateur Ajouter !');
        }catch (Exception $exception){
            return $this->response->fail($exception->getMessage());
        }
    }

    public function UpdateUser($data, $user)
    {
        try {
            if (isset($data['password'])) {
                $newData = data_set($data, 'password', \Hash::make($data['password']));
                $user->update($newData);
            }

            $user->update($data);
            if (isset($data['role'])) {
                $this->handleRoles($user, $data['role']);
            }
            return $this->response->success('Utlisateur Modifier !');
        }catch (Exception $exception){
            return $this->response->fail($exception->getMessage());
        }
    }

    public function DeleteUser($ids)
    {
        $ids = explode(',', $ids);
        $deleteAction =  User::destroy($ids);
        if ($deleteAction) {
            return $this->response->success('Utlisateur Supprimer !');
        }
        else{
             User::withTrashed()->find($ids)->each(function ($user, $key) {
                $user->forceDelete();
            });
            return $this->response->warning('Utlisateur a été supprimer définitivement !');
        }
    }

    private function handleRoles($user, $role){
        $roles = $user->getRoleNames();
        if (in_array($role, array($roles)) ) {
            $user->removeRole($role);
        }
        $user->syncRoles($role);
    }
}
