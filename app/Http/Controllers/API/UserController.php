<?php

namespace App\Http\Controllers\API;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    public function getUser() {
        $authUser = Auth::user();
        $user = User::findOrFail($authUser->id);
        $user->avatar = $this->getS3Url($user->avatar);
        return $this->sendResponse($user, 'User');
    }


    public function uploadAvatar(Request $request) {
        // Validate the image file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            try {
                // Log the start of the process
                \Log::info('Starting avatar upload process');
                
                // Get authenticated user
                $authUser = Auth::user();
                $user = User::findOrFail($authUser->id);
                
                // Get file extension
                $extension = $request->file('image')->getClientOriginalExtension();
                \Log::info('File extension: ' . $extension);
                
                // Create filename and path
                $image_name = time() . '_' . $authUser->id . '.' . $extension;
                \Log::info('Image name: ' . $image_name);
                
                // Check S3 configuration
                \Log::info('S3 Disk Exists: ' . (Storage::disk('s3') ? 'Yes' : 'No'));
                \Log::info('S3 Config: ' . json_encode(config('filesystems.disks.s3')));
                
                // Upload file to S3
                $path = $request->file('image')->storeAs('images', $image_name, 's3');
                \Log::info('Upload path: ' . $path);
                
                // Set file visibility to public
                Storage::disk('s3')->setVisibility($path, "public");
                \Log::info('Visibility set to public');
                
                // Update user record
                $user->avatar = $path;
                $user->save();
                \Log::info('User record updated');
                
                // Generate S3 URL
                $avatarUrl = null;
                if(isset($user->avatar)){
                    try {
                        $avatarUrl = $this->getS3Url($path);
                        \Log::info('Generated URL: ' . $avatarUrl);
                    } catch (\Exception $e) {
                        \Log::error('Error generating S3 URL: ' . $e->getMessage());
                        \Log::error($e->getTraceAsString());
                    }
                }
                
                $success['avatar'] = $avatarUrl;
                return $this->sendResponse($success, 'User profile avatar uploaded successfully!');
                
            } catch (\Exception $e) {
                \Log::error('Avatar upload error: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                return $this->sendError('Error uploading avatar: ' . $e->getMessage(), [], 500);
            }
        }
        
        return $this->sendError('No image file found', [], 400);
    }

    /**
     * Remove avatar image from S3 and clear user record
     *
     * @return \Illuminate\Http\Response
     */
    public function removeAvatar()
    {
        // User is already authenticated via sanctum middleware
        $authUser = Auth::user();
        
        // Get user from authUser
        $user = User::findOrFail($authUser->id);
        
        // Remove file from S3 using the path saved in user record
        if ($user->avatar) {
            Storage::disk('s3')->delete($user->avatar);
        }
        
        // Set avatar field to NULL and save
        $user->avatar = null;
        $user->save();
        
        // Return success response
        $success['avatar'] = null;
        return $this->sendResponse($success, 'User profile avatar removed successfully!');
    }

    /**
     * Send verification email
     *
     * @return \Illuminate\Http\Response
     */
    public function sendVerificationEmail()
    {
        // Implementation for sending verification email
    }

    /**
     * Change user email
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeEmail(Request $request)
    {
        // Implementation for changing email
    }
}