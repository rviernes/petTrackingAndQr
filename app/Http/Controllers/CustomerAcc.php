<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class CustomerAcc extends Controller
{
    public function widgetProfile()
    {
        $widgetProfile = DB::table('users')->get();
        return view('/customer/custAcc',compact('widgetProfile'));
    }

    
    public function useredit(){
    
        $usercust_id = DB::table('users')->where('id','=',$users_id)->first();
        
        return view('customer.custeditProfile', compact('usercust_id'));
    }

   
   
    function editCustSubmit(Request $request, $users_id){
                    DB::table('users')
                    ->where('id', '=', $users_id)
                    ->update(array(
                    'name' => $request -> name,
                    'mobile' => $request -> mobile,
                    'email' => $request -> email
                    // 'user_password' => $request -> user_password,
                    // 'userType_id' => $request -> userType_id
                ));
          
            return redirect('/customer/custProfile')->with('success','Customer has been updated successfuly');
        }
    public function getUser(){

    $custUser=DB::table('user_accounts')->where('user_Id','=',$users_id)->first();
    }
    // function saveType(Request $request,$users_id){
    //     DB::table('users')->where('id',$users_id)
    //     ->update(['name'=>$request->users_name]);
    //     return redirect('/customer/custProfile')->with('Success','Successfully Updated!');
        
    // }
    
}
    // function updateInfo(Request $request){
           
    //     $validator = \Validator::make($request->all(),[
    //         'user_name'=>'required',
    //         'user_mobile'=> 'required',
    //         'user_email'=>'required'
    //     ]);
         
    // if(!$validator->passes()){
    //     return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
    // }else{
    //      $query = User::find(Auth::user()->id)->update([
    //                   'user_name' => $request ->name,
    //                   'user_mobile' => $request ->mobile,
    //                   'user_email' => $request -> email
    //      ]);
    //     }
    // }
    // function usereditcustomerID($user_id){
    //     $usercust_id = DB::table('user_accounts')->where('user_id','=',$user_id)->first();
    //     return view('customer.custeditProfile', compact('usercust_id'));
    //     }
    // function editCustSubmit(Request $request, $user_id){
    //             DB::table('user_accounts')
    //             ->where('user_id', '=', $user_id)
    //             ->update(array(
    //             'user_name' => $request -> user_name,
    //             'user_mobile' => $request -> user_mobile,
    //             'user_email' => $request -> user_email
    //             // 'user_password' => $request -> user_password,
    //             // 'userType_id' => $request -> userType_id
    //         ));
      
    //     return redirect('/customer/custProfile')->with('success','Customer has been updated successfuly');
    // }
    
    

