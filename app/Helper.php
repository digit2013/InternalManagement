<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Session;

class Helper
{
    public static function checkUser()
    {
        if(Session::get('user')== null){
            return false;
        }
        else{
            return true;
        }
    }
    public static function isAdmin(){
        if(Session::get('user') != null){
            return Session::get('user')->isAdmin;
        }
        else{
            return 0;
        }
    }

}