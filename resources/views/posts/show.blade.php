@extends('master')
@section('title', $post->title)
@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <article class="bg-white rounded-4 shadow-sm overflow-hidden mb-5">
                <!-- Header Info -->
                <div class="p-4 p-lg-5 bg-dark text-white">
                    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <span class="badge rounded-pill text-bg-danger">{{ $post->publisher ?? 'Redaksi' }}</span>
                        @if ($post->published == 'yes')
                            <span class="badge rounded-pill text-bg-success">Published</span>
                        @else
                            <span class="badge rounded-pill text-bg-secondary">Draft</span>
                        @endif
                    </div>
                    <h1 class="display-5 fw-bold mb-3">{{ $post->title }}</h1>
                    <div class="text-white-50 small d-flex flex-wrap gap-3 align-items-center">
                        <span>Oleh: <strong>{{ $post->publisher ?? 'Kabar Burung' }}</strong></span>
                        <span>•</span>
                        <span>Kejadian: {{ $post->event_date ? $post->event_date->format('d M Y') : 'Tidak ditentukan' }}</span>
                    </div>
                </div>

                <!-- Featured Image -->
                @if ($post->image)
                    <div class="ratio ratio-21x9 bg-light">
                        <img src="{{ $post->image_url }}" class="object-fit-cover w-100 h-100" alt="{{ $post->title }}">
                    </div>
                @else
                    <div class="bg-secondary-subtle py-5 text-center text-muted">
                        <p class="mb-0">Tidak ada gambar yang dilampirkan.</p>
                    </div>
                @endif

                <!-- Article Content -->
                <div class="p-4 p-lg-5">
                    <div class="fs-5 text-dark lh-lg mb-5" style="white-space: pre-line;">
                        {{ $post->content }}
                    </div>

                    <hr class="border-secondary-subtle my-4">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            @if ($post->source_url)
                                <a href="{{ $post->source_url }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-4">Kunjungi Sumber Asli</a>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary rounded-pill px-4">Kembali ke Berita</a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
@stop
