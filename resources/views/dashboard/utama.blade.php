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
                <p>Total Dokumen :
                    <strong>
                        {{ number_format($total->submit + $total->reject + $total->approve, 0, ',', '.') }}
                    </strong>
                </p>
                <p>Progres Dokumen :
                    <strong>{{ round(
                        (($total->submit + $total->reject + $total->approve) /
                            ($total->submit + $total->reject + $total->approve + $total->open)) *
                            100,
                        2,
                    ) }}%</strong>
                </p>
                <p id="lastUpdate"> Last Update: {{ $kegiatan->updated_at->addHours(7)->format('d-m-Y H:i:s') }}</p>
            </div>



            <div class="header-logo">
                <img src="{{ asset('images/icon.png') }}">
            </div>

        </div>
        <div class="row g-3">

        <div class="col-md-3">
            <div class="card text-center border-secondary">
                <div class="card-body card-open">
                    <h6 class="text-muted">OPEN</h6>
                    <h2>{{ number_format($total->open, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body card-approve">
                    <h6 class="text-muted">SUBMITTED</h6>
                    <h2>{{ number_format($total->submit, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body card-reject">
                    <h6 class="text-muted">REJECT</h6>
                    <h2>{{ number_format($total->reject, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body card-submit">
                    <h6 class="text-muted">APPROVE</h6>
                    <h2>{{ number_format($total->approve, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

    </div>


        <!-- TABEL -->
        <div class="row mt-4">
            <div class="col-md-12">

                <div class="card p-3">

                    <h5>Tabel Petugas</h5>

                    <div class="mb-3">

                        <a class="btn btn-success me-2" href="{{ route('download.excel', $kegiatan->id) }}">
                            Download Excel
                        </a>

                    </div>
                    @php
                        function sortLink($column, $label, $sort, $direction)
                        {
                            $newDirection = $sort == $column && $direction == 'asc' ? 'desc' : 'asc';
                            $arrow = '';

                            if ($sort == $column) {
                                $arrow = $direction == 'asc' ? '↑' : '↓';
                            }

                            $query = array_merge(request()->query(), [
                                'sort' => $column,
                                'direction' => $newDirection,
                            ]);

                            $url = url()->current() . '?' . http_build_query($query);

                            return '<a href="' .
                                $url .
                                '" style="text-decoration:none;color:inherit;">
                ' .
                                $label .
                                ' ' .
                                $arrow .
                                '
            </a>';
                            if ($sort == 'progress') {
                                $petugass = Petugas::where('id_kegiatan', $id)
                                    ->orderByRaw(
                                        '(submit + reject + approve) / (submit + reject + approve + open) ' .
                                            $direction,
                                    )
                                    ->paginate(10)
                                    ->withQueryString();
                            }
                        }
                    @endphp
                    <form method="GET" class="mb-3 d-flex align-items-center gap-2">
                        <label>Tampilkan:</label>
                    
                        <select name="perPage" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    
                        <!-- biar sorting tetap kebawa -->
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <input type="hidden" name="direction" value="{{ $direction }}">
                    </form>
                    <table class="table table-striped">

                        <thead>
                            <tr>
                                <th>{!! sortLink('nama', 'Nama Petugas', $sort, $direction) !!}</th>
                                <th class="text-end">{!! sortLink('open', 'OPEN', $sort, $direction) !!}</th>
                                <th class="text-end">{!! sortLink('submit', 'SUBMITTED', $sort, $direction) !!}</th>
                                <th class="text-end">{!! sortLink('reject', 'REJECTED', $sort, $direction) !!}</th>
                                <th class="text-end">{!! sortLink('approve', 'APPROVED', $sort, $direction) !!}</th>
                                <th class="text-end">{!! sortLink('progress', 'Progress', $sort, $direction) !!}</th>
                            </tr>
                        </thead>

                        <tbody id="tablePetugas"></tbody>
                        @foreach ($petugass as $petugas)
                            <tr>
                                <td>{{ $petugas->nama }}</td>
                                <td class="text-end">{{ number_format($petugas->open, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($petugas->submit, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($petugas->reject, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($petugas->approve, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    {{ round(
                                        (($petugas->submit + $petugas->reject + $petugas->approve) /
                                            ($petugas->submit + $petugas->reject + $petugas->approve + $petugas->open)) *
                                            100,
                                        2,
                                    ) }}%
                                </td>
                            </tr>
                        @endforeach

                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">



                        <div>
                            {{ $petugass->links() }}
                        </div>

                    </div>
                    {{-- <div class="d-flex justify-content-between align-items-center mt-3"> --}}

                    {{-- <button class="btn btn-outline-primary" onclick="prevPage()">
← Sebelumnya
</button>

<span id="pageInfo"></span>

<button class="btn btn-outline-primary" onclick="nextPage()">
Berikutnya →
</button> --}}

                    {{-- </div> --}}

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
