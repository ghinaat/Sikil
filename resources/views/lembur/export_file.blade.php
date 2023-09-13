<table>
    <thead>
        <tr><td>Rekap Lembur Pegawai SEAQIL</td></tr>
        <tr><td>Tanggal Awal: {{ $lemburs['start_date'] }} Tanggal Akhir : {{ $lemburs['end_date'] }}</td></tr>
        <tr>
            <th>No.</th>
            <th>Nama Pegawai</th>
            <th>Divisi</th>
            <th>Tanggal (Desc)</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Waktu Lembur</th>
            <th>Uraian Tugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lemburs['data'] as $key => $lembur)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{ $lembur->user->nama_pegawai }}</td>
            <td>{{ $lembur->user->jabatan->nama_jabatan }}</td>
            <td>{{ $lembur->tanggal }}</td>
            <td>{{ $lembur->jam_mulai }}</td>
            <td>{{ $lembur->jam_selesai }}</td>
            <td>{{ $lembur->jam_lembur }}</td>
            <td>{{ $lembur->tugas }}</td>
        </tr>
        @endforeach
</table>
