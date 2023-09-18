@component('mail::message')
# {{ $data['judul'] }}

{{ $data['pesan'] }}

<a href="http://127.0.0.1:8000{{  $data['link'] }}">
    Lihat Link Tautan
</a>

<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
