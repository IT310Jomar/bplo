<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    } //public function login(Request $request)

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // return response()->json(auth()->user());

        $user = Auth::user();
        $data = User::where('id', $user->id)->get();

        $dataUser = [
            'id'        => auth()->user()->id,
            'email'     => auth()->user()->email,
            'name' => auth()->user()->username,
            'user'    => $user,
            'data'      => $data
        ];
        return response()->json(['success' => true, 'dataUser' => $dataUser], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        // id || Role Name
        //=========================
        // 1  || SuperAdmin
        // 2  || Regulatory Officer

        if (Auth::user()->department_id == 1) {
            $ability = [
                ['action' => 'manage', 'subject' => 'Admin'],
                ['action' => 'manage', 'subject' => 'SystemAndAdmin'],
            ];
        }
        if (Auth::user()->department_id == 2) {
            $ability = [
                ['action' => 'manage', 'subject' => 'Buco'],
                ['action' => 'manage', 'subject' => 'SystemAndBuco'],
            ];
        }
        if (Auth::user()->department_id == 3) {
            $ability = [
                ['action' => 'manage', 'subject' => 'CleanRo'],
                ['action' => 'manage', 'subject' => 'SystemAndCleanRo'],
            ];
        }
        if (Auth::user()->department_id == 4) {
            $ability = [
                ['action' => 'manage', 'subject' => 'Health'],
                ['action' => 'manage', 'subject' => 'SystemAndHealth'], 
            ];
        }
        if (Auth::user()->department_id == 5) {
            $ability = [
                ['action' => 'manage', 'subject' => 'BFP'],
                ['action' => 'manage', 'subject' => 'SystemAndBFP'],
            ];
        }

        $user = Auth::user();
        $department = Departments::find($user->department_id);

        $dataUser = [
            'id'        => auth()->user()->id,
            'email'     => auth()->user()->email,
            'name' => auth()->user()->username,
            'user'    => $user,
            'department'      => $department->name,
            'ability'   => $ability
        ];

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user'          => $dataUser,
        ]);
    }
    
    public function guard()
    {
        return Auth::guard();
    } // public function guard()


}
