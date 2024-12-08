<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = new Profile([
                'user_id' => $user->user_id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'skills' => []
            ]);
            $user->profile()->save($profile);
        }

        return view('entrepreneur.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'bio' => 'required|string',
            'skills' => 'required|string',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $profile = $user->profile ?? new Profile(['user_id' => $user->user_id]);

            // Update profile info
            $profile->name = $validated['name'];
            $profile->location = $validated['location'];
            $profile->bio = $validated['bio'];
            $profile->skills = array_map('trim', explode(',', $validated['skills']));

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                // Delete old picture if exists
                if ($profile->profile_pic) {
                    Storage::delete('public/profile_pictures/' . $profile->profile_pic);
                }

                // Store new picture
                $imageName = time() . '_' . uniqid() . '.' . $request->profile_pic->extension();

                // Ensure directory exists
                Storage::makeDirectory('public/profile_pictures');

                // Store the file
                $request->profile_pic->storeAs('public/profile_pictures', $imageName);
                $profile->profile_pic = $imageName;
            }

            $user->profile()->save($profile);
            DB::commit();

            return redirect()->route('entrepreneur.profile')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
