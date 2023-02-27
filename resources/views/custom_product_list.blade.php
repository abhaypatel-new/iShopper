@extends('layouts.front-end.app')

@section('title', \App\CPU\translate('Custom List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .czi-eye{
            color:#fff !important;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #banner-image-modal .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #banner-image-modal .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #banner-image-modal .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }
        @media (max-width: 500px) {
            #banner-image-modal .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }
        }
    </style>
@endpush
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm">
                    <h1 class="page-header-title">
                        <span class="badge badge-soft-dark ml-2"></span>
                    </h1>
                </div>
            </div>
            <!-- End Row -->

            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="tio-chevron-left"></i>
              </a>
            </span>

                <span class="hs-nav-scroller-arrow-next" style="display: none;">
              <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                <i class="tio-chevron-right"></i>
              </a>
            </span>

                <!-- Nav -->
              <!--   <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{\App\CPU\translate('Customer')}} {{\App\CPU\translate('List')}} </a>
                    </li>

                </ul> -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->
    <div><a href="{{url('/customer_products')}}" class="btn btn-primary" style="float:right;margin-right: 10px;">Add Product</a></div>
        <!-- Card -->
        <div class="card" style="margin-top: 100px">
            <!-- Header -->
            <div class="card-header">
                <div class="flex-between row justify-content-between align-items-center flex-grow-1 mx-1">
                            <div>
                                <div class="flex-start">
                                    <div><h5>{{ \App\CPU\translate('Customer')}} {{ \App\CPU\translate('Table')}}</h5></div>
                                    <div class="mx-1"><h5 style="color: red;"></h5></div>
                                </div>
                            </div>
                            <div style="width: 40vw">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                <input id="datatableSearch_" type="search" name="search" class="form-control"
                 placeholder="{{\App\CPU\translate('Search by Name or Email or Phone')}}" aria-label="Search orders" value="{{ Request::get('search') }}" required>
                                        <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table
                       style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       style="width: 100%"
                       data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                      }],
                     "order": [],
                     "info": {
                       "totalQty": "#datatableWithPaginationInfoTotalQty"
                     },
                     "search": "#datatableSearch",
                     "entries": "#datatableEntries",
                     "pageLength": 25,
                     "isResponsive": false,
                     "isShowPaging": false,
                     "pagination": "datatablePagination"
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="">
                           #
                        </th>
                         <th>{{\App\CPU\translate('Images')}}</th>
                        <th class="table-column-pl-0">{{\App\CPU\translate('Name')}}</th>
                        <th>{{\App\CPU\translate('Colors')}}</th>
                        <th>{{\App\CPU\translate('Offers')}}</th>
                        <!--<th>{{\App\CPU\translate('Url')}}</th>-->
                        <th>{{\App\CPU\translate('Description')}}</th>
                        <th>{{\App\CPU\translate('Action')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($product as $key=>$customer)
                        <tr class="">
                         <td>
                                {{$key+1}}
                         </td>
                      <td>
                   
                        <div class="avatar avatar-circle">
                        <a href="javascript:" onclick="quickViewgg('{{$customer->id}}')"> <img class="avatar-img" style="max-height: 80px;width: 80px;!important;" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     src="{{asset('storage/app/public/custom/product/thumbnail')}}/{{$customer->thumbnail}}"
                                     alt="" width="">
                                     </a>
                                 </div>
                           </td>
                            <td class="">
                                {{$customer->name}}
                            </td>
                           
                            <td>
                                @if($customer->color)
                                @foreach(json_decode($customer->color) as $colors)
                            <button class="btn" style="color:#fff; border: 1px solid;
                               text-align: center; background:{{$colors}} ">
                            </button>
                                @endforeach
                                 @endif
                            </td>
                            
                              <td class="">
                                  @if($customer->available_offers > 0)
                                  <span class="badge rounded-pill badge-success">{{$customer->available_offers}}</span>
                                  @else
                                   <span class="badge rounded-pill badge-danger">{{$customer->available_offers}}</span>
                                  
                                  @endif
                                
                            </td>
                             <!--<td>-->
                              <!--<a href="{{$customer->url}}">{!! \Illuminate\Support\Str::limit($customer->url,40) !!}   </a>                    </td>-->
                               <td>
                              {!! \Illuminate\Support\Str::limit($customer->description,40) !!}                         </td>
                            
                              <td> <div class="text-center quick-view">
                   @if(Request::is('product/*'))
            <a class="btn btn-primary btn-sm" href="{{route('product',$product->id)}}">
                <i class="czi-forward align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('View')}}
            </a>
                   @else
            <a class="btn btn-primary btn-sm"
            style="margin-top:0px;padding-top:5px;padding-bottom:5px;padding-left:10px;padding-right:10px;" href="javascript:"
               onclick="quickView12345('{{$customer->id}}')">
                <i class="czi-eye align-middle {{Session::get('direction') === "rtl" ? 'ml-1' : 'mr-1'}}"></i>
                {{\App\CPU\translate('View')}} {{\App\CPU\translate('Offers')}}
            </a>
             @if($customer->available_offers > 0)
                                    <a class="btn btn-primary btn-sm edit disabled"
                                                title="{{ \App\CPU\translate('Edit')}}"
                                               href="{{route('custom-edit',[$customer['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                  @else
                                   <a class="btn btn-primary btn-sm edit" style="cursor: pointer;"
                                                title="{{ \App\CPU\translate('Edit')}}"
                                               href="{{route('custom-edit',[$customer['id']])}}">
                                                <i class="tio-edit"></i>
                                            </a>
                                  
                                  @endif
           
             <a class="btn btn-danger btn-sm" style="cursor: pointer;"
                                                title="{{ \App\CPU\translate('Delete')}}"
                                               id="{{$product['id']}}" onclick="dlt('{{$customer->id}}')">
                                                <i class="tio-add-to-trash"></i>
                                            </a>
                    @endif
    </div>
</td>
       </tr>
                    @endforeach
                    </tbody>
                </table>
               </div>
                            <!-- End Table -->
                 <div class="card-footer">
                                            <!-- Pagination -->
                                 {!! $product->links() !!}

                                <!-- End Pagination -->
                              </div>
                         @if(count($product)==0)
                     <div class="text-center p-4">
                    <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                    <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                </div>
            @endif
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'd-none'
                    },
                    {
                        extend: 'excel',
                        className: 'd-none'
                    },
                    {
                        extend: 'csv',
                        className: 'd-none'
                    },
                    {
                        extend: 'pdf',
                        className: 'd-none'
                    },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                // language: {
                //     zeroRecords: '<div class="text-center p-4">' +
                //         '<img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">' +
                //         '<p class="mb-0">No data to show</p>' +
                //         '</div>'
                // }
            });

            $('#datatableSearch').on('mouseup', function (e) {
                var $input = $(this),
               // console($input);
                    oldValue = $input.val();

                if (oldValue == "") return;

                setTimeout(function () {
                    var newValue = $input.val();

                    if (newValue == "") {
                        // Gotcha
                        datatable.search('').draw();
                    }
                }, 1);
            });
        });
    </script>
    <script>
        
      
    </script>
    <script>
      
        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.customer.status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                }
            });
        });
    </script>
@endpush
