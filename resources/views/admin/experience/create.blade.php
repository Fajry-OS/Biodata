@extends('layout_2.app')
@section('content')
    <form action="{{ route('experience.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <select name="id_profile" class="form-control" aria-label="Default select example">
                <option selected>-- Pilih User --</option>
                @foreach ($profile as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control">
        </div>
        <div class="mb-3">
            <label for="subjudul">Sub Judul</label>
            <input type="text" name="subjudul" id="subjudul" class="form-control">
        </div>
        <div class="mb-3">
            <label for="tgl_experience">Periode Pengalaman</label>
            <input type="text" name="tgl_experience" id="tgl_experience" class="form-control">
        </div>
        <div class="mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ url('admin/experience') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
@endsection
