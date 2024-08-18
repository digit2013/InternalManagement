<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\Role;
use App\Models\HeadOffice;
use App\Models\Department;
use App\Models\MeetingMinute;
use App\Models\User;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
class help
{
        public static function getUserName($u_id)
        {


                return DB::table('users')->find($u_id);
        }
        public static function getRole($id){
                return Role::find($id);
        }
        public static function getAllRolesById($rid)
        {
                $role_hierarchy = DB::select('SELECT t2.id, GROUP_CONCAT(t2.r ORDER BY t2.lvl DESC) as parent_role
FROM (
  SELECT id, r, lvl
  FROM (
    SELECT
      t0.r_init AS id,
      @r := IF(t0.reset_r = 1, t0.r_init, 
                (select parent from roles where id = @r)) AS r,
      @l := IF(t0.reset_r = 1, 1, @l + 1) AS lvl
    FROM 
      (SELECT m0.id as counter, m1.id AS r_init,
         ((SELECT min(id) FROM roles) = m0.id) AS reset_r 
       FROM roles m0, roles m1
       ORDER BY r_init, counter
      ) t0 
    ORDER BY t0.r_init, t0.counter
  ) t1
  WHERE r <> 0
) t2
where t2.id = '.$rid.'
GROUP BY t2.id;');
                return $role_hierarchy;
        }
        
}
class SetupController extends Controller
{
        public function getMeetingMinutes()
        {
                $minutes = MeetingMinute::paginate(10);
    
                return view('meeting-minutes', compact('minutes'))->with('helper', new help);
    
        }
    public function getRoles()
    {
            $roles = Role::where('status',1)->paginate(10);

            return view('roles', compact('roles'))->with('helper', new help);

    }
   
    public function getOffices()
    {
            $hos = HeadOffice::where('status',1)->paginate(10);

            return view('hos', compact('hos'));

    }
    public function getDepts()
    {
            $depts = DB::table('departments')
            ->join('branchs', 'branchs.id', '=', 'departments.b_id')
            ->join('headoffices', 'headoffices.id', '=', 'departments.h_id')
            ->select('departments.id', 'departments.name', 'departments.location','departments.description','branchs.id as b_id','branchs.name as b_name','headoffices.id as h_id','headoffices.name as h_name', 'departments.created_at', 'departments.updated_at', 'departments.status')
            ->paginate(10);

            return view('depts', compact('depts'));

    }
    public function getBranchs()
    {
            $branchs = DB::table('branchs')
            ->join('headoffices', 'headoffices.id', '=', 'branchs.h_id')
            ->select('branchs.id', 'branchs.name', 'branchs.location','branchs.description','headoffices.id as h_id','headoffices.name as h_name', 'branchs.created_at', 'branchs.updated_at', 'branchs.status')
            ->paginate(10);

            return view('branchs', compact('branchs'));

    }
    

    public function saveRole(Request $request,$id=null)
    {
        
        if($id == null){
                $validatedData = $request->validate(
                        [
                            'name' => 'required|min:3|max:50',
                            'description' => 'required|min:3|max:50',

                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 3 characters.',
                            'name.max' => 'Name must be at most 50 characters.',
                            'description.required' => 'Please Input Name.',
                            'description.min' => 'Name must be at least 3 characters.',
                            'description.max' => 'Name must be at most 20 characters.',
                        ]
                    );
                    try {
                    $roleData = new Role();
                    $roleData->name = $request->name;
                    $roleData->description = $request->description;
                    $roleData->isAdmin = $request->has('isAdmin')==true ? 1:0;
                    $roleData->parent =  empty($request->get('parent')) ? 0:$request->get('parent');
                    $roleData->status = 1;
                    $roleData->save();
                    return redirect()->back()->with('message', 'Role Save Successfully!');
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
                Role::find($id)->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'parent' => empty($request->get('parent')) ? 0:$request->get('parent'),
                        'isAdmin' => $request->has('isAdmin')==true ? 1:0,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Role Update Successfully!');
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
   
    public function getRole()
    {   
        $roles = Role::where('status',1)->get();
        return view('role',compact('roles'));

    }
    public function getMeetingMinute()
    {   
        $users = DB::table('users')
        ->join('departments', 'departments.id', '=', 'users.d_id')
        ->join('branchs', 'users.b_id', '=', 'branchs.id')
        ->join('headoffices', 'users.h_id', '=', 'headoffices.id')
        ->select('users.id as id', 'users.name', 'headoffices.name as hname', 'branchs.name as bname', 'departments.name as dname')->get();        
        return view('/meeting-minute',compact('users'))->with('helper', new help);

    }
    public function getRoleById($id)
    {
        $roles = Role::where('status',1)->get();

        $role = DB::table('roles')->find($id);
        return View::make('/role', compact('role','roles'));

    }
    public function getMeetingMinuteById($id)
    {
                $minute = MeetingMinute::find($id);
        $users = DB::table('users')
        ->join('departments', 'departments.id', '=', 'users.d_id')
        ->join('branchs', 'users.b_id', '=', 'branchs.id')
        ->join('headoffices', 'users.h_id', '=', 'headoffices.id')
        ->select('users.id as id', 'users.name', 'headoffices.name as hname', 'branchs.name as bname', 'departments.name as dname')->get();    
        return View::make('/meeting-minute', ['minute' => $minute, 'users' => $users]);

    }
    public function getHo()
    {
        return view('ho');

    }
    public function getHoById($id)
    {
        $ho = DB::table('headoffices')->find($id);
        return View::make('ho', compact('ho'));

    }

    public function saveHo(Request $request,$id=null)
    {
        if($id == null){
                $validatedData = $request->validate(
                        [
                            'name' => 'required|min:3|max:20',
                            'location' => 'required|min:3|max:50',
                            'description' => 'required|min:3|max:50',

                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 3 characters.',
                            'name.max' => 'Name must be at most 20 characters.',
                            'location.required' => 'Please Input Name.',
                            'location.min' => 'Name must be at least 3 characters.',
                            'location.max' => 'Name must be at most 50 characters.',
                            'description.required' => 'Please Input Name.',
                            'description.min' => 'Name must be at least 3 characters.',
                            'description.max' => 'Name must be at most 50 characters.',
                        ]
                    );
                    try {
                    $hoData = new HeadOffice();
                    $hoData->name = $request->name;
                    $hoData->location = $request->location;
                    $hoData->description = $request->description;
                    $hoData->status = 1;
                    $hoData->save();
                    return redirect()->back()->with('message', 'Head Office Save Successfully!');
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
                        HeadOffice::find($id)->update([
                        'name' => $request->name,
                        'location' => $request->location,
                        'description' => $request->description,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Head Office Update Successfully!');
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
    public function saveMeetingMinute(Request $request,$id=null)
    {

        if($id == null){
                // $validatedData = $request->validate(
                //         [
                //                 'host' => 'gt:0',
                //                 'attendees' => 'gt:0',
                //                 'description' => 'required|min:10',

                //         ],
                //         [
                //             'host.gt:0' => 'Select Host.',
                //             'attendees.gt:0' => 'Select Attendees.',
                //             'description.require' => 'Please Input Meeting Minute Detail.',
                           
                //         ]
                //     );
                    try {
                    $minute = new MeetingMinute();
                    $minute->meeting_date = $request->meeting_date;
                    $minute->description = $request->description;
                    $minute->host = $request->get('host');
                    $minute->attendees = implode(',',$request->attendees);
                    $minute->status = 1;
                    $minute->save();
                    return redirect()->back()->with('message', 'Meeting Minute Save Successfully!');
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
                        MeetingMinute::find($id)->update([
                        'meeting_date' => $request->meeting_date,
                        'host' =>  $request->get('host'),
                        'attendees'  => implode(',',$request->attendees),
                        'description' => $request->description,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Meeting Minute Update Successfully!');
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

    public function getBranch()
    {
        $hos['headoffices'] = HeadOffice::get(["name", "id"]);
        return view('branch',$hos);

    }
    public function getBranchById($id)
    {
        $headoffices = HeadOffice::get(["name", "id"]);
        $branch = DB::table('branchs')->find($id);
        return view('branch', ['branch' => $branch, 'headoffices' => $headoffices]);
    }

    public function saveBranch(Request $request,$id=null)
    {


        if($id == null){
                $validatedData = $request->validate(
                        [
                            'name' => 'required|min:3|max:20',
                            'headoffice' => 'gt:0',
                            'location' => 'required|min:3|max:50',
                            'description' => 'required|min:3|max:50',
                        
                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 3 characters.',
                            'name.max' => 'Name must be at most 20 characters.',
                            'headoffice.gt:0' => 'Select Head Office.',
                            'location.required' => 'Please Input Name.',
                            'location.min' => 'Name must be at least 3 characters.',
                            'location.max' => 'Name must be at most 50 characters.',
                            'description.required' => 'Please Input Name.',
                            'description.min' => 'Name must be at least 3 characters.',
                            'description.max' => 'Name must be at most 50 characters.',
                        ]
                    );
                    try {
                    $branchData = new Branch();
                    $branchData->name = $request->name;
                    $branchData->h_id = $request->get('headoffice');
                    $branchData->location = $request->location;
                    $branchData->description = $request->description;
                    $branchData->status = 1;
                    $branchData->save();
                    return redirect()->back()->with('message', 'Branch Save Successfully!');
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
                        Branch::find($id)->update([
                        'name' => $request->name,
                        'h_id' => $request->get('headoffice'),
                        'location' => $request->location,
                        'description' => $request->description,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Branch Update Successfully!');
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


    public function getDept()
    {
        $hos = HeadOffice::get(["name", "id"]);
        $branchs= Branch::get(["name", "id"]);

        return view('dept', ['branchs' => $branchs, 'headoffices' => $hos]);

    }
    public function getDeptById($id)
    {
        $headoffices = HeadOffice::get(["name", "id"]);

        $dept = DB::table('departments')->find($id);
        $branchs = Branch::where('h_id',$dept->h_id)->get(["name", "id"]);
        
        return view('dept', ['dept' => $dept, 'headoffices' => $headoffices,'branchs' => $branchs]);
    }

    public function saveDept(Request $request,$id=null)
    {


        if($id == null){
                $validatedData = $request->validate(
                        [
                            'name' => 'required|min:2|max:20',
                            'headoffice' => 'gt:0',
                            'branchs' => 'gt:0',
                            'location' => 'required|min:3|max:50',
                            'description' => 'required|min:3|max:50',
                        
                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 2 characters.',
                            'name.max' => 'Name must be at most 20 characters.',
                            'headoffice.gt:0' => 'Select Head Office.',
                            'branchs.gt:0' => 'Select Branch.',
                            'location.required' => 'Please Input Name.',
                            'location.min' => 'Name must be at least 3 characters.',
                            'location.max' => 'Name must be at most 50 characters.',
                            'description.required' => 'Please Input Name.',
                            'description.min' => 'Name must be at least 3 characters.',
                            'description.max' => 'Name must be at most 50 characters.',
                        ]
                    );
                    try {
                    $deptData = new Department();
                    $deptData->name = $request->name;
                    $deptData->h_id = $request->get('headoffice');
                    $deptData->b_id = $request->get('branchs');
                    $deptData->location = $request->location;
                    $deptData->description = $request->description;
                    $deptData->status = 1;
                    $deptData->save();
                    return redirect()->back()->with('message', 'Department Save Successfully!');
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
                        Department::find($id)->update([
                        'name' => $request->name,
                        'h_id' => $request->get('headoffice'),
                        'b_id' => $request->get('branchs'),
                        'location' => $request->location,
                        'description' => $request->description,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Department Update Successfully!');
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


    
    public function fetchBranchs(Request $request)
    {
        $data['branchs'] = Branch::where("h_id", $request->h_id)
        ->get(["name", "id"]);
        return response()->json($data);
    }
    public function fetchDepts(Request $request)
    {
        $data['depts'] = Department::where("h_id", $request->h_id)->where("b_id", $request->b_id)
        ->get(["name", "id"]);
        return response()->json($data);
    }
}
