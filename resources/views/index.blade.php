@extends('master')
@section('title', 'Portal Berita - Kabar Burung')
@push('styles')
<style>

    .news-shell {
        background:
            radial-gradient(circle at top left, rgba(217, 4, 41, 0.16), transparent 28%),
            linear-gradient(180deg, #ffffff 0%, #f4f6fb 100%);
        min-height: 100vh;
    }

    .topbar {
        background: #0f172a;
        color: #fff;
    }

    .brand-mark {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, #d90429, #ff7b00);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .hero-card {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(30, 41, 59, 0.92));
        color: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 999px;
        padding: .45rem .85rem;
        font-size: .85rem;
    }

    .news-card {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        transition: transform .2s ease, box-shadow .2s ease;
        height: 100%;
    }

    .news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.13);
    }

    .news-image {
        aspect-ratio: 16 / 10;
        object-fit: cover;
        width: 100%;
    }

    .section-label {
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #d90429;
        font-size: .78rem;
        font-weight: 800;
    }

    .story-item + .story-item {
        border-top: 1px solid rgba(15, 23, 42, 0.08);
    }

    .story-meta {
        color: #6b7280;
        font-size: .9rem;
    }
</style>
@endpush
@section('body')
<div class="news-shell">
    <div class="topbar py-3">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="brand-mark">KB</div>
                <div>
                    <a href="{{ url('/') }}" class="text-white text-decoration-none"><div class="fw-bold fs-4 lh-1">Kabar Burung</div></a>
                    <small class="text-white-50">Portal berita sederhana untuk menampilkan informasi terbaru.</small>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <div class="text-white-50 small ms-2">
                    Update terakhir: {{ now()->format('d M Y, H:i') }}
                </div>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-danger rounded-pill px-3">Register</a>
                @else
                    <a href="{{ url('/profile') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Profil</a>
                    <a href="{{ url('/home') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Home</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <main class="container py-4 py-lg-5">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-8">
                @php($headline = $posts->first())
                @if($headline)
                    <article class="hero-card h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-6">
                                <a href="{{ route('posts.show', $headline->id) }}">
                                    <img src="{{ $headline->image_url }}" class="w-100 h-100 object-fit-cover" alt="{{ $headline->title }}">
                                </a>
                            </div>
                            <div class="col-md-6 p-4 p-lg-5 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="hero-badge mb-3">
                                        <span class="badge rounded-pill text-bg-danger">Headline</span>
                                        <span>{{ $headline->publisher ?? 'Redaksi' }}</span>
                                    </div>
                                    <a href="{{ route('posts.show', $headline->id) }}" class="text-white text-decoration-none">
                                        <h1 class="display-6 fw-bold mb-3">{{ $headline->title }}</h1>
                                    </a>
                                    <p class="lead text-white-50 mb-4">{{ \Illuminate\Support\Str::limit($headline->content, 180) }}</p>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 text-white-50">
                                    <div class="d-flex gap-3 align-items-center">
                                        <span>{{ optional($headline->event_date)->format('d M Y') ?? $headline->created_at->format('d M Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $headline->publisher ?? 'Kabar Burung' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @else
                    <div class="alert alert-warning">Belum ada data berita. Jalankan seeder untuk menampilkan konten.</div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="bg-white rounded-4 p-4 h-100 shadow-sm">
                    <div class="section-label mb-2">Sorotan Cepat</div>
                    <h2 class="h4 fw-bold mb-4">Berita terbaru hari ini</h2>
                    <div class="d-flex flex-column gap-3">
                        @forelse($posts->take(4) as $post)
                            <div class="story-item pb-3 pt-1">
                                <div class="story-meta mb-1">{{ $post->publisher ?? 'Redaksi' }} • {{ optional($post->event_date)->format('d M Y') ?? $post->created_at->format('d M Y') }}</div>
                                <a href="{{ route('posts.show', $post->id) }}" class="d-block fw-semibold text-dark">{{ $post->title }}</a>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Data berita belum tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-4 mt-lg-5">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <div>
                    <div class="section-label mb-2">Daftar Berita</div>
                    <h2 class="fw-bold mb-0">Kumpulan artikel dari berbagai publisher</h2>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted">{{ $posts->count() }} artikel tersedia</div>
                </div>
            </div>

            <div class="row g-4">
                @foreach($posts->skip(1) as $post)
                    <div class="col-md-6 col-xl-4">
                        <article class="card news-card">
                            <a href="{{ route('posts.show', $post->id) }}">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="news-image">
                            </a>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                                    <span class="badge text-bg-light">{{ $post->publisher ?? 'Publisher' }}</span>
                                    <small class="text-muted">{{ optional($post->event_date)->format('d M Y') ?? $post->created_at->format('d M Y') }}</small>
                                </div>
                                <a href="{{ route('posts.show', $post->id) }}" class="text-dark text-decoration-none">
                                    <h3 class="h5 fw-bold">{{ $post->title }}</h3>
                                </a>
                                <p class="text-muted grow">{{ \Illuminate\Support\Str::limit($post->content, 120) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <a href="{{ route('posts.show', $post->id) }}" class="fw-semibold text-decoration-none" style="color: var(--news-accent);">Baca selengkapnya</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</div>
@stop
