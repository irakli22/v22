<template>
    <div class="p-4 bg-white shadow-md rounded-lg">
        <p class="font-bold text-lg cursor-pointer" @click="toggleVisibility">Storage</p>
        <div  v-if="isVisible" class="mt-4">
            <div class="grid grid-cols-1 gap-2 mb-4">
                <div v-for="(capacity, index) in capacitiesToShow" :key="index" class="flex items-center">
                    <input :id="capacity" type="checkbox" :value="capacity" @change="filterProducts(capacity, $event)"
                        :checked="capacitiesArray.includes(capacity)" class="accent-blue-500 h-4 w-4 cursor-pointer">
                    <label :for="capacity" class="ml-2 text-sm text-gray-700 cursor-pointer">{{ capacity }} GB</label>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <button v-if="capacities.length > 8" @click="toggleShowMore"
                    class="text-blue-500 text-sm hover:text-blue-600 transition-colors duration-150">
                    {{ showMore ? 'Show Less' : 'Show More' }}
                </button>
                <div>
                    <button @click="closeAll"
                        class="text-gray-500 text-sm hover:text-gray-600 transition-colors duration-150 mr-2">Close
                        All</button>
                    <button v-if="isChanged" @click="updateAndNavigate"
                        class="bg-blue-500 text-white text-sm px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-150">OK</button>
                </div>
            </div>
        </div>
    </div>
</template>
<!-- :checked="checkedCapacities.value.includes(capacity)"  -->
<script setup>
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const isVisible = ref(true);

const capacities = props.storageCapacities || [];
const showMore = ref(false);
const isChanged = ref(false);


const capacitiesValue = ref(new URLSearchParams(window.location.search).get('capacities'));
const capacitiesArray = capacitiesValue.value
    ? capacitiesValue.value.split(',').map(value => parseInt(value))
    : [];

console.log(capacitiesArray.includes(64))
console.log(capacitiesArray)

// Ensure only valid capacities are checked initially
const checkedCapacities = ref(capacitiesArray.filter(capacity => capacities.includes(capacity)));

// Compute whether to show more or fewer capacities based on showMore state
const capacitiesToShow = computed(() => {
    return showMore.value ? capacities : capacities.slice(0, 8);
});

function toggleShowMore() {
    showMore.value = !showMore.value;
}

function filterProducts(capacity, event) {
    const index = checkedCapacities.value.indexOf(capacity);
    if (event.target.checked && index === -1) {
        checkedCapacities.value.push(capacity);
    } else if (!event.target.checked && index !== -1) {
        checkedCapacities.value.splice(index, 1);
    }
        isChanged.value = true;
}

function closeAll() {
    checkedCapacities.value = []; // Clear all selections
    // Additional logic to uncheck all checkboxes (DOM manipulation or model update)
}

function toggleVisibility() {
    isVisible.value = !isVisible.value;
}

function updateAndNavigate() {
    const params = new URLSearchParams(window.location.search);
    if (checkedCapacities.value.length > 0) {
        const result = checkedCapacities.value.join(',');
        params.set('capacities', result);
    } else {
        params.delete('capacities');
    }
    const queryParams = Object.fromEntries(params);
    const url = route('products.index', queryParams);
    router.visit(url);
}



</script>
