@extends('layout_2.app')
@section('content')
    <div class="card">
        <div class="card-header">Profiles</div>
        <div class="card-body">
            <a href="{{ route('profile.create') }}" class="btn btn-primary btn-sm mb-2">ADD</a>
            <a href="{{ route('profile.recycle') }}" class="btn btn-warning btn-sm mb-2">Recycle</a>
            <div class="table table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No.Telp</th>
                            <th>Gambar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profiles as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <input type="radio" name="status" class="status-radio" data-id="{{ $item->id }}"
                                        {{ $item->status == 1 ? 'checked' : null }}>
                                </td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->no_telpon }}</td>
                                <td><img src="{{ asset('storage/image/' . $item->picture) }}" width="100" alt="">
                                </td>
                                <td>
                                    <a href="{{ route('profile.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <form action="{{ route('profile.softdelete', $item->id) }}" style="display: inline;"
                                        onsubmit="return confirm('Data Akan di Hapus Sementara')" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <a href="{{ route('generate-pdf', $item->id) }}"
                                        class="btn btn-sm btn-warning">Print</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
@endsection

@section('script-sweetalert')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const radios = document.querySelectorAll('.status-radio');
            radios.forEach(radio => {
                radio.addEventListener('click', (event) => {
                    const itemId = event.target.getAttribute('data-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch(`/admin/profile/update-status/${itemId}`, {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Berhasil',
                                    'Status berhasil diperbarui',
                                    'success'
                                );
                                radios.forEach(r => {
                                    if (r.getAttribute('data-id') !== itemId) {
                                        r.checked = false;
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    data.error ||
                                    'Terjadi Kesalahan saat memperbarui Status',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Gagal',
                                'Terjadi kesalahan saat memperbarui status.',
                                'error'
                            );
                        });
                });
            });
        });
    </script>
@endsection
