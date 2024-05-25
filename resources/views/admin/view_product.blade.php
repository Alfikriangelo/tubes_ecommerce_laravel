<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
            <h1 style="color: #1E0342">Daftar Produk</h1>
              <form action="{{url('product_search')}}" method="get" style="display: flex; justify-content: flex-end">
                  @csrf
                  <div style="display: flex;">
                      <input type="search" name="search" class="form-control">
                      <input style="margin-left: 10px" type="submit" class="btn btn-secondary" value="Search">
                  </div>
              </form>

              <table style="margin-top: 20px" class="table table-borderless">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product as $products)
                    <tr>
                        <th scope="row">{{ ($product->currentPage() - 1) * $product->perPage() + $loop->iteration }}</th>
                        <td>{{$products->title}}</td>
                        <td>{!!Str::limit($products->description, 50)!!}</td>
                        <td>{{$products->category}}</td>
                        
                        <td>Rp {{ number_format($products->price, 0, ',', '.') }}</td>
                        <td>{{$products->quantity}}</td>
                        <td>
                            <img height="120" width="120" src="products/{{$products->image}}">
                        </td>
                        <td>
                          <a class="btn btn-success" href="{{url('update_product', $products->id)}}">Edit</a>
                        </td>
                        <td>
                          <a class="btn btn-danger" onclick="confirmation(event)" style="color: white" href="{{url('delete_product', $products->id)}}">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                <div style="display: flex; justify-content: flex-end; margin-top: 20px; padding: 10px">
                    {{$product->onEachSide(2)->links()}}
                </div>
            </div>
        </div>
    </div>


    <script>
      function confirmation(ev){
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        console.log(urlToRedirect);
        swal({
          title: "Anda yakin?",
          text: "Setelah dihapus, data tidak bisa dikembalikan.",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            window.location.href = urlToRedirect;
          } else {
            swal("Data batal di hapus");
          }
        });
      }
    </script>

    <!-- JavaScript files-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
  </body>
</html>