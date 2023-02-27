<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Controllers\Controller;
//use Illuminate\Auth\SessionGuard\customer;
use Validator;
use Auth;
use App\Model\Seller;
use App\Model\DeliveryMan;
use App\Model\ShippingAddress;
use App\Model\Category;
use App\Model\Color;
use App\Model\Brand;
use App\CPU\Helpers;
use save;
use App\Model\CustomProduct;
use App\CPU\ImageManager;
use Brian2694\Toastr\Facades\Toastr;
Use DB;
use App\Model\DealOfTheDay;
use App\Model\FlashDealProduct;
use Redirect;
use App\CPU\ProductManager;
use Illuminate\Support\Facades\Storage;
use App\Model\OrderDetail;
use App\Model\Order;
use App\Model\Wishlist;
use App\Model\Product;
use App\Model\Offer;
use App\User;
use App\Model\Cart;
use App\Model\Unit;
use App\Model\Review;
use Session;
use Carbon\Carbon;
use function App\CPU\translate;
use Illuminate\Validation\Rule;

class Customerproduct extends BaseController
{

    public function customerstores(Request $request)
    {
    
  
        $id = Auth::User()->id;
        $validator = Validator::make($request->all() , ['category_id' => 'required', 'name' => 'required', 'color' => 'nullable', 'unit' => 'nullable',  'sub_category_id' => 'required', 'images' => 'required', 'description' => 'required', 'url' => 'required', 'size' => 'required', ], ['customer_id.required' => 'Customer does not exist', 'images.required' => 'Product images is required!', 'category_id.required' => 'category name is required!', 'sub_category_id.required' => 'category name is required!','description.required' => 'description  is required!', 'url.required' => 'url is required!', 'quantity.required' => 'Quantity is required!','name.required' => 'Product name is required!']);
         if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $Cproduct = new CustomProduct();
        $Cproduct->user_id = $id;
        if ($request->has('color') && count($request->color) > 0)
        {
            $Cproduct->color = json_encode($request->color);
        }
        else
        {
            $colors = [];
            $Cproduct->color = json_encode($colors);
        }
        $size = isset($request->size)?$request->size:0;
        $Cproduct->added_by = "customer";
        $Cproduct->url = $request->url;
        $Cproduct->name = $request->name;
        $Cproduct->category_id = $request->category_id;
        $Cproduct->size = $size;
        $Cproduct->unit = $request->unit;
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
        if ($request->sub_sub_category_id != null) {
            array_push($category, [
                'id' => $request->sub_sub_category_id,
                'position' => 3,
            ]);
        }
        //print_r($category);die;
        $Cproduct->category_id = json_encode($category, true);
        $Cproduct_images = [];

        if ($request->ajax())
        {
            return response()
                ->json([], 200);
        }
        else
        {
          
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
       
            $Cproduct->save();
            
            if ($Cproduct)
            {
         $C_id = Seller::whereNotNull('cm_firebase_token')->get()->toArray();
     
         foreach ($C_id as $add) {
            
           if (in_array($request->category_id, json_decode($add['category_id']))) {
                 if($add['cm_firebase_token'] != null){
                  $data = [
                    'title' => $Cproduct->name,
                    'description' => $Cproduct->description,
                    'category' => 'Shoes',
                    'image' => config('app.url').'/'.$Cproduct->thumbnail,
                ];
                Helpers::send_push_notif_to_seller($add['cm_firebase_token'], $data);
           }
           }
        }
    
                $response['status'] = 200;
                $response['error'] = 'True';
                $response['message'] = 'Custom product was created successfully';
                $response['response'] = $Cproduct;
       
               
            }
            else
            {
                $response['error'] = 'false';
                $response['message'] = 'Data Not Found';
            }
            return response()->json($response);
        }
    }
     public function uploade_video(Request $request)
   { 
    $id = Auth::User()->id;
    
    $validator = Validator::make($request->all(), [ 
            
            'id'   => 'required',
            'video' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required',
         
        ], [
           
            'video.required' => 'Product video is required!',
            'id.required' => 'Product id is required!'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
      
         $Cproduct_video = [];
         
        if ($request->ajax()) {
            return response()->json([], 200);
        }else{
           
                 $fileName = $request->video->getClientOriginalName();
        $filePath = 'custom/videos/' . $fileName;
 
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->video));
 
        // File URL to access the video in frontend
           $url = Storage::disk('public')->url($filePath);
           $offer_data = CustomProduct::find($request->id);
             $Cproduct = $offer_data->update(['video' =>  $filePath]);
             if($Cproduct){
             $response['status'] = 200;
             $response['error'] = 'True';
             $response['message'] = 'Custom product was created successfully';
             $response['response'] = $Cproduct;
             }else{
             $response['error'] = 'false';
             $response['message'] = 'Data Not Found';
             }
             return response()->json($response);     
         }
   }
    public function get_searched_products_by_seller(Request $request)
    {
          $data = Helpers::get_seller_by_token($request);
   
      
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
   
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
           if ($data['success'] == 1) {
       $seller = $data['data'];
       $request['id'] = $seller['id'];
      
        $products = ProductManager::search_products_by_seller($request['name'], $request['id'], $request['limit'], $request['offset']);
        if ($products['products'] == null) {
            $products = ProductManager::translated_product_search($request['name'], $request['limit'], $request['offset']);
        }
           
        $products['products'] = Helpers::product_data_formatting($products['products'], true);
        return response()->json($products, 200);
    }else{
            
                 return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
            
        }
    }
   
    public function offer_list(Request $request, $id)
    {
        $offers = Offer::with('custom_product', 'sellers')->where('custom_product_id', $id)->get();
         
        
           $storage = [];
            $storage1 = [];
            $offers_count = Offer::with('custom_product')->where('custom_product_id', $id)->count();
            
             $d = CustomProduct::find($id);
            if($d != null)
            {
                $d['available_offers'] = $offers_count;
                   $d['images'] =  $d->images == null?[]: json_decode($d->images);
                //  $d['images'] = json_decode($d->images);
                //  $d['images'] = $d->images;
                 $color =  $d->color == null?[]: json_decode($d->color);
                $d['color'] = Color::whereIn('code', $color)->get(['name', 'code']);
                 $d['category_id'] = json_decode($d->category_id);
                 foreach ($d['category_id'] as $key =>$cat_id) {
                //   dd($cat_id);->get();
                 $d['category_id'] = Category::where('id', $cat_id->id)->get(['name', 'slug']);
                  $d['sub_category_id'] = Category::with(['childes.childes'])->where(['position'=> $cat_id->position, 'parent_id' => $cat_id->id])->priority()->get(['name', 'slug']);
                //   array_push($storage1, $ci);
                 }
                // $d['category_id']= $storage1;
                $item['common_details'] = $d; 
                
                 // unset($item['common_details']);
                 // $data = $storage;
                foreach ($offers as $key =>$items) {
                     $color =  $items->custom_product->color == null?[]: json_decode($items->custom_product->color);
                $c['sellers'] = Seller::where('id', $items['seller_id'])->selectRaw("id as seller_id, CONCAT(f_name,' ',l_name) as full_name, phone,email,image")->get();
                 $c['offers'] = $items['offer'];
                 $c['id'] = $items['id'];
                 $available_offers['product'] = Product::with(['rating'])->where('id',$items['seller_offer_id'])->get();
                $c['offer_id'] = Helpers::product_data_formatting($available_offers['product'], true);
                $items['colors'] = Color::whereIn('code', $color)->get(['name', 'code']);
                 
                 array_push($item, $c);
                
                  $item['offers'][$key] = $item[$key];
                  unset($item[$key]);
               
                  // unset($item['offer_details']);
               }
          
             array_push($storage, $item);
           
          if(count($offers)>0){
            $response['status'] = 200;
            $response['message'] = 'Custom Product retrived successfully';
            $response['data'] = $storage;
            return response()->json($response);
               }else{
             $response['status'] = false;
             $response['message'] = "Available Offer 0";
             return response()->json($response); 
                  }
            }else{
              $response['status'] = false;
             $response['message'] = "Product not found";
             return response()->json($response); 
            }
      
    }
    
     public function unit_list(Request $request, $id)
    {
        
        $units = Unit::where('category_id', $id)->get();
    
          if(count($units)>0){
            $response['status'] = 200;
            $response['message'] = 'Units retrived successfully';
            $response['data'] = $units;
            return response()->json($response);
               }else{
             $response['status'] = false;
             $response['message'] = "Data Not Found";
             return response()->json($response); 
                  }
      
    }
     public function sub_category_list(Request $request, $id)
    {
        
        $units = Category::where('parent_id', $id)->get();
    
          if(count($units)>0){
            $response['status'] = 200;
            $response['message'] = 'Sub Category retrived successfully';
            $response['data'] = $units;
            return response()->json($response);
               }else{
             $response['status'] = false;
             $response['message'] = "Data Not Found";
             return response()->json($response); 
                  }
      
    }
    
    
    public function offer_count(Request $request, $id)
    {
        $offers = Offer::with('custom_product')->where('custom_product_id', $id)->count();
        // dd($offers);
        if ($offers)
        {
            $response['status'] = 200;
            // $response['error'] = 'false';
            $response['message'] = 'Custom product retrived successfully';
            $response['count'] = $offers;
            return response()->json($response);
        }
        else
        {
            $response['status'] = false;
            $response['message'] = "Data Not Found";
            return response()->json($response);
        }
    }

    public function custom_product_list(Request $request)
    {
      
        $data = Helpers::get_seller_by_token($request);
        $ids = [];
        if ($data['success'] == 1)
        {
            $seller = $data['data'];
            $id = $seller['id'];
            $C_id = Seller::where('id', $id)->get();
            // $cat = $C_id[0]['category_id'];
            $cat = json_decode($C_id[0]['category_id'], true);
            $seller = Seller::where('id',$id)->pluck('category_id')->toArray();
            $cats = CustomProduct::where(['checked' => 1])->get();
          
         foreach ($cats as $item) {
               
                $items = json_decode($item['category_id']);
            
                if(in_array($items[0]->id, json_decode($seller[0])))
                {
                    
                     array_push($ids, (integer)$item['id']);
                }
              
                }
            $query_param = [];
            $search = $request['search'];
            if ($request->has('search'))
            {
                $key = explode(' ', $request['search']);
                $products = CustomProduct::with('user')->whereIn('id', $ids)->where(function ($q) use ($key)
                {
                    foreach ($key as $value)
                    {
                        $q->Where('description', 'like', "%{$value}%");
                    }
                });
                $query_param = ['search' => $request['search']];
            }
            else
            {
              
                $products = CustomProduct::with('user')->whereIn('id', $ids);
              
            }
            $products = $products->orderBy('id', 'DESC')
                ->paginate(Helpers::pagination_limit())
                ->appends($query_param);
               
           
            $response['status'] = 200;
            // $response['error'] = 'false';
            $response['message'] = 'Custom product retrived successfully';
            $response['data'] = $products;
            return response()->json($response);
        }
        else
        {
            return response()->json(['auth-001' => translate('Your existing session token does not authorize you any more') ], 401);

        }
    }
    public function custom_list_userwise(Request $request)
    {
       $uid = Auth::User()->id;
      
      $cid = [];
      $top_sell = CustomProduct::where(['user_id'=>$uid])->rightJoin('offers', 'offers.custom_product_id', '=', 'custom_products.id')
            ->groupBy('custom_product_id')
            ->distinct('id')
            ->select(['custom_product_id',
                DB::raw('IFNULL(count(offers.custom_product_id),0) as total'),'name','description'
                
            ])
            ->orderBy('total', 'desc')
            
            ->get();
          
     $storage = [];
    // dd($top_sell);
     $c_id= CustomProduct::where('user_id', $uid)->orderBy('id', 'desc')->get();
   
       foreach ($c_id as $item) {
    
                $variation = [];
                $item['category_id'] = $item['category_id'] == null?[]: json_decode($item['category_id']);
                // $item['category_id'] = json_decode($item['category_id']);
                $item['images'] =  $item['images'] == null?[]: json_decode($item['images']);
               $color =  $item['color'] == null?[]: json_decode($item['color']);
                  $item['color'] = Color::whereIn('code', $color)->get(['name', 'code']);
                 
                $count = Offer::where('custom_product_id', $item['id'])->count();
                $item['available_offers'] = isset($count)>0?$count:0;
                 
                 array_push($storage, $item);
         
               }
        
 
      $data = Offer::with('custom_product', 'reviews')->get();
      
        
       $dataa = [];
        foreach ($data as $order) {
            array_push($dataa, $order->custom_product);
        }

            $response['status'] = 200;
            // $response['error'] = 'false';
            $response['message'] = 'Custom product retrived successfully';
            // $c_id['product_listing'] = $dataa;
            // $c_id['json'] = $top_sell;
            $response['data'] = $storage;
            return response()->json($response);
  
    }
   public function edit_custom(Request $request, $id){

         $data = Helpers::get_seller_by_token($request);
            if ($data['success'] == 1) {
            $seller = $data['data'];
            $uid = $seller['id'];
            $storage = [];
            $product = CustomProduct::withoutGlobalScopes()->with('translations')->find($id);
            $product['images'] = json_decode($product['images']);
            $product['color'] = json_decode($product['color']);
            if(!empty($product))
            {
            $offers = Offer::with('custom_product')->where('custom_product_id', $id)->where('seller_id', $uid)->first();
            
            $categories = Category::get();
            $br = Brand::orderBY('name', 'ASC')->get();
            $item['products'] = $product;
            $item['offer'] = $offers;
            $item['brands'] = $br;
            $item['categories'] = $categories;
            array_push($storage, $item);
            $response['status'] = 200;
            $response['message'] = 'Id wise details retrived successfully';
            $response['data'] = $storage;
            
            return response()->json($response);
            }else{
                 $response['status'] = false;
        $response['message'] = "Data Not Found";
       return response()->json($response);
            }
            }
            else{
                 return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
            }
    }
    public function view_custom(Request $request, $id)
    {

        $data = Helpers::get_seller_by_token($request);
        if ($data['success'] == 1)
        {
            $seller = $data['data'];
            $uid = $seller['id'];
            $product = CustomProduct::with(['reviews', 'offers'])->where(['id' => $id])->first();
             $product['images'] = json_decode($product['images']);
            $product['color'] = json_decode($product->color);
             $product['category'] = Category::where('id', $product->category_id)->get(['name', 'slug']);
            $product['customer_details'] = User::where('id',$product->user_id)->selectRaw("CONCAT(f_name,' ',l_name) as full_name, phone")->get();  
            $offer = Offer::where(['custom_product_id' => $id])->where(['seller_id' => $uid])->first();
        
            $reviews = Review::where(['custom_product_id' => $id])->paginate(Helpers::pagination_limit());
            $response['status'] = 200;
            $response['message'] = 'Details retrived successfully';
            $response['data'] = $product;
            $response['offer'] = $offer;
            $response['reviews'] = $reviews;
            return response()->json($response);
        }
        else
        {
            return response()->json(['auth-001' => translate('Your existing session token does not authorize you any more') ], 401);
        }

    }

   public function update_custom_product(Request $request, $id){

      $validator = Validator::make($request->all(), [

            
             'name'     => 'required',
             'seller_offer_id'     => 'required',
             'offers'     => 'nullable',
             'description'     => 'required',

        ],[
            
            'offers.required' => 'Offer is required!',
            'description.required'     => 'Description is required',

        ]);
         if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        
         $authdata = Helpers::get_seller_by_token($request);
        
        if ($authdata['success'] == 1) {
        $seller = $authdata['data'];
        $data = CustomProduct::where('id', $id)->first();
       
        $offer_data = Offer::where('custom_product_id', $id)->where('seller_id', $seller['id'])->first();
     
        if ($offer_data != null) {
            $offer_data->update(['offer' => $request->offers, 'seller_offer_id' => $request->seller_offer_id]);
        } else {
            $offer_create = Offer::create([
                'custom_product_id' => $id,
                'seller_id' => $seller['id'],
                'seller_offer_id' => $request->seller_offer_id,
                'offer' => $request->offers
            ]);
        }

        if (!empty($data)) {
   
        // $activated = $data->update(['unit' => $request->unit, 'description' => $request->description, 'name' => $request->name]);

        $response['data'] = $data;
        $response['status'] = true;
        $response['message'] = "Data Update successfully";
        
       return response()->json($response);
        }else
        {
        $response['status'] = false;
        $response['message'] = "Data Not Found";
       return response()->json($response);
        }
        }else{
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        
        }
        }
    public function color(Request $request)
    {

        $Fproduct = Color::get();
        $response['status'] = 200;
        // $response['error'] = 'false';
        $response['message'] = 'True';
        $response['data'] = $Fproduct;
        return response()->json($response);

    }

    public function category(Request $request)
    {
        $Fproduct = category::where('parent_id', '=' , 0)->get();
        $response['status'] = 200;
        // $response['error'] = 'false';
        $response['message'] = 'True';
        $response['data'] = $Fproduct;
        
        return response()->json($response);

    }

   
    public function delete_product(Request $request, $id)
    {

        $product = CustomProduct::find($id);
        $Fproduct = FlashDealProduct::get();
        $DOD = DealOfTheDay::get();
        $cart = Cart::get();

        if (!empty($product))
        {
            $del = $product->delete();

            Cart::where('custom_product_id', $product->id)
                ->delete();
            Offer::where('custom_product_id', $product->id)
                ->delete();
          
                ImageManager::delete('/product/' . $product->images);
                // ImageManager::delete('/product/thumbnail/' . $product['thumbnail']);
                $product->delete();

                $response['status'] = true;
                $response['message'] = "Product removed successfully!";
                return response()->json($response);
            
        }
        else
        {
            $response['status'] = 'error';
            $response['message'] = "Product does not exist!";
            return response()->json($response);
        }
    }

function sellerlist(Request $request)
       {
           
        $data = Helpers::get_seller_by_token($request);
      
        $ids = [];
      
        if ($data['success'] == 1) {
        $seller = $data['data'];
       
       
        
       
            $seller = Seller::where('id',$seller['id'])->pluck('category_id')->toArray();
            $cats = CustomProduct::get();
          
         foreach ($cats as $item) {
               
                $items = json_decode($item['category_id']);
            
                if(in_array($items[0]->id, json_decode($seller[0])))
                {
                    
                     array_push($ids, (integer)$item['id']);
                }
              
                }
                
        }else{
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        
        }
         $query_param = [];
         $search = $request['search'];
         if ($request->has('search')) {
             $key = explode(' ', $request['search']);
             $products = CustomProduct::with('user')->whereIn('id', $ids)
                 ->where(function ($q) use ($key) {
                     foreach ($key as $value) {
                         $q->Where('description', 'like', "%{$value}%");
                     }
                 });
             $query_param = ['search' => $request['search']];
         } else {
             $products = CustomProduct::with(['user'])->whereIn('id', $ids)->get();
           
             $products->map(function ($data) {
                $category = json_decode($data['category_id']);
                $data['category_id'] = Category::where('id',  $category[0]->id)->get(['name', 'slug']);
                $data['full_name'] = $data->user['f_name'].' '.$data->user['l_name'];
                $data['color'] = $data['color'] == null?[]:Color::whereIn('code', json_decode($data['color']))->get(['name', 'code']);
                $data['images'] = json_decode($data['images']);
                // $data['color'] = Color::whereIn('code', json_decode($data['color']))->get(['name', 'code']);
              
                $offers = Offer::where(['custom_product_id' => $data['id']])->get();
                $data['available_offers'] = count($offers)>0?count($offers):0;
              
                return $data;
            });
         }
        //  dd($products);
         $products = $products;
             $response['status'] = 200;
             // $response['error'] = 'false';
             $response['message'] = 'Custom product retrived successfully';
             $response['data'] = $products;
             return response()->json($response);
         // return view('seller-views.custom-product.list', compact('products', 'search'));
         
       }

    public function seller_update(Request $request)
    {

        $validator = Validator::make($request->all() , [

        'id' => 'required', 'name' => 'nullable', 'offer' => 'required', 'description' => 'required', ], ['id.required' => 'Customer id is required!', 'offers.required' => 'Offer is required!',

        ]);

        if ($validator->fails())
        {
            return $this->sendError($validator->errors());
        }
        $data = CustomProduct::where('id', $request->id)
            ->first();
        //   echo auth('seller')->id();die;
        //   print_r($data);die;
        $offer_data = Offer::where('custom_product_id', $request->id)
            ->first();
        if ($offer_data != null)
        {
            $offer_data->update(['offer' => $request->offer]);
        }
        else
        {
            $offer_create = Offer::create(['custom_product_id' => $request->id,
            // 'seller_id' => \auth('seller')->id(),
            'offer' => $request->offer]);
            // print_r($offer_create);die;
            
        }
        if (!empty($data))
        {
            $activated = $data->update(['unit' => $request->unit, 'description' => $request->description, 'name' => $request->name]);

            $response['status'] = "true";
            $response['message'] = "Seller Update successfully!";
        }
        else
        {
            $response['status'] = "false";
            $response['message'] = "Not found data";
        }
        return response()->json($response);
    }

    public function seller_delete(Request $request)
    {

        CustomProduct::where(['id' => $request
            ->id])
            ->delete();
        $products = Offer::where(['custom_product_id' => $request
            ->id])
            ->delete();
        if (!empty($products))
        {

            $response['status'] = "true";
            $response['message'] = "Product removed successfully!";
        }
        else
        {
            $response['status'] = "false";
            $response['message'] = " Product Already remove!";
        }
        // Toastr::success('Product removed successfully!');
        return response()->json($response);
    }

    public function seller_view($id)
    {

        $product = CustomProduct::with(['reviews', 'offers'])->where(['id' => $id])->first();
        $offer = Offer::where(['custom_product_id' => $id])->where(['seller_id' => auth('seller')
            ->id() ])
            ->first();
        $reviews = Review::where(['custom_product_id' => $id])->paginate(Helpers::pagination_limit());

        if (!empty($product))
        {

            $response['status'] = "true";
            $response['data'] = $product;
            $response['message'] = "Success";
        }
        else
        {
            $response['status'] = "false";
            $response['message'] = " Not found data!";
        }
        // return view('seller-views.custom-product.view', compact('product', 'offer', 'reviews'));
        return response()->json($response);
    }
    
    public function getOrderList(Request $request, $status)
{
      $sellerId = Helpers::get_seller_by_token($request);
      
    if ($sellerId['success'] == 1) {
        $seller = $sellerId['data']['id'];
       
        if ($status != 'customproduct') {
            $orders = Order::where(['seller_is' => 'customer'])->where(['seller_id' => $seller])->where(['order_status' => $status]);
        } else {
            $orders = Order::where(['seller_is' => 'customer'])->where(['seller_id' => $seller]);
        }
        
        Order::where(['checked' => 0])->update(['checked' => 1]);

        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $orders = $orders->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('id', 'like', "%{$value}%");
                }
            });
            $query_param = ['search' => $request['search']];
        }
        // dd($orders);
        $orders = $orders->where('order_type','default_type')->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
         $orders->map(function ($data) {
                $data['shipping_address_data'] = json_decode($data['shipping_address_data']);
                $data['billing_address_data'] = json_decode($data['billing_address_data']);
                return $data;
            });
            $response['status'] = 200;
            $response['message'] = 'True';
            $response['data'] = $orders;
            return response()->json($response);
        }else{
             return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }
}

public function getOrderDetails($id)
{
    // echo "string";die;
    $order = Order::with('details', 'shipping', 'seller')->where(['id' => $id])->first();
    
    $linked_orders = Order::where(['order_group_id' => $order['order_group_id']])
        ->whereNotIn('order_group_id', ['def-order-group'])
        ->whereNotIn('id', [$order['id']])
        ->get();

    $shipping_method = Helpers::get_business_settings('shipping_method');
    $delivery_men = DeliveryMan::where('is_active', 1)->when($order->seller_is == 'admin', function ($query) {
        $query->where(['seller_id' => 0]);
    })->when($order->seller_is == 'seller' && $shipping_method == 'sellerwise_shipping', function ($query) use ($order) {
        $query->where(['seller_id' => $order['seller_id']]);
    })->when($order->seller_is == 'seller' && $shipping_method == 'inhouse_shipping', function ($query) use ($order) {
        $query->where(['seller_id' => 0]);
    })->get();

    $shipping_address = ShippingAddress::find($order->shipping_address);
    if($order->order_type == 'default_type')
    {
        $response['status'] = 200;
            $response['message'] = 'True';
            $response['data'] = $order;
            return response()->json($response);
    }else{
         $response['status'] = 200;
            $response['message'] = 'True';
            $response['data'] = $order;
            return response()->json($response);
    }
}
public function getSizeAndMaterials(Request $request)
{
    try {

    $input=$request->all();
    $data =0;
    $raw_query="SELECT CASE WHEN name LIKE '%lot%' THEN 1 ELSE 0 END as cloth, CASE WHEN name LIKE '%hoes%' THEN 2 ELSE 0 END as shoes FROM `categories` where parent_id !=0 and id=".$input['category_id'];
    $category = DB::select( DB::raw($raw_query) );

    if($category[0]->cloth == 1 || $category[0]->shoes == 1 )
    {
        $data =1;
    }else
    if($category[0]->cloth == 2 || $category[0]->shoes == 2 )
    {
        $data=2;
    }else{
    
    $Fproduct = category::where('id',$input['category_id'])->first();
        
    $raw_query="SELECT CASE WHEN name LIKE '%lot%' THEN 1 ELSE 0 END as cloth, CASE WHEN name LIKE '%hoes%' THEN 2 ELSE 0 END as shoes FROM `categories` where  id=".$Fproduct->parent_id;
    $category = DB::select( DB::raw($raw_query) );

    if($category[0]->cloth == 1 || $category[0]->shoes == 1 )
    {
        $data =1;
    }else
    if($category[0]->cloth == 2 || $category[0]->shoes == 2 )
    {
        $data=2;
    }

    }

    if($data ==1)
    {
        $sizes = array("XXS", "XS","S","M","L", "XL","XXL" );
        $material=array("Chiffon","Cotton","Crepe","Denim","Lace","Leather","Linen","Satin","Silk","Synthetics","Velvet","Wool");

    }else
    if($data ==2)
    {
        $sizes=['UK2/US5/EU35','UK3/US6/EU36','UK4/US7/EU37','UK5/US8/EU38','UK6/US9/EUR39','UK7/US10/EU40','UK8/US11/EU41','UK9/US12/EUR42'];
        $material=array("Leather","Canvas","Textiles","Natural Rubber","Synthetics","Foam","Denim");

    }
    else{
        $sizes=['Free Size'];
        $material=['No'];

    }

    $resposne['sizes']=$sizes;
    $resposne['material']=$material;

    $responses['status'] = 200;
    $responses['message'] = 'True';
    $responses['data'] = $resposne;

      return response()->json($responses, 200);
    } catch (\Exception $e) {
        return response()->json([], 200);
    }
}
}

