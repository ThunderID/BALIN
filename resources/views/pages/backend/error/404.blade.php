@extends('template.backend.layout') 

@section('content')
    <div class="middle-box text-center animated fadeInDown" style="margin-top: 80px">
        <h1 class="m-t-n-md">404</h1>
        <h3 class="font-bold">Halaman tidak ditemukan</h3>

        <div class="error-desc">
            Maaf, halaman yang anda cari tidak ditemukan <br>
        </div>

        <div class="action">
            <a href="{{ route('backend.home') }}" class="btn btn-primary btn-sm m-t-sm">Home</a>
        </div>
    </div>
@stop