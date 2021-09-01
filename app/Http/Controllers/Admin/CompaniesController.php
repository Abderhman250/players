<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Storage;
class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Company  =  Company::all();
        return view('admin.user_compan.index', ['Company' => $Company]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_compan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    private function arrayValidator()
    {
          $rules = [
            'name'                 => ['required', 'string'],
            'email'                => ['required', 'string', 'unique:users'],
            'ConfigPassword'       => ['required', 'string', 'min:8'],
            'password'             => ['required_with:ConfigPassword', 'same:ConfigPassword', 'min:8'],
            'phone'                => ['required'],
            'logo'                 => ['required'],
            'Foundation_year'      => ['required'],
            'brands'               => ['required'],
            'Branch_Locations'     => ['required'],

        ];

        return  $rules;
    }

    public function store(Request $request)
    {
        //
      try {


            $gender  =  array("Female", "Male");
            $type = ($request->has('type')) ? $request->input('type') : null;
            $rules =  $this->arrayValidator();
            $Role = null;

            $Role = Role::where('name', '=', 'company')->first();


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                session()->flash('errors', $validator->errors()->first());
                return back();
            }

            // if (!$this->validEmail($request->input("emails"))) {
            //     session()->flash('errors', 'Invalid email address');
            //     return back();
            // }
            if (!empty($request->file('logo'))) {


                $file = $request->file('logo');
                $file_name = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = $file->storeAs('uploades/', $file_name);
                $logo =  Storage::disk('local')->url($file_name);
            } else {
                $logo = null;
            }
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $Role->id,
                'phone' => $request->input('phone'),
            ]);


            $Company = Company::create([
                'logo' => $logo,
                'Foundation_year' => $request->input('Foundation_year'),
                'brands' => $request->input('brands'),
                'Location' => $request->input('Location'),
                'Branch_Locations' => $request->input('Branch_Locations'),
                'user_id' => $user->id,
            ]);

            if (!$this->CheckUserRole($user)) {
                session()->flash('errors', 'Invalid');
                return back();
            }

            $message = "register successfully";




            return redirect('/companie');
        } catch (\Exception $ex) {
            if (isset($Company->id))
                $Company->delete();

            if (isset($user->id))
                $user->delete();

            session()->flash('errors', 'MESSING ERROR');
            return back();
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
