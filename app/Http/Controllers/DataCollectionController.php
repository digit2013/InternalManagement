<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class help{

    public static function  getCountry($country){
        $countries = File::json('geo_data/allCountries.json');
            $res = collect($countries)->where('isoCode',$country)->first();
        return $res;
    }
    public static function  getState($countryName,$countryCode,$stateCode){
        $states = File::json('geo_data/allStatesNested.geo.json');
        $state = $states[str_replace(' ','_',$countryName).'-'.$countryCode];
            $res = collect($state)->where('countryCode',$countryCode)->where('isoCode',$stateCode)->first();
        return $res;
    }

    public static function  getCities($countryName,$countryCode,$stateName,$stateCode,$cityName){
        $cities = File::json('geo_data/allCitiesNested.geo.json');
       $city = $cities[str_replace(' ','_',$countryName).'-'.$countryCode][str_replace(' ','_',$stateName).'-'.$stateCode];
       $res = collect($city)->where('countryCode',$countryCode)->where('stateCode',$stateCode)->where('name',$cityName)->first();
        return $res;
    }
}

class DataCollectionController extends BaseController
{
    public function getPerson()
    {
        $countries = File::json('geo_data/allCountries.json');
        $occupations = File::json('occupations/occupations.json');
        return view('personal-info',['countries' => $countries,'occupations'=> $occupations]);
    }
    public function getPersons()
    {
        $persons = Person::paginate(50);
        return view('personal-source', ['persons' => $persons])->with('helper', new help);
    }

    public function getPersonById($id)
    {
        $person = Person::find($id);
        $countries = File::json('geo_data/allCountries.json');
        $occupations = File::json('occupations/occupations.json');

        return view('personal-edit', ['person' => $person,'countries' => $countries,'occupations'=> $occupations]);
    }

 

    public function savePerson(Request $request, $id = null)
    {
       if(session('user')){
        if ($id == null) {
            // $validatedData = $request->validate(
            //     [
            //         'name' => 'required',
            //         'phone' => 'required',
            //         'country' => 'required',
            //         'gender' => 'gt:0',
            //         'occupation' => 'required',
            //         'age' => 'required|numeric|gt:0',
            //     ],
            //     [
            //         'name.required' => 'Please Input Name.',
            //         'phone.required' => 'Please Input Phone.',
            //         'country.required' => 'Please Select Country.',
            //         'gender.gt:0' => 'Please Select Gender.',
            //         'occupation.required' => 'Please Select Occupation.',
            //         'age.gt:0' => 'Please Valid Age.',

            //     ]
            // );
            try {
                $person = new Person();
                $person->name = $request->name;
                $person->age = $request->age;
                $person->occupation =$request->get('occupation');
                $person->gender =$request->get('gender');
                $person->material =  empty($request->get('material'))?null:$request->get('material');
                $person->countryCode =$request->get('country');
                $person->stateCode =  empty($request->get('state'))?null:$request->get('state');
                $person->city = empty($request->get('city'))?null:$request->get('city');
                $person->address = $request->address;
                $person->phonecode = $request->phonecode;
                $person->phone = $request->phone;
                $person->mail = $request->address;
                $person->avgIncome = $request->avgIncome;
                $person->currency = $request->currency;
                $person->created_by = session('user')->id;
                $person->updated_by = session('user')->id;
                $person->status = 1;
                $person->save();
                return redirect()->back()->with('message', 'Personal Information Save Successfully!');
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
                Person::find($id)->update([
                    'name' => $request->name,
                    'age' => $request->age,
                    'occupation' => $request->get('occupation'),
                    'gender' => $request->get('gender'),
                    'material' => $request->get('material'),
                    'countryCode' => $request->get('country'),
                    'stateCode' => $request->get('state'),
                    'city' => $request->get('city'),
                    'address' => $request->address,
                    'phonecode' => $request->phonecode,
                    'phone' => $request->phone,
                    'mail' => $request->mail,
                    'phone' =>  $request->phone,
                    'avgIncome' =>  $request->avgIncome,
                    'currency' =>  $request->currency,
                    'updated_by' => session('user')->id,
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->back()->with('message', 'Personal Information Update Successfully!');
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
    public function fetchStates(Request $request)
    {
        $states = File::json('geo_data/allStatesNested.geo.json');
        return response()->json((empty($states[str_replace(' ','_',$request->countryName).'-'.$request->countryCode])?null:$states[str_replace(' ','_',$request->countryName).'-'.$request->countryCode]));
    }
    public function fetchCities(Request $request)
    {
        $cities = File::json('geo_data/allCitiesNested.geo.json');
        return response()->json((empty($cities[str_replace(' ','_',$request->countryName).'-'.$request->countryCode][str_replace(' ','_',$request->stateName).'-'.$request->stateCode])? null:$cities[str_replace(' ','_',$request->countryName).'-'.$request->countryCode][str_replace(' ','_',$request->stateName).'-'.$request->stateCode]));
    }
}
