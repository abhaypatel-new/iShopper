<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CustomProduct;
use Illuminate\Support\Facades\Validator;

class SellerOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
          $validator = Validator::make($request->all(), [
           
            'customer_id' => 'required',
            'unit' => 'nullable',
            'offer' =>'required',
            'description' => 'required',
           
            
        ], [
            'customer_id.required' => 'Product name is required!',
            'offer.required' => 'Product images is required!',
               
        ]);
         $data = CustomProduct::where('seller_id', $id)->first(); 
        if (!empty($data)) {
            
            $activated = $data->update(['offers' => $request->offers, 'unit' => $request->unit, 'description' => $request->description]);
           Toastr::success('Product updated successfully.');
            return back();
            // return view('seller-views.custom-product.list', compact('products', 'search'));
        } else {
           
           Toastr::success('Product updation failed!.');
            return back();
        }
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
