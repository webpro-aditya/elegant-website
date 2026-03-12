<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\User\Helpers\UserHelper;

class UserController extends Controller
{
    public function verifyLogin(UserHelper $userHelper, Request $request)
    {
        $user = $userHelper->getUserByEmail($request->email);

        if (($user != null) && (Hash::check($request->password, $user->password))) {
            $token = $userHelper->createToken($user, $request->deviceIdentity);
            $user->append(['user_permissions', 'user_roles']);
            $response = ['status' => true, 'data' => ['access_token' => $token, 'user' => $user], 'message' => 'User verified successfully'];

            return response()->json($response, 200);
        } else {
            $response = ['status' => false, 'message' => 'Login Failed. Please check your credentials and try again.'];

            return response()->json($response, 200);
        }
    }

    public function refreshToken(UserHelper $userHelper, Request $request)
    {
        $user = auth()->user();

        $token = $userHelper->createToken($user, $request->deviceIdentity);
        $user->append(['user_permissions', 'user_roles']);
        $response = ['status' => true, 'data' => ['access_token' => $token, 'user' => $user], 'message' => 'User verified successfully'];

        return response()->json($response, 200);
    }

    public function logout(UserHelper $userHelper)
    {
        $user = auth()->user();
        $status = $userHelper->revokeToken($user);

        if (!empty($status)) {
            $response = ['status' => true, 'message' => 'Logout successfully'];

            return response()->json($response, 200);
        } else {
            $response = ['status' => false, 'message' => 'Logout faild'];

            return response()->json($response, 200);
        }
    }
}
