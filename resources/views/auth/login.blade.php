<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Pengaduan Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-lg p-4" style="width: 500px; border-radius: 1rem;">
        <div class="text-center mb-4">
            <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                     class="bi bi-building-check text-primary" viewBox="0 0 16 16">
                    <path d="M6.5 15.5v-1h3v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5M13 2.5a.5.5 0 0 0-.5-.5H9V1a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v1H1.5a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5H6v-1h4v1h4.5a.5.5 0 0 0 .5-.5zm-1 13V3h-2v12zm-3 0V1H4v14z"/>
                    <path d="M15.854 5.146a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L12 8.793l3.146-3.147a.5.5 0 0 1 .708 0"/>
                </svg>
            </div>
            <h4 class="mt-3 fw-bold text-primary">Login Sistem Pengaduan Desa</h4>
            <p class="text-muted small mb-0">Layanan Aspirasi dan Pengaduan Masyarakat Desa</p>
        </div>

        @include('partials.toaster')

        <form method="POST" action="/login">
            @csrf
            <input type="hidden" name="from_url" id="from_url" value="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="{{ old('username', session('username')) }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                Masuk
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // get from_url param
    const from_url = new URLSearchParams(window.location.search).get('from_url');
    if (from_url) {
        document.getElementById('from_url').value = from_url;
    }
    </script>
</body>
</html>
