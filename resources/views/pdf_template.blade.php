<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            margin: 0;
            position: relative;
            font-family: sans-serif;
        }

        .image {
            position: absolute;
            left: {{ $x }}cm;
            top: {{ $y }}cm;
            width: 3cm;
            height: 4cm;
        }

        .content {
            margin-top: 6cm;
            text-align: center;
        }
    </style>
</head>

<body>
    <img src="{{ $imgData }}" class="image">
    <div class="content">
        <h2>PDF dengan Foto 3x4 cm</h2>
        <p>Contoh konten PDF di bawah gambar.</p>
    </div>
</body>

</html>
