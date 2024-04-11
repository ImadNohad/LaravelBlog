<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '<>', auth()->user()->id)->paginate(15);
        $user_count = User::all()->count();
        return view("admin.users.index", ['users' => $users, 'user_count' => $user_count]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'email' => 'required:email',
            'bio' => 'required',
            'password' => 'required|confirmed',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
        ]);

        $user = new User();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $request->image->store('public/images');
            $user->imageURL = $file->hashName();
        }

        $user->type = $validated["type"];
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->bio = $validated["bio"];
        $user->password = Hash::make($validated["password"]);

        $user->save();

        return redirect()->route("users.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("admin.users.edit", ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'email' => 'required:email',
            'bio' => 'required',
            'password' => 'confirmed',
            'image' => 'mimes:jpeg,jpg,png,gif',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $request->image->store('public/images');
            $user->imageURL = $file->hashName();
        }

        $user->type = $validated["type"];
        $user->name = $validated["name"];
        $user->email = $validated["email"];
        $user->bio = $validated["bio"];

        if (!empty($validated["password"]))
            $user->password = Hash::make($validated["password"]);

        $user->update();

        return redirect()->route("users.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
