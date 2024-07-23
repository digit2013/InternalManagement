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

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
class SetupController extends Controller
{
  
    public function getRoles()
    {
            $roles = Role::where('status',1)->paginate(10);

            return view('roles', compact('roles'));

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
                            'name' => 'required|min:3|max:20',
                            'description' => 'required|min:3|max:50',

                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 3 characters.',
                            'name.max' => 'Name must be at most 20 characters.',
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
        return view('role');

    }
    public function getRoleById($id)
    {
        $role = DB::table('roles')->find($id);
        return View::make('/role', compact('role'));

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
