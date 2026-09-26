@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Customer Data</h1>
            <p class="text-muted mb-0">Kelola data customer yang terdaftar.</p>
        </div>

        <a href="{{ route('customer.create') }}" class="btn btn-success mt-2 mt-md-0">
            <i class="fas fa-plus mr-1"></i>
            Tambah Customer
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th width="140" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($customer as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->user?->name ?? '-' }}</td>
                                <td>{{ $data->user?->email ?? '-' }}</td>
                                <td>{{ $data->no_telepon ?: '-' }}</td>
                                <td class="text-center text-nowrap">

                                    <a href="{{ route('customer.show', $data->id) }}"
                                       class="btn btn-sm btn-light border"
                                       title="Lihat">
                                        <i class="fas fa-eye text-dark"></i>
                                    </a>

                                    <a href="{{ route('customer.edit', $data->id) }}"
                                       class="btn btn-sm btn-light border"
                                       title="Edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-light border"
                                            title="Hapus"
                                            onclick='actionDestroy(@json(route("customer.destroy", $data->id)), @json($data->user?->name ?? "customer"))'>
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data customer.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<form action="" id="form-destroy" method="POST">
    @csrf
    @method('DELETE')
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function actionDestroy(url, name) {
    Swal.fire({
        title: 'Hapus customer?',
        text: 'Data ' + name + ' akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-destroy').action = url;
            document.getElementById('form-destroy').submit();
        }
    });
}
</script>
@endsection
