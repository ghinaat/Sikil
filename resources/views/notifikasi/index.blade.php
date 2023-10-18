@extends('adminlte::page')

@section('title', 'SIKLIS | Notifikasi')

@section('content_header')
    <h1 class="m-0">Notifikasi</h1>

    <style>

        body{
            background:#FDFDFF
        }
        body.badge {
            border-radius: 8px;
            padding: 4px 8px;
            text-transform: uppercase;
            font-size: .7142em;
            line-height: 12px;
            background-color: transparent;
            border: 1px solid;
            margin-bottom: 5px;
            border-radius: .875rem;
        }
        .bg-green {
            background-color: #50d38a !important;
            color: #fff;
        }
        .bg-blush {
            background-color: #ff758e !important;
            color: #fff;
        }
        .bg-amber {
            background-color: #FFC107 !important;
            color: #fff;
        }
        .bg-red {
            background-color: #ec3b57 !important;
            color: #fff;
        }
        .bg-blue {
            background-color: #60bafd !important;
            color: #fff;
        }
        .card {
            background: #fff;
            margin-bottom: 30px;
            transition: .5s;
            border: 0;
            border-radius: .1875rem;
            display: inline-block;
            position: relative;
            width: 100%;
            box-shadow: none;
        }
        .inbox .action_bar .delete_all {
            margin-bottom: 0;
            margin-top: 8px
        }

        .inbox .action_bar .btn,
        .inbox .action_bar .search {
            margin: 0
        }

        .inbox .mail_list .list-group-item {
            border: 0;
            padding: 15px;
            margin-bottom: 1px
        }

        .inbox .mail_list .list-group-item:hover {
            background: #eceeef
        }

        .inbox .mail_list .list-group-item .media {
            margin: 0;
            width: 100%
        }

        .inbox .mail_list .list-group-item .controls {
            display: inline-block;
            margin-right: 10px;
            vertical-align: top;
            text-align: center;
            margin-top: 11px
        }

        .inbox .mail_list .list-group-item .controls .checkbox {
            display: inline-block
        }

        .inbox .mail_list .list-group-item .controls .checkbox label {
            margin: 0;
            padding: 10px
        }

        .inbox .mail_list .list-group-item .controls .favourite {
            margin-left: 10px
        }

        .inbox .mail_list .list-group-item .thumb {
            display: inline-block
        }

        .inbox .mail_list .list-group-item .thumb img {
            width: 40px
        }

        .inbox .mail_list .list-group-item .media-heading a {
            color: #555;
            font-weight: normal
        }

        .inbox .mail_list .list-group-item .media-heading a:hover,
        .inbox .mail_list .list-group-item .media-heading a:focus {
            text-decoration: none
        }

        .inbox .mail_list .list-group-item .media-heading time {
            font-size: 13px;
            margin-right: 10px
        }

        .inbox .mail_list .list-group-item .media-heading .badge {
            margin-bottom: 0;
            border-radius: 50px;
            font-weight: normal
        }

        .inbox .mail_list .list-group-item .msg {
            margin-bottom: 0px
        }

        .inbox .mail_list .unread {
            border-left: 2px solid
        }

        .inbox .mail_list .unread .media-heading a {
            color: #333;
            font-weight: 700
        }

        .inbox .btn-group {
            box-shadow: none
        }

        .inbox .bg-gray {
            background: #e6e6e6
        }

        @media only screen and (max-width: 767px) {
            .inbox .mail_list .list-group-item .controls {
                margin-top: 3px
            }
        }

    </style>
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <section class="content inbox border rounded p-2">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    @if($notifikasis->count() > 0)
                                    <ul class="mail_list list-group list-unstyled">
                                        @foreach ($notifikasis as $notifikasi)
                                        <li class="list-group-item @if($notifikasi->is_dibaca === 'tidak_dibaca') unread @endif">
                                            <div class="media">
                                                <div class="pull-left">
                                                    <div class="controls">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="basic_checkbox_1">
                                                            <label for="basic_checkbox_1"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <div class="media-heading">
                                                        <a href="{{ route('notifikasi.detail', $notifikasi->id_notifikasi) }}" class="m-r-10">{{ $notifikasi->judul }}</a>
                                                        @if($notifikasi->is_dibaca === 'tidak_dibaca')
                                                            <span class="badge bg-secondary">{{ $notifikasi->label }}</span>
                                                        @endif
                                                        <small class="float-right text-muted"><time class="hidden-sm-down" datetime="{{ $notifikasi->created_at->tz('Asia/Jakarta')->format('d M Y, H:i:s') }}">{{ $notifikasi->created_at->tz('Asia/Jakarta')->format('d M Y, H:i:s') }}</time><i class="zmdi zmdi-attachment-alt"></i> </small>
                                                    </div>
                                                    <p class="msg">{{ substr($notifikasi->pesan, 0, 40)  }}...</p>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <h3>Belum ada notifikasi</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
