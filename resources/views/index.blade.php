@extends('layouts.app')

@section('title', 'Beranda')

@section('produk')
    <table>
        <tr>
            <td>Nama Produk</td>
            <td>Harga</td>
            <td>Deskripsi</td>
        </tr>
        @foreach ($produks as $produk)
            <tr>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->harga }}</td>
                <td>{{ $produk->deskripsi }}</td>
            </tr>
        @endforeach
    </table>
@endsection