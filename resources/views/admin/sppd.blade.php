@extends('layouts.app')

@section('title', 'SPPD')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>SPPD</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="{{ route('sppd.create') }}" class="btn btn-md btn-success mb-3">TAMBAH SPPD</a>
                                <table class="table" id="table-1" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="4%" class="text-center">No</th>
                                            <th width="15%">No SPT</th>
                                            <th width="10%">Tanggal Berangkat</th>
                                            <th width="15%">Nama</th>
                                            <th>Perihal</th>
                                            <th width="15%">Tujuan</th>
                                            <th width="12%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-sppd">
                                    @php
                                        use Carbon\Carbon;
                                        $no = 1;
                                    @endphp
                                    @foreach($sppds as $sppd)
                                        <tr id="index_{{ $sppd->id }}" class="{{ $sppd->jenis == 'inti' ? 'table-active' : 'table-light' }}" >
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $sppd->no_surat }}</td>
                                            <td>{{ Carbon::parse($sppd->tgl_berangkat)->format('d-m-Y') }}</td>
                                            <td>{{ $sppd->pegawai->nama }}</td>
                                            <td>{{ $sppd->perihal }}</td>
                                            <td>{{ $sppd->tujuan }}</td>
                                            <td class="text-center">
                                                @if($sppd->jenis == 'inti')
                                                <a href="{{ route('sppd.edit', ['sppd' => $sppd->id]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                                <a href="{{ route('pdf.sppd', ['id' => $sppd->id]) }}" id="btn-print-sppd" class="btn btn-info btn-sm" target="_blank"><i class="fa-solid fa-print"></i></i></a>
                                                <a href="javascript:void(0)" id="btn-delete-sppd" data-no_surat="{{ $sppd->no_surat }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                                @else
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<!-- Modal -->
    <div class="modal fade" id="sppd-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAMBAH SPPD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">No Surat</label>
                        <input type="text" class="form-control" id="no_surat" name="no_surat" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_surat"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Asal Surat</label>
                        <input type="text" class="form-control" id="pengirim" name="pengirim" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pengirim"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3" >
                        <label for="name" class="control-label">Tanggal Surat</label>
                        <input name="tgl_surat" id="tgl_surat" type="date" class="form-control" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_surat"></div>
                    </div>
                    <div class="form-group col-md-3" >
                        <label for="name" class="control-label">Tanggal Diterima</label>
                        <input name="tgl_diterima" id="tgl_diterima" type="date" class="form-control" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_diterima"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-perihal"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Ditujukan</label>
                        <input type="text" class="form-control" id="ditujukan" name="ditujukan" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-ditujukan"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori">
                    </div>
                  <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Gambar</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    new DataTable('#tabel1');

    $(document).ready(function(){
        $('.btn-create-sppd').click(function(){
           $('#sppd-create').modal('show');
        });
    });

    $('#sppd-create').on('hidden.bs.modal', function (e) {
      $('body').removeClass('modal-open');
      $('.modal-backdrop').remove();
    });

    //action create post
    $('#store').click(function(e) {
        $.ajaxSetup({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        e.preventDefault();
        //define variable
        let no_surat        = $('#no_surat').val();
        let pengirim        = $('#pengirim').val();
        let perihal         = $('#perihal').val();
        let tgl_surat       = $('#tgl_surat').val();
        let tgl_diterima    = $('#tgl_diterima').val();
        let ditujukan       = $('#ditujukan').val();
        let kategori        = $('#kategori').val();
        let keterangan      = $('#keterangan').val();
        let image           = $('#image').val();
        let token           = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({
            url: '/sppd',
            type: "POST",
            cache: false,
            data: {
                "no_surat"      :no_surat,
                "pengirim"      :pengirim,
                "perihal"       :perihal,
                "tgl_surat"     :tgl_surat,
                "tgl_diterima"  :tgl_diterima,
                "ditujukan"     :ditujukan,
                "kategori"      :kategori,
                "keterangan"    :keterangan,
                "image"         :image,
                "_token"        :token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });
                
                //clear form
                $('#no_surat').val('');
                $('#pengirim').val('');
                $('#perihal').val('');
                $('#tgl_surat').val('');
                $('#tgl_diterima').val('');
                $('#ditujukan').val('');
                $('#kategori').val('');
                $('#keterangan').val('');
                $('#image').val('');

                //close modal
                $('#sppd-create').modal('hide');

                setTimeout(function(){
                    location.reload();
                }, 500);
                
            },
            error:function(error){
                
                if(error.responseJSON.no_surat[0]) {

                    //show alert
                    $('#alert-no_surat').removeClass('d-none');
                    $('#alert-no_surat').addClass('d-block');

                    //add message to alert
                    $('#alert-no_surat').html(error.responseJSON.no_surat[0]);
                } 

                if(error.responseJSON.pengirim[0]) {

                    //show alert
                    $('#alert-pengirim').removeClass('d-none');
                    $('#alert-pengirim').addClass('d-block');

                    //add message to alert
                    $('#alert-pengirim').html(error.responseJSON.pengirim[0]);
                }
                if(error.responseJSON.perihal[0]) {

                    //show alert
                    $('#alert-perihal').removeClass('d-none');
                    $('#alert-perihal').addClass('d-block');

                    //add message to alert
                    $('#alert-perihal').html(error.responseJSON.perihal[0]);
                } 

                if(error.responseJSON.tgl_surat[0]) {

                    //show alert
                    $('#alert-tgl_surat').removeClass('d-none');
                    $('#alert-tgl_surat').addClass('d-block');

                    //add message to alert
                    $('#alert-tgl_surat').html(error.responseJSON.tgl_surat[0]);
                }

                if(error.responseJSON.tgl_diterima[0]) {

                    //show alert
                    $('#alert-tgl_diterima').removeClass('d-none');
                    $('#alert-tgl_diterima').addClass('d-block');

                    //add message to alert
                    $('#alert-tgl_diterima').html(error.responseJSON.tgl_diterima[0]);
                }
                
                if(error.responseJSON.ditujukan[0]) {

                    //show alert
                    $('#alert-ditujukan').removeClass('d-none');
                    $('#alert-ditujukan').addClass('d-block');

                    //add message to alert
                    $('#alert-ditujukan').html(error.responseJSON.ditujukan[0]);
                } 
            }

        });

    });
    </script>


    <script>
        //button create post event
        $(document).on('click', '#btn-edit-sppd', function() {
            let id_ssppd = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `/sppd/${id_ssppd}`,
                type: "GET",
                cache: false,
                success:function(response){

                    //fill data to form
                    $('#id_ssppd').val(response.data.id);
                    $('#no_surat-edit').val(response.data.no_surat);
                    $('#pengirim-edit').val(response.data.pengirim);
                    $('#perihal-edit').val(response.data.perihal);
                    $('#tgl_surat-edit').val(response.data.tgl_surat);
                    $('#tgl_diterima-edit').val(response.data.tgl_diterima);
                    $('#ditujukan-edit').val(response.data.ditujukan);
                    $('#keterangan-edit').val(response.data.keterangan);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            //define variable
            let id_ssppd   = $('#id_ssppd').val();
            let no_surat    = $('#no_surat-edit').val();
            let pengirim    = $('#pengirim-edit').val();
            let perihal     = $('#perihal-edit').val();
            let tgl_surat   = $('#tgl_surat-edit').val();
            let tgl_diterima= $('#tgl_diterima-edit').val();
            let ditujukan   = $('#ditujukan-edit').val();
            let keterangan  = $('#keterangan-edit').val();
            let token       = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/sppd/${id_ssppd}`,
                type: "PUT",
                cache: false,
                data: {
                    "no_surat"      :no_surat,
                    "pengirim"      :pengirim,
                    "perihal"       :perihal,
                    "tgl_surat"     :tgl_surat,
                    "tgl_diterima"  :tgl_diterima,
                    "ditujukan"     :ditujukan,
                    "keterangan"    :keterangan,
                    "_token"        :token
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

                    //close modal
                    $('#modal-edit').modal('hide');

                 setTimeout(function(){
                    location.reload();
                 }, 500);

                },
                error:function(error){

                    if(error.responseJSON.title[0]) {

                        //show alert
                        $('#alert-title-edit').removeClass('d-none');
                        $('#alert-title-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-title-edit').html(error.responseJSON.title[0]);
                    } 

                    if(error.responseJSON.content[0]) {

                        //show alert
                        $('#alert-content-edit').removeClass('d-none');
                        $('#alert-content-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-content-edit').html(error.responseJSON.content[0]);
                    } 
                }
            });
        });

    //button create post event
    $(document).on('click', '#btn-delete-sppd', function() {
        let no_surat = $(this).data('no_surat');
        let token   = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Ingin menghapus semua data dengan No Surat ini?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {
                //fetch to delete all data with same no_surat
                $.ajax({
                    url: `/sppd/delete-by-no-surat`,
                    type: "DELETE",
                    cache: false,
                    data: {
                        "_token": token,
                        "no_surat": no_surat
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
                        //remove all rows with this no_surat
                        $(`tr`).filter(function(){
                            return $(this).find('td:nth-child(2)').text().trim() === no_surat;
                        }).remove();
                    }
                });
            }
        })
    });
    </script>

    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
