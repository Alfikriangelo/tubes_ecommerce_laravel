<!DOCTYPE html>
<html>

<head>
    @include('home.css')
</head>

<body>
  @include('home.header')
  <section class="shop_section" style="margin-top: 60px; margin-bottom: 60px">
    <div class="container">
      <div class="heading_container">
        <h2>{{$data->title}}</h2>
      </div>
      <div style="display:flex">
        <img src="/products/{{($data->image)}}" width="300">
        <div style="width:600px">
            <p style="margin-left:20px; font-size:20px">{{$data->description}}</p>
        </div>
        <div style="margin-left:20px">
            <p style="color:red; font-size:20px">Rp {{ number_format($data->price, 0, ',', '.') }}</p>
            <a class="btn btn-primary" href="{{url('add_cart', $data->id)}}">Masukkan Keranjang</a>
        </div>
      </div>
    </div>
  </section>

  @include('home.footer')
</body>

</html>