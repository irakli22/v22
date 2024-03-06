<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { Link, usePage, router, } from '@inertiajs/vue3';
// import Router from 'vendor/tightenco/ziggy/src/js/Router';

const isOpen = ref(false);
const elementRef1 = ref(null);
const elementRef2 = ref(null);
const eventElement = ref(null);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const closeDropdown = () => {
    isOpen.value = false;
};

const checkIfClickOutside = (event) => {
    if (isOpen.value &&
        !elementRef1.value.contains(event.target) &&
        !elementRef2.value.contains(event.target) &&
        event.target !== eventElement.value) {
        closeDropdown();
    }
};

watch(isOpen, (newValue) => {
    if (newValue) {
        document.addEventListener('click', checkIfClickOutside);
    } else {
        document.removeEventListener('click', checkIfClickOutside);
    }
});

onUnmounted(() => {
    document.removeEventListener('click', checkIfClickOutside);
});

function updateAndNavigate(order) {
    const params = new URLSearchParams(window.location.search);
    params.set('order', order);
    const queryParams = Object.fromEntries(params);
    const url = route('products.index', queryParams);
    router.visit(url);
}

</script>

<template>
    <div class="relative ml-auto">
        <button ref="eventElement" @click="toggleDropdown" class="p-2 rounded border border-gray-300 hover:bg-white">Sort
            By</button>
        <div ref="elementRef1" v-show="isOpen"
            class="hidden md:block absolute right-0 bg-white p-4 rounded shadow-lg mt-1 z-10 w-64"
            @click.self="closeDropdown">
            <!-- Dropdown Content for Larger Screens -->
            <ul>
                <li class="py-1 cursor-pointer hover:bg-gray-100">
                    <!-- <Link :href="route('products.index', { order: 'asc' })">Price: Low to High</Link> -->
                    <button @click="updateAndNavigate('asc')">Price: Low to High</button>
                    <!-- <button @click="$emit('order', { order: 'asc' })">Price: Low to High</button> -->
                </li>
                <li class="py-1 cursor-pointer hover:bg-gray-100">
                    <!-- <Link :href="route('products.index', { order: 'desc' })">Price: High to Low</Link> -->
                    <!-- <button @click="$emit('order', { order: 'desc' })">Price: High to Low</button> -->
                    <button @click="updateAndNavigate('desc')">Price: High to Low</button>
                </li>
            </ul>
        </div>
        <div ref="elementRef2" v-show="isOpen" @click.self="closeDropdown"
            class="md:hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-10">
            <div class="bg-white p-4 rounded shadow-lg w-full sm:max-w-sm mx-auto">
                <!-- Full-Screen Dropdown Content for Smaller Screens -->
                <ul>
                    <li class="py-1 cursor-pointer hover:bg-gray-100">
                        <!-- <Link :href="route('products.index', { order: 'asc' })">Price: Low to High</Link> -->
                        <button @click="updateAndNavigate('asc')">Price: Low to High</button>
                        <!-- <button @click="$emit('order', { order: 'asc' })">Price: Low to High</button> -->
                    </li>
                    <li class="py-1 cursor-pointer hover:bg-gray-100">
                        <!-- <Link :href="route('products.index', { order: 'desc' })">Price: High to Low</Link> -->
                        <!-- <button @click="$emit('order', { order: 'desc' })">Price: High to Low</button> -->
                        <button @click="updateAndNavigate('desc')">Price: High to Low</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
