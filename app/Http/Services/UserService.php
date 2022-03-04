<?php


namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserService
{
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
        $user = User::create($newData);
        if ($data['role']) {
            $user->assignRole($data['role']);
        }
        return ['msg' => 'Utlisateur Ajouter !'];
    }

    public function UpdateUser($data, $user)
    {
        if (isset($data['password'])) {
            $newData = data_set($data, 'password', \Hash::make($data['password']));
            $user->update($newData);
        }
        $user->update($data);
        if ($data['role']) {
            $user->syncRoles($data['role']);
        }
        return ['msg' => 'Utlisateur Modifier !'];
    }

    public function DeleteUser($ids)
    {
        $ids = explode(",", $ids);
        User::destroy($ids);
        return ['msg' => 'Utlisateur Supprimer !'];
    }
}
