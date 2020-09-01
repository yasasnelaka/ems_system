<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function admin(){
        return view('admin.admin');
    }
    public function report(){
        $user=User::where('role_id',2)
            ->get();
        return view('admin.report')->with('user',$user);
    }
    public function edit(Request $request){
        $user=User::where('id',$request->id)->first();
        return view('admin.edit_form')->with('user',$user);
    }
    public function edit_register(Request $request){
        $user=User::where('id',$request->id)->first();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back();
    }

}
