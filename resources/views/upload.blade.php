<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Gambar ke PDF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-center text-blue-600 mb-6">
            Tambah Gambar ke PDF Asli
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/upload" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">File PDF Asli</label>
                <input type="file" name="pdf_file" required
                    class="mt-1 w-full border rounded p-2 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Gambar (foto/stempel)</label>
                <input type="file" name="image_file" required
                    class="mt-1 w-full border rounded p-2 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Posisi X (mm)</label>
                    <input type="number" step="0.1" name="x" value="100" required
                        class="mt-1 w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Posisi Y (mm)</label>
                    <input type="number" step="0.1" name="y" value="150" required
                        class="mt-1 w-full border rounded p-2" />
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                    Tempelkan Gambar ke PDF
                </button>
            </div>
        </form>
    </div>

</body>

</html>
