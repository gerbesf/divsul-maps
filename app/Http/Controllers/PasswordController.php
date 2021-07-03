<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function doChangePassword(){

        $password = request()->get('password');
        $password_confirmed = request()->get('password_confirmed');

        $change = true;

        if($password!=$password_confirmed){
            echo 'Password not match'.PHP_EOL;
            $change = false;
        }

        if(strlen($password_confirmed)<=5){
            echo 'Password is weak'.PHP_EOL;
            $change = false;
        }

        if($change){
            $id = Auth::user()->id;
            User::where('id',$id)->update([
                'password'=>\Hash::make(request()->get('password'))
            ]);
            return redirect(route('profile').'?message=PasswordUpdated');
        }

    }
}
