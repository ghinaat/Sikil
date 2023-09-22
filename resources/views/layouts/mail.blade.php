@component('mail::message')
# {{ $data['judul'] }}

{{ $data['pesan'] }}

<a href="{{ url('/') .  $data['link'] }}">
    Lihat Link Tautan
</a>

<br>
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
