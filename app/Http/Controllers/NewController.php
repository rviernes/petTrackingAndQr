<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vonModel;
use UxWeb\SweetAlert\SweetAlert;


class NewController extends Controller
{
    function inputName(Request $request){
        $vonModel = new vonModel;
        $vonModel->fname = $request->fname;
        $vonModel->mname = $request->mname;
        $vonModel->lname = $request->lname;
        $vonModel->save();

        alert()->success('NAKUHA RAJUD HAHAHA', 'YO WAZZUP');
        return redirect()->back();
    }

    function index(){
        return view('nameInput');
    }
}
