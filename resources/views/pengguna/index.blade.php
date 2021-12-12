@extends('layouts.app')

@section('title')
    TAHUNGODING ABSENSI RFID - PENGGUNA
@endsection

@section('css')
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-kit.css?v=3.0.0" rel="stylesheet" />
@endsection

@section('content')
    <section class="my-5 py-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12 ">
                    <div class="px-5">
                        <button data-bs-toggle="modal" data-bs-target="#tambahList" class="btn btn-primary btn-lg"><span
                                class="fa fa-plus-circle"></span>
                            Tambah </button>
                    </div>
                    <table class="table table-borderless text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>RFID</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list">
                            @foreach ($list as $item)
                                <tr id="list_{{ $item->id }}">
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->rfid }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-id="{{ $item->id }}"
                                            onclick="listUpdate(this)" class="btn btn-outline-info btn-sm"><span
                                                class="fa fa-edit"></span></a>
                                        <a href="javascript:void(0)" onclick="listDelete({{ $item->id }})"
                                            class="btn btn-outline-danger btn-sm"><span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="tambahList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="tambahListLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahListLabel">Tambah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="tambah">
                        <div class="modal-body">
                            <div class="input-group input-group-static">
                                <label for="">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="name_tambah">
                            </div>
                            <div class="input-group input-group-static mt-5">
                                <label for="">RFID</label>
                                <input type="text" class="form-control" name="rfid" id="rfid_tambah">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="temp" style="visibility: hidden">tambah</div>
        <div class="modal fade" id="ubahList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="ubahListLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahListLabel">Ubah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="ubah">
                        <input type="hidden" name="id" id="id_ubah">
                        <div class="modal-body">
                            <div class="input-group input-group-static">
                                <label for="">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" id="name_ubah" required>
                            </div>
                            <div class="input-group input-group-static mt-5">
                                <label for="">RFID</label>
                                <input type="text" class="form-control" name="rfid" id="rfid_ubah" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>
    <script>
        var rfid_temp = setInterval(() => {
            $.ajax({
                url: "{{ route('pengguna.rfid-temp') }}",
                method: "GET",

                success: function(result) {
                    $('#rfid_' + document.getElementById('temp').textContent).val(result.data);
                }
            });
        }, 2000);

        //Aksi Tambah
        const tambah = document.getElementById('tambah');

        tambah.addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = tambah.name.value;
            const rfid = tambah.rfid.value;
            const _token = "{{ csrf_token() }}";

            let formData = new FormData();
            formData.append("name", name);
            formData.append("rfid", rfid);

            try {
                let response = await fetch("{{ route('pengguna.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": _token
                    }
                });
                var datasend = await response.json();

                if (datasend.status == 'success') {

                    var res_id = datasend.data.id;
                    var res_name = datasend.data.name;
                    var res_rfid = datasend.data.rfid;

                    var row =
                        '<tr id="list_' + res_id +
                        '"> <th>#</th> <td>' + res_name + '</td>';
                    row +=
                        '<td>' + res_rfid + '</td> <td> <a href="javascript:void(0)" data-id="' + res_id +
                        '"';
                    row +=
                        'onclick="listUpdate(this)" class="btn btn-outline-info btn-sm"><span class="fa fa-edit"></span></a>';
                    row +=
                        '&nbsp;<a href = "javascript:void(0)" onclick = "listDelete(' + res_id +
                        ')" class="btn btn-outline-danger btn-sm"> <span class="fa fa-trash"></span></a ></td> </tr>';

                    $('#name_tambah').val("");
                    $('#rfid_tambah').val("");
                    $('#list').append(row);
                    $('#tambahList').modal('hide');
                    Swal.fire('Pengguna berhasil ditambahkan', '', 'success')
                }

            } catch (err) {
                console.log(err);
            }

            return false;
        });

        //Aksi Ubah

        function listUpdate(obj) {

            var id = obj.getAttribute('data-id');

            fetch("{{ url('pengguna') }}/" + id).then(function(response) {
                response.json().then(function(text) {
                    var res = text;
                    var name = res.data.name;
                    var rfid = res.data.rfid;

                    $('#id_ubah').val(id);
                    $('#name_ubah').val(name);
                    $('#rfid_ubah').val(rfid);
                });
            });

            $('#temp').html('ubah');
            rfid_temp;
            $('#ubahList').modal('show');
        }

        const ubah = document.getElementById('ubah');

        ubah.addEventListener('submit', async (e) => {
            e.preventDefault();

            const id = ubah.id.value;
            const name = ubah.name.value;
            const rfid = ubah.rfid.value;
            const _token = "{{ csrf_token() }}";

            let formData = new FormData();
            formData.append("id", id);
            formData.append("name", name);
            formData.append("rfid", rfid);

            try {
                let response = await fetch("{{ route('pengguna.update-list') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": _token
                    }
                });
                var datasend = await response.json();

                if (datasend.status == 'success') {

                    var res_id = datasend.data.id;
                    var res_name = datasend.data.name;
                    var res_rfid = datasend.data.rfid;

                    var row =
                        '<tr id="list_' + res_id +
                        '"> <th>#</th> <td>' + res_name + '</td>';
                    row +=
                        '<td>' + res_rfid + '</td> <td> <a href="javascript:void(0)" data-id="' + res_id +
                        '"';
                    row +=
                        'onclick="listUpdate(this)" class="btn btn-outline-info btn-sm"><span class="fa fa-edit"></span></a>';
                    row +=
                        '&nbsp;<a href = "javascript:void(0)" onclick = "listDelete(' + res_id +
                        ')" class="btn btn-outline-danger btn-sm"> <span class="fa fa-trash"></span></a ></td> </tr>';

                    $('#name_ubah').val("");
                    $('#rfid_ubah').val("");
                    $('#list_' + res_id).replaceWith(row);
                    $('#ubahList').modal('hide');
                    $('#temp').html('tambah');
                    Swal.fire('Pengguna berhasil diperbaharui', '', 'success')
                }

            } catch (err) {
                console.log(err);
            }

            return false;
        });

        function listDelete(id) {
            Swal.fire({
                title: 'apakah kamu yakin menghapus Pengguna ini?',
                icon: 'info',
                confirmButtonText: `Ya, Hapus !`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pengguna.delete-list') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },

                        success: function(result) {
                            Swal.fire('Pengguna berhasil dihapus', '', 'success')
                            $('#list_' + id).remove();
                        }
                    });
                } else {

                }
            });
        }
    </script>
@endsection
