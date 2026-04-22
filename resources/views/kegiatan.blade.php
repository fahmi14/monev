<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kegiatan</title>

    <!-- Logo Browser -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kegiatan.css') }}">

</head>
<body>

<div class="container mt-4">

    <div class="header">
        <h2>Dashboard Monitoring</h2>
        <h4>BPS Kabupaten Wonosobo</h4>
    </div>

    <a href="/dashboard/gc-pbi" class="text-decoration-none">
        <div class="card kegiatan-card gc-pbi">
            <div class="card-body">
                <h4 class="card-title">GC PBI Tahap 2</h4>
                <p class="card-text">Monitoring Ground Check PBI Tahun 2026</p>
            </div>
        </div>
    </a>

    <a href="/dashboard/gc-pln" class="text-decoration-none">
        <div class="card kegiatan-card gc-pln">
            <div class="card-body">
                <h4 class="card-title">GC PLN</h4>
                <p class="card-text">Monitoring Ground Check PLN Tahun 2026</p>
            </div>
        </div>
    </a>

</div>

</body>
</html>