<script setup>
import { defineProps, defineEmits, computed } from 'vue'

const props = defineProps({
  currentPage: { type: Number, default: 1 },
  lastPage: { type: Number, default: 1 }
})

const emit = defineEmits(['page-change'])

const goToPage = (page) => {
    if (page >= 1 && page <= props.lastPage) {
        emit('page-change', page)
    }
}

// Gumawa ng range ng pages (halimbawa 1–5 lang, depende sa current page)
const pages = computed(() => {
    let start = Math.max(1, props.currentPage - 2)
    let end = Math.min(props.lastPage, props.currentPage + 2)
    let result = []
    for (let i = start; i <= end; i++) {
        result.push(i)
    }
    return result
})
</script>

<template>
    <div class="flex gap-2 mt-4 items-center flex-wrap">
        <!-- Prev -->
        <button class="transition-transform duration-200 
         hover:translate-y-1 hover:scale-105 px-3 py-1 bg-gray-200 rounded disabled:opacity-50" :disabled="currentPage === 1"
            @click="goToPage(currentPage - 1)">
            Prev
        </button>

        <!-- Page numbers -->
        <button v-for="page in pages" :key="page" class="transition-transform duration-200 
         hover:translate-y-1 hover:scale-105 px-3 py-1 rounded"
            :class="page === currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200'" @click="goToPage(page)">
            {{ page }}
        </button>

        <!-- Next -->
        <button class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50 
         transition-transform duration-200 
         hover:translate-y-1 hover:scale-105" :disabled="currentPage === lastPage" @click="goToPage(currentPage + 1)">
            Next
        </button>
    </div>
</template>