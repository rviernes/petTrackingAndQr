<?php

namespace App\Http\Controllers;

use App\Models\UserAccounts;
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
            $userAccounts = new UserAccounts();
            $userAccounts->user_name     = $request->user_name;
            $userAccounts->user_password = Hash::make($request->user_password);
            $userAccounts->user_mobile   = $request->user_mobile;
            $userAccounts->user_email    = $request->user_email;
            $userAccounts->userType_id   = $type;
            $userAccounts->save();

            if ($userAccounts == true) { //If the insert account success
                $getid = DB::table('user_accounts')->select('user_id')->where('user_email','=', $request->user_email)->first(); //assign id to variable

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
                    $customers->user_id              = $convert;
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
    //check if the request is for User
    final function checkUser(Request $request){
        //VALIDATION OF INPUTS
        $request->validate([
            'user_email'=>'required',
            'user_password'=>'required'
        ]);

        // $userAccounts = new UserAccounts();

        // $creds = $userAccounts->only('user_email','user_password');
        // if (Auth::attempt($creds)) {
        //     return redirect()->route('user.home');
        // }else{
        //     return redirect()->route('user.login')->with('fail','Incorrect Username/Password');
        // }

        // $userInfo = UserAccounts::where('user_email','=', $request->user_email)->first();
        $userInfo = DB::table('user_accounts')->select('*')->where('user_email','=', $request->user_email)->first();
        
        dd($userInfo->user_password == $request->user_password); die();
        if (!$userInfo) {
            return back()->with('fail','We do not recognize your email address');
        }else{
                if ($userInfo->user_password == $request->user_password) {
                    if ($userInfo->userType_id == 1) {
                        $request->session()->put('LoggedUser', $userInfo->user_id); //for admin
                        return redirect('admin/index');
                    }elseif ($userInfo->userType_id == 3) {
                        $request->session()->put('LoggedUser', $userInfo->user_id); // for customer
                        return redirect('customer/custProfile');
                    }
                    elseif($userInfo->userType_id == 2){
                        $request->session()->put('LoggedUser', $userInfo->user_id); // for veterinary
                        return redirect('veterinary/vethome');
                    }
                }else{
                    alert()->error('Incorrect Password','Login Fail');
                    return back();
                }
        }
    }
}
