<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($request, &$reason = NULL)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $request['username'])) ? 'email' : 'phone';
        if (User::onlyTrashed()->where($type, $request['username'])->exists()) {
            $reason = 'USER_BLOCKED';
            return NULL;
        } else {
            $user = User::where($type, $request['username'])->first();

            if (!Hash::check($request['password'], $user->password)) {
                $reason = 'INVALID_PASSWORD';
                return NULL;
            } else {
                auth('api')->user()?->tokens()?->delete();

                $user->fcmTokens()->firstOrCreate([
                    'token' => $request['fcm_token'],
                ]);

                return [
                    "token" => $user->createToken("Device")->plainTextToken,
                    "user" => $user,
                ];
            }
        }
    }

    public function forget($username, &$reason)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $username)) ? 'email' : 'phone';
        $user = User::withTrashed()->where($type, $request['username'])->first();

        if ($user->trashed()) {
            $reason = 'USER_BLOCKED';
            return NULL;
        } else {
            $rand = random_int(1111, 9999);
            $rand = 1111;
            //send email or sms

            $user->update([
                'verification_code' => $rand
            ]);
            return $user;
        }
    }

    public function checkCode($request, &$reason)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $request['username'])) ? 'email' : 'phone';
        $user = User::withTrashed()->where($type, $request['username'])->first();

        if ($user->trashed()) {
            $reason = 'USER_BLOCKED';
            return NULL;
        } else {
            if ($user->verification_code != $request['verification_code'] || $request['verification_code'] == 0) {
                $reason = 'CODE_NOT_MATCH';
                return NULL;
            } else {
                $user->update([
                    'verification_code' => 1
                ]);
                return $user;
            }
        }
    }

    public function reset($request, &$reason)
    {
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $request['username'])) ? 'email' : 'phone';
        $user = User::withTrashed()->where($type, $request['username'])->first();

        if ($user->trashed()) {
            $reason = 'USER_BLOCKED';
            return NULL;
        } else {
            if ($user->verification_code == 1) {
                $user->update([
                    'verification_code' => 0,
                    'password' => $request['password'],
                ]);

                $user->fcmTokens()->firstOrCreate([
                    'token' => $request['fcm_token']
                ]);

                $data = [
                    "token" =>  $user->createToken("Device")->plainTextToken,
                    "user"  =>  $user
                ];
                return $data;
            } else {
                $reason = 'ACCOUNT_NOT_READY_TO_RESET';
                return NULL;
            }
        }
    }
}
