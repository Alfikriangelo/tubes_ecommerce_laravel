<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\User;

use App\Models\Cart;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function home(){
        $product = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        }
        else{
            $count = '';
        }
        return view('home.index', compact('product', 'count'));
    }

    public function login_home(){
        $product = Product::all();
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        }
        else{
            $count = '';
        }
        return view('home.index', compact('product','count'));
    }

    public function product_details($id){
        $data = Product::find($id);
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        }
        else{
            $count = '';
        }
        return view('home.product_details', compact('data', 'count'));
    }

    public function add_cart($id){
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;
        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;

        $data->save();

        toastr()->timeout(4000)->closeButton()->success("Berhasil dimasukkan ke keranjang");

        return redirect()->back();
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371; // Radius of the earth in km
        $dLat = $this->deg2rad($lat2 - $lat1); // deg2rad below
        $dLon = $this->deg2rad($lon2 - $lon1);
        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos($this->deg2rad($lat1)) * cos($this->deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c; // Distance in km
        return $d;
    }

    public function deg2rad($deg) {
        return $deg * (pi() / 180);
    }

    public function mycart(){
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();
            $cartItems = Cart::where('user_id', $user->id)->get();

            $groupedCartItems = $cartItems->groupBy('product_id')->map(function ($row) {
                $firstItem = $row->first();
                $firstItem->quantity = $row->count();
                return $firstItem;
            });
        }

        return view('home.mycart', compact('count', 'cart'), ['cartItems' => $groupedCartItems]);
    }
    public function delete_cart($id){
        $data = Cart::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function confirm_order(Request $request){
        // Method to calculate distance between two points
        function calculateDistance($lat1, $lon1, $lat2, $lon2) {
            $R = 6371; // Radius of the earth in km
            $dLat = deg2rad($lat2 - $lat1); // deg2rad below
            $dLon = deg2rad($lon2 - $lon1);
            $a =
                sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $d = $R * $c; // Distance in km
            return $d;
        }

        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $userid = Auth::user()->id;
        $cart = Cart::where('user_id', $userid)->get();
        
        // Calculate total price
        $total_price = 0;
        foreach($cart as $carts) {
            $product = Product::find($carts->product_id);
            $total_price += $product->price * $carts->quantity;
        }
        
        // Add shipping cost to total price
        $distance = calculateDistance(-6.977858787896994, 107.6308397477381, $latitude, $longitude);
        $additionalCost = 3000;
        if ($distance >= 1) {
            $additionalCost = 3000 * ceil($distance);
        }
        $total_price += $additionalCost;

        // Save order
        foreach($cart as $carts) {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $carts->product_id;
            $order->maps = "$latitude,$longitude";
            $order->total_price = $total_price;

            $order->save();
        }

        // Clear cart
        Cart::where('user_id', $userid)->delete();

        return redirect('/');
    }


    public function home_search(Request $request){
        $search = $request->search;
        $product = Product::where('title', 'LIKE', '%'.$search.'%')->orWhere('category', 'LIKE', '%'.$search.'%')->paginate(3);
        return view('home.index', compact('product'));
    }
    
}

