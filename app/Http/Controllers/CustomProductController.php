<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\CPU\Helpers;
use App\Model\Seller;
use save;
use App\Model\CustomProduct;
use App\CPU\ImageManager;
use Brian2694\Toastr\Facades\Toastr;
use Redirect;
use App\CPU\ProductManager;
use App\Model\OrderDetail;
use App\Model\Order;
use App\Model\Wishlist;
use App\Model\Product;
use App\Model\Category;
use App\Model\Brand;
use App\Model\Offer;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;

class CustomProductController extends Controller
{
    public function customer_products(){
        
         $data['categories'] =  Category::where(['parent_id' => 0])->get();
        $data['brand'] = Brand::orderBY('name', 'ASC')->get();

        //$data['categories'] = DB::table('categories')->get();
        $data['colors'] = DB::table('colors')->get();
        $data['sallers'] = DB::table('sellers')->get();
        
        return view('add_customer_product',$data);
    }

    public function customerstore(Request $request)
{
   
         $validator = Validator::make($request->all(), [
           
            'customer_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'color' => 'nullable',
            'unit' => 'nullable',
            'images' => 'required',
            'description' => 'nullable',
            'url' => 'required',
       
        ], [
            'customer_id.required' => 'Customer does not exist',
            'images.required' => 'Product images is required!',
            'category_id.required' => 'category name is required!',
            'name.required' => 'Name  is required!',
            'url.required' => 'Url is required!',
            'quantity.required' => 'Quantity is required!',
            
        ]);
      
         $Cproduct = new CustomProduct();
         $Cproduct->user_id = auth('customer')->id();
      
         if ($request->has('color') && count($request->color) > 0) {
            $Cproduct->color = json_encode($request->color);
        } else {
            $colors = [];
            $Cproduct->color = json_encode($colors);
        }
        $Cproduct->added_by = "customer";
    //   $Cproduct->seller_id = $request->seller_id;
        $Cproduct->url = $request->url;
       // $Cproduct->color = $request->color;
         $Cproduct->name = $request->name;
         $Cproduct->category_id = $request->category_id;
         $Cproduct->size = $request->size;
         $Cproduct->material = $request->material;
         $Cproduct->description = $request->description;
         
        $category = [];
        if ($request->category_id != null) {
            array_push($category, [
                'id' => $request->category_id,
                'position' => 1,
            ]);
        }
       if ($request->sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_category_id,
                'position' => 2,
            ]);
        }
        $Cproduct->category_id = json_encode($category, true);
        //$Cproduct->brand_id = $request->brand_id;
        $Cproduct->unit = $request->unit;
        $Cproduct_images = [];
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            if ($request->file('images')) {
                foreach ($request->file('images') as $img) {     
                    $Cproduct_images[] = ImageManager::upload('custom/product/', 'png', $img);
                }
            foreach ($request->file('images') as $img) {     
                   $Cproduct->thumbnail = ImageManager::upload('custom/product/thumbnail/', 'png', $img);
                   break;
                }
            
           
         $Cproduct->images = json_encode($Cproduct_images);
            }
            
            
           //dd($Cproduct);die;
           $Cproduct->save();
             if ($Cproduct)
            {
        //      $C_id = Seller::whereNotNull('cm_firebase_token')->get()->toArray();
     
        //  foreach ($C_id as $add) {
            
        //   if (in_array($request->category_id, json_decode($add['category_id']))) {
        //          if($add['cm_firebase_token'] != null){
        //           $data = [
        //             'title' => $Cproduct->name,
        //             'description' => $Cproduct->description,
        //             'category' => 'Shoes',
        //             'image' => config('app.url').'/'.$Cproduct->thumbnail,
        //         ];
        //         Helpers::send_push_notif_to_sellers($add['cm_firebase_token'], $data);
        //   }
        //   }
        // }
             Toastr::success('Product added successfully!');
             return Redirect::route('custom_product_list');
            }else{
                Toastr::error('Failed product submission!');
                return Redirect::route('customer_products');
            }

    }
}

      public function custom_product_list(Request $request){

         $C_id = CustomProduct::where('user_id', \auth('customer')->id())->get();
  
    //   $cat = json_decode($C_id[0]['category_id'], true);
      $query_param = [];
      $search = $request['search'];
      $c_ids = Order::pluck('custom_product_id');
      
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $offers = Offer::where(['custom_product_id' => $data['id']])->get();
            $data['available_offers'] = count($offers)>0?count($offers):0;
             $product = CustomProduct::with('user')->whereNotIn('id', $c_ids)->where('user_id',\auth('customer')->id())
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->Where('description', 'like', "%{$value}%");
                         $q->orWhere('name', 'like', "%{$value}%");
                    }
                })->paginate(3);
              
                $product->map(function ($data) {
                 
                    $offers = Offer::where(['custom_product_id' => $data['id']])->get();
                    $data['available_offers'] = count($offers)>0?count($offers):0;
                    return $data;

                });
            $query_param = ['search' => $request['search']];
         
            return view('custom_product_list', compact('product','search'));
        } else{
              
          $product=CustomProduct::where('user_id', \auth('customer')->id())->orderBy('id', 'DESC')->paginate(3);
    
     
          $product->map(function ($data) {
          
            $offers = Offer::where(['custom_product_id' => $data['id']])->get();
            $data['available_offers'] = count($offers)>0?count($offers):0;

            return $data;
        });
      
          return view('custom_product_list', compact('product','search'));
        }
  
}
       public function view_custom(Request $request){
       
       $product = CustomProduct::where('id',$request->product_id)->get();
      
        $wishlists = Wishlist::where('custom_product_id', $request->product_id)->get();
        // $countOrder = count($order_details);
        $countWishlist = count($wishlists);
       // $relatedProducts = CustomProduct::with(['reviews'])->where('category_id', $product->category_id)->where('id', '!=', $request->product_id)->limit(12)->get();
      
        return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._view_custom', compact('product', 'countWishlist', 'wishlists'))->render(),
        ]);
        //  $product = ProductManager::get_products($request->product_id);
     
        // $order_details = OrderDetail::where('custom_product_id', $product->id)->get();
        // $wishlists = Wishlist::where('custom_product_id', $product->id)->get();
        // $countOrder = count($order_details);
        // $countWishlist = count($wishlists);
        // $relatedProducts = CustomProduct::with(['reviews'])->where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(12)->get();
        // return response()->json([
        //     'success' => 1,
        //     'view' => view('web-views.partials._view_custom', compact('product', 'countWishlist', 'countOrder', 'relatedProducts'))->render(),
        // ]);
    }
    
   public function view_offer(Request $request){

          $product = ProductManager::get_products($request->product_id);
           $link = Product::find($product->seller_offer_id);
    
          $order_details = OrderDetail::where('custom_product_id', $product->id)->get();
          $offers = Offer::with('custom_product', 'sellers')->where('custom_product_id', $request->product_id)->get();
          $wishlists = Wishlist::where('custom_product_id', $product->id)->get();
          $countWishlist = count($wishlists);
          $relatedProducts = CustomProduct::with(['reviews'])->where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(12)->get();
        
          return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._view_offer', compact('product', 'offers', 'wishlists', 'countWishlist', 'order_details', 'relatedProducts', 'link'))->render(),
        ]);
    }
       public function get_categories(Request $request)
    {
   
      $cat = Category::where(['parent_id' =>$request->parent_id])->get();
        
     
        
        $res = '<option value="' . 0 . '" disabled selected>---Select---</option>';
        foreach ($cat as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'select_tag' => $res,
        ]);
    }
     public function deleteCustom(Request $request)
    {
        CustomProduct::where(['id' => $request['id'], 'user_id' => auth('customer')->id()])->delete();
        $data = "Product has been remove from list!";
       
     
        return response()->json([
            'success' => $data,
            'id' => $request->id
           
        ]);
    }
    public function custom_edit($id)
    {
        $product = CustomProduct::find($id);
        $product->category = json_decode($product->category_id);
      
        $product->colors = json_decode($product->color);
        $categories = Category::where(['parent_id' => 0])->get();
        $br = Brand::orderBY('name', 'ASC')->get();
        return view('custom_product_edit', compact('categories', 'br', 'product'));
    }
     public function custom_update(Request $request)
    {
  
       $validator = Validator::make($request->all(), [
           
            'customer_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            'color' => 'nullable',
            'unit' => 'nullable',
            'images' => 'required',
            'description' => 'nullable',
            'url' => 'required',
       
        ], [
            'customer_id.required' => 'Customer does not exist',
            'images.required' => 'Product images is required!',
            'category_id.required' => 'category name is required!',
            'name.required' => 'Name  is required!',
            'url.required' => 'Url is required!',
            'quantity.required' => 'Quantity is required!',
            
        ]);
      
         $Cproduct = $request->all();

         $Cproduct['user_id'] = auth('customer')->id();
      
         if ($request->has('color') && count($request->color) > 0) {
            $Cproduct['color'] = json_encode($request->color);
        } else {
            $colors = [];
            $Cproduct['color'] = json_encode($colors);
        }
        $Cproduct['added_by'] = "customer";
    //   $Cproduct->seller_id = $request->seller_id;
        $Cproduct['url'] = $request->url;
       // $Cproduct->color = $request->color;
         $Cproduct['name'] = $request->name;
         $Cproduct['category_id'] = $request->category_id;
         $Cproduct['size'] = $request->size;
         $Cproduct['material'] = $request->material;
         $Cproduct['description'] = $request->description;
         
        $category = [];
        if ($request->category_id != null) {
            array_push($category, [
                'id' => $request->category_id,
                'position' => 1,
            ]);
        }
       if ($request->sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_category_id,
                'position' => 2,
            ]);
        }
        $Cproduct['category_id'] = json_encode($category, true);
        //$Cproduct->brand_id = $request->brand_id;
        $Cproduct['unit'] = $request->unit;
        $Cproduct_images = [];
        if ($request->ajax()) {
            return response()->json([], 200);
        } else {
            if ($request->file('images')) {
                foreach ($request->file('images') as $img) {     
                    $Cproduct_images[] = ImageManager::upload('custom/product/', 'png', $img);
                }
            foreach ($request->file('images') as $img) {     
                   $Cproduct['thumbnail'] = ImageManager::upload('custom/product/thumbnail/', 'png', $img);
                   break;
                }
       
        $Cproduct['images'] = json_encode($Cproduct_images);
        $custom_product = CustomProduct::find($Cproduct['id']);
        $Cproduct = $custom_product->update($Cproduct); 
            }
           if($Cproduct) {
            
           //dd($Cproduct);die;


         Toastr::success('Product updated successfully!');
             return Redirect::route('custom_product_list');
            }else{
                Toastr::error('Failed product updation!');
                return Redirect::route('custom-edit');
            }
    }
}
     
}
