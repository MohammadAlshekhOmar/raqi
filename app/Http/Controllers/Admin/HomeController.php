<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function cp()
    {
        $usersCount = User::all()->count();
        return view('Admin.SubViews.cp', [
            'usersCount' => $usersCount,
        ]);
    }
}
