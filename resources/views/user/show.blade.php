@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @include('partials.breadcrumb', ['items' => [
    'Pengaturan' => '#',
    'User' => route('user.index'),
    'Detail' => '',
    ]])

    @include('partials.alert')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-user-circle"></i> Detail User
                </div>
                <div class="card-body">

                    <table class="table table-bordered mb-0">
                        <tr>
                            <th width="200" class="bg-light">Nama</th>
                            <td>
                                <strong>{{ $data->name }}</strong>
                                @if($data->id == auth()->id())
                                <span class="badge badge-info ml-1">Anda</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Email</th>
                            <td>
                                <i class="fas fa-envelope text-muted"></i>
                                {{ $data->email }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Terdaftar</th>
                            <td>
                                <i class="far fa-clock text-muted"></i>
                                {{ $data->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Terakhir Diperbarui</th>
                            <td>
                                <i class="far fa-clock text-muted"></i>
                                {{ $data->updated_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('user.edit', $data->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection