@extends('layouts.back-end.app-seller')

@section('title',\App\CPU\translate('Product List'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard.index')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('Custom Products')}}</li>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-between justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 mb-1 col-md-4">
                                <h5>{{ \App\CPU\translate('Product')}} {{ \App\CPU\translate('Table')}} ({{ $products->total() }})</h5>
                                
                            </div>
    
                            
                            <div class="col-12 mb-1 col-md-5">
                                <form action="{{ url()->current() }}" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\translate('Search by Product Name')}}" aria-label="Search orders" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                           
                        </div>
                        
                    </div>
                    <div class="card-body" style="padding: 0">
                        <div class="table-responsive">
                            <table id="datatable"
                                   style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                   style="width: 100%">
                                <thead class="thead-light">
                                <tr> 
                              
                                    <th>{{\App\CPU\translate('SL#')}}</th>
                                     <th>{{\App\CPU\translate('created_at')}}</th>
                                    <th>{{\App\CPU\translate('Customer Name')}}</th>
                                    <th>{{\App\CPU\translate('Product Image')}}</th>
                                    <!--<th>{{\App\CPU\translate('Unit')}}</th>-->
                                    <th>{{\App\CPU\translate('Description')}}</th>
                                    <th>{{\App\CPU\translate('Offer status')}}</th>
                                   
                                    <th>{{\App\CPU\translate('Add')}} {{\App\CPU\translate('Offer')}}</th>
                                    <th style="width: 5px" class="text-center">{{\App\CPU\translate('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $k=>$p)
                                    <tr>
                                        <th scope="row">{{$products->firstitem()+ $k}}</th>
                                         <td>
                                            {{ date('d F Y', strtotime($p['created_at']))}}
                                        </td>
                                        <td><a href="{{route('seller.product.view',[$p['id']])}}">
                                                {{\Illuminate\Support\Str::limit($p['user']['f_name'],40)}}  {{$p['user']['l_name']}}
                                            </a></td>
                                        <td>
                                   
                                        <div class="avatar avatar-circle">
                                              @php $img =$p->thumbnail != ''?$p->thumbnail:'no-image-icon-6.png';
                                             
                                           @endphp 
                                        <img
                                            class="avatar-img" src="{{asset("storage/app/public/custom/product/thumbnail/$img")}}"
                                            alt="Image Description">
                                    </div>
                                  
                                            <!-- {{\App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($p['seller_id']))}} -->
                                        </td>
                                        <!--<td>-->
                                        <!--    {{$p['unit']}}-->
                                        <!--</td>-->
                                        <td>

                                        {!! \Illuminate\Support\Str::limit($p['description'],40) !!}
                                        </td>
                                        <td>
                                            @if($p->request_status == 0)
                                                <label class="badge badge-warning">{{\App\CPU\translate('New Request')}}</label>
                                            @elseif($p->request_status == 1)
                                                <label class="badge badge-success" style="background-color:#00c9a7 ! important">{{\App\CPU\translate('Offered')}}</label>
                                            @elseif($p->request_status == 2)
                                                <label class="badge badge-danger">{{\App\CPU\translate('Denied')}}</label>
                                            @endif
                                        </td>
                                        <td>
                             <a  class="btn btn-primary btn-sm"--   href="{{route('seller.product.custom.edit',[$p['id']])}}">
                                              
                                               
                                                <i class="tio-shopping-cart"></i>
                                            </a>
                                            
                                            
                                            
                                            <!--<label class="switch">-->
                                            <!--    <input type="checkbox" class="status"-->
                                            <!--           id="{{$p['id']}}" {{$p->status == 1?'checked':''}}>-->
                                            <!--    <span class="slider round"></span>-->
                                            <!--</label>-->
                                        </td>
                                        
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                                title="{{\App\CPU\translate('view')}}"
                                                href="{{route('seller.product.custom-view',[$p['id']])}}">
                                                <i class="tio-visible"></i>
                                            </a>
                                            <!--<a  class="btn btn-primary btn-sm"-->
                                            <!--    title="{{\App\CPU\translate('Edit')}}"-->
                                            <!--    href="{{route('seller.product.custom.edit',[$p['id']])}}">-->
                                            <!--    <i class="tio-forward"></i>-->
                                            <!--</a>-->
                                            <a  class="btn btn-danger btn-sm" href="javascript:"
                                                title="{{\App\CPU\translate('Delete')}}"
                                                onclick="form_alert('product-{{$p['id']}}','{{\App\CPU\translate("Want to delete this item")}} ?')">
                                               <i class="tio-add-to-trash"></i> 
                                            </a>
                                            <form action="{{route('seller.product.custom.delete',[$p['id']])}}"
                                                  method="post" id="product-{{$p['id']}}">
                                                @csrf @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Footer -->
                     <div class="card-footer">
                        {{$products->links()}}
                    </div>
                    @if(count($products)==0)
                        <div class="text-center p-4">
                            <img class="mb-3" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description" style="width: 7rem;">
                            <p class="mb-0">{{\App\CPU\translate('No data to show')}}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

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
                url: "{{route('seller.product.custom-status-update')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (data) {
                    if(data.success == true) {
                        toastr.success('{{\App\CPU\translate('Status updated successfully')}}');
                    }
                    else if(data.success == false) {
                        toastr.error('{{\App\CPU\translate('Status updated failed. Product must be approved')}}');
                        location.reload();
                    }
                }
            });
        });
    </script>
    <style>
    .selectize-input items has-options full has-items{
        height: 46px !important;
    }
    </style>
@endpush
