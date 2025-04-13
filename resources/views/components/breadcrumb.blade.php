<div class="text-sm text-gray-500 space-x-1">
  @foreach (Request::segments() as $index => $segment)
    @if ($index + 1 < count(Request::segments()))
      <a href="{{ url(implode('/', array_slice(Request::segments(), 0, $index + 1))) }}"
         class="text-indigo-600 hover:underline capitalize">
        {{ ucwords(str_replace('-', ' ', $segment)) }}
      </a>
      <span>/</span>
    @else
      <span class="text-gray-700 font-semibold capitalize">
        {{ ucwords(str_replace('-', ' ', $segment)) }}
      </span>
    @endif
  @endforeach
</div>
