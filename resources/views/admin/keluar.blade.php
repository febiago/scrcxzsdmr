@extends('layouts.app')

@section('title', 'Surat Keluar')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Arsip Surat Keluar</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <button class="btn btn-success mb-2" id="btn-create-keluar" data-toggle="modal" data-target="#keluar-create">TAMBAH SURAT KELUAR</button>
                                <table class="table-striped table" id="table-1" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="4%" class="text-center">No</th>
                                            <th width="16%">No Surat</th>
                                            <th width="10%">Tanggal</th>
                                            <th>Perihal</th>
                                            <th width="12%">Tujuan Surat</th>
                                            <th width="10%">Tanggal Penerimaan</th>
                                            <th width="8%">Keterangan</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-keluar">
                                    @php
                                        use Carbon\Carbon;
                                        $no = 1;
                                    @endphp
                                    @foreach($skeluar as $keluar)
                                        <tr id="index_{{ $keluar->id }}">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $keluar->no_surat }}</td>
                                            <td>{{ Carbon::parse($keluar->tgl_surat)->format('d-m-Y') }}</td>
                                            <td>{{ $keluar->perihal }}</td>
                                            <td>{{ $keluar->ditujukan }}</td>
                                            <td>{{ Carbon::parse($keluar->tgl_dikirim)->format('d-m-Y') }}</td>
                                            <td>{{ $keluar->keterangan }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" id="btn-edit-keluar" data-id="{{ $keluar->id }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                                <a href="javascript:void(0)" id="btn-delete-keluar" data-id="{{ $keluar->id }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
    <div class="modal fade" id="keluar-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAMBAH SURAT KELUAR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">No Surat</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control text-right" id="no_surat1" name="no_surat" required>
                            <input type="text" class="form-control text-right" id="no_surat2" value="{{ $nomorSurat }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">/408.63/2025</div>
                        </div>
                        </div>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_surat1"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Ditujukan</label>
                        <input type="text" class="form-control" id="ditujukan" name="ditujukan" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-ditujukan"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3" >
                        <label for="name" class="control-label">Tanggal Surat</label>
                        <input name="tgl_surat" id="tgl_surat" type="date" class="form-control" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_surat"></div>
                    </div>
                    <div class="form-group col-md-3" >
                        <label for="name" class="control-label">Tanggal Dikirim</label>
                        <input name="tgl_dikirim" id="tgl_dikirim" type="date" class="form-control" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_dikirim"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-perihal"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan">
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
    $(document).ready(function(){
        $('.btn-create-keluar').click(function(){
           $('#keluar-create').modal('show');
        });
    });

    $('#keluar-create').on('hidden.bs.modal', function (e) {
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
        let no_surat1       = $('#no_surat1').val();
        let no_surat2       = $('#no_surat2').val();
        let perihal         = $('#perihal').val();
        let tgl_surat       = $('#tgl_surat').val();
        let tgl_dikirim     = $('#tgl_dikirim').val();
        let ditujukan       = $('#ditujukan').val();
        let kategori        = $('#kategori').val();
        let keterangan      = $('#keterangan').val();
        let image           = $('#image').val();
        let token           = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({
            url: '/surat-keluar',
            type: "POST",
            cache: false,
            data: {
                "no_surat1"     :no_surat1,
                "no_surat2"     :no_surat2,
                "perihal"       :perihal,
                "tgl_surat"     :tgl_surat,
                "tgl_dikirim"   :tgl_dikirim,
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
                //data post
                
                
                //clear form
                $('#no_surat1').val('');
                $('#no_surat2').val('');
                $('#perihal').val('');
                $('#tgl_surat').val('');
                $('#tgl_dikirim').val('');
                $('#ditujukan').val('');
                $('#kategori').val('');
                $('#keterangan').val('');
                $('#image').val('');

                //close modal
                $('#keluar-create').modal('hide');

                setTimeout(function(){
		        	location.reload();
		        }, 500);
                
            },
            error:function(error){
                
                if(error.responseJSON.no_surat1[0]) {

                    //show alert
                    $('#alert-no_surat1').removeClass('d-none');
                    $('#alert-no_surat1').addClass('d-block');

                    //add message to alert
                    $('#alert-no_surat1').html(error.responseJSON.no_surat1[0]);
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

                if(error.responseJSON.tgl_dikirim[0]) {

                    //show alert
                    $('#alert-tgl_dikirim').removeClass('d-none');
                    $('#alert-tgl_dikirim').addClass('d-block');

                    //add message to alert
                    $('#alert-tgl_dikirim').html(error.responseJSON.tgl_dikirim[0]);
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

    <!-- Modal -->
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT SURAT KELUAR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id_skeluar">

                    <div class="form-row">
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">No Surat</label>
                            <input type="text" class="form-control" id="no_surat-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_surat-edit"></div>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori-edit"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3" >
                            <label for="name" class="control-label">Tanggal Surat</label>
                            <input id="tgl_surat-edit" type="date" class="form-control" required>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_surat-edit"></div>
                        </div>
                        <div class="form-group col-md-3" >
                            <label for="name" class="control-label">Tanggal Dikirim</label>
                            <input id="tgl_dikirim-edit" type="date" class="form-control" required>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_dikirim-edit"></div>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Perihal</label>
                            <input type="text" class="form-control" id="perihal-edit" required>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-perihal-edit"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Ditujukan</label>
                            <input type="text" class="form-control" id="ditujukan-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-ditujukan-edit"></div>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan-edit"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-primary" id="update">UPDATE</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        //button create post event
        $(document).on('click', '#btn-edit-keluar', function() {
            let id_skeluar = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `/surat-keluar/${id_skeluar}`,
                type: "GET",
                cache: false,
                success:function(response){

                    //fill data to form
                    $('#id_skeluar').val(response.data.id);
                    $('#no_surat-edit').val(response.data.no_surat);
                    $('#perihal-edit').val(response.data.perihal);
                    $('#tgl_surat-edit').val(response.data.tgl_surat);
                    $('#tgl_dikirim-edit').val(response.data.tgl_dikirim);
                    $('#ditujukan-edit').val(response.data.ditujukan);
                    $('#kategori-edit').val(response.data.kategori);
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
            let id_skeluar   = $('#id_skeluar').val();
            let no_surat    = $('#no_surat-edit').val();
            let perihal     = $('#perihal-edit').val();
            let tgl_surat   = $('#tgl_surat-edit').val();
            let tgl_dikirim= $('#tgl_dikirim-edit').val();
            let ditujukan   = $('#ditujukan-edit').val();
            let kategori    = $('#kategori-edit').val();
            let keterangan  = $('#keterangan-edit').val();
            let token       = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/surat-keluar/${id_skeluar}`,
                type: "PUT",
                cache: false,
                data: {
                    "no_surat"      :no_surat,
                    "perihal"       :perihal,
                    "tgl_surat"     :tgl_surat,
                    "tgl_dikirim"   :tgl_dikirim,
                    "ditujukan"     :ditujukan,
                    "kategori"      :kategori,
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
    $(document).on('click', '#btn-delete-keluar', function() {

        let id_skeluar = $(this).data('id');
        let token   = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
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

                    url: `/surat-keluar/${id_skeluar}`,
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
                        $(`#index_${id_skeluar}`).remove();
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
