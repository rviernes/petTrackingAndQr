<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\User;
use App\Models\user_account;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Types\StringType;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use function PHPUnit\Framework\isFalse;
use function PHPUnit\Framework\isTrue;

class VeterinariansController extends Controller
{
     
    // retrieve data for customers 

    final function getAllCustomer(){

        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')->orderBy('customer_id', 'DESC')
        ->paginate(5);

        return view('veterinary/viewvetcustomer', compact('customers'));
    }
    //-> end for retrieve data customers

    final function veterinariesInfo(){
        
        $veterinaries = DB::table('veterinary')
        ->join('clinic','clinic.clinic_id','=','veterinary.vet_id')
        ->select('veterinary.vet_id', DB::raw("CONCAT(vet_fname,' ', vet_lname) AS vet_name"),
        'veterinary.vet_mobile','veterinary.vet_tel','veterinary.vet_birthday','veterinary.vet_DP', DB::raw("CONCAT(vet_blk, ' ', vet_street,' ',vet_subdivision,' ',vet_barangay,' ',
        vet_city,' ',vet_zip) AS vet_address"),'veterinary.vet_dateAdded','clinic.clinic_name','veterinary.vet_isActive')
        ->paginate(10);
       

        return view('veterinary/viewvet', ['veterinaries'=>$veterinaries]);
    }

    final function clinicInfo(){
        $clinics = DB::table('clinic')
        ->select('clinic_id','clinic_name','owner_name','clinic_mobile','clinic_email','clinic_tel',
        DB::raw("CONCAT(clinic_blk,' ', clinic_street,' ',clinic_barangay,' ',clinic_city,' ',
        clinic_zip) AS clinic_address"),'clinic_isActive')
        ->paginate(15);

        return view('veterinary.viewvetclinic',['clinics'=>$clinics]);
    }

    final function retrieveInfo(){
        
    //--> retrieve pet information to table

        $petInfoDatas = DB::table('pets') 
        ->join('pet_types','pet_types.type_id','=','pets.pet_type_id')
        ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        ->join('customers','customers.customer_id','=','pets.customer_id')
        ->join('clinic','clinic.clinic_id','=','pets.clinic_id')
        ->select('pets.pet_id','pets.pet_name','pets.pet_type_id', 'pets.pet_breed_id','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        'pet_breeds.breed_name','pets.pet_isActive', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),
        'clinic.clinic_name', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"))
        ->paginate(10);

        return view('veterinary.viewvetpatient', compact('petInfoDatas'));

    //--> retrieve pet information to table
    
    }
    
    final function petClassification($customer_id){

        $pet_types = DB::table('pet_types')->get(); //-> retrieve pet types
        
        $pet_breeds = DB::table('pet_breeds')->get(); //-> retrieve breeds 

        $pet_clinics = DB::table('clinic')->get(); // -> retrieve vet clinics

        $custInfo = DB::table('customers')->where('customer_id', '=', $customer_id)->first(); // -> retrieve info customer

        return view('veterinary.registerpet', compact('custInfo','pet_types','pet_breeds','pet_clinics'));
    }
    public function countData(){
        $countPet = DB::table('pets')->count();            //
        $countCustomers = DB::table('customers')->count(); // -> retrieve dashboard info
        $countClinic = DB::table('clinic')->count();       //
        return view('veterinary.vethome', compact('countPet','countCustomers','countClinic'));
    }


    function userViewPatient($customer_id){
        $Owners = DB::table('pets')
        ->join('pet_types','pet_types.type_id','=','pets.pet_type_id')
        ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        ->join('customers','customers.customer_id','=','pets.customer_id')
        ->join('clinic','clinic.clinic_id','=','pets.clinic_id')
        ->select('pets.pet_id','pets.pet_name','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        'pet_breeds.breed_name','pets.pet_isActive','pets.customer_id', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),
        'clinic.clinic_name')
        ->where('pets.customer_id','=', $customer_id)->get();

        return view('veterinary/userviewpatient', compact('Owners'));
    }

     //<------------- ---Start of customer crud operations----------------------->//

    function addCustomer(Request $request){

        $fname = $request->customer_fname;
        $lname = $request->customer_lname;
        $mname = $request->customer_mname;

        $checkQuery = DB::table('customers')
        ->where('customer_fname','=', $fname, 'AND',
         'customer_lname','=', $lname, 'AND', 
         'customer_mname','=', $mname)->first();

        $checkcust = DB::table('customers')
        ->where('customer_fname','=', $fname)
        ->where('customer_lname','=', $lname)
        ->where('customer_mname','=', $mname)->first();

         //QUERY FOR CHECKING IF THE CUSTOMER IS ALREADY REGISTERED

        if ($checkcust) {
            return back()->with('existing','The customer is Already Exist');
        }else{

        
            $type = 3;
            $insAccQuery = DB::table('user_accounts')->insert([
                'user_name'=>$request->user_name,
                'user_password'=>$request->user_password,
                'user_mobile'=>$request->user_mobile,
                'user_email'=>$request->user_email,
                'userType_id'=>$type
            ]);
            //INSERT QUERY FOR ACCOUNTS


            if ($insAccQuery) { //IF THE INSERT ACCOUNT SUCCESS
                
                $getid = DB::table('user_accounts')->select('user_id')->where('user_email','=', $request->user_email)->first();
                //GET ID BY USING UNIQUE ATTRIBUTES
               
                if (is_object($getid)) {
                    
                    $toArray = (array)$getid; //CONVERT OBJECT INTO ARRAY
                    $convert = implode($toArray); // CONVERT ARRAY INTO STRING

                    $isActive = 1;

                    DB::table('customers')->insert([
                        'customer_fname'=>$request->customer_fname,
                        'customer_lname'=>$request->customer_lname,
                        'customer_mname'=>$request->customer_mname,
                        'customer_mobile'=>$request->customer_mobile,
                        'customer_tel'=>$request->customer_tel,
                        'customer_gender'=>$request->customer_gender,
                        'customer_birthday'=>$request->customer_birthday,
                        'customer_DP'=>$request->customer_DP,
                        'customer_blk'=>$request->customer_blk,
                        'customer_street'=>$request->customer_street,
                        'customer_subdivision'=>$request->customer_subdivision,
                        'customer_barangay'=>$request->customer_barangay,
                        'customer_city'=>$request->customer_city,
                        'customer_zip'=>$request->customer_zip,
                        'user_id'=>$convert ,
                        'customer_isActive'=>$isActive
                    ]);
                    return redirect('/veterinary/viewvetcustomer')->with('newCustomer','Customer has been completely added succesfully');
                   
                }
            }  
        } 
    }


    final function veteditcustomerID($customer_id){
        $vetcust_id = DB::table('customers')->where('customer_id','=', $customer_id)->first();
        // GET ID TO RETRIEVE SPECIFIC CUSTOMER FOR VIEWVETCUSTOMER PAGE UPDATE BTN
        return view('veterinary.veteditcustomer', compact('vetcust_id'));
    }


    final function editCustomer(Request $request, $customer_id){

        DB::table('customers')
        ->where('customer_id', $customer_id)
        ->update([
            'customer_fname'=>$request->customer_fname,
            'customer_lname'=>$request->customer_lname,
            'customer_mobile'=>$request->customer_mobile,
            'customer_tel'=>$request->customer_tel,
            'customer_gender'=>$request->customer_gender,
            'customer_birthday'=>$request->customer_birthday,
            'customer_blk'=>$request->customer_blk,
            'customer_street'=>$request->customer_street,
            'customer_subdivision'=>$request->customer_subdivision,
            'customer_city'=>$request->customer_city,
            'customer_zip'=>$request->customer_zip,
        ]);//editCustomer


        return back()->with('customer_updated','Customer has been updated successfuly');
    }

    final function saveCustomer(Request $request, $customer_id){

         $NoActionQuery = DB::table('customers')
        ->where('customer_fname','=', $request->customer_fname)
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

        if($NoActionQuery) {
            return redirect('veterinary/viewvetcustomer')->with('warning','No changes');
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

             return redirect('veterinary/viewvetcustomer')->with('success','Customer has been updated successfuly');

        }
   }
    
    final function addPatients(Request $request){
        $breed = $request->pet_breed_id;
        $type = $request->pet_type_id;
        $name = $request->pet_name;

        $checkQuery = DB::table('pets')->where('pet_name','=', $name, 'AND', 'pet_type_id','=', $type, 'pet_breed_id','=', $breed)->first();
        //QUERY IF THE PET IS ALREADY REGISTER

        if ($checkQuery) {
            return back()->with('fail', 'Pet is Already Registered');
        }else{

            // PET ADD VALIDATION -START
            $request->validate([
                "pet_name"=>'required',
                "pet_gender"=>'required',
                "pet_birthday"=>'required',
                "pet_notes"=>'required',
                "pet_bloodType"=>'required',
                "pet_registeredDate"=>'required',
                "pet_type_id"=>'required',
                "pet_breed_id"=>'required',
                "pet_isActive"=>'required'

            ]);// PET ADD VALIDATION -END



            // INSERT PET -START
            DB::table('pets')->insert([
                'pet_name'=>$request->pet_name,
                'pet_gender'=>$request->pet_gender,
                'pet_birthday'=>$request->pet_birthday,
                'pet_notes'=>$request->pet_notes,
                'pet_bloodType'=>$request->pet_bloodType,
                'pet_DP'=>$request->pet_DP,
                'pet_registeredDate'=>$request->pet_registeredDate,
                'pet_type_id'=>$request->pet_type_id,
                'pet_breed_id'=>$request->pet_breed_id,
                'customer_id'=>$request->customer_id,
                'clinic_id'=>$request->clinic_id,
                'pet_isActive'=>$request->pet_isActive,
                'pet_DP'=>$request->image
                
            ]);
            //INSERT PET -END

            $customer_id = $request->customer_id;
            return redirect()->route('custownerpatient', ['customer_id'=> base64_encode($customer_id)])->with('success', 'Patient has been added succesfully');
        }

    }

    final function deleteCustomers($customer_id){ 
        $checkPetCustomer = DB::table('pets')->where('customer_id', '=', $customer_id)->first();

        if ($checkPetCustomer) {
            return back()->with('error','You cant delete a customer does have a register pet');
        }else{
            DB::table('customers')->where('customer_id', $customer_id)->delete();// DELETE CUSTOMERS
            return back()->with('customer_deleted','Customer has been deleted succesfully');
        }
       
    }

    //<------------- ---End of customer crud operations----------------------->//


    function getPetIDVet($pet_id){
        $editPet = DB::table('pets')->where('pet_id', '=', $pet_id)->first();
        $getTypePet = DB::table('pet_types')->get();
        $getBreedPet = DB::table('pet_breeds')->get();
        $getClinicPet = DB::table('clinic')->get();
        $getOwnerPet = DB::table('customers')->get();
        
        return view('veterinary.vieweditpatient', compact('editPet', 'getTypePet', 'getBreedPet','getClinicPet','getOwnerPet'));
    }
    
    function getPetID($pet_id){

        $editPet = DB::table('pets')->where('pet_id', '=', $pet_id)->first();
        $getTypePet = DB::table('pet_types')->get();
        $getBreedPet = DB::table('pet_breeds')->get();
        $getClinicPet = DB::table('clinic')->get();
        $getOwnerPet = DB::table('customers')->get();
        
        return view('veterinary.vieweditpatient', compact('editPet', 'getTypePet', 'getBreedPet','getClinicPet','getOwnerPet'));
    }

    function savePetVet(Request $request, $pet_id){

        $breed = $request->pet_breed_id;
        $gender = $request->pet_gender;
        $birthday = $request->pet_birthday;
        $notes = $request->pet_notes;
        $bloodtype = $request->pet_bloodType;
        $regDate = $request->pet_registeredDate;
        $type = $request->pet_type_id;
        $name = $request->pet_name;
        $customer = $request->customer_id;
        $clinic = $request->clinic_id;
        $status = $request->pet_isActive;


        $NoActionQuery = DB::table('pets')
        ->where('pet_name','=', $request->pet_name)
        ->where('pet_gender','=', $request->pet_gender)
        ->where('pet_birthday','=', $request->pet_birthday)
        ->where('pet_notes','=', $request->pet_notes)
        ->where('pet_bloodType','=', $request->pet_bloodType)
        ->where('pet_registeredDate','=',$request->pet_registeredDate)
        ->where('pet_type_id','=', $request->pet_type_id)
        ->where('pet_breed_id','=', $request->pet_breed_id)
        ->where('customer_id', '=', $request->customer_id)
        ->where('clinic_id','=', $request->clinic_id)
        ->where('pet_isActive','=', $request->pet_isActive)->first();


        if ($NoActionQuery) {
            return redirect('veterinary/viewvetpatient')->with('warning','Nothing Changes');
        }else{
            DB::table('pets')
        ->where('pet_id', $pet_id)
        ->update([
            'pet_name'=>$request->pet_name,
            'pet_gender'=>$request->pet_gender,
            'pet_birthday'=>$request->pet_birthday,
            'pet_notes'=>$request->pet_notes,
            'pet_bloodType'=>$request->pet_bloodType,
            'pet_registeredDate'=>$request->pet_registeredDate,
            'pet_type_id'=>$request->pet_type_id,
            'pet_breed_id'=>$request->pet_breed_id,
            'customer_id'=>$request->customer_id,
            'clinic_id'=>$request->clinic_id,
            'pet_isActive'=>$request->pet_isActive
        ]);

            $customer_id = $request->customer_id;

            return redirect('veterinary/viewvetpatient')->with('success','Patients has been updated sucessfully');
        }
    }
    function savePet(Request $request, $pet_id){


    
        $customer = $request->customer_id;
        $NoActionQuery = DB::table('pets')
        ->where('pet_name','=', $request->pet_name)
        ->where('pet_gender','=', $request->pet_gender)
        ->where('pet_birthday','=', $request->pet_birthday)
        ->where('pet_notes','=', $request->pet_notes)
        ->where('pet_bloodType','=', $request->pet_bloodType)
        ->where('pet_registeredDate','=',$request->pet_registeredDate)
        ->where('pet_type_id','=', $request->pet_type_id)
        ->where('pet_breed_id','=', $request->pet_breed_id)
        ->where('customer_id', '=', $request->customer_id)
        ->where('clinic_id','=', $request->clinic_id)
        ->where('pet_isActive','=', $request->pet_isActive)
        ->first();

        if ($NoActionQuery) {
            return redirect()->route('custownerpatient', ['customer_id'=> base64_encode($customer)])->with('warning','Nothing Changes');
        }else{

            DB::table('pets')
        ->where('pet_id', $pet_id)
        ->update([
            'pet_name'=>$request->pet_name, 
            'pet_gender'=>$request->pet_gender,
            'pet_birthday'=>$request->pet_birthday,
            'pet_notes'=>$request->pet_notes,
            'pet_bloodType'=>$request->pet_bloodType,
            'pet_registeredDate'=>$request->pet_registeredDate,
            'pet_type_id'=>$request->pet_type_id,
            'pet_breed_id'=>$request->pet_breed_id,
            'customer_id'=>$request->customer_id,
            'clinic_id'=>$request->clinic_id,
            'pet_isActive'=>$request->pet_isActive,
            'pet_DP'=>$request->image
        ]);

            $customer_id = $request->customer_id;

            return redirect()->route('custownerpatient', ['customer_id'=> base64_encode($customer_id)])->with('success','Patients has been updated sucessfully');
        }
    }

    final function deletePatients($pet_id){
        DB::table('pets')->where('pet_id', $pet_id)->delete(); //DELETE PATIENTS FROM viewvetpatient OR PETS
        return back()->with('patients_deleted','Patients has been deleted sucessfully');
    }
    final function deleteCustPatients($pet_id){
        DB::table('pets')->where('pet_id', $pet_id)->delete(); //DELETE PATIENTS from viewpatient OR PETS
        return back()->with('error','Patients has been deleted sucessfully');
    }

    final function patientsOwnerView($customer_id){
       $PatientOwner = DB::table('pets') 
        ->join('pet_types','pet_types.type_id','=','pets.pet_type_id')
        ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        ->join('customers','customers.customer_id','=','pets.customer_id')
        ->join('clinic','clinic.clinic_id','=','pets.clinic_id')
        ->select('pets.pet_id','pets.pet_name','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pet_DP','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        'pet_breeds.breed_name','pets.pet_isActive','pets.customer_id', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name",),DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"),'clinic.clinic_name')
        ->where('pets.customer_id','=', base64_decode($customer_id))->get();

        return view('veterinary/viewpatient', ['PatientOwner'=>$PatientOwner]);
    }

    final function QRcode($pet_id){

        $QrCodeDatas= DB::table('pets')
        ->join('pet_types','pet_types.type_id','=','pets.pet_type_id')
        ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        ->join('customers','customers.customer_id','=','pets.customer_id')
        ->join('clinic','clinic.clinic_id','=','pets.clinic_id')
        ->select('pets.pet_id','pets.pet_name','pets.pet_type_id', 'pets.pet_breed_id','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        'pet_breeds.breed_name','pets.pet_isActive', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),
        'clinic.clinic_name', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"))
        ->where('pet_id','=', $pet_id)
        ->first();

        return view('veterinary.qrcode', compact('QrCodeDatas'));

    }

    public function search(Request $request){
        
        $search = $request->get('search');
        $usersData = DB::table('pets')->where('pet_name', 'like', '%'.$search.'%')->paginate('5');
        return view('veterinary.user', compact('usersData'));
    }

    public function custSearch(Request $request){
        $search = $request->get('custsearch');
        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')
        -> where('customer_fname', 'like', '%'.$search.'%')->paginate('5');
        return view('veterinary.viewvetcustomer', compact('customers'));
    }

    public function patientSearch(Request $request){
        $search = $request->get('petsearch');

         $petInfoDatas = DB::table('pets') 
        ->join('pet_types','pet_types.type_id','=','pets.pet_type_id')
        ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        ->join('customers','customers.customer_id','=','pets.customer_id')
        ->join('clinic','clinic.clinic_id','=','pets.clinic_id')
        ->select('pets.pet_id','pets.pet_name','pets.pet_type_id', 'pets.pet_breed_id','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        'pet_breeds.breed_name','pets.pet_isActive', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),
        'clinic.clinic_name', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"))
        ->where('pet_name', 'like', '%'. $search. '%')
        ->paginate(10);

        return view('veterinary.viewvetpatient', compact('petInfoDatas'));

    }

    public function saveProfile(Request $request, $vet_id, $user_id){

        $NoActionQueryUser = DB::table('user_accounts')
        ->where('user_name', '=', $request->user_name)
        ->where('user_mobile', '=', $request->user_mobile) // query for not changes user_account
        ->where('user_email', '=', $request->user_email)->first();

        $NoActionQueryVet = DB::table('veterinary')
        ->where('vet_fname','=', $request->vet_fname)
        ->where('vet_lname','=', $request->vet_lname)
        ->where('vet_mname','=', $request->vet_mname)
        ->where('vet_mobile','=', $request->vet_mobile)
        ->where('vet_tel','=', $request->vet_tel)
        ->where('vet_blk','=',$request->vet_blk)    // query for not changes veterinary
        ->where('vet_street','=', $request->vet_street)
        ->where('vet_subdivision','=', $request->vet_subdivision)
        ->where('vet_barangay', '=', $request->vet_barangay)
        ->where('vet_city', '=', $request->vet_city)
        ->where('vet_zip','=', $request->vet_zip)->first();

        if($NoActionQueryVet && $NoActionQueryUser) {
            return back()->with('warning', 'No changes');  // no actions
        }
    
    
        DB::table('user_accounts')
            ->where('user_id', $user_id)
            ->update([
                'user_name'=>$request->user_name,
                'user_mobile'=>$request->user_mobile, // acc update query
                'user_email'=>$request->user_email
            ]);

        DB::table('veterinary')
            ->where('vet_id', $vet_id)
            ->update([
                'vet_fname'=>$request->vet_fname,
                'vet_lname'=>$request->vet_lname,
                'vet_mname'=>$request->vet_mname,
                'vet_mobile'=>$request->vet_mobile,
                'vet_tel'=>$request->vet_tel,
                'vet_blk'=>$request->vet_blk,         // vet info update query
                'vet_street'=>$request->vet_street,
                'vet_subdivision'=>$request->vet_subdivision,
                'vet_barangay'=>$request->vet_barangay,
                'vet_city'=>$request->vet_city,
                'vet_zip'=>$request->vet_zip
            ]);

            return redirect('veterinary/profilevet')->with('success', 'Profile updated');

    }

    public function changePassword(Request $request, $user_id){

        $checkOldPass = DB::table('user_accounts')->where('user_id','=', $user_id)->first();

        if ($request->oldpassword == $checkOldPass->user_password) {

            DB::table('user_accounts')
            ->where('user_id', $checkOldPass->user_id)
            ->update([
                'user_password'=>$request->new_pass
            ]);

             return redirect('veterinary/profilevet')->with('success', 'password successfully changed');
        }else{
            return back()->with('error', 'wrong password');
        }


    }

}