<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\User\Helpers\RoleHelper;
use Modules\User\Helpers\UserHelper;
use Modules\User\Http\Requests\Admin\Role\RoleAddRequest;
use Modules\User\Http\Requests\Admin\Role\RoleCreateRequest;
use Modules\User\Http\Requests\Admin\Role\RoleDeleteRequest as RoleRoleDeleteRequest;
use Modules\User\Http\Requests\Admin\Role\RoleEditRequest;
use Modules\User\Http\Requests\Admin\Role\RoleListRequest;
use Modules\User\Http\Requests\Admin\Role\RoleUpdateRequest;
use Modules\User\Http\Requests\Admin\User\UserListDataRequest;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    protected $roleHelper;

    protected $userHelper;

    public function __construct(RoleHelper $roleHelper, UserHelper $userHelper)
    {
        $this->roleHelper = $roleHelper;
        $this->userHelper = $userHelper;
    }

    public function listRoles(RoleListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Roles'],
        ];
        $roles = $this->roleHelper->getAllRole();

        return view('user::roles.listRoles', compact('breadcrumbs', 'roles'));
    }

    public function addRole(RoleAddRequest $request)
    {
        $permissions = $this->roleHelper->getPermissions();
        $responce['html'] = (string) view('user::roles.addRole', compact('permissions'));
        $responce['scripts'][] = (string) mix('js/roles/addRole.js');

        return $responce;
    }

    public function createRole(RoleCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => Str::lower((Str::replace(' ', '_', $request->name))),
                'guard_name' => $request->guard,
                'status' => 'active',
            ];
            $permissions = $request->permissions;
            $role = $this->roleHelper->createRole($data, $permissions);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('user_role_list')->with('success', 'Role added successfully');
    }

    public function editRole(RoleEditRequest $request)
    {
        $role = $this->roleHelper->getRole($request->id);
        $activePermissions = $role->getPermissionNames();
        $permissions = $this->roleHelper->getPermissions($role->guard_name);
        $responce['html'] = (string) view('user::roles.editRole', compact('permissions', 'activePermissions', 'role'));
        $responce['scripts'][] = (string) mix('js/roles/editRole.js');

        return $responce;
    }

    public function viewRole(RoleEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'user_role_list', 'name' => 'Roles', 'permission' => 'role_read'],
            ['name' => 'View Role'],
        ];
        $role = $this->roleHelper->getRole($request->id);

        return view('user::roles.viewRole', compact('role', 'breadcrumbs'));
    }

    public function rolesUsersListData(UserListDataRequest $request)
    {
        $users = $this->userHelper->getAllUsersexcepetSuperAdmin($request->all());
        $dataTableJSON = DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('name', function ($user) {
                $data['url'] = request()->user()->can('user_view') ? route('user_edit', ['id' => $user->id]) : '';
                $data['text'] = $user->name;

                return view('elements.listLink', compact('data'));
            })
            ->addColumn('status', function ($user) {
                return view('elements.listStatus')->with('data', $user);
            })
            ->addColumn('action', function ($user) use ($request) {
                $data['edit_url'] = request()->user()->can('user_update') ? route('user_edit', ['id' => $user->id]) : '';
                $data['delete_url'] = request()->user()->can('user_delete') ? route('user_delete', ['id' => $user->id]) : '';

                return view('elements.listAction', compact('data'));
            })
            ->make();

        return $dataTableJSON;
    }

    public function updateRole(RoleUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
            ];
            $permissions = $request->permissions;
            $role = $this->roleHelper->updateRole($request->id, $data, $permissions);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => false, 'message' => $e->getMessage()];

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    public function deleteRole(RoleRoleDeleteRequest $request)
    {
        $status = false;
        $role = $this->roleHelper->getRole($request->id);

        if ($role->users->count() <= 0) {
            $status = $this->roleHelper->delete($request->id);
        }

        if ($request->expectsJson()) {
            if ($status) {
                return response()->json(['status' => 1, 'message' => 'Role deleted successfully']);
            }

            return response()->json(['status' => 0, 'message' => 'Role deleted failed']);
        } else {
            if ($status) {
                return redirect()->route('role_list')->with('success', 'Role deleted successfully');
            } else {
                return redirect()->route('role_list')->with('error', 'Role deleted failed');
            }
        }
    }

    public function roleOptions(Request $request)
    {
        $gaurd = $request->gaurd ?? 'admin';
        $term = trim($request->q);
        $users = $this->roleHelper->searchRole($term, $gaurd);

        $userOptions = [];

        foreach ($users as $user) {
            $userOptions[] = ['id' => $user->id, 'text' => $user->name_display];
        }

        return response()->json($userOptions);
    }

    public function checkRole(Request $request)
    {
        $selectedRoles = $request->roles ? [$request->roles] : [];
        $maintanaceMangerRole = $this->roleHelper->getRoleIdByRole('fas_maintenance_manager');

        if ($maintanaceMangerRole) {
            if (in_array($maintanaceMangerRole->id, $selectedRoles)) {
                return response()->json(['status' => 1, 'message' => 'Success']);
            } else {
                return response()->json(['status' => 0, 'message' => 'Failed']);
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Failed']);
        }
    }
}
