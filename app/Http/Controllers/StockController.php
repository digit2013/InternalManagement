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
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Stock;
use App\Models\Sales;
use App\Models\StockPrice;
use App\Models\Branch;
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
    public static function getPrice($price_type,$stock_id){
        return DB::table('prices')->where('stock_id',$stock_id)->where('price_type',$price_type)->get();
    }
    public static function getCustomers(){
        return DB::table('customers')->where('status',1)->get();
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
     
        $cart = session()->get('cart');
        if (isset($cart[$id])) {

            $cart[$id]['quantity'] = $q;

            session()->put('cart', $cart);
            return true;

        }

    }
    public function addToCart($id,$sid,$pid)
    {
        $product = Product::find($id);
        $price = StockPrice::where('stock_id',$sid)->where('price_type',$pid)->first();
        if (!$product) {

            abort(404);
        }

        $cart = session()->get('cart');

        if (!$cart) {

            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $price->selling_price,
                    "photo" => $product->photo,
                    "stock" => $sid,
                    "price_type" => $pid

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
            "price" => $price->selling_price,
            "photo" => $product->photo,
            "stock" => $sid,
            "price_type" => $pid


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

    public function saleProduct(Request $request){
        if(session('user')){
            if(empty(session()->get('cart'))){
                return redirect()->back()->with('message', 'Empty Cart!');
            }
            $validatedData = $request->validate(
                [
                    'customers' => 'gt:0',
                    'commission' => 'lt:100'
                ],
                [
                    'customers.gt:0' => 'Select Customer.',
                    'commission.lt:100' => 'Commission Percent must under 100%.'
                ]
            );
            $invoiceLst = Invoice::orderBy('id', 'desc')->where('warehouse_id',Session::get('user')->b_id)->first();
            $invoiceNum = Branch::find(Session::get('user')->b_id)->description . date('Y').date('M').date('d').sprintf("%06d",1, (empty($invoiceList)? 1: $invoiceLst->id+1));
            try{
                $invoice = new Invoice();
                $invoice->warehouse_id = Session::get('user')->b_id;
                $invoice->invoice_id =  $invoiceNum;
                $invoice->customer_id =  $request->get('customers');
                $invoice->discount_id =  $request->did;
                $invoice->commission =  $request->commission;
                $invoice->price_type =  $request->pid;
                $invoice->created_by =   Session::get('user')->id;
                $invoice->updated_by =   Session::get('user')->id;
                $invoice->status =   1;
                $invoice->save();
    
                foreach(session()->get('cart') as $c){
                    $sale = new Sales();
                    $sale->warehouse_id =Session::get('user')->b_id;
                    $sale->invoice_id =$invoice->id;
                    $sale->stock_id =  $c['stock'];
                    $sale->unit_price = $c['price'];
                    $sale->qty = $c['quantity'];
                    $sale->amount = $c['price'] * $c['quantity'];
                    
                    $sale->discount_amt =$request->discountAmt;
                    $sale->created_by =Session::get('user')->id;
                    $sale->updated_by =Session::get('user')->id;
                    $sale->status = 1;
                    $sale->save();
                    
                }
                session()->forget('cart');
    
                return redirect()->back()->with('message', 'Invoice Number('.$invoiceNum.') was sold!');
    
            }catch (ConnectionException $ex) {
                Log::error($ex);
                return back()->with('message', 'Bad Request!');
            } catch (Exception $ex) {
                Log::error($ex);
                return back()->with('message', 'Internal Server Error!');
            } catch (PDOException $e) {
                return back()->with('message', 'Database Server Error!');
            }
           
        }else{
            return view('login');
        }
    
      


    }

    public function updateStocks(Request $request , $id =null){
        if(session('user')){
            $stockData = DB::table('stocks')->where('product_id',$id)->where('warehouse_id',Session::get('user')->b_id)->first();
            $stockId = 0;
            if(!empty($stockData)){
                Stock::where('product_id',$id)->where('warehouse_id',Session::get('user')->b_id)->update([
                    'qty' => $request->qty,
                    'updated_by' =>  Session::get('user')->id,
                    'updated_at' => Carbon::now()
                ]);
                $stockId=$stockData->id;
            }else{
                $stock = new Stock();
                $stock->warehouse_id = Session::get('user')->b_id;
                $stock->product_id = $id;
                $stock->qty = $request->qty;
                $stock->created_by = Session::get('user')->id;
                $stock->updated_by = Session::get('user')->id;
                $stock->save(); 
                $stockId = $stock->id;
    
            }
            $priceCount = DB::table('prices')->where('stock_id',$stockId)->where('warehouse_id',Session::get('user')->b_id)->count();
    
            if($priceCount > 0){
                foreach(config('app.selling') as $title => $value){
                    StockPrice::where('stock_id','=',$stockId)->where('price_type','=',$value)->where('warehouse_id',Session::get('user')->b_id)->update([
                        'selling_price' => $request->{$title},
                        'updated_by' =>  Session::get('user')->id,
                        'updated_at' => Carbon::now()
                    ]);
                }
               
            }else{
                foreach(config('app.selling') as $title => $value){
                    $priceInput = new StockPrice();
                    $priceInput->warehouse_id = Session::get('user')->b_id;
                    $priceInput->stock_id = $stockId;
                    $priceInput->price_type = $value;       
                    $priceInput->selling_price = $request->{$title};
                    $priceInput->created_by = Session::get('user')->id;
                    $priceInput->updated_by = Session::get('user')->id;
                    $priceInput->save();
                }
            }
            return redirect()->back()->with('message', 'Stock Update Successfully!');
    
        }else{
            return view('login');
        }
       

    }
    public function getStocks()
    {
        $products = DB::table('products')
            ->leftJoin('stocks','products.id', '=','stocks.product_id')
            ->join('categories', 'categories.id', '=', 'products.c_id')
            ->join('units', 'units.id', '=', 'products.u_id')
            ->select('products.id as id', 'products.price', 'products.name', 'products.description', 'categories.id as c_id', 'categories.name as c_name', 'units.id as u_id', 'units.description as u_name', 'products.created_at', 'products.updated_at', 'products.status','stocks.qty as s_qty', 'stocks.id as s_id')
            ->paginate(10);
        return view('stocks', ['products' => $products])->with('helper', new help);
    }
    public function pos()
    {
        if(session('user')){
            $products = DB::table('stocks')
            ->join('products','stocks.product_id','=','products.id')
            ->join('categories', 'categories.id', '=', 'products.c_id')
            ->join('units', 'units.id', '=', 'products.u_id')
            ->where('stocks.warehouse_id',Session::get('user')->b_id)
            ->select('products.id as id', 'products.price', 'products.name', 'products.description', 'categories.id as c_id', 'categories.name as c_name', 'units.id as u_id', 'units.description as u_name', 'products.created_at', 'products.updated_at', 'products.status','stocks.id as s_id','stocks.qty as s.qty')
           ->get();
        return view('pos', ['products' => $products,'pid'=>1])->with('helper', new help);
        }else{
            return view('login');
        }
       
    }
    public function posSellingType($id)
    {
        $products = DB::table('stocks')
            ->join('prices','prices.stock_id','=','stocks.id')
            ->join('products','stocks.product_id','=','products.id')
            ->join('categories', 'categories.id', '=', 'products.c_id')
            ->join('units', 'units.id', '=', 'products.u_id')
            ->where('stocks.warehouse_id',Session::get('user')->b_id)
            ->where('prices.price_type',$id)
            ->select('products.id as id', 'products.price', 'products.name', 'products.description', 'categories.id as c_id', 'categories.name as c_name', 'units.id as u_id', 'units.description as u_name', 'products.created_at', 'products.updated_at', 'products.status','stocks.id as s_id','stocks.qty as s.qty')
           ->get();
        return view('pos', ['products' => $products,'pid'=>$id])->with('helper', new help);
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
        if(session('user')){
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
                        'type.gt:0' => 'Select Discount Type.',
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
}
