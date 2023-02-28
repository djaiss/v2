<x-settings-layout>

  <!-- personal information -->
  <div class="p-5 md:grid md:grid-cols-3 md:gap-16 border-b border-gray-200">
    <div class="md:col-span-1">
      <h2 class="text-lg mb-2 font-bold">Your employee profile</h2>
      <p>Everyone in the company will be able to see these information.</p>
    </div>

    <div class="md:mt-0 md:col-span-2">
      <!-- first name -->
      <div class="w-full max-w-lg mb-4">
        <x-input-label for="first_name" :value="__('First name')" />
        <x-text-input id="first_name" dusk="first-name-field" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
      </div>

      <!-- last name -->
      <div class="w-full max-w-lg mb-4">
        <x-input-label for="last_name" :value="__('Last name')" />
        <x-text-input id="first_name" dusk="first-name-field" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <!-- email -->
      <div class="w-full max-w-lg mb-8">
        <x-input-label for=" email" :value="__('Email')" />
        <x-text-input id="email" dusk="email-field" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
        <x-input-help>{{ __('We\'ll send you an email to confirm your new address.') }}</x-input-help>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <div class="flex items-center justify-between mt-4">
        <x-primary-button dusk="submit-button">
          {{ __('Save') }}
        </x-primary-button>
      </div>
    </div>
  </div>

  <!-- personal information -->
  <div class="p-5 md:grid md:grid-cols-3 md:gap-16">
    <div class="md:col-span-1">
      <h2 class="text-lg mb-2 font-bold">Your employee profile</h2>
      <p>Everyone in the company will be able to see these information.</p>
    </div>

    <div class="md:mt-0 md:col-span-2">
      <!-- first name -->
      <div class="w-full max-w-lg mb-4">
        <x-input-label for="first_name" :value="__('First name')" />
        <x-text-input id="first_name" dusk="first-name-field" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
      </div>

      <!-- last name -->
      <div class="w-full max-w-lg mb-4">
        <x-input-label for="last_name" :value="__('Last name')" />
        <x-text-input id="last_name" dusk="first-name-field" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
      </div>

      <!-- email -->
      <div class="w-full max-w-lg mb-8">
        <x-input-label for=" email" :value="__('Email')" />
        <x-text-input id="email" dusk="email-field" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <div class="flex items-center justify-between mt-4">
        <x-primary-button dusk="submit-button">
          {{ __('Save') }}
        </x-primary-button>
      </div>
    </div>
  </div>
</x-settings-layout>
