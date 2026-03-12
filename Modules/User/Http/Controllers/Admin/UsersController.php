<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\User\Helpers\RoleHelper;
use Modules\User\Helpers\UserHelper;
use Modules\User\Http\Requests\Admin\User\UserAddRequest;
use Modules\User\Http\Requests\Admin\User\UserCreateRequest;
use Modules\User\Http\Requests\Admin\User\UserDeleteRequest;
use Modules\User\Http\Requests\Admin\User\UserEditRequest;
use Modules\User\Http\Requests\Admin\User\UserListDataRequest;
use Modules\User\Http\Requests\Admin\User\UserListRequest;
use Modules\User\Http\Requests\Admin\User\UserPasswordEditRequest;
use Modules\User\Http\Requests\Admin\User\UserPasswordUpdateRequest;
use Modules\User\Http\Requests\Admin\User\UserUpdateRequest;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    protected $userHelper;

    protected $roleHelper;

    public function __construct(UserHelper $userHelper, RoleHelper $roleHelper)
    {
        $this->userHelper = $userHelper;
        $this->roleHelper = $roleHelper;
    }

    public function listUsers(UserListRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Users'],
        ];

        return view('user::users.listUsers', compact('breadcrumbs'));
    }

    public function userListData(UserListDataRequest $request)
    {
        $users = $this->userHelper->getAllUsersexcepetSuperAdmin($request->all());
        $dataTableJSON = DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function ($user) {
                return $user->roles->first() ? ucwords(str_replace('_', ' ', $user->roles->first()->name)) : '';
            })
            ->editColumn('name', function ($user) {
                $data['image'] = $user->profile_picture && Storage::disk('elegant')->exists($user->profile_picture) ? Storage::disk('elegant')->url($user->profile_picture) : asset('images/avatars/blank.png');
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

    public function addUser(UserAddRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'user_list', 'name' => 'Users', 'permission' => 'user_read'],
            ['name' => 'Add User'],
        ];

        $roles = $this->roleHelper->getAllRole();

        return view('user::users.addUser', compact('roles', 'breadcrumbs'));
    }

    public function createUser(UserCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userHelper->save($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
        DB::commit();

        return redirect()
            ->route('user_list')
            ->with('success', 'User added successfully');
    }

    public function editUser(UserEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['link' => 'user_list', 'name' => 'Users', 'permission' => 'user_read'],
            ['name' => 'User Details'],
        ];
        $user = $this->userHelper->getUser($request->id);
        $roles = $this->roleHelper->getAllRole();

        return view('user::users.editUser', compact('user', 'roles', 'breadcrumbs'));
    }

    public function updateUser(UserUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            if (!empty($request->password)) {
                if (auth()->user()->id == $request->id) {
                    $validator = Validator::make($request->all(), [
                        'current_password' => [
                            'required', function ($attribute, $value, $fail) {
                                if (!Hash::check($value, auth()->user()->password)) {
                                    $fail('Old Password didn\'t match');
                                }
                            },
                        ],
                    ]);

                    if ($validator->fails()) {
                        return redirect()->back()->with('error', 'Current Password Is Not Matching');
                    }
                }
            }

            $user = $this->userHelper->update($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('user_list')->with('success', 'User updated successfully');
    }

    public function changeUserPassword(UserPasswordEditRequest $request)
    {
        $breadcrumbs = [
            ['link' => 'dashboard_home', 'name' => 'Dashboard'],
            ['name' => 'Change Password'],
        ];

        return view('user::users.changeUserPassword', compact('breadcrumbs'));
    }

    public function updateUserPassword(UserPasswordUpdateRequest $request)
    {
        $validator = Validator::make($request->all(), [], []);

        if ($request->has('current')) {
            if (!Hash::check($request->current, auth()->user()->password)) {
                $validator->getMessageBag()->add('current', 'The current password is incorrect.');

                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->current == $request->password) {
                $validator->getMessageBag()->add('password', 'New password must be different from current.');

                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $data['password'] = Hash::make($request->password);
        $user = $this->userHelper->update($request->id, $data);

        if ($request->has('current')) {
            return redirect()->route('admin_dashboard_home')->with('success', 'User password updated successfully');
        }

        return redirect()
            ->route('user_list')
            ->with('success', 'User password updated successfully');
    }

    public function deleteUser(UserDeleteRequest $request)
    {
        if ($this->userHelper->delete($request->id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 1, 'message' => 'User deleted successfully']);
            } else {
                return redirect()->route('user_list')->with('success', 'User deleted successfully');
            }
        }

        if ($request->ajax()) {
            return response()->json(['status' => 0, 'message' => 'Failed to delete']);
        } else {
            return redirect()->route('user_list')->with('success', 'Failed to delete');
        }
    }

    public function userOptions(Request $request)
    {
        $term = trim($request->search);
        $role = $request->role;
        $users = $this->userHelper->userOptionsWithRoles($term, $role);

        $userOptions = [];

        foreach ($users as $user) {
            $userOptions[] = ['id' => $user->id, 'text' => $user->name];
        }

        return response()->json($userOptions);
    }
}
