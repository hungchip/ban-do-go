@section('title')
    Trang chủ
@stop

@extends('pages.master')
@if (Session::has('order_success'))
    <script>
        alert("{{ Session::get('order_success') }}");
    </script>
@endif
@if (Session::has('contact_success'))
    <script>
        alert("{{ Session::get('contact_success') }}");
    </script>
@endif
@section('content')
    <!-- =====BANNER======== -->
    <section id="banner">
        <div class="owl-carousel owl-theme">
            @foreach ($all_banner as $key => $value)
                <div class="item">
                    <img src="upload/banner/{{ $value->banner_image }}" alt="">
                </div>
            @endforeach
        </div>
    </section>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" style="margin-top: 50px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            <strong>Thành công!</strong>{{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('danger'))
        <div class="alert alert-danger alert-dismissible" style="margin-top: 50px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            <strong>Không thành công!</strong>{{ Session::get('danger') }}
        </div>
    @endif
    <!-- ====WP-CONTENT====== -->
    <section id="wp-content">
        <div class="container-fluid">
            <!-- ====PRODUCT===== -->
            <section id="product">
                <div class="row">
                    <div class="col-md-12 title-cate">
                        <h2>Sản phẩm mới nhất</h2>
                    </div>

                    <!-- ------- -->
                    @foreach ($spmn as $key => $value_spmn)
                        <div class="col-md-3">
                            <div class="image-item">
                                <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value_spmn->product_name)) }}">
                                    <img class="img-product" src="upload/product/{{ $value_spmn->product_image }}"
                                        alt="">
                                </a>
                                <form action="{{ URL::to('/save-cart') }}" method="post">

                                    {{ csrf_field() }}
                                    <div class="image-tools">
                                        <button style="background: none;border: none;outline: none;" type="submit"
                                            class="add-cart" data-toggle="tooltip" data-id="{{ $value_spmn->product_id }}"
                                            data-placement="top" title="Thêm vào giỏ">
                                            <div class="cart-icon">
                                                <strong>+</strong>
                                            </div>
                                        </button>
                                        <input name="qty" type="hidden" value="1">
                                        <input name="productid_hidden" type="hidden"
                                            value="{{ $value_spmn->product_id }}">
                                        <!-- <input type="hidden" value="{{ $value_spmn->product_id }}" class="cart_product_id_{{ $value_spmn->product_id }}">
                                            <input type="hidden" value="{{ $value_spmn->product_name }}" class="cart_product_name_{{ $value_spmn->product_id }}">
                                            <input type="hidden" value="{{ $value_spmn->product_image }}" class="cart_product_image_{{ $value_spmn->product_id }}">
                                            <input type="hidden" value="{{ $value_spmn->product_price }}" class="cart_product_price_{{ $value_spmn->product_id }}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{ $value_spmn->product_id }}"> -->
                                    </div>
                                </form>
                            </div>

                            <div class="info-item">
                                <p>{{ $value_spmn->cate_name }}</p>
                                <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value_spmn->product_name)) }}"
                                    class="name-product">
                                    {{ $value_spmn->product_name }}
                                </a>
                                <p class="price">
                                    {{ number_format($value_spmn->product_price) }} ₫
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <!-- ------- -->
                </div>
            </section>
        </div>
        <div class="container-fluid">
            <section id="product">
                <div class="row">
                    <div class="col-md-12 title-cate">
                        <h2>Sản phẩm yêu thích</h2>
                    </div>

                    <!-- ------- -->
                    <div id="row_wishlist" class="row" style="width: 100%;">

                    </div>
                    <!-- ------- -->
                </div>
            </section>
        </div>
        <!-- =====ICON========= -->
        <section id="promotion">
            <div class="background">
                <div style="background-color: rgba(45, 45, 45, 0.8);">
                    <div class="container">
                        <div class="row pd-75">
                            <div class="col-md-4">
                                <div class="icon">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M128,332.8c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2s51.2-22.963,51.2-51.2
                                                            C179.2,355.763,156.237,332.8,128,332.8z M128,418.133c-18.825,0-34.133-15.309-34.133-34.133
                                                            c0-18.825,15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133C162.133,402.825,146.825,418.133,128,418.133z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="119.467" y="375.467" width="17.067" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M418.133,332.8c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2c28.237,0,51.2-22.963,51.2-51.2
                                                            C469.333,355.763,446.37,332.8,418.133,332.8z M418.133,418.133C399.309,418.133,384,402.825,384,384
                                                            c0-18.825,15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133C452.267,402.825,436.958,418.133,418.133,418.133z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="409.6" y="375.467" width="17.067" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M511.394,312.559l-51.2-128c-1.306-3.234-4.437-5.359-7.927-5.359H341.333c-4.719,0-8.533,3.823-8.533,8.533V384
                                                            c0,4.719,3.814,8.533,8.533,8.533h34.133v-17.067h-25.6v-179.2h96.623l48.444,121.105v58.095H460.8v17.067h42.667
                                                            c4.719,0,8.533-3.814,8.533-8.533v-68.267C512,314.65,511.795,313.574,511.394,312.559z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M341.333,110.933H8.533c-4.71,0-8.533,3.823-8.533,8.533V384c0,4.719,3.823,8.533,8.533,8.533h76.8v-17.067H17.067V128
                                                            H332.8v247.467H170.667v17.067h170.667c4.719,0,8.533-3.814,8.533-8.533V119.467C349.867,114.756,346.052,110.933,341.333,110.933
                                                            z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M401.067,281.6v-51.2H460.8v-17.067h-68.267c-4.719,0-8.533,3.823-8.533,8.533v68.267c0,4.719,3.814,8.533,8.533,8.533
                                                            h102.4V281.6H401.067z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="477.867" y="341.333" width="25.6" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect y="341.333" width="68.267" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="187.733" y="341.333" width="153.6" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M51.2,179.2c-4.71,0-8.533,3.823-8.533,8.533v76.8h17.067v-68.267h34.133V179.2H51.2z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="51.2" y="213.333" width="42.667" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M170.667,204.8c0-14.114-11.486-25.6-25.6-25.6h-25.6c-4.71,0-8.533,3.823-8.533,8.533v76.8H128v-68.267h17.067
                                                            c4.702,0,8.533,3.831,8.533,8.533c0,4.702-3.831,8.533-8.533,8.533c-4.71,0-8.533,3.823-8.533,8.533
                                                            c0,4.71,3.823,8.533,8.533,8.533c4.702,0,8.533,3.831,8.533,8.533v25.6h17.067v-25.6c0-6.554-2.475-12.535-6.537-17.067
                                                            C168.192,217.335,170.667,211.354,170.667,204.8z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="196.267" y="213.333" width="42.667" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M238.933,196.267V179.2h-42.667c-4.71,0-8.533,3.823-8.533,8.533V256c0,4.719,3.823,8.533,8.533,8.533h42.667v-17.067
                                                            H204.8v-51.2H238.933z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="264.533" y="213.333" width="42.667" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M307.2,196.267V179.2h-42.667c-4.719,0-8.533,3.823-8.533,8.533V256c0,4.719,3.814,8.533,8.533,8.533H307.2v-17.067
                                                            h-34.133v-51.2H307.2z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="42.667" y="281.6" width="264.533" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect x="34.133" y="76.8" width="76.8" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <rect y="76.8" width="17.067" height="17.067"></rect>
                                            </g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="icon-text">
                                    <h3>Giao hàng free</h3>
                                    Áp dụng trong thành phố cho các đơn hàng từ 200.000đ & dưới 2kg. <br> Siêu tiện lợi:
                                    Mạng lưới vận chuyển phủ khắp 63 tỉnh thành cùng quy trình xử lý đơn hàng khép kín và
                                    hoàn toàn tự động.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="icon">
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M480,143.686H378.752c7.264-4.96,13.504-9.888,17.856-14.304c25.792-25.952,25.792-68.192,0-94.144
                                                            c-25.056-25.216-68.768-25.248-93.856,0c-13.856,13.92-50.688,70.592-45.6,108.448h-2.304
                                                            c5.056-37.856-31.744-94.528-45.6-108.448c-25.088-25.248-68.8-25.216-93.856,0C89.6,61.19,89.6,103.43,115.36,129.382
                                                            c4.384,4.416,10.624,9.344,17.888,14.304H32c-17.632,0-32,14.368-32,32v80c0,8.832,7.168,16,16,16h16v192
                                                            c0,17.632,14.368,32,32,32h384c17.632,0,32-14.368,32-32v-192h16c8.832,0,16-7.168,16-16v-80
                                                            C512,158.054,497.632,143.686,480,143.686z M138.08,57.798c6.496-6.528,15.104-10.112,24.256-10.112
                                                            c9.12,0,17.728,3.584,24.224,10.112c21.568,21.696,43.008,77.12,35.552,84.832c0,0-1.344,1.056-5.92,1.056
                                                            c-22.112,0-64.32-22.976-78.112-36.864C124.672,93.318,124.672,71.302,138.08,57.798z M240,463.686H64v-192h176V463.686z
                                                             M240,239.686H32v-64h184.192H240V239.686z M325.44,57.798c12.992-13.024,35.52-12.992,48.48,0
                                                            c13.408,13.504,13.408,35.52,0,49.024c-13.792,13.888-56,36.864-78.112,36.864c-4.576,0-5.92-1.024-5.952-1.056
                                                            C282.432,134.918,303.872,79.494,325.44,57.798z M448,463.686H272v-192h176V463.686z M480,239.686H272v-64h23.808H480V239.686z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="icon-text">
                                    <h3>Quà tặng đặc biệt</h3>
                                    Nhiều phần quà hấp dẫn khi bạn trở thành khách hàng thân thiết,cùng những ưu đãi khi mua
                                    các sản phẩm và nhiều phần quà khi tích lũy đủ số điểm mua hàng.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="icon">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M260.348,352.204c-4.503,0-8.153,3.65-8.153,8.153v17.39c0,4.503,3.65,8.153,8.153,8.153s8.153-3.65,8.153-8.153v-17.39
                                                            C268.501,355.854,264.851,352.204,260.348,352.204z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M507.064,235.387c-3.182-3.182-7.411-4.934-11.912-4.934c-0.001,0-0.002,0-0.003,0l-20.929,0.003
                                                            c-0.265,0-0.447-0.298-0.503-0.574c-5.753-28.218-18.654-54.82-37.31-76.932c-18.032-21.372-41.127-38.18-66.88-48.737
                                                            c-4.154-17.536-12.925-35.616-30.222-49.207c-16.746-13.158-33.612-15.69-34.321-15.792c-2.336-0.333-4.709,0.363-6.495,1.912
                                                            c-1.786,1.549-2.811,3.795-2.811,6.159v44.026h-29.588c-7.312-25.09-30.5-43.482-57.919-43.482
                                                            c-28.001,0-51.603,19.177-58.376,45.085c-40.312,5.491-77.4,25.021-104.92,55.386C15.937,180.233,0,221.569,0,264.696
                                                            c0,96.801,50.255,175.564,65.659,197.397c4.758,6.745,12.551,10.773,20.846,10.773h34.701c14.086,0,25.546-11.46,25.546-25.546
                                                            v-11.285c8.781,1.352,17.702,2.045,26.633,2.045h78.811v9.24c0,14.086,11.46,25.546,25.546,25.546h38.117
                                                            c11.966,0,22.471-8.493,24.978-20.193l4.184-19.524c53.584-13.049,96.667-50.641,117.872-99.424h32.258
                                                            c9.291,0,16.849-7.558,16.849-16.849v-69.572C512,242.801,510.248,238.57,507.064,235.387z M208.17,64.136
                                                            c24.276,0,44.025,19.75,44.025,44.026c0,6.208-1.329,12.323-3.833,17.936h-80.385c-2.503-5.615-3.833-11.728-3.833-17.936
                                                            C164.144,83.885,183.894,64.136,208.17,64.136z M495.694,316.874c0,0.3-0.243,0.544-0.544,0.544h-26.128
                                                            c4.441-13.904,7.174-28.526,7.956-43.604c0.234-4.496-3.223-8.331-7.72-8.564c-4.497-0.228-8.331,3.223-8.564,7.72
                                                            c-3.454,66.592-48.778,123.449-111.832,142.252l11.391-53.155c0.944-4.403-1.861-8.737-6.264-9.68
                                                            c-4.4-0.946-8.737,1.861-9.68,6.264l-19.416,90.604c-0.907,4.232-4.707,7.304-9.034,7.304h-38.119c-5.095,0-9.24-4.145-9.24-9.24
                                                            v-34.786c0-4.503-3.65-8.153-8.153-8.153s-8.153,3.65-8.153,8.153v9.24h-78.811c-8.945,0-17.874-0.769-26.633-2.262v-59.155
                                                            c0-4.503-3.65-8.153-8.153-8.153s-8.153,3.65-8.153,8.153v86.964c0,5.095-4.145,9.24-9.24,9.24H86.505
                                                            c-3.048,0-5.79-1.409-7.522-3.866c-14.703-20.843-62.677-95.997-62.677-187.999c0-39.072,14.437-76.52,40.651-105.445
                                                            c23.99-26.473,55.999-43.853,90.907-49.561c0.141,5.587,1.057,11.111,2.701,16.407h-3.27c-4.503,0-8.153,3.65-8.153,8.153
                                                            s3.65,8.153,8.153,8.153h121.75c4.503,0,8.153-3.65,8.153-8.153s-3.65-8.153-8.153-8.153h-3.271
                                                            c1.795-5.779,2.727-11.828,2.727-17.936c0-0.183-0.012-0.362-0.014-0.544h27.19v17.936c0,4.503,3.65,8.153,8.153,8.153
                                                            c4.503,0,8.153-3.65,8.153-8.153V57.99c15.469,5.854,44.569,23.835,44.569,76.26c0,4.503,3.65,8.153,8.153,8.153
                                                            s8.153-3.65,8.153-8.153c0-3.454-0.125-7.101-0.411-10.87c19.667,9.58,37.311,23.272,51.498,40.087
                                                            c16.9,20.031,28.586,44.123,33.795,69.673c1.609,7.895,8.541,13.624,16.483,13.623l20.929-0.002c0.055,0,0.225,0,0.384,0.159
                                                            c0.159,0.159,0.159,0.327,0.159,0.384V316.874z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M424.521,235.759c-5.06-13.576-18.455-22.698-33.327-22.698c-14.873,0-28.266,9.121-33.329,22.698
                                                            c-1.573,4.219,0.572,8.914,4.791,10.487c4.22,1.575,8.915-0.572,10.487-4.791c2.696-7.23,9.95-12.088,18.05-12.088
                                                            s15.355,4.858,18.05,12.088c1.223,3.281,4.333,5.307,7.64,5.307c0.947,0,1.909-0.166,2.847-0.516
                                                            C423.949,244.673,426.094,239.977,424.521,235.759z"></path>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path
                                                    d="M216.323,258.479v-41.664c15.994,1.944,27.176,9.354,27.176,16.085c0,4.503,3.65,8.153,8.153,8.153
                                                            c4.503,0,8.153-3.65,8.153-8.153c0-16.668-18.534-30.069-43.482-32.49v-0.937c0-4.503-3.65-8.153-8.153-8.153
                                                            s-8.153,3.65-8.153,8.153v0.937c-24.948,2.421-43.482,15.822-43.482,32.49c0,23.807,23.52,32.399,43.482,38.013v41.664
                                                            c-15.994-1.944-27.176-9.354-27.176-16.085c0-4.503-3.65-8.153-8.153-8.153s-8.153,3.65-8.153,8.153
                                                            c0,16.668,18.534,30.069,43.482,32.49v0.937c0,4.503,3.65,8.153,8.153,8.153s8.153-3.65,8.153-8.153v-0.937
                                                            c24.948-2.421,43.482-15.822,43.482-32.49C259.805,272.684,236.284,264.093,216.323,258.479z M200.017,253.843
                                                            c-20.08-6.299-27.176-12.023-27.176-20.943c0-6.731,11.182-14.141,27.176-16.085V253.843z M216.323,312.578v-37.028
                                                            c20.08,6.298,27.176,12.023,27.176,20.943C243.499,303.224,232.316,310.634,216.323,312.578z">
                                                </path>
                                            </g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="icon-text">
                                    <h3>Ưu đãi khi mua hàng</h3>
                                    Giá Siêu rẻ, hợp túi tiền. Hấp dẫn hơn, Siêu chợ luôn có nhiều chương trình mua hàng
                                    khuyến mãi, miễn phí vận chuyển, tích lũy điểm, tri ân khách hàng … cho bạn thỏa sức mua
                                    sắm mà vẫn yêu túi tiền!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </section>

        <!-- ====PRODUCT===== -->
        <div class="container-fluid">
            <section id="product">
                <div class="row">
                    <div class="col-md-12 title-cate">
                        <h2>Bàn ghế</h2>
                    </div>

                    <!-- ------- -->
                    @foreach ($bg as $key => $value_bg)
                        <div class="col-md-3">
                            <div class="image-item">
                                <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value_bg->product_name)) }}">
                                    <img class="img-product" src="upload/product/{{ $value_bg->product_image }}"
                                        alt="">
                                </a>

                                <form action="{{ URL::to('/save-cart') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="image-tools">
                                        <button style="background: none;border: none;outline: none;" type="submit"
                                            class="add-cart" data-toggle="tooltip" data-placement="top"
                                            title="Thêm vào giỏ">
                                            <div class="cart-icon">
                                                <strong>+</strong>
                                            </div>
                                        </button>
                                        <input name="qty" type="hidden" value="1">
                                        <input name="productid_hidden" type="hidden"
                                            value="{{ $value_bg->product_id }}">
                                    </div>
                                </form>
                            </div>

                            <div class="info-item">
                                <p>{{ $value_bg->cate_name }}</p>
                                <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value_bg->product_name)) }}"
                                    class="name-product">
                                    {{ $value_bg->product_name }}
                                </a>
                                <p class="price">
                                    {{ number_format($value_bg->product_price) }} ₫
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <!-- ------- -->
                </div>
            </section>
        </div>

        <div class="banner-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="conner">

                            <a href="{{ URL::to('/san-pham') }}">
                                <img src="{{ url('/frontend') }}/images/img4-1024x512.jpg" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="conner">

                            <a href="{{ URL::to('/san-pham') }}">
                                <img src="{{ url('/frontend') }}/images/img5-1024x512.jpg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====PRODUCT===== -->
        <div class="container-fluid">
            <section id="product">
                <div class="row">
                    <div class="col-md-12 title-cate">
                        <h2>Kệ tivi</h2>
                    </div>

                    <!-- ------- -->
                    @foreach ($ketivi as $key => $value_ke)
                        <div class="col-md-3">
                            <div class="image-item">
                                <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value_ke->product_name)) }}">
                                    <img class="img-product" src="upload/product/{{ $value_ke->product_image }}"
                                        alt="">
                                </a>

                                <form action="{{ URL::to('/save-cart') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="image-tools">
                                        <button style="background: none;border: none;outline: none;" type="submit"
                                            class="add-cart" data-toggle="tooltip" data-placement="top"
                                            title="Thêm vào giỏ">
                                            <div class="cart-icon">
                                                <strong>+</strong>
                                            </div>
                                        </button>
                                        <input name="qty" type="hidden" value="1">
                                        <input name="productid_hidden" type="hidden"
                                            value="{{ $value_ke->product_id }}">
                                    </div>
                                </form>
                            </div>

                            <div class="info-item">
                                <p>{{ $value_ke->cate_name }}</p>
                                <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value_ke->product_name)) }}"
                                    class="name-product">
                                    {{ $value_ke->product_name }}
                                </a>
                                <p class="price">
                                    {{ number_format($value_ke->product_price) }} ₫
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <!-- ------- -->
                </div>
            </section>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
@stop
