@extends('master')
@section('title', 'Tambah Berita Baru')
@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white p-4 rounded-top-4 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 fw-bold">Tambah Berita Baru</h3>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Kembali</a>
                </div>
                <div class="card-body p-5">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Berita</label>
                            <input type="text" name="title" class="form-control rounded-3" value="{{ old('title') }}" placeholder="Masukkan judul berita" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Berita</label>
                            <textarea name="content" rows="6" class="form-control rounded-3" placeholder="Masukkan isi materi berita" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Penerbit (Publisher)</label>
                                <input type="text" name="publisher" class="form-control rounded-3" value="{{ old('publisher') }}" placeholder="Contoh: Kompas, Detik">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Kejadian</label>
                                <input type="date" name="event_date" class="form-control rounded-3" value="{{ old('event_date') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">URL Sumber Berita (Source URL)</label>
                            <input type="url" name="source_url" class="form-control rounded-3" value="{{ old('source_url') }}" placeholder="https://example.com/news">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Publikasikan</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline text-success">
                                        <input class="form-check-input" type="radio" name="published" id="published_yes" value="yes" checked>
                                        <label class="form-check-label fw-bold" for="published_yes">Ya</label>
                                    </div>
                                    <div class="form-check form-check-inline text-danger">
                                        <input class="form-check-input" type="radio" name="published" id="published_no" value="no">
                                        <label class="form-check-label fw-bold" for="published_no">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Upload Gambar Berita</label>
                                <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                                <div class="form-text">Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger btn-lg rounded-pill fw-bold py-2 shadow-sm">Simpan Berita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
