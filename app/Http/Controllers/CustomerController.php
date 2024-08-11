<?php

namespace App\Http\Controllers;

use App\Models\TaskFiles;
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



class CustomerController extends BaseController
{
    public function getCustomer()
    {
        return view('customer');
    }
    public function getCustomers()
    {

        $customers = Customer::paginate(10);

        return view('customers', ['customers' => $customers]);
    }

    public function getCustomerById($id)
    {
        $customer = Customer::find($id);

        return view('customer', ['customer' => $customer]);
    }

    public function updateCustomerStatus(Request $request)
    {
        try {
            Customer::find($request->id)->update([
                'updated_at' => Carbon::now(),
                'status' => $request->status
            ]);


            return back()->with('message', 'Customer Status Update Successfully!');
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

    public function saveCustomer(Request $request, $id = null)
    {
        if ($id == null) {
            $validatedData = $request->validate(
                [
                    'name' => 'required',
                    'phone' => 'required',
                    'mail' => 'required'
                ],
                [
                    'name.required' => 'Please Input Name.',
                    'phone.required' => 'Please Input Phone.',
                    'mail.required' => 'Please Input Mail.'
                ]
            );
            try {
                $customer = new Customer();
                $customer->name = $request->name;
                $customer->phone = $request->phone;
                $customer->mail = $request->mail;
                $customer->address = $request->address;
                $customer->status = 1;
                $customer->save();
                return redirect()->back()->with('message', 'Customer Save Successfully!');
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
                Customer::find($id)->update([
                    'name' => $request->name,
                    'phone' =>  $request->phone,
                    'mail' =>  $request->mail,
                    'address' =>  $request->address,
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->back()->with('message', 'Customer Update Successfully!');
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
    }
}
