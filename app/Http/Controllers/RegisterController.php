<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    final function registerUser(Request $request){
        $request->validate([
            'user_name'=>'required',
            'user_password'=>'required',
            'user_mobile'=>'required',
            'user_email'=>'required | email | unique:user_accounts'
        ]);

        $UserAccounts = new UserAccounts;
        $UserAccounts->user_name = $request->user_name;

        DB::table('user_accounts')->insert([
            'user_name'=>$request->user_name,
            'user_password'=>Hash::make($request->user_password),
            'user_mobile'=>$request->user_mobile,
            'user_email'=>$request->user_email,
            'userType_id'=>$request->userType_id
        ]);
    }
}
