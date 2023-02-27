@extends('layouts.front-end.app')

@section('title', \App\CPU\translate('add_custom_product'))

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid main-card rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
    <!--<nav aria-label="breadcrumb">-->
    <!--    <ol class="breadcrumb">-->
    <!--     @if(auth('customer')->check())-->
    <!--        <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('add_custom_product')}}</li>-->
    <!--        @endif-->
    <!--    </ol>-->

    <!--</nav>-->
    <div class="row">
        <div class="col-12">
            <div class="card o-hidden border-0 shadow-lg my-4">
                <div class="card-body ">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                
                                <div class="text-center mb-2 ">
                                    <h3 style="color:#EC9BA2 !important" class="" > {{\App\CPU\translate('Custom')}} {{\App\CPU\translate('Product')}}</h3>
                                     @if (auth('customer')->id() == '')
                                   
                                         <a href="{{route('customer.auth.login')}}">  <h5 style="margin-left: 94%;color: pink;"><i class="czi-menu align-middle mt-n1 mr-2"></i> List</h5></a>
                                    @else
                                       <a href="custom_product_list">  <h5 style="margin-left: 94%;color: pink;"><i class="czi-menu align-middle mt-n1 mr-2"></i> List</h5></a>
                                    @endif 
                                 
                                   
                                </div>
                                <form class="user" action="{{route('customerstore')}}" method="post" enctype="multipart/form-data" style="padding: 33px;border: 1px solid #d3d3d35e;">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                             <label class="input-label" for="priority">{{\App\CPU\translate('Name')}}</label>
                                            <input type="text" class="form-control form-control-user" id="name" name="name" value="{{ old('name', 'default value') }}" placeholder="{{\App\CPU\translate('name')}}" required>
                                        </div>
                                        
                                         <div class="col-md-6 ">
                                        <label class="input-label" for="priority">{{\App\CPU\translate('Colors')}}</label>
                                        <select class="form-control" name="color[]" id="" required>
                                            @foreach($colors as $color)
                                            <option
                                            value="{{$color->code}}" {{$color->name==$color->name?'selected':''}}>{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                        
                                    <!--     <div class="col-md-6 mt">-->
                                    <!-- <label class="control-label">{{\App\CPU\translate('Youtube video link')}}</label>-->
                                    <!--<small class="badge badge-soft-danger"> ( {{\App\CPU\translate('optional, please provide embed link not direct link')}}. )</small>-->
                                    <!--        <input type="url" class="form-control form-control-user" id="" name="url" value="{{old('url')}}" placeholder="{{\App\CPU\translate('url')}}">-->
                                    <!--</div>-->
                                   
                                    </div>

                                    <div class="form-group row mt-3 mb-2">
                                        <div class="col-md-12 ">
                                              <label class="input-label" for="priority">{{\App\CPU\translate('Description')}}</label>
                                            <Textarea type="description" class="editor form-control form-control-user" id="description" name="description" value="{{old('description')}}" placeholder="{{\App\CPU\translate('description')}}" required></Textarea>
                                        </div>
                                       </div>
                                    
                                    
                                    
                                  <div class="form-group row mt-3 mb-2">
                                  <div class="col-md-6 ">
                                        <label class="input-label" for="priority">{{\App\CPU\translate('Category')}}</label>
                                        <select class="js-example-basic-multiple form-control"
                                            name="category_id"
                                            onchange="getRequest('{{route('get-categories')}}?parent_id='+this.value,'sub-category-select','select')"
                                            required>>
                                        
                                            @foreach($categories as $category)
                                            <option
                                            value="{{$category->id}}" {{$category->name==$category->name?'selected':''}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="col-md-6">
                                        <label for="name">{{\App\CPU\translate('Sub_category')}}</label>
                                        <select class="js-example-basic-multiple form-control"
                                                name="sub_category_id" id="sub-category-select"
                                                onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-sub-category-select','select')">
                                        </select>
                                    </div>
                                 
                                  
                                   </div>
                                 <div class="form-group">
                                <div class="row">
                                     <div class="col-md-4 ">
                                        <label class="input-label" for="priority">{{\App\CPU\translate('Size')}}</label>
                                        
                                          <input type="text" name="size" id="size" class="form-control"
                                                       accept="" value="{{ old('size', 'default value') }}">
                                        <!--<select class="form-control" name="quantity" id="">-->
                                        <!-- <option value="1">1</option>-->
                                        <!--  <option value="2">2</option>-->
                                        <!--   <option value="3">3</option>-->
                                        <!--    <option value="4">4</option>-->
                                        <!--     <option value="5">5</option>-->
                                        <!--      <option value="6">6</option> -->
                                        <!--       <option value="7">7</option>-->
                                        <!--        <option value="8">8</option>-->
                                        <!--         <option value="9">9</option>-->
                                        <!--         <option value="10">10</option>-->
                                        <!--         <option value="10">10 + more</option>-->
                                        <!--</select>-->
                                    </div>
                                    
                                     <div class="col-md-4 ">
                                        <label class="input-label" for="priority">{{\App\CPU\translate('Material')}}</label>
                                        
                                          <input type="text" name="material" id="material" class="form-control"
                                                       accept="" value="{{ old('material', 'default value') }}">
                               
                                    </div>
                                    
                                    
                                      <div class="col-md-4 ">
                                                <label class="input-label" for="priority">{{\App\CPU\translate('Images')}}(if any)</label>
                                            <div class="custom-file" style="text-align: left">
                                                <input type="file" name="images[]" id="BannerUpload" class="custom-file-input"
                                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" style="overflow: hidden; padding: 2%">
                                                <label class="custom-file-label" for="BannerUpload">{{\App\CPU\translate('Upload')}} {{\App\CPU\translate('Image')}}</label>
                                            </div>
                                        </div>
                                    
                                    <!--<div class="col-md-6">-->
                                    <!--    <label for="name">{{\App\CPU\translate('Unit')}}</label>-->
                                    <!--    <select-->
                                    <!--        class="js-example-basic-multiple form-control"-->
                                    <!--        name="unit">-->
                                    <!--        @foreach(\App\CPU\Helpers::units() as $x)-->
                                    <!--            <option-->
                                    <!--                value="{{$x}}" {{old('unit')==$x? 'selected':''}}>{{$x}}</option>-->
                                    <!--        @endforeach-->
                                    <!--    </select>-->
                                    <!--</div>-->
                                </div>
                            </div>
                                   
                                  <!-- <div class="form-group row mt-3 mb-2">-->

                                  <!--   <div class="col-md-6 ">-->
                                  <!--              <label class="input-label" for="priority">{{\App\CPU\translate('Images')}}</label>-->
                                  <!--          <div class="custom-file" style="text-align: left">-->
                                  <!--              <input type="file" name="images[]" id="BannerUpload" class="custom-file-input"-->
                                  <!--                     accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" style="overflow: hidden; padding: 2%">-->
                                  <!--              <label class="custom-file-label" for="BannerUpload">{{\App\CPU\translate('Upload')}} {{\App\CPU\translate('Banner')}}</label>-->
                                  <!--          </div>-->
                                  <!--      </div>-->
                                  <!--</div>-->
                                   
                                    <div class="mb-3 pt-2 imageThubnail" style="display:none;width:100px">
                                      
                                        <div class="pb-1">
                                            <center>
                                                <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewerBanner"
                                                     src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                            </center>
                                        </div>
        
                                    </div>
                                      @if (auth('customer')->id() == '')
                                    <a href="{{route('customer.auth.login')}}" class="btn btn-primary btn-user mt-2" style="margin-left: 43%;">
                                        {{\App\CPU\translate('Submit')}} {{\App\CPU\translate('Request')}} 
                                    
                                        </a>
                                    @else
                                        <button type="submit" class="btn btn-primary btn-user mt-2" style="margin-left: 43%;">{{\App\CPU\translate('Submit')}} {{\App\CPU\translate('Request')}} 
                                    </button>
                                    @endif
                                   
                                </form>
                                <hr>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
</script>
@push('script')
@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
<script>
    $('#inputCheckd').change(function () {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#apply').removeAttr('disabled');
            } else {
                $('#apply').attr('disabled', 'disabled');
            }

        });

    $('#exampleInputPassword ,#exampleRepeatPassword').on('keyup',function () {
        var pass = $("#exampleInputPassword").val();
        var passRepeat = $("#exampleRepeatPassword").val();
        if (pass==passRepeat){
            $('.pass').hide();
        }
        else{
            $('.pass').show();
        }
    });
    $('#apply').on('click',function () {

        var image = $("#image-set").val();
        if (image=="")
        {
            $('.image').show();
            return false;
        }
        var pass = $("#exampleInputPassword").val();
        var passRepeat = $("#exampleRepeatPassword").val();
        if (pass!=passRepeat){
            $('.pass').show();
            return false;
        }


    });
    function Validate(file) {
        var x;
        var le = file.length;
        var poin = file.lastIndexOf(".");
        var accu1 = file.substring(poin, le);
        var accu = accu1.toLowerCase();
        if ((accu != '.png') && (accu != '.jpg') && (accu != '.jpeg')) {
            x = 1;
            return x;
        } else {
            x = 0;
            return x;
        }
    }

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

    function readlogoURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewerLogo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function readBannerURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewerBanner').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#LogoUpload").change(function () {
        readlogoURL(this);
    });
    $("#BannerUpload").change(function () {
        readBannerURL(this);
        $(".imageThubnail").css("display", "block");

    });
</script>

<!-- ck editor -->



<!-- ck editor -->




@endpush
@endsection