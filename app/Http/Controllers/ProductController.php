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
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Unit;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
        public function getCategories()
        {
                $categories = Category::where('status',1)->paginate(10);

                return view('categories', ['categories' => $categories]);

        }
        public function getUnits()
        {
                $units = Unit::where('status',1)->paginate(10);

                return view('units', ['units' => $units]);

        }
        public function getProducts()
        {
                $products = DB::table('products')
                ->join('categories', 'categories.id', '=', 'products.c_id')
                ->join('units', 'units.id', '=', 'products.u_id')
                ->select('products.id as id','products.price', 'products.name','products.description','categories.id as c_id','categories.name as c_name','units.id as u_id','units.description as u_name', 'products.created_at', 'products.updated_at', 'products.status')
                ->paginate(10);
                return view('productlist', ['products' => $products]);

        }
    public function getProduct()
    {
    
        $categories = Category::get(["name", "id"]);
        $units = Unit::get(["description", "id"]);

            return view('product', ['categories' => $categories,'units' => $units]);

    }
    public function getCategory()
    {
    
            return view('category');

    }
    public function getUnit()
    {
    
            return view('unit');

    }
    public function showProductImages($id){
        $product = DB::table('products')
        ->join('categories', 'categories.id', '=', 'products.c_id')
        ->join('units', 'units.id', '=', 'products.u_id')
        ->select('products.id as id','products.price', 'products.name','products.description','categories.id as c_id','categories.name as c_name','units.id as u_id','units.description as u_name', 'products.created_at', 'products.updated_at', 'products.status')
        ->where('products.id',$id)->first();
        $productImages = DB::table('product_images')->where('p_id',$id)->get();
        // $productImages = ProductIamges::get(["image_url", "id"]);
        return view('/product-images', compact('product','productImages'));
    }
    public function getAnnoucementById($id)
    {
        // $depts = DB::table('departments')
        // ->join('branchs', 'departments.b_id', '=', 'branchs.id')
        // ->join('headoffices', 'departments.h_id', '=', 'headoffices.id')

        // ->select('departments.id as id', 'headoffices.name as hname','branchs.name as bname','departments.name as dname')->get();
        // $announce = DB::table('annoucements')->find($id);
        // return view('/annoucement', ['announce' => $announce, 'depts' => $depts]);

    }

    public function getCategoryById($id)
    {
      
        $category = DB::table('categories')->find($id);
        return view('/category', ['category' => $category]);

    }
    public function getUnitById($id)
    {
      
        $unit = DB::table('units')->find($id);
        return view('/unit', ['unit' => $unit]);

    }
    public function getProductById($id)
    {
        $categories = Category::get(["name", "id"]);
        $units = Unit::get(["description", "id"]);
        $product = DB::table('products')->find($id);
        return view('/product', ['categories' => $categories,'units' => $units, 'product'=>$product]);

    }
    public function saveCategory(Request $request,$id=null)
    {
   
        if($id == null){
                $validatedData = $request->validate(
                        [
                               
                                'name' => 'required|min:5',
                                'description' => 'required|min:5',

                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 5 characters.',
                            'description.required' => 'Please Input description.',
                            'description.min' => 'description must be at least 5 characters.',
                        ]
                    );
                    try {
                    $category = new Category();
                    $category->name = $request->name;
                    $category->description = $request->description;
                    $category->status = 1;
                    $category->save();
                    return redirect()->back()->with('message', 'Category Save Successfully!');
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
                        Category::find($id)->update([
                        'name' => $request->name,
                        'description' =>  $request->description,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'category Update Successfully!');
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
    public function saveUnit(Request $request,$id=null)
    {
        if($id == null){
                $validatedData = $request->validate(
                        [
                               
                                'name' => 'required|min:1',
                                'description' => 'required|min:5',
                                'actual' => 'required|numeric|min:1|not_in:0',


                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 1 characters.',
                            'description.required' => 'Please Input description.',
                            'description.min' => 'description must be at least 5 characters.',
                            'actual.not_in:0' => 'actual unit must greater than zero.' 
                        ]
                    );
                    try {
                    $unit = new Unit();
                    $unit->name = $request->name;
                    $unit->description = $request->description;
                    $unit->actual = (float)$request->actual;
                    $unit->status = 1;
                    $unit->save();
                    return redirect()->back()->with('message', 'Unit Save Successfully!');
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
                        Unit::find($id)->update([
                        'name' => $request->name,
                        'description' =>  $request->description,
                        'actual' =>  (float)$request->actual,
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Unit Update Successfully!');
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
    public function saveProduct(Request $request,$id=null)
    {
        if($id == null){
                $validatedData = $request->validate(
                        [
                               
                                'name' => 'required|min:5',
                                'description' => 'required|min:5',
                                'category' => 'gt:0',
                                'unit' => 'gt:0',
                                'price' => 'required|numeric|min:1|not_in:0',



                        ],
                        [
                            'name.required' => 'Please Input Name.',
                            'name.min' => 'Name must be at least 5 characters.',
                            'description.required' => 'Please Input description.',
                            'description.min' => 'description must be at least 5 characters.',
                            'category.gt:0' => 'Select Category.',
                            'unit.gt:0' => 'Select Unit.',
                            'price.not_in:0' => 'selling price must greater than zero.' 


                        ]
                    );
                    try {
                    $product = new Product();
                    $product->name = $request->name;
                    $product->price = (float)$request->price;
                    $product->description = $request->description;
                    $product->c_id = $request->get('category');
                    $product->u_id = $request->get('unit');
                    $product->status = 1;
                    $product->save();
                    return redirect()->back()->with('message', 'Product Save Successfully!');
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
                        Product::find($id)->update([
                        'name' => $request->name,
                        'description' =>  $request->description,
                        'price' =>  (float)$request->price,
                        'c_id' => $request->get('category'),
                        'u_id' => $request->get('unit'),
                        'updated_at' => Carbon::now()
                    ]);
                return redirect()->back()->with('message', 'Product Update Successfully!');
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
    public function imageStore(Request $request, int $productId)
    {

        // $request->validate([
        //     'images.*' => 'required|image|mimes:png,jpg,jpeg,webp'
        // ]);

        $product = Product::findOrFail($productId);
        $imageData = [];

        if($files = $request->file('images')){

                foreach($files as $key => $file){
    
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key.'-'.time(). '.' .$extension;
    
                    $path =  "uploads/products/";
    
                    $file->move($path, $filename);
    
                    DB::table('product_images')->insert([
                        'p_id' => $productId,
                        'image_url' => $path.$filename
                    ]);
                }
            }


        return redirect()->back()->with('status', 'Uploaded Successfully');

    }

    public function destroy(int $productImageId)
    {
        $productImage = DB::table('product_images')->where('id',$productImageId)->first();
        if(File::exists($productImage->image_url)){
            File::delete($productImage->image_url);
        }
        DB::table('product_images')->where('id',  $productImageId)->delete();


        return redirect()->back()->with('status', 'Image Deleted');
    }
}
