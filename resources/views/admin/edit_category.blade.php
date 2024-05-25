<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .div_deg{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }
        .editCategoryInput{
            display: flex;
            justify-content: center;
        }
        #categoryEdit:focus {
            border-color: #1E0342;
            outline-color: #fff;
        }
        #categoryEdit {
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
                <h1 style="color: #1E0342">Perbarui Kategori</h1>
                <div class="div_deg">
                    <form action="{{url('update_category', $data->id)}}" method="post">
                        @csrf
                        <div class="editCategoryInput">
                            <input value="{{$data->categrory_name}}" style="margin-right: 10px; color: black;" type="text" name="category" class="form-control" id="categoryEdit" aria-describedby="emailHelp">
                            <input class="btn btn-primary" type="submit" value="Tambah" style="background-color: #1E0342">
                        </div>
                    </form>
                </div>
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