<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserCentre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(Request $request)
    {
        $user = backpack_user()->id;
        $userDefaultCenter = UserCentre::where(['user_id' => $user, 'default' => 1])->first();

        $request->session()->put('centre_id', $userDefaultCenter->centre_id);

        return view('vendor.backpack.base.dashboard');
    }
}
