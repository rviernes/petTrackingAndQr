<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vets;
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
        $countVeterinarians = Veterinary::count();
        $countPet = Pets::count();
        $countCustomers = Customers::count();
        $countClinic = Clinic::count();

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

        $a = Customers::where('customer_lname', 'like', '%'.$search.'%');

        $customers = Customers::Select('*')
                                ->where('customer_fname', 'like', '%'.$search.'%')
                                       ->union($a)
                                       ->paginate('5');
        
        // DB::table('customers')
        // ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        // 'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        // 'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        // customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'id', 'customer_isActive')
        // -> where('customer_fname', 'like', '%'.$search.'%')
        // ->paginate('5');
        return view('dashboard/admin/customer/CRUDcustomers', compact('customers'));
    }

    public function clinicSearch(Request $request){
        $search = $request->get('clinicSearch');
        $getClinicInfo = DB::table('clinics')->select('*')->where('clinic_name', 'LIKE', '%'.$search.'%')->paginate('5');
        return view('dashboard/admin/clinic/CRUDclinic', compact('getClinicInfo'));
    }

    public function userSearch(Request $request){
        $search = $request->get('userSearch');

        $a = User::where('username','LIKE','%'.$search.'%');

        $userTypes_name = Admin::where('username','LIKE','%'.$search.'%')->union($a)->get();

        return view('dashboard/admin/users/CRUDusers', compact('userTypes_name'));
    }

    function addPetType(Request $request){

        $type_name= $request->type_name;
    
        $checkQuery = DB::table('pet_types')->where('type_name','=', $type_name)->first();
    
        if ($checkQuery) {
            alert()->warning('Pet Already Exist!', 'Creation Fail');
            return back();
        }else{
            $request->validate([ 'type_name'=>'required' ]);
            DB::table('pet_types')->insert([ 'type_name'=>$request->type_name ]);
    
            alert()->success('Pet type added succesfully', 'Type Added!');
            return redirect('/admin/CRUDpettype');
        }
    }

    function getTypeID($id){

        $getID = PetTypes::where('id','=',$id)->first();

        return view('dashboard/admin/pet/CRUDedittype',compact('getID'));
    }


    function saveType(Request $request,$id){
        $type_name = $request->type_name;
        $checkQuery = DB::table('pet_types')->where('type_name','=', $type_name)->first();

        if ($checkQuery) {
            alert()->message('No changes have been applied', 'Same Name');
            return back();
        }else{
            DB::table('pet_types')
            ->where('id',$id)
            ->update([
                'type_name'=>$request->type_name
            ]);
            alert()->success('Type Name Successfully Updated', 'Updated!');
            return redirect('/admin/CRUDpettype');
        }
    }

    function deleteType($id){
        $queryCheck = Pets::where('pet_type_id',$id)->first();

        if ($queryCheck) {
            alert()->error('Pet Type is in use.', 'Cannot Delete.');
            return back();
        }else{
            DB::table('pet_types')->where('id', $id)->delete();
            alert()->warning('Pet Type Successfully Deleted', 'Type Deletion');
            return back();
        }
    }

    function viewAddBreed(){
        return view('dashboard.admin.pet.CRUDaddbreed');
    }

    function addBreed(Request $request) {
        $breed_name = $request->breed_name;
    
        $checkQuery = PetBreeds::where('breed_name','=', $breed_name)->first();
    
        if ($checkQuery) {
            alert()->warning('Pet breed has Already Exist','Existing!');
            return back();
        }elseif ($breed_name == null) {
            alert()->message('Type something to create','Empty');
            return back();
        }else{
            $request->validate([
                'breed_name'=>'required',
            ]);
            PetBreeds::insert(['breed_name'=>$request->breed_name]);
            // DB::table('pet_breeds')->insert([
            //     'breed_name'=>$request->breed_name
            // ]);
            alert()->success('Pet breed added succesfully','New Breed Name');
            return redirect('/admin/CRUDpetbreed');
        }
    }

    function getBreedID($breed_id){
        $getID = DB::table('pet_breeds')->where ('breed_id','=',$breed_id)->first();
        return view ('dashboard.admin.pet.CRUDeditbreed',compact('getID'));
    }

    function saveBreed(Request $request,$breed_id){
        $checkQuery = PetBreeds::where('breed_name','=',$request->breed_name)->first();

        if ($checkQuery) {
            alert()->warning('Breed name already Exist','No Changes');
            return back();
        }elseif ($request->breed_name == null) {
            alert()->message('Type something to create','Empty');
            return back();
        }else{
            PetBreeds::where('breed_id',$breed_id)
                     ->update(['breed_name' => $request->breed_name]);

            alert()->success('Breed name successfully updated!','Updated!');
            return redirect('/admin/CRUDpetbreed');
        }
    }

    function deleteBreed($breed_id){
        $checkQuery = DB::table('pets')->where('pet_breed_id',$breed_id)->first();

        if ($checkQuery) {
            alert()->error('Breed option is in use!', 'Cannot Delete');
            return back();
        }else{
            PetBreeds::where('breed_id', $breed_id)->delete();
            alert()->warning('Breed name has been deleted!', 'Deleted!');
            return redirect('/admin/CRUDpetbreed');
        }
        

    }

    final function admin_PatientsOwnerViews($customer_id){
        $PatientOwner = Pets::join('pet_types','pet_types.id','=','pets.pet_type_id')
                            ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
                            ->join('customers','customers.customer_id','=','pets.customer_id')
                            ->join('clinics','clinics.clinic_id','=','pets.clinic_id')
                            ->select('pets.pet_id','pets.pet_name','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
         'pet_breeds.breed_name','pets.pet_isActive','pets.customer_id', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name",),DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
         customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"),'clinics.clinic_name')
         ->where('pets.customer_id','=', $customer_id)->get();
                            
        
        // DB::table('pets')
        //  ->join('pet_types','pet_types.id','=','pets.pet_type_id')
        //  ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        //  ->join('customers','customers.customer_id','=','pets.customer_id')
        //  ->join('clinics','clinics.clinic_id','=','pets.clinic_id')
        //  ->select('pets.pet_id','pets.pet_name','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        //  'pet_breeds.breed_name','pets.pet_isActive','pets.customer_id', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name",),DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        //  customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"),'clinic.clinic_name')
        //  ->where('pets.customer_id','=', $customer_id)->get();
 
         return view('dashboard.admin.customer.viewPatient', compact('PatientOwner'));
    }

    final function admin_veteditcustomersID($customer_id){
        $vetcust_id = Customers::where('customer_id','=',$customer_id)->first();

        return view('dashboard.admin.customer.customerEdit', compact('vetcust_id'));
    }


    final function admin_SaveCustomers(Request $request, $customer_id){
        $checkQuery = 

        Customers::where('customer_fname','=',$request->customer_fname)
                 ->where('customer_lname','=', $request->customer_lname)
                 ->where('customer_mname','=', $request->customer_mname)
                 ->where('customer_mobile','=', $request->customer_mobile)
                 ->where('customer_tel','=', $request->customer_tel)
                 ->where('customer_gender','=',$request->customer_gender)
                 ->where('customer_birthday','=', $request->customer_birthday)
                 ->where('customer_blk','=', $request->customer_blk)
                 ->where('customer_street', '=', $request->customer_street)
                 ->where('customer_subdivision', '=', $request->customer_subdivision)
                 ->where('customer_barangay','=', $request->customer_barangay)
                 ->where('customer_city','=', $request->customer_city)
                 ->where('customer_zip','=', $request->customer_zip)
                 ->where('customer_isActive','=', $request->isActive)->first();
        
        // DB::table('customers')
        // ->where('customer_fname','=', $request->customer_fname)
        // ->where('customer_lname','=', $request->customer_lname)
        // ->where('customer_mname','=', $request->customer_mname)
        // ->where('customer_mobile','=', $request->customer_mobile)
        // ->where('customer_tel','=', $request->customer_tel)
        // ->where('customer_gender','=',$request->customer_gender)
        // ->where('customer_birthday','=', $request->customer_birthday)
        // ->where('customer_blk','=', $request->customer_blk)
        // ->where('customer_street', '=', $request->customer_street)
        // ->where('customer_subdivision', '=', $request->customer_subdivision)
        // ->where('customer_barangay','=', $request->customer_barangay)
        // ->where('customer_city','=', $request->customer_city)
        // ->where('customer_zip','=', $request->customer_zip)
        // ->where('customer_isActive','=', $request->isActive)->first();

        if($checkQuery) {
            alert()->message('Change something to update','Same Values');
            return back();
        }else{
            DB::table('customers')
            ->where('customer_id', '=', $customer_id)
            ->update(array(
                'customer_fname'=>$request->customer_fname,
                'customer_lname'=>$request->customer_lname,
                'customer_mname'=>$request->customer_mname,
                'customer_mobile'=>$request->customer_mobile,
                'customer_tel'=>$request->customer_tel,
                'customer_gender'=>$request->customer_gender,
                'customer_birthday'=>$request->customer_birthday,
                'customer_blk'=>$request->customer_blk,
                'customer_street'=>$request->customer_street,
                'customer_subdivision'=>$request->customer_subdivision,
                'customer_barangay'=>$request->customer_barangay,
                'customer_city'=>$request->customer_city,
                'customer_zip'=>$request->customer_zip,
                'customer_isActive'=>$request->isActive
            ));
            //UPDATE CUSTOMER INFO
            alert()->success('Customer Updated Successfully','Updated!');
             return redirect('/admin/CRUDcustomers');

        }
    }

    final function admin_DeleteCustomer2($customer_id){ 
        $getUserID = Customers::where('customer_id', $customer_id)->pluck('id')->first();
        $getType = User::where('id',$getUserID)->pluck('userType_id')->first();
        $getType2 = Admin::where('id',$getUserID)->pluck('userType_id')->first();
        $custID = Customers::where('id',$getUserID)->pluck('customer_id')->first();
        $custQuery = DB::table('pets')->where('customer_id', $custID)->first();
        $countAdmin = Admin::count();
        // $deleteVet = DB::table('veterinary')->where('user_id', $getUserID)->delete();

        if ($custQuery) {
            alert()->error('Customer has registered pets','Delete Fail');
            return back();
        }else{
            if ($getType = 3) {
                Customers::where('id', $getUserID)->delete();
                User::where('id', $getUserID)->delete();

                alert()->warning('Customer successfully deleted','Deleted');
                return back();
            // }
            // elseif($getType = 2){
            //     if($deleteVet == true){
            //         DB::table('user_accounts')->where('user_id', $getUserID)->delete();
            //     }
            }else{
                if ($countAdmin>1) {
                    DB::table('user_accounts')->where('id', $getUserID)->delete();
                }else{
                    return back()->with('deleteFail2','Need 1 Administrator.');
                }
            }
        }       
        alert()->warning('User Successfully deleted','Deleted');        
        return back();
    }

    public function admin_AddClinicSubmit(Request $request){
        $checkQuery = Clinic::where('clinic_blk', $request->clinic_blk)->first();
        $checkQuery2 = Clinic::where('clinic_street', $request->clinic_blk)->first();

        // dd($checkQuery2); die;

        if ($checkQuery) {
            alert()->warning('Clinic is already registered');
            return back();
        }elseif ($checkQuery2) {
            alert()->warning('Clinic is already registered');
            return back();
        }else {
            Clinic::insert([
                'clinic_name' => ucwords($request->clinic_name),
                'owner_name' => ucwords($request->owner_name),
                'clinic_mobile' => $request->clinic_mobile,
                'clinic_tel' => $request->clinic_tel,
                'clinic_email' => $request->clinic_email,
                'clinic_blk' => ucwords($request->clinic_blk),
                'clinic_street' => ucwords($request->clinic_street),
                'clinic_barangay' => ucwords($request->clinic_barangay),
                'clinic_city' => ucwords($request->clinic_city),
                'clinic_zip' => ucwords($request->clinic_zip),
                'clinic_isActive' => $request->clinic_isActive
            ]);
            alert()->success('Clinic successfully registered!', 'Clinic Created!');
            return redirect('/admin/CRUDclinic');   
        }
    }

    function viewCLinic(){
        return view('dashboard.admin.clinic.registerClinic');
    }

    // function admin_viewVetDetails($clinic_id){
    //     $vetDetails = Veterinary::join('user_accounts', 'user_accounts.user_id','=','veterinary.user_id')
    //                             ->join('usertypes', 'user_accounts.userType_id','=','usertypes.userType_id')
    //                             ->select('veterinary.*','user_accounts.*','usertypes.*')->where('clinic_id','=', $clinic_id)->get();
        
    //     DB::table('veterinary')
    //     ->join('user_accounts', 'user_accounts.user_id','=','veterinary.user_id')
    //     ->join('usertypes', 'user_accounts.userType_id','=','usertypes.userType_id')
    //     ->select('veterinary.*','user_accounts.*','usertypes.*')->where('clinic_id','=', $clinic_id)->get();

    //     // ('vet_id','vet_fname','vet_lname',
    //     //     DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay','customer_city','customer_zip', 
    //     //     DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ', customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')
    //     // ->where('user_id', '=', $user_id)
    //     // ->get();

    //     return view('admin/vet/viewVetDetails', ['vetDetails'=>$vetDetails]);
    // }

    function admin_AddVetID($clinic_id){
        $userVetID = DB::table('users')->select('id')->orderBy('id', 'desc')->first();

        $vetInfo = DB::table('clinics')->where('clinic_id', '=', $clinic_id)->first();
        $clinicInfo = DB::table('clinics')->get();

        return view('dashboard.admin.vet.registerVet', compact('userVetID','vetInfo','clinicInfo'));
    }

    function admin_AddVeterinarian(Request $request){
        $username = $request->user_name;
        $password = $request->user_password;
        $email = $request->user_email;

        $fname = $request->vet_fname;
        $lname = $request->vet_lname;
        $mname = $request->vet_mname;

        $checkQuery = Veterinary::where('vet_fname','=', $fname)
                                ->Where('vet_lname', '=', $lname)
                                ->Where('vet_mname', '=', $mname)->first();
        
        $checkQuery2 = Vets::where('username','=', $request->user_name)
                           ->where('email','=', $request->user_email)->first();

        if ($checkQuery) {
            alert()->warning('The Veterinarian Already Exist','Already Exist');
            return back();
        }else{
            if ($checkQuery2) {
                alert()->warning('Account already taken');
                return back();
            }
                $type = 2; //type 2 = veterinary
                $vets = new Vets();
                $vets->username    = $username;
                $vets->password    = Hash::make($password);
                $vets->user_mobile = $request->user_mobile;
                $vets->email       = $email;
                $vets->userType_id = $type;
                $vets->save();
     
                if($vets == true){
                     $getId = Vets::select('id')->where('username','=', $request->user_name)->first();
     
                         Veterinary::insert([
                         'vet_fname'=>ucwords($request->vet_fname),
                         'vet_lname'=>ucwords($request->vet_lname),
                         'vet_mname'=>ucwords($request->vet_mname),
                         'vet_mobile'=>$request->vet_mobile,
                         'vet_tel'=>$request->vet_tel,
                         'vet_birthday'=>$request->vet_birthday,
                         'vet_DP'=>$request->vet_DP,
                         'vet_blk'=>ucwords($request->vet_blk),
                         'vet_street'=>ucwords($request->vet_street),
                         'vet_subdivision'=>ucwords($request->vet_subdivision),
                         'vet_barangay'=>ucwords($request->vet_barangay),
                         'vet_city'=>ucwords($request->vet_city),
                         'vet_zip'=>$request->vet_zip,
                         'id'=>$getId,
                         'clinic_id'=>$request->clinic_id,
                         'vet_isActive'=>$request->vet_isActive,
                         'vet_dateAdded'=>$request->vet_dateAdded
     
                     ]);
                         $id = $request->clinic_id;
                         alert()->success('Veterinary has been Successfully added','Welcome!');
                         return back();
                         // return redirect()->route('clinicvet', ['clinic_id'=> $id]);
                 
            }
           
        }
    }
    
}