<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Editor\AuthRequest;
use Exception;
use App\Helpers\MyHelper;

class LoginController extends Controller
{
    public function logout()
    {
        auth('editor')->logout();
        return redirect('editor/login');
    }

    public function authenticate(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        try {
            if (auth('editor')->attempt($credentials)) {
                if (!auth('editor')->user()->roles()->first()) {
                    return MyHelper::responseJSON('المحرر ليس لديه دور', 400);
                }
                return MyHelper::responseJSON('تم تسجيل الدخول بنجاح', 200);
            } else {
                return MyHelper::responseJSON('فشلت عملية تسجيل الدخول, حقل اسم المستخدم او كلمة المرور غير صحيحة', 400);
            }
        } catch (Exception $e) {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
