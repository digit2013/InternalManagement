<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use App\Models\Role;
use App\Models\HeadOffice;
use App\Models\Department;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use app\Helper;
use App\Models\Annoucement;
use App\Models\Product;
use App\Models\TaskDetail;
use App\Models\TaskFiles;
use App\Models\TaskHead;
use App\Models\User;

class help
{
    public static function getTopWidget(){
        if(Session::get('isAdmin')==1){
            $userCount = User::where('status',1)->count();
        }else{
            $userCount = User::where('d_id',Session::get('user')->d_id)->count();
        }
        $overdueTaskCount = TaskDetail::where('status',3)->where('u_id',Session::get('user')->id)->count();
        $pendingTaskCount = TaskDetail::where('status',2)->where('u_id',Session::get('user')->id)->count();
        $newTaskCount = TaskDetail::where('status',1)->where('u_id',Session::get('user')->id)->count();
        $completeTaskCount = TaskDetail::where('status',4)->where('u_id',Session::get('user')->id)->count();

        $productCount = Product::where('status',1)->count();
        return array(['userCount'=>$userCount,'productCount'=>$productCount,'overdueTaskCount'=>$overdueTaskCount,'pendingTaskCount'=>$pendingTaskCount,
    'newTaskCount'=>$newTaskCount,'completeTaskCount'=>$completeTaskCount]);
    }
    public static function getFileList($t_id)
    {

        return $task_details = TaskFiles::where('t_id', $t_id)->get();
    }
    public static function getTaskDetailList()
    {

        return $task_details = TaskDetail::where('u_id', Session::get('user')->id)->paginate(2);
    }
    public static function getUser($u_id)
    {
        return $task_details =  DB::table('users')->find($u_id);
    }
    public static function getAssignedBy($t_id)
    {
        return $task_head = DB::table('task_heads')->find($t_id);
    }
    public static function getAssignedByUser($user_id, $status)
    {
        return DB::table('task_details')
            ->join('task_heads', 'task_details.t_id', '=', 'task_heads.id')
            ->join('users', 'users.id', '=', 'task_details.u_id')
            ->where('task_heads.created_by', $user_id)
            ->where('task_details.status', $status)
            ->select('task_details.id as id', 'task_details.name', 'task_details.description', 'task_details.assign_start_date', 'task_details.assign_end_date', 'task_details.status', 'task_details.finish_end_date', 'task_details.finish_start_date', 'users.name as assigned_member')
            ->paginate(10);
    }
}
class HomeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function home()
    {
        if (Session::get('user') == null) {
            return view('login');
        } else {
            $overdueTaskCount = TaskDetail::where('status',3)->where('u_id',Session::get('user')->id)->count();
            $pendingTaskCount = TaskDetail::where('status',2)->where('u_id',Session::get('user')->id)->count();
            $newTaskCount = TaskDetail::where('status',1)->where('u_id',Session::get('user')->id)->count();
            $completeTaskCount = TaskDetail::where('status',4)->where('u_id',Session::get('user')->id)->count();
            return view('home',compact('newTaskCount', 'pendingTaskCount','overdueTaskCount','completeTaskCount'))->with('helper', new help);
        }
    }
}
