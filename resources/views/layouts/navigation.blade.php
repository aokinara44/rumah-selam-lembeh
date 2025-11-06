<?php
// Lokasi File: resources/views/layouts/navigation.blade.php
?>
{{-- Hapus @props --}}

@php
    $activeMenu = null;
    if (request()->routeIs('admin.service*')) $activeMenu = 'services';
    elseif (request()->routeIs('admin.gallery*')) $activeMenu = 'media';
    elseif (request()->routeIs('admin.review*')) $activeMenu = 'feedback';
    elseif (request()->routeIs('admin.user*') || request()->routeIs('admin.profile*') || request()->routeIs('admin.contact*') || request()->routeIs('admin.transaction*') || request()->routeIs('admin.schedules*')) $activeMenu = 'management'; // <-- 1. DITAMBAHKAN 'admin.schedules*'
@endphp

<div x-data="{
        activeDropdown: null,
        floatingDropdown: null,
        sidebarMinimized: localStorage.getItem('sidebarMinimized') === 'true', {{-- Baca localStorage --}}
        toggleAccordion(id) {
            if (!this.sidebarMinimized) {
                this.activeDropdown = (this.activeDropdown === id) ? null : id;
            }
            this.floatingDropdown = null;
        },
        toggleFloating(id, event) {
            if (!this.sidebarMinimized) return;
            event.stopPropagation();
            this.activeDropdown = null;
            const currentlyOpen = this.floatingDropdown === id;
            this.floatingDropdown = currentlyOpen ? null : id;
            if (!currentlyOpen && this.floatingDropdown) {
                const buttonRect = event.currentTarget.getBoundingClientRect();
                const sidebarRect = document.getElementById('sidebar-container').getBoundingClientRect();
                this.$nextTick(() => {
                    const dropdownEl = this.$refs[id + 'Floating'];
                    if (dropdownEl) {
                        dropdownEl.style.top = `${buttonRect.top}px`;
                        dropdownEl.style.left = `${sidebarRect.right}px`;
                    }
                });
            }
        },
        closeFloating() {
            this.floatingDropdown = null;
        },
        init() {
            {{-- Inisialisasi accordion hanya jika tidak minimized --}}
            if (!this.sidebarMinimized) {
                this.activeDropdown = '{{ $activeMenu }}';
            }
            {{-- Hapus $watch untuk prop --}}
            window.addEventListener('click', (event) => {
                 const sidebar = document.getElementById('sidebar-container');
                 const isClickInsideSidebar = sidebar && sidebar.contains(event.target);
                 const floatingMenu = this.floatingDropdown ? this.$refs[this.floatingDropdown + 'Floating'] : null;
                 const isClickInsideFloatingMenu = floatingMenu && floatingMenu.contains(event.target);
                 if (!isClickInsideSidebar && !isClickInsideFloatingMenu) {
                     this.closeFloating();
                 }
            });
        }
    }"
    {{-- Tetap dengarkan event global untuk sinkronisasi --}}
    @toggle-sidebar.window="sidebarMinimized = !sidebarMinimized; if (sidebarMinimized) { activeDropdown = null; } else { activeDropdown = '{{ $activeMenu }}'; }"
    class="flex flex-col h-full overflow-y-auto"
>
    <div class="flex-shrink-0 flex items-center h-16 px-4"
         :class="{'justify-start': !sidebarMinimized, 'justify-center': sidebarMinimized}">
        <a href="{{ route('admin.dashboard', ['locale' => app()->getLocale()]) }}" class="flex items-center"
           :class="{'space-x-3': !sidebarMinimized, 'justify-center': sidebarMinimized}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                 class="h-10 w-auto transition-all duration-300 flex-shrink-0"
                 :class="{'h-10': !sidebarMinimized, 'h-8': sidebarMinimized}">
            <div x-show="!sidebarMinimized"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="flex flex-col -space-y-1">
                <span class="font-semibold text-lg whitespace-nowrap text-blue-600">Rumah Selam</span>
                <span class="text-yellow-500 text-sm whitespace-nowrap">Dive Center</span>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">

        {{-- Item menu lainnya --}}
        <div>
            <button @click="sidebarMinimized ? toggleFloating('services', $event) : toggleAccordion('services')"
                    class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150 ease-in-out"
                    :class="{
                        'bg-gray-100 text-gray-900': activeDropdown === 'services' && !sidebarMinimized,
                        'justify-start': !sidebarMinimized,
                        'justify-center': sidebarMinimized
                    }">
                 <div class="flex items-center overflow-hidden whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    {{-- x-show tetap menggunakan state lokal sidebarMinimized --}}
                    <span class="ml-3 font-medium" x-show="!sidebarMinimized" x-transition:fade>Services</span>
                 </div>
                 <svg x-show="!sidebarMinimized" class="w-5 h-5 transition-transform flex-shrink-0 text-gray-400" :class="{'rotate-90': activeDropdown === 'services'}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="activeDropdown === 'services' && !sidebarMinimized" x-collapse x-cloak class="mt-1 space-y-0.5">
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.services.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.services.*')"> {{ __('All Services') }} </x-nav-link>
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.service-categories.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.service-categories.*')"> {{ __('Categories') }} </x-nav-link>
            </div>
        </div>
         {{-- ... (blok menu lainnya serupa) ... --}}

        <div>
            <button @click="sidebarMinimized ? toggleFloating('media', $event) : toggleAccordion('media')"
                    class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150 ease-in-out"
                     :class="{
                         'bg-gray-100 text-gray-900': activeDropdown === 'media' && !sidebarMinimized,
                         'justify-start': !sidebarMinimized,
                         'justify-center': sidebarMinimized
                     }">
                 <div class="flex items-center overflow-hidden whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    <span class="ml-3 font-medium" x-show="!sidebarMinimized" x-transition:fade>Media</span>
                 </div>
                 <svg x-show="!sidebarMinimized" class="w-5 h-5 transition-transform flex-shrink-0 text-gray-400" :class="{'rotate-90': activeDropdown === 'media'}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="activeDropdown === 'media' && !sidebarMinimized" x-collapse x-cloak class="mt-1 space-y-0.5">
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.galleries.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.galleries.*')"> {{ __('All Galleries') }} </x-nav-link>
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.gallery-categories.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.gallery-categories.*')"> {{ __('Categories') }} </x-nav-link>
            </div>
        </div>

        <div>
            <button @click="sidebarMinimized ? toggleFloating('feedback', $event) : toggleAccordion('feedback')"
                    class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150 ease-in-out"
                     :class="{
                         'bg-gray-100 text-gray-900': activeDropdown === 'feedback' && !sidebarMinimized,
                         'justify-start': !sidebarMinimized,
                         'justify-center': sidebarMinimized
                     }">
                 <div class="flex items-center overflow-hidden whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.31h5.513c.498 0 .704.656.34.98l-4.46 3.24a.563.563 0 00-.182.63l2.125 5.111a.563.563 0 01-.84.62l-4.46-3.24a.563.563 0 00-.656 0l-4.46 3.24a.563.563 0 01-.84-.62l2.125-5.111a.563.563 0 00-.182-.63l-4.46-3.24a.563.563 0 01.34-.98h5.513a.563.563 0 00.475-.31l2.125-5.111z" /></svg>
                    <span class="ml-3 font-medium" x-show="!sidebarMinimized" x-transition:fade>Feedback</span>
                 </div>
                 <svg x-show="!sidebarMinimized" class="w-5 h-5 transition-transform flex-shrink-0 text-gray-400" :class="{'rotate-90': activeDropdown === 'feedback'}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="activeDropdown === 'feedback' && !sidebarMinimized" x-collapse x-cloak class="mt-1 space-y-0.5">
                 <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.reviews.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.reviews.*')"> {{ __('Reviews') }} </x-nav-link>
            </div>
        </div>

        <div>
            <button @click="sidebarMinimized ? toggleFloating('management', $event) : toggleAccordion('management')"
                    class="w-full flex items-center justify-between text-left px-3 py-2.5 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors duration-150 ease-in-out"
                     :class="{
                         'bg-gray-100 text-gray-900': activeDropdown === 'management' && !sidebarMinimized,
                         'justify-start': !sidebarMinimized,
                         'justify-center': sidebarMinimized
                     }">
                 <div class="flex items-center overflow-hidden whitespace-nowrap">
                    <svg class="w-6 h-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-4.682 2.72a.5.5 0 01-.063.03c-.38.166-.78.29-1.2.37M10.5 11.25a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15.11A5.23 5.23 0 0110.5 15c-1.43 0-2.734-.5-3.75-1.35M16.5 11.25a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.75V9A2.25 2.25 0 0018.75 6.75h-9A2.25 2.25 0 007.5 9v3.75m13.5 0A2.25 2.25 0 0118.75 15h-9a2.25 2.25 0 01-2.25-2.25V9A2.25 2.25 0 017.5 6.75h9A2.25 2.25 0 0121 9v3.75M3 13.5A2.25 2.25 0 01.75 11.25V9A2.25 2.25 0 013 6.75h3A2.25 2.25 0 018.25 9v3.75A2.25 2.25 0 016 15H3m14.25-6.09A5.23 5.23 0 0115 7.5c-1.43 0-2.734-.5-3.75 1.35M16.5 15c-1.016.85-2.32 1.35-3.75 1.35A5.23 5.23 0 017.5 15" /></svg>
                    <span class="ml-3 font-medium" x-show="!sidebarMinimized" x-transition:fade>Management</span>
                 </div>
                 <svg x-show="!sidebarMinimized" class="w-5 h-5 transition-transform flex-shrink-0 text-gray-400" :class="{'rotate-90': activeDropdown === 'management'}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="activeDropdown === 'management' && !sidebarMinimized" x-collapse x-cloak class="mt-1 space-y-0.5">
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.users.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.users.*')"> {{ __('Users') }} </x-nav-link>
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.contacts.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.contacts.*')"> {{ __('Contacts') }} </x-nav-link> 
                
                {{-- Mengambil dari kode file yang di-upload sebelumnya --}}
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.transactions.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.transactions.*')"> {{ __('Financial Report') }} </x-nav-link>
                
                {{-- 2. BARIS INI DITAMBAHKAN --}}
                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.schedules.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.schedules.*')"> {{ __('Schedule') }} </x-nav-link>

                <x-nav-link class="block w-full pl-10 pr-4 py-1.5 text-sm rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.profile.edit', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.profile.*')"> {{ __('My Profile') }} </x-nav-link>
            </div>
        </div>
    </nav>

     {{-- Floating Menus --}}
    <div class="absolute z-50">
         <div x-ref="servicesFloating"
               x-show="floatingDropdown === 'services'" x-cloak
               @click.outside="closeFloating"
               x-transition
               class="absolute w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1"
               style="display: none;">
             <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.services.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.services.*')"> {{ __('All Services') }} </x-nav-link>
             <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.service-categories.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.service-categories.*')"> {{ __('Categories') }} </x-nav-link>
         </div>

         <div x-ref="mediaFloating"
               x-show="floatingDropdown === 'media'" x-cloak
               @click.outside="closeFloating"
               x-transition
               class="absolute w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1"
               style="display: none;">
             <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.galleries.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.galleries.*')"> {{ __('All Galleries') }} </x-nav-link>
             <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.gallery-categories.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.gallery-categories.*')"> {{ __('Categories') }} </x-nav-link>
         </div>

         <div x-ref="feedbackFloating"
               x-show="floatingDropdown === 'feedback'" x-cloak
               @click.outside="closeFloating"
               x-transition
               class="absolute w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1"
               style="display: none;">
              <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.reviews.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.reviews.*')"> {{ __('Reviews') }} </x-nav-link>
         </div>

         <div x-ref="managementFloating"
               x-show="floatingDropdown === 'management'" x-cloak
               @click.outside="closeFloating"
               x-transition
               class="absolute w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1"
               style="display: none;">
               <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.users.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.users.*')"> {{ __('Users') }} </x-nav-link>
               <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.contacts.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.contacts.*')"> {{ __('Contacts') }} </x-nav-link> 
               
               {{-- Mengambil dari kode file yang di-upload sebelumnya --}}
               <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.transactions.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.transactions.*')"> {{ __('Financial Report') }} </x-nav-link>
               
               {{-- 3. BARIS INI DITAMBAHKAN --}}
               <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.schedules.index', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.schedules.*')"> {{ __('Schedule') }} </x-nav-link>
               
               <x-nav-link class="block w-full px-4 py-1.5 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" :href="route('admin.profile.edit', ['locale' => app()->getLocale()])" :active="request()->routeIs('admin.profile.*')"> {{ __('My Profile') }} </x-nav-link>
         </div>
    </div>
</div>