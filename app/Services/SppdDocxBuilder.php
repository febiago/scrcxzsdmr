<?php

namespace App\Services;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Cell;
use PhpOffice\PhpWord\Style\Table;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\SimpleType\VerticalJc;

class SppdDocxBuilder
{
    public function build(array $v, string $downloadName = 'SPPD.docx'): string
    {
        // $v berisi data yang nanti kamu isi dari Controller
        // ex:
        // $v = [
        //   'data' => Collection<Sppd>,
        //   'first' => Sppd induk,
        //   'camat' => Pegawai,
        //   'bendahara' => Pegawai,
        //   'tgl_berangkat' => '10 Agustus 2025',
        //   'tgl_kembali' => '12 Agustus 2025',
        //   'waktu' => 'Senin, 10 Agustus 2025',
        //   'hari' => 2,
        //   'jumlah' => 250000,
        //   'pengikut' => Collection<Sppd>,
        // ];

        $pw = new PhpWord();
        $pw->setDefaultFontName('Times New Roman');
        $pw->setDefaultFontSize(11);

        // Global styles
        $bold = ['bold' => true];
        $kop = ['bold' => true, 'size' => 18];
        $spt = ['bold' => true, 'size' => 16];
        $center = ['alignment' => Jc::CENTER];
        $right  = ['alignment' => Jc::RIGHT];
        $just   = ['alignment' => Jc::BOTH];

        $tableFull = [
            'borderColor' => '000000',
            'borderSize'  => 6,                 // 1/2 pt * 8 = 4 pt approx
            'unit'        => TblWidth::PERCENT,
            'width'       => 100 * 50,          // percent is handled differently; use Table style options + cell width below
            'cellMargin'  => Converter::cmToTwip(0.2),
        ];

        $marginLeftCm  = 1.27;
        $marginRightCm = 1.27;
        $contentWidthTwip = Converter::cmToTwip(21 - ($marginLeftCm + $marginRightCm));
        $tableNoBorder = [
            'allowAutoFit' => false,                 // jangan biarkan Word mengubah lebar
            'layout'       => Table::LAYOUT_FIXED,   // paksa fixed layout
            'unit'         => TblWidth::TWIP,        // ukuran pakai twips
            'width'        => $contentWidthTwip,     // lebar tabel = lebar konten halaman
            'borderColor' => 'FFFFFF',
            'borderSize'  => 0,
            'cellMargin'  => Converter::cmToTwip(0.05),
        ];

        // Section default A4 + margin ~1.27cm
        $section = $pw->addSection([
            'paperSize'   => 'A4',
            'marginLeft'  => Converter::cmToTwip(1.27),
            'marginRight' => Converter::cmToTwip(1),
            'marginTop'   => Converter::cmToTwip(1.27),
            'marginBottom'=> Converter::cmToTwip(1.27),
        ]);

        $pw->setDefaultParagraphStyle([
            'spaceAfter' => 0,
            'spaceBefore' => 0,
            'lineSpacing' => 1,
        ]);

        // === 1) KOP SURAT ===
        $t = $section->addTable($tableNoBorder);
        $t->addRow();
        $cellLogo = $t->addCell(Converter::cmToTwip(2), ['valign' => VerticalJc::CENTER]);
        $logoPath = public_path('img/kop.png');
        if (is_file($logoPath)) {
            $cellLogo->addImage($logoPath, ['width' => 62]);
        }
        $cellTitle = $t->addCell(Converter::cmToTwip(14), ['valign' => VerticalJc::TOP]);
        $cellTitle->addTextRun($center)
            ->addText('PEMERINTAH KABUPATEN PACITAN', $kop);
        $cellTitle->addTextRun($center)
            ->addText('KECAMATAN SUDIMORO', $kop);
        $cellTitle->addTextRun($center)
            ->addText('Jl. Sudimoro no 22, (0357) 421001');
        $cellTitle->addTextRun($center)
            ->addText('Website : www.sudimoro.pacitankab.go.id');
        $cellTitle->addTextRun($center)
            ->addText('Email : camat_sudimoro@pacitankab.go.id');

        $section->addLine(['weight' => 2,'height' => 0, 'width' => Converter::cmToPixel(14)]); // pengganti <hr>

        // === 2) Judul SPT + Nomor ===
        $section->addText('Surat Perintah Tugas', $spt, $center);
        $nomor = optional($v['data']->first())->no_surat ?? $v['first']->no_surat ?? '-';
        $section->addText("Nomor : {$nomor}", [], $center);
        $section->addTextBreak(1);

        // === 3) Daftar Dasar ===
        $t = $section->addTable($tableNoBorder);
        $this->rowDasar($t, 'Dasar    :', '1.', 'Peraturan Daerah Kabupaten Pacitan Nomor 8 Tahun 2024 tentang Pendapatan dan Belanja Daerah Kabupaten Pacitan Tahun Anggaran 2025');
        $this->rowDasar($t, '', '2.', 'Peraturan Bupati Pacitan Nomor 126 Tahun 2023 tentang Perubahan Kedua atas Peraturan Bupati Nomor 45 Tahun 2021 tentang Pedoman Pelaksanaan Perjalanan Dinas Pemerintah Kabupaten Pacitan');
        $this->rowDasar($t, '', '3.', 'Peraturan Bupati Pacitan Nomor 21 Tahun 2024 tentang Standar Biaya Umum Pemerintah Kabupaten Pacitan Tahun Anggaran 2025');
        $this->rowDasar($t, '', '4.', 'Peraturan Bupati Pacitan Nomor 81 Tahun 2024 tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2025');
        $this->rowDasar($t, '', '5.', optional($v['data']->first())->dasar ?? '');

        $section->addTextBreak(1);

        // === 4) MEMERINTAHKAN + daftar pegawai ===
        $section->addText('MEMERINTAHKAN', $bold, $center);
        foreach ($v['data'] as $i => $row) {
            $t = $section->addTable($tableNoBorder);
            $t->addRow();
            $t->addCell(Converter::cmToTwip(1.8))->addText($i === 0 ? 'Kepada :' : '');
            $t->addCell(Converter::cmToTwip(0.8))->addText(($i + 1) . '.');
            $t->addCell(Converter::cmToTwip(3.2))->addText('Nama');
            $t->addCell(Converter::cmToTwip(10))->addText(': ' . ($row->pegawai->nama ?? ''));

            $t->addRow();
            $t->addCell(Converter::cmToTwip(1.8))->addText('');
            $t->addCell(Converter::cmToTwip(0.8))->addText('');
            $t->addCell(Converter::cmToTwip(3.2))->addText('Pangkat / golongan');
            $t->addCell(Converter::cmToTwip(10))->addText(': ' . ($row->pegawai->pangkat ?? ''));

            $t->addRow();
            $t->addCell(Converter::cmToTwip(1.8))->addText('');
            $t->addCell(Converter::cmToTwip(0.8))->addText('');
            $t->addCell(Converter::cmToTwip(3.2))->addText('NIP');
            $t->addCell(Converter::cmToTwip(10))->addText(': ' . ($row->pegawai->nip ?? ''));

            $t->addRow();
            $t->addCell(Converter::cmToTwip(1.8))->addText('');
            $t->addCell(Converter::cmToTwip(0.8))->addText('');
            $t->addCell(Converter::cmToTwip(3.2))->addText('Jabatan');
            $t->addCell(Converter::cmToTwip(10))->addText(': ' . ($row->pegawai->jabatan ?? ''));
        }

        $section->addTextBreak(1);

        // === 5) Untuk: perihal, tanggal, tempat ===
        $t = $section->addTable($tableNoBorder);
        $t->addRow();
        $t->addCell(Converter::cmToTwip(2))->addText('Untuk');
        $t->addCell(Converter::cmToTwip(1))->addText(': 1.');
        $t->addCell(Converter::cmToTwip(12))->addText($v['first']->perihal ?? '');

        $t->addRow();
        $t->addCell(Converter::cmToTwip(2))->addText('');
        $t->addCell(Converter::cmToTwip(1))->addText(': 2.');
        $t->addCell(Converter::cmToTwip(12))->addText("Pada Tanggal {$v['tgl_berangkat']} s.d {$v['tgl_kembali']}");

        $t->addRow();
        $t->addCell(Converter::cmToTwip(2))->addText('');
        $t->addCell(Converter::cmToTwip(1))->addText(': 3.');
        $t->addCell(Converter::cmToTwip(12))->addText('Bertempat di ' . ($v['first']->tujuan ?? ''));

        $section->addTextBreak(1);

        // === 6) Blok tanda tangan Camat ===
        $t = $section->addTable($tableNoBorder);
        $t->addRow();
        $t->addCell(Converter::cmToTwip(10))->addText('');
        $t->addCell(Converter::cmToTwip(7))->addText('Ditetapkan di Pacitan');
        $t->addRow();
        $t->addCell(Converter::cmToTwip(10))->addText('');
        $t->addCell(Converter::cmToTwip(7))->addText('Pada Tanggal : ' . $v['tgl_berangkat']);
        $t->addRow();
        $t->addCell(Converter::cmToTwip(10))->addText('');
        $t->addCell(Converter::cmToTwip(7))->addText('Camat Sudimoro', $bold);
        $t->addRow(Converter::cmToTwip(2));
        $t->addRow();
        $t->addCell(Converter::cmToTwip(10))->addText('');
        $t->addCell(Converter::cmToTwip(7))->addText($v['camat']->nama ?? '', ['bold' => true, 'underline' => 'single']);
        $t->addRow();
        $t->addCell(Converter::cmToTwip(10))->addText('');
        $t->addCell(Converter::cmToTwip(7))->addText($v['camat']->pangkat ?? '');
        $t->addRow();
        $t->addCell(Converter::cmToTwip(10))->addText('');
        $t->addCell(Converter::cmToTwip(7))->addText('NIP. ' . ($v['camat']->nip ?? ''));

        // === PAGE BREAK ===
        $section->addPageBreak();

        // === 7) (Per pegawai) SPD lembar 1 ===
        foreach ($v['data'] as $idx => $row) {
            // Kop ulang
            $this->kop($section, $logoPath);

            $section->addLine(['weight' => 2,'height' => 0, 'width' => Converter::cmToPixel(14)]);

            $t = $section->addTable($tableNoBorder);
            $t->addRow();
            $t->addCell(Converter::cmToTwip(8.5))->addText('');
            $t->addCell(Converter::cmToTwip(2))->addText('Lembar ke');
            $t->addCell(Converter::cmToTwip(3.5))->addText(': 1');

            $t->addRow();
            $t->addCell(Converter::cmToTwip(8.5))->addText('');
            $t->addCell(Converter::cmToTwip(2))->addText('Kode no');
            $t->addCell(Converter::cmToTwip(3.5))->addText(': ' . ($idx + 1));

            $t->addRow();
            $t->addCell(Converter::cmToTwip(8.5))->addText('');
            $t->addCell(Converter::cmToTwip(2))->addText('Nomor');
            $t->addCell(Converter::cmToTwip(3.5))->addText(': ' . $nomor);

            $section->addTextBreak(0.5);
            $section->addText('SURAT PERJALANAN DINAS (SPD)', $spt, $center);
            $section->addTextBreak(0.5);

            // Tabel SPD (border)
            $spd = $section->addTable([
                'allowAutoFit' => false,                 // jangan biarkan Word mengubah lebar
                'layout'       => Table::LAYOUT_FIXED,   // paksa fixed layout
                'unit'         => TblWidth::TWIP,        // ukuran pakai twips
                'width'        => $contentWidthTwip,     // lebar tabel = lebar konten halaman
                'borderColor' => '000000',
                'borderSize'  => 6,
                'cellMargin'  => Converter::cmToTwip(0.15),
                'alignment'   => Jc::BOTH,
            ]);

            $this->row4($spd, '1', 'Pengguna Anggaran / Kuasa Pengguna Anggaran', ':', 'Camat Sudimoro');
            $this->row4($spd, '2', 'Nama / NIP Pegawai yang melaksanakan Perjalanan Dinas', ':', ($row->pegawai->nama ?? '') . " / " . ($row->pegawai->nip ?? ''));
            $this->row4($spd, '3', 'a. Pangkat / Golongan', ':', $row->pegawai->pangkat ?? '');
            $this->row4($spd, '', 'b. Jabatan', ':', $row->pegawai->jabatan ?? '');
            $this->row4($spd, '', 'c. Tingkat Biaya Perjalanan Dinas', ':', $row->jenis_sppd->nama ?? '');
            $this->row4($spd, '4', 'Maksud perjalanan dinas', ':', $row->perihal ?? '');
            $this->row4($spd, '5', 'Alat Angkut yang digunakan', ':', $row->kendaraan ?? '');
            $this->row4($spd, '6', 'a. Tempat berangkat', ':', 'Kecamatan Sudimoro');
            $this->row4($spd, '', 'b. Tempat tujuan', ':', $row->tujuan ?? '');
            $this->row4($spd, '7', 'a. Lamanya Perjalanan Dinas', ':', (($v['hari'] ?? 0) + 1) . ' Hari');

            // Pengikut
            $spd->addRow();
            $spd->addCell(Converter::cmToTwip(1))->addText('8');
            $spd->addCell(Converter::cmToTwip(6))->addText('Pengikut : nama');
            $spd->addCell(Converter::cmToTwip(1))->addText(':');
            $spd->addCell(Converter::cmToTwip(6))->addText('Jabatan');

            if (!empty($v['pengikut']) && count($v['pengikut']) > 0 && $idx === 0) {
                foreach ($v['pengikut'] as $k => $np) {
                    $spd->addRow();
                    $spd->addCell(Converter::cmToTwip(1))->addText('');
                    $spd->addCell(Converter::cmToTwip(6))->addText(($k + 1) . '. ' . ($np->pegawai->nama ?? ''));
                    $spd->addCell(Converter::cmToTwip(1))->addText(':');
                    $spd->addCell(Converter::cmToTwip(6))->addText($np->pegawai->jabatan ?? '');
                }
            } else {
                // placeholder 2 baris
                for ($i2 = 1; $i2 <= 2; $i2++) {
                    $spd->addRow();
                    $spd->addCell(Converter::cmToTwip(1))->addText('');
                    $spd->addCell(Converter::cmToTwip(6))->addText($i2 . '. ');
                    $spd->addCell(Converter::cmToTwip(1))->addText(':');
                    $spd->addCell(Converter::cmToTwip(6))->addText('');
                }
            }

            $this->row4($spd, '9', 'Pembebanan Anggaran', ':', 'APBD Kab. Pacitan');
            $this->row4($spd, '', 'a. Instansi', ':', 'Kecamatan Sudimoro');
            $this->row4($spd, '', 'b. Kode rekening', ':', '5.1.02.04.01.0003');
            $this->row4($spd, '10', 'Keterangan Lain-Lain', ':', $row->keterangan ?? '');

            // TTD ulang
            $section->addTextBreak(0.5);
            $t = $section->addTable($tableNoBorder);
            $t->addRow();
            $t->addCell(Converter::cmToTwip(10))->addText('');
            $t->addCell(Converter::cmToTwip(7))->addText('Ditetapkan di Pacitan');
            $t->addRow();
            $t->addCell(Converter::cmToTwip(10))->addText('');
            $t->addCell(Converter::cmToTwip(7))->addText('Pada Tanggal : ' . $v['tgl_berangkat']);
            $t->addRow();
            $t->addCell(Converter::cmToTwip(10))->addText('');
            $t->addCell(Converter::cmToTwip(7))->addText('Camat Sudimoro', $bold);
            $t->addRow(Converter::cmToTwip(1.3));
            $t->addRow();
            $t->addCell(Converter::cmToTwip(10))->addText('');
            $t->addCell(Converter::cmToTwip(7))->addText($v['camat']->nama ?? '', ['bold' => true, 'underline' => 'single']);
            $t->addRow();
            $t->addCell(Converter::cmToTwip(10))->addText('');
            $t->addCell(Converter::cmToTwip(7))->addText($v['camat']->pangkat ?? '');
            $t->addRow();
            $t->addCell(Converter::cmToTwip(10))->addText('');
            $t->addCell(Converter::cmToTwip(7))->addText('NIP. ' . ($v['camat']->nip ?? ''));

            if ($idx < (count($v['data']) - 1)) {
                $section->addPageBreak();
            }
        }

        // === PAGE BREAK ===
        $section->addPageBreak();

        // === 8) KUITANSI ===
        $section->addText('RINCIAN BIAYA PERJALANAN DINAS DALAM DAERAH', $spt, $center);
        $section->addTextBreak(1);
        $section->addText('KUITANSI', $kop, $center);

        $kuit = $section->addTable($tableNoBorder);
        $this->row2($kuit, 'Nomor', ': ');
        $this->row2($kuit, 'Sudah terima dari', ': Bendahara Pengeluaran Kecamatan Sudimoro');
        $this->row2($kuit, 'Terbilang', ': ' . \Terbilang::make($v['jumlah'], ' rupiah'));
        $guna = (optional($v['first']->jenis_sppd)->id == 1) ? 'Uang Transport' : 'Uang Harian';
        $this->row2($kuit, 'Guna Membayar', ': ' . $guna . ' ' . ($v['first']->perihal ?? '') . ' di ' . ($v['first']->tujuan ?? '') . ' pada Tgl ' . $v['tgl_berangkat']);
        $this->row2($kuit, 'Jumlah Uang', ': Rp. ' . number_format($v['jumlah'], 2));

        $section->addTextBreak(0.5);

// hitung lebar area konten (A4 = 21cm, margin kiri/kanan contoh 1.27cm)
$marginLeft = 1.27;
$marginRight = 1.27;
$contentW = Converter::cmToTwip(21 - ($marginLeft + $marginRight));

// lebar kolom konsisten
$w1 = Converter::cmToTwip(1.2);   // NO
$w2 = Converter::cmToTwip(7.5);   // PERHITUNGAN BIAYA
$w3 = Converter::cmToTwip(5.5);   // JUMLAH
$w4 = $contentW - ($w1 + $w2 + $w3); // PENERIMA (sisa agar pas margin)

// gaya paragraf ringkas
$pCenter = ['alignment' => Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 0];
$pRight  = ['alignment' => Jc::RIGHT,  'spaceBefore' => 0, 'spaceAfter' => 0];
$pBase   = ['spaceBefore' => 0, 'spaceAfter' => 0];

// SATU TABEL SAJA (fixed layout + width penuh)
$tbl = $section->addTable([
    'borderColor' => '000000',
    'borderSize'  => 6,
    'cellMargin'  => 0,
    'allowAutoFit'=> false,
    'unit'        => \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP,
    'width'       => $contentW,
]);

// HEADER
$tbl->addRow(360);
$tbl->addCell($w1)->addText('NO', $bold, $pCenter);
$tbl->addCell($w2)->addText('PERHITUNGAN BIAYA', $bold, $pCenter);
$tbl->addCell($w3)->addText('JUMLAH', $bold, $pCenter);
$tbl->addCell($w4)->addText('NAMA DAN TANDA TANGAN PENERIMA', $bold, $pCenter);

// baris penanda 1,2,3,4
$tbl->addRow(260);
$tbl->addCell($w1)->addText('1', ['italic' => true], $pCenter);
$tbl->addCell($w2)->addText('2', ['italic' => true], $pCenter);
$tbl->addCell($w3)->addText('3', ['italic' => true], $pCenter);
$tbl->addCell($w4)->addText('4', ['italic' => true], $pCenter);

// DATA
foreach ($v['data'] as $i => $row) {
    $tbl->addRow(300);

    // kolom 1: nomor
    $tbl->addCell($w1)->addText((string)($i + 1), [], $pCenter);

    // kolom 2: uraian + baris kedua
    $c2  = $tbl->addCell($w2);
    $run = $c2->addTextRun($pCenter);
    $run->addText((optional($row->jenis_sppd)->id == 1) ? 'Uang Transport' : 'Uang Harian', [], $pBase);
    $run->addTextBreak();
    $run->addText('1 x Rp. ' . number_format(optional($row->jenis_sppd)->biaya ?? 0, 2), [], $pBase);

    // kolom 3: jumlah (kanan)
    $tbl->addCell($w3)->addText(
        'Rp. ' . number_format(optional($row->jenis_sppd)->biaya ?? 0, 2),
        [],
        $pRight
    );

    // kolom 4: nama penerima (turunkan beberapa baris)
    $c4  = $tbl->addCell($w4);
    $r4  = $c4->addTextRun($pCenter);
    $r4->addTextBreak();
    $r4->addTextBreak();
    $r4->addTextBreak();
    $r4->addText($row->pegawai->nama ?? '', [], $pBase);
}

// BARIS TOTAL
$tbl->addRow(300);

// span 2 kolom pertama: width = $w1 + $w2
$cellSpan = $tbl->addCell($w1 + $w2, ['gridSpan' => 2]);
$cellSpan->addText('JUMLAH SELURUHNYA', ['bold' => true], $pCenter);

// kolom 3: total rupiah
$tbl->addCell($w3)->addText(
    'Rp. ' . number_format($v['jumlah'], 2),
    ['bold' => true],
    $pRight
);

// kolom 4: kosong
$tbl->addCell($w4)->addText('', [], $pBase);

$section->addTextBreak(1);

        // Tabel tanda tangan (pakai TextRun, bukan "\n")
        $t = $section->addTable([
            'borderColor' => 'FFFFFF',
            'borderSize'  => 0,
            'cellMargin'  => 0,
            'allowAutoFit'=> false,
            'layout'      => \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,
            'unit'        => \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP,
            'width'       => $contentW,
        ]);

        $t->addRow();
        $left  = $t->addCell(Converter::cmToTwip(8));
        $mid   = $t->addCell(Converter::cmToTwip(2));
        $right = $t->addCell($contentW - Converter::cmToTwip(10)); // sisa

        // kiri
        $r = $left->addTextRun(['spaceBefore'=>0, 'spaceAfter'=>0]);
        $r->addTextBreak();
        $r->addText('Mengetahui/menyetujui');
        $r->addTextBreak();
        $r->addText('Kuasa Pengguna Anggaran');
        $r->addTextBreak(); $r->addTextBreak(); $r->addTextBreak(); $r->addTextBreak();
        $r->addText($v['camat']->nama ?? '', ['bold'=>true, 'underline'=>'single']);
        $r->addTextBreak();
        $r->addText($v['camat']->nip ?? '');

        // kanan
        $r2 = $right->addTextRun(['spaceBefore'=>0, 'spaceAfter'=>0]);
        $r2->addText('Lunas Dibayar');
        $r2->addTextBreak();
        $r2->addText('Pada Tanggal : ' . $v['tgl_berangkat']);
        $r2->addTextBreak();
        $r2->addText('Bendahara Pengeluaran Kec. Sudimoro');
        $r2->addTextBreak(); $r2->addTextBreak(); $r2->addTextBreak(); $r2->addTextBreak();
        $r2->addText($v['bendahara']->nama ?? '', ['bold'=>true, 'underline'=>'single']);
        $r2->addTextBreak();
        $r2->addText($v['bendahara']->nip ?? '');

    // === PAGE BREAK ===
    $section->addPageBreak();

        // === 9) Laporan Perjalanan Dinas ===
        $section->addText('LAPORAN PERJALANAN DINAS', $kop, $center);
        $section->addTextBreak(0.5);

        $lap = $section->addTable($tableNoBorder);
        $this->row3($lap, 'I.', 'DASAR', ': ' . ($v['first']->no_surat ?? ''));
        $this->row3($lap, 'II.', 'MAKSUD DAN TUJUAN', ': ' . ($v['first']->perihal ?? ''));
        $this->row3($lap, 'III.', 'WAKTU PELAKSANAAN', ': ' . $v['waktu'] . ' Jam ............ WIB s/d ............ WIB');

        foreach ($v['data'] as $i => $petugas) {
            $this->row3($lap, ($i === 0 ? 'IV.' : ''), ($i === 0 ? 'NAMA PETUGAS' : ''), ': ' . ($i + 1) . '. ' . ($petugas->pegawai->nama ?? ''));
        }

        $this->row3($lap, 'V.', 'DAERAH TUJUAN/INSTANSI YANG DIKUNJUNGI', ': ' . ($v['first']->tujuan ?? ''));
        $this->row3($lap, 'VI.', 'HADIR DALAM PERTEMUAN', ': ');
        $this->row3Area($lap, 'VII.', 'PETUNJUK / ARAHAN YANG DIBERIKAN');
        $this->row3Area($lap, 'VIII.', 'MASALAH / TEMUAN');
        $this->row3Area($lap, 'IX.', 'SARAN TINDAKAN');
        $this->row3Area($lap, 'X.', 'LAIN - LAIN');

        $section->addTextBreak(1);

        $col = $v['data'];
        $ttd2 = method_exists($col, 'get') ? $col->get(1) : ($col[1] ?? null);
        $ttd1 = method_exists($col, 'get') ? $col->get(0) : ($col[0] ?? null);

        $namaTtd = $ttd2->pegawai->nama ?? ($ttd1->pegawai->nama ?? '');
        $nipTtd  = $ttd2->pegawai->nip  ?? ($ttd1->pegawai->nip  ?? '');

        // Tabel tanpa border
        $t = $section->addTable($tableNoBorder);
        $t->addRow();

        // Kolom kiri spacer
        $t->addCell(Converter::cmToTwip(11))->addText('', [], ['spaceBefore'=>0, 'spaceAfter'=>0]);

        // Kolom kanan: pakai TextRun + addTextBreak (pengganti "\n")
        $cell = $t->addCell(Converter::cmToTwip(7));
        $run  = $cell->addTextRun(['alignment' => Jc::LEFT, 'spaceBefore'=>0, 'spaceAfter'=>0]);

        $run->addText('Sudimoro, ' . ($v['tgl_berangkat'] ?? ''));
        $run->addTextBreak();
        $run->addText('Yang melaksanakan Perjalanan Dinas');
        // jeda tanda tangan
        $run->addTextBreak(); $run->addTextBreak(); $run->addTextBreak(); $run->addTextBreak();
        $run->addText($namaTtd, ['bold'=>true, 'underline'=>'single']);
        $run->addTextBreak();
        $run->addText('NIP ' . $nipTtd);

        // === PAGE BREAK ===
        $section->addPageBreak();

        // === 10) SPD Lembar 2 (Form blangko cap) ===
        $tjudul = $section->addTable($tableNoBorder);
        $tjudul->addRow();
        $tjudul->addCell(Converter::cmToTwip(9))->addText('');
        $tjudul->addCell(Converter::cmToTwip(3))->addText('SPPD Nomor');
        $tjudul->addCell(Converter::cmToTwip(4))->addText(': ' . $nomor);
        $tjudul->addRow();
        $tjudul->addCell(Converter::cmToTwip(9))->addText('');
        $tjudul->addCell(Converter::cmToTwip(3))->addText('Lembar Ke');
        $tjudul->addCell(Converter::cmToTwip(4))->addText(': 2');

        $section->addTextBreak(0.5);

        // Tabel 3 kolom besar
        $tbl = $section->addTable([
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => Converter::cmToTwip(0.2),
            'allowAutoFit' => false,                 // jangan biarkan Word mengubah lebar
            'layout'       => Table::LAYOUT_FIXED,   // paksa fixed layout
            'unit'         => TblWidth::TWIP,        // ukuran pakai twips
            'width'        => $contentWidthTwip,     // lebar tabel = lebar konten halaman
        ]);

        // Baris 1
        $tbl->addRow();
        $tbl->addCell(Converter::cmToTwip(1), ['vMerge' => 'restart', 'valign' => VerticalJc::CENTER])->addText('');
        $tbl->addCell(Converter::cmToTwip(8), ['vMerge' => 'restart'])->addText('');
        $c = $tbl->addCell(Converter::cmToTwip(8));
        $c->addText('Berangkat dari : Kecamatan Sudimoro');
        $c->addText('Pada tanggal    : ' . $v['tgl_berangkat']);
        $c->addText('Ke                    : ' . ($v['first']->tujuan ?? ''));
        $c->addTextBreak(1);
        $c->addText('CAMAT SUDIMORO', $bold, $center);
        $c->addTextBreak(3);
        $c->addText($v['camat']->nama ?? '', ['bold' => true, 'underline' => 'single'], $center);
        $c->addText('NIP. ' . ($v['camat']->nip ?? ''), [], $center);

        // Baris 2
        $tbl->addRow(Converter::cmToTwip(2.2));
        $tbl->addCell(null, ['vMerge' => 'continue']);
        $c1 = $tbl->addCell(Converter::cmToTwip(8));
        $c1->addText('Tiba di          : ' . ($v['first']->tujuan ?? ''));
        $c1->addText('Pada tanggal : ' . $v['tgl_berangkat']);
        $c1->addText('Kepala          : ');
        $c1->addTextBreak(3);
        $c2 = $tbl->addCell(Converter::cmToTwip(8));
        $c2->addText('Berangkat dari : ' . ($v['first']->tujuan ?? ''));
        $c2->addText('Ke                    : Kecamatan Sudimoro');
        $c2->addText('Pada tanggal    : ' . $v['tgl_kembali']);

        // Baris 3
        $tbl->addRow(Converter::cmToTwip(2.2));
        $tbl->addCell(null, ['vMerge' => 'continue'])->addText('III');
        $c1 = $tbl->addCell(Converter::cmToTwip(8));
        $c1->addText('Tiba di          : ');
        $c1->addText('Pada tanggal : ');
        $c1->addText('Kepala          : ');
        $c1->addTextBreak(2);
        $c2 = $tbl->addCell(Converter::cmToTwip(8));
        $c2->addText('Berangkat dari : ');
        $c2->addText('Ke                    : ');
        $c2->addText('Pada tanggal    : ');

        // Baris 4
        $tbl->addRow(Converter::cmToTwip(2.2));
        $tbl->addCell(null, ['vMerge' => 'continue'])->addText('VI');
        $c1 = $tbl->addCell(Converter::cmToTwip(8));
        $c1->addText('Tiba di          : ');
        $c1->addText('Pada tanggal : ');
        $c1->addText('Kepala          : ');
        $c1->addTextBreak(2);
        $c2 = $tbl->addCell(Converter::cmToTwip(8));
        $c2->addText('Berangkat dari : ');
        $c2->addText('Ke                    : ');
        $c2->addText('Pada tanggal    : ');

        // Baris 5
        $tbl->addRow(Converter::cmToTwip(2.2));
        $tbl->addCell(null, ['vMerge' => 'continue'])->addText('V');
        $c1 = $tbl->addCell(Converter::cmToTwip(8));
        $c1->addText('Tiba di          : Kecamatan Sudimoro');
        $c1->addText('Pada tanggal : ' . $v['tgl_berangkat']);
        $c1->addTextBreak(3);
        $c1->addText('CAMAT SUDIMORO', $bold, $center);
        $c1->addTextBreak(3);
        $c1->addText($v['camat']->nama ?? '', ['bold' => true, 'underline' => 'single'], $center);
        $c1->addText('NIP. ' . ($v['camat']->nip ?? ''), [], $center);

        $c2 = $tbl->addCell(Converter::cmToTwip(8));
        $c2->addText('Telah diperiksa dengan keterangan bahwa perjalanan tersebut di atas dilakukan atas perintahnya dan semata mata untuk kepentingan jabatan dalam waktu sesingkat-singkatnya.', [], $just);
        $c2->addTextBreak(1);
        $c2->addText('PENGGUNA ANGGARAN', $bold, $center);
        $c2->addTextBreak(3);
        $c2->addText($v['camat']->nama ?? '', ['bold' => true, 'underline' => 'single'], $center);
        $c2->addText('NIP. ' . ($v['camat']->nip ?? ''), [], $center);

        // Baris 6
        $tbl->addRow();
        $tbl->addCell(null, ['vMerge' => 'continue'])->addText('VI');
        $tbl->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(16), ['gridSpan' => 2])->addText('CATATAN LAIN - LAIN');

        // Baris 7
        $tbl->addRow();
        $tbl->addCell(null, ['vMerge' => 'continue'])->addText('VII');
        $tbl->addCell(Converter::cmToTwip(16), ['gridSpan' => 2])->addText('PERHATIAN');

        // Paragraf perhatian
        $section->addTextBreak(0.5);
        $section->addText(
            'Pejabat yang berwenang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat / tiba serta Bendaharawan bertanggung jawab berdasarkan peraturan-peraturan Keuangan Negara apabila Negara mendapat rugi akibat kesalahan, kelalaian dan kealpaannya',
            [],
            $just
        );

        // === Simpan file ===
        $safe = Str::slug(pathinfo($downloadName, PATHINFO_FILENAME)).'.docx';
        $path = storage_path("app/tmp/{$safe}");
        @mkdir(dirname($path), 0775, true);
        IOFactory::createWriter($pw, 'Word2007')->save($path);

        return $path;
    }

    // ==== Helpers ====

    private function kop($section, string $logoPath): void
    {
        $t = $section->addTable([
            'borderColor' => 'FFFFFF',
            'borderSize'  => 0,
            'cellMargin'  => Converter::cmToTwip(0.05),
        ]);
        $t->addRow();
        $cellLogo = $t->addCell(Converter::cmToTwip(2), ['valign' => VerticalJc::CENTER]);
        if (is_file($logoPath)) {
            $cellLogo->addImage($logoPath, ['width' => 62]);
        }
        $cellTitle = $t->addCell(Converter::cmToTwip(14), ['valign' => VerticalJc::TOP]);
        $cellTitle->addText('PEMERINTAH KABUPATEN PACITAN', ['bold' => true, 'size' => 18], ['alignment' => Jc::CENTER]);
        $cellTitle->addText('KECAMATAN SUDIMORO', ['bold' => true, 'size' => 18], ['alignment' => Jc::CENTER]);
        $cellTitle->addText('Jl. Sudimoro no 22, (0357) 421001', [], ['alignment' => Jc::CENTER]);
        $cellTitle->addText('Website : www.sudimoro.pacitankab.go.id', [], ['alignment' => Jc::CENTER]);
        $cellTitle->addText('Email : kecsudimoro@gmail.com', [], ['alignment' => Jc::CENTER]);
    }

    private function rowDasar($t, string $label, string $nomor, string $isi): void
    {
        $t->addRow();
        $t->addCell(Converter::cmToTwip(2.2))->addText($label);
        $t->addCell(Converter::cmToTwip(0.8))->addText($nomor);
        $t->addCell(Converter::cmToTwip(13))->addText($isi);
    }

    private function row2($t, string $kiri, string $kanan): void
    {
        $t->addRow();
        $t->addCell(Converter::cmToTwip(5))->addText($kiri);
        $t->addCell(Converter::cmToTwip(12))->addText($kanan);
    }

    private function row4($t, string $a, string $b, string $c, string $d): void
    {
        $t->addRow();
        $t->addCell(Converter::cmToTwip(1))->addText($a);
        $t->addCell(Converter::cmToTwip(6))->addText($b);
        $t->addCell(Converter::cmToTwip(1))->addText($c);
        $t->addCell(Converter::cmToTwip(10))->addText($d);
    }

    private function row3($t, string $kode, string $judul, string $isi): void
    {
        $t->addRow();
        $t->addCell(Converter::cmToTwip(1.2))->addText($kode);
        $t->addCell(Converter::cmToTwip(6.8))->addText($judul);
        $t->addCell(Converter::cmToTwip(10))->addText($isi);
    }

    private function row3Area($t, string $kode, string $judul): void
    {
        $this->row3($t, $kode, $judul, ': ........................................................................................................');
        $t->addRow();
        $t->addCell(Converter::cmToTwip(1.2))->addText('');
        $t->addCell(Converter::cmToTwip(6.8))->addText('');
        $t->addCell(Converter::cmToTwip(10))->addText("  ........................................................................................................\n  ........................................................................................................\n  ........................................................................................................");
    }
}
