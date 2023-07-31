@extends('adminlte::page')

@section('title', 'Detail User')

@section('content_header')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<h1 class="m-0 text-dark">Detail Profile</h1>
@stop

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if ($user->photo === 'no_pp.png')
                            <img class="profile-user-img img-fluid img-rounded"
                                src="{{ asset( 'images/' . $user->photo)  }}"
                                alt="User profile picture">    
                            @else
                            <img class="profile-user-img img-fluid img-rounded"
                                src="{{ asset( 'storage/profile/' . $user->photo)  }}"
                                alt="User profile picture">
                            @endif
        
                            <h3 class="profile-username text-center">{{ $main_user->nama_pegawai }}</h3>
                            <p class="text-muted text-center">{{ $main_user->jabatan->nama_jabatan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    @if (Route::currentRouteName() === 'user.showAdmin')
                        @include('partials.nav-pills-profile-admin', ['id_users' => $main_user->id_users])
                    @else
                        @include('partials.nav-pills-profile')
                    @endcan
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="data-pribadi">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama" class='form-label'>Nama</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama" name="nama"
                                                value="{{ $main_user->nama_pegawai }}" readonly>
                                            @error('nama') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jabatan" class='form-label'>jabatan</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" placeholder="jabatan" name="jabatan"
                                                value="{{ $main_user->jabatan->nama_jabatan }}" readonly>
                                            @error('jabatan') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nip" class='form-label'>NIP</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" placeholder="NIP" name="nip"
                                                value="{{$user->nip ?? old('nip')}}" readonly>
                                            @error('nip') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik" class='form-label'>NIK</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK" name="nik"
                                                value="{{$user->nik ?? old('nik')}}" readonly>
                                            @error('nik') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kk" class='form-label'>KK</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('kk') is-invalid @enderror" id="kk" placeholder="KK" name="kk"
                                                value="{{$user->kk ?? old('kk')}}" readonly>
                                            @error('kk') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_lahir" class='form-label'>Tempat Lahir</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" placeholder="Tempat Lahir" name="tempat_lahir"
                                                value="{{$user->tempat_lahir ?? old('tempat_lahir')}}" readonly>
                                            @error('tempat_lahir') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_lahir" class='form-label'>Tanggal Lahir</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" placeholder="Tanggal Lahir" name="tanggal_lahir"
                                                value="{{$user->tanggal_lahir ?? old('tanggal_lahir')}}" readonly>
                                            @error('tanggal_lahir') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat" class='form-label'>Alamat</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat" name="alamat"
                                                value="{{$user->alamat ?? old('alamat')}}" readonly>
                                            @error('alamat') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp" class='form-label'>No HP</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="No HP" name="no_hp"
                                                value="{{$user->no_hp ?? old('no_hp')}}" readonly>
                                            @error('no_hp') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="agama" class='form-label'>Agama</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama" placeholder="Agama" name="agama"
                                                value="{{$user->agama ?? old('agama')}}" readonly>
                                            @error('agama') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class='form-label'>Gender</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('gender') is-invalid @enderror" id="gender" placeholder="Gender" name="gender"
                                                value="{{$user->gender ?? old('gender')}}" readonly>
                                            @error('gender') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pendidikan" class='form-label'>Pendidikan</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" placeholder="Pendidikan" name="pendidikan"
                                                value="{{$user->pendidikan ?? old('pendidikan')}}" readonly>
                                            @error('pendidikan') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tmt" class='form-label'>Tanggal Mulai Tugas</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('tmt') is-invalid @enderror" id="tmt" placeholder="Tanggal Mulai Tugas" name="tmt"
                                                value="{{$user->tmt ?? old('tmt')}}" readonly>
                                            @error('tmt') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="masa_kerja" class='form-label'>Masa Kerja</label>
                                        <div class="form-input">
                                            @if (isset($user->tmt))
                                            <input type="text" class="form-control @error('masa_kerja') is-invalid @enderror" id="masa_kerja" placeholder="Masa Kerja" name="masa_kerja"
                                                value="{{date('Y-m-d', strtotime('+2 year', strtotime($user->tmt) )) ?? old('masa_kerja')}}" readonly>
                                            @error('masa_kerja') <span class="textdanger">{{$message}}</span> @enderror
                                            @else
                                            <input type="text" class="form-control @error('masa_kerja') is-invalid @enderror" id="masa_kerja" placeholder="Masa Kerja" name="masa_kerja"
                                                value="" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status_kawin" class='form-label'>Status Kawin</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('status_kawin') is-invalid @enderror" id="status_kawin" placeholder="Status Kawin" name="status_kawin"
                                                value="{{$user->status_kawin ?? old('status_kawin')}}" readonly>
                                            @error('status_kawin') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="bpjs" class='form-label'>BPJS</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('bpjs') is-invalid @enderror" id="bpjs" placeholder="BPJS" name="bpjs"
                                                value="{{$user->bpjs ?? old('bpjs')}}" readonly>
                                            @error('bpjs') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tingkat_pendidikan" class='form-label'>Tingkat Pendidikan</label>
                                        <div class="form-input">
                                            <input type="text" class="form-control @error('tingkat_pendidikan') is-invalid @enderror" id="tingkat_pendidikan" placeholder="Tingkat Pendidikan" name="tingkat_pendidikan"
                                                value="{{$user->tingkat_pendidikan->nama_tingkat_pendidikan ?? old('tingkat_pendidikan')}}" readonly>
                                            @error('tingkat_pendidikan') <span class="textdanger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#editModal">
                                            Edit
                                        </a>
                                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Kegiatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('profile.update', $main_user->id_users ) }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="my-2">
                                                                <label for="nip" class='form-label'>NIP</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" placeholder="NIP" name="nip"
                                                                        value="{{$user->nip ?? old('nip')}}" >
                                                                    @error('nip') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="nik" class='form-label'>NIK</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK" name="nik"
                                                                        value="{{$user->nik ?? old('nik')}}" >
                                                                    @error('nik') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="kk" class='form-label'>KK</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('kk') is-invalid @enderror" id="kk" placeholder="KK" name="kk"
                                                                        value="{{$user->kk ?? old('kk')}}" >
                                                                    @error('kk') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="tempat_lahir" class='form-label'>Tempat Lahir</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" placeholder="Tempat Lahir" name="tempat_lahir"
                                                                        value="{{$user->tempat_lahir ?? old('tempat_lahir')}}" >
                                                                    @error('tempat_lahir') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="tanggal_lahir" class='form-label'>Tanggal Lahir</label>
                                                                <div class="form-input">
                                                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" placeholder="Tanggal Lahir" name="tanggal_lahir"
                                                                        value="{{$user->tanggal_lahir ?? old('tanggal_lahir')}}" >
                                                                    @error('tanggal_lahir') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="alamat" class='form-label'>Alamat</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat" name="alamat"
                                                                        value="{{$user->alamat ?? old('alamat')}}" >
                                                                    @error('alamat') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="no_hp" class='form-label'>No HP</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="No HP" name="no_hp"
                                                                        value="{{$user->no_hp ?? old('no_hp')}}" >
                                                                    @error('no_hp') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="exampleInputagama">Agama</label>
                                                                @if (isset($user->agama))
                                                                    <select class="form-select @error('agama') isinvalid @enderror" id="exampleInputagama" name="agama">
                                                                        <option value="islam" @if($user->agama == 'islam' || old('agama')=='islam' ) selected @endif>Islam</option>
                                                                        <option value="kristen" @if($user->agama == 'kristen' || old('agama')=='kristen' ) selected @endif>Kristen</option>
                                                                        <option value="katolik" @if($user->agama == 'katolik' || old('agama')=='katolik' ) selected @endif>Katolik</option>
                                                                        <option value="hindu" @if($user->agama == 'hindu' || old('agama')=='hindu' ) selected @endif>Hindu</option>
                                                                        <option value="budha" @if($user->agama == 'budha' || old('agama')=='budha' ) selected @endif>Budha</option>
                                                                        <option value="konghucu" @if($user->agama == 'konghucu' || old('agama')=='konghucu' ) selected @endif>konghucu</option>
                                                                    </select>
                                                                    @error('agama') <span class="textdanger">{{$message}}</span>
                                                                    @enderror    
                                                                @else
                                                                    <select class="form-select @error('agama') isinvalid @enderror" id="exampleInputagama" name="agama">
                                                                        <option value="islam" >Islam</option>
                                                                        <option value="kristen">Kristen</option>
                                                                        <option value="katolik">Katolik</option>
                                                                        <option value="hindu" >Hindu</option>
                                                                        <option value="budha" >Budha</option>
                                                                        <option value="konghucu" >konghucu</option>
                                                                    </select>
                                                                    @error('agama') <span class="textdanger">{{$message}}</span>
                                                                    @enderror   
                                                                @endif
                                                                
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="exampleInputgender">gender</label>
                                                                @if (isset($user->gander))
                                                                    <select class="form-select @error('gender') isinvalid @enderror" id="exampleInputgender" name="gender">
                                                                        <option value="laki-laki" @if($user->gender == 'laki-laki' || old('gender')=='laki-laki' ) selected @endif>laki-laki</option>
                                                                        <option value="perempuan" @if($user->gender == 'perempuan' || old('gender')=='perempuan' ) selected @endif>perempuan</option>
                                                                    </select>
                                                                    @error('gender') <span class="textdanger">{{$message}}</span>
                                                                    @enderror
                                                                @else
                                                                    <select class="form-select @error('gender') isinvalid @enderror" id="exampleInputgender" name="gender">
                                                                        <option value="laki-laki">laki-laki</option>
                                                                        <option value="perempuan">perempuan</option>
                                                                    </select>
                                                                    @error('gender') <span class="textdanger">{{$message}}</span>
                                                                    @enderror
                                                                @endif
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="pendidikan" class='form-label'>Pendidikan</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" placeholder="Pendidikan" name="pendidikan"
                                                                        value="{{$user->pendidikan ?? old('pendidikan')}}" >
                                                                    @error('pendidikan') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="tmt" class='form-label'>Tanggal Mulai Tugas</label>
                                                                <div class="form-input">
                                                                    <input type="date" class="form-control @error('tmt') is-invalid @enderror" id="tmt" placeholder="Tanggal Mulai Tugas" name="tmt"
                                                                        value="{{$user->tmt ?? old('tmt')}}" >
                                                                    @error('tmt') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="exampleInputstatus_kawin">Status Kawin</label>
                                                                @if (isset($user->status_kawin))
                                                                    <select class="form-select @error('status_kawin') isinvalid @enderror" id="exampleInputstatus_kawin" name="status_kawin">
                                                                        <option value="menikah" @if($user->status_kawin == 'menikah' || old('status_kawin')=='menikah' ) selected @endif>menikah</option>
                                                                        <option value="belum_menikah" @if($user->status_kawin == 'belum_menikah' || old('status_kawin')=='belum_menikah' ) selected @endif>belum menikah</option>
                                                                    </select>
                                                                    @error('status_kawin') <span class="textdanger">{{$message}}</span>
                                                                    @enderror    
                                                                @else
                                                                    <select class="form-select @error('status_kawin') isinvalid @enderror" id="exampleInputstatus_kawin" name="status_kawin">
                                                                        <option value="menikah" >menikah</option>
                                                                        <option value="belum_menikah">belum menikah</option>
                                                                    </select>
                                                                    @error('status_kawin') <span class="textdanger">{{$message}}</span>
                                                                    @enderror
                                                                @endif
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="bpjs" class='form-label'>BPJS</label>
                                                                <div class="form-input">
                                                                    <input type="text" class="form-control @error('bpjs') is-invalid @enderror" id="bpjs" placeholder="BPJS" name="bpjs"
                                                                        value="{{$user->bpjs ?? old('bpjs')}}" >
                                                                    @error('bpjs') <span class="textdanger">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="tingkat_pendidikan" class='form-label'>Tingkat Pendidikan</label>
                                                                <div class="form-input">
                                                                    <select class="form-select @error('tingkat_pendidikan') isinvalid @enderror" id="exampleInputtingkat_pendidikan" name="id_tingkat_pendidikan">
                                                                        @foreach ($tingkat_pendidikans as $tingkat_pendidikan)
                                                                        <option value="{{ $tingkat_pendidikan->id_tingkat_pendidikan }}" @if(
                                                                            old('id_tingkat_pendidikan')==$tingkat_pendidikan->id_tingkat_pendidikan ) selected @endif>
                                                                            {{ $tingkat_pendidikan->nama_tingkat_pendidikan }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="my-2">
                                                                <label for="photo">Photo Profile</label>
                                                                @if ($user->photo === 'no_pp.png')
                                                                <p>Previous File: <a
                                                                    href="{{ asset('/public/' . $user->photo) }}"
                                                                    target="_blank">{{ $user->photo }}</a></p>    
                                                                @elseif ( isset($user->photo) )
                                                                <p>Previous File: <a
                                                                        href="{{ asset('/storage/profile/' . $user->photo) }}"
                                                                        target="_blank">{{ $user->photo }}</a></p>
                                                                @endif
                                                                <input type="file" name="photo" id="photo"
                                                                    class="form-control">
                                                                @error('photo')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                <a href="{{route('kegiatan.index')}}" class="btn btn-default">
                                                                    Batal
                                                                </a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- @endif --}}
                                        <a href="{{route('user.index')}}" class="btn btn-primary ">
                                            Kembali
                                        </a>
                                    </div>
                                </div>
                        
                            </div>
                            <div class="tab-pane" id="timeline">
                               <h1>test</h1>
                        
                            </div>
                        </div>
                    <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

</section>
<!-- /.content -->



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
</script>
<script>
function pilih(id, nama_pegawai) {
    // Mengisi nilai input dengan data yang dipilih dari tabel
    document.getElementById('selected_id_users').value = id;
    document.getElementById('pegawai').value = nama_pegawai;
}
</script>



@endpush