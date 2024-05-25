<?php
// Mendapatkan URL saat ini
$currentURL = url()->current();

// Tentukan halaman mana yang sedang dibuka
$isBeranda = $currentURL === url('admin');
$isViewCategory = $currentURL === url('view_category');
$isAddProduct = $currentURL === url('add_product');
$isViewProduct = $currentURL === url('view_product');
?>

<div class="d-flex align-items-stretch">
<!-- Sidebar Navigation-->
<nav id="sidebar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="{{asset('admincss/img/avatar-6.jpg')}}" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title">
            <h1 class="h5">{{ Auth::user()->name }}</h1>
            <p>Penjual</p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus-->
    <span class="heading">Main</span>
    <ul class="list-unstyled">
        <li class="{{ $isBeranda ? 'active' : '' }}">
            <a href="{{url('admin')}}"> 
                <i class="icon-home"></i>Beranda
            </a>
        </li>
        <li class="{{ $isViewCategory ? 'active' : '' }}">
            <a href="{{url('view_category')}}"> 
                <i class="icon-grid"></i>Kategori 
            </a>
        </li>
        
        <li>
            <a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> 
                <i class="icon-windows"></i>Produk
            </a>
            <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li class="{{ $isAddProduct ? 'active' : '' }}"><a href="{{url('add_product')}}">Tambah Produk</a></li>
                <li class="{{ $isViewProduct ? 'active' : '' }}"><a href="{{url('view_product')}}">Lihat Produk</a></li>
            </ul>
        </li>
    </ul>
</nav>
