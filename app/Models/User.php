<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Dispatcher; 
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;
use \Exception;
use \Session;
use \Crypt;

/**
 * @property int $id
 * @property int $role_id
 * @property int $city_id
 * @property int $district_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property float $scout
 * @property int $block
 * @property int $isActive
 * @property string $forgot_code
 * @property string $api_token
 * @property string $fcm_tocken
 * @property string $created_at
 * @property string $updated_at
 * @property City $city
 * @property District $district
 * @property UserRole $userRole
 * @property Click[] $clicks
 * @property Medicine[] $medicines
 * @property Reservation[] $reservations
 * @property Reservation[] $reservations
 */
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    /**
     * @var array
     */
    protected $fillable = ['role_id', 'name', 'email','password','phone', 'isActive','forgot_code', 'api_token', 'created_at', 'updated_at'];



    

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function userRole()
    // {
    //     return $this->belongsTo('App\Models\UserRole', 'role_id');
    // }








     //login 
    public static function login($email,$password){

        try {    

           $email = $email;
           $password = $password;

            //$filter =  filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            if(Auth::attempt(['email' => $email , 'password' => $password])){
       
                if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
               
                    // if (Auth::user()->isVerified == 0) {

                    //     session()->flash('error', 'لم يتم التحقق من الحساب');
                    //     return redirect()->back();
                    // }

                    $data['isActive'] = 1;
                    
              

                 $user = User::findOrFail(Auth::id());
                 $user->fill($data)->save();
    

                 return view('admin.dashboard');

                } else{
            
                   session()->flash('errors', 'Incorrect username or password');
                   return false; 
                }

            }else{

                session()->flash('errors', 'Incorrect username or password');
                return false; 
            }


        } catch (Exception $e) {

          report($e);
          return $e->getMessage();
        }

    }


    //logout
    public static function logout(){

       
        $isactive['isActive'] = 0;
        $user = User::findOrFail(Auth::id());
        $user->fill($isactive)->save();

        Session::flush(); // remove session
        return redirect('/');
        

    }

    public static function block($id){

        $user = User::findOrFail($id);

        if ($user->block == 1) {

            $userdata['block'] = 0;
            $user->fill($userdata)->save();
            session()->flash('success2' , trans('messages.user_unblock_successfully'));
            return redirect()->route('users.index');

        }else{

             $userdata['block'] = 1;
             $user->fill($userdata)->save();
             session()->flash('success' , trans('messages.user_block_successfully'));
             return redirect()->route('users.index');

        }

    }

}

