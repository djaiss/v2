@if ($attributes->has('href'))
<a {{ $attributes->merge(['class' => 'relative text-sm dark:text-gray-100 dark:box-s bg-white dark:bg-gray-800 border-zinc-900 dark:border-zinc-100 rounded button']) }} href="{{ $href }}">
  @if ($attributes->has('save'))
  <span class="flex items-center">
    <x-heroicon-o-plus-small class="icon relative mr-1 inline h-5 w-5" />
    <span>{{ $slot }}</span>
  </span>
  @else
  {{ $slot }}
  @endif
</a>
@else
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'relative text-sm dark:text-gray-100 dark:box-s bg-white dark:bg-gray-800 border-zinc-900 dark:border-zinc-100 rounded save button']) }}>
  {{ $slot }}
</button>
@endif
