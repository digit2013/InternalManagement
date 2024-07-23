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

class AnnoucementController extends Controller
{
        public function getAnnoucements()
        {
                $depts = DB::table('departments')
                ->join('branchs', 'branchs.id', '=', 'departments.b_id')
                ->join('headoffices', 'headoffices.id', '=', 'departments.h_id')
                ->select('departments.id as id', 'departments.name', 'departments.location','departments.description','branchs.id as b_id','branchs.name as b_name','headoffices.id as h_id','headoffices.name as h_name', 'departments.created_at', 'departments.updated_at', 'departments.status')
                ->paginate(10);
                $announcesRes=[] ;
                $announces = DB::table('annoucements')->get();
                foreach($announces as $announce){
                        $deptArr=[];

                        foreach(explode(",",$announce->destination) as $des){
                               foreach($depts as $dept){
                                if($dept->id == $des){
                                        $deptArr[] = $dept->h_name . ' > ' .$dept->b_name.' > '.$dept->name;
                                }
                               }

                        }

                        $announce->deptArr = $deptArr;

                        $announcesRes[]=$announce;

                }
                return view('annoucements', ['announces' => $announcesRes, 'depts' => $depts]);

        }
  
    public function getAnnoucement()
    {
    
        $depts = DB::table('departments')
        ->join('branchs', 'departments.b_id', '=', 'branchs.id')
        ->join('headoffices', 'departments.h_id', '=', 'headoffices.id')

        ->select('departments.id as id', 'headoffices.name as hname','branchs.name as bname','departments.name as dname')->get();
            return view('annoucement', compact('depts'));

    }

    public function getAnnoucementById($id)
    {
        $depts = DB::table('departments')
        ->join('branchs', 'departments.b_id', '=', 'branchs.id')
        ->join('headoffices', 'departments.h_id', '=', 'headoffices.id')

        ->select('departments.id as id', 'headoffices.name as hname','branchs.name as bname','departments.name as dname')->get();
        $announce = DB::table('annoucements')->find($id);
        return view('/annoucement', ['announce' => $announce, 'depts' => $depts]);

    }

    public function saveAnnoucement(Request $request,$id=null)
    {
   
        if($id == null){
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
                    $announce = new Annoucement();
                    $announce->destination = implode(',',$request->destination);
                    $announce->heading = $request->heading;
                    $announce->information = $request->information;
                    $announce->created_by = session('user')->id;
                    $announce->updated_by = session('user')->id;
                    $announce->startDate = Carbon::parse(explode('-',$request->effectDate)[0]);
                    $announce->endDate = Carbon::parse(explode('-',$request->effectDate)[1]);
                    $announce->status = 1;
                    $announce->save();
                    return redirect()->back()->with('message', 'Annoucement Save Successfully!');
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
                        Annoucement::find($id)->update([
                        'name' => $request->name,
                        'destination' =>  implode(',',$request->destination),
                        'heading' => $request->heading,
                        'information' => $request->information,
                        'startDate' => Carbon::parse(explode('-',$request->effectDate)[0]),
                        'endDate' => Carbon::parse(explode('-',$request->effectDate)[1]),
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Annoucement Update Successfully!');
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

    public function fetchAnnoucements(){
        $announces = DB::table('annoucements')->whereRaw("find_in_set((".session('user')->d_id."),destination) and now() between startDate and endDate and status = 1")->get();
        return response()->json($announces);
    }
}
