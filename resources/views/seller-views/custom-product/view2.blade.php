@extends('layouts.back-end.app-seller')

@section('title', \App\CPU\translate('Product Preview'))

@push('css_or_js')
    <style>
        .checkbox-color label {
            width: 2.25rem;
            height: 2.25rem;
            float: left;
            padding: 0.375rem;
            margin-right: 0.375rem;
            display: block;
            font-size: 0.875rem;
            text-align: center;
            opacity: 0.7;
            border: 2px solid #d3d3d3;
            border-radius: 50%;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            transition: all 0.3s ease;
            transform: scale(0.95);
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <!-- Page Header -->
        <div class="page-header">
            <div class="flex-between row mx-1">
                <div>
                    <h1 style="color:#EC9BA2 !important" class="page-header-title">{{$product['name']}}</h1>
                </div>
                <div>
                    <a href="{{url()->previous()}}" class="btn btn-primary float-right">
                        <i class="tio-back-ui"></i> {{\App\CPU\translate('Back')}}
                    </a>
                </div>
            </div>
            @if($product['request_status'] == 2)
                <!-- Card -->
                <div class="card mb-3 mb-lg-5 mt-2 mt-lg-3 bg-warning">
                    <!-- Body -->
                    <div class="card-body text-center">
                        <span style="color:#EC9BA2 !important" class="text-dark">{{ $product['denied_note'] }}</span>
                    </div>
                </div>
            @endif
            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:">
                        {{\App\CPU\translate('Product reviews')}}
                    </a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center gx-md-5">
                    <!--<div class="col-md-auto mb-3 mb-md-0">-->
                    <!--    <div class="d-flex align-items-center">-->
                              
                    <!--        <img class="avatar avatar-xxl avatar-4by3 {{Session::get('direction') === "rtl" ? 'ml-4' : 'mr-4'}}"-->
                    <!--             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"-->
                    <!--             src="{{asset("storage/app/public/custom/product/thumbnail/$product->thumbnail")}}"-->
                    <!--             alt="Image Description">-->
                             
                    <!--        <div class="d-block">-->
                    <!--            <h4 class="display-2 text-dark mb-0">{{count($product->rating)>0?number_format($product->rating[0]->average, 2, '.', ' '):0}}</h4>-->
                    <!--            <p> of {{$product->reviews->count()}} {{\App\CPU\translate('reviews')}}-->
                    <!--                <span class="badge badge-soft-dark badge-pill {{Session::get('direction') === "rtl" ? 'mr-1' : 'ml-1'}}"></span>-->
                    <!--            </p>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <!--<div class="col-md">-->
                    <!--    <ul class="list-unstyled list-unstyled-py-2 mb-0">-->

                    <!--    @php($total=$product->reviews->count())-->
                        <!-- Review Ratings -->
                    <!--        <li class="d-flex align-items-center font-size-sm">-->
                    <!--            @php($five=\App\CPU\Helpers::rating_count($product['id'],5))-->
                    <!--            <span-->
                    <!--                class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">5 {{\App\CPU\translate('star')}}</span>-->
                    <!--            <div class="progress flex-grow-1">-->
                    <!--                <div class="progress-bar" role="progressbar"-->
                    <!--                     style="width: {{$total==0?0:($five/$total)*100}}%;"-->
                    <!--                     aria-valuenow="{{$total==0?0:($five/$total)*100}}"-->
                    <!--                     aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--            </div>-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$five}}</span>-->
                    <!--        </li>-->
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                    <!--        <li class="d-flex align-items-center font-size-sm">-->
                    <!--            @php($four=\App\CPU\Helpers::rating_count($product['id'],4))-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">4 {{\App\CPU\translate('star')}}</span>-->
                    <!--            <div class="progress flex-grow-1">-->
                    <!--                <div class="progress-bar" role="progressbar"-->
                    <!--                     style="width: {{$total==0?0:($four/$total)*100}}%;"-->
                    <!--                     aria-valuenow="{{$total==0?0:($four/$total)*100}}"-->
                    <!--                     aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--            </div>-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$four}}</span>-->
                    <!--        </li>-->
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                    <!--        <li class="d-flex align-items-center font-size-sm">-->
                    <!--            @php($three=\App\CPU\Helpers::rating_count($product['id'],3))-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">3 {{\App\CPU\translate('star')}}</span>-->
                    <!--            <div class="progress flex-grow-1">-->
                    <!--                <div class="progress-bar" role="progressbar"-->
                    <!--                     style="width: {{$total==0?0:($three/$total)*100}}%;"-->
                    <!--                     aria-valuenow="{{$total==0?0:($three/$total)*100}}"-->
                    <!--                     aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--            </div>-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$three}}</span>-->
                    <!--        </li>-->
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                    <!--        <li class="d-flex align-items-center font-size-sm">-->
                    <!--            @php($two=\App\CPU\Helpers::rating_count($product['id'],2))-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">2 {{\App\CPU\translate('star')}}</span>-->
                    <!--            <div class="progress flex-grow-1">-->
                    <!--                <div class="progress-bar" role="progressbar"-->
                    <!--                     style="width: {{$total==0?0:($two/$total)*100}}%;"-->
                    <!--                     aria-valuenow="{{$total==0?0:($two/$total)*100}}"-->
                    <!--                     aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--            </div>-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$two}}</span>-->
                    <!--        </li>-->
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                    <!--        <li class="d-flex align-items-center font-size-sm">-->
                    <!--            @php($one=\App\CPU\Helpers::rating_count($product['id'],1))-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'ml-3' : 'mr-3'}}">1 {{\App\CPU\translate('star')}}</span>-->
                    <!--            <div class="progress flex-grow-1">-->
                    <!--                <div class="progress-bar" role="progressbar"-->
                    <!--                     style="width: {{$total==0?0:($one/$total)*100}}%;"-->
                    <!--                     aria-valuenow="{{$total==0?0:($one/$total)*100}}"-->
                    <!--                     aria-valuemin="0" aria-valuemax="100"></div>-->
                    <!--            </div>-->
                    <!--            <span class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">{{$one}}</span>-->
                    <!--        </li>-->
                            <!-- End Review Ratings -->
                    <!--    </ul>-->
                    <!--</div>-->

                   <!-- <div class="col-12">
                        <hr>
                    </div>-->
                    <div class="col-4 pt-2">
                        <div class="flex-start">
                            <h4 class="border-bottom">{{$product['name']}}</h4>
                        </div>
                        <div class="flex-start">
                            <span>{{\App\CPU\translate('Price')}} : </span>
                            <span class="mx-1">
                            @if(!empty($offer))
                            {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($offer['offer']?$offer['offer']:00))}}</span>
                            @endif
                        </div>
                        
                        
                         <div class="flex-start">
                            <span>{{\App\CPU\translate('Size')}} : </span>
                            <span class="mx-1">
                           {{$product['size']}}</span>
                           
                        </div>
                        
                         <div class="flex-start">
                            <span>{{\App\CPU\translate('Description')}} : </span>
                            <span class="mx-1">
                           {{$product['description']}}</span>
                           
                        </div>
                        
                         <div class="flex-start">
                            <span>{{\App\CPU\translate('Category')}} : </span>
                            <span class="mx-1">
                           </span>
                           
                        </div>
                        
                          <div class="flex-start">
                            <span>{{\App\CPU\translate('Material')}} : </span>
                            <span class="mx-1">
                           {{$product['material']}}</span>
                           
                        </div>
                        
                        
                         <div class="flex-start">
                            <span>{{\App\CPU\translate('Customer Name')}} : </span>
                            <span class="mx-1">
                           </span>
                           
                        </div>
                        
                        
                        <!-- <div class="flex-start">-->
                        <!--    <span>{{\App\CPU\translate('description')}} : </span>-->
                        <!--    <span class="mx-1">-->
                        <!--   {{$product['description']}}</span>-->
                           
                        <!--</div>-->
                        
                        
                        
                        
                        
                        <!--  <div class="flex-start">-->
                        <!--    <span>{{\App\CPU\translate('category_id')}} : </span>-->
                        <!--    <span class="mx-1">-->
                        <!--    @if(!empty($category))-->
                        <!--    {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($product['category']?$product['category_id']:00))}}</span>-->
                        <!--    @endif-->
                        <!--</div>-->
                       
                        
                        <!--<div class="flex-start">-->
                        <!--    <span>{{\App\CPU\translate('Current Stock')}} : </span>-->
                        <!--    <span class="mx-1">{{ $product->current_stock }}</span>-->
                        <!--</div>-->
                    </div>

                    <div class="col-8 pt-2 border-left">

                        <span> @if(count(json_decode($product->color)) > 0)
                                <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="product-description-label mt-2">{{\App\CPU\translate('Available color')}}:
                                    </div>
                                </div>
                                <div class="col-10">
                                    <ul class="list-inline checkbox-color mb-1">
                                        @foreach (json_decode($product->color) as $key => $color)
                                            <li>

                                                <label style="background: {{ $color }};"
                                                       for="{{ $product->id }}-color-{{ $key }}"
                                                       data-toggle="tooltip"></label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif</span><br>
                        <span>
                        {{\App\CPU\translate('Product Image')}}

                     <div class="row">
 
                                            
     @foreach (json_decode($product->images) as $key => $photo)
                             <div class="col-md-3">
                                 <div class="card">
                                     <div class="card-body">
                                         <img style="width: 100%"
                                              onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                              src="{{asset("storage/app/public/custom/product/$photo")}}" alt="Product image">

                                     </div>
                                 </div>
                             </div>
                      @endforeach
                     </div>
                    </span>
                    </div>
                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->




<div class="card-body" style="background-color: #dddddd30;
    border: 10px 10ox;
    border-radius: 10px; display:none"> 
    <form class="product-form" action="{{route('seller.product.insert_bid')}}" method="post"
                      enctype="multipart/form-data"
                      id="custom_product_bid">
         @csrf

                            <div class="form-group">
                                <div class="row">
                                    
                                    <input type="hidden" name="customer_id" id="customer_id" value="{{$product['user_id']}}">
                                    <input type="hidden" name="seller_id" id="seller_id" value="{{$product['seller_id']}}">
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product['id']}}">
                                    
                                    
                                    <div class="col-md-6">
                                        <label for="name">Available Product</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="seller_name"
                                            id="SelExample"
                                             style="color: #EC9BA2!important;padding: 12px;">
                                            @foreach($sellerproducts as $product)
                                                <option
                                                    value="{{$product['id']}}" {{ $product->id==$product->category_id ? 'selected' : ''}} >{{$product['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                   <div class="col-md-6">
                                        <label class="control-label">{{\App\CPU\translate('Offer Price')}}</label>
                                        <input type="url" min="0" 
                                               placeholder="Offer Price"
                                               name="offer_price" class="form-control"
                                               value=""}} readonly>
                                    </div>
                                   
                                </div>
                                <br><br>
                                  <div>
                    <!--<a href="{{url()->previous()}}" class="btn btn-primary float-right">-->
                    <!--    <i class=""></i> {{\App\CPU\translate('Send request')}}-->
                    <!--</a>-->
                    <button type="button" onclick="insertBidsubmit()" class="btn btn-primary">{{ \App\CPU\translate('Send request') }}</button>
                </div> 
                            </div>
                            
                           </form>
                         
                
                            
                         </div>    
                                    
            
            
            
            
            
            <!-- End Table -->
          
            <!-- Footer -->
            <div class="card-footer">
              {!! $reviews->links() !!}
            </div>
            <!-- End Footer -->
        </div>









        <!-- Card -->
        <div class="card" style="display:none">
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table class="table table-borderless table-thead-bordered table-nowrap card-table"
                       style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                    <thead class="thead-light">
                    <tr>
                        <th>{{\App\CPU\translate('Reviewer')}}</th>
                        <th>{{\App\CPU\translate('Review')}}</th>
                        <th>{{\App\CPU\translate('Date')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($reviews as $review)
                        @if(isset($review->customer))
                        <tr>
                            <td>
                                <a class="d-flex align-items-center"
                                   href="{{route('admin.customer.view',[$review['customer_id']])}}">
                                    <div class="avatar avatar-circle">
                                        <img
                                            class="avatar-img"
                                            onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                            src="{{asset('storage/app/public/profile/')}}{{$review->customer->image??""}}"
                                            alt="Image Description">
                                    </div>
                                    <div class="{{Session::get('direction') === "rtl" ? 'mr-3' : 'ml-3'}}">
                                    <span class="d-block h5 text-hover-primary mb-0">{{$review->customer['f_name']??""}} {{$review->customer['l_name']??""}} <i
                                            class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                            title="Verified Customer"></i></span>
                                        <span class="d-block font-size-sm text-body">{{$review->customer->email??""}}</span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="text-wrap" style="width: 18rem;">
                                    <div class="d-flex mb-2">
                                        <label class="badge badge-soft-info">
                                            {{$review->rating}} <i class="tio-star"></i>
                                        </label>
                                    </div>
                                    <p>
                                        {{$review['comment']}}
                                    </p>
                                </div>
                            </td>
                            <td>
                                {{date('d M Y H:i:s',strtotime($review['created_at']))}}
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table -->
            @if(count($reviews)==0)
                <div class="text-center p-4">
                    <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                    <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                </div>
            @endif
            <!-- Footer -->
            <div class="card-footer">
              {!! $reviews->links() !!}
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script>
        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });
        $(document).ready(function () {
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
        
        
        $(document).ready(function(){
 
   $('#SelExample').selectize({
          sortField: 'text'
      });
});

 </script>
 
 
  <script>
        function insertBidsubmit(){
           
          // var url = window.location.origin;
            var formData = new FormData(document.getElementById('custom_product_bid'));
            
            
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            $.ajax({
                url: '{{route('seller.product.insert_bid')}}',
                method:'POST',
                 headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                   
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });

                        }
                    } else {
                        toastr.success('{{\App\CPU\translate('product updated successfully!')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#custom_product_bid').submit();
                    }
                }
            });
        };
    </script>
 
 
 
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

@endpush
