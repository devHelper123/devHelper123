<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
trait SavesUserData
{
    public function saveUser(array $data, User $user = null): User
    {
        $user = $user ?? new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        if (!empty($data['image'])) {
            $image = $data['image'];
            $image_name = Str::slug($data['name']) . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profile-images'), $image_name);
            $file_link = 'images/profile-images/' . $image_name;
            if ($user->profileImage) {
                $old_file_path = public_path($user->profileImage->filename);
                if (is_file($old_file_path) && file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
                $user->profileImage->delete();
            }
            $user->profileImage()->create([
                'path' => $file_link,
            ]);
        }
        if (!empty($data['img_updated']) && $data['img_updated'] == '1' && empty($data['image'])) {
            if ($user->profileImage) {
                $file_path = public_path($user->profileImage->filename);
                if (is_file($file_path) && file_exists($file_path)) {
                    unlink($file_path);
                }
                $user->profileImage->delete();
            }
        }
        $user->user_type = $data['user_type'] ?? 'client';
        $user->save();
        return $user;
    }
}
