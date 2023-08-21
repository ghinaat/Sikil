<table>
    <thead>
        <tr><td>Rekap Sisa Jatah Cuti Tahunan 2023 (2023: Tahun aktif)</td></tr>
        <tr></tr>
        <tr>
            <th>No.</th>
            <th>Nama Pegawai</th>
            <th>Jabatan</th>
            <th>Sisa Cuti Tahunan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cutis as $key => $cuti)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{ $cuti->user->nama_pegawai }}</td>
            <td>{{ $cuti->user->jabatan->nama_jabatan }}</td>
            <td>{{ $cuti->jatah_cuti }}</td>
            {{-- <td>{{ $cuti['jabatan'] }}</td> --}}
            {{-- <td>{{ $cuti['cutis'] }}</td> --}}
        </tr>
        @endforeach
</table>