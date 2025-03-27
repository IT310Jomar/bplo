<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function getclient(){
        $clientdatas=Client::latest()->get();
        return response()->json(['success'=>true,'clientdatas'=>$clientdatas],200); 
    }

    public function viewclient($id){
        $viewclient=Client::where('id',$id)->get();
        return response()->json(['success'=>true,'viewclient'=>$viewclient],200); 
    }
}


