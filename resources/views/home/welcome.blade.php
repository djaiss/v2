<x-guest-layout>

  <img src="img/logo.svg" alt="logo" class="text-center mx-auto mb-4 block">

  <div class="mb-4 text-gray-600 dark:text-gray-400">
    {{ __('OfficeLife lets you manage what\'s going on inside your company.') }}
  </div>

  <div class="mb-4 text-gray-600 dark:text-gray-400">
    {{ __('Would you like to create a new company, or join your existing company\'s account?') }}
  </div>

  <div class="mt-4 justify-between">
    <div class="text-center">
      <!-- create a company -->
      <div>

      </div>
      <p>
        <x-link dusk="link-create-company" :route="route('create_company.index')">
          {{ __('Create an account for your company') }}
        </x-link>
      </p>
      <p>Or</p>
      <p>
        <x-link :route="route('logout')">
          {{ __('Create an account for your company') }}
        </x-link>
      </p>
    </div>

    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <x-button-as-link>{{ __('Log out') }}</x-button-as-link>
    </form>
  </div>
</x-guest-layout>
