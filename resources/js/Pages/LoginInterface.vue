<script setup>
import AnotherLayout from '@/Layouts/AnotherLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <AnotherLayout>
        <div class="mt-6 grid cols-1 justify-center gap-4">
            <Link :href="route('select.role', 'admin')" class="border rounded-full text-center text-white bg-gray-800 py-1">
                Administrator
            </Link>
            <Link :href="route('select.role', 'user')" class="border rounded-full text-center text-white bg-gray-800 py-1">
                Resident
            </Link>
            <Link href="/registration" class="border rounded-full text-center text-white bg-gray-800 px-4 py-1">
                Apply for Registration
            </Link>
        </div>
   </AnotherLayout>
</template>