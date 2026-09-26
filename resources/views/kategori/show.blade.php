@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Kategori' => route('kategori.index'),
    'Detail' => '',
    ]])

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-info-circle"></i> Detail Kategori
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nama Kategori</th>
                            <td>{{ $data->nama_kategori }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $data->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui</th>
                            <td>{{ $data->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Barang Terkait</th>
                            <td>{{ $data->items()->count() }} barang</td>
                        </tr>
                    </table>

                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('kategori.edit', $data->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection