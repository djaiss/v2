<x-settings-layout>
  <div class="p-5">
    <div class="md:grid md:grid-cols-3 md:gap-16">
      <div class="md:col-span-1">
        <h2 class="text-lg mb-2 font-bold">{{ __('Roles & permissions') }}</h2>
        <p>{{ __('You can configure all the roles and permissions used throughout the application.') }}</p>
      </div>

      <div class="md:mt-0 md:col-span-2">
        <ul class=" list mb-2 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          @foreach ($view->roles as $role)
          <li class="item-list border-b border-gray-200 hover:bg-slate-50 dark:border-gray-700 dark:bg-slate-900 hover:dark:bg-slate-800 p-3">
            <x-link route="{{ $role['url'] }}">{{ $role['name'] }}</x-link>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</x-settings-layout>
