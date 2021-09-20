<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function countData(){
    
        $countPet = DB::table('pets')->count();
        
        return view('pet.count', compact('countPet'));
    }

    function userName(){
        $getUser = DB::select('select * from user_accounts where user_id = :user_id',['user_id' => 5]);
        return view('customer/custProfile',compact('getUser'));
    }
}
