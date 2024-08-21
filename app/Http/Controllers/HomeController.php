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
use App\Models\Stock;
use App\Models\Invoice;
use App\Models\MeetingMinute;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
class help
{

    public static function getCategoryPerProducts()
    {
        return  DB::select('SELECT A.name, CASE WHEN B.products is null THEN 0 ELSE B.products END as products FROM categories as A
left join (select c_id , count(1) as products from products group by c_id) B on A.id = B.c_id;');
    }

    public static function getTopRole()
    {
        return DB::table('roles')->where('parent', 0)->get();
    }
    public static function getChildRole($id)
    {
        return DB::table('roles')->where('parent', $id)->get();
    }
    public static function getPrice($price_type, $stock_id)
    {
        return DB::table('prices')->where('stock_id', $stock_id)->where('price_type', $price_type)->get();
    }
    public static function getProductImage($p_id)
    {
        return DB::table('product_images')->where('p_id', $p_id)->get();
    }
    public static function getTopWidget()
    {
        if (Session::get('isAdmin') == 1) {
            $userCount = User::where('status', 1)->count();
        } else {
            $userCount = User::where('d_id', Session::get('user')->d_id)->count();
        }
        $overdueTaskCount = TaskDetail::where('status', 3)->where('u_id', Session::get('user')->id)->count();
        $pendingTaskCount = TaskDetail::where('status', 2)->where('u_id', Session::get('user')->id)->count();
        $newTaskCount = TaskDetail::where('status', 1)->where('u_id', Session::get('user')->id)->count();
        $completeTaskCount = TaskDetail::where('status', 4)->where('u_id', Session::get('user')->id)->count();

        $productCount = Product::where('status', 1)->count();
        return array([
            'userCount' => $userCount,
            'productCount' => $productCount,
            'overdueTaskCount' => $overdueTaskCount,
            'pendingTaskCount' => $pendingTaskCount,
            'newTaskCount' => $newTaskCount,
            'completeTaskCount' => $completeTaskCount
        ]);
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
    public function dataCollection()
    {

        $persons = DB::table('person')->get();
        $comesticsRaw = File::json('comestic/comestic.json');
        $categories = [];
        $brands = [];
        $i=0;$j=0;
        $brandBase = [];
        $cateBase = [];
        foreach(collect($comesticsRaw)->groupBy('Category') as $c => $cate){
            $categories[]=$c;
        }
        $comesticsByBrand = collect($comesticsRaw)->groupBy('Brand');
        foreach($comesticsByBrand as $b => $brand){
            $brands[]=$b;
            $cateBase[$j]['name']=$b;
            $data = [];
            foreach($categories as $c){
                $data []= collect($brand)->where('Category',$c)->count();
            }
            $cateBase[$j]['data']=$data;
            $j++;
        }
        $comesticsByCate = collect($comesticsRaw)->groupBy('Category');
        foreach($comesticsByCate as $c => $cate){
            $brandBase[$i]['name']=$c;
            $data = [];
            foreach($brands as $b){
                $data []= collect($cate)->where('Brand',$b)->count();
            }
            $brandBase[$i]['data']=$data;
            $i++;
        }
     
        return view('data-collection', compact('persons', 'brandBase','categories','brands','cateBase'))->with('helper', new help);
    }
    public function home()
    {
        if (Session::get('user') == null) {
            return view('login');
        } else {
            $branchCount = Branch::where('status', 1)->count();
            $deptCount = Department::where('status', 1)->count();
            $minutes = MeetingMinute::get();
            $overdueTaskCount = TaskDetail::where('status', 3)->where('u_id', Session::get('user')->id)->count();
            $pendingTaskCount = TaskDetail::where('status', 2)->where('u_id', Session::get('user')->id)->count();
            $newTaskCount = TaskDetail::where('status', 1)->where('u_id', Session::get('user')->id)->count();
            $completeTaskCount = TaskDetail::where('status', 4)->where('u_id', Session::get('user')->id)->count();
            $products = DB::table('products')
                ->join('categories', 'categories.id', '=', 'products.c_id')
                ->select('products.id', 'products.name', 'products.description', 'categories.name as cname')->get();

            return view('home', compact('newTaskCount', 'pendingTaskCount', 'overdueTaskCount', 'completeTaskCount', 'products', 'branchCount', 'deptCount', 'minutes'))->with('helper', new help);
        }
    }

    public function inventoryData() {}
    public function salesData() {}
}
