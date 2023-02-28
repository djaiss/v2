<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-0 md:px-6 shadow-sm">
      <!-- header -->
      <div class="flex flex-wrap mx-auto bg-white rounded-t-lg sticky top-0 z-30">
        <div class="flex items-center justify-between w-full border-b h-18 border-slate-200">
          <div class="flex items-center justify-between w-full px-4 py-6 h-8">
            <div class="flex items-center justify-start w-[300px] text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2 text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
              </svg>

              <x-link :route="route('home.index')">Back to home</x-link>
            </div>
            <div class="flex items-center justify-center w-full space-x-1.5">
              Settings
            </div>
            <div class="flex justify-end w-[300px]">
              &nbsp;
            </div>
          </div>
        </div>
      </div>

      <!-- body -->
      <div class=" w-full rounded-b-lg mx-auto bg-white max-w-7xl ">
        <div class=" flex w-full divide-x divide-slate-200">
          <nav class=" max-w-[25%] space-y-6 sidebar whitespace-nowrap p-3">
            <ul>
              <li class="uppercase text-xs mb-2 font-light">Your account</li>
              <li class="bg-slate-100 hover:bg-slate-100 pl-2 pr-5 py-1 rounded cursor-pointer mb-1 flex items-center group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2 text-cyan-800 group-hover:text-cyan-800">
                  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                </svg>

                Profile
              </li>
              <li class="hover:bg-slate-100 pl-2 pr-5 py-1 rounded cursor-pointer mb-1 flex items-center group">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2 text-gray-400 group-hover:text-cyan-800">
                  <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 016.775-5.025.75.75 0 01.313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 011.248.313 5.25 5.25 0 01-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 112.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0112 6.75zM4.117 19.125a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008z" clip-rule="evenodd" />
                  <path d="M10.076 8.64l-2.201-2.2V4.874a.75.75 0 00-.364-.643l-3.75-2.25a.75.75 0 00-.916.113l-.75.75a.75.75 0 00-.113.916l2.25 3.75a.75.75 0 00.643.364h1.564l2.062 2.062 1.575-1.297z" />
                  <path fill-rule="evenodd" d="M12.556 17.329l4.183 4.182a3.375 3.375 0 004.773-4.773l-3.306-3.305a6.803 6.803 0 01-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 00-.167.063l-3.086 3.748zm3.414-1.36a.75.75 0 011.06 0l1.875 1.876a.75.75 0 11-1.06 1.06L15.97 17.03a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>

                Preferences
              </li>
            </ul>

            <ul>
              <li class="uppercase text-xs mb-2 font-light">Company</li>
              <li class="bg-slate-100 hover:bg-slate-100 px-5 py-1 rounded cursor-pointer mb-1">Overview</li>
              <li class="hover:bg-slate-100 px-5 py-1 rounded cursor-pointer mb-1">General</li>
              <li class="hover:bg-slate-100 px-5 py-1 rounded cursor-pointer mb-1">Security</li>
              <li class="hover:bg-slate-100 px-5 py-1 rounded cursor-pointer mb-1">Permissions</li>
            </ul>
          </nav>

          <!-- right part -->
          <div class="flex flex-col min-w-[75%] w-full">
            {{ $slot }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
