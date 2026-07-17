@extends('master')
@section('title', 'Profil Pengguna')
@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white text-center py-4 rounded-top-4">
                    <h3 class="mb-0 fw-bold">Profil Pengguna</h3>
                </div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger text-white rounded-circle fw-bold" style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nama</label>
                        <p class="fs-5 fw-semibold border-bottom pb-2">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Email</label>
                        <p class="fs-5 fw-semibold border-bottom pb-2">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ url('/home') }}" class="btn btn-danger btn-lg rounded-pill fw-bold">Ke Dashboard</a>
                        <a href="{{ url('/posts') }}" class="btn btn-outline-secondary rounded-pill">Kembali ke Berita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
