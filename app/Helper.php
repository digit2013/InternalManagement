<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Session;
use App\Models\TaskDetail;
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
        public static function getTaskDetailList($t_id)
        {
        
          
                return $task_details = TaskDetail::where('t_id',$t_id)->get();
             
    
        }
}