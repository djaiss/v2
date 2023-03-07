<div class="">
  @if (! $openModal)
  <div class="flex justify-end mb-3">
    <x-secondary-button wire:click="toggle" dusk="open-modal-button">
      {{ __('Add') }}
    </x-secondary-button>
  </div>
  @endif

  @if ($openModal)
  <form wire:submit.prevent="store" class="bg-form mb-6 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
    <div class="border-b border-gray-200 dark:border-gray-700 p-5">
      <!-- name -->
      <div class="w-full max-w-lg">
        <x-input-label for="name" :value="__('Label')" />
        <x-text-input wire:model.defer="name" id="name" dusk="name-field" class="block mt-1 w-full name" type="text" name="name" :value="old('name')" autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>
    </div>

    <!-- permissions -->
    <div class="border-b border-gray-200 dark:border-gray-700 p-5">
      <p class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">{{ __('Permissions') }}</p>

      <div class="grid grid-cols-3 gap-1">
        @foreach ($permissions as $permission)
        <x-toggle label="{{ $permission['name'] }}" class="text-base" wire:model.defer="model" />
        @endforeach
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
      <x-link route="{{ $role['url'] }}">{{ $role['name'] }}</x-link>

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

@push('scripts')
<script>
  Livewire.on('focusNameField', () => {
    document.querySelector('.name').focus();
  })
</script>
@endpush
