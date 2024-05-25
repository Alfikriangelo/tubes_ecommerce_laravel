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
                <h1 style="color: #1E0342">Tambah Produk</h1>
                <form action="{{url('upload_product')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault01">Nama Produk</label>
                            <input name="title" type="text" class="form-control" id="validationDefault01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="inputState">Jenis Kategori</label>
                            <select name="category" id="inputState" class="form-control" required>
                                <option>-</option>
                                @foreach($category as $category)
                                    <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault02">Harga</label>
                            <input name="price" type="text" class="form-control" id="validationDefault02" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="validationDefault02">Jumlah</label>
                            <input name="qty" type="text" class="form-control" id="validationDefault02" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="exampleFormControlTextarea1">Deskripsi</label>
                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleFormControlFile1">Foto Produk</label>
                            <input name="image" type="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Tambah">
                </form>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
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
