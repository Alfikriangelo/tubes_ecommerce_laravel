<section class="shop_section" style="margin-top: 60px; margin-bottom: 60px">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Produk
            </h2>
        </div>
        <div class="row">
            @if($product->isEmpty())
                <div class="col-md-12">
                    <p class="text-center">Produk tidak ditemukan</p>
                </div>
            @else
                @foreach($product as $products)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="{{url('product_details', $products->id)}}">
                                <div class="img-box">
                                    <img src="products/{{$products->image}}" alt="">
                                </div>
                                <div class="detail-box" style="display: flex; flex-direction: column;">
                                    @if(strlen($products->title) > 20)
                                        <h6>{{ substr($products->title, 0, 20) }}...</h6>
                                    @else
                                        <h6>{{$products->title}}</h6>
                                    @endif
                                    <h6 style="color: red">Rp {{ number_format($products->price, 0, ',', '.') }}</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
