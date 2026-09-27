@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        {{-- Page Heading --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">Customers Data Page</h1>
            <p class="text-muted mb-0">Manage your customer data</p>
        </div>
        {{-- Add Customer Button --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('customer.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-1"></i>
                Add Customer
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
                                        <a href="javascript:void(0)" title="Hapus" onclick="actionDestroy('{{ route('customer.destroy', $user->id) }}',
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
