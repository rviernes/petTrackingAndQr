<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class CustProfileController extends Controller
{


    // final function userprofileID(){

    //     $getUserinfo = DB::select('select * from user_accounts where user_id = :user_id',['user_id' => 5]);
    //     return view('customer/custProf',compact('getUserinfo'));
    // }

    
    
    final function userProfile(){
        $data = ['LoggedUserInfo'=>DB::table('user_accounts')
        ->join('customers','customers.user_id','=', 'user_accounts.user_id')
        ->select('*')
        ->where('user_accounts.user_id','=', session('LoggedUser'))->first()];
        return view('customer.custProfile', $data);

        // return dd($data);
    }
    final function editProfile(){
        $data = ['LoggedUserInfo'=>DB::table('user_accounts')
        ->join('customers','customers.user_id','=', 'user_accounts.user_id')
        ->select('*')
        ->where('user_accounts.user_id','=', session('LoggedUser'))->first()];
        return view('customer.custAcc', $data);
    }
    public function custProfile(Request $request, $customer_id, $user_id){

        $NoActionQueryUser = DB::table('user_accounts')
        ->where('user_name', '=', $request->user_name)
        ->where('user_mobile', '=', $request->user_mobile) // query for not changes user_account
        ->where('user_email', '=', $request->user_email)->first();

        $NoActionQueryCustomer = DB::table('customers')
        ->where('customer_fname','=', $request->customer_fname)
        ->where('customer_lname','=', $request->customer_lname)
        ->where('customer_mname','=', $request->customer_mname)
        ->where('customer_mobile','=', $request->customer_mobile)
        ->where('customer_tel','=', $request->customer_tel)
        ->where('customer_blk','=',$request->customer_blk)    // query for not changes customer
        ->where('customer_street','=', $request->customer_street)
        ->where('customer_subdivision','=', $request->customer_subdivision)
        ->where('customer_barangay', '=', $request->customer_barangay)
        ->where('customer_city', '=', $request->customer_city)
        ->where('customer_zip','=', $request->customer_zip)->first();

        if ($NoActionQueryUser && $NoActionQueryCustomer) {
            return back()->with('warning', 'No changes all data are the same');
        }
            DB::table('user_accounts')
            ->where('user_id',$user_id)
            ->update([
                'user_name'=>$request->user_name,
                'user_mobile'=>$request->user_mobile,
                'user_email'=>$request->user_email
            ]);
       
            DB::table('customers')
            ->where('customer_id', $customer_id)
            ->update([
                'customer_fname'=>$request->customer_fname,
                'customer_lname'=>$request->customer_lname,
                'customer_mname'=>$request->customer_mname,
                'customer_mobile'=>$request->customer_mobile,
                'customer_tel'=>$request->customer_tel,
                'customer_blk'=>$request->customer_blk,
                'customer_street'=>$request->customer_street,
                'customer_subdivision'=>$request->customer_subdivision,
                'customer_barangay'=>$request->customer_barangay,
                'customer_city'=>$request->customer_city,
                'customer_zip'=>$request->customer_zip
            ]);
        
            return back()->with('success', 'Profile updated');
        
    }
    public function changePw(Request $request, $user_id){

    $checkOldPass = DB::table('user_accounts')->where('user_id','=', $user_id)->first();

    if ($request->oldpass == $checkOldPass->user_password) {

        DB::table('user_accounts')
        ->where('user_id', $checkOldPass->user_id)
        ->update([
            'user_password'=>$request->new_pass
        ]);

         return redirect('customer/custAcc')->with('success', 'password successfully changed');
    }else{
        return back()->with('warning', 'wrong password');
    }
}
}