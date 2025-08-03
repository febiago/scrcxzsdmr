@extends('layouts.app')

@section('title', 'EDIT SPPD')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Perjalanan Dinas</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <form action="{{ route('sppd.updated', $sppd->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="no_surat">No SPPD</label>
                                        <input type="text" class="form-control" id="no_surat" value="{{ $sppd->no_surat }}" name="no_surat" required>
                                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_surat"></div>
                                    
                                        @error('no_surat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="pegawai">Pegawai</label>
                                        <select name="pegawai"
                                            class="form-control select2 @error('pegawai') is-invalid @enderror">
                                            @foreach($pegawais as $key => $value)
                                                <option value="{{ $key }}" {{ $sppd->pegawai_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('pegawai')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="kendaraan" class="control-label">Kendaraan</label>
                                        <input type="text" name="kendaraan" id="kendaraan"
                                            class="form-control" value="{{ $sppd->kendaraan }}">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="jenis">Jenis SPPD</label>
                                        <select name="jenis"
                                            class="form-control select2 @error('jenis') is-invalid @enderror">
                                            @foreach($jenis as $key => $value)
                                                <option value="{{ $key }}" {{ $sppd->jenis_sppd_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="kegiatan">Sub Kegiatan</label>
                                        <select name="kegiatan" id="kegiatan"
                                            class="form-control select2 @error('kegiatan') is-invalid @enderror">
                                            @foreach($kegiatans as $key => $value)
                                                <option value="{{ $key }}" {{ $sppd->kegiatan_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('kegiatan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="tgl_berangkat" class="control-label">Tanggal Berangkat</label>
                                        <input name="tgl_berangkat" id="tgl_berangkat" type="date"
                                            value="{{ $sppd->tgl_berangkat }}" class="form-control" required>
                                        <div class="alert alert-danger mt-2 d-none" role="alert"
                                            id="alert-tgl_berangkat"></div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tgl_kembali" class="control-label">Tanggal Kembali</label>
                                        <input name="tgl_kembali" id="tgl_kembali" type="date"
                                            value="{{ $sppd->tgl_kembali }}" class="form-control" required>
                                        <div class="alert alert-danger mt-2 d-none" role="alert"
                                            id="alert-tgl_kembali"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="tujuan" class="control-label">Tujuan</label>
                                        <input type="text" class="form-control" id="tujuan"
                                            value="{{ $sppd->tujuan }}" name="tujuan" required>
                                        <div class="alert alert-danger mt-2 d-none" role="alert"
                                            id="alert-tujuan"></div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="dasar" class="control-label">Dasar SPPD</label>
                                        <input type="text" class="form-control" id="dasar"
                                            value="{{ $sppd->dasar }}" name="dasar">
                                        <div class="alert alert-danger mt-2 d-none" role="alert"
                                            id="alert-dasar"></div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="perihal" class="control-label">Perihal</label>
                                        <input type="text" class="form-control" id="perihal"
                                            value="{{ $sppd->perihal }}" name="perihal">
                                        <div class="alert alert-danger mt-2 d-none" role="alert"
                                            id="alert-perihal"></div>
                                    </div>
                                </div>
                                <h4>Pengikut</h4>
                                <button type="button" class="btn btn-success mb-2" id="tambah-pengikut">Tambah
                                    Pengikut</button>
                                <div id="error"></div>
                                <div id="pengikut-container" class="form-row">
                                    {{-- Populate existing pengikut here --}}
                                    @if (!empty($pegawaiPengikut))
                                        @foreach($pegawaiPengikut as $index => $pengikut)
                                            <div class="form-group col-md-3">
                                                <label for="name" class="control-label">Nama</label>
                                                <select name="pegawai_id[]"
                                                    class="form-control select2 @error('pegawai_id.*') is-invalid @enderror"
                                                    onchange="cekUnique(), getKendaraan(this)">
                                                    @foreach($pegawais as $key => $value)
                                                        <option value="{{ $key }}" {{ $pengikut->pegawai_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="angkutan" class="control-label">Kendaraan</label>
                                                <input type="text" name="angkutan[]" id="kendaraan-{{ $index }}"
                                                    class="form-control" value="{{ $pengikut->kendaraan }}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label for="angkutan" class="control-label">Hapus</label>
                                                <a href="javascript:void(0)" id="btn-delete-sppd" data-id="{{ $pengikut->id }}" class="btn btn-danger btn-sm form-control"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tambah-pengikut').on('click', function () {
            var index = $('select[name="pegawai_id[]"]').length;
            var html = '<div class="form-group col-md-4" >' +
                '<label for="name" class="control-label">Nama</label>' +
                '{!! Form::select("pegawai_id[]", $pegawais, null, ["class" => "form-control select2", "placeholder" => "", "name" => "pegawai_id[]", "onchange" => "cekUnique(), getKendaraan(this)"]) !!}' +
                '</div>' +
                '<div class="form-group col-md-2">' +
                '<label for="angkutan" class="control-label">Kendaraan</label>' +
                '<input type="text" name="angkutan[]" id="kendaraan-' + index + '" class="form-control">' +
                '</div>';

            $('#pengikut-container').append(html);
            $(".select2").select2();
        });

        // Hapus Pengikut
        $('#btn-remove-pengikut').on('click', function () {
            $(this).parents(".form-row").remove();
        });
        
    });

    $('#pegawai').change(function () {
        var pegawaiId = $(this).val();
        if (pegawaiId) {
            $.ajax({
                url: 'edit/kendaraan/',
                type: 'GET',
                data: {
                    'id': pegawaiId
                },
                success: function (data) {
                    $('#kendaraan').val(data);
                }
            });
        }
    });

    function getKendaraan(element) {
        var pegawaiId = $(element).val();
        var index = $('select[name="pegawai_id[]"]').index($(element));
        var kendaraanElement = $('#kendaraan-' + index);

        if (pegawaiId) {
            $.ajax({
                url: 'edit/kendaraan/',
                type: 'GET',
                data: {
                    'id': pegawaiId
                },
                success: function (data) {
                    kendaraanElement.val(data);
                }
            });
        } else {
            kendaraanElement.val('');
        }
    }

        function cekUnique() {
            let tgl_berangkat = $('#tgl_berangkat').val();
            let pegawaiUtama = $('select[name="pegawai"]').val();
            let pengikut = $('select[name="pegawai_id[]"]').map(function() {
              return $(this).val();
            }).get();
            let sppdId = '{{ $sppd->no_surat }}'; // pastikan variabel ini tersedia
        
            let semuaPegawai = [];
            if (pegawaiUtama) semuaPegawai.push(pegawaiUtama);
            semuaPegawai = semuaPegawai.concat(pengikut);
        
            $.ajax({
                type: 'POST',
                url: 'check-unique/',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'tgl_berangkat': tgl_berangkat,
                    'pegawai_id': semuaPegawai,
                    'sppd_id': sppdId // kirim id sppd yang sedang diedit
                },
            success: function(data) {
                if (data.errors) {
                    var errorHtml = '';
                    $.each(data.errors, function(index, value) {
                        errorHtml += '<div class="alert alert-danger"><strong>' + value + '</strong></div>';
                    });
                    $('#error').html(errorHtml);
                } else {
                    $('#error').html('');
                    console.log(data);
                }
            }
        });
    }

    $('#pegawai').change(cekUnique);
    $('#tgl_berangkat').change(cekUnique);
    $('select[name="pegawai_id[]"]').change(cekUnique);

        $(document).on('click', '#btn-delete-sppd', function() {

        let id_sppd = $(this).data('id');
        let token   = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {

                console.log('test');

                //fetch to delete data
                $.ajax({

                    url: `/sppd/edit/${id_sppd}`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    success:function(response){ 

                        //show success message
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        //remove post on table
                        window.location.reload();
                    }
                });
            }
        })
        
    });


</script>
<!-- JS Libraies -->
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush