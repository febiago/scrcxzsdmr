@extends('layouts.app')

@section('title', 'Pegawai')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pegawai</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <button class="btn btn-success mb-2" id="btn-create-pegawai" data-toggle="modal" data-target="#pegawai-create">TAMBAH PEGAWAI</button>
                                <table class="table-striped table"
                                    id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama</th>
                                            <th>NIP</th>
                                            <th>Pangkat</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-pegawai">
                                    @php
                                        use Carbon\Carbon;
                                    @endphp
                                    @foreach($pegawais as $pegawai)
                                        <tr id="index_{{ $pegawai->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pegawai->nama }}</td>
                                            <td>{{ $pegawai->nip }}</td>
                                            <td>{{ $pegawai->pangkat }}</td>
                                            <td>{{ $pegawai->jabatan }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" id="btn-edit-pegawai" data-id="{{ $pegawai->id }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                                <a href="javascript:void(0)" id="btn-delete-pegawai" data-id="{{ $pegawai->id }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
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
    <div class="modal fade" id="pegawai-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAMBAH PEGAWAI</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">NAMA</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6" >
                        <label for="pangkat" class="control-label">PANGKAT</label>
                        <select class="form-control" id="pangkat" name="pangkat">
                          <option value="-"> - </option>
                          <option value="Pemula (V)">Pemula (V)</option>
                          <option value="Juru Muda (I/a)">Juru Muda (I/a)</option>
                          <option value="Juru Muda Tingkat I (I/b)">Juru Muda Tingkat I (I/b)</option>
                          <option value="Juru (I/c)">Juru (I/c)</option>
                          <option value="Juru Tingkat I (I/d)">Juru Tingkat I (I/d)</option>
                          <option value="Pengatur Muda (II/a)">Pengatur Muda (II/a)</option>
                          <option value="Pengatur Muda Tingkat I (II/b)">Pengatur Muda Tingkat I (II/b)</option>
                          <option value="Pengatur (II/c)">Pengatur (II/c)</option>
                          <option value="Pengatur Tingkat I (II/d)">Pengatur Tingkat I (II/d)</option>
                          <option value="Penata Muda (III/a)">Penata Muda (III/a)</option>
                          <option value="Penata Muda Tingkat I (III/b)">Penata Muda Tingkat I (III/b)</option>
                          <option value="Penata (III/c)">Penata (III/c)</option>
                          <option value="Penata Tingkat I (III/d)">Penata Tingkat I (III/d)</option>
                          <option value="Pembina (IV/a)">Pembina (IV/a)</option>
                          <option value="Pembina Tingkat I (IV/b)">Pembina Tingkat I (IV/b)</option>
                          <option value="Pembina Utama Muda (IV/c)">Pembina Utama Muda (IV/c)</option>
                          <option value="Pembina Utama (IV/d)">Pembina Utama (IV/d)</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pangkat"></div>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="name" class="control-label">JABATAN</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan"></div>
                    </div>
                </div>
                        <input type="text" class="form-control" id="kendaraan" name="kendaraan" value="Kendaraan Pribadi" required hidden>
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
        $('.btn-create-pegawai').click(function(){
           $('#pegawai-create').modal('show');
        });
    });

    $('#pegawai-create').on('hidden.bs.modal', function (e) {
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
        let nama       = $('#nama').val();
        let nip        = $('#nip').val();
        let pangkat    = $('#pangkat').val();
        let jabatan    = $('#jabatan').val();
        let kendaraan  = $('#kendaraan').val();
        let token      = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({
            url: '/pegawai',
            type: "POST",
            cache: false,
            data: {
                "nama"      :nama,
                "nip"       :nip,
                "pangkat"   :pangkat,
                "jabatan"   :jabatan,
                "kendaraan" :kendaraan,
                "_token"    :token
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
                $('#nama').val('');
                $('#nip').val('');
                $('#pangkat').val('');
                $('#jabatan').val('');
                $('#kendaraan').val('');

                //close modal
                $('#pegawai-create').modal('hide');

                setTimeout(function(){
		        	location.reload();
		        }, 500);
                
            },
            error:function(error){
                
                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama').removeClass('d-none');
                    $('#alert-nama').addClass('d-block');

                    //add message to alert
                    $('#alert-nama').html(error.responseJSON.nama[0]);
                } 

                if(error.responseJSON.nip[0]) {

                    //show alert
                    $('#alert-nip').removeClass('d-none');
                    $('#alert-nip').addClass('d-block');

                    //add message to alert
                    $('#alert-nip').html(error.responseJSON.nip[0]);
                }
                if(error.responseJSON.pangkat[0]) {

                    //show alert
                    $('#alert-pangkat').removeClass('d-none');
                    $('#alert-pangkat').addClass('d-block');

                    //add message to alert
                    $('#alert-pangkat').html(error.responseJSON.pangkat[0]);
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
                    <h5 class="modal-title" id="exampleModalLabel">EDIT PEGAWAI</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id_pegawai" value="{{ $pegawai->id_pegawai }}">

                    <div class="form-row">
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">NIP</label>
                            <input type="text" class="form-control" id="nip-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip-edit"></div>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Nama</label>
                            <input type="text" class="form-control" id="nama-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Pangkat</label>
                            <select class="form-control" id="pangkat-edit" required>
                                <option value="-" {{ old('pangkat', $pegawai->pangkat) == '-' ? 'selected' : '' }}> - </option>
                                <option value="Pemula (V)" {{ old('pangkat', $pegawai->pangkat) == 'Pemula (V)' ? 'selected' : '' }}>Pemula (V)</option>
                                <option value="Juru Muda (I/a)" {{ old('pangkat', $pegawai->pangkat) == 'Juru Muda (I/a)' ? 'selected' : '' }}>Juru Muda (I/a)</option>
                                <option value="Juru Muda Tingkat I (I/b)" {{ old('pangkat', $pegawai->pangkat) == 'Juru Muda Tingkat I (I/b)' ? 'selected' : '' }}>Juru Muda Tingkat I (I/b)</option>
                                <option value="Juru (I/c)" {{ old('pangkat', $pegawai->pangkat) == 'Juru (I/c)' ? 'selected' : '' }}>Juru (I/c)</option>
                                <option value="Juru Tingkat I (I/d)" {{ old('pangkat', $pegawai->pangkat) == 'Juru Tingkat I (I/d)' ? 'selected' : '' }}>Juru Tingkat I (I/d)</option>
                                <option value="Pengatur Muda (II/a)" {{ old('pangkat', $pegawai->pangkat) == 'Pengatur Muda (II/a)' ? 'selected' : '' }}>Pengatur Muda (II/a)</option>
                                <option value="Pengatur Muda Tingkat I (II/b)" {{ old('pangkat', $pegawai->pangkat) == 'Pengatur Muda Tingkat I (II/b)' ? 'selected' : '' }}>Pengatur Muda Tingkat I (II/b)</option>
                                <option value="Pengatur (II/c)" {{ old('pangkat', $pegawai->pangkat) == 'Pengatur (II/c)' ? 'selected' : '' }}>Pengatur (II/c)</option>
                                <option value="Pengatur Tingkat I (II/d)" {{ old('pangkat', $pegawai->pangkat) == 'Pengatur Tingkat I (II/d)' ? 'selected' : '' }}>Pengatur Tingkat I (II/d)</option>
                                <option value="Penata Muda (III/a)" {{ old('pangkat', $pegawai->pangkat) == 'Penata Muda (III/a)' ? 'selected' : '' }}>Penata Muda (III/a)</option>
                                <option value="Penata Muda Tingkat I (III/b)" {{ old('pangkat', $pegawai->pangkat) == 'Penata Muda Tingkat I (III/b)' ? 'selected' : '' }}>Penata Muda Tingkat I (III/b)</option>
                                <option value="Penata (III/c)" {{ old('pangkat', $pegawai->pangkat) == 'Penata (III/c)' ? 'selected' : '' }}>Penata (III/c)</option>
                                <option value="Penata Tingkat I (III/d)" {{ old('pangkat', $pegawai->pangkat) == 'Penata Tingkat I (III/d)' ? 'selected' : '' }}>Penata Tingkat I (III/d)</option>
                                <option value="Pembina (IV/a)" {{ old('pangkat', $pegawai->pangkat) == 'Pembina (IV/a)' ? 'selected' : '' }}>Pembina (IV/a)</option>
                                <option value="Pembina Tingkat I (IV/b)" {{ old('pangkat', $pegawai->pangkat) == 'Pembina Tingkat I (IV/b)' ? 'selected' : '' }}>Pembina Tingkat I (IV/b)</option>
                                <option value="Pembina Utama Muda (IV/c)" {{ old('pangkat', $pegawai->pangkat) == 'Pembina Utama Muda (IV/c)' ? 'selected' : '' }}>Pembina Utama Muda (IV/c)</option>
                                <option value="Pembina Utama (IV/d)" {{ old('pangkat', $pegawai->pangkat) == 'Pembina Utama (IV/d)' ? 'selected' : '' }}>Pembina Utama (IV/d)</option>
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pangkat-edit"></div>
                        </div>

                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Perihal</label>
                            <input type="text" class="form-control" id="jabatan-edit" required>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan-edit"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6" >
                            <label for="name" class="control-label">Kendaraan</label>
                            <input type="text" class="form-control" id="kendaraan-edit">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kendaraan-edit"></div>
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
        $(document).on('click', '#btn-edit-pegawai', function() {
            let id_pegawai = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `/pegawai/${id_pegawai}`,
                type: "GET",
                cache: false,
                success:function(response){

                    //fill data to form
                    $('#id_pegawai').val(response.data.id);
                    $('#nip-edit').val(response.data.nip);
                    $('#nama-edit').val(response.data.nama);
                    $('#pangkat-edit').val(response.data.pangkat);
                    $('#jabatan-edit').val(response.data.jabatan);
                    $('#kendaraan-edit').val(response.data.kendaraan);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });

        //action update post
        $('#update').click(function(e) {
            e.preventDefault();

            //define variable
            let id_pegawai   = $('#id_pegawai').val();
            let nip           = $('#nip-edit').val();
            let nama          = $('#nama-edit').val();
            let pangkat       = $('#pangkat-edit').val();
            let jabatan       = $('#jabatan-edit').val();
            let kendaraan     = $('#kendaraan-edit').val();
            let token         = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/pegawai/${id_pegawai}`,
                type: "PUT",
                cache: false,
                data: {
                    "nip"           :nip,
                    "nama"          :nama,
                    "pangkat"       :pangkat,
                    "jabatan"       :jabatan,
                    "kendaraan"     :kendaraan,
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
                        $('#alert-nip-edit').removeClass('d-none');
                        $('#alert-nip-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-nip-edit').html(error.responseJSON.nip[0]);
                    } 

                    if(error.responseJSON.content[0]) {

                        //show alert
                        $('#alert-nama-edit').removeClass('d-none');
                        $('#alert-nama-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-nama-edit').html(error.responseJSON.nama[0]);
                    } 
                }
            });
        });

    //button create post event
    $(document).on('click', '#btn-delete-pegawai', function() {

        let id_pegawai = $(this).data('id');
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
                //fetch to delete data
                $.ajax({

                    url: `/pegawai/${id_pegawai}`,
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
                        $(`#index_${id_pegawai}`).remove();
                    },
                    error: function(xhr, status, error) {
                        //show error message
                        Swal.fire({
                            type: 'error',
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Gagal menghapus data!',
                            showConfirmButton: false,
                            timer: 2000
                        });
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
