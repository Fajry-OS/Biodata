@extends('layout_2.app')
@section('content')
    <div class="card">
        <div class="card-header">Profiles</div>
        <div class="card-body">
            <a href="{{ url('admin/profile') }}" class="btn btn-primary btn-sm mb-2">Back</a>
            <div class="table table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
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
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->no_telpon }}</td>
                                <td><img src="{{ asset('storage/image/' . $item->picture) }}" alt="" width="100">
                                </td>
                                <td>
                                    <a href="{{ route('profile.restore', $item->id) }}"
                                        class="btn btn-success btn-sm mr-2">Restore</a>
                                    <form action="{{ route('profile.destroy', $item->id) }}" style="display: inline;"
                                        onsubmit="return confirm('Data Akan di Hapus Permanen')" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
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
