<?php

namespace App\Http\Controllers;

use Exception;
use App\Library\Res;
use App\Models\User;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request)
    {
        try{
            //Validasi input
            $request->validate([
                'phone_number'=>'required',
                'password'=>'required'
            ]);

            //Mengecek credential login
            $credentials = request(['phone_number','password']);
            if(!Auth::attempt($credentials)){
                return Res::error(null,'Password atau no hanphone salah', 401);
            }

            //Jika hash tidak sesuai maka beri error
            $user = User::where('phone_number', $request->phone_number)->first();
            if(!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            //Cek akun aktif
            if($user->active ==  false){return Res::error(null,'Akun sudah tidak aktif', 401);}
            //Jika berhasil maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            //UPDATE FCM TOKEN
            $user->update([
            'fcm_token' => $request->fcm_token,
            'remember_token' => $tokenResult
            ]);
            return Res::success([
                'token' => $tokenResult,
                'user' => $user
            ], 'Aunthenticated');

        } catch(Exception $error) {
            return Res::error([
                'message' => 'Someting went wrong',
                'error' => $error
            ],'Aunthenticated Failed', 500);
        }
    }
    public function register(Request $request)
    {
        $validation =  Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|string',
                'phone_number' => 'required|unique:users,phone_number|digits_between:9,13',
                'password' => [
                    'required', 'min:6', 'max:18', Password::min(6)
                ],
                'confirm_password' => 'required|same:password',
            ],[
                'name.required' => 'Nama harus diisi',
                'phone_number.required' => 'No Handphone harus diisi',
                'password.required' => 'Password harus diisi',
                'confirm_password.required' => 'Konfirmasi Password harus diisi',
                'password.min' => 'Password minimal 6 digit',
                'phone_number.digits_between' => 'No Hanphone minimal 9 sampai 13 digit',
                'phone_number.unique' => 'No Hanphone sudah terdaftar',
                'confirm_password.same' => 'Konfirmasi password tidak sama'
            ]
        );

        if($validation->fails()){
            return Res::errorValidation($validation->errors());
        }
        // try{
            // DB::beginTransaction();
            $phone_number = $request->phone_number;
            $phoneNumber = null;
            if ($phone_number[0] == '0') {
                $phoneNumber = substr($phone_number, 1);
            } else {
                $phoneNumber = $phone_number;
            }            
            User::create([
                'name' => $request->name,
                'phone_number' => $phoneNumber,
                'password' => Hash::make($request->password),
                'active' => true
            ]);            
            $user = User::where('phone_number', $phoneNumber)->first();
            //* CREATE POINT
            Point::create(['user_id' => $user->id, 'balance' => '0']);
            $tokenResult = $user->createToken('authToken')->plainTextToken;            
            // DB::commit();
            return Res::success(['token' => 'Bearer '.$tokenResult,'user' => $user],'User Registered');
        // } catch(Exception $error){
        //     DB::rollBack();
        //     return Res::error(['message' => 'Someting went wrong',],'Aunthenticated Failed', 500);
        // }
    }
}
