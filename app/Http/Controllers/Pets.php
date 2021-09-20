<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PetsController extends Controller
{
    function addPets(Request $request) {
        $pet_name= $request->pet_name;
    
        $checkQuery = DB::table('pet_name')->where('pet_name','=', $pet_name)->first();
    
        if ($checkQuery) {
            return redirect('/admin/pets/CRUDpet')->with('existing','Pet breed has Already Exist');
        }else{
    
            $request->validate([
                'pet_name'=>'required',
            ]);
            DB::table('pet_breeds')->insert([
                'pet_name'=>$request->breed_name
            ]);
            return redirect('/admin/pets/CRUDpet')->with('newPet','Pet breed added succesfully');
    }
    
    
    }
          function retrievePet(){
            $Pet = DB::table('pets')
            ->join('pet_breeds', 'pet_breeds.breed_id','=','pets.pet_breed_id')
            ->join('pet_types', 'pet_types.type_id','=','pets.pet_type_id')
            ->join('customers', 'customers.customer_id', '=', 'pets.customer_id')
            ->join('clinic', 'clinic.clinic_id', '=', 'pets.clinic_id')
            ->select('pets.*','pet_breeds.*','pet_types.*','customers.*','clinic.*', DB::raw("CONCAT(customer_fname,' ', customer_lname) AS customer_name",), DB::raw("CONCAT(customer_blk,' ', customer_street,' ', customer_subdivision,' ',
        customer_barangay,' ',customer_city,' ', customer_zip) AS customer_address"))->paginate(10);
    
            return view('/admin/pets/CRUDpet',compact('Pet'));
        }

        function getPetID($pet_id){
            $getID = DB::table('pets')->where ('pet_id','=',$pet_id)->first();
            return view ('admin.pets.CRUDeditpet',compact('getID'));
        }

        function savePet(Request $request,$breed_id){
    
            DB::table('pets')
            ->where('breed_id',$pet_id)
            ->update([
                'pet_name'=>$request->pet_name
            ]);
            return redirect('/admin/pets/CRUDpet')->with('Success','Successfully Updated!');
        }
        function deleteBreed($pet_id){
            DB::table('pets')->where('pet_id', $pet_id)->delete();
            return redirect('/admin/pets/CRUDpet')->with('pet_deleted','Sucessfully Deleted!!!!!');
    
        }
    
        public function search(Request $request){
            
            $search = $request->get('search');
            $usersData = DB::table('pets')->where('breed_id','=','3', 'AND','breed_name', 'like', '%'.$search.'%')->paginate('5');
            return view('/admin/pets/CRUDpet', compact('Pet'));
        }

        final function admin_PatientsOwnerViews2($customer_id){
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
    
        final function getCustomerPet(){

            $data = ['LoggedUserInfo'=>DB::table('pets')
            ->join('pets','pets.customer_id','=', 'pets.customer_id')
            ->select('*')
            ->where('pets.customer_id','=', session('LoggedUser'))->first()];
            return view('pets.custHome', $data);
    
        }

    }
