<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PDFController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file'   => 'required|mimes:pdf',
            'image_file' => 'required|image',
            'x'          => 'required|numeric', // posisi kiri dalam mm
            'y'          => 'required|numeric', // posisi atas dalam mm
        ]);

        // Simpan file PDF asli
        $pdfPath = $request->file('pdf_file')->storeAs('temp', 'input.pdf');
        $pdfFullPath = storage_path('app/' . $pdfPath);

        // Konversi gambar ke PNG menggunakan Intervention Image
        $originalImagePath = $request->file('image_file')->getRealPath();
        $imageOutputPath = storage_path('app/temp/image_converted.png');

        $manager = new ImageManager(new GdDriver());
        $manager->read($originalImagePath)->toPng()->save($imageOutputPath);

        // Buat PDF baru dari PDF lama + gambar
        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile($pdfFullPath);
        $template = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($template);

        // Tambahkan halaman dengan ukuran sama
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($template);

        // Tempelkan gambar ukuran 3x4 cm (30x40 mm) di posisi x, y
        $pdf->Image($imageOutputPath, $request->x, $request->y, 30, 40); // 30mm x 40mm

        // Output PDF ke browser
        return response($pdf->Output('S', 'output.pdf'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="output.pdf"');
    }
}