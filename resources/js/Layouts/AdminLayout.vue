<script setup>
import { onMounted, ref, watch } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import 'flowbite';


const showDropdown = ref(false);
const page = usePage();

// auto-open if current route is under "request.*"
onMounted(() => {
    if (
        route().current("resident.lists") ||
        route().current("request.list") ||
        route().current("processing.list") ||
        route().current("ready_to_pick_up.list") ||
        route().current("released.list") ||
        route().current("admin.dashboard")
    ) {
        showDropdown.value = true;
    }
});

// optional: auto-update kapag nag-navigate ka
watch(
    () => page.url,
    () => {
        if (
            route().current("resident.lists") ||
            route().current("request.list") ||
            route().current("processing.list") ||
            route().current("ready_to_pick_up.list") ||
            route().current("released.list") ||
            route().current("admin.dashboard")
        ) {
            showDropdown.value = true;
        }
    }
);

const toggleDropdown = () => {
    showDropdown.value = !showDropdown.value;
};


const logout = () => {
    router.post(route("logout"));
    router.visit('/');
}

const toggleSidebarMobile = (sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose) => {
    sidebar.classList.toggle('hidden');
    sidebarBackdrop.classList.toggle('hidden');
    toggleSidebarMobileHamburger.classList.toggle('hidden');
    toggleSidebarMobileClose.classList.toggle('hidden');
};

onMounted(() => {
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarMobileEl = document.getElementById('toggleSidebarMobile');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
    const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');

    if (
        sidebar &&
        toggleSidebarMobileEl &&
        sidebarBackdrop &&
        toggleSidebarMobileHamburger &&
        toggleSidebarMobileClose
    ) {
        toggleSidebarMobileEl.addEventListener('click', () => {
            toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
        });

        sidebarBackdrop.addEventListener('click', () => {
            toggleSidebarMobile(sidebar, sidebarBackdrop, toggleSidebarMobileHamburger, toggleSidebarMobileClose);
        });
    } else {
        console.error('One or more elements not found in the DOM');
    }




});
</script>

<template>

    <div>
        <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                            class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                            <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <a href="#" class="text-xl font-bold flex items-center lg:ml-2.5">
                            <img src="/images/bg1.jpg" alt="bg1" class="h-12 mr-2 object-cover">
                            <span class="self-center whitespace-nowrap">Barangay Management System</span>
                        </a>

                    </div>
                </div>
            </div>
        </nav>

        <div class="flex overflow-hidden bg-white pt-16">
            <aside id="sidebar"
                class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75"
                aria-label="Sidebar">

                <div class="min-h-screen flex flex-row ">

                    <div class="flex flex-col w-56 bg-white  overflow-hidden border-2 border-gray-200">
                        <!-- <div class="flex items-center justify-center h-20 py-10 shadow-md">
      
                            
    </div> -->
                        <div class="flex justify-center  border-b py-2"><span
                                class="text-2xl text-red-600 font-bold">Admin</span></div>
                        <ul class="flex flex-col py-4">
                            <li class="hover:bg-gray-200 rounded mb-2">
                                <Link :href="route('admin.dashboard')" :class="route().current('admin.dashboard')
                                    ? 'bg-blue-500 text-white font-semibold'
                                    : 'text-gray-500  hover:text-gray-600'"
                                    class="flex flex-row items-center h-12 rounded transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                                <span
                                    class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400 "><i
                                        class="bx bx-home"></i></span>
                                <span class="text-sm font-medium">Home</span>
                                </Link>
                            </li>
                            <li class="hover:bg-gray-200 rounded mb-2">
                                <Link :href="route('resident.lists')" :class="route().current('resident.lists')
                                    ? 'bg-blue-500 text-white font-semibold'
                                    : 'text-gray-500  hover:text-gray-600'"
                                    class="flex rounded flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-white-900">
                                <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                        class="bx bx-receipt"></i></span>
                                <span class="text-sm font-medium">Residents</span>
                                </Link>
                            </li>
                            <li>
                                <button @click="toggleDropdown"
                                    class="w-full flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800 focus:outline-none">
                                    <span
                                        class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400">
                                        <i class="bx bx-receipt"></i>
                                    </span>
                                    <span class="text-sm font-medium flex-1 text-left">Request List</span>
                                    <svg class="w-4 h-4 mr-3 transform transition-transform duration-200"
                                        :class="{ 'rotate-90': showDropdown }" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <ul v-show="showDropdown" class="ml-12 space-y-1 transition-all duration-300">
                                    <li>
                                        <Link :href="route('request.list')" class="block py-2 text-sm rounded px-2"
                                            :class="route().current('request.list')
                                                ? 'bg-blue-500 text-white font-semibold'
                                                : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'">
                                        Pending Requests
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('processing.list')" class="block py-2 text-sm rounded px-2" :class="route().current('processing.list')
                                            ? 'bg-blue-500 text-white font-semibold'
                                            : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'">
                                        Proccessing Requests
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('ready_to_pick_up.list')" class="block py-2 text-sm rounded px-2" :class="route().current('ready_to_pick_up.list')
                                            ? 'bg-blue-500 text-white font-semibold'
                                            : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'">
                                        Ready to Pick-up Requests
                                        </Link>
                                    </li>
                                    <li>
                                        <Link :href="route('released.list')" class="block py-2 text-sm rounded px-2" :class="route().current('released.list')
                                            ? 'bg-blue-500 text-white font-semibold'
                                            : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800'">
                                        Released Requests
                                        </Link>
                                    </li>
                                </ul>
                            </li>
                            <li class="hover:bg-gray-200 rounded mb-2">
                                <a href="#"
                                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                                    <span
                                        class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                            class="bx bx-user"></i></span>
                                    <span class="text-sm font-medium">Profile</span>
                                </a>
                            </li>
                            <li class="hover:bg-gray-200 rounded mb-2">
                                <button @click="logout"
                                    class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                                    <span
                                        class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i
                                            class="bx bx-log-out"></i></span>
                                    <span class="text-sm font-medium">Logout</span>
                                </button>
                            </li>
                        </ul>

                    </div>

                </div>

            </aside>

            <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
            <div id="main-content" class="h-full w-full bg-white relative overflow-y-auto lg:ml-64">
                <main>
                    <slot />
                </main>

                <!-- <div class="text-center text-sm text-gray-500  h-screen">
            &copy; 2025 <a href="#" class="hover:underline" target="_blank">ARS</a>. All rights
            reserved.
      </div> -->
                <div class="text-center text-sm text-gray-500  py-2 bg-white">
                    &copy; 2025 <a href="#" class="hover:underline" target="_blank">ARS</a>. All rights
                    reserved.
                </div>
            </div>

        </div>


    </div>
</template>