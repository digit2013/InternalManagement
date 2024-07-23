<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Role;
use App\Models\HeadOffice;
use App\Models\Department;
use App\Models\Branch;
use App\Models\UserRole;
use Hash;
use Auth;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
class UserController extends Controller
{
  
    public function getUsers()
    {
        $users = DB::table('users')
        ->join('headoffices', 'headoffices.id', '=', 'users.h_id')
        ->join('branchs', 'branchs.id', '=', 'users.b_id')
        ->join('departments', 'departments.id', '=', 'users.d_id')
        ->join('roles', 'roles.id', '=', 'users.r_id')

        ->select('users.id', 'users.name', 'users.email','users.phone','branchs.id as b_id','branchs.name as b_name','headoffices.id as h_id','headoffices.name as h_name','departments.id as d_id','departments.name as d_name','roles.id as r_id','roles.name as r_name', 'users.created_at', 'users.updated_at', 'users.status')
        ->paginate(10);
        return view('users', compact('users'));

    }
    public function getUser()
    {
       
        $hos = HeadOffice::get(["name", "id"]);
        $branchs= Branch::get(["name", "id"]);
        $depts= Department::get(["name", "id"]);
        $roles = Role::get(["name", "id"]);

        return view('user', ['branchs' => $branchs, 'headoffices' => $hos,'depts' => $depts,'roles'=>$roles]);

    }
    public function getUserById($id)
    {
        $headoffices = HeadOffice::get(["name", "id"]);
        $user = DB::table('users')->find($id);
        $branchs = Branch::where('h_id',$user->h_id)->get(["name", "id"]);
        $depts = Department::where('h_id',$user->h_id)->where('b_id',$user->b_id)->get(["name", "id"]);
        $roles = Role::get(["name", "id"]);

        return view('user', ['user' => $user, 'headoffices' => $headoffices,'branchs' => $branchs,'depts' => $depts,'roles'=>$roles]);
    }

    public function saveUser(Request $request,$id=null)
    {

       
        if($id == null){
                $validatedData = $request->validate(
                        [
                            'name' => 'required|min:6|max:20',
                            'roles' => 'gt:0',
                            'headoffice' => 'gt:0',
                            'branchs' => 'gt:0',
                            'email' => 'required|unique:users',
                            'phone' => 'required|unique:users',
                            'password' => 'required|min:4|max:20',
                            'confrim_password' => 'required|same:password'
                        
                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 6 characters.',
                            'name.max' => 'Name must be at most 10 characters.',
                            'name.min' => 'Name must be at least 6 characters.',
                            'name.min' => 'Name must be at least 6 characters.',
                            'name.min' => 'Name must be at least 6 characters.',
                            'headoffice.gt:0' => 'Select Head Office.',
                            'branchs.gt:0' => 'Select Branch.',
                            'roles.gt:0' => 'Select Role.',
                            'depts.gt:0' => 'Select Department.',
                            'email.required' => 'Please Input Email.',
                            'phone.required' => 'Please Input Phone Number.',
                            'password.required' => 'Please Input Password.',
                            'password.min' => 'Password must be at least 8 characters.',
                            'password.max' => 'Password must be at most 20 characters.',
                            'confrim_password.required' => 'Please Input Password.',
                            'confrim_password.same' => 'Confirm password is not the same as password.',
                        ]
                    );
                    try {
                    $userData = new User();
                    $userData->name = $request->name;
                    $userData->h_id = $request->get('headoffice');
                    $userData->b_id = $request->get('branchs');
                    $userData->d_id = $request->get('depts');
                    $userData->r_id = $request->get('roles');
                    $userData->email = $request->email;
                    $userData->phone = $request->phone;
                    $userData->address = $request->address;
                    $userData->password = $request->password;
                    $userData->status = 1;
                    $userData->save();
                    return redirect()->back()->with('message', 'User Save Successfully!');
                    }catch (ConnectionException $ex) {
                        Log::error($ex);
                        return redirect()->back()->with('message', 'Bad Request!');
                } catch (Exception $ex) {
                        Log::error($ex);
                        return redirect()->back()->with('message', 'Internal Server Error!');
                } catch (PDOException $e) {
                        return redirect()->back()->with('message', 'Database Server Error!');
                }
        }else{
                try{
                        User::find($id)->update([
                        'name' => $request->name,
                        'h_id' => $request->get('headoffice'),
                        'b_id' => $request->get('branchs'),
                        'd_id' => $request->get('depts'),
                        'r_id' => $request->get('roles'),
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'User Update Successfully!');
                }catch (ConnectionException $ex) {
                        Log::error($ex);
                        return redirect()->back()->with('message', 'Bad Request!');
                } catch (Exception $ex) {
                        Log::error($ex);
                        return redirect()->back()->with('message', 'Internal Server Error!');
                } catch (PDOException $e) {
                        return redirect()->back()->with('message', 'Database Server Error!');
                }
        }
    }
    
    function login(){
        return view('login');
        
    }
    function userLogin(Request $request ){
        $user = DB::table('users')->where('email',$request->email)->first();
        if (Hash::check($request->input('password'), $user->password)) {
            Session::put('user',$user);
            $isAdmin = Role::find($user->r_id)->first();
            Session::put('isAdmin',$isAdmin->isAdmin);
            
            return redirect()->intended('/');
        }else{
            return redirect("login")->withSuccess('Login details are not valid');
        } 
    }
 
}
