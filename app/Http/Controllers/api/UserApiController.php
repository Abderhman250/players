<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\City;
use App\Models\User;
use App\Models\Role;

use App\Models\Team;
use App\Models\UserPublic;


use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {


        try {

            $rules = [
                "email" => "required",
                "password" => "required"
           ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->Error($validator->errors()->first(), 401);
            }
            //login

            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('api')->attempt($credentials);


            if (!$token)
                return $this->Error("csas", 400);

            $User = Auth::guard('api')->user();
            $User->api_token = $token;

            if (!$this->CheckUserRole($User))
                return $this->Error("Invalid", 401);

    
            unset($User->password);
            $data['isActive'] = 1;
                    
        
            $user = User::findOrFail($User->id);
            $user->fill($data)->save();

            $message = "login successfully ";
            return $this->Data('User', ["User" => $User, "lang" => $this->lang()], $message, 200);
        } catch (\Exception $ex) {
            return $this->Error($ex->getMessage(), 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    private function arrayValidator($type){

        $rules = [
            'name'            => ['required', 'string'],
            'email'           => ['required', 'string' ,'unique:users'],
            'configPass'      => ['required', 'string'],
            'password'        => ['required_with:configPass','same:configPass'],
            'phone'           => ['required'],

        ];
        if($type == 'user'){
            
            $rules['gender'] =['required'];
            $rules['birthday'] =['required'];
            $rules['profile_picture'] =['required'];


        }elseif($type  == 'team'){
            
            $rules['foundation_year'] =['required'];
            $rules['shortened_name'] =['required'];
            $rules['team_uniform'] =['required'];
            $rules['team_color'] =['required'];
            $rules['country'] =['required'];
            $rules['coach'] =['required'];
            $rules['official_site'] =['required'];
            $rules['owner'] =['required'];
            $rules['sports_director'] =['required'];
            
           
        }
       return  $rules;
    }
    



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $array_Role = array("team","user");
            
             $type =($request->has('type'))?$request->input('type'):null;
             $rules =  $this->arrayValidator($request->input('type'));
             $Role =null;
             if(in_array($type,$array_Role))
                $Role = Role::where('name','=',$type)->first();
             else
               return $this->Error("is not valid data type to user ", 401);
            $role_id = (int)$request->input('role_id');
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) 
                return $this->Error($validator->errors()->first(), 401);
            
            if (!$this->validEmail($request->input("email")))
                return $this->Error("Invalid email address", 401);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $Role->id,
                'phone' => $request->input('phone'),
            ]);


           if($type == 'team'){

             $user->Team = Team::create([
                                        'foundation_year' => $request->input('foundation_year'),
                                        'shortened_name' => $request->input('shortened_name'),
                                        'team_uniform' =>  $request->input('team_uniform'),
                                        'team_color' => $request->input('team_color'),
                                        'country' => $request->input('country'),
                                        'coach' => $request->input('coach'),
                                        'official_site' => $request->input('official_site'),
                                        'owner' => $request->input('owner'),
                                        'sports_director' => $request->input('sports_director'),
                                        'user_id' =>$user->id
                                    ]);

           }elseif($type == 'user'){

                $user->Public = UserPublic::create([
                                                'gender' => $request->input('gender'),
                                                'birthday' => $request->input('birthday'),
                                                'profile_picture' => $request->input('profile_picture'),
                                                'user_id' =>$user->id
                                                ]);

           }
           $collection = $request->only(['email', 'password']);

            $token = Auth::guard('api')->attempt($collection);
            $user->api_token = $token;

            if (!$this->CheckUserRole($user))
                return $this->Error("Invalid", 401);
            
            $message = "register successfully";
  
            return $this->Data('Data', ["User" => $user, "lang" => $this->lang()], $message, 200);
         } catch (\Exception $ex) {
            return $this->Error($ex->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
