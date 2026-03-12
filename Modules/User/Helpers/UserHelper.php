<?php

namespace Modules\User\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Builder;

class UserHelper
{
    public function getAllUsersexcepetSuperAdmin($data)
    {
        return User::with(['roles'])->where('email', '!=', 'web@ipixsolutions.com')
            ->when((isset($data['status']) && $data['status']), function ($query) use ($data) {
                $query->where('status', '=', $data['status']);
            })
            ->when((isset($data['role_id']) && $data['role_id']), function ($query) use ($data) {
                $query->whereHas('roles', function ($query) use ($data) {
                    return $query->where('role_id', $data['role_id']);
                });
            })
            ->select(app(User::class)->getTable() . '.*');
    }

    public function save($requestData)
    {

        $data = Arr::only($requestData, ['name', 'email', 'status']);

        if (!empty($requestData['password'])) {
            $data['password'] = Hash::make($requestData['password']);
        }

        if (isset($requestData['profile_picture']) && $requestData['profile_picture']->isValid()) {
            $data['profile_picture'] = Storage::disk('elegant')->putFile('users', $requestData['profile_picture']);
        }
        $user = new User;

        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $user->$key = $value;
            }
        }

        if ($user->save()) {
            if (!empty($requestData['role_id'])) {
                $roles = Role::whereIn('id', $requestData['role_id'])->get();
                $user->assignRole($roles);
            }
        }

        return $user;
    }

    public function getUserInfo($userId)
    {
        $user = User::find($userId);
        $user->append('user_permissions');

        return $user;
    }

    public function getUser($userId)
    {
        return User::find($userId);
    }

    public function update($requestData)
    {
        $data = Arr::only($requestData, ['name', 'email', 'status']);

        if (!empty($requestData['password'])) {
            $data['password'] = Hash::make($requestData['password']);
        }

        if (isset($requestData['profile_picture']) && $requestData['profile_picture']->isValid()) {
            $data['profile_picture'] = Storage::disk('elegant')->putFile('users', $requestData['profile_picture']);
        } elseif (isset($requestData['profile_picture_remove']) && $requestData['profile_picture_remove']) {
            $data['profile_picture'] = '';
        }
        $user = User::find($requestData['id']);

        foreach ($data as $key => $value) {
            $user->$key = $value;
        }

        if ($user->update($data)) {
            if (!empty($requestData['role_id'])) {
                $roles = Role::whereIn('id', $requestData['role_id'])->get();
                $user->syncRoles($roles);
            }
        }

        return $user;
    }

    public function delete($userId)
    {
        return User::find($userId)->delete();
    }

    public function userOptionsWithRoles($keyword, $roleName)
    {

        $users = User::with('roles')->where('status', 'active')->where('name', 'like', "%{$keyword}%")
            ->where('email', '!=', 'web@ipixsolutions.com');

        if (isset($roleName) && $roleName != null) {
            $role = Role::where('name', $roleName)->pluck('id')->toArray();
            $users = $users->whereHas('roles', function ($query) use ($role) {
                return $query->whereIn('role_id', $role);
            });
        }

        return $users->orderBy('name', 'asc')->paginate(30, ['*'], 'page', request()->get('page'));
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function createToken($user, $deviceIdentity)
    {
        return $user->createToken($deviceIdentity)->plainTextToken;
    }

    public function revokeToken($user)
    {
        return $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    }



    public function getAllUsers()
    {
        return User::All();
    }
}
