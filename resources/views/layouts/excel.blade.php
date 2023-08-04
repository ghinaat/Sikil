<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Finger</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Terlambat</th>
            <th>Pulang Cepat</th>
            <th>Kehadiran</th>
            <th>Jenis Perizinan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presensis as $presensi)
        <tr>
            <td>{{ $presensi->id_presensi }}</td>
            <td>{{ $presensi->kode_finger }}</td>
            <td>{{ $presensi->tanggal }}</td>
            <td>{{ $presensi->jam_masuk }}</td>
            <td>{{ $presensi->jam_pulang }}</td>
            <td>{{ $presensi->terlambat }}</td>
            <td>{{ $presensi->pulang_cepat }}</td>
            <td>{{ $presensi->kehadiran }}</td>
            <td>{{ $presensi->jenis_perizinan }}</td>
        </tr>
        @endforeach

        <tr></tr><tr></tr><tr></tr>
        <tr>
            <td>I</td>
            <td>Ijin</td>
        </tr>
        <tr>
            <td>S</td>
            <td>Sakit</td>
        </tr>
        <tr>
            <td>CS</td>
            <td>Cuti Sakit</td>
        </tr>
        <tr>
            <td>CT</td>
            <td>Cuti Tahunan</td>
        </tr>
        <tr>
            <td>CM</td>
            <td>Cuti Melahirkan</td>
        </tr>
        <tr>
            <td>DL</td>
            <td>Dinas Luar</td>
        </tr>
        <tr>
            <td>A</td>
            <td>Alpha</td>
        </tr>
        <tr>
            <td>CB</td>
            <td>Cuti Bersama</td>
        </tr>
        <tr>
            <td>CH</td>
            <td>Cuti Haji</td>
        </tr>
        <tr>
            <td>TB</td>
            <td>Tugas Belajar</td>
        </tr>
    </tbody>
</table>
