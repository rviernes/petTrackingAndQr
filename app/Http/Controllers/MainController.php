<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customers;
use App\Models\Clinic;
use App\Models\PetBreeds;
use App\Models\Pets;
use App\Models\PetTypes;
use App\Models\userTypes;
use App\Models\Veterinary;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User_accounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Hash;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Types\StringType;
use UxWeb\SweetAlert\SweetAlert;

class MainController extends Controller
{
    //CREATE USER FOR CUSTOMER
    function create(Request $request){

        $username = $request->user_name;
        $password = $request->user_password;
        $email = $request->user_email;

        $fname = $request->customer_fname;
        $lname = $request->customer_lname;
        $mname = $request->customer_mname;

        $checkCust = DB::table('customers')
        ->where('customer_fname', '=', $fname)
        ->where('customer_lname', '=', $lname)
        ->where('customer_mname', '=', $mname)->first();

        if ($checkCust) {
            alert()->warning('The customer already exist', 'Existing!');
            return back();
        } else {
            $type = 3; //type 3 = customer
            $users = new User();
            $users->username    = $username;
            $users->password    = Hash::make($password);
            $users->user_mobile = $request->user_mobile;
            $users->email       = $email;
            $users->userType_id = $type;
            $users->save();

            if ($users == true) { //If the insert account success
                $getid = DB::table('users')->select('id')->where('email','=', $email)->first(); //assign id to variable

                // dd($getid); die();
                if (is_object($getid)) {
                    $toArray = (array)$getid; //convert id to array
                    $convert = implode($toArray); // convert array to string

                    $customers = new Customers();
                    $customers->customer_fname       = ucwords($request->customer_fname);
                    $customers->customer_lname       = ucwords($request->customer_lname);
                    $customers->customer_mname       = ucwords($request->customer_mname);
                    $customers->customer_mobile      = $request->customer_mobile;
                    $customers->customer_tel         = $request->customer_tel;
                    $customers->customer_gender      = $request->customer_gender;
                    $customers->customer_birthday    = $request->customer_birthday;
                    $customers->customer_DP          = $request->customer_DP;
                    $customers->customer_blk         = ucwords($request->customer_blk);
                    $customers->customer_street      = ucwords($request->customer_street);
                    $customers->customer_subdivision = ucwords($request->customer_subdivision);
                    $customers->customer_city        = ucwords($request->customer_city);
                    $customers->id                   = $convert;
                    $customers->customer_isActive    = 1;
                    $customers->save();


                    alert()->success('Creation of account successful','Account Registered!');
                    return redirect('/user/login')->with('success','Your account is successfully registered');
                }
            }
        }
    }

    //LOGIN FUNCTION
    final function logIn(){
        return view('auth/login');
    }

    final function logout(){
        Auth::logout();
        return redirect('/');
    }
    
    //check if the request is for User
    final function checkUser(Request $request){
        //VALIDATION OF INPUTS
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        
        // $userAccounts = new UserAccounts();

        $creds = $request->only('email','password');
        if (Auth::attempt($creds)) {
            return redirect()->route('user.home');
        }else{
            alert()->error('Incorrect Username/Password','Fail');
            return redirect()->route('user.login');
        }
    }
}
