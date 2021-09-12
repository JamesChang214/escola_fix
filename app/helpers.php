<?php

use App\Models\UserCentre;
use Illuminate\Support\Facades\DB;

if (!function_exists('getDefaultCentreByAuthId')) {
    function getDefaultCentreByAuthId()
    {
        $user = backpack_user()->id;

        return UserCentre::select('centre_id')->where(['user_id' => $user, 'default' => 1])->first();
    }
}

if (!function_exists('getCentreByAuthId')) {
    function getCentreByAuthId()
    {
        $user = backpack_user()->id;

        $userCenters = UserCentre::select('centre_id')->where(['user_id' => $user])->get();
        $centres = [];

        foreach ($userCenters as $userCenter) {
            $centres[] = DB::table('centres')->select('name', 'id')->where('id', $userCenter->centre_id)->first();
        }

        return $centres;
    }
}
