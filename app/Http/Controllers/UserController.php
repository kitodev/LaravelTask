<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->map(function ($user) {
            return UserDTO::fromModel($user);
        });
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(UserDTO::fromModel($user));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json(UserDTO::fromModel($user), 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(UserDTO::fromModel($user), 200);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(null, 204);
    }
}
