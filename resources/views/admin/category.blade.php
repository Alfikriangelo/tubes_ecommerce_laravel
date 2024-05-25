<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style type="text/css">
        .addCategoryInput{
            display: flex;
            justify-content: center;
        }
        .div_deg{
            display: flex;
            justify-content: flex-end;
            alight-items: center;
            margin: 15px;
        }
        #categoryInput:focus {
            border-color: #1E0342;
            outline-color: #fff;
        }
        #categoryInput {
            border-radius: 10px;
        }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1 style="color: #1E0342">Tambah Kategori</h1>
                <div class="div_deg">
                    <form action="{{url('add_category')}}" method="post">
                        @csrf
                        <div class="addCategoryInput">
                            <input style="margin-right: 10px; color: black;" type="text" name="category" class="form-control" id="categoryInput" aria-describedby="emailHelp">
                            <input class="btn btn-primary" type="submit" value="Tambah katergori" style="background-color: #1E0342">
                        </div>
                    </form>
                </div>
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $data)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$data->category_name}}</td>
                            <td>
                                <a class="btn btn-success" href="{{url('edit_category', $data->id)}}">Edit</a>
                                <a class="btn btn-danger" onclick="confirmation(event)" style="color: white" href="{{url('delete_category', $data->id)}}">Hapus</a>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
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