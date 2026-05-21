<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gopet</title>
</head>
<body>

    <h2>Dashboard Gopet</h2>

    <p>Halo, <b>{{ $nama }}</b></p>
    <p>Role: {{ $role }}</p>

    <hr>

    <h3>Daftar Hewan Kamu 🐶</h3>

    @if($daftar_hewan->count() > 0)
        @foreach($daftar_hewan as $data)
            <p>Nama: {{ $data->nama_hewan }} | Jenis: {{ $data->jenis }}</p>
        @endforeach
    @else
        <p>Belum ada data hewan.</p>
    @endif

    <br><br>
    <a href="/logout">Logout</a>

</body>
</html>
