<?php

namespace Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\User\Helpers\UserHelper;
use Modules\User\Http\Requests\Api\User\UserDeleteRequest;
use Modules\User\Http\Requests\Api\User\UserGetRequest;
use Modules\User\Http\Requests\Api\User\UserListDataRequest;
use Modules\User\Http\Requests\Api\User\UserPasswordUpdateRequest;
use Modules\User\Http\Requests\Api\User\UserSaveRequest;
use Modules\User\Http\Requests\Api\User\UserUpdateRequest;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    protected $userHelper;

    public function __construct(UserHelper $userHelper)
    {
        $this->userHelper = $userHelper;
    }

    public function userInfo()
    {
        $user = $this->userHelper->getUserInfo(auth()->user()->id);
        $response = ['status' => true, 'data' => ['user' => $user], 'message' => 'Success'];

        return response()->json($response, 200);
    }

    public function table(UserListDataRequest $request)
    {
        request()->merge(['length' => $request->has('limit') && $request->limit ? $request->limit : 50]);
        request()->merge(['page' => $request->has('page') && $request->page ? $request->page : 1]);
        request()->merge(['start' => (request()->page - 1) * request()->length]);
        request()->merge(['draw' => request()->page - 1]);
        request()->merge(['search' => ['value' => $request->has('search_text') && $request->search_text ? $request->search_text : '']]);
        request()->merge(['columns' => [['name' => 'name', 'orderable' => true], ['name' => 'email', 'orderable' => true]]]);
        request()->merge(['order' => [['column' => 0, 'dir' => 'asc']]]);

        $users = $this->userHelper->getAllUsersexcepetSuperAdmin($request->all());

        $dataTableJSON = DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function ($user) {
                return $user->role_names;
            })
            ->make();

        return response()->json(['status' => true, 'data' => $dataTableJSON, 'message' => 'Success'], 200);
    }

    public function save(UserSaveRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userHelper->save($request->all());
            DB::commit();

            return response()->json(['status' => true, 'data' => compact('user'), 'message' => 'User successfully added'], 200);
        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => false, 'message' => $e->getMessage()];

            return response()->json($response, 200);
        }
    }

    public function get(UserGetRequest $request)
    {
        $user = $this->userHelper->getUser($request->id);
        $user->append(['user_permissions', 'user_roles']);

        return response()->json(['status' => true, 'data' => compact('user'), 'message' => 'Success'], 200);
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userHelper->update($request->all());
            DB::commit();

            return response()->json(['status' => true, 'data' => compact('user'), 'message' => 'User successfully updated'], 200);
        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => false, 'message' => $e->getMessage()];

            return response()->json($response, 200);
        }
    }

    public function delete(UserDeleteRequest $request)
    {
        if ($this->userHelper->delete($request->id)) {
            return response()->json(['status' => true, 'message' => 'Success'], 200);
        }

        return response()->json(['status' => false, 'message' => 'Success'], 200);
    }

    public function userOptions(Request $request)
    {
        $term = trim($request->search);
        $role = $request->role;
        $users = $this->userHelper->searchUserWithRoles($request->all());

        $userOptions = [];

        foreach ($users as $user) {
            $userOptions[] = ['id' => $user->id, 'text' => $user->name];
        }

        return response()->json($userOptions);
    }

    public function changePassword(UserPasswordUpdateRequest $request)
    {
        $user = $this->userHelper->getUser($request->id);

        if ($user->email != 'web@ipixsolutions.com') {
            $status = $this->userHelper->updateUserPassword($request->id, $request->password);

            if (!empty($status)) {
                $response = ['status' => true, 'message' => 'User password updated successfully'];

                return response()->json($response, 200);
            } else {
                $response = ['status' => false, 'message' => 'User password updated faild'];

                return response()->json($response, 200);
            }
        } else {
            $response = ['status' => false, 'message' => 'Super admin password update is not allowed'];

            return response()->json($response, 200);
        }
    }
}
