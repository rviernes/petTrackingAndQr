<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    final function registerUser(Request $request){
        $request->validate([
            'name'=>'required',
            'password'=>'required',
            'user_mobile'=>'required',
            'email'=>'required | email | unique:users'
        ]);

        $UserAccounts = new UserAccounts;
        $UserAccounts->user_name = $request->user_name;

        DB::table('user_accounts')->insert([
            'name'=>$request->user_name,
            'password'=>Hash::make($request->user_password),
            'user_mobile'=>$request->user_mobile,
            'email'=>$request->user_email,
            'userType_id'=>$request->userType_id
        ]);
    }
}
