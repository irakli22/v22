<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex justify-between flex-1 sm:hidden">
            <button @click="changePage(currentPage - 1)" :disabled="currentPage <= 1"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50">
                Previous
            </button>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage >= lastPage"
                class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50">
                Next
            </button>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ (currentPage - 1) * perPage + 1 }}</span>
                    to
                    <span class="font-medium">{{ currentPage * perPage }}</span>
                    of
                    <span class="font-medium">{{ total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button v-for="page in pageNumbers" :key="page" @click="updateAndNavigate(page)"
                        :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium', page === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-blue-50']">
                        {{ page }}
                    </button>
                </nav>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { computed, defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    currentPage: Number,
    lastPage: Number,
    total: Number,
    perPage: Number
});

const pageNumbers = computed(() => {
    let pages = [];
    for (let i = 1; i <= props.lastPage; i++) {
        pages.push(i);
    }
    return pages;
});

// const changePage = (page) => {
//     if (page < 1 || page > props.lastPage) return;
//     // Emit an event to parent component
//     emit('update:page', page);
// };

function updateAndNavigate(order) {
    const params = new URLSearchParams(window.location.search);
    params.set('page', order);
    const queryParams = Object.fromEntries(params);
    const url = route('products.index', queryParams);
    router.visit(url);
}
</script>
  