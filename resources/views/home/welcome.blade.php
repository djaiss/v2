<x-guest-layout>

  <img src="img/logo.svg" alt="logo" class="text-center mx-auto mb-4 block">

  <div class="text-center font-bold mb-4 text-gray-600 dark:text-gray-400">
    {{ __('Does your company already exist in OfficeLife?') }}
  </div>

  <div class="mb-8 text-center text-gray-600 dark:text-gray-400">
    {{ __('You can add your company or join your existing company if it already exists.') }}
  </div>

  <div class="mt-4 justify-between mb-4">
    <div class="text-center">
      <!-- create a company -->
      <a href="{{ route('create_company.index') }}" dusk="link-create-company" class="mb-4 border group border-gray-200 rounded-lg p-5 flex hover:bg-gray-50 cursor-pointer hover:border-gray-300 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:text-emerald-600 mr-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <span class="">
          {{ __('Add your company') }}
        </span>
      </a>
      <a href="{{ route('create_company.index') }}" dusk="" class="mb-4 border group border-gray-200 rounded-lg p-5 flex hover:bg-gray-50 cursor-pointer hover:border-gray-300 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:text-emerald-600 mr-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>

        <span class="">
          {{ __('Join an existing company') }}
        </span>
      </a>
    </div>

    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <x-button-as-link class="text-xs block ">{{ __('Or you can also log out') }}</x-button-as-link>
    </form>
  </div>
</x-guest-layout>
