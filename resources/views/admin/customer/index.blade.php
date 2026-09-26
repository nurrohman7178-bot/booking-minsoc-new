@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">

<<<<<<< HEAD
        {{-- Page Heading --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">Customers Data Page</h1>
            <p class="text-muted mb-0">Manage your customer data</p>
        </div>

        {{-- Add Customer Button --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('customer.create') }}"
           class="btn btn-success">

            <i class="fas fa-plus mr-1"></i>
            Tambah Customer

        </a>
        </div>

        {{-- Customer Table --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">

                        <thead>
                            <tr>
                                <th width="50px">NO</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                
                                <th width="100px" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($customer as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->user->name }}</td>
                                    <td>{{ $user->user->email }}</td>
                                    <td>{{ $user->no_telepon }}</td>
                                    

                                    <td class="text-center">

                                        {{-- Detail --}}
                                        <a href="{{ route('customer.show', $user->id) }}" class="mr-2" title="Lihat">
                                            <i class="fas fa-eye text-dark"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('customer.edit', $user->id) }}" class="mr-2" title="Edit">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <a href="javascript:void(0)" title="Hapus"
                                            onclick="actionDestroy('{{ route('customer.destroy', $user->id) }}',
                                            '{{ $user->user->name }}')">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>

                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Data customer is empty
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
=======
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Customer Data</h1>
            <p class="text-muted mb-0">Kelola data customer yang terdaftar.</p>
>>>>>>> 31e2af5067c9108ce512f1147ceb4f359d46fc77
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
