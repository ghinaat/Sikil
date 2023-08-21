<table>
    <thead>
        <tr><td>Data Rekap Presensi Pegawai SEAMEO QITEP in Language</td></tr>
        <tr><td>Periode: {{ $presensis['start_date'] }} s.d. {{ $presensis['end_date'] }}</td></tr>
        <tr></tr>
        <tr>
            <th>No.</th>
            <th>Nama Pegawai</th>
            <th>Kehadiran</th>
            <th>Terlambat</th>
            <th>Ijin</th>
            <th>Sakit</th>
            <th>Cuti Sakit</th>
            <th>Cuti Tahunan</th>
            <th>Cuti Melahirkan</th>
            <th>Dinas Luar</th>
            <th>ALPHA</th>
            <th>Cuti Bersama</th>
            <th>Cuti Haji</th>
            <th>Tugas Belajar</th>
        </tr>
    </thead>
        <tbody>
            @foreach($presensis['data'] as $key => $presensi)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{ $presensi['user'] }}</td>
                <td>{{ $presensi['kehadiran'] }}</td>
                <td>{{ $presensi['terlambat'] }}</td>
                <td>{{ $presensi['ijin'] }}</td>
                <td>{{ $presensi['sakit'] }}</td>
                <td>{{ $presensi['cutiSakit'] }}</td>
                <td>{{ $presensi['cutiTahunan'] }}</td>
                <td>{{ $presensi['cutiMelahirkan'] }}</td>
                <td>{{ $presensi['dinasLuar'] }}</td>
                <td>{{ $presensi['alpha'] }}</td>
                <td>{{ $presensi['cutiBersama'] }}</td>
                <td>{{ $presensi['cutiHaji'] }}</td>
                <td>{{ $presensi['tugasBelajar'] }}</td>
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

