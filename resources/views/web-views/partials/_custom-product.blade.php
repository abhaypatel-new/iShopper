@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))

<style>
    .quick-view{
        display: none;
        padding-bottom: 8px;
    }
    .product-single-hover{
        box-shadow: 0px 0px 5px rgba(0, 113, 220, 0.15);
        border-radius: 5px;
    }
    .quick-view , .single-product-details{
        background: #ffffff;
    }
    .product-single-hover:hover > .single-product-details {
        
        margin-top:-39px;
    }
    .product-single-hover:hover >  .quick-view{
        display: block;
    }
</style>
  @if(auth('customer')->id() == $product->custom_product['user_id'])
<div class="product-single-hover" >
    <div class="inline_product clickable d-flex justify-content-center" 
            style="cursor: pointer;max-height: 193px;min-height: 193px;background:{{$web_config['primary_color']}}10;background-position: center center;background-size: cover;">
        @if($product->discount > 0)
            <div class="d-flex" style="left:5px;top:5px;position: absolute">
                    <span class="for-discoutn-value p-1 pl-2 pr-2">
                    @if ($product->discount_type == 'percent')
                            {{round($product->discount,2)}}%
                        @elseif($product->discount_type =='flat')
                            {{\App\CPU\Helpers::currency_converter($product->discount)}}
                        @endif
                        {{\App\CPU\translate('off')}}
                    </span>
            </div>
        @else
            <div class="d-flex justify-content-end for-dicount-div-null">
                <span class="for-discoutn-value-null"></span>
            </div>
        @endif
        
       
        <div class="d-flex d-block center-div element-center" style="cursor: pointer;">
            <a href="{{route('custom-product',$product->custom_product->id)}}">
                 @foreach (json_decode($product->custom_product->images) as $key => $photo)
                  
                <img src="{{asset('storage/app/public/custom/product')}}/{{$photo}}"
                  style="width: 100%;border-radius:5px;">
                       @endforeach
                          
            </a>
        </div>
    </div>
    <div class="single-product-details" style="position:relative;height:145px;padding-top:10px; border-radius: 0px 0px 5px 5px;">
        <div class="text-{{Session::get('direction') === "rtl" ? 'right pr-3' : 'left pl-3'}}">
            <a href="{{route('product',$product->id)}}">
                {{ Str::limit($product->custom_product['name'], 23) }}
            </a>
        </div>
        <div class="rating-show justify-content-between text-center">
            <span class="d-inline-block font-size-sm text-body">
                @for($inc=0;$inc<5;$inc++)
                    @if($inc<$overallRating[0])
                        <i class="sr-star czi-star-filled active"></i>
                    @else
                        <i class="sr-star czi-star" style="color:#fea569 !important"></i>
                    @endif
                @endfor
                <label class="badge-style">({{$product->reviews_count ? '$product->reviews_count' : '0' }})</label>
            </span>
        </div>
        <div class="justify-content-between text-center">
            <div class="product-price text-center">
                @if($product->custom_product->discount > 0)
                    <strike style="font-size: 12px!important;color: #E96A6A!important;">
                        {{\App\CPU\Helpers::currency_converter($product->custom_product->quantity)}}
                    </strike><br>
                @endif
                <span class="text-accent">
                    {{\App\CPU\Helpers::currency_converter(
                        $product->offer-(\App\CPU\Helpers::get_product_discount($product,$product->custom_product->quantity))
                    )}}
                </span>
            </div>
        </div>
        
    </div>
    <div class="text-center quick-view" >
        @if(Request::is('product/*'))
            <a class="btn btn-primary btn-sm" href="{{route('product',$product->id)}}">
                <i class="czi-forward align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('View')}}
            </a>
        @else
            <a class="btn btn-primary btn-sm"
            style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
               onclick="quickViewgg('{{$product->custom_product_id}}')">
                <i class="czi-eye align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('Quick')}} {{\App\CPU\translate('View')}}
            </a>
        @endif
        @endif
      
    </div>
</div>
