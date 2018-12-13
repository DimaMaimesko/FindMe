<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UsersController extends Controller
{
    const USERS_FOR_PAGINATION = 10;

    public function index()
    {
        $users = User::paginate(self::USERS_FOR_PAGINATION);
        return view('admin.users.index',[
            'users' => $users,
        ]);
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->all());
        return redirect()->route('admin.users.show', $user)->with('success','New User created successfully!');

    }


    public function show($user)
    {
        $user = User::find($user);
        return view('admin.users.show', compact('user'));
    }


    public function edit($user)
    {
        $user = User::find($user);
        return view('admin.users.edit',[
            'user' => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return  redirect()->route('admin.users.show', $user)->with('success','User ' .$user->name . ' updated successfully!');

    }

    public function destroy($id)
    {
        $user = User::find($id);
        User::destroy($id);

        $users = User::paginate(self::USERS_FOR_PAGINATION);
        return redirect()->route('admin.users.index', $users)->with('warning', 'User ' .$user->name . ' destroyed!');

    }
}
