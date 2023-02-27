<?php

namespace App\Http\Controllers\api\v2\seller;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Chatting;
use App\Model\Shop;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\CPU\translate;

class ChatController extends Controller
{
    public function messages(Request $request)
    {
        $data = Helpers::get_seller_by_token($request);

        if ($data['success'] == 1) {
            $seller = $data['data'];
        } else {
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }
         $storage = [];
        try {
            $messages = Chatting::with(['seller_info', 'customer', 'shop'])->where('seller_id', $seller['id'])->latest()
            ->get();
           
            return response()->json($messages, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }
     public function single_user_chat(Request $request)
    {
        $data = Helpers::get_seller_by_token($request);

        if ($data['success'] == 1) {
            $seller = $data['data'];
        } else {
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }
         $storage = [];
        try {
            $messages = Chatting::where('seller_id', $seller['id'])->where('user_id', $request->user_id)->latest()
            ->get();
            
            return response()->json($messages, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function send_message(Request $request)
    {
        $data = Helpers::get_seller_by_token($request);

        if ($data['success'] == 1) {
            $seller = $data['data'];
        } else {
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }

        // if ($request->message == '') {
        //     return response()->json(translate('type something!'), 200);
        // } else {
            $shop_id = Shop::where('seller_id', $seller['id'])->first()->id;
            $message = $request->message;
            $time = now();

            DB::table('chattings')->insert([
                'user_id' => $request->user_id, //user_id == seller_id
                'shop_id' => $shop_id,
                'seller_id' => $seller['id'],
                'message' => $request->message,
                'images' => $request->images,
                'videos' =>$request->videos,
                'sent_by_seller' => 1,
                'seen_by_seller' => 0,
                'created_at' => now(),
            ]);
            return response()->json(['message' => $message, 'time' => $time]);
        // }
    }
     public function chat_video(Request $request)
   { 
     $data = Helpers::get_seller_by_token($request);
      if ($data['success'] == 1) {
            $seller = $data['data'];
        } else {
            return response()->json([
                'auth-001' => translate('Your existing session token does not authorize you any more')
            ], 401);
        }
   
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
