<!-- main nav -->
<nav x-data="{ open: false }" class="max-w-8xl mx-auto flex h-10 items-center justify-between border-b bg-gray-50 px-3 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200 sm:px-6">
  <div class="dark:highlight-white/5 items-center rounded-lg border border-gray-200 bg-white px-2 py-1 text-sm dark:border-0 dark:border-gray-700 dark:bg-gray-900 dark:bg-gray-400/20 sm:flex">
    {{ $layout['company']['name'] }}
  </div>

  <!-- search box -->
  <div class="flew-grow relative">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon-search absolute h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
    <input type="text" class="dark:highlight-white/5 block w-64 rounded-md border border-gray-300 px-2 py-1 text-center placeholder:text-gray-600 hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-0 dark:border-gray-700 dark:bg-slate-900 placeholder:dark:text-gray-400 hover:dark:bg-slate-700 sm:text-sm" @focus="goToSearchPage" />
  </div>

  <!-- settings -->
  <div class="hidden sm:flex sm:items-center sm:ml-6">
    <x-dropdown>
      <x-slot name="trigger">
        <div class="flex items-center">
          <x-heroicon-o-cog-8-tooth class="mr-1 inline-block h-4 w-4 cursor-pointer text-gray-600 dark:text-gray-400 sm:h-4 sm:w-4" />

          <span class=" text-sm dark:text-sky-400">Settings</span>
        </div>
      </x-slot>
      <x-dropdown.item label="{{ __('Your profile') }}" />
      <x-dropdown.item href="{{ route('settings.index') }}" separator label="{{ __('Settings') }}" />
      <x-dropdown.item href="{{ route('logout') }}" label="{{ __('Log out') }}" />
    </x-dropdown>
  </div>

  <!-- Hamburger -->
  <div class="-mr-2 flex items-center sm:hidden">
    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
      <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- <div class="flew-grow">
    <ul class="relative">
      <li class="mr-4 inline">
        <a href class="relative inline">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon-cog relative mr-1 inline-block h-4 w-4 cursor-pointer text-gray-600 dark:text-gray-400 dark:text-gray-300 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>

          <span class="text-sm dark:text-sky-400">Settings</span>
        </a>
      </li>
      <li class="inline">
        <a class="inline" method="post" href="route('logout')" as="button">
          <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 inline-block h-4 w-4 cursor-pointer text-gray-600 dark:text-gray-400 dark:text-gray-300 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>

          <span class="text-sm dark:text-sky-400">logour</span>
        </a>
      </li>
    </ul>
  </div> -->
</nav>


<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-link :route="'home.index'" :active="request()->routeIs('home.index')">
        {{ __('Dashboard') }}
      </x-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class=" pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
      <div class="px-4">
        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
      </div>

      <div class="mt-3 space-y-1">
        <x-link :route="'home.index'">
          {{ __('Profile') }}
        </x-link>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <x-link :route="'logout'" onclick="event.preventDefault();
                                        this.closest('form').submit();">
            {{ __('Log Out') }}
          </x-link>
        </form>
      </div>
    </div>
  </div>
</nav>
