<?php

namespace App\Http\Controllers;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use UxWeb\SweetAlert\SweetAlert;


class PetBreedController extends Controller
{
  function addBreed(Request $request) {
    $breed_name= $request->breed_name;

    $checkQuery = DB::table('pet_breeds')->where('breed_name','=', $breed_name)->first();

    if ($checkQuery) {
        alert()->warning('Pet breed has Already Exist','Existing!');
        return redirect('/admin/pets/CRUDpetbreed');
    }else{

        $request->validate([
            'breed_name'=>'required',
        ]);
        DB::table('pet_breeds')->insert([
            'breed_name'=>$request->breed_name
        ]);
        alert()->success('Pet breed added succesfully','New Breed Name');
        return redirect('/admin/pets/CRUDpetbreed');
    }
}
      function retrieveBreed(){
        $typeBreed = DB::table('pet_breeds')->orderBy('breed_id','DESC')->paginate(8);

        return view('/admin/pets/CRUDpetbreed',compact('typeBreed'));
    }
    function getBreedID($breed_id){
        $getID = DB::table('pet_breeds')->where ('breed_id','=',$breed_id)->first();
        return view ('/admin/pets/CRUDeditbreed',compact('getID'));
    }
    function saveBreed(Request $request,$breed_id){
        $checkQuery = DB::table('pet_breeds')->where('breed_name','=',$request->breed_name)->first();

        if ($checkQuery) {
            alert()->message('Breed name already Exist','No Changes');
            return redirect('/admin/pets/CRUDpetbreed');
        }else{
            DB::table('pet_breeds')
            ->where('breed_id',$breed_id)
            ->update([
                'breed_name'=>$request->breed_name
            ]);
            alert()->success('Breed name successfully updated!','Updated!');
            return redirect('/admin/pets/CRUDpetbreed');
        }
    }

    function deleteBreed($breed_id){
        $checkQuery = DB::table('pets')->where('pet_breed_id',$breed_id)->first();

        if ($checkQuery) {
            alert()->error('Breed option is in use!', 'Cannot Delete');
            return back();
        }else{
            DB::table('pet_breeds')->where('breed_id', $breed_id)->delete();
            alert()->warning('Breed Name Successfully Deleted!', 'Deleted!');
            return redirect('/admin/pets/CRUDpetbreed');
        }
        

    }

    public function search(Request $request){
        
        $search = $request->get('search');
        $usersData = DB::table('pet_breeds')->where('breed_id','=','3', 'AND','breed_name', 'like', '%'.$search.'%')->paginate('5');
        return view('/admin/pets/CRUDpetbreed', compact('typeBreed'));
    }

   

}