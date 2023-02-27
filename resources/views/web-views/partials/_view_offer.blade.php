@php
    $overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews);
    $rating = \App\CPU\ProductManager::get_rating($product->reviews);
    $productReviews = \App\CPU\ProductManager::get_product_review($product->id);

@endphp

<style>
    .product-title2 {
        font-family: 'Roboto', sans-serif !important;
        font-weight: 400 !important;
        font-size: 22px !important;
        color: #000000 !important;
        position: relative;
        display: inline-block;
        word-wrap: break-word;
        overflow: hidden;
        max-height: 1.2em; / (Number of lines you want visible)  (line-height) */
        line-height: 1.2em;
    }

    /*.cz-product-gallery {*/
    /*    display: block;*/
    /*}*/

    .cz-preview {
        width: 100%;
        margin-top: 0;
        margin- {{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;
        max-height: 100% !important;
    }

    .cz-preview-item > img {
        width: 80%;
    }

    .details {
        border: 1px solid #E2F0FF;
        border-radius: 3px;
        padding: 16px;
    }

    img, figure {
        max-width: 100%;
        vertical-align: middle;
    }

    .cz-thumblist-item {
        display: block;
        position: relative;
        width: 64px;
        height: 64px;
        margin: .625rem;
        transition: border-color 0.2s ease-in-out;
        border: 1px solid #E2F0FF;
        border-radius: .3125rem;
        text-decoration: none !important;
        overflow: hidden;
    }

    .for-hover-bg {
        font-size: 18px;
        height: 45px;
    }

    .cz-thumblist-item > img {
        display: block;
        width: 80%;
        transition: opacity .2s ease-in-out;
        max-height: 58px;
        opacity: .6;
    }
    #add-to-cart-form .btn{
        padding: 2px 20px !important;
    }

    #add-to-cart-form .table th, .table td {
    vertical-align: middle !important;
    text-align: center;
    }

    @media (max-width: 767.98px) and (min-width: 576px) {
        .cz-preview-item > img {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .cz-thumblist {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-pack: center;
            justify-content: center;
            margin-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 0;
            padding-top: 1rem;
            padding-right: 22px;
            padding-bottom: 10px;
        }

        .cz-thumblist-item {
            margin: 0px;
        }

        .cz-thumblist {
            padding-top: 8px !important;
        }

        .cz-preview-item > img {
            width: 100%;
        }

    }
</style>

<div class="modal-header rtl">
    <div>
        <h4 class="modal-title product-title">
            <a class="product-title2" href="{{route('product',$product->id)}}" data-toggle="tooltip"
               data-placement="right"
               title="Go to product page">{{$product['name']}}
                <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-2' : 'right ml-2'}} font-size-lg" style="margin-right: 0px !important;"></i>
            </a>
        </h4>
    </div>
    <div>
        <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>

<div class="modal-body rtl">
    <div class="row ">
        <div class="col-lg-4 col-md-6">
            <div class="cz-product-gallery">
                <div class="cz-preview">
                  
               
                            <!--<div class="cz-preview-item d-flex align-items-center justify-content-center  {{$product->custom_product->images !=null?'active':''}}">-->
                            <!--    <img class="show-imag img-responsive" style="max-height: 500px!important;"-->

                            <!--         src="{{asset('storage/app/public/custom/product')}}/{{$product->custom_product->images}}"-->
                            <!--         alt="Product image" width="">-->
                            <!--</div>-->
                        @if($product->custom_product->images!=null && json_decode($product->custom_product->images)>0)
                        @foreach (json_decode($product->custom_product->images) as $key => $photo)
                            <div class="cz-preview-item d-flex align-items-center justify-content-center  {{$key==0?'active':''}}">
                                <img class="show-imag img-responsive" style="max-height: 500px!important;" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"

                                     src="{{asset('storage/app/public/custom/product')}}/{{$photo}}"
                                     alt="Product image" width="">
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <div class="table-responsive" style="max-height: 515px; padding: 0px;">
                        <div class="d-flex">
                          
                                    <div class="cz-thumblist">
                                        <a href="javascript:" class=" cz-thumblist-item d-flex align-items-center justify-content-center">
                                            <img class="click-img" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" src="{{asset('storage/app/public/custom/product/thumbnail')}}/{{$product->custom_product->thumbnail}}"
                                                
                                                 alt="Product thumb">
                                        </a>
                                    </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product details-->
        <div class="col-lg-8 col-md-6 mt-md-0 mt-sm-3">
            <div class="details" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                <a href="{{route('product',$product->id)}}" class="h3 mb-2 product-title"></a>
                <div class="d-flex align-items-center mb-2 pro">
                </div>
                <form id="add-to-cart-form" class="mb-2">
                    @csrf
                    <!--<input type="hidden" name="id" value="{{ $product->id }}">-->
                      <table class="table table-bordered data-table " id="example" style="width:100%;">
							<thead>
                         <thead class="thead-light">
                    <tr>

                        <th class="table-column-pl-0">{{\App\CPU\translate('Seller Name')}}</th>
                         <th>{{\App\CPU\translate('Product Name')}}</th>
                        <th>{{\App\CPU\translate('Offers')}}</th>
                        <th>{{\App\CPU\translate('Action')}}</th>

                    </tr>
                    </thead>
                     @foreach($offers as $values)
         <tbody>

      <td>{{$values->sellers->f_name}}</td>
       <td>{{$values->custom_product->name}}</td>
       <td><a href="{{url('/')}}/product/{{$link->slug}}" target="_blank">View Offer</a></td>
        <td>
                        <button class="btn btn-secondary" onclick="buy_now_product_datas()"
                                type="button"  >
                            {{\App\CPU\translate('buy_now')}}
                        </button>
                        <!--<input type="hidden" id="id" value="{{$values->custom_product_id}}">-->
                          <input type="hidden" id="id" value="{{$values->custom_product_id}}">
                        <button class="btn btn-secondary string-limit"
                                onclick="addToCartproduct()"
                                type="button"
                                >
                            {{\App\CPU\translate('add_to_cart')}}
                        </button>
                          <button class="btn btn-secondary string-limit"type="button"
                                >
                              <a class="text-white" href="{{url('/')}}/product/{{$link->slug}}" target="_blank">  <i class="fa fa-envelope"></i>
                                            <span>{{\App\CPU\translate('chat')}}</span></a>
                           
                        </button>
                        <!--<button type="button" onclick="addWishlist('{{$product['id']}}')"-->
                        <!--        class="btn btn-dark for-hover-bg string-limit"-->
                        <!--        style="">-->
                        <!--    <i class="fa fa-heart-o {{Session::get('direction') === "rtl" ? 'ml-2' : 'mr-2'}}"-->
                        <!--       aria-hidden="true"></i>-->
                        <!--    <span class="countWishlist-{{$product['id']}}">{{$countWishlist}}</span>-->
                        <!--</button>-->
                </td>

        </tbody>
          @endforeach
                    </table>

                <!-- Quantity + Add to cart -->

                    {{--to do--}}

                </form>
                <!-- Product panels-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form11 input').on('change', function () {
        getVariantPrice();
    });

    $(document).ready(function() {
        $('.click-img').click(function(){
            var idimg = $(this).attr('id');
            var srcimg = $(this).attr('src');
            $(".show-imag").attr('src',srcimg);
        });
    });
</script>