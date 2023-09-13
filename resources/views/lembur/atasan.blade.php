@extends('adminlte::page')
@section('title', 'List Lembur')
@section('content_header')
<h1 class="m-0 text-dark">List Lembur</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Pemohon</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Jumlah Jam</th>
                                <th>Uraian Tugas</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lembur as $key => $lr)
                            <tr>
                                <td id={{$key+1}}>{{$key+1}}</td>
                                <td id={{$key+1}}>{{date_format( new DateTime($lr->tanggal), 'd F Y')}}</td>
                                <td id={{$key+1}}>{{$lr->user->nama_pegawai}}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_mulai)->format('H:i') }}</td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_selesai)->format('H:i') }}
                                </td>
                                <td id={{$key+1}}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $lr->jam_lembur)->format('H:i') }}</td>
                                <td id={{$key+1}}>{{$lr->tugas}}</td>
                                <td>
                                    @if($lr->status_izin_atasan !== null)
                                    @if($lr->status_izin_atasan === '1')
                                    Disetujui
                                    @else
                                    Ditolak
                                    @endif
                                    @else
                                    <a href="#" class="btn btn-primary btn-xs edit-button" data-toggle="modal"
                                        data-target="#editModal{{$lr->id_lembur}}" data-id="{{$lr->id_lembur}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{$lr->id_lembur}}" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Persetujuan Lembur</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('lembur.status', $lr->id_lembur) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <label for="status_izin_atasan">Apakah anda menyetujui
                                                                    lembur {{$lr->user->nama_pegawai}}?</label>
                                                                <div class="input">
                                                                    <input type="radio" name="status_izin_atasan"
                                                                        value="1" @if ($lr->status_izin_atasan === '1')
                                                                    checked @endif> Disetujui<br>
                                                                    <input type="radio" name="status_izin_atasan"
                                                                        value="0" @if ($lr->status_izin_atasan === '0')
                                                                    checked @endif> Ditolak<br>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@push('js')
<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>

<script>
$('#example2').DataTable({
    "responsive": true,
});

function updateRecord(event, rowNumber, id_lembur, newStatus) {
    event.preventDefault(); // Prevent the default link behavior

    const confirmation = confirm("Are you sure you want to update this record?"); // Display a confirmation dialog

    if (confirmation) {
        // User confirmed, send AJAX request to update the record
        const token = '{{ csrf_token() }}';

        fetch(`/persetujuan/${id_lembur}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-Token': token,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    status_izin_atasan: newStatus
                }),
            })
            .then(response => {
                if (response.ok) {
                    // Handle success (e.g., show a success message, update UI)
                    console.log(`Record ${id_lembur} updated successfully`);
                } else {
                    // Handle errors (e.g., show an error message)
                    console.error(`Error updating record ${id_lembur}`);
                }
            })
            .catch(error => {
                // Handle network errors
                console.error('Network error:', error);
            });
    } else {
        // User canceled the operation
        console.log(`Update of record ${id_lembur} canceled.`);
    }
}
</script>
@endpush