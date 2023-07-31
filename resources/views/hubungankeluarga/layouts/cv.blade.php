<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=", initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CV</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family:  Tahoma, Geneva, Verdana, sans-serif;
        }
        .surat{
            padding-top: 50px;
            position: relative;
        }
        h5{
            font-size: 14px;    
        }
        img{
            width: 90px;
        }
        footer { position: absolute; bottom: 0px; left: 0px; right: 0px; }
        footer img{
            margin:;
        }

    </style>
</head>
<body>
    <footer>
        <hr style="margin: -10px 20px 0 20px;height:0.1px;color:#000;padding:0px;">
        <img src="images/footer.png" alt="" style="width:80%; padding-left:75px;">
        <p style="font-size:8px;"><i>Auto Generated File by <a href="#">SIKLIS</a></i></p>
    </footer>
    <main>
        <div class="surat">
            <div class="header">
                <table>
                    <tr>
                        <td style="width:33%;padding-left:15px;">
                            <img src="images/tutwuri.png" alt="">
                            <img src="images/seameo.png" alt="">
                            <img src="images/qitep.png" alt="">        
                        </td>
                        <td style="width:50%;">
                            <h5 style="margin-top: -40px;">The Southeast Asian Ministers of Education Organization (SEAMEO) <br>Regional Center for Quality Improvement of Teachers and Education Personnel (QITEP) in Language (SEAQIL) </h5>        
                        </td>
                    </tr>
                </table>
                <p style="padding:20px;font-size:12px;margin-top:-35px;">Jalan Gardu, Srengseng Sawah, Jagakarsa, Jakarta Seletan 12640, Indonesia | Telp.: +62 (021) 7888 4160 | Fax.: +62 (021) 7888 4073</p>
                <hr style="margin: -10px 20px 0 20px;height:0.1px;color:#000;padding:0px;">
            </div>
            <div class="body">
                <h5 style="text-align: center; margin-top:20px;">Daftar Biodata Staff</h5>
                <table style="width:100%;margin-top:20px;margin-left:150px;">
                    <tr>
                        <td style="width: 30%;">1. Nama</td>
                        <td style="width: 40%;">: {{ Auth::user()->nama_pegawai }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">2. Jabatan</td>
                        <td style="width: 40%;">: {{ Auth::user()->jabatan->nama_jabatan  }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">3. NIP</td>
                        <td style="width: 40%;">: {{ $user->nip }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">4. NIK</td>
                        <td style="width: 40%;">: {{ $user->nik }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">5. KK</td>
                        <td style="width: 40%;">: {{ $user->kk }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">6. Tempat Lahir</td>
                        <td style="width: 40%;">: {{ $user->tempat_lahir }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">7. Tanggal Lahir</td>
                        <td style="width: 40%;">: {{ $user->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">8. Alamat</td>
                        <td style="width: 40%;">: {{ $user->alamat }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">9. No Handphone</td>
                        <td style="width: 40%;">: {{ $user->no_hp }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">10. Agama</td>
                        <td style="width: 40%;">: {{ $user->agama }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">11. Gender</td>
                        <td style="width: 40%;">: {{ $user->gender }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">12. Tanggal Mulai Tugas</td>
                        <td style="width: 40%;">: {{ $user->tmt }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">13. Masa Kerja</td>
                        <td style="width: 40%;">: {{ date('Y-m-d', strtotime('+2 year', strtotime($user->tmt) )) ?? old('masa_kerja') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">14. Status Kawin</td>
                        <td style="width: 40%;">: {{ $user->status_kawin }}</td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">15. BPJS</td>
                        <td style="width: 40%;">: {{ $user->bpjs }}</td>
                    </tr>
                    @if(isset($user->tingkat_pendidikan->nama_tingkat_pendidikan))
                    <tr>
                        <td style="width: 30%;">16. Tingkat Pendidikan</td>
                        <td style="width: 40%;">: {{ $user->tingkat_pendidikan->nama_tingkat_pendidikan }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </main>
</body>
</html>