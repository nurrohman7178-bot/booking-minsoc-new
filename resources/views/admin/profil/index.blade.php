@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        {{-- Heading --}}
        <div class="mb-4">
            <h1 class="page-title mb-1">
                Profil
            </h1>
            <p class="text-muted mb-0">
                Kelola informasi akun admin.
            </p>
        </div>
        <div class="row">
            {{-- INFORMASI AKUN --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="m-0 font-weight-bold">
                            Informasi Akun
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <div class="form-group mb-0">
                            <label>Role</label>
                            <input type="text" class="form-control"
                                value="{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Pelanggan' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            {{-- INFORMASI SISTEM --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h6 class="m-0 font-weight-bold">
                            Informasi Sistem
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Aplikasi</label>
                            <input type="text" class="form-control" value="MiniSoccer Book" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tarif Lapangan</label>
                            <input type="text" class="form-control" value="Rp120.000 / jam" readonly>
                        </div>
                        <div class="form-group mb-0">
                            <label>Status Sistem</label>
                            <input type="text" class="form-control" value="Aktif" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection