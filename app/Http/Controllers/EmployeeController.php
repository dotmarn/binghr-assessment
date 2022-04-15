<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class EmployeeController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        $roles = Role::all();
        return view('welcome', compact('users', 'roles'));
    }

    public function createOrUpdateUser(Request $request)
    {
        $error = Validator::make(
            $request->all(),
            [
                'firstname' => ['required', 'string'],
                'lastname' => ['required', 'string'],
                'username' => ['required', 'string', $request->action_type == 'add' ? 'unique:users' : 'unique:users,username,'.$request->id],
                'email' => ['required', 'email', $request->action_type == 'add' ? 'unique:users' : 'unique:users,email,'.$request->id],
                'phone' => ['required', 'digits:11', $request->action_type == 'add' ? 'unique:users' : 'unique:users,phone,'.$request->id],
                'password' => [$request->action_type == 'add' ? ['required','confirmed'] : 'nullable', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
                'role' => ['required', 'numeric']
            ]
        );

        if ($error->fails()) {
            return response()->json([
                'message' => 'Please fill all the required field(s)',
                'data' => $error->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $data = [
                'username' => $request->username,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone
            ];

            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->action_type == 'add') {
               $data['employee_id'] = 'EMP-'.mt_rand(1000, 9999);
            }

            $user = User::updateOrCreate([
                'id' => $request->id
            ], $data);

            $user->syncRoles($request->role);

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => ($request->action_type == 'add') ? 'User created successfully' : 'Record updated successfully',
                'data' => null
            ], Response::HTTP_OK);
        }
    }
}
