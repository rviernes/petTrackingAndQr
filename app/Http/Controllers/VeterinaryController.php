<?php

namespace App\Http\Controllers;

use App\Models\Veterinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use UxWeb\SweetAlert\SweetAlert;

class VeterinaryController extends Controller
{
    function admin_AddVeterinarian(Request $request){

        $fname = $request->vet_fname;
        $lname = $request->vet_lname;
        $mname = $request->vet_mname;


        $checkQuery = DB::table('veterinary')
        ->where('vet_fname','=', $fname)
        ->Where('vet_lname', '=', $lname)
        ->Where('vet_mname', '=', $mname)->first();

        if ($checkQuery) {
            alert()->warning('The Veterinarian Already Exist','Already Exist');
            return back();
        }else{

            $request->validate([
                'user_name'=>'required | unique:user_accounts',
                'user_email' => 'required | email | unique:user_accounts'
            ]);
    
           $inCheckQuery = DB::table('user_accounts')->insert([
                'user_name'=>$request->user_name,
                'user_password'=>$request->user_password,
                'user_mobile'=>$request->user_mobile,
                'user_email'=>$request->user_email,
                'userType_id'=>2
            ]);

           if($inCheckQuery){
                $getId = DB::table('user_accounts')->select('user_id')->where('user_name','=', $request->user_name)->first();

                if(is_object($getId)){

                    $toArray = (array)$getId;
                    $convert = implode($toArray);

                    DB::table('veterinary')->insert([
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
                    'user_id'=>$convert,
                    'clinic_id'=>$request->clinic_id,
                    'vet_isActive'=>$request->vet_isActive,
                    'vet_dateAdded'=>$request->vet_dateAdded

                ]);
                    $id = $request->clinic_id;
                    alert()->success('Veterinary has been Successfully added','Welcome!');
                    return redirect()->route('clinicvet', ['clinic_id'=> $id]);
            }
           }
    }
    }

    function admin_AddVetID($clinic_id){
        $userVetID = DB::table('user_accounts')->select('user_id')->orderBy('user_id', 'desc')->first();

        $vetInfo = DB::table('clinic')->where('clinic_id', '=', $clinic_id)->first();
        $clinicInfo = DB::table('clinic')->get();

        return view('admin.vet.registerVet', compact('userVetID','vetInfo','clinicInfo'));
    }

    function admin_viewVetDetails($clinic_id){
        $vetDetails = DB::table('veterinary')
        ->join('user_accounts', 'user_accounts.user_id','=','veterinary.user_id')
        ->join('usertypes', 'user_accounts.userType_id','=','usertypes.userType_id')
        ->select('veterinary.*','user_accounts.*','usertypes.*')->where('clinic_id','=', $clinic_id)->get();

        // ('vet_id','vet_fname','vet_lname',
        //     DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay','customer_city','customer_zip', 
        //     DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ', customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')
        // ->where('user_id', '=', $user_id)
        // ->get();

        return view('admin/vet/viewVetDetails', ['vetDetails'=>$vetDetails]);
    }

    final function admin_DeleteVets($user_id){
        $getType = DB::table('user_accounts')->where('user_id', $user_id)->pluck('userType_id')->first();
        $deleteVet = DB::table('veterinary')->where('user_id', $user_id)->delete();
        
        if ($getType = 2) {
            if($deleteVet == true){
                    DB::table('user_accounts')->where('user_id', $user_id)->delete();
                    alert()->success('Veterinary Deleted', 'Thank you for your service!');
                    return back();
                }
        }
    }

    function admin_GetVet($vet_id){
        $vets = DB::table('veterinary')->where('vet_id','=', $vet_id)->first();

        $userVetID = DB::table('user_accounts')->get();

        $vetInfo = DB::table('clinic')->get();

        $clinicInfo = DB::table('veterinary')->get();

        return view('admin.vet.editVet', compact('vets', 'userVetID', 'vetInfo', 'clinicInfo'));
    }



    function admin_EditVetDetails(Request $request, $vet_id){
        $vet_fname = $request->vet_fname;
        $vet_lname = $request->vet_lname;
        $vet_mname = $request->vet_mname;
        $vet_mobile = $request->vet_mobile;
        $vet_tel = $request->vet_tel;
        $vet_birthday = $request->vet_birthday;
        $vet_blk = $request->vet_blk;
        $vet_street = $request->vet_street;
        $vet_subdivision = $request->vet_subdivision;
        $vet_barangay = $request->vet_barangay;
        $vet_city = $request->vet_city;
        $vet_zip = $request->vet_zip;
        $vet_dateAdded = $request->vet_dateAdded;
        $vet_isActive = $request->vet_isActive;

        $checkClinicQuery = DB::table('veterinary')
            ->where('vet_fname', '=', $vet_fname)
            ->where('vet_lname', '=', $vet_lname)
            ->where('vet_mname', '=', $vet_mname)
            ->where('vet_mobile', '=', $vet_mobile)
            ->where('vet_tel', '=', $vet_tel)
            ->where('vet_birthday', '=', $vet_birthday)
            ->where('vet_blk', '=', $vet_blk)
            ->where('vet_street', '=', $vet_street)
            ->where('vet_subdivision', '=', $vet_subdivision)
            ->where('vet_barangay', '=', $vet_barangay)
            ->where('vet_city', '=', $vet_city)
            ->where('vet_zip', '=', $vet_zip)
            ->where('vet_dateAdded', '=', $vet_dateAdded)
            ->where('vet_isActive', '=', $vet_isActive)->first();

            if ($checkClinicQuery) {
                alert()->warning('No changes / all are the same', 'Update Fail');
                return back();
            }else{
                
            DB::table('veterinary')
            ->where('vet_id', $vet_id)
            ->update(array(
                'vet_fname'=>$request->vet_fname,
                'vet_lname'=>$request->vet_lname,
                'vet_mname'=>$request->vet_mname,
                'vet_mobile'=>$request->vet_mobile,
                'vet_tel'=>$request->vet_tel,
                'vet_birthday'=>$request->vet_birthday,
                'vet_blk'=>$request->vet_blk,
                'vet_street'=>$request->vet_street,
                'vet_subdivision'=>$request->vet_subdivision,
                'vet_barangay'=>$request->vet_barangay,
                'vet_city'=>$request->vet_city,
                'vet_dateAdded'=>$request->vet_dateAdded,
                'vet_zip'=>$request->vet_zip,
                'vet_isActive'=>$request->vet_isActive
        ));
                $clinic_id = $request->clinic_id;
                alert()->success('Vet has been updated sucessfully','Updated!');
                return redirect()->route('clinicvet', ['clinic_id'=> $clinic_id]);
        }
            // return redirect('/admin/clinic/CRUDclinic/home')->with('vet_updated','Vet has been successfully Updated');
    }


    function admin_GetAllCustomer(){
        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')->orderBy('customer_id', 'DESC')
        ->paginate(5);
        $pet_clinics = DB::table('clinic')->get();

        $users = DB::table('user_accounts')->where('userType_id','=','3')->get();

        $pet_types = DB::table('pet_types')->get();

        $pet_breeds = DB::table('pet_breeds')->get();

        $pet_clinics = DB::table('clinic')->get();

        return view('admin/customer/CRUDcustomers', compact('customers','users','pet_clinics','pet_breeds', 'pet_types'));
    }

    public function customerSearch(Request $request){
        $search = $request->get('custsearch');
        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')
        -> where('customer_fname', 'like', '%'.$search.'%')->paginate('5');
        return view('admin.customer.CRUDcustomers', compact('customers'));
    }

    final function admin_PatientsOwnerViews($customer_id){
       $PatientOwner = DB::table('pets')
        ->join('pet_types','pet_types.type_id','=','pets.pet_type_id')
        ->join('pet_breeds','pet_breeds.breed_id','=','pets.pet_breed_id')
        ->join('customers','customers.customer_id','=','pets.customer_id')
        ->join('clinic','clinic.clinic_id','=','pets.clinic_id')
        ->select('pets.pet_id','pets.pet_name','pets.pet_gender','pets.pet_birthday','pets.pet_notes','pets.pet_bloodType','pets.pet_registeredDate', 'pet_types.type_name',
        'pet_breeds.breed_name','pets.pet_isActive','pets.customer_id', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name",),DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"),'clinic.clinic_name')
        ->where('pets.customer_id','=', $customer_id)->get();

        return view('admin/customer/viewPatient', ['PatientOwner'=>$PatientOwner]);
    }

    final function admin_veteditcustomersID($customer_id){
    $vetcust_id = DB::table('customers')->where('customer_id','=', $customer_id)->first();
    return view('admin.customer.customerEdit', compact('vetcust_id'));
    }

    final function admin_SaveCustomers(Request $request, $customer_id){
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
            return back()->with('editVetFail','No editing happened. Change something to edit.');
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
             return redirect('admin/customer/CRUDcustomers')->with('success','Customer has been updated successfuly');

   }
}

   public function autocompleteSearch(Request $request)
    {
        
          $query = $request->get('');
          $filterResult = User::where('name', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    }

    function admin_getPetID($pet_id){
        $pluckID = DB::table('pets')->where('pet_id', $pet_id)->pluck('customer_id')->first();
        $getCustID = DB::table('customers')->where('customer_id','=', $pluckID)->first();
        $editPet = DB::table('pets')->where('pet_id', '=', $pet_id)->first();
        $getTypePet = DB::table('pet_types')->get();
        $getBreedPet = DB::table('pet_breeds')->get();
        $getClinicPet = DB::table('clinic')->get();
        $getOwnerPet = DB::table('customers')->get();
        
        return view('admin.vet.adminEditPatient', compact('editPet', 'getTypePet', 'getBreedPet','getClinicPet','getOwnerPet', 'getCustID'));
    }

    public function customerSearch2(Request $request){
        $search = $request->get('custsearch');
        $customers = DB::table('customers')
        ->select('customer_id','customer_fname','customer_lname', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name"),'customer_mobile', 'customer_tel', 
        'customer_gender','customer_DP','customer_birthday','customer_blk','customer_street','customer_subdivision','customer_barangay',
        'customer_city','customer_zip', DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"), 'user_id', 'customer_isActive')
        -> where('customer_fname', 'like', '%'.$search.'%')->paginate('5');
        return view('admin.customer.CRUDcustomers', compact('customers'));
    }

    function admin_savePetVet(Request $request, $pet_id){
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
            alert()->warning('Pet has been updated sucessfully','Updated!');
            return back();
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

            $id = $request->customer_id;
            alert()->warning('Pet has been updated sucessfully','Updated!');
            return redirect()->route('adminPetView', ['customer_id'=>$request->customer_id]);
        }

    }

    function admin_DeletePet($pet_id){
        $delPet = DB::table('pets')->where('pet_id',$pet_id)->delete();
        $getPetName = DB::table('pets')->select('pet_name')->where('pet_id',$pet_id)->first();

        alert()->success('Pet info deleteted Successfully. Goodbye!', 'Successfully Deleted!');
        return back();
    }

}
    