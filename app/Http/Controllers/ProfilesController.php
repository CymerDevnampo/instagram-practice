<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(), //pwede ta butang og pila ka seconds para sa cache
            function () use ($user) {
                return $user->posts->count();
            }
        );

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(), //pwede ta butang og pila ka seconds para sa cache
            function () use ($user) {
                return $user->profile->followers->count();
            }
        );

        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(), //pwede ta butang og pila ka seconds para sa cache
            function () use ($user) {
                return $user->following->count();
            }
        );

        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {

        $this->authorize('update', $user->profile);

        $data = request()->validate([
            // 'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        // $user = User::find($user->id);

        // if ($user) {

        //     $user->name = $data['name'];
        //     $user->save();
        // }

        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

        auth()->user()->profile->update(
            array_merge(
                $data,
                $imageArray ?? []
            )
        );

        return redirect("/profile/{$user->id}");
    }

}
