<!-- resources/views/karyawan/index.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h1>Daftar Karyawan</h1>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('karyawan.create') }}"> Data Baru</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nomor Induk</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>Tanggal Bergabung</th>
                <th>Sisa Cuti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->nomor_induk }}</td>
                    <td>{{ $data->nama }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->tanggal_lahir }}</td>
                    <td>{{ $data->tanggal_bergabung }}</td>
                    <td>{{ $data['sisa_cuti'] }}</td>
                    <td>
                        <form action="{{ route('karyawans.destroy',$data->id) }}" method="POST">
                            <a class="btn btn-primary" href="{{ route('karyawans.edit',$data->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
