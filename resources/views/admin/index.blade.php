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
         <div style="display: flex; justify-content: center;">  
            <section class="no-padding-top no-padding-bottom">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block" style="border-radius: 10px">
                      <div class="title">
                        <div class="icon">
                          <div class="number dashtext-1">
                            {{ $totalOrders }}
                          </div>
                        </div>
                        <strong>Pesanan</strong>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="statistic-block block" style="border-radius: 10px">
                      <div class="title">
                        <div class="icon">
                          <div class="number dashtext-1">
                            Rp {{ number_format($totalIncome) }}
                          </div>
                        </div>
                        <strong>Pemasukan</strong>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block" style="border-radius:10px; width:300px; height: 119px; display: flex; flex-direction: row; justify-content: center; align-items: center">
                      <div>
                        <strong style="display: flex;align-items: center; justify-content: center;font-size: 28px;" class="number dashtext-1">{{ $sedangProsesCount }}</strong>
                        <strong style="font-size: 14px;">Proses</strong>
                      </div>
                      <div style="margin-left: 50px">
                        <strong style="display: flex;align-items: center; justify-content: center;font-size: 28px;" class="number dashtext-1">{{ $sedangDiperjalananCount }}</strong>
                        <strong style="font-size: 14px;">Perjalanan</strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        
            <h1 style="color: #1E0342">Pesanan</h1>
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Penerima</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Status</th>
                    <th scope="col" style="width: 150px">Ganti Status</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $timestamp => $orders)
                  <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>{{ $orders->first()->name }}</td>
                      <td>{{ $orders->first()->rec_address }}</td>
                      <td>
                          @php
                          $status = $orders->first()->status;
                          @endphp
                          @if($status == 'Sedang proses')
                          <span style="padding: 10px" class="badge badge-secondary">Sedang proses</span>
                          @elseif($status == 'Sedang diperjalanan')
                          <span style="padding: 10px; color: white" class="badge badge-warning">Sedang diperjalanan</span>
                          @elseif($status == 'Sudah sampai')
                          <span style="padding: 10px" class="badge badge-success">Sudah sampai</span>
                          @endif
                      </td>
                      <td>
                          <select class="form-control" onchange="location = this.value;">
                              <option selected>Pilih</option>
                              <option value="{{url('on_process', $orders->first()->id)}}">Sedang proses</option>
                              <option value="{{url('on_the_way', $orders->first()->id)}}">Sedang diperjalanan</option>
                              <option value="{{url('delivered', $orders->first()->id)}}">Sudah sampai</option>
                          </select>
                      </td>
                      <td>{{ number_format($totalPrices[$timestamp]) }}</td>
                      <td>
                          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $loop->iteration }}">
                              Lihat detail
                          </button>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="12">
                          <div class="collapse" id="collapse{{ $loop->iteration }}">
                              <div>
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th scope="col">Alamat</th>
                                              <th scope="col">Maps</th>
                                              <th scope="col">No HP</th>
                                              <th scope="col">produk</th>
                                              <th scope="col">Waktu</th>
                                              <th scope="col">Gambar</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($orders as $order)
                                          <tr>
                                              <td>{{ $order->rec_address }}</td>
                                              <td><a href="https://www.google.com/maps/place/{{ $order->maps }}">{{ substr($order->maps, 0, 10) }}...</a></td>
                                              <td>{{ $order->phone }}</td>
                                              <td>{{ $order->product->title }}</td>
                                              <td>{{ \Carbon\Carbon::parse($timestamp)->format('H:i:s d-m-Y') }}</td>
                                              <td><img width="150" src="products/{{ $order->product->image }}"></td>
                                          </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
  </body>
</html>
