<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Monitoring GC PLN</title>

<link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/gc-pln.css') }}">

</head>

<body>

<div class="container-fluid p-4">

<!-- Tombol Kembali -->
<div class="mb-3">
<a href="/" class="btn back-btn shadow-sm">
← Kembali ke Beranda
</a>
</div>

<div class="header d-flex justify-content-between align-items-center">

<div>
<h2>Dashboard Monitoring GC PLN Kabupaten Wonosobo</h2>
<p>Total Dokumen : <span id="total">-</span></p>
<p id="lastUpdate">Last Update: -</p>
</div>

<div class="logo-kecil">
<img src="{{ asset('images/bps.png') }}">
<img src="{{ asset('images/Logo_PLN.png') }}">
</div>

<div class="header-logo">
<img src="{{ asset('images/icon.png') }}">
</div>

</div>

<!-- CARD -->
<div class="row">

<div class="col-md-3">
<div class="card dashboard-card card-open">
<h5>OPEN</h5>
<h2 id="open">0</h2>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-submit">
<h5>SUBMITTED</h5>
<h2 id="submit">0</h2>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-reject">
<h5>REJECT</h5>
<h2 id="reject">0</h2>
</div>
</div>

<div class="col-md-3">
<div class="card dashboard-card card-progress">
<h5>PROGRESS</h5>
<h2 id="progress">0%</h2>
</div>
</div>

</div>


<!-- TABEL -->
<div class="row mt-4">
<div class="col-md-12">

<div class="card p-3">

<h5>Tabel Petugas</h5>

<div class="mb-3">

<button class="btn btn-success me-2" onclick="exportPetugas()">
Download Excel
</button>

</div>

<table class="table table-striped">

<thead>
<tr>
<th>Nama Petugas</th>
<th class="text-end">OPEN</th>
<th class="text-end">SUBMITTED</th>
<th class="text-end">REJECTED</th>
<th class="text-end progress-sort" onclick="toggleSort()">
Progress ⬍
</th>
</tr>
</thead>

<tbody id="tablePetugas"></tbody>

</table>

<div class="d-flex justify-content-between align-items-center mt-3">

<button class="btn btn-outline-primary" onclick="prevPage()">
← Sebelumnya
</button>

<span id="pageInfo"></span>

<button class="btn btn-outline-primary" onclick="nextPage()">
Berikutnya →
</button>

</div>

</div>

</div>
</div>

</div>

<footer class="footer text-center mt-4">
<p>©2026 | BPS Kabupaten Wonosobo</p>
</footer>

<script src="{{ asset('js/gc-pln.js') }}"></script>

</body>
</html>