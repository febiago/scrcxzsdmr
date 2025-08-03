<!DOCTYPE html>
<html>
    <head>
        <title>SPPD</title>
        <style>
            #kop {
              font-size: 24px;
            }
            #spt {
              font-size: 20px;
            }
            td {
                vertical-align: text-top;
            }
            body {
                font-family: "Times-Roman";
                font-size: 11pt;
            }
            .page_break { 
                page-break-before: always; 
            }
            table {
                border-collapse:collapse;
            }
            .page-break-a {
                page-break-inside: avoid;
            }
        </style>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td width="0%" align="center"><img src="{{ public_path('img/kop.png') }}" width="92" alt="Logo">
                </td>
                <td valign="top" width="100%" align="center">
                    <b id="kop">PEMERINTAH KABUPATEN PACITAN</b>
                    <br><b id="kop">KECAMATAN SUDIMORO</b>
                    <br>Jl. Sudimoro no 22, (0357) 421001
                    <br>Website : www.sudimoro.pacitankab.go.id
                    <br>Email : camat_sudimoro@pacitankab.go.id
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <center><b id="spt"><u>Surat Perintah Tugas</u></b></center>
        @foreach($data->take(1) as $sppd)
            <center>Nomor : {{ $sppd->no_surat }}</center>
        @endforeach
        <br />
        <table border="0">
            <tr>
                <td width="60">Dasar &nbsp; &nbsp; &nbsp; &nbsp; :</td>
                <td>1. </td>
                <td>Peraturan Daearah Kabupaten Pacitan Nomor 8 Tahun 2024 tentang Pendapatan dan Belanja Daerah Kabupaten Pacitan Tahun Anggaran 2025 </td>
            </tr>
            <tr>
                <td width="60"></td>
                <td>2. </td>
                <td>Peraturan Bupati Pacitan Nomor 126 Tahun 2023 tentang Perubahan Kedua atas Peraturan Bupati Nomor 45 Tahun 2021 tentang Pedoman Pelaksanaan Perjalanan Dinas Pemerintah Kabupaten Pacitan </td>
            </tr>
            <tr>
                <td width="60"></td>
                <td>3. </td>
                <td>Peraturan Bupati Pacitan Nomor 21 Tahun 2024 tentang Standart Biaya Umum Pemerintah Kabupaten Pacitan Tahun Anggaran 2025 </td>
            </tr>
            <tr>
                <td width="60"></td>
                <td>4. </td>
                <td>Peraturan Bupati Pacitan Nomor : 81 Tahun 2024 tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2025</td>
            </tr>
            <tr>
                <td width="60"></td>
                <td>5. </td>
                @foreach($data->take(1) as $dasar)
                <td>{{ $dasar->dasar }}</td>
                @endforeach
            </tr>
        </table>
        <br>
        <center><b>MEMERINTAHKAN</b></center>
        @foreach($data as $sppd)
        <table border="0">
            <tr>
                <td width="60">
                    @if($loop->first)
                    Kepada &nbsp; &nbsp; :
                    @endif
                </td>
                <td>{{ $loop->iteration }}. </td>
                <td width="100">Nama</td>
                <td>: {{ $sppd->pegawai->nama }}</td>
            </tr>
            <tr>
                <td width="60"></td>
                <td></td>
                <td width="100">Pangkat / golongan</td>
                <td>: {{ $sppd->pegawai->pangkat }}</td>
            </tr>
            <tr>
                <td width="60"></td>
                <td></td>
                <td width="100">Nip</td>
                <td>: {{ $sppd->pegawai->nip }}</td>
            </tr>
            <tr>
                <td width="60"></td>
                <td></td>
                <td width="100">Jabatan</td>
                <td>: {{ $sppd->pegawai->jabatan }}</td>
            </tr>
        </table>
        @endforeach
        <br />
        <table>
            <tr>
                <td width="53">Untuk &nbsp; &nbsp;</td> 
                <td width="15">: 1. </td>
                <td>{{ $sppd->perihal }}</td>
            </tr>
            <tr>
                <td></td> 
                <td>: 2.</td>
                <td>Pada Tanggal {{ $tgl_berangkat }} s.d {{ $tgl_kembali }}</td>
            </tr>
            <tr>
                <td></td> 
                <td>: 3.</td>
                <td>Bertempat di {{ $sppd->tujuan }}</td>
            </tr>
        </table>
        <br>
        <div class="page-break-a">
        <table border="0">
            <tr>
                <td width="310"></td>
                <td width="220">Ditetapkan di Pacitan</td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220">Pada Tanggal : {{ $tgl_berangkat }}</td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220" ><b>Camat Sudimoro</b></td>
            </tr>
            <tr>
                <td width="310" height="35"></td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220"><b><u>{{ $camat->nama }}</u></b></td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220">{{ $camat->pangkat }}</td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220">NIP. {{ $camat->nip }}</td>
            </tr>
        </table>
        </div>
        @foreach($data as $sppd)
        <div class="page_break"></div>
        <table width="100%">
            <tr>
                <td width="0%" align="center"><img src="{{ public_path('img/kop.png') }}" width="92" alt="Logo">
                </td>
                <td valign="top" width="100%" align="center">
                    <b id="kop">PEMERINTAH KABUPATEN PACITAN</b>
                    <br><b id="kop">KECAMATAN SUDIMORO</b>
                    <br>Jl. Raya Solo Nomor 021 Pacitan, Telp (0357) 511032
                    <br>Website : www.sudimoro.pacitankab.go.id
                    <br>Email : kecsudimoro@gmail.com
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <table>
            <tr>
                <td width="300"></td>
                <td width="70">Lembar ke</td>
                <td>: 1</td>
            </tr>
            <tr>
                <td width="300"></td>
                <td width="70">Kode no</td>
                <td>: {{ $loop->iteration }}</td>
            </tr>
            <tr>
                <td width="300"></td>
                <td width="70">Nomor</td>
                @foreach($data->take(1) as $nosurat)
                    <td>: {{ $nosurat->no_surat }}</td>
                @endforeach
            </tr>
        </table>
        <br>
        <center><b id="spt"><u>SURAT PERJALANAN DINAS (SPD)</u></b></center>
        <br>
        <table width="100%" border="1">
            <tr>
                <td width="4%">1</td>
                <td width="35%">Pengguna Anggaran / Kuasa Pengguna Anggaran</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> Camat Sudimoro</td>
            </tr>
            <tr>
                <td width="4%">2</td>
                <td width="35%">Nama / NIP Pegawai uang melaksanakan Perjalan Dinas</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->pegawai->nama }} <br> {{ $sppd->pegawai->nip }}</td>
            </tr>
            <tr>
                <td width="4%">3</td>
                <td width="35%">a. Pangkat / Golongan</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->pegawai->pangkat }}</td>
            </tr>
            <tr>
                <td width="4%"></td>
                <td width="35%">b. Jabatan</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->pegawai->jabatan }}</td>
            </tr>
            <tr>
                <td width="4%"></td>
                <td width="35%">c. Tingkat Biaya Perjalan Dinas</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->jenis_sppd->nama }}</td>
            </tr>
            <tr>
                <td width="4%">4</td>
                <td width="35%">Maksud perjalan dinas</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->perihal }}</td>
            </tr>
            <tr>
                <td width="4%">5</td>
                <td width="35%">Alat Angkut yang digunakan</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->kendaraan }}</td>
            </tr>
            <tr>
                <td width="4%">6</td>
                <td width="35%">a. Tempat berangkat</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> Kecamatan Sudimoro</td>
            </tr>
            <tr>
                <td width="4%"></td>
                <td width="35%">b. Tempat tujuan</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->tujuan }}</td>
            </tr>
            <tr>
                <td width="4%">7</td>
                <td width="35%">a. Lamanya Perjalan Dinas</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2">  {{ $hari + 1 }} Hari</td>
            </tr>
            <tr>
                <td width="4%">8</td>
                <td width="35%">Pengikut : nama</td>
                <td width="4%">:</td>
                <td width="20%">Tanggal Lahir</td>
                <td width="37%">Keterangan / Jabatan</td>
            </tr>
                {{ $currentPage = $loop->iteration; }}
            @forelse($pengikut as $np)
            @if($currentPage == 1)
            <tr>
                <td width="4%"></td>
                <td width="35%">{{ $loop->iteration }}. {{ $np->pegawai->nama }}</td>
                <td width="4%">:</td>
                <td width="20%"> </td>
                <td width="37%">{{ $np->pegawai->jabatan }}</td>
            </tr>
            @else
            <tr>
                <td width="4%"></td>
                <td width="35%">{{ $loop->iteration }}.</td>
                <td width="4%">:</td>
                <td width="20%"></td>
                <td width="37%"></td>
            </tr>
            @endif
            @empty
            <tr>
                <td width="4%"></td>
                <td width="35%">1. </td>
                <td width="4%">:</td>
                <td width="20%"> </td>
                <td width="37%"></td>
            </tr>
            <tr>
                <td width="4%"></td>
                <td width="35%">2. </td>
                <td width="4%">:</td>
                <td width="20%"> </td>
                <td width="37%"></td>
            </tr>
            @endforelse
            <tr>
                <td width="4%">9</td>
                <td width="35%">Pembebanan Anggaran</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> APBD Kab. Pacitan</td>
            </tr>
            <tr>
                <td width="4%"></td>
                <td width="35%">a. Instansi</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> Kecamatan Sudimoro</td>
            </tr>
            <tr>
                <td width="4%"></td>
                <td width="35%">b. Kode rekening</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> 5.1.02.04.01.0003</td>
            </tr>
            <tr>
                <td width="4%">10</td>
                <td width="35%">Keterangan Lain-Lain</td>
                <td width="4%">:</td>
                <td width="57%" colspan="2"> {{ $sppd->keterangan }}</td>
            </tr>
        </table>
        <br>
        
        <table>
            <tr>
                <td width="310"></td>
                <td width="220">Ditetapkan di Pacitan</td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220">Pada Tanggal : {{ $tgl_berangkat }}</td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220" ><b>Camat Sudimoro</b></td>
            </tr>
            <tr>
                <td width="310" height="35"></td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220"><b><u>{{ $camat->nama }}</u></b></td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220">{{ $camat->pangkat }}</td>
            </tr>
            <tr>
                <td width="310"></td>
                <td width="220">NIP. {{ $camat->nip }}</td>
            </tr>
        </table>
    @endforeach
    <div class="page_break"></div>
    @foreach($data->take(1) as $kuitansi)
    <center><b id="spt">RINCIAN BIAYA PERJALANAN DINAS DALAM DAERAH</b></center>
    <br> <br>
    <center><b id="kop">KUITANSI</b></center>
    <table width="100%">
        <tr>
            <td style="vertical-align: middle;" height="20" width="20%">Nomor</td>
            <td style="border-bottom: 1px solid black; vertical-align: middle;">: </td>
        </tr>
        <tr>
            <td style="vertical-align: middle;" height="20" width="20%">Sudah terima dari</td>
            <td style="border-bottom: 1px solid black; vertical-align: middle;">: Bendahara Pengeluaran Kecamatan Sudimoro</td>
        </tr>
        <tr>
            <td style="vertical-align: middle;" height="20" width="20%">Terbilang</td>
            <td style="border-bottom: 1px solid black; vertical-align: middle;">: {{ Terbilang::make($jumlah, ' rupiah') }}</td>
        </tr>
        <tr>
            <td style="vertical-align: middle;" height="20" width="20%">Guna Membayar</td>
            <td style="border-bottom: 1px solid black; vertical-align: middle;">:  
                @if($sppd->jenis_sppd->id == 1)
                    Uang Transport
                @else
                    Uang Harian
                @endif {{ $kuitansi->perihal }} di {{ $kuitansi->tujuan }} pada Tgl {{ $tgl_berangkat }}</td>
        </tr>
        <tr>
            <td style="vertical-align: middle;" height="20" width="20%">Jumlah Uang</td>
            <td style="border-bottom: 1px solid black; vertical-align: middle;">:<b> Rp. {{ number_format($jumlah, 2) }} </b></td>
        </tr>
    </table>
    @endforeach
    <br>
    <table border="1" width="100%">
        <tr>
            <td align="center" width="4%"><b>NO</td>
            <td align="center" width="30%"><b>PERHITUNGAN BIAYA</td>
            <td align="center" width="25%"><b>JUMLAH</td>
            <td align="center" width="41%"><b>NAMA DAN TANDA TANGAN PENERIMA</td>
        </tr>
        <tr>
            <td align="center"><i>1</i></td>
            <td align="center"><i>2</i></td>
            <td align="center"><i>3</i></td>
            <td align="center"><i>4</i></td>
        </tr>
    @foreach($data as $sppd)
        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">
                @if($sppd->jenis_sppd->id == 1)
                    Uang Transport
                @else
                    Uang Harian
                @endif
                <br>1 x Rp. {{ number_format($sppd->jenis_sppd->biaya, 2) }}
            </td>
            <td align="right">Rp. {{ number_format($sppd->jenis_sppd->biaya, 2) }}</td>
            <td align="center"><br><br><br>{{ $sppd->pegawai->nama }}</td>
        </tr>
    @endforeach
        <tr>
            <td align="center" colspan="2"><b>JUMLAH SELURUHNYA</b></td>
            <td align="right"><b> Rp. {{ number_format($jumlah, 2) }} </b></td>
            <td></td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td width="40%">
                <br>Mengetahui/menyetujui 
                <br>Kuasa Pengguna Anggaran
                <br><br><br><br><b><u>{{ $camat->nama }}</u></b>
                <br>{{ $camat->nip }}
            </td>
            <td width="20%">   </td>
            <td width="40%">
                Lunas Dibayar
                <br>Pada Tanggal : {{ $tgl_berangkat }}
                <br>Bendahara Pengeluaran Kec. Sudimoro
                <br><br><br><br><b><u>{{ $bendahara->nama }}</u></b>
                <br>{{ $bendahara->nip }}
            </td>
        </tr>
    </table>
    <div class="page_break"></div>
    <center><b id="kop">LAPORAN PERJALANAN DINAS</b></center>
    <P></P>
    <table width="100%">
        @foreach($data->take(1) as $lap)
        <tr>
            <td height="20" width="4%">I.</td>
            <td width="28%">DASAR</td>
            <td width="68%">: {{ $lap->no_surat }}</td>
        </tr>
        <tr>
            <td height="20" width="4%">II.</td>
            <td width="28%">MAKSUD DAN TUJUAN</td>
            <td width="68%">: {{ $lap->perihal }}</td>
        </tr>
        <tr>
            <td height="40" width="4%">III.</td>
            <td width="28%">WAKTU PELAKSANAAN</td>
            <td width="68%">: {{ $waktu }} Jam ............... WIB s/d ............... WIB</td>
        </tr>
        @foreach ($data as $petugas)
        <tr>
            <td height="20" width="4%">@if($loop->first)IV.@endif</td>
            <td width="28%">@if($loop->first)NAMA PETUGAS @endif</td>
            <td width="68%">: {{ $loop->iteration }}. {{ $petugas->pegawai->nama }}</td>
        </tr>
        @endforeach
        <tr>
            <td width="4%">V.</td>
            <td width="28%">DAERAH TUJUAN/INSTANSI YANG DIKUNJUNGI</td>
            <td width="68%">: {{ $lap->tujuan }}</td>
        </tr>
        @endforeach
        <tr>
            <td width="4%">VI.</td>
            <td width="28%">HADIR DALAM PERTEMUAN</td>
            <td width="68%">: </td>
        </tr>
        <tr>
            <td width="4%">VII.</td>
            <td width="28%">PETUNJUK / ARAHAN YANG DIBERIKAN</td>
            <td width="68%" height="70" style="text-align: justify;">: ................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
        </td>
        </tr>
        <tr>
            <td width="4%">VIII.</td>
            <td width="28%">MASALAH / TEMUAN</td>
            <td width="68%" height="70" style="text-align: justify;">: ................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
        </tr>
        <tr>
            <td width="4%">IX.</td>
            <td width="28%">SARAN TINDAKAN</td>
            <td width="68%" height="70" style="text-align: justify;">: ................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
        </tr>
        <tr>
            <td width="4%">X.</td>
            <td width="28%">LAIN - LAIN</td>
            <td width="68%" height="70" style="text-align: justify;">: ................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
            <br>..................................................................................................................................
        </tr>
    </table>
    <br><br>
    <table width="100%">
        <tr>
            <td width="70%"></td>
            
            <td width="30%">
                Sudimoro, {{ $tgl_berangkat }}
                <br>Yang melaksanakan Perjalanan Dinas
                <br><br><br><br><br>
                @foreach ($data as $key => $petugas)
                    @if ($key == 1)
                        <b><u> {{ $petugas->pegawai->nama }} </u></b>
                        <br> {{ $petugas->pegawai->nip }}
                    @endif
                @endforeach
                @if (!isset($data[1]))
                    <b><u> {{ $data[0]->pegawai->nama }} </u></b>
                    <br> {{ $data[0]->pegawai->nip }}
                @endif
                
            </td>
            
        </tr>
    </table>
    <div class="page_break"></div>
    @foreach($data->take(1) as $nosurat)                
    <table>
        <tr>
            <td width="300"></td>
            <td width="80">SPPD Nomor</td>
            <td>: {{ $nosurat->no_surat }}</td>
        </tr><tr>
            <td width="300"></td>
            <td width="80">Lembar Ke</td>
            <td>: 2</td>
        </tr>
    </table>
    <br>
    <table width="100%" border="1">
        <tr>
            <td style="border-right: none;" width="2%"></td>
            <td style="border-left: none;" width="48%"></td>
            <td width="48%">
                Berangkat dari &nbsp; : Kecamatan Sudimoro
                <br>Pada tanggal&nbsp; &nbsp; &nbsp; : {{ $tgl_berangkat }}
                <br>Ke &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $sppd->tujuan }}
                <br> <br>
                <center><b>CAMAT SUDIMORO</b></center>
                <br> <br> <br>
                <center><b><u>{{ $camat->nama }}</u></b></center>
                <center>NIP. {{ $camat->nip }}</center>
            </td>
        </tr>
        <tr>
            <td style="border-right: none;" width="2%">II</td>
            <td style="border-left: none;" height:="80px" width="48%">
                Tiba di &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $sppd->tujuan }}
                <br>Pada Tanggal&nbsp; : {{ $tgl_berangkat }}
                <br>Kepala&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                <br> <br> <br> <br> <br> <br>
            </td>
            <td width="48%">
                Berangkat dari &nbsp; : {{ $sppd->tujuan }}
                <br>Ke &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : Kecamatan Sudimoro
                <br>Pada tanggal&nbsp; &nbsp; &nbsp; : {{ $tgl_kembali }}
            </td>
        </tr>
        <tr>
            <td style="border-right: none;" width="2%">III</td>
            <td style="border-left: none;" height:="80px" width="48%">
                Tiba di &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                <br>Pada Tanggal&nbsp; :
                <br>Kepala&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                <br> <br> <br> <br> <br> <br>
            </td>
            <td width="48%">
                Berangkat dari &nbsp; :
                <br>Ke &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : 
                <br>Pada tanggal&nbsp; &nbsp; &nbsp; : 
            </td>
        </tr>
        <tr>
            <td style="border-right: none;" width="2%">VI</td>
            <td style="border-left: none;" height:="80px" width="48%">
                Tiba di &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                <br>Pada Tanggal&nbsp; :
                <br>Kepala&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                <br> <br> <br> <br> <br> <br>
            </td>
            <td width="48%">
                Berangkat dari &nbsp; :
                <br>Ke &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : 
                <br>Pada tanggal&nbsp; &nbsp; &nbsp; : 
            </td>
        </tr>
        <tr>
            <td style="border-right: none;" width="2%">V</td>
            <td style="border-left: none;" width="48%">
                Tiba di &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Kecamatan Sudimoro
                <br>Pada tanggal&nbsp; &nbsp; &nbsp; : {{ $tgl_berangkat }}
                <br> <br> <br> <br>
                <center><b>CAMAT SUDIMORO</b></center>
                <br> <br> <br>
                <center><b><u>{{ $camat->nama }}</u></b></center>
                <center>NIP. {{ $camat->nip }}</center>
            </td>
            <td width="48%" style="text-align: justify;">
                Telah diperiksa dengan keterangan bahwa perjalanan tersebut diatas dilakukan atas perintahnya
                dan semata mata untuk kepentingan jabatan dalam waktu sesingkat singkatnya
                <br> <br>
                <center><b>PENGGUNA ANGGARAN</b></center>
                <br> <br> <br>
                <center><b><u>{{ $camat->nama }}</u></b></center>
                <center>NIP. {{ $camat->nip }}</center>
            </td>
        </tr>
        <tr>
            <td style="border-right: none;" width="2%">VI</td>
            <td colspan="2">CATATAN LAIN - LAIN</td>
        </tr>
        <tr>
            <td style="border-right: none;" width="2%">VII</td>
            <td colspan="2">PERHATIAN</td>
        </tr>
        <tr>
            <td style="text-align: justify;" colspan="3">
            <br>
            Pejabat yang berwenang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan 
            tanggal berangkat / tiba serta Bendaharawan bertanggungjawab berdasarkan peraturan-peraturan Keuangan Negara 
            apabila Negara mendapat rugi akibat kesalahan, kelalaian dan kealpaannya 
            <br>
            </td>
        </tr> 
    </table>
    @endforeach
    </body>
</html>