<?php

namespace App\Http\Controllers;

use App\Models\user_account;
use Illuminate\Http\Request;
use App\Models\User_accounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Hash;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Types\StringType;
use UxWeb\SweetAlert\SweetAlert;



class PetTypeController extends Controller
{

function addType(Request $request){

    $type_name= $request->type_name;

    $checkQuery = DB::table('pet_types')->where('type_name','=', $type_name)->first();

    if ($checkQuery) {
        alert()->warning('Pet Already Exist!', 'Creation Fail');
        return redirect('/admin/pets/CRUDpettype/home');
    }else{
        $request->validate([ 'type_name'=>'required' ]);
        DB::table('pet_types')->insert([ 'type_name'=>$request->type_name ]);

        alert()->success('Pet type added succesfully', 'Type Added!');
        return redirect('/admin/pets/CRUDpettype/home');
    }
}

    function retrieveType(){
    
        $typePet = DB::table('pet_types')->paginate(8);

        return view('/admin/pets/CRUDpettype',compact('typePet'));
    }

    function getTypeID($type_id){

        $getID=DB::table('pet_types')->where('type_id','=',$type_id)->first();

        return view('/admin/pets/CRUDedittype',compact('getID'));
    }


    function saveType(Request $request,$type_id){
        $type_name = $request->type_name;
        $checkQuery = DB::table('pet_types')->where('type_name','=', $type_name)->first();

        if ($checkQuery) {
            alert()->message('No changes have been applied', 'Same Name');
            return redirect('/admin/pets/CRUDpettype/home');
        }else{
            DB::table('pet_types')
            ->where('type_id',$type_id)
            ->update([
                'type_name'=>$request->type_name
            ]);
            alert()->success('Type Name Successfully Updated', 'Updated!');
            return redirect('/admin/pets/CRUDpettype/home');
        }
       
    }
    
    function deleteType($type_id){
        $queryCheck = DB::table('pets')->where('pet_type_id',$type_id)->first();

        if ($queryCheck) {
            alert()->error('Pet Type is in use.', 'Cannot Delete.');
            return back();
        }else{
            DB::table('pet_types')->where('type_id', $type_id)->delete();
            alert()->warning('Pet Type Successfully Deleted', 'Type Deletion');
            return back();
        }
    }

    public function search(Request $request){
        
        $search = $request->get('search');
        $usersData = DB::table('pet_types')->where('type_id','=','3', 'AND','type_name', 'like', '%'.$search.'%')->paginate('5');
        return view('/admin/pets/CRUDpettype', compact('typePet'));
    }

    public function widgetClinic(){
        $widgetClinic = DB::table('clinic')->get();
        return view('/veterinary/vetclinic', compact('widgetClinic'));
    }
}

