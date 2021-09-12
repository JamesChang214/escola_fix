<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\UserCentre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CenterSwitchController extends Controller
{
    public function home()
    {
        $user = backpack_user()->id;

        $userCenters = UserCentre::select('centre_id')->where(['user_id' => $user])->get();
        $centres = [];

        foreach ($userCenters as $userCenter) {
            $centres[] = DB::table('centres')->select('name', 'id')->where('id', $userCenter->centre_id)->first();
        }

        return view('centre_switch.home', [
            'centres' => $centres
        ]);
    }

    public function switch(Request $request)
    {
        $request->session()->put('centre_id', $request->centreId);
    }

    public function switchDefault(Request $request)
    {
        $user = backpack_user()->id;

        $userCenters = UserCentre::where(['user_id' => $user])->get();

        foreach ($userCenters as $userCenter) {
            $userCenter->default = 0;
            $userCenter->save();
        }

        $userDefaultCenter = UserCentre::where(['user_id' => $user, 'centre_id' => $request['centreId']])->first();
        $userDefaultCenter->default =1;
        $userDefaultCenter->save();

        return "You have successfully updated your default centre";
    }
}
