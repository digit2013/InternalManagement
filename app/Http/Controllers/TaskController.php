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
use app\Helper;
use App\Models\Annoucement;
use App\Models\TaskDetail;
use App\Models\TaskHead;
use App\Models\User;
use Illuminate\Support\Facades\File;
class help
{
        public static function getTaskDetailList($t_id)
        {


                return $task_details = TaskDetail::where('t_id', $t_id)->get();
        }
        public static function getUserName($u_id)
        {


                return $task_details =  DB::table('users')->find($u_id);
        }
}
class TaskController extends Controller
{
     
        public function attachmentStore(Request $request, int $taskId)
        {
    
            // $request->validate([
            //     'images.*' => 'required|image|mimes:png,jpg,jpeg,webp'
            // ]);
            $task_detail = TaskDetail::findOrFail($taskId);
            $attachData = [];
            if($files = $request->file('taskAttach')){
    
                    foreach($files as $key => $file){
        
                        $extension = $file->getClientOriginalExtension();
                        $filename = $key.'-'.time(). '.' .$extension;
        
                        $path =  "uploads/tasks/";
        
                        $file->move($path, $filename);
        
                        DB::table('task_files')->insert([
                            't_id' => $taskId,
                            'file_url' => $path.$filename
                        ]);
                    }
                }
            return redirect()->back()->with('status', 'Uploaded Successfully');
        }
       
        public function getAssignments(){
                
        }
    
        public function destroy(int $fileId)
        {
                $tfile = DB::table('task_files')->where('id',$fileId)->first();
                if(File::exists($tfile->file_url)){
                    File::delete($tfile->file_url);
                }
                DB::table('task_files')->where('id',  $fileId)->delete();
        
        
                return redirect()->back()->with('status', 'File Deleted');
        }
        public function getTasks()
        {
                $task_heads = TaskHead::where('status', 1)->paginate(10);
                $users = DB::table('users')
                        ->join('departments', 'departments.id', '=', 'users.d_id')
                        ->join('branchs', 'users.b_id', '=', 'branchs.id')
                        ->join('headoffices', 'users.h_id', '=', 'headoffices.id')
                        ->select('users.id as id', 'users.name', 'headoffices.name as hname', 'branchs.name as bname', 'departments.name as dname')->get();
                $task_details = TaskDetail::get();
                return view('tasks', compact('task_heads', 'users', 'task_details'))->with('helper', new help);
        }
        public function deleteTask($id)
        {

                try{
                        TaskDetail::where('id',$id)->delete(); 

                       
                        return back()->with('message', 'Task Detail Update Successfully!');

                }                                        
                catch (ConnectionException $ex) {
                        Log::error($ex);
                        return back()->with('message', 'Bad Request!');
                } catch (Exception $ex) {
                        Log::error($ex);
                        return back()->with('message', 'Internal Server Error!');
                } catch (PDOException $e) {
                        return back()->with('message', 'Database Server Error!');
                }
        }
        public function getTask()
        {

                $users = DB::table('users')
                        ->join('departments', 'departments.b_id', '=', 'users.d_id')
                        ->join('branchs', 'users.b_id', '=', 'branchs.id')
                        ->join('headoffices', 'users.h_id', '=', 'headoffices.id')
                        ->select('users.id as id', 'users.name', 'headoffices.name as hname', 'branchs.name as bname', 'departments.name as dname')->get();

                return view('/task', compact('users'));
        }
        public function updateTaskDetail(Request $request, $id = null)
        {
                try{
                        
                        TaskDetail::find($id)->update([
                                'name' => $request->name,
                                'description' => $request->description,
                                'assign_start_date' => Carbon::parse(explode('-', $request->effectDate)[0]),
                                'assign_end_date' => Carbon::parse(explode('-', $request->effectDate)[1]),
                                'updated_at' => Carbon::now()
                        ]);
                        return back()->with('message', 'Task Detail Update Successfully!');

                }                                        
                catch (ConnectionException $ex) {
                        Log::error($ex);
                        return back()->with('message', 'Bad Request!');
                } catch (Exception $ex) {
                        Log::error($ex);
                        return back()->with('message', 'Internal Server Error!');
                } catch (PDOException $e) {
                        return back()->with('message', 'Database Server Error!');
                }

        }
        public function updateStatusTaskDetail(Request $request){
                try{
                        if($request->status == 2){
                                TaskDetail::find($request->id)->update([
                                        'finish_start_date'=> Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'status' => $request->get('status')
                                ]);
                        }elseif($request->status == 4){
                                TaskDetail::find($request->id)->update([
                                        'finish_end_date'=> Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                        'status' => $request->get('status')
                                ]);
                        }
                     
                        return back()->with('message', 'Task Detail Update Successfully!');

                }                                        
                catch (ConnectionException $ex) {
                        Log::error($ex);
                        return back()->with('message', 'Bad Request!');
                } catch (Exception $ex) {
                        Log::error($ex);
                        return back()->with('message', 'Internal Server Error!');
                } catch (PDOException $e) {
                        return back()->with('message', 'Database Server Error!');
                }
        }
        public function saveTaskDetail(Request $request)
        {

             
                        $validatedData = $request->validate(
                                [
                                        'name' => 'required|min:5',
                                        'description' => 'required|min:5',
                                        'effectDate' => 'required'
                                ],
                                [
                                        'name.required' => 'Please Input Name.',
                                        'name.min' => 'Name must be at least 5 characters.',
                                        'description.required' => 'Please Input description.',
                                        'description.min' => 'description must be at least 5 characters.',
                                        'effectDate.required' => 'Select Effective Date.',

                                ]
                        );
                        if (empty($request->users) && count($request->users)) {
                                return redirect()->back()->with('message', 'Need to Select User to assign!');
                        } else {
                                try {
                                        foreach ($request->users as $user) {
                                                $taskdetail = new TaskDetail();
                                                $taskdetail->t_id = $request->t_id;
                                                $taskdetail->name = $request->name;
                                                $taskdetail->description = $request->description;
                                                $taskdetail->u_id = $user;
                                                $taskdetail->assign_start_date = Carbon::parse(explode('-', $request->effectDate)[0]);
                                                $taskdetail->assign_end_date = Carbon::parse(explode('-', $request->effectDate)[1]);
                                                $taskdetail->finish_start_date = null;
                                                $taskdetail->finish_end_date = null;
                                                $taskdetail->status = 1;
                                                $taskdetail->save();
                                        }
                                        return back()->with('message', 'Task Detail Save Successfully!');
                                } catch (ConnectionException $ex) {
                                        Log::error($ex);
                                        return back()->with('message', 'Bad Request!');
                                } catch (Exception $ex) {
                                        Log::error($ex);
                                        return back()->with('message', 'Internal Server Error!');
                                } catch (PDOException $e) {
                                        return back()->with('message', 'Database Server Error!');
                                }
                        }
                
        }

        public function getTaskDetailById($id)
        {
                $users = DB::table('users')
                        ->join('departments', 'departments.b_id', '=', 'users.d_id')
                        ->join('branchs', 'users.b_id', '=', 'branchs.id')
                        ->join('headoffices', 'users.h_id', '=', 'headoffices.id')
                        ->select('users.id as id', 'users.name', 'headoffices.name as hname', 'branchs.name as bname', 'departments.name as dname')->get();
                $task_detail = DB::table('task_details')->find($id);

                return view('/task_detail', ['task_detail' => $task_detail, 'users' => $users])->with('helper', new help);
        }
        public function getTaskById($id)
        {
                // $depts = DB::table('departments')
                // ->join('branchs', 'departments.b_id', '=', 'branchs.id')
                // ->join('headoffices', 'departments.h_id', '=', 'headoffices.id')

                // ->select('departments.id as id', 'headoffices.name as hname','branchs.name as bname','departments.name as dname')->get();
                $task_head = DB::table('task_heads')->find($id);
                // $task_details = DB::table('task_heads')->where('t_id',$id)->get();

                return view('/task', ['task_head' => $task_head]);
        }

        public function saveTask(Request $request, $id = null)
        {
                if(session('user')){
                        if ($id == null) {
                                // $validatedData = $request->validate(
                                //         [
                                //                 'destination.*'  => [
                                //                         'required',
                                //                         'distinct', // members of the array must be unique
                                //                         'min:1'     // each string must have min 3 chars
                                //                 ],
                                //                 'heading' => 'required|min:10',
        
                                //         ],
                                //         [
                                //             'heading.required' => 'Please Input Name.',
                                //             'heading.min' => 'Name must be at least 10 characters.',
                                //             'heading.min' => 'Name must be at least 10 characters.',
        
                                //             'destination.*' => 'Please select Destination Departments.'
                                //         ]
                                //     );
                                try {
                                        $taskhead = new TaskHead();
                                        $taskhead->name = $request->name;
                                        $taskhead->description = $request->description;
                                        $taskhead->created_by = session('user')->id;
                                        $taskhead->updated_by = session('user')->id;
                                        $taskhead->status = 1;
                                        $taskhead->save();
                                        return redirect()->back()->with('message', 'Task Save Successfully!');
                                } catch (ConnectionException $ex) {
                                        Log::error($ex);
                                        return redirect()->back()->with('message', 'Bad Request!');
                                } catch (Exception $ex) {
                                        Log::error($ex);
                                        return redirect()->back()->with('message', 'Internal Server Error!');
                                } catch (PDOException $e) {
                                        return redirect()->back()->with('message', 'Database Server Error!');
                                }
                        } else {
                                try {
                                        TaskHead::find($id)->update([
                                                'name' => $request->name,
                                                'description' => $request->description,
                                                'updated_by' => session('user')->id,
                                                'updated_at' => Carbon::now()
                                        ]);
                                        return redirect()->back()->with('message', 'Task Update Successfully!');
                                } catch (ConnectionException $ex) {
                                        Log::error($ex);
                                        return redirect()->back()->with('message', 'Bad Request!');
                                } catch (Exception $ex) {
                                        Log::error($ex);
                                        return redirect()->back()->with('message', 'Internal Server Error!');
                                } catch (PDOException $e) {
                                        return redirect()->back()->with('message', 'Database Server Error!');
                                }
                        }
                }else{
                        return view('login');
                }
            
        }

        public function fetchUsers($deptId)
        {
                $users = DB::table('users')->where('d_id', $deptId)->get();
                return response()->json($users);
        }
}
