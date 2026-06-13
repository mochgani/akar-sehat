@php
  $__h = trim((string) ($html ?? ''));
  $__tag = $tag ?? 'p';
  $__class = trim((string) ($class ?? ''));
@endphp
@if($__h !== '')
  @if(\App\Support\RichText::isBlock($__h))
    <div class="{{ trim($__class . ' rich-block') }}">{!! $__h !!}</div>
  @else
    @php $__al = \App\Support\RichText::align($__h); @endphp
    <{{ $__tag }}@if($__class) class="{{ $__class }}"@endif @if($__al) style="text-align:{{ $__al }}"@endif>{!! \App\Support\RichText::inline($__h) !!}</{{ $__tag }}>
  @endif
@endif
