<div class="">
  @if (! $openModal)
  <div class="flex justify-end mb-3">
    <x-secondary-button wire:click="toggle" dusk="open-modal-button">
      {{ __('Add') }}
    </x-secondary-button>
  </div>
  @endif

  @if ($openModal)
  <form action="" class="bg-form mb-6 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
      <div class="border-b border-gray-200 dark:border-gray-700 p-5">
          <!-- label -->
          <div class="w-full max-w-lg">
              <x-input-label for="label" :value="__('Label')" />
              <x-text-input wire:model.defer="firstName" id="label" dusk="first-name-field" class="block mt-1 w-full" type="text" name="label" :value="old('label')" autofocus />
              <x-input-error :messages="$errors->get('label')" class="mt-2" />
          </div>
      </div>

      <!-- actions -->
      <div class="flex justify-between p-5">
          <x-secondary-button wire:click="toggle">{{ __('Cancel') }}</x-secondary-button>

          <x-primary-button wire:loading.attr="disabled" dusk="submit-button">
              {{ __('Save') }}
          </x-primary-button>
      </div>
  </form>
  @endif

  <!-- list of roles -->
  <ul class=" list mb-2 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
      @foreach ($roles as $role)
      <li class="item-list border-b border-gray-200 hover:bg-slate-50 dark:border-gray-700 dark:bg-slate-900 hover:dark:bg-slate-800 p-3 flex justify-between items-center">
          <x-link route="{{ $role->url }}">{{ $role->name }}</x-link>

          <x-dropdown>
              <x-dropdown.header label="Settings">
                  <x-dropdown.item label="Preferences" />
                  <x-dropdown.item label="My Profile" />
              </x-dropdown.header>
              <x-dropdown.item label="Logout" />
          </x-dropdown>
      </li>
      @endforeach
  </ul>
</div>
