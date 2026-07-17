<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --news-bg: #f4f6fb;
        --news-ink: #111827;
        --news-accent: #d90429;
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: var(--news-bg);
        color: var(--news-ink);
    }

    a {
        text-decoration: none;
    }

    .site-footer {
        background: #0f172a;
        color: rgba(255, 255, 255, 0.82);
    }

    .site-footer a {
        color: #ffffff;
    }
</style>
@stack('styles')
</head>
<body>
@yield('body')

<footer class="site-footer py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-2">
        <div>
            <div class="fw-bold">Kabar Burung</div>
            <small>Portal berita sederhana untuk menampilkan informasi terbaru.</small>
        </div>
        <small>&copy; {{ date('Y') }} Kabar Burung. All rights reserved.</small>
    </div>
</footer>
</body>
</html>
