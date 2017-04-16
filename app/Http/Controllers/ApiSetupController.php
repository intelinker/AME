<?php

namespace App\Http\Controllers;

use App\Country;
use App\UserPosition;
use App\UserTitle;
use Illuminate\Http\Request;
use App\User;

class ApiSetupController extends Controller
{
    public function maininfo(Request $request) {
        $user = User::findOrFail($request['userid']);
        $user->profile->airport = $request['airport'];
        $user->profile->title = $request['title'];
        $user->profile->position = $request['position'];
        $user->profile->save();
        return ['result'=>'success'];
    }

    public function loadTitles(Request $request) {
//        dd($request['isperson']);
        return UserTitle::Where('is_person', $request['isperson'])->get();
    }

    public function loadPositions(Request $request) {
//        dd($request['isperson']);
        return UserPosition::Where('is_person', $request['isperson'])->get();
    }

    public function loadCountries(Request $request) {
//        dd($request['isperson']);
        return Country::all();
    }

}
