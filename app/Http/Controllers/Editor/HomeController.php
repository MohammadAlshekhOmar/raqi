<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function cp()
    {
        $usersCount = User::all()->count();
        return view('Editor.SubViews.cp', [
            'usersCount' => $usersCount,
        ]);
    }
}
