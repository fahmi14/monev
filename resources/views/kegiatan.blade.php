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

    @foreach ($kegiatans as $kegiatan)
        <a href="{{ url('/kegiatan/' . $kegiatan->id) }}" class="text-decoration-none text-dark">
        <div class="card kegiatan-card gc-pbi">
            <div class="card-body">
                <h4 class="card-title">{{ $kegiatan->nama }}</h4>
                <p class="card-text">{{ $kegiatan->tahun }}</p>
            </div>
        </div>
    </a>
    @endforeach
    


</div>

</body>
</html>