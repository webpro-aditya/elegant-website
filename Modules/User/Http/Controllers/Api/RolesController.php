<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Helpers\RoleHelper;
use Modules\User\Http\Requests\Api\Role\RoleDeleteRequest;
use Modules\User\Http\Requests\Api\Role\RoleGetRequest;
use Modules\User\Http\Requests\Api\Role\RoleListDataRequest;
use Modules\User\Http\Requests\Api\Role\RoleSaveRequest;
use Modules\User\Http\Requests\Api\Role\RoleUpdateRequest;

class RolesController extends Controller
{
    protected $roleHelper;

    public function __construct(RoleHelper $roleHelper)
    {
        $this->roleHelper = $roleHelper;
    }

    public function list(RoleListDataRequest $request)
    {
        $roles = $this->roleHelper->getAllRoles($request->all());

        return response()->json(['status' => true, 'data' => compact('roles'), 'message' => 'Success'], 200);
    }

    public function save(RoleSaveRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => Str::lower((Str::replace(' ', '_', $request->name))),
                'status' => $request->status,
            ];
            $permissions = $request->permissions;
            $role = $this->roleHelper->createRole($data, $permissions);

            DB::commit();

            return response()->json(['status' => true, 'data' => compact('role'), 'message' => 'Role successfully added'], 200);
        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => false, 'message' => $e->getMessage()];

            return response()->json($response, 200);
        }
    }

    public function get(RoleGetRequest $request)
    {
        $role = $this->roleHelper->getRole($request->id);

        if ($role) {
            $role->getAllPermissions();
        }

        return response()->json(['status' => true, 'data' => compact('role'), 'message' => 'Success'], 200);
    }

    public function update(RoleUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
                'status' => $request->status,
            ];
            $permissions = $request->permissions;
            $role = $this->roleHelper->updateRole($request->id, $data, $permissions);

            DB::commit();

            return response()->json(['status' => true, 'data' => compact('role'), 'message' => 'Role successfully updated'], 200);
        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => false, 'message' => $e->getMessage()];

            return response()->json($response, 200);
        }
    }

    public function delete(RoleDeleteRequest $request)
    {
        if ($this->roleHelper->delete($request->id)) {
            return response()->json(['status' => true, 'message' => 'Success'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Success'], 200);
    }

    public function roleOptions(Request $request)
    {
        $term = trim($request->q);
        $users = $this->roleHelper->searchRole($term);

        $userOptions = [];

        foreach ($users as $user) {
            $userOptions[] = ['id' => $user->id, 'text' => $user->name];
        }

        return response()->json($userOptions);
    }

    public function permissions(Request $request)
    {
        $permissions = $this->roleHelper->getPermissions();

        return response()->json(['status' => true, 'data' => compact('permissions'), 'message' => 'Success'], 200);
    }
}
