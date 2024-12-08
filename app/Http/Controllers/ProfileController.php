<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        // Create profile if it doesn't exist
        $profile = $user->profile ?? Profile::create(['user_id' => $user->user_id]);

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
                'profile_pic' => 'nullable|image|max:5120', // 5MB max
                'profile_pic_url' => 'nullable|url'
            ]);

            $profile = Profile::where('user_id', auth()->id())->first();
            if (!$profile) {
                $profile = new Profile(['user_id' => auth()->id()]);
            }

            $profile->name = $request->name;
            $profile->location = $request->location;
            $profile->bio = $request->bio;
            $profile->skills = array_map('trim', explode(',', $request->skills));

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                // Delete old image if exists
                if ($profile->profile_pic) {
                    Storage::disk('public')->delete('profile_pictures/' . $profile->profile_pic);
                }

                $fileName = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
                $request->file('profile_pic')->storeAs('profile_pictures', $fileName, 'public');
                $profile->profile_pic = $fileName;
                $profile->profile_pic_url = null;
            } 
            // Handle profile picture URL
            elseif ($request->profile_pic_url) {
                $profile->profile_pic_url = $request->profile_pic_url;
                $profile->profile_pic = null;
            }

            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getExtensionFromUrl($url)
    {
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        return $extension ?: 'jpg'; // Default to jpg if no extension found
    }
}
