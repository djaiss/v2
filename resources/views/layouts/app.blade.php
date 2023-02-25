<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'OfficeLife') }}</title>

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
    <header class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
    </header>
    @endif

    <!-- Page Content -->
    <main>
      {{ $slot }}
    </main>

    <!-- footer -->
    <div class="max-w-8xl mx-auto text-xs flex h-10 items-center justify-center sm:px-6 mb-10">

      <!-- copyright -->
      <div class="text-center">
        <p class="mb-2 text-gray-600">{{ __('OfficeLife. All rights reserved. 2019 — :year. Made from all over the world. We ❤️ you.', ['year' => $layout['currentYear']]) }}</p>

        <!-- language selector -->
        <ul class="list">
          @foreach ($layout['locales'] as $locale)
          <li class="inline mr-2">
            <x-link :route="$locale['url']" class="text-xs">{{ $locale['name'] }}</x-link>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</body>

</html>
