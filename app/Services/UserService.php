<?php

namespace App\Services;

use App\Models\User;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function all()
    {
        return User::withTrashed()->get();
    }

    public function find($id)
    {
        return User::withTrashed()->find($id);
    }

    public function add($request)
    {
        DB::beginTransaction();
        $user = User::create($request);
        $user->addMedia($request['image'])->toMediaCollection('User');

        if (isset($request['fcm_token'])) {
            $messaging = Firebase::messaging();
            $messaging->subscribeToTopic('all', $request['fcm_token']);
            $messaging->subscribeToTopic('users', $request['fcm_token']);

            $user->fcmTokens()->attach([
                'token' => $request['fcm_token'],
            ]);
        }
		$user = User::find($user->id);
        DB::commit();
        return $user;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $user = User::withTrashed()->find($request['id']);
        if (isset($request['image'])) {
            $user->clearMediaCollection('User');
            $user->addMedia($request['image'])->toMediaCollection('User');
        }

        $user->update($request);
        DB::commit();
        return $user;
    }

    public function changeLanguage($language_id, $user_id)
    {
        $user = User::find($user_id);
        $user->update([
            'language_id' => $language_id,
        ]);
        return $user;
    }

    public function changePassword($request, $user_id)
    {
        $user = User::find($user_id);

        if (!Hash::check($request['current_password'], $user->password)) {
            return NULL;
        }

        $user->update([
            'password' => $request['password'],
        ]);
        return $user;
    }

    public function delete($user_id)
    {
        $user = User::withTrashed()->find($user_id);
        $user->tokens()->delete();
        $user->fcmTokens()->delete();
        $user->delete();
        return $user;
    }
}
