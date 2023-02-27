<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Chatting;
use App\CPU\Convert;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Storage;
use App\CPU\ImageManager;
use App\Model\Shop;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;

class ChatController extends Controller
{
    public function chat_with_seller(Request $request)
    {
          $storag = [];
        try {
            $last_chat = Chatting::with(['seller_info', 'customer', 'shop'])->where('user_id', $request->user()->id)
                ->orderBy('created_at', 'DESC')
                ->first();
    
            if (isset($last_chat)) {

                $chattings = Chatting::with(['seller_info', 'customer', 'shop'])->join('shops', 'shops.id', '=', 'chattings.shop_id')
                    ->select('chattings.*', 'shops.name', 'shops.image')
                    ->where('chattings.user_id', $request->user()->id)
                    ->where('shop_id', $last_chat->shop_id)
                    ->get();

                $unique_shops = Chatting::with(['seller_info', 'shop'])
                    ->where('user_id', $request->user()->id)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->unique('shop_id');

                $store = [];
               $storage = [];
              
                foreach ($unique_shops as $shop) {
                    array_push($store, $shop);
                }
              
            
              

                return response()->json([
                    'last_chat' => $last_chat,
                    'chat_list' => $chattings,
                    'unique_shops' => $store,
                ], 200);
            } else {
                return response()->json($last_chat, 200);
            }

        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function messages(Request $request)
    {
        // dd(Auth::User()->id);
         $storage = [];
        try {
            $messages = Chatting::with(['seller_info', 'customer', 'shop'])->where('user_id', $request->user()->id)
                ->where('shop_id', $request->shop_id)
                ->get();
           
            return response()->json($messages, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function messages_store(Request $request)
    {
        // dd($request->all());
        try {
            // if ($request->message == '') {
            //     return response()->json(translate('type something!'));
            // } else {
                $shop = Shop::find($request->shop_id);
                DB::table('chattings')->insert([
                    'user_id' => $request->user()->id,
                    'shop_id' => $request->shop_id,
                    'seller_id' => $shop->seller_id,
                    'message' => $request->message,
                    'images' =>$request->images,
                    'videos' =>$request->videos,
                    'sent_by_customer' => 1,
                    'seen_by_customer' => 0,
                    'created_at' => now(),
                ]);

                return response()->json(['message' => translate('sent')], 200);
            // }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }
      public function upload_images(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'type' => 'required|in:product,thumbnail,meta',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $path = $request['type'] == 'product' ? '' : $request['type'] . '/';
        $image = ImageManager::upload('product/' . $path, 'png', $request->file('image'));

        return response()->json(['image_name' => $image, 'type' => $request['type']], 200);
    }
     public function chat_video(Request $request)
   { 
    $id = Auth::User()->id;
   
    $validator = Validator::make($request->all(), [ 
            
         
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
        $filePath = 'videos/' . $fileName;
 
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->video));
 
        // File URL to access the video in frontend
           $url = Storage::disk('public')->url($filePath);
         
           
           
             $response['status'] = 200;
             $response['error'] = 'True';
            
             $response['video'] = $fileName;
             
             return response()->json($response);     
         }
   }
}
