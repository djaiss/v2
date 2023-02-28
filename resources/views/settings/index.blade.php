<x-settings-layout>
  <div class="p-3 md:grid md:grid-cols-3 md:gap-16">
    <div>
      <h2>Your employee profile</h2>
      <p>Everyone in the company will be able to see these information.</p>
    </div>

    <div>
      <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" dusk="email-field" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>
    </div>
  </div>
</x-settings-layout>
