@if ($paginator->hasPages())
<div class="pag">
  @if ($paginator->onFirstPage())
    <span class="disabled">&laquo;</span>
  @else
    <a href="{{ $paginator->previousPageUrl() }}">&laquo;</a>
  @endif

  @foreach ($elements as $element)
    @if (is_string($element))
      <span>{{ $element }}</span>
    @endif
    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="active">{{ $page }}</span>
        @else
          <a href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}">&raquo;</a>
  @else
    <span class="disabled">&raquo;</span>
  @endif
</div>
@endif
