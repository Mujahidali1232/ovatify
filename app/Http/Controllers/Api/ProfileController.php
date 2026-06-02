<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileImageRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Upload / Update profile picture
     */
    public function updateProfileImage(UpdateProfileImageRequest $request)
    {
        $user = $request->user();

        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image
        $path = $request->file('profile_image')->store('profiles', 'public');

        // Update user record
        $user->profile_image = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile image updated successfully.',
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Get profile picture details / user profile
     */
    public function getProfile(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($request->user())
        ]);
    }
}
