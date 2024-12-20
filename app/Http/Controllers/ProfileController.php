<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = Profile::firstOrCreate(['user_id' => $user->user_id]);
        return view('entrepreneur.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'bio' => 'required|string',
                'skills' => 'required|string',
                'profile_pic' => 'nullable|image|max:5120',
                'profile_pic_url' => 'nullable|url'
            ]);

            $user = Auth::user();
            $profile = Profile::firstOrCreate(['user_id' => $user->user_id]);

            // Handle profile picture
            if ($request->hasFile('profile_pic')) {
                if ($profile->profile_pic) {
                    Storage::disk('public')->delete('profile_pictures/' . $profile->profile_pic);
                }
                $fileName = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
                $request->file('profile_pic')->storeAs('profile_pictures', $fileName, 'public');
                $profile->profile_pic = $fileName;
                $profile->profile_pic_url = null;
            } elseif ($request->profile_pic_url) {
                $profile->profile_pic_url = $request->profile_pic_url;
                $profile->profile_pic = null;
            }

            // Update other fields
            $profile->name = $request->name;
            $profile->location = $request->location;
            $profile->bio = $request->bio;
            $profile->skills = array_map('trim', explode(',', $request->skills));

            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'profile' => $profile
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }
}
