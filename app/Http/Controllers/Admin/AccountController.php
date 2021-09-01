<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\City;
use App\Models\District;
use App\Models\BestDoctor;
use \Validator;
use \Session;

class AccountController extends Controller
{

    public function login(Request $request){

          try {
            $validateForm = Validator::make($request->all(), [
                'email' => ['required'],
                'password' => ['required']
            ]);
            if ($validateForm->fails()) {

                session()->flash('errors', $validateForm->errors());
                return redirect()->back();
            }
 
           $email    = $request->input('email');
           $password = $request->input('password');
           $user = User::login($email,$password);
 

           if($user === false)
              return back();

           $user =  Auth::attempt(['email' => $email , 'password' => $password]);
        
      
           $credentials = $request->only(['email', 'password']);

          return view("admin.dashboard");

        } catch (\Exception $e) {

            report($e);
            return $e->getMessage();
            return redirect('/admin/somethingwrong');
        }
    }



    


    public function logout(){

        $user = User::logout();
        return $user;

    }
}
