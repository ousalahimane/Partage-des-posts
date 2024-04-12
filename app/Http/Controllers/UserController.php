<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser $request, User $user)
    {
        // Upload Picture for current Post
        if($request->hasFile('avatar')) {

            $path = $request->file('avatar')->store('users');

                if($user->image) {
                  Storage::delete($user->image->path);
                  $user->image->path = $path;
                  $user->image->save();
                }
                else {
                    $user->image()->save(Image::make(['path' => $path]));
                }

      }

      $user->locale = $request->locale;
      $user->save();

       return redirect()->back()->withStatus('User Updated !');
    }

    /**
     * Remove the specif;ied resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
