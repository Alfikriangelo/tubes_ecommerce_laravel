<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <!-- Load Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    @include('home.header')

    <h1 class="container my-5" style="font-weight: 500">Isi Data Penerima</h1>
    <form action="{{url('confirm_order')}}" method="post" class="container">
        @csrf
        <div style="display: flex; justify-content: space-between; margin-bottom: 140px">
            <div>
                <div style="display: flex;max-width: 130vh">
                    <div class="form-group">
                        <label>Nama</label>
                        <input style="width: 60vh" type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                    </div>
                    <div class="form-group" style="margin-left: 55px">
                        <label>No penerima</label>
                        <input style="width: 60vh" type="text" class="form-control" name="phone">
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea style="max-width: 130vh" class="form-control" name="address">{{Auth::user()->address}}</textarea>
                </div>

                <!-- Container for the map -->
                <div id="map" style="height: 400px;"></div>

                <!-- Hidden input fields to store selected coordinates -->
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <div class="container" style="margin-top: 70px">
                    <table class="table table-borderless" style="max-width: 130vh">
                        <tbody>
                            <?php $value = 0; ?>
                            @foreach($cartItems as $cart)
                                <tr>
                                    <td>{{ $cart->product->title }}</td>
                                    <td>x{{ $cart->quantity }}</td>
                                    <td>Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <img src="/products/{{ $cart->product->image }}" width="100">
                                    </td>
                                    <td>
                                        <a style="color: red; font-size: 30px" href="{{url('delete_cart', $cart->id)}}">-</a>
                                    </td>
                                </tr>
                                <?php $value = $value + ($cart->product->price * $cart->quantity); ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        
            <div>
                <!-- New element for shipping cost -->
                <p style="font-weight: bold">Biaya Ongkir: Rp <span id="shippingCost">0</span></p>
                <!-- Total biaya -->
                <p style="font-weight: bold; font-size: 18px">Total: Rp <span id="total">{{ number_format($value, 0, ',', '.') }}</span></p>
                <div style="display: flex; justify-content: flex-end">
                    <input type="submit" class="btn btn-primary" value="Pesan" style="margin-bottom: 40px; width: 200px">
                </div>
            </div>

        </div>
    </form>

    @include('home.footer')

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Script for Leaflet map -->
    <script>
        // Function to calculate distance between two points
        function calculateDistance(lat1, lon1, lat2, lon2) {
            var R = 6371; // Radius of the earth in km
            var dLat = deg2rad(lat2 - lat1); // deg2rad below
            var dLon = deg2rad(lon2 - lon1);
            var a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c; // Distance in km
            return d;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        var map = L.map('map').setView([-6.978212919800793, 107.6308121458837], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;

            // Calculate distance between clicked point and fixed point
            var distance = calculateDistance(-6.977858787896994, 107.6308397477381, e.latlng.lat, e.latlng.lng);
            // Check if distance is greater than 1km
            var additionalCost = 3000;
            if (distance >= 1) {
                additionalCost = 3000 * Math.ceil(distance);
            }
            // Set shipping cost value
            document.getElementById('shippingCost').innerText = additionalCost;

            // Update total cost
            var total = {{ $value }};
            total += additionalCost;
            document.getElementById('total').innerText = total.toLocaleString();
        });
    </script>

</body>

</html>
