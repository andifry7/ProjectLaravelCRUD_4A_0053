@extends('master')
@section('title', 'Dashboard - Manajemen Berita')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        padding: 2.5rem 0 1.5rem;
    }
    .stat-card {
        border: none;
        border-radius: 1rem;
        padding: 1.5rem;
        background: white;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.10); }
    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }
    .table-news th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 2px solid #e2e8f0; }
    .table-news td { vertical-align: middle; }
    .badge-published { background: #dcfce7; color: #16a34a; }
    .badge-draft { background: #fef3c7; color: #d97706; }
    .img-thumb { width: 56px; height: 40px; object-fit: cover; border-radius: 6px; }
    .btn-action { font-size: .78rem; padding: .25rem .65rem; border-radius: 6px; }
    .avatar-circle {
        width: 40px; height: 40px; border-radius: 50%;
        background: var(--news-accent);
        color: white; font-weight: 700; font-size: 1rem;
        display: flex; align-items: center; justify-content: center;
    }
</style>
@endpush

@section('body')
{{-- Top Navigation --}}
<nav class="navbar navbar-dark" style="background:#0f172a;">
    <div class="container d-flex align-items-center gap-3">
        <a class="navbar-brand fw-bold" href="{{ url('/posts') }}">
            <span class="text-danger">Kabar</span>Burung
        </a>
        <span class="badge bg-danger ms-1">Dashboard</span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <a href="{{ url('/posts') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                ← Ke Halaman Publik
            </a>
            <div class="avatar-circle">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span class="text-white-50 small">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ url('/logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">Logout</button>
            </form>
        </div>
    </div>
</nav>

{{-- Dashboard Header --}}
<div class="dashboard-header">
    <div class="container">
        <h1 class="h3 fw-bold mb-1">Manajemen Berita</h1>
        <p class="text-white-50 mb-0">Kelola seluruh artikel berita dari halaman ini.</p>
    </div>
</div>

<div class="container py-4">

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <strong>✅</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#dbeafe;"><i class="bi bi-newspaper" style="color:#2563eb;"></i></div>
                <div>
                    <div class="text-muted small">Total Berita</div>
                    <div class="fw-bold fs-4">{{ $posts->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#dcfce7;"><i class="bi bi-check-circle-fill" style="color:#16a34a;"></i></div>
                <div>
                    <div class="text-muted small">Dipublikasikan</div>
                    <div class="fw-bold fs-4">{{ $posts->where('published','yes')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#fef3c7;"><i class="bi bi-hourglass-split" style="color:#d97706;"></i></div>
                <div>
                    <div class="text-muted small">Draft</div>
                    <div class="fw-bold fs-4">{{ $posts->where('published','no')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#fee2e2;"><i class="bi bi-calendar3" style="color:#dc2626;"></i></div>
                <div>
                    <div class="text-muted small">Ditambah Bulan Ini</div>
                    <div class="fw-bold fs-4">{{ $posts->filter(fn($p) => $p->created_at->month === now()->month)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-white border-0 rounded-top-4 py-3 px-4 d-flex align-items-center justify-content-between">
            <h2 class="h5 fw-bold mb-0">Daftar Artikel</h2>
            <a href="{{ route('posts.create') }}" class="btn btn-danger rounded-pill px-4 fw-bold">
                <i class="bi bi-plus-lg me-1"></i>Tambah Berita Baru
            </a>
        </div>
        <div class="card-body p-0">
            @if($posts->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:3rem; color:#94a3b8;"></i>
                    <p class="mt-2">Belum ada berita. Mulai dengan menambahkan artikel pertama!</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-danger rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i>Tambah Sekarang</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-news table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Gambar</th>
                                <th>Judul</th>
                                <th>Publisher</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="img-thumb">
                                </td>
                                <td style="max-width:280px;">
                                    <a href="{{ route('posts.show', $post->id) }}" class="fw-semibold text-dark d-block" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $post->title }}">
                                        {{ $post->title }}
                                    </a>
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($post->content, 60) }}</small>
                                </td>
                                <td class="text-muted small">{{ $post->publisher ?? '-' }}</td>
                                <td class="text-muted small text-nowrap">{{ optional($post->event_date)->format('d M Y') ?? $post->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($post->published === 'yes')
                                        <span class="badge badge-published px-2 py-1 rounded-pill">Dipublikasikan</span>
                                    @else
                                        <span class="badge badge-draft px-2 py-1 rounded-pill">Draft</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-outline-secondary btn-action" title="Lihat Detail"><i class="bi bi-eye me-1"></i>Lihat</a>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-warning btn-action fw-semibold" title="Edit Berita"><i class="bi bi-pencil me-1"></i>Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita: {{ addslashes($post->title) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-action" title="Hapus"><i class="bi bi-trash me-1"></i>Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmsSZUoLkdLPBzYqO7UhiLKbMtYj" crossorigin="anonymous"></script>
@stop
