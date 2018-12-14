<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Image;

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
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('/', $filename, 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        $url = Storage::disk('s3')->url($path);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'photo' => $url,
        ]);

        $thumb = Image::make($file);
        $thumb->fit(200);
        $jpg = (string) $thumb->encode('jpg');

        $thumbName = pathinfo($filename, PATHINFO_FILENAME).'-thumb.jpg';
        Storage::disk('s3')->put($thumbName,$jpg,'public');

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
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('/', $filename, 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        $url = Storage::disk('s3')->url($path);

        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'photo' => $url,
        ]);

        $thumb = Image::make($file);
        $thumb->fit(200);
        $jpg = (string) $thumb->encode('jpg');

        $thumbName = pathinfo($filename, PATHINFO_FILENAME).'-thumb.jpg';
        Storage::disk('s3')->put($thumbName,$jpg,'public');
        return  redirect()->route('admin.users.show', $user)->with('success','User ' .$user->name . ' updated successfully!');

    }

    public function destroy($id)
    {
        $user = User::find($id);
        Storage::disk('s3')->delete($user->photo);
        User::destroy($id);
        $users = User::paginate(self::USERS_FOR_PAGINATION);
        return redirect()->route('admin.users.index', $users)->with('warning', 'User ' .$user->name . ' destroyed!');

    }
}
