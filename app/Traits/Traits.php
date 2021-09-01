<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
    
trait Traits
{

    public $PlayerLocation =  array(
        'en' => array(
            'A goal keeper',
            'Right-back',
            'left back',
            'defensive heart',
            'Late right wing',
            'Late left wing',
            'defensive axis',
            'middle left ',
            'middle left ',
            'advanced axis',
            'advanced middle ',
            'Right wing',
            'Left wing',
            'second attack',
            'Spearhead',

        ),
        'ar' => array(
            'حارس مرمى.',
            'ظهير أيمن',
            'ظهير أيسر',
            'قلب دفاع',
            ' جناح أيمن متأخر',
            'محور دفاعي',
            'وسط أيمن',
            'وسط أيسر',
            'محور متقدم',
            'وسط متقدم',
            'جناح الأيمن',
            'جناح أيسر',
            'هاجم ثاني',
            'رأس حربة',

        ),
        'fr' => array()

    );



    public $Level =  [
        'en' => [
            'professional',
            'regional',
            'amateur'
        ],

        'ar' => [
            'محترف',
            'جهوي',
            'هاوي',
        ],
        'fr' => [],

    ];
    public function Error($message, $numberStatus)
    {
        return response()->json([
            'status' => "Error",
            'Error' => true,
            'message' => $message
        ], $numberStatus);
    }


    public function Success($message = "", $numberStatus)
    {
        return response()->json([
            'status' => "Success",
            'Error' => false,
            "message" => $message
        ], $numberStatus);
    }

    public function Data($key, $value, $message = "", $numberStatus)
    {
        return response()->json([
            'status' => "Done",
            'Error' => false,
            $key => $value,
            "message" => $message
        ], $numberStatus);
    }

    public function CheckUserRole(&$User)
    {


        if (isset($User)) {
            $UserRole = Role::find($User->role_id);
            unset($User->role_id);
            $nameRole = (app()->getLocale() == "en") ? $UserRole->name : "";

            $User->role_Name = $nameRole;

            return true;
        } else
            return false;
    }
    public function validEmail($str)
    {
        return (preg_match("/^([\w\W])+\@([\w\W])+$/", $str)) ? TRUE : False;
    }

    public function lang()
    {
        return app()->getLocale();
    }


    public  function Decrypt(&$Decrypt)
    {

        try {
            $Decrypt = Crypt::decrypt($Decrypt);
            return true;
        } catch (DecryptException $ex) {
            //
            return false;
        }
    }
    public function encryptAllUser(&$User)
    {
        try {
            foreach ($User  as &$user) {

                $id =  encrypt($user->id);
                unset($user->id);
                $user->key_Doc = $id;
            }
            return true;
        } catch (\Exception $ex) {
            return true;
        }
    }


    public function encryptId(&$encryptId)
    {
        try {
            $id =  encrypt($encryptId->id);
            unset($encryptId->id);
            $encryptId->key_Doc = $id;
            return true;
        } catch (\Exception $ex) {
            return true;
        }
    }
    public function encrypted(&$encrypt)
    {
        try {
            $encrypt =  encrypt($encrypt);

            return true;
        } catch (\Exception $ex) {
            return true;
        }
    }


    public function validtion($request, $rules)
    {

        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            session()->flash('errors', $validator->errors()->first());
            return false;
        } else
            return true;
    }


     public function  UploadFile($file){
         
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = $file->storeAs('uploades/', $file_name);
            return   Storage::disk('local')->url($file_name);

     }
}
