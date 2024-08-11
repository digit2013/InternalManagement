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
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDOException;
use Illuminate\Support\Carbon;


class help
{
    public static function getDiscounts(){
        $total  = 0;
        if(!empty(session()->get('cart'))){
            foreach(session()->get('cart') as $c){
                $total += ($c['price'] * $c['quantity']);
            }
            $discounts = DB::table('discounts')->where('fr_price','<=',$total)->where('to_price','>=',$total)->where('status',1)->get();
            return $discounts;
        }
    }
    public static function getProductImage($p_id)
    {


        return $productImages = DB::table('product_images')->where('p_id', $p_id)->first();
    }
    public static function getUserName($u_id)
    {


        return $task_details =  DB::table('users')->find($u_id);
    }
}
class StockController extends BaseController
{
    public function showCartTable()
    {
        $products = Product::all();

        return view('cart', compact('products'));
    }
    public function customToCart($id,$q){
        $product = Product::find($id);

        if (!$product) {
            return false;
        }
        $cart = session()->get('cart');

        if (isset($cart[$id])) {

            $cart[$id]['quantity'] = $q;
            session()->put('cart', $cart);
            return true;

        }

    }
    public function addToCart($id)
    {
        $product = Product::find($id);

        if (!$product) {

            abort(404);
        }
        $cart = session()->get('cart');

        if (!$cart) {

            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "photo" => $product->photo
                ]
            ];

            session()->put('cart', $cart);
            return redirect()->back()->with('success','Product added to cart successfully!');

        }

        if (isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);
            return redirect()->back()->with('success','Product added to cart successfully!');

        }
      

        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        session()->put('cart', $cart);
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Product added to cart successfully!']);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function minusToCart($id)
    {
        $product = Product::find($id);

        if (!$product) {

            abort(404);
        }
        $cart = session()->get('cart');

        if (isset($cart[$id])) {


            if($cart[$id]['quantity'] == 1){
                unset($cart[$id]);
            }else{
                $cart[$id]['quantity']--;
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product reduce item from cart successfully!');
        }
    }
    public function removeCartItem(Request $request)
    {
        if ($request->id) {

            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back();
    }

    public function pos()
    {
        $products = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.c_id')
            ->join('units', 'units.id', '=', 'products.u_id')
            ->select('products.id as id', 'products.price', 'products.name', 'products.description', 'categories.id as c_id', 'categories.name as c_name', 'units.id as u_id', 'units.description as u_name', 'products.created_at', 'products.updated_at', 'products.status')
            ->paginate(10);
        return view('pos', ['products' => $products])->with('helper', new help);
    }
    public function getDiscount()
    {
        return view('discount');
    }
    public function getDiscounts()
    {

        $discounts = Discount::paginate(10);

        return view('discounts', ['discounts' => $discounts]);
    }

    public function getDiscountById($id)
    {
        $discount = Discount::find($id);

        return view('discount', ['discount' => $discount]);
    }

    public function updateDiscountStatus(Request $request)
    {
        try {
            Discount::find($request->id)->update([
                'updated_at' => Carbon::now(),
                'status' => $request->status
            ]);


            return back()->with('message', 'Discount Status Update Successfully!');
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

    public function saveDiscount(Request $request, $id = null)
    {
        if ($id == null) {
            $validatedData = $request->validate(
                [
                    'name' => 'required',
                    'fr_price' => 'required|numeric|gt:0',
                    'to_price' => 'required|numeric|gt:0',
                    'type' => 'gt:0',
                    'amount' => 'required|numeric|gt:0'

                ],
                [
                    'name.required' => 'Please Input Name.',
                    'fr_price.required' => 'Please Input valid amount.',
                    'fr_price.required' => 'Please Input valid amount.',
                    'type..gt:0' => 'Select Discount Type.',
                    'amount.required' => 'Please Input valid amount.',
                ]
            );
            try {
                $discount = new Discount();
                $discount->name = $request->name;
                $discount->fr_price = $request->fr_price;
                $discount->to_price = $request->to_price;
                $discount->type = $request->type;
                $discount->amount = $request->amount;
                $discount->status = 1;

                $discount->save();
                return redirect()->back()->with('message', 'Discount Save Successfully!');
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
                Discount::find($id)->update([
                    'name' => $request->name,
                    'fr_price' =>  $request->fr_price,
                    'to_price' =>  $request->to_price,
                    'type' =>  $request->type,
                    'amount' =>  $request->amount,
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->back()->with('message', 'Discount Update Successfully!');
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
