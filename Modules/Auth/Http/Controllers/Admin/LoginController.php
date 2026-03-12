<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\Admin\Auth\LoginRequest;
use Modules\Auth\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('destroy');
    }

    public function showLoginForm()
    {
        return view('auth::admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::ADMIN);
    }

    public function checkEmail(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['valid' => false]);
        }

        return response()->json(['valid' => true]);
    }

    public function checkPassword(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['valid' => false]);
        }
        $hash = Hash::check($request->password, $user->password);

        return response()->json(['valid' => $hash]);
    }

    public function destroy(Request $request)
    {
        auth()->guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::ADMIN);
    }
}
