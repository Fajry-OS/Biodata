<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penjumlahan</title>
</head>

<body>
    <h1>Penjumlahan</h1>
    <form action="{{ route('store_penjumlahan') }}" method="post">
        {{-- untuk csrf digunkan untuk mengamankan dari sql injection --}}
        @csrf
        <label for="">Angka 1</label>
        <input type="number" name="angka1" placeholder="Masukkan angka 1"><br><br>
        <label for="">Angka 2</label>
        <input type="number" name="angka2" placeholder="Masukkan angka 2"><br><br>
        <button type="submit">Hitung</button>
    </form>

    <h1>Hasil : {{ $jumlah }}</h1>
    <a href="{{ url('latihan') }}">Back</a>


</body>

</html>
