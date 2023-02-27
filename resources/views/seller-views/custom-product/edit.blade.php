@extends('layouts.back-end.app-seller')

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')


    <div class="content container-fluid">
        <!-- Page Heading -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('seller.product.custom.list')}}">{{\App\CPU\translate('Custom Product')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{ \App\CPU\translate('Edit')}}</li>
            </ol>
            
            
        </nav>
      

        <!-- Content Row -->
        <div class="row">
            
              <!--<div class="card-body" style="">-->
              <!--          <div class="table-responsive">-->
              <!--              <table id="datatable"-->
              <!--                     style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"-->
              <!--                     class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"-->
              <!--                     style="width: 100%">-->
              <!--                  <thead class="thead-light">-->
              <!--                  <tr> -->
                              
              <!--                      <th>{{\App\CPU\translate('SL#')}}</th>-->
              <!--                       <th>{{\App\CPU\translate('created_at')}}</th>-->
              <!--                      <th>{{\App\CPU\translate('Customer Name')}}</th>-->
              <!--                      <th>{{\App\CPU\translate('Product Image')}}</th>-->
                                    <!--<th>{{\App\CPU\translate('Unit')}}</th>-->
              <!--                      <th>{{\App\CPU\translate('Description')}}</th>-->
              <!--                      <th>{{\App\CPU\translate('Offer status')}}</th>-->
                                   
              <!--                      <th>{{\App\CPU\translate('Add')}} {{\App\CPU\translate('Offer')}}</th>-->
              <!--                      <th style="width: 5px" class="text-center">{{\App\CPU\translate('Action')}}</th>-->
              <!--                  </tr>-->
              <!--                  </thead>-->
              <!--                  <tbody>-->
                               
              <!--                  </tbody>-->
              <!--              </table>-->
              <!--              <tbody>-->
              <!--                    <tr>-->
                                      
              <!--                         <td>1</td>-->
              <!--                           <td>1</td>-->
              <!--                             <td>1</td>-->
              <!--                               <td>1</td>-->
              <!--                                 <td>1</td>-->
              <!--                                   <td>1</td>-->
              <!--                                    <td>1</td>-->
              <!--                                     <td>1</td>-->
                                                 
              <!--                        </tr>-->
                                
              <!--              </tbody>-->
                            
              <!--          </div>-->
              <!--      </div>  -->
            
     
            <div class="col-md-12">
                <form class="product-form" action="{{route('seller.product.custom.update',$product->id)}}" method="post"
                      enctype="multipart/form-data"
                      id="custom_product_form1">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')

                            @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#"
                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <a href="{{route('seller.product.add-new')}}" class="btn btn-primary float-right">
                                    <i class="tio-add-circle"></i>
                                    <span class="text">Add new product</span>
                                </a>
                        </div>
                                         
     <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr> 
                              
                                     <th>{{\App\CPU\translate('Date')}}</th>
                                       <th style="width: 5px" class="text-center">{{\App\CPU\translate('image')}}</th>
                                     <th>{{\App\CPU\translate('Product name')}}</th>
                                    <th>{{\App\CPU\translate('Category')}}</th>
                                    
                                    <th>{{\App\CPU\translate('Description')}}</th>
                           
                                    <th>{{\App\CPU\translate('size')}}</th>
                                    
                                    <th>{{\App\CPU\translate('color')}}</th>
                                   
                                    <th> {{\App\CPU\translate('Material')}}</th>
                                    <th>{{\App\CPU\translate('View')}}</th>
                                    
                                 
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fontincreases">
                                            {{ date('d F Y', strtotime($product['created_at']))}}
                                        </td>
                                        
                                         <td class="fontincreases">
                                             <div class="avatar avatar-circle">
                                             <?php $img =$product['thumbnail'] != ''?$product['thumbnail']:'no-image-icon-6.png';
                                             
                                          ?>
                                        <img
                                            class="avatar-img" src="{{asset("storage/app/public/custom/product/thumbnail/$img")}}"
                                            alt="Image Description">
                                    </div>
                                        </td>
                                        
                                        
                                        <td class="fontincreases">
                                             {{$product['name']}}
                                        </td>
                                        
                                        <td>
                                 -  </td>
                                        <td class="fontincreases">
                                                {!! Str::limit($product['description'], 50) !!}

                                             
                                        </td>
                                        <td class="fontincreases">
                                            {{$product['size']}}
                                        </td>
                                        <td class="fontincreases">
                                             {{$product['color']}}
                                        </td>
                                        <td class="fontincreases">
                                             {{$product['material']}}
                                        </td>
                                        <td class="fontincreases">
                                             <a class="btn btn-info btn-sm"
                                                title="{{\App\CPU\translate('view')}}"
                                                href="{{route('seller.product.custom-view',[$product['id']])}}">
                                                <i class="tio-visible"></i>
                                            </a>
                                        </td>
                                      
                                        
                                        
                                        
                                    </tr>
                                    
                               
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    
                    <div class="clearfix">
                         <div class="card mt-2 rest-part">
                           
                             
                         </div> 
                    </div>
              
                    <div class="card mt-2 rest-part" style="1px solid darkgray"> 
                     <div class="card-body">
                         <h5 style="font-size: 21px;">Our product</h5>
                          <div class="form-group">
                                <div class="row">
                                    <input type="hidden" name="customer_id" id="customer_id" value="{{$product['user_id']}}">
                                    <input type="hidden" name="seller_id" id="seller_id" value="{{$product['seller_id']}}">
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product['id']}}">
                                    
                                    
                                    <div class="col-md-8">
                                        <label for="name">Available Product</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="seller_product_id"
                                            id="SelExample"
                                             style="color: #EC9BA2!important;padding: 12px;">
                                            @foreach($sellerproducts as $product_sell)
                                                <option
                                                    value="{{$product_sell['id']}}" {{ $product_sell->id==$product->category_id ? 'selected' : ''}} >{{$product_sell['name']}} - {{$product_sell['purchase_price']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                   <!--<div class="col-md-6">-->
                                   <!--     <label class="control-label">{{\App\CPU\translate('Offer Price')}}</label>-->
                                   <!--     <input type="url" min="0" -->
                                   <!--            placeholder="Offer Price"-->
                                   <!--            name="seller_offer_price" class="form-control"-->
                                   <!--            value="">-->
                                   <!-- </div>-->
                                   
                                </div><br>
                                 <div class="row">
                                     
                                         <div class="col-md-8">
                                        <label class="control-label">{{\App\CPU\translate('Offer Price')}}</label>
                                        <input type="url" min="0" 
                                               placeholder="Offer Price"
                                               name="seller_offer_price" class="form-control"
                                               value="" readonly>
                                    </div>
                                     
                                 </div>
                                 <br>
                                  <div class="row">
                                     
                                         <div class="col-md-8">
                                        <label class="control-label">{{\App\CPU\translate('Description')}}</label>
                                       <textarea name="description" class="form-control">
                                           
                                       </textarea>
                                    </div>
                                     
                                 </div>
                                
                                
                                
                                
                                
                                
                                <br><br>
                                  <div>
                    
                </div> 
                            </div>
                            </div>
                         
                 </div>  
                 

                        <div class="card-body" style="display:none">
                            @foreach(json_decode($language) as $lang)
                                <?php
                                if (count($product['translations'])) {
                                    $translate = [];
                                    foreach ($product['translations'] as $t) {

                                        if ($t->locale == $lang && $t->key == "name") {
                                            $translate[$lang]['name'] = $t->value;
                                        }
                                        if ($t->locale == $lang && $t->key == "description") {
                                            $translate[$lang]['description'] = $t->value;
                                        }

                                    }
                                }
                                ?>
                                <div class="{{$lang != 'en'? 'd-none':''}} lang_form" id="{{$lang}}-form">
                                    <div class="form-group">
                                        <label class="input-label" for="{{$lang}}_name">{{ \App\CPU\translate('Name')}}
                                            ({{strtoupper($lang)}})</label>
                                        <input type="text" {{$lang == 'en'? 'required':''}} name="name"
                                               id="{{$lang}}_name"
                                               value="{{$translate[$lang]['name']??$product['name']}}"
                                               class="form-control" placeholder="New Product" required>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                    <div class="form-group pt-4">
                                        <label class="input-label">{{ \App\CPU\translate('description')}}
                                            ({{strtoupper($lang)}})</label>
                                           <!--   <Textarea type="description" class="editor form-control form-control-user" id="description" name="description" value="{{$product['description']}}" placeholder="{{\App\CPU\translate('description')}}" required></Textarea> -->
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card mt-2 rest-part" style="display:none">
                        <div class="card-header">
                            <h4>{{ \App\CPU\translate('General Info')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{ \App\CPU\translate('Category')}}</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="category_id"
                                            id="category_id"
                                            onchange="getRequest('{{route('get-categories')}}?parent_id='+this.value,'sub-category-select','select')">
                                            <option value="0" selected disabled>---{{ \App\CPU\translate('Select')}}---</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category['id']}}" {{$category->name==$category->name?'selected':''}} >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                      <div class="col-md-6">
                                        <label for="name">{{\App\CPU\translate('Quantity')}}</label>
                                        <!--<select-->
                                        <!--    class="js-example-basic-multiple js-states js-example-responsive form-control"-->
                                        <!--    name="units">-->
                                        <!--    @foreach(\App\CPU\Helpers::units() as $x)-->
                                        <!--        <option-->
                                        <!--            value={{$x}} {{ $product->unit==$x ? 'selected' : ''}}>{{$x}}</option>-->
                                        <!--    @endforeach-->
                                        <!--</select>-->
                                        
                                         <input type="text" name="name"
                                               id=""
                                               value="{{$product['quantity']}}"
                                               class="form-control" placeholder="">
                                    </div>
                                  
                                </div>
                            </div>
                            
                            
                            
                            
                          <input type="hidden" name="customer_id" value="{{$product['user_id']}}">
                         <!--   <div class="form-group">
                                <div class="row">
                                   

                                    <div class="col-md-6">
                                        <label for="name">{{\App\CPU\translate('Units')}}</label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control"
                                            name="units">
                                            @foreach(\App\CPU\Helpers::units() as $x)
                                                <option
                                                    value={{$x}} {{ $product->unit==$x ? 'selected' : ''}}>{{$x}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>

                    <div class="card mt-2 rest-part" style="display:none">
                        <div class="card-header">
                            <h4>{{\App\CPU\translate('Variations')}}</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="row">
                                     <div class="col-md-6">
                                        <label for="colors">
                                            {{\App\CPU\translate('Colors')}} :
                                        </label>
                                        <label class="switch">
                                            <input type="checkbox" class="status" name="colors_active" value="{{old('colors_active')}}" style="    padding: 4px;
padding:4px" >
                                            <span class="slider round"></span>
                                        </label>
                                        <select
                                            class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                            name="colors[]" multiple="multiple" id="colors-selector" disabled>
                                            @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                                <option value="{{ $color->code }}">
                                                    {{$color['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                      <div class="col-md-6">
                                          <div class="avatar avatar-circle">
                                          
                                        <img
                                            class="avatar-img" src=""
                                            alt="Image Description">
                                    </div>
                                  
                                        <!--<label class="control-label">{{\App\CPU\translate('price')}}</label>-->
                                        <!--<input type="text" min="0" step="0.01"-->
                                        <!--       placeholder=""-->
                                        <!--       name="offers" class="form-control" -->
                                        <!--       valu"{{$product['price']}}">-->
                                    </div>
                                 <!--<div>-->
                                 <!--           <label class="switch">-->
                                 <!--               <input type="checkbox" name="multiplyQTY"-->
                                 <!--                      id="" >-->
                                 <!--               <span class="slider round"></span>-->
                                 <!--           </label>-->
                                 <!--       </div>-->
    
                            </div>
                        </div>
                    </div>

                            
                    <!--<div class="card mt-2 rest-part">-->
                    <!--    <div class="card-header">-->
                    <!--        <h4>{{\App\CPU\translate('Product price & stock')}}</h4>-->
                    <!--    </div>-->
                    <!--    <div class="card-body">-->
                    <!--        <div class="form-group">-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-md-6">-->
                    <!--                    <label class="control-label">{{\App\CPU\translate('price')}}</label>-->
                    <!--                    <input type="text" min="0" step="0.01"-->
                    <!--                           placeholder="{{\App\CPU\translate('Unit price') }}"-->
                    <!--                           name="offers" class="form-control"-->
                    <!--                           value={{\App\CPU\BackEndHelper::usd_to_currency(!empty($offers->offer))?$offers->offer:''}} required>-->
                    <!--                </div>-->
                                   
                    <!--            </div>-->
                              
                    <!--            <div class="sku_combination pt-4" id="sku_combination">-->
                                  
                    <!--            </div>-->
                    <!--            <div class="row">-->
                    <!--                <div class="col-sm-6" id="quantity">-->
                    <!--                    <label-->
                    <!--                        class="control-label">{{\App\CPU\translate('total')}} {{\App\CPU\translate('Quantity')}} </label>-->
                    <!--                    <input type="number" min="0" value={{ $product->unit }} step="1"-->
                    <!--                           placeholder="{{\App\CPU\translate('Quantity') }}"-->
                    <!--                           name="unit" class="form-control" required>-->
                    <!--                </div>-->
                                  
                                   
                                      
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    </div>
                    <!--<div class="card mt-2 rest-part">-->
                    <!--    <div class="card-body">-->
                    <!--        <div class="row">-->
                    <!--            <div class="col-md-12 mb-4">-->
                    <!--                <label class="control-label">{{\App\CPU\translate('Youtube video link')}}</label>-->
                    <!--                <small class="badge badge-soft-danger"> ( {{\App\CPU\translate('optional, please provide embed link not direct link.')}} )</small>-->
                    <!--                <input type="text" value="{{$product['video_url']}}" name="video_link" placeholder="EX : https://www.youtube.com/embed/5R06LRdUCSE" class="form-control" required>-->
                    <!--            </div>-->

                    <!--            <div class="col-md-8">-->
                    <!--                <div class="form-group">-->
                    <!--                    <label>{{\App\CPU\translate('Upload product images')}}</label><small-->
                    <!--                        style="color: red">* ( {{\App\CPU\translate('ratio')}} 1:1 )</small>-->
                    <!--                </div>-->
                    <!--                <div class="" style="max-width:230px;">-->
                    <!--                    <div class="row" id="coba">-->
                    <!--                       @foreach (json_decode($product->images) as $key => $photo)-->
                    <!--                            <div class="col-6">-->
                    <!--                                <div class="card">-->
                    <!--                                    <div class="card-body">-->
                    <!--                                        <img style="width: 100%" height="auto"-->
                    <!--                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"-->
                    <!--                                             src="{{asset("storage/app/public/custom/product/$photo")}}"-->
                    <!--                                             alt="Product image">-->
                                                            
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        @endforeach-->
                                          
                    <!--                    </div>-->
                    <!--                </div>-->

                    <!--            </div>-->
                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="name">{{\App\CPU\translate('Upload thumbnail')}}</label><small-->
                                <!--            style="color: red">* ( {{\App\CPU\translate('ratio')}} 1:1 )</small>-->
                                <!--    </div>-->
                                <!--    <div style="max-width:200px;">-->
                                <!--        <div class="row" id="thumbnail"></div>-->
                                <!--    </div>-->
                                <!--</div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
             
                                   

                    <div class="card ">
                        <div class="row">
                            <div class="col-md-12" style="padding-top: 20px">
                                @if($product['request_status'] == 2)
                                    <button type="button" onclick="checkcustom()" class="btn btn-primary">{{ \App\CPU\translate('resubmit') }}</button>
                                @else
                                    <button type="button" onclick="checkcustom()" class="btn btn-primary">{{ \App\CPU\translate('Send request') }}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('public/assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        var imageCount = {{($product->images)}};
        var thumbnail = '{{\App\CPU\ProductManager::product_image_path('thumbnail').'/'.$product->thumbnail??asset('public/assets/back-end/img/400x400/img2.jpg')}}';
        $(function () {
            if (imageCount < 0) {
                $("#coba").spartanMultiImagePicker({
                    fieldName: 'images[]',
                    maxCount: imageCount,
                    rowHeight: 'auto',
                    groupClassName: 'col-6',
                    maxFileSize: '',
                    placeholderImage: {
                        image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                        width: '100%',
                    },
                    dropFileLabel: "Drop Here",
                    
                    onRenderedPreview: function (index) {

                    },
                    onRemoveRow: function (index) {

                    },
                    onExtensionErr: function (index, file) {
                        toastr.error('{{\App\CPU\translate('Please only input png or jpg type file')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    },
                    onSizeErr: function (index, file) {
                        toastr.error('{{\App\CPU\translate('File size too big')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                });
            }
            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: thumbnail,
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#meta_img").spartanMultiImagePicker({
                fieldName: 'meta_image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('Please only input png or jpg type file')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('{{\App\CPU\translate('File size too big')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }
        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{trans('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{trans('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');

            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }
        $('#colors-selector').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            update_sku();
        });


        function update_sku() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('seller.product.sku-combination')}}',
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data.view);
                    $('#sku_combination').addClass('pt-4');
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        };

        $(document).ready(function () {
            // color select select2
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
    </script>


    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('.textarea').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
    </script>
    {{--ck editor--}}

    <script>
        function checkcustom(){
       
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
          // var url = window.location.origin;
            var formData = new FormData(document.getElementById('custom_product_form1'));
            
           
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            $.ajax({
                url: '{{route('seller.product.custom.update',$product->id)}}',
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
                        $('#custom_product_form1').submit();
                    }
                }
            });
        };
    </script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <script>
        update_qty();

        function update_qty() {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", true);
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }

        $('input[name^="qty_"]').on('keyup', function () {
            var total_qty = 0;
            var qty_elements = $('input[name^="qty_"]');
            for (var i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });
    </script>

    <script>
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".rest-part").removeClass('d-none');
            } else {
                $(".rest-part").addClass('d-none');
            }
        })
            $(document).ready(function(){
 
   $('#SelExample').selectize({
          sortField: 'text'
      });
});
    </script>
    <style>
      
        .select2-search__field {
padding: 4px;
}
 .fontincreases {
font-size: 20px
}
.selectize-input items full has-options has-items{
        height: 50px;
    
}
    </style>
@endpush
