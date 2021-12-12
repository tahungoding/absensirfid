@extends('layouts.app')

@section('title')
    TAHUNGODING ABSENSI RFID - REKAPITULASI
@endsection

@section('css')
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-kit.css?v=3.0.0" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"
        integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list">
                            @foreach ($list as $item)
                                <tr id="list_{{ $item->id }}">
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->pengguna->name }}</td>
                                    <td>{{ $item->date_in }}</td>
                                    <td>{{ $item->date_out }}</td>
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
                                <select name="user_id" class="form-control" id="user_id_tambah">
                                    @foreach ($pengguna as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-static mt-5">
                                <label for="">Waktu Masuk</label>
                                <input type="text" class="form-control datetimepicker" name="date_in" id="date_in_tambah">
                            </div>
                            <div class="input-group input-group-static mt-5">
                                <label for="">Waktu Keluar</label>
                                <input type="text" class="form-control datetimepicker" name="date_out" id="date_out_tambah">
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
                                <select name="user_id" class="form-control" id="user_id_ubah">
                                    @foreach ($pengguna as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-static mt-5">
                                <label for="">Waktu Masuk</label>
                                <input type="text" class="form-control datetimepicker" name="date_in" id="date_in_ubah">
                            </div>
                            <div class="input-group input-group-static mt-5">
                                <label for="">Waktu Keluar</label>
                                <input type="text" class="form-control datetimepicker" name="date_out" id="date_out_ubah">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>
    <script>
        //Aksi Tambah
        const tambah = document.getElementById('tambah');
        console.log(tambah);

        tambah.addEventListener('submit', async (e) => {
            e.preventDefault();

            const user_id = tambah.user_id.value;
            const date_in = tambah.date_in.value;
            const date_out = tambah.date_out.value;
            const _token = "{{ csrf_token() }}";

            let formData = new FormData();
            formData.append("user_id", user_id);
            formData.append("date_in", date_in);
            formData.append("date_out", date_out);

            try {
                let response = await fetch("{{ route('rekapitulasi.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": _token
                    }
                });
                var datasend = await response.json();

                if (datasend.status == 'success') {

                    var res_id = datasend.data.id;
                    var res_name = datasend.data.pengguna.name;
                    var res_date_in = datasend.data.date_in;
                    var res_date_out = datasend.data.date_out;

                    var row = '<tr id="list_' + res_id +
                        '"> <th>#</th> <td>' + res_name + '</td>';
                    row +=
                        '<td>' + res_date_in +
                        '</td> <td>' +
                        res_date_out + '</td> <td> <a href="javascript:void(0)" data-id="' + res_id +
                        '" onclick="listUpdate(this)" class="btn btn-outline-info btn-sm"> <span class="fa fa-edit"></span></a> <a href="javascript:void(0)" onclick="listDelete(' +
                        res_id + ')"';
                    row +=
                        'class="btn btn-outline-danger btn-sm"><span class="fa fa-trash"></span></a> </td></tr>';

                    $('#user_id_tambah').val("");
                    $('#date_in_tambah').val("");
                    $('#date_out_tambah').val("");
                    $('#list').append(row);
                    $('#tambahList').modal('hide');
                    Swal.fire('Rekapitulasi berhasil ditambahkan', '', 'success')
                }

            } catch (err) {
                console.log(err);
            }

            return false;
        });

        //Aksi Ubah

        function listUpdate(obj) {

            var id = obj.getAttribute('data-id');

            fetch("{{ url('rekapitulasi') }}/" + id).then(function(response) {
                response.json().then(function(text) {
                    var res = text;
                    var user_id = res.data.user_id;
                    var date_in = res.data.date_in;
                    var date_out = res.data.date_out;

                    $('#id_ubah').val(id);
                    $('#user_id_ubah').val(user_id);
                    $('#date_in_ubah').val(date_in);
                    $('#date_out_ubah').val(date_out);
                });
            });


            $('#ubahList').modal('show');
        }

        const ubah = document.getElementById('ubah');

        ubah.addEventListener('submit', async (e) => {
            e.preventDefault();

            const id = ubah.id.value;
            const user_id = ubah.user_id.value;
            const date_in = ubah.date_in.value;
            const date_out = ubah.date_out.value;
            const _token = "{{ csrf_token() }}";

            let formData = new FormData();
            formData.append("id", id);
            formData.append("user_id", user_id);
            formData.append("date_in", date_in);
            formData.append("date_out", date_out);

            try {
                let response = await fetch("{{ route('rekapitulasi.update-list') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": _token
                    }
                });
                var datasend = await response.json();

                if (datasend.status == 'success') {

                    var res_id = datasend.data.id;
                    var res_name = datasend.data.pengguna.name;
                    var res_date_in = datasend.data.date_in;
                    var res_date_out = datasend.data.date_out;

                    var row = '<tr id="list_' + res_id +
                        '"> <th>#</th> <td>' + res_name + '</td>';
                    row +=
                        '<td>' + res_date_in +
                        '</td> <td>' +
                        res_date_out + '</td> <td> <a href="javascript:void(0)" data-id="' + res_id +
                        '" onclick="listUpdate(this)" class="btn btn-outline-info btn-sm"> <span class="fa fa-edit"></span></a> <a href="javascript:void(0)" onclick="listDelete(' +
                        res_id + ')"';
                    row +=
                        'class="btn btn-outline-danger btn-sm"><span class="fa fa-trash"></span></a> </td></tr>';

                    $('#user_id_ubah').val("");
                    $('#date_in_ubah').val("");
                    $('#date_out_ubah').val("");
                    $('#list_' + res_id).replaceWith(row);
                    $('#ubahList').modal('hide');
                    Swal.fire('Rekapitulasi berhasil diperbaharui', '', 'success')
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
                        url: "{{ route('rekapitulasi.delete-list') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },

                        success: function(result) {
                            Swal.fire('Rekapitulasi berhasil dihapus', '', 'success')
                            $('#list_' + id).remove();
                        }
                    });
                } else {

                }
            });
        }

        jQuery.datetimepicker.setLocale('id');

        $('.datetimepicker').datetimepicker({
            format: 'Y-m-d H:i'
        });
    </script>
@endsection
