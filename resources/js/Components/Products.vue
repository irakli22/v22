<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ProductSorting from './ProductSorting.vue';
import ProductFilter from './ProductFilters/ProductFilter.vue';
import ProductPagination from './ProductPagination.vue';

const { props } = usePage();
const products = ref(props.products.data);
const isFilterVisible = ref(false);

const setDefaultImage = (event) => {
    event.target.src = 'images/placeholder.png';
};

console.log(products.value)

const currentPage = ref(props.products.current_page);
const lastPage = ref(props.products.last_page); // you should calculate this based on your data
const totalItems = ref(props.products.total); // total number of items
const itemsPerPage = ref(props.products.per_page); // items per page

const fetchData = (page) => {
    currentPage.value = page;
    // Fetch your data based on the new page
};

const toggleFilter = () => {
    isFilterVisible.value = !isFilterVisible.value;
};

</script>

<template>
    <div class="m-4">

        <div class="flex flex-col md:flex-row">
            <div :class="[
                isFilterVisible ? 'fixed inset-0 z-40 bg-white' : 'hidden',
                'md:block md:relative md:z-auto md:bg-transparent md:w-1/4'
            ]">
                <ProductFilter />
                <!-- Only show the "X" button when isFilterVisible is true and on small screens -->
                <div :class="[isFilterVisible ? 'block' : 'hidden', 'md:hidden', 'absolute top-0 right-0']">
                    <button @click="toggleFilter" class="font-bold text-xl m-4 p-2">X</button>
                </div>
            </div>

            <div class="md:w-3/4">
                <div class="flex flex-row justify-between m-4">
                    <button @click="toggleFilter"
                        class="md:hidden font-bold py-2 px-4 rounded border border-gray-300 hover:bg-white">
                        Toggle Filter
                    </button>
                    <ProductSorting />
                </div>
                <div class="p-4">
                    <h1 class="text-2xl font-bold mb-5">Product List</h1>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 ">
                        <!-- Product Cards -->
                        <div v-for="product in products" :key="product.id"
                            class="border rounded-lg p-4 bg-white shadow-md hover:shadow-lg transition-shadow">
                            <img :src="product.image || '/path-to-default-image.jpg'" @error="setDefaultImage"
                                class="w-full h-64 object-cover mb-3 rounded" alt="Product Image">
                            <h2 class="text-xl font-semibold mb-2">{{ product.name }}</h2>
                            <p class="text-gray-600">$ {{ product.price }}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <ProductPagination :current-page="currentPage" :last-page="lastPage" :total="totalItems"
                        :per-page="itemsPerPage" @update:page="fetchData" />
                </div>
            </div>
        </div>
    </div>
</template>
