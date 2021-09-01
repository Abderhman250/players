<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Player;
use App\Models\Videos;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Player = Player::all();
        $Video =  Videos::all();

        return view('admin.user_Player.index', ['Player' => $Player, 'Video' => $Video]);
    }
    protected $footPlay = array('left', 'right');

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Player = Player::all();
        $Video =  Videos::all();

        return view('admin.user_Player.create', [
                                                'Player' => $Player,
                                                 'Video' => $Video,
                                                'footPlay' => $this->footPlay,
                                                'PlayerLocation'=> $this->PlayerLocation['en'],  'Level'=>$this->Level['en']
                                                ]);
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
            'nickname'             => ['required'],
            "gender"               => ['required'],
            "profile_picture"      => ['required', 'mimes:jpeg,bmp,png,jpg'],
            "birthday"             => ['required'],
            "position"             => ['required'],
            "weight"               => ['required'],
            "height"               => ['required'],
            "footPlay"             => ['required'],
            "living_location"      => ['required'],
            "previous_clubs"       => ['required'],
            "strength_point"       => ['required'],
            "scientificl_level"    => ['required'],
            "level"                => ['required'],


        ];

        return  $rules;
    }

    public function store(Request $request)
    {

       //
        try {
         
        $gender  =  array("Female", "Male");
        $type = ($request->has('type')) ? $request->input('type') : null;
        $footPlay = $this->footPlay;
        $rules =  $this->arrayValidator();
        $Role = null;

        $Role = Role::where('name', '=', 'player')->first();


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            session()->flash('errors', $validator->errors()->first());
            return back();
        }

        if (!$this->validEmail($request->input("email"))) {
            session()->flash('errors', 'Invalid email address');
            return back();
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $Role->id,
            'phone' => $request->input('phone'),
        ]);


        if (!empty($request->file('profile_picture'))) {


            $file = $request->file('profile_picture');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = $file->storeAs('uploades/', $file_name);
            $profile_picture =  Storage::disk('local')->url($file_name);
        }else 
            $profile_picture = null;
        

        $footPlay =   isset($footPlay[(int)$request->input('footPlay')]) ? $footPlay[(int)$request->input('footPlay')] : $footPlay[0];
        $gender = isset($gender[$request->input('gender')]) ? $gender[$request->input('gender')] : $gender[1];
        $Player = Player::create([
                                    'nickname' => $request->input('nickname'),
                                    'gender' => $request->input('gender'),
                                    'profile_picture' => $profile_picture,
                                    'birthday' => $request->input('birthday'),
                                    'height' => (int) $request->input('height'),
                                    'weight' => (int)$request->input('weight'),
                                    'position' => $request->input('position'),
                                    'footPlay' => $footPlay,
                                    'living_location' => $request->input('living_location'),
                                    'previous_clubs' => $request->input('previous_clubs'),
                                    'current_club' => $request->input('current_club'),
                                    'number_goals' => $request->input('number_goals'),
                                    'number_matches' => $request->input('number_matches'),
                                    'player_location' => $request->input('player_location'),
                                    'strength_point' => $request->input('strength_point'),
                                    'scientificl_level' => $request->input('scientificl_level'),
                                    'level' => $request->input('level'),
                                    'user_id' => $user->id,
                                ]);

        if (!$this->CheckUserRole($user)) {
            session()->flash('errors', 'Invalid');
            return back();
        }

        $message = "register successfully";
        $video =array();
        if (!empty($request->file('Video'))) {


            foreach ($request->file('Video') as $file) {
           
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = $file->storeAs('uploades/', $file_name);
            $videoName =  Storage::disk('local')->url($file_name);


            $Video = Videos::create([
                'name' => $file_name,
                'src' => $videoName,
     
                'user_id' => $user->id,
                'phone' => $request->input('phone'),
            ]);

            }
        } else {
            $video = null;
        }


        return redirect('/player');
         } catch (\Exception $ex) {
            session()->flash('errors','MESSING ERROR');
            return back();
        }
    }






    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


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
