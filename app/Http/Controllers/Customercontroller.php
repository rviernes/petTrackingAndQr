<?php

namespace App\Http\Controllers;

use App\Models\Pets;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Customercontroller extends Controller
{

    public function widgetPets(){
        $loggedUserInfo = DB::table('users')
        ->join('customers','customers.id','=', 'users.id')
        ->select('*')
        ->where('users.id','=', auth()->user()->id)->first();

        $customerid = Customers::where('id', auth()->user()->id)->first();
        $petinfo = Pets::where('customer_id', $customerid)->get();
        
        return view('dashboard.user.home',compact('loggedUserInfo','petinfo'));
    }

    final function userProfile(){
        $data = ['loggedUserInfo'=>DB::table('users')
        ->join('customers','customers.id','=', 'users.id')
        ->select('*')
        ->where('users.id','=', session('LoggedUser'))->first()];
        return view('dashboard.user.custProfile', $data);

        // return dd($data);
    }
}

    function getPetID($id_pet){

        $getID=DB::table('pets')->where('pet_id','=',$id_pet)->first();
    
    

        return view('/customer/custhome',compact('getID'));
    }

    function saveType(Request $request,$id_pet){

        DB::table('pets')
        ->where('pet_id',$id_pet)
        ->update([
            'pet_name'=>$request->pet_name
        ]);
        return redirect('/customer/custhome')->with('Success','Successfully Updated!');
}



