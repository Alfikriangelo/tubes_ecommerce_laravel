<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Product;

use App\Models\User;

use App\Models\Order;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $data = Order::latest()->get()->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d H:i');
        });
        
        $totalOrders = 0;
        $totalIncome = 0;
        $totalPrices = [];

        foreach ($data as $timestamp => $orders) {
            $totalOrders += $orders->count();

            $totalPrices[$timestamp] = $orders->sum('total_price');

            $totalIncome += $totalPrices[$timestamp];
        }

        $sedangProsesCount = Order::where('status', 'Sedang proses')->distinct()->count('created_at');
        $sedangDiperjalananCount = Order::where('status', 'Sedang diperjalanan')->distinct()->count('created_at');

    return view('admin.index', compact('data', 'totalOrders', 'totalPrices', 'totalIncome', 'sedangProsesCount', 'sedangDiperjalananCount'));
}


    public function view_category(){
        $data = Category::all();
        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request){
        $category = new Category;
        $category->category_name = $request->category;
        $category->save();

        toastr()->timeout(4000)->closeButton()->success("Kategori berhasil ditambahkan");

        return redirect()->back();
    }

    public function delete_category($id){
        $data = Category::find($id);
        $data->delete();

        toastr()->timeout(4000)->closeButton()->success("Kategori berhasil dihapus");

        return redirect()->back();
    }

    public function edit_category($id){
        $data = Category::find($id);

        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id){
        $data = Category::find($id);
        $data->category_name = $request->category;
        $data->save();

        toastr()->timeout(4000)->closeButton()->success("Kategori berhasil diperbarui");

        return redirect('/view_category');

    }

    public function add_product(){
        $category = Category::all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request){
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;
        $data->category = $request->category;

        $image = $request->image;
        
        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        toastr()->timeout(4000)->closeButton()->success("Produk berhasil ditambah");

        return redirect('/view_product');
    }

    public function view_product(){
        $product = Product::paginate(5);
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id){
        $data = Product::find($id);
        $image_path = public_path('products/'.$data->image);

        if(file_exists($image_path)){
            unlink($image_path);
        }

        $data->delete();
        return redirect()->back();
    }

    public function update_product($id){
        $data = Product::find($id);
        $category = Category::all();
        return view('admin.update_product', compact('data','category'));
    }

    public function edit_product(Request $request, $id){
        $data = Product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->category = $request->category;
        $image = $request->image;

        if($image){
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        toastr()->timeout(4000)->closeButton()->success("Produk berhasil diperbarui");

        return redirect('/view_product');
    }

    public function product_search(Request $request){
        $search = $request->search;
        $product = Product::where('title', 'LIKE', '%'.$search.'%')->orWhere('category', 'LIKE', '%'.$search.'%')->paginate(3);
        return view('admin.view_product', compact('product'));
    }

        public function on_process($id){
        $order = Order::find($id);
        $timestamp = $order->created_at;

        $orders = Order::where('created_at', $timestamp)->get();

        foreach ($orders as $order) {
            $order->status = 'Sedang proses';
            $order->save();
        }

        return redirect('/admin');
    }

    public function on_the_way($id){
        $order = Order::find($id);
        $timestamp = $order->created_at;
        
        $orders = Order::where('created_at', $timestamp)->get();

        foreach ($orders as $order) {
            $order->status = 'Sedang diperjalanan';
            $order->save();
        }

        return redirect('/admin');
    }

    public function delivered($id){
        $order = Order::find($id);
        $timestamp = $order->created_at;

        $orders = Order::where('created_at', $timestamp)->get();

        foreach ($orders as $order) {
            $order->status = 'Sudah sampai';
            $order->save();
        }

        return redirect('/admin');
    }


    
}
