@extends('adminlte::page')

@section('title', 'Pengajuan 2')

@section('content_header')

<link rel="stylesheet" href="{{ asset('css/card.css') }}">
<link rel="stylesheet" href="{{asset('fontawesome-free-6.4.2\css\all.min.css')}}">
<style>
@media(max-width:512px) {
    .header-text-home {
        font-size: 24px;
    }

    h2 {
        font-size: 24px;
    }

    h3 {
        font-size: 20px;
    }

    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 10rem;
        height: 10rem;
        /* Set a fixed height for the card */
    }

    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 10rem;
        height: 10rem;
        /* Set a fixed height for the card */
    }

    .icon {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }


}
</style>

@stop

@section('content')
<div class="ag-format-container">
    <div class="ag-courses_box">
        <div class="ag-courses_item">
            <a href="{{route('surat.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Nomer Surat
                </div>
            </a>
        </div>


        <div class="ag-courses_item">
            <a href="{{route('url.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fas fa-qrcode"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Short Link / QR Code
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuansinglelink.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-link"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Single Link
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanzoom.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-video"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Zoom Meeting
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanblastemail.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Blast Email
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanform.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-brands fa-wpforms"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Gooogle Form
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('peminjaman.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-regular fa-handshake"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Peminjaman Alat TIK
                </div>
            </a>
        </div>

        <div class="ag-courses_item">
            <a href="{{route('ajuanperbaikan.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Perbaikan Alat TIK
                </div>
            </a>
        </div>


        <div class="ag-courses_item">
            <a href="{{route('ajuandesain.index')}}" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_icon">
                    <div class="circle-background">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                </div>


                <div class="ag-courses-item_date-box">
                    Permohonan Desain
                </div>
            </a>
        </div>

    </div>
</div>






</div>

@stop