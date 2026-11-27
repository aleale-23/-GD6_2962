@props(['pesan', 'tipe' => 'info'])

<div class="alert alert-{{ $tipe }}" role="alert">
    {{ $pesan }}
</div>