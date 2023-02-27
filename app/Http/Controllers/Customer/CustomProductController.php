<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CPU\BackEndHelper;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Auth;
use App\CPU\ImageManager;
use App\Http\Controllers\BaseController;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Color;
use App\Model\seller;
use App\Model\Offer;
use App\Model\CustomProduct;
use App\Model\DealOfTheDay;
use App\Model\FlashDealProduct;
use App\Model\Product;
use App\Model\Review;
use App\Model\Translation;
use App\Model\Wishlist;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use function App\CPU\translate;
use App\Model\Cart;
use App\User;

class CustomProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
       
       $seller = Seller::where('id',auth('seller')->id())->pluck('category_id')->toArray();
         $cat = CustomProduct::where(['checked' => 0])->get();
         $ids = [];
         $count = 1;
         foreach ($cat as $item) {
               
                $items = json_decode($item['category_id']);
                // dd($items[0]->id);
                if(in_array($items[0]->id, json_decode($seller[0])))
                {
                    $products = CustomProduct::where('checked',0)->where('id',$item['id'])->update(['checked'=>1]);
                    
                }
              
                }
                 // $seller = Seller::where('id',auth('seller')->id())->pluck('category_id')->toArray();
        $cats = CustomProduct::where(['checked' => 1])->get();
        
         foreach ($cats as $item) {
               
                $items = json_decode($item['category_id']);
            
                if(in_array($items[0]->id, json_decode($seller[0])))
                {
                    
                     array_push($ids, (integer)$item['id']);
                }
              
                }
        
       $C_id = Seller::where('id', \auth('seller')->id())->get();
       // $cat = $C_id[0]['category_id'];
       $cat = json_decode($C_id[0]['category_id'], true);
       
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $products = CustomProduct::with('seller', 'user')->where('seller_id',\auth('seller')->id())
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('description', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
                $products = CustomProduct::with('user')->whereIn('id', $ids);
        }
        $products = $products->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends($query_param);
       
        return view('seller-views.custom-product.list', compact('products', 'search'));
        
        
    }
      public function custom_list(Request $request)
    {
       
       $id = !empty($request->user_id)?$request->user_id:\auth('seller')->id();
       
       $C_id = Seller::where('id', $id)->get();
       $cat = json_decode($C_id[0]['category_id'], true);
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $products = CustomProduct::with('seller', 'user')->where('seller_id',\auth('seller')->id())
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('description', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $products = CustomProduct::with('user')->whereIn('category_id', $cat);
        }
        $products = $products->orderBy('id', 'DESC')->paginate(Helpers::pagination_limit())->appends($query_param);
           // $response['status'] = 200;
           //  // $response['error'] = 'false';
           //  $response['message'] = 'Custom product retrived successfully';
           //  $response['data'] = $products;
           //  return response()->json($response);
         return view('seller-views.custom-product.list', compact('products', 'search'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
           
            'customer_id' => 'nullable',
            'category_id' => 'required',
            'color' => 'nullable',
            'seller_id' => 'required',
            'unit' => 'nullable',
            'images' => 'required',
            'description' => 'required',
           
            
        ], [
            'customer_id.nullable' => 'Customer does not exist',
            'seller_id.required' => 'seller  is required!',
            'images.required' => 'Product images is required!',
            'category_id.required' => 'category name is required!',
            'description.required' => 'description  is required!',
            
        ]);
       
        $Cproduct = new CustomProduct();
        $uid = !empty(auth('customer')->id()) ? auth('customer')->id() : $request->user_id;
        $Cproduct->user_id = auth('customer')->id();
        $Cproduct->added_by = "customer";
        // $Cproduct->user_id = $request->customer_id;
        $Cproduct->seller_id = $request->seller_id;
       
        $Cproduct->category_id = $request->category_id;
        $Cproduct->unit = $request->unit;
        $Cproduct->description = $request->description;

       
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        //combinations end
        
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            if ($request->file('images')) {
               
                foreach ($request->file('images') as $img) {
                  
                    $Cproduct_images[] = ImageManager::upload('custom/product/', 'png', $img);
                }
                $Cproduct->images = json_encode($Cproduct_images);
            }
            // $product->thumbnail = ImageManager::upload('product/thumbnail/', 'png', $request->file('photo'));
            // $Cproduct->meta_description = $request->meta_description;
            // $product->meta_image = ImageManager::upload('product/meta/', 'png', $request->meta_image);

            $Cproduct->save();
           
           
            $response['status'] = 200;
            // $response['error'] = 'false';
            $response['message'] = 'Custom product added successfully';
            $response['data'] = $Cproduct;
            return response()->json($response);
            // return $this->sendResponse($Cproduct, 'Custom product added successfully');
           
            // Toastr::success('Product added successfully!');
            // return redirect()->route('seller.product.list');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $product = CustomProduct::withoutGlobalScopes()->with('translations')->find($id);
        $offers = Offer::with('custom_product')->where('custom_product_id', $id)->where('seller_id', \auth('seller')->id())->first();
        $sellerproducts = Product::where(['added_by' => 'seller', 'user_id' => \auth('seller')->id()])->get();

        $categories = Category::get();
        $br = Brand::orderBY('name', 'ASC')->get();
        
       //dd($product);die;
        return view('seller-views.custom-product.edit', compact('categories', 'br', 'product', 'offers','sellerproducts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
