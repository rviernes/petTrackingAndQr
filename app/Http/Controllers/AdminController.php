<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Customers;
use App\Models\Clinic;
use App\Models\PetBreeds;
use App\Models\Pets;
use App\Models\PetTypes;
use App\Models\UserTypes;
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

class AdminController extends Controller
{
    public function admin_CountData(){
        $countVeterinarians = DB::table('veterinaries')->count();
        $countPet = DB::table('pets')->count();
        $countCustomers = DB::table('customers')->count();
        $countClinic = DB::table('clinics')->count();

        return view('dashboard.admin.home', compact('countVeterinarians','countPet','countCustomers','countClinic'));
    }

    final function checkAdmin(Request $request){
        //VALIDATION OF INPUTS
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        
        // $userAccounts = new UserAccounts();

        $creds = $request->only('email','password');
        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('admin.home');
        }else{
            alert()->error('Incorrect Username/Password','Fail');
            return redirect()->route('admin.login');
        }
    }

    final function addType(){
        return view('dashboard/admin/pet/CRUDaddtype');
    }

    final function logout(){
        Auth::logout();
        return redirect('/');
    }

    function getAllVet(){
        $admin_Veterinary = DB::table('veterinaries')
        ->join('clinics', 'veterinaries.clinic_id', '=', 'clinics.clinic_id')
        ->join('users', 'veterinaries.id', '=','users.id')
        ->select('veterinaries.*', 'clinics.*', 'users.*', DB::raw("CONCAT(vet_blk,'/', vet_street,'/', vet_subdivision,'/', vet_barangay,' ',vet_city,' ', vet_zip) AS vet_address"))->paginate(5);
        //inner join clinic

        $pet_clinics = DB::table('clinics')->get();

        $users = DB::table('users')->where('userType_id','=','3')->get();

        $pet_types = DB::table('pet_types')->get();

        $pet_breeds = DB::table('pet_breeds')->get();

        $pet_clinics = DB::table('clinics')->get();

        

        return view('dashboard/admin/vet/CRUDvet', compact('admin_Veterinary','users','pet_clinics','pet_breeds', 'pet_types'));
    }

    public function petSearch(Request $request){
        $search = $request->get('petSearch');
        $Pet = DB::table('pets')->select('*')->where('pet_name', 'LIKE', '%'.$search.'%')->paginate('8');
        return view('dashboard/admin/pet/CRUDpet', compact('Pet'));
    }

    public function petTypeSearch(Request $request){
        $search = $request->get('petTypeSearch');
        $typePet = DB::table('pet_types')->select('*')->where('type_name', 'LIKE', '%'.$search.'%')->paginate('8');
        return view('dashboard/admin/pet/CRUDpettype', compact('typePet'));
    }

    public function breedSearch(Request $request){
        $search = $request->get('breedSearch');
        $typeBreed = DB::table('pet_breeds')->select('*')->where('breed_name', 'LIKE', '%'.$search.'%')->paginate('5');
        return view('dashboard/admin/pet/CRUDpetbreed', compact('typeBreed'));
    }

    function getAllCustomers(){
        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'id', 'customer_isActive')->orderBy('customer_id', 'DESC')
        ->paginate(5);
        $pet_clinics = DB::table('clinics')->get();

        $users = DB::table('users')->where('userType_id','=','3')->get();

        $pet_types = DB::table('pet_types')->get();

        $pet_breeds = DB::table('pet_breeds')->get();

        $pet_clinics = DB::table('clinics')->get();

        return view('dashboard/admin/customer/CRUDcustomers', compact('customers','users','pet_clinics','pet_breeds', 'pet_types'));
    }

    public function customerSearch2(Request $request){
        $search = $request->get('custsearch');
        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'id', 'customer_isActive')
        -> where('customer_fname', 'like', '%'.$search.'%')->paginate('5');
        return view('dashboard/admin/customer/CRUDcustomers', compact('customers'));
    }

    public function clinicSearch(Request $request){
        $search = $request->get('clinicSearch');
        $getClinicInfo = DB::table('clinics')->select('*')->where('clinic_name', 'LIKE', '%'.$search.'%')->paginate('5');
        return view('dashboard/admin/clinic/CRUDclinic', compact('getClinicInfo'));
    }

    public function userSearch(Request $request){
        $search = $request->get('userSearch');
        
        // $users = new User();
        // $usertypes = new userTypes();
        // $admins = new Admin();

        // $userTypes_name = UserTypes::where('username','LIKE', '%'.$search.'%')
        //                 ->join('users')
        

        $userTypes_name = DB::table('user_types')
        ->join('users', 'user_types.userType_id', '=', 'users.userType_id')
        // ->join('admins', 'user_types.userType_id', '=', 'admins.userType_id')
        ->select('users.*','user_types.*')
        ->where('users.username', 'LIKE', '%'.$search.'%')
        ->orderBy('id', 'DESC')
        ->paginate('5');

        // ->where([
        //     ['users.username','LIKE', '%'.$search.'%'],
        //     ['admins.username','LIKE', '%'.$search.'%'],
        // ])

        // dd($userTypes_name); die();
        return view('dashboard/admin/users/CRUDusers', compact('userTypes_name'));
    }

    // function addType(Request $request){

    //     $type_name= $request->type_name;
    
    //     $checkQuery = DB::table('pet_types')->where('type_name','=', $type_name)->first();
    
    //     if ($checkQuery) {
    //         alert()->warning('Pet Already Exist!', 'Creation Fail');
    //         return back();
    //     }else{
    //         $request->validate([ 'type_name'=>'required' ]);
    //         DB::table('pet_types')->insert([ 'type_name'=>$request->type_name ]);
    
    //         alert()->success('Pet type added succesfully', 'Type Added!');
    //         return redirect('/admin/pet/CRUDaddtype');
    //     }
    // }
}
// 'users.username', 'LIKE', '%'.$search.'%'